<?php
  require(DIR_MOBILE_CLASSES . 'split_page_results_ajax.php');
  $listing_split = new splitPageResultsAjax($listing_sql, 40, 'p.products_id');
  $listing_split->generateJS();
?>
<!-- products //-->
<div id="prodFrame">
<!--  ajax_results_begining -->
<?php
$num_of_columns = 2;
	$row = 0;
  	$col = 0;
    $listing_query = tep_db_query($listing_split->sql_query);
    while ($listing = tep_db_fetch_array($listing_query)) {
		if ($col >= $num_of_columns) {
			$col = 0;
			echo "<br />";
		} 
  
  

        

            // PATROCINE
        if ($new_price = tep_get_products_special_price($listing['products_id'])) {

    //GRUPO DE PRODUCTOS

        //sde pricemod
            global $customer_id;
          $customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . "        where customers_id =  '" . $customer_id . "'");
          $customer_group = tep_db_fetch_array($customer_group_query);

        $scustomer_group_price_query = tep_db_query("select customers_group_price from " . 'products_groups' . " where products_id = '" . $listing['products_id']. "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
        if ($scustomer_group_price = tep_db_fetch_array($scustomer_group_price_query))
        $new_price= $scustomer_group_price['customers_group_price'];

    //FIN

      $price = '<s>' . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
      $products_price_limpio = '' . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '' . $currencies->display_price($new_price, tep_get_tax_rate($listing['products_tax_class_id'])) . '';
 } else {

    //GRUPO DE PRODUCTOS
global $customer_id;
$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . 'products_groups' . " where products_id = '" . $listing['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $price = $currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id']));
    $products_price_limpio = $customer_group_price['customers_group_price'];
  } else {
      $price = $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
      $products_price_limpio = $listing['products_price'];
    }
} else {
    $price = $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
    $products_price_limpio = $listing['products_price'];
  }
// FIN
    }

               //PATROCINE
        
        
        
        $buy_button = '<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']) . '"><img src="' . DIR_MOBILE_IMAGES . 'btn_mob_cart.png" alt="' . IMAGE_BUTTON_IN_CART . '" /></a>';

  
                                //tep_mobile_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id'])
    	$path = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'mobile_product_info.php?cPath=' . $cPath  . '&products_id='. $listing['products_id'] . '">';
     
     
     

               $products_id_stock = $listing['products_id'];
         require('product_stock.php');


               $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $codigo_proveedor_stock . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){

 if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $listing['products_image'])) {

 $img = tep_image($ref_fabricante['proveedor_ruta_images'] . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

        ?>
					<div id="prodCell">
					<div class="prodImg"><?php echo $path . $img . '</a>'; ?></div>
					<div class="prodName"><?php
						if (strlen($listing['products_name']) > MOBILE_PRODUCT_NAME_LENGTH)
						{
							echo $path . substr($listing['products_name'], 0, MOBILE_PRODUCT_NAME_LENGTH) . '...</a>' . '</p></b></a><b><font size="5">Cod.'.$listing['products_id'].'</font>';
						}
						else
						{
							echo $path . $listing['products_name']. '</a>'.'</p></b></a><b><font size="5">Cod.'.$listing['products_id'].'</font>';
						}


                        ?>
      </div>
      
      
<?php

       if (PERMISO_PORCENTAGE_PRECIO == 'True'){

  if ($listing['products_porcentage'] <= -0.1){

         $porcentage = '<div class="prodPrice"><font color="#FF0000">' . $listing['products_porcentage'].'%'.'</font></div>';
}else if ($listing['products_porcentage'] >= 0.1){
                     if (PERMISO_PORCENTAGE_PRECIO_MAS == 'True'){
         $porcentage = ' <div class="prodPrice"><font color="#00FF00">' . '+'.$listing['products_porcentage'].'%'.'</font></div>';
                                           }else{
                                      $porcentage = '';
                                      }


           }else{
              $porcentage = '';
           }

       } // permiso porcentaje precio.
 ?>
 
 
   <?php echo $porcentage; ?>

 
      
      <?php
     if ($listing['products_price'] == 0){
     $price = '';
     }else{



     ?>

    <div class="prodPrice"><?php echo $price; ?></div>
     <?php }  ?>




      <?php
   $stock_query = tep_db_query("select * from " . 'products_stock' . " where  products_id = '" . $listing['products_id'] . "'");
 $p_stock = tep_db_fetch_array($stock_query);
      
      if (BOTON_COMPRA == 'True' and $listing['products_price'] <> 0){

      if ($p_stock['products_stock_real'] >= 1){

           ?>
  <div class="prodBuy"><?php echo $buy_button; ?></div>
     <?php
     
        }else{
         ?>
          <div class="prodBuy"><?php echo $buy_button; ?></div>

      <?php
         
    }
     
     }else{
   }  ?>

      <?php
      if (BOTON_STOCK == 'True'){
      ?>
      <div class="prodStock"><?php echo $texto_stock; ?></div>
      <div class="prodStock"><?php







               // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 1 . "'");
       if ($product_compartir = tep_db_fetch_array($product_compartir_values)){
 echo $stock_ex = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine_propio.php?stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . '&web=' . $product_compartir['ruta_url'] . '& "> </script>';
    }


              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
       WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){
 echo $stock_ex = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . '&web=' . $product_compartir['ruta_url'] . '& "> </script>';
    }










      ?></div>
     <?php }  ?>




    				</div>
<?php


} else {

  $img = tep_image($ref_fabricante['proveedor_ruta_images'] . 'no-foto.jpg', $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

                        // if ($HTTP_GET_VARS['keywords']){
                ?>
					<div id="prodCell">
					<div class="prodImg"><?php echo $path . $img . '</a>'; ?></div>
					<div class="prodName"><?php
						if (strlen($listing['products_name']) > MOBILE_PRODUCT_NAME_LENGTH)
						{
							echo $path . substr($listing['products_name'], 0, MOBILE_PRODUCT_NAME_LENGTH) . '...</a>'. '</p></b></a><b><font size="5">Cod.'.$listing['products_id'].'</font>';
						}
						else
						{
							echo $path . $listing['products_name']. '</a>'.'</p></b></a><b><font size="5">Cod.'.$listing['products_id'].'</font>' ;
						}
						?></div>
      
      
      
      
      
      


<?php

       if (PERMISO_PORCENTAGE_PRECIO == 'True'){

  if ($listing['products_porcentage'] <= -0.1){

         $porcentage = '<div class="prodPrice"><font color="#FF0000">' . $listing['products_porcentage'].'%'.'</font></div>';
}else if ($listing['products_porcentage'] >= 0.1){

         $porcentage = ' <div class="prodPrice"><font color="#00FF00">' . '+'.$listing['products_porcentage'].'%'.'</font></div>';

           }else{
              $porcentage = '';
           }

       } // permiso porcentaje precio.
 ?>


   <?php echo $porcentage; ?>



      
      
      
      
      
      
      
                      <?php
     if ($price == 0){
     $price = '';
     }else{
     ?>
    <div class="prodPrice"><?php echo $price; ?></div>
     <?php }  ?>
     
     

      <?php
      
        $stock_query = tep_db_query("select * from " . 'products_stock' . " where  products_id = '" . $listing['products_id'] . "'");
 $p_stock = tep_db_fetch_array($stock_query);
      
      if (BOTON_COMPRA == 'True' and $price <> ''){
             if ($p_stock['products_stock_real'] >= 1){
           ?>
  <div class="prodBuy"><?php echo $buy_button; ?></div>
     <?php
     }
     }else{


   }  ?>


    <?php
      if (BOTON_STOCK == 'True'){
      ?>
      <div class="prodStock"><?php echo $texto_stock; ?></div>
      <div class="prodStock"><?php


               // directamente el almacen de las tiendas
              $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
       WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){
     ?>
                  <?php echo $stock_ex = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico']  .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
  ?>
                                    <?php
    }




              ?></div>
     <?php //} // FIJN DE PALABRA CLAVE ?>


</div>
<?php

  }

 }

  }else{





   if (ereg("^http://", $listing['products_image']) ) {
    $img = tep_image('' . $listing['products_image'], $listing['products_name'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT);
    

    
        ?>
					<div id="prodCell">
					<div class="prodImg"><?php echo $path . $img . '</a>'; ?></div>
					<div class="prodName"><?php
						if (strlen($listing['products_name']) > MOBILE_PRODUCT_NAME_LENGTH)
						{
							echo $path . substr($listing['products_name'], 0, MOBILE_PRODUCT_NAME_LENGTH) . '...</a>'. '</p></b></a><b><font size="5">Cod.'.$listing['products_id'].'</font>';
						}
						else
						{
							echo $path . $listing['products_name'] . '</a>'. '</p></b></a><b><font size="5">Cod.'.$listing['products_id'].'</font>';
						}
						?></div>
                        <?php
     if ($listing['products_price'] == 0){
     $price = '';
     }else{
     ?>
    <div class="prodPrice"><?php echo $price; ?></div>
     <?php }  ?>



      <?php
      
 $stock_query = tep_db_query("select * from " . 'products_stock' . " where  products_id = '" . $listing['products_id'] . "'");
 $p_stock = tep_db_fetch_array($stock_query);

      
      if (BOTON_COMPRA == 'True' and $listing['products_price'] <> 0){

                    if ($p_stock['products_stock_real'] >= 1){


           ?>
  <div class="prodBuy"><?php echo $buy_button; ?></div>
     <?php
            }
     }else{
   }  ?>


    <?php
      if (BOTON_STOCK == 'True'){
      ?>
      <div class="prodStock"><?php echo $texto_stock; ?></div>
      <div class="prodStock"><?php echo $stock_exterior; ?></div>
     <?php }  ?>


   				</div>
<?php

     
     
}else{
    $img = tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT);
    
      if (@getimagesize(DIR_WS_IMAGES . $listing['products_image'])) {
          ?>
					<div id="prodCell">
					<div class="prodImg"><?php echo $path . $img . '</a>'; ?></div>
					<div class="prodName"><?php
						if (strlen($listing['products_name']) > MOBILE_PRODUCT_NAME_LENGTH)
						{
							echo $path . substr($listing['products_name'], 0, MOBILE_PRODUCT_NAME_LENGTH) . '...</a>'. '</a>'.'</b></a><b><font size="5">'.$listing['products_id'].'</font>';
						}
						else
						{
							echo $path . $listing['products_name'] . '</a>'. '</a>'.'</b></a><b><font size="5">'.$listing['products_id'].'</font>';
						}
						?></div>
      
      
      
      

      
      
      
      
      
      
      
                     <?php
     if ($listing['products_price'] == 0){
     $price = '';
     }else{
     ?>
    <div class="prodPrice"><?php echo $price; ?></div>
     <?php }  ?>


      <?php
      if (BOTON_COMPRA == 'True' and $listing['products_price'] <> 0){

           ?>
  <div class="prodBuy"><?php echo $buy_button; ?></div>
     <?php
     }else{
   }  ?>

    <?php
      if (BOTON_STOCK == 'True'){
      ?>
      <div class="prodStock"><?php echo $texto_stock; ?></div>
      <div class="prodStock"><?php echo $stock_exterior; ?></div>
     <?php }  ?>


  				</div>
<?php

  }
   }



   } // fin ref_fabricante




                    
     
     
     

     
     
     
     
     
     
     
     



























































		$col++;
      } 
	  while ($col % $num_of_columns != 0) {
			$col++;
			echo '<div id="empty"></div>';
	  } 
      
?>
</div>
<!--  ajax_results_ending -->
<?php
  if ($listing_split->number_of_rows > 0 ) {
?>
<div id="results">
<?php  if(AJAX_ENABLED == 'true') {?>
<script language="javascript"><!--
document.write('<?php echo $listing_split->display_ajax_msg(); ?>');
--></script>
<noscript>
    <?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?>
	<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
</noscript>
<?php  } else { ?>

    <?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?>
	<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>

<?php  }
  }
?>
