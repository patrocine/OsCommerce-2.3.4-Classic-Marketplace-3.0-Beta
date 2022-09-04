<?php
require_once('mobile/includes/application_top.php');
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  if (!isset($HTTP_GET_VARS['order_id']) || (isset($HTTP_GET_VARS['order_id']) && !is_numeric($HTTP_GET_VARS['order_id']))) {
    tep_redirect(tep_href_link(FILENAME_MOBILE_ACCOUNT_HISTORY, '', 'SSL'));
  }
  
  $customer_info_query = tep_db_query("select o.customers_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS . " s where o.orders_id = '". (int)$HTTP_GET_VARS['order_id'] . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "'");
  $customer_info = tep_db_fetch_array($customer_info_query);
  if ($customer_info['customers_id'] != $customer_id) {
    tep_redirect(tep_href_link(FILENAME_MOBILE_ACCOUNT_HISTORY, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_ACCOUNT_HISTORY_INFO));

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_MOBILE_ACCOUNT_HISTORY, '', 'SSL'));
  $breadcrumb->add(sprintf(NAVBAR_TITLE_3, $HTTP_GET_VARS['order_id']), tep_href_link(FILENAME_MOBILE_ACCOUNT_HISTORY_INFO, 'order_id=' . $HTTP_GET_VARS['order_id'], 'SSL'));

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order($HTTP_GET_VARS['order_id']);
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write(sprintf(HEADING_ORDER_NUMBER, $HTTP_GET_VARS['order_id']) . '(' . $order->info['orders_status'] . ')');
?>
<div id="iphone_content">
<div id="accthistpl">
<h1><?php echo HEADING_ORDER_DATE . ' ' . tep_date_short($order->info['date_purchased']); ?></h1>
<h1><?php echo HEADING_ORDER_TOTAL . ' ' . $order->info['total']; ?></h1>

<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>
                  <div id="nomProd"><?php echo HEADING_PRODUCTS; ?></div>
				  <div id="taxProd"><?php echo HEADING_TAX; ?></div>
				  <div id="totalProd"><?php echo HEADING_TOTAL; ?></div>
<?php
  } else {
?>
                  <div id="nomProd"><?php echo HEADING_PRODUCTS; ?></div>
<?php
  }

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    echo '' . '<div id="ligneProdNom">' .
         '' . $order->products[$i]['qty'] . '&nbsp;x' . '&nbsp;' .
         '' . $order->products[$i]['name'];

    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '<br><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small>';
      }
    }

    echo '' . '</div>';

    if (sizeof($order->info['tax_groups']) > 1) {
      echo '<div id="ligneProdTax">' . tep_display_tax_value($order->products[$i]['tax']) . '%' . '</div>';
    }

    echo '<div id="ligneProdPrix">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '' . '</div>' .
         '' . '';
  }
	?>
	<div class="clear"></div>
	<hr />
	<?php
  for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
    echo '' . '' .
         '<div id="titre">' . $order->totals[$i]['title'] . '&nbsp;&nbsp;' . '</div>' .
    	 '<div id="text">' . $order->totals[$i]['text'] . '' . '</div>' .
         '' . '';
  }
?>
<div class="clear"></div>
<hr />
<?php
  if ($order->delivery != false) {
?>
               <div id="delivery">
			   <h1><?php echo HEADING_DELIVERY_ADDRESS; ?></h1>
			   <?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', ''); ?>
			   </div>
<?php
    if (tep_not_null($order->info['shipping_method'])) {
?>
              <div id="shipping">
			  <h1><?php echo HEADING_SHIPPING_METHOD; ?></h1>
			  <?php echo $order->info['shipping_method']; ?>
			  </div>
<?php
    }
  }
?>
<div class="clear"></div>
				<div id="billing">
                <h1><?php echo HEADING_BILLING_ADDRESS; ?></h1>
				<?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', ''); ?>
				</div>
				<div id="payment">
				<h1><?php echo HEADING_PAYMENT_METHOD; ?></h1>
				<?php echo $order->info['payment_method']; ?>
				</div>
				<div class="clear"></div>
				<hr />
				<h1><?php echo HEADING_ORDER_HISTORY; ?></h1>
<?php
  $statuses_query = tep_db_query("select os.orders_status_name, osh.date_added, osh.comments from " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh where osh.orders_id = '" . (int)$HTTP_GET_VARS['order_id'] . "' and osh.orders_status_id = os.orders_status_id and os.language_id = '" . (int)$languages_id . "' order by osh.date_added");
  while ($statuses = tep_db_fetch_array($statuses_query)) {
  ?>
  <div id="historic">
  <?php
    echo '' . '' .
         '' . tep_date_short($statuses['date_added']) . '' . '<br />' .
         '' . $statuses['orders_status_name'] . '' .
         '' . (empty($statuses['comments']) ? '' :  '<br />' . nl2br(tep_output_string_protected($statuses['comments']))) . '' . '' .
         '' . '';
	?>
	</div>
	<?php
  }
?>

<?php
  if (DOWNLOAD_ENABLED == 'true') include(DIR_MOBILE_MODULES . 'downloads.php');
?>
</div>
<div id="accthistpl">
<div id="bouton">
<?php echo '<a href="' . tep_mobile_link(FILENAME_MOBILE_ACCOUNT_HISTORY) . '">'.tep_mobile_button(IMAGE_BUTTON_BACK).'</a>'; ?>
</div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
