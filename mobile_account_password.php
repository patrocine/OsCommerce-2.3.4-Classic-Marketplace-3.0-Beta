<?php
require_once('mobile/includes/application_top.php');
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

// needs to be included earlier to set the success message in the messageStack
  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_ACCOUNT_PASSWORD));

  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process')) {
    $password_current = tep_db_prepare_input($HTTP_POST_VARS['password_current']);
    $password_new = tep_db_prepare_input($HTTP_POST_VARS['password_new']);
    $password_confirmation = tep_db_prepare_input($HTTP_POST_VARS['password_confirmation']);

    $error = false;

    if (strlen($password_current) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_password', ENTRY_PASSWORD_CURRENT_ERROR);
    } elseif (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR);
    } elseif ($password_new != $password_confirmation) {
      $error = true;

      $messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
    }

    if ($error == false) {
      $check_customer_query = tep_db_query("select customers_password from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
      $check_customer = tep_db_fetch_array($check_customer_query);

      if (tep_validate_password($password_current, $check_customer['customers_password'])) {
        tep_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . tep_encrypt_password($password_new) . "' where customers_id = '" . (int)$customer_id . "'");

        tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$customer_id . "'");

        $messageStack->add_session('account', SUCCESS_PASSWORD_UPDATED, 'success');

        tep_redirect(tep_mobile_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL'));
      } else {
        $error = true;

        $messageStack->add('account_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
      }
    }
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_mobile_link(FILENAME_MOBILE_ACCOUNT_PASSWORD, '', 'SSL'));
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<div id="iphone_content">
<?php echo tep_draw_form('account_password', tep_mobile_link(FILENAME_MOBILE_ACCOUNT_PASSWORD, '', 'SSL'), 'post', 'onSubmit="return check_form(account_password);"') . tep_draw_hidden_field('action', 'process'); ?>
<div id="password">
<?php
  if ($messageStack->size('account_password') > 0) {
?>
<div id="messageStack">
      <?php echo $messageStack->output('account_password'); ?>
</div>
<?php
  }
?>
                    <label for="password" class="float"><?php echo ENTRY_PASSWORD_CURRENT; ?></label>
					<?php echo tep_draw_password_field('password_current'); ?>
					<br />
					<label for="pwdnew" class="float"><?php echo ENTRY_PASSWORD_NEW; ?></label>
					<?php echo tep_draw_password_field('password_new'); ?>
					<br />
					<label for="confirmation" class="float"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></label>
					<?php echo tep_draw_password_field('password_confirmation'); ?>
</div>
<div id="accthistpl">
<div id="bouton" style="text-align:left;">
<?php echo '<a href="' . tep_href_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL') . '"><input type="button" value="' . IMAGE_BUTTON_BACK . '"></a>' . 
	   '<span style="float:right;"><a href="' . tep_href_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL') . '">' . tep_mobile_button(IMAGE_BUTTON_CONTINUE) . '</a></span>';?>
</form>
</div>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
