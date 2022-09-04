<?php
/*
  $Id products_next_previous.php 2010-12-23 00:33:00 hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if (!defined('PREVIOUS_NEXT_PRODUCT_LINK_TYPE')) {
    define('PREVIOUS_NEXT_PRODUCT_LINK_TYPE', 'Css');
    tep_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function) VALUES ('Previous/Next Product Link Type', 'PREVIOUS_NEXT_PRODUCT_LINK_TYPE', 'Css', 'Select the type of links you want to display', 8, 11, now(), 'tep_cfg_select_option(array(\'Css\', \'Image\', \'Text\'),')");
  }
  if (!defined('PREVIOUS_NEXT_PRODUCT_LINK_CATEGORY_DISPLAY')) {
    define('PREVIOUS_NEXT_PRODUCT_LINK_CATEGORY_DISPLAY', 'True');
    tep_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function) VALUES ('Previous/Next Product Link Category Display', 'PREVIOUS_NEXT_PRODUCT_LINK_CATEGORY_DISPLAY', 'True', 'Do you want to display the category/manufacturer link?', 8, 12, now(), 'tep_cfg_select_option(array(\'True\', \'False\'),')");
  }
  if (!defined('PREVIOUS_NEXT_PRODUCT_LINK_NAVIGATION')) {
    define('PREVIOUS_NEXT_PRODUCT_LINK_NAVIGATION', 'Bottom');
    tep_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function) VALUES ('Previous/Next Product Link Navigation', 'PREVIOUS_NEXT_PRODUCT_LINK_NAVIGATION', 'Bottom', 'Sets the location of the previous/next product links', 8, 13, now(), 'tep_cfg_select_option(array(\'Top\', \'Bottom\', \'Both\', \'None\'),')");
  }

// calculate the previous and next
  if (isset($_GET['manufacturers_id'])) { 
    $products_ids = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p where p.products_status = '1' and p.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
    $category_name_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
    $category_name_row = tep_db_fetch_array($category_name_query);
    $prev_next_in = PREV_NEXT_MB . ' <a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $category_name_row['manufacturers_id']) . '">' . $category_name_row['manufacturers_name'] . '</a>';
    $fPath = 'manufacturers_id=' . intval($_GET['manufacturers_id']);
  } else {
    if (!$current_category_id) {
      $cPath_query = tep_db_query ("select categories_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  (int)$_GET['products_id'] . "'");
      $cPath_row = tep_db_fetch_array($cPath_query);
      $current_category_id = $cPath_row['categories_id'];
    }
	$products_ids = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "'");
    $category_name_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$current_category_id . "' and language_id = '" . (int)$languages_id . "'");
    $category_name_row = tep_db_fetch_array($category_name_query);
    $prev_next_in = PREV_NEXT_CAT . ' <a href="' . tep_href_link(FILENAME_DEFAULT, tep_get_path($current_category_id = '')) . '">' . $category_name_row['categories_name'] . '</a>';
    $fPath = 'cPath=' . $cPath;
  }

// Check if there is at least 1 product
  $counter = 0;
  if($product_row = tep_db_fetch_array($products_ids)) {
    $position = 1;
    $counter = tep_db_num_rows($products_ids);
// Just in case there is no other product, previous and next will be the same as the current product
    $previous = $next_item = $product_row['products_id'];
// First row is the current product, so previous product will be the last one
    if($product_row['products_id'] == intval($_GET['products_id'])) {
// Set the next row
      if($product_row = tep_db_fetch_array($products_ids)) {
        $previous = $next_item = $product_row['products_id'];
        while ($product_row = tep_db_fetch_array($products_ids))
        $previous = $product_row['products_id'];
      }
    } else {// First row is not the current one
// Look for the current item
      while ($product_row = tep_db_fetch_array($products_ids)) {
        $position++;
// This is the current product, we now just need to look at the next one if exist
        if($product_row['products_id'] == intval($_GET['products_id'])) {
          if($product_row = tep_db_fetch_array($products_ids))
          $next_item = $product_row['products_id'];
        break;
        }
// Update previous id
        else
          $previous = $product_row['products_id'];
        }
    }
	
// Products Id of the first product in the category
    tep_db_data_seek($products_ids, 0);
	$product_row = tep_db_fetch_array($products_ids);
	$first = $product_row['products_id'];
	
// Products Id of the last product in the category
    tep_db_data_seek($products_ids, $counter-1);
	$product_row = tep_db_fetch_array($products_ids);
	$last = $product_row['products_id'];
  }

  $firstDisplay = '';
  $prevDisplay = '';
  $nextDisplay = '';
  $lastDisplay = '';
  $prevnextProductLinkDisplay = '';
  $prevnexProductsID = intval($_GET['products_id']);

  if (PREVIOUS_NEXT_PRODUCT_LINK_TYPE == 'Text') {
    $prevDisplay = (($first != $prevnexProductsID) ? '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $previous) . '">' . ALT_PREVIOUS_PRODUCT . '</a>' : tep_draw_separator('pixel_trans.gif', '50%'));
    $nextDisplay = (($last != $prevnexProductsID) ? '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $next_item) . '">' . ALT_NEXT_PRODUCT . '</a>' : tep_draw_separator('pixel_trans.gif', '50%'));
    $firstDisplay = (($first != $prevnexProductsID) ? '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $first) . '">' . ALT_FIRST_PRODUCT . '</a>' . ' | ' : tep_draw_separator('pixel_trans.gif', '50%'));
    $lastDisplay = (($last != $prevnexProductsID) ? ' | ' . '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $last) . '">' . ALT_LAST_PRODUCT . '</a>' : tep_draw_separator('pixel_trans.gif', '50%'));
  } elseif (PREVIOUS_NEXT_PRODUCT_LINK_TYPE == 'Image') {
    $prevDisplay = (($first != $prevnexProductsID) ? '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $previous) . '">' . tep_image_button('button_prev.png', ALT_PREVIOUS_PRODUCT) . '</a>' : tep_draw_separator('pixel_trans.gif', '50%'));
    $nextDisplay = (($last != $prevnexProductsID) ? '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $next_item) . '">' . tep_image_button('button_next.png', ALT_NEXT_PRODUCT) . '</a>' : tep_draw_separator('pixel_trans.gif', '50%'));
    $firstDisplay = (($first != $prevnexProductsID) ? '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $first) . '">' . tep_image_button('button_first.png', ALT_PREVIOUS_PRODUCT) . '</a>' . ' ' : tep_draw_separator('pixel_trans.gif', '50%'));
    $lastDisplay = (($last != $prevnexProductsID) ? ' ' . '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $last) . '">' . tep_image_button('button_last.png', ALT_NEXT_PRODUCT) . '</a>' : tep_draw_separator('pixel_trans.gif', '50%'));
  } else {
    $prevDisplay = (($first != $prevnexProductsID) ? tep_draw_button(ALT_PREVIOUS_PRODUCT, 'seek-prev', tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $previous), 'highlight') : tep_draw_separator('pixel_trans.gif', '50%'));
    $nextDisplay = (($last != $prevnexProductsID) ? tep_draw_button(ALT_NEXT_PRODUCT, 'seek-next', tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $next_item), 'highlight') : tep_draw_separator('pixel_trans.gif', '50%'));
    $firstDisplay = (($first != $prevnexProductsID) ? tep_draw_button(ALT_FIRST_PRODUCT, 'seek-first', tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $first), 'highlight') . ' ' : tep_draw_separator('pixel_trans.gif', '50%'));
    $lastDisplay = (($last != $prevnexProductsID) ? ' ' . tep_draw_button(ALT_LAST_PRODUCT, 'seek-end', tep_href_link(FILENAME_PRODUCT_INFO, $fPath . '&products_id=' . $last), 'highlight') : tep_draw_separator('pixel_trans.gif', '50%'));
  }
?>
<?php
  if ($counter > 1) {
    $prevnextProductLinkDisplay .= '<!-- previous_next -->' . "\n" .
                                   '<div class="contentText" style="padding: 25px 0px;">' . "\n" .
                                   '  <table border="0" width="100%" cellspacing="0" cellpadding="2">' . "\n" .
                                   '    <tr>' . "\n" .
                                   '      <td width="33%" align="right">' . $firstDisplay . $prevDisplay . '</td>' . "\n" .
                                   '      <td width="33%" align="center">' . PREV_NEXT_PRODUCT . $position . PREV_NEXT_OF . $counter . '</td>' . "\n" .
                                   '      <td width="33%" align="left">' . $nextDisplay . $lastDisplay . '</td>' . "\n" .
                                   '    </tr>' . "\n";

    if (PREVIOUS_NEXT_PRODUCT_LINK_CATEGORY_DISPLAY == 'True') {
      $prevnextProductLinkDisplay .= '    <tr>' . "\n" .
                                     '      <td align="center" colspan="3">' . $prev_next_in . '</td>' . "\n" .
                                     '    </tr>' . "\n";
    }

    $prevnextProductLinkDisplay .= '  </table>' . "\n" .
                                   '</div>' . "\n" .
                                   '<!-- previous_next_eof -->' . "\n";
  }
?>