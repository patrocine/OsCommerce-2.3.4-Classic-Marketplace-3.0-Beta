<?php
/*
  $Id: newsletter_abonnement.php le 05 Avril 2012

  Auteur : Brouillard s'embrouille (brouillard-sembrouille@laposte.net)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Newsletters');
define('HEADING_TITLE', 'Subcripción');

define('TEXT_INFORMATION', '<strong>Gracias por subcribirse a nuestras ofertas y liquidaciones.</strong><br />Su email ha sido guardado correctamente.');

define('EMAIL_WELCOME_SUBJECT', 'Bienvenido a ' . STORE_NAME);

define('EMAIL_WELCOME', 'Gracias por subcribirse a ' . STORE_NAME . ' <br /><br />Será el primero en estar informado de nuestras ofertas y liquidaciones en el mismo momento que las publiquemos. <br /><br />');

define('TEXT_PRIVACY_EMAIL', '<br /><br />La información que nos facilite es confidencial, puede ver nuestra politica de privacidad en este link: ' . '<a href="' . tep_href_link(FILENAME_PRIVACY, '', 'NONSSL') . '">' . tep_href_link(FILENAME_PRIVACY, '', 'NONSSL') . '</a>');

define('NL_DESABONNEMENT_LINK', '<br /><br />Cancelar Subcripción:<br /><a href="' . tep_href_link(FILENAME_NEWSLETTER_DESABONNEMENT, '%s', 'NONSSL') . '">' . tep_href_link(FILENAME_NEWSLETTER_DESABONNEMENT, '%s', 'NONSSL') . '</a>');

define('TEXT_EMAIL_HTML', 'HTML');
define('TEXT_EMAIL_TXT', 'Text');

define('PREVENIR_EMAIL_NEW_INSCRIT_NL', 'oui');
define('EMAIL_NEW_INSCRIT_NL', 'A new subscribe to the Newsletter');

//mis en page html-----------------------------------------------
define('EMAIL_START_HTML', '<html><head> </head><body>');
define('EMAIL_STOP_HTML', '<br /></body></html>');
define('EMAIL_SPAN_START_STYLE', '<span style="font-family:Verdana, Arial, sans-serif; font-size:12px;">');
define('EMAIL_SPAN_STOP_STYLE', '</span>');
//fin mis en page html-----------------------------------------------
?>
