<?php
/*
$Id: edit_orders.php,v 2.0 2006/03/14 10:42:44 ams Exp $
spanish

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright © 2006 osCommerce

Released under the GNU General Public License

Translation provided by banachek
*/

define('HEADING_TITLE', 'Editar Pedido');
define('HEADING_TITLE_NUMBER', 'Nr.');
define('HEADING_TITLE_DATE', 'del');
define('HEADING_SUBTITLE', 'Modificar los campos necesarios y pulsar el botón "Actualizar" del final de la página.');
define('HEADING_TITLE_STATUS', 'Estado');
define('ADDING_TITLE', 'Añadir un producto al pedido');

define('HINT_UPDATE_TO_CC', '<span style="color: red;">Aviso: </span>Set payment to "Credit Card" to show some additional fields.');
define('HINT_DELETE_POSITION', '<span style="color: red;">Aviso: </span>Para borrar un artículo poner a "0" la cantidad.<br />Si cambia el precio del artículo con una opción de producto, debe calcular el nuevo costo manualmente.');
define('HINT_TOTALS', '<span style="color: red;">Aviso: </span>Para aplicar descuentos añada importes negativos a la lista.<br />Los campos con importe a "0" se borrarán al actualizar el pedido (excepto el envío).');
define('HINT_PRESS_UPDATE', 'Por favor, haga click en "Actualizar" para guardar todos los cambios.');

define('TABLE_HEADING_COMMENTS', 'Comentarios');
define('TABLE_HEADING_STATUS', 'Nuevo estado');
define('TABLE_HEADING_QUANTITY', 'Cant.');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Modelo');
define('TABLE_HEADING_PRODUCTS', 'Producto');
define('TABLE_HEADING_TAX', '% IVA');
define('TABLE_HEADING_UNIT_PRICE', 'Precio (excl.)');
define('TABLE_HEADING_UNIT_PRICE_TAXED', 'Precio (incl.)');
define('TABLE_HEADING_TOTAL_PRICE', 'Total (excl.)');
define('TABLE_HEADING_TOTAL_PRICE_TAXED', 'Total (incl.)');
define('TABLE_HEADING_TOTAL_MODULE', 'Total Precio Componente');
define('TABLE_HEADING_TOTAL_AMOUNT', 'Importe');
define('TABLE_HEADING_DELETE', '¿Cancelación?');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Notificación al cliente');
define('TABLE_HEADING_DATE_ADDED', 'Fecha de pedido');

define('ENTRY_CUSTOMER_NAME', 'Nombre');
define('ENTRY_CUSTOMER_COMPANY', 'Empresa');
define('ENTRY_CUSTOMER_ADDRESS', 'Dirección del cliente');
define('ENTRY_CUSTOMER_SUBURB', 'Suburb');
define('ENTRY_CUSTOMER_CITY', 'Población');
define('ENTRY_CUSTOMER_STATE', 'Estado');
define('ENTRY_CUSTOMER_POSTCODE', 'Código postal');
define('ENTRY_CUSTOMER_COUNTRY', 'País');
define('ENTRY_CUSTOMER_PHONE', 'Teléfono');
define('ENTRY_CUSTOMER_EMAIL', 'e-Mail');
define('ENTRY_ADDRESS', 'Dirección');

define('ENTRY_SHIPPING_ADDRESS', 'Dirección de envío');
define('ENTRY_BILLING_ADDRESS', 'Dirección de facturación');
define('ENTRY_PAYMENT_METHOD', 'Forma de pago:');
define('ENTRY_CREDIT_CARD_TYPE', 'Tipo de tarjeta:');
define('ENTRY_CREDIT_CARD_OWNER', 'Titular de la tarjeta:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Número de tarjeta:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Caducidad tarjeta:');
define('ENTRY_SUB_TOTAL', 'Sub Total:');
define('ENTRY_TAX', 'IVA:');
define('ENTRY_TOTAL', 'Total:');
define('ENTRY_STATUS', 'Estado del pedido:');
define('ENTRY_NOTIFY_CUSTOMER', 'Notificar al cliente:');
define('ENTRY_NOTIFY_COMMENTS', 'Enviar comentarios:');

define('TEXT_NO_ORDER_HISTORY', 'Pedido no existe');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Su pedido ha sido actualizado');
define('EMAIL_TEXT_ORDER_NUMBER', 'Número de pedido:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice URL:');
define('EMAIL_TEXT_DATE_ORDERED', 'Fecha de pedido:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Muchas gracias por su pedido!' . "\n\n" . 'El estado de su pedido ha sido actualizado.' . "\n\n" . 'Nuevo estado: %s' . "\n\n");
define('EMAIL_TEXT_STATUS_UPDATE2', 'Si tiene cualquier pregunta, por favor, esponda a este correo.' . "\n\n" . 'Reciba un saludo de sus amigos de ' . STORE_NAME . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Estos son los comentarios sobre su pedido:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Error: No existe el pedido.');
define('SUCCESS_ORDER_UPDATED', 'Completado: El pedido ha sido actualizado correctamente.');

define('ADDPRODUCT_TEXT_CATEGORY_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_SELECT_PRODUCT', 'Escoja un producto');
define('ADDPRODUCT_TEXT_PRODUCT_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_SELECT_OPTIONS', 'Escoja una opción');
define('ADDPRODUCT_TEXT_OPTIONS_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_OPTIONS_NOTEXIST', 'El producto no tiene opciones');
define('ADDPRODUCT_TEXT_CONFIRM_QUANTITY', 'Unidades del producto');
define('ADDPRODUCT_TEXT_CONFIRM_ADDNOW', 'Añadir');
define('ADDPRODUCT_TEXT_STEP', 'Paso');
define('ADDPRODUCT_TEXT_STEP1', ' &laquo; Seleccionar una categoria. ');
define('ADDPRODUCT_TEXT_STEP2', ' &laquo; Seleccionar un producto. ');
define('ADDPRODUCT_TEXT_STEP3', ' &laquo; Seleccionar una opción. ');

define('MENUE_TITLE_CUSTOMER', '1. Datos del cliente');
define('MENUE_TITLE_PAYMENT', '2. Forma de pago');
define('MENUE_TITLE_ORDER', '3. Productos del pedido');
define('MENUE_TITLE_TOTAL', '4. Descuento, envío y total');
define('MENUE_TITLE_STATUS', '5. Estado y notificaciones');
define('MENUE_TITLE_UPDATE', '6. Actualizar datos');
?>
