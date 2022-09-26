<?php
/*
  Copyright (c) 2003 osCommerce
  Portions Copyright 2013 Jack York at http://www.oscommerce-solution.com 
*/  
?>
   <tr>
     <td><table border="1" cellpadding="0" width="100%" class="BorderedBoxLight">
        
       <!-- BEGIN OF ViewCounter -->
       <?php echo tep_draw_form('view_counter_parts', 'view_counter_reports.php', '', 'post') . tep_draw_hidden_field('action', 'process'); ?> 
         <tr class="smallText">
           <td colspan="4"><table border="0" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;">
             <tr>
               <td><table border="0" cellpadding="0" width="60%">
                 <td class="main" width="130"><?php echo TEXT_REPORT_SHOW_ARG; ?></td>
                 <td class="main" width="60"><INPUT TYPE="radio" NAME="show_arg" VALUE="<?php echo TEXT_REPORT_SHOW_ARG_NO; ?>" <?php echo $showArg['no']; ?> onChange="this.form.submit();"> <?php echo TEXT_REPORT_SHOW_ARG_NO; ?>&nbsp;</td>
                 <td class="main" width="60"><INPUT TYPE="radio" NAME="show_arg" VALUE="<?php echo TEXT_REPORT_SHOW_ARG_YES; ?>" <?php echo $showArg['yes']; ?> onChange="this.form.submit();"> <?php echo TEXT_REPORT_SHOW_ARG_YES; ?>&nbsp;</td>
                 
                 <td>
                   <div class="main" style="float:left;">
                     <div style="float:left; padding-left:20px;"><?php echo TEXT_REPORT_SHOW_BOTS; ?>&nbsp;</div>
                     <div style="float:left; padding-left:4px; vertical-align: middle; margin-top:2px; "><INPUT TYPE="checkbox" NAME="show_bots" <?php echo $showBots; ?> onChange="this.form.submit();"></div>
                   </div>  
                 </td>
                 
                 <?php echo tep_draw_hidden_field('show_report', $showReport) .
                            tep_draw_hidden_field('showarg', urlencode(serialize($showArg))) .
                            tep_draw_hidden_field('sortbyarray', urlencode(serialize($sortByArray))) .
                            tep_draw_hidden_field('sortby', $sortBy);
                 ?>
               </table></td>
             </tr>  
           </table></td>
         </tr>            
       </form>

       <tr class="smallText">
         <td width="100%" ><table border="2" cellpadding="0" width="100%" style="border-width: thin; border-style: outset;" class="smallText">
       
           <tr>
             <?php 
             echo tep_draw_form('page_counts', 'view_counter_reports.php', '', 'post') . tep_hide_session_id() . tep_draw_hidden_field('action', 'process_ips'); 
             echo tep_draw_hidden_field('colsortSet', false) .
                  tep_draw_hidden_field('colsortType', '') .
                  tep_draw_hidden_field('page', $pageNumb) .
                  tep_draw_hidden_field('show_report', $showReport) .
                  tep_draw_hidden_field('showarg', urlencode(serialize($showArg))) .
                  tep_draw_hidden_field('sortbyarray', urlencode(serialize($sortByArray))) .
                  tep_draw_hidden_field('sortby', $sortBy);                
             ?> 
             <td width="10" align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_PAGE_COUNT; ?>','page_counts')" style="background-color:<?php echo ($sortByArray['count'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_PAGE_COUNT_CNT . $sortDirection[TEXT_SORT_BY_COUNT]; ?></td>
             <td width="6" align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_PAGE_ISBOT; ?>','page_counts')" style="background-color:<?php echo ($sortByArray['isbot'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_PAGE_COUNT_ISBOT . $sortDirection[TEXT_SORT_BY_ISBOT]; ?></td>
             <td width="55" align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_PAGE_FILENAME; ?>','page_counts')" style="background-color:<?php echo ($sortByArray['filename'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_PAGE_COUNT_FILENAME . $sortDirection[TEXT_SORT_BY_FILENAME]; ?></td>
             <?php if ($showArg['yes'] == ' checked ') { ?>
             <td width="55" align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_PAGE_ARG; ?>','page_counts')" style="background-color:<?php echo ($sortByArray['args'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_PAGE_COUNT_ARGS . $sortDirection[TEXT_SORT_BY_ARG]; ?></td>
             <td            align="center" onClick="SortColumn('<?php echo TEXT_SORT_BY_PAGE_IP; ?>','page_counts')" style="background-color:<?php echo ($sortByArray['ip'] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : ''); ?>"><?php echo TEXT_REPORT_PAGE_COUNT_IP . $sortDirection[TEXT_SORT_BY_IP]; ?></td>
             <?php } ?>
           </tr>
           
           <tr>
           <?php 
             $isBot = (tep_not_null($showBots) ? '' : ' where isbot = 0 ' );
             $groupBy = ($showArg['yes'] == ' checked ' ? ' group by file_name, arg ' : ' group by file_name ');
             $sortByTmp = (strpos($sortBy, 'view_count') !== FALSE ? str_replace('view_count', 'cnt', $sortBy) : $sortBy);
             
             $view_query_numrows = 0;
             $view_query_raw = "select count(file_name) as cnt, isbot, file_name, arg, inet_ntoa(ip_number) as ip from view_counter " . $isBot . $groupBy . $sortByTmp;       
             $view_split = new splitPageResults($pageNumb, VIEW_COUNTER_MAX_ROWS, $view_query_raw, $view_query_numrows);   
             $view_query = tep_db_query($view_query_raw);
  
             $data = '';
             while ($view_page = tep_db_fetch_array($view_query)) {
                 $data .= '<tr  ' . ($view_page['isbot'] ? 'style="background-color:' . $colors[COLOR_IS_BOT] . '"' : '' ) . '>
                 <td class="smallText" width="10">' . $view_page['cnt'] . '</td>
                 <td class="smallText" width="6" align="center">' . $view_page['isbot']  . '</td>
                 <td class="smallText" width="50">' . $view_page['file_name']  . '</td>' .
                  ($showArg['yes'] == ' checked ' ? '<td class="smallText" width="100">' . (tep_not_null($view_page['arg']) ? $view_page['arg'] : '&nbsp;')  . '</td>' . 
                                                    '<td class="smallText" width="100">' . $view_page['ip']  . '</td>' : '');
                 $data .= '</tr>';
             }
             echo $data;             
             
           // $sortBy = rawurlencode($sortBy);
           $sortBy = str_replace(' ','gg',$sortBy); //should use rawurlencode here but something in the variable triggers osc_sec so use this to mask it
    
           $showarg = urlencode(serialize($showArg)); 
           $sortbyarray = urlencode(serialize($sortByArray));
           ?>
           </tr>
           <tr>       
             <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr>
                 <td class="smallText" valign="top"><?php echo $view_split->display_count($view_query_numrows, VIEW_COUNTER_MAX_ROWS, $pageNumb, TEXT_DISPLAY_NUMBER_OF_LINKS); ?></td>
                 <td class="smallText" align="right"><?php 
                   echo $view_split->display_links($view_query_numrows, VIEW_COUNTER_MAX_ROWS, VIEW_COUNTER_MAX_ROWS, $pageNumb, '&show_report=Page Counts&action=choose_report&report_types=Page Counts&showarg='.$showarg.'&sortby='.$sortBy.'&sortbyarray='.$sortbyarray); 
                 ?></td>
               </tr>
             </table></td>  
           <tr>     
             
         </table><td>
       </tr>
       
     </table></td>
   </tr>  
