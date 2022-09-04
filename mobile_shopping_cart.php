<?php
require_once('mobile/includes/application_top.php');

  if ($cart->count_contents() > 0) {
    include(DIR_WS_CLASSES . 'payment.php');
    $payment_modules = new payment;
  }

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_SHOPPING_CART));
  $breadcrumb->add(NAVBAR_TITLE, tep_mobile_link(FILENAME_SHOPPING_CART));
    
  require(DIR_MOBILE_INCLUDES . 'header.php');
  $headerTitle->write();
  
  echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product'));
?>
<div id="iphone_content">
<?php
  if ($cart->count_contents() > 0) {
?>
<?php
    $info_box_contents = array();

    $info_box_contents[0][] = array('params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_PRODUCTS);

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_QUANTITY);

    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_TOTAL);

    $any_out_of_stock = 0;
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                       and pa.options_id = '" . (int)$option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . (int)$languages_id . "'
                                       and poval.language_id = '" . (int)$languages_id . "'");
          $attributes_values = tep_db_fetch_array($attributes);

          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $info_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($info_box_contents) - 1;

      $products_name = '<table border="0" cellspacing="0" cellpadding="0">' .
                       '  <tr>' .
                       '    <td class="productListing-data" align="center" rowspan="10"><a href="' . tep_mobile_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH/2, SMALL_IMAGE_HEIGHT/2) . '</a></td>' .
                       '  </tr>' .
                       '  <tr>' .
                         '    <td class="productListing-data" valign="top"><a href="' . tep_mobile_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a>';

      if (STOCK_CHECK == 'true') {
        $stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
        if (tep_not_null($stock_check)) {
          $any_out_of_stock = 1;

          $products_name .= $stock_check;
        }
      }

      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        reset($products[$i]['attributes']);
        while (list($option, $value) = each($products[$i]['attributes'])) {
          $products_name .= '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
        }
      }

      $products_name .= '    </td>' .
                        '  </tr>' .
                        '</table>';

      $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                                             'text' => $products_name);

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="2" text-align="right"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']) . '<br><span style="position:relative; top:8px;">' . tep_mobile_button(IMAGE_BUTTON_UPDATE) . '</form>');

      $info_box_contents[$cur_row][] = array('align' => 'right',
					     'params' => 'class="productListing-data" valign="top"',
					     'text' => '<b>' . $currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b><br><br>' .
					     '<a href="' .tep_mobile_link(FILENAME_SHOPPING_CART, 'products_id=' . $products[$i]['id'] . '&action=remove_product') . '"><input type="button" value="' . IMAGE_BUTTON_REMOVE . '"></a>');
    }

	if ($any_out_of_stock == 1) {
		?><span class="messageStackWarning"><?php
		if (STOCK_ALLOW_CHECKOUT == 'true') {
			echo OUT_OF_STOCK_CAN_CHECKOUT;
		} else {
			echo OUT_OF_STOCK_CANT_CHECKOUT; 
		}
		?></span><?php
	}
?>
<div id="cms">
<?php	
	new productListingBox($info_box_contents);
    echo '<br><div style="padding-right:4px; float:right;"><strong>' . SUB_TITLE_TOTAL . $currencies->format($cart->show_total()) . '</strong></div><br><br>';
?>
</div>
<div id="checkout_payment">
<div id="bouton" style="text-align:left;">
	<?php echo tep_draw_form('continue', tep_mobile_link(FILENAME_CATALOG, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_CONTINUE_SHOPPING, 'name="continue shopping"') . '</form>' . 
	 	   '<span style="float:right;">' . tep_draw_form('cart_quantity', tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_CHECKOUT, 'name="checkout"') . '</form></span>'; ?>
	</div>			
	</div>			
<?php
    //$initialize_checkout_methods = $payment_modules->checkout_initialization_method();

    if (!empty($initialize_checkout_methods)) {
?>
        <div style="padding-right: 50px;"><?php echo TEXT_ALTERNATIVE_CHECKOUT_METHODS; ?></div>
<?php
      reset($initialize_checkout_methods);
      while (list(, $value) = each($initialize_checkout_methods)) {
?>
<div>
<?php echo $value; ?>
</div><?php
      }
    }
  } else {
?>
        <div id="checkout_payment" style="text-align:center;">
        <?php echo TEXT_CART_EMPTY; ?>
        <div id="bouton">
        </form><?php echo tep_draw_form('continue_shopping', tep_mobile_link(FILENAME_CATALOG, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_CONTINUE_SHOPPING, 'name="continue shopping"') . '</form>'; ?>
        </div></div><?php
  }
require(DIR_MOBILE_INCLUDES . 'footer.php');
?>