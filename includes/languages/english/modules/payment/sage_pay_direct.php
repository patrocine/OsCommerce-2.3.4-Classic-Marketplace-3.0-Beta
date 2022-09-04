<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_TEXT_TITLE', 'Sage Pay Direct');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_TEXT_PUBLIC_TITLE', 'Tarjeta de credito (procesado por Sage Pay)');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://support.sagepay.com/apply/default.aspx?PartnerID=C74D7B82-E9EB-4FBD-93DB-76F0F551C802&PromotionCode=osc223" target="_blank" style="text-decoration: underline; font-weight: bold;">Visite la web de Sage Pay</a>&nbsp;<a href="javascript:toggleDivBlock(\'sagePayInfo\');">(info)</a><span id="sagePayInfo" style="display: none;"><br /><i>Con el uso del link para usar Sage Pay osCommerce da a cada cliente otra opcion mas de pago.</i></span>');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_TYPE', 'Tipo de tarjeta de credito:');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_OWNER', 'Titular de la tarjeta:');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_NUMBER', 'Numero de la tarjeta:');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_STARTS', 'Fecha de inicio de la tarjeta:');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_STARTS_INFO', '(solo para tarjetas Maestro, Solo y American Express)');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_EXPIRES', 'Fecha de caducidad:');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_ISSUE_NUMBER', 'Numero de tarjeta de credito:');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_ISSUE_NUMBER_INFO', '(solo para tarjetas Maestro y Solo)');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_CREDIT_CARD_CVC', 'Codigo de seguridad de la tarjeta (CVC):');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_3DAUTH_TITLE', 'Verificacion 3D Secure');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_3DAUTH_INFO', 'Clic en el boton Continuar para autentificar su tarjeta en la web de su banco.');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_3DAUTH_BUTTON', 'CONTINUAR');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_TITLE', 'Se ha producido un error al procesar su tarjeta de credito');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_GENERAL', 'Intentelo de nuevo y si el problema persiste intente otra forma de pago.');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_CARDTYPE', 'El tipo de tarjeta no es compatible. Por favor, intentelo de nuevo con otra tarjeta y si el problema persiste intente otra forma de pago.');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_CARDOWNER', 'Debe proporcionar el nombre del titular de la tarjeta para completar el pedido, intentelo de nuevo y si el problema persiste intente otra forma de pago');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_CARDNUMBER', 'El numero de la tarjeta no pudo ser procesado, intentelo de nuevo y si el problema persiste intente otra forma de pago.');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_CARDSTART', 'La fecha de inicio de la tarjeta no pudo ser procesada, intentelo de nuevo y si el problema persiste intente otra forma de pago.');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_CARDEXPIRES', 'La fecha de caducidad de la tarjeta no pudo ser procesada, intentelo de nuevo y si el problema persiste intente otra forma de pago.');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_CARDISSUE', 'La numero de la tarjeta no pudo ser procesado, intentelo de nuevo y si el problema persiste intente otra forma de pago.');
  define('MODULE_PAYMENT_SAGE_PAY_DIRECT_ERROR_CARDCVC', 'El codigo de seguridad de la tarjeta (CVC) no pudo ser procesado, intentelo de nuevo y si el problema persiste intente otra forma de pago.');
?>
