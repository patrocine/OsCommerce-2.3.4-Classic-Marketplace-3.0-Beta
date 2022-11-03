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

 $referencia_padre_g2 = $_GET['referencia_padre_g2'];
 $referencia_padre_g3 = $_GET['referencia_padre_g3'];
 $products_cpe = $_GET['products_cpe'];
 $products_cpf = $_GET['products_cpf'];
 $products_extra_image_1 = $_GET['products_extra_image_1'];
 $products_extra_image_2 = $_GET['products_extra_image_2'];
 $products_extra_image_3 = $_GET['products_extra_image_3'];
 $products_extra_image_4 = $_GET['products_extra_image_4'];
 $products_extra_image_5 = $_GET['products_extra_image_5'];
 $products_extra_image_6 = $_GET['products_extra_image_6'];
 $products_extra_image_7 = $_GET['products_extra_image_7'];
 $products_extra_image_8 = $_GET['products_extra_image_8'];


 $referencia_padre = $_GET['referencia_padre'];


  $query = tep_db_query("SELECT * FROM `products_compartir` WHERE  proveedor_id='" . 2 . "'");
 $web = tep_db_fetch_array($query);

 
$products_name = str_replace('_', ' ', $products_name);


 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
if ($products = tep_db_fetch_array($query)){





    }else{
 $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


     
     
 $query = tep_db_query("SELECT * FROM `products` WHERE  products_model='" . $codigobarras . "'");
 $id = tep_db_fetch_array($query);





}

 $query = tep_db_query("SELECT * FROM `configuration` WHERE  configuration_key='" . 'STORE_NAME' . "'");
$store_name = tep_db_fetch_array($query);



           echo '<p style=\"margin-top: 0; margin-bottom: 0\"><b><span style=\"background-color: #000000\">Updates</span></p>';
           
           
           


           
           
           
           
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


  
?>"+
 
"<?php




?>"+

    

    
"<?php








 ?></font>";

document.write(saludo);


