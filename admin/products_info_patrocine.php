var saludo=""+
"<?php
if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');
  require('includes/configure.php');
   require(DIR_WS_FUNCTIONS . 'database.php');
  tep_db_connect() or die('Unable to connect to database server!');
  
  
  
   $products_model_stock = $_GET['products_model_stock'];
$almacen = $_GET['almacen'];

 $query = mysql_query("SELECT * FROM `products` WHERE  products_model='" . $products_model_stock . "' and stock_nivel = 6");
if ($products = mysql_fetch_array($query)){

   if ($products['time_entradasysalidas'] <=0){
     $imagen_stock = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pagotado.png> ';
}else{

    $imagen_stock = ' </p> <p style=margin-top: 0; margin-bottom: 0><img border=0 src=images/otros/pdisponible.png> ';
}




?>"+
 
"<?php echo $imagen_stock . $almacen . ' Stock: ' . $products['time_entradasysalidas'] . ' Pcs.' . ' Pendiente: ' . $products['time_mercancia_entregado_procesando'] . ' Pcs.'; ?>"+

    

    
"<?php } ?></font>";

document.write(saludo);


