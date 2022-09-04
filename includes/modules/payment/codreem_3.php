<?php
/*
  $Id: cod.php,v 1.28 2003/02/14 05:51:31 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class codreem_3 {
    var $code, $title, $description, $enabled;

// class constructor
    function codreem_3() {
      global $order;
  //  $address_books_values = mysql_query("select * from " . ' address_book' . " where customers_id = '" . $order->delivery['custo'] . "' and entry_city like '%" . 'orotava' . "%'");
// IF ( $address_books = mysql_fetch_array($address_books_values)){

// }else{
      $this->code = 'codreem_3';
      $this->title = MODULES_RECOGER_TIENDA_3;
      $this->description = MODULES_RECOGER_TIENDA_3;
      $this->sort_order = MODULE_PAYMENT_CODREEM_3_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_CODREEM_3_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_CODREEM_3_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_CODREEM_3_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
//    }
}
// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_CODREEM_3_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_CODREEM_3_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }

// disable the module if the order only contains virtual products
      if ($this->enabled == true) {
        if ($order->content_type == 'virtual') {
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
      return false;
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
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_CODREEM_3_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Cash On Delivery Module', 'MODULE_PAYMENT_CODREEM_3_STATUS', 'True', 'Do you want to accept Cash On Delevery payments?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', 'MODULE_PAYMENT_CODREEM_3_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_CODREEM_3_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_CODREEM_3_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Titulo del modo de pago', 'MODULES_RECOGER_TIENDA_3', 'Recoger en Tienda 3', 'Titulo modo de pago 9', '6', '0', now())");
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Email', 'RECOGER_TIENDA_EMAIL_3', 'tienda3@gmail.com', 'Si el cliente selecciona este metodo de envio, el sistema enviara una copia del pedido a este correo.', '6', '0', now())");

      }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_CODREEM_3_STATUS', 'MODULES_RECOGER_TIENDA_3' , 'MODULE_PAYMENT_CODREEM_3_ZONE', 'MODULE_PAYMENT_CODREEM_3_ORDER_STATUS_ID', 'MODULE_PAYMENT_CODREEM_3_SORT_ORDER', 'RECOGER_TIENDA_EMAIL_3');
    }
  }
?>
