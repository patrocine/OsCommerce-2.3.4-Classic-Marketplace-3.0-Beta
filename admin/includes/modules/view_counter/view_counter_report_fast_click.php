<?php
/*
  Copyright (c) 2003 osCommerce
  Portions Copyright 2013 Jack York at http://www.oscommerce-solution.com 
*/
 
 $db_query = tep_db_query("select bot_name, inet_ntoa(ip_number) as ip from view_counter group by ip_number having count(ip_number) > 10 order by last_date asc  ");
 
 
 $iplist = array();
 $iplist[] = array('id' => TEXT_REPORT_PATH_TRACKER_PICK_IP, 'text' => TEXT_REPORT_PATH_TRACKER_PICK_IP);
 while ($db = tep_db_fetch_array($db_query)) {
     $text = ((tep_not_null($db['bot_name']) && $db['bot_name'] != 'bot_name') ? $db['ip'] .'-'.$db['bot_name'] : $db['ip']);
     $iplist[] = array('id' => $db['ip'], 'text' => $text);
 }
   $pathSelectedIP = (! tep_not_null($pathSelectedIP) ? TEXT_REPORT_PATH_TRACKER_PICK_IP : $pathSelectedIP);
?>
   <tr>
     <td><table border="0" cellpadding="0" width="100%" class="BorderedBoxLight">
        
       <!-- BEGIN OF ViewCounter -->
       <?php echo tep_draw_form('view_counter_parts', 'view_counter_reports.php', '', 'post') . tep_draw_hidden_field('action', 'process_path'); ?> 
         <tr class="smallText">
           <td colspan="4"><table border="0" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;">
           
             <tr>
              <td>
               <div class="smallText">
                 <div style="display:inline-block;"><?php echo TEXT_REPORT_PATH_TRACKER_IP_LIST . '&nbsp;'; ?></div>
                 <div style="display:inline-block;"><?php echo tep_draw_pull_down_menu('iplist', $iplist, $pathSelectedIP, 'onChange="this.form.submit();"'); ?></div>
                 <div style="display:inline-block; margin-left:10px"><?php echo TEXT_REPORT_PATH_TRACKER_CURRENT_IP . '&nbsp;'; ?></div>
                 <div style="display:inline-block;"><?php echo tep_draw_input_field('current_ip', (($pathSelectedIP != TEXT_REPORT_PATH_TRACKER_PICK_IP) ? $pathSelectedIP : ''), 'maxlength="35" size="14"', false, '', false); ?> </div>
                 <div style="display:inline-block; margin-left:10px"><?php echo TEXT_REPORT_PATH_TRACKER_BAN_IP . '&nbsp;'; ?></div>
                 <div style="display:inline-block;"><INPUT TYPE="radio" NAME="ban_fast_ip" onChange="this.form.submit();"></div>
                </div> 
      
                <?php echo tep_draw_hidden_field('show_report', $showReport) .
                           tep_draw_hidden_field('sortbyarray', serialize($sortByArray)) .
                           tep_draw_hidden_field('sortby', $sortBy) .
                           tep_draw_hidden_field('last_selected_ip', $pathSelectedIP);
                ?>
              </td>
             </tr>   
           </table></td>
         </tr>            
       </form>

       <tr class="smallText">
         <td width="100%" ><table border="2" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;" class="smallText">
       
             <?php 
                 
             if (tep_not_null($pathSelectedIP)) {  
                 $db_query = tep_db_query("select file_name, arg, last_date, inet_ntoa(ip_number) as ip from view_counter where ip_number = inet_aton('" . $pathSelectedIP .  "') order by last_date asc");
           
                 $data = '';
                 while ($db = tep_db_fetch_array($db_query)) {  
                     $data .= '<tr>
                                <td class="smallText" width="150">' . $db['last_date'] . '</td>
                                <td class="smallText">' . $db['file_name'] . ' ' . $db['arg'] . '</td>
                              </tr>';
                 } 
                 echo $data;
             } 
             ?> 
     
         </table><td>
       </tr>
       
     </table></td>
   </tr>  
