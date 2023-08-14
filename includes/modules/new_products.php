<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/


 if (PERMISO_STOCK_NIVEL_6 == 'true'){

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query(
        "select
             p.codigo_proveedor, products_porcentage, p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, p.products_model, pd.products_description,
p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . 'products_stock' . " ps
        where
            p.products_status = '1'
            and ps.products_id = p.products_id
            and ps.products_stock_real >= 0.01
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "' or
            p.products_status = '1'
            and ps.products_id = p.products_id
            and ps.products_stock_pendiente >= 0.01
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
                order by
            p.products_date_added desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query(
        "select
            distinct p.codigo_proveedor, products_porcentage, p.products_id, p.products_image,  p.products_tax_class_id, pd.products_name, p.products_model, pd.products_description,
  p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . 'products_stock' . " ps
        where
            p.products_id = p2c.products_id
            and ps.products_id = p.products_id
            and ps.products_stock_real >= 0.01
            and p2c.categories_id = c.categories_id
            and c.parent_id = '" . (int)$new_products_category_id . "'
            and p.products_status = '1'
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
        order by
            p.products_price desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);
  
  
}else{



  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query(
        "select
             p.codigo_proveedor, products_porcentage, p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, p.products_model, pd.products_description,
p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd
        where
            p.products_status = '1' and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "' or
            p.products_status = '1'
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
                order by
            p.products_date_added desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query(
        "select
            distinct p.codigo_proveedor, products_porcentage, p.products_id, p.products_image,  p.products_tax_class_id, pd.products_name, p.products_model, pd.products_description,
  p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c
        where
            p.products_id = p2c.products_id
            and p2c.categories_id = c.categories_id
            and c.parent_id = '" . (int)$new_products_category_id . "'
            and p.products_status = '1'
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
        order by
            p.products_price desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);






}
  
  
  
  

if ($num_new_products > 0) {
  $counter = 0;
  $col = 0;

    $new_prods_content = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
    while ($new_products = tep_db_fetch_array($new_products_query)) {
        $counter++;

        if ($col === 0) {
            $new_prods_content .= '<tr>';
        }
		
             if (PERMISO_PORCENTAGE_PRECIO == 'True'){

             if ($new_products['products_porcentage'] <= -0.1) {
                 $porcentage = '<font color="#FF0000"  size="2">'.$new_products['products_porcentage']. '% '.'</font>';
             }else if($new_products['products_porcentage'] >= 0.1){
                     if (PERMISO_PORCENTAGE_PRECIO_MAS == 'True'){
                  $porcentage = '<font color="#008000"  size="2">+'.$new_products['products_porcentage']. '% '.'</font>';
                                          }else{
                                      $porcentage = '';
                                      }
         }else{
       $porcentage = '';

     }

           } // permiso porcentaje
		
		
		if (tep_not_null($new_products['specials_new_products_price'])) {
            $products_price = '<span class="productSpecialPrice">' . $currencies->display_price($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>';
        }
		else
		 {
            $products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])).'</b></font>';
        }
		

                            
        //             if ($products_price == 0){
    // $products_price = '';
  //  }



 $customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $new_products['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</b></font>';




  }
}


       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $new_products['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'].'%';
            $products_price = '<s>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($new_products['products_price'] *$customers_porcentage/100+$new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</b></font></span>';
            $price_descpro = $new_products['products_price'] *$customers_porcentage/100+$new_products['products_price'];

            if ($price_descpro == $new_products['products_price']){

$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($new_products['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

            }

}


                         // Total CON EL DESCUENTO DEL PRODUCTO
                                   if ($customer_id <> 0 OR DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $new_products['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'].'%';
            $products_price = '<s>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($new_products['products_price'] *$customers_porcentage/100+$new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</b></font></span>';


      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] <> 0 ){

      $customers_porcentage = $customers_porcentage['customers_porcentage'].'%';

            $products_price = '<s>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($new_products['products_price'] *$customers_porcentage/100+$new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</b></font></span>';


 }else{


      $customers_porcentage = DESCUENTO_CLIENTE;
              if (DESCUENTO_CLIENTE <> 0){
            $products_price = '<s>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($new_products['products_price'] *$customers_porcentage/100+$new_products['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
                                  }


}


  }
         } // Total CON EL DESCUENTO DEL PRODUCTO
         


         if (tep_not_null($new_products['specials_new_products_price'])) {
            $products_price = '<s>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s>&nbsp;
                <font color="#FF0000" size="3"><b>' . $currencies->display_price($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</b></font></span>';
        } else {
          //  $products_price = $porcentage. $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id']));
        }

                       $precio_permiso = $products_price;

             
         
if ($customers_porcentage == 0){

        $customers_porcentage = '';

    }
         
        
      //  $products_price = az_change_format($products_price);

       $pdc_precio_final_values = tep_db_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" . $new_products['products_id']  . "'  order by pdc_unidades asc");
      if ( $pdc_precio_final = tep_db_fetch_array($pdc_precio_final_values)){



            $pdc_price_final = ' <font color="#000000" size="0"><p style="margin-top: 0; margin-bottom: 0"> <font size="0">+'.$pdc_precio_final['pdc_unidades'].' Pcs ->></s>
              <font color="#ff0000" size="0"><b>' . $pdc_precio_final['pdc_price_final'] . '€ .....</b></font></span></p>';



}else{
 $pdc_price_final = '';
}



        #Include template layout for the product box
        #build variables map
        $product['id']				= $new_products['products_id'];
        $product['name']			= $new_products['products_name'];
        

		               if ($new_products['products_price'] <> 0 or $customer_group_price['customers_group_price'] <> 0){
        $product['price']			= $products_price . $pdc_price_final;//.' <font color="#FF0000"><b>'.$customers_porcentage.'</b></font>';
            }else{
        $product['price']			= '';

        }
		
        $product['info_url']		= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id'].'&cPath='.$cPath);










          $product['desc']			= $new_products['products_description'];
        $product['more_info_btn']	= tep_image_button('', AZ_BUTTON_MORE_INFO, '', '3');

                      if (BOTON_COMPRA == 'True' and $new_products['products_price'] <> 0){

 $stock_query = tep_db_query("select * from " . 'products_stock' . " where  products_id = '" . $new_products['products_id'] . "'");
 $p_stock = tep_db_fetch_array($stock_query);

                          if ($p_stock['products_stock_real'] >= 1){

        $product['buy_now_url']		= tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $new_products['products_id']);
         $product['buy_now_btn']	    = tep_image_button('button_in_cart.gif', AZ_BUTTON_CART, '', '2', false);
                                                                                                     }else{

                                                             $product['buy_now_btn']	    = '';
                                                        }
                                       }
        
        $product['review_stars']	= az_get_products_rating($new_products['products_id']);
		
		$product['buy_now_btn_main'] = az_image(TMPL_IMAGES . 'az-button-cart.gif');

  

                  $products_id_stock = $product['id'];
               $act_stock_siempre = 'OK';

      require('product_stock.php');
      require('product_images_new.php');




          if (($col >= $az_listing_columns) || ($counter == $num_new_products)) {
            $new_prods_content .= '</tr>';

            $col = 0;
        }
    }

    $new_prods_content .= '</table>';

?>

  <!-- <h2><?php echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?></h2> -->
	
  <div class="contentText contConteiner_listing">
    <?php echo $new_prods_content; ?>
  </div>

<?php
  }
?>
