var saludo=""+
"<?php
if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');
  require('includes/configure.php');
   require(DIR_WS_FUNCTIONS . 'database.php');
  tep_db_connect() or die('Unable to connect to database server!');
  
  
  
   $products_id_stock = $_GET['products_id_stock'];
$almacen = $_GET['almacen'];













                                                                                                              //p.stock_nivel = 6 and
                $ayuda_producto_values = mysql_query("select * from products p, products_description pd where p.products_id = pd.products_id and p.products_id = '" . $products_id_stock . "' order by time_entradasysalidas ASC");
    if ($ayuda_producto = mysql_fetch_array($ayuda_producto_values)){

      $tr = $ayuda_producto['time_entradasysalidas']-$ayuda_producto['time_entradasysalidas']-$ayuda_producto['time_entradasysalidas'];





                                                                                                                                                                                                                                                                        // p.stock_nivel = 6 and p.products_id = pd.products_id and p.time_entradasysalidas <= '" . 0 . "' and  p.products_status = '" . 1 . "'
                                                                                                                                                                                        // and p.time_entradasysalidas <= '" . 0 . "'




                  $products_id = $products_id_stock;


    $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);

    $sumar_mercancia_entregado_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.status_entregas and a.admin_groups_id=6";
    $sumar_mercancia_entregado_procesando_sales_query = tep_db_query($sumar_mercancia_entregado_procesando_sales_raw);
    $sumar_mercancia_entregado_procesando= tep_db_fetch_array($sumar_mercancia_entregado_procesando_sales_query);

    $sumar_retirado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.retirarado and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_retirado_sales_query = tep_db_query($sumar_retirado_sales_raw);
    $sumar_retirado= tep_db_fetch_array($sumar_retirado_sales_query);

    $sumar_credito_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.credito and a.admin_groups_id=6";
    $sumar_credito_total_sales_query = tep_db_query($sumar_credito_total_sales_raw);
    $sumar_credito_total= tep_db_fetch_array($sumar_credito_total_sales_query);


    //$sumar_no_recogido_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $product_info['products_id'] . "'and o.orders_status =a.no_recogido and a.admin_groups_id=6";
    //$sumar_no_recogido_sales_query = tep_db_query($sumar_no_recogido_sales_raw);
    //$sumar_no_recogido= tep_db_fetch_array($sumar_no_recogido_sales_query);

    $sumar_pagado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.pagado and a.admin_groups_id=6";
    $sumar_pagado_total_sales_query = tep_db_query($sumar_pagado_total_sales_raw);
    $sumar_pagado_total= tep_db_fetch_array($sumar_pagado_total_sales_query);

    $sumar_cobrados_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.cobrado and a.admin_groups_id=6";
    $sumar_cobrados_total_sales_query = tep_db_query($sumar_cobrados_total_sales_raw);
    $sumar_cobrados_total= tep_db_fetch_array($sumar_cobrados_total_sales_query);

    $sumar_pagado_transferencia_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.pagado_transferencia and a.admin_groups_id=6";
    $sumar_pagado_transferencia_sales_query = tep_db_query($sumar_pagado_transferencia_sales_raw);
    $sumar_pagado_transferencia= tep_db_fetch_array($sumar_pagado_transferencia_sales_query);

    $sumar_paypal_enviado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.paypal_enviado and a.admin_groups_id=6";
    $sumar_paypal_enviado_sales_query = tep_db_query($sumar_paypal_enviado_sales_raw);
    $sumar_paypal_enviado= tep_db_fetch_array($sumar_paypal_enviado_sales_query);

    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);

    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.credito and a.admin_groups_id=6";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);
    
    $sumar_albaran_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.albaran and a.admin_groups_id=6";
    $sumar_albaran_sales_query = tep_db_query($sumar_albaran_sales_raw);
    $sumar_albaran= tep_db_fetch_array($sumar_albaran_sales_query);
    
    $sumar_albaran_cobrar_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.albaran_cobrar and a.admin_groups_id=6";
    $sumar_albaran_cobrar_sales_query = tep_db_query($sumar_albaran_cobrar_sales_raw);
    $sumar_albaran_cobrar= tep_db_fetch_array($sumar_albaran_cobrar_sales_query);

    $sumar_pagos_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.status_liquidacion and a.admin_groups_id=6";
    $sumar_pagos_procesando_sales_query = tep_db_query($sumar_pagos_procesando_sales_raw);
    $sumar_pagos_procesando= tep_db_fetch_array($sumar_pagos_procesando_sales_query);



    $entradas_os = $sumar_entregado_total['value'];
    $salidas_os = $sumar_pagos_procesando['value'] + $sumar_credito['value'] + $sumar_albaran['value'] + $sumar_albaran_cobrar['value'] + $sumar_retirado['value'] + $sumar_cobrados_total['value'] + $sumar_pagado_total['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value'];



   $resultado =  $entradas_os-$salidas_os;
     $pagado = $sumar_pagado_total['value'];






        $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

            // $sql_data_array = array('time_proveedores' => time()+rand(1,130000),
             //                     'time_mercancia_entregado_procesando' => $sumar_mercancia_entregado_procesando['value'],
               //                    'time_entradasysalidas' => $resultado,
                 //                  'time_ultimaactualizacion' => $oldday1,);

   //  tep_db_perform('products', $sql_data_array, 'update', "products_id = '" . $products_id_stock . "'");


        $products_stock_values = mysql_query("select * from products_stock pd where products_id = '" . $products_id_stock . "'");
    if ($products_stock = mysql_fetch_array($products_stock_values)){


             $sql_data_array = array('products_stock_pendiente' => $sumar_mercancia_entregado_procesando['value'],
                                   'products_stock_ultimaactualizacion' => $oldday1,
                                   //'products_stock_min' => $ayuda_producto['products_stock_min'],
                                   'products_stock_real' => $resultado,);

     tep_db_perform('products_stock', $sql_data_array, 'update', "products_id = '" . $products_id_stock . "'");



}else{



              //products_stock_min = '" . $ayuda_producto['products_stock_min'] . "',

             $Query = "INSERT INTO " . 'products_stock' . " set
              products_id = '" . $products_id_stock . "',
              products_stock_ultimaactualizacion = '" . $oldday1 . "',
             products_stock_real = '" . $resultado . "',
              products_stock_pendiente = '" . $sumar_mercancia_entregado_procesando['value'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();





}
                                                         //      echo $ayuda_producto['products_id'] . ' - ' . $resultado;



}  // fin actualizaciones













   $query = mysql_query("SELECT * FROM `products` WHERE  products_id='" . $products_id_stock . "'");
 $products = mysql_fetch_array($query);
   $query = mysql_query("SELECT * FROM `products_stock` WHERE  products_id='" . $products_id_stock . "'");
 $products_stock = mysql_fetch_array($query);


                 $ayuda_quanty_values = mysql_query("select * from orders where orders_status = '" . 75 . "' order by orders_id DESC");
    $ayuda_quanty = mysql_fetch_array($ayuda_quanty_values);






?>"+
 
"<?php
     //  if ($products['time_entradasysalidas'] <= 0){
                                                                                                                                                                                                      //$products['time_entradasysalidas']
echo  '<a target=_blank href='. 'edit_orders_tienda.php?action=edit&rr=&oID='.$ayuda_quanty['orders_id'] . '&codigobarras_negativos='.$products['products_model'] . '&unidades_negativos=' . $tr .'>'.$products_stock['products_stock_real'].'</a>';
      //                                      }else{

//echo $products['time_entradasysalidas'];

//}



?>"+

    

    
"<?php   ?></font>";

document.write(saludo);


