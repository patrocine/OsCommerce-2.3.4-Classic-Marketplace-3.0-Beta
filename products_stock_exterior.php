var saludo=""+
"<?php
if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');
  require('includes/configure.php');
   require(DIR_WS_FUNCTIONS . 'database.php');
  tep_db_connect() or die('Unable to connect to database server!');
  
    // ZONA CONSULTA Y DEVOLUCIÖN

$codigobarras = $_GET['codigobarras'];
$url = $_GET['url'];
$proveedor_id = $_GET['proveedor_id'];
$cPath = $_GET['cPath'];

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){

 $query = tep_db_query("SELECT * FROM `products_description` WHERE  products_id='" . $products['products_id'] . "'");
$id_d = tep_db_fetch_array($query);
 $query = tep_db_query("SELECT * FROM `configuration` WHERE  configuration_key='" . 'STORE_NAME' . "'");
$store_name = tep_db_fetch_array($query);


   echo 'Entrada desde: '.$store_name['configuration_value'];
   
                       $big = 1;
                $extra_values = tep_db_query("select * from " . 'products_extra_images' . " where products_id = '" . $products['products_id'] . "'");
               while ($extra=tep_db_fetch_array($extra_values)){


  $img .= 'products_extra_image_'.$big++. '=' . $extra['products_extra_image'].'&';

           }
           
           
                       $pvga = 1;
                $extra_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $products['products_id'] . "'");
               while ($extra=tep_db_fetch_array($extra_values)){


  $pvg .= 'products_groups_'.$pvga++. '=' . $extra['customers_group_price'].'&';

           }
   
   

                              $products_description = str_replace('"', '', $id_d['products_description']);
                                $products_name = str_replace(' ', '_', $id_d['products_name']);
                echo '<script language=javascript src=' . $url . '?codigobarras='. $codigobarras .'&cPath='.$cPath .'&products_name='.$products_name .'&products_price='.$products['products_price'] .'&products_image='.$products['products_image'] .'&proveedor_id='.$proveedor_id .'&products_youtube_1='.$products['products_youtube_1'] .'&products_youtube_2='.$products['products_youtube_2'] .'&referencia_padre='.$products['referencia_padre'] .'&referencia_padre_g2='.$products['referencia_padre_g2'] .'&referencia_padre_g3='.$products['referencia_padre_g3'] .'&products_cpe='.$products['products_cpe'] .'&products_cpf='.$products['products_cpf'] .'&products_rc='.$products['products_rc'] . '&' .$img.$pvg.'> </script>';


    }
 // header("Location: products_stock_exterior.php");


?>"+
 
"<?php




?>"+

    

    
"<?php








 ?></font>";

document.write(saludo);


