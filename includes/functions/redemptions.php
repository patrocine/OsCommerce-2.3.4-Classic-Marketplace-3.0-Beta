<?php
/*
  $Id: redemptions.php, V2.1rc2a 2008/OCT/03 12:30:04 dsa_ Exp $
  created by Ben Zukrel, Deep Silver Accessories
  http://www.deep-silver.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/


// shopping points the customer currently has
  function tep_get_shopping_points($id = '', $check_session = true) {
	  global $customer_id;
	  
	  if (is_numeric($id) == false) {
		  if (tep_session_is_registered('customer_id')) {
			  $id = $customer_id;
		  } else {
			  return 0;
		  }
	  }
	  
	  if ($check_session == true) {
		  if ( (tep_session_is_registered('customer_id') == false) || ($id != $customer_id) ) {
			  return 0;
		  }
	  }
	  
	  if (tep_not_null(POINTS_AUTO_EXPIRES)) {
		  $points_query = tep_db_query("select customers_shopping_points from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$id . "' and customers_points_expires > CURDATE() limit 1");
	  } else {
		  $points_query = tep_db_query("select customers_shopping_points from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$id . "' limit 1");
	  }
	  
	  $points = tep_db_fetch_array($points_query);
	  
	  return $points['customers_shopping_points'];
  }
  
// calculate the shopping points value for the customer
  function tep_calc_shopping_pvalue($points) {
	  
	  return tep_round(((float)$points * (float)REDEEM_POINT_VALUE), 2);
  }

// calculate the products shopping points tax value if any  
  function tep_display_points($products_price, $products_tax, $quantity = 1) {
	  
	  if ((DISPLAY_PRICE_WITH_TAX == 'true') && (USE_POINTS_FOR_TAX == 'true')) {
		  $products_price_points_query = tep_add_tax($products_price, $products_tax) * $quantity;
	  } else {
		  $products_price_points_query = $products_price * $quantity;
	  }
	  
	  return $products_price_points_query;
  }
    
// calculate the shopping points for any products price  
  function tep_calc_products_price_points($products_price_points_query) {
	  
	  $products_points_total = $products_price_points_query * POINTS_PER_AMOUNT_PURCHASE;
	  
	  return $products_points_total;
  }
  
// calculate the shopping points value for any products price  
  function tep_calc_price_pvalue($products_points_total) {
	  
	  $products_points_value = tep_calc_shopping_pvalue($products_points_total);
	  
	  return($products_points_value);
  }

// products restriction by model.
  function get_redemption_rules($order) {
	  
	  if (tep_not_null(RESTRICTION_MODEL)||tep_not_null(RESTRICTION_PID)||tep_not_null(RESTRICTION_PATH)) {
		  if (tep_not_null(RESTRICTION_MODEL))   
          for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	          if (!(substr($order->products[$i]['model'], 0, 10) == RESTRICTION_MODEL)) {
		          return false;
	          }
             return true;
          }
          
          if (tep_not_null(RESTRICTION_PID))   
		  for ($i=0; $i<sizeof($order->products); $i++) {
			  $p_ids = split("[,]", RESTRICTION_PID);
			  for ($ii = 0; $ii < count($p_ids); $ii++) {
				  if ($order->products[$i]['id'] == $p_ids[$ii]) {
					  return true;
				  }
			  }
		  }
		  
		  if (tep_not_null(RESTRICTION_PATH))   
		  for ($i=0; $i<sizeof($order->products); $i++) {
			  $cat_ids = split("[,]", RESTRICTION_PATH);
			  $sub_cat_ids = split("[_]", tep_get_product_path($order->products[$i]['id']));
			   for ($iii = 0; $iii < count($sub_cat_ids); $iii++) {
				   for ($ii = 0; $ii < count($cat_ids); $ii++) {
					   if ($sub_cat_ids[$iii] == $cat_ids[$ii]) {
						   return true;
					   }
				   }
			   }
		   }
		   return false;
	   } else {
		   return true;
	   }
  }
    
// check to see if to add pending points for specials.
  function get_award_discounted($order) {
	  
	  if (USE_POINTS_FOR_SPECIALS == 'false') {
		  for ($i=0; $i<sizeof($order->products); $i++) {
			  if (tep_get_products_special_price($order->products[$i]['id']) >0) {
				  return true;
			  }
		  }
		  return false;
	  } else {
		  return true;
	  }
  }
  
// products pending points to add.
  function get_points_toadd($order) {
	  
	  if ($order->info['total'] > 0) {
		  if ((USE_POINTS_FOR_SHIPPING == 'false') && (USE_POINTS_FOR_TAX == 'false'))
		  $points_toadd = $order->info['total'] - $order->info['shipping_cost'] - $order->info['tax'];
		  else if ((USE_POINTS_FOR_SHIPPING == 'false') && (USE_POINTS_FOR_TAX == 'true'))
		  $points_toadd = $order->info['total'] - $order->info['shipping_cost'];
		  else if ((USE_POINTS_FOR_SHIPPING == 'true') && (USE_POINTS_FOR_TAX == 'false'))
		  $points_toadd = $order->info['total'] - $order->info['tax'];
		  else $points_toadd = $order->info['total'];
		  
		  if (USE_POINTS_FOR_SPECIALS == 'false') {
			  for ($i=0; $i<sizeof($order->products); $i++) {
				  if (tep_get_products_special_price($order->products[$i]['id']) >0) {
					  if (USE_POINTS_FOR_TAX == 'true') {
						  $points_toadd = $points_toadd - (tep_add_tax($order->products[$i]['final_price'],$order->products[$i]['tax'])*$order->products[$i]['qty']);
					  } else {
						  $points_toadd = $points_toadd - ($order->products[$i]['final_price']*$order->products[$i]['qty']);
					  }
				  }
			  }
		  }
		  return $points_toadd;
	  } else {
		  return false;
	  }
  }
  
// sets the customers Pending points
  function tep_add_pending_points($customer_id, $insert_id, $points_toadd, $points_comment, $points_type) {
	  
	  $points_awarded = ($points_type != 'SP') ? $points_toadd : $points_toadd * POINTS_PER_AMOUNT_PURCHASE;
	  
	  if (POINTS_AUTO_ON == '0') {
		  $sql_data_array = array('customer_id' => (int)$customer_id,
		                          'orders_id' => (int)$insert_id,
		                          'points_pending' => $points_awarded,
		                          'date_added' => 'now()',
		                          'points_comment' => $points_comment,
		                          'points_type' => $points_type,
		                          'points_status' => 2);
		  
          tep_db_perform(TABLE_CUSTOMERS_POINTS_PENDING, $sql_data_array);
          
          $sql = "optimize table " . TABLE_CUSTOMERS_POINTS_PENDING . "";
          
          if (tep_not_null(POINTS_AUTO_EXPIRES)) {
	          $expire  = date('Y-m-d', strtotime('+ '. POINTS_AUTO_EXPIRES .' month'));
	          tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = customers_shopping_points + '". $points_awarded ."', customers_points_expires = '". $expire ."' where customers_id = '". (int)$customer_id ."' limit 1");
          } else {
	          tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = customers_shopping_points + '". $points_awarded ."' where customers_id = '". (int)$customer_id ."' limit 1");
          }
      } else {
	      $sql_data_array = array('customer_id' => (int)$customer_id,
                                  'orders_id' => (int)$insert_id,
                                  'points_pending' => $points_awarded,
                                  'date_added' => 'now()',
                                  'points_comment' => $points_comment,
                                  'points_type' => $points_type,
                                  'points_status' => 1);
          tep_db_perform(TABLE_CUSTOMERS_POINTS_PENDING, $sql_data_array);
          
          $sql = "optimize table " . TABLE_CUSTOMERS_POINTS_PENDING . "";
      }
  }
  
// balance customer points account & record the customers redeemed_points
  function tep_redeemed_points($customer_id, $insert_id, $customer_shopping_points_spending) {
	  
	  if ((tep_get_shopping_points($customer_id) - $customer_shopping_points_spending) > 0) {
		  tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = customers_shopping_points - '". $customer_shopping_points_spending ."' where customers_id = '". (int)$customer_id ."' limit 1");
	  } else {
		  tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = null, customers_points_expires = null where customers_id = '". (int)$customer_id ."' limit 1");
	  }
	  
	  if (DISPLAY_POINTS_REDEEMED == 'true') {
		  $sql_data_array = array('customer_id' => (int)$customer_id,
                                  'orders_id' => (int)$insert_id,
                                  'points_pending' => - $customer_shopping_points_spending,
                                  'date_added' => 'now()',
                                  'points_comment' => 'TEXT_DEFAULT_REDEEMED',
                                  'points_type' => 'SP',
                                  'points_status' => 4);
          tep_db_perform(TABLE_CUSTOMERS_POINTS_PENDING, $sql_data_array);
          
          $sql = "optimize table " . TABLE_CUSTOMERS_POINTS_PENDING . "";
      }
  }

// sets the new signup customers welcome points
  function tep_add_welcome_points($customer_id) {
	  
	  $welcome_points = NEW_SIGNUP_POINT_AMOUNT;
	  
	  if (tep_not_null(POINTS_AUTO_EXPIRES)) {
		  tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = customers_shopping_points + '" . $welcome_points . "', customers_points_expires = DATE_ADD(NOW(),INTERVAL '" . POINTS_AUTO_EXPIRES . "' MONTH) where customers_id = '" . (int)$customer_id . "' limit 1");
	  } else {
		  tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = customers_shopping_points + '" . $welcome_points . "' where customers_id = '" . (int)$customer_id . "' limit 1");
	  }
  }

// get the last update value for any key
  function tep_get_last_date($key) {
	  
	  $key_date_query = tep_db_query("select last_modified from " . TABLE_CONFIGURATION . " where configuration_key = '". $key ."' limit 1");
      $key_date = tep_db_fetch_array($key_date_query);

      return tep_date_long($key_date['last_modified']);
  }
  
// products discounted restriction if enabled.
  function get_points_rules_discounted($order) {
	  
	  if (REDEMPTION_DISCOUNTED == 'true') {
		  for ($i=0; $i<sizeof($order->products); $i++) {
			  if (tep_get_products_special_price($order->products[$i]['id']) >0) {
				  return false;
			  }
		  }
		  return true;
	  } else {
		  return true;
	  }
  }
      
  function get_redemption_awards($customer_shopping_points_spending) {
	  global $order;
	  
	  if (USE_POINTS_FOR_REDEEMED == 'false') {
		  if (!$customer_shopping_points_spending) {
			  return true;
		  }
		  return false;
	  } else {
		  return true;
	  }
  }

  function calculate_max_points($customer_shopping_points) {
	  global $currencies, $order;
	  
	  $max_points = $order->info['total']/REDEEM_POINT_VALUE;
	  
	  if (REDEMPTION_DISCOUNTED == 'true') {
		  $special_points = 0;
		  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
			  $special_price = tep_get_products_special_price($order->products[$i]['id']);
              if ($special_price > 0) {
                  $special_points = $special_points + (($special_price*$order->products[$i]['qty'])/REDEEM_POINT_VALUE);
                  $max_points = $max_points - (($special_price*$order->products[$i]['qty'])/REDEEM_POINT_VALUE);
              }
          }
      }
      
      if (tep_not_null(RESTRICTION_MODEL)) {
	      $model_points = 0;
	      for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
              if ($order->products[$i]['model'] != RESTRICTION_MODEL) {
	              $model_price = $order->products[$i]['price'];
                  $model_points = $model_points + (($model_price*$order->products[$i]['qty'])/REDEEM_POINT_VALUE);
                  $max_points = $max_points - (($model_price*$order->products[$i]['qty'])/REDEEM_POINT_VALUE);
              }
          }
      }
      
      if (tep_not_null(RESTRICTION_PID) && !tep_not_null(RESTRICTION_MODEL)) {
	      $pid_points = 0;
	      for ($i=0; $i<sizeof($order->products); $i++) {
		      $p_ids = split("[,]", RESTRICTION_PID);
		      for ($ii = 0; $ii < count($p_ids); $ii++) {
			      if ($order->products[$i]['id'] == $p_ids[$ii]) {
				      $pid_points = ($order->products[$i]['price']*$order->products[$i]['qty'])+($order->info['shipping_cost']+$order->info['tax']);
				      $max_points =  $pid_points/REDEEM_POINT_VALUE;
			      }
		      }
	      }
      }
      
      if (tep_not_null(RESTRICTION_PATH) && !tep_not_null(RESTRICTION_PID) && !tep_not_null(RESTRICTION_MODEL)) {
	      $path_points = 0;
	      for ($i=0; $i<sizeof($order->products); $i++) {
		      $cat_ids = split("[,]", RESTRICTION_PATH);
		      $sub_cat_ids = split("[_]", tep_get_product_path($order->products[$i]['id']));
		      for ($iii = 0; $iii < count($sub_cat_ids); $iii++) {
			      for ($ii = 0; $ii < count($cat_ids); $ii++) {
				      if ($sub_cat_ids[$iii] == $cat_ids[$ii]) {
					      $path_points = ($order->products[$i]['price']*$order->products[$i]['qty'])+($order->info['shipping_cost']+$order->info['tax']);
					      $max_points =  $path_points/REDEEM_POINT_VALUE;
				      }
			      }
		      }
	      }
      }
      
      $max_points = $max_points > POINTS_MAX_VALUE ? POINTS_MAX_VALUE : $max_points;
      $max_points = $customer_shopping_points > $max_points ? $max_points : $customer_shopping_points;
      
      return $max_points;
  }

  function points_selection($cart_show_total) {
	  global $currencies, $order;
	  
	  if (($customer_shopping_points = tep_get_shopping_points()) && $customer_shopping_points > 0) {
		  if (get_redemption_rules($order) && (get_points_rules_discounted($order) || get_cart_mixed($order))) {
			  if ($customer_shopping_points >= POINTS_LIMIT_VALUE) {
				 //if ((POINTS_MIN_AMOUNT == '') || ($cart->show_total() >= POINTS_MIN_AMOUNT) ) {
				 if ((POINTS_MIN_AMOUNT == '') || ($cart_show_total >= POINTS_MIN_AMOUNT) ) {
					  if (tep_session_is_registered('customer_shopping_points_spending')) tep_session_unregister('customer_shopping_points_spending');
					  
					  $max_points = calculate_max_points($customer_shopping_points);
					  if ($order->info['total'] > tep_calc_shopping_pvalue($max_points)) {
						  $note = '<br /><small>' . TEXT_REDEEM_SYSTEM_NOTE .'</small>';
					  }
					  
					  $customer_shopping_points_spending = $max_points;
?>
	        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
          <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main"><b><?php echo TABLE_HEADING_REDEEM_SYSTEM; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main"><?php printf(TEXT_REDEEM_SYSTEM_START, $currencies->format(tep_calc_shopping_pvalue($customer_shopping_points)), $currencies->format($order->info['total']). $note); ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>
              <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main"><?php printf(TEXT_REDEEM_SYSTEM_SPENDING, number_format($max_points,POINTS_DECIMAL_PLACES), $currencies->format(tep_calc_shopping_pvalue($max_points))); ?></td>
                <td class="main" align="right"><?php echo tep_draw_checkbox_field('customer_shopping_points_spending', $customer_shopping_points_spending,'','onclick="submitFunction()"'); ?></td>
                <td width="25"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php 
				  }
			  }
		  }
	  }
  }
  
  function referral_input() {
	  
	  if (tep_not_null(USE_REFERRAL_SYSTEM)) {
?>
        <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
          <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main"><b><?php echo TABLE_HEADING_REFERRAL; ?></b></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
            <tr class="infoBoxContents">
              <td><table border="0" width="100%" cellspacing="5" cellpadding="2">
                <tr>
                  <td class="main"><?php echo TEXT_REFERRAL_REFERRED; ?></td>
                  <td class="main"><?php echo tep_draw_input_field('customer_referred', $customer_referred); ?></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
<?php
	  }
  }
    
// products discounted and normal products in cart?
  function get_cart_mixed($order) {
	  
	  if (sizeof($order->products) >1) {
		  $special = false;
		  $normal = false;
		  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
			  if (tep_get_products_special_price($order->products[$i]['id']) >0) {
				  $special = true;
			  } else {
				  $normal = true;
			  }
		  }
		  
		  if ($special == true && $normal == true) {
			  return true;
		  } else {
			  return false;
		  }
		  
		  return false;
	  }
  }
?>