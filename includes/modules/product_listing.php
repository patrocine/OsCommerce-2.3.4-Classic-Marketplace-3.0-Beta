<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
//add product description to fetched fields
$listing_sqls = str_replace('pd.products_name,', 'pd.products_name, pd.products_description, ', $listing_sql);
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id ');
?>

<div class="contentText contConteiner_listing">
<?php
if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
    <div>
      <span class="f_right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>
      <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
    </div>
    <br />
<?php
  }

  $prod_list_contents = '<div class="infoBoxContainer">';

  if ( !empty($column_list) ) {
  $prod_list_contents .='  <div class="infoBoxHeading1 padding_pages_2 margin_bottom_1">' .
                        '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="productListingHeader1">' .
                        '      <tr>' .
                        '      <td class="padding0"><b>'.TEXT_SORT_PRODUCTS.' '.TEXT_BY.':</b>  ';

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    $lc_align = '';

    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
      $prod_list_contents .= '  '.$lc_text.'  ' ;
    }
  }

  $prod_list_contents .= '      </td>' .
                         '      </tr>' .
                         '    </table>' .
                         '  </div>';
  } // if ( !empty($column_list) ) {

  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);

    $prod_list_contents .= '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="padding0 productListingData">';

    $counter = 0;
    $col = 0;
    $width = floor(100 / $az_listing_columns);
    $num_products = tep_db_num_rows($listing_query);
    while ($listing = tep_db_fetch_array($listing_query)) {

        $counter++;
        if ($col === 0) {
            $prod_list_contents .= '<tr>';
        }

    $ctc_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $listing['products_id'] . "'");
    $ctc = tep_db_fetch_array($ctc_values);
    $ctcp_values = tep_db_query("select * from " . TABLE_CATEGORIES . " where categories_id= '" . $ctc['categories_id'] . "'");
    $ctcp = tep_db_fetch_array($ctcp_values);
    $ctcp2_values = tep_db_query("select * from " . TABLE_CATEGORIES . " where categories_id= '" . $ctcp['parent_id'] . "'");
    $ctcp2 = tep_db_fetch_array($ctcp2_values);

                          if (ACTIVAR_IMAGEN_AUTOMATICA == 'true'){
                       if ($listing['products_image']){
            $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctc['categories_id'] . "'");

             $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctcp['parent_id'] . "'");
                                              }
                                              
                                              
             $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctcp2['parent_id'] . "'");
                                        }

   if (PERMISO_PORCENTAGE_PRECIO == 'True'){


             if ($listing['products_porcentage'] <= -0.1) {
                 $porcentage = '<font color="#FF0000"  size="2">'.$listing['products_porcentage']. '% '.'</font>';
             }else if($listing['products_porcentage'] >= 0.1){
                     if (PERMISO_PORCENTAGE_PRECIO_MAS == 'True'){
                  $porcentage = '<font color="#008000"  size="2">+'.$listing['products_porcentage']. '% '.'</font>';
                                          }else{
                                      $porcentage = '';
                                      }


         }else{
       $porcentage = '';

     }
     
     
           } // permiso porcentaje
     
     






$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $listing['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = ''.$currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '';
  }
}
                $products_price = az_change_format($products_price);



       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'].'%';
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
            $price_descpro = $listing['products_price'] *$customers_porcentage/100+$listing['products_price'];

            if ($price_descpro == $listing['products_price']){

$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        }

}else{

  $products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

}


                         // Total CON EL DESCUENTO DEL PRODUCTO
                                     if ($customer_id <> 0 OR DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'];

            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

            if ($products_price <> $listing['products_price']){

//$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
            }
            


      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] <> 0 ){

      $customers_porcentage = $customers_porcentage['customers_porcentage'];







            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';




      
 }else{

      $customers_porcentage = DESCUENTO_CLIENTE;
              if (DESCUENTO_CLIENTE <> 0){
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';



                                                                                     }


}


  }
         } // Total CON EL DESCUENTO DEL PRODUCTO



    // if ($products_price == 0){
     //$products_price = '';
   // }


if ($customers_porcentage == 0){

        $customers_porcentage = '';


}
if ($customers_porcentage){

     }else{
            $products_price =  '<font color="#000000" size="5"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</b></font>';
              }
              
    $pdc_precio_final_values = mysql_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $listing['products_id'] . "' order by pdc_unidades asc");
  if ($pdc_precio_final = mysql_fetch_array($pdc_precio_final_values)){

            $pdc_price_final = ' <font color="#000000" size="0"><p style="margin-top: 0; margin-bottom: 0"> <font size="0">+'.$pdc_precio_final['pdc_unidades'].' Pcs ->></s>
              <font color="#ff0000" size="0"><b>' . $pdc_precio_final['pdc_price_final'] . '€ .....</b></font></span></p>';



}else{
 $pdc_price_final = '';
}

              
              

              
        if (tep_not_null($listing['specials_new_products_price'])) {
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
                <font color="#FF0000" size="6"><b>' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        } else {
          //  $products_price = $porcentage . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
        }

            $precio_permiso = $products_price;
              
              
    
     if (tep_not_null($listing['specials_new_products_price'])) {

          $customers_porcentage = '';
 }


        #Include template layout for the product box
        #build variables map
        $product['id']				= $listing['products_id'];
        $product['model']				= $listing['products_model'];
        $product['name']			= $listing['products_name']  . ' ' .$listing['products_model'] . '';

        if ($listing['products_price'] <> 0 or $customer_group_price['customers_group_price'] <> 0){


    $pro_g1_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" .  $customer_id . "'");
    $pro_g1 =tep_db_fetch_array($pro_g1_values);

    $pro_g_values = tep_db_query("select * from " . 'products_groups' . " where customers_group_id = '" .  $pro_g1['customers_group_id'] . "' and products_id = '" .  $listing['products_id'] . "'");
    if ($pro_g =tep_db_fetch_array($pro_g_values)){

       $products_price = '<p><b><font size="6" color="#000000">' .  $currencies->display_price($pro_g['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</font></b></p></b></p>';
}



        $product['price']			= $products_price.$pdc_price_final;//.' <font color="#FF0000"><b>'.$customers_porcentage.'</b></font>';

		                            }else{

                                  $product['price']			= '';
                                  }

        $product['price_special']	= $products_price_special;



         $product['info_url']		= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id'].'&cPath='.$cPath);









        $product['desc']			= $listing['products_description'];
        $product['more_info_btn']	= tep_image_button('', AZ_BUTTON_MORE_INFO, '', '3');

  $stock_query = tep_db_query("select * from " . 'products_stock' . " where  products_id = '" . $listing['products_id'] . "'");
                         $p_stock = tep_db_fetch_array($stock_query);


                if (BOTON_COMPRA == 'True' and $listing['products_price'] <> 0){

                                         if ($p_stock['products_stock_real'] >= 1){
                  // $product['buy_now_url'] = tep_draw_button(IMAGE_BUTTON_BUY_NOW, 'cart', tep_href_link($PHP_SELF, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']))
        $product['buy_now_url']		= tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']);
        
         $product['buy_now_btn']	    = tep_image_button('button_in_cart.gif', AZ_BUTTON_CART, '', '2', false);
         
                                                            }else{

                                                             $product['buy_now_btn']	    = '';
                                                        }
                            }
        $product['review_stars']	= az_get_products_rating($listing['products_id']);

		$product['buy_now_btn_main'] = az_image(TMPL_IMAGES . 'az-button-cart.gif');





               $products_id_stock = $product['id'];
                $act_stock_siempre = 'OK';

      require('product_stock.php');

      require('product_images_listing.php');





        //$get_width	= get_img_width(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, '', '', '');
















                               if (PERMISO_REGLADEPRECIOS_PRODUCTSLISTING == 'True'){









                         // SELECCION 1


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $product['id'] . "'");
     $products = tep_db_fetch_array($wersdfs_values);


                                                  //REGLAS DE CATEGORIAS



                                                 if (PERMISO_REGLADEPRECIOS_PRODUCTSLISTING == 'True' and $products['products_rc'] == 1){








                                              $product['id'] =   $listing['products_id'];




                                                               //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $product['id'] . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);



     $wersdfs_values = tep_db_query("select * from " . 'products_compartir' . " where proveedor_id= '" . $wersdfs['codigo_proveedor'] . "'");
     $id_categoria_defecto = tep_db_fetch_array($wersdfs_values);


                                                if ($id_categoria_defecto['id_categoria_defecto']){
                                                     $v_categories_id_original = $id_categoria_defecto['id_categoria_defecto'];
                                            }else{
                                            $v_categories_id_original = CATEGORIA_DEFECTO_RDC;
                                              }




                                                        $quitar_tiempo =  $_GET['quitar_tiempo'];

                                                         if ($quitar_tiempo == 'ok'){
                                                   $wersdfs['easypopulate_time'] = time();

                                                     }else{

                                                       }



            $sql_status_update_array = array('easypopulate_time' => time()+rand(1,5000000));
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $product['id'] . "' and easypopulate_time = 0");


                                  if (time() >= $wersdfs['easypopulate_time']){
                                 // activar nuevo tiempo falta un update.            time()+rand(1,130000)


            $sql_status_update_array = array('easypopulate_time' => time()+rand(1,5000000));
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $product['id'] . "'");

                                                                ECHO '.';


                                                             $tiempo_permiso = 1;

                                 } //



                                                         //seguridad
                                    if ($tiempo_permiso == 1){

 tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $product['id'] . "'");



                     // si el producto no encuentra categoria se inserta en la categoría novedades definida en el listado exel.

    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "'");
    if ($cpe = tep_db_fetch_array($cpe_values)){


}else{

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $product['id'] . "' and categories_id= '" . $v_categories_id_original . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $product['id'] . '", "' . $v_categories_id_original . '")');
   } // CPCAT


}






      if ($wersdfs['products_cpf'] == 1){
          $wersdfs['products_cpf'] = 0;
      }
      if ($wersdfs['products_cpe'] == 1){
          $wersdfs['products_cpe'] = 0;
                        }

                  // por número de categoria externa.
    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' or cp_cf= '" . $wersdfs['products_cpf'] . "' and cp_cf >= '" . 1 . "'");
    while ($cpe = tep_db_fetch_array($cpe_values)){





                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }  // CPE

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $product['id'] . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $product['id'] . '", "' . $v_categories_id . '")');
   } // CPCAT







                                                         //seguridad




                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }  // CPE

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $product['id'] . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $product['id'] . '", "' . $v_categories_id . '")');
   } // CPCAT











} // fin while cpe











                       //seleccion 1


              // por medio de coincidencia por referencia products_model
    $cpe_busca_values = tep_db_query("select * from " . 'categories_pareja' . " order by cp_id ASC");
     while ($cpe_busca = tep_db_fetch_array($cpe_busca_values)){


       if ($cpe_busca['cp_ce_model'] <> 'defaultmodel'){


    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_model like '%" . $cpe_busca['cp_ce_model'] . "%' and products_id= '" . $product['id'] . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){
      $cpe_busca_a_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_model = '" . $cpe_busca['cp_ce_model'] . "'");
        while  ($cpe_busca_a = tep_db_fetch_array($cpe_busca_a_values)){
                                   $v_categories_id =  $cpe_busca_a['cp_ci'];







     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $product['id'] . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $product['id'] . "' and categories_id = '" .  $v_categories_id_original . "'");

}



                                         if ($v_categories_id){
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $product['id'] . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $product['id'] . '", "' . $v_categories_id . '")');
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





   $cpe_menos_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_menosnombre_1'] . "%' and products_id= '" . $product['id'] . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_2'] . "%' and products_id= '" . $product['id'] . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_3'] . "%' and products_id= '" . $product['id'] . "'");
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
            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $product['id'] . "'");



 }else{

 }



                               // por medio de coincidencia por el nombre del producto products_name
   $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_nombre'] . "%' $bce_nombre2_1 $bce_nombre3_1 and products_id= '" . $product['id'] . "'");
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
    while  ($cpe_busca_b = tep_db_fetch_array($cpe_busca_b_values)){




     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $product['id'] . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $product['id'] . "' and categories_id = '" .  $v_categories_id_original . "'");

}








                                    if ($cpe_busca_b['cp_ci']){
                                  $v_categories_id =  $cpe_busca_b['cp_ci'];
                                       }else{

                                  $v_categories_id =  $v_categories_id_original;

                                   }







                                 //     ECHO 'SELECCION1rd'. $v_categories_id;

                                                        //seguridad


                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                         }

                                         if ($v_categories_id){
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $product['id'] . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $product['id'] . '", "' . $v_categories_id . '")');
   } // CPCAT

                                       } // SEGURIDAD


                                      } // $v_categories_id



                                   } // fin while.





                                               // $v_categories_id =  $cpe_busca_b['cp_ci'];

       }
         }
          }// comprobar cpe model y nombre
















                                }  // FIN REGLAS DE CATEGORIAS






                                   }











            IF (PERMISO_COINCIDENCIA_PROVEEDOR == 'True'){


            //Borra todos los registros que coincidan con precio y deja la ultima fecha.

         $group_producto_values = mysql_query("select referencia_fabricante, count(referencia_fabricante) as rf from " . 'products' . " where referencia_fabricante = '" . $listing['referencia_fabricante'] . "' and products_status = 1 group by referencia_fabricante order by products_price DESC");
   while  ($group_producto = mysql_fetch_array($group_producto_values)){

                     if  ($group_producto['referencia_fabricante'] <> '' and $group_producto['rf'] >= 2){

       $group2_producto_values = mysql_query("select * from " . 'products' . " where referencia_fabricante = '" . $group_producto['referencia_fabricante'] . "' order by products_price asc");
   if  ($group2_producto = mysql_fetch_array($group2_producto_values)){




            $sql_status_update_array = array('products_status' => 0,);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id <> '" . $group2_producto['products_id'] . "' and referencia_fabricante = '" . $group2_producto['referencia_fabricante'] . "' ");




          ?>



         <script type="text/javascript">

       var pagina = '<? echo $PHP_SELF.$_SERVER['REQUEST_URI'];  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


      <?php





      echo $group2_producto['products_price'];
   }

                   // echo $group_producto['rf'] . ' | ';
                                                             }


}



               } // permiso de coincidencia de proveedor




        if (($col >= $az_listing_columns) || ($counter == $num_products)) {
            while ( $col < $az_listing_columns ) {
                $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top"></td>';
                $col++;
            }

            $prod_list_contents .= '</tr>';
            $col = 0;
        }
    }

    $prod_list_contents .= '    </table>' .
                           '</div>';

    echo $prod_list_contents;




   } else {

/************** BEGIN SITESEARCH CHANGE ******************/
    if (isset($_GET['keywords'])) {







      echo  tep_draw_form('product_notify', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'post', 'onsubmit="return checkform(this);"'),
                                 '<table border="0"><tr><td class="productListing-data" colspan="2">' . TEXT_NO_PRODUCTS_KEYWORD  . '</td></tr>' .
                                 '<tr><td height="5"></td></tr><tr><td width="25%" class="productListing-data">' . TEXT_PRODUCT_NAME . '</td><td>' . tep_draw_input_field('keywords', '', 'size="40" maxlength="255" ') . '</td></tr>' .
                                 '<tr><td height="5"></td></tr><tr><td class="productListing-data">' . TEXT_CUSTOMER_NAME . '</td><td>' . tep_draw_input_field('cust_name', '', 'size="40" maxlength="100"', false) . '</td></tr>' .
                                 '<tr><td height="5"></td></tr><tr><td class="productListing-data">' . TEXT_CUSTOMER_EMAIL . '</td><td>' . tep_draw_input_field('cust_email', '', 'size="40" maxlength="100"', false) . '</td></tr>' .

                                 '<tr><td height="5"></td></tr><tr><td class="productListing-data" valign="top">' . TEXT_COMMENTS  . '</td><td>' . tep_draw_textarea_field('comments', 'soft', 10, 4, '', '', false) . '</td></tr>' .

                                 '<tr><td height="5"></td></tr><tr><td colspan="2" align="center" class="productListing-data"><INPUT type="submit" name="request_submit" value="Submit"></td></tr>' .
                                 '</table></form>';








    } else {
?>
    <p><?php echo TEXT_NO_PRODUCTS; ?></p>

<?php
    }
}
/************** BEGIN SITESEARCH CHANGE ******************/





  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

    <div class="az_pager">
      <span><?php echo '<label>'.TEXT_RESULT_PAGE.'</label>' . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>

    </div>
<?php
  }
?>
</div>
