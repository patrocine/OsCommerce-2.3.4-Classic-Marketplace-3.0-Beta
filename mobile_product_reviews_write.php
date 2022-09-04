<?php
require_once('mobile/includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
        $navigation->set_snapshot();
        tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

  if (!isset($HTTP_GET_VARS['products_id'])) {
  	  tep_redirect(tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS, tep_get_all_get_params(array('action'))));
  }

  $product_info_query = tep_db_query("select p.products_id, p.products_model, p.products_image, p.products_price, p.products_tax_class_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
  if (!tep_db_num_rows($product_info_query)) {
      tep_redirect(tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS, tep_get_all_get_params(array('action', 'module'))));
  } else {
    $product_info = tep_db_fetch_array($product_info_query);
  }

  $customer_query = tep_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
  $customer = tep_db_fetch_array($customer_query);

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
    $rating = tep_db_prepare_input($HTTP_POST_VARS['rating']);
    $review = tep_db_prepare_input($HTTP_POST_VARS['review']);

    $error = false;
    if (strlen($review) < REVIEW_TEXT_MIN_LENGTH) {
      $error = true;

      $messageStack->add('review', JS_REVIEW_TEXT);
    }

    if (($rating < 1) || ($rating > 5)) {
      $error = true;

      $messageStack->add('review', JS_REVIEW_RATING);
    }

    if ($error == false) {
      tep_db_query("insert into " . TABLE_REVIEWS . " (products_id, customers_id, customers_name, reviews_rating, date_added) values ('" . (int)$HTTP_GET_VARS['products_id'] . "', '" . (int)$customer_id . "', '" . tep_db_input($customer['customers_firstname']) . ' ' . tep_db_input($customer['customers_lastname']) . "', '" . tep_db_input($rating) . "', now())");
      $insert_id = tep_db_insert_id();

      tep_db_query("insert into " . TABLE_REVIEWS_DESCRIPTION . " (reviews_id, languages_id, reviews_text) values ('" . (int)$insert_id . "', '" . (int)$languages_id . "', '" . tep_db_input($review) . "')");

      $messageStack->add_session('product_reviews', TEXT_REVIEW_RECEIVED, 'success');
      tep_redirect(tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS, tep_get_all_get_params(array('action', 'module'))));
    }
  }

  if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
    $products_price = '<s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
  } else {
    $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
  }

  if (tep_not_null($product_info['products_model'])) {
    $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
  } else {
    $products_name = $product_info['products_name'];
  }

	require(DIR_MOBILE_INCLUDES . 'header.php');
    require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_PRODUCT_REVIEWS_WRITE));

  $breadcrumb->add(NAVBAR_TITLE, tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS, tep_get_all_get_params()));
  
  require(DIR_MOBILE_INCLUDES. "product_header.php");
?>

  <div id="ficheProdMid">
    <table>
      <tr>
       <td class="main"><?php echo tep_draw_form('back', tep_mobile_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id', 'action')))) . tep_mobile_button(IMAGE_BUTTON_BACK) . "</form>"; ?>
      </tr>
    </table>
<?php echo tep_draw_form('product_reviews_write', tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS_WRITE, 'action=process&products_id=' . $HTTP_GET_VARS['products_id']), 'post', 'onSubmit="return checkForm();"'); ?>
<?php
  if ($messageStack->size('review') > 0) {
?>
    <table>
      <tr>
        <td><?php echo $messageStack->output('review'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
    </table>
<?php
  }
?>
    <table border="0">
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '2'); ?></td>
      </tr>
        <tr>
        	<td class="main"><b><?php echo SUB_TITLE_FROM; ?></b></td>
        	<td class="main"><?php echo tep_output_string_protected($customer['customers_firstname'] . ' ' . $customer['customers_lastname']); ?></td>
        </tr>
		<tr>
        	<td class="main"><b><?php echo SUB_TITLE_RATING ; ?></b></td>
        	<td class="main"><?php echo TEXT_BAD . ' ' . tep_draw_radio_field('rating', '1') . ' ' . tep_draw_radio_field('rating', '2') . ' ' . tep_draw_radio_field('rating', '3') . ' ' . tep_draw_radio_field('rating', '4') . ' ' . tep_draw_radio_field('rating', '5') . ' ' . TEXT_GOOD; ?></td>
		</tr>
      <tr>
		<td class="main" colspan="2"><b><?php echo SUB_TITLE_REVIEW; ?></b></td>
	  </tr>
	  <tr class="infoBoxContents">
		<td class="main" colspan="2"><?php echo tep_draw_textarea_field('review', 'soft', 30, 5); ?></td>
	  </tr>
	  <tr>
      	<td class="smallText"  colspan="2"><?php echo TEXT_NO_HTML; ?></td>
      </tr>
      <tr>
	<td class="main" colspan="2"><?php echo tep_mobile_button(IMAGE_BUTTON_CONTINUE) . "</form>"; ?></td>
      </tr>
    </table>
  </div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
