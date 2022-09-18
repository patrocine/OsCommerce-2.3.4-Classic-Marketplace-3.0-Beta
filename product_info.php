<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

        $pro_mo = $_GET['products_id'] ;
        
        
             require('mobile_version_info.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);
  $product_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  


 // Begin product_previous_next
  include(DIR_WS_MODULES . 'products_next_previous.php');
// End product_previous_next

  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' or p.products_status = '1' and p.products_model= '" . $pro_mo . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);

  require(DIR_WS_INCLUDES . 'template_top.php');

  if ($product_check['total'] < 1) {
?>

<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_PRODUCT_NOT_FOUND; ?>
  </div>

  <div style="float: right;">
    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?>
  </div>
</div>

<?php


  } else {




    $product_info_query = tep_db_query("select opcion_1, opcion_1_1,
                                               opcion_2, opcion_2_2,
                                               opcion_3, opcion_3_3,
                                               opcion_4, opcion_4_4,
                                               opcion_5, opcion_5_5,
                                               opcion_6, opcion_6_6,
                                               opcion_7, opcion_7_7,
                                               opcion_8, opcion_8_8,
                                               opcion_9, opcion_9_9,
                                               opcion_10, opcion_10_10,
                                               products_youtube_1, products_youtube_2, p.codigo_proveedor, p.modificar_categoria_rdc, p.stock_disponible_proveedor, p.products_cpe, p.products_cpf, p.products_id, p.manufacturers_name, referencia_fabricante, time_mercancia_entregado_procesando, p.products_status, pd.products_name, pd.products_description, pd.products_viewed, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_last_modified, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' or p.products_status = '1' and p.products_model = '" . $pro_mo . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);



    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");


                  // calula el descuento de del cliente
       $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);



    
    
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
    
    
    

      $products_price_limpio = '' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '';
 } else {

    //GRUPO DE PRODUCTOS
global $customer_id;
$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . 'products_groups' . " where products_id = '" . $HTTP_GET_VARS['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {

           // calula el descuento de del cliente
           //   if ($customers_porcentage['customers_porcentage'] <> 0){
           //   $descuento_insert = $customers_porcentage['customers_porcentage'];
           //     $customer_group_price['customers_group_price'] = $customer_group_price['customers_group_price'] *$descuento_insert/100+$customer_group_price['customers_group_price'];
      //   }

    $products_price = $currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    $products_price_limpio = $customer_group_price['customers_group_price'];
  } else {
           // calula el descuento de del cliente
            //  if ($customers_porcentage['customers_porcentage'] <> 0){
             // $descuento_insert = $customers_porcentage['customers_porcentage'];
              //  $product_info['products_price'] = $product_info['products_price'] *$descuento_insert/100+$product_info['products_price'];
        // }

      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
      $products_price_limpio = $product_info['products_price'];
    }
} else {
           // calula el descuento de del cliente
           //   if ($customers_porcentage['customers_porcentage'] <> 0){
             // $descuento_insert = $customers_porcentage['customers_porcentage'];
               // $product_info['products_price'] = $product_info['products_price'] *$descuento_insert/100+$product_info['products_price'];
        // }
    $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    $products_price_limpio = $product_info['products_price'];
  }
// FIN
    }

               //PATROCINE
                                                                              // products_viewed


ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $product_info['products_last_modified'], $mifecha);
$lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];

ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $product_info['products_date_added'], $mifechaalta);
$lafechaalta = $mifechaalta[3] . "/" . $mifechaalta[2] . "/" . $mifechaalta[1];


    if (tep_not_null($product_info['products_model'])) {
      $products_name .= $product_info['products_name'];
      

      
      
      } else {
      $products_name = $product_info['products_name'];
    }
    
    

    //   if ($products_price == 0){
  // $products_price = '';
  //}





// Begin product_previous_next
  if ( ($product_check['total'] > 0) && ( (PREVIOUS_NEXT_PRODUCT_LINK_NAVIGATION == 'Top') || (PREVIOUS_NEXT_PRODUCT_LINK_NAVIGATION == 'Both') ) ) {

  }  echo $prevnextProductLinkDisplay;
// End product_previous_next


    
    
    
 //  include(DIR_WS_INCLUDES . 'products_next_previous.php');
    


$products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));


       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $product_info['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'].'%';
  $products_price = '<s>' .  $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="6"><b>' . $currencies->display_price($product_info['products_price'] *$customers_porcentage/100+$product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</b></font></span>';
           $price_descpro = $product_info['products_price'] *$customers_porcentage/100+$product_info['products_price'];

            if ($price_descpro == $product_info['products_price']){

$products_price = '<font color="#000000" size="6"><b>'.$currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</b></font></span>';
        }

}else{

     $products_price = '<font color="#000000" size="6"><b>'.$currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</b></font></span>';

}






                         // Total CON EL DESCUENTO DEL PRODUCTO
                              if ($customer_id <> 0 OR DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){

                                      if ($customer_id){
              $customers_porcentage = $products_porcentage['products_descuento'].'%';
              
            $products_price = '<s>' .  $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($product_info['products_price'] *$customers_porcentage/100+$product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</b></font></span>';



















                                                     }
      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] <> 0 ){

      $customers_porcentage = $customers_porcentage['customers_porcentage'].'%';
      
            $products_price = '<s>' .  $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($product_info['products_price'] *$customers_porcentage/100+$product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</b></font></span>';

      
 }else{

     $customers_porcentage = DESCUENTO_CLIENTE;
              if (DESCUENTO_CLIENTE <> 0){
            $products_price = '<s>' .  $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($product_info['products_price'] *$customers_porcentage/100+$product_info['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';





                                  }





  }

         } // Total CON EL DESCUENTO DEL PRODUCTO

    $pro_special_values = mysql_query("select * from " . 'specials' . " where products_id = '" .  (int)$HTTP_GET_VARS['products_id'] . "' and status = 1");
    if ($pro_special = mysql_fetch_array($pro_special_values)){

         $products_price = ' <font color="#FF0000" size="3"><b><s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span>' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</b></font></span>';
                                                           }

if ($customers_porcentage == 0){

        $customers_porcentage = '';

    }



}


    $pro_special_values = mysql_query("select * from " . 'specials' . " where products_id = '" .  (int)$HTTP_GET_VARS['products_id'] . "' and status = 1");
    if ($pro_special = mysql_fetch_array($pro_special_values)){

         $products_price = ' <font color="#FF0000" size="3"><b><s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span>' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</b></font></span>';
                                                           }




    $pdc_precio_final_values = mysql_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $product_info['products_id'] . "' order by pdc_unidades asc");
    while ($pdc_precio_final = mysql_fetch_array($pdc_precio_final_values)){

            $pdc_price_final .= '<p style="margin-top: 0; margin-bottom: 0"> <font size="3">+'.$pdc_precio_final['pdc_unidades'].' Pcs ->></s>
              <font color="#FF0000" size="3"><b>' . $pdc_precio_final['pdc_price_final'] . '€</b></font></span></p>';
              
              
            if ($products_price <> $product_info['products_price']){

$products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));


            }
              
              
              
              

                                                           }
?>

<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>

<div>
  <h1 style="float: right;"><?php

   if ($product_info['products_price'] <> 0 or $customer_group_price['customers_group_price'] <> 0){

       //'<p><font style="font-size: 24pt; font-weight: 700">'.
  echo ''.$products_price . '<p style="margin-top: 0; margin-bottom: 0">' . $pdc_price_final . '</p>';//.'</font><font color="#FF0000" size="6"><b> '.$customers_porcentage.'</b></font></p>';
  

                   }


  ?></h1>
  <h1><?php echo $products_name; ?></h1>
</div>









  <?php

  echo '<p>&nbsp;</p>';

    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
?>

    <p><?php echo TEXT_PRODUCT_OPTIONS; ?></p>

    <p>
<?php
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
      <strong><?php echo $products_options_name['products_options_name'] . ':'; ?></strong><br /><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?><br />
<?php
      }
?>
    </p>

<?php
  }
?>
















<div class="contentContainer">
  <div class="contentText">

<?php
    if (tep_not_null($product_info['products_image'])) {
      $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");

      if (tep_db_num_rows($pi_query) > 0) {
?>

    <div id="piGal" style="float: right;">
      <ul>

<?php


























        $pi_counter = 0;
        while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;

          $pi_entry = '        <li><a href="';

          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '#piGalimg_' . $pi_counter;
          } else {
            $pi_entry .= tep_href_link(DIR_WS_IMAGES . $pi['image']);
          }

          $pi_entry .= '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $pi['image']) . '</a>';

          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '<div style="display: none;"><div id="piGalimg_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div></div>';
          }

          $pi_entry .= '</li>';

         // echo $pi_entry;
        }
?>



<script type="text/javascript">
$('#piGal ul').bxGallery({
  maxwidth: 300,
  maxheight: 200,
  thumbwidth: <?php echo (($pi_counter > 1) ? '75' : '0'); ?>,
  thumbcontainer: 300,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>

<?php
      } else {
?>

    <div id="piGal" style="float: right;">
      <?php


         $pi_query = tep_db_query("select * from " . 'products_extra_images' . " where products_id = '" . (int)$product_info['products_id'] . "' order by products_extra_image");

      if (tep_db_num_rows($pi_query) > 0) {


?>

    <div id="piGal" style="float: right;">
      <ul>

<?php




                              $pi_counter = 0;
        while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;

          $pi_entry = '        <li><a href="';

          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '#piGalimg_' . $pi_counter;
          } else {







                $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $product_info['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){


    // $image_sc = $ref_fabricante['proveedor_ruta_images'] . $pi['products_extra_image'];


if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $pi['products_extra_image'])) {
 $image_sc = $ref_fabricante['proveedor_ruta_images'] . $pi['products_extra_image'];
} else {



if (@getimagesize(DIR_WS_IMAGES . $pi['products_extra_image'])) {
     $image_sc = DIR_WS_IMAGES . $pi['products_extra_image'];
}else{
  $image_sc = '';
}


 }

       }else{

          $image_sc = DIR_WS_IMAGES . $pi['products_extra_image'];

   }












            $pi_entry .= $image_sc;
          }


                $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $product_info['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){


    // $image_sc = $ref_fabricante['proveedor_ruta_images'] . $pi['products_extra_image'];


if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $pi['products_extra_image'])) {
 $image_sc = '<img src='.$ref_fabricante['proveedor_ruta_images'] . $pi['products_extra_image']. ' width="150" height="">';
} else {


if (@getimagesize(DIR_WS_IMAGES . $pi['products_extra_image'])) {


     $image_sc = '<img src='. DIR_WS_IMAGES . $pi['products_extra_image']. ' width="150" height="">';
}else{
  $image_sc = '';
}

}

       }else{

if (@getimagesize(DIR_WS_IMAGES . $pi['products_extra_image'])) {


     $image_sc = '<img src='. DIR_WS_IMAGES . $pi['products_extra_image']. ' width="150" height="">';
}else{
  $image_sc = '';
}
         } // fin ref_fabricante






                                               // '<img src='.$image_sc. '>'

         $pi_entry .= '" target="_blank" rel="fancybox">' . $image_sc . '</a>';



          if (tep_not_null($pi['htmlcontent'])) {
            $pi_entry .= '<div style="display: none;"><div id="piGalimg_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div></div>';
          }

          $pi_entry .= '</li>';

      echo $pi_entry;
        }






if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $pi['products_extra_image'])) {
     $extra_imagenes_existe = (($pi_counter > 1) ? '0' : '0');
}else{
if (@getimagesize(DIR_WS_IMAGES . $pi['products_extra_image'])) {
   $extra_imagenes_existe = (($pi_counter > 1) ? '0' : '0');
}else{
}
}



 ?>

      </ul>
    </div>

<script type="text/javascript">
$('#piGal ul').bxGallery({
  maxwidth: 100,
  maxheight: 0,
  thumbwidth: <?php echo $extra_imagenes_existe; ?>,
  thumbcontainer: 100,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>

<?php
        
}



               $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $product_info['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);
                   // galeria $ref_fabricante['proveedor_ruta_images'].$product_info['codigo_proveedor'];
      if ($ref_fabricante['proveedor_ruta_images']){

if (getimagesize($ref_fabricante['proveedor_ruta_images']. $product_info['products_image'])) {
echo '<a href="' . $ref_fabricante['proveedor_ruta_images'] . $product_info['products_image'] . '" target="_blank" rel="fancybox">' . tep_image($ref_fabricante['proveedor_ruta_images'] . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, null, 'hspace="5" vspace="5"') . '</a>';
} else {

echo '<a href="'. $ref_fabricante['proveedor_ruta_images'] . $product_info['products_image'] .'"><img src="'. $ref_fabricante['proveedor_ruta_images'] . $product_info['products_image']  .'" width="'. SMALL_IMAGE_WIDTH .'"></a>' . '</a>';
//  echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, null, 'hspace="5" vspace="5"') . '</a>';
 }

  }else{

// si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^https://", $product_info['products_image']) ) {
  echo '<a href="' . $product_info['products_image'] . '" target="_blank" rel="fancybox">' . tep_image('' . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, null, 'hspace="5" vspace="5"') . '</a>';
}else{
   echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank" rel="fancybox">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, null, 'hspace="5" vspace="5"') . '</a>';
  }

// SE UTILIZA EL SUMADOR DE PRODUCTOS PARA GENERAR LA CONSULTA Y DESPUES GUARDARLA EN UNA TABLA PARA QUE ESTE PROCESO SE LO MENOS TARDIO POSIBLE.

   } // fin ref_fabricante








               $products_id_stock = $product_info['products_id'];
         require('product_stock.php');










          echo $texto_stock;




                 $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 1 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



               echo $stock_exterior = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine_propio.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';


    }

                 $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "' and almacenpro = '" . 0 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



               echo $stock_exterior = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_info_patrocine.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $products_model_stock .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';


    }




                       echo '<p></p>';





                         ?>


           
                                        <div><img src="http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo ' | ' . $product_info['products_model'] . ' | ' . $product_info['products_name'] . ' Por Solo ' . number_format($products_price_limpio, 2, '.', '').'Eur     ' . $product_url ; ?>" alt="QR:
<?php $product_info['products_name']; ?>" title="<?php $product_info['products_name']; ?>"/></div>



      <p>&nbsp;</p>



    </div>

      
      



      
    </div>

<?php


      }
?>

<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>







<?php
    }


  if ($product_info['manufacturers_name'] == 0){

    tep_db_query("delete from " . 'manufacturers' . " where manufacturers_name = '" . 0 . "'");


}

         // si se crea un manufactures sin nombre vacio '' lo borra, de lo contrario se borraria el nombre del facbricante del productos_info.php
      tep_db_query("delete from " . 'manufacturers' . " where manufacturers_name = '' ");

 $manufact_query = tep_db_query("select * from " . 'manufacturers' . "");
while ($manufact = tep_db_fetch_array($manufact_query)){

  // if (eregi('[[:blank:]]'.$manufact['manufacturers_name'].'[[:blank:]]', $product_info['products_name'])){

    if (preg_match("/\b".$manufact['manufacturers_name']."\b/i", $product_info['products_name'])){

 $reffab_query = tep_db_query("select * from " . 'products' . " where products_id = '" . $product_info['products_id'] . "' and manufacturers_name = '" . $manufact['manufacturers_name'] . "'");
 if ($reffab = tep_db_fetch_array($reffab_query)){



      //  echo  $manufact['manufacturers_name'];


}else{
            $sql_status_update_array = array('manufacturers_name' => $manufact['manufacturers_name'],);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $product_info['products_id'] . "'");





    /*

 $fabricantes_query = tep_db_query("select * from " . 'products_fabricantes' . " where  concepto = '" . 'cambio' . "' and products_reemplazar_este = '" . $product_info['manufacturers_name'] . "'");
 $fabricantes = tep_db_fetch_array($fabricantes_query);



  if ($fabricantes['products_reemplazar_poreste']){
      $product_info['manufacturers_name'] = $fabricantes['products_reemplazar_poreste'];


      $sql_status_update_array = array('manufacturers_name' => $product_info['manufacturers_name'],);
      tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $product_info['products_id'] . "'");


}


        */



      $redirect_fabricante = $_GET['redirect_fabricante'];



      if ($redirect_fabricante){
                            }else{

          ?>
        <script type="text/javascript">

       var pagina = 'product_info.php<?php echo '?products_id=' . (int)$HTTP_GET_VARS['products_id'] . '&redirect_fabricante=ok'.'&cPath='.$cPath ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>




   <?php
   } // redirect

}   // reffab
} // ereg
























} //manucfact







  $fabricantes_eliminar_query = tep_db_query("select * from " . 'products_fabricantes' . " where  concepto = '" . 'eliminar' . "' and products_reemplazar_este = '" . $product_info['manufacturers_name'] . "'");
 if ($fabricantes_eliminar = tep_db_fetch_array($fabricantes_eliminar_query)){

                                         //  echo $fabricantes_eliminar['products_reemplazar_este'];
                                           
   tep_db_query("delete from " . 'manufacturers' . " where manufacturers_name = '" . $fabricantes_eliminar['products_reemplazar_este'] . "'");
                                                                          }
    
 $fabricantes_query = tep_db_query("select * from " . 'products_fabricantes' . " where  concepto = '" . 'cambio' . "' and products_reemplazar_este = '" . $product_info['manufacturers_name'] . "'");
 $fabricantes = tep_db_fetch_array($fabricantes_query);
 


  if ($fabricantes['products_reemplazar_poreste']){
      $product_info['manufacturers_name'] = $fabricantes['products_reemplazar_poreste'];
      
      
      $sql_status_update_array = array('manufacturers_name' => $product_info['manufacturers_name'],);
      tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $product_info['products_id'] . "'");

      
}

    
    
         $product_info_referencia_fabricante = ereg_replace("[[:blank:]]", '', $product_info['referencia_fabricante']);
          $product_info_manufacturers_name = ereg_replace("[[:blank:]]", '', $product_info['manufacturers_name']);
          $product_info['products_model'] = ereg_replace("[[:blank:]]", '', $product_info['products_model']);

               if (INFO_REFERENCIA == 'True'){
$products_parametros .= '<br /><span class="smallText"> Referencia: [' . $product_info['products_model'] . ']</span>';
                                 }
               if (INFO_FABRICANTE == 'True' and $products_price <> 0){
$products_parametros .= '<br /><span class="smallText"> Frabricante: [' . $product_info_manufacturers_name . ']</span>';
                                 }
               if (INFO_PARTNUMBER == 'True' and $products_price <> 0){
$products_parametros .=     '<br /><span class="smallText"> PartNumber: [' . $product_info_referencia_fabricante . ']</span>';
                                 }
               if (INFO_FECHAALTA == 'True' and $products_price <> 0){
$products_parametros .=    '<br /><span class="smallText"> Fecha de Alta: [' . $lafechaalta . ']</span>';
                                 }
               if (INFO_ULTIMAACTUALIZACION == 'True' and $products_price <> 0){
$products_parametros .=    '<br /><span class="smallText"> Ultima Actualizacion: [' . $lafecha . ']</span>';
                                 }
               if (INFO_UNIDADESDISPONIBLES == 'True' and $products_price <> 0){
                   if ($product_info['stock_disponible_proveedor']){
$products_parametros .=    '<br /><span class="smallText"> Número de Unidades Disponibles: [' . $product_info['stock_disponible_proveedor'] . '] Pcs</span>';
                                 }}
               if (INFO_VISTO == 'True'){
$products_parametros .=   '<br /><span class="smallText"> Visto: [' . $product_info['products_viewed'] . ']</span>';
                                 }

//$products_parametros .=   '<br /><span class="smallText"> RDC: [' . $product_info['products_cpe'] . ']</span>';

//$products_parametros .=   '<br /><span class="smallText"> RDF: [' . $product_info['products_cpf'] . ']</span>';
                                            if (PERMISO_REGLADEPRECIOS_PRODUCTSINFO == 'True'){
//$products_parametros .=   '<br /><span class="smallText">RDC Activas</span>';
                                                                 }
     $categorias_id_values = tep_db_query("select cd.categories_name, cd.categories_id, c.parent_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_CATEGORIES . " c  where ptc.categories_id = cd.categories_id and c.categories_id = cd.categories_id and ptc.products_id= '" . $product_info['products_id'] . "'");
    while ($categorias_id = tep_db_fetch_array($categorias_id_values)){


 $categories_parentid_query = tep_db_query("select * from " . 'categories_description' . " where categories_id = '" . $categorias_id['parent_id'] . "'");
 $categories_parentid = tep_db_fetch_array($categories_parentid_query);

                                                                         // tep_href_link('index.php', 'products_id=' . $listing['products_id'].'&cPath='.$cPath);
  $products_parametros .=   '<br />Categoría: <a href="' . tep_href_link(FILENAME_DEFAULT, 'cPath='.$categorias_id['parent_id'] . '_' .$categorias_id['categories_id']) . '"><span class="smallText">' . $categories_parentid['categories_name'] . '/' . $categorias_id['categories_name'] . '</a></span>';
  $products_parametros .= '';
}
                               echo $products_parametros;

            echo '<p>&nbsp;</p>';
            
            
            
            
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




       $gallery_query = tep_db_query("select * from " . 'gallery_photos' . " where  products_model = '" . $product_info['products_model'] . "'");
      if ($gallery = tep_db_fetch_array($gallery_query)){

     ?>


           <a href="<?php echo tep_href_link(FILENAME_PHOTO_GALLERY . '?products_model=' . $product_info['products_model']);?>">Galería de Fotos Disponibles</a>


<table border="0" width="46%" id="table1">
	<tr>
<?php  $gallery2_query = tep_db_query("select * from " . 'gallery_photos' . " where  products_model = '" . $product_info['products_model'] . "' LIMIT 3");
      while ($gallery2 = tep_db_fetch_array($gallery2_query)){
 ?>
		<td width="4"><a href="<?php echo tep_href_link(FILENAME_PHOTO_GALLERY . '?products_model=' . $product_info['products_model']);?>"><img border="0" src="<?php echo 'images/gallery/' . $gallery2['gallery_photo'] ?>" height="75"></td>
  
  <?php
}

     ?>

	</tr>
</table>


                  <?php

                }
                     ?>




           <?php
            
             echo '<p>&nbsp;</p>';
    echo stripslashes($product_info['products_description']);


   ?>

 <iframe width='250' src='  <?php echo $product_info['products_youtube_1']?>' frameborder='0' allowfullscreen></iframe>
 <iframe width='250' src='  <?php echo $product_info['products_youtube_2']?>' frameborder='0' allowfullscreen></iframe>


           <?php

  echo '<p>&nbsp;</p>';

   if ($product_info['products_price'] <> 0){
?>



     <?php

       if (PERMISO_HISTORICO_PRECIO == 'True'){

         ?>


<table border="0" width="39%" id="table1" cellspacing="0" style="font-size: 6pt; font-family: Verdana; font-weight: bold">
                    <td>HISTÓRICOS DE PRECIOS</td>
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
        
        
        

        } // fin permiso historico de precios











     $rc_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_rc = 1 and products_id= '" . $product_info['products_id'] . "'");
     $rc = tep_db_fetch_array($rc_values);












                                                  //REGLAS DE CATEGORIAS



                                                 if (PERMISO_REGLADEPRECIOS_PRODUCTSINFO == 'True' and $rc['products_rc']  == 1 and $product_info['modificar_categoria_rdc'] == 0){



                                                          // echo 'SI';





                                              $v_products_id =   $product_info['products_id'];




                                                               //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                                         $v_categories_id_original = CATEGORIA_DEFECTO_RDC;





                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 2;
                                   // $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if ( time() >= $tiempo_3600hora){

         $sql_status_update_array = array('easypopulate_time2' => time()+rand(1,5));
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");



                                                             $tiempo_permiso = 1;
                                    echo '';
                                                             
                             }else{

                                echo '';
                         }
                                    echo '';
                             if ($tiempo_permiso == 1){

                                                         //seguridad
                               //     if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

 tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "'");



                     // si el producto no encuentra categoria se inserta en la categoría novedades definida en el listado exel.

    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "'");
    if ($cpe = tep_db_fetch_array($cpe_values)){


}else{

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id_original . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id_original . '")');
   } // CPCAT


}






      if ($wersdfs['products_cpf'] == 1){
          $wersdfs['products_cpf'] = 0;
      }
      if ($wersdfs['products_cpe'] == 1){
          $wersdfs['products_cpe'] = 0;
                        }



                  // cambio 12

                  // por número de categoria externa.
    $cpe_menosa_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' or cp_cf= '" . $wersdfs['products_cpf'] . "' and cp_cf >= '" . 1 . "'");
    while ($cpe_menosa = tep_db_fetch_array($cpe_menosa_values)){








                 // Reglas de Categorias por nombre en el producto.
   $cpe_menos_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_menosa['cp_ce_menosnombre_1'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_menosa['cp_ce_menosnombre_2'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_menosa['cp_ce_menosnombre_3'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_menos = tep_db_fetch_array($cpe_menos_values)){
                                         /*
          Reglas de categorias por referencia, configura la regla en el producto y el producto lo compara con su pareja
          en categories pareja


                                              */
            $sql_status_update_array = array('products_cp_ce_menosnombre_1' => $cpe_menosa['cp_ce_menosnombre_1'],
                                             'products_cp_ce_menosnombre_2' => $cpe_menosa['cp_ce_menosnombre_2'],
                                             'products_cp_ce_menosnombre_3' => $cpe_menosa['cp_ce_menosnombre_3']);
            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");



 }else{

 }




}// menosa



    $cpe_cpe_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.products_cpe like '%" . $cpe_menosa['cp_ce'] . "%' and p.products_id= '" . $v_products_id . "'");
     IF  ($cpe_cpe = tep_db_fetch_array($cpe_cpe_values)){


                                 if ($cpe_menosa['cp_ce_menosnombre_1'] <> 'defaultmenosnombre1'){
                  $bce_defaultmenosnombre1_cpe = "and cp_ce_menosnombre_1 <> '" . $cpe_cpe['products_cp_ce_menosnombre_1'] . "'";
                                }else{
                  $bce_defaultmenosnombre1_cpe = '';

                  }

                                 if ($cpe_menosa['cp_ce_menosnombre_2'] <> 'defaultmenosnombre2'){
                  $bce_defaultmenosnombre2_cpe = "and cp_ce_menosnombre_2 <> '" . $cpe_cpe['products_cp_ce_menosnombre_2'] . "'";
                                }else{
                  $bce_defaultmenosnombre2_cpe = '';

                  }


                                 if ($cpe_menosa['cp_ce_menosnombre_3'] <> 'defaultmenosnombre3'){
                  $bce_defaultmenosnombre3_cpe = "and cp_ce_menosnombre_3 <> '" . $cpe_cpe['products_cp_ce_menosnombre_3'] . "'";
                                }else{
                  $bce_defaultmenosnombre3_cpe = '';

                  }













}  // fin cambio 12







                  // por número de categoria externa.
    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' $bce_defaultmenosnombre1_cpe $bce_defaultmenosnombre2_cpe
                                                                                or cp_cf= '" . $wersdfs['products_cpf'] . "' and cp_cf >= '" . 1 . "'");
    while ($cpe = tep_db_fetch_array($cpe_values)){










                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }  // CPE
                                         $vv_catce = $v_categories_id;
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT







                                                         //seguridad




                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }  // CPE

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT











                                    //     } // SEGURIDAD



} // fin while cpe


                    // cambio 13
                     // si el producto no encuentra categoria se inserta en la categoría novedades definida en el listado exel.

    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' $bce_defaultmenosnombre1_cpe or cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' $bce_defaultmenosnombre2_cpe ");
    if ($cpe = tep_db_fetch_array($cpe_values)){


}else{

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id_original . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id_original . '")');
   } // CPCAT


}



                  // cambio 13





                                    $tiempo_3600hora = $wersdfs['easypopulate_time'] + 5;
                                    $tiempo_60min  = $wersdfs['easypopulate_time'] + 1;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                               ///     if ($vv_seguridad == 5 and $tiempo_permiso == 1){

                       //seleccion 1


              // por medio de coincidencia por referencia products_model
    $cpe_busca_values = tep_db_query("select * from " . 'categories_pareja' . " order by cp_id ASC");
     while ($cpe_busca = tep_db_fetch_array($cpe_busca_values)){


       if ($cpe_busca['cp_ce_model'] <> 'defaultmodel'){



                 // cambio 11
                 // Reglas de Categorias por nombre en el producto.
   $cpe_menos_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_menosnombre_1'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_2'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_3'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_menos = tep_db_fetch_array($cpe_menos_values)){
                                         /*
          Reglas de categorias por referencia, configura la regla en el producto y el producto lo compara con su pareja
          en categories pareja
          

                                              */
            $sql_status_update_array = array('products_cp_ce_menosnombre_1' => $cpe_busca['cp_ce_menosnombre_1'],
                                             'products_cp_ce_menosnombre_2' => $cpe_busca['cp_ce_menosnombre_2'],
                                             'products_cp_ce_menosnombre_3' => $cpe_busca['cp_ce_menosnombre_3']);
            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");



 }else{

 }


                 

    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.products_model like '%" . $cpe_busca['cp_ce_model'] . "%' and p.products_id= '" . $v_products_id . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){


                                 if ($cpe_busca['cp_ce_menosnombre_1'] <> 'defaultmenosnombre1'){
                  $bce_defaultmenosnombre1_mod = "and cp_ce_menosnombre_1 <> '" . $cpe_model['products_cp_ce_menosnombre_1'] . "'";
                                }else{
                  $bce_defaultmenosnombre1_mod = '';

                  }

                                 if ($cpe_busca['cp_ce_menosnombre_2'] <> 'defaultmenosnombre2'){
                  $bce_defaultmenosnombre2_mod = "and cp_ce_menosnombre_2 <> '" . $cpe_model['products_cp_ce_menosnombre_2'] . "'";
                                }else{
                  $bce_defaultmenosnombre2_mod = '';

                  }


                                 if ($cpe_busca['cp_ce_menosnombre_3'] <> 'defaultmenosnombre3'){
                  $bce_defaultmenosnombre3_mod = "and cp_ce_menosnombre_3 <> '" . $cpe_model['products_cp_ce_menosnombre_3'] . "'";
                                }else{
                  $bce_defaultmenosnombre3_mod = '';

                  }



      $cpe_busca_a_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_model = '" . $cpe_busca['cp_ce_model'] . "' $bce_defaultmenosnombre1_mod $bce_defaultmenosnombre1_mod $bce_defaultmenosnombre1_mod");
         while  ($cpe_busca_a = tep_db_fetch_array($cpe_busca_a_values)){
                                   $v_categories_id =  $cpe_busca_a['cp_ci'];


                     // cambio 11 f

     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $v_products_id . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "' and categories_id = '" .  $v_categories_id_original . "'");

}



                                         if ($v_categories_id){
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT

                                       // } // SEGURIDAD


                                      } // $v_categories_id

                                   } // fin while

       }}







        IF  ($cpe_busca['cp_ce_nombre'] <> 'defaultnombre'){

                                 if ($cpe_busca['cp_ce_nombre_2'] <> 'defaultnombre2'){
                  $bce_nombre2_1 = "and products_name like '%" . $cpe_busca['cp_ce_nombre_2'] . "%'";
                                }else{
                      $bce_nombre2_1 = '';

                  }


                                 if ($cpe_busca['cp_ce_nombre_3'] <> 'defaultnombre3'){
                  $bce_nombre3_1 = "and products_name like '%" . $cpe_busca['cp_ce_nombre_3'] . "%'";
                                }else{
                      $bce_nombre3_1 = '';

                  }



                 // Reglas de Categorias por nombre en el producto.
   $cpe_menos_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_menosnombre_1'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_2'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_3'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_menos = tep_db_fetch_array($cpe_menos_values)){
                                         /*
                                 $menos1 = $cpe_busca['cp_ce_menosnombre_1']

                    if ($cpe_busca['cp_ce_menosnombre_1'] == 'defaultmenosnombre1'){
                         $cpe_busca['cp_ce_menosnombre_1'] = '';
                }
                    if ($cpe_busca['cp_ce_menosnombre_2'] == 'defaultmenosnombre2'){
                         $cpe_busca['cp_ce_menosnombre_2'] = '';
                }
                    if ($cpe_busca['cp_ce_menosnombre_3'] == 'defaultmenosnombre1'){
                         $cpe_busca['cp_ce_menosnombre_3'] = '';
                }

                                              */
            $sql_status_update_array = array('products_cp_ce_menosnombre_1' => $cpe_busca['cp_ce_menosnombre_1'],
                                             'products_cp_ce_menosnombre_2' => $cpe_busca['cp_ce_menosnombre_2'],
                                             'products_cp_ce_menosnombre_3' => $cpe_busca['cp_ce_menosnombre_3']);
            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");



 }else{

 }



                               // por medio de coincidencia por el nombre del producto products_name
   $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_nombre'] . "%' $bce_nombre2_1 $bce_nombre3_1 and products_id= '" . $v_products_id . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){

                   if ($cpe_busca['cp_ce_nombre_2'] <> 'defaultnombre2'){
                  $bce_nombre2_2 = "and cp_ce_nombre_2 = '" . $cpe_busca['cp_ce_nombre_2'] . "'";
                      }else{
                      $bce_nombre2_2 = '';

                  }


                   if ($cpe_busca['cp_ce_nombre_3'] <> 'defaultnombre3'){
                  $bce_nombre3_2 = "and cp_ce_nombre_3 = '" . $cpe_busca['cp_ce_nombre_3'] . "'";
                      }else{
                      $bce_nombre3_2 = '';

                  }



                                 if ($cpe_busca['cp_ce_menosnombre_1'] <> 'defaultmenosnombre1'){
                  $bce_defaultmenosnombre1_2 = "and cp_ce_menosnombre_1 <> '" . $cpe_model['products_cp_ce_menosnombre_1'] . "'";
                                }else{
                  $bce_defaultmenosnombre1_2 = '';

                  }


                                 if ($cpe_busca['cp_ce_menosnombre_2'] <> 'defaultmenosnombre2'){
                  $bce_defaultmenosnombre2_2 = "and cp_ce_menosnombre_2 <> '" . $cpe_model['products_cp_ce_menosnombre_2'] . "'";
                                }else{
                  $bce_defaultmenosnombre2_2 = '';

                  }


                                 if ($cpe_busca['cp_ce_menosnombre_3'] <> 'defaultmenosnombre3'){
                  $bce_defaultmenosnombre3_2 = "and cp_ce_menosnombre_3 <> '" . $cpe_model['products_cp_ce_menosnombre_3'] . "'";
                                }else{
                  $bce_defaultmenosnombre3_2 = '';

                  }







      $cpe_busca_b_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_nombre = '" . $cpe_busca['cp_ce_nombre'] . "' $bce_nombre2_2 $bce_nombre3_2 $bce_defaultmenosnombre1_2 $bce_defaultmenosnombre2_2 $bce_defaultmenosnombre3_2");
   while   ($cpe_busca_b = tep_db_fetch_array($cpe_busca_b_values)){




     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $v_products_id . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "' and categories_id = '" .  $v_categories_id_original . "'");

}








                                    if ($cpe_busca_b['cp_ci']){
                                  $v_categories_id =  $cpe_busca_b['cp_ci'];
                                       }else{

                                  $v_categories_id =  $v_categories_id_original;

                                   }





                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                         }




                                         if ($v_categories_id){
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT

                                       // } // SEGURIDAD


                                      } // $v_categories_id



                                          } // fin while.







                                               // $v_categories_id =  $cpe_busca_b['cp_ci'];

       }
         }
          }// comprobar cpe model y nombre




                                }// tiempo_permiso


























                                }  // FIN REGLAS DE CATEGORIAS
























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

                              ?>



  <?php
  


           $time_added = time($product_info['products_date_added']);

      $time2 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
    $fecha_pp = date("Y-m-d", $time2);
//$datetime1 = new DateTime($product_info['products_date_added']);
//$datetime2 = new DateTime($fecha_pp);

       if (PERMISO_IMAGE_TWITTER == 'False'){


$interval = $datetime1->diff($datetime2);




if ($interval->format('%R%a') <= 30){
    $producto_nuevo_twitter = '#Nuevo ';
}





       if ($ref_fabricante['proveedor_ruta_images']){
 $pi_twiiter_image = $ref_fabricante['proveedor_ruta_images'].$product_info['products_image'];

   }else{
 $pi_twiiter_image = HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES .$product_info['products_image'];
        }

}


     //   if  ($product_info['manufacturers_name'] <> '' and $product_info['referencia_fabricante'] <> ''){
    // $icecat_twitter = '#IceCat';
   // }

        if  ($product_info['manufacturers_name'] <> '' and $product_info['referencia_fabricante'] <> ''){
     $icecat_pinterest = 'IceCat';
    }

  if (ereg("[^.]{30}", $product_info['products_description']) ) {
     // $product_descripcion_twitter = '#Descripción';
}

  if (ereg("[^.]{30}", $product_info['products_description']) ) {
      $product_descripcion_pinterest = 'Descripcion';
}




        if ($currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) <> 0){

        $pinterest_precio = $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id']));

    }else{
        $pinterest_precio = $products_price;
}


 if ($precio_diferencia_porcent <= -0.01){
 $twitter_text =  $novedad_text . number_format($precio_diferencia_porcent, 2, '.', '') . '% ' . number_format($product_info['products_price'], 2, '.', '') . '€ ' . $product_info['products_name'] . ' ' . HASTAG_TWITTER . ' ' . $product_descripcion_twitter . ' ' . $pi_twiiter_image;

 }else if ($precio_diferencia_porcent >= 0.01){
 $twitter_text =  $novedad_text . '+' . number_format($precio_diferencia_porcent, 2, '.', '') . '% ' . number_format($product_info['products_price'], 2, '.', '') . '€ ' . $product_info['products_name'] . ' ' . HASTAG_TWITTER . ' ' . $product_descripcion_twitter . ' ' . $pi_twiiter_image;

 
 }else{

 $twitter_text =  $producto_nuevo_twitter . number_format($product_info['products_price'], 2, '.', '') . '€ ' . $product_info['products_name'] . ' ' . HASTAG_TWITTER . ' ' . $product_descripcion_twitter . ' ' . $pi_twiiter_image;


}



      $pinterest_text =  number_format($product_info['products_price'], 2, '.', '') . 'Eur. ' . $product_info['products_name'] . ' Tenerife '. $icecat_pinterest . ' ' . $product_descripcion_pinterest;


      ?>

    
    

<?php
    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
?>

    <p style="text-align: center;"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></p>

<?php
    }
?>

  </div>
  
  
  
<?php
// Begin product_previous_next
  if ( ($product_check['total'] > 0) && ( (PREVIOUS_NEXT_PRODUCT_LINK_NAVIGATION == 'Bottom') || (PREVIOUS_NEXT_PRODUCT_LINK_NAVIGATION == 'Both') ) ) {
    echo $prevnextProductLinkDisplay;
  }
// End product_previous_next
?>

  

<?php
    $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and reviews_status = 1");
    $reviews = tep_db_fetch_array($reviews_query);
?>

  <div class="buttonSet">
    <span class="buttonAction"><?php

	define('TEXT_ASK_QUESTION', 'Hacer una pregunta sobre este producto');




           if (BOTON_COMPRA == 'True' and $product_info['products_price'] <> 0 or BOTON_COMPRA == 'True' and $customer_group_price['customers_group_price'] <> 0){

   echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', null, 'primary');
                            }


       ?></span>
    <?php echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews['count'] > 0) ? ' (' . $reviews['count'] . ')' : ''), 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()));
if (tep_session_is_registered('customer_id') || (ALLOW_ASK_A_QUESTION == 'true'))  {
  echo tep_draw_button(TEXT_ASK_QUESTION, 'help', tep_href_link(FILENAME_ASK_QUESTION, 'products_id='.$product_info['products_id']));
}
     ?>
  </div>
  
     </form>

<?php
     if (INFO_ALERTAS == 'True'){
     ?>

                                   <p>&nbsp;</p>
                                  <p>Información y precios validos salvo error tipografico</p>
                                 <p>&nbsp;</p>
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








           <?php } ?>
           
           
           


          <?php

             $ref_fabri = ereg_replace("[[:space:]]", '', $product_info['referencia_fabricante']);
           //patrocine
        if  ($ref_fabricante['proveedor_ficha']){


      ?>


      <IFRAME WIDTH='700px' HEIGHT='350px' FRAMEBORDER='0' style='overflow-X: none;overflow-Y:auto;' src='  <?php echo $ref_fabricante['proveedor_ficha'] . $product_info['referencia_fabricante'] ?>'></IFRAME>


<?php
    }
       //patrocine

      ?>


           
           
          <?php

             $ref_fabri = ereg_replace("[[:space:]]", '', $product_info['referencia_fabricante']);
           //patrocine
        if  ($product_info['manufacturers_name'] <> '' and $product_info['referencia_fabricante'] <> ''){
      ?>
      <IFRAME WIDTH='700px' HEIGHT='900px' FRAMEBORDER='0' style='overflow-X: none;overflow-Y:auto;' src='http://prf.icecat.biz/?shopname=openIcecat-url;smi=product;vendor=<?php echo $product_info['manufacturers_name']; ?>;prod_id=
<?php echo $ref_fabri; ?>;lang=es'></IFRAME>



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
  


<?php
    if ((USE_CACHE == 'true') && empty($SID)) {
      echo tep_cache_also_purchased(3600);
    } else {
      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
    }
?>

</div>






 </td>







                           <?php


                              ?>






<?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
