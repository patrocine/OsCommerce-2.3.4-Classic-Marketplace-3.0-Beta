<?php
require_once('mobile/includes/application_top.php');
require(DIR_WS_CLASSES.'http_client.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_mobile_link(FILENAME_SHOPPING_CART));
  }

// if no shipping destination address was selected, use the customers own address as default
  if (!tep_session_is_registered('sendto')) {
    tep_session_register('sendto');
    $sendto = $customer_default_address_id;
  } else {
// verify the selected shipping address
    if ( (is_array($sendto) && empty($sendto)) || is_numeric($sendto) ) {
      $check_address_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$sendto . "'");
      $check_address = tep_db_fetch_array($check_address_query);

      if ($check_address['total'] != '1') {
        $sendto = $customer_default_address_id;
        if (tep_session_is_registered('shipping')) tep_session_unregister('shipping');
      }
    }
  }

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
  if (!tep_session_is_registered('cartID')) {
        tep_session_register('cartID');
  } elseif (($cartID != $cart->cartID) && tep_session_is_registered('shipping')) {
        tep_session_unregister('shipping');
  }

  $cartID = $cart->cartID = $cart->generate_cart_id();

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
  if ($order->content_type == 'virtual') {
    if (!tep_session_is_registered('shipping')) tep_session_register('shipping');
    $shipping = false;
    $sendto = false;
    tep_redirect(tep_mobile_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
  }

  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();

// load all enabled shipping modules
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping;

  if ( defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true') ) {
    $pass = false;

    switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
      case 'national':
        if ($order->delivery['country_id'] == STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'international':
        if ($order->delivery['country_id'] != STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'both':
        $pass = true;
        break;
    }

    $free_shipping = false;
    if ( ($pass == true) && ($order->info['total'] >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER) ) {
      $free_shipping = true;

      include(DIR_WS_LANGUAGES . $language . '/modules/order_total/ot_shipping.php');
    }
  } else {
    $free_shipping = false;
  }

  // process the selected shipping method
  if ( isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process') ) {
    if (!tep_session_is_registered('comments')) tep_session_register('comments');
    if (tep_not_null($HTTP_POST_VARS['comments'])) {
      $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
    }

    if (!tep_session_is_registered('shipping')) tep_session_register('shipping');

    if ( (tep_count_shipping_modules() > 0) || ($free_shipping == true) ) {
      if ( (isset($HTTP_POST_VARS['shipping'])) && (strpos($HTTP_POST_VARS['shipping'], '_')) ) {
        $shipping = $HTTP_POST_VARS['shipping'];

        list($module, $method) = explode('_', $shipping);
        if ( is_object($$module) || ($shipping == 'free_free') ) {
          if ($shipping == 'free_free') {
            $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else {
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            tep_session_unregister('shipping');
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
              $shipping = array('id' => $shipping,
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                                'cost' => $quote[0]['methods'][0]['cost']);

              tep_redirect(tep_mobile_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
            }
          }
        } else {
          tep_session_unregister('shipping');
        }
      }
    } else {
      $shipping = false;
                
      tep_redirect(tep_mobile_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
    }    
  }

// get all available shipping quotes
  $quotes = $shipping_modules->quote();

// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
  if ( !tep_session_is_registered('shipping') || ( tep_session_is_registered('shipping') && ($shipping == false) && (tep_count_shipping_modules() > 1) ) ) $shipping = $shipping_modules->cheapest();

  require(DIR_WS_LANGUAGES . $language . '/checkout_shipping.php');

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_mobile_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<script type="text/javascript"><!--
var selected;

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
  if (document.checkout_address.shipping[0]) {
    document.checkout_address.shipping[buttonSelect].checked=true;
  } else {
    document.checkout_address.shipping.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
//--></script>
<div id="iphone_content">
<?php echo tep_draw_form('checkout_address', tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'), 'post', '', true) . tep_draw_hidden_field('action', 'process'); ?>
<div id="checkout_shipping">
<?php
  if (tep_count_shipping_modules() > 0) {
?>

  <h1><?php echo TABLE_HEADING_SHIPPING_METHOD; ?></h1>
</br>
<?php
    if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1 && $free_shipping == false) {
?>
  <div id="ship_add">
    <?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?>

<?php
    } elseif ($free_shipping == false) {
?>

  <div id="ship_add">
    <?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?>

<?php
    }
    if ($free_shipping == true) {
?>
  <div id="ship_add">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><strong><?php echo FREE_SHIPPING_TITLE; ?></strong></br>&nbsp;<?php echo $quotes[$i]['icon']; ?></td>
      </tr>
      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, 0)">
        <td style="padding-left: 15px; padding-top: 12px; padding-bottom: 12px;"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . tep_draw_hidden_field('shipping', 'free_free'); ?></td>
      </tr>
    </div>
<?php
    } else {
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <?php
      $radio_buttons = 0;
      for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
?>
</br>
      <tr>
        <td colspan="3"><strong><?php echo $quotes[$i]['module']; ?></strong>&nbsp;<?php if (isset($quotes[$i]['icon']) && tep_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></td>
      </tr>

<?php
        if (isset($quotes[$i]['error'])) {
?>

      <tr>
        <td colspan="3"><?php echo $quotes[$i]['error']; ?></td>
      </tr>

<?php
        } else {
          for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
// set the radio button to be checked if it is the method chosen
            $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $shipping['id']) ? true : false);

            if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
              echo '      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
            } else {
              echo '      <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
            }
?>

        <td style="padding-left: 10px;"><?php echo tep_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked); ?></td>
        <td width="89%" style="padding-top: 13px; padding-bottom: 11px;">&nbsp;<?php echo $quotes[$i]['methods'][$j]['title']; ?></td>

<?php
            if ( ($n > 1) || ($n2 > 1) ) {
?>

        <td><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></td>

<?php
            } else {
?>

        <td align="right" colspan="2"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))) . tep_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></td>

<?php
            }
?>

      </tr>

<?php
            $radio_buttons++;
          }
        }
      }
    }
?>

    </table>
  </div>

<?php
  }
?>
  <hr />
   <h1><?php echo TABLE_HEADING_SHIPPING_ADDRESS; ?></h1>
      <div id="ship_add">
	  <?php echo tep_address_label($customer_id, $sendto, true, ' ', '</br>'); ?>
	    <table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
	    	<?php echo tep_mobile_selection(tep_mobile_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS), array(IMAGE_BUTTON_CHANGE_ADDRESS)).'<div class="fleche" style="position:relative; top:3px;"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>'; ?>
	    </table>
     </div>
<?php echo tep_draw_form('checkout_address', tep_mobile_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'), 'post', '', true) . tep_draw_hidden_field('action', 'process'); ?>
 <hr />
   <h1><?php echo TABLE_HEADING_COMMENTS; ?></h1>
      <div id="ship_add">
	  <?php echo tep_draw_textarea_field('comments', 'soft', '40', '6'); ?>
	  </div>
      <div id="bouton" style="height:24px;">
      <?php echo '<span style="float:right;"><input type="submit" value="' . IMAGE_BUTTON_CONTINUE . '"></form></span>' . 
      		 '<span style="float:left;">' . tep_draw_form('back', tep_mobile_link(FILENAME_SHOPPING_CART, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_BACK) . '</form></span>'; ?>		
      </div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
