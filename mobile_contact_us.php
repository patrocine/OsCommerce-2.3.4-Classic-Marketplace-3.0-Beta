<?php
require_once('mobile/includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_CONTACT_US));

  $error = false;
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'send')) {
    $name = tep_db_prepare_input($HTTP_POST_VARS['name']);
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email']);
    $enquiry = tep_db_prepare_input($HTTP_POST_VARS['enquiry']);

    if (!tep_validate_email($email_address)) {
      $error = true;

      $messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }

    $actionRecorder = new actionRecorder('ar_contact_us', (tep_session_is_registered('customer_id') ? $customer_id : null), $name);
    if (!$actionRecorder->canPerform()) {
      $error = true;

      $actionRecorder->record(false);

      $messageStack->add('contact', sprintf(ERROR_ACTION_RECORDER, (defined('MODULE_ACTION_RECORDER_CONTACT_US_EMAIL_MINUTES') ? (int)MODULE_ACTION_RECORDER_CONTACT_US_EMAIL_MINUTES : 15)));
    }

    if ($error == false) {
      tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_SUBJECT, $enquiry, $name, $email_address);

      $actionRecorder->record();

      tep_redirect(tep_mobile_link(FILENAME_MOBILE_CONTACT_US, 'action=success'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_mobile_link(FILENAME_MOBILE_CONTACT_US));
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<div id="iphone_content">
<!--  ajax_part_begining -->
<div id="messageStack">
<?php
  if ($messageStack->size('contact') > 0) {
?>
        <?php echo $messageStack->output('contact'); ?>
<?php
  }
?>
</div>
<div id="contactForm">
<?php
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) { ?>
  	  <?php echo TEXT_SUCCESS; ?>
  	  <?php echo '<a href="' . tep_mobile_link(FILENAME_DEFAULT) . '">' . tep_mobile_button(IMAGE_BUTTON_CONTINUE) . '</a>';
  } else {
 	  echo tep_draw_form('contact_us', tep_mobile_link(FILENAME_MOBILE_CONTACT_US, 'action=send'), 'post','',true); ?>
  	  <label for="name" class="float"><?php echo ENTRY_NAME; ?></label>
	  <?php echo tep_draw_input_field('name'); ?>
	  <br />
	  <label for="email" class="float"><?php echo ENTRY_EMAIL; ?></label>
	  <?php echo tep_draw_input_field('email'); ?>
	  <br />
	  <label for="enquiry" class="float"><?php echo ENTRY_ENQUIRY; ?></label>
	  <?php echo tep_draw_textarea_field('enquiry', 'soft', 30, 5); ?>
	  <br />
	  <?php echo tep_mobile_button(IMAGE_BUTTON_CONTINUE); ?>
<?php
  }
?>
	  <?php if (PERMISO_DIRECCIONWEB == 'True'){ ?>
	  <br /><br />
	  <?php echo STORE_OWNER . '&nbsp;' . STORE_NAME_ADDRESS; ?>
</div>

                <?php } ?>

<!--  ajax_part_ending -->
</form>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
