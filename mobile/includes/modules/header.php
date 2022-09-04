<?php if(isset($HTTP_GET_VARS['ajax']) == false) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="viewport"
content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
<meta name="apple-mobile-web-app-capable"
         content="yes" />
<meta name="apple-mobile-web-app-status-bar-style"
         content="default" />
<?php
if (strpos($PHP_SELF,'checkout') || strpos($PHP_SELF,'shopping_cart') || strpos($PHP_SELF,'account') || strpos($PHP_SELF,'log') || strpos($PHP_SELF,'address') > 0) {
?>         
<meta name="googlebot"
   content="noindex, nofollow">
<meta name="robots"
   content="noindex, nofollow">
<?php
}
?>         
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<style type="text/css" media="screen">
@import "<?php echo DIR_WS_HTTP_CATALOG . DIR_MOBILE_INCLUDES; ?>iphone.css";
</style>
    <title><?php echo $product_info_name . ' ' . TITLE ?></title>
</head>
<body>
<div id="errorMsg">
<?php
if ($messageStack->size('header') > 0) {
echo $messageStack->output('header');
}
?>
</div>
<link rel="stylesheet" type="text/css" href="ext/jquery/ui/redmond/jquery-ui-1.8.6.css" />
<script type="text/javascript" src="ext/jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.8.6.min.js"></script>
<script>
$(function() {
$("#search").autocomplete({
                        source: "autocomplete.php",
                        minLength: 2,
                        select: function(event, ui) {
                        }
                });

});
</script>
<!-- header //-->
<div id="header">
<div id="headerLogo"><?php echo '<a href="' . tep_mobile_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES . 'store_logo.png', STORE_OWNER, 0,70) . '</a>';?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="headerNavigation">
  <tr class="headerNavigation">
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_DEFAULT);?>"><?php echo  tep_image(DIR_MOBILE_IMAGES. "home.png") . "<br>" . TEXT_HOME; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_CATALOG);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "boutique.png") . "<br>" . TEXT_SHOP; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_MOBILE_ACCOUNT);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "compte.png") . "<br>" . TEXT_ACCOUNT; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_SEARCH);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "search2.png") . "<br>" . IMAGE_BUTTON_SEARCH; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link(FILENAME_MOBILE_ABOUT);?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "help.png") . "<br>" . TEXT_ABOUT; ?></a></td>
  </tr>
</table>
</div>
<!-- header_eof //-->
<!-- error msg -->
<div id="errorMsg">
<?php
  if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message']))
	echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['error_message'])));
?>
</div>
<!-- error msg -->
<div id="mainBody">
<?php } 
    if(sizeof($breadcrumb->_trail) > 0)
		$headerTitleText = $breadcrumb->_trail[sizeof($breadcrumb->_trail) - 1]['title'];
?>
</div>
