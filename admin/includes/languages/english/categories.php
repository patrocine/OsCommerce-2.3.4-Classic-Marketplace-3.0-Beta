<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Categories / Products');
define('HEADING_TITLE_SEARCH', 'Search:');
define('HEADING_TITLE_GOTO', 'Go To:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Categories / Products');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_STATUS', 'Status');

define('TEXT_NEW_PRODUCT', 'New Product in &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Categories:');
define('TEXT_SUBCATEGORIES', 'Subcategories:');
define('TEXT_PRODUCTS', 'Products:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Price:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Tax Class:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Average Rating:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Quantity:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_DATE_AVAILABLE', 'Date Available:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Please insert a new category or product in this level.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'For more information, please visit this products <a href="http://%s" target="blank"><u>webpage</u></a>.');
define('TEXT_PRODUCT_DATE_ADDED', 'This product was added to our catalog on %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'This product will be in stock on %s.');

define('TEXT_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_EDIT_CATEGORIES_ID', 'Category ID:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Category Name:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Category Image:');
define('TEXT_EDIT_SORT_ORDER', 'Sort Order:');

define('TEXT_INFO_COPY_TO_INTRO', 'Please choose a new category you wish to copy this product to');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Current Categories:');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'New Category');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Edit Category');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Delete Category');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Move Category');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Delete Product');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Move Product');
define('TEXT_INFO_HEADING_COPY_TO', 'Copy To');

define('TEXT_DELETE_CATEGORY_INTRO', 'Are you sure you want to delete this category?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Are you sure you want to permanently delete this product?');

define('TEXT_DELETE_WARNING_CHILDS', '<strong>WARNING:</strong> There are %s (child-)categories still linked to this category!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<strong>WARNING:</strong> There are %s products still linked to this category!');

define('TEXT_MOVE_PRODUCTS_INTRO', 'Please select which category you wish <strong>%s</strong> to reside in');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Please select which category you wish <strong>%s</strong> to reside in');
define('TEXT_MOVE', 'Move <strong>%s</strong> to:');

define('TEXT_NEW_CATEGORY_INTRO', 'Please fill out the following information for the new category');
define('TEXT_CATEGORIES_NAME', 'Category Name:');
define('TEXT_CATEGORIES_IMAGE', 'Category Image:');
define('TEXT_SORT_ORDER', 'Sort Order:');

define('TEXT_PRODUCTS_STATUS', 'Products Status:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Date Available:');
define('TEXT_PRODUCT_AVAILABLE', 'In Stock');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Out of Stock');
define('TEXT_PRODUCTS_MANUFACTURER', 'Products Manufacturer:');
define('TEXT_PRODUCTS_NAME', 'Products Name:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Products Description:');
define('TEXT_PRODUCTS_QUANTITY', 'Products Quantity:');
define('TEXT_PRODUCTS_MODEL', 'Products Model:');
define('TEXT_PRODUCTS_IMAGE', 'Products Image:');
define('TEXT_PRODUCTS_MAIN_IMAGE', 'Main Image');
define('TEXT_PRODUCTS_LARGE_IMAGE', 'Large Image');
define('TEXT_PRODUCTS_LARGE_IMAGE_HTML_CONTENT', 'HTML Content (for popup)');
define('TEXT_PRODUCTS_ADD_LARGE_IMAGE', 'Add Large Image');
define('TEXT_PRODUCTS_LARGE_IMAGE_DELETE_TITLE', 'Delete Large Product Image?');
define('TEXT_PRODUCTS_LARGE_IMAGE_CONFIRM_DELETE', 'Please confirm the removal of the large product image.');
define('TEXT_PRODUCTS_URL', 'Products URL:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(without http://)</small>');
define('TEXT_PRODUCTS_PRICE_NET', 'Products Price (Net):');
define('TEXT_PRODUCTS_PRICE_GROSS', 'Products Price (Gross):');
define('TEXT_PRODUCTS_WEIGHT', 'Products Weight:');

define('EMPTY_CATEGORY', 'Empty Category');

define('TEXT_HOW_TO_COPY', 'Copy Method:');
define('TEXT_COPY_AS_LINK', 'Link product');
define('TEXT_COPY_AS_DUPLICATE', 'Duplicate product');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: Can not link products in the same category.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Error: Catalog images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Error: Catalog images directory does not exist: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT', 'Error: Category cannot be moved into child category.');



define('AYUDA_TEXT_STATUS', ' Activa o desactiva el producto de la web de compras.');
define('AYUDA_TEXT_FECHA_ALTA', ' Fecha de alta del producto, si dejas en blanco la fecha de alta es la actual.');
define('AYUDA_TEXT_FABRICANTE', ' Fabricante del producto.');
define('AYUDA_TEXT_NOMBRE_PRODUCTO', ' Nombre del producto');
define('AYUDA_TEXT_REFERENCIA', ' Codigo de Barras o Referencia');
define('AYUDA_TEXT_IMPUESTO_NOMBRE', ' Impuesto que se aplicará al precio.');
define('AYUDA_TEXT_PVP', ' Precio de venta al publico.');
define('AYUDA_TEXT_PVP_IMPUESTO', ' Precio de venta al publico incluyento impuesto.');
define('AYUDA_TEXT_PRECIO_GRUPO', ' En el campo G1 configura el precio B2B o 2º precio y en G2 configura el precio de costo, solo los clientes que tengan este grupo configurado en su cuenta podrán comprar con este precio.');
define('AYUDA_TEXT_SHOPTOSHOP', ' Como deseas que se vean tus productos em el banner shoptoshop que conectas al marketplace, 1 todos los productos al azar, 2 Solo las ofertas, 3 Solo los productos seleccionados.');
define('AYUDA_TEXT_SHOPTOSHOP_SELECCION', ' 1 Activado, 0 Desactivado');
define('AYUDA_TEXT_DESCUENTO_CLIENTE_VINCULAR', ' 1 el producto esta vinculado al descuento cliente, 0 el desceutno se vincula al producto');
define('AYUDA_TEXT_DESCUENTO_CLIENTE', ' Si el descuento esta vinculado al producto 0, se aplicará el descuento que configures en este campo, ej si quieres que el producto no tenga descuento pues deje en 0.00 o aplique un descuento diferente al del cliente.');
define('AYUDA_TEXT_DESCUENTO_CANTIDAD_UNIDADES', '  Descuento por cantidades, ej. 1Pcs. 10€, 10Pcs 9€, 20Pcs. 8€ .....');
define('AYUDA_TEXT_DESCUENTO_CANTIDAD_PRECIO', '  Elimina todos los descuentos por cantidades del producto, o elimina directamento solo un rango de descuento.');
define('AYUDA_TEXT_OFERTAS_SELEC', ' 1 Crear oferta, 2 Desactivar, 3 Borrar Oferta, también puedes administrarlas desde facturación.');
define('AYUDA_TEXT_OFERTAS', ' Precio de la Oferta');
define('AYUDA_TEXT_PROVEEDORES', ' Vincula el producto a un proveedor y en la ficha del proveedor puedes configurar que la imagen del producto se carge desde la web del provvedor');
define('AYUDA_TEXT_STOCKNIVEL', ' Determina que tipo de stock quieres para el producto 1 Stock, 2 Cita Previa, 3 Bajo Pedido, 4 de 1 a 3 semanas, 5 de 3 a 6 semanas, 6 Stock Real');
define('AYUDA_TEXT_REGLADEPRECIOS', ' Previamente se requiere crear las reglas de precios, las reglas de precios se aplican dependiendo del rango de precio del producto, ej si el producto vale (de 0 a 1 eur +10%), (de 1 a 5 eur +8%), se utilizan en listados grandes de productos para ajustar el margen de beneficios dependiendo del precio del producto. ');
define('AYUDA_TEXT_REGLAFABRICANTE', ' Previamente la regla de fabricante debe estar creada, este valor ordena el producto automaticamente en la cagoria donde se corresponda.(Nota se usa en catalogos grandes de productos actualizados via exel)');
define('AYUDA_TEXT_REGLACATEGORIA', ' Previamente la regla de categoria debe estar creada, este valor ordena el producto automaticamente en la categoría donde correcsponda (Nota se usa en catalogos grandes de productos actualizados via exel)');
define('AYUDA_TEXT_REGLADECATEGORIAS_ONOFF', ' 1 para vincular este producto a la actulización con reglas de caegorias, 2 Actualizar la categoria del producto manual');
define('AYUDA_TEXT_CARASTERISTICAS', ' Añade hasta 20 carasteristicas al producto, ejemplo, (opcion_1: Opcion_1_1) = Capacidad: 10L');
define('AYUDA_TEXT_CODIGODEBARRAS', ' Si estas usando la referencia con otro codigo entonces ingresa aquí el codigo de barras del producto.');
define('AYUDA_TEXT_ID', ' ');
define('AYUDA_TEXT_ID', ' ');
define('AYUDA_TEXT_ID', ' ');
define('AYUDA_TEXT_ID', ' ');









?>
