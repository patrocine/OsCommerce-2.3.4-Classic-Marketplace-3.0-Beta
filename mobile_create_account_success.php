<?php
require_once('mobile/includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_CREATE_ACCOUNT_SUCCESS));

  $breadcrumb->add(NAVBAR_TITLE_1);
  $breadcrumb->add(NAVBAR_TITLE_2);

  if (sizeof($navigation->snapshot) > 0) {
    $origin_href = tep_mobile_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
    $navigation->clear_snapshot();
  } else {
    $origin_href = tep_href_link(FILENAME_DEFAULT);
  }
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<div id="iphone_content">
<div id="cms">
<h1><?php echo TEXT_ACCOUNT_CREATED; ?></h1>
<div id="bouton"><?php echo tep_draw_form('login', $origin_href). tep_mobile_button(IMAGE_BUTTON_CONTINUE) . '</form>'; ?></div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
