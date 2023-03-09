<?php


    $palabraclave = $_POST['palabraclave'];
    $cambio_monetario = $_POST['cambio_monetario'];
    $codigobarras_inv = $_POST['codigobarras_inv'];
    $codigobarras = $_POST['codigobarras'];
    $new_product = $_POST['new_product'];
    $unidades = $_POST['unidades'];
    $productoid = $_GET['productoid'];
    $prueba_notif = $_GET['prueba_notif'];
     $enviarpedido_notif = $_GET['enviarpedido_notif'];
     $donde_esta = $_GET['donde_esta'];
     $actualizar_cantidades = $_GET['actualizar_cantidades'];
               $codigobarras_negativos = $_GET['codigobarras_negativos'];
   // $codigobarras = ereg_replace("-M", "-", $codigobarras);
 //  $codigobarras_inv  =  ereg_replace("-M", "-", $codigobarras_inv);
  //  $palabraclave  =  ereg_replace("-M", "-", $palabraclave);

   $codigobarrasID = $codigobarras;

       $sel_iten_1 = $_POST['sel_iten_1'];
      $level_iten = $_GET['level_iten'];



// TAREA EN 270

        


         
  /*  CH'098
  CH'098
  CH'098
  
  $Id: edit_orders.php, v2.1 2006/03/21 10:42:44 ams Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce

  Released under the GNU General Public License
 
  Original file written by Jonathan Hilgeman of SiteCreative.com

*/

   
  // First things first: get the required includes, classes, etc.
  require('includes/application_top.php');
  require('includes/status_tiendas.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ORDER_PROCESS_TIENDA);
  
    $codigobarras = CODIGODEBARRAS . $codigobarras;


   $oID = $_GET['oID'];

                            //2393
   require(DIR_WS_INCLUDES . 'template_top.php');







 $query = tep_db_query("SELECT * FROM `configuration` WHERE  configuration_key='" . 'NEW_PRODUCT_PRE' . "'");
$new_product_pre = tep_db_fetch_array($query);




$action_in = $_GET['action_in'];
$codigobarras_in = $_GET['codigobarras_in'];


        echo $codigobarras;
  if ($action_in == 'true'){

       $newproducts_values = tep_db_query("select * from " . 'products' . " where products_model = '" . $codigobarras_in . "' or codigo_barras = '" . $codigobarras_in . "'");
      if ($newproducts = tep_db_fetch_array($newproducts_values)){
             echo '<font color="#008000" size="1" face="Arial Black">Producto con ean '.$codigobarras_in.' se importo correctamente</font>';
     }else{
             echo '<font color="#ff0000" size="1" face="Arial Black">Producto con ean '.$codigobarras_in.' No Disponible</font>';
       ?>


 <script language=javascript>
window.open('categories.php<? echo '?cPath=' . $categories['parent_id'] . '&action=new_product&codigobarras='.$codigobarras_in.'&action_in=true';  ?>', '_blank');
</script>




    <?php

}}







           if (NEW_PRODUCT == 1){

        $newproducts_values = tep_db_query("select pd.products_name from " . 'products' . " p, products_description pd where p.products_id = pd.products_id and p.products_model = '" . $codigobarras . "'");
      if ($newproducts = tep_db_fetch_array($newproducts_values)){

                  if ($newproducts['products_name'] == $codigobarras){

                if (NEW_PRODUCT_PRE == 1){
                                                    //zona envío
               $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){

             //   echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='. $codigobarras .'&url='. HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'products_stock_nuevaalta.php' . '"> </script>';

         echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='.$codigobarras.'&url='. HTTPS_SERVER . DIR_WS_CATALOG . 'admin/products_stock_nuevaalta.php' . '&proveedor_id=' . $product_compartir['proveedor_id'] . '"> </script>';
                      }
    //   echo  header("Location: '" . $PHP_SELF.'?codigobarras=' . $codigobarras . '&oID='.$oID.'&action=edit' . "'");

         ?>

           <script type="text/javascript">
    var pagina = '<?php echo $PHP_SELF.'?codigobarras_in=' . $codigobarras . '&oID='.$oID.'&action=edit&action_in=true'; ?>';
    var segundos = 999999999999999999999;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

   <?php
    }
       }

























    }else{


                 if (NEW_PRODUCT_PRE == 1){

                                                     //zona envío
                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){


             //   echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='. $codigobarras .'&url='. HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'products_stock_nuevaalta.php' . '"> </script>';

   echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='.$codigobarras.'&url='. HTTPS_SERVER . DIR_WS_CATALOG . 'admin/products_stock_nuevaalta.php' . '&proveedor_id=' . $product_compartir['proveedor_id'] . '"> </script>';
                              }


       if  ($codigobarras){

    //   echo  header("Location: '" . $PHP_SELF.'?codigobarras=' . $codigobarras . '&oID='.$oID.'&action=edit' . "'");

         ?>
            <?php $PHP_SELF.'?codigobarras_in=' . $codigobarras . '&oID='.$oID.'&action=edit&action_in=true'; ?>
            
           <script type="text/javascript">
    var pagina = '<?php echo $PHP_SELF.'?codigobarras_in=' . $codigobarras . '&oID='.$oID.'&action=edit&action_in=true'; ?>';
    var segundos = 9999999999999999999999999;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>






    <?php

            }

               }


}



}









                 if (NEW_PRODUCT == 2){
                         $codigobarras_in = $codigobarras;
                 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
                 if ($products = tep_db_fetch_array($query)){

                             }else{
                                                       //zona envío
                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){


             //   echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='. $codigobarras .'&url='. HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'products_stock_nuevaalta.php' . '"> </script>';
        echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='.$codigobarras.'&url='. HTTPS_SERVER . DIR_WS_CATALOG . 'admin/products_stock_nuevaalta.php' . '&proveedor_id=' . $product_compartir['proveedor_id'] . '"> </script>';
                              }





    }

  }




 require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  include(DIR_WS_CLASSES . 'order.php');
       $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);



if ($level_iten==2 ){


	tep_db_query ("UPDATE " . 'orders' . " SET
					sel_iten_max = '" . 2 . "'
					WHERE orders_id = '" . $oID . "' ");
         ?>

 <script language=javascript>
window.open('<? echo 'edit_orders_tienda.php?oID='.$oID.'&action=edit&action_cod=o&escbot=ok';  ?>', '_blank');
</script>


<?php


                    }

if ($level_iten==1 ){
 	tep_db_query ("UPDATE " . 'orders' . " SET
					sel_iten_max = '" . 1 . "'
					WHERE orders_id = '" . $oID . "' ");

                   
         ?>

 <script language=javascript>
window.open('<? echo 'edit_orders_tienda.php?oID='.$oID.'&action=edit&action_cod=o&escbot=ok';  ?>', '_blank');
</script>


<?php

                   
                   
                    }
if ($porcentage_tienda['sel_iten_max'] == 2){

    $sel_iten_max = 10;
    
}else{
  $sel_iten_max = 9999;
}




                                                                                                              
         /*

                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");




    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.codigo_barras = '" . $codigobarras_inv . "' or  p.products_id = pd.products_id and p.products_model = '" . $codigobarras_inv . "' or  p.products_id = pd.products_id and p.products_id = '" . $productoid . "'");
   if ($codigobarras_c = tep_db_fetch_array($codigobarras_values)){






  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op where o.orders_status = '" . $abono . "' and op.orders_id= o.orders_id  and op.products_id= '" . $codigobarras_c['products_id'] . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){


              */
  
  
  
  
     // Resetear Inventario
     
     

     
     
     
     
                                          /*
     
                                                        //zona envío
                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



             //   echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='. $codigobarras .'&url='. HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'products_stock_nuevaalta.php' . '"> </script>';
        echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='.$codigobarras.'&url='. HTTPS_SERVER . DIR_WS_CATALOG . 'products_stock_nuevaalta.php' . '"> </script>';



    }
     
     
                    */
     
     




     
     
     
     
     


     
     
   if ($prueba_notif){

     $de_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
     $de = tep_db_fetch_array($de_values);





$mail_notif .= "Su pedido necesita de su atención. ". "\n" ;
$mail_notif .= "Algunos productos de su pedido no están disponibles pero podemos ofrecerle otra alternativa.". "\n" . "\n" ;
$mail_notif .= "Podemos cambiarle este producto". "\n" ;

   $top1_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $oID . "' and cambio_de_productos = 1 ");
    while ($top1 = tep_db_fetch_array($top1_values)){

   $mail_notif .= $top1['products_quantity']  . " x " . $top1['products_name'] . " - " . number_format($top1['products_price'], 2, '.', '') . "€ \n" ;

}
$mail_notif .= "\n";

$mail_notif .= "Por este otro". "\n" ;


   $top1_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $oID . "' and cambio_de_productos = 2 ");
    while ($top1 = tep_db_fetch_array($top1_values)){

   $mail_notif .= $top1['products_quantity']  . " x " . $top1['products_name'] . " - " . number_format($top1['products_price'], 2, '.', '') . "€ \n" ;

}

$mail_notif .= "\n";
$mail_notif .= "(haga click en el link para aceptar)". "\n" . "\n";
$mail_notif .= "Si, acepto el cambio que me propones". "\n";
$mail_notif .= HTTP_SERVER."/decidir.php?aceptar_cambio=ok&pedido=" . $oID . "&nombre=".$de['delivery_postcode']."". "\n" . "\n";
$mail_notif .= "Deseo Cancelar el pedido". "\n" ;
$mail_notif .= HTTP_SERVER."/decidir.php?cancelar_pedido=ok&pedido=" . $oID . "&nombre=".$de['delivery_postcode']."". "\n" . "\n";
$mail_notif .= "Deseo que el pedido siga como esta esperaré a que este disponible". "\n" ;
$mail_notif .= HTTP_SERVER."/decidir.php?esperar=ok&pedido=" . $oID . "&nombre=".$de['delivery_postcode']."". "\n" . "\n";

$mail_notif .= "\n";
$mail_notif .= "\n";

$mail_notif .= "Responda a este mail si tiene alguna consulta que hacernos.". "\n" . "\n";

 tep_mail('', $de['customers_email_address'], STORE_NAME.'Modificación de Pedidos', $mail_notif, '', EMAIL_FROM);

     echo 'Notificación de cambio enviada.';



   }





 // envio de mail pedir al cliente si quiere que se le envíe el pedido.

   if ($enviarpedido_notif){

     $de_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
     $de = tep_db_fetch_array($de_values);





$mail_notif .= "SU PEDIDO YA SE ENCUENTRA EN STOCK". "\n" . "\n" ;
$mail_notif .= "Podemos enviarselo de inmediato". "\n" ;


$mail_notif .= "SU PEDIDO". "\n" ;


   $top1_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $oID . "'");
    while ($top1 = tep_db_fetch_array($top1_values)){

   $mail_notif .= $top1['products_quantity']  . " x " . $top1['products_name'] . " - " . number_format($top1['products_price'], 2, '.', '') . "€ \n" ;

}




$mail_notif .= "\n";
$mail_notif .= "(haga click en el link para aceptar)". "\n" . "\n";
$mail_notif .= "Si, acepto el envío". "\n";
$mail_notif .= HTTP_SERVER."/decidir.php?enviar_producto=ok&pedido=" . $oID . "&nombre=".$de['delivery_postcode']."". "\n" . "\n";
$mail_notif .= "Deseo Cancelar el pedido". "\n" ;
$mail_notif .= HTTP_SERVER."/decidir.php?cancelar_pedido=ok&pedido=" . $oID . "&nombre=".$de['delivery_postcode']."". "\n" . "\n";

$mail_notif .= "\n";
$mail_notif .= "\n";

$mail_notif .= "Responda a este mail si tiene alguna consulta que hacernos.". "\n" . "\n";

 tep_mail('', $de['customers_email_address'], STORE_NAME.'SU PEDIDO YA SE ENCUENTRA EN STOCK', $mail_notif, '', EMAIL_FROM);

      echo 'Notificación el pedido esta disponible';



   }





     
     
     
  if ($reset_inventario){


                       $sql_status_update_array = array('products_inventario' => 0,);

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_id= '" . $oID . "'");


}






  
    if ($inventario){






  if ($codigobarras){

}else{
  $codigobarras = 'noaynada';
}


    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.codigo_barras = '" . $codigobarras_inv . "' or  p.products_id = pd.products_id and p.products_model = '" . $codigobarras_inv . "'
                                                                                                                                                                                                              or  p.products_id = pd.products_id and p.products_model_2 = '" . $codigobarras_inv . "'
                                                                                                                                                                                                              or  p.products_id = pd.products_id and p.products_model_3 = '" . $codigobarras_inv . "'");
   if ($codigobarras_cd = tep_db_fetch_array($codigobarras_values)){






  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op where o.orders_id = '" . $oID . "' and op.orders_id= '" . $oID . "'  and op.products_id= '" . $codigobarras_cd['products_id'] . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){




                      $sql_status_update_array = array('products_inventario' => $unidades_inv + $codigobarras_a['products_inventario'],);

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

 echo '<p><b><font face="Verdana" size="1" color="#0000FF">Actualizado Correctamente</font></b></p>';

}else{

 echo '<p><b><font size="1" face="Verdana" color="#FF0000">No se ha actualizado ningún producto</font></b></p>';

}




}

}else{



}



// Next up: define the functions unique to this file 
 // Function    : tep_get_country_id
  // Arguments   : country_name		country name string
  // Return      : country_id
  // Description : Function to retrieve the country_id based on the country's name
  function tep_get_country_id($country_name) {
    $country_id_query = tep_db_query("select * from " . TABLE_COUNTRIES . " where countries_name = '" . $country_name . "'");
    if (!tep_db_num_rows($country_id_query)) {
      return 0;
    }
    else {
      $country_id_row = tep_db_fetch_array($country_id_query);
      return $country_id_row['countries_id'];
    }
  }

   // Function    : tep_get_zone_id
  // Arguments   : country_id		country id string    zone_name		state/province name
  // Return      : zone_id
  // Description : Function to retrieve the zone_id based on the zone's name
  function tep_get_zone_id($country_id, $zone_name) {
    $zone_id_query = tep_db_query("select * from " . TABLE_ZONES . " where zone_country_id = '" . $country_id . "' and zone_name = '" . $zone_name . "'");
    if (!tep_db_num_rows($zone_id_query)) {
      return 0;
    }
    else {
      $zone_id_row = tep_db_fetch_array($zone_id_query);
      return $zone_id_row['zone_id'];
    }
  }
  
  // Function    : tep_field_exists
  // Arguments   : table	table name  field  	field name
  // Return      : true/false
  // Description : Function to check the existence of a database field
  function tep_field_exists($table,$field) {
    $describe_query = tep_db_query("describe $table");
    while($d_row = tep_db_fetch_array($describe_query))
    {
      if ($d_row["Field"] == "$field")
      return true;
    }
    return false;
  }

  // Function    : tep_html_quotes
  // Arguments   : string	any string
  // Return      : string with single quotes converted to html equivalent
  // Description : Function to change quotes to HTML equivalents for form inputs.
  function tep_html_quotes($string) {
    return str_replace("'", "&#39;", $string);
  }

  // Function    : tep_html_unquote
  // Arguments   : string	any string
  // Return      : string with html equivalent converted back to single quotes
  // Description : Function to change HTML equivalents back to quotes
  function tep_html_unquote($string) {
    return str_replace("&#39;", "'", $string);
  }
  //
  
   // Then we get down to the nitty gritty
   
   if ($login_groups_id == 1){

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 2 . "' or  language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 3 . "'ORDER BY orders_status_name");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }
  
  


}else{

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 2 . "'ORDER BY orders_status_name");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }

}

  $action = (isset($_GET['action']) ? $_GET['action'] : 'edit');

  // Update Inventory Quantity
  if (tep_not_null($action)) {
    switch ($action) {
    	
	// 1. UPDATE ORDER ###############################################################################################
	case 'update_order':

          if (tep_session_is_registered('admin')) {





		$oID = tep_db_prepare_input($_GET['oID']);
		$order = new order($oID);
		$status = tep_db_prepare_input($_POST['status']);
  

  
  
		             if ($_POST['status']){ //evita que cuando caduque secion se altere el status.
               
               
               
               

               
               
               
               
               
               
		// 1.1 UPDATE ORDER INFO #####
		$UpdateOrders = "UPDATE " . TABLE_ORDERS . " set
			customers_name = '" . tep_db_input(stripslashes($_POST['update_customer_name'])) . "',
			customers_company = '" . tep_db_input(stripslashes($_POST['update_customer_company'])) . "',
			customers_street_address = '" . tep_db_input(stripslashes($_POST['update_customer_street_address'])) . "',
			customers_suburb = '" . tep_db_input(stripslashes($_POST['update_customer_suburb'])) . "',
			customers_city = '" . tep_db_input(stripslashes($_POST['update_customer_city'])) . "',
			customers_state = '" . tep_db_input(stripslashes($_POST['update_customer_state'])) . "',
			customers_postcode = '" . tep_db_input($_POST['update_customer_postcode']) . "',
			customers_country = '" . tep_db_input(stripslashes($_POST['update_customer_country'])) . "',
			customers_telephone = '" . tep_db_input($_POST['update_customer_telephone']) . "',
			last_modified = '" . tep_db_input($_POST['update_last_modified']) . "',
			customers_email_address = '" . tep_db_input($_POST['update_customer_email_address']) . "',";

		$UpdateOrders .= "billing_name = '" . tep_db_input(stripslashes($_POST['update_billing_name'])) . "',
			billing_company = '" . tep_db_input(stripslashes($_POST['update_billing_company'])) . "',
			billing_street_address = '" . tep_db_input(stripslashes($_POST['update_billing_street_address'])) . "',
			billing_suburb = '" . tep_db_input(stripslashes($_POST['update_billing_suburb'])) . "',
			billing_city = '" . tep_db_input(stripslashes($_POST['update_billing_city'])) . "',
			billing_state = '" . tep_db_input(stripslashes($_POST['update_billing_state'])) . "',
			billing_postcode = '" . tep_db_input($_POST['update_billing_postcode']) . "',
			billing_country = '" . tep_db_input(stripslashes($_POST['update_billing_country'])) . "',";

		$UpdateOrders .= "delivery_name = '" . tep_db_input(stripslashes($_POST['update_delivery_name'])) . "',
			delivery_company = '" . tep_db_input(stripslashes($_POST['update_delivery_company'])) . "',
			delivery_street_address = '" . tep_db_input(stripslashes($_POST['update_delivery_street_address'])) . "',
			delivery_suburb = '" . tep_db_input(stripslashes($_POST['update_delivery_suburb'])) . "',
			delivery_city = '" . tep_db_input(stripslashes($_POST['update_delivery_city'])) . "',
			delivery_state = '" . tep_db_input(stripslashes($_POST['update_delivery_state'])) . "',
			delivery_postcode = '" . tep_db_input($_POST['update_delivery_postcode']) . "',
			delivery_country = '" . tep_db_input(stripslashes($_POST['update_delivery_country'])) . "',
			payment_method = '" . tep_db_input($_POST['update_info_payment_method']) . "',
			cc_type = '" . tep_db_input($_POST['update_info_cc_type']) . "',
			cc_owner = '" . tep_db_input($_POST['update_info_cc_owner']) . "',
			cc_number = '" . tep_db_input($_POST['update_info_cc_number']) . "',
            cc_expires = '" . tep_db_input($_POST['update_info_cc_expires']) . "'";

               //last_modified = '" . date ("Y-m-d H:i:s") . "',

		$UpdateOrders .= " where orders_id = '" . tep_db_input($_GET['oID']) . "';";

		tep_db_query($UpdateOrders);
		$order_updated = true;


    $pro_last_modified_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" .  $oID. "'");
    $pro_last_modified = tep_db_fetch_array($pro_last_modified_values);

    $id_factura_ultimo_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" .  $pagado. "' or orders_status = '" .  $status_liquidacion. "' order by factura_id desc");
    $id_factura_ultimo = tep_db_fetch_array($id_factura_ultimo_values);
    
    $id_factura_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" .  $oID. "' and orders_status = '" .  $pagado. "'or orders_id = '" .  $oID. "' and orders_status = '" .  $status_liquidacion. "' order by factura_id desc");
    $id_factura = tep_db_fetch_array($id_factura_values);

                             

                                   //status pagado y pagos procesando bloqueados
                           if ($pagado == $_POST['status'] or $status_liquidacion == $_POST['status']){


                            if ($pro_last_modified['orders_status'] == $pagado or $pro_last_modified['orders_status'] == $status_liquidacion){









          tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $_POST['status'] . "', last_modified = '" . $pro_last_modified['last_modified'] . "' where orders_id = '" . $oID . "'");





                                                                                   }else{
        tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $_POST['status'] . "', last_modified = '" . date ("Y-m-d H:i:s") . "' where orders_id = '" . $oID . "'");
                                                         }
      if ($id_factura['factura_id']){

            }else{
                if ($pagado == $_POST['status'] or $status_liquidacion == $_POST['status']){
	tep_db_query ("UPDATE " . TABLE_ORDERS . " SET
					factura_id = '" . ++$id_factura_ultimo['factura_id'] . "'
					WHERE orders_id = '" . $oID . "' ");
                              }


                  }

                                                              }else{

   if ($pro_last_modified['orders_status'] <> $pagado or $pro_last_modified['orders_status'] <> $status_liquidacion){






   if ($pro_last_modified['orders_status'] == $pagado or $pro_last_modified['orders_status'] == $status_liquidacion){
   }else{
          tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $_POST['status'] . "', last_modified ='" . date ("Y-m-d H:i:s") . "' where orders_id = '" . $oID . "'");








     }

}ELSE{





           tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $_POST['status'] . "', last_modified ='" . date ("Y-m-d H:i:s") . "' where orders_id = '" . $oID . "'");

 }


}










                                    // actualiza las observaciones en la ficha del cliente
                           
    $c_observ_query = tep_db_query("select customers_id from " . TABLE_ORDERS . " where orders_id = '" . $_GET['oID'] . "'");
    $c_observ = tep_db_fetch_array($c_observ_query);

                      $sql_status_update_array = array('customers_observaciones' => $_POST['customers_observaciones'],
                                                      );

             tep_db_perform(TABLE_CUSTOMERS, $sql_status_update_array, 'update', " customers_id= '" . $c_observ['customers_id'] . "'");

                                        // FI




  

     $sql_data_array = array('orders_id' => $_GET['oID'],
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
						'orders_status_id' => $_POST['status'], //for MS1 or MS2
                          'date_added' => date ("Y-m-d H:i:s"));
    tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
                                              }//evita que cuando caduque secion se altere el status.
                                              
                                        } // FIN ADMIN
                                              
                                              
                                              

    $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
    $check_status = tep_db_fetch_array($check_status_query);
	
		// 1.2 UPDATE STATUS HISTORY & SEND EMAIL TO CUSTOMER IF NECESSARY #####
		
		 if ( ($check_status['orders_status'] != $status) || tep_not_null($_POST['comments'])) {
		        if ($_POST['status']){ //evita que cuando caduque secion se altere el status.
			// Notify Customer
      $customer_notified = '0';
			if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {
			  $notify_comments = '';
			  if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on')) {
			    $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $_POST['comments']) . "\n\n";
			  }
			  $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]) . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE2);
			  tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
			  $customer_notified = '1';
			}			  
          		
			tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " 
				(orders_id, orders_status_id, date_added, customer_notified, comments) 
				values ('" . tep_db_input($_GET['oID']) . "', '" . tep_db_input($_POST['status']) . "', now(), " . tep_db_input($customer_notified) . ", '" . tep_db_input($_POST['comments'])  . "')");
			}

                }//evita que cuando caduque secion se altere el status.


		// 1.3 UPDATE PRODUCTS #####
		
		$RunningSubTotal = 0;
		$RunningTax = 0;

    // Do pre-check for subtotal field existence (CWS)
		$ot_subtotal_found = false;
		$ot_total_found = false;
		if (is_array ($_POST['update_totals'])) {
	foreach($_POST['update_totals'] as $total_details) {
		  extract($total_details,EXTR_PREFIX_ALL,"ot");
			if($ot_class == "ot_subtotal") {
			  $ot_subtotal_found = true;
    	break;
			}
			
			if($ot_class == "ot_total"){
			$ot_total_found = true;
			break;
			}
		}//end foreach() 
		}//end if (is_array())
		        
		// 1.3.1 Update orders_products Table
		if (is_array($_POST['update_products'])){
		foreach($_POST['update_products'] as $orders_products_id => $products_details)	{




			// 1.3.1.1 Update Inventory Quantity
			$order_query = tep_db_query("SELECT products_id, products_quantity 
			FROM " . TABLE_ORDERS_PRODUCTS . " 
			WHERE orders_id = '" . (int)$oID . "'
			AND orders_products_id = '$orders_products_id'");
			$order = tep_db_fetch_array($order_query);
   
   

      //    $sql_status_update_array = array('codigo_barras' => $products_details["codigo_barras"],  );
          //  tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $orders_products_id . "'");



			// First we do a stock check 
			if ($products_details["qty"] != $order['products_quantity']){
			$quantity_difference = ($products_details["qty"] - $order['products_quantity']);
				if (STOCK_CHECK == 'true'){
				    tep_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
					products_quantity = products_quantity - " . $quantity_difference . ",
					products_ordered = products_ordered + " . $quantity_difference . " 
					WHERE products_id = '" . (int)$order['products_id'] . "'");
					} else {
					tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_ordered = products_ordered + " . $quantity_difference . "
					WHERE products_id = '" . (int)$order['products_id'] . "'");
				}
			}
               
	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_model_2 = '" . $products_details['model_2'] . "',
					products_model_3 = '" . $products_details['model_3'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "' ");





$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

                              //NUEVO PRODUCTO
         if (isset($products_details["products_aut_referencia1"])){

	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_model = '" . $products_details['model'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "' ");

                        }
                        
                        

                        
                        
                        


                              //NUEVO PRODUCTO
         if (isset($products_details["products_shoptoshop"])){

	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_shoptoshop = '" . $products_details["products_shoptoshop"] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "' ");

                        }


               if (isset($products_details["products_news_update"])){

             	tep_db_query ("UPDATE " . TABLE_PRODUCTS_DESCRIPTION . " SET
					products_name = '" . $products_details["name"] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "' ");

           }






                               //NUEVO PRODUCTO
         if (isset($products_details["products_news"])){

    $new_product_query = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_model = '" . $products_details["model"] . "'");
   if ($new_product = tep_db_fetch_array($new_product_query)){





     } else {

      $sql_data_array = array(//Comment out line you don't need
							//'new_value' => $new_value,
							'products_price' => $products_details['price'],
                            'products_model' => $products_details['model'],
                            'stock_nivel' => 6,
                            'products_rc' => 2,
                            'products_date_added' => $oldday1);
     tep_db_perform(TABLE_PRODUCTS, $sql_data_array);

    $new_productd_query = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_model = '" . $products_details["model"] . "'");
   if ($new_productd = tep_db_fetch_array($new_productd_query)){



      $sql_data_array = array(//Comment out line you don't need
							'products_id' => $new_productd['products_id'],
							'products_name' => $products_details['name'],
                            'language_id' => 1);
     tep_db_perform('products_description', $sql_data_array);
     
     
      $sql_data_array = array(//Comment out line you don't need
							'products_id' => $new_productd['products_id']);
     tep_db_perform('products_to_categories', $sql_data_array);
     
     
     }
     

     }

                                      }






 if (isset($products_details['products_aut_referencia2'])){
	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
                          products_model_2 = '" . $products_details['model_2'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "' ");
                                         }
 if (isset($products_details['products_aut_referencia3'])){
	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
                          products_model_3 = '" . $products_details['model_3'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "' ");
                                         }

                                         
           //quitar producto de la lista del proveedor
   if (isset($products_details['lista_prov_poner'])){



	tep_db_query ("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET
					lista_prov = 1
					WHERE products_id = '" . (int)$order['products_id'] . "' and orders_id = '" . (int)$oID . "'");


                 }
		   if (isset($products_details['lista_prov_quitar'])){



	tep_db_query ("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET
					lista_prov = 0
					WHERE products_id = '" . (int)$order['products_id'] . "' and orders_id = '" . (int)$oID . "'");


                 }
                 
                 
                 
           //Desvincular o vincular producto a la lista
   if (isset($products_details['products_status_exel_1'])){



	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_status_exel = 1
					WHERE products_id = '" . (int)$order['products_id'] . "' ");


                 }
		   if (isset($products_details['products_status_exel_2'])){



	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_status_exel = 2
					WHERE products_id = '" . (int)$order['products_id'] . "'");


                 }

                     if (isset($products_details['products_aut_codigo'])){


                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



                echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_codigo.php?products_id=' . (int)$order['products_id'] . '&codigo='. $products_details["codigo_barras"] .'"> </script>';


    }



                                   }
                                   
                                   
                                   
                                   
                     if (isset($products_details['products_aut_referencia2'])){


                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



                echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_codigo.php?products_id=' . (int)$order['products_id'] . '&referencia2='. $products_details["model_2"] .'"> </script>';


    }



                                  }
                                  
                                  
                                  
                                  


		   if (isset($products_details['products_price_modificar'])){



	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_price = '" . $products_details["price"] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "'");

                }
                
                
	tep_db_query ("UPDATE " . 'orders_products' . " SET
					products_price = '" . $products_details["price"] . "'
					WHERE orders_products_id = '" . $orders_products_id . "'");



                             // stock minimo para que pedir al proveedor

		   if (isset($products_details['stock_min'])){



	// tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
			//		products_stock_min = '" . $products_details['stock_min'] . "'
				//	WHERE products_id = '" . (int)$order['products_id'] . "'");

	tep_db_query ("UPDATE " . 'products_stock' . " SET
					products_stock_min = '" . $products_details['stock_min'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "'");

                 }
                 
                 
                 
                 
		   if ($products_details['pdc_unidades'] <> 0){


       $sql_data_array = array(//Comment out line you don't need
							'pdc_products_id' => (int)$order['products_id'],
							'pdc_unidades' => $products_details['pdc_unidades'],
                            'pdc_price_final' => $products_details['pdc_price_final']);
     tep_db_perform('products_descuento_cantidad', $sql_data_array);


                 }
                 
                 
                 


                             // Observaciones de productos para pedir al proveedor (ejemplo no pedir mas de 1 en cada pedido)

		   if (isset($products_details['stock_obs'])){



	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_stock_obs = '" . $products_details['stock_obs'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "'");


                 }

		   if (isset($products_details['products_descuento_onoff'])){



	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_descuento_onoff = '" . $products_details['products_descuento_onoff'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "'");


                 }



		   if (isset($products_details['products_special_status'])){

    $pro_special_values = tep_db_query("select * from " . 'specials' . " where products_id = '" .  (int)$order['products_id'] . "'");
    if ($pro_special = tep_db_fetch_array($pro_special_values)){

	tep_db_query ("UPDATE " . 'specials' . " SET
					status = '" . $products_details['products_special_status'] . "',
					specials_new_products_price = '" . $products_details['products_special_price'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "'");
     
     



}else{

 if ($products_details['products_special_status'] == 1) {
      $sql_data_array = array(//Comment out line you don't need
							'products_id' => (int)$order['products_id'],
							'status' => $products_details['products_special_status'],
                            'specials_new_products_price' => $products_details['products_special_price']);
     tep_db_perform('specials', $sql_data_array);



     


}
}

                		   if ($products_details['products_special_status']==2){

          			//then delete the little bugger
			$Query = "DELETE FROM " . 'specials' . "
			WHERE products_id = '" . (int)$order['products_id'] . "';";
				tep_db_query($Query);

                                          }







             }







		   if (isset($products_details['products_descuento_p'])){



	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_descuento = '" . $products_details['products_descuento_p'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "'");


                 }


		   if (isset($products_details['stock_nivel'])){



	tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					stock_nivel = '" . $products_details['stock_nivel'] . "'
					WHERE products_id = '" . (int)$order['products_id'] . "'");


                 }


                 
			 //Then we check if the product should be deleted
    
    
    
			 if (isset($products_details['delete'])){
			 //update quantities first
			 if (STOCK_CHECK == 'true'){
				    tep_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
					products_quantity = products_quantity + " . $products_details["qty"] . ",
					products_ordered = products_ordered - " . $products_details["qty"] . " 
					WHERE products_id = '" . (int)$order['products_id'] . "'");
					} else {
					tep_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_ordered = products_ordered - " . $products_details["qty"] . "
					WHERE products_id = '" . (int)$order['products_id'] . "'");
					}
					
			//then delete the little bugger
			$Query = "DELETE FROM " . TABLE_ORDERS_PRODUCTS . "
			WHERE orders_id = '" . (int)$oID . "'
			AND orders_products_id = '$orders_products_id';";
				tep_db_query($Query);

				// and all its attributes
				if(isset($products_details[attributes]))
				{
				$Query = "DELETE from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
				WHERE orders_id = '" . (int)$oID . "'
				AND orders_products_id = '$orders_products_id';";
				tep_db_query($Query);
				}

			
			}// end of if (isset($products_details['delete']))
			
			   else { // if we don't delete, we update
      
      
      

                                echo 'Procesando .....';
                                

                                
                                
                                
                                
                           $serie_c = 'ok';
require('includes/proveedores_precios.php');












       // MERCANCIAS PROCESANDO ENTREGAS


 if (isset($products_details['entregada_selec'])){



    $unidades =  $products_details['entregada_unidades'];



            //si es admin o tienda
     if ($login_id_remoto <> 0){
      $admin_a_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id_remoto . "'");
     $admin_a = tep_db_fetch_array($admin_a_values);

           }else{
      $admin_a_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id . "'");
     $admin_a = tep_db_fetch_array($admin_a_values);


     }             //fin



            //direcciones
     $address_books_values = tep_db_query("select * from " . 'address_book' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $address_books = tep_db_fetch_array($address_books_values);
     $customerss_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $customerss = tep_db_fetch_array($customerss_values);
              //fin


       //si el la peticion de entrada no existe se crea una nueva en la tienda correspondiente.
    $salidas_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $status_entregas . "'");
   if ($salidas_c = tep_db_fetch_array($salidas_values)){








                   //
                  //selecciona los productos y los datos de estos
    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . (int)$order['products_id'] . "'");
   if ($codigobarras_c = tep_db_fetch_array($codigobarras_values)){








  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where  orders_id = '" . $salidas_c['orders_id'] . "' and products_id = '" . (int)$order['products_id'] . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){


 //Pone el precio de oferta antes que el precio normal
  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}  //fin



                                                           //CHIVATOS
                                                echo '<font color="#008000" face="Verdana" size="1"><b>Actualizado Correctamente en (Mercancias Procesando Entregas)  - Serie A</b></font>';

                                                              //FIN
                             //
                              $serie_a = 'ok';
  require('includes/proveedores_precios.php');




                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

                      $sql_status_update_array = array('contencion' =>1,);

               if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;

            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $codigobarras_a['products_id'] . "'");







}else{

           $unidades =  $products_details['entregada_unidades'];



  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){

 // si el status de la oferta es uno el PVP se convierte en la oferta.
        if ($ofertas['status'] == 1){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}
}




                                echo '<p><b><font size="2" face="Verdana" color="#0000FF">Insertado Correctamente en (Mercancias Procesando Entregas) Serie B</font></b></p>';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'ddii';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $salidas_c['orders_id'] . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");






     }



       }










}else{


      $unidades =  $products_details['entregada_unidades'];



$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


   $sql_data_array = array('customers_id' => $address_books['customers_id'],
                          'customers_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'customers_company' => '',
                          'customers_street_address' => $address_books['entry_street_address'],
                          'customers_suburb' => '',
                          'customers_city' => $address_books['entry_city'],
                          'customers_postcode' => $address_books['entry_postcode'],
                          'customers_state' => '',
                          'customers_country' => $address_books['entry_country_id'],
                          'customers_telephone' => $customerss['customers_telephone'],
                          'customers_email_address' => $customerss['customers_email_address'],
                          'customers_address_format_id' => 1,
                          'delivery_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'delivery_company' => '',
                          'delivery_street_address' => $address_books['entry_street_address'],
                          'delivery_suburb' => '',
                          'delivery_city' => $address_books['entry_city'],
                          'delivery_postcode' => $customerss['customers_telephone'],
                          'delivery_state' => '',
                          'delivery_country' => $address_books['entry_country_id'],
                          'delivery_address_format_id' => 1,
                          'billing_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'billing_company' => '',
                          'billing_street_address' => $customerss['customers_email_address'],
                          'billing_suburb' => '',
                          'billing_city' => $address_books['entry_city'],
                          'billing_postcode' => $address_books['entry_postcode'],
                          'billing_state' => '',
                          'billing_country' => $address_books['entry_country_id'],
                          'billing_address_format_id' => 1,
                          'payment_method' => $order->info['payment_method'],
                          'cc_type' => '',
                          'cc_owner' => '',
                          'cc_number' => '',
                          'cc_expires' => '',
                          'date_purchased' => $oldday1,
                          'last_modified' => $oldday1,
                          'orders_status' => $status_entregas,
                          'currency' => 'EUR',
                          'currency_value' => 1);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

    $insert_id = tep_db_insert_id();


      $sql_data_array = array('orders_id' => $insert_id,
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
							'orders_status_id' => $status_entregas, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_SUBTOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_subtotal",
                            'sort_order' => "1");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);


   $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DISCOUNT,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_customer_discount",
                            'sort_order' => "2");
   tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DELIVERY,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_shipping",
                            'sort_order' => "3");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TAX,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_tax",
                            'sort_order' => "4");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

      $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_total",
                            'sort_order' => "5");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);


 // Header("Location: ".$PHP_SELF."?serie_bb=ok&action_entradas=ok&action_salidas=ok&admin_id_c=".$admin_id_c."&products_id=".$products_id."&status_entradas_c=".$status_entradas_c."&status_salidas_c=".$status_salidas_c."&unidades=".$unidades."");

    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . (int)$order['products_id'] . "'");
    $codigobarras_c = tep_db_fetch_array($codigobarras_values);


  //Insertar el producto
  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){



 // si el status de la oferta es uno el PVP se convierte en la oferta.
        if ($ofertas['status'] == 1){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}



}
                                echo '<p><b><font size="2" face="Verdana" color="#0000FF">Insertado Nuevo pedido (Mercancias Procesando Entregas) y Producto Correctamente Serie B</font></b></p>';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'insertado el producto';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $insert_id . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");





     }





}        //fin






























             // STATUS PENDIENTE DE ENTRADA


 if (isset($products_details['pendiente_entrada_selec'])){



    $unidades =  $products_details['pendiente_entrada_unidades'];



            //si es admin o tienda
     if ($login_id_remoto <> 0){
      $admin_a_values = tep_db_query("select * from " . 'admin' . " where admin_id = '" . $login_id_remoto . "'");
     $admin_a = tep_db_fetch_array($admin_a_values);

           }else{
      $admin_a_values = tep_db_query("select * from " . 'admin' . " where admin_id = '" . $login_id . "'");
     $admin_a = tep_db_fetch_array($admin_a_values);


     }             //fin



            //direcciones
     $address_books_values = tep_db_query("select * from " . 'address_book' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $address_books = tep_db_fetch_array($address_books_values);
     $customerss_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $customerss = tep_db_fetch_array($customerss_values);
              //fin


       //si el la peticion de entrada no existe se crea una nueva en la tienda correspondiente.
    $salidas_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $login_pendiente_entrada_entienda . "'");
   if ($salidas_c = tep_db_fetch_array($salidas_values)){








                   //
                  //selecciona los productos y los datos de estos
    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . (int)$order['products_id'] . "'");
   if ($codigobarras_c = tep_db_fetch_array($codigobarras_values)){








  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where  orders_id = '" . $salidas_c['orders_id'] . "' and products_id = '" . (int)$order['products_id'] . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){


 //Pone el precio de oferta antes que el precio normal
  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){


 // si el status de la oferta es uno el PVP se convierte en la oferta.
        if ($ofertas['status'] == 1){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}



}  //fin



                                                           //CHIVATOS
                                                echo '<font color="#008000" face="Verdana" size="1"><b>Actualizado Correctamente (Pendiente de Entrada) Serie A</b></font>';

                                                             //FIN
                             //
                              $serie_a = 'ok';
  require('includes/proveedores_precios.php');




                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

                      $sql_status_update_array = array('contencion' =>1,);

               if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;

            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $codigobarras_a['products_id'] . "'");







}else{

           $unidades =  $products_details['pendiente_entrada_unidades'];



  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){

 // si el status de la oferta es uno el PVP se convierte en la oferta.
        if ($ofertas['status'] == 1){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

}




                                echo '<p><b><font size="1" face="Verdana" color="#0000FF">Insertado Correctamente (Pendiente de Entrada) Serie B</font></b></p>';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');




           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $salidas_c['orders_id'] . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");






     }



       }










}else{


      $unidades =  $products_details['pendiente_entrada_unidades'];



$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


   $sql_data_array = array('customers_id' => $address_books['customers_id'],
                          'customers_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'customers_company' => '',
                          'customers_street_address' => $address_books['entry_street_address'],
                          'customers_suburb' => '',
                          'customers_city' => $address_books['entry_city'],
                          'customers_postcode' => $address_books['entry_postcode'],
                          'customers_state' => '',
                          'customers_country' => $address_books['entry_country_id'],
                          'customers_telephone' => $customerss['customers_telephone'],
                          'customers_email_address' => $customerss['customers_email_address'],
                          'customers_address_format_id' => 1,
                          'delivery_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'delivery_company' => '',
                          'delivery_street_address' => $address_books['entry_street_address'],
                          'delivery_suburb' => '',
                          'delivery_city' => $address_books['entry_city'],
                          'delivery_postcode' => $customerss['customers_telephone'],
                          'delivery_state' => '',
                          'delivery_country' => $address_books['entry_country_id'],
                          'delivery_address_format_id' => 1,
                          'billing_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'billing_company' => '',
                          'billing_street_address' => $customerss['customers_email_address'],
                          'billing_suburb' => '',
                          'billing_city' => $address_books['entry_city'],
                          'billing_postcode' => $address_books['entry_postcode'],
                          'billing_state' => '',
                          'billing_country' => $address_books['entry_country_id'],
                          'billing_address_format_id' => 1,
                          'payment_method' => $order->info['payment_method'],
                          'cc_type' => '',
                          'cc_owner' => '',
                          'cc_number' => '',
                          'cc_expires' => '',
                          'date_purchased' => $oldday1,
                          'last_modified' => $oldday1,
                          'orders_status' => $login_pendiente_entrada_entienda,
                          'currency' => 'EUR',
                          'currency_value' => 1);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

    $insert_id = tep_db_insert_id();


      $sql_data_array = array('orders_id' => $insert_id,
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
							'orders_status_id' => $login_pendiente_entrada_entienda, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_SUBTOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_subtotal",
                            'sort_order' => "1");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);


   $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DISCOUNT,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_customer_discount",
                            'sort_order' => "2");
   tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DELIVERY,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_shipping",
                            'sort_order' => "3");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TAX,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_tax",
                            'sort_order' => "4");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

      $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_total",
                            'sort_order' => "5");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

 // Header("Location: ".$PHP_SELF."?serie_bb=ok&action_entradas=ok&action_salidas=ok&admin_id_c=".$admin_id_c."&products_id=".$products_id."&status_entradas_c=".$status_entradas_c."&status_salidas_c=".$status_salidas_c."&unidades=".$unidades."");

    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . (int)$order['products_id'] . "'");
    $codigobarras_c = tep_db_fetch_array($codigobarras_values);


  //Insertar el producto
  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){

 // si el status de la oferta es uno el PVP se convierte en la oferta.
        if ($ofertas['status'] == 1){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

}
                                      echo '<p><b><font size="1" face="Verdana" color="#0000FF">Insertado Correctamente (Pendiente de Entrada) Serie B</font></b></p>';

                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');



           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $insert_id . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");











}        //fin    PENDIENTE DE ENTRADA




   }





















                         // Descuenta los productos del pedido actual PENDIENTE DE ENTRADA
               if ($products_details['pendiente_entrada_unidades']){

                        $entregas_unidades  = $products_details["qty"]-$products_details['pendiente_entrada_unidades'] ;
               }
                
                
                         // Descuenta los productos del pedido actual ENTREGA DE UNIDADES
               if ($products_details['entregada_unidades']){

                        $entregas_unidades  = $products_details["qty"]-$products_details['entregada_unidades'] ;
               }
               
               
               
               
               
                 if ($products_details['entregada_unidades'] or $products_details['pendiente_entrada_unidades']){

             }else{
                   $entregas_unidades =  $products_details["qty"];
                  }
                  
                           //    $login_id        solo con cuenta especifica
                         //      $log_id          solo hay que cambiarse de tienda


         // Situacion donde esta el producto en el almacen
         // cada tienda tiene su propio sistame de codi         /(
    $donde_esta_c_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . (int)$order['products_id'] . "' and login_id = '" . $log_id . "'");
   if  ($donde_esta_c= tep_db_fetch_array($donde_esta_c_values)){



             $sql_status_update_array = array('donde_esta' => $products_details["donde_esta"],
                                              'products_model' => $products_details["model"],);
            tep_db_perform('products_donde_esta', $sql_status_update_array, 'update', " products_id='" . (int)$order['products_id'] . "' and login_id= '" . $log_id . "'");


}else{



           $Query = "INSERT INTO " . 'products_donde_esta' . " set
              products_id = '" . (int)$order['products_id'] . "',
              donde_esta = '" . $products_details["donde_esta"] . "',
              products_model = '" . $products_details["model"] . "',
              login_id = '" . $log_id . "'";
              tep_db_query($Query);





}


       $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
       $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);


       $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $porcentage_tienda['customers_id'] . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);



       $tienda_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $orders_products_id. "'");
       $tienda = tep_db_fetch_array($tienda_values);

              if ($customers_porcentage['customers_porcentage'] <> 0){
                $descuento_insert = $customers_porcentage['customers_porcentage'];
         }
             if  ($porcentage_tienda['porcentage_tienda'] <> 0){
                  $descuento_insert = $porcentage_tienda['porcentage_tienda'];
          }







      if ($products_details['deson_detail']){
   $products_details["final_price"] = $products_details["price"] *$descuento_insert/100+$products_details["price"] ;
                                         }
                  if ($products_details['products_descuento'] <> 0){
  $products_details["final_price"] = $products_details["price"] * $products_details["products_descuento"]/100+$products_details["price"] ;
                                            }
                                      //descuento


    $pdc_precio_final_values = tep_db_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  (int)$order['products_id'] . "' and pdc_unidades <= '" .  $entregas_unidades. "' order by pdc_unidades desc");
    if ($pdc_precio_final = tep_db_fetch_array($pdc_precio_final_values)){


          $products_details["final_price"] = $pdc_precio_final['pdc_price_final'];


                                                     }
                                                           

                                if ($products_details["name"]){

                                    }
                          
				$Query = "UPDATE " . TABLE_ORDERS_PRODUCTS . " set
					products_model = '" . $products_details["model"] . "',
					products_name = '" . $products_details["name"] . "',
					final_price = '" . $products_details["final_price"] . "',
					products_descuento = '" . $products_details["products_descuento"] . "',
					final_price_euro = '" . $total_pago_euro . "',
					cambio_de_productos = '" . $products_details["cambio_de_productos"] . "',
					final_price_tienda = '" . $ganancias_tiendas . "',
					products_tax = '" . $products_details["tax"] . "',
                    products_quantity = '" . $entregas_unidades . "'
					where orders_products_id = '$orders_products_id';";
				tep_db_query($Query);


		// 1.5 SUCCESS MESSAGE #####
  
  
  
  
  
  
  
  

  
  
  
  
  
  
  
  
  
  
  
  

		if ($order_updated)	{
			$messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
		}



            //no funciona
             // el codigo funciona, lo que no funciona es $numero_nuevo_pedido, se supone que viaja pero en el proceso se para.

   // Insertar el producto en otro pedido ya existente.


  if ($products_details['unidades_nuevo_pedido'] <> 0){
 $unidades = $products_details['unidades_nuevo_pedido'];
 $numero_pedido = $products_details['numero_nuevo_pedido'];
}


  $addstock_values = tep_db_query("select * from " . TABLE_ORDERS . "  where orders_status = '" . $entregas_stock . "' order by date_purchased DESC");
   $addstock = tep_db_fetch_array($addstock_values);

  $addpend_values = tep_db_query("select * from " . TABLE_ORDERS . "  where orders_status = '" . $status_entregas . "' order by date_purchased DESC");
   $addpend = tep_db_fetch_array($addpend_values);

              if ($addpend['orders_id'] == $oID) {
             }else{
  if ($products_details['unidades_nuevo_pedido_pend'] <> 0){
 $unidades = $products_details['unidades_nuevo_pedido_pend'];
 $numero_pedido = $products_details['numero_nuevo_pedido_pend'];
}}
              if ($addstock['orders_id'] == $oID) {
             }else{
  if ($products_details['unidades_nuevo_pedido_stock'] <> 0){
 $unidades = $products_details['unidades_nuevo_pedido_stock'];
 $numero_pedido = $products_details['numero_nuevo_pedido_stock'];
}}




    if ($unidades){

  $selec_nuevopedido_values = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op where o.orders_id = op.orders_id and o.orders_id = '" . $numero_pedido . "' and op.products_id = '" . (int)$order['products_id'] . "'");
   if ($selec_nuevopedido = tep_db_fetch_array($selec_nuevopedido_values)){

   // si existe actualiza la nueva cantidad.


           $sql_status_update_array = array('products_quantity' => $selec_nuevopedido["products_quantity"]+$unidades, );
            tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . (int)$order['products_id'] . "' and orders_id = '" . $numero_pedido . "'");





        // Suma order total

// precio total del pedido actual
   $precioactual_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_total' . "'");
   $precioactual_total = tep_db_fetch_array($precioactual_total_values);

// precio total del pedido actual
   $precioactual_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");
   $precioactual_subtotal = tep_db_fetch_array($precioactual_subtotal_values);

// datos del producto
   $producto_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . (int)$order['products_id'] . "'");
   $producto = tep_db_fetch_array($producto_values);

    $importe = $producto['products_price']*$unidades;

                  // ot_total
           $sql_status_update_array = array('value' => $precioactual_total['value']+$importe,
                                            'text' => $precioactual_total['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido. "' and class = '" . 'ot_total' . "'");


                  // ot_subtotal
           $sql_status_update_array = array('value' => $precioactual_subtotal['value']+$importe,
                                            'text' => $precioactual_subtotal['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");



         // fin








    // si no existe lo inserta por primera vez
}else{

    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . (int)$order['products_id'] . "'");
    $codigobarras_c = tep_db_fetch_array($codigobarras_values);

                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');






           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $numero_pedido . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
              
              
              
              
              
              
              
        // Suma order total

// precio total del pedido actual
   $precioactual_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_total' . "'");
   $precioactual_total = tep_db_fetch_array($precioactual_total_values);

// precio total del pedido actual
   $precioactual_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");
   $precioactual_subtotal = tep_db_fetch_array($precioactual_subtotal_values);

// datos del producto
   $producto_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . (int)$order['products_id'] . "'");
   $producto = tep_db_fetch_array($producto_values);

    $importe = $producto['products_price']*$unidades;

                  // ot_total
           $sql_status_update_array = array('value' => $precioactual_total['value']+$importe,
                                            'text' => $precioactual_total['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido . "' and class = '" . 'ot_total' . "'");

           // ot_subtotal
           $sql_status_update_array = array('value' => $precioactual_subtotal['value']+$importe,
                                            'text' => $precioactual_subtotal['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");


         // fin
              
              
              
              
              
              
              
              
              

            }
               }// fin









           
          $sql_status_update_array = array('codigo_barras' => $products_details["codigo_barras"],
                                           'products_status' => $products_details["products_status"],
                                           'proveedor_price' => $products_details["proveedor_price"],   );
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . (int)$order['products_id'] . "'");



       $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);


       $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $porcentage_tienda['customers_id'] . "' and customers_porcentage <> '" . 0 . "'");
    $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);




          if ($customers_porcentage['customers_porcentage']){
              $porcentage_tienda['porcentage_tienda'] = $customers_porcentage['customers_porcentage'];

      }else if ($porcentage_tienda['porcentage_tienda']){


  }

   				//update subtotal and total during update function
				$RunningSubTotal += $products_details["qty"] * $products_details["final_price"]; 
				$RunningTax += (($products_details['tax']/100) * ($products_details['qty'] * $products_details['final_price']));
                    			$Runningprice += ($products_details['qty'] * $products_details['price']) *$porcentage_tienda['porcentage_tienda']/100 ;


				// Update Any Attributes
				if(isset($products_details[attributes]))
				{
					foreach($products_details["attributes"] as $orders_products_attributes_id => $attributes_details)
					{
						$Query = "UPDATE " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " set
							products_options = '" . $attributes_details["option"] . "',
							products_options_values = '" . $attributes_details["value"] . "',
							options_values_price ='" . $attributes_details["price"] . "',
							price_prefix ='" . $attributes_details["prefix"] . "'
							where orders_products_attributes_id = '$orders_products_attributes_id';";
						tep_db_query($Query);
					}//end of foreach($products_details["attributes"]
				}// end of if(isset($products_details[attributes]))
				}// end of if/else (isset($products_details['delete']))
			
		}//end of foreach
		}//end of if (is_array())
		
		// 1.4 UPDATE SHIPPING, CUSTOM FEES, DISOUNTS, TAXES, AND TOTALS #####
		
	/* 1.4.0.1 Shipping Tax
		  Optional Tax Rate/Percent (two methods)
		    If you want to add tax to shipping, activate either method */
			
	//Method 1: calculated based on store configuration
	//If you have more than one tax class, change the '1' in (1, $CountryID, $ZoneID) if necessary    
			//$CountryID = tep_get_country_id($_POST['update_customer_country']);
			//$ZoneID = tep_get_zone_id($CountryID, ($_POST['update_customer_state']));
			//$AddShippingTax = tep_get_tax_rate(1, $CountryID, $ZoneID);
			
	//or
	//Method 2: enter the appropriate tax rate manually
            //comment out the next line if you use Method 1
			$AddShippingTax = "0.00"; // e.g. shipping tax of 17.5% is "17.5"
			
			if (is_array ($_POST['update_totals'])){
			foreach($_POST['update_totals'] as $total_index => $total_details)
			{
				extract($total_details,EXTR_PREFIX_ALL,"ot");
				if(($ot_class == "ot_shipping") && ($RunningTax != 0))
				{
					$RunningTax += (($AddShippingTax / 100) * $ot_value);
				}
			  }
		    }
		
		$RunningTotal = 0;
		$sort_order = 0;
			
			// 1.4.1 Do pre-check for Tax field existence
			$ot_tax_found = 0;
			if (is_array ($_POST['update_totals'])){
			foreach($_POST['update_totals'] as $total_details)	{
				extract($total_details,EXTR_PREFIX_ALL,"ot");
				if($ot_class == "ot_tax")
				{
					$ot_tax_found = 1;
					break;
				}
				
	///////////////////////This section is, for reasons I cannot yet comprehend, necessary for section 1.4.1.1, below, to work properly.  Without it the text value is written to the db as '0'
		if ($ot_class == "ot_total" || $ot_class == "ot_tax" || $ot_class == "ot_subtotal" || $ot_class == "ot_shipping" || $ot_class == "ot_custom" || $ot_class == "ot_loworderfee") {
		$order = new order($oID);
        $RunningTax += 0 * $products_details['tax'] / $order->info['currency_value'] / 100 ; 
		 }
	///////////////////End bizarro code section
			
			}//end foreach
			}//end if (is_array
				
						
			// 1.4.1.1  If ot_tax doesn't exist, but $RunningTax has been calculated, create an appropriate entry in the db and add tax to the total
			if (($RunningTax != 0) && ($ot_tax_found != 1)) {
			$Query = "INSERT INTO " . TABLE_ORDERS_TOTAL . " set
							orders_id = '" . $oID . "',
							title ='" . ENTRY_TAX . "',
							text = '" . $currencies->format($RunningTax, true, $order->info['currency'], $order->info['currency_value']) . "',
				            value = '" . $RunningTax . "',
							class = 'ot_tax',
							sort_order = '2'";
						tep_db_query($Query);
						$ot_tax_found = 1;
						$RunningTotal += $RunningTax;
						}
						
				////////////////////OPTIONAL- create entries for subtotal and/or total if none exists
 			/*
			//1.4.1.2
			/////////////////////////Add in subtotal to db if it doesn't already exist
			if (($RunningSubTotal >0) && ($ot_subtotal_found != true)) {
				$Query = 'INSERT INTO ' . TABLE_ORDERS_TOTAL . ' SET
							orders_id = "' . $oID . '",
							title ="' . ENTRY_SUB_TOTAL . '",
							text = "' . $currencies->format($RunningSubTotal, true, $order->info['currency'], $order->info['currency_value']) . '",
				            value = "' . $RunningSubTotal . '",
							class = "ot_subtotal",
							sort_order = "1"';
						tep_db_query($Query);
						$ot_subtotal_found = true;
						$RunningTotal += $RunningSubTotal;
						}
						
						//1.4.1.3
			/////////////////////////Add in total to db if it doesn't already exist
			if (($RunningTotal >0) && ($ot_total_found != true)) {
				$Query = 'INSERT INTO ' . TABLE_ORDERS_TOTAL . ' SET
							orders_id = "' . $oID . '",
							title ="' . ENTRY_TOTAL . '",
							text = "' . $currencies->format($RunningTotal, true, $order->info['currency'], $order->info['currency_value']) . '",
				            value = "' . $RunningTotal . '",
							class = "ot_total",
							sort_order = "4"';
						tep_db_query($Query);
						$ot_total_found = true;
						}
   			*/
						//////////////////////////end optional section
						
			// 1.4.2. Summing up total
			if (is_array ($_POST['update_totals'])) {
			foreach($_POST['update_totals'] as $total_index => $total_details)	
			
			{
			
		 	 // 1.4.2.1 Prepare Tax Insertion			
			extract($total_details,EXTR_PREFIX_ALL,"ot");
			
			
			
		 // 1.4.2.2 Update ot_subtotal, ot_tax, and ot_total classes aka "The Final Countdown"
				if (trim($ot_title) && trim($ot_value)) 
				
				{
					$sort_order++;
					if ($ot_class == "ot_subtotal") {
						$ot_value = $RunningSubTotal;
					}						
					if ($ot_class == "ot_tax") {
						$ot_value = $RunningTax;
					}

				    // Check for existence of subtotals (CWS)                      
					if ($ot_class == "ot_total") {
					$ot_value = $RunningTotal;
				         		          
				          if ( !$ot_subtotal_found ) 
				          { // There was no subtotal on this order, lets add the running subtotal in.
				               $ot_value +=  $RunningSubTotal;
				          }
				     
				     }
									
					// Set $ot_text (display-formatted value)
                    $order = new order($oID);
					$ot_text = $currencies->format($ot_value, true, $order->info['currency'], $order->info['currency_value']);
						
				//this little ditty writes the total into the database in with <b> and </b>
					if ($ot_class == "ot_total") {
						$ot_text = "<b>" . $ot_text . "</b>";
					}

					if($ot_total_id > 0) { // Already in database --> Update
						$Query = "UPDATE " . TABLE_ORDERS_TOTAL . " set
							title = '" . $ot_title . "',
							text = '" . $ot_text . "',
							value = '" . $ot_value . "',
							value2 = '" . $Runningprice . "',
							sort_order = '" . $sort_order . "'
							WHERE orders_total_id = '". $ot_total_id . "'";
						tep_db_query($Query);
					} else { // New Insert (does this even work?)
						$Query = "INSERT INTO " . TABLE_ORDERS_TOTAL . " SET
							orders_id = '" . $oID . "',
							title = '" . $ot_title . "',
							text = '" . $ot_text . "',
							value = '" . $ot_value . "',
							class = '" . $ot_class . "',
							sort_order = '" . $sort_order . "'";
						tep_db_query($Query);
					}
										
					if ($ot_class == "ot_shipping" || $ot_class == "ot_custom" || $ot_class == "ot_loworderfee") {
						// Again, because products are calculated in terms of default currency, we need to align shipping, custom etc. values with default currency
						$RunningTotal += $ot_value / $order->info['currency_value'];
					}
					else
					{
						$RunningTotal += $ot_value;
					}
			
				}
				
	elseif (($ot_total_id > 0) && ($ot_class != "ot_shipping")) { // value = 0 => Delete Total Piece
				
					$Query = "DELETE from " . TABLE_ORDERS_TOTAL . " 
					WHERE orders_id = '" . (int)$oID . "' 
					AND orders_total_id = '$ot_total_id'";
					tep_db_query($Query);
				}

			}
		
}//end if (is_array())
		
		// 1.5 SUCCESS MESSAGE #####
		
		if ($order_updated)	{
			$messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
		}







          echo 'Procesando 16..'.$products_details["name"];








   ?>

            <script type="text/javascript">

    var pagina = '<?php echo FILENAME_EDIT_ORDERS_TIENDA . '?action=edit&oID=' . $oID; ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


   <?php













       //  Header("Location: http://www.euroconsolas.com/euroconsolas/spain/index.php");
       
       

       
             ?>


          <?php
      //  $rh = $_GET['rh'];

        //   if ($rh=='ok'){


        // }else{

       // Header("Location: '?action=edit&rr=&oID=" . $oID . "");
                                                        // (int)$order['products_id']

          ?>





   <?php
         // }


	//	tep_redirect(tep_href_link('orders_tienda.php', 'action=edit&rr='.(int)$order['products_id'].'&oID=' . $oID));
		
 break;

	// 2. ADD A PRODUCT ###############################################################################################
	case 'add_product':

		if($_POST['step'] == 5)
		{
			// 2.1 GET ORDER INFO #####
			
			$oID = tep_db_prepare_input($_GET['oID']);
			$order = new order($oID);

			$AddedOptionsPrice = 0;

			// 2.1.1 Get Product Attribute Info
			if(is_array ($_POST['add_product_options']))
			{
				foreach($_POST['add_product_options'] as $option_id => $option_value_id)
				{
					$result = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " 
					pa LEFT JOIN " . TABLE_PRODUCTS_OPTIONS . " po 
					ON po.products_options_id=pa.options_id 
					LEFT JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov 
					ON pov.products_options_values_id=pa.options_values_id 
					WHERE products_id=" . $_POST['add_product_products_id'] . " 
					and options_id=" . $option_id . " 
					and options_values_id=" . $option_value_id . " 
					and po.language_id = '" . (int)$languages_id . "' 
					and pov.language_id = '" . (int)$languages_id . "'");
					
					$row = tep_db_fetch_array($result);
					extract($row, EXTR_PREFIX_ALL, "opt");
					$AddedOptionsPrice += $opt_options_values_price;
					$option_value_details[$option_id][$option_value_id] = array ("options_values_price" => $opt_options_values_price);
					$option_names[$option_id] = $opt_products_options_name;
					$option_values_names[$option_value_id] = $opt_products_options_values_name;
				}
			}

			// 2.1.2 Get Product Info
			$InfoQuery = "select 
			              p.products_model,
						  p.products_price,
						  pd.products_name,
						  p.products_tax_class_id 
						  from " . TABLE_PRODUCTS . " 
						  p left 
						  join " . TABLE_PRODUCTS_DESCRIPTION . " 
						  pd on pd.products_id=p.products_id 
						  where p.products_id=" . $_POST['add_product_products_id'] . " 
						  and pd.language_id = '" . (int)$languages_id . "'";
			$result = tep_db_query($InfoQuery);

			$row = tep_db_fetch_array($result);
			extract($row, EXTR_PREFIX_ALL, "p");
			
			// 2.1.3  Pull specials price from db if there is an active offer
			$special_price = tep_db_query("select specials_new_products_price 
			from " . TABLE_SPECIALS . " 
			where products_id =". $_POST['add_product_products_id'] . " 
			and status");
			$new_price = tep_db_fetch_array($special_price);
			
			if ($new_price) 
			{
			$p_products_price = $new_price['specials_new_products_price'];
			}
			
			// Following two functions are defined at the top of this file
			$CountryID = tep_get_country_id($order->delivery["country"]);
			$ZoneID = tep_get_zone_id($CountryID, $order->delivery["state"]);
			$ProductsTax = tep_get_tax_rate($p_products_tax_class_id, $CountryID, $ZoneID);
			
			// 2.2 UPDATE ORDER ####
   

                                   echo 'Procesando .13....';

                                   $serie_d = 'ok';
   require(DIR_WS_INCLUDES . 'proveedores_precios.php');


            $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $oID . "',
              products_id = '" . $_POST['add_product_products_id'] . "',
              products_model = '" . $p_products_model . "',
              products_name = '" . tep_html_quotes($p_products_name) . "',
              products_price = '". $p_products_price . "',
              final_price = '" . ($p_products_price + $AddedOptionsPrice) . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $_POST['add_product_quantity'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
			
			// 2.2.1 Update inventory Quantity
			//This is only done if store is set up to use stock
			if (STOCK_CHECK == 'true'){
			tep_db_query("UPDATE " . TABLE_PRODUCTS . " set
			products_quantity = products_quantity - " . $_POST['add_product_quantity'] . " 
			where products_id = '" . $_POST['add_product_products_id'] . "'");
			}
			
			//2.2.1.1 Update products_ordered info
			tep_db_query ("UPDATE " . TABLE_PRODUCTS . " set
			products_ordered = products_ordered + " . $_POST['add_product_quantity'] . "
			where products_id = '" . $_POST['add_product_products_id'] . "'");

			//2.2.1.2 keep a record of the products attributes
			if (is_array ($_POST['add_product_options'])) {
				foreach($_POST['add_product_options'] as $option_id => $option_value_id) {
				$Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " set
						orders_id = '" . $oID . "',
						orders_products_id = '" . $new_product_id . "',
						products_options = '" . $option_names[$option_id] . "',
						products_options_values = '" . tep_db_input($option_values_names[$option_value_id]) . "',
						options_values_price = '" . $option_value_details[$option_id][$option_value_id]['options_values_price'] . "',
						price_prefix = '+'";
					tep_db_query($Query);
				}
			}
			
			// 2.2.2 Calculate Tax and Sub-Totals
			$order = new order($oID);
			$RunningSubTotal = 0;
			$RunningTax = 0;

			for ($i=0; $i<sizeof($order->products); $i++) {


// This calculatiion of Subtotal and Tax is part of the 'add a product' process
		$RunningSubTotal += ($order->products[$i]['qty'] * $order->products[$i]['final_price']);
		$RunningTax += (($order->products[$i]['tax'] / 100) * ($order->products[$i]['qty'] * $order->products[$i]['final_price']));
			}

			// 2.2.2.1 Tax
			$Query = 'UPDATE ' . TABLE_ORDERS_TOTAL . ' set
				text = "' . $currencies->format($RunningTax, true, $order->info['currency'], $order->info['currency_value']) . '",
				value = "' . $RunningTax . '"
				WHERE class= "ot_tax" AND orders_id= "' . $oID . '"';
			tep_db_query($Query);

			// 2.2.2.2 Sub-Total
			$Query = 'UPDATE ' . TABLE_ORDERS_TOTAL . ' set
				text = "' . $currencies->format($RunningSubTotal, true, $order->info['currency'], $order->info['currency_value']) . '",
				value = "' . $RunningSubTotal . '"
				WHERE class="ot_subtotal" AND orders_id= "' . $oID . '"';
			tep_db_query($Query);

			// 2.2.2.3 Total
			$Query = 'SELECT sum(value) AS total_value from ' . TABLE_ORDERS_TOTAL . '
			WHERE class != "ot_total" AND orders_id= "' . $oID . '"';
			$result = tep_db_query($Query);
			$row = tep_db_fetch_array($result);
			$Total = $row['total_value'];

			$Query = 'UPDATE ' . TABLE_ORDERS_TOTAL . ' set
				text = "' . $currencies->format($Total, true, $order->info['currency'], $order->info['currency_value']) . '",
				value = "' . $Total . '"
				WHERE class="ot_total" and orders_id= "' . $oID . '"';
			tep_db_query($Query);

			// 2.3 REDIRECTION #####
   

          $ro = $_GET['ro'];

           if ($ro=='ok'){


         }else{

   ?>

            <script type="text/javascript">

    var pagina = '<?php echo FILENAME_EDIT_ORDERS_TIENDA . '?action=edit&ro=ok&oID=' . $oID; ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


   <?php
      }
        // Header("Location: http://www.euroconsolas.com/euroconsolas/spain/index.php");
		//	tep_redirect(tep_href_link(FILENAME_EDIT_ORDERS_TIENDA,  'action=edit&oID=' . $oID));

		}
	
	  break;
		
  }
}

  if (($action == 'edit') && isset($_GET['oID'])) {
    $oID = tep_db_prepare_input($_GET['oID']);

    $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
    $order_exists = true;
    if (!tep_db_num_rows($orders_query)) {
      $order_exists = false;
      $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
  }
















    // EL FALLO ME APARECE DESDE AQUI

// Insertar Producto o Actualiza de los insertados desde el formulario de la pagina


  if ($action_cod='ok'){

  if ($codigobarras){

}else{
  $codigobarras = 'noaynada';
}


  if ($productoid){

}else{
  $productoid = 'noaynada';
}
          //POSIBLE LOCALIZACION AQUI
          


  if ($productoid <> 'noaynada'){


   $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.products_id = '" . $productoid . "'");



}else{



   $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . $codigobarrasID . "' or p.products_id = pd.products_id and p.codigo_barras = '" . $codigobarras . "'
                                                                                                                                                                                                         or  p.products_id = pd.products_id and p.products_model = '" . $codigobarras . "'
                                                                                                                                                                                                         or  p.products_id = pd.products_id and p.products_model_2 = '" . $codigobarras . "'
                                                                                                                                                                                                         or  p.products_id = pd.products_id and p.products_model_3 = '" . $codigobarras . "'");




}
  
  
  
  
  
 //POSIBLE LOCALIZACION HASTA AQUI
   if ($codigobarras_c = tep_db_fetch_array($codigobarras_values)){



  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op where o.orders_id = '" . $oID . "' and op.orders_id= '" . $oID . "'  and op.products_id= '" . $codigobarras_c['products_id'] . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){







  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){


 // si el status de la oferta es uno el PVP se convierte en la oferta.
        if ($ofertas['status'] == 1){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}



}



                                                $conf_actualizar = 'ok';



                              $serie_a = 'ok';
  require('includes/proveedores_precios.php');






                           $entregas_unidades  =  $unidades + $codigobarras_a['products_quantity'];
                           
    $pdc_precio_final_values = tep_db_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $codigobarras_a['products_id'] . "' and pdc_unidades <= '" .  $entregas_unidades. "' order by pdc_unidades desc");
    if ($pdc_precio_final = tep_db_fetch_array($pdc_precio_final_values)){


          $products_precio = $pdc_precio_final['pdc_price_final'];
          
          
                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price' => $products_precio,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );


                                                           }else{

                                                            //descuento
                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );
                                                         }
                                                         
                                                         
             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

                      $sql_status_update_array = array('contencion' =>1,);

               if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;

            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $codigobarras_a['products_id'] . "'");







}else{


                                $conf_insertar = 'ok';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');




               // SELECCIONA EL PRECIO DEPENDIENDO DE LOS PERMISOS.
 $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id= '" . $oID . "'");
 $codigobarras_a = tep_db_fetch_array($codigobarras_a_values);



 $PVP_PVM_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $codigobarras_a['customers_id'] . "'");
 $PVP_PVM = tep_db_fetch_array($PVP_PVM_values);


    if ($PVP_PVM['customers_group_id'] >= 1){

    $pr_grupos_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $codigobarras_c['products_id'] . "' and customers_group_id = '" . $PVP_PVM['customers_group_id'] . "'");
$pr_grupos = tep_db_fetch_array($pr_grupos_values);

     $codigobarras_c['products_price'] = $pr_grupos['customers_group_price'];

}

//FIN
       $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);


       $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $porcentage_tienda['customers_id'] . "' and customers_porcentage <> '" . 0 . "'");
  $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);

              if ($customers_porcentage['customers_porcentage'] <> 0){
                $descuento_insert = $customers_porcentage['customers_porcentage'];
         }
             if  ($porcentage_tienda['porcentage_tienda'] <> 0){
                  $descuento_insert = $porcentage_tienda['porcentage_tienda'];
          }
                                    if ($customers_porcentage['customers_porcentage'] <> 0 or $porcentage_tienda['porcentage_tienda'] <> 0 ){
                            // al insertar nuevo aplica el descuento de la ficha del producto, solo si esta configurado previamente.
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $codigobarras_c['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $descuento_insert = $products_porcentage['products_descuento'];
                }
                  }

                                     //descuento



                $producto_precio =  $codigobarras_c['products_price'];
                $producto_precio_final =  $codigobarras_c['products_price']*$descuento_insert/100+$codigobarras_c['products_price'];



  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){

 // si el status de la oferta es uno el PVP se convierte en la oferta.
        if ($ofertas['status'] == 1){
      $producto_precio_final = $ofertas['specials_new_products_price'];
}


}



    $pdc_precio_final_values = tep_db_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $codigobarras_c['products_id'] . "' and pdc_unidades <= '" .  $unidades. "' order by pdc_unidades desc");
    if ($pdc_precio_final = tep_db_fetch_array($pdc_precio_final_values)){


              $producto_precio_final = $pdc_precio_final['pdc_price_final'];

                                    // enviar solicitud para comprobar si existe el codigo de barras en otras tiendas.






                                                                  }
                                     // enviar solicitud para comprobar si existe el codigo de barras en otras tiendas.
                             // inserta desde el formulario principal.

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $oID . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $producto_precio . "',
              final_price = '" . $producto_precio_final . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");





       }










  			// 2.2.2 Calculate Tax and Sub-Totals
			$order = new order($oID);
			$RunningSubTotal = 0;
			$RunningTax = 0;
                                   //descuento
			for ($i=0; $i<sizeof($order->products); $i++) {



// This calculatiion of Subtotal and Tax is part of the 'add a product' process
		$RunningSubTotal += ($order->products[$i]['qty'] * $order->products[$i]['final_price']);
		$RunningTax += (($order->products[$i]['tax'] / 100) * ($order->products[$i]['qty'] * $order->products[$i]['final_price']));

      $Total_price  += ($order->products[$i]['qty'] *$order->products[$i]['price']);

                 }

			// 2.2.2.1 Tax
			$Query = 'UPDATE ' . TABLE_ORDERS_TOTAL . ' set
				text = "' . $currencies->format($RunningTax, true, $order->info['currency'], $order->info['currency_value']) . '",
				value = "' . $RunningTax . '"
				WHERE class= "ot_tax" AND orders_id= "' . $oID . '"';
			tep_db_query($Query);

			// 2.2.2.2 Sub-Total
			$Query = 'UPDATE ' . TABLE_ORDERS_TOTAL . ' set
				text = "' . $currencies->format($RunningSubTotal, true, $order->info['currency'], $order->info['currency_value']) . '",
				value = "' . $RunningSubTotal . '"
				WHERE class="ot_subtotal" AND orders_id= "' . $oID . '"';
			tep_db_query($Query);

			// 2.2.2.3 Total
			$Query = 'SELECT sum(value) AS total_value from ' . TABLE_ORDERS_TOTAL . '
			WHERE class != "ot_total" AND orders_id= "' . $oID . '"';
			$result = tep_db_query($Query);
			$row = tep_db_fetch_array($result);
			$Total = $row['total_value'];

       $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);


       $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $codigobarras_a['customers_id'] . "' and customers_porcentage <> '" . 0 . "'");
  if  ($customers_porcentage = tep_db_fetch_array($customers_porcentage_values)){


              $porcentage_tienda['porcentage_tienda'] =   $customers_porcentage['customers_porcentage'];


}

                $Total_descuento =  $Total_price*$porcentage_tienda['porcentage_tienda']/100;



			$Query = 'UPDATE ' . TABLE_ORDERS_TOTAL . ' set
				text = "' . $currencies->format($Total, true, $order->info['currency'], $order->info['currency_value']) . '",
				value = "' . $Total . '",
				value2 = "' . $Total_descuento . '"
				WHERE class="ot_total" and orders_id= "' . $oID . '"';
			tep_db_query($Query);








































       if ($pcla){

       $pclaw = 'pcla=ok&';


   }




    ?>

              <script type="text/javascript">

    var pagina = '<?php echo FILENAME_EDIT_ORDERS_TIENDA . '?'.$pclaw.'action=edit&oID=' . $oID . '&conf_actualizar=' . $conf_actualizar . '&conf_insertar=' . $conf_insertar; ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


   <?php

   // tep_redirect(tep_href_link(FILENAME_EDIT_ORDERS_TIENDA,  'action=edit&oID=' . $oID . '&conf_actualizar=' . $conf_actualizar . '&conf_insertar=' . $conf_insertar));


             }else{
             // echo 'INCORRECTO';
         }



}
   // EL FALLO ME APARECE AQUI FINAL

 ?>








    <script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/jquery.flot.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>

   <?php //patrocine.es ?>
  <script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=450,height=600,screenX=150,screenY=150,top=150,left=150')
}
//--></script>



   

        
<?php




if (($action == 'edit') && ($order_exists == true)) {
  $order = new order($oID);
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">
            
 <?php
 
    $proveedorid_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "' and orders_status = '" . $abono . "'");
   if ($proveedorid = tep_db_fetch_array($proveedorid_values)){

   $proveedor_nombre_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $proveedorid['proveedor_id'] . "'");
   $proveedor_nombre = tep_db_fetch_array($proveedor_nombre_values);

 
 if  ($login_groups_id <> 1){





  ?>
  
  
  
  
   <p>Proveedor: <?php echo $proveedor_nombre['proveedor_name'] ?>  </p>
  <p>
  
   <?php
}

    if ($login_groups_id == 1){
 
  if ($select_proveedor){


             
               $sql_status_update_array = array('proveedor_id' => $select_proveedor,);
            tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', " orders_id= '" . $oID . "' and orders_status= '" . $abono . "'");



}

    ?>
<form name="form1" method="post" action="">
  <p>Proveedor: <?php echo $proveedor_nombre['proveedor_name'] ?>  </p>
  <p>
    <input name="select_proveedor" type="text" value="<?php echo $proveedorid['proveedor_id'] ?>" size="5">
   <input type="submit" name="Submit" value="Proveedor">
    </p>
</form>




          <?php  }} ?>

               <td class="pageHeading" align="left"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?>
               
               
                   <?php   $escbot = $_GET['escbot'];

                     if ($escbot == 'ok'){



                 }else{


                      ?>
               


                                                              <td class="pageHeading" align="left">
            <a target="_blank" href="invoice_factura_ind_tiket.php<?php ECHO  '?oID=' . $_GET['oID']; ?>"><img src="images/tpv_tiketimprimir_1.jpg" onmouseover="this.src='images/tpv_tiketimprimir_2.jpg';" onmouseout="this.src='images/tpv_tiketimprimir_1.jpg';"/>
            <a target="_blank" href="invoice_factura_ind.php<?php ECHO  '?oID=' . $_GET['oID']; ?>"><img src="images/tpv_facturaimprimir_1.jpg" onmouseover="this.src='images/tpv_facturaimprimir_2.jpg';" onmouseout="this.src='images/tpv_facturaimprimir_1.jpg';"/>
             <a target="_blank" href="invoice_factura_alb.php<?php ECHO  '?oID=' . $_GET['oID']; ?>"><img src="images/tpv_albaranimprimir_1.jpg" onmouseover="this.src='images/tpv_albaranimprimir_2.jpg';" onmouseout="this.src='images/tpv_albaranimprimir_1.jpg';"/>


                             <?php


             }



                                  ?>
                                           </td>


                                                              
                                                              
                                                              
          </tr>
		<tr>
          
          

          
          
        <?php  // comienzo 1
        
        
  $estatuspmw_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
  $estatuspmw = tep_db_fetch_array($estatuspmw_values);


 $estatus_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "' and orders_status = '" . $abono . "'");
 $estatus = tep_db_fetch_array($estatus_values);

 $new_product_configuration_values = tep_db_query("select * from " . TABLE_CONFIGURATION . " where configuration_key = '" . 'NEW_PRODUCT' . "'");
 $new_product_configuration = tep_db_fetch_array($new_product_configuration_values);


 // SOLO STATUS SELECCIONADOS SE EJECUTARÁ ESTA PARTE DEL CODIGO
 


//if (ACTIVACION_AEPR == 'false'){

 if ($estatuspmw['orders_status'] == $abono and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $pagado and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $entregas_stock and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $retirarado and ACTIVACION_AEPR == 'false'){

// }
  
  

}else{

         ?>
         
         
         
         
         
         
         
         
         
         



         
         
         
         
         
<BODY topMargin=3 onload=sf()>
    <?php

       $conf_actualizar = $_GET['conf_actualizar'];
       $conf_insertar = $_GET['conf_insertar'];
       $codigobarras_negativos = $_GET['codigobarras_negativos'];
       $unidades_negativos = $_GET['unidades_negativos'];
       
         // $codigobarras_negativos_pro = ereg_replace("^" . CODIGODEBARRAS , "", $codigobarras_negativos); // $cadena = hispano-america
       
     if ($conf_actualizar){

    echo  '<p><font color="#FFFFFF" face="Verdana" size="2"><span style="background-color: #0000FF"><b>Actualizado</b></span></font></p>';



}else if ($conf_insertar){
 echo '<p><span style="background-color: #00FF00"><b><font face="Verdana" size="2">Insertado</font></b></span></p>';

}

         ?>
         
                             <?php

                                 //   echo  $entregas_stock.'/'. $order->info['orders_status'];
                             if ($entregas_stock == $order->info['orders_status'] or $order->info['orders_status'] == '75' ){   ?>
      <p align="center"><font size="5" face="Arial Black" color="#008000">HOJA DE ENTREGA</font></p>
                                                       <?php } ?>
                             <?php // ECHO   $status_entregas .'-'. $order->info['orders_status'];
                             if ($status_entregas == $order->info['orders_status'] or $order->info['orders_status'] == '77' ){
                               ?>
      <p align="center"><font size="5" face="Arial Black" color="#00FF00">PENDIENTES DE ENTREGA</font></p>
                                                       <?php } ?>
                             <?php   //echo $retirarado .'-'. $order->info['orders_status'];
                             if ($retirarado == $order->info['orders_status'] or $order->info['orders_status'] == '78' ){
                               ?>
      <p align="center"><font size="5" face="Arial Black" color="#FF0000">HOJA DE RETIRADA</font></p>
                                                       <?php } ?>

                             <?php //  echo $status_salidas .'-'. $order->info['orders_status'];
                             if ($status_salidas == $order->info['orders_status'] or $order->info['orders_status'] == '76' ){
                               ?>
      <p align="center"><font size="5" face="Arial Black" color="#FF9999">HOJA DE RETIRADA PROCESANDO</font></p>
                                                       <?php } ?>







            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>






 <form name="f"  method="post" action="<?php echo $PHP_SELF.'?oID='.$oID.'&action=edit&action_cod=o&escbot=ok'; ?>">
  <p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">Codigo Barras / Referencia /

       <?php   if ($login_groups_id == 1){ ?>
       
         Precio C.
       
       <?php
         }
         ?>
       Unid</font></b></p>
       
  <?php
       
       



                              //NUEVO PRODUCTO
         if ($new_product == 1){

	tep_db_query ("UPDATE " . TABLE_CONFIGURATION . " SET
					configuration_value = '" . 1 . "'
					WHERE configuration_key = '" . 'NEW_PRODUCT' . "' ");
     



     

                        }else if ($new_product == 2){
	tep_db_query ("UPDATE " . TABLE_CONFIGURATION . " SET
					configuration_value = '" . 2 . "'
					WHERE configuration_key = '" . 'NEW_PRODUCT' . "' ");

                    }
                    
                              //NUEVO PRODUCTO
         if ($sel_iten_1 == 1){

	tep_db_query ("UPDATE " . TABLE_CONFIGURATION . " SET
					configuration_value = '" . 1 . "'
					WHERE configuration_key = '" . 'SEL_ITEN_1' . "'");






                        }else if ($sel_iten_1 == 2){
	tep_db_query ("UPDATE " . TABLE_CONFIGURATION . " SET
					configuration_value = '" . 2 . "'
					WHERE configuration_key = '" . 'SEL_ITEN_1' . "' ");

                    }
                    
                    
                    
                    

 $new_product_configuration_values = tep_db_query("select * from " . TABLE_CONFIGURATION . " where configuration_key = '" . 'NEW_PRODUCT' . "'");
 $new_product_configuration = tep_db_fetch_array($new_product_configuration_values);

 $selitem_values = tep_db_query("select * from " . TABLE_CONFIGURATION . " where configuration_key = '" . 'SEL_ITEN_1' . "'");
 $selitem = tep_db_fetch_array($selitem_values);

if ($new_product_configuration['configuration_value'] == 1 ){

$checked_1 = 'checked';
}
if ($new_product_configuration['configuration_value'] == 2 ){

$checked_0 = 'checked';
}

if ($selitem['configuration_value'] == 1 ){

$selitem_1 = 'checked';
}
if ($selitem['configuration_value'] == 2 ){

$selitem_0 = 'checked';
}



                   if (AYUDA_ADMIN == 'true'){
                 $ayuda_buscar_facturacion_regular= '<a class="hastip"  title="' . AYUDA_TEXT_FACTURACION_REGULAR . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
                 $ayuda_buscar_facturacion_nuevo_producto = '<a class="hastip"  title="' . AYUDA_TEXT_FACTURACION_NUEVO_PRODUCTO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
                 $ayuda_codigo_barras = '<a class="hastip"  title="' . AYUDA_TEXT_CODIGO_BARRAS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
                 $ayuda_buscar_inactive = '<a class="hastip"  title="' . AYUDA_TEXT_BUSCAR_INACTIVE . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
                 $ayuda_buscar_producto = '<a class="hastip"  title="' . AYUDA_TEXT_BUSCAR_PRODUCTO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
                 $ayuda_udidades = '<a class="hastip"  title="' . AYUDA_TEXT_UNIDADES . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';


                   }





             echo     $ayuda_buscar_facturacion_nuevo_producto;





                   ?>

<input type="radio" value="1" <?php echo $checked_1; ?> name="new_product">   <?php  echo     $ayuda_buscar_facturacion_regular; ?><input type="radio" value="2" <?php echo $checked_0; ?> name="new_product">


 | <input type="radio" value="1" <?php echo $selitem_1; ?> name="sel_iten_1">   <?php  echo     $ayuda_selitem; ?><input type="radio" value="2" <?php echo $selitem_0; ?> name="sel_iten_1">

  | <?php
         echo $sel_iten_max . ' <a href="'. 'edit_orders_tienda.php?oID='.$oID.'&action=edit&action_cod=o&escbot=ok&level_iten=2'. '"> Max 10 </a> <a href="'. 'edit_orders_tienda.php?oID='.$oID.'&action=edit&action_cod=o&escbot=ok&level_iten=1'. '"> Todos</a>';

     ?>
       

  <p style="margin-top: 0; margin-bottom: 0">


            <?php     echo     $ayuda_codigo_barras;


             if (SEL_ITEN_1 == 1){
           ?>

  <input name="unidades" value="<?php echo $unidades_negativos; ?>"type="text" size="3" style="font-size: 37pt"></b></font>


  <?php
   }
    ?>







    <font size="1" face="Verdana"><b>
    <input  name="codigobarras" value ="<?php echo $codigobarras_negativos.$codigobarras_in; ?>" type="text"  size="18" style="font-size: 37pt">

   <?php   if ($login_groups_id == 1){
    //<input name="proveedorprice" type="text" value="" size="6">
                ?> <?php
                   }
                   
                 if ($unidades_negativos){

             }else{

                 $unidades_negativos = 1;
         }


      // seleccionado busca todos los productos que esten activados o desactivados.
            echo     $ayuda_udidades;


             if (SEL_ITEN_1 == 2){
           ?>

  <input name="unidades" value="<?php echo $unidades_negativos; ?>"type="text" size="3" style="font-size: 37pt"></b></font>
  
  
  <?php
   }
    ?>
  </p>
  <p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
  Búsquedas</font></b></p>
  <p style="margin-top: 0; margin-bottom: 0">
    <font size="1" face="Verdana"><b>
    
    <?php
      // seleccionado busca todos los productos que esten activados o desactivados.
            echo     $ayuda_buscar_inactive;
       ?>
<input type="checkbox" name="stock_disponible" value="ON">
    
    <input name="palabraclave" type="text" value="" size="18" style="font-family: Verdana; font-size: 37pt; color: #000080; border-style: outset; border-width: 3; background-color: #FFFF00">
     <input type="hidden" name="add_product">


    <?php
      // seleccionado busca todos los productos que esten activados o desactivados.
            echo     $ayuda_buscar_producto;
       ?>

                <input type="submit" name="Submit" value="Buscar" style="color: #FFFFFF; font-family: ve; font-size: 40pt; background-color: #008080">
    </b></font>

</form>




















<?php





}//fin 1
     $stock_disponible = $_POST['stock_disponible'];

       if ($stock_disponible){
      // todos los productos que esten o no esten disponible

   }else{
    // solo los productos que esten disponibles.
   $stock_status = 'p.products_status = 1 and';

}





       if ($palabraclave){

             }else{
        $palabraclave = 'nohaynada';

         }

 //pv.proveedor_name  like '%" . $palabraclave . "%'        " . 'proveedor' . " pv,
 //  or
         
   $orders_query_raw = "select * from  " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where
    " . $stock_status . " pd.products_name like '%" . $palabraclave . "%'
   or p.products_model like '%" . $palabraclave . "%'
   or p.products_model_2 like '%" . $palabraclave . "%'
   or p.products_model_3 like '%" . $palabraclave . "%'
   or p.codigo_barras like '%" . $palabraclave . "%' group by p.products_id ";
   
 $orders_query = tep_db_query($orders_query_raw);
 
 
 
 
    while ($orders = tep_db_fetch_array($orders_query)) {


 if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}




    $proveedor_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $orders['codigo_proveedor'] . "'");
    $proveedor = tep_db_fetch_array($proveedor_values);

    $donde_esta_a_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $orders['products_id'] . "' and login_id = '" . $log_id . "'");
    $donde_esta_a = tep_db_fetch_array($donde_esta_a_values);


  $ofertas_values = tep_db_query("select * from " . 'specials' . " where products_id = '" . $orders['products_id'] . "'");
 if  ($ofertas = tep_db_fetch_array($ofertas_values)){


      $orders['products_price'] = $ofertas['specials_new_products_price'];
}
 $preciomayor_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $orders['products_id'] . "' and customers_group_id = '" . 1 . "'");
 $preciomayor = tep_db_fetch_array($preciomayor_values);

 $products_stock_values = tep_db_query("select * from " . 'products_stock' . " where products_id = '" . $orders['products_id'] . "'");
 $products_stock = tep_db_fetch_array($products_stock_values);




                            // IMAGENES DE PRODUCTO
                         $products_imagen = $orders['products_image'];
                         $codigo_proveedor = $orders['codigo_proveedor'];
if (@getimagesize(HTTPS_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES . $products_imagen)) {
                                          }else{
        $image_product = DIR_WS_CATALOG_IMAGES . 'imnd.svg';
}

                               //IMAGENES PRODUCTOS
  $codigo_proveedor_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $codigo_proveedor . "'");
  $codigo_proveedor= tep_db_fetch_array($codigo_proveedor_values);


 if (file($codigo_proveedor['proveedor_ruta_images'] . $products_imagen)) {
 $image_product = $codigo_proveedor['proveedor_ruta_images'] . $products_imagen;
}
                                          //  echo  $order->products[$i]['codigo_proveedor'];
if (@getimagesize(HTTPS_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES . $products_imagen)) {
        $image_product = DIR_WS_CATALOG_IMAGES . $products_imagen;
}
  ?>
  

  
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
   <td width="5%"><font size="1" face="Verdana"><p></a><img src="<?php echo $image_product ?>" width="35" ></p></font></td>

   <td width="20%"><font size="1" face="Verdana"><p> <form method="POST" action="<?php echo $PHP_SELF . '?pcla=ok&action=edit&action_cod=ok&oID='.$oID.'&productoid='.$orders['products_id']; ?>">
	<input type="text" name="unidades" size="3" value="1" style="font-family: Verdana; font-size: 8pt; background-color: #FFCC00"><input type="submit" value="Añadir" name="B1" style="font-size: 8pt; font-family: Verdana; color: #FFFFFF; font-weight: bold; background-color: #000080"></p>

   <td width="20%"><font size="1" face="Verdana"><?php echo $products_stock['products_stock_real'] . ' / ' . $products_stock['products_stock_pendiente'] . ' | ' . $products_stock['products_stock_min']  . ' / ' . $orders['products_stock_obs'] ?></font></td>



<?php

                  // stock exterior
                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



                $stock_exteriors = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_admin.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $orders['products_model'] .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
  ?>
  <td width="1%"><font size="1" face="Verdana"><?php echo $stock_exteriors ?></font></td>

  <?php
 

    }

 ?>
   <td width="1%"><font size="1" face="Verdana"><?php //echo $orders['time_entradasysalidas'] . ' / ' . $orders['time_mercancia_entregado_procesando'] . ' | ' . $orders['products_stock_min']  . ' / ' . $orders['products_stock_obs'] ?></font></td>




</form> </a></p></font></td>

        <td width="5%"><font size="1" face="Verdana"><p><?php echo $donde_esta_a['donde_esta'] ?></a></p></font></td>
     <td width="5%"><font size="1" face="Verdana"><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $orders['products_id']) . '&value_2=' . 'A' . $affiliate_id . '\')">'; ?>Stock</a></font></td>
     <td width="20%"><font size="1" face="Verdana"><?php echo $orders['products_name'] ?></font></td>
    <td width="9%"><font size="1" face="Verdana"><?php echo $orders['products_model'] ?></font></td>
      <td width="20%"><font size="1" face="Verdana"><?php echo $orders['products_status'] ?></font></td>
   <td width="3%"><font size="1" face="Verdana"><?php echo $currencies->format($orders['products_price'], true, $order->info['currency'], $order->info['currency_value']) ?></font></td>
     <td width="3%"><font size="1" face="Verdana"><?php echo $currencies->format($preciomayor['customers_group_price'], true, $order->info['currency'], $order->info['currency_value']) ?></font></td>
    <td width="15%"><font size="1" face="Verdana"><?php ECHO $proveedor['proveedor_name']; ?></font></td>
  </tr>           </table></td>
   <?php
}










 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

  
  
  
  
  
  

                       // $precioactual_total['value']
  
         $precioactual_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $oID . "' and class = '" . 'ot_total' . "'");
   $precioactual_total = tep_db_fetch_array($precioactual_total_values);
   
      $orders_cambio_db_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
 $orders_cambio_db = tep_db_fetch_array($orders_cambio_db_values);


//}
                     $cambio_monetario_b = $_GET['cambio_monetario'];
                     
                     
                                      if ($cambio_monetario_b == 'tarjeta'){
                     
                                            $sql_status_update_array = array('orders_medas' => $cambio_monetario_b, );

             tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', " orders_id= '" . $oID . "'");
             
             
                          ?>
             
                      <script type="text/javascript">

    var pagina = '<?php echo $PHP_SELF . '?page=1&oID=' . $oID; ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

              <?php
             
             

                                                     }
                     
                
       if ($orders_cambio_db['orders_medas'] == 'tarjeta'){





                           if  ($cambio_monetario_b == 'tarjeta'){

                      $sql_status_update_array = array('orders_medas' => '', );

             tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', " orders_id= '" . $oID . "'");


            //  echo number_format($cambio_monetario-$precioactual_total['value'], 2, ",", ".") . ' Eur.';

                                  }


      ECHO  '<p><font face="Arial Rounded MT Bold">PAGADO CON TARJETA DE CREDITO
<a href="' . $PHP_SELF . '?page=1&cambio_monetario=tarjeta&oID=' . $oID  . '">Eliminar</a></font></p>';






     //  echo $cambio_monetario.'ppp';;


  }else{
    ?>
  
  
                        <?php
                            if ($escbot == 'ok'){
                        }else{
                           ?>
  
  


               <form method="POST" action="<?php $PHP_SELF . '?page=1&oID=' . $oID ?>">
	<!--webbot bot="SaveResults" U-File="fpweb:///_private/form_results.csv" S-Format="TEXT/CSV" S-Label-Fields="TRUE" -->
	<p>Me Das <input type="text" name="cambio_monetario" value="<?php echo $cambio_monetario; ?>" size="5" style="font-size: 18pt"> Te
	Devuelvo <font size="6"> <b><font size="6" color="#FF0000"><?php

      if ($cambio_monetario){


                      $sql_status_update_array = array('orders_cambio_dev' => $cambio_monetario-$precioactual_total['value'],
                                                       'orders_medas' => $cambio_monetario, );

             tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', " orders_id= '" . $oID . "'");


              echo number_format($cambio_monetario-$precioactual_total['value'], 2, ",", ".") . ' Eur.';
  }



    ?> </font></b> </font>
	<input type="submit" value="X" name="B1"></p>
</form>
             <font face="Arial Rounded MT Bold"><a href="<?php echo $PHP_SELF . '?page=1&cambio_monetario=tarjeta&oID=' . $oID ?>">PAGAR CON TARJETA</a></font>
       <?php



      }

  } // escbot
              ?>
          
          
          

          


          
          
          
          
          
          
          
	          <td class="main" colspan="3"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
        </table></td>
      </tr>

<!-- Begin Addresses Block -->

      <tr><?php echo tep_draw_form('edit_order', FILENAME_EDIT_ORDERS_TIENDA, tep_get_all_get_params(array('action')) . 'action=update_order'); ?>
	  </tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr>   




	<!-- Begin Update Block -->
<!-- Improvement: more "Update" buttons (Michel Haase, 2005-02-18) - here after FORM und before MENUE_TITLE_CUSTOMER -->
	
 
<?php



     $estatuspmw_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
     $estatuspmw = tep_db_fetch_array($estatuspmw_values);
   $contar_values = tep_db_query("select count(*) as value from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $oID . "'");
     $contar = tep_db_fetch_array($contar_values);






       $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);


       $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $porcentage_tienda['customers_id'] . "' and customers_porcentage <> '" . 0 . "'");
    $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);




          if ($customers_porcentage['customers_porcentage']){
              $porcentage = $customers_porcentage['customers_porcentage'];

      }else if ($porcentage_tienda['porcentage_tienda']){


  }

    $ot_total_values = tep_db_query("select * from " . 'orders_total' . " where orders_id = '" . $oID . "' and class = '" . 'ot_total' . "'");
     $ot_total_pt = tep_db_fetch_array($ot_total_values);



   $monedabusd_values = tep_db_query("select * from " . 'currencies' . " where currencies_id = '" . 1 . "'");
     $monedabusd = tep_db_fetch_array($monedabusd_values);


   $monedabusd_values = tep_db_query("select * from " . 'currencies' . " where currencies_id = '" . 1 . "'");
     $monedabusd = tep_db_fetch_array($monedabusd_values);




                                    //descuento
   $monedabusd_01 = ($monedabusd['value'] / 100);
   
     $busdtotal = $ot_total_pt['value'] * $monedabusd['value'];
     $busd =  $monedabusd_01 * ($busdtotal  * $porcentage / 100) / $monedabusd_01;
     $descuento = ($ot_total_pt['value2']  * $monedabusd['value']);

   
                $total_sindes_off  = number_format($ot_total_pt['value'] - $ot_total_pt['value2'], 2, '.', '');
                $total_condes_off  = number_format($ot_total_pt['value'], 2, '.', '');
                $total_condes  = number_format($ot_total_pt['value'], 2, '.', '');
              
              if ($total_condes_off == $total_sindes_off){

          }else{
               $total_sindes  = number_format($ot_total_pt['value'] - $ot_total_pt['value2'], 2, '.', '').'€ / ';
               $descuento_value2 = ' / ' .  number_format($ot_total_pt['value2'], 2, '.', '').'€';
              $descuento_busd    =  ' / ' . number_format($descuento, 2, '.', '').'b$';
            }
             
               ?>
      <p><font size="4">LINEAS: <b><font color="#FF0000"><?php echo $contar['value']; ?></font></b> TOTAL: <b>
	<font color="#FF0000"><?php echo $total_condes.'€' . $descuento_value2 ; ?></font> Busd: <b>
 <font color="#FF0000"><?php echo number_format($busdtotal, 2, '.', '').'b$ ' .$descuento_busd ; ?></font></b></font></p>

             <?php                                                        //  and  $login_groups_id <> 1
 // SOLO STATUS SELECCIONADOS SE EJECUTARÁ ESTA PARTE DEL CODIG




//if (ACTIVACION_AEPR == 'false'){
              $consulta1_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
              $consulta1 = tep_db_fetch_array($consulta1_values);
      //    echo  $consulta1['code_admin'] . '-';


              $consulta2_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
              $consulta2 = tep_db_fetch_array($consulta2_values);
     //   echo $consulta2['orders_status'] . '-';

              $consulta3_values = tep_db_query("select * from " . 'orders_status' . " where orders_status_id = '" . $order->info['orders_status'] . "'");
              $consulta3 = tep_db_fetch_array($consulta3_values);
      //   echo $consulta3['tienda'] . '-';


  if ( $consulta3['tienda'] == $consulta1['code_admin']){

 if ($estatuspmw['orders_status'] == $abono and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $pagado and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $entregas_stock and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $retirarado and ACTIVACION_AEPR == 'false'){

   }else{



 ?>
 



   
      <tr>
	      <td>

				</td>
      </tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>


          <?php
       }
}
            ?>
	<!-- End of Update Block -->
 











 
 
<!-- Begin Products Listing Block -->
      <tr>
	      <td>
          <table width="100%" border="0" cellpadding="2" cellspacing="1">
            <tr>


              
              <td class="main" bgcolor="#C9C9C9"><?php echo tep_image_submit('tpv_actualizar_1.jpg', 'Pulsar para Actualizar'); ?></td>

          <td class="main" bgcolor="#C9C9C9" width="10">

                <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
 <td class="main" bgcolor="#C9C9C9" width="10">

           <td class="main" bgcolor="#C9C9C9" width="10">

 <?php
                             $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);


       $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $porcentage_tienda['customers_id'] . "' and customers_porcentage <> '" . 0 . "'");
  $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);



                                  $descuento_cliente = $_POST['descuento_cliente'];
                                              echo    $descuento_cliente;

                                if ($descuento_cliente){
                      $sql_status_update_array = array('customers_porcentage' => $descuento_cliente,  );
             tep_db_perform('customers', $sql_status_update_array, 'update', " customers_id= '" . $porcentage_tienda['customers_id'] . "'");
             
            ?>


        <script type="text/javascript">

       var pagina = 'edit_orders_tienda.php<? echo '?action=edit&oID=' . $oID.'&action=edit';  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


              <?php

             
                            }
                                
                                  $descuento_pedido = $_POST['descuento_pedido'];

                                if ($descuento_pedido){
                                       echo    $descuento_pedido;

                      $sql_status_update_array = array('porcentage_tienda' => $descuento_pedido,  );
             tep_db_perform('orders', $sql_status_update_array, 'update', " customers_id= '" . $porcentage_tienda['customers_id'] . "' and orders_id = '" . $oID . "'");


            ?>


        <script type="text/javascript">

       var pagina = 'edit_orders_tienda.php<? echo '?action=edit&oID=' . $oID.'&action=edit';  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


              <?php

                            }


     ?>




         <td class="main" bgcolor="#C9C9C9" width="10">







         <td class="main" bgcolor="#C9C9C9" width="10">
         

                     
                     
 <?php                                 //descuento
 
 
 




     ?>

                     
                     
                     

          <td class="main" bgcolor="#C9C9C9" width="10">

          <td class="main" bgcolor="#C9C9C9" width="10">

             <td class="main" bgcolor="#C9C9C9" width="10">

              <td class="main" bgcolor="#C9C9C9" width="10">
               <?php
                   if (AYUDA_ADMIN == 'true'){
               $ayuda_editar = '<a class="hastip"  title="' . AYUDA_TEXT_EDITAR . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
               $ayuda_actualizar = '<a class="hastip"  title="' . AYUDA_TEXT_ACTUALIZAR . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
               $ayuda_descuento_pedido = '<a class="hastip"  title="' . AYUDA_TEXT_DESCUENTO_PEDIDO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
               $ayuda_descuento_cliente = '<a class="hastip"  title="' . AYUDA_TEXT_DESCUENTO_CLIENTE . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
               $ayuda_keywoards_cliente = '<a class="hastip"  title="' . AYUDA_TEXT_KEYWOARDS_CLIENTE . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
               $ayuda_keywoards_producto = '<a class="hastip"  title="' . AYUDA_TEXT_KEYWOARDS_PRODUCTO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
                                                   }


                   ?>

                                       </form>

              <td class="main" bgcolor="#C9C9C9" width="10">

              <?php echo tep_draw_form('orders', 'edit_orders_tienda.php', '', 'get'); ?>
        <?php echo 'Actualizar'  .$ayuda_actualizar.  ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit'); ?>

                                          </form>


           <td class="main" bgcolor="#C9C9C9" width="10">
           
               <?php echo tep_draw_form('orders', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
        <?php echo 'Editar' .$ayuda_editar. ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit'); ?>

                                          </form>


           <td class="main" bgcolor="#C9C9C9" width="10">



              <td class="main" bgcolor="#C9C9C9" width="10">
              
                  <?php echo tep_draw_form('descuento_pedido', 'edit_orders_tienda.php', 'oID='. $oID .'&action=edit', 'post'); ?>
           <?php echo 'Descuento en pedido' .$ayuda_descuento_pedido. ' ' . $porcentage_tienda['porcentage_tienda']. tep_draw_input_field('descuento_pedido', '', 'size="12"'); ?>
                                                 </form>

              <td class="main" bgcolor="#C9C9C9" width="10">

              <td class="main" bgcolor="#C9C9C9" width="10">
              
                  <?php echo tep_draw_form('descuento_cliente', 'edit_orders_tienda.php', 'oID='. $oID .'&action=edit', 'post'); ?>
           <?php echo 'Descuento de Cliente' .$ayuda_descuento_cliente.  ' ' . $customers_porcentage['customers_porcentage']. tep_draw_input_field('descuento_cliente', '', 'size="12"'); ?>
                                                 </form>
                                                                                                        <?php


                                                       ?>

              <td class="main" bgcolor="#C9C9C9" width="10">
              
              
                  <?php echo tep_draw_form('keywoards', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
           <?php echo 'Datos de Cliente' .$ayuda_keywoards_cliente. ' ' . tep_draw_input_field('keywoards', '', 'size="12"'); ?>


                                         </form>






              <td class="main" bgcolor="#C9C9C9" width="10">


                    <?php echo tep_draw_form('products_keywoards', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
          <?php echo 'Buscar por Producto: ' .$ayuda_keywoards_producto. ' ' . tep_draw_input_field('products_keywoards', '', 'size="12"'); ?>

                                              </form>




              <td class="main" bgcolor="#C9C9C9" width="10">





              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
               <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
               <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
                            <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>

<td class="main" bgcolor="#C9C9C9" width="10" align="center"><?php echo tep_image_submit('tpv_actualizar_1.jpg', 'Pulsar para Actualizar'); ?></td>
	          </tr>
          </table>
				</td>
      </tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>



	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr>
      <tr>
	      <td>
       


	<?php


      $ord='orders_products_id';
 if ($ord){

}else{
  $ord='products_model';
}
 
    $ord='orders_products_id';
     // Override order.php Class's Field Limitations
		$index = 0;
		$order->products = array();
		$orders_products_query = tep_db_query("select  op.products_quantity,
                                                      op.products_name,
                                                      p.products_id,
                                                      p.products_stock_min,
                                                      p.products_stock_obs,
                                                      p.stock_nivel,
                                                      p.products_image,
                                                      p.codigo_proveedor,
                                                       p.products_shoptoshop,
                                                      p.products_status,
                                                      p.time_mercancia_entregado_procesando,
                                                      p.products_price,
                                                      p.proveedor_price_general,
                                                      p.codigo_barras,
                                                      p.time_entradasysalidas,
                                                      op.cambio_de_productos,
                                                      op.products_model,
                                                      p.products_model_2,
                                                      p.products_model_3,
                                                     pde.donde_esta,
                                                      op.products_inventario,
                                                      op.final_price_euro,
                                                      op.lista_prov,
                                                      p.products_status_exel,
                                                      p.codigo_proveedor,
                                                      op.final_price_tienda,
                                                      p.proveedor_price,
                                                       op.products_tax,
                                                      op.products_price,
                                                      op.final_price,
                                                      op.products_descuento,
                                                      p.products_descuento_onoff,
                                                      op.orders_products_id from " . TABLE_ORDERS_PRODUCTS .  " op, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd left join " . 'products_donde_esta' . " pde on pde.login_id = '" . $log_id . "'  where op.products_quantity <> 0 and p.products_id = pd.products_id and op.products_id = p.products_id and op.orders_id = '" . (int)$oID . "' group by op.orders_products_id ORDER BY op.orders_products_id DESC LIMIT $sel_iten_max");
		while ($orders_products = tep_db_fetch_array($orders_products_query)) {                                                                                                                                                       //p.products_id = pde.products_id and
		$order->products[$index] = array('qty' => $orders_products['products_quantity'],
                                     'name' => tep_html_quotes($orders_products['products_name']),
                                     'products_id' => $orders_products['products_id'],
                                     'codigo_barras' => $orders_products['codigo_barras'],
                                     'codigo_proveedor' => $orders_products['codigo_proveedor'],
                                     'cambio_de_productos' => $orders_products['cambio_de_productos'],
                                     'products_image' => $orders_products['products_image'],
                                     'products_status' => $orders_products['products_status'],
                                     'products_price' => $orders_products['products_price'],
                                     'proveedor_price' => $orders_products['proveedor_price'],
                                     'products_descuento' => $orders_products['products_descuento'],
                                     'products_shoptoshop' => $orders_products['products_shoptoshop'],
                                     'products_descuento_onoff' => $orders_products['products_descuento_onoff'],
                                     'proveedor_price_general' => $orders_products['proveedor_price_general'],
                                     'products_inventario' => $orders_products['products_inventario'],
                                     'model' => $orders_products['products_model'],
                                     'model_2' => $orders_products['products_model_2'],
                                     'model_3' => $orders_products['products_model_3'],
                                     'stock_min' => $orders_products['products_stock_min'],
                                     'stock_obs' => $orders_products['products_stock_obs'],
                                     'stock_nivel' => $orders_products['stock_nivel'],
                                     'time_entradasysalidas' => $orders_products['time_entradasysalidas'],
                                     'codigo_proveedor' => $orders_products['codigo_proveedor'],
                                     'tax' => $orders_products['products_tax'],
                                     'price' => $orders_products['products_price'],
                                     'donde_esta' => $orders_products['donde_esta'],
                                     'final_price' => $orders_products['final_price'],
                                     'final_price_euro' => $orders_products['final_price_euro'],
                                     'final_price_tienda' => $orders_products['final_price_tienda'],
                                     'lista_prov' => $orders_products['lista_prov'],
                                     'products_status_exel' => $orders_products['products_status_exel'],
                                     'time_mercancia_entregado_procesando' => $orders_products['time_mercancia_entregado_procesando'],
                                     'orders_products_id' => $orders_products['orders_products_id']);





		$subindex = 0;
		$attributes_query_string = "select * from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$oID . "' and orders_products_id = '" . (int)$orders_products['orders_products_id'] . "'";
		$attributes_query = tep_db_query($attributes_query_string);
  
  




		if (tep_db_num_rows($attributes_query)) {
		while ($attributes = tep_db_fetch_array($attributes_query)) {
		  $order->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
		                                                            'value' => $attributes['products_options_values'],
		                                                            'prefix' => $attributes['price_prefix'],
		                                                            'price' => $attributes['options_values_price'],
		                                                            'orders_products_attributes_id' => $attributes['orders_products_attributes_id']);
		  $subindex++;
		  }
		}
		$index++;
	}

?>

<table border="0" width="10%" cellspacing="0" cellpadding="2" align="center">

	<tr class="dataTableHeadingRow">
		  <td class="dataTableHeadingContent"><?php echo 'DEL'; ?>
      <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_DEL;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'IMAG'; ?>
     <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_IMAG;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'ID'; ?>
     <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_ID;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'EANA'; ?>
      <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_EANA;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'PVM'; ?>
      <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_PVM;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
  
  
  
  
  
  
  <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
      
  <?php
    }
      ?>
      

	  <td class="dataTableHeadingContent"><?php echo 'X'; ?>
         <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
   <a class="hastip"  title="<?php echo AYUDA_TEXT_X;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'EAN'; ?>
          <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_EAN;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'NOMBRE'; ?>
          <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_NOMBRE;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'PCS'; ?>
          <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_PCS;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
  	  <td class="dataTableHeadingContent"><?php echo 'PVP'; ?>
           <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_PVP;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'PVF'; ?>
           <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_PVF;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  	  <td class="dataTableHeadingContent"><?php echo 'DESCUENTO'; ?>
            <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_DESCUENTO;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
  	  <td class="dataTableHeadingContent"><?php echo 'TOTAL'; ?>
           <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_TOTAL;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
  	  <td class="dataTableHeadingContent"><?php echo 'ADD>>'; ?>
           <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_ADD;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	   <td class="dataTableHeadingContent"><?php  echo 'ID Order'; ?></td>
  	  <td class="dataTableHeadingContent"><?php echo 'STATUS'; ?>
           <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_STATUS;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
      
  	  <td class="dataTableHeadingContent"><?php echo 'CATEGORIA'; ?>
                <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_CATEGORIA;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>

     <td class="dataTableHeadingContent"><?php echo 'IMAG'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_IMAG;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'STOCK'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_STOCK;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'PENDIENTE'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_PENDIENTE;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'Stock Min'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_STOCKMIN;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'Observa StockMin'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_OBS;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'Descuento Producto'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_DESCUENTO_PRODUCTO;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'Descuento Cantidad'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_DESCUENTO_CANTIDAD;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'Crear Oferta'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_CREAR_OFERTA;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'Stock Nivel'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_STOCK_NIVEL;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
	  <td class="dataTableHeadingContent"><?php echo 'STS'; ?>
              <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_STS;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'Ubicacion'; ?>
               <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_UBICACION;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'Editar Ubicacion'; ?>
               <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_EDITAR_UBICACION;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'Stock'; ?>
               <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_STOCK;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
 	  <td class="dataTableHeadingContent"><?php echo 'Nombre Producto'; ?>
               <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_EDITAR_NOMBRE_PRODUCTO;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
  <td class="dataTableHeadingContent" align="right"><?php  echo 'Web'; ?></td>

 	  <td class="dataTableHeadingContent"><?php echo 'or'; ?>
                <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_EXEL;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <td class="dataTableHeadingContent" align="right"><?php  echo 'Exel'; ?></td>
  <?php
    }
      ?>
  	  <td class="dataTableHeadingContent"><?php echo 'TOTAL'; ?>
                <?php
  if (AYUDA_ADMIN == 'true'){
      ?>
  <a class="hastip"  title="<?php echo AYUDA_TEXT_TOTAL;?>"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>
  <?php
    }
      ?>
		</tr>
	<?php


	for ($i=0; $i<sizeof($order->products); $i++) {
	$orders_products_id = $order->products[$i]['orders_products_id'];
	$delete_products = $order->products[$i]['orders_products_id'];


		$RowStyle = "dataTableContent";

echo '	  <tr class="dataTableRow">' . "\n";

  $estatus_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "' and orders_status = '" . $abono . "'");
  $estatus = tep_db_fetch_array($estatus_values);
  $estatuspmw_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
  $estatuspmw = tep_db_fetch_array($estatuspmw_values);


    $proveedor_admin_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" .  $order->products[$i]['codigo_proveedor'] . "'");
    $proveedor_admin = tep_db_fetch_array($proveedor_admin_values);



                                       //  and  $login_groups_id <> 1
 // SOLO STATUS SELECCIONADOS SE EJECUTARÁ ESTA PARTE DEL CODIG
       /*

     $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $order->products[$i]['products_id'] . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);

    $sumar_no_recogido_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $order->products[$i]['products_id'] . "'and o.orders_status =a.no_recogido and a.admin_groups_id=6";
    $sumar_no_recogido_sales_query = tep_db_query($sumar_no_recogido_sales_raw);
    $sumar_no_recogido= tep_db_fetch_array($sumar_no_recogido_sales_query);

    $sumar_pagado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $order->products[$i]['products_id'] . "'and o.orders_status =a.pagado and a.admin_groups_id=6";
    $sumar_pagado_total_sales_query = tep_db_query($sumar_pagado_total_sales_raw);
    $sumar_pagado_total= tep_db_fetch_array($sumar_pagado_total_sales_query);

    $sumar_cobrados_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $order->products[$i]['products_id'] . "'and o.orders_status =a.cobrado and a.admin_groups_id=6";
    $sumar_cobrados_total_sales_query = tep_db_query($sumar_cobrados_total_sales_raw);
    $sumar_cobrados_total= tep_db_fetch_array($sumar_cobrados_total_sales_query);

    $sumar_pagado_transferencia_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $order->products[$i]['products_id'] . "'and o.orders_status =a.pagado_transferencia and a.admin_groups_id=6";
    $sumar_pagado_transferencia_sales_query = tep_db_query($sumar_pagado_transferencia_sales_raw);
    $sumar_pagado_transferencia= tep_db_fetch_array($sumar_pagado_transferencia_sales_query);

    $sumar_paypal_enviado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $order->products[$i]['products_id'] . "'and o.orders_status =a.paypal_enviado and a.admin_groups_id=6";
    $sumar_paypal_enviado_sales_query = tep_db_query($sumar_paypal_enviado_sales_raw);
    $sumar_paypal_enviado= tep_db_fetch_array($sumar_paypal_enviado_sales_query);

    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $order->products[$i]['products_id'] . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);




    $entradas_os = $sumar_entregado_total['value'] + $sumar_no_recogido['value'];
    $salidas_os =  $sumar_cobrados_total['value'] + $sumar_pagado_total['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value'] + $sumar_pendiente_entrada_total['value'];


   $stock_euroconsolas =  $entradas_os - $salidas_os;


           */



 if ($estatuspmw['orders_status'] == $abono and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $pagado and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $entregas_stock and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $retirarado and ACTIVACION_AEPR == 'false'){




  echo '	    <td class="' . $RowStyle . '" align="left" valign="top"><img border="0" src="'. DIR_WS_CATALOG_IMAGES . $order->products[$i]['products_image'] .'" width="40">' . "\n";
  echo '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $order->products[$i]['proveedor_price_general'].$diferencia.'</td>' . "\n";


   //echo    '	<td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][donde_esta]' size='6' value='" . $order->products[$i]['donde_esta'] . "'>";
     	 echo '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $order->products[$i]['proveedor_price'].'</td>' . "\n";


      $saber_stock_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and o.orders_status = '" . $abono . "' and op.products_id = '" . $order->products[$i]['products_id'] . "' and op.products_quantity >= 1");
     if ($saber_stock = tep_db_fetch_array($saber_stock_values)){


        echo    '   <td class="' . $RowStyle . '" align="right" valign="top">' . '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $order->products[$i]['products_id']) . '&value_2=' . 'A' . $affiliate_id . '\')">'    ."          ".'<p><font color="#FF0000">Stock</font></p>'."</td>\n";

             }else{


          echo    '   <td class="' . $RowStyle . '" align="right" valign="top">' . '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $order->products[$i]['products_id']) . '&value_2=' . 'A' . $affiliate_id . '\')">'    ."          ".'Stock'."</td>\n";

         }

               // echo    '   <td class="' . $RowStyle . '" align="right" valign="top">' . '<a target="_blank" href="bbbbb">stock5</a>'."</td>\n";
          echo '	    </td>' . "\n";
	      echo '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $order->products[$i]['final_price_euro'] .'</td>' . "\n";
	      echo '	    </td>' . "\n";
          echo  '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $order->products[$i]['final_price_tienda'] . '</td>' . "\n";

	echo '	    </td>' . "\n" .
       '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $order->products[$i]['codigo_barras'].'</td>' . "\n";

    $pr_grupos_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $codigobarras_c['products_id'] . "' and customers_group_id = '" . $PVP_PVM['customers_group_id'] . "'");
$pr_grupos = tep_db_fetch_array($pr_grupos_values);

     $codigobarras_c['products_price'] = $pr_grupos['customers_group_price'];
	echo '	    </td>' . "\n" .
       '	    <td class="' . $RowStyle . '" align="left" valign="top">' . 'iiiii'.'</td>' . "\n";


	echo '	    </td>' . "\n" .
		   '	    <td class="' . $RowStyle . '" align="left" valign="top">' . ' '.'</td>' . "\n".
            '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $order->products[$i]['qty'].'</td>' . "\n".
            '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $order->products[$i]['name'].'</td>' . "\n";



		// Has Attributes?
		if (sizeof($order->products[$i]['attributes']) > 0) {
			for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
				$orders_products_attributes_id = $order->products[$i]['attributes'][$j]['orders_products_attributes_id'];
				echo '<br /><nobr><small>&nbsp;<i> - ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][option]' size='6' value='" . $order->products[$i]['attributes'][$j]['option'] . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][value]' size='10' value='" . $order->products[$i]['attributes'][$j]['value'] . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][prefix]' size='1' value='" . $order->products[$i]['attributes'][$j]['prefix'] . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][price]' size='6' value='" . $order->products[$i]['attributes'][$j]['price'] . "'>";
				echo '</i></small></nobr>';
			}
		}


	echo '	    </td>' . "\n" .


          '	    <td class="' . $RowStyle . '" align="left" valign="top">' .$order->products[$i]['model'].'</td>' . "\n".

		  //   '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][tax]' size='6' value='" . tep_display_tax_value($order->products[$i]['tax']) . "'>" . '</td>' . "\n" .
		   '	    <td class="' . $RowStyle . '" align="left" valign="top">' .number_format($order->products[$i]['final_price'], 2, '.', '').'</td>' . "\n".
            '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $currencies->format($order->products[$i]['final_price'] + ($order->products[$i]['final_price'] * $order->products[$i]['tax']/100), true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" .
		     '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" .
		     '	    <td class="' . $RowStyle . '" align="right" valign="top"><b>' . $currencies->format(($order->products[$i]['final_price'] + ($order->products[$i]['final_price'] * $order->products[$i]['tax']/100)) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
			 '	  </tr>' . "\n" .
			 '     <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>' . "\n";



    //CAMBIO A ADMIN           time_entradasysalidas
}else{






    // BORRAR
   echo	'	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][delete]' type='checkbox' /></div></td>\n";
 // IMAGENES


                         $products_imagen = $order->products[$i]['products_image'];
                         $codigo_proveedor = $order->products[$i]['codigo_proveedor'];


;
                         
if (@getimagesize(HTTPS_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES . $products_imagen)) {
                                          }else{
        $image_product = DIR_WS_CATALOG_IMAGES . 'imnd.svg';
}

                               //IMAGENES PRODUCTOS
  $codigo_proveedor_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $codigo_proveedor . "'");
  $codigo_proveedor= tep_db_fetch_array($codigo_proveedor_values);


 if (file($codigo_proveedor['proveedor_ruta_images'] . $products_imagen)) {
 $image_product = $codigo_proveedor['proveedor_ruta_images'] . $products_imagen;
}
                                          //  echo  $order->products[$i]['codigo_proveedor'];
if (@getimagesize(HTTPS_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES . $products_imagen)) {
        $image_product = DIR_WS_CATALOG_IMAGES . $products_imagen;
}
                         
                         
                         
                         



  echo '	    <td class="' . $RowStyle . '" align="left" valign="top"><a target="_blank" href=/product_info.php?products_id=' . $order->products[$i]['products_id'] . '><img border="0" src="'. $image_product .'" width="40">' . "\n";

    $products_stock_values = tep_db_query("select * from " . 'products_stock' . " where products_id = '" .  $order->products[$i]['products_id'] . "'");
    $products_stock = tep_db_fetch_array($products_stock_values);

    $products_values = tep_db_query("select * from " . 'products' . " where products_id = '" .  $order->products[$i]['products_id'] . "'");
    $products = tep_db_fetch_array($products_values);
    $pro_special_values = tep_db_query("select * from " . 'specials' . " where products_id = '" .  $order->products[$i]['products_id'] . "'");
    $pro_special = tep_db_fetch_array($pro_special_values);

  $stock_exterior = '<script language="javascript" src="products_info_stock.php?stock_nivel=6&products_id_stock='. $order->products[$i]['products_id'] . ' "> </script>';

                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



              // echo $stock_exteriors = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_admin.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $order->products[$i]['model'] .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
                              // echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_codigo.php?products_id=' . $order->products[$i]['products_id'] . '&codigo='. $order->products[$i]['codigo_barras'] .'"> </script>';


    }


echo    '	<td class="' . $RowStyle . '" valign="top">' .  $order->products[$i]['products_id'];



         // CODIGOS DE BARRAS

 //echo '	    </td>' . "\n" .
   //   '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][products_aut_codigo]' type='checkbox' /></div></td>\n";


      echo    '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][codigo_barras]' size='7' value='" . $order->products[$i]['codigo_barras'] . "'><input name='update_products[$orders_products_id][products_aut_codigo]' type='checkbox' />";



    $pr_grupos_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $order->products[$i]['products_id'] . "' and customers_group_id = '" . 2 . "'");
$pr_grupos = tep_db_fetch_array($pr_grupos_values);

     $pvmver = $_GET['pvmver'];

              if ($pvmver == 'true'){
              $beneficio =  $order->products[$i]['final_price'] -  $pr_grupos['customers_group_price'];
               $pvmtotal = $pr_grupos['customers_group_price'] * $order->products[$i]['qty'];
               $pvptotal =  $order->products[$i]['final_price'] * $order->products[$i]['qty'];

                       $pvmbeness =  $pvptotal- $pvmtotal;
               if ($pvmbeness == $beneficio){

           }else{

                $pvmbene =  $pvptotal- $pvmtotal;
                 $pvmbene2 =  number_format($pvmbene, 2, '.', '').'€';
       }

	echo '	    </td>' . "\n" .
    '	  </p> <td class="' . $RowStyle . '" align="left" valign="top">' . number_format($pr_grupos['customers_group_price'], 2, '.', '') . '€ ' . number_format($beneficio, 2, '.', ''). '€ ' . $pvmbene2 . '</td>' . "\n";
              }else{

   echo '	    <td class="' . $RowStyle . '" align="left" valign="top"><a target="_blank" href=edit_orders_tienda.php?oID='.$oID.'&pvmver=' . 'true' . '>' . 'ver' .'</td>' . "\n";
                }


if (PERMISO_INSERTAR_PRODUCTO_EN_NUEVO_PEDIDO == 'True'){


 echo '	    </td>' . "\n" .
     '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][products_aut_referencia1]' type='checkbox' /><p> <input name='update_products[$orders_products_id][products_aut_referencia2]' type='checkbox' /><p> <input name='update_products[$orders_products_id][products_aut_referencia3]' type='checkbox' /><p> <input name='update_products[$orders_products_id][products_aut_referencia4]' type='checkbox' /></div></td>\n </div></td>\n";

 	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][model]' size='5' value='" . $order->products[$i]['model'] . "'><p>" . "".
  "<input name='update_products[$orders_products_id][model_2]' size='5' value='" . $order->products[$i]['model_2'] . "'><p>" . "" .
  "<input name='update_products[$orders_products_id][model_3]' size='5' value='" . $order->products[$i]['model_3'] . "'><p>" . "" .
   "<input name='update_products[$orders_products_id][model_4]' size='5' value='" . $order->products[$i]['model_4'] . "'>" . "";



                     // nombre del producto y cantidad
        echo '	    </td>' . "\n" .
             '	    <td class="' . $RowStyle . '" valign="top">' . $order->products[$i]['name'] .
           	 '     <td class="' . $RowStyle . '" align="left" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][qty]' size='6' value='" . $order->products[$i]['qty'] . "'>PCS</div></td>";
 		//'	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][peso]' size='7' value='" . $order->products[$i]['peso'] . "


    // solo modifica el precio en  PVP RECONFIGURAR Y MODIFICAR CADA ESCALA
// echo '	    </td>' . "\n" .
 //     '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][products_price_modificar]' type='checkbox' /></div></td>\n";

                      // precios, cambiar precio del producto, totales
                // admin level price
       if ($estatuspmw['admin_level_price'] == 1 and $login_groups_id == 9 and PERMISO_EMPLEADO_PRECIO == 'True'){
echo '	    </td>' . "\n" .
		 '	    <td class="' . $RowStyle . '" align="left" valign="top">' . number_format($order->products[$i]['final_price'], 2, '.', '') .'Eur.</td>' . "\n";

       }else{

	echo '	    </td>' . "\n" .
		   //  '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][tax]' size='6' value='" . tep_display_tax_value($order->products[$i]['tax']) . "'>" . '</td>' . "\n" .
		      '	    <td class="' . $RowStyle . '" align="left" valign="top">' . "<input name='update_products[$orders_products_id][price]' size='4' value='" . number_format($order->products[$i]['price'], 2, '.', '') . "'><input name='update_products[$orders_products_id][products_price_modificar]' type='checkbox' /" . '<font color="#008080">PVP</font></td></b>' . "\n";




	echo '	    </td>' . "\n" .
		   //  '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][tax]' size='6' value='" . tep_display_tax_value($order->products[$i]['tax']) . "'>" . '</td>' . "\n" .      //descuento
		      '	    <td class="' . $RowStyle . '" align="left" valign="top">' . "<input name='update_products[$orders_products_id][final_price]' size='4' value='" . number_format($order->products[$i]['final_price'], 2, '.', '') . "'><input name='update_products[$orders_products_id][deson_detail]' type='checkbox' />" . ' <font color="#008080">PVF</font></td></b>' . "\n";

	echo '	    </td>' . "\n" .
		   //  '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][tax]' size='6' value='" . tep_display_tax_value($order->products[$i]['tax']) . "'>" . '</td>' . "\n" .      //descuento
		      '	    <td class="' . $RowStyle . '" align="left" valign="top">' . "<input name='update_products[$orders_products_id][products_descuento]' size='4'  value='" . number_format($order->products[$i]['products_descuento'], 2, '.', '') . " '  /style=color: #FF0000; border: 1px solid #FF0000>" . '<font color="#FF0000">DES</font></b>' . "\n";


                                 } //fin admin level price



	echo '	    </td>' . "\n" .
		   //  '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][tax]' size='6' value='" . tep_display_tax_value($order->products[$i]['tax']) . "'>" . '</td>' . "\n" .
		      '	    <td class="' . $RowStyle . '" align="right" valign="top"><b>' . $currencies->format(($order->products[$i]['final_price'] + ($order->products[$i]['final_price'] * $order->products[$i]['tax']/100)) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";

  $addstock_values = tep_db_query("select * from " . TABLE_ORDERS . "  where orders_status = '" . $entregas_stock . "' order by date_purchased DESC");
   $addstock = mysqli_fetch_array($addstock_values);

  $addpend_values = tep_db_query("select * from " . TABLE_ORDERS . "  where orders_status = '" . $status_entregas . "' order by date_purchased DESC");
   $addpend = tep_db_fetch_array($addpend_values);




 // INSERTAR PRODUCTO EN OTRO PEDIDO
echo    '	<td class="' . $RowStyle . '" valign="top">' . "Add>>order<input name='update_products[$orders_products_id][numero_nuevo_pedido]' size='6' value='" . '' . "'>"  .
                                                           "Add>>Stock<input name='update_products[$orders_products_id][numero_nuevo_pedido_stock]' size='6' value='" . $addstock['orders_id'] . "'>" .
                                                           "Add>>pdie<input name='update_products[$orders_products_id][numero_nuevo_pedido_pend]' size='6' value='" . $addpend['orders_id'] . "'>"  ;


echo    '	<td class="' . $RowStyle . '" valign="top">' . "Pcs<input name='update_products[$orders_products_id][unidades_nuevo_pedido]' size='2' value='" . '' . "'>"  .
                                       "Pcs<input name='update_products[$orders_products_id][unidades_nuevo_pedido_stock]' size='2' value='" . '' . "'>".
                                       "Pcs<input name='update_products[$orders_products_id][unidades_nuevo_pedido_pend]' size='2' value='" . '' . "'>";
                                                 }
                                                 


    if ($order->products[$i]['products_status'] == 1){
           $order_statuses = 'Active';
}else{

          $order_statuses = 'Inactive';
}




        echo '	    </td>' . "\n" .
             '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][products_status]' size='3' value='" . $order->products[$i]['products_status'] . "'>'" . $order_statuses . "'";






   echo '	    <td class="' . $RowStyle . '" align="left" valign="top"><a target="_blank" href=categories.php?search=' . $order->products[$i]['model'] . '>' . 'Categoria' .
   '	  <a target="_blank" href=categories.php?pID=' . $order->products[$i]['products_id'] . '&action=new_product>' . 'Editar' .
    '	  <a target="_blank" href=quick_cliente.php?buscar=ok&page=&MAX_DISPLAY_SEARCH_RESULTS=1&codigo_proveedor=' . $order->products[$i]['codigo_proveedor'] . '&palabraclave=' . $order->products[$i]['model'] . '&>' . 'Repositorio' .'</td>' . "\n";



                                                 
   echo '	    <td class="' . $RowStyle . '" align="left" valign="top"><a target="_blank" href=/product_info.php?products_id=' . $order->products[$i]['products_id'] . '><img border="0" src="'. $image_product .'" width="40">' . "\n";
  // echo '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $stock_exterior . '/' . $order->products[$i]['time_mercancia_entregado_procesando'] . '</td>     ' . "\n";
   echo '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $stock_exterior . '/' . $products_stock['products_stock_pendiente'] . '</td>     ' . "\n";

                  // stock exterior
                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo <> '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



              $stock_exteriors = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_admin.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $order->products[$i]['model'] .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
 echo '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $stock_exteriors . '/'  . '</td>     ' . "\n";


    }




    $pdc_precio_final_values = tep_db_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $order->products[$i]['products_id'] . "' order by pdc_unidades desc");
  if ($pdc_precio_final = tep_db_fetch_array($pdc_precio_final_values)){

            $pdc_price_final = '<p style="margin-top: -5px; margin-bottom: -5px"><font size="0">+'.$pdc_precio_final['pdc_unidades'].'->></s>
             <b>' . $pdc_precio_final['pdc_price_final'] . '€</b></p>';



}else{

   $pdc_price_final = '';

}

	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">Min' . "<input name='update_products[$orders_products_id][stock_min]' size='2' value='" . $products_stock['products_stock_min'] . "'>" . '</td>' . "\n";
	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">Obs ' . "<input name='update_products[$orders_products_id][stock_obs]' size='3' value='" . $order->products[$i]['stock_obs'] . "'>" . '</td>' . "\n";

 	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">1-0 ' . "<input name='update_products[$orders_products_id][products_descuento_onoff]' size='3' value='" . $order->products[$i]['products_descuento_onoff'] . "'>" . "Dprod <input name='update_products[$orders_products_id][products_descuento_p]' size='3' value='" . $products['products_descuento'] . "'>" . '</td>' . "\n";

 	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">Cantidad ' . "<input name='update_products[$orders_products_id][pdc_unidades]' size='10' value='" . '' . "'>" . "Price <input name='update_products[$orders_products_id][pdc_price_final]' size='7' value='" . '' . "'>" .  $pdc_price_final . '</td>' . "\n";

 	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">1-0-2 ' . "<input name='update_products[$orders_products_id][products_special_status]' size='3' value='" . $pro_special['status'] . "'>" . "Special<input name='update_products[$orders_products_id][products_special_price]' size='3' value='" . $pro_special['specials_new_products_price'] . "'>" . '</td>' . "\n";

	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">StNi ' . "<input name='update_products[$orders_products_id][stock_nivel]' size='3' value='" . $order->products[$i]['stock_nivel'] . "'>" . '</td>' . "\n";

	echo '	    </td>' . "\n" .
  '	    <td class="' . $RowStyle . '" valign="top">0-1 ' . "<input name='update_products[$orders_products_id][products_shoptoshop]' size='3' value='" . $order->products[$i]['products_shoptoshop'] . "'>" . '</td>' . "\n";

           if (PERMISO_DONDE_ESTA == 'True'){
          echo  '	    <td class="' . $RowStyle . '" align="left" valign="top">';
   $donde_esta_a_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $order->products[$i]['products_id'] . "'");
   while  ($donde_esta_a = tep_db_fetch_array($donde_esta_a_values)){



   echo $donde_esta_a['donde_esta'] . '-';


}

   $donde_esta_b_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $order->products[$i]['products_id'] . "' and login_id = '" . $log_id . "' ");
     $donde_esta_b = tep_db_fetch_array($donde_esta_b_values);


     '</td>' . "\n";


       if ($order->products[$i]['donde_esta']){

         }else{
      $order->products[$i]['donde_esta'] = '';
     }



        	echo    '	<td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][donde_esta]' size='6' value='" . $donde_esta_b['donde_esta'] . "'>";












        }   // DONDE ESTA
     	//echo    '	<td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][proveedor_price]' size='6' value='" . $order->products[$i]['proveedor_price_general'] . "'>";

      $saber_stock_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and o.orders_status = '" . $abono . "' and op.products_id = '" . $order->products[$i]['products_id'] . "' and op.products_quantity >= 1");
     if ($saber_stock = tep_db_fetch_array($saber_stock_values)){


        echo    '   <td class="' . $RowStyle . '" align="right" valign="top">' . '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $order->products[$i]['products_id']) . '&value_2=' . 'A' . $affiliate_id . '\')">'    ."          ".'<p><font color="#FF0000">Stock</font></p>'."</td>\n";

             }else{


            echo    '   <td class="' . $RowStyle . '" align="right" valign="top">' . '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $order->products[$i]['products_id']) . '&value_2=' . 'A' . $affiliate_id . '\')">'    ."          ".'Stock'."</td>\n";

         }



      $categorias_id_values = tep_db_query("select cd.categories_name, cd.categories_id, c.parent_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_CATEGORIES . " c  where ptc.categories_id = cd.categories_id and c.categories_id = cd.categories_id and ptc.products_id= '" . $order->products[$i]['products_id'] . "'");
    while ($categorias_id = tep_db_fetch_array($categorias_id_values)){


 $categories_parentid_query = tep_db_query("select * from " . 'categories_description' . " where categories_id = '" . $categorias_id['parent_id'] . "'");
 $categories_parentid = tep_db_fetch_array($categories_parentid_query);

                                                                         // tep_href_link('index.php', 'products_id=' . $listing['products_id'].'&cPath='.$cPath);
  $products_parametros =   '<br />Categoría: <a href="' . tep_href_link('categories.php?', 'cPath='.$categorias_id['parent_id'].'&pID='. $order->products[$i]['products_id'] .'&action=move_product&cPath='.$categorias_id['parent_id'] . '_' .$categorias_id['categories_id']) . '"><span class="smallText">' . $categories_parentid['categories_name'] . '/' . $categorias_id['categories_name'] . '</a></span>';

}



                     // nombre del producto y cantidad
        echo '	    </td>' . "\n" .
             '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][name]' size='38' value='" . $order->products[$i]['name'] . "'><input name='update_products[$orders_products_id][products_news]' type='checkbox' />" . ' ' . " | <input name='update_products[$orders_products_id][products_news_update]' type='checkbox' />" . '<a class="hastip"  title="' . AYUDA_TEXT_NUEVO_PRODUCTO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>'  . $products_parametros ;
 		//'	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][peso]' size='7' value='" . $order->products[$i]['peso'] . "
                          // NUEVO PRODUCTO






//   echo '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $v_products_price = number_format($order->products[$i]['products_price'], 2, '.', '') .'</td>' . "\n";

 //  echo '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $order->products[$i]['proveedor_price_general'].$diferencia.'</td>' . "\n";



         

        // echo    '   <td class="' . $RowStyle . '" align="right" valign="top">' . '<a target="_blank" href="'.'consultar_stock_tiendas.php?products_id=' . $order->products[$i]['products_id'] . '&value_2=' . 'A' . $affiliate_id .'">stock5</a>'."</td>\n";
          echo '	    </td>' . "\n";
	 //     echo '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $order->products[$i]['final_price_euro'] .'</td>' . "\n";
	      echo '	    </td>' . "\n";
       //   echo  '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $order->products[$i]['final_price_tienda'] . '</td>' . "\n";





          //Pasar Productos a MERCANCIA ENTREGADA


	//echo '	    </td>' . "\n" .
	//	     '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][entregada_selec]' type='checkbox' /></div></td>\n" .
		//	 '     <td class="' . $RowStyle . '" align="right" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][entregada_unidades]' size='2' value='" . 0 . "'></div></td>\n";
                                   //fin





	//echo '	    </td>' . "\n" .
		//     '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][pendiente_entrada_selec]' type='checkbox' /></div></td>\n" .
	//	 '     <td class="' . $RowStyle . '" align="right" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][pendiente_entrada_unidades]' size='2' value='" . 0 . "'></div></td>\n";
                                   //fin

    /*
 if (PERMISO_STOCK_EN_ALMACEN == 'True'){






 echo '	    </td>' . "\n" .
       '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . $order->products[$i]['lista_prov'] . "<input name='update_products[$orders_products_id][lista_prov_quitar]' type='checkbox' /></div></td>\n" .
		'	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . $order->products[$i]['lista_prov'] . "<input name='update_products[$orders_products_id][lista_prov_poner]' type='checkbox' /></div></td>\n";
           }






                  // admin level borrar seguridad antirrobo.
          if ($estatuspmw['admin_level_borrar'] == 1 and $login_groups_id == 9 and PERMISO_EMPLEADO_BORRAR == 'True'){
      echo '	    </td>' . "\n" .
		 '	    <td class="' . $RowStyle . '" align="left" valign="top">' . 'Borrar'.'</td>' . "\n";
      }else{
 echo '	    </td>' . "\n" .
		'	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][delete]' type='checkbox' /></div></td>\n";
			// '     <td class="' . $RowStyle . '" align="right" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][qty]' size='5' value='" . $order->products[$i]['qty'] . "'></div></td>\n" .
 		//    '	    <td class="' . $RowStyle . '" align="left" valign="top">' .$order->products[$i]['products_inventario'].'</td>' . "\n ".
     '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][codigo_barras]' size='15' value='" . $order->products[$i]['codigo_barras'] . "'>";

       } // fin admin level borrar

                     */






    if (PERMISO_CAMBIO_POR_OTRO == 'True'){
 echo '	    </td>' . "\n" .

 '	    <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][cambio_de_productos]' size='2' value='" . $order->products[$i]['cambio_de_productos'] . "'>";

                 }  // PERMISO_CAMBIO_POR_OTRO


              if (PERMISO_NOMBRE_PROVEEDOR == 'True'){
     echo '	    </td>' . "\n" .
		 '	    <td class="' . $RowStyle . '" align="left" valign="top">' . $proveedor_admin['proveedor_name'].'</td>' . "\n";

                             }
                             
                             
                             
                             

		// Has Attributes?
		if (sizeof($order->products[$i]['attributes']) > 0) {
			for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
				$orders_products_attributes_id = $order->products[$i]['attributes'][$j]['orders_products_attributes_id'];

          echo '	    </td>' . "\n" .
		 '	    <td class="' . $RowStyle . '" align="left" valign="top">' .  "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][option]' size='6' value='" . $order->products[$i]['attributes'][$j]['option'] . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][value]' size='10' value='" . $order->products[$i]['attributes'][$j]['value'] . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][prefix]' size='1' value='" . $order->products[$i]['attributes'][$j]['prefix'] . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][price]' size='6' value='" . $order->products[$i]['attributes'][$j]['price'] . "'>".'</td>' . "\n";


			}
		}












                                                                                      if ($estatuspm['orders_status'] == $abono){

                                                                                      $order->products[$i]['final_price'] =   $order->products[$i]['proveedor_price_general'];
                                                                                  }
                                                                                 if ($order->products[$i]['products_status_exel'] == 1){

                                                                                 $status_exel = 'Exel';
                                                                                        }else if  ($order->products[$i]['products_status_exel'] == 2){
                                                                                 $status_exel = 'Web';
                                                                                 }


 echo '	    </td>' . "\n" .
       '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][products_status_exel_1]' type='checkbox' /></div></td>\n" .
        '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . $status_exel . "</div></td>\n" .
       '	    <td class="' . $RowStyle . '" valign="top"><div align="center">' . "<input name='update_products[$orders_products_id][products_status_exel_2]' type='checkbox' /></div></td>\n";









    echo '	    </td>' . "\n" .

		 //    '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $currencies->format($order->products[$i]['final_price'] + ($order->products[$i]['final_price'] * $order->products[$i]['tax']/100), true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" .
		 //    '	    <td class="' . $RowStyle . '" align="right" valign="top">' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" .
		     '	    <td class="' . $RowStyle . '" align="right" valign="top"><b>' . $currencies->format(($order->products[$i]['final_price'] + ($order->products[$i]['final_price'] * $order->products[$i]['tax']/100)) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
			 '	  </tr>' . "\n" .
			 '     <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>' . "\n";





           }






	}

?>
 </table>
        </td>
      <tr>
	      <td>

	<!-- End Products Listings Block -->

	<!-- Begin Update Block -->
<!-- Improvement: more "Update" buttons (Michel Haase, 2005-02-18) -->



  <?php



     $estatuspmw_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
     $estatuspmw = tep_db_fetch_array($estatuspmw_values);

                                       //  and  $login_groups_id <> 1
 // SOLO STATUS SELECCIONADOS SE EJECUTARÁ ESTA PARTE DEL CODIG




//if (ACTIVACION_AEPR == 'false'){

              $consulta1_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
              $consulta1 = tep_db_fetch_array($consulta1_values);
      //    echo  $consulta1['code_admin'] . '-';


              $consulta2_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
              $consulta2 = tep_db_fetch_array($consulta2_values);
     //   echo $consulta2['orders_status'] . '-';

              $consulta3_values = tep_db_query("select * from " . 'orders_status' . " where orders_status_id = '" . $order->info['orders_status'] . "'");
              $consulta3 = tep_db_fetch_array($consulta3_values);
      //   echo $consulta3['tienda'] . '-';


  if ( $consulta3['tienda'] == $consulta1['code_admin']){


 if ($estatuspmw['orders_status'] == $abono and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $pagado and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $entregas_stock and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $retirarado and ACTIVACION_AEPR == 'false'){

   }else{



 ?>

      <tr>
	      <td>
          <table width="100%" border="0" cellpadding="2" cellspacing="1">
            <tr>
              <td class="main" bgcolor="#C9C9C9"><?php echo tep_image_submit('tpv_actualizar_1.jpg', 'Pulsar para Actualizar'); ?></td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="120" align="center"><?php echo tep_image_submit('tpv_actualizar_1.jpg', 'Pulsar para Actualizar'); ?></td>
	          </tr>
          </table>
				</td>
      </tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      
      
      
      <?php
    }
    
}

         ?>
	<!-- End of Update Block -->
 
 
 
 


 
 
 
 
 
 
 
 
     	      <td class="SubTitle"><?php echo MENUE_TITLE_TOTAL; ?></td>
			</tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr>
      <tr>
	      <td>

 
 

 
 

<table border="0" cellspacing="0" cellpadding="2" class="dataTableRow">
	<tr class="dataTableHeadingRow">
	  <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TOTAL_MODULE; ?></td>
	  <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TOTAL_AMOUNT; ?></td>
	  <td class="dataTableHeadingContent"width="1"><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
	</tr>
<?php
  // Override order.php Class's Field Limitations
  $totals_query = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$oID . "' order by sort_order");
  $order->totals = array();
  while ($totals = tep_db_fetch_array($totals_query)) {
	  $order->totals[] = array('title' => $totals['title'], 'text' => $totals['text'], 'class' => $totals['class'], 'value' => $totals['value'], 'orders_total_id' => $totals['orders_total_id']);
	}

// START OF MAKING ALL INPUT FIELDS THE SAME LENGTH
	$max_length = 0;
	$TotalsLengthArray = array();
	for ($i=0; $i<sizeof($order->totals); $i++) {
		$TotalsLengthArray[] = array("Name" => $order->totals[$i]['title']);
	}
	reset($TotalsLengthArray);
	foreach($TotalsLengthArray as $TotalIndex => $TotalDetails) {
		if (strlen($TotalDetails["Name"]) > $max_length) {
			$max_length = strlen($TotalDetails["Name"]);
		}
	}
// END OF MAKING ALL INPUT FIELDS THE SAME LENGTH

	$TotalsArray = array();
		for ($i=0; $i<sizeof($order->totals); $i++) {
		$TotalsArray[] = array("Name" => $order->totals[$i]['title'], "Price" => number_format($order->totals[$i]['value'], 2, '.', ''), "Class" => $order->totals[$i]['class'], "TotalID" => $order->totals[$i]['orders_total_id']);
		$TotalsArray[] = array("Name" => "", "Price" => "", "Class" => "ot_custom", "TotalID" => "0");
	}

	array_pop($TotalsArray);
	foreach($TotalsArray as $TotalIndex => $TotalDetails)
	{
		$TotalStyle = "smallText";
		if($TotalDetails["Class"] == "ot_total")
		{
			echo '	<tr>' . "\n" .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . $TotalDetails["Name"] . '</b></td>' .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . $currencies->format($TotalDetails["Price"], true, $order->info['currency'], $order->info['currency_value']) . '</b>' .
						    "<input name='update_totals[$TotalIndex][title]' type='hidden' value='" . trim($TotalDetails["Name"]) . "' size='" . strlen($TotalDetails["Name"]) . "' >" .
						    "<input name='update_totals[$TotalIndex][value]' type='hidden' value='" . $TotalDetails["Price"] . "' size='6' >" .
						    "<input name='update_totals[$TotalIndex][class]' type='hidden' value='" . $TotalDetails["Class"] . "'>\n" .
						    "<input type='hidden' name='update_totals[$TotalIndex][total_id]' value='" . $TotalDetails["TotalID"] . "'>" . '</b></td>' .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . tep_draw_separator('pixel_trans.gif', '1', '17') . '</b>' .
				   '	</tr>' . "\n";
		}
		elseif($TotalDetails["Class"] == "ot_subtotal")
		{
			echo '	<tr>' . "\n" .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . $TotalDetails["Name"] . '</b></td>' .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . $currencies->format($TotalDetails["Price"], true, $order->info['currency'], $order->info['currency_value']) . '</b>' .
						    "<input name='update_totals[$TotalIndex][title]' type='hidden' value='" . trim($TotalDetails["Name"]) . "' size='" . strlen($TotalDetails["Name"]) . "' >" .
						    "<input name='update_totals[$TotalIndex][value]' type='hidden' value='" . $TotalDetails["Price"] . "' size='6' >" .
						    "<input name='update_totals[$TotalIndex][class]' type='hidden' value='" . $TotalDetails["Class"] . "'>\n" .
						    "<input type='hidden' name='update_totals[$TotalIndex][total_id]' value='" . $TotalDetails["TotalID"] . "'>" . '</b></td>' .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . tep_draw_separator('pixel_trans.gif', '1', '17') . '</b>' .
				   '	</tr>' . "\n";
		}
		elseif($TotalDetails["Class"] == "ot_tax")
		{
			echo '	<tr>' . "\n" .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . trim($TotalDetails["Name"]) . "</b><input name='update_totals[$TotalIndex][title]' type='hidden' size='" . $max_length . "' value='" . trim($TotalDetails["Name"]) . "'>" . '</td>' . "\n" .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . $currencies->format($TotalDetails["Price"], true, $order->info['currency'], $order->info['currency_value']) . '</b>' .
						    "<input name='update_totals[$TotalIndex][value]' type='hidden' value='" . $TotalDetails["Price"] . "' size='6' >" .
						    "<input name='update_totals[$TotalIndex][class]' type='hidden' value='" . $TotalDetails["Class"] . "'>\n" .
						    "<input type='hidden' name='update_totals[$TotalIndex][total_id]' value='" . $TotalDetails["TotalID"] . "'>" . '</b></td>' .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . tep_draw_separator('pixel_trans.gif', '1', '17') . '</b>' .
				   '	</tr>' . "\n";
		}
			else
		{
			echo '	<tr>' . "\n" .
				   '		<td align="right" class="' . $TotalStyle . '">' . "<input name='update_totals[$TotalIndex][title]' size='" . $max_length . "' value='" . tep_html_quotes($TotalDetails["Name"]) . "'>" . '</td>' . "\n" .
				   '		<td align="right" class="' . $TotalStyle . '">' . "<input name='update_totals[$TotalIndex][value]' size='6' value='" . $TotalDetails["Price"] . "'>" .
						    "<input type='hidden' name='update_totals[$TotalIndex][class]' value='" . $TotalDetails["Class"] . "'>" .
						    "<input type='hidden' name='update_totals[$TotalIndex][total_id]' value='" . $TotalDetails["TotalID"] . "'>" .
				   '		<td align="right" class="' . $TotalStyle . '"><b>' . tep_draw_separator('pixel_trans.gif', '1', '17') . '</b>' .
					 '   </td>' . "\n" .
				   '	</tr>' . "\n";
				   '	</tr>' . "\n";
		}
	}

		?>
</table>

	      </td>
      <tr>




 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

      <tr>
	    <td class="SubTitle"><?php echo MENUE_TITLE_CUSTOMER; ?></td>
	  </tr>
      <tr>
	    <td class="SubTitle"><?php echo 'ID de Cliente: '.$estatuspmw['customers_id'] . '<p>&nbsp;</p><a href="create_order_tienda.php?Customer_nr='. $estatuspmw['customers_id'] .'"> Hacer nueva factura con este cliente</a></p>'; ?></td>
	    </tr>
       <tr>
	    <td class="SubTitle"><?php echo '<a href="edit_orders_tienda.php?action=edit&oID='.$oID.'&prueba_notif=ok"> Notificar Cambios al Cliente</a></p>'; ?></td>
	    </tr>
      <tr>
	    <td class="SubTitle"><?php echo '<a href="edit_orders_tienda.php?action=edit&oID='.$oID.'&enviarpedido_notif=ok"> Notificar que el pedido ya se encuentra en stock</a></p>'; ?></td>
	    </tr>
        <tr>
	    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr>   

			<tr>
			  <td>
     
     
     
     
     
     
     
     

     
     

     
     
     
     
     
     
     
     
      
<table border="0" class="dataTableRow" cellpadding="2" cellspacing="0">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" width="80"></td>
    <td class="dataTableHeadingContent" width="150"><?php echo ENTRY_CUSTOMER_ADDRESS; ?></td>
    <td class="dataTableHeadingContent" width="6">&nbsp;</td>
    <td class="dataTableHeadingContent" width="150"><?php echo ENTRY_SHIPPING_ADDRESS; ?></td>
	 <td class="dataTableHeadingContent" width="6">&nbsp;</td>
    <td class="dataTableHeadingContent" width="150"><?php echo ENTRY_BILLING_ADDRESS; ?></td>
  </tr>
 <?php
  if (ACCOUNT_COMPANY == 'true') {
?>
 <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_COMPANY; ?>: </b></td>
    <td><span class="main"><input name="update_customer_company" size="25" value="<?php echo tep_html_quotes($order->customer['company']); ?>" /></span></td>
		<td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_company" size="25" value="<?php echo tep_html_quotes($order->delivery['company']); ?>" /></span></td>
	<td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_company" size="25" value="<?php echo tep_html_quotes($order->billing['company']); ?>" /></span></td>
  </tr>
  <?php
  }
?>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_NAME; ?>: </b></td>
     <td><span class="main"><input name="update_customer_name" size="25" value="<?php echo tep_html_quotes($order->customer['name']); ?>" /></span></td>
    <td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_name" size="25" value="<?php echo tep_html_quotes($order->delivery['name']); ?>" /></span></td>
	<td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_name" size="25" value="<?php echo tep_html_quotes($order->billing['name']); ?>" /></span></td>
  </tr>
  <tr>
    <td class="main"><b><?php echo ENTRY_ADDRESS; ?>: </b></td>
    <td><span class="main"><input name="update_customer_street_address" size="25" value="<?php echo tep_html_quotes($order->customer['street_address']); ?>" /></span></td>
    <td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_street_address" size="25" value="<?php echo tep_html_quotes($order->delivery['street_address']); ?>" /></span></td>
	<td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_street_address" size="25" value="<?php echo tep_html_quotes($order->billing['street_address']); ?>" /></span></td>
  </tr>
  <?php
  if (ACCOUNT_SUBURB == 'true') {
?>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_SUBURB; ?>: </b></td>
    <td><span class="main"><input name="update_customer_suburb" size="25" value="<?php echo tep_html_quotes($order->customer['suburb']); ?>" /></span></td>
    <td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_suburb" size="25" value="<?php echo tep_html_quotes($order->delivery['suburb']); ?>" /></span></td>
	<td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_suburb" size="25" value="<?php echo tep_html_quotes($order->billing['suburb']); ?>" /></span></td>
  </tr>
  <?php
  }
?>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_CITY; ?>: </b></td>
    <td><span class="main"><input name="update_customer_city" size="25" value="<?php echo tep_html_quotes($order->customer['city']); ?>" /></span></td>
    <td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_city" size="25" value="<?php echo tep_html_quotes($order->delivery['city']); ?>" /></span></td>
	<td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_city" size="25" value="<?php echo tep_html_quotes($order->billing['city']); ?>" /></span></td>
  </tr>
  <?php
  if (ACCOUNT_STATE == 'true') {
?>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_STATE; ?>: </b></td>
    <td><span class="main"><input name="update_customer_state" size="25" value="<?php echo tep_html_quotes($order->customer['state']); ?>" /></span></td>
    <td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_state" size="25" value="<?php echo tep_html_quotes($order->delivery['state']); ?>" /></span></td>
	<td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_state" size="25" value="<?php echo tep_html_quotes($order->billing['state']); ?>" /></span></td>
  </tr>
  <?php
  }
?>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_POSTCODE; ?>: </b></td>
    <td><span class="main"><input name="update_customer_postcode" size="25" value="<?php echo $order->customer['postcode']; ?>" /></span></td>
    <td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_postcode" size="25" value="<?php echo $order->delivery['postcode']; ?>" /></span></td>
	 <td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_postcode" size="25" value="<?php echo $order->billing['postcode']; ?>" /></span></td>
  </tr>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_COUNTRY; ?>: </b></td>
    <td><span class="main"><input name="update_customer_country" size="25" value="<?php echo tep_html_quotes($order->customer['country']); ?>" /></span></td>
    <td>&nbsp;</td>
    <td><span class="main"><input name="update_delivery_country" size="25" value="<?php echo tep_html_quotes($order->delivery['country']); ?>" /></span></td>
	<td>&nbsp;</td>
    <td><span class="main"><input name="update_billing_country" size="25" value="<?php echo tep_html_quotes($order->billing['country']); ?>" /></span></td>
  </tr>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_PHONE; ?>: </b></td>
    <td><span class="main"><input name="update_customer_telephone" size="25" value="<?php echo $order->customer['telephone']; ?>" /></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	 <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="main"><b><?php echo ENTRY_CUSTOMER_EMAIL; ?>: </b></td>
    <td><span class="main"><input name="update_customer_email_address" size="25" value="<?php echo $order->customer['email_address']; ?>" /></span></td>
   <td>&nbsp;</td>
    <td>&nbsp;</td>
	 <td>&nbsp;</td>
    <td>&nbsp;</td>
  	</tr>

  </tr>
  <tr>
	</table>

      <?php


    $c_customers_query = tep_db_query("select customers_observaciones from " . TABLE_CUSTOMERS . " where customers_id = '" . $estatuspmw['customers_id'] . "'");
    $c_customers = tep_db_fetch_array($c_customers_query);

                                      //CHIVATOS BORRAR
                             //  echo 's'.$customers_id.$c_observ['customers_id'].$estatuspmw['customers_id'].$c_customers['customers_observaciones'];


   $codigo_proveedor_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
  $lastm= tep_db_fetch_array($codigo_proveedor_values);


              ?>
 <td class="main"><b><?php echo 'Observaciones'; ?>: </b></td>
    <td><span class="main"><input name="customers_observaciones" size="100" value="<?php echo $c_customers['customers_observaciones']; ?>" />  </span></td>
      <p>&nbsp;</p>
    	</td>
			</tr>

  <td class="main"><b><?php echo 'Fecha Ultima modificación'; ?>: </b></td>
    <td><span class="main"><input name="update_last_modified" size="20" value="<?php echo $lastm['last_modified']; ?>" /> </span></td>
          <td>&nbsp;</td>   <p>&nbsp;</p>
    	</td>
			</tr>
   
   
<!-- End Addresses Block -->

      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>      

<!-- Begin Payment Block -->
      <tr>
	      <td class="SubTitle"><?php echo MENUE_TITLE_PAYMENT; ?></td>
			</tr>
      <tr>


      
  	</tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr>   
      <tr>
	      <td>
				
<table border="0" cellspacing="0" cellpadding="2" class="dataTableRow">
  <tr class="dataTableHeadingRow">
    <td colspan="2" class="dataTableHeadingContent"><?php echo ENTRY_PAYMENT_METHOD; ?></td>
	</tr>
  <tr>
	  <td colspan="2" class="main"><input name="update_info_payment_method" size="35" value="<?php echo $order->info['payment_method']; ?>" /></td>
	</tr>

	<!-- Begin Credit Card Info Block -->
	  <?php if ($order->info['cc_type'] || $order->info['cc_owner'] || $order->info['cc_number'] || $order->info['payment_method'] == "Credit Card" || $order->info['payment_method'] == "Kreditkarte") { ?>
	  <tr>
	    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
	    <td class="main"><input name="update_info_cc_type" size="10" value="<?php echo $order->info['cc_type']; ?>" /></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
	    <td class="main"><input name="update_info_cc_owner" size="20" value="<?php echo $order->info['cc_owner']; ?>" /></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
	    <td class="main"><input name="update_info_cc_number" size="20" value="<?php echo $order->info['cc_number']; ?>" /></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
	    <td class="main"><input name="update_info_cc_expires" size="4" value="<?php echo $order->info['cc_expires']; ?>" maxlength="4" /></td>
	  </tr>
	<?php } ?>
  <!-- End Credit Card Info Block -->
	
</table>
   </td>
      </tr>
	   
<!-- End Payment Block -->

      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>


	<!-- Begin Order Total Block -->

	      </td>
      <tr>
			  <td class="smalltext"><?php echo HINT_TOTALS; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
	<!-- End Order Total Block -->
	
	<!-- Begin Status Block -->
      <tr>
	      <td class="SubTitle"><?php echo MENUE_TITLE_STATUS; ?></td>
			</tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr> 
      <tr>
        <td class="main">
				  
<table border="0" cellspacing="0" cellpadding="2" class="dataTableRow">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></td>
    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="left"><?php echo HEADING_TITLE_STATUS; ?></td>
   <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_COMMENTS; ?></td>
   </tr>
   
   
   



<?php
$orders_history_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . tep_db_input($oID) . "' order by date_added");
if (tep_db_num_rows($orders_history_query)) {
  while ($orders_history = tep_db_fetch_array($orders_history_query)) {
    echo '  <tr>' . "\n" .
         '    <td class="smallText" align="center">' . tep_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
         '    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>' . "\n" .
         '    <td class="smallText" align="center">';
    if ($orders_history['customer_notified'] == '1') {
      echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
    } else {
      echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
    }
    echo '    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>' . "\n" .
         '    <td class="smallText" align="left">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n";
   echo '    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>' . "\n" .
           '    <td class="smallText" align="left">' . nl2br(tep_db_output($orders_history['comments'])) . '&nbsp;</td>' . "\n";
  echo '  </tr>' . "\n";
  }
} else {
  echo '  <tr>' . "\n" .
       '    <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
       '  </tr>' . "\n";
}
?>
</table>

			  </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr>
      <tr>
			  <td>

<table border="0" cellspacing="0" cellpadding="2" class="dataTableRow">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_STATUS; ?></td>
    <td class="main" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_COMMENTS; ?></td>
  </tr>
	<tr>
	  <td>
		  <table border="0" cellspacing="0" cellpadding="2">
        <tr>



<?php



     $estatuspmw_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
     $estatuspmw = tep_db_fetch_array($estatuspmw_values);

                                       //  and  $login_groups_id <> 1
 // SOLO STATUS SELECCIONADOS SE EJECUTARÁ ESTA PARTE DEL CODIG




//if (ACTIVACION_AEPR == 'false'){

              $consulta1_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
              $consulta1 = tep_db_fetch_array($consulta1_values);
      //    echo  $consulta1['code_admin'] . '-';


              $consulta2_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
              $consulta2 = tep_db_fetch_array($consulta2_values);
     //   echo $consulta2['orders_status'] . '-';

              $consulta3_values = tep_db_query("select * from " . 'orders_status' . " where orders_status_id = '" . $order->info['orders_status'] . "'");
              $consulta3 = tep_db_fetch_array($consulta3_values);
      //   echo $consulta3['tienda'] . '-';


  if ( $consulta3['tienda'] == $consulta1['code_admin']){
 if ($estatuspmw['orders_status'] == $abono and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $pagado and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $entregas_stock and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $retirarado and ACTIVACION_AEPR == 'false'){

   }else{

     $c_customers_query = tep_db_query("select customers_billetera from " . TABLE_CUSTOMERS . " where customers_id = '" . $estatuspmw['customers_id'] . "'");
    $c_customers = tep_db_fetch_array($c_customers_query);


 ?>





          <td class="main"><b><?php echo ENTRY_STATUS; ?></b></td>
          <td class="main" align="right"><?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
        </tr>
        <tr>
          <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b></td>
          <td class="main" align="right"><?php echo tep_draw_checkbox_field('notify', '', false); ?></td>
        </tr>
        <tr>
          <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b></td>
          <td class="main" align="right"><?php echo tep_draw_checkbox_field('notify_comments', '', false); ?></td>
        </tr>
     </table>
	  </td>
    <td class="main" width="10">&nbsp;</td>
    <td class="main">
    <?php
   	  echo tep_draw_textarea_field('comments', 'soft', '40', '5');
		  ?>
    </td>
  </tr>
</table>

                                         <div><img src="http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $c_customers['customers_billetera'] ; ?>" alt="QR:"/></div>

			  </td>
			</tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
	<!-- End of Status Block -->
	                       <?php echo $c_customers['customers_billetera'] ; ?>
	<!-- Begin Update Block -->
      <tr>                           </p>
          Descuento: <font color="#FF0000"><?php echo  number_format($descuento-$descuento-$descuento, 2, '.', '').'b$'; ?></font></b></font></p>

      <tr>
	      <td class="SubTitle"><?php echo MENUE_TITLE_UPDATE; ?></td>
			</tr>
      <tr>
	      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
      </tr>   
      <tr>
	      <td>
          <table width="100%" border="0" cellpadding="2" cellspacing="1">
            <tr>
              <td class="main" bgcolor="#C9C9C9"><?php echo tep_image_submit('tpv_actualizar_1.jpg', 'Pulsar para Actualizar'); ?></td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="10">&nbsp;</td>
              <td class="main" bgcolor="#C9C9C9" width="120" align="center"><?php echo tep_image_submit('tpv_actualizar_1.jpg', 'Pulsar para Actualizar'); ?></td>
	          </tr>
          </table>
				</td>
      </tr>
	<!-- End of Update Block -->
	
      </form>
			
<?php


} // modificacion

}


}
if($action == "add_product")
{
?>
      <tr>
        <td width="100%">
				  <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td class="pageHeading"><?php echo ADDING_TITLE; ?> (No. <?php echo $oID; ?>)</td>
              <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
              <td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_EDIT_ORDERS_TIENDA, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
            </tr>
          </table>
				</td>
      </tr>

<?php
	// ############################################################################
	//   Get List of All Products
	// ############################################################################

		$result = tep_db_query("SELECT products_name, p.products_id, categories_name, ptc.categories_id FROM " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id=p.products_id LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc ON ptc.products_id=p.products_id LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON cd.categories_id=ptc.categories_id where pd.language_id = '" . (int)$languages_id . "' ORDER BY categories_name");
		while($row = tep_db_fetch_array($result))
		{
			extract($row,EXTR_PREFIX_ALL,"db");
			$ProductList[$db_categories_id][$db_products_id] = $db_products_name;
			$CategoryList[$db_categories_id] = $db_categories_name;
			$LastCategory = $db_categories_name;
		}
		
	// ############################################################################
	//   Add Products Steps
	// ############################################################################
	echo '<tr><td><table border="0">' . "\n";
		
		// Set Defaults
			if(!isset($_POST['add_product_categories_id']))
			$add_product_categories_id = 0;

			if(!isset($_POST['add_product_products_id']))
			$add_product_products_id = 0;
			
			// Step 1: Choose Category
			echo '<tr class="dataTableRow"><form action=' . $_SERVER['PHP_SELF'] .'?oID=' . $_GET['oID'] . '&action=' . $_GET['action'] . ' method="POST">' . "\n";
			echo '<td class="dataTableContent" align="right"><b>' . ADDPRODUCT_TEXT_STEP . ' 1:</b></td>' .  "\n";
			echo '<td class="dataTableContent" valign="top">';
			if (isset($_POST['add_product_categories_id'])) {
			$current_category_id = $_POST['add_product_categories_id'];
			}
			echo ' ' . tep_draw_pull_down_menu('add_product_categories_id', tep_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"');
			echo '<input type="hidden" name="step" value="2">' . "\n";
			echo '</td>' . "\n";
			echo '<td class="dataTableContent">' . ADDPRODUCT_TEXT_STEP1 . '</td>' . "\n";
			echo '</form></tr>' . "\n";
			echo '<tr><td colspan="3">&nbsp;</td></tr>' . "\n";
		   
		// Step 2: Choose Product
           if(($_POST['step'] > 1) && ($_POST['add_product_categories_id'] > 0))
		   {
           echo '<tr class="dataTableRow"><form action=' . $_SERVER['PHP_SELF'] .'?oID=' . $_GET['oID'] . '&action=' . $_GET['action'] . ' method="POST">' . "\n";
           echo '<td class="dataTableContent" align="right"><b>' . ADDPRODUCT_TEXT_STEP . ' 2: </b></td>' . "\n";
           echo '<td class="dataTableContent" valign="top"><select name="add_product_products_id" onChange="this.form.submit();">';
           $ProductOptions = "<option value='0'>" . ADDPRODUCT_TEXT_SELECT_PRODUCT . "\n";
           asort($ProductList[$_POST['add_product_categories_id']]);
           foreach($ProductList[$_POST['add_product_categories_id']] as $ProductID => $ProductName)
           {
              $ProductOptions .= "<option value='$ProductID'> $ProductName\n";
           }
		   if(isset($_POST['add_product_products_id'])){
         $ProductOptions = str_replace("value='" . $_POST['add_product_products_id'] . "'", "value='" . $_POST['add_product_products_id'] . "' selected=\"selected\"", $ProductOptions);
           }
		   echo ' ' . $ProductOptions .  ' ';
           echo '</select></td>' . "\n";
           echo '<input type="hidden" name="add_product_categories_id" value=' . $_POST['add_product_categories_id'] . '>';
           echo '<input type="hidden" name="step" value="3">' . "\n";
           echo '<td class="dataTableContent">' . ADDPRODUCT_TEXT_STEP2 . '</td>' . "\n";
           echo '</form></tr>' . "\n";
           echo '<tr><td colspan="3">&nbsp;</td></tr>' . "\n";
           }

		// Step 3: Choose Options
		if(($_POST['step'] > 2) && ($_POST['add_product_products_id'] > 0))
		
		{
			// Get Options for Products
			$result = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa LEFT JOIN " . TABLE_PRODUCTS_OPTIONS . " po ON po.products_options_id=pa.options_id LEFT JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov ON pov.products_options_values_id=pa.options_values_id WHERE products_id=" . $_POST['add_product_products_id'] . " and po.language_id = '" . (int)$languages_id . "'");
			
			// Skip to Step 4 if no Options
			if(tep_db_num_rows($result) == 0)
			{
				echo '<tr class="dataTableRow">' . "\n";
				echo '<td class="dataTableContent" align="right"><b>' . ADDPRODUCT_TEXT_STEP . ' 3: </b></td>' . "\n";
				echo '<td class="dataTableContent" valign="top" colspan="2"><i>' . ADDPRODUCT_TEXT_OPTIONS_NOTEXIST . '</i></td>' . "\n";
				echo '</tr>' . "\n";
				$_POST['step'] = 4;
			}
			else
			{
				while($row = tep_db_fetch_array($result))
				{
					extract($row,EXTR_PREFIX_ALL,"db");
					$Options[$db_products_options_id] = $db_products_options_name;
					$ProductOptionValues[$db_products_options_id][$db_products_options_values_id] = $db_products_options_values_name;
				}
			
				echo '<tr class="dataTableRow"><form action=' . $_SERVER['PHP_SELF'] .'?oID=' . $_GET['oID'] . '&action=' . $_GET['action'] . ' method="POST">' . "\n";
				echo '<td class="dataTableContent" align="right"><b>' . ADDPRODUCT_TEXT_STEP . ' 3: </b></td><td class="dataTableContent" valign="top">';
				foreach($ProductOptionValues as $OptionID => $OptionValues)
				{
					$OptionOption = "<b>" . $Options[$OptionID] . "</b> - <select name='add_product_options[$OptionID]'>";
					foreach($OptionValues as $OptionValueID => $OptionValueName)
					{
					$OptionOption .= "<option value='$OptionValueID'> $OptionValueName\n";
					}
					$OptionOption .= "</select><br />\n";
					
					if(isset($_POST['add_product_options'])){
					 $OptionOption = str_replace("value='" . $_POST['add_product_options'][$OptionID] . "'", "value='" . $_POST['add_product_options'][$OptionID] . "' selected=\"selected\"", $OptionOption);
					}
					echo '' .  $OptionOption . '';
				}		
				echo '</td>';
				echo '<td class="dataTableContent" align="center"><input type="submit" value="' . ADDPRODUCT_TEXT_OPTIONS_CONFIRM . '">';
				echo '<input type="hidden" name="add_product_categories_id" value=' . $_POST['add_product_categories_id']. '>';
				echo '<input type="hidden" name="add_product_products_id" value=' . $_POST['add_product_products_id'] . '>';
				echo '<input type="hidden" name="step" value="4">';
				echo '</td>' . "\n";
				echo '</form></tr>' . "\n";
			}

			echo '<tr><td colspan="3">&nbsp;</td></tr>' . "\n";
		}

		// Step 4: Confirm
		if($_POST['step'] > 3)
		
		{
		   	echo '<tr class="dataTableRow"><form action=' . $_SERVER['PHP_SELF'] .'?oID=' . $_GET['oID'] . '&action=' . $_GET['action'] . ' method="POST">' . "\n";
			echo '<td class="dataTableContent" align="right"><b>' . ADDPRODUCT_TEXT_STEP . ' 4: </b></td>';
			echo '<td class="dataTableContent" valign="top"><input name="add_product_quantity" size="2" value="1"> ' . ADDPRODUCT_TEXT_CONFIRM_QUANTITY . '</td>';
			echo '<td class="dataTableContent" align="center"><input type="submit" value="' . ADDPRODUCT_TEXT_CONFIRM_ADDNOW . '">';

			if(is_array ($_POST['add_product_options']))
			{
				foreach($_POST['add_product_options'] as $option_id => $option_value_id)
				{
					echo '<input type="hidden" name="add_product_options[' . $option_id . ']" value="' . $option_value_id . '">';
				}
			}
			echo '<input type="hidden" name="add_product_categories_id" value=' . $_POST['add_product_categories_id'] . '>';
			echo '<input type="hidden" name="add_product_products_id" value=' . $_POST['add_product_products_id'] . '>';
			echo '<input type="hidden" name="step" value="5">';
			echo '</td>' . "\n";
			echo '</form></tr>' . "\n";
		}
		
		echo '</table></td></tr>' . "\n";
}  





?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->


<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>

         <?php      //ORDER UPDATED
           	if ($order_updated){

            ?>


        <script type="text/javascript">

       var pagina = 'edit_orders_tienda.php<? echo '?action=edit&oID=' . $oID.'&action=edit';  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


              <?php
           }
                ?>



<?php
require(DIR_WS_INCLUDES . 'application_bottom.php');






       Header("Location: ". FILENAME_EDIT_ORDERS_TIENDA. '?action=edit&oID=' . $oID ."");



?>








