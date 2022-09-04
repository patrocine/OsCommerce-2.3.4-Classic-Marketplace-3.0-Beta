<?php
require_once('mobile/includes/application_top.php');
require(DIR_MOBILE_INCLUDES . 'header.php');
require(DIR_WS_LANGUAGES . $language . '/modules/boxes/bm_currencies.php');
$classic_site = DIR_WS_HTTP_CATALOG . 'index.php';
$headerTitle->write(MODULE_BOXES_CURRENCIES_BOX_TITLE);
?>
<!-- currencies //-->
<div id="iphone_content">
<table width="100%" cellpadding="0" cellspacing="0"  class="categories">
<?php 
	if (isset($currencies) && is_object($currencies) && (count($currencies->currencies) > 1)) {
		$path = $_SERVER['HTTP_REFERER'] . ((strpos($_SERVER['HTTP_REFERER'],'?') == false) ? '?' : '&') . 'currency='; 
		reset($currencies->currencies);
		$currencies_array = array();
		while (list($key, $value) = each($currencies->currencies)) {
			$currencies_array[] = array('id' => $key, 'text' => $value['title']);
			echo tep_mobile_selection($path . $key, array($value['title']));
		}
	}
?>
</table>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
