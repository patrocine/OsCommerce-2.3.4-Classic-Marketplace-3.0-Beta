<?php
/*
  Copyright (c) 2003 osCommerce
  Portions Copyright 2013 Jack York at http://www.oscommerce-solution.com 
*/  
?>
   
    <div id="dhtmltooltip"></div> <!-- for tooltip popup //--> 
    <script src="includes/javascript/view_counter/ddrivetip.js"></script> <!-- must follow the above //--> 
    <div id='dialog'></div>  <!-- for ajax popup //-->    
   
       <!-- BEGIN OF ViewCounter IP Count-->           
       <tr class="smallText">
         <td width="90%" ><table border="2" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;" class="smallText">

           <tr>
             <?php 
             echo tep_draw_form('ip_counts', 'view_counter_reports.php', '', 'post') . tep_hide_session_id() . tep_draw_hidden_field('action', 'process_ips'); 
             echo tep_draw_hidden_field('colsortSet', false) .
                  tep_draw_hidden_field('colsortType', '') .
                  tep_draw_hidden_field('show_report', $showReport) .
                  tep_draw_hidden_field('sortby', $sortBy);
             ?> 
             <td width="55" align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_COUNT; ?>','ip_counts')" style="background-color:<?php echo ($sortByArray['count'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_IP_COUNT_CNT . $sortDirection[TEXT_SORT_BY_COUNT]; ?></td>
             <td width="55" align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_ISBOT; ?>','ip_counts')" style="background-color:<?php echo ($sortByArray['isbot'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_IP_COUNT_ISBOT . $sortDirection[TEXT_SORT_BY_ISBOT]; ?></td>
             <td            align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_IP; ?>','ip_counts')" style="background-color:<?php echo ($sortByArray['ip'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_IP_COUNT_IP . $sortDirection[TEXT_SORT_BY_IP]; ?></td>
             </form> 
           </tr>
       
           <?php 
           $view_query = tep_db_query("select inet_ntoa(ip_number) as ip, count(view_count) as view_count, isbot from view_counter group by ip " . $sortBy );
     
           if (tep_db_num_rows($view_query) > 0) {
            
               require(DIR_FS_CATALOG . 'view_counter/IP2Location.php');

               $data = '';
               while ($view = tep_db_fetch_array($view_query)) {
                 
                   $domainInfo = GetDomainLocation($view['ip']);
                   $flag = (file_exists('images/view_counter/flags/' . strtolower($domainInfo['Country Code']) . '.png') ? '<img src="images/view_counter/flags/' . strtolower($domainInfo['Country Code']) . '.png" alt="' . $domainInfo['Country Name'] . '" title="' . $domainInfo['Country Name'] . '">' : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
 
                   $data .= '<tr  ' . ($view['isbot'] ? 'style="background-color:' . $colors[COLOR_IS_BOT] . '"' : '' ) . '>
                               <td>' . $view['view_count'] .'</td>
                               <td>' . $view['isbot']. '</td>
                               <td><span style="vertical-align:bottom;">' . $flag . '<a href="https://myip.ms/info/whois/' . $view['ip'] . '" onMouseover="ddrivetip(\'' . ShowIPDetails($domainInfo) . '\',\'' . $colors[COLOR_CART_POPUP_BACK] . '\',\'' . $showWidth . '\' )"; onMouseout="hideddrivetip()"' . ' target="_blank" >' . $view['ip'] . '</a></span></span></td>
                             </tr>';                   
               }                
               echo $data; 
           }
           ?>
           
         </table><td>
       </tr>