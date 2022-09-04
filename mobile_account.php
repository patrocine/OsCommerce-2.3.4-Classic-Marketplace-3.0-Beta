<?php
require_once('mobile/includes/application_top.php');
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_ACCOUNT));
  
  $breadcrumb->add(NAVBAR_TITLE, tep_mobile_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL'));
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write(NAVBAR_TITLE);
/*if(AJAX_ENABLED && $curl_installed)
	include(DIR_MOBILE_CLASSES . 'account_js.php');
*/?>
<!-- account //-->
<div id="iphone_content">
<table width="100%" cellpadding="0" cellspacing="0"  class="categories">
<?php 
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_ACCOUNT_HISTORY, '', 'SSL'), array(TEXT_MY_ORDERS)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_ACCOUNT_EDIT, '', 'SSL'), array(HEADER_TITLE_MY_ACCOUNT)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_ADDRESS_BOOK), array(IMAGE_BUTTON_ADDRESS_BOOK)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_ACCOUNT_PASSWORD), array(CATEGORY_PASSWORD)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_ACCOUNT_NEWSLETTERS), array(EMAIL_NOTIFICATIONS_NEWSLETTERS)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_ACCOUNT_NOTIFICATIONS), array(EMAIL_NOTIFICATIONS_PRODUCTS)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
	echo tep_mobile_selection(tep_mobile_link(FILENAME_MOBILE_LOGOFF), array(HEADER_TITLE_LOGOFF)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
?>
	</table>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
