<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $moneybookers_ping_button = '';
  if (defined('MODULE_PAYMENT_MONEYBOOKERS_STATUS') && tep_not_null(MODULE_PAYMENT_MONEYBOOKERS_SECRET_WORD)) {
    $moneybookers_ping_button = '<p><img src="images/icons/locked.gif" border="0">&nbsp;<a href=' . tep_href_link('ext/modules/payment/moneybookers/activation.php', 'action=testSecretWord', 'SSL') . ' style="text-decoration: underline; font-weight: bold;">Prueba palabra secreta</a></p>';
  }

  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_TITLE', 'Moneybookers - Modulo principal');
  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_PUBLIC_TITLE', 'Moneybookers eWallet (monedero electronico)');
  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="http://www.moneybookers.com/partners/oscommerce" target="_blank" style="text-decoration: underline; font-weight: bold;">Visite la web de Moneybookers</a>' . $moneybookers_ping_button);
  define('MODULE_PAYMENT_MONEYBOOKERS_RETURN_TEXT', 'Continuar y regresar a ' . STORE_NAME);
  define('MODULE_PAYMENT_MONEYBOOKERS_LANGUAGE_CODE', 'ES');

  define('MB_ACTIVATION_TITLE', 'Activacion de la cuenta Moneybookers');
  define('MB_ACTIVATION_ACCOUNT_TITLE', 'Verificar cuenta');
  define('MB_ACTIVATION_ACCOUNT_TEXT', 'La activacion de Moneybookers Quick Checkout le permite recibir los pagos directos de tarjetas de credito, debito y de mas de 60 otras opciones de pago locales en mas de 200 paises, asi como Moneybookers eWallet.<br /><br />Para tener acceso a la red de pagos internacionales de Moneybookers <a href="http://www.moneybookers.com/partners/oscommerce" target="_blank">registrese aqui</a> para obtener una cuenta gratuita si aun no tiene una');
  define('MB_ACTIVATION_EMAIL_ADDRESS', 'email de cuenta Moneybookers:');
  define('MB_ACTIVATION_ACTIVATE_TITLE', 'Activacion de la cuenta');
  define('MB_ACTIVATION_ACTIVATE_TEXT', 'Una solicitud de activacion ha sido enviada a Moneybookers. Por favor, tenga en cuenta que el proceso de verificacion para utilizar Moneybookers Quick Checkout puede tardar hasta 72 horas. <strong>Usted sera contactado por Moneybookers cuando el proceso de verificacion se haya completado.</strong><br /><br /><i>Despues de la activacion Moneybookers le dara acceso a una nueva seccion en su cuenta de Moneybookers denominada "Herramientas de vendedor". Por favor, elija una palabra secreta (no utilice la contraseña para esto) e insertela en la seccion de herramientas comerciales y en la configuracion del modulo de pago de la siguiente pagina.</i>');
  define('MB_ACTIVATION_NONEXISTING_ACCOUNT_TITLE', 'Error de cuenta');
  define('MB_ACTIVATION_NONEXISTING_ACCOUNT_TEXT', 'El email no tiene una cuenta registrada en Moneybookers. Por favor <a href="http://www.moneybookers.com/partners/oscommerce" target="_blank">registrese aqui</a> para comenzar a vender con Moneybookers.');
  define('MB_ACTIVATION_SECRET_WORD_TITLE', 'Prueba palabra secreta');
  define('MB_ACTIVATION_SECRET_WORD_SUCCESS_TEXT', 'La palabra secreta se ha configurado <strong>correctamente</strong>! Ahora las transacciones pueden ser verificadas de forma segura con la pasarela de pago');
  define('MB_ACTIVATION_SECRET_WORD_FAIL_TEXT', 'La configuracion de la palabra secreta <strong>ha fallado</strong>! Por favor, revise la palabra secreta en "Herramientas de vendedor" de su cuenta Moneybookers y en la configuracion del modulo de pago.');
  define('MB_ACTIVATION_SECRET_WORD_ERROR_TITLE', 'Error');
  define('MB_ACTIVATION_SECRET_WORD_ERROR_EXCEEDED', 'Ha superado el numero maximo de intentos. Por favor, intentelo de nuevo en una hora');
  
  define('MB_ACTIVATION_CORE_REQUIRED_TITLE', 'Modulo principal de Moneybookers necesario');
  define('MB_ACTIVATION_CORE_REQUIRED_TEXT', 'El modulo principal de pagos Moneybookers es necesario para el soporte de las opciones de pago de Moneybookers Quick Checkout. Por favor, continue para instalar y configurar el modulo de pago principal.');
  define('MB_ACTIVATION_VERIFY_ACCOUNT_BUTTON', 'Verificar cuenta');
  define('MB_ACTIVATION_CONTINUE_BUTTON', 'Continuar y configurar el modulo de pago');
  define('MB_ACTIVATION_SUPPORT_TITLE', 'Soporte');
  define('MB_ACTIVATION_SUPPORT_TEXT', 'Tiene alguna pregunta? Contacte con Moneybookers por email en <a href="mailto: ecommerce@moneybookers.com">ecommerce@moneybookers.com</a> o por telefono +44 (0) 870 383 0762. Su pregunta ya puede estar respondida en el <a href="http://forums.oscommerce.com/forum/78-moneybookers/" target="_blank">foro de ayuda de la comunidad osCommerce</a>.');
?>
