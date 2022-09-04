<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Busqueda Avanzada');
define('NAVBAR_TITLE_2', 'Resultados de la Busqueda');

define('HEADING_TITLE_1', 'Busqueda Avanzada');
define('HEADING_TITLE_2', 'Productos que satisfacen los criterios de b&uacute;squeda');

define('HEADING_SEARCH_CRITERIA', 'Busqueda Avanzada');

define('TEXT_SEARCH_IN_DESCRIPTION', 'Buscar también en la descripción');
define('ENTRY_CATEGORIES', 'Categorías:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'Incluir subcategorías');
define('ENTRY_MANUFACTURERS', 'Fabricante:');
define('ENTRY_PRICE_FROM', 'Desde precio:');
define('ENTRY_PRICE_TO', 'a precio:');
define('ENTRY_DATE_FROM', 'Desde la fecha:');
define('ENTRY_DATE_TO', 'Hasta la fecha:');

define('TEXT_SEARCH_HELP_LINK', '<u>Ayuda</u> [?]');

define('TEXT_ALL_CATEGORIES', 'Todas');
define('TEXT_ALL_MANUFACTURERS', 'Todos');

define('HEADING_SEARCH_HELP', 'Consejos para b&uacute;squeda avanzada');
define('TEXT_SEARCH_HELP', 'El motor de b&uacute;squeda le permite hacer una b&uacute;squeda por palabras clave en el modelo, nombre y descripci&oacute;n del producto y en el nombre del fabricante.<br><br>Cuando haga una b&uacute;squeda por palabras o frases clave, puede separar estas con los operadores l&oacute;gicos AND y OR. Por ejemplo, puede hacer una b&uacute;squeda por <u>anillo AND pendientes</u>. Esta b&uacute;squeda dar&iacute;a como resultado los productos que contengan ambas palabras. Por el contrario, si teclea  <u>anillo OR pendientes</u>, conseguir&aacute; una lista de los productos que contengan las dos o solo una de las palabras. Si no se separan las palabras o frases clave con AND o con OR, la b&uacute;squeda se har&aacute; usando por defecto el operador l&oacute;gico AND.<br><br>Puede realizar b&uacute;squedas exactas de varias palabras encerr&aacute;ndolas entre comillas. Por ejemplo, si busca <u>"reloj caballero"</u>, obtendr&aacute; una lista de productos que tengan exactamente esa cadena en ellos.<br><br>Se pueden usar par&eacute;tensis para controlar el orden de las operaciones l&oacute;gicas. Por ejemplo, puede introducir <u>conjunto and (pendientes or colgante or anillo)</u>.');
define('TEXT_CLOSE_WINDOW', '<u>Cerrar ventana</u> [x]');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Modelo');
define('TABLE_HEADING_PRODUCTS', 'Descripci&oacute;n');
define('TABLE_HEADING_MANUFACTURER', 'Fabricante');
define('TABLE_HEADING_QUANTITY', 'Cantidad');
define('TABLE_HEADING_PRICE', 'Precio');
define('TABLE_HEADING_WEIGHT', 'Peso');
define('TABLE_HEADING_BUY_NOW', 'Compre ahora');

define('TEXT_NO_PRODUCTS', 'No hay productos que corresponden con los criterios de b&uacute;squeda.');

define('ERROR_AT_LEAST_ONE_INPUT', 'Debe introducir al menos un criterio de b&uacute;squeda.');
define('ERROR_INVALID_FROM_DATE', 'La fecha de alta desde es inv&aacute;lida');
define('ERROR_INVALID_TO_DATE', 'La fecha de alta hasta es inv&acute;lida');
define('ERROR_TO_DATE_LESS_THAN_FROM_DATE', 'Fecha de alta hasta debe ser mayor que fecha de alta desde');
define('ERROR_PRICE_FROM_MUST_BE_NUM', 'El precio desde debe ser num&eacute;rico');
define('ERROR_PRICE_TO_MUST_BE_NUM', 'El precio hasta debe ser num&eacute;rico');
define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', 'Precio hasta debe ser mayor o igual que el precio desde');
define('ERROR_INVALID_KEYWORDS', 'Palabras clave incorrectas');



/************** BEGIN SITESEARCH CHANGE ******************/
define('TABLE_HEADING_SITESEARCH', 'Archivos que contienen los parametros de la busqueda');
define('TABLE_HEADING_SITESEARCH_ARTICLES', 'Articulos que coinciden con la busqueda');
define('TABLE_HEADING_SITESEARCH_ATTRIBUTES', 'Atributos que coinciden con la busqueda');
define('TEXT_NO_PRODUCTS_KEYWORD', 'No hay productos que coincidan con los parametros de la busqueda, si usted desea hacer una pregunta sobre esta busqueda rellene el siguiente formulario y en un maximo de 24horas le responderemos.');
define('TEXT_COMMENTS', 'Comentarios');
define('TEXT_PRODUCT_NAME', 'Articulo en los que usted esta interesado:');
define('TEXT_CUSTOMER_EMAIL', 'Email:');
define('TEXT_CUSTOMER_NAME', 'Nombre:');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('NO_PRODUCT_EMAIL_TEXT_BODY', 'From %s' . "\n\n" . 'Por Favor envieme información acerca de los siguientes productos.:' . "\n\n" . EMAIL_SEPARATOR . "\n" . '%s' . "\n" .EMAIL_SEPARATOR . "\n\n" . 'Comentario Adicional:' ."\n" . '%s');
define('NO_PRODUCT_EMAIL_TEXT_SUBJECT', 'Solicitud de Información sobre el producto %s');
/************** END SITESEARCH CHANGE ****************/

?>
