<?php

  require_once('mobile/includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_PASSWORD_RESET));

  $error = false;

  if ( !isset($HTTP_GET_VARS['account']) || !isset($HTTP_GET_VARS['key']) ) {
    $error = true;

    $messageStack->add_session('password_forgotten', TEXT_NO_RESET_LINK_FOUND);
  }

  if ($error == false) {
    $email_address = tep_db_prepare_input($HTTP_GET_VARS['account']);
    $password_key = tep_db_prepare_input($HTTP_GET_VARS['key']);

    if ( (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) || (tep_validate_email($email_address) == false) ) {
      $error = true;

      $messageStack->add_session('password_forgotten', TEXT_NO_EMAIL_ADDRESS_FOUND);
    } elseif (strlen($password_key) != 40) {
      $error = true;

      $messageStack->add_session('password_forgotten', TEXT_NO_RESET_LINK_FOUND);
    } else {
      $check_customer_query = tep_db_query("select c.customers_id, c.customers_email_address, ci.password_reset_key, ci.password_reset_date from " . TABLE_CUSTOMERS . " c, " . TABLE_CUSTOMERS_INFO . " ci where c.customers_email_address = '" . tep_db_input($email_address) . "' and c.customers_id = ci.customers_info_id");
      if (tep_db_num_rows($check_customer_query)) {
        $check_customer = tep_db_fetch_array($check_customer_query);

        if ( empty($check_customer['password_reset_key']) || ($check_customer['password_reset_key'] != $password_key) || (strtotime($check_customer['password_reset_date'] . ' +1 day') <= time()) ) {
          $error = true;

          $messageStack->add_session('password_forgotten', TEXT_NO_RESET_LINK_FOUND);
        }
      } else {
        $error = true;

        $messageStack->add_session('password_forgotten', TEXT_NO_EMAIL_ADDRESS_FOUND);
      }
    }
  }

  if ($error == true) {
    tep_redirect(tep_href_link(FILENAME_PASSWORD_FORGOTTEN));
  }

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process') && isset($HTTP_POST_VARS['formid']) && ($HTTP_POST_VARS['formid'] == $sessiontoken)) {
    $password_new = tep_db_prepare_input($HTTP_POST_VARS['password']);
    $password_confirmation = tep_db_prepare_input($HTTP_POST_VARS['confirmation']);

    if (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('password_reset', ENTRY_PASSWORD_NEW_ERROR);
    } elseif ($password_new != $password_confirmation) {
      $error = true;

      $messageStack->add('password_reset', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
    }

    if ($error == false) {
      tep_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . tep_encrypt_password($password_new) . "' where customers_id = '" . (int)$check_customer['customers_id'] . "'");

      tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now(), password_reset_key = null, password_reset_date = null where customers_info_id = '" . (int)$check_customer['customers_id'] . "'");

      $messageStack->add_session('login', SUCCESS_PASSWORD_RESET, 'success');

      tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2);
  require(DIR_MOBILE_INCLUDES . 'header.php');
  require('includes/form_check.js.php');
  $headerTitle->write();
  ?>
<!-- header_eof //-->
<div id="iphone_content">
<!-- body //-->
    <?php echo tep_draw_form('password_reset', tep_mobile_link(FILENAME_MOBILE_PASSWORD_RESET, 'account=' . $email_address . '&key=' . $password_key . '&action=process', 'SSL'), 'post', 'onsubmit="return check_form(password_reset);"', true);
	?>
	<div id="messageStack">
<?php
  if ($messageStack->size('password_reset') > 0) {
    echo $messageStack->output('password_reset');
  }
?>

<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_MAIN; ?>
  </div>
</div>

<?php
	  ?>
	  </div>
	  <div id="returning_cust">
                <?php echo TEXT_MAIN; ?>
				<br /><br />
                <label for="password" class="float"><?php echo ENTRY_PASSWORD; ?></label>
				<?php echo tep_draw_password_field('password'); ?>
				<br />
                <label for="confirmation" class="float"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></label>
				<?php echo tep_draw_password_field('confirmation'); ?>
				<br />
                <?php echo ''.tep_mobile_button(IMAGE_BUTTON_CONTINUE).''; ?>
	</div>
    </form>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>