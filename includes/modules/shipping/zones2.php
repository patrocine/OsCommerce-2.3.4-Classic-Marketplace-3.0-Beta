<?php
/*
May 03 2004 1:45 CST
******************Coding Monkey Update*******************
*                                                       *
*  This script has now been updated to do flat and      *
*  percentage based shipping i.e.                       *
*                                                       *
*  3:8.50,500:13%,99999:20.00                           *
*                                                       *
*  This means that anything up to three dollars or      *
*  pounds = $8.50 upto 500 $ or pounds = 13% of total   *
*  99999 lbs or $ = $20.00                              *
*                                                       *
*  You can have as many percentage or flat setting as   *
*  you wish                                             *
*                                                       *
*  I have not updated any of the other info someone     *
*  else can if they wish or I may do it later.          * 
*                                                       *
*********************************************************

  $Id: zones.php,v 1.20 2003/06/15 19:48:09 thomasamoulton Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  USAGE
  By default, the module comes with support for 1 zone.  This can be
  easily changed by editing the line below in the zones constructor 
  that defines $this->num_zones.

  Next, you will want to activate the module by going to the Admin screen,
  clicking on Modules, then clicking on Shipping.  A list of all shipping
  modules should appear.  Click on the green dot next to the one labeled 
  zones.php.  A list of settings will appear to the right.  Click on the
  Edit button. 

  PLEASE NOTE THAT YOU WILL LOSE YOUR CURRENT SHIPPING RATES AND OTHER 
  SETTINGS IF YOU TURN OFF THIS SHIPPING METHOD.  Make sure you keep a 
  backup of your shipping settings somewhere at all times.

  If you want an additional handling charge applied to orders that use this
  method, set the Handling Fee field.

  Next, you will need to define which countries are in each zone.  Determining
  this might take some time and effort.  You should group a set of countries
  that has similar shipping charges for the same weight.  For instance, when
  shipping from the US, the countries of Japan, Australia, New Zealand, and 
  Singapore have similar shipping rates.  As an example, one of my customers
  is using this set of zones:
    1: USA
    2: Canada
    3: Austria, Belgium, Great Britain, France, Germany, Greenland, Iceland,
       Ireland, Italy, Norway, Holland/Netherlands, Denmark, Poland, Spain,
       Sweden, Switzerland, Finland, Portugal, Israel, Greece
    4: Japan, Australia, New Zealand, Singapore
    5: Taiwan, China, Hong Kong

  When you enter these country lists, enter them into the Zone X Countries
  fields, where "X" is the number of the zone.  They should be entered as
  two character ISO country codes in all capital letters.  They should be
  separated by commas with no spaces or other punctuation. For example:
    1: US
    2: CA
    3: GB,FR,DE,NL,JP
    4: JP,AU,NZ,SG
    5: TW,CN,HK

  Now you need to set up the shipping rate tables for each zone.  Again,
  some time and effort will go into setting the appropriate rates.  You
  will define a set of weight ranges and the shipping price for each
  range.  For instance, you might want an order than weighs more than 0
  and less than or equal to 3 to cost 5.50 to ship to a certain zone.  
  This would be defined by this:  3:5.5

  You should combine a bunch of these rates together in a comma delimited
  list and enter them into the "Zone X Shipping Table" fields where "X" 
  is the zone number.  For example, this might be used for Zone 1:
    1:3.5,2:3.95,3:5.2,4:6.45,5:7.7,6:10.4,7:11.85, 8:13.3,9:14.75,10:16.2,11:17.65,
    12:19.1,13:20.55,14:22,15:23.45

  The above example includes weights over 0 and up to 15.  Note that
  units are not specified in this explanation since they should be
  specific to your locale.

  CAVEATS
  At this time, it does not deal with weights that are above the highest amount
  defined.  This will probably be the next area to be improved with the
  module.  For now, you could have one last very high range with a very
  high shipping rate to discourage orders of that magnitude.  For 
  instance:  999:1000

  If you want to be able to ship to any country in the world, you will 
  need to enter every country code into the Country fields. For most
  shops, you will not want to enter every country.  This is often 
  because of too much fraud from certain places. If a country is not
  listed, then the module will add a $0.00 shipping charge and will
  indicate that shipping is not available to that destination.  
  PLEASE NOTE THAT THE ORDER CAN STILL BE COMPLETED AND PROCESSED!

  It appears that the osC shipping system automatically rounds the 
  shipping weight up to the nearest whole unit.  This makes it more
  difficult to design precise shipping tables.  If you want to, you 
  can hack the shipping.php file to get rid of the rounding.

  Lastly, there is a limit of 255 characters on each of the Zone
  Shipping Tables and Zone Countries. 

*/

  class zones2 {
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function zones2() {
      $this->code = 'zones2';

      $this->title = MODULE_ENVIO_TRANSFERENCIA;
      $this->description = MODULE_SHIPPING_ZONES2_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_ZONES2_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_ZONES2_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_ZONES2_STATUS == 'True') ? true : false);

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_zones = 10;
    }

// class methods
    function quote($method = '') {
      global $order, $cart, $shipping_weight, $shipping_num_boxes;
      
      if (MODULE_SHIPPING_ZONES2_MODE == 'price') {
        $order_total = $cart->show_total();
      } else {
        $order_total = $shipping_weight;
      }

      $dest_country = $order->delivery['country']['iso_code_2'];
      $dest_zone = 0;
      $error = false;

      for ($i=1; $i<=$this->num_zones; $i++) {
        $countries_table = constant('MODULE_SHIPPING_ZONES2_COUNTRIES_' . $i);
        $country_zones = split("[,]", $countries_table);
        if (in_array($dest_country, $country_zones)) {
          $dest_zone = $i;
          break;
        }
      }

      if ($dest_zone == 0) {
        $error = true;
      } else {
        $shipping = -1;
        $zones_cost = constant('MODULE_SHIPPING_ZONES2_COST_' . $dest_zone);

        $zones_table = split("[:,]" , $zones_cost);
        $size = sizeof($zones_table);
        for ($i=0; $i<$size; $i+=2) {
          if ($order_total <= $zones_table[$i]) {
            $shipping = $zones_table[$i+1];
            $shipping_method = constant('MODULE_SHIPPING_ZONES2_TITLE_' . $dest_zone);
            if (MODULE_SHIPPING_ZONES2_MODE == 'weight') 
            	$shipping_method .= " : " . $shipping_weight . ' ' . MODULE_SHIPPING_ZONES2_TEXT_UNITS;
            break;
          }
        }

        if ($shipping == -1) {
          $shipping_cost = 0;
          $shipping_method = MODULE_SHIPPING_ZONES2_UNDEFINED_RATE;
        } else {

		 
		  
		  
		  //edited by the thecodingmonkey


          if (strpos($shipping, "%") === false) {
	      $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_ZONES2_HANDLING_' . $dest_zone);
         } else {
         $shipcost = (str_replace("%","",$shipping));
         $shipping_cost = ($order_total * $shipcost) + constant('MODULE_SHIPPING_ZONES2_HANDLING_' . $dest_zone);
          }






  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

     $wersdf_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $order->products[$i]['id'] . "'");
    while ($wersdf = mysql_fetch_array($wersdf_values)){

    $products_extrapeso_precio =  $wersdf['products_extrapeso_precio'];
                                                    }
}


        //edited
        }
      }

      $envi = $cart->show_total();
 if   ($envi >= MINIMO_GASTOS_DE_ENVIO_GRATIS){


       $envio_incluido =  0;

}else{

     $envio_incluido =  $shipping_cost + $products_extrapeso_precio;
}//fin autorizado


      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_ENVIO_TRANSFERENCIA,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $shipping_method,
                                                     'cost' => $envio_incluido)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_ZONES2_INVALID_ZONE;

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_ZONES2_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Zones Method', 'MODULE_SHIPPING_ZONES2_STATUS', 'True', 'Do you want to offer zone rate shipping?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_SHIPPING_ZONES2_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_ZONES2_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Table Method', 'MODULE_SHIPPING_ZONES2_MODE', 'weight', 'The shipping cost is based on the order total or the total weight of the items ordered.', '6', '0', 'tep_cfg_select_option(array(\'weight\', \'price\'), ', now())");

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Nombre del Modo de Envio', 'MODULE_ENVIO_TRANSFERENCIA', 'Transferencia, Paypal, Tarjeta, BitCoin', 'Titulo del Modo de envio. para esta tabla de tarifas', '6', '0', now())");

      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = 'ES';
        if ($i == 1) {
          $default_countries = 'US';
        } else if ($i == 2) {
          $default_countries = 'CA';
        }
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone " . $i ." Countries', 'MODULE_SHIPPING_ZONES2_COUNTRIES_" . $i ."', '" . $default_countries . "', 'Comma separated list of two character ISO country codes that are part of Zone " . $i . ".', '6', '0', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone " . $i ." Shipping Method Name', 'MODULE_SHIPPING_ZONES2_TITLE_" . $i ."', 'Delibery" . $default_countries . "', 'Description of this shipping method shown during checkout. ie. UPS Ground', '6', '0', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone " . $i ." Shipping Table', 'MODULE_SHIPPING_ZONES2_COST_" . $i ."', '0.01:0.00,0.10:5.00,0.20:05.00,0.35:5.50,1.00:7.20,2.00:7.50,5.00:9.60,10.00:9.00,15.00:11.00,20.00:14.00,25.00:15.50,30.00:21.00,35.00:25.00,40.00:30.00,50.00:40.00,60.00:50.00,70.00:60.00,80.00:70.00,90.00:80.00,100.00:90.00,200.00:150.00', 'Shipping rates to Zone " . $i . " destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone " . $i . " destinations.', '6', '0', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone " . $i ." Handling Fee', 'MODULE_SHIPPING_ZONES2_HANDLING_" . $i."', '0', 'Handling Fee for this shipping zone', '6', '0', now())");
      }
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_ZONES2_STATUS', 'MODULE_ENVIO_TRANSFERENCIA', 'MODULE_SHIPPING_ZONES2_MODE', 'MODULE_SHIPPING_ZONES2_TAX_CLASS', 'MODULE_SHIPPING_ZONES2_SORT_ORDER');

      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_ZONES2_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_ZONES2_TITLE_' . $i;
        $keys[] = 'MODULE_SHIPPING_ZONES2_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_ZONES2_HANDLING_' . $i;
      }

      return $keys;
    }
  }
?>
