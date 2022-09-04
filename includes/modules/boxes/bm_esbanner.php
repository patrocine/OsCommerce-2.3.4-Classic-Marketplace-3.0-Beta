<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_esbanner {
    var $code = 'bm_esbanner';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_esbanner() {
      $this->title = MODULE_BOXES_ESBANNER_TITLE;
      $this->description = MODULE_BOXES_ESBANNER_DESCRIPTION;

      if ( defined('MODULE_BOXES_ESBANNER_STATUS') ) {
        $this->sort_order = MODULE_BOXES_ESBANNER_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_ESBANNER_STATUS == 'True');

        $this->group = ((MODULE_BOXES_ESBANNER_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }




    function execute() {
      global $oscTemplate;




         
  $empresa_banner = '<p align="center"><div class="banner-53f856ff9e897" style="width: 120px; height: 600px; padding: 0px; background-color: gray;"><a href="http://www.esbanner.com" target="_blank" class="link-53f856ff9e897" style="display: block; width: 100%; height: 100%; color: white; background-color: black; text-align: center; text-decoration: none; font-family: sans-serif; font-size: 13px;">intercambio banners</a> </div> <script src="http://www.esbanner.com/script/block/53f856ff9e897" type="text/javascript"></script>';


              
              
              
              
	  $infobox = new azInfoBox();
      $infobox->azSetBoxHeading(MODULE_BOXES_ESBANNER_BOX_TITLE);
      $infobox->azSetBoxContent($empresa_banner);
      $infobox->azSetBoxFooter();
      $data = $infobox->azCreateBox('', '', '', '', false);
              
              

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_ESBANNER_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable ESBANNER Module', 'MODULE_BOXES_ESBANNER_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_ESBANNER_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_ESBANNER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_ESBANNER_STATUS', 'MODULE_BOXES_ESBANNER_CONTENT_PLACEMENT', 'MODULE_BOXES_ESBANNER_SORT_ORDER');
    }
  }
?>
