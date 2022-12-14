<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_shopping_cart {
    var $code = 'bm_shopping_cart';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_shopping_cart() {
      $this->title = MODULE_BOXES_SHOPPING_CART_TITLE;
      $this->description = MODULE_BOXES_SHOPPING_CART_DESCRIPTION;

      if ( defined('MODULE_BOXES_SHOPPING_CART_STATUS') ) {
        $this->sort_order = MODULE_BOXES_SHOPPING_CART_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_SHOPPING_CART_STATUS == 'True');

        $this->group = ((MODULE_BOXES_SHOPPING_CART_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $cart, $new_products_id_in_cart, $currencies, $oscTemplate;

      $cart_contents_string = '';

      if ($cart->count_contents() > 0) {
        $cart_contents_string = '<table border="0" width="100%" cellspacing="0" cellpadding="0" class="ui-widget-content infoBoxContents">';
        $products = $cart->get_products();
        for ($i=0, $n=sizeof($products); $i<$n; $i++) {
          $cart_contents_string .= '<tr><td align="right" valign="top">';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '<span class="newItemInCart">';
          }

          $cart_contents_string .= $products[$i]['quantity'] . '&nbsp;x&nbsp;';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '</span>';
          }

          $cart_contents_string .= '</td><td valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '<span class="newItemInCart">';
          }

          $cart_contents_string .= $products[$i]['name'];

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '</span>';
          }

          $cart_contents_string .= '</a></td></tr>';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            tep_session_unregister('new_products_id_in_cart');
          }
        }

#### Points/Rewards Module V2.1beta BOF ####
  if (USE_REDEEM_SYSTEM == 'true') {
	  $has_points = tep_get_shopping_points($customer_id);
	  if ($has_points > 0) {
		  $cust_points = '<table cellpadding="0" width="100%" cellspacing="0" border="0"><tr><td align="center" class="smalltext"><b><a href="' . tep_href_link(FILENAME_MY_POINTS, '', 'SSL') . '">'. TEXT_POINTS_BALANCE . '</a></b></tr></td><tr><td class="smalltext" align="right" valign="bottom">' . TEXT_POINTS .'&nbsp;'. number_format($has_points,POINTS_DECIMAL_PLACES) .'</tr></td><tr><td class="smalltext" align="right" valign="bottom">' .  TEXT_VALUE . $currencies->format(tep_calc_shopping_pvalue($has_points)) . '</td></tr></table>';
	  }
  }

$cart_contents_string .= '<tr><td colspan="2" style="padding-top: 5px; padding-bottom: 2px;">' . tep_draw_separator() . '</td></tr>' .
			 '<tr><td colspan="2" align="right">' . $currencies->format($cart->show_total()) . '</td></tr>' .
			 '</table>'.$cust_points;
#### Points/Rewards Module V2.1beta EOF ####

      } else {
        $cart_contents_string .= '<div class="ui-widget-content infoBoxContents">' . MODULE_BOXES_SHOPPING_CART_BOX_CART_EMPTY . '</div>';
      }

      /*$data = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="ui-widget-header infoBoxHeading"><a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . MODULE_BOXES_SHOPPING_CART_BOX_TITLE . '</a></div>' .
              '  ' . $cart_contents_string .
              '</div>';*/

      $infobox = new azInfoBox();
      $infobox->azSetBoxHeading(MODULE_BOXES_SHOPPING_CART_BOX_TITLE, tep_href_link(FILENAME_SHOPPING_CART));
      $infobox->azSetBoxContent($cart_contents_string);
      $infobox->azSetBoxFooter();
      $data = $infobox->azCreateBox('', '', '', '', false);

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_SHOPPING_CART_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Shopping Cart Module', 'MODULE_BOXES_SHOPPING_CART_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_SHOPPING_CART_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_SHOPPING_CART_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_SHOPPING_CART_STATUS', 'MODULE_BOXES_SHOPPING_CART_CONTENT_PLACEMENT', 'MODULE_BOXES_SHOPPING_CART_SORT_ORDER');
    }
  }
?>
