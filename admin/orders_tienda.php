<?php

 //  echo $HTTP_POST_VARS['new_status'];




/*
  $Id: orders.php,v 1.112 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require('includes/conf_status.php');

  
    require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ORDER_PROCESS_TIENDA);

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();


      $certificado = $_POST['certificado'];
      $f_reclamacion = $_POST['f_reclamacion'];
      $n_reclamacion = $_POST['n_reclamacion'];


                    $orders_cuenta_dev = $_POST['orders_cuenta_dev'];
                  $orders_titular_dev = $_POST['orders_titular_dev'];
                  $orders_observaciones_dev = $_POST['orders_observaciones_dev'];
                  $orders_fecha_dev = $_POST['orders_fecha_dev'];


  

  $oorders_statuses = array();
  $oorders_status_array = array();
  $oorders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' or  language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' ORDER BY orders_status_name");
  while ($oorders_status = tep_db_fetch_array($oorders_status_query)) {
    $oorders_statuses[] = array('id' => $oorders_status['orders_status_id'],
                               'text' => $oorders_status['orders_status_name']);
    $oorders_status_array[$oorders_status['orders_status_id']] = $oorders_status['orders_status_name'];
  }




                        //  or $login_groups_id == 8
   if ($login_groups_id == 1){
        //     echo 'dos';
             
             
             
             
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 2 . "' or  language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 3 . "' ORDER BY orders_status_name");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }
  
  
  
  
  
}else{
  //   echo 'tres';
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 2 . "'ORDER BY orders_status_name");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }

}
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
// Start Batch Update Status v0.2
if (isset($HTTP_POST_VARS['submit'])){
 if (($HTTP_POST_VARS['submit'] == BUS_SUBMIT)&&(isset($HTTP_POST_VARS['new_status']))){ // Fair enough, let's update ;)
  $status = tep_db_prepare_input($HTTP_POST_VARS['new_status']);
  if ($status == '') { // New status not selectedaaaaaaaaaaaa
     tep_redirect(tep_href_link(TABLE_ORDERS_TIENDA),tep_get_all_get_params());
  }
  foreach ($HTTP_POST_VARS['update_oID'] as $this_orderID){
    $order_updated = false;
    $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$this_orderID . "'");
    $check_status = tep_db_fetch_array($check_status_query);
    $comments = "Batch status update";
    if ($check_status['orders_status'] != $status) {


     $id_factura_ultimo_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" .  $pagado. "' or orders_status = '" .  $status_liquidacion. "' order by factura_id desc");
    $id_factura_ultimo = tep_db_fetch_array($id_factura_ultimo_values);


                            if ($pagado == tep_db_input($status) or $status_liquidacion == tep_db_input($status)){

    $pro_last_modified_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" .  (int)$this_orderID . "'");
    $pro_last_modified = tep_db_fetch_array($pro_last_modified_values);
    

    $id_factura_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" .  (int)$this_orderID .  "' and orders_status = '" .  $pagado. "' order by factura_id desc");
    $id_factura = tep_db_fetch_array($id_factura_values);


         if ($pagado == tep_db_input($status) and $pro_last_modified['orders_status'] >= 1 or $status_liquidacion == tep_db_input($status) and $pro_last_modified['orders_status'] >= 1 ){
	tep_db_query ("UPDATE " . TABLE_ORDERS . " SET
					factura_id = '" . ++$id_factura_ultimo['factura_id'] . "'
					WHERE orders_id = '" . (int)$this_orderID . "' ");
                                          }





                            if ($pro_last_modified['orders_status'] == $pagado or $pro_last_modified['orders_status'] == $status_liquidacion){


          tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = '" . $pro_last_modified['last_modified'] . "' where orders_id = '" . (int)$this_orderID . "'");
                                                                                   }else{
        tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$this_orderID . "'");
                                                         }

                                                              }else{
   if ($pro_last_modified['orders_status'] <> $pagado or $pro_last_modified['orders_status'] <> $status_liquidacion){

}ELSE{
        tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$this_orderID . "'");
  }
                                                          }







      if (tep_db_input($status) == $pagado or tep_db_input($status) == $pagado_internacional or tep_db_input($status) == $pagado_paypal or tep_db_input($status) == $pagado_transferencia){


           $orders_4_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . "  where orders_id = '" . $this_orderID . "' and pagado = '" . 1 . "'");
    while ($orders_4 = tep_db_fetch_array($orders_4_values)){


                   
                    // actualizar producto pedido para que no calcule mas veces.
                   
               $sql_status_update_array = array('pagado' => 2,                         );
   tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $orders_4['products_id'] . "' and orders_products_id = '" . $orders_4['orders_products_id'] . "'");

           
                  // descuenta el producto del almacen
      $orders_3_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and o.orders_status = '" . $abono . "' and op.products_id = '" . $orders_4['products_id'] . "'");
     if ($orders_3 = tep_db_fetch_array($orders_3_values)){

                                           ECHO '<p style="margin-top: 0; margin-bottom: 0">'.'Descontado del Almacen - '.$orders_4['products_name'].'</p>';

                                          
                                          
                                    // Recta producto del abono de la tienda
                                          
                $sql_status_update_array = array('products_quantity' => $orders_3['products_quantity'] - $orders_4['products_quantity'],
                                                );
            tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $orders_4['products_id'] . "' and orders_products_id = '" . $orders_3['orders_products_id'] . "'");


           //  echo $orders_3['products_quantity'] - $orders_4['products_quantity'];

                            }else{


        // si el producto no existe en el almacen en el momento del pago lo inserta y lo pondria en negativo.
        
        
        
        
        
        
      $proveedor_2_values = tep_db_query("select * from " . TABLE_PRODUCTS . " op where products_id = '" . $orders_4['products_id'] . "'");
      $proveedor_2 = tep_db_fetch_array($proveedor_2_values);

                 //  echo 'antes'.$abono.$proveedor_2['codigo_proveedor'].'fin';

      $proveedor_3_values = tep_db_query("select * from " . TABLE_ORDERS . " o where proveedor_id = '" . $proveedor_2['codigo_proveedor'] . "' and orders_status = '" . $abono . "'");
   if ($proveedor_3 = tep_db_fetch_array($proveedor_3_values)){



        
        
        
        
        
        

                              $serie_g = 'ok';
   require(DIR_WS_INCLUDES . 'proveedores_precios.php');




                              ECHO '<p style="margin-top: 0; margin-bottom: 0">'.'En el almacen no existe y se ha insertado en negativo - '.$orders_4['products_name'].'</p>';




                 $sql_data_array = array('orders_id' => $proveedor_3['orders_id'],
                                         'products_id' => $orders_4['products_id'],
                                         'products_model' => $orders_4['products_model'],
                                         'products_name' => $orders_4['products_name'],
                                         'products_price' => $orders_4['products_price'],
                                         'final_price' => $orders_4['products_price'],
                                         'final_price_euro' => $total_pago_euro,
                                         'final_price_tienda' => $ganancias_tiendas,
                                         'products_tax' => $ProductsTax,
                                         'products_quantity' => - $orders_4['products_quantity'],);
               tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);


                           }


                        }
                            
                            
                            
                            }
                             }

   
   
   
   
   
   
   
   
   
   
   
     if (tep_db_input($status) == $entregas_stock and tep_db_input($status) <> 75 ){


           $orders_4_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . "  where orders_id = '" . $this_orderID . "' and pagado = '" . 1 . "'");
    while ($orders_4 = tep_db_fetch_array($orders_4_values)){



                    // actualizar producto pedido para que no calcule mas veces.

               $sql_status_update_array = array('pagado' => 3,                         );
       tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $orders_4['products_id'] . "' and orders_products_id = '" . $orders_4['orders_products_id'] . "'");



      $orders_3_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and o.orders_status = '" . $abono . "' and op.products_id = '" . $orders_4['products_id'] . "'");
     if ($orders_3 = tep_db_fetch_array($orders_3_values)){




                                    // Recta producto del abono de la tienda

  ECHO '<p style="margin-top: 0; margin-bottom: 0">'.'Mercancía Repuesta - '.$orders_4['products_name'].'</p>';



                              $serie_e = 'ok';
   require(DIR_WS_INCLUDES . 'proveedores_precios.php');

















                                                            // Suma los productos del pedido de entrega al ABONO
                $sql_status_update_array = array('products_quantity' => $orders_3['products_quantity'] + $orders_4['products_quantity'],
                                                 'final_price_euro' => $total_pago_euro,
                                                 'final_price_tienda' => $ganancias_tiendas,
                                                                     );
            tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $orders_4['products_id'] . "' and orders_products_id = '" . $orders_3['orders_products_id'] . "'");


          //   echo $orders_3['products_quantity'] - $orders_4['products_quantity'];

                            }else{


                            
      $proveedor_2_values = tep_db_query("select * from " . TABLE_PRODUCTS . " op where products_id = '" . $orders_4['products_id'] . "'");
      $proveedor_2 = tep_db_fetch_array($proveedor_2_values);
      
                  ECHO '<p style="margin-top: 0; margin-bottom: 0">'.'Mercancía Entregada - '.$orders_4['products_name'].'</p>';

      $proveedor_3_values = tep_db_query("select * from " . TABLE_ORDERS . " o where proveedor_id = '" . $proveedor_2['codigo_proveedor'] . "' and orders_status = '" . $abono . "'");
   if ($proveedor_3 = tep_db_fetch_array($proveedor_3_values)){






                              $serie_g = 'ok';
   require(DIR_WS_INCLUDES . 'proveedores_precios.php');




                              ECHO 'Insertar Productos en Almacen';



              
                 $sql_data_array = array('orders_id' => $proveedor_3['orders_id'],
                                         'products_id' => $orders_4['products_id'],
                                         'products_model' => $orders_4['products_model'],
                                         'products_name' => $orders_4['products_name'],
                                         'products_price' => $orders_4['products_price'],
                                         'final_price' => $orders_4['products_price'],
                                         'final_price_euro' => $total_pago_euro,
                                         'final_price_tienda' => $ganancias_tiendas,
                                         'products_tax' => $ProductsTax,
                                         'products_quantity' => $orders_4['products_quantity'],);
               tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);


              

                                    }else{




























     //SI NO EXISTE EL ABONO ESTE CODIGO INSERTA UNO NUEVO
     








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
                          'orders_status' => $abono,
                          'currency' => 'EUR',
                          'proveedor_id' => $proveedor_2['codigo_proveedor'],
                          'currency_value' => 1);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

    $insert_id = tep_db_insert_id();


      $sql_data_array = array('orders_id' => $insert_id,
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
							'orders_status_id' => $login_pendiente_entrada, //for MS1 or MS2
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

                              $serie_g = 'ok';
   require(DIR_WS_INCLUDES . 'proveedores_precios.php');




                              ECHO 'Insertar Productos en NUEVO Abono';




                 $sql_data_array = array('orders_id' => $insert_id,
                                         'products_id' => $orders_4['products_id'],
                                         'products_model' => $orders_4['products_model'],
                                         'products_name' => $orders_4['products_name'],
                                         'products_price' => $orders_4['products_price'],
                                         'final_price' => $orders_4['products_price'],
                                         'final_price_euro' => $total_pago_euro,
                                         'final_price_tienda' => $ganancias_tiendas,
                                         'products_tax' => $ProductsTax,
                                         'products_quantity' => $orders_4['products_quantity'],);
               tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);












































                                }
                            
                            
                            
                            

                        }
                            }
                             }
















     if (tep_db_input($status) == $retirarado){


           $orders_4_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . "  where orders_id = '" . $this_orderID . "' and pagado = '" . 1 . "'");
    while ($orders_4 = tep_db_fetch_array($orders_4_values)){



                    // actualizar producto pedido para que no calcule mas veces.

                        $sql_status_update_array = array('pagado' => 3,);
           tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $orders_4['products_id'] . "' and orders_products_id = '" . $orders_4['orders_products_id'] . "'");



      $orders_3_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and o.orders_status = '" . $abono . "' and op.products_id = '" . $orders_4['products_id'] . "'");
     if ($orders_3 = tep_db_fetch_array($orders_3_values)){




                       ECHO '<p style="margin-top: 0; margin-bottom: 0">'.'Mercancía retirada - '.$orders_4['products_name'].'</p>';






                              $serie_f = 'ok';
   require(DIR_WS_INCLUDES . 'proveedores_precios.php');



                               // Recta producto del abono de la tienda


                                                            // Suma los productos del pedido de entrega al ABONO
                $sql_status_update_array = array('products_quantity' => $orders_3['products_quantity'] - $orders_4['products_quantity'],
                                                 'final_price_euro' => $total_pago_euro,
                                                 'final_price_tienda' => $ganancias_tiendas,);
            tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $orders_4['products_id'] . "' and orders_products_id = '" . $orders_3['orders_products_id'] . "'");


           //  echo $orders_3['products_quantity'] - $orders_4['products_quantity'];













                        }
                            }
                             }















       $customer_notified ='0';
          if (isset($HTTP_POST_VARS['notify'])) {
            $notify_comments = '';
            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . MENSAJE_CANCELAR . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $this_orderID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $this_orderID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
            tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
            $customer_notified = '1';
          }
          tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$this_orderID . "', '" . tep_db_input($status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments)  . "')");
          $order_updated = true;
    }
        if ($order_updated == true) {
         $messageStack->add_session("Order $this_orderID updated.", 'success');
        } else {
          $messageStack->add_session("Order $this_orderID not updated.", 'warning');
        }
  } // End foreach ID loop
 }






}
// End Batch Update Status v0.2



  if (tep_not_null($action)) {
    switch ($action) {
      case 'update_order':
        $oID = tep_db_prepare_input($_GET['oID']);
        $status = tep_db_prepare_input($HTTP_POST_VARS['status']);
        $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
        
        $sql_status_update_array = array('certificado' => $certificado,
                                         'orders_titular_dev' => $orders_titular_dev,
                                         'orders_cuenta_dev' => $orders_cuenta_dev,
                                         'orders_observaciones_dev' => $orders_observaciones_dev,
                                         'orders_fecha_dev' => $orders_fecha_dev,
                                         'f_reclamacion' => $f_reclamacion,
                                         'n_reclamacion' => $n_reclamacion );
                tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', "orders_id = '" . $oID . "'");

        $order_updated = false;
        $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
        $check_status = tep_db_fetch_array($check_status_query);
        
        

        if ( ($check_status['orders_status'] != $status) || tep_not_null($comments)) {
          tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$oID . "'");

          $customer_notified = '0';
          if (isset($HTTP_POST_VARS['notify']) && ($HTTP_POST_VARS['notify'] == 'on')) {
            $notify_comments = '';
            if (isset($HTTP_POST_VARS['notify_comments']) && ($HTTP_POST_VARS['notify_comments'] == 'on')) {
              $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
            }

            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n"  . MENSAJE_CANCELAR . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);

            tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, $admin_email_address);

            $customer_notified = '1';
          }

          tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$oID . "', '" . tep_db_input($status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments)  . "')");

          $order_updated = true;
        }







                  $affiliate_datos_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
             $affiliate_datos = tep_db_fetch_array($affiliate_datos_values);

                 //PEDIDO CANCELADO
                 if ($affiliate_datos['orders_status'] == 7){

         //   $devolucion_values = tep_db_query("select * from " . TABLE_AFFILIATE_SALES . " where affiliate_orders_id = '" . $affiliate_datos['orders_id'] . "'");
        //    $devolucion = tep_db_fetch_array($devolucion_values);
            
                 if ($devolucion['affiliate_status_dev'] == 1){


               // BUCLE PARA QUE NO SE GENEREN DOS CONCELACIONES EN UN MISMO PEDIDO.

         //  $sql_status_update_array = array('affiliate_status_dev' => '3');
         //  tep_db_perform(TABLE_AFFILIATE_SALES, $sql_status_update_array, 'update', "affiliate_orders_id = '" . $affiliate_datos['orders_id'] . "' and affiliate_status_dev =  '" . 1 . "'");
                              //FIN

              // Descontar Comision de Afiliado Principal en CANCELADO


              /*

                                $h_affiliate_value = '-'.$devolucion['affiliate_value'];
                                $h_affiliate_payment = '-'.$devolucion['affiliate_payment'];
                                $h_affiliate_percent = '-'.$devolucion['affiliate_percent'];


        $sql_data_array = array('affiliate_id' => $devolucion['affiliate_id'],
                                           'affiliate_date' => date ("Y-m-d H:i:s"),
                                           'affiliate_browser' => $devolucion['affiliate_browser'],
                                           'affiliate_ipaddress ' => $devolucion['affiliate_ipaddress '],
                                           'affiliate_orders_id' => tep_db_input($oID),
                                           'affiliate_orders_cancel_id' => tep_db_input($oID),
                                           'affiliate_status_dev' => '2',
                                           'affiliate_value' => $h_affiliate_value,
                                           'affiliate_payment' => $h_affiliate_payment,
                                           'affiliate_clickthroughs_id ' => $devolucion['affiliate_clickthroughs_id'],
                                           'affiliate_billing_status' => $devolucion['affiliate_billing_status'],
                                           'affiliate_payment_date' => $devolucion['affiliate_payment_date'],
                                           'affiliate_payment_id' => '0',
                                           'affiliate_percent' => $h_affiliate_percent, );
                                     tep_db_perform(TABLE_AFFILIATE_SALES, $sql_data_array);
                                         //FIN
                                         */

                                     // Descontar Comision de Afiliado Remoto en CANCELADO
                                  $ar_values = tep_db_query("select * from " . 'conf_afiliados' . " where id = '" . 22 . "'");
             $ar = tep_db_fetch_array($ar_values);

                       if ($ar['value'] == 1) {

                                     /*
$remote_remove_values = tep_db_query("select * from " . TABLE_AFFILIATE_SALES . " where affiliate_devolution_remote = '" . $affiliate_datos['orders_id'] . "'");
$remote_remove = tep_db_fetch_array($remote_remove_values);


                               $d_affiliate_value = '-'.$remote_remove['affiliate_value'];
                                $d_affiliate_payment = '-'.$remote_remove['affiliate_payment'];
                                $d_affiliate_percent = '-'.$remote_remove['affiliate_percent'];


          $sql_data_array = array('affiliate_id' => $remote_remove['affiliate_id'],
                                                        'affiliate_date' => date ("Y-m-d H:i:s"),
                                                        'affiliate_browser' => $remote_remove['affiliate_browser'],
                                                        'affiliate_ipaddress ' => $remote_remove['affiliate_ipaddress '],
                                                        'affiliate_orders_id' => tep_db_input($oID),
                                                        'affiliate_orders_cancel_id' => tep_db_input($oID),
                                                        'affiliate_status_dev' => '2',
                                                        'affiliate_value' => $d_affiliate_value,
                                                        'affiliate_payment' => $d_affiliate_payment,
                                                        'affiliate_clickthroughs_id ' => $remote_remove['affiliate_clickthroughs_id'],
                                                        'affiliate_billing_status' => $remote_remove['affiliate_billing_status'],
                                                        'affiliate_payment_date' => $remote_remove['affiliate_payment_date'],
                                                        'affiliate_payment_id' => '0',
                                                        'affiliate_percent' => $d_affiliate_percent, );

                      tep_db_perform(TABLE_AFFILIATE_SALES, $sql_data_array);
                                       */
                                  }}}
                             //fin

                                   // DESHACER CAMBIOS DE CANCELADO BORRAR COMISIONES
                 if ( $affiliate_datos['orders_status'] == BOX_CANCEL_DESHACER){

             //    tep_db_query("delete from " . TABLE_AFFILIATE_SALES . " where affiliate_orders_cancel_id  = '" . tep_db_input($oID) . "'");


                              $a_status_update_cancel = 1;

              //   $sql_status_update_array = array('affiliate_status_dev' => $a_status_update_cancel);

               //  tep_db_perform(TABLE_AFFILIATE_SALES, $sql_status_update_array, 'update', "affiliate_orders_id = '" . tep_db_input($oID) . "'");



                           }
                          //FIN























        if ($order_updated == true) {
         $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
        }




















        tep_redirect(tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('action'))));
        
        
        
        
        
        

        
        
        
        
        
        break;
      case 'deleteconfirm':
        $oID = tep_db_prepare_input($_GET['oID']);

        tep_remove_order($oID, $HTTP_POST_VARS['restock']);

        tep_redirect(tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID', 'action'))));
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

  include(DIR_WS_CLASSES . 'order.php');
  
  
          //    <script language="javascript"><!--
// function popupWindow(url) {
 // window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=450,height=600,screenX=150,screenY=150,top=150,left=150')
//}
//--></script>

  
                             //line940
     require(DIR_WS_INCLUDES . 'template_top.php');
?>

































































<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (($action == 'edit') && ($order_exists == true)) {
    $order = new order($oID);

    
    
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>
          
          
<td class="pageHeading" align="right">
<?php echo '<a href="' . tep_href_link(FILENAME_EDIT_ORDERS_TIENDA, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> &nbsp; '; ?>
<?php echo '<a href="' . tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?>
</td>
          

          
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="3"><?php echo tep_draw_separator(); ?></td>
          </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b></td>
                <td class="main"><?php echo $order->customer['telephone']; ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                <td class="main"><?php echo '<a href="mailto:' . $order->customer['email_address'] . '"><u>' . $order->customer['email_address'] . '</u></a>'; ?></td>
              </tr>
               <tr>
                 <?php
               $purchased_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
              $purchased= tep_db_fetch_array($purchased_values);

                   ?>
               
                <td class="main"><b><?php echo 'Fecha: '; ?></b></td>
                <td class="main"><?php echo tep_datetime_short($purchased['date_purchased']); ?></td>
              </tr>

               <tr>

                <td class="main"><b><?php echo 'Ultima Actualización: '; ?></b></td>
                <td class="main"><?php echo tep_datetime_short($purchased['last_modified']); ?></td>
              </tr>


            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>'); ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, '', '<br>'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
            <td class="main"><?php echo $order->info['payment_method']; ?></td>
          </tr>
<?php
    if (tep_not_null($order->info['cc_type']) || tep_not_null($order->info['cc_owner']) || tep_not_null($order->info['cc_number'])) {
?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
            <td class="main"><?php echo $order->info['cc_type']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
            <td class="main"><?php echo $order->info['cc_owner']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
            <td class="main"><?php echo $order->info['cc_number']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
            <td class="main"><?php echo $order->info['cc_expires']; ?></td>
          </tr>
<?php
    }
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td>













      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:10pt; font-family:Verdana" bordercolor="#111111" width="100%" id="AutoNumber11">
  <tr>
    <td width="3%" align="center" bgcolor="#C0C0C0">Cam</td>
  <td width="3%" align="center" bgcolor="#C0C0C0">Codigo Barras</td>
       <td width="3%" align="center" bgcolor="#C0C0C0">Vendidos</td>
    <td width="6%" align="center" bgcolor="#C0C0C0">Cantidad</td>
    <td width="31%" align="center" bgcolor="#C0C0C0">Nombre Producto</td>
    <td width="5%" align="center" bgcolor="#C0C0C0">Modelo</td>
    <td width="14%" align="center" bgcolor="#C0C0C0">Impuestos</td>
    <td width="8%" align="center" bgcolor="#C0C0C0">Precio (Ex)</td>
    <td width="11%" align="center" bgcolor="#C0C0C0">Precio (Inc)</td>
    <td width="11%" align="center" bgcolor="#C0C0C0">Total (Ex)</td>
    <td width="11%" align="center" bgcolor="#C0C0C0">Total(Inc)</td>
  </tr>
</table>




              <?php   $factura_orders_cambio_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
              $factura_orders_cambio = tep_db_fetch_array($factura_orders_cambio_values); ?>





                       <?php

     $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . tep_db_input($oID) . "'");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {



 $factura_shipping_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . tep_db_input($oID) . "' and class =  '" . 'ot_shipping' . "'");
              $factura_shipping = tep_db_fetch_array($factura_shipping_values);

 $factura_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . tep_db_input($oID) . "' and class =  '" . 'ot_total' . "'");
              $factura_total = tep_db_fetch_array($factura_total_values);


 $factura_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . tep_db_input($oID) . "' and class =  '" . 'ot_subtotal' . "'");
              $factura_subtotal = tep_db_fetch_array($factura_subtotal_values);


                $factura_orders_cambio_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
              $factura_orders_cambio = tep_db_fetch_array($factura_orders_cambio_values);
              



      $mas_history_raw = "select sum(products_quantity) as count from " . TABLE_ORDERS . "  o, " . TABLE_ORDERS_PRODUCTS . " op  where   o.orders_id = op.orders_id and o.orders_status = '" . $cobrado . "' and op.products_id = '" . $factura_products['products_id'] . "'";
    $mas_query=tep_db_query($mas_history_raw);
    $mas = tep_db_fetch_array($mas_query);



     
        $orders_id = tep_db_input($oID);


    ?>






<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family:Verdana; font-size:8pt" bordercolor="#111111" width="100%" id="AutoNumber10">
  <tr>











    <form method='post' action='cambios_actualizar.php?orders_id=<?php echo tep_db_input($oID); ?>'><tr>

  <td> <input type="checkbox"" name="products_id" value="<?php echo $factura_products['products_id']; ?>">


     <td align="center"> <?php echo      $mas['count'];?>



     <td align="center"> <?php echo $factura_products['products_quantity'];?>

             <td width="31%"><?php

              $factura_productos_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $factura_products['products_id'] . "'");
            if  ($factura_productos = tep_db_fetch_array($factura_productos_values)){
              echo    $factura_productos['products_name'];
        }else{
          ?>

         <font color="#FF0000"><?php echo $factura_products['products_name']; ?></font>

      <?php
    }

             echo ' - ' . $factura_products['products_id'];


       ?></td> <td width="5%">
  <p align="left"><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $factura_products['products_id']) . '\')">'; ?>Stock</a></font></td></td>
  <td width="6%">
  
  <p align="left"><?php echo $factura_products['products_model'] ?></td>
  <td width="6%">



  <p align="right"><?php echo $factura_products['products_tax'] ?>%</td>
  <td width="11%" align="right">
  <p align="right"><?php echo $currencies->format($factura_products['products_price'], true, $order->info['currency'], $order->info['currency_value']) ?></td>
  <td width="11%" align="right"><?php echo $currencies->format($factura_products['final_price'] , true, $order->info['currency'], $order->info['currency_value']) ?></td>
  <td width="11%" align="right"><?php echo $currencies->format($factura_products['products_price'] *  $factura_products['products_quantity'], true, $order->info['currency'], $order->info['currency_value'])?></td>
  <td width="11%" align="right"><?php echo $currencies->format($factura_products['final_price'] *  $factura_products['products_quantity'], true, $order->info['currency'], $order->info['currency_value'])?></td>
  </tr>
</table>



 <?php   } ?>




  <?php

 $factura_orders_cambios_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
                      $factura_orders_cambios = tep_db_fetch_array($factura_orders_cambios_values);
    ?>
       <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber12">
  <tr>

    <td width="14%">

<td> </td></tr>


 <font face="Verdana" size="1">Nº Productos:</font><input type=text name='products_quantity' size="2" value=''>
<input type=submit value='Insertar Abono'></form>





</td>
    <td width="86%">&nbsp;



  <?php if ($factura_orders_cambios['orders_cambios'] == 4) {     ?>














      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-size:10pt; font-family:Verdana" bordercolor="#111111" width="100%" id="AutoNumber11">
  <tr>
    <td width="3%" align="center" bgcolor="#C0C0C0">Cam</td>
    <td width="3%" align="center" bgcolor="#C0C0C0">Vendidos</td>
    <td width="6%" align="center" bgcolor="#C0C0C0">Cantidad</td>
    <td width="31%" align="center" bgcolor="#C0C0C0">Nombre Producto</td>
    <td width="5%" align="center" bgcolor="#C0C0C0">Modelo</td>
    <td width="14%" align="center" bgcolor="#C0C0C0">Impuestos</td>
    <td width="8%" align="center" bgcolor="#C0C0C0">Precio (Ex)</td>
    <td width="11%" align="center" bgcolor="#C0C0C0">Precio (Inc)</td>
    <td width="11%" align="center" bgcolor="#C0C0C0">Total (Ex)</td>
    <td width="11%" align="center" bgcolor="#C0C0C0">Total(Inc)</td>
  </tr>
</table>





    <?php $factura_productss_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . tep_db_input($oID) . "' and orders_cambios =  '" . 4 . "'");
         while      ($factura_productss = tep_db_fetch_array($factura_productss_values)) {


 ?>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family:Verdana; font-size:8pt" bordercolor="#111111" width="100%" id="AutoNumber10">
  <tr>


<form  method='post' action='cambios_delete.php?orders_id=<?php echo tep_db_input($oID);  ?>'><tr>

  <td> <input type="checkbox"" name="products_id" value="<?php echo $factura_productss['products_id']; ?>">


  <td width="6%"><p align="center"><?php echo $factura_productss['orders_cambios_quantity'] ?></td>

  <td width="31%"><?php echo $factura_productss['products_name'] ?></td>
  <td width="5%">
  <p align="left"><?php echo $factura_productss['products_model'] ?></td>
  <td width="11%">
  <p align="right"><?php echo $factura_productss['products_tax'] ?>%</td>
  <td width="11%" align="right">
  <p align="right"><?php echo $currencies->format($factura_productss['products_price'], true, $order->info['currency'], $order->info['currency_value']) ?></td>
  <td width="11%" align="right"><?php echo $currencies->format($factura_productss['final_price'] , true, $order->info['currency'], $order->info['currency_value']) ?></td>
  <td width="11%" align="right"><?php echo $currencies->format($factura_productss['products_price'] *  $factura_productss['products_quantity'], true, $order->info['currency'], $order->info['currency_value'])?></td>
  <td width="11%" align="right"><?php echo $currencies->format($factura_productss['final_price'] *  $factura_productss['products_quantity'], true, $order->info['currency'], $order->info['currency_value'])?></td>
  </tr>


  </table>

            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber12">
  <tr>

    <td width="14%">

<td> </td></tr>



           <?php   }   ?>
           
           
               <input type=submit value='Eliminar un Producto'></form> </td>

      <form  method='post' action='cambios_delete_orders.php?orders_id=<?php echo tep_db_input($oID); ?>'><tr>



         <input type=submit value='Eliminar Abono'></form></td>

                 <?php
           
                      }


               ?>



<?php

    for ($i=0; $i<sizeof($order->totals); $i++) {

      echo '              <tr>' . "\n" .

           '                <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .

           '                <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .

           '              </tr>' . "\n";

    }







      $factura_insert_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . tep_db_input($oID) . "'");
               while   ( $factura_insert = tep_db_fetch_array($factura_insert_values)) {

                    $factura_insert_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
                      $factura_insert_orders = tep_db_fetch_array($factura_insert_orders_values);

?>








     <?php







                    }






              $certificado_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
              $certificado = tep_db_fetch_array($certificado_values);

     // $log_id .'-'. $order->info['orders_status'] . '-';

              $consulta1_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
              $consulta1 = tep_db_fetch_array($consulta1_values);
          //  $consulta1['code_admin'] . '-';


              $consulta2_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
              $consulta2 = tep_db_fetch_array($consulta2_values);
        //  $consulta2['orders_status'] . '-';

              $consulta3_values = tep_db_query("select * from " . 'orders_status' . " where orders_status_id = '" . $order->info['orders_status'] . "'");
              $consulta3 = tep_db_fetch_array($consulta3_values);
        //  $consulta3['tienda'] . '-';


  if ( $consulta3['tienda'] == $consulta1['code_admin']){


                      ?>


      </tr>
      <tr>
        <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
      
      <tr><?php echo tep_draw_form('status', FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('action')) . 'action=update_order'); ?>
        <td class="main"><?php echo tep_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
      </tr>
             <tr><td><?php

 if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}          //segurdidad
       $estatuspmw_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");
     $estatuspmw = tep_db_fetch_array($estatuspmw_values);

  if ($estatuspmw['orders_status'] == $abono and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $pagado and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $entregas_stock and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $retirarado and ACTIVACION_AEPR == 'false'){

}else{



                                 
 if ($login_id_remoto == 1){

              $log_id = $login_id;
       include("comment_bar.php");
}else if ($login_id_remoto == 14){
              $log_id = $login_id;
      include("comment_bar.php");
      
}else{
    include("comment_bar_tienda.php");
              
}

}
              ?></td></tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="2">
            
            
            
            <?php



                                       //  and  $login_groups_id <> 1
 // SOLO STATUS SELECCIONADOS SE EJECUTARÁ ESTA PARTE DEL CODIG




//if (ACTIVACION_AEPR == 'false'){



 if ($estatuspmw['orders_status'] == $abono or $estatuspmw['orders_status'] == $pagado or $estatuspmw['orders_status'] == $entregas_stock or $estatuspmw['orders_status'] == $retirarado){

           if (ACTIVACION_AEPR == 'true'){
                    ?>
       
             <tr>
                <td class="main"><b><?php echo ENTRY_STATUS; ?>
                
                
                <?php



                 
                    ?>
                </b> <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', true); ?></td>
                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo tep_draw_checkbox_field('notify_comments', '', true); ?></td> </tr>
               <td class="smallText" align="right"><?php echo 'Nº de Certificado:' . ' ' . tep_draw_input_field('certificado', $certificado['certificado'], 'size="20"'); ?></td>
               <td class="smallText" align="right"><?php echo 'Fecha de Reclamación:' . ' ' . tep_draw_input_field('f_reclamacion', $certificado['f_reclamacion'], 'size="20"'); ?></td>
               <td class="smallText" align="right"><?php echo 'Nº de Reclamación:' . ' ' . tep_draw_input_field('n_reclamacion', $certificado['n_reclamacion'], 'size="20"'); ?></td>



<p style="margin-top: 0; margin-bottom: 0">Devoluciones de Dinero de Pago por Transferencias</p>
<p style="margin-top: 0; margin-bottom: 0">Cuenta <input type="text" name="T1" size="20">
Titular <input type="text" name="T2" size="20"> Observaciones
<input type="text" name="T3" size="20"></p>



          </tr>
            </table></td>
            <td valign="top"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
          </tr>
        </table></td>
      </form></tr>
      <tr>

       
        <?php
       
        }
        
        
   }else{



                 ?>
              <tr>
                <td class="main"><b><?php echo ENTRY_STATUS; ?>
                </b> <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', true); ?></td>
                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo tep_draw_checkbox_field('notify_comments', '', true); ?></td> </tr>
               <td class="smallText" align="right"><?php echo 'Nº de Certificado:' . ' ' . tep_draw_input_field('certificado', $certificado['certificado'], 'size="20"'); ?></td>
               <td class="smallText" align="right"><?php echo 'Fecha de Reclamación:' . ' ' . tep_draw_input_field('f_reclamacion', $certificado['f_reclamacion'], 'size="20"'); ?></td>
               <td class="smallText" align="right"><?php echo 'Nº de Reclamación:' . ' ' . tep_draw_input_field('n_reclamacion', $certificado['n_reclamacion'], 'size="20"'); ?></td>




          </tr>
            </table></td>
            <td valign="top"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
          </tr>
        </table></td>

	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>

<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td>

<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">Devoluciones de Dinero de Pago por Transferencias</font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana"><b>
Cuenta </b> <?php echo tep_draw_input_field('orders_cuenta_dev', $certificado['orders_cuenta_dev'], 'size="30"'); ?><b>
Titular </b><?php echo tep_draw_input_field('orders_titular_dev', $certificado['orders_titular_dev'], 'size="40"'); ?><b>
Observaciones </b><?php echo tep_draw_input_field('orders_observaciones_dev', $certificado['orders_observaciones_dev'], 'size="30"'); ?> <b>
Fecha </b><?php echo tep_draw_input_field('orders_fecha_dev', $certificado['orders_fecha_dev'], 'size="30"'); ?>






</font></p></td>



  		</tr>
	</table>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
          </form></tr>
      <tr>
      
      
      
     <?php

    }
    
}
        ?>

<?php echo  '<td colspan="2" align="right"><a href="' . tep_href_link(FILENAME_CUSTOMER_EXPORT, 'id=' . $_GET['oID']) . '">' . tep_image_button('button_export.gif', IMAGE_ORDERS_INVOICE) . '</a></td>';

 ?>

      </tr>
       <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
            <? if($CommentsWithStatus) { ?>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
            <? } ?>
          </tr>
<?php
    $orders_history_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . tep_db_input($oID) . "' order by date_added");
    if (tep_db_num_rows($orders_history_query)) {
      while ($orders_history = tep_db_fetch_array($orders_history_query)) {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" align="center">' . tep_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
             '            <td class="smallText" align="center">';
        if ($orders_history['customer_notified'] == '1') {
          echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
        } else {
          echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
        }
        echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n";

        if($CommentsWithStatus) {
        echo '            <td class="smallText">' . nl2br(tep_db_output($orders_history['comments'])) . '&nbsp;</td>' . "\n";
        }

        echo '          </tr>' . "\n";
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      
      
      
      
      
      
      
       <script language="JavaScript">

function checkdatosmultiples() {
 x = document.form1;
 email = x.ecorreo.value;
 var comentario="";
   var longi=0;
   var i=0;
   var vacio=false;
   var cadena="";
   var cCadenaNros="";
   var caracter="";
    var caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-.";
    var i;
    var valido = true;
    var pos_arroba = email.indexOf("@");
    var pos_ultimo_punto = email.lastIndexOf(".");
    var email_minus = email.toLowerCase();
    var trozo;

    if (pos_arroba == -1) {
		alert("Por favor indique la dirección de correo electrónico correcta.")
        return false;
    }
    if (email_minus.indexOf("usuario@servidor.es") != -1){
		alert("Por favor indique la dirección de correo electrónico correcta.")
        return false;
    }

    if (pos_ultimo_punto == -1) {
		alert("Por favor indique la dirección de correo electrónico correcta.")
        return false;
    }

    if (email_minus.indexOf("@.") != -1){
		alert("Por favor indique la dirección de correo electrónico correcta.")
        return false;
    }

    trozo = email.substring(0, pos_arroba);
    for(i=0;i<trozo.length;i++) {
        if (caracteres.indexOf(trozo.charAt(i)) == -1) {
			valido = false;
	        break;
        }
    }

    if (!valido) {
		alert("Por favor indique la dirección de correo electrónico correcta.")
        return false;
    }

    valido = true;
    trozo = email.substring(1+pos_arroba, pos_ultimo_punto);

    for(i=0;i<trozo.length;i++) {
        if (caracteres.indexOf(trozo.charAt(i)) == -1) {
            valido = false;
            break;
        }
    }
    if (!valido) {
		alert("Por favor indique la dirección de correo electrónico correcta.")
        return false;
    }

    valido = true;
    trozo = email.substring(1+pos_ultimo_punto, email.length);

    if ((trozo.length >= 2)&&(trozo.length <= 6)) {
        for(i=0;i<trozo.length;i++) {
            if (caracteres.indexOf(trozo.charAt(i)) == -1) {
                valido = false;
                break;
            }
        }
        if (!valido) {
			alert("Por favor indique la dirección de correo electrónico correcta.")
            return false;
        }
    } else {
		alert("Por favor indique la dirección de correo electrónico correcta.")
        return false;
    }

//******************************
var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ" + "abcdefghijklmnñopqrstuvwxyz" + "1234567890";
var checkStr = x.numeros.value;
var allValid = true;
for (i = 0; i < checkStr.length; i++) {
	ch = checkStr.charAt(i);
	for (j = 0; j < checkOK.length; j++){
		if (ch == checkOK.charAt(j)){
			break
		}
		if  (checkStr.charCodeAt(i) == 13){
			break
		}
		if  (checkStr.charCodeAt(i) == 10){
			break
		}
		if (j == checkOK.length-1) {
			allValid = false
			break
		}
	}

if (!allValid) {
	alert("Por favor, introduzca un código por línea, hasta un máximo de 10, pulsando enter después de cada código")
	x.numeros.focus()
	break
	}
}

return allValid;
}



function checkdatosunitarios() {
 x = document.form1

 if (x.numero.value==""){
  alert("Por favor escriba el código que desee consultar.")
  x.numero.focus()
 return false;
 }
 return true;
}


function enviarPagina(){


	document.form1.submit()
}

function valoraccionUno(){
	document.form1.accion.value='LocalizaUno'
}
function valoraccionVarios(){
	document.form1.accion.value='LocalizaVarios'
}

    </script>

    <div class="txtNormal" style="WIDTH: 427px">
      <form name="form1"  target="I1" action="http://www.correos.es/comun/localizador/track.asp?numero=<?php echo $certificado['certificado'] ?>" method="post">
        <input type="hidden" value="LocalizaUno" name="accion">
        <table cellSpacing="0" cellPadding="0" width="400" border="0" height="27">
          <tr>
            <td class="txtDest" align="middle" height="27">
            <table cellSpacing="0" cellPadding="0" width="400" border="0">
              <tr vAlign="top">
                <td class="txtNormal" width="150"><b>Código de envío: </b></td>
                <td width="150"><label for="codigo">&nbsp;<input class="FormObject" id="ver_info" style="WIDTH: 140px" accessKey="c" tabIndex="1" maxLength="23" size="23" value="<?php echo $certificado['certificado'] ?>" name="numero"></label>
                </td>
                <td align="middle" width="100">&nbsp;<input class="botonSt" id="button1" onclick="javascript:if(checkdatosunitarios()) {valoraccionUno();enviarPagina();}" type="button" value="Consultar" name="button1">

        <!-- <textarea name="" cols="" rows="" dir="rtl" lang="es"></textarea> -->
      </form>
    </div>
    </td>

      
   <p>&nbsp;</p>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="100%">
    <p align="center">
    <iframe name="I1" width="682" height="383" src="blanco.php">
    El explorador no admite los marcos flotantes o no está configurado actualmente para mostrarlos.
    </iframe></td>
  </tr>
      
      
      
      
      
<?php
  } else {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">

            </form></tr>
              <tr><?php echo tep_draw_form('orders', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo 'Editar' . ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit') . tep_draw_hidden_field('value_edita', 'ok') . tep_draw_hidden_field('vp', 'ok'); ?></td>
             </form></tr>



               <tr><?php echo tep_draw_form('orders', 'edit_orders_tienda.php', '', 'get'); ?>
                <td class="smallText" align="right"><?php echo 'Actualizar'. ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit'); ?></td>
             </form></tr>



                   <tr><?php echo tep_draw_form('keywoards', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
             <td class="smallText" align="right"><?php echo 'Datos de Cliente' . ' ' . tep_draw_input_field('keywoards', '', 'size="12"'); ?></td>
   </form></tr>


               <?php
                   $keywoards_n = $_GET['keywoards'];

               if ($keywoards_n){ ?>

                    <tr><?php echo tep_draw_form('status_keywoards', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . tep_draw_input_field('keywoards', '', 'size="12"') . tep_draw_pull_down_menu('status_keywoards', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $oorders_statuses), '', 'onChange="this.form.submit();"'); ?></td>
              </form></tr>

      <?php
                   }else{
                         ?>





                <?php
             }
                  ?>





                   <tr><?php echo tep_draw_form('products_keywoards', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
             <td class="smallText" align="right"><?php echo 'Buscar por Producto: ' . ' ' . tep_draw_input_field('products_keywoards', '', 'size="12"'); ?></td>
   </form></tr>




                </td>
                </form></tr>
               <?php
                   $products_keywoards = $_GET['products_keywoards'];

               if ($products_keywoards){ ?>
               
                    <tr><?php echo tep_draw_form('status_keywoards', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . tep_draw_input_field('products_keywoards', '', 'size="12"') . tep_draw_pull_down_menu('status_keywoards', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $oorders_statuses), '', 'onChange="this.form.submit();"'); ?></td>
              </form></tr>

      <?php
                   }else{
                         ?>

                
                             <tr><?php echo tep_draw_form('status', FILENAME_ORDERS_TIENDA, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . tep_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $oorders_statuses), '', 'onChange="this.form.submit();"'); ?></td>
              </form></tr>


                
                <?php
             }
                  ?>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
<!-- Start Batch Update Status v0.2 -->
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
<?php
echo tep_draw_form('UpdateStatus', FILENAME_ORDERS_TIENDA,tep_get_all_get_params()); ?>
<script language="javascript">
function checkAll(){
  var el = document.getElementsByName('update_oID[]')
  for(i=0;i<el.length;i++){
    el[i].checked = true;
  }
}
function uncheckAll(){
  var el = document.getElementsByName('update_oID[]')
  for(i=0;i<el.length;i++){
    el[i].checked = false;
  }
}

</script>

         <div align="center">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
<td></td>
                <td class="dataTableHeadingContent"><?php echo 'Certf'; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo 'Factura'; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo 'Atencion'; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo 'Monetario'; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                 <td class="dataTableHeadingContent" align="center"><?php echo 'Creado'; ?></td>
                 <td class="dataTableHeadingContent" align="center"><?php echo 'Actualizado'; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

    $keywoards =  $_GET['keywoards'];

    if (isset($_GET['cID'])) {
      $cID = tep_db_prepare_input($_GET['cID']);
      $orders_query_raw = "select o.orders_id, o.admin_level_usuario, o.certificado, o.orders_status, o.orders_medas, orders_cambio_dev, o.customers_name, o.proveedor_id, o.delivery_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_PRODUCTS . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$cID . "' or o.delivery_state like '%" . tep_db_input($keywoards) . "%' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' group by o.orders_id order by orders_id DESC";
    } elseif (isset($_GET['status_produc'])) {


  $produc_values = tep_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $produc . "'");
  $produc = tep_db_fetch_array($produc_values);


      $status = tep_db_prepare_input($_GET['status_produc']);
      $orders_query_raw = "select o.orders_id, o.admin_level_usuario, o.customers_name, o.certificado, o.orders_medas, orders_cambio_dev,
                         o.payment_method, o.factura_id, o.delivery_name, o.date_purchased,
                         o.last_modified, o.currency, o.currency_value,
                         s.orders_status_name, ot.text as order_total
                         from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s, " . TABLE_ORDERS_PRODUCTS . " op where
                         o.orders_status = s.orders_status_id
                         and o.orders_id = op.orders_id
                         and s.language_id = '" . (int)$languages_id . "'
                         and s.orders_status_id = '" . (int)$status . "'
                         and op.products_name like '%" . $produc['products_name'] . "%'
                     and ot.class = 'ot_total' order by o.orders_id DESC";
                     
    } elseif (isset($_GET['status'])) {
      $status = tep_db_prepare_input($_GET['status']);
      $orders_query_raw = "select o.orders_id, o.factura_id, o.admin_level_usuario, o.delivery_name, o.certificado, o.orders_medas, orders_cambio_dev, o.proveedor_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.orders_status_id = '" . (int)$status . "' and ot.class = 'ot_total' group by o.orders_id order by o.last_modified DESC";

 } elseif  (isset($_GET['status_keywoards']) and isset($_GET['keywoards'])){
   $orders_query_raw = "select o.orders_status, o.factura_id, o.admin_level_usuario, o.certificado, o.orders_medas, orders_cambio_dev, o.orders_id,o.proveedor_id, o.customers_telephone, o.delivery_name, o.billing_name, o.delivery_name, o.customers_email_address, o.customers_state, o.customers_postcode, o.customers_name, o.customers_id, o.customers_city, o.customers_street_address, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_STATUS . " s on o.orders_status = s.orders_status_id where
                     o.customers_name like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.delivery_name like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.orders_id like '%" . tep_db_input($keywoards) . "%'   and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.orders_status like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.delivery_state like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_state like '%" . tep_db_input($keywoards) . "%'  and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.certificado like '%" . tep_db_input($keywoards) . "%'and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_street_address like '%" . tep_db_input($keywoards) . "%'  and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_id like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_city like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_postcode like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_state like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_telephone like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.customers_email_address like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.delivery_name like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.billing_name like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "'
                     or o.currency_value like '%" . tep_db_input($keywoards) . "%' and o.orders_status = '" . $_GET['status_keywoards'] . "' group by o.orders_id order by o.last_modified DESC";


                     
 } elseif (isset($_GET['keywoards'])){

   $orders_query_raw = "select o.orders_status, o.factura_id, o.admin_level_usuario, o.certificado, o.orders_medas, orders_cambio_dev, o.orders_id,o.proveedor_id, o.customers_telephone, o.delivery_name, o.billing_name, o.delivery_name, o.customers_email_address, o.customers_state, o.customers_postcode, o.customers_name, o.customers_id, o.customers_city, o.customers_street_address, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_STATUS . " s on o.orders_status = s.orders_status_id where
                     o.customers_name like '%" . tep_db_input($keywoards) . "%'
                     or o.delivery_name like '%" . tep_db_input($keywoards) . "%'
                     or o.orders_id like '%" . tep_db_input($keywoards) . "%'
                     or o.orders_status like '%" . tep_db_input($keywoards) . "%'
                     or o.delivery_state like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_state like '%" . tep_db_input($keywoards) . "%'
                     or o.certificado like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_street_address like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_id like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_city like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_postcode like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_state like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_telephone like '%" . tep_db_input($keywoards) . "%'
                     or o.customers_email_address like '%" . tep_db_input($keywoards) . "%'
                     or o.delivery_name like '%" . tep_db_input($keywoards) . "%'
                     or o.billing_name like '%" . tep_db_input($keywoards) . "%'
                     or o.currency_value like '%" . tep_db_input($keywoards) . "%' group by o.orders_id order by o.last_modified DESC";
                     




 } elseif (isset($_GET['status_keywoards']) and isset($_GET['products_keywoards'])){

   $orders_query_raw = "select * from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p, " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_STATUS . " s on o.orders_status = s.orders_status_id where
                     op.products_name like '%" . tep_db_input($_GET['products_keywoards']) . "%' and o.orders_id = op.orders_id and o.orders_status = '" . $_GET['status_keywoards'] . "' and p.products_id = op.products_id  or
                     op.products_model like '%" . tep_db_input($_GET['products_keywoards']) . "%' and o.orders_id = op.orders_id and o.orders_status = '" . $_GET['status_keywoards'] . "' and p.products_id = op.products_id
                     group by o.orders_id order by o.last_modified DESC";

 } elseif (isset($_GET['products_keywoards'])){

   $orders_query_raw = "select * from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p, " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_STATUS . " s on o.orders_status = s.orders_status_id where
                     op.products_name like '%" . tep_db_input($_GET['products_keywoards']) . "%'
                     and o.orders_id = op.orders_id and p.products_id = op.products_id  or op.products_model like '%" . tep_db_input($_GET['products_keywoards']) . "%'
                     and o.orders_id = op.orders_id and p.products_id = op.products_id     group by o.orders_id order by o.last_modified DESC";



} else{
   $orders_query_raw = "select o.orders_id, o.factura_id, o.admin_level_usuario, o.orders_status, o.certificado, o.orders_medas, orders_cambio_dev, o.customers_name, o.proveedor_id, o.delivery_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' and s.tienda = '" . $code_admin . "' and o.orders_status <> '" . 7 . "'  group by o.orders_id order by o.orders_id DESC";


}

    $orders_split = new splitPageResults($_GET['page'], 100, $orders_query_raw, $orders_query_numrows);
    $orders_query = tep_db_query($orders_query_raw);
    while ($orders = tep_db_fetch_array($orders_query)) {
    if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $orders['orders_id']))) && !isset($oInfo)) {
        $oInfo = new objectInfo($orders);
      }



 $proveedor_k_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $orders['proveedor_id'] . "'");
 $proveedor_k = tep_db_fetch_array($proveedor_k_values);
  if ($proveedor_k['proveedor_name']){
  $separador = ' / ';
}

                     // seguridad
  $estatuspmw_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $orders['orders_id'] . "'");
  $estatuspmw = tep_db_fetch_array($estatuspmw_values);


// Start Batch Update Status v0.2
      if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >' . "\n";
        $onclick = 'onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '\'"';
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >' . "\n";
        $onclick = 'onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '\'"';
      }
      

            

            $precio_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $orders['orders_id'] . "' and class = '" . 'ot_total' . "'");
      $precio = tep_db_fetch_array($precio_values);

  $yergfcvs_values = tep_db_query("select * from " . 'admin_supervisores' . " where admin_id = '" . $login_id . "'");
 $yergfcvs = tep_db_fetch_array($yergfcvs_values);

?>

                               <td class="dataTableContent"> <p><p><a  target="_blank" href="<?php echo 'correos.php' . '?certificado=' . $orders['certificado']; ?>">
                                <?php echo $orders['certificado']; ?>
                <?php  if ($login_id == $yergfcvs['admin_id']){

                 if ($estatuspmw['orders_status'] == $abono and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $pagado and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $entregas_stock and ACTIVACION_AEPR == 'false' or $estatuspmw['orders_status'] == $retirarado and ACTIVACION_AEPR == 'false'){

                          ?>



                </a></p></td>  <td class="dataTableContent">Block</td>
                         <?php
                 }else{



     // $log_id .'-'. $order->info['orders_status'] . '-';

              $consulta1_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
              $consulta1 = tep_db_fetch_array($consulta1_values);
       //   echo  $consulta1['code_admin'] . '-';


              $consulta2_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
              $consulta2 = tep_db_fetch_array($consulta2_values);
      //  echo  $consulta2['orders_status'] . '-';

              $consulta3_values = tep_db_query("select * from " . 'orders_status' . " where orders_status_id = '" . $estatuspmw['orders_status'] . "'");
              $consulta3 = tep_db_fetch_array($consulta3_values);
       // echo  $consulta3['tienda'] . '-';


  if ( $consulta3['tienda'] == $consulta1['code_admin']){



                    ?>
                    
                    
                    
                </a></p></td>  <td class="dataTableContent"><input type="checkbox" name="update_oID[]" value="<?php echo $orders['orders_id'];?>"></td>
                         <?php
                 }else{
                     ?>
                        </a></p></td>  <td class="dataTableContent">Block</td>
                  <?php
             }
                         
                }

                       }

                            ?>

                <td class="dataTableContent" <?php echo $onclick; ?>><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $orders['customers_name'] . ' ' . $proveedor_k['proveedor_name']; ?>

                   <?php

              //admin level cierra el acceso al cambio de pricio y al borrado del producto.
       if ($login_groups_id == 9){

      $sql_status_update_array = array('admin_level_price' => 1,
                                       'admin_level_borrar' => 1);
            tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', " orders_id = '" . $orders['orders_id'] . "'");

   }

         // fin admin level



                      ?>
               <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo  $orders['factura_id']; ?></td>
                  <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo 'Atcion: ' . $orders['admin_level_usuario'] ; ?></td>

                    <?php

                     if  ($orders['orders_medas'] == 'tarjeta'){

                                        ?>

             <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo 'Pago con ' . $orders['orders_medas'] ; ?></td>

   <?php








                 }else if ($orders['orders_medas']){

                   ?>

                   <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo 'Cambio: ' . $orders['orders_medas'] . 'Eur. Dev: ' . $orders['orders_cambio_dev'] .'Eur.' ; ?></td>



              <?php

             }else{

               ?>

               <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo '' ; ?></td>


              <?php



         }



 if  ($_GET['products_keywoards']){
  $consulta_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id =  '"  . $orders['orders_id'] . "' and products_model like '%" . tep_db_input($_GET['products_keywoards']) . "%' or orders_id =  '"  . $orders['orders_id'] . "' and products_name like '%" . tep_db_input($_GET['products_keywoards']) . "%'");
 while ($consulta = tep_db_fetch_array($consulta_values)){

              ?>


                  <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo '<p style="margin-top: 0; margin-bottom: 0"><b><font color="#FF0000">'.  $consulta['products_quantity']. ' - ' .$consulta['products_name'].'</font></b></p>' ?></td>
              <?php
       //  echo '<p style="margin-top: 0; margin-bottom: 0"><b><font color="#FF0000">'.  $consulta['products_quantity']. ' - ' .$consulta['products_name'].'</font></b></p>';

     }

}
                ?></td>
                <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo $precio['text']; ?></td>
                <td class="dataTableContent" align="center" <?php echo $onclick; ?>><?php echo tep_datetime_short($orders['date_purchased']); ?></td>
                <td class="dataTableContent" align="center" <?php echo $onclick; ?>><?php echo tep_datetime_short($orders['last_modified']); ?></td>
                <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php echo $orders['orders_status_name']; ?></td>
                <td class="dataTableContent" align="right" <?php echo $onclick; ?>><?php if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
<?php

if ($login_id == $yergfcvs['admin_id']){

echo '<tr class="dataTableContent"><td colspan="4">' . BUS_HEADING_TITLE . ': ' . tep_draw_pull_down_menu('new_status', array_merge(array(array('id' => '', 'text' => BUS_TEXT_NEW_STATUS)), $orders_statuses), '', '');
echo '</td><td colspan="2">' . tep_draw_checkbox_field('notify','1',true) . ' ' . BUS_NOTIFY_CUSTOMERS . '</td></tr>';
echo '<tr class="dataTableContent" align="center"><td colspan="6" nobr="nobr">' .
     tep_draw_input_field('select_all',BUS_SELECT_ALL,'onclick="checkAll(); return false;"','','submit') .
     tep_draw_input_field('select_none',BUS_SELECT_NONE,'onclick="uncheckAll(); return false;"','','submit') .
     tep_draw_input_field('submit',BUS_SUBMIT,'','','submit') . '</td></tr>';
echo '<tr><td colspan="6">' . tep_black_line() . '</td></tr>';
         }

     $suma_status_raw = "select sum(ot.value) as value, count(*) as count from " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS . " o where o.orders_id = ot.orders_id and ot.class ='" . 'ot_total' . "' and o.orders_status ='" . $_GET['status'] . "'";
    $suma_status_query = tep_db_query($suma_status_raw);
    $suma_status= tep_db_fetch_array($suma_status_query);



?>



              <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                    <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('page', 'oID', 'action'))) . number_format($suma_status['value'], 2, '.', '').'€'; ?></td>
                  </tr>
                </table>
               </td>
              </tr>
            </table>
            </td>
<?php // End Batch Update Status v0.1?>









<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDER . '</b>');

      $contents = array('form' => tep_draw_form('orders', FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br><br><b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');
      $contents[] = array('text' => '<br>' . tep_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<b>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . tep_datetime_short($oInfo->date_purchased) . '</b>');

     $contents[] = array('align' => 'center', 'text' => tep_draw_button('Editar', 'document', tep_href_link(FILENAME_ORDERS_TIENDA, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit')) . tep_draw_button('Actualizar', 'document', tep_href_link(FILENAME_EDIT_ORDERS_TIENDA, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit')));


     $contents[] = array('align' => 'center', 'text' => tep_draw_button('Etiquetas', 'document', DIR_WS_CATALOG.'barcode.php?oID=' . $oInfo->orders_id ));
     $contents[] = array('align' => 'center', 'ui-widget2', 'text' => tep_draw_button('Cerrar Caja', 'document', DIR_WS_CATALOG.'admin/invoice_procesando_tienda.php?invoice_status=37'));
     $contents[] = array('align' => 'center', 'ui-widget2', 'text' => tep_draw_button('Print Albaranes', 'document', 'invoice_selec_albaran.php?'.$_SERVER['QUERY_STRING']));
     $contents[] = array('align' => 'center', 'ui-widget2', 'text' => tep_draw_button('Print Facturas', 'document', 'invoice_selec_facturas.php?'.$_SERVER['QUERY_STRING']));



     $contents[] = array('text' => '<br>' . TEXT_DATE_ORDER_CREATED . ' ' . tep_date_short($oInfo->date_purchased));

               if (tep_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . tep_date_short($oInfo->last_modified));
        $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENT_METHOD . ' '  . $oInfo->payment_method);
      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
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
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
