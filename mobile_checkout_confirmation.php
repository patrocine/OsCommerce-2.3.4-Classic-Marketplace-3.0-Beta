<?php
require_once('mobile/includes/application_top.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
    tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_mobile_link(FILENAME_SHOPPING_CART));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!tep_session_is_registered('shipping')) {
    tep_redirect(tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

// unregister mobile redirectCancelled for external payment service return to mobile
	tep_session_unregister('redirectCancelled');

  if (!tep_session_is_registered('payment')) tep_session_register('payment');
  if (isset($HTTP_POST_VARS['payment'])) $payment = $HTTP_POST_VARS['payment'];

  if (!tep_session_is_registered('comments')) tep_session_register('comments');
  if (isset($HTTP_POST_VARS['comments']) && tep_not_null($HTTP_POST_VARS['comments'])) {
        $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
  }
  
  
  //kgt - discount coupons
  if (!tep_session_is_registered('coupon')) tep_session_register('coupon');
  //this needs to be set before the order object is created, but we must process it after
  $coupon = tep_db_prepare_input($HTTP_POST_VARS['coupon']);
  //end kgt - discount coupons
  

// load the selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  $payment_modules->update_status();


##### Points/Rewards Module V2.1beta check for error BOF #######
  if ((USE_POINTS_SYSTEM == 'true') && (USE_REDEEM_SYSTEM == 'true')) {
	  if (isset($_POST['customer_shopping_points_spending']) && is_numeric($_POST['customer_shopping_points_spending']) && ($_POST['customer_shopping_points_spending'] > 0)) {
		  $customer_shopping_points_spending = false;
		  // This if sentence should include check for amount of points on account compared to the transferred point from checkout_payment.php
		  // Possible Hack Fix included
		  if (tep_calc_shopping_pvalue($_POST['customer_shopping_points_spending']) < $order->info['total'] && !is_object($$payment) || (tep_get_shopping_points($customer_id) < $_POST['customer_shopping_points_spending'])) {
			  $customer_shopping_points_spending = false;
			  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(REDEEM_SYSTEM_ERROR_POINTS_NOT), 'SSL'));
		  } else {
			  $customer_shopping_points_spending = $_POST['customer_shopping_points_spending'];
			  if (!tep_session_is_registered('customer_shopping_points_spending')) tep_session_register('customer_shopping_points_spending');
		  }
	  }

	  //To ensure only the first order of a new customer is entitled to grant point to his/her referrer. Otherwise, a hacker might hard-code the email address of  a referrer and cheat for point on every single order the new customer made.
	  if (tep_not_null(USE_REFERRAL_SYSTEM) && (tep_count_customer_orders() == 0)) {
		  if (isset($_POST['customer_referred']) && tep_not_null($_POST['customer_referred'])) {
			  $customer_referral = false;
			  $check_mail = trim($_POST['customer_referred']);
			  if (tep_validate_email($check_mail) == false) {
				  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(REFERRAL_ERROR_NOT_VALID), 'SSL'));
			  } else {
				  $valid_referral_query = tep_db_query("select customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . $check_mail . "' limit 1");
				  $valid_referral = tep_db_fetch_array($valid_referral_query);
				  if (!tep_db_num_rows($valid_referral_query)) {
					  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(REFERRAL_ERROR_NOT_FOUND), 'SSL'));
				  }

				  if ($check_mail == $order->customer['email_address']) {
					  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(REFERRAL_ERROR_SELF), 'SSL'));
				  } else {
					  $customer_referral = $valid_referral['customers_id'];
					  if (!tep_session_is_registered('customer_referral')) tep_session_register('customer_referral');
				  }
			  }
		  }
	  }
  }
//if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
  if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) && (!$customer_shopping_points_spending) || (is_object($$payment) && ($$payment->enabled == false)) ) {
	  tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
  }
########  Points/Rewards Module V2.1beta EOF #################*/
  if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
  }



    //kgt - discount coupons
  if( tep_not_null( $coupon ) && is_object( $order->coupon ) ) { //if they have entered something in the coupon field
    $order->coupon->verify_code();
    if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DEBUG != 'true' ) {
		  if( !$order->coupon->is_errors() ) { //if we have passed all tests (no error message), make sure we still meet free shipping requirements, if any
			  if( $order->coupon->is_recalc_shipping() ) tep_redirect( tep_href_link( FILENAME_CHECKOUT_SHIPPING, 'error_message=' . urlencode( ENTRY_DISCOUNT_COUPON_SHIPPING_CALC_ERROR ), 'SSL' ) ); //redirect to the shipping page to reselect the shipping method
		  } else {
			  if( tep_session_is_registered('coupon') ) tep_session_unregister('coupon'); //remove the coupon from the session
			  tep_redirect( tep_href_link( FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode( implode( ' ', $order->coupon->get_messages() ) ), 'SSL' ) ); //redirect to the payment page
		  }
    }
	} else { //if the coupon field is empty, unregister the coupon from the session
		if( tep_session_is_registered('coupon') ) { //we had a coupon entered before, so we need to unregister it
      tep_session_unregister('coupon');
      //now check to see if we need to recalculate shipping:
      require_once( DIR_WS_CLASSES.'discount_coupon.php' );
      if( discount_coupon::is_recalc_shipping() ) tep_redirect( tep_href_link( FILENAME_CHECKOUT_SHIPPING, 'error_message=' . urlencode( ENTRY_DISCOUNT_COUPON_SHIPPING_CALC_ERROR ), 'SSL' ) ); //redirect to the shipping page to reselect the shipping method
    }
	}
	//end kgt - discount coupons



// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;
  $order_total_modules->process();

// Stock Check
  $any_out_of_stock = false;
  if (STOCK_CHECK == 'true') {
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      if (tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
        $any_out_of_stock = true;
      }
    }
    // Out of Stock
    if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
      tep_redirect(tep_mobile_link(FILENAME_SHOPPING_CART));
    }
  }

  require(DIR_WS_LANGUAGES . $language . '/checkout_confirmation.php');

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2);

	require(DIR_MOBILE_INCLUDES . 'header.php');
	$headerTitle->write();
?>
<?php
  if (isset($$payment->form_action_url)) {
    $form_action_url = $$payment->form_action_url;
  } else {
    $form_action_url = tep_mobile_link(FILENAME_MOBILE_CHECKOUT_PROCESS, '', 'SSL');
  }
?>


        <div id="cms">
  <div id="bouton" style="height:200px;">

         <?php include(DIR_WS_LANGUAGES . $language . '/' . 'define_checkout_confirmation.php'); ?>

        </div>
</div>


<div id="iphone_content">
<div id="checkout_conf">
<?php
      if (is_array($payment_modules->modules)) {
      	      echo $payment_modules->process_button();
      }
      echo tep_draw_form('checkout_confirmation', $form_action_url, 'post'); ?>
<!-- cart -->
<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>
                  <?php echo '<h1>' . HEADING_PRODUCTS . ' <a href="' . tep_mobile_link(FILENAME_SHOPPING_CART) . '"><input type="button" value="' . IMAGE_BUTTON_CHANGE . '"></a></h1>'; ?>
				  <?php echo HEADING_TAX; ?>
				  <?php echo HEADING_TOTAL; ?>
<?php
  } else {
?>
                  <?php echo '<h1>' . HEADING_PRODUCTS . ' <a href="' . tep_mobile_link(FILENAME_SHOPPING_CART) . '"><input type="button" value="' . IMAGE_BUTTON_CHANGE . '"></a></h1>'; ?>
<?php
  }

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    echo '' . '<div id="ligneProd">' .
         '' . $order->products[$i]['qty'] . '&nbsp;x&nbsp;' . '' .
         '' . $order->products[$i]['name'];

    if (STOCK_CHECK == 'true') {
      echo tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty']);
    }

    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';
      }
    }

    echo '' . '</div>';

    if (sizeof($order->info['tax_groups']) > 1) 
	echo '' . tep_display_tax_value($order->products[$i]['tax']) . '%' . '<br />';
	echo '<div class="gras">' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . '' . '</div>' .
         '' . '';
  }
?>
<!-- end of cart -->
<hr />
<?php
  if (MODULE_ORDER_TOTAL_INSTALLED) {
  ?>
  <table border="0" cellspacing="0" cellpadding="2">
  <?php
    echo $order_total_modules->output();
	?>
	</table>
	<?php
  }
?>
      	<hr />
		<?php echo '<h1>' . HEADING_PAYMENT_METHOD . '' .  ' <a href="' . tep_mobile_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><input type="button" value="' . IMAGE_BUTTON_CHANGE . '"></a></h1>'; ?>
		<?php echo $order->info['payment_method']; ?>
		<hr />
<?php
  if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) {
?>
      <h1><?php echo HEADING_PAYMENT_INFORMATION; ?></h1>
	  <div id="text"><?php echo $confirmation['title']; ?>
<?php
          if (isset($confirmation['fields'])) {
          	  for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {
          	  	  echo $confirmation['fields'][$i]['title'];
          	  	  echo $confirmation['fields'][$i]['field'];
          	  }
          }
      ?>
      </div>
      <?php
    }
  }
?>
		<hr />
		<?php echo '<h1>' . HEADING_BILLING_ADDRESS . ' <a href="' . tep_mobile_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '"><input type="button" value="' . IMAGE_BUTTON_CHANGE . '"></a></h1>'; ?>
		<?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>'); ?>
		<hr />
<?php
	if ($sendto != false) {
		if ($order->info['shipping_method']) {
?>
      
	  <?php echo '<h1>' . HEADING_SHIPPING_METHOD . ' <a href="' . tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '"><input type="button" value="' . IMAGE_BUTTON_CHANGE . '"></a></h1>'; ?>
	  <?php echo $order->info['shipping_method']; ?>
<?php
    	}
?>
		<hr />
      <?php echo '<h1>' . HEADING_DELIVERY_ADDRESS . ' <a href="' . tep_mobile_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '"><input type="button" value="' . IMAGE_BUTTON_CHANGE . '"></a></h1>'; ?>
	  <?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>'); ?>
	  <hr />
<?php
	} // end of if ($sendto != false) 

  if (tep_not_null($order->info['comments'])) {
?>
	<?php echo '<h1><b>' . HEADING_ORDER_COMMENTS . '</b></h1> <a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><input type="button" value="' . IMAGE_BUTTON_CHANGE . '"></a>'; ?>
        <?php echo nl2br(tep_output_string_protected($order->info['comments'])) . tep_draw_hidden_field('comments', $order->info['comments']);
        ?>
        <hr />
        <?php
  }

if (is_array($payment_modules->modules)) {
echo $payment_modules->process_button();
}
?>
      <div id="bouton" style="height:24px;">
      <?php echo '<span style="float:right;"><input type="submit" value="' . IMAGE_BUTTON_CONFIRM_ORDER . '"></form></span>' . 
      		 '<span style="float:left;">' . tep_draw_form('back', tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_BACK) . '</form></span>'; ?>		
</div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
