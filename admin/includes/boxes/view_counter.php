<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/

                           
if (strpos(PROJECT_VERSION, 'v2.3') !== FALSE) {

  $vc_menu = array(
    array('code' => 'view_counter.php',
          'title' => MODULES_ADMIN_MENU_VIEW_COUNTER_MONITOR,
          'link' => tep_href_link('view_counter.php')
         ),
    array(
      'code' => 'view_counter_color.php',
      'title' => MODULES_ADMIN_MENU_VIEW_COUNTER_COLOR,
      'link' => tep_href_link('view_counter_color.php')
    ),
    array(
      'code' => 'view_counter_reports.php',
      'title' => MODULES_ADMIN_MENU_VIEW_COUNTER_REPORTS,
      'link' => tep_href_link('view_counter_reports.php')
    ),
    array(
      'code' => 'view_counter_tools.php',
      'title' => MODULES_ADMIN_MENU_VIEW_COUNTER_TOOLS,
      'link' => tep_href_link('view_counter_tools.php')
    )         
  );
  $cl_box_groups[] = array('heading' => MODULES_ADMIN_MENU_VIEW_COUNTER_HEADING,
                           'apps' => $vc_menu);
 

} else {
?>
<!-- view_counter_bof //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_VIEW_COUNTER,
                     'link'  => tep_href_link('view_counter.php', 'selected_box=view_counter'));

  if ($selected_box == 'view_counter') {
    $contents[] = array('text'  => '<a href="' . tep_href_link('view_counter.php') . '" class="menuBoxContentLink">' . BOX_VIEW_COUNTER_MONITOR . '</a><br>' .
                                   '<a href="' . tep_href_link('view_counter_color.php') . '" class="menuBoxContentLink">' . BOX_VIEW_COUNTER_COLOR . '</a><br>' .
                                   '<a href="' . tep_href_link('view_counter_reports.php') . '" class="menuBoxContentLink">' . BOX_VIEW_COUNTER_REPORTS . '</a><br>' .
                                   '<a href="' . tep_href_link('view_counter_tools.php') . '" class="menuBoxContentLink">' . BOX_VIEW_COUNTER_TOOLS . '</a> ');
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- view_counter_eof //-->
<?php } ?>