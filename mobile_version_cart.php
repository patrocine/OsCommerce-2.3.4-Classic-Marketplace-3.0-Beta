<?php


    if(ereg("Android", $_SERVER["HTTP_USER_AGENT"])){
  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
  //  tep_redirect(tep_href_link('mobile_login.php', '', 'SSL'));
  }}

//header('Location:'. HTTP_COOKIE_PATH .'mobile_shopping_cart.php');
} if(ereg("iPhone", $_SERVER["HTTP_USER_AGENT"])){

  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
   // tep_redirect(tep_href_link('mobile_login.php', '', 'SSL'));
  }}
  
  
//header('Location:'. HTTP_COOKIE_PATH .'mobile_shopping_cart.php');
} if(ereg("BlackBerry", $_SERVER["HTTP_USER_AGENT"])){

  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
   // tep_redirect(tep_href_link('mobile_login.php', '', 'SSL'));
  }}



//header('Location:'. HTTP_COOKIE_PATH .'mobile_shopping_cart.php');

}

?>



