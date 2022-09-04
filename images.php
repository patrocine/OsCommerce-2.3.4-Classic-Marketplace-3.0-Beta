<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');


  
  
  
  
  

    $proveedor_id = $_GET['proveedor_id'];
    $filtro = $_GET['filtro'];

      $imagenes = $_GET['imagenes'];
      $extra_imagenes = $_GET['extra_imagenes'];
      $repetidas = $_GET['repetidas'];


       $modelo = $_GET['modelo'];




        if ($modelo == 1){


          if ($imagenes){
                                                            // products_status = '1' and
$query = mysql_query("select * from " . 'products' . " where codigo_proveedor = '" . $proveedor_id . "' and filtro = '" . $filtro . "'");
while ($products_image = mysql_fetch_array($query)){

$proveedor_datos = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $proveedor_id . "'");
$proveedor_datos_x = mysql_fetch_array($proveedor_datos);

   $imagen_cortada = ereg_replace("^[a-z]+/", "", $products_image['products_image']);

    if (@getimagesize($proveedor_datos_x['proveedor_ruta_images']. $products_image['products_image'])) {
                            if ($repetidas == 1){

       echo '<p><a href="' . $proveedor_datos_x['proveedor_ruta_images_two'] . $imagen_cortada . '">'. $imagen_cortada . '</a></p>';
                                             } // fin repetidas

      }else{
                       // http://www2.megastore.es//web2/   http://mcsi.no-ip.biz/productos/
                      //  http://cluster.qicanarias.com/img/
        echo '<p><a href="' . $proveedor_datos_x['proveedor_ruta_images_two'] . $imagen_cortada . '">'. $imagen_cortada . '</a></p>';

    }

  }
  } // images
         if ($extra_imagenes){


$query = mysql_query("select * from " . 'products' . " p, " . 'products_extra_images' . " pei where p.products_id = pei.products_id and p.filtro = '" . $filtro . "' and p.codigo_proveedor = '" . $proveedor_id . "'");
while ($products_extraimage = mysql_fetch_array($query)){

$proveedor_datos = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $proveedor_id . "'");
$proveedor_datos_x = mysql_fetch_array($proveedor_datos);

    $imagen_cortada = ereg_replace("^[a-z]+/", "", $products_extraimage['products_extra_image']);


       if (@getimagesize($proveedor_datos_x['proveedor_ruta_images'] . $products_extraimage['products_extra_image'])) {

                                  if ($repetidas == 1){

        echo '<p><a href="' . $proveedor_datos_x['proveedor_ruta_images_two'] . $imagen_cortada . '">'. $imagen_cortada . '</a></p>';
                                         } // fin repetidas


     }else{

        echo '<p><a href="' . $proveedor_datos_x['proveedor_ruta_images_two'] . $imagen_cortada . '">'. $imagen_cortada . '</a></p>';

     }

  }



   echo 'FIN DEL LISTADO';


 } // extra images



}else{







          if ($imagenes){
                                                           // products_status = '1' and
$query = mysql_query("select * from " . 'products' . " where codigo_proveedor = '" . $proveedor_id . "' and filtro = '" . $filtro . "'");
while ($products_image = mysql_fetch_array($query)){

$proveedor_datos = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $proveedor_id . "'");
$proveedor_datos_x = mysql_fetch_array($proveedor_datos);

   $imagen_cortada = ereg_replace("^[a-z]+/", "", $products_image['products_image']);


                       // http://www2.megastore.es//web2/   http://mcsi.no-ip.biz/productos/
                      //  http://cluster.qicanarias.com/img/
        echo '<p><a href="' . $proveedor_datos_x['proveedor_ruta_images_two'] . $imagen_cortada . '">'. $imagen_cortada . '</a></p>';



  }
  } // images
         if ($extra_imagenes){


$query = mysql_query("select * from " . 'products' . " p, " . 'products_extra_images' . " pei where p.products_id = pei.products_id and p.filtro = '" . $filtro . "' and p.codigo_proveedor = '" . $proveedor_id . "'");
while ($products_extraimage = mysql_fetch_array($query)){

$proveedor_datos = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $proveedor_id . "'");
$proveedor_datos_x = mysql_fetch_array($proveedor_datos);

    $imagen_cortada = ereg_replace("^[a-z]+/", "", $products_extraimage['products_extra_image']);




        echo '<p><a href="' . $proveedor_datos_x['proveedor_ruta_images_two'] . $imagen_cortada . '">'. $imagen_cortada . '</a></p>';


  }



   echo 'FIN DEL LISTADO';


 } // extra images





}
  
  
  
  
?>















<?php

?>
