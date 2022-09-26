<?php
/*
  $Id: osCAffiliate 20-Nov-2014
  OSC-Affiliate for osCommerce 2.3xx family
  Contribution based on: http://addons.oscommerce.com/info/158
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 - 2014 osCommerce
  Released under the GNU General Public License
  Updated by Fimble (http://forums.oscommerce.com/user/15542-fimble/)
  http://www.linuxuk.co.uk
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_PASSWORD_FORGOTTEN);

  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $check_affiliate_query = tep_db_query("select affiliate_firstname, affiliate_lastname, affiliate_password, affiliate_id from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . $_POST['email_address'] . "'");
    if (tep_db_num_rows($check_affiliate_query)) {
      $check_affiliate = tep_db_fetch_array($check_affiliate_query);
      // Crypted password mods - create a new password, update the database and mail it to them
      $newpass = tep_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
      $crypted_password = tep_encrypt_password($newpass);
      tep_db_query("update " . TABLE_AFFILIATE . " set affiliate_password = '" . $crypted_password . "' where affiliate_id = '" . $check_affiliate['affiliate_id'] . "'");
      
      tep_mail($check_affiliate['affiliate_firstname'] . " " . $check_affiliate['affiliate_lastname'], $_POST['email_address'], EMAIL_PASSWORD_REMINDER_SUBJECT, nl2br(sprintf(EMAIL_PASSWORD_REMINDER_BODY, $newpass)), STORE_OWNER, AFFILIATE_EMAIL_ADDRESS);
      tep_redirect(tep_href_link(FILENAME_AFFILIATE, 'info_message=' . urlencode(TEXT_PASSWORD_SENT), 'SSL', true, false));
    } else {
      tep_redirect(tep_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, 'email=nonexistent', 'SSL'));
    }
  } else {

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_AFFILIATE, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', 'SSL'));
  require(DIR_WS_INCLUDES . 'template_top.php');

?>
<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
  <div class="contentText">
    <?php// echo TEXT_INFORMATION; ?>
  </div>
<?php echo tep_draw_form('password_forgotten', tep_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, 'action=process', 'SSL')); ?>
  <div class="contentText">
            <p><?php echo ENTRY_EMAIL_ADDRESS; ?></p>
            <p><?php echo tep_draw_input_field('email_address', '', 'maxlength="96"'); ?></p>
</div>
  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_AFFILIATE)); ?></span>
  </div>
<?php
  if (isset($_GET['email']) && ($_GET['email'] == 'nonexistent')) {
    echo '          <tr>' . "\n";
    echo '            <td colspan="2" class="smallText">' .  TEXT_NO_EMAIL_ADDRESS_FOUND . '</td>' . "\n";
    echo '          </tr>' . "\n";
  }
?>
</div>
<?php } ?>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>