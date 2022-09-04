<?php
/*
  $Id: btc.php,v 1.0 2014/01/25 13:49

  for CRE Loaded & OSCommerce
  by Marc Rogivue www.KULTUhR.net marc@rogivue.com
  If this Module is helpful to you, please consider to pay me a drink, or two: 
  My BTC address 17KRpq5u2GaStjiF2h3Vja9VvKwVnC3THD
  
  Released under the GNU General Public License
*/

  class btc {
    var $code, $title, $description, $enabled;

// class constructor
    function btc() {
      global $order;

      $this->code = 'btc';
      $this->title = MODULE_PAGO_BTC;
      if (defined('MODULE_PAYMENT_BTC_TEXT_DESCRIPTION')) {
        $this->description = MODULE_PAYMENT_BTC_TEXT_DESCRIPTION;
      } else {
        $this->description = '';
      }
      if (defined('MODULE_PAYMENT_BTC_SORT_ORDER')) {
        $this->sort_order = (int)MODULE_PAYMENT_BTC_SORT_ORDER;
      } else {
        $this->sort_order = '';
      }

      if (defined('MODULE_PAYMENT_BTC_STATUS')) {
        $this->enabled = ((MODULE_PAYMENT_BTC_STATUS == 'True') ? true : false);
      } else {
        $this->enabled = false;
      }

      if (defined('MODULE_PAYMENT_BTC_ORDER_STATUS_ID')) {
        if ((int)MODULE_PAYMENT_BTC_ORDER_STATUS_ID > 0) {
          $this->order_status = MODULE_PAYMENT_BTC_ORDER_STATUS_ID;
        }
      } else {
        $this->order_status = 0;
      }

      if (is_object($order)) $this->update_status();

      if (defined('MODULE_PAYMENT_BTC_TEXT_EMAIL_FOOTER')) {
        $this->email_footer = MODULE_PAYMENT_BTC_TEXT_EMAIL_FOOTER;
      } else {
        $this->email_footer = '';
      }
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_BTC_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_BTC_ZONE . "' and ( zone_country_id = 0 or zone_country_id = '" . $order->billing['country']['id'] . "' ) order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return array('title' => MODULE_PAYMENT_BTC_TEXT_DESCRIPTION);
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BTC_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable BTC Module', 'MODULE_PAYMENT_BTC_STATUS', 'True', 'Do you want to accept Bitcoin payments?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Your BTC Address:', 'MODULE_PAYMENT_BTC_PAYTO', '0x7777fa5A15699f29083F55262a580E7bb4185B27', 'Who should payments be made payable to (Bitcoin Address)?', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('BTC Sort order of display.', 'MODULE_PAYMENT_BTC_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('BTC Payment Zone', 'MODULE_PAYMENT_BTC_ZONE', '0', 'If a zone is selected, enable this payment method for that zone only.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('BTC Set Order Status', 'MODULE_PAYMENT_BTC_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Titulo BitCoin y Criptos', 'MODULE_PAGO_BTC', 'Pagar con BitCoin', 'Titulo BitCoin y Criptos', '6', '0', now())");
          }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_BTC_STATUS', 'MODULE_PAGO_BTC', 'MODULE_PAYMENT_BTC_ZONE', 'MODULE_PAYMENT_BTC_ORDER_STATUS_ID', 'MODULE_PAYMENT_BTC_SORT_ORDER', 'MODULE_PAYMENT_BTC_PAYTO');
    }
  }
?>
