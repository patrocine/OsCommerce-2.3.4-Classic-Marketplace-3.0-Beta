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
         
         
         
         
<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'de,en,es,fr,it,pt,ru', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
         
         
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
<p align="center"><b><font size="7">MARKETPLACE</font></b></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="headerNavigation">
  <tr class="headerNavigation">
	<td class="headerNavigation"><a href="<?php echo tep_mobile_link('mobile_marketplace.php');?>"><?php echo  tep_image(DIR_MOBILE_IMAGES. "marketplace.png") . "<br>" . Marketplace; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo 'https://CanariasToken.com';?>"><?php echo  tep_image(DIR_MOBILE_IMAGES. "islascanarias.png") . "<br>" . 'Canarias Token'; ?></a></td>
	<td class="headerNavigation"><a href="<?php echo 'https://www.youtube.com/@vivelocriptocomunidad';?>"><?php echo tep_image(DIR_MOBILE_IMAGES. "vcr.png") . "<br>" . 'Anyela Rios'; ?></a></td>
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
</div><p align="center"><b><font size="6"><a href="<?php echo tep_mobile_link('mobile_marketplace.php');?>">CATEGORIAS</a></font></b>
