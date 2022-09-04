<?php
function imageRestrict($image) {  
	$maxwidth = 137; 
	$maxheight = 118;
	list($width,$height) = @getimagesize($image);
	if ($width > $height) { 
			$newheight = round($maxwidth/$width * $height);  
			return '<img src="'.$image.'" width="'.$maxwidth.'" height="'.$newheight.'" alt="" />';  
	}  
	else { 
		$newwidth = @round($maxheight/$height * $width);
		if ($newwidth > $maxwidth) {
			return '<img src="'.$image.'" width="'.$maxwidth.'"  alt="" />';
		}
		return '<img src="'.$image.'" width="'.$newwidth.'" height="'.$maxheight.'" alt="" />';
	}
}
?>

<center>
	<div class="space_2">&nbsp;</div>
	<div class="new_products_slider_box">
		

<?php
//$products_new_added_query = tep_db_query("select distinct pd.products_id, .pd.products_name, p.products_date_added, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by rand() ");
$products_new_added_query = tep_db_query("select distinct pd.products_id, .pd.products_name, p.products_date_added, p.codigo_proveedor, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by RAND() LIMIT 30");    // p.products_date_added DESC, pd.products_name


?>
<?php if (tep_db_num_rows($products_new_added_query) < 1) {?>
<div class="display_none">&nbsp;</div>  
<?php } else {?>
	
	<div class="prev2"></div>
	<div class="gallery2">
		<ul>
		  		<?php 
		 		$k = 0;
				while ($products_new_added = tep_db_fetch_array($products_new_added_query) ) { 
					
					$products_new_added['specials_new_products_price'] = tep_get_products_special_price($products_new_added['products_id']);
				
					if (tep_not_null($products_new_added['specials_new_products_price'])) {
				 		$whats_new_price = $currencies->display_price($products_new_added['specials_new_products_price'], tep_get_tax_rate($products_new_added['products_tax_class_id']));
					} else {
				  		$whats_new_price = $currencies->display_price($products_new_added['products_price'], tep_get_tax_rate($products_new_added['products_tax_class_id']));
					}
					$products_new_added_price = $whats_new_price;	
				
					$realpath = DIR_FS_CATALOG.'/images/'. $products_new_added['products_image'];	;
					//if(file_exists($realpath)) {








             $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $products_new_added['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){




 if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $products_new_added['products_image'])) {


     $image_sc = $ref_fabricante['proveedor_ruta_images'] . $products_new_added['products_image'];



} else {
        $image_sc = $ref_fabricante['proveedor_ruta_images'] . 'no-foto.jpg';

 }






  }else{

// si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^http://", $products_new_added['products_image']) ) {

      $image_sc = '' . $products_new_added['products_image'];



}else{

      $image_sc = DIR_WS_IMAGES . $products_new_added['products_image'];



  }


   } // fin ref_fabricante





    	?>
					<li>
						<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr valign="middle"><td height="150" valign="middle" align="center">
							<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>">
								<?php								
									//if product has big img
									$current_product =  $products_new_added['products_id'];
									$products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' ");									
									$products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query);
									if (tep_not_null($products_new_added_big_img['image'])) {
									 	echo imageRestrict(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name'], '', '','style="border:none"');
									 }
									 else {
										echo imageRestrict($image_sc, $products_new_added['products_name']);
									}
								?>
							</a>
							
						</td></tr></table>
						<div>
							<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>"><?php echo $products_new_added['products_name'];?></a>
						</div>
						<div><?php echo $products_new_added_price; ?></div>
							
				</li>
				<?php 
				// }
				}  
				?>
		</ul>					
	</div>
	<div class="next2"></div>
	<div class="clear"></div>
	
<?php } ?>
	</div>
	<div class="space_2">&nbsp;</div>
</center>
