<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');


?>

<h1><?php echo 'DESCRICIONES'; ?></h1>

<div class="contentContainer">
  <div class="contentText">



            <?php
            
            
 $codigobarras_des = $_GET['codigobarras_des'];
 $url = $_GET['url'];
$proveedor_id = $_GET['proveedor_id'];
$referencia_padre = $_GET['referencia_padre'];
 $products_youtube_1 = $_GET['products_youtube_1'];
 $products_youtube_2 = $_GET['products_youtube_2'];
            


 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras_des . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_description` WHERE  products_id='" . $products['products_id'] . "'");
$products_description = tep_db_fetch_array($query);


        echo $products_description['products_description'];

        ?>








       <?php
}




         //      "<script languaje='javascript' type='text/javascript'>window.close();</script>";
                    ?>




