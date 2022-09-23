<?php



                 $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $new_products['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){
             if ($ref_fabricante['proveedor_ruta_images']){
 //if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $new_products['products_image'])) {

//$product['image']			= tep_image($ref_fabricante['proveedor_ruta_images'] . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

 $product['image']			='<a href="'. $ref_fabricante['proveedor_ruta_images'] . $new_products['products_image'] .'"><img src="'. $ref_fabricante['proveedor_ruta_images'] . $new_products['products_image']  .'" height="'. HEADING_IMAGE_HEIGHT .'"  width="'. SMALL_IMAGE_WIDTH .'"></a>' . '</a>';



       require(TMPL_DIR. 'templ_product_box.php');

               $new_prods_content .= '<td align="center" valign="top">'.$az_product_html.$texto_stock;

              // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 1 . "'");
       if ($product_compartir = tep_db_fetch_array($product_compartir_values)){

 $new_prods_content .= '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine_propio.php?stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . '&web=' . $product_compartir['ruta_url'] . ' "> </script>';
    }


              // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
       WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){

 $new_prods_content .= '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . '&web=' . $product_compartir['ruta_url'] . '  "> </script>';
    }


              $new_prods_content .= '</td>';


               $col ++;



} else {
$product['image']			= tep_image($ref_fabricante['proveedor_ruta_images'] . 'no-foto.jpg', $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

//$product['image']			= tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

 }

  }else{

           // si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^http://", $new_products['products_image']) ) {



 $product['image']			= tep_image('' . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
 require(TMPL_DIR. 'templ_product_box.php');
               $new_prods_content .= '<td align="center" valign="top">'.$az_product_html.$texto_stock.$stock_exterior.'</td>';
               $col ++;








   if (@getimagesize($new_products['products_image'])) {


}else{







              if (ACTIVO_NOIMAGES == 'True'){

             $sql_status_update_array = array('products_status' => 0,);
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $products_id_stock . "'");
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


            } // ACTIVO_NOIMAGES

        } // http no existe


















}else{




         if (@getimagesize(DIR_WS_IMAGES . $new_products['products_image'])) {

//   $product['image']			= tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
 $product['image']	=     tep_info_image($new_products['products_image'], $new_products['products_name'], HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);


      require(TMPL_DIR. 'templ_product_box.php');


              // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
       WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){

 $stock_exterior = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . '&web=' . $product_compartir['ruta_url'] . '  "> </script>';
    }






               $new_prods_content .= '<td align="center" valign="top">'.$az_product_html.$texto_stock.$stock_exterior.'</td>';


               $col ++;
             }else{

               if (ACTIVO_NOFOTO == 'True'){


               if ($new_products['products_image']){

$product['image']			='<img src="images/'. $new_products['products_image']  .'" height="'. HEADING_IMAGE_HEIGHT .'"  width="'. SMALL_IMAGE_WIDTH .'"></a>' . '</a>';
                              }else{
$product['image']			='<img src="images/'. 'imnd.svg'  .'" height="'. HEADING_IMAGE_HEIGHT .'"   width="'. SMALL_IMAGE_WIDTH .'"></a>' . '</a>';

                          }


 //$product['image']			= tep_info_image($new_products['products_image'], $new_products['products_name'], HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);
      require(TMPL_DIR. 'templ_product_box.php');
               $new_prods_content .= '<td align="center" valign="top">'.$az_product_html.$texto_stock.$stock_exterior.'</td>';
               $col ++;
                } // activo nofoto



              if (ACTIVO_NOIMAGES == 'True'){
                
             $sql_status_update_array = array('products_status' => 0,);
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $products_id_stock . "'");
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
                
                
            } // ACTIVO_NOIMAGES

                 } // si existe images
             
             





                                                                                                                
             
             
             
     }

   } // fin ref_fabricante



 
  ?>
