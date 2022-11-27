var s=""+
"<?php

  require('includes/configure.php');


// include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
  tep_db_connect() or die('Unable to connect to database server!');

// set the application parameters
  $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . 'configuration');
  while ($configuration = tep_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

   $pro_ale = $_GET['pro_ale'];
    
  if ($pro_ale <= 11){




            if (SHOPTOSHOP_MODO == 1){
$query = tep_db_query("select p.products_image, p.codigo_proveedor, p.products_id, p.products_price, pd.products_name from " . 'products' . " p, " . 'products_description' . " pd where p.products_id = pd.products_id and p.products_status = '1' and p.products_price <> 0 ORDER BY RAND() LIMIT 10");
                                  }else if (SHOPTOSHOP_MODO == 2){
$query = tep_db_query("select p.products_image, p.codigo_proveedor, p.products_id, p.products_price, pd.products_name from " . 'products' . " p, " . 'products_description' . " pd, " . 'specials' . " s where p.products_id = pd.products_id and p.products_id = s.products_id and s.status = 1 and p.products_status = '1' and p.products_price <> 0 ORDER BY RAND() LIMIT 10");
                                  }else if (SHOPTOSHOP_MODO == 3){
$query = tep_db_query("select p.products_image, p.codigo_proveedor, p.products_id, p.products_price, pd.products_name from " . 'products' . " p, " . 'products_description' . " pd where p.products_id = pd.products_id and p.products_shoptoshop = 1 and p.products_status = '1' and p.products_price <> 0 ORDER BY RAND() LIMIT 10");
                                   }
?>"+
"<table align=center border=0 cellpadding=0 cellspacing=0 style=border-collapse: collapse bordercolor=#111111 width=100%>"+
  "<tr>"+
    "<td width=100%>"+
    "<p align=center><b><font face=Tahoma size=2><?php echo STORE_NAME . '<p style=margin-top: 0; margin-bottom: 0></p>'?></font></b></td>"+
  "</tr> "+
"</table>  "+

"<?php
while ($products_image = tep_db_fetch_array($query)){
   // Busca comillas (") en el texto del nombre y las elimina, el scrip es incompatible con las comillas.
                       $nombre_producto = ereg_replace("[\"]", '', $products_image['products_name']);
                       
                       
                       
                $ref_fabricante_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $products_image['codigo_proveedor'] . "'");
               $ref_fabricante= tep_db_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){


     $image_sc = $ref_fabricante['proveedor_ruta_images'] . $products_image['products_image'];
  }else{

// si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^http://", $products_image['products_image']) ) {

      $image_sc = $products_image['products_image'];
}else{

     $image_sc = $products_image['products_image'];

  }


   } // fin ref_fabricante



   if (ereg("^https://", $products_image['products_image']) ) {

      $image_sc = $products_image['products_image'];
}else{

       $image_sc = $ref_fabricante['proveedor_ruta_images'] . $products_image['products_image'];

  }



$products_price = '<p><p align=center><font face=Verdana ><font size=5><b>' . number_format($products_image['products_price'], 2, ",", ".") . 'Eur</a></font></p>';


                         // Total CON EL DESCUENTO DEL PRODUCTO
                                     if (DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $products_image['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'];

            $products_price = '<s>' .  $currencies->display_price($products_image['products_price'], tep_get_tax_rate($products_image['products_tax_class_id'])) . '</s>&nbsp;
              <font color=#FF0000 size=5><b>' . $currencies->display_price($products_image['products_price'] *$customers_porcentage/100+$products_image['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';




      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] <> 0 ){


 }else{


      $customers_porcentage = DESCUENTO_CLIENTE;
              if (DESCUENTO_CLIENTE <> 0){
            $products_price2 = number_format($products_image['products_price'], 2, ",", ".") . 'Eur'. '</s> &nbsp;<b><font size=5 color=#FF0000>'.number_format($products_image['products_price'] *DESCUENTO_CLIENTE/100+$products_image['products_price'], 2, ",", ".");
            $products_price =  '<p><p align=center><font face=Verdana > <a href=' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'product_info.php?ref='.$affiliate_id.'&products_id=' . $products_image['products_id'] . '><s>' . $products_price2 .'</a></font></p>';


                                  }


}


  }
         } // Total CON EL DESCUENTO DEL PRODUCTO


    $pro_special_values = tep_db_query("select * from " . 'specials' . " where products_id = '" .  $products_image['products_id'] . "'");
    $pro_special = tep_db_fetch_array($pro_special_values);


        if ($pro_special['specials_new_products_price']) {

            $products_price2 = number_format($products_image['products_price'], 2, ",", ".") . 'Eur'. '</s> &nbsp;<b><font size=5 color=#FF0000>'.number_format($pro_special['specials_new_products_price'], 2, ",", ".").'Eur';
            $products_price =  '<p><p align=center><font face=Verdana > <a href=' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'product_info.php?ref='.$affiliate_id.'&products_id=' . $products_image['products_id'] . '><s>' . $products_price2 .'</a></font></p>';

            }




                       
?>"+

        "        <hr size=15 noshade color=#000000> "+
"<table border=0 cellpadding=0 cellspacing=0 style=border-collapse: collapse bordercolor=#111111 width=100%>"+
"<tr>"+
"<td width=100%>"+
"<p align=center style=margin-top: -10; margin-bottom: 0> <p align=center><?php echo '<a href=' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'product_info.php' . '?ref=' . $affiliate_id . '&products_id=' . $products_image['products_id'] . '><img border=0 src='. $image_sc .' width=100 alt=></p>'; ?></td></p> "+
"  <tr>  "+
"    <td width=100%> "+
"    <p align=center style=margin-top: -10; margin-bottom: 0><?php echo '<p><p align=center><font face=Verdana size=1 ><a href=' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'product_info.php?ref='. AFFILIATE_MARKETPLACE .'&products_id=' . $products_image['products_id'] . '>' . $nombre_producto . '</a></font></p>'; ?></td> "+
"  </tr>"+
"    <td width=100%> "+
"    <p align=center style=margin-top: -10; margin-bottom: 0><?php echo $products_price; ?> </td>"+
"  </tr>"+


"</table>  "+




" <?php } }








?>"+






"    <p align=center style=margin-top: 0; margin-bottom: 0>	Enlace del Banner <?php  echo HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'enlace.php' ?> </td></a> ";




document.write(s);
