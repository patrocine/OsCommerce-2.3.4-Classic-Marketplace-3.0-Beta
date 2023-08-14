<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

// Start the clock for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());

// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);

// check support for register_globals
  if (function_exists('ini_get') && (ini_get('register_globals') == false) && (PHP_VERSION < 4.3) ) {
    exit('Server Requirement Error: register_globals is disabled in your PHP configuration. This can be enabled in your php.ini configuration file or in the .htaccess file in your catalog directory. Please use PHP 4.3+ if register_globals cannot be enabled on the server.');
  }

// load server configuration parameters
  if (file_exists('includes/local/configure.php')) { // for developers
    include('includes/local/configure.php');
  } else {
    include('includes/configure.php');
  }

// Define the project version --- obsolete, now retrieved with tep_get_version()
  define('PROJECT_VERSION', 'osCommerce Online Merchant v2.3');

// some code to solve compatibility issues
  require(DIR_WS_FUNCTIONS . 'compatibility.php');

// set php_self in the local scope
$req = parse_url($HTTP_SERVER_VARS['SCRIPT_NAME']);
$PHP_SELF = substr($req['path'], strlen(DIR_WS_ADMIN));
// Used in the "Backup Manager" to compress backups
  define('LOCAL_EXE_GZIP', 'gzip');
  define('LOCAL_EXE_GUNZIP', 'gunzip');
  define('LOCAL_EXE_ZIP', 'zip');
  define('LOCAL_EXE_UNZIP', 'unzip');

// include the list of project filenames
  require(DIR_WS_INCLUDES . 'filenames.php');

// include the list of project database tables
  require(DIR_WS_INCLUDES . 'database_tables.php');

// Define how do we update currency exchange rates
// Possible values are 'oanda' 'xe' or ''
  define('CURRENCY_SERVER_PRIMARY', 'oanda');
  define('CURRENCY_SERVER_BACKUP', 'xe');

// include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
  tep_db_connect() or die('Unable to connect to database server!');

// set application wide parameters
  $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = tep_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

// define our general functions used application-wide
  require(DIR_WS_FUNCTIONS . 'general.php');
  require(DIR_WS_FUNCTIONS . 'html_output.php');

// initialize the logger class
  require(DIR_WS_CLASSES . 'logger.php');

// include shopping cart class
  require(DIR_WS_CLASSES . 'shopping_cart.php');

// define how the session functions will be used
  require(DIR_WS_FUNCTIONS . 'sessions.php');

// set the session name and save path
  tep_session_name('osCAdminID');
  tep_session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
   if (function_exists('session_set_cookie_params')) {
    session_set_cookie_params(0, DIR_WS_ADMIN);
  } elseif (function_exists('ini_set')) {
    ini_set('session.cookie_lifetime', '0');
    ini_set('session.cookie_path', DIR_WS_ADMIN);
  }

  @ini_set('session.use_only_cookies', (SESSION_FORCE_COOKIE_USE == 'True') ? 1 : 0);

// lets start our session
  tep_session_start();

  if ( (PHP_VERSION >= 4.3) && function_exists('ini_get') && (ini_get('register_globals') == false) ) {
    extract($_SESSION, EXTR_OVERWRITE+EXTR_REFS);
  }

// set the language
  if (!tep_session_is_registered('language') || isset($HTTP_GET_VARS['language'])) {
    if (!tep_session_is_registered('language')) {
      tep_session_register('language');
      tep_session_register('languages_id');
    }

    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language();

    if (isset($HTTP_GET_VARS['language']) && tep_not_null($HTTP_GET_VARS['language'])) {
      $lng->set_language($HTTP_GET_VARS['language']);
    } else {
      $lng->get_browser_language();
    }

    $language = $lng->language['directory'];
    $languages_id = $lng->language['id'];
  }

// redirect to login page if administrator is not yet logged in
  if (!tep_session_is_registered('admin')) {
    $redirect = false;

    $current_page = $PHP_SELF;

// if the first page request is to the login page, set the current page to the index page
// so the redirection on a successful login is not made to the login page again
    if ( ($current_page == FILENAME_LOGIN) && !tep_session_is_registered('redirect_origin') ) {
      $current_page = FILENAME_DEFAULT;
      $HTTP_GET_VARS = array();
    }

    if ($current_page != FILENAME_LOGIN) {
      if (!tep_session_is_registered('redirect_origin')) {
        tep_session_register('redirect_origin');

        $redirect_origin = array('page' => $current_page,
                                 'get' => $HTTP_GET_VARS);
      }

// try to automatically login with the HTTP Authentication values if it exists
      if (!tep_session_is_registered('auth_ignore')) {
        if (isset($HTTP_SERVER_VARS['PHP_AUTH_USER']) && !empty($HTTP_SERVER_VARS['PHP_AUTH_USER']) && isset($HTTP_SERVER_VARS['PHP_AUTH_PW']) && !empty($HTTP_SERVER_VARS['PHP_AUTH_PW'])) {
          $redirect_origin['auth_user'] = $HTTP_SERVER_VARS['PHP_AUTH_USER'];
          $redirect_origin['auth_pw'] = $HTTP_SERVER_VARS['PHP_AUTH_PW'];
        }
      }

      $redirect = true;
    }

    if (!isset($login_request) || isset($HTTP_GET_VARS['login_request']) || isset($HTTP_POST_VARS['login_request']) || isset($HTTP_COOKIE_VARS['login_request']) || isset($HTTP_SESSION_VARS['login_request']) || isset($HTTP_POST_FILES['login_request']) || isset($HTTP_SERVER_VARS['login_request'])) {
      $redirect = true;
    }

    if ($redirect == true) {
      tep_redirect(tep_href_link(FILENAME_LOGIN, (isset($redirect_origin['auth_user']) ? 'action=process' : '')));
    }

    unset($redirect);
  }

// include the language translations
  // include the language translations
  $_system_locale_numeric = setlocale(LC_NUMERIC, 0);
  require(DIR_WS_LANGUAGES . $language . '.php');
  setlocale(LC_NUMERIC, $_system_locale_numeric); // Prevent LC_ALL from setting LC_NUMERIC to a locale with 1,0 float/decimal values instead of 1.0 (see bug #634)
  
  
  $current_page = basename($PHP_SELF);
  if (file_exists(DIR_WS_LANGUAGES . $language . '/' . $current_page)) {
    include(DIR_WS_LANGUAGES . $language . '/' . $current_page);
  }

// define our localization functions
  require(DIR_WS_FUNCTIONS . 'localization.php');

// Include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');

// setup our boxes
  require(DIR_WS_CLASSES . 'table_block.php');
  require(DIR_WS_CLASSES . 'box.php');

// initialize the message stack for output messages
  require(DIR_WS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;

// split-page-results
  require(DIR_WS_CLASSES . 'split_page_results.php');

// entry/item info classes
  require(DIR_WS_CLASSES . 'object_info.php');

// email classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');

// file uploading class
  require(DIR_WS_CLASSES . 'upload.php');

// action recorder
  require(DIR_WS_CLASSES . 'action_recorder.php');

// calculate category path
  if (isset($HTTP_GET_VARS['cPath'])) {
    $cPath = $HTTP_GET_VARS['cPath'];
  } else {
    $cPath = '';
  }

  if (tep_not_null($cPath)) {
    $cPath_array = tep_parse_category_path($cPath);
    $cPath = implode('_', $cPath_array);
    $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  } else {
    $current_category_id = 0;
  }

// initialize configuration modules
  require(DIR_WS_CLASSES . 'cfg_modules.php');
  $cfgModules = new cfg_modules();

// the following cache blocks are used in the Tools->Cache section
// ('language' in the filename is automatically replaced by available languages)
  $cache_blocks = array(array('title' => TEXT_CACHE_CATEGORIES, 'code' => 'categories', 'file' => 'categories_box-language.cache', 'multiple' => true),
                        array('title' => TEXT_CACHE_MANUFACTURERS, 'code' => 'manufacturers', 'file' => 'manufacturers_box-language.cache', 'multiple' => true),
                        array('title' => TEXT_CACHE_ALSO_PURCHASED, 'code' => 'also_purchased', 'file' => 'also_purchased-language.cache', 'multiple' => true)
                       );
                       
                       


  if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}

   // $sumar_balance_sales_raw = "select sum(products_balance_stock) as value, count(*) as products_quantity from " . TABLE_PRODUCTS . " where products_balance_stock_control = 0";
 //   $sumar_balance_sales_query = tep_db_query($sumar_balance_sales_raw);
  //  $sumar_balance= tep_db_fetch_array($sumar_balance_sales_query);


    // Transforma el pedido
    /*
                     if ($value_edita == 'ok') {
           $orders_statuss_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
                      $orders_statuss = tep_db_fetch_array($orders_statuss_values);



           $orders_statusa_values = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . $orders_statuss['orders_status'] . "'");
                      $orders_statusa = tep_db_fetch_array($orders_statusa_values);



           $admin_selcb_values = tep_db_query("select * from " . 'admin' . " where code_admin = '" . $orders_statusa['tienda'] . "' and  admin_groups_id <> '" . 1 . "'");
                      $admin_selcb = tep_db_fetch_array($admin_selcb_values);


                               echo  $value_edit = $admin_selecb['admin_id'];

                                }


                          */

       if ($_GET['value_edit']){
               $value_edit = $_GET['value_edit'];
   }else if ($_POST['value_edit']){
             $value_edit =  $_POST['value_edit'];
}

     $login_id  = $admin['id'];
     $vp_2 = $_POST['vp_2'];
     
   
if ($value_edit){

 $yergfcv_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $value_edit . "'");
 $yergfcv = tep_db_fetch_array($yergfcv_values);

 $yergfcvs_values = tep_db_query("select * from " . 'admin_supervisores' . " where admin_id = '" . $login_id . "'");
 $yergfcvs = tep_db_fetch_array($yergfcvs_values);



    if ($value_edit == $yergfcvs['admin_id_remoto']){

    $value_edit = $yergfcvs['admin_id_remoto'];

    if ($login_id == 1) {

       $value_edit = $yergfcvs['admin_id'];

}

    }

            $sql_status_update_array = array('cobrado' => $yergfcv['cobrado'],
                                             'reserva' => $yergfcv['reserva'],
                                             'admin_id_remoto' => $value_edit,
                                             'abono' => $yergfcv['abono'],
                                             'admin_cif' => $yergfcv['admin_cif'],
                                             'admin_direccion' => $yergfcv['admin_direccion'],
                                             'admin_poblacion' => $yergfcv['admin_poblacion'],
                                             'admin_provincia' => $yergfcv['admin_provincia'],
                                             'admin_titularbanco' => $yergfcv['admin_titularbanco'],
                                             'admin_nombrebanco' => $yergfcv['admin_nombrebanco'],
                                             'admin_cuentabancaria' => $yergfcv['admin_cuentabancaria'],
                                             'admin_cp' => $yergfcv['admin_cp'],
                                             'admin_telefono' => $yergfcv['admin_telefono'],
                                             'admin_movil' => $yergfcv['admin_movil'],
                                             'paypal_enviado' => $yergfcv['paypal_enviado'],
                                             'pagado' => $yergfcv['pagado'],
                                             'procesando_paypal' => $yergfcv['procesando_paypal'],
                                             'pagado_internacional' => $yergfcv['pagado_internacional'],
                                             'pagado_transferencia' => $yergfcv['pagado_transferencia'],
                                             'pagado_paypal' => $yergfcv['pagado_paypal'],
                                             'recoger' => $yergfcv['recoger'],
                                             'no_recogido' => $yergfcv['no_recogido'],
                                             'transferencia' => $yergfcv['transferencia'],
                                             'transferencia_procesando' => $yergfcv['transferencia_procesando'],
                                             'facturado' => $yergfcv['facturado'],
                                             'procesando_reembolso_internacional' => $yergfcv['procesando_reembolso_internacional'],
                                             'cancelado' => $yergfcv['cancelado'],
                                             'esperando_respuesta' => $yergfcv['esperando_respuesta'],
                                             'cambio_procesando' => $yergfcv['cambio_procesando'],
                                             'entregas_stock' => $yergfcv['entregas_stock'],
                                             'name_boxes' => $yergfcv['name_boxes'],
                                             'status_entregas' => $yergfcv['status_entregas'],
                                             'status_salidas' => $yergfcv['status_salidas'],
                                             'pendiente_entrada' => $yergfcv['pendiente_entrada'],
                                             'pendiente_entrada_entienda' => $yergfcv['pendiente_entrada_entienda'],
                                             'presupuestos' => $yergfcv['presupuestos'],
                                             'credito' => $yergfcv['credito'],
                                             'albaran' => $yergfcv['albaran'],
                                             'albaran_cobrar' => $yergfcv['albaran_cobrar'],
                                             'status_pendiente' => $yergfcv['status_pendiente'],
                                             'status_procesando' => $yergfcv['status_procesando'],
                                             'tienda_cuenta_cliente' => $yergfcv['tienda_cuenta_cliente'],
                                             'peticiones_mercancias' => $yergfcv['peticiones_mercancias'],
                                             'status_liquidacion' => $yergfcv['status_liquidacion'],
                                             'code_admin' => $yergfcv['code_admin'],
                                             'retirarado' => $yergfcv['retirarado'],);
            tep_db_perform(TABLE_ADMIN, $sql_status_update_array, 'update', " admin_groups_id = '" . $yergfcvs['admin_groups_id'] . "'and admin_id = '" . $login_id. "'");



if ($vp){



      Header('Location: orders_tienda.php?page=1&oID='.$oID . '&action=edit');
	// tep_redirect(tep_href_link('orders_tienda.php?page=1&oID='.$oID . '&action=edit'));

} else if ($vp_2){

    Header('Location: edit_orders_tienda.php?page=1&oID='.$oID);

 	// tep_redirect(tep_href_link('edit_orders_tienda.php?page=1&oID='.$oID . ''));


}else{
//Header('Location: orders_tienda.php?selected_box='.$yergfcv['name_boxes'].'&borrame='.$value_edit);
  	// tep_redirect(tep_href_link('orders_tienda.php?selected_box='.$yergfcv['name_boxes'].'&borrame='.$value_edit));
  }

}














                                                                                                                                                                                                                                                                         
                       
        $scs_query = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $admin['id']. "'");
        $scs = tep_db_fetch_array($scs_query);


$login_groups_id =  $scs['admin_groups_id'];
$admin_email_address = $scs['admin_email_address'];

$login_recoger = $scs['recoger'];
$login_credito = $scs['credito'];
$albaran = $scs['albaran'];
$albaran_cobrar = $scs['albaran_cobrar'];
$login_facturado = $scs['facturado'];
$login_cancelado = $scs['cancelado'];
$login_esperando_respuesta = $scs['esperando_resupuesta'];
$login_cambio_procesando = $scs['cambio_procesando'];



$cobrado = $scs['cobrado'];
$reserva = $scs['reserva'];
$abono = $scs['abono'];
$abono_true = $scs['abono_true'];
$pagado = $scs['pagado'];
$pagado_internacional = $scs['pagado_internacional'];
$pagado_transferencia = $scs['pagado_transferencia'];
$pagado_paypal = $scs['pagado_paypal'];

$login_paypal_enviado = $scs['paypal_enviado'];
$login_transferencia = $scs['transferencia'];






$login_no_recogido = $scs['no_recogido'];

$entregas_stock = $scs['entregas_stock'];
$retirarado = $scs['retirarado'];
$code_admin = $scs['code_admin'];
$name_boxes = $scs['name_boxes'];
$status_salidas = $scs['status_salidas'];
$status_entregas = $scs['status_entregas'];
$status_liquidacion = $scs['status_liquidacion'];
$tienda_cuenta_cliente = $scs['tienda_cuenta_cliente'];
$login_id_remoto = $scs['admin_id_remoto'];
$login_peticiones_mercancias = $scs['peticiones_mercancias'];
$login_pendiente_entrada = $scs['pendiente_entrada'];
$login_pendiente_entrada_entienda = $scs['pendiente_entrada_entienda'];
$login_presupuestos = $scs['presupuestos'];
$login_pendiente = $scs['status_pendiente'];
$login_procesando = $scs['status_procesando'];
$login_procesando_reembolso_internacional = $scs['procesando_reembolso_internacional'];
$login_transferencia_procesando = $scs['transferencia_procesando'];
$login_procesando_paypal = $scs['procesando_paypal'];
$login_cambio_procesando = $scs['cambio_procesando'];
$customer_cc = $scs['tienda_cuenta_cliente'];
$mercancia_entregado_procesando = $scs['mercancia_entregado_procesando'];

 if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}

         $scsh_query = tep_db_query("select admin_email_address,status_pendiente,cobrado,presupuestos,pendiente_entrada,peticiones_mercancias,admin_id_remoto,abono,pagado,entregas_stock,retirarado,code_admin,name_boxes,status_salidas,status_entregas,status_liquidacion,tienda_cuenta_cliente from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
         $scsh = tep_db_fetch_array($scsh_query);



$admin_email_address = $scsh['admin_email_address'];


      $secury_files_values = tep_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where admin_groups_id like '%" . $login_groups_id . "%' and admin_files_name = '" . $PHP_SELF . "'");
   if  ($secury_files = tep_db_fetch_array($secury_files_values)){
           //  echo  $secury_files['admin_files_name'].'S';







  }else{


         if ($PHP_SELF == 'login.php'){

   }else{

   tep_redirect(tep_href_link('categories.php'));
   
}




 //tep_redirect(tep_href_link(FILENAME_FORBIDEN));

 }
  
  // Include OSC-AFFILIATE
  include(DIR_WS_INCLUDES . 'affiliate_application_top.php');



/*

  if (VIEW_COUNTER_ENABLED == 'true') {


      if (VIEW_COUNTER_FORCE_RESET > 0) {
          $dateNow = @date("Y-m-d", time() - (VIEW_COUNTER_FORCE_RESET * 86400)) . ' 23:59:59';
          tep_db_query("delete from " . TABLE_VIEW_COUNTER . " where last_date < '" . $dateNow ."' ");
          tep_db_query("optimize table " . TABLE_VIEW_COUNTER);
      }

      if (VIEW_COUNTER_FORCE_RESET_STORAGE > 0) {
          $dateNow = @date("Y-m-d", time() - (VIEW_COUNTER_FORCE_RESET_STORAGE * 86400)) . ' 23:59:59';
          tep_db_query("delete from " . TABLE_VIEW_COUNTER_STORAGE . " where last_date < '" . $dateNow ."' ");
          tep_db_query("optimize table " . TABLE_VIEW_COUNTER_STORAGE);

      }

      include(DIR_FS_CATALOG . DIR_WS_MODULES . FILENAME_VIEW_COUNTER);
  }
  /

                     */
?>
