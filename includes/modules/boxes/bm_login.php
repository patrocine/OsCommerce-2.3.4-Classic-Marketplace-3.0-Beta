<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_login {
    var $code = 'bm_login';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $my_account_links;
    var $greeting;
    var $name_display;
    var $version = '1.2.0';

    function bm_login() {
      $this->title = MODULE_BOXES_LOGIN_TITLE . ' ' . $this->version;
      $this->description = MODULE_BOXES_LOGIN_DESCRIPTION;

      if ( defined('MODULE_BOXES_LOGIN_STATUS') ) {
        $this->sort_order = MODULE_BOXES_LOGIN_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_LOGIN_STATUS == 'True');
        $this->my_account_links = MODULE_BOXES_LOGIN_ACCOUNT_LINKS;
        $this->greeting = MODULE_BOXES_LOGIN_GREETING;
        $this->name_display = MODULE_BOXES_LOGIN_NAME_DISPLAY;

        $this->group = ((MODULE_BOXES_LOGIN_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function lbfile_array() {
      return array(FILENAME_CREATE_ACCOUNT, FILENAME_LOGIN, FILENAME_PASSWORD_FORGOTTEN, FILENAME_PASSWORD_RESET);
    }

    function execute() {
      global $PHP_SELF, $customer_id, $customer_first_name, $customer_last_name, $oscTemplate;

      if (!tep_session_is_registered('customer_id')) {
        if (!in_array(basename($PHP_SELF), $this->lbfile_array())) {
          $data = '    ' . tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL'), 'post', '', true) .
                  '    ' . '<span style="float: left">' . MODULE_BOXES_LOGIN_BOX_EMAIL_ADDRESS . '</span><br />' . tep_draw_input_field('email_address', '', 'size="10" style="width: 90%"') . '<br /><span style="float: left">' . MODULE_BOXES_LOGIN_BOX_PASSWORD . '</span><br />' . tep_draw_password_field('password', '', 'size="10" style="width: 90%"') . '<br />' . tep_draw_button(IMAGE_BUTTON_LOGIN, 'key', null, 'primary') . '<br /><a href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_PASSWORD_FORGOTTEN . '</a><br /><a href="' . tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_NEW_ACCOUNT . '</a>';


                  $infobox = new azInfoBox();
      $infobox->azSetBoxHeading(MODULE_BOXES_LOGIN_BOX_ACCOUNT_TITLE);
      $infobox->azSetBoxContent($data);
      $infobox->azSetBoxFooter();
      $data = $infobox->azCreateBox('', '', '', '', false);

      $oscTemplate->addBlock($data, $this->group);
        }
      } elseif (tep_session_is_registered('customer_id')) {
        if ($this->my_account_links == 'True') {
          if (tep_session_is_registered('customer_first_name') && tep_session_is_registered('customer_last_name')) {
            switch ($this->name_display) {
              case 'First':
                $lbname_display = $customer_first_name;
                break;
              case 'Last':
                $lbname_display = $customer_last_name;
                break;
              case 'Both':
                $lbname_display = $customer_first_name . ' ' . $customer_last_name;
                break;
              case 'None':
                $lbname_display = '';
                break;
              default:
                $lbname_display = $customer_first_name;
                break;
            }
          } else {
            $lbname_display = '';
          }

          $data = (($this->greeting == 'True') ? '  <strong>' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_TEXT . tep_output_string_protected($lbname_display) . '</strong><br />' : '') .
                  '    <a href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_INFORMATION . '</a><br />' .
                  '    <a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_ADDRESS_BOOK . '</a><br />' .
                  '    <a href="' . tep_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_PASSWORD . '</a><br />' .
                  '    <a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_ORDERS_VIEW . '</a><br />' .
                  '    <a href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a><br />' .
                  '    <a href="' . tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_EMAIL_NOTIFICATIONS_PRODUCTS . '</a><br />' .
                  '    <a href="' . tep_href_link(FILENAME_LOGOFF, '', 'SSL') . '">' . MODULE_BOXES_LOGIN_BOX_ACCOUNT_LOGOFF . '</a>' ;

               $infobox = new azInfoBox();
      $infobox->azSetBoxHeading(MODULE_BOXES_LOGIN_BOX_ACCOUNT_TITLE);
      $infobox->azSetBoxContent($data);
      $infobox->azSetBoxFooter();
      $data = $infobox->azCreateBox('', '', '', '', false);

      $oscTemplate->addBlock($data, $this->group);
        }
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_LOGIN_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Login Box Module', 'MODULE_BOXES_LOGIN_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display My Account Links', 'MODULE_BOXES_LOGIN_ACCOUNT_LINKS', 'True', 'Do you want to display the my account links?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Greeting', 'MODULE_BOXES_LOGIN_GREETING', 'True', 'Do you want to display the welcome greeting?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Name', 'MODULE_BOXES_LOGIN_NAME_DISPLAY', 'First', 'How do you want the name to be displayed in the welcome greeting?', '6', '1', 'tep_cfg_select_option(array(\'First\', \'Last\', \'Both\', \'None\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_LOGIN_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_LOGIN_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_LOGIN_STATUS', 'MODULE_BOXES_LOGIN_ACCOUNT_LINKS', 'MODULE_BOXES_LOGIN_GREETING', 'MODULE_BOXES_LOGIN_NAME_DISPLAY', 'MODULE_BOXES_LOGIN_CONTENT_PLACEMENT', 'MODULE_BOXES_LOGIN_SORT_ORDER');
    }
  }
?>
