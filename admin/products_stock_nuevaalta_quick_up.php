var saludo=""+
"<?php

// define how the session functions will be used
  require('includes/application_top.php');

  // ZONA CONSULTA Y DEVOLUCIÖN
  
$codigobarras = $_GET['codigobarras'];
$url = $_GET['url'];
 $codigo_proveedor_up_replace   = $_GET['codigo_proveedor_up_replace'];
$proveedor_id = $_GET['proveedor_id'];
$referencia_padre = $_GET['referencia_padre'];
 $products_youtube_1 = $_GET['products_youtube_1'];
 $products_youtube_2 = $_GET['products_youtube_2'];
 // $products_description = $_GET['products_description'];

 $products_image = $_GET['products_image'];
$products_name = $_GET['products_name'];

 $referencia_padre_g2 = $_GET['referencia_padre_g2'];
 $referencia_padre_g3 = $_GET['referencia_padre_g3'];
 
  $products_extra_image_1 = $_GET['products_extra_image_1'];
 $products_extra_image_2 = $_GET['products_extra_image_2'];
 $products_extra_image_3 = $_GET['products_extra_image_3'];
 $products_extra_image_4 = $_GET['products_extra_image_4'];
 $products_extra_image_5 = $_GET['products_extra_image_5'];
 $products_extra_image_6 = $_GET['products_extra_image_6'];
 $products_extra_image_7 = $_GET['products_extra_image_7'];
 $products_extra_image_8 = $_GET['products_extra_image_8'];

 
$products_description = $_GET['products_description'];


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



 $codigo_proveedor = $_GET['codigo_proveedor'];




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





 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and referencia_padre = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('referencia_padre' => $referencia_padre);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{

}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and referencia_padre_g2 = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('referencia_padre_g2' => $referencia_padre_g2);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{

}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and referencia_padre_g3 = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('referencia_padre_g3' => $referencia_padre_g3);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{

}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and products_cpe = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('products_cpe' => $products_cpe);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{

}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and products_cpf = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('products_cpf' => $products_cpf);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{

}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and products_rc = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('products_rc' => $products_rc);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{

}
                                              /*
 $query = tep_db_query("SELECT * FROM `products_description` WHERE  products_id='" . $products['products_id'] . "' and products_description = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('products_description' => $products_description);
            tep_db_perform('products_description', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{

}

                  */
                  
 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and codigo_proveedor = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){

                 }else{
         $sql_status_update_array = array('codigo_proveedor' => $codigo_proveedor);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");





}

                  
 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and products_youtube_1 = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){

                                                // if ($products_youtube_1 == ''){
                                               //  }else{
         $sql_status_update_array = array('products_youtube_1' => $products_youtube_1);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");
                                                 //  }
    }else{



}


 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and products_youtube_2 = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('products_youtube_2' => $products_youtube_2);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{



}

 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "' and products_image = '" . '' . "'");
if ($products = tep_db_fetch_array($query)){


         $sql_status_update_array = array('products_image' => $products_image);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

    }else{


}










  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $products_image == ''){
                                              }else{
         $sql_status_update_array = array('products_image' => $products_image);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}



  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $codigo_proveedor == ''){
                                                 }else{
         $sql_status_update_array = array('codigo_proveedor' => $codigo_proveedor);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}




  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $products_youtube_2 == ''){
                                              }else{
         $sql_status_update_array = array('products_youtube_2' => $products_youtube_2);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}

  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $products_youtube_1 == ''){

                                                }else{
         $sql_status_update_array = array('products_youtube_1' => $products_youtube_1);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");
                                               }
}


     // remplazar parametros

  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $referencia_padre == ''){
    }else{

         $sql_status_update_array = array('referencia_padre' => $referencia_padre);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}



  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $referencia_padre_g2 == ''){
    }else{

         $sql_status_update_array = array('referencia_padre_g2' => $referencia_padre_g2);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}


  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $referencia_padre_g3 == ''){
    }else{

         $sql_status_update_array = array('referencia_padre_g3' => $referencia_padre_g3);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}


   $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $products_cpe == ''){
    }else{

         $sql_status_update_array = array('products_cpe' => $products_cpe);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}

   $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $products_cpf == ''){
    }else{

         $sql_status_update_array = array('products_cpf' => $products_cpf);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}


   $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update' and  $products_rc == ''){
    }else{

         $sql_status_update_array = array('products_rc' => $products_rc);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}








                   $products_name = str_replace('_', ' ', $products_name);
  $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){


    if ($codigo_proveedor_up_replace == 'update'){

         $sql_status_update_array = array('products_name' => $products_name);
            tep_db_perform('products_description', $sql_status_update_array, 'update', " products_id='" . $products['products_id'] . "'");

}}



           echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><span style=\"background-color: #000000\">aa'. $codigo_proveedor_up_replace.'</span></p>';
           

  // echo ' Entrada en Almcen '.$store_name['configuration_value'] . ' ' , $codigobarras . ' ';
   if ($referencia_padre){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.$referencia_padre.'</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#FF0000>RPadre</font></b></p>';

}
   if ($referencia_padre_g2){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.'R.padre2'.'</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#FF0000>R.padre2</font></b></p>';

}

   if ($referencia_padre_g3){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.'R.padre3'.'</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#FF0000>R.padre3</font></b></p>';

}

   if ($products_cpe){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.'R.categ'.'</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#FF0000>R.categ</font></b></p>';

}

   if ($products_cpf){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.'R.Fabri'.'</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#FF0000>R.Fabri</font></b></p>';

}


   if ($products_image == ''){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color="#FF0000">Imagen</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.'Imagen'.'</font></b></p>';

}


  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>';

   if ($products_extra_image_1){
     echo '<font color=#008000>1';
}else{
    echo '<font color=#ff0000>1';
}
   if ($products_extra_image_2){
     echo '<font color=#008000>2';
}else{
    echo '<font color=#ff0000>2';
}
   if ($products_extra_image_3){
     echo '<font color=#008000>3';
}else{
    echo '<font color=#ff0000>3';
}

    if ($products_extra_image_4){
     echo '<font color=#008000>4';
}else{
    echo '<font color=#ff0000>4';
}
    if ($products_extra_image_5){
     echo '<font color=#008000>5';
}else{
    echo '<font color=#ff0000>5';
}
    if ($products_extra_image_6){
     echo '<font color=#008000>6';
}else{
    echo '<font color=#ff0000>6';
}
    if ($products_extra_image_7){
     echo '<font color=#008000>7';
}else{
    echo '<font color=#ff0000>7';
}
    if ($products_extra_image_8){
     echo '<font color=#008000>8';
}else{
    echo '<font color=#ff0000>8';
}

     echo     '</font></b></p>';









   if ($products_youtube_1){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.'Tube1'.'</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#FF0000>Tube1</font></b></p>';

}






   if ($products_youtube_2){
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#008000>'.'Tube2'.'</font></b></p>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><font color=#FF0000>Tube2</font></b></p>';

}
   if ($products_description){
   echo '<p style=\"margin-top: 0; margin-bottom: 0\"><a target=\"_blank\" href=\"'.$web['ruta_url'].'product_info.php?products_id='.$codigobarras.'\"><b><font color=#008000>Descrip</b></p></a></font>';
}else{
  echo '<p style=\"margin-top: 0; margin-bottom: 0\"><a target=\"_blank\" href=\"'.$web['ruta_url'].'product_info.php?products_id='.$codigobarras.'\"><b><font color=#FF0000>Descrip</b></p></a></font>';

}










  // echo ' Entrada en Almcen '.$store_name['configuration_value'] . ' ' , $codigobarras . ' ';

?>"+
 
"<?php




?>"+

    

    
"<?php








 ?></font>";

document.write(saludo);


