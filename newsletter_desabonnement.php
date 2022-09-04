<?php
/*
  $Id: newsletter_desabonnement.php le 05 Avril 2012

  Auteur : Brouillard s'embrouille (brouillard-sembrouille@laposte.net)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSLETTER_DESABONNEMENT);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_NEWSLETTER_DESABONNEMENT));

  $nlmail_search_chars = array('/4r0b6s3/', '/\'/');
  $nlmail_replace_chars = array('@', '');

  $desabonnement_email = tep_db_prepare_input(strtolower(preg_replace($nlmail_search_chars, $nlmail_replace_chars, $_GET['emaildesabonnement'])));
  $desabonnement_id = tep_db_prepare_input($_GET['iID']);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
  <div class="contentText">
    <?php echo DESABONNEMENT_TEXT_INFORMATION; ?>
  </div>

  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_form('form_newsletterdesabonnement', tep_href_link(FILENAME_NEWSLETTER_DESABONNEMENT_SUCCESS, '', 'NONSSL'), 'post', '') . tep_draw_hidden_field('desabonnementemail', $desabonnement_email, '') . tep_draw_hidden_field('desabonnementid', (int)$desabonnement_id, '') . tep_draw_button(IMAGE_BUTTON_NEWSLETTER_DESABONNEMENT, 'triangle-1-e', null, 'primary'); ?></span>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
