<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Enviar a un amigo');

define('HEADING_TITLE', 'Enviar informaci&oacute;n sobre \'%s\' a un amigo/a');

define('FORM_TITLE_CUSTOMER_DETAILS', 'Sus datos');
define('FORM_TITLE_FRIEND_DETAILS', 'Los datos de su amigo/a');
define('FORM_TITLE_FRIEND_MESSAGE', 'Su mensaje');

define('FORM_FIELD_CUSTOMER_NAME', 'Su nombre:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Su email:');
define('FORM_FIELD_FRIEND_NAME', 'El nombre de su amigo/a:');
define('FORM_FIELD_FRIEND_EMAIL', 'El email de su amigo/a:');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Su email sobre <b>%s</b> ha sido enviado a <b>%s</b>.');

define('TEXT_EMAIL_SUBJECT', 'Su amigo %s le quiere recomendar "%s" de la tienda online ' . STORE_NAME);
define('TEXT_EMAIL_INTRO', '¡Hola %s!' . "\n\n" . 'su amigo %s pens&oacute; que estar&iacute;a interesado/a en %s de la tienda online ' STORE_NAME);
define('TEXT_EMAIL_LINK', 'Para ver el producto usa el siguiente enlace:' . "\n\n\n" . '%s');
define('TEXT_EMAIL_SIGNATURE', 'Atentamente,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'El email de su amigo/a no puede estar vac&iacute;o.');
define('ERROR_TO_ADDRESS', 'El email de su amigo/a debe ser v&aacute;lido.');
define('ERROR_FROM_NAME', 'Su nombre no puede estar vac&iacute;o.');
define('ERROR_FROM_ADDRESS', 'Su email debe de ser v&aacute;lido.');
define('ERROR_ACTION_RECORDER', 'Un email ya ha sido enviado. Por favor, int&eacute;ntelo de nuevo en %s minutos.');
?>
