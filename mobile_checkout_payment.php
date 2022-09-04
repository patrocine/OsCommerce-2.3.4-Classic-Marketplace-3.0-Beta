<?php
require_once('mobile/includes/application_top.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_mobile_link(FILENAME_SHOPPING_CART));
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!tep_session_is_registered('shipping')) {
    tep_redirect(tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }

// Stock Check
  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (tep_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
        tep_redirect(tep_mobile_link(FILENAME_SHOPPING_CART));
        break;
      }
    }
  }

// if no billing destination address was selected, use the customers own address as default
  if (!tep_session_is_registered('billto')) {
    tep_session_register('billto');
    $billto = $customer_default_address_id;
  } else {
// verify the selected billing address
    if ( (is_array($billto) && empty($billto)) || is_numeric($billto) ) {
      $check_address_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$billto . "'");
      $check_address = tep_db_fetch_array($check_address_query);

      if ($check_address['total'] != '1') {
        $billto = $customer_default_address_id;
        if (tep_session_is_registered('payment')) tep_session_unregister('payment');
      }
    }
  }

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  if (!tep_session_is_registered('comments')) tep_session_register('comments');
  if (isset($HTTP_POST_VARS['comments']) && tep_not_null($HTTP_POST_VARS['comments'])) {
    $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
  }

  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();

// load all enabled payment modules
  require(DIR_MOBILE_CLASSES . 'payment.php');
  $payment_modules = new payment;

  require(DIR_WS_LANGUAGES . $language . '/checkout_payment.php');

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_mobile_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<script type="text/javascript"><!--
var selected;

 /* Points/Rewards Module V2.1beta bof*/
var submitter = null;
function submitFunction() {
   submitter = 1;
   }
/* Points/Rewards Module V2.1beta eof*/


function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
  if (document.checkout_payment.payment[0]) {
    document.checkout_payment.payment[buttonSelect].checked=true;
  } else {
    document.checkout_payment.payment.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
//--></script>
<?php echo $payment_modules->javascript_validation(); ?>
<div id="iphone_content">
<?php echo tep_draw_form('checkout_payment', tep_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onsubmit="return check_form();"', true); ?>
<div id="checkout_payment">
<?php
  if (isset($HTTP_GET_VARS['payment_error']) && is_object(${$HTTP_GET_VARS['payment_error']}) && ($error = ${$HTTP_GET_VARS['payment_error']}->get_error())) {
?>
<div id="messageStackError">
<?php echo tep_output_string_protected($error['title']); ?>
<?php echo tep_output_string_protected($error['error']); ?>
</div>
<?php
  }
?>
<h1><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></h1>
</br>
<?php
  $selection = $payment_modules->selection();

  if (sizeof($selection) > 1) {
?>

  <div id="bill_add">
    <?php echo TEXT_SELECT_PAYMENT_METHOD; ?>
  </br>
  </br>

<?php
    } elseif ($free_shipping == false) {
?>

  <div id="bill_add">
    <?php echo TEXT_ENTER_PAYMENT_INFORMATION; ?>
  </br>
  </br>

<?php
    }
?>

<?php
  $radio_buttons = 0;
  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
    if ( ($selection[$i]['id'] == $payment) || ($n == 1) ) {
      echo '      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    } else {
      echo '      <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    }
?>
<td style="padding-left: 10px;">
<?php
	if (sizeof($selection) > 0) {
      echo tep_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $payment));
    } else {
      echo tep_draw_hidden_field('payment', $selection[$i]['id']);
    }
?>
</td>
        <td width="100%" style="padding-top: 13px; padding-bottom: 11px;">&nbsp;&nbsp;<strong><?php echo $selection[$i]['module']; ?></strong></td>
      </tr>

<?php
    if (isset($selection[$i]['error'])) {
?>

      <tr>
        <td colspan="2"><?php echo $selection[$i]['error']; ?></td>
      </tr>

<?php
    } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
?>

      <tr>
        <td colspan="2"><table border="0" cellspacing="0" cellpadding="2">

<?php
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>

          <tr>
            <td><?php echo $selection[$i]['fields'][$j]['title']; ?></td>
            <td><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
          </tr>

<?php
      }
?>

        </table></td>
      </tr>

<?php
    }
?>

    </table>

<?php
    $radio_buttons++;
  }
?>

  <!-- Points/Rewards Module V2.1beta Redeemption box bof -->
<?php
  if ((USE_POINTS_SYSTEM == 'true') && (USE_REDEEM_SYSTEM == 'true')) {
	  //echo points_selection();
	  $cart_show_total= $cart->show_total();
	  echo points_selection($cart_show_total);
	  if (tep_not_null(USE_REFERRAL_SYSTEM) && (tep_count_customer_orders() == 0)) {
		  echo referral_input();
	  }
  }
?>
<!-- Points/Rewards Module V2.1beta Redeemption box eof -->



  </div>
      <hr />
		<h1><?php echo TABLE_HEADING_BILLING_ADDRESS; ?></h1>
      <div id="bill_add">
	  <?php echo tep_address_label($customer_id, $billto, true, ' ', '</br>'); ?>
	    <table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
	    	<?php echo tep_mobile_selection(tep_mobile_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS), array(IMAGE_BUTTON_CHANGE_ADDRESS)).'<div class="fleche" style="position:relative; top:1px;"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>'; ?>
	    </table>
     </div>
<?php echo tep_draw_form('checkout_payment', tep_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onsubmit="return check_form();" ', true);
?>
      <hr />
      <h1><?php echo TABLE_HEADING_COMMENTS; ?></h1>
      <div id="bill_add">
      <?php echo tep_draw_textarea_field('comments', 'soft', '40', '6', $comments); ?>
      </div>

   <?php
/* kgt - discount coupons */
	//if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_STATUS == 'true' ) {
?>
<h2><?php echo TABLE_HEADING_COUPON; ?></h2>

  <div class="contentText">
  	 </div>

        <div class="contentText">
        <?php echo ENTRY_DISCOUNT_COUPON.' '.tep_draw_input_field('coupon', '', 'size="32"', $coupon); ?>
  	 </div>

<?php
	//}
/* end kgt - discount coupons */

     ?>


      <div id="bouton" style="height:24px;">
      <?php echo '<span style="float:right;"><input type="submit" value="' . IMAGE_BUTTON_CONTINUE . '"></form></span>' . 
      		 '<span style="float:left;">' . tep_draw_form('back', tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_BACK) . '</form></span>'; ?>		
      </div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
