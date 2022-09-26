<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require('includes/languages/' . $language . '/view_counter.php');  
  require('includes/functions/view_counter.php');
  
  $htaccess_backup_files = array();
  $separator = ((substr(DIR_FS_CATALOG, -1) != '/') ? '/' : '');
  $selectedCountries = array();
  
  if (is_dir(DIR_FS_CATALOG . $separator . TEXT_HTACCESS_BACKUP_LOCN)) {
      $htaccess_backup_files = scandir(DIR_FS_CATALOG . $separator . TEXT_HTACCESS_BACKUP_LOCN);

      $htaccessFileArray = array();
      $htaccessFileArray[] = array('id' => TEXT_HTACCESS_CHOOSE, 'text' => TEXT_HTACCESS_CHOOSE);
      $ctr = 1;
      foreach ($htaccess_backup_files as $file) {
          if (strpos($file, 'htaccess_bkup') !== FALSE) {
              $htaccessFileArray[] = array('id' => $ctr++, 'text' => $file);
          }
      }  
  } 
 
  /*********************** HANDLE THE MAINTENANCE SECTION ************************/
  if (isset($_POST['action']) && $_POST['action'] == 'process') {
  
      if (isset($_POST['htaccess_group'])) {
      
          switch ($_POST['htaccess_group']) {      
              case 'htaccess_backup': 
                  $type = '';
                  $result = HtaccessBackup($type);
                  $messageStack->add($result, $type);
              break;          
          
              case 'htaccess_restore':
                  if ($_POST['htaccess_file'] != TEXT_HTACCESS_CHOOSE) {
                      $type = '';
                      $result = HtaccessRestore($htaccessFileArray[$_POST['htaccess_file']]['text'], $type);
                      $messageStack->add($result, $type);
                  } else {
                      $messageStack->add(ERROR_HTACCESS_INVALID_FILE, 'error');                  
                  }
              break;              

              case 'htaccess_rebuild':
                  $type = '';
                  $result = HtaccessRebuild($type);
                  $messageStack->add($result, $type);
              break;
              
              case 'htaccess_rebuild_banned':
                  $type = '';
                  $result = HtaccessRebuildBannedList($type);
                  $messageStack->add($result, $type);
              break;              
              
              case 'htaccess_whitelist_ip':
                  $ip = $_POST['whitelist_ip'];
                  if (IsValidIP($ip)) {
                      $type = '';
                      $result = HtaccessWhitelistIP($ip, $type);
                      $messageStack->add($result, $type);
                  } else {
                      $messageStack->add(sprintf(ERROR_RANGE_BLOCK, $ip), 'error');
                  }
              break;              
          }
      }
      $openSection = "'statusMsgMaint', 'imgStatusMaint'";      
  }
  
  /*********************** HANDLE THE EDITOR ************************/
  else if (isset($_POST['action']) && $_POST['action'] == 'process_editor') {  
      $data = $_POST['htaccess_data'];
      $arrayWrite = explode("\n", $data);
      $htaccessFile = DIR_FS_CATALOG . '.htaccess';

      for ($i = 0; $i < count($arrayWrite); ++$i) {
          $arrayWrite[$i] .= "\n"; //re-attach the line ending
      }

      $type = '';
      $result = HtaccessBackup($type);
      $messageStack->add($result, $type);
      
      WriteHTAccess($htaccessFile, $arrayWrite); 
      $openSection = "'statusMsgHtaccess', 'imgStatusHtaccess'";
  }  
    
  /*********************** HANDLE BLOCKING COUNTRIES ************************/
  else if (isset($_POST['action']) && $_POST['action'] == 'process_block_countries_notification') { 
      /**************** UPDATE THE BLOCKED COUTNRIES LIST ****************/ 
      if (isset($_POST['update'])) {
          $cnt = 0; 
          if (isset($_POST['country'])) {      
              foreach ($_POST['country'] as $$country => $text) {
                  if ($text == TEXT_BLOCK_COUNTRIES_SELECT) { //invalid selection
                      $cnt = 0;
                      break;
                  } else {
                      $cnt++;
                  }    
              }
          }
         
          if (! $cnt) { //either no selection was made or the selection includes the text to select
              $messageStack->add(ERROR_BLOCK_COUNTRY_SELECTION_ERROR, 'error');
          } else {   
              
              $doAdd = (strpos($_POST['update'], 'ADD') !== FALSE ? true : false);
              $prevList = array();
              
              //Create the array of previously picked countries
              if ($doAdd) {
                  $db_query = tep_db_query("select name_to_block as country from view_counter_block_list");

                  if (tep_db_num_rows($db_query)) {
                      while ($db = tep_db_fetch_array($db_query)) {
                          $prevList[] = array('id' => $db['country'], 'text' => $db['country']); 
                      }     
                  }
              } 
              
              //Create the array of just picked countries
              foreach ($_POST['country'] as $country => $text) {
                  $text = trim($text);
                  if (! $doAdd || ($doAdd && ! VC_in_multi_array($text, $prevList))) {
                      $selectedCountries[] = array('id' => $text, 'text' => $text); 
                  }
              }               
              
              //Merge the two arrays              
              if ($doAdd) {
                  $selectedCountries = array_merge($selectedCountries, $prevList);
              } 
              
              tep_db_query("TRUNCATE view_counter_block_list");
 
              for ($i = 0; $i < count($selectedCountries); ++$i) {
                  $text = $selectedCountries[$i]['text'];
                  tep_db_query("insert into view_counter_block_list (name_to_block) values ('" . tep_db_input($text) . "')");
              }
          }
      }
      /**************** DELETE THE BLOCKED COUTNRIES ****************/ 
      else {
          $ctry = tep_db_prepare_input($_POST['blocked_countries']);
          $db_query = tep_db_query("delete from view_counter_blocked where country = '" . tep_db_input($ctry) . "'");
      }
      $openSection = "'statusMsgBlockCtry', 'imgStatusBlockCtry'";
  }  
  
  /*********************** SEND VISITOR A MESSAGE ************************/
  else if (isset($_POST['action']) && $_POST['action'] == 'process_customer_notification') {  
      if (VIEW_COUNTER_ENABLE_KILL_SESSION == 'true') {
          $data = tep_db_prepare_input($_POST['customer_msg']);
          $ip = (int)$_POST['customer_ip'];

          $activeTime = (VIEW_COUNTER_ACTIVE_TIME > 0 ? VIEW_COUNTER_ACTIVE_TIME : 5);
          $whereActive = " and last_date > (NOW() - INTERVAL " . (int)$activeTime . " MINUTE ) ";
          $db_query = tep_db_query("select session_id from view_counter where ip_number = " . $ip . " and ip_active=1 and isadmin = '' and language_id = " . (int)$languages_id . $whereActive . " group by ip_number order by last_date asc");
          $db = tep_db_fetch_array($db_query);

          $msg = tep_db_prepare_input($data);
          $session = $db['session_id'];

          KickOffIP($ip, $session, $msg);
          
          $messageStack->add(TEXT_CUSTOMER_MESSAGE_SUCCESS, 'success');
      } else {
          $messageStack->add(ERROR_KICK_NOT_ENABLED, 'error');
      }             
      $openSection = "'statusMsgBlockCust', 'imgStatusCust'";
  }  
  
  require('includes/view_counter_header.php');   
  
  $colors = array();  
  LoadColorSettings($colors);  
  
  $blockedArray = array();
  $db_query = tep_db_query("select country, count(count) as ttl   from view_counter_blocked GROUP BY country ORDER BY country ");
  if (tep_db_num_rows($db_query)) {
      while ($db = tep_db_fetch_array($db_query)) {
          $blockedArray[] = array('id' => $db['country'], 'text' => $db['country'] . ' (' . $db['ttl'] . ')');
      }
  }
  
  $cntryArray = GetCountriesList();
   
  if (count($selectedCountries) == 0) {
      $db_query = tep_db_query("select name_to_block from view_counter_block_list name_to_block ");
 
      if (tep_db_num_rows($db_query)) {
          $pos = 0;
          while ($db = tep_db_fetch_array($db_query)) {
              foreach ($cntryArray as $key => $name) {
                  if (trim($name['text']) == $db['name_to_block']) {
                      $selectedCountries[$pos] = array('id' => $db['name_to_block'], 'text' => $db['name_to_block']);
                      $pos++;    
                  }                     
              }
          }
      }
  }
?>

<script language="javascript" type="text/javascript"><!--

function showHelpTools(){
	$( "#dialog-modal" ).dialog({
  width: 600,
  height: 400,
  modal: true,
  open: function(event, ui)	{
   $(this).load("view_counter_help.php?file=tools");
  }
 });
}

function switchView(obj, imgsrc) {
	var el = document.getElementById(obj);
// var img = document.getElementById('imgStatus');
 var img = document.getElementById(imgsrc);
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
//--></script>  
  
<style type="text/css">
table.BorderedBox {border:ridge #CCFFCC 3px; background-color: #ddd; }
table.BorderedBoxWhite {border:ridge #CCFFCC 3px; background-color: <?php echo $colors[COLOR_HDR_BKGND]; ?>; }
table.BorderedBoxLight {border:ridge #CCFFCC 3px; background-color: <?php echo $colors[COLOR_OPTIONS]; ?>; }
table.rightBar {border-right:2px solid gray;}
tr.Header { background-color: #CCFFCC; }
.em_small { font-family: Verdana, Arial, sans-serif; font-size: 10px; font-weight:bold }
input { vertical-align: middle; margin-top: -1px;}
th { border-width:thin; border-style: outset; background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>} 
</style>

<?php if (strpos(PROJECT_VERSION, 'v2.3') !== FALSE) { ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php } else { ?>
<body bgcolor="#FFFFFF" onload="switchView(<?php echo $openSection; ?>);">
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
 
    <td width="100%" valign="top"><table border="2" width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="BorderedBoxWhite colortable">
       <tr>
        <td class="pageheading" colspan="2"><?php echo HEADING_TOOLS; ?></td>
       </tr>
       <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>   
       <tr>
        <td class="main" colspan="2"><?php echo HEADING_TOOLS_EXPLAIN; ?></td>
       </tr>
       <tr>       
      </table></td>  
     </tr>    
          
     
     <!-- BEGIN OF ViewCounter -->
     <tr>
       <td><table border="1" width="100%" class="BorderedBoxLight">
         <tr style="background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>">
           <td class="smallText"><div style="float:left; width:180px;"><b><?php echo '<a href="##Gotostatusmsg" onClick="switchView(\'statusMsgMaint\', \'imgStatusMaint\'); return false;"><img src="images/view_counter/vc_arrow_down.gif" border="0" id="imgStatusMaint" alt="show" title="show"></a>' . TEXT_HTACCESS_TOOLS; ?></b></div></td>
         </tr>
         
         <tr>
           <td id="statusMsgMaint" style="display:none"> 
             <?php echo tep_draw_form('view_counter_main', 'view_counter_tools.php', '', 'post') . tep_draw_hidden_field('action', 'process'); ?> 
       
             <div class="smallText" style="width:500px;">
             
               <div style="padding-top:4px;">
                 <div style="float:left; width:180px;"><b><?php echo TEXT_HTACCESS_BACKUP; ?></b></div>
                 <div style="float:left;"><?php echo tep_draw_radio_field('htaccess_group', 'htaccess_backup', false); ?> </div>
               </div>
               
               <div style="padding-top:20px;">
                 <div style="float:left; width:180px;"><b><?php echo TEXT_HTACCESS_RESTORE; ?></b></div>
                 <div style="float:left;"><?php echo tep_draw_radio_field('htaccess_group', 'htaccess_restore', false); ?> </div>
                 <div style="float:left;  padding-left:10px;"><?php echo tep_draw_pull_down_menu('htaccess_file', $htaccessFileArray); ?></div>
               </div>

               <div style="padding-top:20px;">
                 <div style="float:left; width:180px;"><b><?php echo TEXT_HTACCESS_REBUILD; ?></b></div>
                 <div style="float:left;"><?php echo tep_draw_radio_field('htaccess_group', 'htaccess_rebuild', false); ?> </div>
               </div>
               
               <div style="padding-top:20px;">
                 <div style="float:left; width:180px;"><b><?php echo TEXT_HTACCESS_REBUILD_BANNED; ?></b></div>
                 <div style="float:left;"><?php echo tep_draw_radio_field('htaccess_group', 'htaccess_rebuild_banned', false); ?> </div>
               </div>               

               <div style="padding-top:20px;">
                 <div style="float:left; width:180px;"><b><?php echo TEXT_HTACCESS_WHITELIST; ?></b></div>
                 <div style="float:left;"><?php echo tep_draw_radio_field('htaccess_group', 'htaccess_whitelist_ip', false); ?> </div>
                 <div style="float:left; padding-left:10px;"><?php echo tep_draw_input_field('whitelist_ip', '', 'maxlength="15"', false); ?> </div>
                 
               </div>
               
               <div style="padding-top:30px;">
                 <div><input type="submit" name="update"></div>
               </div>  
            </div>

            </form>
           </td>  
         </tr>  
       </table></td>
     </tr>  
     
     
     <!-- BEGIN CUSTOMER NOTIFICATION -->
     <tr>
       <td><table border="1" width="100%" class="BorderedBoxLight">
         <?php echo tep_draw_form('view_counter_customer_notification', 'view_counter_tools.php', '', 'post') . tep_draw_hidden_field('action', 'process_customer_notification'); 
         
          $activeTime = (VIEW_COUNTER_ACTIVE_TIME > 0 ? VIEW_COUNTER_ACTIVE_TIME : 5);
          $whereActive = " and last_date > (NOW() - INTERVAL " . (int)$activeTime . " MINUTE ) ";    
          $db_query = tep_db_query("select ip_number, inet_ntoa(ip_number) as ip from view_counter where ip_active=1 and isadmin = '' and language_id = " . (int)$languages_id . $whereActive . " group by ip_number order by last_date asc");

          $activeIPArray = array();
          $activeIPArray[] = array('id' => TEXT_CUSTOMER_ACTIVE_SESSIONS, 'text' => TEXT_CUSTOMER_ACTIVE_SESSIONS);

          while ($db = tep_db_fetch_array($db_query)) {   
              $activeIPArray[] = array('id' => $db['ip_number'], 'text' => $db['ip']);
          }
         ?>       

          <tr style="background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>">
            <td colspan="2"> 
              <div class="smallText" style="width:500px; float:left;"><b><?php echo '<a href="##Gotostatusmsg" onClick="switchView(\'statusMsgCust\', \'imgStatusCust\'); return false;"><img src="images/view_counter/vc_arrow_down.gif" border="none" id="imgStatusCust" alt="show" title="show"></a>' . TEXT_CUSTOMER_NOTIFICATION; ?></b>
            </td>  
          </tr> 
          <tr>
            <td id="statusMsgCust" style="display:none">
              <div style="float:left;"><?php echo tep_draw_textarea_field('customer_msg', 'soft', 70, 20, TEXT_CUSTOMER_MESSAGE, '', false); ?></div>  
   
              <div style="float:left; padding-top:4px;  padding-left:10px;">
                <div class="smallText" style="float:left; padding-left:6px;"><?php echo tep_draw_pull_down_menu('customer_ip', $activeIPArray); ?></div>
                <div style="float:right; padding-left:6px;"><input type="submit" name="update"></div>
              </div>                
            </td>
          </tr>  
         </form>
       </table></td>
     </tr> 
     <!-- END CUSTOMER NOTIFICATION -->     
     
     
     <!-- BEGIN BLOCK COUNTRIES -->
     <tr>
       <td><table border="1" width="100%" class="BorderedBoxLight">
         <?php echo tep_draw_form('view_counter_block_countries', 'view_counter_tools.php', '', 'post') . tep_draw_hidden_field('action', 'process_block_countries_notification'); ?>       

          <tr style="background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>">
            <td colspan="2"> 
              <div class="smallText" style="width:500px; float:left;"><b><?php echo '<a href="##Gotostatusmsg" onClick="switchView(\'statusMsgBlockCtry\', \'imgStatusBlockCtry\'); return false;"><img src="images/view_counter/vc_arrow_down.gif" border="none" id="imgStatusBlockCtry" alt="show" title="show"></a>' . TEXT_BLOCK_COUNTRIES; ?></b>
            </td>  
          </tr> 
          <tr>
            <td id="statusMsgBlockCtry" style="display:none;">
              <table border="0" width="100%" cellpadding="0">
               <tr>
                <td style="width:800px;">
                 <div>
                  <div style="display:inline-block; padding-top:10px; padding-left:4px;"><?php echo TEXT_BLOCK_LIST_EXPLAIN; ?></div>
                  <div style="display:inline-block; padding-top:10px; padding-left:25px;"><?php echo TEXT_BLOCKED_EXPLAIN; ?></div>
                 </div>   

                 <div>
                  <div class="smallText" style="display:inline-block; padding-top:10px; padding-left:6px;"><?php echo VCMultiSelectMenu('country[]', $cntryArray, $selectedCountries, ' style="width:260;" size="20" id="countrylist"') . '</div>'; ?>
                  <div class="smallText" style="display:inline-block; padding-top:10px; padding-left:30px;"><?php echo tep_draw_pull_down_menu('blocked_countries', $blockedArray, '', ' style="width:260;" size="20"') . '</div>'; ?>
                  <div class="smallText" style="display:inline-block; padding-top:10px; padding-left:20px; vertical-align:top; width:300px;"><?php echo TEXT_BLOCK_COUNTRIES_EXPLAIN . '</div>'; ?>
                 </div>  
                 
                 <div>
                  <div style="display:inline-block; padding-top:10px; padding-left:4px;"><input type="submit" name="update" value="<?php echo TEXT_BLOCK_COUNTRIES_UPDATE; ?>" style="font-size:10px; height:18px; width:126px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></div>
                  <div style="display:inline-block; padding-top:10px; padding-left:8px;"><input type="submit" name="update" value="<?php echo TEXT_BLOCK_COUNTRIES_ADD; ?>" style="font-size:10px; height:18px; width:126px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></div>
                  <div style="display:inline-block; padding-top:10px; padding-left:88px;"><input type="submit" name="delete_block" value="<?php echo TEXT_BLOCK_COUNTRY_DELETE; ?>" style="font-size:10px; height:18px; width:126px; border:1px solid #000; background:<?php echo $colors[COLOR_BUTTONS]; ?>"></div>
                 </div> 
                </td>
               </tr>
              </table>
                
            </td>
          </tr>  

         </form>
       </table></td>
     </tr> 
     <!-- END BLOCK COUNTRIES -->        
     
     
     <!-- BEGIN HTACCESS EDITOR --> 
     <tr>
       <td><table border="1" width="100%" class="BorderedBoxLight">
         <tr style="background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>">
           <td class="smallText"><div style="float:left; width:180px;"><b><?php echo '<a href="##Gotostatusmsg" onClick="switchView(\'statusMsgHtaccess\', \'imgStatusHtaccess\'); return false;"><img src="images/view_counter/vc_arrow_down.gif" border="0" id="imgStatusHtaccess" alt="show" title="show"></a>' . TEXT_HTACCESS_EDITOR; ?></b></div></td>
         </tr>
         <tr>         
           <td id="statusMsgHtaccess" style="display:none"> 
             <?php echo tep_draw_form('view_counter_editor', 'view_counter_tools.php', '', 'post') . tep_draw_hidden_field('action', 'process_editor'); 
             $htaccessFile = file_get_contents(DIR_FS_CATALOG . '.htaccess');
             ?> 
       
             <div class="smallText" style="width:500px;">
             
               <div style="padding-top:4px;">
                 <div><?php echo tep_draw_textarea_field('htaccess_data', 'soft', 120, 20, $htaccessFile, '', false); ?></div>
               </div>
               
               <div style="padding-top:30px;">
                 <div><input type="submit" name="update"></div>
               </div>  
            </div>

            </form>
           </td>  
         </tr>  
        </table></td>
      </tr>  
     <!-- END OF ViewCounter -->
      
    </table></td>
<!-- body_TOOLS_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require('includes/view_counter_footer.php'); ?>