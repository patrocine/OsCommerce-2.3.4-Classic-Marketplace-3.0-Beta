<?php
/*
  $Id: ask_a_question.php,v 2.3.4 2013/06/25 18:20:39 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  
*/



define('NAVBAR_TITLE', 'Hacer Pregunta');

define('HEADING_TITLE', 'Ask a question about the:');

define('FORM_TITLE_CUSTOMER_DETAILS', '');
define('FORM_TITLE_FRIEND_MESSAGE', 'Preguntar');

define('FORM_FIELD_CUSTOMER_NAME', 'Tu Nombre:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Direccion Email:');


define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Su pregunta sobre <strong>%s</strong> se ha enviado correctamente...');

define('TEXT_EMAIL_SUBJECT', 'Una pregunta de %s');
define('TEXT_EMAIL_INTRO', '%s' . "\n\n" . 'El Cliente, %s, tiene una pregunta sobre: %s - %s.');
define('TEXT_EMAIL_LINK', 'Aquí enlace del Producto:' . "\n\n" . '%s');
define('TEXT_EMAIL_SIGNATURE', 'Recuerdos,' . "\n\n" . '%s');

define('ERROR_FROM_NAME', 'Error: El campo del nombre no puede estar vacío.');
define('ERROR_FROM_ADDRESS', 'Error: Su direccion de correo electronico debe ser una direccion email válida.');
define('ERROR_MESSAGE', 'Error: No has logrado introducir la pregunta');
define('ERROR_HAS_LINK', 'Error: un enlace al producto que usted tiene una pregunta acerca de que ya se está incluido en el mensaje No se permiten otros enlaces');
define('ERROR_INVALID_ACCESS', 'Error: acceso de archivo no válido');
?>
