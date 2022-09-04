<?php
/*
  $Id: password_forgotten.php,v 1.50 2003/06/05 23:28:24 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require_once('mobile/includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_PASSWORD_FORGOTTEN));

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);

    $check_customer_query = tep_db_query("select customers_firstname, customers_lastname, customers_password, customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
    if (tep_db_num_rows($check_customer_query)) {
      $check_customer = tep_db_fetch_array($check_customer_query);

      $new_password = tep_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
      $crypted_password = tep_encrypt_password($new_password);

      tep_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . tep_db_input($crypted_password) . "' where customers_id = '" . (int)$check_customer['customers_id'] . "'");

      tep_mail($check_customer['customers_firstname'] . ' ' . $check_customer['customers_lastname'], $email_address, EMAIL_PASSWORD_REMINDER_SUBJECT, sprintf(EMAIL_PASSWORD_REMINDER_BODY, $new_password), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

      $messageStack->add_session('login', SUCCESS_PASSWORD_SENT, 'success');

      tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
    } else {
      $messageStack->add('password_forgotten', TEXT_NO_EMAIL_ADDRESS_FOUND);
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_mobile_link(FILENAME_MOBILE_PASSWORD_FORGOTTEN, '', 'SSL'));
  require(DIR_MOBILE_INCLUDES . 'header.php');
  $headerTitle->write();
  ?>
<!-- header_eof //-->
<div id="iphone_content">
<!-- body //-->
    <?php echo tep_draw_form('password_forgotten', tep_mobile_link(FILENAME_MOBILE_PASSWORD_FORGOTTEN, 'action=process', 'SSL'));
	?>
	<div id="messageStack">
	<?php
 	 if ($messageStack->size('password_forgotten') > 0) {
	 echo $messageStack->output('password_forgotten'); 
	  }
	  ?>
	  </div>
	  <div id="returning_cust">
                <?php echo TEXT_MAIN; ?>
				<br /><br />
                <label for="email" class="float"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
				<?php echo tep_draw_input_field('email_address'); ?>
				<br />
				<?php echo '<a href="' . tep_mobile_link(FILENAME_LOGIN, '', 'SSL') . '">'.tep_mobile_button(IMAGE_BUTTON_BACK).'</a>'; ?>
                <?php echo ''.tep_mobile_button(IMAGE_BUTTON_CONTINUE).''; ?>
	</div>
    </form>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php'); ?>
</div>