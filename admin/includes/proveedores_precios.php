<?php

if ($serie_a == 'ok'){

         $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);
    $producto_precio =  $codigobarras_c['products_price']*$porcentage_tienda['porcentage_tienda']/100+$codigobarras_c['products_price'];
         //copiar en una pagina desde aqui


                        //HARDMEMORY
        $proveedor_2_values = mysql_query("select * from " . 'proveedor' . "  where proveedor_id = '" . $codigobarras_c['codigo_proveedor'] . "'");
       if ($proveedor_2 = mysql_fetch_array($proveedor_2_values)){


         if ($proveedor_2['proveedor_grupo_id'] == 2){

          $unid = $unidades+$codigobarras_a['products_quantity'];

          $precio_base = $codigobarras_c['proveedor_price'] * $unid * $proveedor_2['proveedor_impuesto']/100+$codigobarras_c['proveedor_price']*$unid;
          $precio_publico = $producto_precio*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;

                         //Comercial del Disco Canarias 10%
        }else if ($proveedor_2['proveedor_grupo_id'] == 3){


          $unid = $unidades+$codigobarras_a['products_quantity'];

          $precio_base = $codigobarras_c['proveedor_price'] * $unid * $proveedor_2['proveedor_descuento']/100+$codigobarras_c['proveedor_price']*$unid;
          $precio_base2 = $precio_base*$proveedor_2['proveedor_impuesto']/100+$precio_base;
          $precio_publico = $producto_precio*$unid;

            $ganancias_div =   $precio_publico-$precio_base2;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base2+$ganancias_tiendas;


                          //EUROCONSOLAS DISTRIBUCION
        }else if ($proveedor_2['proveedor_grupo_id'] == 1){


        $eurodis_values = mysql_query("select * from " . 'products_groups' . "  where products_id = '" . $codigobarras_c['products_id'] . "' and customers_group_id = '" . 1 . "'");
        $eurodis = mysql_fetch_array($eurodis_values);


                          $eurodis['customers_group_price'];


          $unid = $unidades+$codigobarras_a['products_quantity'];

          $precio_base = $eurodis['customers_group_price'] * $unid * $proveedor_2['proveedor_descuento']/100+$eurodis['customers_group_price']*$unid;
          $precio_publico = $producto_precio*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div;
            $total_pago_euro =  $precio_base;




     }
            //hasta aquí
  }
}



















if ($serie_b == 'ok'){


         $porcentage_tienda_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
   $porcentage_tienda = tep_db_fetch_array($porcentage_tienda_values);
    $producto_precio =  $codigobarras_c['products_price']*$porcentage_tienda['porcentage_tienda']/100+$codigobarras_c['products_price'];


        $proveedor_2_values = mysql_query("select * from " . 'proveedor' . "  where proveedor_id = '" . $codigobarras_c['codigo_proveedor'] . "'");
       if ($proveedor_2 = mysql_fetch_array($proveedor_2_values)){


       //Hardmemory
        if ($proveedor_2['proveedor_grupo_id'] == 2){

          $precio_base = $codigobarras_c['proveedor_price'] * $unidades * $proveedor_2['proveedor_impuesto']/100+$codigobarras_c['proveedor_price']*$unidades;
          $precio_publico = $producto_precio*$unidades;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;
                             //Comercial del Disco 10%
            }else if ($proveedor_2['proveedor_grupo_id'] == 3){

        $precio_base = $codigobarras_c['proveedor_price'] * $unidades * $proveedor_2['proveedor_descuento']/100+$codigobarras_c['proveedor_price']*$unidades;
        $precio_base2 = $precio_base*$proveedor_2['proveedor_impuesto']/100+$precio_base;
          $precio_publico = $producto_precio*$unidades;

            $ganancias_div =   $precio_publico-$precio_base2;
            $ganancias_tiendas = $ganancias_div/2;
            $total_pago_euro =  $precio_base2+$ganancias_tiendas;

     }else if ($proveedor_2['proveedor_grupo_id'] == 1){


         $eurodis_values = mysql_query("select * from " . 'products_groups' . "  where products_id = '" . $codigobarras_c['products_id'] . "' and customers_group_id = '" . 1 . "'");
        $eurodis = mysql_fetch_array($eurodis_values);


                          $eurodis['customers_group_price'];



        $precio_base = $eurodis['customers_group_price'] * $unidades * $proveedor_2['proveedor_descuento']/100+$eurodis['customers_group_price']*$unidades;
        $precio_publico = $producto_precio*$unidades;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div;
            $total_pago_euro =  $precio_base;



                           }


                }

}






















if ($serie_c == 'ok'){


      $codigo_1_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . (int)$order['products_id'] . "'");
     $codigo_1 = mysql_fetch_array($codigo_1_values);


         //copiar en una pagina desde aqui


                        //HARDMEMORY
        $proveedor_2_values = mysql_query("select * from " . 'proveedor' . "  where proveedor_id = '" . $codigo_1['codigo_proveedor'] . "'");
       if ($proveedor_2 = mysql_fetch_array($proveedor_2_values)){


         if ($proveedor_2['proveedor_grupo_id'] == 2){

     $unid = $products_details["qty"];

          $precio_base = $products_details["proveedor_price"] * $unid * $proveedor_2['proveedor_impuesto']/100+$products_details["proveedor_price"]*$unid;
          $precio_publico = $products_details["final_price"]*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;

                         //Comercial del Disco Canarias 10%
        }else if ($proveedor_2['proveedor_grupo_id'] == 3){


        $unid = $products_details["qty"];

          $precio_base = $products_details["proveedor_price"] * $unid * $proveedor_2['proveedor_descuento']/100+$products_details["proveedor_price"]*$unid;
          $precio_base2 = $precio_base*$proveedor_2['proveedor_impuesto']/100+$precio_base;
          $precio_publico = $products_details["final_price"]*$unid;

            $ganancias_div =   $precio_publico-$precio_base2;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base2+$ganancias_tiendas;



                         //EUROCONSOLAS
        }else if ($proveedor_2['proveedor_grupo_id'] == 1){


         $eurodis_values = mysql_query("select * from " . 'products_groups' . "  where products_id = '" . (int)$order['products_id'] . "' and customers_group_id = '" . 1 . "'");
        $eurodis = mysql_fetch_array($eurodis_values);


                          $eurodis['customers_group_price'];


        $unid = $products_details["qty"];

          $precio_base = $eurodis['customers_group_price'] * $unid * $proveedor_2['proveedor_descuento']/100+$eurodis['customers_group_price']*$unid;
          $precio_publico = $products_details["final_price"]*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div;
            $total_pago_euro =  $precio_base;









     }
            //hasta aquí
  }


}
















































if ($serie_d == 'ok'){



      $codigo_1_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $_POST['add_product_products_id'] . "'");
      $codigo_1 = mysql_fetch_array($codigo_1_values);





        $proveedor_2_values = mysql_query("select * from " . 'proveedor' . "  where proveedor_id = '" . $codigo_1['codigo_proveedor'] . "'");
       if ($proveedor_2 = mysql_fetch_array($proveedor_2_values)){


       //Hardmemory
        if ($proveedor_2['proveedor_grupo_id'] == 2){

         $unid = $_POST['add_product_quantity'];

          $precio_base = $codigo_1['proveedor_price'] * $unid * $proveedor_2['proveedor_impuesto']/100+$codigo_1['proveedor_price']*$unid;
          $precio_publico = $p_products_price*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;
            
            
                             //Comercial del Disco 10%
            }else if ($proveedor_2['proveedor_grupo_id'] == 3){

        $unid = $_POST['add_product_quantity'];

        $precio_base = $codigo_1['proveedor_price'] * $unid * $proveedor_2['proveedor_descuento']/100+$codigo_1['proveedor_price']*$unid;
        $precio_base2 = $precio_base*$proveedor_2['proveedor_impuesto']/100+$precio_base;
          $precio_publico = $p_products_price*$unid;

            $ganancias_div =   $precio_publico-$precio_base2;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;




                             //EUROCONSOLAS
            }else if ($proveedor_2['proveedor_grupo_id'] == 3){




         $eurodis_values = mysql_query("select * from " . 'products_groups' . "  where products_id = '" . $_POST['add_product_products_id'] . "' and customers_group_id = '" . 1 . "'");
        $eurodis = mysql_fetch_array($eurodis_values);


                          $eurodis['customers_group_price'];




        $unid = $_POST['add_product_quantity'];

        $precio_base = $eurodis['customers_group_price'] * $unid * $proveedor_2['proveedor_descuento']/100+$eurodis['customers_group_price']*$unid;
          $precio_publico = $p_products_price*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div;
            $total_pago_euro =  $precio_base;




                }

}



}




























if ($serie_e == 'ok'){





     $codigo_1_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $orders_4['products_id'] . "'");
     $codigo_1 = mysql_fetch_array($codigo_1_values);


         //copiar en una pagina desde aqui


                        //IMPUESTO
        $proveedor_5_values = mysql_query("select * from " . 'proveedor' . "  where proveedor_id = '" . $codigo_1['codigo_proveedor'] . "'");
       if ($proveedor_5 = mysql_fetch_array($proveedor_5_values)){


        if ($proveedor_5['proveedor_grupo_id'] == 2){

          $unid = $orders_3['products_quantity'] + $orders_4['products_quantity'];

          $precio_base = $products_details["proveedor_price"] * $unid * $proveedor_5['proveedor_impuesto']/100+$codigo_1["proveedor_price"]*$unid;
          $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;

                         //DESCUENTO + IMPUESTO
        }else if ($proveedor_5['proveedor_grupo_id'] == 3){


        $unid = $orders_3['products_quantity'] + $orders_4['products_quantity'];

          $precio_base = $codigo_1["proveedor_price"] * $unid * $proveedor_5['proveedor_descuento']/100+$codigo_1["proveedor_price"]*$unid;
         $precio_base2 = $precio_base*$proveedor_5['proveedor_impuesto']/100+$precio_base;
          $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base2;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base2+$ganancias_tiendas;

                         //EUROCONSOLAS
        }else if ($proveedor_5['proveedor_grupo_id'] == 1){


          $eurodis_values = mysql_query("select * from " . 'products_groups' . "  where products_id = '" . $orders_4['products_id'] . "' and customers_group_id = '" . 1 . "'");
        $eurodis = mysql_fetch_array($eurodis_values);


                          $eurodis['customers_group_price'];





      $unid = $orders_3['products_quantity'] + $orders_4['products_quantity'];

          $precio_base = $eurodis['customers_group_price'] * $unid * $proveedor_5['proveedor_descuento']/100+$eurodis['customers_group_price']*$unid;
          $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div;
            $total_pago_euro =  $precio_base;


     }
            //hasta aquí
  }









}











if ($serie_f == 'ok'){









    $codigo_1_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $orders_4['products_id'] . "'");
    $codigo_1 = mysql_fetch_array($codigo_1_values);


         //copiar en una pagina desde aqui


                        //IMPUESTO
        $proveedor_5_values = mysql_query("select * from " . 'proveedor' . "  where proveedor_id = '" . $codigo_1['codigo_proveedor'] . "'");
       if ($proveedor_5 = mysql_fetch_array($proveedor_5_values)){


if ($proveedor_5['proveedor_grupo_id'] == 2){

          $unid = $orders_3['products_quantity'] - $orders_4['products_quantity'];

          $precio_base = $products_details["proveedor_price"] * $unid * $proveedor_5['proveedor_impuesto']/100+$codigo_1["proveedor_price"]*$unid;
          $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;

                         //DESCUENTO + IMPUESTO
        }else if ($proveedor_5['proveedor_grupo_id'] == 3){


          $unid = $orders_3['products_quantity'] - $orders_4['products_quantity'];

          $precio_base = $codigo_1["proveedor_price"] * $unid * $proveedor_5['proveedor_descuento']/100+$codigo_1["proveedor_price"]*$unid;
          $precio_base2 = $precio_base*$proveedor_5['proveedor_impuesto']/100+$precio_base;
          $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;



     }
            //hasta aquí
  }














}
















if ($serie_g == 'ok'){





     $codigo_1_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $orders_4['products_id'] . "'");
     $codigo_1 = mysql_fetch_array($codigo_1_values);


         //copiar en una pagina desde aqui


                        //IMPUESTO
        $proveedor_5_values = mysql_query("select * from " . 'proveedor' . "  where proveedor_id = '" . $codigo_1['codigo_proveedor'] . "'");
       if ($proveedor_5 = mysql_fetch_array($proveedor_5_values)){


        if ($proveedor_5['proveedor_grupo_id'] == 2){

          $unid = $orders_4['products_quantity'];

          $precio_base = $products_details["proveedor_price"] * $unid * $proveedor_5['proveedor_impuesto']/100+$codigo_1["proveedor_price"]*$unid;
          $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base+$ganancias_tiendas;

                         //DESCUENTO + IMPUESTO
        }else if ($proveedor_5['proveedor_grupo_id'] == 3){


          $unid = $orders_4['products_quantity'];

          $precio_base = $codigo_1["proveedor_price"] * $unid * $proveedor_5['proveedor_descuento']/100+$codigo_1["proveedor_price"]*$unid;
          $precio_base2 = $precio_base*$proveedor_5['proveedor_impuesto']/100+$precio_base;
          $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base2;
            $ganancias_tiendas = $ganancias_div /2;
            $total_pago_euro =  $precio_base2+$ganancias_tiendas;


                         //DESCUENTO + IMPUESTO
        }else if ($proveedor_5['proveedor_grupo_id'] == 1){



          $eurodis_values = mysql_query("select * from " . 'products_groups' . "  where products_id = '" . $orders_4['products_id'] . "' and customers_group_id = '" . 1 . "'");
        $eurodis = mysql_fetch_array($eurodis_values);


                          $eurodis['customers_group_price'];




          $unid = $orders_4['products_quantity'];

          $precio_base = $eurodis['customers_group_price'] * $unid * $proveedor_5['proveedor_descuento']/100+$eurodis['customers_group_price']*$unid;
           $precio_publico = $orders_4['products_price']*$unid;

            $ganancias_div =   $precio_publico-$precio_base;
            $ganancias_tiendas = $ganancias_div;
            $total_pago_euro =  $precio_base;




     }
            //hasta aquí
  }







}







 ?>
