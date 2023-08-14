<?php
function imageRestrict_bs($image) {  
	$maxwidth = 77;
	$maxheight = 45;
	
	list($width,$height) = getimagesize($image); 
		if ($width > $height) { 
			$newheight = round($maxwidth/$width * $height);  
			return '<img src="'.$image.'" width="'.$maxwidth.'" height="'.$newheight.'" alt="" />';  
		}  
		else  { 
		//	$newwidth = round($maxheight/$height * $width);
			if ($newwidth > $maxwidth) {
				return '<img src="'.$image.'" width="'.$maxwidth.'"  alt="" />';
			}
			return '<span class="space_1"><img src="'.$image.'" width="'.$newwidth.'" height="'.$maxheight.'" alt="" /></span>';
		}
}
?>

<?php $count = 0;
                   if (PERMISO_STOCK_NIVEL_6 == 'true'){
		$products_bestsellers_query = tep_db_query("select distinct pd.products_id, .pd.products_name, pd.products_description, p.codigo_proveedor, p.products_id, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p, " . 'products_stock' . " ps  where p.products_status = '1' and ps.products_id = p.products_id and ps.products_stock_real >= 0.01 and  p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'   order by pd.products_viewed desc LIMIT 10");
                                }else{
		$products_bestsellers_query = tep_db_query("select distinct pd.products_id, .pd.products_name, pd.products_description, p.codigo_proveedor, p.products_id, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_status = '1' and  p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'   order by pd.products_viewed desc LIMIT 10");

                            }

		
			while ($best_viewed = tep_db_fetch_array($products_bestsellers_query)) {
					if (tep_not_null($best_viewed['specials_new_products_price'])) {
						$best_viewed_price = '<del>' . $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</del><br />';
						$best_viewed_price .= '<span class="productSpecialPrice">' . $currencies->display_price($best_viewed['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>';
					} else {
						$best_viewed_price = $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id']));
					}
			
					$best_viewed_price_1 = az_change_format($best_viewed_price);
					
					
					$count++;




                $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $best_viewed['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){


     $image_sc = $ref_fabricante['proveedor_ruta_images'] . $best_viewed['products_image'];
  }else{

// si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^http://", $best_viewed['products_image']) ) {

      $image_sc = '' . $best_viewed['products_image'];
}else{

      $image_sc = DIR_WS_IMAGES . $best_viewed['products_image'];

  }


   } // fin ref_fabricante


   if (ereg("^https://", $best_viewed['products_image']) ) {

      $image_sc = '' . $best_viewed['products_image'];
}



                         // Total CON EL DESCUENTO DEL PRODUCTO
                              if ($customer_id <> 0 OR DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $best_viewed['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'];

            $best_viewed_price_1 = '<s>' .  $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($best_viewed['products_price'] *$customers_porcentage/100+$best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</b></font></span>';




      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] <> 0 ){

      $customers_porcentage = $customers_porcentage['customers_porcentage'];

            $best_viewed_price_1 = '<s>' .  $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($best_viewed['products_price'] *$customers_porcentage/100+$best_viewed['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';


}else{


      $customers_porcentage = DESCUENTO_CLIENTE;
              if (DESCUENTO_CLIENTE <> 0){
            $best_viewed_price_1 = '<s>' .  $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($best_viewed['products_price'] *$customers_porcentage/100+$best_viewed['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
                                  }


}



  }
         } // Total CON EL DESCUENTO DEL PRODUCTO


if ($customers_porcentage == 0){

        $customers_porcentage = '';


}
if ($customers_porcentage){

     }else{
            $best_viewed_price_1 =  '<font color="#000000" size="5"><b>'.$currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])).'</b></font>';
              }

    $pro_special_values = mysql_query("select * from " . 'specials' . " where products_id = '" .  $best_viewed['products_id'] . "'");
    $pro_special = mysql_fetch_array($pro_special_values);

        if (tep_not_null($pro_special['specials_new_products_price'])) {
            $best_viewed_price_1= '<s>' .  $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</s>&nbsp;
                <font color="#FF0000" size="5"><b>' . $currencies->display_price($pro_special['specials_new_products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</b></font></span>';
        } else {
          //  $products_price = $porcentage . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
        }

            $precio_permiso = $products_price;



     if (tep_not_null($best_viewed['specials_new_products_price'])) {

          $customers_porcentage = '';
 }

					if (tep_not_null($best_viewed['specials_new_products_price'])) {
						$best_viewed_price_1 = '<del>' . $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</del><br />';
						$best_viewed_price_1 .= '<span class="productSpecialPrice">' . $currencies->display_price($best_viewed['specials_new_products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</span>';
					} else {
						//$best_viewed_price_1 = $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id']));
					}



					$bestviewed_list .= '
					 <li class="list-style '.(($count == tep_db_num_rows($products_bestsellers_query)) ? 'last' : 'default_count').'">
						<div class="bestsellers_img">
							<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_viewed['products_id']) . '">' . imageRestrict_bs($image_sc, $best_viewed['products_name'],  SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>
						</div>
						<div class="bestsellers_text">
							<div><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$best_viewed['products_id']).'">'.az_short_text($best_viewed['products_name'], '35').'</a></div>
							<div class="bestsellers_price">'. $best_viewed_price_1 .'</div>
						</div>
						<div class="clear"></div>
						
					</li>
					';
			 }
			 


			 
		 
if (tep_db_num_rows($products_bestsellers_query) == 0) {
	 $data = '&nbsp;';

} elseif (tep_db_num_rows($products_bestsellers_query) < 4)
{
	$data = '<ul class="case_less_3">' . $bestviewed_list . '</ul>'; 

} elseif (tep_db_num_rows($products_bestsellers_query) > 3) {
	
	
	$data = '<ul id="mycarousel" class="jcarousel jcarousel-skin-tango">' . $bestviewed_list . '</ul>';
}
	
	
	
	
	echo $data;  
          
?>
