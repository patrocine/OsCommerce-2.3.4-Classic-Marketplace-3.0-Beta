<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
//add product description to fetched fields
$listing_sql = str_replace('pd.products_name,', 'pd.products_name, pd.products_description, ', $listing_sql);
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
?>

<div class="contentText">
<?php
if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
    <div>
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>
      <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
    </div>
    <br />
<?php
  }

  $prod_list_contents = '<div class="ui-widget infoBoxContainer">';

  if ( !empty($column_list) ) {
  $prod_list_contents .='  <div class="ui-widget-header ui-corner-top infoBoxHeading">' .
                        '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="productListingHeader">' .
                        '      <tr>' .
                        '      <td><b>'.TEXT_SORT_PRODUCTS.' '.TEXT_BY.':</b>  ';

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    $lc_align = '';

    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
      $prod_list_contents .= '  '.$lc_text.'  ' ;
    }
  }

  $prod_list_contents .= '      </td>' .
                         '      </tr>' .
                         '    </table>' .
                         '  </div>';
  } // if ( !empty($column_list) ) {

  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);

    $prod_list_contents .= '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="productListingData">';

    $counter = 0;
    $col = 0;
    $width = floor(100 / $az_listing_columns);
    $num_products = tep_db_num_rows($listing_query);
    while ($listing = tep_db_fetch_array($listing_query)) {

        $counter++;
        if ($col === 0) {
            $prod_list_contents .= '<tr>';
        }

        if (tep_not_null($listing['specials_new_products_price'])) {
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>
                <span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
        } else {
            $products_price = $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
        }
        $products_price = az_change_format($products_price);

        #Include template layout for the product box
        #build variables map
        $product['id']				= $listing['products_id'];
        $product['name']			= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id']) . '">' . $listing['products_name'] . '</a>';
        $product['price']			= $products_price;
        $product['info_url']		= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id']);
        $product['image']			= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
        $product['desc']			= $listing['products_description'];
        $product['more_info_btn']	= tep_image_button('', AZ_BUTTON_MORE_INFO);
        $product['buy_now_url']		= tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']);
        $product['buy_now_btn']	    = tep_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART, '', '2', false);
        $product['review_stars']	= az_get_products_rating($listing['products_id']);

	    require(TMPL_DIR. 'templ_product_box.php');

        $prod_list_contents .= '<td width="'.$width.'%" align="center" valign="top">'.$az_product_html.'</td>';

        $col ++;
        if (($col >= $az_listing_columns) || ($counter == $num_products)) {
            while ( $col < $az_listing_columns ) {
                $prod_list_contents .= '<td width="'.$width.'%" align="center" valign="top"></td>';
                $col++;
            }

            $prod_list_contents .= '</tr>';
            $col = 0;
        }
    }

    $prod_list_contents .= '    </table>' .
                           '</div>';

    echo $prod_list_contents;
  } else {
?>
    <p><?php echo TEXT_NO_PRODUCTS; ?></p>
<?php
  }
  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>
    <br />
    <div>
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>
      <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
    </div>
<?php
  }
?>
</div>