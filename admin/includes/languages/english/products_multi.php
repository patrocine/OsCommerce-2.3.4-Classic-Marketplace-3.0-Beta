<?php
/*
  $Id: products_multi.php, v 2.6

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Multiple Products Manager');
define('HEADING_TITLE_SEARCH', 'Search:');
define('HEADING_TITLE_GOTO', 'Go To:');

define('TABLE_HEADING_SELECT', 'Select');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Categories / Products');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_PRODUCTS_QUANTITY', 'Quantity');
define('TABLE_HEADING_MANUFACTURERS_NAME', 'Manufacturer');
define('TABLE_HEADING_STATUS', 'Status');

define('TEXT_DELETE_PRODUCT', 'Delete Product:');
define('DEL_CHOOSE_DELETE_ART', 'How to delete?');
define('DEL_THIS_CAT', 'Only in this category');
define('DEL_COMPLETE', 'Completely delete product');

define('TEXT_CATEGORIES', 'Categories:');
define('TEXT_ATTENTION_DANGER', '<span class="dataTableContentRedAlert"><u>Warning:</u></span>&nbsp;Backup your database before moving, copying, or deleting any of your products.');
define('TEXT_MOVE_TO', 'Move To:');
define('TEXT_LINK_TO', 'Link To:');
define('TEXT_COPY_TO', 'Copy To:');
define('TEXT_CHOOSE_ALL', 'Select All');
define('TEXT_CHOOSE_ALL_REMOVE', 'Remove All');
define('TEXT_SUBCATEGORIES', 'Subcategories:');
define('TEXT_PRODUCTS', 'Products:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Price:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Average Rating:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Quantity:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Please insert a new category or product in<br>&nbsp;<br><b>%s</b>');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');

define('EMPTY_CATEGORY', 'Empty Category');

define('TEXT_HOW_TO_COPY', 'Copy Method:');
define('TEXT_COPY_AS_LINK', 'Link product');
define('TEXT_COPY_AS_DUPLICATE', 'Duplicate product');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: Can not link products in the same category.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Error: Catalog images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Error: Catalog images directory does not exist: ' . DIR_FS_CATALOG_IMAGES);
?>