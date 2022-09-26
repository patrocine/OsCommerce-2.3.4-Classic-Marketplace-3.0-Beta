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

  if (!tep_session_is_registered('affiliate_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_AFFILIATE, '', 'SSL'));
  }

// needs to be included earlier to set the success message in the messageStack
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_NEWSLETTER);

  $newsletter_query = tep_db_query("select affiliate_newsletter from " . TABLE_AFFILIATE . " where affiliate_id = '" . (int)$affiliate_id . "'");
  $newsletter = tep_db_fetch_array($newsletter_query);

  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    if (isset($_POST['newsletter_affiliate']) && is_numeric($_POST['newsletter_affiliate'])) {
      $newsletter_affiliate = tep_db_prepare_input($_POST['newsletter_affiliate']);
    } else {
      $newsletter_affiliate = '0';
    }

    if ($newsletter_affiliate != $newsletter['affiliate_newsletter']) {
      $newsletter_affiliate = (($newsletter['affiliate_newsletter'] == '1') ? '0' : '1');

      tep_db_query("update " . TABLE_AFFILIATE . " set affiliate_newsletter = '" . (int)$newsletter_affiliate . "' where affiliate_id = '" . (int)$affiliate_id . "'");
    }

    $messageStack->add_session('account', SUCCESS_NEWSLETTER_UPDATED, 'success');

    tep_redirect(tep_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL'));
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_AFFILIATE_NEWSLETTER, '', 'SSL'));
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<?php echo tep_draw_form('account_newsletter', tep_href_link(FILENAME_AFFILIATE_NEWSLETTER, '', 'SSL')) . tep_draw_hidden_field('action', 'process'); ?>
 <h1><?php echo HEADING_TITLE; ?></h1>
<div class="contentContainer">
  <div class="contentText">
    <?php echo MY_NEWSLETTERS_TITLE; ?>
  </div>
   <div class="contentText">
     <p><?php echo tep_draw_checkbox_field('newsletter_affiliate', '1', (($newsletter['affiliate_newsletter'] == '1') ? true : false), 'onclick="checkBox(\'newsletter_affiliate\')"'); ?></p>
     <p><strong><?php echo MY_NEWSLETTERS_AFFILIATE_NEWSLETTER; ?></strong></p>
     <p><?php echo MY_NEWSLETTERS_AFFILIATE_NEWSLETTER_DESCRIPTION; ?></p>
</div>

  <div class="buttonSet">
     <span float: right;><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e'); ?></span>
 </div>
 </div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>