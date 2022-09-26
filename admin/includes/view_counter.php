<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack York - oscommerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/
 function Test_microtime_float() { //just used for testing 
     list($usec, $sec) = explode(" ", microtime());
     return ((float)$usec + (float)$sec);
 }
  require('includes/application_top.php'); 
  require('includes/languages/' . $language . '/view_counter.php');
  require('includes/functions/view_counter.php');
  require(DIR_FS_CATALOG . 'view_counter/IP2Location.php');

  $pageNumb = (isset($_GET['page']) ? $_GET['page'] : $_POST['page']); //$_REQUEST failiing on some servers so use this
  $sortByArray = array('date' => '', 'filename' => 'checked', 'ip_number' => '', 'count' => '', 'arg' => '', 'bot_name' => '');
  $sortBy = ' order by file_name asc';
  $showTypeArray = array('bots' => '', 'customers' => 'checked', 'all' => '');
  $showType = ' and isbot = 0 ';
  $show_only_this_ip = '';
  $show_only_active = ((isset($_POST['show_only_active']) && $_POST['show_only_active'] == 'on') ? 'checked' : '');
  $show_only_spoofed = ((isset($_POST['show_only_spoofed']) && $_POST['show_only_spoofed'] == 'on') ? 'checked' : '');
  $show_related_pages = 'checked'; // (isset($_POST['show_related_pages']) ? 'checked' : '');
  $sortDirectionArray = array();
  $display_table = ((isset($_POST['display_table']) && $_POST['display_table'] == 'on') ? 'checked' : ''); //which storage table is to be used

  if (isset($_POST['sortBy'])) {
      $sortByArray = unserialize(urldecode($_POST['sortByArray']));
      $sortBy = ' ' . $_POST['sortBy'] . ' ';
  }

  if (isset($_POST['showType'])) {
      $showTypeArray = unserialize(urldecode($_POST['showTypeArray']));
      $showType = ' ' . $_POST['showType'] . ' ';
  }
  if (isset($_POST['sortDirectionArray'])) {
      $sortDirectionArray = unserialize(urldecode($_POST['sortDirectionArray']));
  }   
 
  /********************** BEGIN VERSION CHECKER *********************/
  if (file_exists('includes/functions/version_checker.php'))  {
      require('includes/languages/' . $language . '/version_checker.php');
      require('includes/functions/version_checker.php');
      $contribPath = 'https://apps.oscommerce.com/V8iga';
      $currentVersion = 'View Counter V 1.8';
      $contribName = 'View Counter V';
      $versionStatus = '';
  }
  /********************** END VERSION CHECKER *********************/
 
  /********************** CHECK THE VERSION ***********************/
  if (isset($_POST['action']) && $_POST['action'] == 'getversion') {
      if (isset($_POST['version_check']) && $_POST['version_check'] == 'on') {
          $versionStatus = AnnounceVersion($contribPath, $currentVersion, $contribName);
      }    
  }

  /*********************** HANDLE THE MAINTENANCE SECTION ************************/
  else if ((isset($_POST['action']) && $_POST['action'] == 'process') || (isset($_POST['colsortSet']) && $_POST['colsortChange'] != 'ignore')) {
 
      /*********************** REMOVE BANNED IP'S ************************/
      if (isset($_POST['banned_ips']) && $_POST['banned_ips'] > 0) {
          $bannedList = unserialize(urldecode($_POST['bannedList']));
          foreach ($bannedList as $ipArry) {
              if ($ipArry['id'] == $_POST['banned_ips']) {
                  if (RemoveBannedIP($ipArry['text'])) {
                      $messageStack->add(sprintf(SUCCESS_IP_BANNED_REMOVED, $ipArry['text']), 'success'); 
                  } else {
                      $messageStack->add(sprintf(ERROR_HTACCESS_WRITE_FAILED, $ipArry['text']), 'error'); 
                  }                  
                  break;
              }
          }
      }

      /*********************** REMOVE IGNORED IP'S ************************/
      else if (isset($_POST['ignored_ips']) && $_POST['ignored_ips'] > 0) {
          $ignoredIPs_query = tep_db_query("select inet_ntoa(ip_number) as ip_number, ip_string from view_counter_banned where ignore_status = 1 order by ip_number"); 
          $ctr = 0;
          while ($ignoredIPs = tep_db_fetch_array($ignoredIPs_query)) {
             $ctr++;
             if ($ctr == $_POST['ignored_ips']) {
                 $ip = ($ignoredIPs['ip_number'] > 0 ? $ignoredIPs['ip_number'] : $ignoredIPs['ip_string']);
                 RemoveIgnoredIP($ip);
                 $messageStack->add(sprintf(SUCCESS_IP_IGNORED_REMOVED, $ip), 'success'); 
                 break;
             }
         } 
      }      
      
      /*********** BLOCK IP RANGE USING CIDR OR JUST AN IP OR BY DOMAIN NAME ***********/
      else if (isset($_POST['block_range']) && tep_not_null($_POST['block_range'])) {
          $ips = $_POST['block_range'];

          if (IsValidDomainName($ips)) {  //it's a domain name if there are less than two dots in an alphanumeric string 
              if (AlterHtaccessFile($ips, true)) {
                  $messageStack->add(sprintf(SUCCESS_DOMAIN_BLOCK, $ips), 'success');
              } else {    
                  $messageStack->add(sprintf(ERROR_DOMAIN_ALREADY_BANNED, $ips), 'error');
              }  
          } else {
              $ipArray = ConvertRangeToCIDR($ips);
              $items = count($ipArray);
              
              for ($i = 0; $i < $items; ++$i) {
                  if (IsValidIP($ipArray[$i])) {
                      $result = AlterHtaccessFile($ipArray[$i]);
                      if ($result) {
                          $messageStack->add(sprintf(SUCCESS_RANGE_BLOCK, $ipArray[$i]), 'success');
                      } else {    
                          $messageStack->add(sprintf(ERROR_IP_ALREADY_BANNED, $ipArray[$i]), 'error');
                      }  
                  } else {
                      $messageStack->add(sprintf(ERROR_RANGE_BLOCK, $ipArray[$i]), 'error');
                  }
              }
          }
      }  
      
      /*********************** IGNORE IP RANGE USING CIDR ************************/
      else if (isset($_POST['ignore_range']) && tep_not_null($_POST['ignore_range'])) {
          $ips = $_POST['ignore_range'];
          $ipArray = ConvertRangeToCIDR($ips);
          $items = count($ipArray);
          
          for ($i = 0; $i < $items; ++$i) {
              if (IsValidIP($ipArray[$i])) {
                  IgnoreThisIP($ipArray[$i]); //no need to check for failure - if it fails, the DB will show an error
                  $messageStack->add(sprintf(SUCCESS_IP_IGNORED, $ipArray[$i]), 'success');
              }
          }
      }       
      
      /*********************** SHOW ONLY THIS IP ************************/
      else if (isset($_POST['submit_only_this_ip']) && tep_not_null($_POST['only_this_ip'])) {
          $ip = trim($_POST['only_this_ip']);
          if (IsValidIP($ip)) {
              $show_only_this_ip = " and ip_number = INET_ATON('" . $ip . "') ";
          }
      }      
      
      /*********************** CHECK IF IP IS IN CIDR *******************/
      else if (isset($_POST['submit_ip_in_cidr']) && tep_not_null($_POST['ip_in_cidr'])) {
          $result = GetHtaccessFileContents();
  
          echo '<script language="javascript">';
          if ($result) {
              $notused = true;
              $result = IsIPInCidr($_POST['ip_in_cidr'], $result, $notused);
          }
          echo 'alert("' . $result . '")';
          echo '</script>'; 
      }   
      
      /*********************** SORT THE LIST ************************/
      else if ((isset($_POST['colsortSet']) && isset($_POST['colsortType']) && $_POST['colsortSet'] = true)) {
          if (! isset($_POST['colsortChange']) || (isset($_POST['colsortChange']) && $_POST['colsortChange'] != 'ignore')) {
              $cond = $_POST['colsortType'];
              GetSorting($sortByArray, $sortBy, $cond, $sortDirectionArray);
              SaveSettings($show_only_active, $show_only_spoofed, $showType, $showTypeArray, $sortBy, $sortByArray, $sortDirectionArray, $display_table);
          }
      }
      
      /*********************** SHOW BY TYPE ************************/
      else if (isset($_POST['group2'])) {
          switch ($_POST['group2']) {
              case TEXT_SHOW_TYPE_ADMIN: $showTypeArray = array('admin' => 'checked', 'bots' => '', 'customers' => '', 'all' => ''); $showType = " and (isadmin <> '' and isadmin IS NOT NULL) "; break;
              case TEXT_SHOW_TYPE_BOT: $showTypeArray = array('admin' => '', 'bots' => 'checked', 'customers' => '', 'all' => ''); $showType = ' and isbot = 1 '; break;
              case TEXT_SHOW_TYPE_CUSTOMERS: $showTypeArray = array('admin' => '', 'bots' => '', 'customers' => 'checked', 'all' => ''); $showType = ' and isbot = 0 '; break;
              case TEXT_SHOW_TYPE_ALL: $showTypeArray = array('admin' => '', 'bots' => '', 'customers' => '', 'all' => 'checked'); $showType = ''; break;
              
              default: $showTypeArray = array('admin' => '', 'bots' => '', 'customers' => 'checked', 'all' => ''); $showType = ' and isbot = 0 ';
          }
                    
          $idx = '';
          foreach ($sortByArray as $key => $col) {
            if ($col == 'checked') {  //get the correct column
              $idx = ucFirst($key);   //,atch the define
              break;
            }
          }
          SaveSettings($show_only_active, $show_only_spoofed, $showType, $showTypeArray, $sortBy, $sortByArray, $sortDirectionArray, $display_table);
      } 
  }
  
  /*********************** HANDLE THE LIST SECTION ************************/
  else if (isset($_POST['action']) && $_POST['action'] == 'process_list') {
      foreach ($_POST as $id => $post) {
          if (strpos($id, 'ban_ip') !== FALSE) {
              if (IsValidIP($post)) {
                  $result = AlterHtaccessFile($post);
                  if ($result) {
                     $messageStack->add(sprintf(SUCCESS_IP_BANNED, $post), 'success');
                  } else {  
                     $messageStack->add(sprintf(ERROR_IP_ALREADY_BANNED, $post), 'error');
                  }    
              } else {
                  $messageStack->add(sprintf(ERROR_RANGE_BLOCK, $post), 'error');              
              }              
          } else if (strpos($id, 'ignore_ip') !== FALSE) {
              IgnoreThisIP($post);
              $messageStack->add(sprintf(SUCCESS_IP_IGNORED, $post), 'success');
              
          } else if (strpos($id, 'delete_ip') !== FALSE) {
              DeleteThisIP($post);
              $messageStack->add(sprintf(SUCCESS_IP_DELETED, $post), 'success');
          
          } else if (strpos($id, 'kick_off') !== FALSE) {
              if (VIEW_COUNTER_ENABLE_KILL_SESSION == 'true') {
                  KickOffIP($post, $_POST['this_session_id']);
                  $messageStack->add(sprintf(SUCCESS_IP_KICKED, $post), 'success');
              } else {
                  $messageStack->add(ERROR_KICK_NOT_ENABLED, 'error');
              }               
          }             
      }
  }
 
  $colors = array();  
  
  LoadSettings($show_only_active, $show_only_spoofed, $showType, $showTypeArray, $sortBy, $sortByArray, $sortDirectionArray, $display_table, $colors);

  $whereActive = '';
  $whereSpoofed = '';

  require('includes/view_counter_header.php');
?>
<link rel="stylesheet" type="text/css" href="includes/view_counter_styles.css">
<script language="javascript" type="text/javascript">
$(document).ready(function() {

  $('.dia').click(function() {
    var id = ($(this).attr('id'));
    $("#dialog").html(id);
    $('#dialog').load('view_counter_ajax.php?id='+$(this).attr('id'));
    $("#dialog").dialog({modal: true, buttons: [{
                                                 text: "Ok",
                                                 click: function() {
                                                  $(this).dialog("close"); }
                                                }]  , closeOnEscape: false ,
                                                      draggable: true,
                                                      height: 600,
                                                      width:800,
                                                      resizable: true,
                                                      title: 'IP DETAILS',
                                                      zIndex: 9999
                                                });
      return false;  // prevent the default action, e.g., following a link
  });

});  

function ChangeBoxStatus(section) {
  if (section == 'ban') {
     id = "ban_list";
     ele = "remove_ban";
  } else { //section = ignore
     id = "ignore_list";
     ele = "remove_ignore";
  }

  var e = document.getElementById(id);
  var selected = e.options[e.selectedIndex].value;

  if (selected > 0) {
    document.getElementById(ele).disabled = false;
  } else {
    document.getElementById(ele).disabled = true;
  }
}

function SortColumn(col, form) {
  var colsortChange = document.getElementsByName('colsortChange')[0];
  colsortChange.value = true;
  var colsortSet = document.getElementsByName('colsortSet')[0];
  colsortSet.value = true;
  var colsortType = document.getElementsByName('colsortType')[0];
  colsortType.value = col;
  document.forms[form].submit();
}

function showHelp(page){  
	$( "#vc_help" ).dialog({
  width: 600,
  height: 400,
  modal: true,
  open: function(event, ui)	{
   $(this).load(page);
  }
 });
}

function switchView(obj) {
	var el = document.getElementById(obj);
 var img = document.getElementById('imgStatus');
	if ( el.style.display != "none" ) {
   el.style.display = 'none';	
     img.src = 'images/view_counter/vc_arrow_down.gif';
     img.alt = 'show';
     img.title = 'show';
   }
   else {
     el.style.display = '';
     img.src = 'images/view_counter/vc_arrow_up.gif';
     img.alt = 'hide';
     img.title = 'hide';
   }
}
    
var settimmer = 0;
$(function(){
   window.setInterval(function() {
      var timeCounter = $("b[id=timeto_refresh]").html();
      var updateTime = eval(timeCounter)- eval(1);
      $("b[id=timeto_refresh]").html(updateTime);

      if(updateTime == 0){
         // $("form").submit();  //use the meta refresh to submit to ensure form elements are not submitted
      }
   }, <?php 
       switch (true) {
          case (VIEW_COUNTER_PAGE_REFRESH < 100):    echo (VIEW_COUNTER_PAGE_REFRESH - 1) * 100; break;
          case (VIEW_COUNTER_PAGE_REFRESH < 1000):   echo (VIEW_COUNTER_PAGE_REFRESH - 1) * 10;  break;
          case (VIEW_COUNTER_PAGE_REFRESH < 10000):  echo (VIEW_COUNTER_PAGE_REFRESH - 1) ;      break;
          case (VIEW_COUNTER_PAGE_REFRESH < 100000): echo (VIEW_COUNTER_PAGE_REFRESH - 1) / 10;  break;
          default: echo (VIEW_COUNTER_PAGE_REFRESH - 1) / 100;
       }
      ?>);

});
</script>
<style type="text/css">
table.BorderedBox {border:ridge #CCFFCC 3px; background-color: #ddd; }
table.BorderedBoxWhite {border:ridge #CCFFCC 3px; background-color: <?php echo $colors[COLOR_HDR_BKGND]; ?>; }
table.BorderedBoxLight {border:ridge #CCFFCC 3px; background-color: <?php echo $colors[COLOR_OPTIONS]; ?>; }
.rightBar {border-right:2px solid gray; padding-right:10px; height:70px;}
tr.Header { background-color: #CCFFCC; }
.em_small { font-family: Verdana, Arial, sans-serif; font-size: 10px; font-weight:bold }
input { vertical-align: middle; margin-top: -1px;}
th { border-width:thin; border-style: outset; background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>}
td.borderCell{border-bottom: 1px solid #555; } 
div.accountDetail {color:#ff0000; font-weight:normal; font-size:12px; border-top:0px solid; margin-top:4px; width:100%;}  /* used for account detail popup */ 
div.accountDetailBorder {border-top: 1px solid #555;}
div.cartProduct {color:#000; font-size:12px; white-space:nowrap;}     /* used for cart popup */
div.cartAttribute {color:0000ff; font-size:10px; white-space:nowrap;} /* used for cart popup */
div.cartTotal {color:#ff0000; font-weight:bold; border-top:1px solid; margin-top:4px; width:100%;}  /* used for cart popup */ 
#dhtmltooltip{
position: absolute;
width: 150px;
border: 2px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}
</style>

<?php if (strpos(PROJECT_VERSION, 'v2.3') !== FALSE) { ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php } else { ?>
<body bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require('includes/header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require('includes/column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
<?php } ?>

    <div id="dhtmltooltip"></div> <!-- for tooltip popup //--> 
    <script src="includes/javascript/view_counter/ddrivetip.js"></script> <!-- must follow the above //--> 
    <div id='dialog'></div>  <!-- for ajax popup //-->       
 
    
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="BorderedBoxWhite colortable">
       <tr>        
        <td><table border="0" width="40%" cellspacing="0" cellpadding="0">
            <tr>
               <td class="pageHeading" valign="top"><?php echo str_replace(" ", "&nbsp;", $currentVersion); ?></td>
            </tr>
            <tr>
               <td class="em_small" valign="top"><?php echo HEADING_TITLE_SUPPORT_THREAD; ?></td>
            </tr>
        </table></td>                        
        <td width="100%" ><table border="0" width="100%" cellpadding="0">
         <tr>       
          <td class="em_small" align="right"><?php echo HEADING_TITLE_AUTHOR; ?></td>
         </tr>
         <?php  
         if (function_exists('AnnounceVersion')) {
            if (VIEW_COUNTER_ENABLE_VERSION_CHECKER == 'true') { 
         ?>
               <tr>
                <td style="float:right"><table border="0" cellpadding="0"><tr>
                  <td class="em_small" align="right" style="font-weight: bold; color: red;"><?php echo AnnounceVersion($contribPath, $currentVersion, $contribName); ?></td>
                  <td class="em_small" align="right" style="font-weight: bold; color: red;"><INPUT TYPE="radio" NAME="version_check_unreleased" onClick="window.open('http://www.oscommerce-solution.com/check_unreleased_updates.php?id=<?php echo $id; ?>&name=<?php echo $name; ?>')"><?php echo TEXT_VERSION_CHECK_UPDATES_UNRELEASED; ?></td>
                </tr></table></td>                  
               </tr>
         <?php } else if (tep_not_null($versionStatus)) { 
            echo '<tr><td class="em_small" align="right" style="font-weight: bold; color: red;">' . $versionStatus . '</td></tr><tr>';
         } else {
            echo tep_draw_form('version_check', 'view_counter.php', '', 'post') . tep_draw_hidden_field('action', 'getversion') . '<tr>'; 
            $idParts = explode(' ', $currentVersion);
            $id = $idParts[count($idParts)-1];
            $name = $idParts[0];
         ?>
             <td style="float:right"><table border="0" cellpadding="0"><tr>
               <td class="em_small" align="right" style="font-weight: bold; color: red;"><INPUT TYPE="radio" NAME="version_check" onClick="this.form.submit();"><?php echo TEXT_VERSION_CHECK_UPDATES; ?></td>
               <td class="em_small" align="right" style="font-weight: bold; color: red;"><INPUT TYPE="radio" NAME="version_check_unreleased" onClick="window.open('http://www.oscommerce-solution.com/check_unreleased_updates.php?id=<?php echo $id; ?>&name=<?php echo $name; ?>')"><?php echo TEXT_VERSION_CHECK_UPDATES_UNRELEASED; ?></td>
             </tr></table></td>
           </form>
         <?php } } else { ?>
             <td class="em_small" align="right" style="font-weight: bold; color: red;"><?php echo TEXT_MISSING_VERSION_CHECKER; ?></td>
         <?php } ?>  
         </tr>         
        </table></td>
       </tr>  
       
       <tr>
        <td colspan="2"><div class="main" style="float:left; padding-top:10px;"><?php echo HEADING_SUB_TITLE; ?></div></td>
       </tr>
       
       <tr>
        <td colspan="2" width="100%"><table border="0" cellpadding="0" width="100%">
          <tr>    
            <td valign="top"><a href="##Gotostatusmsg" onClick="switchView('statusMsg'); return false;"><img src="images/view_counter/vc_arrow_down.gif" border="0" id="imgStatus" alt="show" title="show"></a></td>
            <td>       
             <div id="statusMsg" style="display:none; margin-top:20px">
              <table border="0" cellpadding="3" cellspacing="0" >
                <tr>
                 <td><div style="float:left;">
                   <?php 
                   $accessArray = GetAccessCountAll();
                   echo sprintf(HEADING_SUB_TEXT, $colors[COLOR_IS_ADMIN],$colors[COLOR_IS_HACKER],$colors[COLOR_IS_BOT],$colors[COLOR_IS_BOT_TRAP],$accessArray['ttl'], $accessArray['bots'],$accessArray['admin']); ?></div></td>
                </tr>
              </table>
             </div>       
            </td>  
          </tr>
       </table></td>
      </tr>          
      </table></td>  
     </tr>    
     
     <tr>
       <td><table border="0" width="100%" class="BorderedBoxLight">
          
       <!-- BEGIN OF ViewCounter -->
       <?php echo tep_draw_form('view_counter_main', 'view_counter.php', '', 'post') . tep_draw_hidden_field('action', 'process'); 
         $ctrBan = 0; 
         $ctrIgn = 0;
         $bannedList = array(); 
         $ignoreList = array(); 
         $bannedIPs_query = tep_db_query("SELECT INET_NTOA(ip_number) as ip_number, ip_string, ignore_status FROM view_counter_banned order by ip_number"); 
     
         while ($bannedIPs = tep_db_fetch_array($bannedIPs_query)) {
             $longIP = ip2long($bannedIPs['ip_number']);
             $goodNumber = ((IsValidIP($bannedIPs['ip_number']) && $longIP != -1 && $longIP !== FALSE) ? true : false);
             $goodString = ( $goodNumber ? false : (IsValidIP($bannedIPs['ip_string']) || IsValidDomainName($bannedIPs['ip_string'])) ? true : false);
             
             if ($bannedIPs['ignore_status']) {             
                 if ($goodNumber) {
                     $ctrIgn++;
                     $ignoreList[] = array('id' => $ctrIgn, 'text' => $bannedIPs['ip_number']);
                 } else if ($goodString) {
                     $ctrIgn++;
                     $ignoreList[] = array('id' => $ctrIgn, 'text' => $bannedIPs['ip_string']);
                 }                   
             } else {
                 if ($goodNumber) {
                     $ctrBan++;
                     $bannedList[] = array('id' => $ctrBan, 'text' => $bannedIPs['ip_number']);
                 } else if ($goodString) {
                     $ctrBan++;
                     $bannedList[] = array('id' => $ctrBan, 'text' => $bannedIPs['ip_string']);
                 }          
             }
         }   
         uasort($bannedList, "VC_SortMultiArray"); 
         uasort($ignoreList, "VC_SortMultiArray"); 
         array_unshift($bannedList, array('id' => 0, 'text' => TEXT_BANNED_IPS));
         array_unshift($ignoreList, array('id' => 0, 'text' => TEXT_IGNORE_IPS));
       ?>       
         <tr>
           <td width="100%"><table border="0" cellpadding="0" width="100%">       
             <tr>
               <td width="300" valign="top"><table border="0" cellpadding="0" width="100%" class="rightBar">
                 <tr>
                   <td width="150"><table border="0" cellpadding="0" width="100%">
                     <tr>
                       <td class="smallText"><?php echo tep_draw_pull_down_menu('banned_ips', $bannedList, TEXT_BANNED_IPS, ' id="ban_list" onChange="ChangeBoxStatus(\'ban\');" style="width:140px;"'); ?></td>
                     </tr> 
                   </table></td>
                   <td width="120"><table border="0" cellpadding="0">
                     <tr class="smallText">
                       <td width="100" style="font-weight:bold;"><?php echo TEXT_BAN_REMOVE; ?></td>
                       <td width="5"><?php echo  '<input type="checkbox" name="remove_ban", id="remove_ban" value="", disabled onchange="this.form.submit();">'; ?></td>
                     </tr>  
                   </table></td>  
                 </tr>
                 <tr>
                   <td width="150"><table border="0" cellpadding="0" width="100%">
                     <tr>
                       <td class="smallText"><?php echo tep_draw_pull_down_menu('ignored_ips', $ignoreList, TEXT_IGNORE_IPS, ' id="ignore_list" onChange="ChangeBoxStatus(\'ignore\');" style="width:140px;"'); ?></td>
                     </tr> 
                   </table></td>
                   <td width="120"><table border="0" cellpadding="0">
                     <tr class="smallText">
                       <td width="100" style="font-weight:bold;"><?php echo TEXT_IGNORE_REMOVE; ?></td>
                       <td width="5"><?php echo  '<input type="checkbox" name="remove_ignore", id="remove_ignore" value="", disabled onchange="this.form.submit();">'; ?></td>
                     </tr>  
                   </table></td>  
                 </tr>
               </table></td> 
               
               <td width="240" valign="top"><table border="0" cellpadding="0" width="100%">
                 <tr>             
                   <div style="margin-left:4px;">
                     <div class="smallText"style="float:left;">
                       <div style="font-weight:bold; padding-bottom:2px;"><?php echo TEXT_SHOW_TYPE; ?></div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="<?php echo TEXT_SHOW_TYPE_ADMIN; ?>" <?php echo $showTypeArray['admin']; ?> onchange="this.form.submit();"> <?php echo TEXT_SHOW_TYPE_ADMIN; ?> </div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="<?php echo TEXT_SHOW_TYPE_BOT; ?>" <?php echo $showTypeArray['bots']; ?> onchange="this.form.submit();"> <?php echo TEXT_SHOW_TYPE_BOT; ?></div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="<?php echo TEXT_SHOW_TYPE_CUSTOMERS; ?>" <?php echo $showTypeArray['customers']; ?> onchange="this.form.submit();"> <?php echo TEXT_SHOW_TYPE_CUSTOMERS; ?> </div>
                       <div><INPUT TYPE="radio" NAME="group2" VALUE="<?php echo TEXT_SHOW_TYPE_ALL; ?>" <?php echo $showTypeArray['all']; ?> onchange="this.form.submit();"> <?php echo TEXT_SHOW_TYPE_ALL; ?> </div>
                     </div>
                     <div class="smallText rightBar" style="float:right; margin-right:4px;">
                       <div style="font-weight:bold; padding-bottom:2px;"><?php echo TEXT_SHOW_TYPE_TYPE; ?></div>
                       <div><INPUT TYPE="checkbox" NAME="show_only_active" <?php echo $show_only_active; ?> onchange="this.form.submit();"><nobr><?php echo TEXT_ONLY_ACTIVE; ?></nobr></div>
                       <div><INPUT TYPE="checkbox" NAME="show_related_pages" <?php echo $show_related_pages; ?> onchange="this.form.submit();"><nobr><?php echo TEXT_RELATED_PAGES; ?></nobr></div>
                       <div><INPUT TYPE="checkbox" NAME="show_only_spoofed" <?php echo $show_only_spoofed; ?> onchange="this.form.submit();"><nobr><?php echo TEXT_ONLY_SPOOFED; ?></nobr></div>
                     </div>
                   </div> 
                 </tr>  
               </table></td> 
               
               <td valign="top"><table border="0" cellpadding="0" width="100%">
                 <tr>
                   <td><table border="0" cellpadding="0">
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_only_this_ip" value="<?php echo TEXT_SHOW_ONLY_IP; ?>" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><?php echo tep_draw_input_field('only_this_ip', '', 'maxlength="35" size="14"', false, '', false); ?> </td>
                     </tr>
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_block_range" value="<?php echo TEXT_BLOCK_IP_RANGE; ?>" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><?php echo tep_draw_input_field('block_range', '', 'maxlength="35" size="14"', false, '', false); ?> </td>
                     </tr>  
                   </table></td> 
                   <td><table border="0" cellpadding="0">
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_ip_in_cidr" value="<?php echo TEXT_IP_IN_CIDR; ?>" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><?php echo tep_draw_input_field('ip_in_cidr', '', 'maxlength="35" size="14"', false, '', false); ?> </td>
                     </tr>  
                     <tr class="smallText">             
                       <td><input type="submit" name="submit_ignore_range" value="<?php echo TEXT_IGNORE_IP_RANGE; ?>" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></td>
                       <td width="60"><?php echo tep_draw_input_field('ignore_range', '', 'maxlength="35" size="14"', false, '', false); ?> </td>
                     </tr> 
                   </table></td>
                 </tr>  
                 <tr>             
                   <td align="center" colspan="2" width="100%">
                    <div>
                    <div class="smallText" style="float:left; padding-top:10px; text-align:center; font-weight:bold;"><?php echo '<input type="checkbox" name="display_table", ' . $display_table . ' onchange="this.form.submit();">' . TEXT_CHOOSE_TABLE; ?></div>
                    <div class="smallText" style="float:right; padding-right:10px; padding-top:10px; text-align:center; font-weight:bold;"><?php echo DisplayRefreshTime(); ?></div>
                    </div>
                   </td>
                 </tr>  
               </table></td>                
              
             </tr> 
           </table></td>
         </tr>  
         <?php        
         echo //tep_draw_hidden_field('display_table', $display_table) .
              tep_draw_hidden_field('bannedList', urlencode(serialize($bannedList))) .         
              tep_draw_hidden_field('sortBy', $sortBy) . 
              tep_draw_hidden_field('sortByArray', urlencode(serialize($sortByArray))) .
              tep_draw_hidden_field('showType', $showType) .
              tep_draw_hidden_field('showTypeArray', urlencode(serialize($showTypeArray))) .
              tep_draw_hidden_field('sortDirectionArray', urlencode(serialize($sortDirectionArray))) .
              tep_draw_hidden_field('page', $pageNumb) ;
         ?> 
       </form>
      </table></td>
     </tr>

     <!-- Show the list //-->
     <?php
     echo tep_draw_form('view_counter_form', 'view_counter.php', '', 'post', 'id="view_counter_form"') . tep_hide_session_id() . tep_draw_hidden_field('action', 'process_list'); 
     ?>      
      <tr>     
       <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0" class="BorderedBoxLight">
      <?php 
       echo tep_draw_hidden_field('display_table', ($display_table == 'checked' ? 'on' : '')) . 
            tep_draw_hidden_field('sortBy', $sortBy) . 
            tep_draw_hidden_field('sortByArray', urlencode(serialize($sortByArray))) .
            tep_draw_hidden_field('showType', $showType) .
            tep_draw_hidden_field('showTypeArray', urlencode(serialize($showTypeArray))) . 
            tep_draw_hidden_field('show_only_active', ($show_only_active == 'checked' ? 'on' : '')) . 
            tep_draw_hidden_field('show_only_spoofed', ($show_only_spoofed == 'checked' ? 'on' : '')) . 
            tep_draw_hidden_field('colsortChange', 'ignore') .
            tep_draw_hidden_field('colsortSet', false) .
            tep_draw_hidden_field('colsortType', '');
            
       $view_query_numrows = 10;
       $languages = tep_get_languages();
       
       $hideIPs = "'" . str_replace(',', "','", str_replace(' ' ,'', VIEW_COUNTER_HIDE_ADMIN_LINKS)) . "'";         //condition the string from the setting
       $hideAdminLinks = 
        (((
              $showTypeArray['admin'] == 'checked'  
            ?         
              " and ( isadmin = '" . DIR_WS_ADMIN . "' and INET_NTOA(ip_number) NOT in (" .  $hideIPs . ")) " 
            : 
             ( $showTypeArray['all'] == 'checked' 
             ?
              " and (isadmin = '' or (isadmin = '" . DIR_WS_ADMIN . "' and INET_NTOA(ip_number) NOT in (" .  $hideIPs . "))) "
             : 
              " and ( (isadmin <> '" . DIR_WS_ADMIN . "')) "
             )
        ))); //build a string to ignore admins IP's

       $showType = ' ' . tep_db_prepare_input($showType);        
       $storage_table = ($display_table ? 'view_counter_storage' : 'view_counter');
       $whereActive = '';
       if ($show_only_active) {
           $activeTime = (VIEW_COUNTER_ACTIVE_TIME > 0 ? VIEW_COUNTER_ACTIVE_TIME : 5);
           $whereActive = " and last_date > (NOW() - INTERVAL " . (int)$activeTime . " MINUTE ) ";           
       }    

       $whereSpoofed = '';
       if ($show_only_spoofed) {
           $whereSpoofed = " and bot_name LIKE '%spoofed%' ";           
       }  
       
       $htaccessArray = GetHtaccessFileContents();
       $inCIDRStr = array();
       $items = count($languages);
       $menuColors = GetSortingColumColor($sortByArray, $colors); 
       $showPopup = false;
       $showWidth = 300;
       
       for ($i = 0; $i < $items ; ++$i) {
//$time_start = Test_microtime_float();  
           $inCIDRStr = GetInCIDRStr($htaccessArray, $storage_table, $languages[$i]['id'], $show_only_this_ip, $showType, $hideAdminLinks, $sortBy, $whereActive,  $whereSpoofed);
           
           $view_query_raw = "select *, TIME_TO_SEC( UNIX_TIMESTAMP( now( ) ) - UNIX_TIMESTAMP( last_date ) ) as time, DATE_FORMAT(last_date, '" . VIEW_COUNTER_DATE_FORMAT . "') as date_time from " . $storage_table . " where ip_active=1 and language_id = " . (int)$languages[$i]['id'] . $inCIDRStr[$i] . $show_only_this_ip . $showType . $whereActive . $whereSpoofed . $hideAdminLinks . $sortBy;
           $view_split = new splitPageResults($pageNumb, VIEW_COUNTER_MAX_ROWS, $view_query_raw, $view_query_numrows);   
           $view_query = tep_db_query($view_query_raw);
           $lastIP = ''; //for sub entries
           $line = 0;    //for flags array and different languages
        ?>
           <tr>
             <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
             <?php    
              
              while ($view = tep_db_fetch_array($view_query)) {
                  $view['ip_number'] = long2ip($view['ip_number']); //convert the ip
                  $colorArray = GetColor($view);
                  $indent = (($view['ip_number'] == $lastIP) ? '&nbsp;&nbsp;-> ' : '');
                  $visitorsName = '';
                  $showAccountDetails = ShowAccountDetails($view, $visitorsName, $showPopup);
                  $showCart = ShowCart($view['session_id'], $showWidth, $view['isadmin']);

                  $domainInfo = GetDomainLocation($view['ip_number']);
                  $flag = (VIEW_COUNTER_SHOW_FLAGS == 'true' && file_exists('images/view_counter/flags/' . strtolower($domainInfo['Country Code']) . '.png') ? '<img src="images/view_counter/flags/' . strtolower($domainInfo['Country Code']) . '.png" alt="' . $domainInfo['Country Name'] . '" title="' . $domainInfo['Country Name'] . '">' : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

                  if ($show_related_pages || (! $show_related_pages && ! $indent)) {
                      if ($line == 0) {
             ?>
                        <tr>
                          <?php if (true) { //count($languages) > 1) { //only show the language title if more than one
                            $accessedCnt = GetAccessCount($languages[$i]['id']);
                          ?>
                          <tr style="background-color:<?php echo $colors[COLOR_LANGUAGE_BAR]; ?>"><td class="smallText" width="100%" align="left" colspan="11"><b><?php echo $languages[$i]['name'] . '</b>&nbsp;&nbsp;' .$accessedCnt; ?></td></tr>
                          <?php
                          }
                          ?>
                          <tr class="smallText">
                            <th width="5%"  <?php echo $menuColors['visitor']; ?> ><?php echo TEXT_VISITOR . $sortDirectionArray[TEXT_SORT_BY_VISITOR]; ?></th>
                            <th width="14%" <?php echo $menuColors['filename']; ?> ><?php echo TEXT_FILE_NAME . $sortDirectionArray[TEXT_SORT_BY_FILENAME]; ?></th>
                            <th width="14%" <?php echo $menuColors['arg']; ?> ><?php echo TEXT_ARG . $sortDirectionArray[TEXT_SORT_BY_ARG]; ?></th>
                            <th width="3%"  <?php echo $menuColors['count']; ?> ><?php echo TEXT_VIEW_COUNT . $sortDirectionArray[TEXT_SORT_BY_COUNT]; ?></th>
                            <th width="10%" <?php echo $menuColors['ip_number']; ?> ><?php echo TEXT_IP . $sortDirectionArray[TEXT_SORT_BY_IP]; ?></th>
                            <th width="9%"  <?php echo $menuColors['date']; ?> ><?php echo TEXT_LAST_DATE . $sortDirectionArray[TEXT_SORT_BY_DATE]; ?></th>
                            <th width="3%" align="center"><?php echo TEXT_BAN_IP; ?></th>
                            <th width="3%" align="center"><?php echo TEXT_IGNORE_IP; ?></th>
                            <th width="3%" align="center"><?php echo TEXT_DELETE_IP; ?></th>
                            <th width="3%" align="center"><?php echo TEXT_KICK_OFF; ?></th>
                            <th width="1%" align="center"><?php echo TEXT_IP_DETAILS; ?></th>
                          </tr>
                          <tr><td style="padding-bottom:4px;"></td></tr>
                        </tr>
                      <?php } ?>
                        <tr class="smallText" <?php echo $colorArray['BG']; ?>>
                          <?php if (VIEW_COUNTER_SHOW_ACCOUNT_DETAILS == 'true' && $showPopup) { ?>
                           <td class="borderCell" width="5%" <?php echo $colorArray['visitor']; ?>><?php echo '<a onMouseover="ddrivetip(\'' . $showAccountDetails . '\',\'' . $colors[COLOR_CART_POPUP_BACK] . '\',\'' . $showWidth . '\' )"; onMouseout="hideddrivetip()"' . '>' . $visitorsName; ?></a></td>
                          <?php } else { ?>
                           <td class="borderCell" width="5%" <?php echo $colorArray['visitor']; ?>><?php echo GetVisitorName($view['bot_name']); ?></td>
                          <?php } ?>

                          <td class="borderCell" width="14%" <?php echo $colorArray['file_name']; ?>><?php echo $indent . '<a onMouseover="ddrivetip(\'' . $showCart . '\',\'' . $colors[COLOR_CART_POPUP_BACK] . '\',\'' . $showWidth . '\' )"; onMouseout="hideddrivetip()" href="' . HTTP_SERVER . DIR_WS_CATALOG . ($view['isadmin'] ? DIR_WS_ADMIN : '') . $view['file_name'] . '?' . $view['arg'] . '" target="_blank">' . $view['file_name'] . '</a>'; ?></td>
                          <td class="borderCell" width="14%" <?php echo $colorArray['args']; ?>><?php echo (tep_not_null($view['arg']) ? $view['arg'] . ShowPageItemName($view['arg']) : '&nbsp;'); ?></td>
                          <td class="borderCell" width="3%"><?php echo $view['view_count']; ?></td>
                          <td class="borderCell" width="10%"><span style="vertical-align:bottom;"><?php echo $flag . '<a onMouseover="ddrivetip(\'' . ShowIPDetails($domainInfo) . '\',\'' . $colors[COLOR_CART_POPUP_BACK] . '\',\'' . $showWidth . '\' )"; onMouseout="hideddrivetip()"' . '>' . $view['ip_number'] . '</a></span></span>'; ?></td>
                          <td class="borderCell" width="9%"><?php echo $view['date_time']; ?></td>
                          <td class="borderCell" width="3%" align="center"><?php echo  '<input type="radio" name="ban_ip_' . $view['ip_number'] . '", value="' . $view['ip_number'] . '", onchange="this.form.submit();">'; ?></td>
                          <td class="borderCell" width="3%" align="center"><?php echo  '<input type="radio" name="ignore_ip_' . $view['ip_number'] . '", value="' . $view['ip_number'] . '", onchange="this.form.submit();">'; ?></td>
                          <td class="borderCell" width="3%" align="center"><?php echo  '<input type="radio" name="delete_ip_' . $view['ip_number'] . '", value="' . $view['ip_number'] . '", onchange="this.form.submit();">'; ?></td>
                          <td class="borderCell" width="3%" align="center"><?php echo  '<input type="radio" name="kick_off_' . $view['ip_number'] . '", value="' . $view['ip_number'] . '", onchange="this.form.submit();">'; ?></td>
                          <td class="borderCell" width="1%" align="center"><a class="dia" href="#" id="<?php echo $view['ip_number'] ?>">?</a></td>
                          <?php echo tep_draw_hidden_field('this_session_id', $view['session_id']); ?>

                        </tr>
                     
                      <?php
                      }
                      $lastIP = $view['ip_number'];
                      $line++;  
              } //end of while language   
          //print Test_microtime_float() - $time_start;

             ?>    
             </table></td>  
           </tr>  
                
           <tr>       
             <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr>
                 <td class="smallText" valign="top"><?php echo $view_split->display_count($view_query_numrows, VIEW_COUNTER_MAX_ROWS, $pageNumb, TEXT_DISPLAY_NUMBER_OF_LINKS); ?></td>
                 <td class="smallText" align="right"><?php echo $view_split->display_links($view_query_numrows, VIEW_COUNTER_MAX_ROWS, VIEW_COUNTER_MAX_ROWS, $pageNumb, tep_get_all_get_params(array('page'))); ?></td>
               </tr>
             </table></td>  
           </tr>
       <?php       
       }   //end of all languages  
       ?>     
       </table></td>
      </tr> 
     </form>
     <!-- END OF ViewCounter -->
      
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require('includes/view_counter_footer.php'); ?>