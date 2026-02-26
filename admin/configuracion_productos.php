<?php
/*
  $Id: stats_products_viewed.php,v 1.29 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
                               mysql_fetch_array
  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
   $borrar = $_GET['borrar'];
  $baja_proveedor = $_GET['baja_proveedor'];
$borrar_product_proveedor = $_GET['borrar_product_proveedor'];
$borrar_spacio_image = $_GET['borrar_spacio_image'];
 $baja_proveedor_id = $_POST['baja_proveedor_id'];
 $borrar_producto_id = $_POST['borrar_producto_id'];
 $eliminar_cm = $_GET['eliminar_cm'];
  if ($action == 'edit'){

  
      if ($login_id_remoto){
               $log_id = $login_id_remoto;
 }else{
              $log_id = $login_id;
}




                      // cambia el products_id por el seleccionado.

     $sql_status_update_array = array('products_id' => $id_cambiar,);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id= '" . $id_buscador . "'");

   $sql_status_update_array = array('products_id' => $id_cambiar,);
            tep_db_perform('products_description', $sql_status_update_array, 'update', " products_id= '" . $id_buscador . "'");

   $sql_status_update_array = array('products_id' => $id_cambiar,);
            tep_db_perform('products_to_categories', $sql_status_update_array, 'update', " products_id= '" . $id_buscador . "'");

  $sql_status_update_array = array('products_id' => $id_cambiar,);
            tep_db_perform('specials', $sql_status_update_array, 'update', " products_id= '" . $id_buscador . "'");












        tep_redirect(tep_href_link('configuracion_productos.php', tep_get_all_get_params(array('action'))));

  
}
          // borra el producto seleccionado.
    if ($borrar == 'edit'){
  
     tep_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" . $borrar_producto_id . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $borrar_producto_id . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $borrar_producto_id . "'");
     tep_db_query("delete from " . TABLE_SPECIALS . " where products_id = '" . $borrar_producto_id . "'");
}
  

      if ($eliminar_cm == 'edit'){


   $categoriesmt_values = tep_db_query("select p.products_id, pc.categories_id from " . 'products' . " p, " . 'products_to_categories' . " pc  where pc.products_id = p.products_id");
  while($categoriesmt = tep_db_fetch_array($categoriesmt_values)){



        $admin_values = tep_db_query("select * from " . 'categories' . " where categories_id = '" . $categoriesmt['categories_id'] . "'");
    if  ($ca_c = tep_db_fetch_array($admin_values)){



 }else{

 echo $categoriesmt['products_id'] ;
 
 
         tep_db_query("delete from " . 'products_to_categories' . " where products_id = '" . $categoriesmt['products_id'] . "'");

 
 

}

       //  $sql_status_update_array = array('categories_id' => 0);
        //    tep_db_perform('products_to_categories', $sql_status_update_array, 'update', " categories_id = '" . 0 . "'");



}





      //  $sql_status_update_array = array('categories_id' => 0);
        //    tep_db_perform('products_to_categories', $sql_status_update_array, 'update', " categories_id = '" . 0 . "'");




 }






  
     if ($cambiar_status == 'edit'){


        $sql_status_update_array = array('products_status' => 0);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_model = '" . $products_model_id . "'");

  
  
  
 }


     if ($baja_proveedor == 'edit'){

        $sql_status_update_array = array('products_status' => 0);
            tep_db_perform('products', $sql_status_update_array, 'update', " codigo_proveedor = '" . $baja_proveedor_id . "'");




 }


          // borra el producto seleccionado.
    if ($borrar_product_proveedor == 'edit'){

   $borrar_values = tep_db_query("select * from " . 'products' . " where codigo_proveedor = '" . $baja_proveedor_id . "'");
  while  ($borrar = tep_db_fetch_array($borrar_values)){


     tep_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . TABLE_SPECIALS . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . 'products_groups' . " where products_id = '" .  $borrar['products_id'] . "'");
     tep_db_query("delete from " . 'products_seguimientos_precios' . " where products_id = '" .  $borrar['products_id'] . "'");

} // while borrar

     }


          // borra el producto seleccionado.
    if ($borrar_spacio_image == 'edit'){                           // 104744 codigo_proveedor = '" . $baja_proveedor_id . "'

   $borrar_values = tep_db_query("select * from " . 'products' . " where codigo_proveedor = '" . $baja_proveedor_id . "'");
  while  ($borrar = tep_db_fetch_array($borrar_values)){
                                                         //$borrar['products_image'] = $borrar;
                                                         

  $borrar['products_image'] = ereg_replace("[[:space:]]", "", "" . $borrar['products_image']  . "");
                          echo $borrar['products_image'];
        $sql_status_update_array = array('products_image' => $borrar['products_image']);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $borrar['products_id']  . "'");


} // while borrar

     }



     $reset_publi = $_GET['reset_publi'];

          // borra el producto seleccionado.
    if ($reset_publi == 'edit'){


        $sql_status_update_array = array('nt_aut' => 1);
            tep_db_perform('newsletter_abonnement', $sql_status_update_array, 'update', " nt_aut <> '" . 5  . "'");

         $sql_status_update_array = array('nt_aut' => 1);
            tep_db_perform('customers', $sql_status_update_array, 'update', " nt_aut <> '" . 5  . "'");


 } // while borrar

     $vaciar_easypopulate_time2 = $_GET['vaciar_easypopulate_time2'];

          // borra el producto seleccionado.
    if ($vaciar_easypopulate_time2 == 'edit'){                           // 104744 codigo_proveedor = '" . $baja_proveedor_id . "'

   $vaciar_values = tep_db_query("select * from " . 'products' . " where easypopulate_time2 <> 0 ");
  while  ($vaciar = tep_db_fetch_array($vaciar_values)){
                                                         //$borrar['products_image'] = $borrar;




        $sql_status_update_array = array('easypopulate_time2' => 0);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $vaciar['products_id']  . "'");


} // while borrar

     }
    $sumar_total_sales_raw = "select sum(stock_total_costo) as value, count(*) as stock_total_costo from products where stock_total_costo >= 1";
    $sumar_total_sales_query = tep_db_query($sumar_total_sales_raw);
    $sumar_total= tep_db_fetch_array($sumar_total_sales_query);



     $stock_almacen = $_GET['stock_almacen'];

          // borra el producto seleccionado.
    if ($stock_almacen == 'edit'){                           // 104744 codigo_proveedor = '" . $baja_proveedor_id . "'

   $vaciar_values = tep_db_query("select * from " . 'products' . "");
  while  ($vaciar = tep_db_fetch_array($vaciar_values)){
                                                         //$borrar['products_image'] = $borrar;


    $permisog2_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $vaciar['products_id']  . "' and customers_group_id = 2");
    $permisog2 = tep_db_fetch_array($permisog2_values);
    $stock_values = tep_db_query("select * from " . 'products_stock' . " where products_id = '" . $vaciar['products_id']  . "'");
    $stock = tep_db_fetch_array($stock_values);

         ?>     '<p>' <?php      ECHO $stock['products_stock_real'] . ' X ' . $permisog2['products_price']  . '  ' .  ($total = $stock['products_stock_real'] *  $permisog2['customers_group_price']);

           ?>  '</p>'

           <?php
                           
        $sql_status_update_array = array('stock_total_costo' => $total);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $vaciar['products_id']  . "'");


} // while borrar

     }







          // borra el producto seleccionado.
    if ($borrar_product_proveedor_inactivo == 'edit'){

   $borrar_values = tep_db_query("select * from " . 'products' . " where codigo_proveedor = '" . $baja_proveedor_id . "' and products_status = '" . 0 . "'");
  while  ($borrar = tep_db_fetch_array($borrar_values)){


     tep_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . TABLE_SPECIALS . " where products_id = '" . $borrar['products_id'] . "'");
     tep_db_query("delete from " . 'products_groups' . " where products_id = '" .  $borrar['products_id'] . "'");
     tep_db_query("delete from " . 'products_seguimientos_precios' . " where products_id = '" .  $borrar['products_id'] . "'");

} // while borrar

     }

   $baja_groupprice_id = $_POST['baja_groupprice_id'];
   $quitar_permiso_price_group = $_GET['quitar_permiso_price_group'];

     if ($quitar_permiso_price_group == 'edit'){

        $sql_status_update_array = array('customers_group_name' => 'retail',
                                         'customers_group_id' => '0');
            tep_db_perform('customers', $sql_status_update_array, 'update', " customers_group_name = '" . $baja_groupprice_id  . "' and customers_lastname <> 'grupo'");




 }


  
?>
<?php     require(DIR_WS_INCLUDES . 'template_top.php');
?>


                       <?php
                       
     if ($login_id_remoto){
               $log_id = $login_id_remoto;
 }else{
              $log_id = $login_id;
}
                       
                       


   $admin_values = tep_db_query("select * from " . 'administrators' . " where admin_id = '" . $log_id . "'");
   $admin_c = tep_db_fetch_array($admin_values);







          if ($hedera){

         $admin_values = tep_db_query("select * from " . 'orders' . " where orders_status = '" . 15 . "'");
    if  ($ca_c = tep_db_fetch_array($admin_values)){



         $sql_status_update_array = array('hedera_autorice' => '1');
            tep_db_perform('orders', $sql_status_update_array, 'update', " orders_status = '" . 15  . "' and hedera_autorice = '2'");


            }
             }



       //  $sql_status_update_array = array('customers_billetera' => '0.0.4312791');
    Ç//        tep_db_perform('customers', $sql_status_update_array, 'update', " customers_id <> '" . 1  . "'");



                     ?>


















    <form name="form1" method="post" action="<?php echo $PHP_SELF.'?action=edit'; ?>">
  <p>Sustituir este ID de Producto
    <input type="text" name="id_cambiar">
    por este otro
    <input type="text" name="id_buscador">
</p>
  <p>
    <input type="submit" name="Submit" value="Cambiar">
</p>
</form>




 <p>&nbsp;</p>
<form name="form2" method="post" action="<?php echo $PHP_SELF.'?borrar=edit'; ?>">
  Borrar Producto con ID:
  <input type="text" name="borrar_producto_id">
     <input type="submit" name="Submit" value="Borrar">
  
</form>



 <p>&nbsp;</p>
<form name="form2" method="post" action="<?php echo $PHP_SELF.'?cambiar_status=edit'; ?>">
  Cambiar a STATUS "0":
  <input type="text" name="products_model_id">
     <input type="submit" name="Submit" value="Borrar">

</form>



 <p>&nbsp;</p>
<form name="form2" method="post" action="<?php echo $PHP_SELF.'?baja_proveedor=edit'; ?>">
  Dar de baja todos los productos de un proveedor STATUS "0":
  <input type="text" name="baja_proveedor_id">
     <input type="submit" name="Submit" value="Borrar">

</form>


 <p>&nbsp;</p>
<form name="form2" method="post" action="<?php echo $PHP_SELF.'?borrar_product_proveedor=edit'; ?>">
 Borrar todos los productos del proveedor con id:
  <input type="text" name="baja_proveedor_id">
     <input type="submit" name="Submit" value="Borrar">

</form>


  <p>&nbsp;</p>
<form name="form2" method="post" action="<?php echo $PHP_SELF.'?borrar_spacio_image=edit'; ?>">
 Quitar Espacios del nombre de la imagen del proveedor Nº:
  <input type="text" name="baja_proveedor_id">
     <input type="submit" name="Submit" value="Borrar">

</form>

  <p>&nbsp;</p>
<form name="form2" method="post" action="<?php echo $PHP_SELF.'?quitar_permiso_price_group=edit'; ?>">
 Resetea todos los permisos en la ficha del cliente y los devuelve a RETAIL:
  <input type="text" name="baja_groupprice_id">
     <input type="submit" name="Submit" value="Borrar">

</form>
 <p><a href="<?php echo $PHP_SELF . '?reset_publi=edit'; ?>">RESETEAR BLOQUEO DE PUBLICIDAD</a></p>

 <p><a href="<?php echo $PHP_SELF . '?vaciar_easypopulate_time2=edit'; ?>">Vacir EasePopulate 2 Tiempo entre
actualización. desde actualizar catalogo.</a></p>

 <p><a href="<?php echo $PHP_SELF . '?stock_almacen=edit'; ?>"> CALCULA LA CANTIDAD STOCK X PRECIO COSTO
  <?php     echo   $sumar_total['value']; ?>

 </a></p>


<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
