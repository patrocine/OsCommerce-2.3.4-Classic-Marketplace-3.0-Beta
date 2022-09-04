<?php
require_once('mobile/includes/application_top.php');
require(DIR_MOBILE_INCLUDES . 'header.php');
  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_PRIVACY));
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRIVACY));
	$headerTitle->write();
?>
<div id="iphone_content">
<!--  ajax_part_begining -->
<div id="cms">
<?php echo TEXT_INFORMATION; ?>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
