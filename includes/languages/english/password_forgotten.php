<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Entrar');
define('NAVBAR_TITLE_2', 'Constrase&ntilde;a olvidada');

define('HEADING_TITLE', '¡He olvidado mi contrase&ntilde;a!');

define('TEXT_MAIN', 'Si ha olvidado su contrase&ntilde;a, introduzca su email y le enviaremos un email con una contrase&ntilde;a nueva.');

define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Error: ese email no figura en nuestra base de datos, int&eacute;ntelo de nuevo.');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', 'Nueva clave de acceso para ' . STORE_NAME);
define('EMAIL_PASSWORD_REMINDER_BODY', 'Ha solicitado una nueva clave de acceso desde ' . $REMOTE_ADDR . '.' . "\n\n" . 'Su nueva clave de acceso para \'' . STORE_NAME . '\' es:' . "\n\n\n\n" . '   %s' . "\n\n");

define('SUCCESS_PASSWORD_SENT', 'Se ha enviado una nueva contrase&ntilde;a a su email');
?>
