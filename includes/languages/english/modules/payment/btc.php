<?php
/*
  $Id: btc.php,v 1.0 2014/01/25 13:49

  for CRE Loaded & OSCommerce
  by Marc Rogivue www.KULTUhR.net marc@rogivue.com
  If this Module is helpful to you, please consider to pay me a drink, or two: 
  My BTC address 17KRpq5u2GaStjiF2h3Vja9VvKwVnC3THD
  
  Released under the GNU General Public License 
*/
define('MODULE_PAYMENT_BTC_TEXT_TITLE', 'Pagar con Bitcoin, Bnb');
define('MODULE_PAYMENT_BTC_TEXT_DESCRIPTION',  'Pagadero a: ' . MODULE_PAYMENT_BTC_PAYTO . '<br><br>' . '<img src= "' . HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . DIR_WS_IMAGES . MODULE_PAYMENT_BTC_PAYTO . '.png" width="250" height="250" border="0" />' . '<br><br>' . 'Ejecutaremos su pedido en cuento recibamos el pago.');
define('MODULE_PAYMENT_BTC_TEXT_EMAIL_FOOTER', 'Pagadero a: ' . MODULE_PAYMENT_BTC_PAYTO . "\n\n"     . '<img src= "' . HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . DIR_WS_IMAGES . MODULE_PAYMENT_BTC_PAYTO . '.png" width="250" height="250" border="0" />' .  "\n\n"    . 'Ejecutaremos su pedido en cuento recibamos el pago.');
?>
