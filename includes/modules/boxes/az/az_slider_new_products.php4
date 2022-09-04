
<?php
function imageRestrict($image) {  
	$maxwidth = 150; 
	$maxheight = 213; 
	list($width,$height) = getimagesize($image); 
	if ($width > $height) { 
			$newheight = round($maxwidth/$width * $height);  
			return '<img src="'.$image.'" width="'.$maxwidth.'" height="'.$newheight.'" alt="" />';  
	}  
	else { 
		$newwidth = round($maxheight/$height * $width);
		if ($newwidth > $maxwidth) {
			return '<img src="'.$image.'" width="'.$maxwidth.'"  alt="" />';
		}
		return '<img src="'.$image.'" width="'.$newwidth.'" height="'.$maxheight.'" alt="" />';
	}
}
?>

<div class="az_corner_top_left"><div class="az_corner_top_right"><div class="az_corner_top_x">&nbsp;</div></div></div>

<div class="az_corner_left_y">
<div class="az_corner_right_y">

<div class="title_featured"><?php echo MENU_TEXT_FEATURED; ?></div>		

<?php
$products_new_added_query = tep_db_query("select distinct p.codigo_proveedor, pd.products_id, pd.products_name, pd.products_description, p.products_date_added, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_image <> 'no-foto.jpg' order by p.products_date_added DESC LIMIT 100");
?>
<?php if (tep_db_num_rows($products_new_added_query) < 1) { ?>
<div class="display_none">&nbsp;</div>
<?php } else {?>

	<div class="prev2"></div>
	<div class="gallery2" style="width:822px !important">
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







				//	if(file_exists($realpath)) {
					?>


                          <?php





               $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $products_new_added['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){




 if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $products_new_added['products_image'])) {


     $image_sc = $ref_fabricante['proveedor_ruta_images'] . $products_new_added['products_image'];

    	?>

					<li>
						<div class="slide_wrapper_color_img">

						<div class="img_bg">
						<table style="" border="0" width="100%" cellspacing="0" cellpadding="0"><tr valign="middle"><td height="213" valign="middle" align="center">
							<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>">
								<?php
									//if product has big img
									$current_product =  $products_new_added['products_id'];
									$products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' ");
									$products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query);
									if (tep_not_null($products_new_added_big_img['image'])) {
									 	echo tep_image($image_sc, $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'style="border:none"');
									 }
									 else {
										echo tep_image($image_sc, $products_new_added['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
									}
								?>
							</a>

						</td></tr></table>
						</div>

						<div class="mask_top"><?php echo az_image(TMPL_IMAGES . 'az_mask_top.gif', IMAGE_BUTTON_WRITE_REVIEW); ?></div>
						<div class="mask_bottom"><?php echo az_image(TMPL_IMAGES . 'az_mask_bottom.gif', IMAGE_BUTTON_WRITE_REVIEW); ?></div>
						<div class="price_box_slider"><?php echo $products_new_added_price; ?></div>
						</div>



						<div>
							<a class="prod_name_featured" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>"><?php echo $products_new_added['products_name'];?></a>
						</div>

				</li>

          <?php

} else {
        $image_sc = $ref_fabricante['proveedor_ruta_images'] . 'no-foto.jpg';

 }






  }else{

// si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^http://", $products_new_added['products_image']) ) {

      $image_sc = '' . $products_new_added['products_image'];


    	?>

					<li>
						<div class="slide_wrapper_color_img">

						<div class="img_bg">
						<table style="" border="0" width="100%" cellspacing="0" cellpadding="0"><tr valign="middle"><td height="213" valign="middle" align="center">
							<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>">
								<?php
									//if product has big img
									$current_product =  $products_new_added['products_id'];
									$products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' ");
									$products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query);
									if (tep_not_null($products_new_added_big_img['image'])) {
									 	echo tep_image($image_sc, $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'style="border:none"');
									 }
									 else {
										echo tep_image($image_sc, $products_new_added['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
									}
								?>
							</a>

						</td></tr></table>
						</div>

						<div class="mask_top"><?php echo az_image(TMPL_IMAGES . 'az_mask_top.gif', IMAGE_BUTTON_WRITE_REVIEW); ?></div>
						<div class="mask_bottom"><?php echo az_image(TMPL_IMAGES . 'az_mask_bottom.gif', IMAGE_BUTTON_WRITE_REVIEW); ?></div>
						<div class="price_box_slider"><?php echo $products_new_added_price; ?></div>
						</div>



						<div>
							<a class="prod_name_featured" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>"><?php echo $products_new_added['products_name'];?></a>
						</div>

				</li>
          <?php


}else{

      $image_sc = DIR_WS_IMAGES . $products_new_added['products_image'];

           	?>

					<li>
						<div class="slide_wrapper_color_img">

						<div class="img_bg">
						<table style="" border="0" width="100%" cellspacing="0" cellpadding="0"><tr valign="middle"><td height="213" valign="middle" align="center">
							<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>">
								<?php
									//if product has big img
									$current_product =  $products_new_added['products_id'];
									$products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' ");
									$products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query);
									if (tep_not_null($products_new_added_big_img['image'])) {
									 	echo tep_image($image_sc, $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'style="border:none"');
									 }
									 else {
										echo tep_image($image_sc, $products_new_added['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
									}
								?>
							</a>

						</td></tr></table>
						</div>

						<div class="mask_top"><?php echo az_image(TMPL_IMAGES . 'az_mask_top.gif', IMAGE_BUTTON_WRITE_REVIEW); ?></div>
						<div class="mask_bottom"><?php echo az_image(TMPL_IMAGES . 'az_mask_bottom.gif', IMAGE_BUTTON_WRITE_REVIEW); ?></div>
						<div class="price_box_slider"><?php echo $products_new_added_price; ?></div>
						</div>



						<div>
							<a class="prod_name_featured" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>"><?php echo $products_new_added['products_name'];?></a>
						</div>

				</li>
          <?php

  }


   } // fin ref_fabricante









                               ?>









					<?php
				 	}
			//	}
				?>


		</ul>					
	</div>
	<div class="next2"></div>
	<div class="clear"></div>
	
<?php } ?>

</div></div>


<div class="az_corner_bottom_left"><div class="az_corner_bottom_right"><div class="az_corner_bottom_x">&nbsp;</div></div></div>

<script type="text/javascript">
	jQuery(function(){
		jQuery('.slide_wrapper_color_img').hover(
			function(){ jQuery('.price_box_slider',this).toggle() }
		);
	});
	
	
	

</script>

