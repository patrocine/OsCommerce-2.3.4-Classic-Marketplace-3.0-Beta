<?php
  	require('mobile/includes/configure.php');
  	require('includes/configure.php');
  	require('mobile/includes/functions/general.php');
	if (COMPATIBILITY_MODE)
	{
		require('includes/iosc_default_application_top.php');
	}
	else
	{
		require('includes/application_top.php');
	}?>
<?php  	//tep_debug("DEBUG IS ON");


	if (PHP_VERSION>='5')
 		require_once('mobile/includes/functions/domxml-php4-to-php5.php');
 	$curl_installed = function_exists('curl_init'); 
  	
	//@TODO need to findout why it's missing $SID for cURL
	if(empty($SID) && strlen(tep_session_id()) > 0 && tep_session_id() == $HTTP_GET_VARS['osCsid'])
		$SID = tep_session_name() . '=' . tep_session_id();

	switch ($HTTP_GET_VARS['action']) {
      case 'remove_product':  if (isset($HTTP_GET_VARS['products_id'])) {
                              	$cart->remove($HTTP_GET_VARS['products_id']);
      							}
    						  tep_redirect(tep_mobile_link($goto, tep_get_all_get_params($parameters, array('module'))));
                              break;                      
    }


    if (!tep_session_is_registered('languages_icon') || isset($HTTP_GET_VARS['language'])) {
    	if(!isset($lng)) {
		    include(DIR_WS_CLASSES . 'language.php');
		    $lng = new language();
    	}
    	tep_session_register('languages_icon');
    	$languages_icon = tep_image(DIR_WS_LANGUAGES .  $lng->language['directory'] . '/images/' . $lng->language['image'], $lng->language['name']);
    }
  
        if (!tep_session_is_registered('redirectCancelled') && substr(basename($PHP_SELF), 0, 15) != 'mobile_checkout') {
    	    tep_session_register('redirectCancelled');
    	    $redirectCancelled = true;
    }

    	include(DIR_MOBILE_CLASSES . 'header_title.php');
	$headerTitle = new headerTitle();
	
    require(DIR_MOBILE_LANGUAGES . $language . '.php');
?>
