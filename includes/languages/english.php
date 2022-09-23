<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'es_ES'                    es_ES.UTF-8, es_ES.UTF8, esp_esp
// on FreeBSD try 'es_ES.ISO_8859-1'
// on Windows try 'sp', or 'Spanish'
setlocale(LC_ALL, array('en_US.UTF-8', 'en_US.UTF8', 'enu_usa'));

define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('JQUERY_DATEPICKER_I18N_CODE', ''); // leave empty for en_US; see http://jqueryui.com/demos/datepicker/#localization
define('JQUERY_DATEPICKER_FORMAT', 'dd/mm/yy'); // see http://docs.jquery.com/UI/Datepicker/formatDate



define('BOX_INFORMATION_MY_POINTS_HELP', 'Programa de Puntos FAQ');//Points/Rewards Module V2.1beta
#### Points/Rewards Module V2.1beta BOF ####
define('REDEEM_SYSTEM_ERROR_POINTS_NOT', 'Valor Puntos no son suficientes para cubrir el costo de su compra. Por favor seleccione otro método de pago');
define('REDEEM_SYSTEM_ERROR_POINTS_OVER', 'REDEEM POINTS ERROR ! Points value can not be over the total value. Please Re enter points');
define('REFERRAL_ERROR_SELF', 'Sorry you can not refer yourself.');
define('REFERRAL_ERROR_NOT_VALID', 'The referral email does not appear to be valid - please make any necessary corrections.');
define('REFERRAL_ERROR_NOT_FOUND', 'The referral email address you entered was not found.');
define('TEXT_POINTS_BALANCE', 'Puntos STATUS');
define('TEXT_POINTS', 'Puntos :');
define('TEXT_VALUE', 'Valor:');
define('REVIEW_HELP_LINK', ' Por escribir un comentario interesante le damos <b>%s</b> en puntos para utilizar en su siguiente compra.');
#### Points/Rewards Module V2.1beta EOF ####

/************** BEGIN SITESEARCH CHANGE ******************/
define('BOX_HEADING_ADVSEARCH', 'Buscar');
define('BOX_ADVSEARCH_KW', 'Palabra(s):');
define('BOX_ADVSEARCH_PRICERANGE', 'Rango de Precios:');
define('BOX_ADVSEARCH_PRICESEP', ' a ');
define('BOX_ADVSEARCH_CAT', 'Categoría:');
define('BOX_ADVSEARCH_ALLCAT', 'Cualquiera');
define('BOX_TEXT_ADVSEARCH', 'Busqueda Avanzada');
/************** END SITESEARCH CHANGE ******************/

//kgt - discount coupons
define('ENTRY_DISCOUNT_COUPON_ERROR', 'El cupón introducido no es válido.');
define('ENTRY_DISCOUNT_COUPON_AVAILABLE_ERROR', 'El cupón introducido ha superado el numero de veces de uso.');
define('ENTRY_DISCOUNT_COUPON_USE_ERROR', 'Nuestros registros indican que usted ha utilizado este cup&oacute;n %s vez(ces). Usted no puede utilizar el c&oacute;digo más de %s vez(ces).');
define('ENTRY_DISCOUNT_COUPON_MIN_PRICE_ERROR', 'El total de compra m&iacute;nima para este cup&oacute;n es de %s');
define('ENTRY_DISCOUNT_COUPON_MIN_QUANTITY_ERROR', 'El n&uacute;mero m&iacute;nimo de productos necesarios para este cup&oacute;n es de %s');
define('ENTRY_DISCOUNT_COUPON_EXCLUSION_ERROR', 'Algunos o todos los productos en su cesta est&aacute;n excluidos.' );
define('ENTRY_DISCOUNT_COUPON', 'CUPON DESCUENTO:');
define('ENTRY_DISCOUNT_COUPON_SHIPPING_CALC_ERROR', 'Los cargos de env&iacute;o calculados han cambiado.');
//end kgt - discount coupons

 //BEGIN : IOSC Switch view labels
define('TEXT_SHOW_VIEW_1', 'Version: ');
define('TEXT_SHOW_VIEW_2', '');
define('TEXT_CLASSIC_VIEW', 'CLASICA');
define('TEXT_MOBILE_VIEW', '<b>MOVIL</b>');
//END : IOSC Switch view labels

define('IMAGE_BUTTON_SEARCH', 'Buscar');


//BEGIN : IOSC Advanced Search Button
define('IMAGE_BUTTON_ADVANCED_SEARCH', 'B&uacute;squeda avanzada');
//END : IOSC Advanced Search Button



define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Cambiar Direcci&oacute;n');



//BEGIN : IOSC Button
define('IMAGE_BUTTON_CHANGE', 'Cambiar');
//END : IOSC Button



define('IMAGE_BUTTON_LOGIN', 'Entrar');



//BEGIN : IOSC Button
define('IMAGE_BUTTON_LOGOFF', 'Salir');
define('IMAGE_BUTTON_CREATE_ACCOUNT', 'Crear Cuenta');
//END : IOSC Button


define('IMAGE_BUTTON_UPDATE_CART', 'Actualizar Cesta');
//BEGIN : IOSC Button


define('IMAGE_BUTTON_REMOVE', 'Quitar');
//END : IOSC Button



////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="es"');

// charset for web pages and emails
define('CHARSET', 'ISO_8859-1');

// page title
define('TITLE', STORE_NAME);


// ################# Contribution Newsletter by brouillard s'embrouille ###########
 define('IMAGE_BUTTON_NEWSLETTER_ABONNEMENT', 'Click');
 define('IMAGE_BUTTON_NEWSLETTER_DESABONNEMENT', 'Darse de Baja');
 define('BOX_HEADING_NEWSLETTER', 'Subscripciones');
 define('BOX_NEWSLETTER_TEXT_ABONNEMENT', '<em>Subscribase a Ofertas y Liquidaciones</em>');
 define('BOX_NEWSLETTER_TEXT_EMAIL','Email: ');
 define('BOX_NEWSLETTER_ERREUR', 'Dirección de Email Incorrecta.\n" + form.emailabonnement.value + " is not a valid email address.');
 define('BOX_NEWSLETTER_ERREUR_CHAMP_VIDE', 'Error, no ha inroducido ningun mail');
 define('BOX_NEWSLETTER_ERREUR_VIRGULE', 'El Email no puede contener comma.');
 define('BOX_NEWSLETTER_ERREUR_ESPACES', 'El Email no puede contener spaces.');
 define('BOX_NEWSLETTER_ERREUR_AROBASE', 'El Email no puede contener los siguientes signos \"@\".');
 // ################# Fin Contribution Newsletter by brouillard s'embrouille ###########

  define('MENSAJE_CANCELAR', 'En caso de querer cancelar el pedido, acceda a su "HISTORIAL DE PEDIDOS" y  pulse en cancelar pedido.');


// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Crear cuenta');
define('HEADER_TITLE_MY_ACCOUNT', 'Mi cuenta');
define('HEADER_TITLE_CART_CONTENTS', 'Ver cesta');
define('HEADER_TITLE_CHECKOUT', 'Realizar pedido');
define('HEADER_TITLE_TOP', 'Inicio');
define('HEADER_TITLE_CATALOG', 'Catalogo');
define('HEADER_TITLE_LOGOFF', 'Salir');
define('HEADER_TITLE_LOGIN', 'Entrar');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'visitas desde');

// text for gender
define('MALE', 'Hombre');
define('FEMALE', 'Mujer');
define('MALE_ADDRESS', 'Sr.');
define('FEMALE_ADDRESS', 'Sra.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/aaaa');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Entrega de informaci&oacute;n');
define('CHECKOUT_BAR_PAYMENT', 'Informaci&oacute;n sobre el pago');
define('CHECKOUT_BAR_CONFIRMATION', 'Confirmaci&oacute;n');
define('CHECKOUT_BAR_FINISHED', 'Terminado');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Seleccione');
define('TYPE_BELOW', 'Escriba a continuaci&oacute;n');

// javascript messages
define('JS_ERROR', 'Se han producido errores durante el proceso.\n\nPor favor, haga las siguientes correcciones:\n\n');
define('JS_REVIEW_TEXT', '* El \' texto\' debe tener al menos' . REVIEW_TEXT_MIN_LENGTH . ' caracteres.\n');
define('JS_REVIEW_RATING', '* Debe evaluar el producto por el que realiza el comentario.\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Por favor, seleccione una forma de pago de su pedido.\n');
define('JS_ERROR_SUBMITTED', 'Esta forma ya se ha presentado. Por favor, pulse Aceptar y espere a que este proceso se complete.');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Por favor, seleccione una forma de pago de su pedido.');

define('CATEGORY_COMPANY', 'Datos de la empresa');
define('CATEGORY_PERSONAL', 'Datos personales');
define('CATEGORY_ADDRESS', 'Direcci&oacute;n');
define('CATEGORY_CONTACT', 'Información de contacto');
define('CATEGORY_OPTIONS', 'Opciones');
define('CATEGORY_PASSWORD', 'Contraseña');

define('ENTRY_COMPANY', 'Nombre de la empresa:');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Sexo:');
define('ENTRY_GENDER_ERROR', 'Por favor seleccione su sexo.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Nombre:');
define('ENTRY_FIRST_NAME_ERROR', 'Su nombre debe contener un m&iacute;nimo de ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caracteres.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Apellido:');
define('ENTRY_LAST_NAME_ERROR', 'Su apellido debe contener un m&iacute;nimo de ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caracteres.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Fecha de nacimiento:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Su fecha de nacimiento debe ser en este formato: DD/MM/AAAA (Ejem. 18/07/1981)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (Ejem. 18/07/1981)');
define('ENTRY_EMAIL_ADDRESS', 'Direcci&oacute;n email:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Su email debe contener un mi&acute;nimo de ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' caracteres.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Su email no parece v&acute;lido - por favor haga las correcciones necesarias.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Su email ya figura entre nuestros clientes - por favor inicie sesi&oacute;n con su email o cree una cuenta con un email diferente.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Direcci&oacute;n:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Su direcci&oacute;n debe tener un m&iacute;nimo de ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caracteres.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Barriada:');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'C&oacute;digo postal:');
define('ENTRY_POST_CODE_ERROR', 'Su c&oacute;digo postal debe contener un m&iacute;nimo de ' . ENTRY_POSTCODE_MIN_LENGTH . ' caracteres.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Poblaci&oacute;n:');
define('ENTRY_CITY_ERROR', 'Su poblaci&oacute;n debe tener un m&iacute;nimo de ' . ENTRY_CITY_MIN_LENGTH . ' caracteres.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Provincia:');
define('ENTRY_STATE_ERROR', 'Su provincia debe tener un m&iacute;nimo de ' . ENTRY_STATE_MIN_LENGTH . ' caracteres.');
define('ENTRY_STATE_ERROR_SELECT', 'Por favor, seleccione una provincia de la lista.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Pais:');
define('ENTRY_COUNTRY_ERROR', 'Debe seleccionar un pa&iacute;s de la lista del men&uacute; desplegable.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'N&uacutemero de tel&eacute;fono:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Su n&uacute;mero de tel&eacute;fono debe contener un m&iacute;nimo de ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caracteres.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'N&uacute;mero de fax:');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Bolet&iacute;n:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Suscrito');
define('ENTRY_NEWSLETTER_NO', 'No suscrito');
define('ENTRY_PASSWORD', 'contrase&ntilde;a:');
define('ENTRY_PASSWORD_ERROR', 'Su contrase&ntilde;a debe tener un m&iacute;nimo de ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'La confirmaci&oacute;n de contrase&ntilde;a debe coincidir con su contrase&ntilde;a.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Confirmaci&oacute;n de contrase&ntilde;a:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'contrase&ntilde;a actual:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Su contrase&ntilde;a debe tener un m&iacute;nimo de ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres.');
define('ENTRY_PASSWORD_NEW', 'Nueva contrase&ntilde;a:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Su nueva contrase&ntilde;a debe tener un m&iacute;nimo de ' . ENTRY_PASSWORD_MIN_LENGTH . ' caracteres.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'La confirmaci&oacute;n de contrase&ntilde;a debe coincidir con su nueva contrase&ntilde;a.');
define('PASSWORD_HIDDEN', '--OCULTO--');

define('FORM_REQUIRED_INFORMATION', '* Informaci&oacute;n obligatoria');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Paginas de resultados:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Viendo del <b>%d</b> al <b>%d</b> (de <b>%d</b> productos)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Viendo del <b>%d</b> al <b>%d</b> (de <b>%d</b> pedidos)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Viendo del <b>%d</b> al <b>%d</b> (de <b>%d</b> comentarios)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Viendo del <b>%d</b> al <b>%d</b> (de <b>%d</b> nuevos productos)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Viendo del <b>%d</b> al <b>%d</b> (de <b>%d</b> ofertas)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Principio');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Anterior');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Siguiente');
define('PREVNEXT_TITLE_LAST_PAGE', 'Final');
define('PREVNEXT_TITLE_PAGE_NO', 'P&aacute;gina %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Anteriores %d paginas');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Siguientes %d paginas');
define('PREVNEXT_BUTTON_FIRST', '<<PRINCIPIO');
define('PREVNEXT_BUTTON_PREV', '[<< Anterior]');
define('PREVNEXT_BUTTON_NEXT', '[Siguiente >>]');
define('PREVNEXT_BUTTON_LAST', 'FINAL>>');

define('IMAGE_BUTTON_ADD_ADDRESS', 'A&ntilde;adir direcci&oacute;n');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Direcciones');
define('IMAGE_BUTTON_BACK', 'Volver');
define('IMAGE_BUTTON_BUY_NOW', 'Compre Ahora');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Cambiar direcci&oacute;n');
define('IMAGE_BUTTON_CHECKOUT', 'Realizar pedido');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Confirmar pedido');
define('IMAGE_BUTTON_CONTINUE', 'Continuar');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Seguir comprando');
define('IMAGE_BUTTON_DELETE', 'Eliminar');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Editar cuenta');
define('IMAGE_BUTTON_HISTORY', 'Historial de pedidos');
define('IMAGE_BUTTON_LOGIN', 'Entrar');
define('IMAGE_BUTTON_IN_CART', 'A&ntilde;adir a la cesta');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Notificaciones');
define('IMAGE_BUTTON_QUICK_FIND', 'B&uacute;squeda rapida');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Eliminar notificaciones');
define('IMAGE_BUTTON_REVIEWS', 'Comentarios');
define('IMAGE_BUTTON_SEARCH', 'Buscar');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Opciones de envi&oacute;');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'D&iacute;selo a un amigo');
define('IMAGE_BUTTON_UPDATE', 'Actualizar');
define('IMAGE_BUTTON_UPDATE_CART', 'Actualizar cesta');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Escribir comentario');

define('SMALL_IMAGE_BUTTON_DELETE', 'Eliminar');
define('SMALL_IMAGE_BUTTON_EDIT', 'Modificar');
define('SMALL_IMAGE_BUTTON_VIEW', 'Ver');

define('ICON_ARROW_RIGHT', 'm&aacute;s');
define('ICON_CART', 'En cesta');
define('ICON_ERROR', 'Error');
define('ICON_SUCCESS', 'Correcto');
define('ICON_WARNING', 'Advertencia');

define('TEXT_GREETING_PERSONAL', '¡Bienvenido de nuevo <span class="greetUser">%s!</span> ¿Le gustar&iacute;a ver que <a href="%s"><u>nuevos productos</u></a> hay disponibles?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Si no es %s, por favor <a href="%s"><u>entre aqu&iacute;</u></a> e introduzca sus datos.</small>');
define('TEXT_GREETING_GUEST', '¡Bienvenido <span class="greetUser">Invitado!</span> ¿Le gustar&iacute;a <a href="%s"><u>entrar en su cuenta</u></a> o preferir&iacute;a <a href="%s"><u>crear una cuenta nueva</u></a>?');

define('TEXT_SORT_PRODUCTS', 'Ordenar productos ');
define('TEXT_DESCENDINGLY', 'Descendentemente');
define('TEXT_ASCENDINGLY', 'Ascendentemente');
define('TEXT_BY', ' por ');

define('TEXT_REVIEW_BY', 'Comentario de %s');
define('TEXT_REVIEW_WORD_COUNT', '%s palabras');
define('TEXT_REVIEW_RATING', 'Evaluaci&oacute;n: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Fecha alta: %s');
define('TEXT_NO_REVIEWS', 'En este momento, no hay ning&uacute;n comentario.');

define('TEXT_NO_NEW_PRODUCTS', 'Ahora mismo no hay novedades.');

define('TEXT_UNKNOWN_TAX_RATE', 'Impuesto desconocido');

define('TEXT_REQUIRED', '<span class="errorText">Obligatorio</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>TEP ERROR:</small> No he podido enviar el email con el servidor SMTP especificado. Configure su servidor SMTP en la secci&oacute;n adecuada del fichero php.ini.</b></font>');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'La fecha de caducidad de la tarjeta de cr&eacute;dito es incorrecta. Compruebe la fecha e int&eacute;ntelo de nuevo.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'El n&uacute;mero de la tarjeta de cr&eacute;dito es incorrecto. Compruebe el n&uacute;mero e int&eacute;ntelo de nuevo.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Los primeros cuatro d&iacute;gitos de su tarjeta son: %s. Si este numero es correcto, no aceptamos este tipo de tarjetas. Si es incorrecto, intentelo de nuevo.');

define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y') . ' <a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . STORE_NAME . '</a>');
/* ************************************************************************************* */
define('ITEM_INFORMATION_PRIVACY', 'Confidencialidad');
define('ITEM_INFORMATION_CONDITIONS', 'Condiciones de uso');
define('ITEM_INFORMATION_SHIPPING', 'Env&iacute;os y Devoluciones');
define('ITEM_ADVANCED_SEARCH', 'B&uacute;squeda Avanzada');
define('TEXT_INPUT_SEARCH', 'Introduce las palabras clave de b&uacute;squeda aqu&iacute;');
define('HEADER_SHOPPING_CART_BOX_CART_EMPTY', ' art&iacute;culos');
define('NOW_IN_CART', ' Mi cesta ');
define('TITLE_SLIDER_BESTSELLERS_HEADER', 'Los m&aacute;s vendidos');
define('IMAGE_BUTTON_DETAILS', 'Detalles');
define('PRICE', 'Precio:&nbsp;&nbsp;');
/* ************************************************************************************* */
define('BANNER_GROUP_2', 'banner2_es');
define('BANNER_GROUP_3', 'banner3_es');
define('BANNER_GROUP_4', 'banner4_es');
define('BANNER_GROUP_5', 'banner5_es');
define('BANNER_GROUP_6', 'banner6_es');
define('BANNER_GROUP_7', 'banner7_es');
define('BANNER_GROUP_8', 'banner8_es');
define('BANNER_GROUP_9', 'banner9_es');
?>
