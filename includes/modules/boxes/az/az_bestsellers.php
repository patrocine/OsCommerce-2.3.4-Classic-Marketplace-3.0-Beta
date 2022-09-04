<div class="bestseller-box">

			
	
<div class="az-slider-top-left-best">
	<div class="az-slider-top-right-best">
		<div class="az-slider-top-x-best">
			<h4 class="box-icon-title"><?php echo 'MAS VISTO'; ?></h4>
		</div>
	</div>
</div>

<div class="az-slider-right-y">
<div class="az-slider-left-y">
<div class="az-slider-bottom-x">
<div class="az-slider-bottom-left">
<div class="az-slider-bottom-right">
	
<?php
function imageRestrict_bs($image) {  
	$maxwidth = 86; 
	$maxheight = 88; 
	
	list($width,$height) = getimagesize($image); 
		//if ($width == $maxwidth) { 
			//return '<img src="'.$image.'" width="'.$maxwidth.'" alt="" />';  
		//}  
		//else  { 
			return '<span class="space_1"><img src="'.$image.'" width="'.$maxwidth.'" height="'.$maxheight.'" alt="" /></span>';
		//}
}
?>

<?php $count = 0;                                                                                                                                                                                                                                                                                         //p.products_ordered > 0 and
		$products_bestsellers_query = tep_db_query("select distinct p.codigo_proveedor, pd.products_id, .pd.products_name, pd.products_description, p.products_id, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by pd.products_viewed desc LIMIT 30 ");

       
		
			while ($best_viewed = tep_db_fetch_array($products_bestsellers_query)) {
					
					$k = $best_viewed['products_id'];	
					
					$specials_review_query = tep_db_query("select distinct r.products_id, r.reviews_rating FROM ".TABLE_REVIEWS." r where  r.products_id = '$k' ");
					
					$specials_review = tep_db_fetch_array($specials_review_query);
					
					if (tep_db_num_rows($specials_review_query) > 0) {
						$product['review_stars'] = tep_image(DIR_WS_IMAGES . 'stars_' . $specials_review ['reviews_rating'] . '.gif' , sprintf(MODULE_BOXES_REVIEWS_BOX_TEXT_OF_5_STARS, $specials_review['reviews_rating']));
						
					}
					else {
						$product['review_stars'] = '';
					}
					
					$best_viewed['specials_new_products_price'] = tep_get_products_special_price($best_viewed['products_id']);
					if (tep_not_null($best_viewed['specials_new_products_price'])) {
						$best_viewed_price = '<s>' . $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</s>';
						$best_viewed_price .= '<span>' . $currencies->display_price($best_viewed['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>';
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







                 	

					$bestviewed_list .= '
					 <li class="list-style">
						<div class="f_left bestseller_img">
							
							
							<div class="img-wrapper-listing '.((SMALL_IMAGE_WIDTH == 0) ? 'width_none':'width_act').'" style="width:88px">
							
								<div class="img-listing">
									<a class="display_block" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_viewed['products_id']) . '">' . imageRestrict_bs($image_sc, $best_viewed['products_name']) . '</a>
								</div>
								<div class="az-corner-top-left">&nbsp;</div>
								<div class="az-corner-top-right">&nbsp;</div>
								<div class="az-corner-bottom-left">&nbsp;</div>
								<div class="az-corner-bottom-right">&nbsp;</div>
							
							
							</div>
							
							
							
						</div>
						
						<div class="f_left bestseller_text">
							<div class="bestseller_name"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$best_viewed['products_id']).'">'.az_short_text($best_viewed['products_name'], 38).'</a></div>
							<div class="bestseller_price">'. $best_viewed_price_1 .'</div>
							</div>
						<div class="clear"></div>
					</li>
					';
			 }
			 


			 
		 
if (tep_db_num_rows($products_bestsellers_query) == 0) {
		$data = '<div>&nbsp;</div>';
	} elseif (tep_db_num_rows($products_bestsellers_query) == 1) {
		$data = '<ul class="slider-none-1">' . $bestviewed_list . '</ul>';
	} elseif (tep_db_num_rows($products_bestsellers_query) == 2) {
		$data = '<ul class="slider-none-2">' . $bestviewed_list . '</ul>';
	} elseif (tep_db_num_rows($products_bestsellers_query) == 3) {
		$data = '<ul class="slider-none-3">' . $bestviewed_list . '</ul>';
	} else {
	 	$data = '<div class="slider-none-scroll"><ul id="mycarousel" class="slider-none-3 jcarousel jcarousel-skin-tango">' . $bestviewed_list . '</ul></div>';   
	}
	echo $data;    
          
?>


</div>
</div>
</div>
</div>
</div>
</div>

