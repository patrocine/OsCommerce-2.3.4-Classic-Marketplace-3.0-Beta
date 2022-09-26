<?php
/*
  Copyright (c) 2003 osCommerce
  Portions Copyright 2013 Jack York at http://www.oscommerce-solution.com 
*/
 
 $db_query = tep_db_query("select bot_name, inet_ntoa(ip_number) as ip from view_counter_storage group by ip ");
 
 $iplist = array();
 $iplist[] = array('id' => TEXT_REPORT_PATH_TRACKER_PICK_IP, 'text' => TEXT_REPORT_PATH_TRACKER_PICK_IP);
 while ($db = tep_db_fetch_array($db_query)) {
     $text = ((tep_not_null($db['bot_name']) && $db['bot_name'] != 'bot_name') ? $db['ip'] .'-'.$db['bot_name'] : $db['ip']);
     $iplist[] = array('id' => $db['ip'], 'text' => $text);
 }
 $pathSelectedIP = (! tep_not_null($pathSelectedIP) ? TEXT_REPORT_PATH_TRACKER_PICK_IP : $pathSelectedIP);
?>
   <tr>
     <td><table border="1" cellpadding="0" width="100%" class="BorderedBoxLight">
        
       <!-- BEGIN OF ViewCounter -->
       <?php echo tep_draw_form('view_counter_parts', 'view_counter_reports.php', '', 'post') . tep_draw_hidden_field('action', 'process_path'); ?> 
         <tr class="smallText">
           <td colspan="4"><table border="0" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;">
             <tr>
               <td><table border="0" cellpadding="0" width="40%">
                 <td class="smallText" style="width:60px; white-space:nowrap;"><?php echo TEXT_REPORT_PATH_TRACKER_IP_LIST . '&nbsp;'; ?></td>
                 <td class="smallText" align="left"><?php echo tep_draw_pull_down_menu('iplist', $iplist, $pathSelectedIP, 'onChange="this.form.submit();"'); ?></td>
                 <td class="smallText"  style="width:60px; white-space:nowrap;" align="right"><?php echo TEXT_REPORT_PATH_TRACKER_CURRENT_IP . '&nbsp;'; ?></td>
                 <td width="60"><?php echo tep_draw_input_field('current_ip', (($pathSelectedIP != TEXT_REPORT_PATH_TRACKER_PICK_IP) ? $pathSelectedIP : ''), 'maxlength="35" size="14"', false, '', false); ?> </td>
                 <?php echo tep_draw_hidden_field('show_report', $showReport) .
                            tep_draw_hidden_field('sortbyarray', serialize($sortByArray)) .
                            tep_draw_hidden_field('sortby', $sortBy) .
                            tep_draw_hidden_field('last_selected_ip', $pathSelectedIP);
                 ?>
               </table></td>
             </tr>  
           </table></td>
         </tr>            
       </form>

       <tr class="smallText">
         <td width="100%" ><table border="2" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;" class="smallText">
       
             <?php                  
             if (tep_not_null($pathSelectedIP)) {  
                 $db_query = tep_db_query("select file_name, arg, last_date from view_counter where ip_number = inet_aton('" . $pathSelectedIP . "') order by ip_number, last_date asc");
//                 $db_query = tep_db_query("select file_name, arg, last_date from view_counter_storage where ip = '" . tep_db_input($pathSelectedIP) . "' order by substring_index(ip, '.', 1) + 0, substring_index(substring_index(ip, '.', -3), '.', 1) + 0, substring_index(substring_index(ip, '.', -2), '.', 1) + 0, substring_index(ip, '.', -1) + 0");
//                 $db_query = tep_db_query("select vc.file_name, vc.arg, vc.last_date from view_counter_storage vc where ip = '" . tep_db_input($pathSelectedIP) . "' and NOT EXISTS (select NULL from view_counter_banned where ip = '" . tep_db_input($pathSelectedIP) . "')  order by substring_index(ip, '.', 1) + 0, substring_index(substring_index(ip, '.', -3), '.', 1) + 0, substring_index(substring_index(ip, '.', -2), '.', 1) + 0, substring_index(ip, '.', -1) + 0");
                 
                 $data = '';
                 while ($db = tep_db_fetch_array($db_query)) {                  
                     $data .= '<tr>
                                 <td class="smallText" width="150">' .  $db['last_date'] . '</td>
                                 <td class="smallText">' . $db['file_name'] . ' ' . $db['arg']. ShowPageItemName($db['arg']) . '</td>
                               </tr>';
                 } 
                 echo $data;
             } 
             ?> 
     
         </table><td>
       </tr>
       
     </table></td>
   </tr>  
