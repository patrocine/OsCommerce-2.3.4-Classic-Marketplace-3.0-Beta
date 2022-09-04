<?php
define('HEADING_TITLE', 'Exclusiones Descuento Cupones para Cup&oacute;n %s');
define('HEADING_TITLE_VIEW_MANUAL', 'Haga clic aqu&iacute; para leer el manual de esta contribuci&oacute;n.');
if( isset( $HTTP_GET_VARS['type'] ) && $HTTP_GET_VARS['type'] != '' ) {
	switch( $HTTP_GET_VARS['type'] ) {
		//category exclusions
		case 'categories':
			$heading_available = 'Este cup&oacute;n puede aplicarse a los productos en estas categor&iacute;as.';
			$heading_selected = 'Esta cup&oacute;n puede <b>no</b> ser aplicado a productos en estas categor&iacute;as.';
			break;
		//end category exclusions
		//manufacturer exclusions
		case 'manufacturers':
			$heading_available = 'Este cup&oacute;n puede aplicarse a los productos para estos fabricantes.';
			$heading_selected = 'Esta cup&oacute;n puede <b>no</b> ser aplicado a productos para estos fabricantes.';
			break;
		//end manufacturer exclusions
    //customer exclusions
		case 'customers':
			$heading_available = 'Este cup&oacute;n puede aplicarse para estos clientes.';
			$heading_selected = 'Este cup&oacute;n <b>no</b> puede aplicarse para estos clientes.';
			break;
		//end customer exclusions
		//product exclusions
		case 'products':
      		$heading_available = 'Este cup&oacute;n puede aplicarse para estos productos.';
			$heading_selected = 'Este cup&oacute;n <b>no</b> puede aplicarse para estos productos.';
			break;
		//end product exclusions
    //shipping zone exclusions
    case 'zones' :
      $heading_available = 'Este cup&oacute;n puede aplicarse para estas zonas de env&iacute;o.';
      $heading_selected = 'Este cup&oacute;n <b>no</b> puede aplicarse para estas zonas de env&iacute;o.';
      break;
    //end zone exclusions
	}
}
define('HEADING_AVAILABLE', $heading_available);
define('HEADING_SELECTED', $heading_selected);

define('MESSAGE_DISCOUNT_COUPONS_EXCLUSIONS_SAVED', 'Nueva regla de exclusi&oacute;n guardada.');

define('ERROR_DISCOUNT_COUPONS_NO_COUPON_CODE', 'Ning&uacute;n cup&oacute;n seleccionado.' );
define('ERROR_DISCOUNT_COUPONS_INVALID_TYPE', 'No se puede crear exclusiones de ese tipo.');
define('ERROR_DISCOUNT_COUPONS_SELECTED_LIST', 'Se ha producido un error en la determinaci&oacute;n de los ya excluidos '.$HTTP_GET_VARS['type'].'.');
define('ERROR_DISCOUNT_COUPONS_ALL_LIST', 'Se ha producido un error en la determinaci&oacute;n de la disponibilidad '.$HTTP_GET_VARS['type'].'.');
define('ERROR_DISCOUNT_COUPONS_SAVE', 'Error al guardar las normas de exclusi&oacute;n nuevas.');
?>