<?php



              $stock_nivel_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $products_id_stock . "'");
             $stock_nivel= tep_db_fetch_array($stock_nivel_values);
             $stock_nivel2_values = tep_db_query("select * from " . 'products_stock' . " where products_id = '" . $products_id_stock . "'");
             $stock_nivel2= tep_db_fetch_array($stock_nivel2_values);




               $products_price_stock = $stock_nivel['products_price'];
               $time_mercancia_entregado_procesando = $stock_nivel['time_mercancia_entregado_procesando'];
               $codigo_proveedor_stock = $stock_nivel['codigo_proveedor'];
               $products_status_stock = $stock_nivel['products_status'];
               $products_model_stock  =  $stock_nivel['products_model'];











                       // SI EL PRODUCTO LO TENEMOS EN STOCK NO MODIFICA NI EL STATUS NI EL PRECIO
     $orders_values = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p, " . 'administrators' . " a, " . TABLE_ORDERS_PRODUCTS . " op where p.stock_nivel <> 6 and o.orders_id = op.orders_id and op.products_id = '" . $products_id_stock . "' and p.products_id = '" . $products_id_stock . "' and o.orders_status = a.abono");
   if ($vvvorders = tep_db_fetch_array($orders_values)){

     $texto_stock = '<p style="margin-top: 0; margin-bottom: 0"><a target="_blank"><img border="0" src="images/otros/stock-100.jpg"></p>';
    ?>


   <?php


 // Dependiendo del número de stock nos dira la disponibilidad del producto.
}else{






 if ($stock_nivel['stock_nivel'] == 1){
     $texto_stock = ' </p> <p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/pdisponible.png"> '. ' STOCK ';


}

if ($stock_nivel['stock_nivel'] == 2){
      $texto_stock = ' <p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/pdisponible.png"> Cita Previa';


   }


if ($stock_nivel['stock_nivel'] == 3){
      $texto_stock = ' <p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/pdisponible.png"> Bajo pedido';


   }
if ($stock_nivel['stock_nivel'] == 4){
       $texto_stock = ' </p> <p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/pdisponible.png"> '. ' Consultar';


   }



if ($stock_nivel['stock_nivel'] == 5){
      $texto_stock = '<p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/stock_17_02.jpg"> </p>';


   }

   // productos euroconsolas
if ($stock_nivel['stock_nivel'] == 6){


                                 $time =  time();//+ 1000000;
                                                                               

                                                                                   




                       if ($act_stock_siempre){

           // si el producto no tiene tiempo este se actualiza por primera vez y si este es rabazado en 48horas también actualiza los productos con los datos de stock mas recientes.
         $proveedor_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $products_id_stock ."' and time_proveedores <= '" . $time ."'");
                                    }else{
          // si el producto no tiene tiempo este se actualiza por primera vez y si este es rabazado en 48horas también actualiza los productos con los datos de stock mas recientes.
         $proveedor_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $products_id_stock ."'");

     }
           if ($proveedor = tep_db_fetch_array($proveedor_values)){



   // $sumar_presupuestos_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $product_info['products_id'] . "'and o.orders_status =a.presupuestos and a.admin_groups_id=6";
   // $sumar_presupuestos_sales_query = tep_db_query($sumar_presupuestos_sales_raw);
   // $sumar_presupuestos= tep_db_fetch_array($sumar_presupuestos_sales_query);


    //$sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $product_info['products_id'] . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6";    and a.admin_id = 14
    //$sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    //$sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);


    $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);

    $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =139";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $prepago_procesando= tep_db_fetch_array($sumar_entregado_total_sales_query);

    $sumar_abono_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.abono_true and a.admin_groups_id=6";
    $sumar_abono_total_sales_query = tep_db_query($sumar_abono_total_sales_raw);
    $sumar_abono_total= tep_db_fetch_array($sumar_abono_total_sales_query);




    $sumar_mercancia_entregado_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.status_entregas and a.admin_groups_id=6";
    $sumar_mercancia_entregado_procesando_sales_query = tep_db_query($sumar_mercancia_entregado_procesando_sales_raw);
    $sumar_mercancia_entregado_procesando= tep_db_fetch_array($sumar_mercancia_entregado_procesando_sales_query);

    $sumar_retirado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.retirarado and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_retirado_sales_query = tep_db_query($sumar_retirado_sales_raw);
    $sumar_retirado= tep_db_fetch_array($sumar_retirado_sales_query);

    //$sumar_no_recogido_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $product_info['products_id'] . "'and o.orders_status =a.no_recogido and a.admin_groups_id=6";
    //$sumar_no_recogido_sales_query = tep_db_query($sumar_no_recogido_sales_raw);
    //$sumar_no_recogido= tep_db_fetch_array($sumar_no_recogido_sales_query);

    $sumar_pagado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.pagado and a.admin_groups_id=6";
    $sumar_pagado_total_sales_query = tep_db_query($sumar_pagado_total_sales_raw);
    $sumar_pagado_total= tep_db_fetch_array($sumar_pagado_total_sales_query);

    $sumar_cobrados_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.cobrado and a.admin_groups_id=6";
    $sumar_cobrados_total_sales_query = tep_db_query($sumar_cobrados_total_sales_raw);
    $sumar_cobrados_total= tep_db_fetch_array($sumar_cobrados_total_sales_query);

    $sumar_pagado_transferencia_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.pagado_transferencia and a.admin_groups_id=6";
    $sumar_pagado_transferencia_sales_query = tep_db_query($sumar_pagado_transferencia_sales_raw);
    $sumar_pagado_transferencia= tep_db_fetch_array($sumar_pagado_transferencia_sales_query);

    $sumar_paypal_enviado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.paypal_enviado and a.admin_groups_id=6";
    $sumar_paypal_enviado_sales_query = tep_db_query($sumar_paypal_enviado_sales_raw);
    $sumar_paypal_enviado= tep_db_fetch_array($sumar_paypal_enviado_sales_query);

    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);

    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.credito and a.admin_groups_id=6";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);

    $sumar_albaran_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.albaran and a.admin_groups_id=6";
    $sumar_albaran_sales_query = tep_db_query($sumar_albaran_sales_raw);
    $sumar_albaran= tep_db_fetch_array($sumar_albaran_sales_query);


    $sumar_albaran_cobrar_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.albaran_cobrar and a.admin_groups_id=6";
    $sumar_albaran_cobrar_sales_query = tep_db_query($sumar_albaran_cobrar_sales_raw);
    $sumar_albaran_cobrar= tep_db_fetch_array($sumar_albaran_cobrar_sales_query);


    $sumar_pagos_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =a.status_liquidacion and a.admin_groups_id=6";
    $sumar_pagos_procesando_sales_query = tep_db_query($sumar_pagos_procesando_sales_raw);
    $sumar_pagos_procesando= tep_db_fetch_array($sumar_pagos_procesando_sales_query);

    $entradas_os = $sumar_entregado_total['value']+$sumar_abono_total['value'];
    $salidas_os = $sumar_pagos_procesando['value'] + $sumar_credito['value'] + $sumar_albaran['value'] + $sumar_albaran_cobrar['value'] + $sumar_retirado['value'] + $sumar_cobrados_total['value'] + $sumar_pagado_total['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value']+$prepago_procesando['value'];



                      } // actualizar stock siempre























   $stock_disponible =  $entradas_os - $salidas_os;
   
   
 if (PERMISO_STOCK_PROPIO == 'true'){



                           if (PERMISO_STOCK_UNIDADES == 'true'){
                               }


                           if (PERMISO_STOCK_UNIDADES == 'true'){
         $pstock = $stock_nivel2['products_stock_real'] . ' Pcs.';
                                }

                        if (PERMISO_PENDIENTE_UNIDADES == 'true'){
        $ppendiente = ' Pendienteeeee: '.number_format($stock_nivel2['products_stock_pendiente'], 0, '.', '') . ' Pcs.';
        $ppendiente2 = '  </p> <p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/pagotado.png"> '. ' Pendiente: '.number_format($stock_nivel2['products_stock_pendiente'], 0, '.', '') . ' Pcs.';
                                     }


   if ($stock_nivel2['products_stock_real'] <= 0 ){



       // STOCK PRINCIPAL PROPIO.

  $texto_stock = '</p> <img border="0" src="images/otros/pagotado.png"> '. ' Stock: ' . $pstock . ' ' . $ppendiente;
}else{         // '<p>&nbsp;</p><img border="0" src="images/otros/pdisponible.png"> '. ' STOCK '.

  $texto_stock =  ' </p> <p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/pdisponible.png"> '. ' Stock ' . $pstock . $ppendiente;




}

 }






                 $almacen_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacen = '" . 1 . "'");
        if ($almacen = tep_db_fetch_array($almacen_values)){

             $texto_stock = '';


    }


                       if ($act_stock_siempre){

           // si el producto no tiene tiempo este se actualiza por primera vez y si este es rabazado en 48horas también actualiza los productos con los datos de stock mas recientes.
         $proveedor_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $products_id_stock ."' and time_proveedores <= '" . $time ."'");
                                    }else{
          // si el producto no tiene tiempo este se actualiza por primera vez y si este es rabazado en 48horas también actualiza los productos con los datos de stock mas recientes.
         $proveedor_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $products_id_stock ."'");

     }
           if ($proveedor = tep_db_fetch_array($proveedor_values)){



       $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

           $sql_data_array = array('time_proveedores' => time()+rand(1,130000),
                                   'time_entradasysalidas' => $stock_disponible,
                                   'products_balance_stock' => $stock_disponible * $products_price_stock,
                                   'time_ultimaactualizacion' => $oldday1,
                                   'time_pendiente_entrada_total' => $sumar_pendiente_entrada_total['value'],
                                   'time_mercancia_entregado_procesando' => $sumar_mercancia_entregado_procesando['value'],
                                   'time_entregado' => $sumar_entregado_total['value'],
                                   'time_paypal_enviado' => $sumar_paypal_enviado['value'],
                                   'time_pagado_transferencia' => $sumar_pagado_transferencia['value'],
                                   'time_no_recogido' => $sumar_no_recogido['value'],
                                   'time_cobrados' => $sumar_cobrados_total['value'],
                                   'time_pagado' => $sumar_pagado_total['value'],);

     tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $products_id_stock . "'");
     
     
     
        $products_stock_values = tep_db_query("select * from products_stock pd where products_id = '" . $products_id_stock . "'");
    if ($products_stock = tep_db_fetch_array($products_stock_values)){


             $sql_data_array = array('products_stock_pendiente' => $sumar_mercancia_entregado_procesando['value']-$sumar_pendiente_entrada_total['value'],
                                   'products_stock_ultimaactualizacion' => $oldday1,
                                  // 'products_stock_min' => $ayuda_producto['products_stock_min'],
                                   'products_stock_real' => $stock_disponible,);

     tep_db_perform('products_stock', $sql_data_array, 'update', "products_id = '" . $products_id_stock . "'");



}else{
            // products_stock_min = '" . $ayuda_producto['products_stock_min'] . "',


             $Query = "INSERT INTO " . 'products_stock' . " set
              products_id = '" . $products_id_stock . "',
              products_stock_ultimaactualizacion = '" . $oldday1 . "',
              products_stock_real = '" . $stock_disponible . "',
              products_stock_pendiente = '" . $sumar_mercancia_entregado_procesando['value'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();





}

     
     
     
     
     
     
     
     
     
     
     

               if (ACTIVO_STOCKN6 == 'True'){
    if   ($listing['time_entradasysalidas'] <= 0){

          $sql_status_update_array = array('products_status' => 0,);
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $products_id_stock . "'");

}else{

         $sql_status_update_array = array('products_status' => 1,);
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $products_id_stock . "'");

}

           ?>



         <script type="text/javascript">

       var pagina = '<? echo $PHP_SELF.$_SERVER['REQUEST_URI'];  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


      <?php
      
       } // ACTIVO_STOCKN6

      
        }



   }


  if ($products_status_stock  == 0){
      $texto_stock = '<p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/stock-agotado.jpg"> </p>';

 }
 
 
 
}


 
  ?>
