<?php 
/* $Id$
LoginRadius, Open Source E-Commerce Solutions
http://www.LoginRadius.com
Copyright (c) 2011 LoginRadius
Released under the GNU General Public License
*/
// needs to be included earlier to set the success message in the messageStack
  //require_once('includes/application_top.php');
  
  
  class bm_sociallogin {
    var $code = 'bm_sociallogin';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
	
	
/**
 * Class constructor.
 */
	function bm_sociallogin() {
      $this->title = MODULE_BOXES_SOCIALLOGIN_BOX_TITLE;
      $this->description = MODULE_BOXES_SOCIALLOGIN_DESCRIPTION;

      if ( defined('MODULE_BOXES_SOCIALLOGIN_STATUS') ) {
        $this->sort_order = MODULE_BOXES_SOCIALLOGIN_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_SOCIALLOGIN_STATUS == 'True');
		$this->group = ((MODULE_BOXES_SOCIALLOGIN_CONTENT_PLACEMENT == 'Left Column')?'boxes_column_left':'boxes_column_right');
      }
    }
	
/**
 * Class Function that that executing process of module.
 */
    function execute() {
	  global $oscTemplate, $customer_first_name, $customer_last_name, $lrsetting, $customer_picture, $SOCIALLOGININTERFACE;
      $SOCIALLOGININTERFACE = '';
		if(tep_session_is_registered('customer_id')) {	      
			if (!empty($customer_picture)) {
				$SOCIALLOGININTERFACE .= '<img src = "'.$customer_picture.'" style ="border:3px solid #e7e7e7;"><br>';
			}
				$SOCIALLOGININTERFACE .='<div style="text-align: center; padding-left: 0px; !importent"> Hi! ';
			if($lrsetting['showname'] == '0'){$SOCIALLOGININTERFACE .= $customer_first_name;}
			elseif($lrsetting['showname'] == '1'){$SOCIALLOGININTERFACE .= $customer_last_name;}
			elseif($lrsetting['showname'] == '2'){$SOCIALLOGININTERFACE .= $customer_first_name.' '.$customer_last_name;}
			else{$SOCIALLOGININTERFACE .= $customer_first_name;}
				$SOCIALLOGININTERFACE .= '</div><a href="account_mapping.php">Linked Social IDs</a>';	
				
        }
				
elseif (!isset($lrsetting['apikey']) || !isset($lrsetting['apisecret'])){  	
        $SOCIALLOGININTERFACE .= '<div style="font-size: 10px; font-weight: bold;">' . $lrsetting['sociallogintitle'] . '<div>
<div style="background-color: #FFFFE0;border: 1px solid #E6DB55;padding: 5px;"><div style="color:red;margin-bottom:5px">LoginRadius Social Login Plugin is not configured!</div><p style="line-height:1.3;margin-bottom:4px">To activate your plugin, navigate to <strong>Social Login and Social Share under module</strong>&nbsp;section in your OsCommerce admin panel and insert LoginRadius API Key &amp; Secret. Follow <a target="_blank" href="http://support.loginradius.com/customer/portal/articles/677100-how-to-get-loginradius-api-key-and-secret">this</a> document to learn how to get API Key &amp; Secret.</p></div></div></div>';
	}
		
// Checking apikey and show interface.
    elseif (!empty($lrsetting['apikey']) && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $lrsetting['apikey']) && !empty($lrsetting['apisecret']) && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $lrsetting['apisecret'])){
        $SOCIALLOGININTERFACE .= '<div style="font-size: 10px; font-weight: bold;">' . $lrsetting['sociallogintitle'] . '<div id="interfacecontainerdiv" class="interfacecontainerdiv"></div></div>';
      
    }
	else {
	$SOCIALLOGININTERFACE .= '<div style="font-size: 10px; font-weight: bold;">' . $lrsetting['sociallogintitle'] . '<p style ="color:red;">Your API connection setting not working. try to change setting from module option or check your php.ini setting for (<b>cURL support = enabled</b> OR <b>allow_url_fopen = On</b>)</p></div>';
	}
  
	  $data = '<div class="ui-widget infoBoxContainer">'.
	  		  '<div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_SOCIALLOGIN_BOX_TITLE . '</div>' .
			  '<div class="ui-widget-content infoBoxContents"><div align ="center">' . $SOCIALLOGININTERFACE .  '</div></div></div>';
	
    $oscTemplate->addBlock($data, $this->group);

  } // function executes ends
  function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_SOCIALLOGIN_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable SocialLogin Module', 'MODULE_BOXES_SOCIALLOGIN_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_SOCIALLOGIN_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_SOCIALLOGIN_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_SOCIALLOGIN_STATUS', 'MODULE_BOXES_SOCIALLOGIN_CONTENT_PLACEMENT', 'MODULE_BOXES_SOCIALLOGIN_SORT_ORDER');
    } 
} 
 
?>