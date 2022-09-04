<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/              //patrocine.es



//BOF Gallery Photos
define('FILENAME_GALLERY_PHOTOS', 'gallery_photos.php');
//EOF Gallery Photos

//Admin begin
  define('FILENAME_ADMIN_ACCOUNT', 'admin_account.php');
  define('FILENAME_ADMIN_FILES', 'admin_files.php');
  define('FILENAME_ADMIN_MEMBERS', 'admin_members.php');
   //Mett
  define('FILENAME_ADMIN_MEMBERS_EDIT', 'admin_members_edit.php');
 //end Mett
define('FILENAME_FORBIDEN', 'forbiden.php');
  define('FILENAME_LOGIN', 'login.php');
  define('FILENAME_LOGOFF', 'logoff.php');
  define('FILENAME_PASSWORD_FORGOTTEN', 'password_forgotten.php');
//Admin end



// Points/Rewards Module V2.1beta BOF
  define('FILENAME_CUSTOMERS_POINTS', 'customers_points.php');
  define('FILENAME_CUSTOMERS_POINTS_PENDING', 'customers_points_pending.php');
  define('FILENAME_CUSTOMERS_POINTS_REFERRAL', 'customers_points_referral.php');
  define('FILENAME_CATALOG_MY_POINTS', 'my_points.php');
  define('FILENAME_CATALOG_MY_POINTS_HELP', 'my_points_help.php');
// Points/Rewards Module V2.1beta EOF
  //kgt - discount coupons
  define('FILENAME_DISCOUNT_COUPONS','coupons.php');
  define('FILENAME_DISCOUNT_COUPONS_MANUAL', 'coupons_manual.html');
  define('FILENAME_DISCOUNT_COUPONS_EXCLUSIONS', 'coupons_exclusions.php');
  //end kgt - discount coupons

  //kgt - discount coupons report
	define('FILENAME_STATS_DISCOUNT_COUPONS', 'stats_discount_coupons.php');
  //end kgt - discount coupons report

// BOF PC Builder
  define('FILENAME_DEPENDS', 'product_depends.php');
  define('FILENAME_BUILDER', 'compbuild.php');
// EOF PC Builder
// ################# Contribution Newsletter by brouillard s'embrouille ##############
  define('FILENAME_NEWSLETTER_GESTION_INSCRITS', 'newsletter_gestion_inscrits.php');
  define('FILENAME_NEWSLETTER_DESABONNEMENT' ,'newsletter_desabonnement.php'); //pour le lien de desinscription
// ################# Fin Contribution Newsletter by brouillard s'embrouille ##############

define('TABLE_LOGINRADIUS_SETTING', 'loginradius_setting');
  define('FILENAME_SOCIALLOGINANDSOCIALSHARE', 'socialloginandsocialshare.php');

   define('FILENAME_CUSTOMERS', 'customers.php');

// BOE Access with Level Account (v. 2.2 RC2A) for the Admin Area of osCommerce (MS2) 1 of 1
// comment below lines to disable this contribution
  define('FILENAME_ADMIN_ACCOUNT', 'admin_account.php');
  define('FILENAME_ADMIN_FILES', 'admin_files.php');
  define('FILENAME_ADMIN_MEMBERS', 'admin_members.php');
  Define('FILENAME_FORBIDDEN', 'forbidden.php');
  define('FILENAME_LOGIN_ADMIN', 'login.php');
  define('FILENAME_LOGOFF_ADMIN', 'logoff_admin.php');
  define('FILENAME_PASSWORD_FORGOTTEN', 'password_forgotten.php');
// BOE Access with Level Account (v. 2.2 RC2A) for the Admin Area of osCommerce (MS2) 1 of 1
                   //patrocine.es

  define('FILENAME_CREATE_ORDER_PROCESS_TIENDA', 'create_order_process_tienda.php');
  define('FILENAME_CREATE_ORDER_TIENDA', 'create_order_tienda.php');
  define('FILENAME_EDIT_ORDERS_TIENDA', 'edit_orders_tienda.php');
  define('FILENAME_CREATE_ACCOUNT_TIENDA', 'create_account_tienda.php');
  define('FILENAME_CREATE_ACCOUNT_PROCESS_TIENDA', 'create_account_process_tienda.php');
  define('FILENAME_CREATE_ACCOUNT_SUCCESS_TIENDA', 'create_account_success_tienda.php');

  define('FILENAME_ACCOUNT_DETAILS_TIENDA', 'account_details_tienda.php');
  define('FILENAME_CREATE_ORDER_DETAILS_TIENDA', 'create_order_details_tienda.php');
 define('FILENAME_INVOICE_LIQUIDACION_TIENDA', 'invoice_liquidacion_tienda.php');
 define('FILENAME_INVOICE_ENTREGAS_TIENDA', 'invoice_entregas_tienda.php');
 define('FILENAME_INVOICE_SALIDAS_TIENDA', 'invoice_salidas_tienda.php');
 define('FILENAME_ORDERS_TIENDA', 'orders_tienda.php');


// define the filenames used in the project
  define('FILENAME_ACTION_RECORDER', 'action_recorder.php');
  define('FILENAME_ADMINISTRATORS', 'administrators.php');
  define('FILENAME_BACKUP', 'backup.php');
  define('FILENAME_BANNER_MANAGER', 'banner_manager.php');
  define('FILENAME_BANNER_STATISTICS', 'banner_statistics.php');
  define('FILENAME_CACHE', 'cache.php');
  define('FILENAME_CATALOG_ACCOUNT_HISTORY_INFO', 'account_history_info.php');
  define('FILENAME_CATEGORIES', 'categories.php');
  define('FILENAME_CONFIGURATION', 'configuration.php');
  define('FILENAME_COUNTRIES', 'countries.php');
  define('FILENAME_CURRENCIES', 'currencies.php');
  define('FILENAME_CUSTOMERS', 'customers.php');
  define('FILENAME_DEFAULT', 'index.php');
  define('FILENAME_DEFINE_LANGUAGE', 'define_language.php');
  define('FILENAME_GEO_ZONES', 'geo_zones.php');
  define('FILENAME_LANGUAGES', 'languages.php');
  define('FILENAME_LOGIN', 'login.php');
  define('FILENAME_MAIL', 'mail.php');
  define('FILENAME_MANUFACTURERS', 'manufacturers.php');
  define('FILENAME_MODULES', 'modules.php');
  define('FILENAME_NEWSLETTERS', 'newsletters.php');
  define('FILENAME_ORDERS', 'orders.php');
  define('FILENAME_ORDERS_INVOICE', 'invoice.php');
  define('FILENAME_ORDERS_PACKINGSLIP', 'packingslip.php');
  define('FILENAME_ORDERS_STATUS', 'orders_status.php');
  define('FILENAME_POPUP_IMAGE', 'popup_image.php');
  define('FILENAME_PRODUCTS_ATTRIBUTES', 'products_attributes.php');
  define('FILENAME_PRODUCTS_EXPECTED', 'products_expected.php');
  define('FILENAME_REVIEWS', 'reviews.php');
  define('FILENAME_SEC_DIR_PERMISSIONS', 'sec_dir_permissions.php');
  define('FILENAME_SERVER_INFO', 'server_info.php');
  define('FILENAME_SHIPPING_MODULES', 'shipping_modules.php');
  define('FILENAME_SPECIALS', 'specials.php');
  define('FILENAME_STATS_CUSTOMERS', 'stats_customers.php');
  define('FILENAME_STATS_PRODUCTS_PURCHASED', 'stats_products_purchased.php');
  define('FILENAME_STATS_PRODUCTS_VIEWED', 'stats_products_viewed.php');
  define('FILENAME_STORE_LOGO', 'store_logo.php');
  define('FILENAME_TAX_CLASSES', 'tax_classes.php');
  define('FILENAME_TAX_RATES', 'tax_rates.php');
  define('FILENAME_VERSION_CHECK', 'version_check.php');
  define('FILENAME_WHOS_ONLINE', 'whos_online.php');
  define('FILENAME_ZONES', 'zones.php');
?>
