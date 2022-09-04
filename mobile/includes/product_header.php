<?php 
echo tep_draw_form('cart_quantity', tep_mobile_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'));
  if (tep_not_null($product_info['products_model'])) {
    $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
  } else {
    $products_name = $product_info['products_name'];
  }
	if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
		$products_price = '<s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
	} else {
		$products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
	}

	$headerTitle->write($product_info['products_name']);
?>
<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.8.22.min.js"></script>

<link rel="stylesheet" type="text/css" href="ext/jquery/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" src="ext/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<?php echo $oscTemplate->getBlocks('header_tags'); ?>
	<div id="ficheProdTop">
<?php
    if (tep_not_null($product_info['products_image'])) {
      $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");

      if (tep_db_num_rows($pi_query) > 0) {
?>

    <div id="piGal" style="float: left;">
      <ul>

<?php
        $pi_counter = 0;
        while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;

          $pi_entry = '        <li><a href="';

          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '#piGalimg_' . $pi_counter;
          } else {
            $pi_entry .= tep_href_link(DIR_WS_IMAGES . $pi['image'], '', 'NONSSL', false);
          }

          $pi_entry .= '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $pi['image'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT) . '</a>';
          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '<div style="display: none;"><div id="piGalimg_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div></div>';
          }

          $pi_entry .= '</li>';

          echo $pi_entry;
        }
?>

      </ul>
    </div>
<?php
      } else {
?>

    <div id="piGal" style="float: left;">
      <?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image'], '', 'NONSSL', false) . '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), null, null, 'hspace="5" vspace="5"') . '</a>'; ?>
    </div>

<?php
      }
?>

<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>

<?php
    }
?>
</div>
<div id="ficheProdTop">
		<h2><?php echo $products_name; ?></h2>
		<div class="prodPrice"><?php echo $products_price; ?></div>
		<div class="options">
		<?php		
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
        $products_options_array = array();
        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
        while ($products_options = tep_db_fetch_array($products_options_query)) {
          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
          if ($products_options['options_values_price'] != '0') {
            $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
          }
        }

        if (is_string($HTTP_GET_VARS['products_id']) && isset($cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']])) {
          $selected_attribute = $cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']];
        } else {
          $selected_attribute = false;
        }
?>
<div class="options">
<strong><?php echo $products_options_name[''] . ''; ?></strong><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?>
</div>
<?php
      }
    }    
?>
</div>
<div class="bouton">
    <?php
 echo   tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_mobile_button(IMAGE_BUTTON_IN_CART). '<br></form>'; 	  
?>
</div>
</div>
</form>
