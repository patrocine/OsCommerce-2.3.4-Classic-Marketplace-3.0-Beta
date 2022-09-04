<?php

/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');

  //creating table BOXNEWSLETTER

$create = tep_db_query ("CREATE TABLE IF NOT EXISTS `newsletter_subscriber` (
  `cus_id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_email_address` varchar(200) NOT NULL,
  PRIMARY KEY (`cus_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ");

	
$email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);

$check_customer_query = tep_db_query("select customers_email_address from `newsletter_subscriber` where customers_email_address = '" . tep_db_input($email_address) . "'");
if (tep_db_num_rows($check_customer_query)) {
    $error = true;
} else {
	tep_db_query("insert into `newsletter_subscriber` (customers_email_address) values ('".$email_address."')");
	$error = false;
	$HEADING_TITLE ='Newsletter Successfully Subscribed';
		 
	$get_mail_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_title='E-Mail Address'");
		
	$get_mail = tep_db_fetch_array($get_mail_query);
	$headers="From:".$get_mail['configuration_value'];
	$msg = 'Thank You for joining our Newsletter. Stay tuned for exciting updates!';
	mail($email_address,"Newsletter Successfully Subscribed",$msg,$headers);
	
	//newsletter query
	$newsletter_query = tep_db_query("select title, content, date_added from `newsletters` order by date_added ");
	
	if (tep_db_num_rows($newsletter_query) > 0) {
		while ($newsletter = tep_db_fetch_array($newsletter_query)) {
			$msg_title = $newsletter['title'];
			$msg_news = $newsletter['content'];
			mail($email_address,$msg_title,$msg_news,$headers);
		}
	}
	
	
	
}
if ($error == true) {
   	$HEADING_TITLE ='Newsletter Already Subscribed';
}
?>
   <h1><?php echo $HEADING_TITLE; ?></h1>
  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?></span>
  </div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
