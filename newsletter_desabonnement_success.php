<?php
/*
  $Id: newsletter_desabonnement_success.php le 05 Avril 2012

  Auteur : Brouillard s'embrouille (brouillard-sembrouille@laposte.net)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSLETTER_DESABONNEMENT);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_NEWSLETTER_DESABONNEMENT));

  $desabonnement_email = tep_db_prepare_input($_POST['desabonnementemail']);
  $desabonnement_id = tep_db_prepare_input($_POST['desabonnementid']);

  $desabonnement_query = tep_db_query("select abonnement_addresse_email from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_newsletter = '1' and abonnement_addresse_email = '" . $desabonnement_email . "' and abonnement_id = '" . $desabonnement_id . "'");
  $desabonnement_values = tep_db_fetch_array($desabonnement_query);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
          <?php
            if ($desabonnement_values['abonnement_addresse_email'] != '') {

// Desabonnement du mail de la table des inscrits
//             $sql_data_array = array('abonnement_newsletter' => '0');
//              tep_db_perform(TABLE_NEWSLETTER_ABONNEMENT, $sql_data_array, 'update', "abonnement_addresse_email = '" . tep_db_input($desabonnement_email) . "' and abonnement_id = '" . tep_db_input($desabonnement_id) . "'");

// Suppression du mail de la table des inscrits
             tep_db_query("delete from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_addresse_email = '" . tep_db_input($desabonnement_email) . "' and abonnement_id = '" . tep_db_input($desabonnement_id) . "'");

// recevoir un mail de desinscription
            if (PREVENIR_EMAIL_DESINSCRIT_NL == 'oui') {
             tep_mail('', STORE_OWNER_EMAIL_ADDRESS, EMAIL_DESINSCRIT_NL, $desabonnement_email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
            }

             echo '<div class="contentText">' . sprintf(DESABONNEMENT_TEXT_OK, $desabonnement_email) . '</div>';
             } else {

             echo '<div class="contentText">' . sprintf(DESABONNEMENT_TEXT_ERROR, $desabonnement_email) . '</div>';
             }
           ?>

  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?></span>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
