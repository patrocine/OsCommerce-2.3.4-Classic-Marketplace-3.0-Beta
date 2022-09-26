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
  
  $defaultCol = array();  
  $showArg = (isset($_REQUEST['showarg']) ? unserialize(urldecode($_REQUEST['showarg'])) : array('no' => ' checked ', 'yes' => '' ));
  $showBots = '';
  $showReport = (isset($_REQUEST['show_report']) ? $_REQUEST['show_report'] : '');
  $sortBy = (isset($_REQUEST['sortby']) ? ( (strpos($_REQUEST['sortby'], 'gg') !== FALSE) ? str_replace('gg', ' ', $_REQUEST['sortby']) : $_REQUEST['sortby'] ) : ' order by ip asc ');
  $sortByArray = (isset($_REQUEST['sortbyarray']) ? unserialize(urldecode($_REQUEST['sortbyarray'])) : array());
  $sortIP = array('count' => '', 'isbot' => '', 'ip' => 'checked');
  $sortDirection = array(); 
  $pageNumb = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);  
  $pathSelectedIP = TEXT_REPORT_PATH_TRACKER_PICK_IP;
  $pathShowTracking = false;
 
  /*********************** HANDLE THE REPORT SELECTION ************************/
  if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'choose_report')) {
 
      switch ($_REQUEST['report_types']) {
          case TEXT_REPORT_FAST_CLICK: $showReport = TEXT_REPORT_FAST_CLICK;  break;
          case TEXT_REPORT_HACKING_ATTEMPTS: $showReport = TEXT_REPORT_HACKING_ATTEMPTS;  break;
          case TEXT_REPORT_IP_COUNT: $showReport = TEXT_REPORT_IP_COUNT; $defaultCol['ip'] = 'checked'; $sortBy = ' order by ip asc '; break;
          case TEXT_REPORT_PAGE_COUNT: $showReport = TEXT_REPORT_PAGE_COUNT; $defaultCol['filename'] = 'checked'; $sortBy = ' order by file_name asc '; break;
          case TEXT_REPORT_PAGE_NOT_VISITED: $showReport = TEXT_REPORT_PAGE_NOT_VISITED;  break;
          case TEXT_REPORT_PATH_TRACKER: $showReport = TEXT_REPORT_PATH_TRACKER;  break;
          case TEXT_REPORT_REFERERS: $showReport = TEXT_REPORT_REFERERS;  break;
          
          default: $showReport = '';
      }
  }
  
  /*********************** SORT THE IP REPORT ************************/
  if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'process_ips' && isset($_REQUEST['colsortSet'])) {
      $showArg = (isset($_REQUEST['showarg']) ? unserialize(urldecode($_REQUEST['showarg'])) : '');
      $sortBy = $_REQUEST['sortby'];
      GetSorting($sortByArray, $sortBy, $_REQUEST['colsortType'], $sortDirection);
      $showReport = (isset($_REQUEST['show_report']) ? $_REQUEST['show_report'] : '');
  }
  
  /*********************** HANDLE THE REPORT OPTIONS ************************/
  else if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'process')) {
      $showArg = array();
      $showBots = ((isset($_REQUEST['show_bots']) && $_REQUEST['show_bots'] == 'on' ) ? ' checked ' : '');
      $sortBy = $_REQUEST['sortby'];
      $sortByArray = unserialize(urldecode($_REQUEST['sortbyarray']));
      $showReport = (tep_not_null($showReport) ? $showReport : (isset($_REQUEST['show_report']) ? $_REQUEST['show_report'] : ''));
      if (isset($_REQUEST['show_arg'])) {
          if ($_REQUEST['show_arg'] == TEXT_REPORT_SHOW_ARG_YES) {
              $showArg['yes'] = ' checked ';
          } else {
              $showArg['no'] = ' checked ';              
          }
      } 
    
      $group_data = array('show_arg' => $showArg, 'show_bots' => $showBots, 'sortbyarray' => $sortByArray, 'sortby' => $sortBy);
      SaveSettingsReports($showReport, $group_data);
  }
  
  else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'process_path') {
      $showArg = array();
      $sortBy = $_REQUEST['sortby'];
      $showReport = (isset($_REQUEST['show_report']) ? $_REQUEST['show_report'] : '');
      $useIP = $_REQUEST['iplist']; 
      $excludeIP = '';
      if (isset($_REQUEST['current_ip']) && tep_not_null($_REQUEST['current_ip']) && $_REQUEST['current_ip'] != $_REQUEST['last_selected_ip']) {
          $useIP = $_REQUEST['current_ip'];
          $excludeIP = $_REQUEST['exclude_ip'];
      }
      if (isset($_REQUEST['exclude_ip'])) {
          $excludeIP = $_REQUEST['exclude_ip'];
      }
       
      if ($useIP != TEXT_REPORT_PATH_TRACKER_PICK_IP) {
          if (isset($_REQUEST['ban_fast_ip']) && $_REQUEST['ban_fast_ip'] == 'on') {
              if (AlterHtaccessFile($useIP)) {              
                  $messageStack->add(sprintf(SUCCESS_IP_BANNED, $useIP), 'success');
              } 
          } else { 
              $pathSelectedIP = tep_db_prepare_input($useIP);
          }
      }
  }  
  
  else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'process_hackers') {
      $post = array_flip($_POST);
      if (isset($post[TEXT_BUTTON_BAN_IP])) {
          $result = AlterHtaccessFile($post[TEXT_BUTTON_BAN_IP]);
          if ($result) {
              $messageStack->add(sprintf(SUCCESS_RANGE_BLOCK, $ipArray[$i]), 'success');
          } else {    
              $messageStack->add(sprintf(ERROR_IP_ALREADY_BANNED, $ipArray[$i]), 'error');
          } 
          $showReport = (isset($_REQUEST['show_report']) ? $_REQUEST['show_report'] : '');
      }      
  }
  
  $colors = array();  
  $group_data = array();
  
  LoadColorSettings($colors);
  
  if (LoadSettingsReports($showReport, $group_data)) {
      $showArg = $group_data['show_arg'];
      $showBots = $group_data['show_bots'];
      $sortByArray = $group_data['sortbyarray'];
      $sortBy = $group_data['sortby'];
  } 
 
  if (empty($sortByArray)) {
      $sortByArray['date'] = '';
      $sortByArray['filename'] = $defaultCol['filename'];
      $sortByArray['ip'] = $defaultCol['ip'];
      $sortByArray['count'] =  '';
      $sortByArray['arg'] =  '';
      $sortByArray['visitor'] =  '';
  }
 
  $choicesArray = array(TEXT_REPORT_CHOICES, 
                        TEXT_REPORT_FAST_CLICK,
                        TEXT_REPORT_HACKING_ATTEMPTS,
                        TEXT_REPORT_IP_COUNT,
                        TEXT_REPORT_PAGE_COUNT,
                        TEXT_REPORT_PAGE_NOT_VISITED,
                        TEXT_REPORT_PATH_TRACKER,
                        TEXT_REPORT_REFERERS
                       ); 
  $explainArray = array(EXPLAIN_TEXT_REPORT_CHOICES, 
                        EXPLAIN_TEXT_REPORT_FAST_CLICK,
                        EXPLAIN_TEXT_REPORT_HACKING_ATTEMPTS,
                        EXPLAIN_TEXT_REPORT_IP_COUNT,
                        EXPLAIN_TEXT_REPORT_PAGE_COUNT,
                        EXPLAIN_TEXT_REPORT_PAGE_NOT_VISITED,
                        EXPLAIN_TEXT_REPORT_PATH_TRACKER,
                        EXPLAIN_TEXT_REPORT_REFERERS
                       );                        
  $reportTypes = array();
  $explainReport = '';
  
  for ($i = 0; $i < count($choicesArray); ++$i) {
      $reportTypes[] = array('id' => $choicesArray[$i], 'text' => $choicesArray[$i]);
      
      if ($showReport == $choicesArray[$i]) {
         $explainReport = $explainArray[$i];    
      }
  }
 
  require('includes/view_counter_header.php');   
?>

<style type="text/css">
table.BorderedBox {border:ridge #CCFFCC 3px; background-color: #ddd; }
table.BorderedBoxWhite {border:ridge #CCFFCC 3px; background-color: <?php echo $colors[COLOR_HDR_BKGND]; ?>; }
table.BorderedBoxLight {border:ridge #CCFFCC 3px; background-color: <?php echo $colors[COLOR_OPTIONS]; ?>; }
table.rightBar {border-right:2px solid gray;}
tr.Header { background-color: #CCFFCC; }
.em_small { font-family: Verdana, Arial, sans-serif; font-size: 10px; font-weight:bold }
input { vertical-align: middle; margin-top: -1px;}
th { border-width:thin; border-style: outset; background-color:<?php echo $colors[COLOR_COL_HEADINGS]; ?>}
#dhtmltooltip{
position: absolute;
width: 250px;
border: 2px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}
</style>
<script language="javascript" type="text/javascript">
function SortColumn(col, form) {
  var colsortSet = document.getElementsByName('colsortSet')[0];
  colsortSet.value = true;
  var colsortType = document.getElementsByName('colsortType')[0];
  colsortType.value = col;
  document.forms[form].submit();
}
</script>
 

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
 
    <td width="100%" valign="top"><table border="2" width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="BorderedBoxWhite colortable">
       <tr>
        <td class="pageheading" colspan="2"><?php echo HEADING_REPORTS; ?></td>
       </tr>
       <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>   
      </table></td>  
     </tr>    
     
     <tr>
       <td><table border="1" width="100%" class="BorderedBoxLight">
          
         <!-- BEGIN OF ViewCounter -->
         <?php echo tep_draw_form('view_counter_main', 'view_counter_reports.php', '', 'post') . tep_draw_hidden_field('action', 'choose_report'); ?> 
       
           <tr class="smallText">
             <td width="100%"><table border="0" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;">
               <tr>
                 <td width="100%"><table border="0" cellpadding="0" width="100%">
                   <td class="main" width="130"><?php echo TEXT_REPORT_SELECT_TYPE; ?></td>
                   <td class="main"><?php echo tep_draw_pull_down_menu('report_types', $reportTypes, $showReport, 'onChange="this.form.submit();"'); ?></td>
                   <td class="smallText"><?php echo $explainReport; ?></td>
                 </table></td>
               </tr>  
             </table></td>
           </tr>            
         </form>
       </table></td>
     </tr>       
     
 
     <?php 
     if ($showReport) { 
         switch ($showReport) {
             case TEXT_REPORT_FAST_CLICK:       include('includes/modules/view_counter/view_counter_report_fast_click.php'); break;
             case TEXT_REPORT_HACKING_ATTEMPTS: include('includes/modules/view_counter/view_counter_report_hacking_attempts.php'); break;
             case TEXT_REPORT_IP_COUNT:         include('includes/modules/view_counter/view_counter_report_ip_count.php'); break;
             case TEXT_REPORT_PAGE_COUNT:       include('includes/modules/view_counter/view_counter_report_page_count.php'); break;
             case TEXT_REPORT_PAGE_NOT_VISITED: include('includes/modules/view_counter/view_counter_report_page_not_visited.php'); break;
             case TEXT_REPORT_PATH_TRACKER:     include('includes/modules/view_counter/view_counter_report_path_tracker.php'); break;
             case TEXT_REPORT_REFERERS:         include('includes/modules/view_counter/view_counter_report_referers.php'); break;
         }
     } 
     ?> 
     <!-- END OF ViewCounter -->
      
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
<?php require('includes/view_counter_footer.php'); ?>