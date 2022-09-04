<?php
/*
 $Id: inpay.php VER: 1.0.3443 $
 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com
 Copyright (c) 2008 osCommerce
 Released under the GNU General Public License
 */

  define('MODULE_PAYMENT_INPAY_TEXT_TITLE', 'Inpay - transferencias bancarias instantaneas online');
  define('MODULE_PAYMENT_INPAY_TEXT_PUBLIC_TITLE', 'Pague con su banco online - instantaneo y 100% seguro');
  define('MODULE_PAYMENT_INPAY_TEXT_PUBLIC_HTML', '<img src="https://resources.inpay.com/images/oscommerce/inpay_checkout.png" alt="Pago seguro usando inpay" /><br /><br />
  <table cellspacing="5">
  	  <tr><td><img src="https://resources.inpay.com/images/oscommerce/inpay_check.png" alt="Pagos 100% seguro usando inpay" /></td><td class="main">Pagos 100% seguro usando inpay <span style="color: #666;">- nuestro nivel de seguridad coincide con la seguridad de su banco online</span></td></tr>
  	  <tr><td><img src="https://resources.inpay.com/images/oscommerce/inpay_check.png" alt="Pagos instantaneos usando inpay" /></td><td class="main">Pagos instantaneos usando inpay <span style="color: #666;">- nuestro sistema se asegura de que usted recibira su pedido tan pronto como sea posible.</span></td></tr>
  	  <tr><td><img src="https://resources.inpay.com/images/oscommerce/inpay_check.png" alt="Pagos anonimos usando inpay" /></td><td class="main">Pagos anonimos usando inpay <span style="color: #666;">- sin necesidad de compartir su numero de tarjeta de credito o cualquier otra informacion personal.</span></td></tr>
  </table><a href="http://inpay.com/shoppers" style="text-decoration: underline;" target="_blank" class="main">Click aqui para leer mas acerca de inpay</a><br />');
  define('MODULE_PAYMENT_INPAY_TEXT_DESCRIPTION', '<strong>Que es inpay?</strong><br />
  	  inpay es una opcion de pago adicional para tiendas virtuales, que permite a los clientes pagar con su banco online - al instante y en todo el mundo<br />
  	  <br />
  	  <strong>Aumente los beneficios</strong><br />
	Al permitir a los compradores pagar con su banco online, ahora puede vender a clientes que de otro modo no pueden o no quieren pagar de otra manera<br />
<br />
<strong>Aumente cuota de mercado</strong><br />
Al ofrecer a sus clientes la opcion de pago a traves de inpay aumenta su cuota de mercado no solo a los propietarios de tarjetas de credito, tambien a los usuarios de banca online de todo el mundo<br />
<br />
<strong>Sin riesgos</strong><br />
Con inpay no hay riesgo de fraude con tarjetas de credito o cualquier tipo de devoluciones del cargo. Esto significa que cuando le pagan esta pagado! Con inpay incluso se puede vender a clientes de las regiones de \'alto riesgo\' de todas partes, incluidas Africa, Asia y Europa del Este.<br /><br />
  <a href="http://inpay.com/" style="text-decoration: underline;" target="_blank">Mas informacion o registrarse en inpay.com (en ingles)</a><br />');
  // ------------- e-mail settings ---------------------------------
  define('EMAIL_TEXT_SUBJECT', 'Pago confirmado por inpay');
  define('EMAIL_TEXT_ORDER_NUMBER', 'Pedido numero:');
  define('EMAIL_TEXT_INVOICE_URL', 'Detalle factura:');
  define('EMAIL_TEXT_DATE_ORDERED', 'Fecha pedido:');
  define('EMAIL_TEXT_PRODUCTS', 'Productos');
  define('EMAIL_TEXT_SUBTOTAL', 'Subtotal:');
  define('EMAIL_TEXT_TAX', 'Impuestos:        ');
  define('EMAIL_TEXT_SHIPPING', 'Envio: ');
  define('EMAIL_TEXT_TOTAL', 'Total:    ');
  define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Direccion de envio');
  define('EMAIL_TEXT_BILLING_ADDRESS', 'Direccion de facturacion');
  define('EMAIL_TEXT_PAYMENT_METHOD', 'Forma de pago');
  define('EMAIL_SEPARATOR', '------------------------------------------------------');
  define('TEXT_EMAIL_VIA', 'via'); 
  
?>