<?php

  require('includes/application_top.php');

 $empresa_values = mysql_query("select * from " . 'affiliate_patrocinemonos' . " where selec='" . 1 . "'");
 $empresa = mysql_fetch_array($empresa_values);

if ($HTTP_GET_VARS['salida_c']){

       //    ECHO $HTTP_GET_VARS['categories_name'];                                                                                    $HTTP_GET_VARS['']
 Header("Location: ".$empresa['patrocinemonos_homepage']."actualizar_productos.php?action=process&categories=ok&empresa_email_address=".$HTTP_GET_VARS['empresa_email_address']."&password=".$HTTP_GET_VARS['password']."&categories_id=".$HTTP_GET_VARS['categories_id']."&categories_name=".$HTTP_GET_VARS['categories_name']."&parent_id=".$HTTP_GET_VARS['parent_id']."");
           }

if ($HTTP_GET_VARS['salida_ca']){

                                             // echo   $HTTP_GET_VARS['empresa_email_address'];
 Header("Location: ".$empresa['patrocinemonos_homepage']."actualizar_productos.php?action=process&products=ok&empresa_email_address=".$HTTP_GET_VARS['empresa_email_address']."&password=".$HTTP_GET_VARS['password']."&products_id=".$HTTP_GET_VARS['products_id']."&products_model=".$HTTP_GET_VARS['products_model']."&products_image=".$HTTP_GET_VARS['products_image']."&products_price=".$HTTP_GET_VARS['products_price']."&products_weight=".$HTTP_GET_VARS['products_weight']."&products_status=".$HTTP_GET_VARS['products_status']."&products_name=".$HTTP_GET_VARS['products_name']."&products_url=".$HTTP_GET_VARS['products_url']."&products_date_added=".$HTTP_GET_VARS['products_date_added']."&products_last_modified=".$HTTP_GET_VARS['products_last_modified']."&products_categories=".$HTTP_GET_VARS['products_categories']."&categories_id=".$HTTP_GET_VARS['categories_id']."&parent_id=".$HTTP_GET_VARS['parent_id']."&categories_name=".$HTTP_GET_VARS['categories_name']."&specials_new_products_price=".$HTTP_GET_VARS['specials_new_products_price']."&specials_date_added=".$HTTP_GET_VARS['specials_date_added']."&specials_last_modified=".$HTTP_GET_VARS['specials_last_modified']."&expires_date=".$HTTP_GET_VARS['expires_date']."&date_status_change=".$HTTP_GET_VARS['date_status_change']."&status=".$HTTP_GET_VARS['status']."");

           }

if ($HTTP_GET_VARS['salida_cb']){
  Header("Location: ".$empresa['patrocinemonos_homepage']."actualizar_productos.php?action=process&products_to_categories=ok&empresa_email_address=".$HTTP_GET_VARS['empresa_email_address']."&password=".$HTTP_GET_VARS['password']."&products_id=".$HTTP_GET_VARS['products_id']."&categories_id=".$HTTP_GET_VARS['categories_id']."");

           }
                  ?>















