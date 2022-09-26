<?php
/*
  $Id: osCAffiliate 20-Nov-2014
  OSC-Affiliate for osCommerce 2.3xx family
  Contribution based on: http://addons.oscommerce.com/info/158
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 - 2014 osCommerce
  Released under the GNU General Public License
  Updated by Fimble (http://forums.oscommerce.com/user/15542-fimble/)
  http://www.linuxuk.co.uk
*/

  class bm_affiliate {
    var $code = 'bm_affiliate';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_affiliate() {
      $this->title = MODULE_BOXES_AFFILIATE_TITLE;
      $this->description = MODULE_BOXES_AFFILIATE_DESCRIPTION;

      if ( defined('MODULE_BOXES_AFFILIATE_STATUS') ) {
        $this->sort_order = MODULE_BOXES_AFFILIATE_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_AFFILIATE_STATUS == 'True');

        $this->group = ((MODULE_BOXES_AFFILIATE_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;
      if (tep_session_is_registered('affiliate_id')) {
      $data = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_BOX_HEADING_AFFILIATE . '</div>' .
              '  <div class="ui-widget-content infoBoxContents">' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_SUMMARY . '</a></strong><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_ACCOUNT . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_PASSWORD, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_PASSWORD . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTER, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_NEWSLETTER . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWS, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_NEWS . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_BANNERS . '</a></strong><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BANNERS, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_BANNERS_BANNERS . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BUILD, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_BANNERS_BUILD . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BUILD_CAT, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_BANNERS_BUILD_CAT . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_CATEGORY, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_BANNERS_CATEGORY . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_PRODUCT, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_BANNERS_PRODUCT . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_TEXT, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_BANNERS_TEXT . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_REPORTS, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_REPORTS . '</a></strong><br />' .
    		  '     <a href="' . tep_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'). '">' . MODULE_BOXES_AFFILIATE_CLICKRATE . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'). '">' . MODULE_BOXES_AFFILIATE_SALES . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'SSL'). '">' . MODULE_BOXES_AFFILIATE_PAYMENT . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_CONTACT, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_CONTACT . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_FAQ, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_FAQ . '</a><br />' .
              '     <a href="' . tep_href_link(FILENAME_AFFILIATE_LOGOUT). '">' . MODULE_BOXES_AFFILIATE_LOGOUT . '</a>' .
              '  </div>' .
              '</div>';

              }
              else   {
                   $data = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_AFFILIATE_BOX_TITLE . '</div>' .
              '  <div class="ui-widget-content infoBoxContents">' .
              '    <a href="' . tep_href_link(FILENAME_AFFILIATE, '', 'SSL') . '">' . MODULE_BOXES_AFFILIATE_LOGIN . '</a><br />'.
			  '    <a href="' . tep_href_link(FILENAME_AFFILIATE_INFO, '', 'NONSSL'). '">' . MODULE_BOXES_AFFILIATE_INFO . '</a><br />' .
              '    <a href="' . tep_href_link(FILENAME_AFFILIATE_FAQ, '', 'NONSSL') . '">' . MODULE_BOXES_AFFILIATE_FAQ . '</a>' .
              '  </div>' .
              '</div>';
                            }

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_AFFILIATE_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable AFFILIATE Module', 'MODULE_BOXES_AFFILIATE_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_AFFILIATE_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_AFFILIATE_SORT_ORDER', '1015', 'Sort order of display. Lowest is displayed first.', '6', '1015', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_AFFILIATE_STATUS', 'MODULE_BOXES_AFFILIATE_CONTENT_PLACEMENT', 'MODULE_BOXES_AFFILIATE_SORT_ORDER');
    }
  }
?>
