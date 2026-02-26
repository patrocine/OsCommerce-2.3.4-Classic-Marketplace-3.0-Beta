<?php
  require(DIR_MOBILE_CLASSES . 'split_page_results_ajax.php');
  $listing_split = new splitPageResultsAjax($listing_sql, 50, 'p.products_id');
  $listing_split->generateJS();
?>
<!-- products //-->
<div id="prodFrame">
<!--  ajax_results_begining -->
<?php
$num_of_columns = 3;
	$row = 0;
  	$col = 0;
    $listing_query = tep_db_query($listing_split->sql_query);
    while ($listing = tep_db_fetch_array($listing_query)) {
		if ($col >= $num_of_columns) {
			$col = 0;
			echo "<br />";
		} 
                                //tep_mobile_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id'])
    	$path = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'mobile_product_info.php?cPath=' . $cPath  . '&products_id='. $listing['products_id'] . '">';
     
     
     



               $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $listing['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){

 if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $listing['products_image'])) {

 $img = tep_image($ref_fabricante['proveedor_ruta_images'] . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

} else {

  $img = tep_image($ref_fabricante['proveedor_ruta_images'] . 'no-foto.jpg', $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);


 }

  }else{





   if (ereg("^http://", $listing['products_image']) ) {
    $img = tep_image('' . $listing['products_image'], $listing['products_name'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT);
}else{
    $img = tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT);

   }



   } // fin ref_fabricante




                    
     
     
     

     
     
     
     
     
     
     
     


   if (PERMISO_PORCENTAGE_PRECIO == 'True'){


             if ($listing['products_porcentage'] <= -0.1) {
                 $porcentage = '<font color="#FF0000"  size="2">'.$listing['products_porcentage']. '% '.'</font>';
             }else if($listing['products_porcentage'] >= 0.1){
                     if (PERMISO_PORCENTAGE_PRECIO_MAS == 'True'){
                  $porcentage = '<font color="#008000"  size="2">+'.$listing['products_porcentage']. '% '.'</font>';
                                          }else{
                                      $porcentage = '';
                                      }


         }else{
       $porcentage = '';

     }


           } // permiso porcentaje








$customer_group_query = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $listing['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = ''.$currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '';
  }
}


                       if ($customer_group['customers_group_id'] == '0'){
              $customers_porcentage = $products_porcentage['products_descuento'].'%';
                                                } if ($customer_group['customers_group_id'] == '1'){

              $customers_porcentage = $products_porcentage['products_descuento_g1'].'%';
                                                 }if ($customer_group['customers_group_id'] == '2'){

               $customers_porcentage = $products_porcentage['products_descuento_g2'].'%';
                                                }if ($customer_group['customers_group_id'] == '3'){

               $customers_porcentage = $products_porcentage['products_descuento_g3'].'%';
                                                }



       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


                       if ($customer_group['customers_group_id'] == '0'){
              $customers_porcentage = $products_porcentage['products_descuento'].'%';
                                                } if ($customer_group['customers_group_id'] == '1'){

              $customers_porcentage = $products_porcentage['products_descuento_g1'].'%';
                                                 }if ($customer_group['customers_group_id'] == '2'){

               $customers_porcentage = $products_porcentage['products_descuento_g2'].'%';
                                                }if ($customer_group['customers_group_id'] == '3'){

               $customers_porcentage = $products_porcentage['products_descuento_g3'].'%';
                                                }
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
            $price_descpro = $listing['products_price'] *$customers_porcentage/100+$listing['products_price'];

            if ($price_descpro == $listing['products_price']){

$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        }

}else{

  $products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

}


                         // Total CON EL DESCUENTO DEL PRODUCTO
                                     if ($customer_id <> 0 OR DEFECT_GROUP_PRICE_WEB <> '0'){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


                       if ($customer_group['customers_group_id'] == '0'){
              $customers_porcentage = $products_porcentage['products_descuento'];
                                                } if ($customer_group['customers_group_id'] == '1'){

              $customers_porcentage = $products_porcentage['products_descuento_g1'];
                                                 }if ($customer_group['customers_group_id'] == '2'){

               $customers_porcentage = $products_porcentage['products_descuento_g2'];
                                                }if ($customer_group['customers_group_id'] == '3'){

               $customers_porcentage = $products_porcentage['products_descuento_g3'];
                                                }

            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

            if ($products_price <> $listing['products_price']){

//$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
            }



      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] == 0 or $customers_porcentage['customers_porcentage_g1'] == 0 or $customers_porcentage['customers_porcentage_g2'] == 0  or $customers_porcentage['customers_porcentage_g3'] == 0 ){

                       if ($customer_group['customers_group_id'] == '0'){
              $customers_porcentage = $customers_porcentage['customers_porcentage'];
                                                } if ($customer_group['customers_group_id'] == '1'){

              $customers_porcentage = $customers_porcentage['customers_porcentage_g1'];
                                                 }if ($customer_group['customers_group_id'] == '2'){

               $customers_porcentage = $customers_porcentage['customers_porcentage_g2'];
                                                }if ($customer_group['customers_group_id'] == '3'){

               $customers_porcentage = $customers_porcentage['customers_porcentage_g3'];
                                                }




    $pro_g1_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" .  $customer_id . "'");
    $pro_g1 =tep_db_fetch_array($pro_g1_values);

    $pro_g_values = tep_db_query("select * from " . 'products_groups' . " where customers_group_id = '" .  $pro_g1['customers_group_id'] . "' and products_id = '" .  $listing['products_id'] . "'");
    $pro_g =tep_db_fetch_array($pro_g_values);
                                               if ($customer_group['customers_group_id'] == '0'){
                                              $pro_g['customers_group_price'] = $listing['products_price'];
                                           }




          if ($customer_id){

             $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="4"><b>' . $currencies->display_price($pro_g['customers_group_price'] *$customers_porcentage/100+$pro_g['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

       }else{

    $pro_g_values = tep_db_query("select * from " . 'products_groups' . " where customers_group_id = '" .  DEFECT_GROUP_PRICE_WEB . "' and products_id = '" .  $listing['products_id'] . "'");
    $pro_g2 =tep_db_fetch_array($pro_g_values);

           $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($pro_g2['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
                }


 }else{

    $pro_g1_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" .  $customer_id . "'");
    $pro_g1 =tep_db_fetch_array($pro_g1_values);

    $pro_g_values = tep_db_query("select * from " . 'products_groups' . " where customers_group_id = '" .  DEFECT_GROUP_PRICE_WEB . "' and products_id = '" .  $listing['products_id'] . "'");
    $pro_g =tep_db_fetch_array($pro_g_values);




    //  $customers_porcentage = DESCUENTO_CLIENTE;
              if (DEFECT_GROUP_PRICE_WEB <> '0'){
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="4"><b>' . $currencies->display_price($pro_g['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
                                                                                     }


}





  }
         } // Total CON EL DESCUENTO DEL PRODUCTO



    // if ($products_price == 0){
     //$products_price = '';
   // }


if ($customers_porcentage == 0){

        $customers_porcentage = '';


}
if ($customers_porcentage){

     }else{
          //  $products_price =  '<font color="#000000" size="5"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</b></font>';
              }

    $pdc_precio_final_values = tep_db_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $listing['products_id'] . "' order by pdc_unidades asc");
  if ($pdc_precio_final = tep_db_fetch_array($pdc_precio_final_values)){

            $pdc_price_final = ' <font color="#000000" size="0"><p style="margin-top: 0; margin-bottom: 0"> <font size="0">+'.$pdc_precio_final['pdc_unidades'].' Pcs ->></s>
              <font color="#ff0000" size="0"><b>' . $pdc_precio_final['pdc_price_final'] . '€ .....</b></font></span></p>';



}else{
 $pdc_price_final = '';
}





        if (tep_not_null($listing['specials_new_products_price'])) {
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
                <font color="#FF0000" size="6"><b>' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        } else {
          //  $products_price = $porcentage . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
        }

            $precio_permiso = $products_price;



     if (tep_not_null($listing['specials_new_products_price'])) {

          $customers_porcentage = '';
 }


        #Include template layout for the product box
        #build variables map
        $product['id']				= $listing['products_id'];
        $product['model']				= $listing['products_model'];
        $product['name']			= $listing['products_name']  . ' ' .$listing['products_model'] . '';

        if ($listing['products_price'] <> 0 or $customer_group_price['customers_group_price'] <> 0){


    $pro_g1_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" .  $customer_id . "'");
    $pro_g1 =tep_db_fetch_array($pro_g1_values);

    $pro_g_values = tep_db_query("select * from " . 'products_groups' . " where customers_group_id = '" .  $pro_g1['customers_group_id'] . "' and products_id = '" .  $listing['products_id'] . "'");
    if ($pro_g =tep_db_fetch_array($pro_g_values)){


                       if ($customer_group['customers_group_id'] == '0'){
              $customers_porcentage = $pro_g1['customers_porcentage'];
                                                } if ($customer_group['customers_group_id'] == '1'){

              $customers_porcentage = $pro_g1['customers_porcentage_g1'];
                                                 }if ($customer_group['customers_group_id'] == '2'){

               $customers_porcentage = $pro_g1['customers_porcentage_g2'];
                                                }if ($customer_group['customers_group_id'] == '3'){

               $customers_porcentage = $pro_g1['customers_porcentage_g3'];
                                                }

       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values));


                       if ($customer_group['customers_group_id'] == '0'){
              $customers_porcentage = $products_porcentage['products_descuento'];
                                                } if ($customer_group['customers_group_id'] == '1'){

              $customers_porcentage = $products_porcentage['products_descuento_g1'];
                                                 }if ($customer_group['customers_group_id'] == '2'){

               $customers_porcentage = $products_porcentage['products_descuento_g2'];
                                                }if ($customer_group['customers_group_id'] == '3'){

               $customers_porcentage = $products_porcentage['products_descuento_g3'];
                                                }




   if ( $customers_porcentage['customers_porcentage'] == 0 or $customers_porcentage['customers_porcentage_g1'] == 0 or $customers_porcentage['customers_porcentage_g2'] == 0  or $customers_porcentage['customers_porcentage_g3'] == 0 ){

    //  $products_price = '<p><b><font size="5" color="#000000">' .  $currencies->display_price($pro_g['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</font></b></p></b></p>';
                             }else{
             $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="4"><b>' . $currencies->display_price($pro_g['customers_group_price'] *$customers_porcentage/100+$pro_g['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';



                                }
}

}


                             $price = $products_price;
        

        $buy_button = '<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']) . '"><img src="' . DIR_MOBILE_IMAGES . 'btn_mob_cart.png" alt="' . IMAGE_BUTTON_IN_CART . '" /></a>';

























 if ($listing['stock_nivel'] == 1){
     $texto_stock =          '<img border="0" src="mobile/images/stock.png" width="13" height="13"> <font size="2">Stock</font>';
  ?>


   <?php

}

if ($listing['stock_nivel'] == 3){
      $texto_stock = '<p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/stock-50.jpg"></p>';

   }
if ($listing['stock_nivel'] == 4){
   $texto_stock =          '<img border="0" src="mobile/images/stock.png" width="13" height="13"> <font size="2">Stock</font>';
}
if ($listing['stock_nivel'] == 5){
      $texto_stock = '<p style="margin-top: 0; margin-bottom: 0"><img border="0" src="images/otros/stock_17_02.jpg"></p>';
   }
   // productos euroconsolas
if ($listing['stock_nivel'] == 6){
                                                                                                                                                                    $time =  time();//+ 1000000;
               // si el producto no tiene tiempo este se actualiza por primera vez y si este es rabazado en 48horas también actualiza los productos con los datos de stock mas recientes.
         $proveedor_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and time_proveedores <= '" . $time . "'");
         if ($proveedor = tep_db_fetch_array($proveedor_values)){

 //   $sumar_presupuestos_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.presupuestos and a.admin_groups_id=6";
 //   $sumar_presupuestos_sales_query = tep_db_query($sumar_presupuestos_sales_raw);
 //   $sumar_presupuestos= tep_db_fetch_array($sumar_presupuestos_sales_query);


   // $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6";
   // $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
   // $sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);

    $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_entregado_total= tep_db_fetch_array($sumar_entregado_total_sales_query);

    $sumar_mercancia_entregado_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.status_entregas and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_mercancia_entregado_procesando_sales_query = tep_db_query($sumar_mercancia_entregado_procesando_sales_raw);
    $sumar_mercancia_entregado_procesando= tep_db_fetch_array($sumar_mercancia_entregado_procesando_sales_query);

    $sumar_retirado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $product_info['products_id'] . "'and o.orders_status =a.retirarado and a.admin_groups_id=6 and a.admin_id = 14";
    $sumar_retirado_sales_query = tep_db_query($sumar_retirado_sales_raw);
    $sumar_retirado= tep_db_fetch_array($sumar_retirado_sales_query);

 //   $sumar_no_recogido_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.no_recogido and a.admin_groups_id=6";
 //   $sumar_no_recogido_sales_query = tep_db_query($sumar_no_recogido_sales_raw);
 //   $sumar_no_recogido= tep_db_fetch_array($sumar_no_recogido_sales_query);

    $sumar_pagado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.pagado and a.admin_groups_id=6";
    $sumar_pagado_total_sales_query = tep_db_query($sumar_pagado_total_sales_raw);
    $sumar_pagado_total= tep_db_fetch_array($sumar_pagado_total_sales_query);

    $sumar_cobrados_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.cobrado and a.admin_groups_id=6";
    $sumar_cobrados_total_sales_query = tep_db_query($sumar_cobrados_total_sales_raw);
    $sumar_cobrados_total= tep_db_fetch_array($sumar_cobrados_total_sales_query);

    $sumar_pagado_transferencia_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.pagado_transferencia and a.admin_groups_id=6";
    $sumar_pagado_transferencia_sales_query = tep_db_query($sumar_pagado_transferencia_sales_raw);
    $sumar_pagado_transferencia= tep_db_fetch_array($sumar_pagado_transferencia_sales_query);

    $sumar_paypal_enviado_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.paypal_enviado and a.admin_groups_id=6";
    $sumar_paypal_enviado_sales_query = tep_db_query($sumar_paypal_enviado_sales_raw);
    $sumar_paypal_enviado= tep_db_fetch_array($sumar_paypal_enviado_sales_query);

    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);


    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status = a.credito and a.admin_groups_id=6";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);

     $sumar_pagos_procesando_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $listing['products_id'] . "'and o.orders_status =a.status_liquidacion and a.admin_groups_id=6";
    $sumar_pagos_procesando_sales_query = tep_db_query($sumar_pagos_procesando_sales_raw);
    $sumar_pagos_procesando= tep_db_fetch_array($sumar_pagos_procesando_sales_query);


       //+ $sumar_no_recogido['value']
    $entradas_os = $sumar_entregado_total['value'];

      // $sumar_presupuestos['value']
    $salidas_os = $sumar_pagos_procesando['value'] + $sumar_credito['value'] + $sumar_retirado['value'] + $sumar_cobrados_total['value'] + $sumar_pagado_total['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value']; //+ $sumar_pendiente_entrada_total['value'];


   $stock_euroconsolas =  $entradas_os - $salidas_os;


       $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

           $sql_data_array = array('time_proveedores' => time()+rand(1,130000),
                                   'time_entradasysalidas' => $entradas_os - $salidas_os,
                                   'products_balance_stock' => $stock_euroconsolas * $listing['products_price'],
                                   'time_ultimaactualizacion' => $oldday1,
                                   'time_pendiente_entrada_total' => $sumar_pendiente_entrada_total['value'],
                                   'time_entregado' => $sumar_entregado_total['value'],
                                   'time_mercancia_entregado_procesando' => $sumar_mercancia_entregado_procesando['value'],
                                   'time_paypal_enviado' => $sumar_paypal_enviado['value'],
                                   'time_pagado_transferencia' => $sumar_pagado_transferencia['value'],
                                   'time_no_recogido' => $sumar_no_recogido['value'],
                                   'time_cobrados' => $sumar_cobrados_total['value'],
                                   'time_pagado' => $sumar_pagado_total['value'],);

     tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $listing['products_id'] . "'");

 }
     $stock_query = tep_db_query("select * from " . 'products_stock' . " where  products_id = '" . $listing['products_id'] . "'");
 $p_stock = tep_db_fetch_array($stock_query);


    if ($p_stock['products_stock_real'] <= 0 ){

   $texto_stock = '<img border="0" src="mobile/images/agotado.png" width="13" height="13"> <font size="2">Stock: ' . number_format($p_stock['products_stock_real'], 2, '.', '').'</font>'; //. ' Pendiente: '. $listing['time_mercancia_entregado_procesando'];

}else{

   $texto_stock = '<img border="0" src="mobile/images/stock.png" width="13" height="13"> <font size="2">Stock: ' . number_format($p_stock['products_stock_real'], 2, '.', '').'</font>';

}
 //  }


}








































                                                                                                                                                                                                                                            
?>			
					<div id="prodCell">
					<div class="prodImg"><?php echo $path . $img . '</a>'; ?></div>
					<div class="prodName"><?php 
						if (strlen($listing['products_name']) > MOBILE_PRODUCT_NAME_LENGTH)
						{
							echo $path . substr($listing['products_name'], 0, MOBILE_PRODUCT_NAME_LENGTH) . '...</a>' ;
						}
						else
						{
							echo $path . $listing['products_name'] . '</a>' ;
						}
						?></div>
					<div class="prodPrice"><?php echo '</p></b></a><b><font size="5">Cod.'.$listing['products_id'].'</font>'; ?></div>
					<div class="prodBuy"><?php echo $price; ?></div>
             <?php
             if ($p_stock['products_stock_real'] >= 0.01 or $listing['stock_nivel'] <> 6){
           ?>
  <div class="prodBuy"><?php echo $buy_button; ?></div>
     <?php
     }else{
      ?>
      <div class="prodBuy"></div>
 <?php
 }
        ?>
					<div class="prodBuy"><?php echo $texto_stock; ?></div>
    	</div>
<?php
		$col++;
      } 
	  while ($col % $num_of_columns != 0) {
			$col++;
			echo '<div id="empty"></div>';
	  } 
      
?>
</div>
<!--  ajax_results_ending -->
<?php
  if ($listing_split->number_of_rows > 0 ) {
?>
<div id="results">
<?php  if(AJAX_ENABLED == 'true') {?>
<script language="javascript"><!--
document.write('<?php echo $listing_split->display_ajax_msg(); ?>');
--></script>
<noscript>
    <?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?>
	<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
</noscript>
<?php  } else { ?>

    <?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?>
	<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>

<?php  }
  }
?>
