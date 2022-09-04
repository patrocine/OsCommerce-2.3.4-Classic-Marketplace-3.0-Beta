<div class="new-products-slider">

<div class="az-slider-top-left">
	<div class="az-slider-top-right">
		<div class="az-slider-top-x">
			<h4 class="box-icon-title"><?php echo MENU_TEXT_NEW_PRODUCTS; ?></h4>
		</div>
	</div>
</div>


<div class="az-slider-right-y">
<div class="az-slider-left-y">
<div class="az-slider-bottom-x">
<div class="az-slider-bottom-left">
<div class="az-slider-bottom-right">


<?php


function imageRestrict_new_prod($image) {  
	$maxwidth = 168; 
	$maxheight = 168; 
	list($width,$height) = getimagesize($image); 
		if ($width == $maxwidth) { 
			return '<img src="'.$image.'" width="'.$maxwidth.'" alt="" />';  
		}  
		else  { 
			return '<span class="space_1"><img src="'.$image.'" width="'.$maxwidth.'" height="'.$maxheight.'" alt="" /></span>';
		}
}
?>


<?php
$products_new_added_query = tep_db_query("select distinct p.codigo_proveedor, pd.products_id, pd.products_name, pd.products_description, p.products_date_added, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_image <> 'no-foto.jpg' order by p.products_date_added DESC LIMIT 100");
?>
<?php if (tep_db_num_rows($products_new_added_query) < 1) { ?>
<div class="display_none">&nbsp;</div>
<?php } else {?>
	
	<div class="prev2"></div>
	<div class="gallery2" style="width:888px !important">
		<ul>
		  		<?php 
		 		$k = 0;
				while ($products_new_added = tep_db_fetch_array($products_new_added_query) ) { 
					
					$products_new_added['specials_new_products_price'] = tep_get_products_special_price($products_new_added['products_id']);
				
					if (tep_not_null($products_new_added['specials_new_products_price'])) {
						$whats_new_price = '<s>' . $currencies->display_price($products_new_added['products_price'], tep_get_tax_rate($products_new_added['products_tax_class_id'])) . '</s> ';
				  		$whats_new_price .= '<span>' . $currencies->display_price($products_new_added['specials_new_products_price'], tep_get_tax_rate($products_new_added['products_tax_class_id'])) . '</span>';
					} else {
				  		$whats_new_price = $currencies->display_price($products_new_added['products_price'], tep_get_tax_rate($products_new_added['products_tax_class_id']));
					}
					$products_new_added_price = az_change_format($whats_new_price);
				

				
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

						<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">

							<div class="img-wrapper-listing <?php echo ((SMALL_IMAGE_WIDTH == 0) ? 'width_none':'width_act'); ?>" style="width:<?php echo ((SMALL_IMAGE_WIDTH == 0) ? '':SMALL_IMAGE_WIDTH + 2); ?>px">

     
             					<div class="img-listing">
									<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>">
                                    <?php echo tep_image($image_sc, $products_new_added['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);	?>

                     				</a>
								</div>

								<div class="az-corner-top-left">&nbsp;</div>
								<div class="az-corner-top-right">&nbsp;</div>
								<div class="az-corner-bottom-left">&nbsp;</div>
								<div class="az-corner-bottom-right">&nbsp;</div>
							</div>

						</td></tr></table>



						<div class="prod-info-intro"><a class="prod_name" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>"><?php echo az_short_text( $products_new_added['products_name'] , 35) ?></a></div>
						<div class="price-slider-intro"><?php echo $products_new_added_price; ?></div>

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

						<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">

							<div class="img-wrapper-listing <?php echo ((SMALL_IMAGE_WIDTH == 0) ? 'width_none':'width_act'); ?>" style="width:<?php echo ((SMALL_IMAGE_WIDTH == 0) ? '':SMALL_IMAGE_WIDTH + 2); ?>px">


             					<div class="img-listing">
									<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>">
                                    <?php echo tep_image($image_sc, $products_new_added['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);	?>

                     				</a>
								</div>

								<div class="az-corner-top-left">&nbsp;</div>
								<div class="az-corner-top-right">&nbsp;</div>
								<div class="az-corner-bottom-left">&nbsp;</div>
								<div class="az-corner-bottom-right">&nbsp;</div>
							</div>

						</td></tr></table>



						<div class="prod-info-intro"><a class="prod_name" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>"><?php echo az_short_text( $products_new_added['products_name'] , 35) ?></a></div>
						<div class="price-slider-intro"><?php echo $products_new_added_price; ?></div>

					</li>

          <?php
      
      
}else{

      $image_sc = DIR_WS_IMAGES . $products_new_added['products_image'];
      
           	?>

                         			<li>

						<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">

							<div class="img-wrapper-listing <?php echo ((SMALL_IMAGE_WIDTH == 0) ? 'width_none':'width_act'); ?>" style="width:<?php echo ((SMALL_IMAGE_WIDTH == 0) ? '':SMALL_IMAGE_WIDTH + 2); ?>px">


             					<div class="img-listing">
									<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>">
                                    <?php echo tep_image($image_sc, $products_new_added['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);	?>

                     				</a>
								</div>

								<div class="az-corner-top-left">&nbsp;</div>
								<div class="az-corner-top-right">&nbsp;</div>
								<div class="az-corner-bottom-left">&nbsp;</div>
								<div class="az-corner-bottom-right">&nbsp;</div>
							</div>

						</td></tr></table>



						<div class="prod-info-intro"><a class="prod_name" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added["products_id"]) ;?>"><?php echo az_short_text( $products_new_added['products_name'] , 35) ?></a></div>
						<div class="price-slider-intro"><?php echo $products_new_added_price; ?></div>

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

</div>


</div>
</div>
</div>
</div>
</div>
