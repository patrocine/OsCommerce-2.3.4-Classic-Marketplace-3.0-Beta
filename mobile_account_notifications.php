<?php
require_once('mobile/includes/application_top.php');
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

// needs to be included earlier to set the success message in the messageStack
  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_ACCOUNT_NOTIFICATIONS));

  $global_query = tep_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "'");
  $global = tep_db_fetch_array($global_query);

  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process')) {
    if (isset($HTTP_POST_VARS['product_global']) && is_numeric($HTTP_POST_VARS['product_global'])) {
      $product_global = tep_db_prepare_input($HTTP_POST_VARS['product_global']);
    } else {
      $product_global = '0';
    }

    (array)$products = $HTTP_POST_VARS['products'];

    if ($product_global != $global['global_product_notifications']) {
      $product_global = (($global['global_product_notifications'] == '1') ? '0' : '1');

      tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set global_product_notifications = '" . (int)$product_global . "' where customers_info_id = '" . (int)$customer_id . "'");
    } elseif (sizeof($products) > 0) {
      $products_parsed = array();
      reset($products);
      while (list(, $value) = each($products)) {
        if (is_numeric($value)) {
          $products_parsed[] = $value;
        }
      }

      if (sizeof($products_parsed) > 0) {
        $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "' and products_id not in (" . implode(',', $products_parsed) . ")");
        $check = tep_db_fetch_array($check_query);

        if ($check['total'] > 0) {
          tep_db_query("delete from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "' and products_id not in (" . implode(',', $products_parsed) . ")");
        }
      }
    } else {
      $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "'");
      $check = tep_db_fetch_array($check_query);

      if ($check['total'] > 0) {
        tep_db_query("delete from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "'");
      }
    }

    $messageStack->add_session('account', SUCCESS_NOTIFICATIONS_UPDATED, 'success');

    tep_redirect(tep_mobile_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL'));
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_mobile_link(FILENAME_MOBILE_ACCOUNT_NOTIFICATIONS, '', 'SSL'));
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<div id="iphone_content">
<?php echo tep_draw_form('account_notifications', tep_mobile_link(FILENAME_MOBILE_ACCOUNT_NOTIFICATIONS, '', 'SSL')) . tep_draw_hidden_field('action', 'process'); ?>
<div id="notifications">
	<h1><?php echo MY_NOTIFICATIONS_TITLE; ?></h1>
	<div id="text"><?php echo MY_NOTIFICATIONS_DESCRIPTION; ?></div>
	<h1><?php echo GLOBAL_NOTIFICATIONS_TITLE; ?></h1>
	<div id="text"><?php echo tep_draw_checkbox_field('product_global', '1', (($global['global_product_notifications'] == '1') ? true : false), 'onclick="checkBox(\'product_global\')"'); ?>
	<strong><?php echo GLOBAL_NOTIFICATIONS_TITLE; ?></strong>
	<br />
	<?php echo GLOBAL_NOTIFICATIONS_DESCRIPTION; ?>
	</div>
<?php
  if ($global['global_product_notifications'] != '1') {
?>
      <h1><?php echo NOTIFICATIONS_TITLE; ?></h1>
	  
<?php
    $products_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "'");
    $products_check = tep_db_fetch_array($products_check_query);
    if ($products_check['total'] > 0) {
?>
                  <div id="text"><?php echo NOTIFICATIONS_DESCRIPTION; ?></div>
<?php
      $counter = 0;
      $products_query = tep_db_query("select pd.products_id, pd.products_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_NOTIFICATIONS . " pn where pn.customers_id = '" . (int)$customer_id . "' and pn.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by pd.products_name");
      while ($products = tep_db_fetch_array($products_query)) {
?>
                  <div id="text">
				  <?php echo tep_draw_checkbox_field('products[' . $counter . ']', $products['products_id'], true, 'onclick="checkBox(\'products[' . $counter . ']\')"'); ?>
				  <?php echo $products['products_name']; ?>
				  </div>
<?php
        $counter++;
      }
    } else {
?>
                  <?php echo NOTIFICATIONS_NON_EXISTING; ?>
<?php
    }
?>
               
<?php
  }
?>
</div>
<div id="accthistpl">
<div id="bouton">
<?php echo tep_mobile_button(IMAGE_BUTTON_CONTINUE); ?>
</form>
</div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
