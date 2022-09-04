<?php
/*
 * ot_discount_coupons.php
 * August 4, 2006
 * author: Kristen G. Thorson
 * ot_discount_coupon_codes version 3.0
 *
 *
 * Released under the GNU General Public License
 *
 */

  class ot_discount_coupon {
    var $title, $output, $coupon;

    function ot_discount_coupon() {
      $this->code = 'ot_discount_coupon';
      $this->title = MODULE_ORDER_TOTAL_DISCOUNT_COUPON_TITLE;
      $this->enabled = ((MODULE_ORDER_TOTAL_DISCOUNT_COUPON_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_DISCOUNT_COUPON_SORT_ORDER;
      $this->output = array();
    }

    function process() {
      global $order, $currencies;
      if( is_object( $order->coupon ) ) {

        //if the order total lines for multiple tax groups should be displayed as one, add them all together
        if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_LINES == 'false' ) $discount_lines = array( array_sum( $order->coupon->applied_discount ) );
        else $discount_lines = $order->coupon->applied_discount;

        if( is_array( $discount_lines ) ) foreach( $discount_lines as $tax_group => $discount ) {
          if( $discount > 0 ) {
            //add in the tax if needed:
            if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_TAX == 'Display discount with discounted tax applied' && is_array( $order->coupon->discount_tax ) ) $discount += array_sum( $order->coupon->discount_tax );
            //determine the display type (with or without the minus sign):
            $display_type = ( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_TYPE == 'true' ? '-' : '' );
            $text = $display_type . $currencies->format( $discount, true, $order->info['currency'], $order->info['currency_value'] );
            //add debug text if debug is on:
            if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DEBUG == 'true' ) $text .= print_r( "\n\n<!-- Discount Coupons DEBUG\n".print_r( $order, true )."\nEnd Discount Coupons DEBUG-->\n\n", true );
            $this->output[] = array( 'title' => $order->coupon->format_display( $tax_group ) . ':',
                                     'text' => $text,
                                     'value' => $display_type . $discount );
          }
        }
        //determine if we need to display a second line to show tax no longer applied
        if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_TAX == 'Display discounted tax in separate line' && is_array( $order->coupon->discount_tax ) ) {
          $discounted_tax = array_sum( $order->coupon->discount_tax );
          $text = $display_type . $currencies->format( $discounted_tax, true, $order->info['currency'], $order->info['currency_value'] );
          $this->output[] = array( 'title' => MODULE_ORDER_TOTAL_DISCOUNT_COUPON_TAX_NOT_APPLIED . ':',
                                   'text' => $text,
                                   'value' => $display_type . $discounted_tax );
        }
      } else $this->enabled = false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array( 'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_STATUS',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_SORT_ORDER',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_TYPE',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_SUBTOTAL',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_TAX',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_EXCLUDE_SPECIALS',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_RANDOM_CODE_LENGTH',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_LINES',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_ALLOW_NEGATIVE',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_USE_LANGUAGE_FILE',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_CONFIG',
                    'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DEBUG');
    }

    function install() {

      tep_db_query("insert into " . TABLE_CONFIGURATION . "
                      (configuration_title,
                       configuration_key,
                       configuration_value,
                       configuration_description,
                       configuration_group_id,
                       sort_order,
                       set_function,
                       date_added)
                      values
                      ('Enable discount coupon?',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_STATUS',
                       'true',
                       '',
                       '615',
                       '1',
                       'tep_cfg_select_option(array(\'true\', \'false\'), ',
                       now()),
                      ('Sort Order',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_SORT_ORDER',
                       '0',
                       'Order in which the discount coupon code order total line will be displayed on order confirmation, invoice, etc.',
                       '615',
                       '2',
                       '',
                       now()),
                      ('Display discount with minus (-) sign?',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_TYPE',
                       'true',
                       '<b>true</b> - the discount will be displayed with a minus sign<br><b>false</b> - the discount will be displayed without a minus sign',
                       '615',
                       '3',
                       'tep_cfg_select_option(array(\'true\', \'false\'), ',
                       now()),
                      ('Display subtotal with applied discount?',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_SUBTOTAL',
                       'true',
                       '<b>true</b> - the order subtotal will be displayed with the discount applied<br><b>false</b> - the order subtotal will be displayed without the discount applied',
                       '615',
                       '4',
                       'tep_cfg_select_option(array(\'true\', \'false\'), ',
                       now()),
                      ('Display tax in discount line?',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_TAX',
                       'None',
                       'Select the method for displaying tax in the discount line.',
                       '615',
                       '5',
                       'tep_cfg_select_option(array(\'None\', \'Display discounted tax in separate line\', \'Display discount with discounted tax applied\'), ',
                       now()),
                      ('Exclude product specials?',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_EXCLUDE_SPECIALS',
                       'true',
                       '<b>true</b> - products with active specials will be excluded from discounts<br><b>false</b> - products with active specials will NOT be excluded from discounts',
                       '615',
                       '6',
                       'tep_cfg_select_option(array(\'true\', \'false\'), ',
                       now()),
                      ('Random Code Length',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_RANDOM_CODE_LENGTH',
                       '6',
                       'Length for randomly generated coupon codes.',
                       '615',
                       '7',
                       '',
                       now()),
                      ('Display discount total lines for each tax group?',
                       'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_LINES',
                       'false',
                       '<b>true</b> - the discount coupon order total lines will be displayed for each tax group for the order<br><b>false</b> - the discount order total lines will be combined and displayed as one line',
                       '615',
                       '8',
                       'tep_cfg_select_option(array(\'true\', \'false\'), ',
                       now()),
                      ('Allow negative order total?',
                        'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_ALLOW_NEGATIVE',
                        'false',
                        'Set to true if you want negative order totals when the discount is greater than the order total.',
                        '615',
                        '9',
                        'tep_cfg_select_option(array(\'true\', \'false\'), ',
                        now()),
                       ('Use the language file to format display string?',
                        'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_USE_LANGUAGE_FILE',
                        'false',
                        '<b>true</b> - use the format found in language file (used for when you have multiple languages and want the order total line to format display depending on language choice)<br><b>false</b> - use the format and language below',
                        '615',
                        '10',
                        'tep_cfg_select_option(array(\'true\', \'false\'), ',
                        now()),
                       ('Display Format for Order Total Line',
                        'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_CONFIG',
                        'Discount Coupon [code] applied',
                        'Display format for the discount coupon code order total line.<br><br>Variables:<br>[code]<br>[coupon_desc]<br>[discount_amount]<br>[min_order]<br>[number_available]<br>[tax_desc]',
                        '615',
                        '11',
                        '',
                        now()),
                       ('Debug Mode',
                        'MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DEBUG',
                        'false',
                        'To use: on checkout confirmation page, View Source in browser for debug output. <b>This must be set to false for live shops or error messages will not display.</b>',
                        '615',
                        '12',
                        'tep_cfg_select_option(array(\'true\', \'false\'), ',
                        now())");

      tep_db_query("CREATE TABLE IF NOT EXISTS discount_coupons (
                      coupons_id VARCHAR(32) NOT NULL DEFAULT '',
                      coupons_description VARCHAR(64) NOT NULL DEFAULT '',
                      coupons_discount_amount DECIMAL(15,12) NOT NULL DEFAULT '0.0000',
                      coupons_discount_type ENUM ('fixed','percent','shipping') NOT NULL DEFAULT 'percent',
                      coupons_date_start DATETIME DEFAULT NULL,
                      coupons_date_end DATETIME DEFAULT NULL,
                      coupons_max_use INT(3) NOT NULL DEFAULT 0,
                      coupons_min_order DECIMAL(15,4) NOT NULL DEFAULT '0.0000',
                      coupons_min_order_type ENUM('price','quantity') DEFAULT 'price',
                      coupons_number_available INT(3) NOT NULL DEFAULT 0,
                      PRIMARY KEY  (coupons_id)
                    )");

      tep_db_query("CREATE TABLE IF NOT EXISTS discount_coupons_to_orders (
                      coupons_id VARCHAR(32) NOT NULL DEFAULT '',
                      orders_id INT(11) DEFAULT '0',
                      PRIMARY KEY  (coupons_id,orders_id)
                    )");

      tep_db_query("CREATE TABLE IF NOT EXISTS discount_coupons_to_categories (
                      coupons_id VARCHAR(32) NOT NULL DEFAULT '',
                      categories_id INT(11) NOT NULL DEFAULT '0',
                      PRIMARY KEY  (coupons_id,categories_id)
                    )");

      tep_db_query("CREATE TABLE IF NOT EXISTS discount_coupons_to_products (
                      coupons_id VARCHAR(32) NOT NULL DEFAULT '',
                      products_id INT(11) NOT NULL DEFAULT '0',
                      PRIMARY KEY  (coupons_id,products_id)
                    )");

      tep_db_query("CREATE TABLE IF NOT EXISTS discount_coupons_to_manufacturers (
                      coupons_id VARCHAR(32) NOT NULL DEFAULT '',
                      manufacturers_id INT(11) NOT NULL DEFAULT '0',
                      PRIMARY KEY  (coupons_id,manufacturers_id)
                    )");

      tep_db_query("CREATE TABLE IF NOT EXISTS discount_coupons_to_customers (
                      coupons_id VARCHAR(32) NOT NULL DEFAULT '',
                      customers_id INT(11) NOT NULL DEFAULT '0',
                      PRIMARY KEY  (coupons_id,customers_id)
                    )");

      tep_db_query("CREATE TABLE IF NOT EXISTS discount_coupons_to_zones (
                      coupons_id VARCHAR(32) NOT NULL DEFAULT '',
                      geo_zone_id INT(11) NOT NULL DEFAULT '0',
                      PRIMARY KEY  (coupons_id,geo_zone_id)
                    )");

    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>
