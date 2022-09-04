var saludo=""+
"<?php
if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');
  require('includes/configure.php');
   require(DIR_WS_FUNCTIONS . 'database.php');
  tep_db_connect() or die('Unable to connect to database server!');
  
  
  
   $products_model_stock = $_GET['products_model_stock'];
$almacen = $_GET['almacen'];
$web = $_GET['web'];
$status_agotado = $_GET['status_agotado'];
$status_stock = $_GET['status_stock'];
$status_pendiente = $_GET['status_pendiente'];

 $query = mysql_query("SELECT * FROM `products` WHERE  products_model='" . $products_model_stock . "' and stock_nivel = 6");
if ($products = mysql_fetch_array($query)){

   if ($products['time_entradasysalidas'] <=0){
   //  $imagen_stock = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pagotado.png> ';
    // $text_stock = ' ' . $status_agotado;
}else{
    // $imagen_stock = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pdisponible.png> ';
 $text_stock = '<a href='.$web.'product_info.php?products_id='.$products_model_stock.'><font color=#008000>'.$status_stock.'</a>';

 // $text_stock = ' '.$status_stock.'</a>';


    }




?>"+
 
"<?php

    if (PERMISO_INFO_STOCK == 'True'){

//echo $imagen_stock . $almacen . ' Stock: ' . number_format($products['time_entradasysalidas'], 0, '.', '') . ' Pcs.' . ' Pendiente: ' . $products['time_mercancia_entregado_procesando'] . ' Pcs.';
                          }else{

              if  ($products['time_mercancia_entregado_procesando'] >= 1 and $products['time_entradasysalidas'] <= 0 ){
//echo ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/ppendiente.png> ' . $almacen . $status_pendiente;
}else{

echo $imagen_stock . $almacen . $text_stock . $products['time_entradasysalidas'].'prueba';

}

                      }




?>"+

    

    
"<?php }





  $codigo = $_GET['codigo'];
//  echo $products_id = $_GET['products_id'];

  echo $codigo = $_GET['codigo'];
   $products_id = $_GET['products_id'];
 echo $referencia2 = $_GET['referencia2'];

    if ($codigo){
	tep_db_query ("UPDATE " . 'products' . " SET
					codigo_barras = '" . $codigo . "'
					WHERE products_id = '" . $products_id . "'");
             }

    if ($referencia2){
	tep_db_query ("UPDATE " . 'products' . " SET
					products_model_2 = '" . $referencia2 . "'
					WHERE products_id = '" . $products_id . "'");
             }



 ?></font>";

document.write(saludo);


