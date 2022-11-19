<?php

 if (@getimagesize(HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . DIR_WS_IMAGES. $products_imagen)) {
                                          }else{


               if (ereg("^https://", $products_imagen) ) {

                 $image_product = $products_imagen;
               }else{
        $image_product = 'images/' . 'imnd.svg';
}                }

                               //IMAGENES PRODUCTOS
  $codigo_proveedor_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $codigo_proveedor . "'");
  $codigo_proveedor= tep_db_fetch_array($codigo_proveedor_values);


 if (file($codigo_proveedor['proveedor_ruta_images'] . $products_imagen)) {
 $image_product = $codigo_proveedor['proveedor_ruta_images'] . $products_imagen;
}
                                          //  echo  $order->products[$i]['codigo_proveedor'];
if (@getimagesize(HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'images/' . $products_imagen)) {
        $image_product = DIR_WS_IMAGES . $products_imagen;
}












 ?>
 
 

