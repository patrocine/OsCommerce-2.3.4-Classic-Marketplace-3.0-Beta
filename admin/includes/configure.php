<?php
  define('HTTP_SERVER', 'https://tienda.es');
   define('HTTPS_SERVER', 'https://tienda.es');
  define('HTTP_CATALOG_SERVER', 'https://tienda.es');
  define('HTTPS_CATALOG_SERVER', 'https://tienda.es');
  define('ENABLE_SSL_CATALOG', 'true');
  define('DIR_FS_DOCUMENT_ROOT', '/home/userplesk/catalog/');  // /shop/
  define('DIR_WS_ADMIN', '/admin/');   // /shop/
  define('DIR_FS_ADMIN', '/home/userplesk/catalog/admin/'); // /shop/
  define('DIR_WS_CATALOG', '/');
  define('DIR_FS_CATALOG', '/home/userplesk/tienda/');   // /shop/
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_CATALOG_IMAGES', DIR_WS_CATALOG . 'images/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
  define('DIR_WS_CATALOG_LANGUAGES', DIR_WS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_LANGUAGES', DIR_FS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG . 'images/');
  define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG . 'includes/modules/');
  define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');

define('DIR_WS_HTTPS_ADMIN', '/catalog/admin/');
  define('DIR_WS_HTTPS_CATALOG', '/catalog/');

  define('DB_SERVER', 'localhost');
   define('DB_SERVER_USERNAME', 'NAME_USER');
  define('DB_SERVER_PASSWORD', '');
  define('DB_DATABASE', 'NAME_DB');
  define('USE_PCONNECT', 'false');
  define('STORE_SESSIONS', 'mysql');
?>
