<?php
/*
  $Id: moneyorder.php,v 1.7 2003/01/24 21:36:05 thomasamoulton Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Transferencia Bancaria, En cuanto le confirmemos la disponibilidad de todos los productos del pedido le enviaremos los datos bancarios donde realizar el pago.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Poner en Observaciones del Pago:&nbsp;' . $insert_id . ' El número de este pedido <br><br>Enviar a<br>' . nl2br(STORE_BANK_ADDRESS_MODULES) . '<br><br>' . '&nbsp;Su pedido se enviará en cuanto se reciba el pago.<p>
Si es posible envíenos una copia, o simplemente una pequeña nota como que ya
realizo la transferencia al mail <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '"> ' . STORE_OWNER_EMAIL_ADDRESS . '</a></p>');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Poner en Observaciones del Pago: ". $insert_id . " El número de este pedido  \n Enviar a\n" . STORE_BANK_ADDRESS_MODULES . "\n\n" . 'Su pedido se enviará en cuanto se reciba el pago.');
?>
