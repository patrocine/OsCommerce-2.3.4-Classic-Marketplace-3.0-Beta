<?php
/*
  $Id: psigate.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_PSIGATE_TEXT_TITLE', 'PSiGate');
  define('MODULE_PAYMENT_PSIGATE_TEXT_DESCRIPTION', 'Tarjeta de credito para pruebas:<br><br>Numero: 4111111111111111<br>Caducidad: cualquiera');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_OWNER', 'Titular de la tarjeta:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_NUMBER', 'Numero de la tarjeta:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_EXPIRES', 'Fecha de caducidad:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_TYPE', 'Tipo de tarjeta:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_JS_CC_NUMBER', '* El numero de la tarjeta de credito debe de tener al menos ' . CC_NUMBER_MIN_LENGTH . ' numeros.\n');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR_MESSAGE', 'Ha ocurrido un error procesando su tarjeta de credito, intentelo de nuevo.');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR', 'Error en tarjeta de credito!');
?>
