var saludo=""+
"<?php
if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');
  require('includes/configure.php');
   require(DIR_WS_FUNCTIONS . 'database.php');
  tep_db_connect() or die('Unable to connect to database server!');
  

  
   $products_model_stock = $_GET['products_model_stock'];
$almacen = $_GET['almacen'];
$almacenpro = $_GET['almacenpro'];
$web = $_GET['web'];
$status_agotado = $_GET['status_agotado'];
$status_stock = $_GET['status_stock'];
$status_pendiente = $_GET['status_pendiente'];

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $products_model_stock . "' and stock_nivel = 6");
if ($products = tep_db_fetch_array($query)){


 $stock_nivel_values = tep_db_query("select * from " . 'products_stock' . " where products_id = '" . $products['products_id'] . "'");
             $stock_nivel= tep_db_fetch_array($stock_nivel_values);
             
    $configurations = tep_db_query("select configuration_value from " . 'configuration' . " where configuration_key='PERMISO_STOCK_UNIDADES' limit 1");
    $pstock = tep_db_fetch_array($configurations);
    $configurations = tep_db_query("select configuration_value from " . 'configuration' . " where configuration_key='PERMISO_PENDIENTE_UNIDADES' limit 1");
    $ppendiente = tep_db_fetch_array($configurations);


                                                         if ($pstock['configuration_value'] == 'true'){
                      $unidades_stock_text = ' (' . $stock_nivel['products_stock_real'] . ' Pcs)</a>';
                                                    }
                                                         if ($ppendiente['configuration_value'] == 'true'){
                      $unidades_pendiente_text = ' (' . $stock_nivel['products_stock_pendiente'] . ' Pcs)</a>';
                                                    }

                                                    

   if ($stock_nivel['products_stock_real'] <=0){
   $imagen_stock = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pagotado.png> ';
     $text_stock = ' ' . $status_agotado;
}else{
     $imagen_stock = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pdisponible.png> ';
     $text_stock = '<a href='.$web.'product_info.php?products_id='.$products_model_stock.'><font color=#008000>'.$status_stock . $unidades_stock_text;

 // $text_stock = ' '.$status_stock.'</a>';


    }

   if ($stock_nivel['products_stock_pendiente'] <=0){
   $imagen_stock_pendiente = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pagotado.png> ';
     $text_stock_pendiente = ' ' . $status_agotado;
}else{
   //  $imagen_stock_pendiente = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pdisponible.png> ';
     $text_stock_pendiente = ' Pendiente: ' . $unidades_pendiente_text;

 // $text_stock = ' '.$status_stock.'</a>';


    }


?>"+
 
"<?php

   if ($stock_nivel['products_stock_real'] <=0){

}else{

    if (PERMISO_INFO_STOCK == 'True'){

echo $imagen_stock . $almacen . ' Stock: ' . number_format($stock_nivel['products_stock_real'], 0, '.', '') . ' Pcs.' . ' Pendiente: ' . $stock_nivel['products_stock_pendiente'] . ' Pcs.';
                          }else{

              if  ($stock_nivel['products_stock_pendiente'] >= 1 and $stock_nivel['products_stock_real'] <= 0 ){
echo ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/ppendiente.png> ' . $almacen . $status_pendiente . ' Stock: ' . $products['time_entradasysalidas'];
}else{

echo $imagen_stock . $almacen . $text_stock;

}
}
                      }







   if ($stock_nivel['products_stock_pendiente'] <=0){

}else{

    if (PERMISO_INFO_STOCK == 'True'){

echo $imagen_stock . $almacen . ' Stock: ' . number_format($stock_nivel['products_stock_real'], 0, '.', '') . ' Pcs.' . ' Pendiente: ' . $stock_nivel['products_stock_pendiente'] . ' Pcs.';
                          }else{

              if  ($stock_nivel['products_stock_pendiente'] >= 1 and $stock_nivel['products_stock_real'] <= 0 ){
echo ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/ppendiente.png> ' . $almacen . $status_pendiente . ' Pendiente: ' . $stock_nivel['products_stock_pendiente'];
}else{

echo $imagen_stock_pendiente . $almacen . $text_stock_pendiente;

}
}
                      }









?>"+

    

    
"<?php } ?></font>";

document.write(saludo);


