<?php
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
echo 'sas';
?>






