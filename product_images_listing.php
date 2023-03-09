<?php


               $products_images_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $products_id_stock . "'");
             $products_images= mysql_fetch_array($products_images_values);
               $products_images_name_values = mysql_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $products_id_stock . "'");
             $products_images_name = mysql_fetch_array($products_images_name_values);


                    $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $products_images['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){



      if ($products_images['getimagesize_proveedor_ruta_images_time']){
         // echo 'si';
       $imgper = $products_images['getimagesize_proveedor_ruta_images_time'];
  }else{
     // echo 'no';
       $imgper = @getimagesize($ref_fabricante['proveedor_ruta_images']. $products_images['products_image']);
    }


    $imgper = 'ok';
    
if ($imgper == 'ok') {

                      // si la imagen existe en destino este cambio indica que no vuelva a ser compro
            $sql_status_update_array = array('getimagesize_proveedor_ruta_images_time' => 1);
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $products_id_stock . "'");



//$product['image']			= tep_image($ref_fabricante['proveedor_ruta_images'] . $products_images['products_image'], $products_images_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

       if (file($ref_fabricante['proveedor_ruta_images'] . $products_images['products_image'])) {
$product['image']			=       '<img src="'. $ref_fabricante['proveedor_ruta_images'] . $products_images['products_image']  .'" width="'. SMALL_IMAGE_WIDTH .'" height="'. SMALL_IMAGE_HEIGHT  .'" ></a>' . '</a>';
                                                         }else{

                                                    if (ereg("^https://", $products_images['products_image']) ) {

  $product['image']			= '<img src="'. $products_images['products_image']  .'" height="'. HEADING_IMAGE_HEIGHT .'"   width="'. SMALL_IMAGE_WIDTH .'"></a>' . '</a>'; //tep_image(DIR_WS_IMAGES . 'imnd.svg', $products_images_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

                                                    }else{
  $product['image']			= '<img src="images/'. 'imnd.svg'  .'" height="'. HEADING_IMAGE_HEIGHT .'"   width="'. SMALL_IMAGE_WIDTH .'"></a>' . '</a>'; //tep_image(DIR_WS_IMAGES . 'imnd.svg', $products_images_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                                                  }
                                                                 }
                                                           
                              if (file(DIR_WS_IMAGES . $products_images['products_image'])) {
$product['image']			=       '<img src="'. $ref_fabricante['proveedor_ruta_images'] . $products_images['products_image']  .'" width="'. SMALL_IMAGE_WIDTH .'" height="'. SMALL_IMAGE_HEIGHT  .'" ></a>' . '</a>';

                          }
                                                           
                                                           


        require(TMPL_DIR. 'templ_product_box.php');



              $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top">'.$az_product_html.$texto_stock;


              // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 1 . "'");
       if ($product_compartir = tep_db_fetch_array($product_compartir_values)){
     ?>
                  <?php  $prod_list_contents .= '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine_propio.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
                             ?>
                                    <?php


                $prod_list_contents .= '';
    }



              // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
       WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){
     ?>
                  <?php  $prod_list_contents .= '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
                             ?>
                                    <?php


                $prod_list_contents .= '';
    }


        $col ++;



} else {










                                                                                     //'no-foto.jpg'
//$product['image']			= tep_image($ref_fabricante['proveedor_ruta_images'] . $products_images['products_image'], $products_images_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

$product['image']			=       '<a href="'. $ref_fabricante['proveedor_ruta_images'] . $products_images['products_image'] .'"><img src="'. $ref_fabricante['proveedor_ruta_images'] . $products_images['products_image']  .'" width="'. SMALL_IMAGE_WIDTH .'" height="'. SMALL_IMAGE_HEIGHT  .'" ></a>' . '</a>';



                      if (ACTIVO_NOFOTO == 'True'){

                                  require(TMPL_DIR. 'templ_product_box.php');

                                             $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top">'.$az_product_html.$texto_stock.$stock_exterior.'</td>';

        $col ++;
        
        


                  }else{
                       if ($_GET['keywords']) {

                                  require(TMPL_DIR. 'templ_product_box.php');

                                             $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top">'.$az_product_html.$texto_stock.$stock_exterior.'</td>';

        $col ++;

                              } // keywords
                                   } // nofoto

//$product['image']			= tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

 }

  }else{

           // si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^https://", $products_images['products_image']) ) {


 $product['image']			= tep_image('' . $products_images['products_image'], $products_images_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                   require(TMPL_DIR. 'templ_product_box.php');
                            $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top">'.$az_product_html.$texto_stock.'</td>';
        $col ++;






   if (@getimagesize($products_images['products_image'])) {


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

        if (@getimagesize(DIR_WS_IMAGES . $products_images['products_image'])) {

 $product['image']			= tep_image(DIR_WS_IMAGES . $products_images['products_image'], $products_images_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

            require(TMPL_DIR. 'templ_product_box.php');
            
            
            

              // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
       WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){
     ?>
                  <?php  $texto_stock .= '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
                             ?>
                                    <?php



    }

            
            
            
            
            
            
                        $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top">'.$az_product_html.$texto_stock.'</td>';

        $col ++;
        
   }else{


                 if (ACTIVO_NOFOTO == 'True'){
  $product['image']			= '<img src="images/'. 'imnd.svg'  .'" height="'. HEADING_IMAGE_HEIGHT .'"   width="'. SMALL_IMAGE_WIDTH .'"></a>' . '</a>'; //tep_image(DIR_WS_IMAGES . 'imnd.svg', $products_images_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);


    require(TMPL_DIR. 'templ_product_box.php');
                        $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top">'.$az_product_html.$texto_stock.'</td>';
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
