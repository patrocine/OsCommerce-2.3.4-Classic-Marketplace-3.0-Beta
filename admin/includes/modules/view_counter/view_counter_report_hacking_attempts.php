<?php
/*
  Copyright (c) 2003 osCommerce
  Portions Copyright 2013 Jack York at http://www.oscommerce-solution.com 
*/
  
 $cmpArry = GetHackerWords(); 
 $data = '';
?>
   <tr>
     <td><table border="1" cellpadding="0" width="100%" class="BorderedBoxLight">
        
       <!-- BEGIN OF ViewCounter -->
       <?php echo tep_draw_form('view_counter_hackers', 'view_counter_reports.php', '', 'post') . tep_draw_hidden_field('action', 'process_path'); ?> 
         <tr class="smallText">
           <td><table border="0" cellpadding="0" width="100%" style="border: thin outset;">
             <tr class="smallText">
               <td>
                 <div style="float:left; vertical-align:bottom; margin-top:3px;"><?php echo TEXT_REPORT_HACKING_ATTENPTS_LIMIT_IP . '&nbsp;'; ?></div>
                 <div style="float:left; padding-left:10px;"><?php echo tep_draw_input_field('current_ip', (($pathSelectedIP != TEXT_REPORT_PATH_TRACKER_PICK_IP) ? $pathSelectedIP : ''), 'maxlength="35" size="14"', false, '', false); ?></div>
               </td>
               <?php echo tep_draw_hidden_field('show_report', $showReport) .
                          tep_draw_hidden_field('sortbyarray', serialize($sortByArray)) .
                          tep_draw_hidden_field('sortby', $sortBy) .
                          tep_draw_hidden_field('last_selected_ip', $pathSelectedIP);
               ?>
             </tr>  
           </table></td>
         </tr>            
       </form>

       <tr class="smallText">
         <?php echo tep_draw_form('view_counter_hackers_ban', 'view_counter_reports.php', '', 'post') . tep_draw_hidden_field('action', 'process_hackers'); ?> 
           <td width="100%" ><table border="2" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;" class="smallText">
         
               <?php  
               $where = '';
               if ($pathSelectedIP != TEXT_REPORT_PATH_TRACKER_PICK_IP) { //do a full search
                   $where .= " and ip_number = INET_ATON('" . $pathSelectedIP . "') ";
               }  
               $db_query = tep_db_query("select inet_ntoa(ip_number) as ip, arg, isbot, last_date from view_counter where arg > '' and ip_active=1 " . $where . " order by last_date asc");
               
               while ($db = tep_db_fetch_array($db_query)) { 
                
                   foreach ($cmpArry as $test) {
                       if ( preg_match('/' . $test . '/', $db['arg'])) { 
                
                           $data .= '<tr>
                             <td class="smallText" width="10" align="center">' . $db['isbot'] . '</td>
                             <td class="smallText" width="150">' . $db['last_date'] . '</td>
                             <td class="smallText">' . $db['ip'] . '</td>
                             <td class="smallText">' . $db['arg'] . '</td>
                             <td><input type="submit" name="' . $db['ip'] . '" value="' . TEXT_BUTTON_BAN_IP . '" style="font-size:10px; height:14px; width:80px; border:1px solid #000; background:' . $colors[COLOR_BUTTONS] . '"></td>
                           </tr>';
                       } 
                   }   
               }
               
               if (! empty($data)) {
                   echo $data;
               }
               echo tep_draw_hidden_field('show_report', $showReport);
               ?>        
           </table><td>
         </form>
       </tr>
       
     </table></td>
   </tr>  
