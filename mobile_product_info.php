<?php
require_once('mobile/includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_PRODUCT_INFO));
require(DIR_MOBILE_INCLUDES . 'header.php');

  if (!isset($HTTP_GET_VARS['products_id'])) {
        tep_redirect(tep_href_link(FILENAME_DEFAULT));
  }


  
        if ((int)$HTTP_GET_VARS['products_id']){
  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);


}else{
$pro_mo = $_GET['products_id'] ;

  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_model = '" . $pro_mo . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);

     $producto_values = mysql_query("select * from " . TABLE_PRODUCTS . " where products_model = '" . $pro_mo . "'");
    $producto= mysql_fetch_array($producto_values);

      $HTTP_GET_VARS['products_id'] = $producto['products_id'];
 }
  
  
?>
<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.8.22.min.js"></script>

<link rel="stylesheet" type="text/css" href="ext/jquery/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" src="ext/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<?php echo tep_draw_form('cart_quantity', tep_mobile_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'));

  if ($product_check['total'] < 1) {
?>
<div id="messageStack">
		<?php new infoBox(array(array('text' => TEXT_PRODUCT_NOT_FOUND))); ?>
		<?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_mobile_button(IMAGE_BUTTON_CONTINUE) . '</a>'; ?>
</div>
<?php
} else {


                  if ((int)$HTTP_GET_VARS['products_id']){
    $product_info_query = tep_db_query("select opcion_1, opcion_1_1,
                                               opcion_2, opcion_2_2,
                                               opcion_3, opcion_3_3,
                                               opcion_4, opcion_4_4,
                                               opcion_5, opcion_5_5,
                                               opcion_6, opcion_6_6,
                                               opcion_7, opcion_7_7,
                                               opcion_8, opcion_8_8,
                                               opcion_9, opcion_9_9,
                                               opcion_10, opcion_10_10, products_youtube_1, products_youtube_2, p.products_id, p.referencia_fabricante, pd.products_viewed, p.products_last_modified, p.products_date_added, pd.products_viewed, p.stock_disponible_proveedor, p.codigo_proveedor, p.stock_nivel, p.manufacturers_name, p.referencia_fabricante, p.products_status, p.time_entradasysalidas, p.time_mercancia_entregado_procesando, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

                           }else{

    $product_info_query = tep_db_query("select opcion_1, opcion_1_1,
                                               opcion_2, opcion_2_2,
                                               opcion_3, opcion_3_3,
                                               opcion_4, opcion_4_4,
                                               opcion_5, opcion_5_5,
                                               opcion_6, opcion_6_6,
                                               opcion_7, opcion_7_7,
                                               opcion_8, opcion_8_8,
                                               opcion_9, opcion_9_9,
                                               opcion_10, opcion_10_10, products_youtube_1, products_youtube_2, p.products_id, p.referencia_fabricante, pd.products_viewed, p.products_last_modified, p.products_date_added, pd.products_viewed, p.stock_disponible_proveedor, p.codigo_proveedor, p.stock_nivel, p.manufacturers_name, p.referencia_fabricante, p.products_status, p.time_entradasysalidas, p.time_mercancia_entregado_procesando, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_model = '" . $pro_mo . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);



                       }




               $products_id_stock = $product_info['products_id'];
         require('product_stock.php');



                 $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 1 . "'");
        if ($product_compartir = tep_db_fetch_array($product_compartir_values)){

 $stock_exterior .= '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine_propio.php?stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . '&web=' . $product_compartir['ruta_url'] . ' "> </script>';


    }

                 $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){

 $stock_exterior .= '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . '&web=' . $product_compartir['ruta_url'] . ' "> </script>';


    }





    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

            // PATROCINE
        if ($new_price = tep_get_products_special_price($product_info['products_id'])) {

    //GRUPO DE PRODUCTOS

        //sde pricemod
            global $customer_id;
          $customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . "        where customers_id =  '" . $customer_id . "'");
          $customer_group = tep_db_fetch_array($customer_group_query);

        $scustomer_group_price_query = tep_db_query("select customers_group_price from " . 'products_groups' . " where products_id = '" . (int)$HTTP_GET_VARS['products_id']. "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
        if ($scustomer_group_price = tep_db_fetch_array($scustomer_group_price_query))
        $new_price= $scustomer_group_price['customers_group_price'];

    //FIN

      $products_price = '<s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
      $products_price_limpio = '' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '';
 } else {

    //GRUPO DE PRODUCTOS
global $customer_id;
$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . 'products_groups' . " where products_id = '" . $HTTP_GET_VARS['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = $currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    $products_price_limpio = $customer_group_price['customers_group_price'];
  } else {
      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
      $products_price_limpio = $product_info['products_price'];
    }
} else {
    $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    $products_price_limpio = $product_info['products_price'];
  }
// FIN
    }

               //PATROCINE

ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $product_info['products_last_modified'], $mifecha);
$lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];

ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $product_info['products_date_added'], $mifechaalta);
$lafechaalta = $mifechaalta[3] . "/" . $mifechaalta[2] . "/" . $mifechaalta[1];



    if (tep_not_null($product_info['products_model'])) {
      $products_name .= $product_info['products_name'];


               if (INFO_REFERENCIA == 'True'){
$products_name .= '<br /><span class="smallText"> Referencia: [' . $product_info['products_model'] . ']</span>';
                                 }
               if (INFO_FABRICANTE == 'True'){
$products_name .= '<br /><span class="smallText"> Frabricante: [' . $product_info['manufacturers_name'] . ']</span>';
                                 }
               if (INFO_PARTNUMBER == 'True'){
$products_name .=     '<br /><span class="smallText"> PartNumber: [' . $product_info['referencia_fabricante'] . ']</span>';
                                 }
               if (INFO_FECHAALTA == 'True'){
$products_name .=    '<br /><span class="smallText"> Fecha de Alta: [' . $lafechaalta . ']</span>';
                                 }
               if (INFO_ULTIMAACTUALIZACION == 'True'){
$products_name .=    '<br /><span class="smallText"> Ultima Actualizacion: [' . $lafecha . ']</span>';
                                 }
               if (INFO_UNIDADESDISPONIBLES == 'True'){
$products_name .=    '<br /><span class="smallText"> Número de Unidades Disponibles: [' . $product_info['stock_disponible_proveedor'] . '] Pcs</span>';
                                 }
               if (INFO_VISTO == 'True'){
$products_name .=   '<br /><span class="smallText"> Visto: [' . $product_info['products_viewed'] . ']</span>';
                                 }
 } else {
      $products_name = $product_info['products_name'];
    }
	$headerTitle->write($product_info['products_name']);
?>

	<div id="ficheProdTop">
<?php
    if (tep_not_null($product_info['products_image'])) {
      $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");

      if (tep_db_num_rows($pi_query) > 0) {
?>

    <div id="piGal">
      <ul>

<?php
        $pi_counter = 0;
        while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;

          $pi_entry = '        <li><a href="';

          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '#piGalimg_' . $pi_counter;
          } else {
            $pi_entry .= tep_href_link(DIR_WS_IMAGES . $pi['image'], '', 'NONSSL', false);
          }

          $pi_entry .= '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $pi['image'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT) . '</a>';
          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '<div style="display: none;"><div id="piGalimg_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div></div>';
          }

          $pi_entry .= '</li>';

          echo $pi_entry;
        }
?>

      </ul>
    </div>
<?php
      } else {
?>









    <div id="piGal">
      <?php //echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image'], '', 'NONSSL', false) . '"  width="300" height="" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), null, null, 'width="300" height=""  hspace="5" vspace="5"') . '</a>'; ?>

<?php






                  $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $product_info['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){

if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $product_info['products_image'])) {
echo '<a href="' . $ref_fabricante['proveedor_ruta_images'] . $product_info['products_image'] . '" target="_blank" rel="fancybox">' . tep_image($ref_fabricante['proveedor_ruta_images'] . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, null, 'hspace="5" vspace="5"') . '</a>';
} else {
  echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, null, 'hspace="5" vspace="5"') . '</a>';
 }

  }else{

       if (ereg("^http://", $product_info['products_image']) ) {
    //$img = tep_image('' . $listing['products_image'], $listing['products_name'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT);
       ?>

   <p><a href="<?php echo $product_info['products_image'] ?>">
<img src="<?php echo $product_info['products_image'] ?>"
alt="<?php echo $product_info['products_name'] ?>"
title=" <?php echo $product_info['products_name'] ?> " height="" hspace="5" vspace="5" width="200"></a></p>
         </div>
  <?php
}else{

  ?>
<p><a href="<?php echo HTTP_COOKIE_PATH.'images/'.$product_info['products_image'] ?>">
<img src="<?php echo HTTP_COOKIE_PATH.'images/'.$product_info['products_image'] ?>"
alt="<?php echo $product_info['products_name'] ?>"
title=" <?php echo $product_info['products_name'] ?> " height="" hspace="5" vspace="5" width="200"></a></p>
    </div>

<?php

 }
    }


      }

         $extra_images_query = tep_db_query("select * from " . 'products_extra_images' . "        where products_id =  '" . (int)$product_info['products_id'] . "'");
       while ($extra_images = tep_db_fetch_array($extra_images_query)){



                  $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $product_info['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){

if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $extra_images['products_extra_image'])) {
echo '<a href="' . $ref_fabricante['proveedor_ruta_images'] . $extra_images['products_extra_image'] . '" target="_blank" rel="fancybox">' . tep_image($ref_fabricante['proveedor_ruta_images'] . $extra_images['products_extra_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, null, 'hspace="5" vspace="5"') . '</a>';
} else {
  //echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $extra_images['products_extra_image']) . '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, null, 'hspace="5" vspace="5"') . '</a>';
 }

  }else{

       if (ereg("^http://", $extra_images['products_extra_image']) ) {
    //$img = tep_image('' . $listing['products_image'], $listing['products_name'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT);
       ?>

   <p><a href="<?php echo $extra_images['products_extra_image'] ?>">
<img src="<?php echo $extra_images['products_extra_image'] ?>"
alt="<?php echo $product_info['products_name'] ?>"
title=" <?php echo $product_info['products_name'] ?> " height="" hspace="5" vspace="5" width="200"></a></p>
         </div>
  <?php
}else{
   if (@getimagesize(HTTP_COOKIE_PATH.'images/'.$extra_images['products_extra_image'])) {
  ?>
<p><a href="<?php echo HTTP_COOKIE_PATH.'images/'.$extra_images['products_extra_image'] ?>">
<img src="<?php echo HTTP_COOKIE_PATH.'images/'.$extra_images['products_extra_image'] ?>"
alt="<?php echo $product_info['products_name'] ?>"
title=" <?php echo $product_info['products_name'] ?> " height="" hspace="5" vspace="5" width="200"></a></p>
    </div>

<?php
}
 }
    }

    }


  ?>

<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>
<?php
    }
    
    
    
    



        if  ($product_info['manufacturers_name'] <> '' and $product_info['referencia_fabricante'] <> ''){
     $icecat = '#IceCat';
    }


  if (ereg("[^.]{30}", $product_info['products_description']) ) {
      $product_descripcion = '#Descripción';
}




?>






</div>
<div id="ficheProdTop">



		<h2> <?php include(DIR_WS_INCLUDES . 'products_next_previous.php'); ?></h2>
		<h2><?php echo $products_name; ?></h2>


       <?php
     if ($product_info['products_price'] == 0){
     $products_price = '';
     }else{
     ?>
<div class="prodPrice"><?php echo $products_price; ?></div>
     <?php }  ?>








                             <?php if (BOTON_STOCK == 'True'){ ?>
		<div class="prodPrice"><?php echo $texto_stock; ?></div>
        <div class="prodPrice"><?php echo $stock_exterior; ?></div>
                                           <?php } ?>



  
<div class="bouton">
    <?php
 // echo   '<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']) . '"><img src="' . DIR_MOBILE_IMAGES . 'btn_mob_cart.png" alt="' . IMAGE_BUTTON_IN_CART . '" /></a>';





?>
</div>






    
    

</div>
<div id="ficheProdTop">

		<?php
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
        $products_options_array = array();
        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
        while ($products_options = tep_db_fetch_array($products_options_query)) {
          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
          if ($products_options['options_values_price'] != '0') {
            $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
          }
        }

        if (is_string($HTTP_GET_VARS['products_id']) && isset($cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']])) {
          $selected_attribute = $cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']];
        } else {
          $selected_attribute = false;
        }
?>
<div class="options">
<strong><?php echo $products_options_name[''] . ''; ?></strong><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?>
</div>
<?php
      }
    }
?>
</div>
      <div id="ficheProdTop">
<div class="bouton">
    <?php
 echo   tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_mobile_button(IMAGE_BUTTON_IN_CART). '<br></form>';
?>
</div>
</div>













<div id="ficheProdMid">
<div class="description">
<?php



            echo '<p>Características</p>';




 ECHO '<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_1'] . ' ' . $product_info['opcion_1_1'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_2'] . ' ' . $product_info['opcion_2_2'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_3'] . ' ' . $product_info['opcion_3_3'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_4'] . ' ' . $product_info['opcion_4_4'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_5'] . ' ' . $product_info['opcion_5_5'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_6'] . ' ' . $product_info['opcion_6_6'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_7'] . ' ' . $product_info['opcion_7_7'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_8'] . ' ' . $product_info['opcion_8_8'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_9'] . ' ' . $product_info['opcion_9_9'] . '</p>
<p style="margin-top: 0; margin-bottom: 0">' .$product_info['opcion_10'] . ' ' . $product_info['opcion_10_10'] . '</p>';









	tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");
?>
	<?php echo stripslashes($product_info['products_description']); ?></p>

           <?php if ($product_info['products_youtube_1']){ ?>
 <iframe width='250' src='  <?php echo $product_info['products_youtube_1']?>' frameborder='0' allowfullscreen></iframe>
  <?php } ?>
  
      <?php if ($product_info['products_youtube_2']){ ?>
   <iframe width='250' src='  <?php echo $product_info['products_youtube_2']?>' frameborder='0' allowfullscreen></iframe>
  <?php } ?>


  <?php
        if (PERMISO_HISTORICO_PRECIO == 'True'){


   if ($product_info['products_price'] <> 0){
?>




<p>HISTÓRICOS DE PRECIOS</p>
<table border="0" width="39%" id="table1" cellspacing="0" style="font-size: 6pt; font-family: Verdana; font-weight: bold">
	<tr>
		<td>Fecha</td>
		<td>Precio</td>

  <?php
      $time2 = mktime(1, 1, 1, date("m"), date("d"), date("Y")-2);
    $fecha_pp = date("Y-m-d", $time2);
         //  and fecha >= '" . $fecha_pp . "'
         $seguimiento_precios_values = mysql_query("select * from " . 'products_seguimientos_precios' . " where products_id = '" . $product_info['products_id'] . "' and fecha >= '" . $fecha_pp . "' group by precio DESC order by fecha DESC");
   while  ($seguimiento_precios = mysql_fetch_array($seguimiento_precios_values)){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
     $fecha = date("Y-m-d", $time);

   //   tep_db_query("delete from " . 'products_seguimientos_precios' . " where precio = '" . $seguimiento_precios['precio'] . "' and products_id = '" . $product_info['products_id'] . "' and id <> '" . $seguimiento_precios['id'] . "'");

      ?>
	</tr>
	<tr>


		<td><?php echo  $seguimiento_precios['fecha']; ?></td>
		<td><?php echo $seguimiento_precios['precio']; ?>€




              <?php
           if ( number_format($product_info['products_price'], 2, '.', '') == $seguimiento_precios['precio']){
      echo '**';

 }
           ?>


            </td>

	</tr>


 <?php
}
   ?>










 <?php


           // porcentaje medio

    $precio_medio_total_sales_raw = "select sum(precio) as value, count(*) as precio from " . 'products_seguimientos_precios' . " where products_id = '" . $product_info['products_id'] . "' and fecha >= '" . $fecha_pp . "'";
    $precio_medio_total_sales_query = tep_db_query($precio_medio_total_sales_raw);
    $precio_medio_total= tep_db_fetch_array($precio_medio_total_sales_query);


    // primer precio


         $precio_antuguo_values = mysql_query("select * from " . 'products_seguimientos_precios' . " where products_id = '" . $product_info['products_id'] . "' and fecha >= '" . $fecha_pp . "' order by fecha ASC");
         $precio_antuguo = mysql_fetch_array($precio_antuguo_values);

     // ultimo precio

         $precio_ultimo_values = mysql_query("select * from " . 'products_seguimientos_precios' . " where products_id = '" . $product_info['products_id'] . "' and fecha >= '" . $fecha_pp . "' order by fecha DESC");
         $precio_ultimo = mysql_fetch_array($precio_ultimo_values);



       $precio_diferencia =  $precio_ultimo['precio']- $precio_antuguo['precio'];


              if ($precio_medio_total['value']){
       $precio_diferencia_porcent = ($precio_diferencia / $precio_antuguo['precio']) * 100;
                           }
   ?>

  	</tr>
	<tr>
		<td>Precio </td>
		<td>Medio</td>
	</tr>

  	</tr>
	<tr>
		<td><font color="#008000">La media es</font></td>
		<td><font color="#008000">  <?php
                if ($precio_medio_total['value']){
    ECHO number_format($precio_medio_total['value']/$precio_medio_total['precio'], 2, '.', '').'€';

        tep_db_query("delete from " . 'products_seguimientos_precios' . " where precio = '" .  0 . "' and products_id = '" . $product_info['products_id'] . "'");

              $sql_status_update_array = array('products_porcentage' => $precio_diferencia_porcent,);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $product_info['products_id'] . "'");


                                     }



    ?></font> </td>
	</tr>



        <?php  if ($precio_diferencia_porcent >= 0) { ?>

   	</tr>
	<tr>
		<td>Evolución </td>
		<td>Porcentaje</td>
	</tr>

  	</tr>
	<tr>
		<td><font color="#008000">Subida del</font></td>
		<td><font color="#008000">  <?php ECHO number_format($precio_diferencia_porcent, 2, '.', '').'%'; ?></font> </td>
	</tr>

              <?php
          }
           ?>

        <?php  if ($precio_diferencia_porcent <= 0) { ?>

   	</tr>
	<tr>
		<td>Evolución </td>
		<td>Porcentaje</td>
	</tr>

  	</tr>
	<tr>
		<td><font color="#FF0000">Bajada del</td> </font>
		<td><font color="#FF0000">  <?php ECHO number_format($precio_diferencia_porcent, 2, '.', '').'%'; ?></font> </td>
	</tr>

              <?php
          }
           ?>
   </table>

           <?php
        }

     } // permiso historico precios

             ?>






		<div class="options">




        <div class="f_left" style="width:80px;//display: none; clear:both">
					<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
					<div class="g-plusone" data-size="medium" data-count="true"></div>
    </div>

				<div class="f_left" style="width:65px">

					<div id="fb-root"></div>
					<script type="text/javascript">
						(function(d, s, id) {
					  		var js, fjs = d.getElementsByTagName(s)[0];
					  		if (d.getElementById(id)) return;
					 		 js = d.createElement(s); js.id = id;
					  		js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
					  		fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
					</script>

					<div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>

    </div>

				<div class="f_left"><a rel="nofollow" href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo HTTP_SERVER . DIR_WS_HTTP_CATALOG . 'product_info.php?products_id='.(int)$HTTP_GET_VARS['products_id']; ?>"

    data-text="<?php echo $products_price . ' ' . $product_info['products_name'] . '' . HASTAG_TWITTER . ' ' . $product_descripcion ; ?>"
      data-count="horizontal"
     data-via="<?php echo USER_TWITTER; ?>">
      </a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>


<a href="http://pinterest.com/pin/create/button/?url=<?php echo HTTP_SERVER; ?>%2Fproduct_info.php%3Fproducts_id%3D<?php echo (int)$HTTP_GET_VARS['products_id'] ?>%26osCsid%3Dk25i3g1cluqru8eufobt7nbtv1&media=<?php echo HTTP_SERVER . DIR_WS_HTTP_CATALOG ?>%2Fimages%2F<?php echo $product_info['products_image'] ?>&description=<?php echo $product_info['products_name'] . ' ' . $pinterest_precio; ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>   </div>







  </div>






      <?php

              echo '<p>&nbsp;</p>';
// Points/Rewards system V2.1beta BOF
    if ((USE_POINTS_SYSTEM == 'true') && (DISPLAY_POINTS_INFO == 'true')) {
	    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
		    $products_price_points = tep_display_points($new_price, tep_get_tax_rate($product_info['products_tax_class_id']));
	    } else {
		    $products_price_points = tep_display_points($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
	    }
	    $products_points = tep_calc_products_price_points($products_price_points);
	    $products_points_value = tep_calc_price_pvalue($products_points);
	    if ((USE_POINTS_FOR_SPECIALS == 'true') || $new_price == false) {
		    echo '<p>' . sprintf(TEXT_PRODUCT_POINTS , number_format($products_points,POINTS_DECIMAL_PLACES), $currencies->format($products_points_value)) . '</p>';
	    }
    }
// Points/Rewards system V2.1beta EOF


            echo '<p>&nbsp;</p>';






             $ref_fabri = ereg_replace("[[:space:]]", '', $product_info['referencia_fabricante']);
           //patrocine
        if  ($ref_fabricante['proveedor_ficha']){


      ?>


      <IFRAME WIDTH='250px' HEIGHT='350px' FRAMEBORDER='0' style='overflow-X: none;overflow-Y:auto;' src='  <?php echo $ref_fabricante['proveedor_ficha'] . $product_info['referencia_fabricante'] ?>'></IFRAME> </p>


<?php
    }
       //patrocine









           //patrocine
       if  ($product_info['manufacturers_name'] <> '' and $product_info['referencia_fabricante'] <> ''){
      ?>
      <IFRAME WIDTH="250" HEIGHT="700" FRAMEBORDER="0" style="overflow-X: none;overflow-Y:auto;" src="http://prf.icecat.biz/?shopname=openIcecat-url;smi=product;vendor=<?php echo $product_info['manufacturers_name']; ?>;prod_id=
<?php echo $product_info['referencia_fabricante']; ?>;lang=es"></IFRAME>
<?php
    }
       //patrocine

      ?>





               <?php if (INFO_HISTORIAL_ANALITICO == 'True'){  ?>

             <p><font size="6">Historial Analítico del Producto</font></p>

               <?php      if ($salidas_os){  ?>
              <p>Total de Unidades Vendidas:
     <?php


    echo  $salidas_os.' Pcs/Kg';
                  }

       $INFO_HISTORIAL_ANALITICO_DIAS = INFO_HISTORIAL_ANALITICO_DIAS;

        ?>

                      </p>
   <p>Totales Diarios ultimos <?php ECHO INFO_HISTORIAL_ANALITICO_DIAS; ?> Días</p>
<?php



              $orders_query = tep_db_query("select date_format(o.date_purchased, '%Y-%m-%d') as dateday, sum(ot.products_quantity) as total from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " ot, administrators a where date_sub(curdate(), interval $INFO_HISTORIAL_ANALITICO_DIAS day) <= o.date_purchased and o.orders_id = ot.orders_id and ot.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and o.orders_status = a.cobrado and a.admin_groups_id=6 or
                                                                                                                                                                                                                                                   date_sub(curdate(), interval $INFO_HISTORIAL_ANALITICO_DIAS day) <= o.date_purchased and o.orders_id = ot.orders_id and ot.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and o.orders_status = a.pagado and a.admin_groups_id=6  group by dateday ORDER BY o.date_purchased DESC");
      while ($orders = tep_db_fetch_array($orders_query)) {

               echo '<p>' . $orders['dateday'] .' / ' . $days[$orders['dateday']] = $orders['total'] . 'Pcs</p>';

     // echo $days[$orders['date_format']];

      }


     } // fin info historial analitico.


   ?>




</div>
<?php
if (tep_not_null($product_info['products_url'])) {
	?>
	<div class="description"><?php echo sprintf(TEXT_MORE_INFORMATION, tep_href_link(FILENAME_REDIRECT, 'action=url&goto=' . urlencode($product_info['products_url']), 'NONSSL', true, false)); ?></div>
			<?php
}

if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
	?>
	<div class="description"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></div>

			<?php
} else {
	?>

	<div class="description"><?php echo sprintf(TEXT_DATE_ADDED, tep_date_long($product_info['products_date_added'])); ?></div>

			<?php
}
?>

<div class="description">
<br>
<?php
			$reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and reviews_status = 1");
			$reviews = tep_db_fetch_array($reviews_query);

       	echo tep_draw_form('comments', tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS, tep_get_all_get_params(array('module'), 'SSL'))) . tep_mobile_button(IMAGE_BUTTON_REVIEWS . (($reviews['count'] > 0) ? ' (' . $reviews['count'] . ')' : '')) . "</form>";
?>
</div>
</div>
<?php
	if ((USE_CACHE == 'true') && empty($SID)) {
		if (tep_not_null(tep_cache_also_purchased(3600))) {
			?><div id="ficheProdMid"><?php
			echo tep_cache_also_purchased(3600);
			?></div><?php
		}
	} else {
		include(DIR_MOBILE_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
	}
}
?>




    <div id="ficheProdTop"> <?php
     if (INFO_ALERTAS == 'True'){
     ?>





          <?php


                $baja_email = $_GET['baja_email'];
                  $email_address = $_POST['email_address'];

          if ($baja_email){

  tep_db_query("delete from " . 'products_notificacion_cambios' . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and email = '" . $baja_email  . "'");

        echo '<p><b><font color="#FF0000">La Alerta se ha borrado con exito</font></b></p>';
      }


          if ($email_address){

                      $v_products_price = number_format($product_info['products_price'], 2, '.', '');
 $comprobar_query = tep_db_query("select * from " . 'products_notificacion_cambios' . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and email = '" . $email_address . "'");
if ($comprobar = tep_db_fetch_array($comprobar_query)){

echo '<p><b><font color="#FF0000">La Alerta ya esta activada</font></b></p>';




}else{

                         $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$fecha = date("Y-m-d", $time1);

      echo '<p><b><font color="#008000">Alerta activada</font></b></p>';

                $sql_data_array = array('products_id' => (int)$HTTP_GET_VARS['products_id'],
                                    'products_price' => $v_products_price,
                                    'email' => $email_address,
                                    'products_activado' => $product_info['products_status'],
                                    'fecha' => $fecha,);


          tep_db_perform('products_notificacion_cambios', $sql_data_array);


}





            } ?>



                           <?php


                              ?>












                 								<form method="POST" action="">

          <p style="margin-top: 0; margin-bottom: 0"><b>Deje su email y le avisamos cuando este producto cambie de precio (Solo se usa para la alerta)</b></p>
<p style="margin-top: 0; margin-bottom: 0"><input type="text" name="email_address" size="30"><input type="submit" value="EMAIL" name="B1"></p>
</form>

           <?php } ?>  </div>























<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
