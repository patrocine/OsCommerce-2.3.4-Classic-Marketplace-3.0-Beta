<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);
  
  if (empty($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];  
  $goto = basename($PHP_SELF);
  $parameters = array('action');
  
  if ( isset($_GET['action']) && $_GET['action'] == 'add_product_qty' ) {
	 
	 if (isset($_POST['products_id']) && is_numeric($_POST['products_id'])) {
	      $qty = (is_numeric($_POST['qty']) && $_POST['qty']>0 ) ? $_POST['qty'] : 1;
		  $attributes = isset($_POST['id']) ? $_POST['id'] : '';
	      $cart->add_cart($_POST['products_id'], $cart->get_quantity(tep_get_uprid($_POST['products_id'], $attributes))+$qty, $attributes);
	  }
							  
	  tep_redirect(str_replace('&amp;', '&', tep_href_link($goto, tep_get_all_get_params($parameters).'action=product_added')));
	  
  }
  
  require(DIR_WS_INCLUDES . 'template_top.php');
  
  if ( isset($_GET['action']) && $_GET['action'] == 'product_added') {
    $messageStack->add('product', AZ_PRODUCT_ADDED, 'success');
  }
  
  $azCat_breadcrumb = new breadcrumb;
  if (isset($cPath_array)) {
    for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
      $categories_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$cPath_array[$i] . "' and language_id = '" . (int)$languages_id . "'");
      if (tep_db_num_rows($categories_query) > 0) {
        $categories = tep_db_fetch_array($categories_query);
		if(($i+1) == $n){
		  $azCat_breadcrumb->add('<span class="headerNavigationEnd">'.$categories['categories_name'].'</span>', tep_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
		}else{
          $azCat_breadcrumb->add($categories['categories_name'], tep_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
		}
      } else {
        break;
      }
    }
  }

  if ($product_check['total'] < 1) {
?>

<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_PRODUCT_NOT_FOUND; ?>
  </div>

  <div style="float: right;">
    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?>
  </div>
</div>

<?php
  } else {
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      $products_price = '<del>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
    } else {
      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    }
	
	$products_price = '<span class="az_productPrice2">'.str_replace($az_curSymbol, $az_newSymbol, $products_price).'</span>';

    if (tep_not_null($product_info['products_model'])) {
      //$products_name = $product_info['products_name'] . '<br /><span class="smallText">[' . $product_info['products_model'] . ']</span>';
	  $products_name = $product_info['products_name'];
    } else {
      $products_name = $product_info['products_name'];
    }
	
	$nav_cid = isset($_REQUEST['az_nav_cid']) ? $_REQUEST['az_nav_cid'] : $cPath_array[count($cPath_array)-1];
	
	$pc_query = tep_db_query("select p2c.categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p2c.products_id = '" . (int)$product_info['products_id'] . "' and p2c.categories_id = '" . $nav_cid . "' limit 1");
    $pc = tep_db_fetch_array($pc_query);
	
	$q = tep_db_query("select 
		distinct p.products_id, pd.products_name
	from 
		" . TABLE_PRODUCTS . " p 
		left join " . TABLE_PRODUCTS_DESCRIPTION . " pd using (products_id) 
		left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c using (products_id) 
	where 
		p.products_status = '1' 
		and pd.language_id = '" . (int)$languages_id . "' 
		and p2c.categories_id = '" . $pc['categories_id'] . "'
		and p.products_id = p2c.products_id
	order by pd.products_name");
	$cats = array();
	while (	$p = tep_db_fetch_array($q) ) {
		$cats[] = $p['products_id'];
	}
	$product_key = array_search($product_info['products_id'], $cats);
	$product_back = !empty( $cats[ $product_key-1 ] ) ? '<a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $cats[ $product_key-1 ] . '&amp;az_nav_cid=' . $nav_cid) .'">'.tep_image_button('', AZ_PRODUCT_BACK, '', 4) .'</a>' : '';
	$product_next = !empty( $cats[ $product_key+1 ] ) ? '<a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $cats[ $product_key+1 ] . '&amp;az_nav_cid=' . $nav_cid) .'">'.tep_image_button('', AZ_PRODUCT_NEXT, '', 4) .'</a>'  : '';
?>

<?php //echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>
<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product_qty')); ?>

<div class="prod_info_left_block">
  <div class="az_category_navigation"><?php echo $azCat_breadcrumb->trail(' : '); ?></div>
  
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
            $pi_entry .= tep_href_link(DIR_WS_IMAGES . $pi['image']);
          }

          $pi_entry .= '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $pi['image']) . '</a>';

          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '<div style="display: none;"><div id="piGalimg_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div></div>';
          }

          $pi_entry .= '</li>';

          echo $pi_entry;
        }
?>

      </ul>
    </div>

<script type="text/javascript">
$('#piGal ul').bxGallery({
  maxwidth: 300,
  maxheight: 200,
  thumbwidth: <?php echo (($pi_counter > 1) ? '75' : '0'); ?>,
  thumbcontainer: 300,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>

<?php
      } else {
?>

    <div id="piGal" style="float: left;">
      <?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), null, null, 'hspace="5" vspace="5"') . '</a>'; ?>
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

<div class="prod_info_right_block">
  <?php if ($messageStack->size('product') > 0) { ?>
    <?php echo $messageStack->output('product'); ?>
  <? } ?>
  <?php if($product_back || $product_next) { ?>
    <div class="az_product_nav">
      <span class="az_product_nav-back"><?php echo $product_back ? $product_back : '&nbsp;'; ?></span>&nbsp;
      <span class="az_product_nav-next"><?php echo $product_next ? $product_next : '&nbsp;'; ?></span>
    </div>
  <?php } ?>
  
  <div class="az_pageHeading"><?php echo $products_name; ?></div>
  
<?php /*?><div>
  <h1 style="float: right;"><?php echo $products_price; ?></h1>
  <h1 class="az_pageHeading"><?php echo $products_name; ?></h1>
</div><?php */?>

<div class="contentContainer">
  <div class="contentText">

<div class="az_product_info_text"><?php echo stripslashes($product_info['products_description']); ?></div>

<div class="az_product_info_text_pane2">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
		    <td class="az_option_heading" width="30%"><?php echo AZ_DETAILS_TEXT;?></td>
		    <td class="az_option_heading" width="10%" align="center"><?php echo AZ_QUANTITY_TEXT; ?></td>
		    <td class="az_option_heading" width="60%" align="center"><?php echo AZ_PRODUCT_OPTION_TEXT; ?></td>
		  </tr>
		  <tr><td style="padding-top:10px;"></td></tr>
          <tr>
            <td valign="top">
			  <div class="az_product_info_text">
			  <?php echo AZ_MODEL_TEXT . ' ' . $product_info['products_model'];?>
			  <?php echo '<br />' . AZ_PRICE_TEXT . ' ' . $products_price; ?>
			  </div>
			</td>
		    <td align="center" valign="top">
			  <div class="az_qty_btn_l"><div class="az_qty_btn_r"><div class="az_qty_btn_m">
			  <?php echo tep_draw_input_field('qty', '1', 'size="4" maxlength="4"');?>
			  </div></div></div>
			</td>
		    <td valign="top">
<?php
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
?>

    <?php /*?><p><?php echo TEXT_PRODUCT_OPTIONS; ?></p><?php */?>

    <table border="0" cellspacing="0" cellpadding="2" align="center">
<?php
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
      <?php /*?><strong><?php echo $products_options_name['products_options_name'] . ':'; ?></strong><br /><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?><br /><?php */?>      
      <tr>
        <td class="az_product_info_text"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
        <td class="az_product_info_text"><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?></td>
      </tr>
<?php
      }
?>
    </table>

<?php
    }
?>
            </td>
          </tr>
        </table>
    <div style="clear: both;"></div>

<?php
    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
?>

    <p style="text-align: center;"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></p>

<?php
    }
?>

  </div>

<?php
    $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and reviews_status = 1");
    $reviews = tep_db_fetch_array($reviews_query);
?>

  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', null, 'primary', null, '1'); ?></span>    

    <?php echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews['count'] > 0) ? ' (' . $reviews['count'] . ')' : ''), 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()), null, null, '2'); ?>
  </div>
</div>

<?php
    if ((USE_CACHE == 'true') && empty($SID)) {
      echo tep_cache_also_purchased(3600);
    } else {
      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
    }
?>

</div>

</div>

</form>

<?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
