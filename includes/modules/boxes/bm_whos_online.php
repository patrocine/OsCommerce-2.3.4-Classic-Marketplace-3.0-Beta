<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_whos_online {
    var $code = 'bm_whos_online';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_whos_online() {
      $this->title = MODULE_BOXES_WHOS_ONLINE_TITLE;
      $this->description = MODULE_BOXES_WHOS_ONLINE_DESCRIPTION;

      if ( defined('MODULE_BOXES_WHOS_ONLINE_STATUS') ) {
        $this->sort_order = MODULE_BOXES_WHOS_ONLINE_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_WHOS_ONLINE_STATUS == 'True');

        $this->group = ((MODULE_BOXES_WHOS_ONLINE_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;



 $n_members=0;$n_guests=0;$member_list='';

$whos_online_query = tep_db_query("select customer_id from " . TABLE_WHOS_ONLINE);
while ($whos_online = tep_db_fetch_array($whos_online_query)) {
  if (!$whos_online['customer_id'] == 0) {
     $n_members++;
     $member = tep_db_fetch_array(tep_db_query("select customers_firstname from ".TABLE_CUSTOMERS." where customers_id = '".$whos_online['customer_id']."'"));
     $member_list .= (($n_members > 1)?', ':'');
     }
   if ($whos_online['customer_id'] == 0) $n_guests++;
   }

$user_total = sprintf(tep_db_num_rows($whos_online_query));
$there_is_are = (($user_total == 1)? BOX_WHOS_ONLINE_THEREIS:BOX_WHOS_ONLINE_THEREARE);
$word_guest = ' '.(($n_guests == 1)? BOX_WHOS_ONLINE_GUEST:BOX_WHOS_ONLINE_GUESTS);
$word_member = ' ' .(($n_members == 1)? BOX_WHOS_ONLINE_MEMBER:BOX_WHOS_ONLINE_MEMBERS);
if (($n_guests >= 1) && ($n_members >= 1)) $word_and = ' ' . BOX_WHOS_ONLINE_AND . ' ';

$textstring = $there_is_are.'';
if ($n_guests >= 1) $textstring .= ' '.$n_guests . $word_guest;

$textstring .= $word_and;
if ($n_members >= 1) {
  $textstring .= ' '. $n_members . $word_member;
  if ((WHOS_ONLINE_LIST=='ja') || (WHOS_ONLINE_LIST=='yes')) $textstring .= ' '.$member_list.'';
  }
$textstring .= ' online.';











      $infobox = new azInfoBox();
      $infobox->azSetBoxHeading('Qien Esta Online');
      $infobox->azSetBoxContent($textstring);
      $infobox->azSetBoxFooter();
      $data = $infobox->azCreateBox('', '', '', '', false);

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_WHOS_ONLINE_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Information Module', 'MODULE_BOXES_WHOS_ONLINE_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_WHOS_ONLINE_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_WHOS_ONLINE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_WHOS_ONLINE_STATUS', 'MODULE_BOXES_WHOS_ONLINE_CONTENT_PLACEMENT', 'MODULE_BOXES_WHOS_ONLINE_SORT_ORDER');
    }
  }
?>
