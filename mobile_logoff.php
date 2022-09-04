<?php
require_once('mobile/includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_LOGOFF));

  $breadcrumb->add(NAVBAR_TITLE);

  tep_session_unregister('customer_id');
  tep_session_unregister('customer_default_address_id');
  tep_session_unregister('customer_first_name');
  tep_session_unregister('customer_country_id');
  tep_session_unregister('customer_zone_id');
  tep_session_unregister('comments');
  //kgt - discount coupons
  tep_session_unregister('coupon');
  //end kgt - discount coupons
  $cart->reset();
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<div id="iphone_content">
<div id="cms">
<?php echo TEXT_MAIN; ?>
<div id="bouton"><?php echo tep_draw_form('cart_quantity', tep_mobile_link(FILENAME_DEFAULT)) . tep_mobile_button(IMAGE_BUTTON_CONTINUE) . '</form>'; ?></div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
