<?php
	
	$tmpl['url']['cart_fetch'] = tep_href_link('cart_cnt_fetch.php'); 
	
	$tmpl['img']['cart_width'] = 50;
	$tmpl['img']['cart_height'] = '';
	$tmpl['img']['cart_loading'] = TMPL_IMAGES.'az_loading.gif';
	
	$tmpl['url']['loginout'] = '';
	$tmpl['txt']['loginout'] = '';
	if (tep_session_is_registered('customer_id')) {
		$tmpl['url']['loginout'] = tep_href_link(FILENAME_LOGOFF, '', 'SSL');
		$tmpl['txt']['loginout'] = MENU_TEXT_LOGOUT;
		
		$tmpl['url']['create_account'] = tep_href_link(FILENAME_ACCOUNT, '', 'SSL');
		$tmpl['txt']['create_account'] = MENU_TEXT_MEMBERS;
				
	} else {
		$tmpl['url']['loginout'] = tep_href_link(FILENAME_LOGIN, '', 'SSL');
		$tmpl['txt']['loginout'] = MENU_TEXT_LOGIN;
		
		$tmpl['url']['create_account'] = tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL');
		$tmpl['txt']['create_account'] = MENU_TEXT_MEMBERS;
		
				
	}
	
	 $tmpl['cfg']['main_page'] = false;
	 if (basename($PHP_SELF) == FILENAME_DEFAULT && !isset($HTTP_GET_VARS['cPath']) && !isset($HTTP_GET_VARS['manufacturers_id']))
	 {$tmpl['cfg']['main_page'] = true; }
	 
		 
	
	
	$tmpl['txt']['advance_search'] = MENU_TEXT_ADVANCE_SEARCH;
	$tmpl['url']['advance_search'] = tep_href_link(FILENAME_ADVANCED_SEARCH);
	
	$tmpl['txt']['advance_search'] = MENU_TEXT_ADVANCE_SEARCH;
	$tmpl['txt']['check_order_status'] = MENU_TEXT_CHECK_ORDER_STATUS;
	$tmpl['txt']['returns_exchange'] = MENU_TEXT_RETURNS_EXCHANGE;
	$tmpl['txt']['about_us'] = MENU_TEXT_ABOUT_US;
	$tmpl['txt']['cond_of_use'] = MENU_TEXT_CONDITION_OF_USE;
	$tmpl['txt']['site_map'] = MENU_TEXT_SITE_MAP;
	
	$tmpl['txt']['shipping_returns'] = MODULE_BOXES_INFORMATION_BOX_SHIPPING;
	
	$tmpl['txt']['wish_list'] = MENU_MY_WISHLIST;
	
	
	$tmpl['txt']['contact'] = MENU_TEXT_CONTACTUS;
	$tmpl['txt']['legal_notice'] = MENU_TEXT_LEGAL_NOTICE;
	$tmpl['txt']['new_products'] = MENU_TEXT_NEW_PRODUCTS;
	$tmpl['txt']['personal_information'] = PERSONAL_INFO;
	$tmpl['txt']['addresses'] = ADDRESSES;
	
	$tmpl['url']['addresses'] = tep_href_link(FILENAME_ADDRESS_BOOK);
	$tmpl['url']['privacy_footer'] = tep_href_link(FILENAME_PRIVACY);
	$tmpl['url']['write_review'] = tep_href_link(FILENAME_ACCOUNT_EDIT);
	$tmpl['url']['order_history'] = tep_href_link(FILENAME_ACCOUNT_HISTORY);
	$tmpl['url']['newsletters'] = tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS);
	$tmpl['url']['change_pass'] = tep_href_link(FILENAME_ACCOUNT_PASSWORD);
	
	$tmpl['txt']['write_review'] = WRITE_REVIEW;
	$tmpl['txt']['reviews'] = MENU_TEXT_REVIEWS;
	$tmpl['txt']['order_history'] = ORDER_HISTORY;
	$tmpl['txt']['newsletters'] = NEWSLETTERS;
	$tmpl['txt']['change_pass'] = CHANGE_PASS;
	$tmpl['txt']['shopping_cart'] = SHOPPING_CART;
	
?>