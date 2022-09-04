<?php
  define('HTTP_SERVER', 'https://tienda.es');
  define('HTTPS_SERVER', 'https://tienda.es');
  define('ENABLE_SSL', false);
  define('HTTP_COOKIE_DOMAIN', '');
  define('HTTPS_COOKIE_DOMAIN', '');
  define('HTTP_COOKIE_PATH', '/');  // '/shop/'
  define('HTTPS_COOKIE_PATH', '/');    // '/shop/'
  define('DIR_WS_HTTP_CATALOG', '/');   // '/shop/'
  define('DIR_WS_HTTPS_CATALOG', '/');   // '/shop/'
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');

  define('DIR_WS_DOWNLOAD_PUBLIC', 'pub/');
  define('DIR_FS_CATALOG', '/home/userplesk/rutatienda/');   // '/shop/'
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');

  define('DB_SERVER', 'localhost');
   define('DB_SERVER_USERNAME', 'NAME_USER');
  define('DB_SERVER_PASSWORD', '');
  define('DB_DATABASE', 'NAME_DB');
  define('USE_PCONNECT', 'false');
  define('STORE_SESSIONS', 'mysql');
?>
