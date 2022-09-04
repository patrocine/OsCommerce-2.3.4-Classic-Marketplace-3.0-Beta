<?php
/*
  $Id: newsletter_abonnement.php le 05 Avril 2012

  Auteur : Brouillard s'embrouille (brouillard-sembrouille@laposte.net)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

   require('includes/application_top.php');
   require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSLETTER_ABONNEMENT);

  $email_abonnement = tep_db_prepare_input(strtolower(str_replace("'", "", $_POST['emailabonnement'])));

  $inscrits_check_query = tep_db_query("select count(*) as checkinscrits from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_addresse_email = '" . $email_abonnement . "' ");
  $inscrits_check_values = tep_db_fetch_array($inscrits_check_query);

  if ( ($inscrits_check_values['checkinscrits']=='0') && ($email_abonnement != '') ) {
    $sql_data_array = array('abonnement_addresse_email' => $email_abonnement,
                            'abonnement_date_creation' => 'now()',
                            'abonnement_newsletter' => '1');
    tep_db_perform(TABLE_NEWSLETTER_ABONNEMENT, $sql_data_array);
    $insert_id = tep_db_insert_id();

    $email_desabonnement = str_replace('@', '4r0b6s3', $email_abonnement);

    $message = EMAIL_START_HTML;
    $message .= EMAIL_SPAN_START_STYLE;
    $message .= EMAIL_WELCOME . TEXT_PRIVACY_EMAIL . sprintf(NL_DESABONNEMENT_LINK, 'emaildesabonnement=' . $email_desabonnement . '&iID='. $insert_id, 'emaildesabonnement=' . $email_desabonnement . '&iID='. $insert_id);
    $message .= EMAIL_SPAN_STOP_STYLE;
    $message .= EMAIL_STOP_HTML;
   tep_mail('', $email_abonnement, EMAIL_WELCOME_SUBJECT, $message, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

// recevoir un mail d'une nouvelle inscription
    if (PREVENIR_EMAIL_NEW_INSCRIT_NL == 'oui') {
     tep_mail('', STORE_OWNER_EMAIL_ADDRESS, EMAIL_NEW_INSCRIT_NL, $email_abonnement, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
    }
   }

  tep_redirect(tep_href_link(FILENAME_NEWSLETTER_ABONNEMENT_SUCCESS, '', 'NONSSL'));

?>