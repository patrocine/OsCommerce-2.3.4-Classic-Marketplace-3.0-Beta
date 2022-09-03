<?php
/*
  $Id: var_map.php,v 1.0 17:37:59 06/17/2009  

  osCommerce mappings (connection) class for for AlgoZone templates (AFTS)

  Copyright (c) 2009 AlgoZone, Inc (www.algozone.com)

*/

	//##### Constants ######
	define (TMPL_DIR, 'az_template/');
	define (TMPL_INC_DIR, TMPL_DIR.'includes/');	
	define (TMPL_DIR_MAPPING, TMPL_DIR . 'mapping/');	
	define (TMPL_BOXES, DIR_WS_MODULES . 'boxes/az/');
	define (TMPL_CLASSES, TMPL_DIR_MAPPING . 'classes/');
	define (TMPL_IMAGES, TMPL_DIR . 'images/');
	define (TMPL_JS, TMPL_DIR . 'js/');
	define (TMPL_CSS, TMPL_DIR . 'css/');
	define (TMPL_LANGUAGES, DIR_WS_LANGUAGES );
	define (TMPL_DIR_MODULES, TMPL_INC_DIR . 'modules/');
	define (TMPL_DIR_MODULES_CONFIG, TMPL_DIR_MODULES . 'config/');
	define (TMPL_ERROR, "Template Error!");
	define (TMPL_CART_CSS, TMPL_DIR_MAPPING . 'css/');
	
	//##### Important MAPPING #####
	require(TMPL_DIR_MAPPING . 'browser_agent.php');
	require_once(TMPL_CLASSES . 'az_boxes.php');
	require(TMPL_DIR_MAPPING . 'functions_map.php');
	//##### Template specific functions
	if ( file_exists(TMPL_INC_DIR . 'templ_functions_map.php') ) {
		require(TMPL_INC_DIR . 'templ_functions_map.php');
	}
		
	// #check if menu is available 
	if ( file_exists(TMPL_LANGUAGES . $language . '/menu.php') ) {
		require(TMPL_LANGUAGES . $language . '/menu.php');
	}
	else{
		echo TMPL_ERROR. " Template file is missing! Please add file: " . TMPL_LANGUAGES . $language . "/menu.php"; 
	}

	$tmpl = array();
	//##### Variables ######
	$tmpl['language'] = $language;
	$tmpl['trail'] = $breadcrumb->trail(' &raquo; ');
	$tmpl['trail_date'] = strftime(DATE_FORMAT_LONG);
	$tmpl['session_id'] = tep_session_id();
	$tmpl['session_param'] = "osCsid=" . $tmpl['session_id'];

	$tmpl['img'] = array();	
	$tmpl['img']['prod_list_width'] = SMALL_IMAGE_WIDTH;
	$tmpl['img']['prod_list_height'] = SMALL_IMAGE_HEIGHT;
    
    //#### PAGES LINKS #########
	$tmpl['url'] = array();
	$tmpl['url']['index'] = tep_href_link(FILENAME_DEFAULT); 
	$tmpl['url']['account'] =  tep_href_link(FILENAME_ACCOUNT, '', 'SSL');
	$tmpl['url']['cart'] = tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL'); 
	$tmpl['url']['checkout'] = tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');
	$tmpl['url']['contact'] = tep_href_link(FILENAME_CONTACT_US);
	$tmpl['url']['specials'] = tep_href_link(FILENAME_SPECIALS);
	$tmpl['url']['newproducts'] = tep_href_link(FILENAME_PRODUCTS_NEW);
	$tmpl['url']['cart'] = tep_href_link(FILENAME_SHOPPING_CART);
	
	$tmpl['url']['shipping'] = tep_href_link(FILENAME_SHIPPING);
    $tmpl['url']['privacy'] = tep_href_link(FILENAME_PRIVACY);
    $tmpl['url']['conditions'] = tep_href_link(FILENAME_CONDITIONS);
	
	$tmpl['url']['products_new'] = tep_href_link(FILENAME_PRODUCTS_NEW);
	$tmpl['url']['reviews'] = tep_href_link(FILENAME_REVIEWS);
		
	//#### PAGES LINK TEXT #########
	$tmpl['txt'] = array();
	
	$tmpl['txt']['site_name'] = STORE_NAME;
	
	$tmpl['txt']['home'] = MENU_TEXT_HOME;
	$tmpl['txt']['cart'] = MENU_TEXT_CART;
	$tmpl['txt']['checkout'] = MENU_TEXT_CHECKOUT;
	$tmpl['txt']['members'] = MENU_TEXT_MEMBERS;
	$tmpl['txt']['contact'] = MENU_TEXT_CONTACTUS;
	$tmpl['txt']['specials'] = MENU_TEXT_SPECIALS;
	$tmpl['txt']['newproducts'] = MENU_TEXT_NEW_PRODUCTS;
	$tmpl['txt']['conditions'] = BOX_INFORMATION_CONDITIONS;
	$tmpl['txt']['privacy'] = BOX_INFORMATION_PRIVACY;
	$tmpl['txt']['shipping'] = BOX_INFORMATION_SHIPPING;	
	$tmpl['txt']['slogan'] = TEXT_SLOGAN;
	$tmpl['txt']['callnumber'] = TEXT_CALLNUMBER;
	$tmpl['txt']['memberbox'] = '';
  	if (!tep_session_is_registered('customer_id')) {	
  		$tmpl['txt']['memberbox'] = HEADER_TITLE_LOGIN;  
  	}
  	else{	
  		$tmpl['txt']['memberbox'] = BOX_HEADING_LOGIN_BOX_MY_ACCOUNT;  
  	}

	$tmpl['url']['loginout'] = '';
	$tmpl['txt']['loginout'] = '';
	if (tep_session_is_registered('customer_id')) {
		$tmpl['url']['loginout'] = tep_href_link(FILENAME_LOGOFF, '', 'SSL');
		$tmpl['txt']['loginout'] = MENU_TEXT_LOGOUT;		
	} else {
		$tmpl['url']['loginout'] = tep_href_link(FILENAME_LOGIN, '', 'SSL');
		$tmpl['txt']['loginout'] = MENU_TEXT_LOGIN;		
	}
	
	$tmpl['txt']['products_new'] = MENU_TEXT_NEW_PRODUCTS;
	$tmpl['txt']['reviews'] = MENU_TEXT_REVIEWS;
    
    //#### CART DROPDOWN VARIABLES #########
    $tmpl['txt']['cart_text'] = TEXT_CART_LINK;
    $tmpl['txt']['cart_empty'] = TEXT_CART_EMPTY;
    $tmpl['txt']['cart_subtotal'] = TEXT_CART_SUBTOTAL;
    $tmpl['txt']['cart_qty'] = TEXT_CART_QUANTITY;
    
    $tmpl['url']['cart_fetch'] = tep_href_link('cart_cnt_fetch.php', '', $request_type); 
    
    $tmpl['img']['cart_width'] = 50;
    $tmpl['img']['cart_height'] = '';
    $tmpl['img']['cart_loading'] = TMPL_IMAGES.'az_loading.gif';
    /////////////////////////////////////////

	$tmpl['txt']['err_msg'] = urldecode($_GET['error_message']);
	$tmpl['txt']['info_msg'] = $_GET['info_message'];
	$tmpl['txt']['footer'] = FOOTER_TEXT_BODY;
	//$tmpl['txt']['copyright'] = 'osCommerce Template &copy; Designed by <a href="http://www.algozone.com" target="_blank" title="osCommerce Template Designed by AlgoZone.com">AlgoZone.com</a>';
						
	$az_curSymbol = array($currencies->currencies[$currency]['symbol_left'], $currencies->currencies[$currency]['symbol_right']);
    $az_newSymbol = array('<small class="az_smallCur">'.$currencies->currencies[$currency]['symbol_left'].'</small>', 
	  			          '<small class="az_smallCur">'.$currencies->currencies[$currency]['symbol_right'].'</small>');
						  
	//check if we have module configs
	if ( file_exists(TMPL_DIR_MODULES_CONFIG) ) {
		$d = dir(TMPL_DIR_MODULES_CONFIG);
		while ($az_entry = $d->read()) {
			if ( substr($az_entry,0,1) == '.' ) continue;
			require TMPL_DIR_MODULES_CONFIG.$az_entry;
		}
		$d->close();
	}	
?>
