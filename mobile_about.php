<?php
require_once('mobile/includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_DEFAULT));
require(DIR_WS_LANGUAGES . $language . '/modules/boxes/bm_information.php');
$classic_site = DIR_WS_HTTP_CATALOG . 'index.php?' . tep_get_all_get_params();
require(DIR_MOBILE_INCLUDES . 'header.php');
    $headerTitle->write(MODULE_BOXES_INFORMATION_TITLE);
/*if(AJAX_ENABLED == 'true' && $curl_installed)
	include(DIR_MOBILE_CLASSES . 'about_js.php');
*/?>
<!-- about //-->
<div id="iphone_content">
<table width="100%" cellpadding="0" cellspacing="0"  class="categories">
<?php 
	echo tep_mobile_selection(tep_mobile_link('mobile_googlemaps.php'), array('Donde Estamos GoogleMaps')).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_SHIPPING), array(MODULE_BOXES_INFORMATION_BOX_SHIPPING)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_PRIVACY), array(MODULE_BOXES_INFORMATION_BOX_PRIVACY)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_CONDITIONS), array(MODULE_BOXES_INFORMATION_BOX_CONDITIONS)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_CONTACT_US), array(MODULE_BOXES_INFORMATION_BOX_CONTACT)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	// echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_REVIEWS), array(BOX_HEADING_REVIEWS)).'<div class="fleche"><img src="' . DIR_WS_HTTP_CATALOG . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
?>
	</table>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
