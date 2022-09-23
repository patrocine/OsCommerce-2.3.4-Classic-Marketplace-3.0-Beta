<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query(
        "select
            p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, pd.products_description,
            p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd
        where
            p.products_status = '1'
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
        order by
            p.products_date_added desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query(
        "select
            distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, pd.products_description,
            p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c
        where
            p.products_id = p2c.products_id
            and p2c.categories_id = c.categories_id
            and c.parent_id = '" . (int)$new_products_category_id . "'
            and p.products_status = '1'
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
        order by
            p.products_date_added desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);

  if ($new_products_query > 0) {
    $counter = 0;
    $col = 0;

    $new_prods_content = '<table border="0" width="100%" cellspacing="0" cellpadding="2">';
    while ($new_products = tep_db_fetch_array($new_products_query)) {
        $counter++;

        if ($col === 0) {
            $new_prods_content .= '<tr>';
        }

        if (tep_not_null($new_products['specials_new_products_price'])) {
            $products_price = '<s>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s>
                <span class="productSpecialPrice">' . $currencies->display_price($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>';
        } else {
            $products_price = $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id']));
        }
        $products_price = az_change_format($products_price);

        #Include template layout for the product box
        #build variables map
        $product['id']				= $new_products['products_id'];
        $product['name']			= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a>';
        $product['price']			= $products_price;
        $product['info_url']		= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']);
        $product['image']			= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
        $product['desc']			= $new_products['products_description'];
        $product['more_info_btn']	= tep_image_button('', AZ_BUTTON_MORE_INFO);
        $product['buy_now_url']		= tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $new_products['products_id']);
        $product['buy_now_btn']	    = tep_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART, '', '2', false);
        $product['review_stars']	= az_get_products_rating($new_products['products_id']);

	    require(TMPL_DIR. 'templ_product_box.php');
		
		$width = floor(100 / $az_listing_columns);

        $new_prods_content .= '<td width="'.$width.'%" align="center" valign="top">'.$az_product_html.'</td>';

        $col ++;

        if (($col >= $az_listing_columns) || ($counter == $num_new_products)) {
            $new_prods_content .= '</tr>';

            $col = 0;
        }
    }

    $new_prods_content .= '</table>';
?>

  <h2><?php echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?></h2>

  <div class="contentText">
    <?php echo $new_prods_content; ?>
  </div>

<?php
  }
?>
