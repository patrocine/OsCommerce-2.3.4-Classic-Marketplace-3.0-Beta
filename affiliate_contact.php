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
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_CONTACT);
  if (!tep_session_is_registered('affiliate_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_AFFILIATE, '', 'SSL'));
  }
  $error = false;
  if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
    if (tep_validate_email(trim($_POST['email']))) {
      tep_mail(STORE_OWNER, AFFILIATE_EMAIL_ADDRESS, EMAIL_SUBJECT, $_POST['enquiry'], $_POST['name'], $_POST['email']);
      tep_redirect(tep_href_link(FILENAME_AFFILIATE_CONTACT, 'action=success'));
    } else {
      $error = true;
    }
  }
  $affiliate_values = tep_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate_id . "'");
  $affiliate = tep_db_fetch_array($affiliate_values);
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_CONTACT));
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<h1><?php echo HEADING_TITLE; ?></h1>
 <div class="contentContainer">
<?php
  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>
<p><?php echo TEXT_SUCCESS ;?></p>
  <div class="buttonSet">
          <a href="<?php echo tep_href_link(FILENAME_AFFILIATE_SUMMARY); ?>"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', null, 'primary'); ?></a>
  </div>


<?php
  } else {
?>
 <?php echo tep_draw_form('contact_us', tep_href_link(FILENAME_AFFILIATE_CONTACT, 'action=send'), 'post', '', true); ?>
   <div class="contentText">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="fieldKey"><?php echo ENTRY_NAME; ?></td>
        <td class="fieldValue"><?php echo tep_draw_input_field('name', $affiliate['affiliate_firstname'] . ' ' . $affiliate['affiliate_lastname'], 'size=40'); ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_EMAIL; ?></td>
        <td class="fieldValue"><?php echo tep_draw_input_field('email', $affiliate['affiliate_email_address'], 'size=40'); if ($error) echo ENTRY_EMAIL_ADDRESS_CHECK_ERROR; ?></td>
      </tr>
      <tr>
        <td class="fieldKey" valign="top"><?php echo ENTRY_ENQUIRY; ?></td>
         <td class="fieldValue"><?php echo tep_draw_textarea_field('enquiry', 'soft', 50, 15); ?></td> 
      </tr>
    </table>
     </div>
      <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', null, 'primary'); ?></span>
        </div>
<?php
  }
?>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>