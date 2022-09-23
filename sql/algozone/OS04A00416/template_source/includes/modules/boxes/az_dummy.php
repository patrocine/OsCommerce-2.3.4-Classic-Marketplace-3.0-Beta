<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class az_dummy {
    var $code = 'az_dummy';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function az_dummy() {
      $this->title = 'Dummy';
      $this->description = 'Can be removed after template layout installation';

      if ( defined('MODULE_BOXES_AZ_DUMMY_STATUS') ) {
        $this->sort_order = '0';
        $this->enabled = 'false';

        $this->group = 'boxes_column_left';
      }
    }

    function execute() {
      global $HTTP_GET_VARS, $current_category_id, $languages_id, $oscTemplate, $currencies;

      $data = '';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_AZ_DUMMY_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Dummy Module', 'MODULE_BOXES_AZ_DUMMY_STATUS', 'False', 'Do you want to add the module to your shop?', '6', '0', '', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_AZ_DUMMY_STATUS');
    }
  }