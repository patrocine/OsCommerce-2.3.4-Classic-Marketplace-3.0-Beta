<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_mobile_version {
    var $code = 'bm_mobile_version';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_mobile_version() {
      $this->title = MODULE_BOXES_MOBILE_VERSION_TITLE;
      $this->description = MODULE_BOXES_MOBILE_VERSION_DESCRIPTION;

      if ( defined('MODULE_BOXES_MOBILE_VERSION_STATUS') ) {
        $this->sort_order = MODULE_BOXES_MOBILE_VERSION_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_MOBILE_VERSION_STATUS == 'True');

        $this->group = ((MODULE_BOXES_MOBILE_VERSION_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate, $mobile_url;
      if (!tep_session_is_registered('language') || isset($HTTP_GET_VARS['language'])) {
      	      $mobile_url .= (strpos($mobile_url,'language=') > 0) ? '' : ((strpos($mobile_url,'?') > 0) ? '&language=' . $current_lang_key : '?language=' . $current_lang_key ) ;
      }
      $mobile_version_link = '<a href="' . $mobile_url . '">' . tep_image(DIR_WS_IMAGES . 'icons/iphone_logo.gif') . '</a>' ;

      $data = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_MOBILE_VERSION_BOX_TITLE . '</div>' .
              '  <div class="ui-widget-content infoBoxContents"><center>' .
                 $mobile_version_link . '<br />' .
              '  </div>' .
              '</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_MOBILE_VERSION_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Mobile Version Module', 'MODULE_BOXES_MOBILE_VERSION_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_MOBILE_VERSION_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_MOBILE_VERSION_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_MOBILE_VERSION_STATUS', 'MODULE_BOXES_MOBILE_VERSION_CONTENT_PLACEMENT', 'MODULE_BOXES_MOBILE_VERSION_SORT_ORDER');
    }
  }
?>