var saludo=""+
"<?php
// define how the session functions will be used
  require('includes/application_top.php');


    // ZONA CONSULTA Y DEVOLUCIÖN
  
$codigobarras = $_GET['codigobarras'];
$url = $_GET['url'];
$products_name = $_GET['products_name'];
$products_description = $_GET['products_description'];
$products_image = $_GET['products_image'];
$products_price = $_GET['products_price'];
$proveedor_id = $_GET['proveedor_id'];
 $products_youtube_1 = $_GET['products_youtube_1'];
 $products_youtube_2 = $_GET['products_youtube_2'];
 $referencia_padre = $_GET['referencia_padre'];
 $referencia_padre_g1 = $_GET['referencia_padre_g1'];
 $referencia_padre_g2 = $_GET['referencia_padre_g2'];
 $products_extra_image_1 = $_GET['products_extra_image_1'];
  $products_extra_image_2 = $_GET['products_extra_image_2'];
  $products_extra_image_3 = $_GET['products_extra_image_3'];
  $products_extra_image_4 = $_GET['products_extra_image_4'];
  $products_extra_image_5 = $_GET['products_extra_image_5'];
  $products_extra_image_6 = $_GET['products_extra_image_6'];
 $products_extra_image_7 = $_GET['products_extra_image_7'];
  $products_extra_image_8 = $_GET['products_extra_image_8'];
$cPath = $_GET['cPath'];



 $query = tep_db_query("SELECT * FROM `configuration` WHERE  configuration_key='" . 'ACTIVAR_REGLACATEGORIAS_REPOSITORIOS' . "'");
 $rc = tep_db_fetch_array($query);
     if ($rc['configuration_value'] == 'true'){
 $products_cpe = $_GET['products_cpe'];
 $products_cpf = $_GET['products_cpf'];
 $products_rc = $_GET['products_rc'];
                          }
                          
                     if ( $products_rc){
                   }else{
                  $products_rc = 2;
                  }
                          
 
$products_name = str_replace('_', ' ', $products_name);


 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){





    }else{
 $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

       $sql_data_array = array(//Comment out line you don't need
							'products_date_added' => $oldday1,
                            'stock_nivel' => 6,
                            'products_status' => 1,
                            'codigo_proveedor' => $proveedor_id,
                            'referencia_padre' => $referencia_padre,
                            'referencia_padre_g2' => $referencia_padre_g2,
                            'referencia_padre_g3' => $referencia_padre_g3,
                            'products_image' => $products_image,
                            'products_cpe' => $products_cpe,
                            'products_cpf' => $products_cpf,
                            'products_youtube_1' => $products_youtube_1,
                            'products_youtube_2' => $products_youtube_2,
                            'products_rc' => $products_rc,
                             'products_model' => $codigobarras,
                            'products_price' => $products_price);
     tep_db_perform('products', $sql_data_array);
     
     
 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
 $id = tep_db_fetch_array($query);


       $sql_data_array = array(//Comment out line you don't need
							'products_id' => $id['products_id'],
							'products_description' => $products_description,
                            'products_name' => $products_name);
     tep_db_perform('products_description', $sql_data_array);
     
     
       $sql_data_array = array(//Comment out line you don't need
							'products_id' => $id['products_id'],
                            'categories_id' => $cPath);
     tep_db_perform('products_to_categories', $sql_data_array);


}

 $query = tep_db_query("SELECT * FROM `configuration` WHERE  configuration_key='" . 'STORE_NAME' . "'");
$store_name = tep_db_fetch_array($query);





 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_1 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_1);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_1 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_1 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_2 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_2);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_2 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_2 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_3 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_3);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_3 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_3 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_4 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_4);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_4 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_4 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}


 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_5 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_5);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_5 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_5 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_6 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_6);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_6 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_6 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_7 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_7);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_7 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_7 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


 $query = tep_db_query("SELECT * FROM `products_extra_images` WHERE  products_extra_image='" . $products_extra_image_8 . "' and products_id='" . $products['products_id'] . "'");
if ($products_extra = tep_db_fetch_array($query)){

         $sql_status_update_array = array('products_extra_image' => $products_extra_image_8);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " products_extra_images_id='" . $products_extra['products_extra_images_id'] . "'");
                              }else{
                        if ($products_extra_image_8 == ''){
                        }else{
           $Query = "INSERT INTO " . 'products_extra_images' . " set
              products_extra_image = '" . $products_extra_image_8 . "',
              products_id = '" . $products['products_id'] . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();
                                 }

                          }
    }else{
}










   echo ' Entrada en Almcen '.$store_name['configuration_value'] . ' ' , $codigobarras . ' ';

  echo $products_name = str_replace('_', ' ', $products_name). ' '.$products_price;
?>"+
 
"<?php




?>"+

    

    
"<?php








 ?></font>";

document.write(saludo);


