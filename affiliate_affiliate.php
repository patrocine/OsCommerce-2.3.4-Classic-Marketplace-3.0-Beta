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
 if (tep_session_is_registered('affiliate_id')){
 tep_redirect(tep_href_link(FILENAME_AFFILIATE_SUMMARY));  
 }
// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
  if ($session_started == false) {
    tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
  }

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE);
 $error = false;
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $affiliate_username = tep_db_prepare_input($_POST['affiliate_username']);
    $affiliate_password = tep_db_prepare_input($_POST['affiliate_password']);

// Check if username exists
    $check_affiliate_query = tep_db_query("select affiliate_id, affiliate_firstname, affiliate_password, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . tep_db_input($affiliate_username) . "'");
    if (!tep_db_num_rows($check_affiliate_query)) {
      $error = false;
    } else {
      $check_affiliate = tep_db_fetch_array($check_affiliate_query);
// Check that password is good
      if (!tep_validate_password($affiliate_password, $check_affiliate['affiliate_password'])) {
 $error = true;
	
      } else {
        $affiliate_id = $check_affiliate['affiliate_id'];
        tep_session_register('affiliate_id');

        $date_now = date('Ymd');

        tep_db_query("update " . TABLE_AFFILIATE . " set affiliate_date_of_last_logon = now(), affiliate_number_of_logons = affiliate_number_of_logons + 1 where affiliate_id = '" . $affiliate_id . "'");

        tep_redirect(tep_href_link(FILENAME_AFFILIATE_SUMMARY,'','SSL'));
      }
    }
  }
  if ($error == true) {
    $messageStack->add('login', TEXT_LOGIN_ERROR);
  }


  

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE, '', 'SSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<?php
  if ($messageStack->size('login') > 0) {
    echo $messageStack->output('login');
  }

?>
<h1><?php echo HEADING_TITLE; ?></h1>
<div class="contentContainer" style="width: 45%; float: left;">
  <h2><?php echo HEADING_NEW_AFFILIATE; ?></h2>
  <div class="contentText">
    <p><?php echo HEADING_NEW_AFFILIATE; ?></p>
    <p><?php echo TEXT_NEW_AFFILIATE_INTRODUCTION; ?></p>
    <p align="right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_AFFILIATE_SIGNUP, '', 'SSL')); ?></p>
  </div>
</div>
<div class="contentContainer" style="width: 45%; float: left; border-left: 1px dashed #ccc; padding-left: 3%; margin-left: 3%;">
  <h2><?php echo  HEADING_RETURNING_AFFILIATE; ?></h2>
  <div class="contentText">
    <p><?php echo TEXT_RETURNING_AFFILIATE; ?></p>
    <?php echo tep_draw_form('login', tep_href_link(FILENAME_AFFILIATE, 'action=process', 'SSL'), 'post', '', true); ?>

    <table border="0" cellspacing="0" cellpadding="2" width="100%">
      <tr>
        <td class="fieldKey"><?php echo TEXT_AFFILIATE_ID; ?></td>
        <td class="fieldValue"><?php echo tep_draw_input_field('affiliate_username'); ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo TEXT_AFFILIATE_PASSWORD; ?></td>
        <td class="fieldValue"><?php echo tep_draw_password_field('affiliate_password'); ?></td>
      </tr>
    </table>
    <p><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_AFFILIATE_PASSWORD_FORGOTTEN . '</a>'; ?></p>
    <p align="right"><?php echo tep_draw_button(IMAGE_BUTTON_LOGIN, 'key', null, 'primary'); ?></p>
    </form>
  </div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
