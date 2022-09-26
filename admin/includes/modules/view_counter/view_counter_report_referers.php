<?php
/*
  Copyright (c) 2003 osCommerce
  Portions Copyright 2013 Jack York at http://www.oscommerce-solution.com 
*/

 //$db_query = tep_db_query("select bot_name, inet_ntoa(ip_number) as ip from view_counter where referrer > ''   group by ip_number having count(ip_number) > 10 order by last_date asc  ");
 $db_query = tep_db_query("select bot_name, inet_ntoa(ip_number) as ip from view_counter where referrer > ''   group by ip_number order by last_date asc  ");

 $iplist = array();
 $iplist[] = array('id' => TEXT_REPORT_PATH_TRACKER_PICK_IP, 'text' => TEXT_REPORT_PATH_TRACKER_PICK_IP);
 while ($db = tep_db_fetch_array($db_query)) {
     $text = ((tep_not_null($db['bot_name']) && $db['bot_name'] != 'bot_name') ? $db['ip'] .'-'.$db['bot_name'] : $db['ip']);
     $iplist[] = array('id' => $db['ip'], 'text' => $text);
 }
?>
    <div id="dhtmltooltip"></div> <!-- for tooltip popup //--> 
    <script src="includes/javascript/view_counter/ddrivetip.js"></script> <!-- must follow the above //--> 
    <div id='dialog'></div>  <!-- for ajax popup //-->    
    
   <tr>
     <td><table border="1" cellpadding="0" width="100%" class="BorderedBoxLight">
        
       <!-- BEGIN OF ViewCounter -->
       <?php echo tep_draw_form('view_counter_referers', 'view_counter_reports.php', '', 'post') . tep_draw_hidden_field('action', 'process_path'); ?> 
         <tr class="smallText">
           <td colspan="4"><table border="0" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;">
             <tr>
               <td><table border="0" cellpadding="0" width="40%">
                 <td class="smallText" style="width:60px; white-space:nowrap;"><?php echo TEXT_REPORT_PATH_TRACKER_IP_LIST . '&nbsp;'; ?></td>
                 <td class="smallText" align="left"><?php echo tep_draw_pull_down_menu('iplist', $iplist, $pathSelectedIP, 'onChange="this.form.submit();"'); ?></td>
                 <td class="smallText"  style="width:60px; white-space:nowrap;padding-left:10px;" align="right"><?php echo TEXT_REPORT_PATH_TRACKER_CURRENT_IP . '&nbsp;'; ?></td>
                 <td width="60"><?php echo tep_draw_input_field('current_ip', (($pathSelectedIP != TEXT_REPORT_PATH_TRACKER_PICK_IP) ? $pathSelectedIP : ''), 'maxlength="35" size="14"', false, '', false); ?> </td>
                 <td class="smallText"  style="width:60px; white-space:nowrap;padding-left:10px;" align="right"><?php echo TEXT_REPORT_PATH_TRACKER_EXCLUDE_IP . '&nbsp;'; ?></td>
                 <td width="60"><?php echo tep_draw_input_field('exclude_ip', $excludeIP, 'id="exclude_ip" maxlength="35" size="14" onChange="this.form.submit();"', false, '', false); ?> </td>
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
                
                 $where = " where referrer > '' ";
                 if ($pathSelectedIP != TEXT_REPORT_PATH_TRACKER_PICK_IP) { //do a full search
                     $where .= " and ip_number = INET_ATON('" . $pathSelectedIP . "') ";
                 } else if (! empty($excludeIP)) {
                     $where .= " and ip_number != INET_ATON('" . $excludeIP . "') ";                  
                 }
                 
                 $db_query = tep_db_query("select inet_ntoa(ip_number) as ip, referrer_query, referrer, last_date from view_counter " . $where . "order by last_date asc");
        
                 $data = '';                  
                 while ($db = tep_db_fetch_array($db_query)) {        
                     $domainInfo = GetDomainLocation($db['ip']);
                     $flag = (file_exists('images/view_counter/flags/' . strtolower($domainInfo['Country Code']) . '.png') ? '<img src="images/view_counter/flags/' . strtolower($domainInfo['Country Code']) . '.png" alt="' . $domainInfo['Country Name'] . '" title="' . $domainInfo['Country Name'] . '">' : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                 
                     $data .= '<tr>
                        <td class="smallText" width="150">' . $db['last_date'] . '</td>
                        <td class="smallText"><span style="vertical-align:bottom;">' . $flag . '<a onMouseover="ddrivetip(\'' . ShowIPDetails($domainInfo) . '\',\'' . $colors[COLOR_CART_POPUP_BACK] . '\',\'' . $showWidth . '\' )"; onMouseout="hideddrivetip()"' . '>' . $db['ip'] . '</a></span></span></td>
                        <td class="smallText">' . (tep_not_null($db['referrer']) ? $db['referrer'] : '&nbsp;') . '</td>
                      </tr>';
               
                 }       
  
                 if (! empty($data)) {
                     echo $data;
                 }
             } 
             ?>
 
     
         </table><td>
       </tr>
       
     </table></td>
   </tr>  
