<div class="specials-slider">

<div class="az-slider-top-left-spec">
	<div class="az-slider-top-right-spec">
		<div class="az-slider-top-x-spec">
			<h4 class="box-icon-title"><?php echo MENU_TEXT_SPECIALS; ?></h4>
		</div>
	</div>
</div>


<div class="az-slider-right-y">
<div class="az-slider-left-y-spec">
<div class="az-slider-bottom-x">
<div class="az-slider-bottom-left-spec">
<div class="az-slider-bottom-right-spec">


<?php
$products_specials_query = tep_db_query("select distinct p.codigo_proveedor, s.products_id, s.specials_new_products_price, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_SPECIALS . " s, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where s.products_id = pd.products_id and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and p.products_status = '1' order by s.specials_date_added  DESC LIMIT 30");
?>
<?php if (tep_db_num_rows($products_specials_query) < 1) { ?>
<div class="display_none">&nbsp;</div>
<?php } else {?>
	
	
	<?php if (tep_db_num_rows($products_specials_query) < 6) { ?>
	<div class="prev3" style="visibility:hidden"></div>
	<?php } else { echo '<div class="prev3"></div>';}?>
	
	
	
	
	<div class="gallery3" style="width:888px !important">
		<ul>
		  		<?php 
		 		$k = 0;
				while ($products_specials = tep_db_fetch_array($products_specials_query ) ) { 
					
					$products_specials['specials_new_products_price'] = tep_get_products_special_price($products_specials['products_id']);
				
					$whats_new_price = '<s>' . $currencies->display_price($products_specials['products_price'], tep_get_tax_rate($products_specials['products_tax_class_id'])) . '</s>&nbsp;&nbsp;';
					$whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price($products_specials['specials_new_products_price'], tep_get_tax_rate($products_specials['products_tax_class_id'])) . '</span>';
														
					$products_specials_price = az_change_format($whats_new_price);

					
					
				
    
               $ref_fabricante_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $products_specials['codigo_proveedor'] . "'");
               $ref_fabricante= mysql_fetch_array($ref_fabricante_values);

      if ($ref_fabricante['proveedor_ruta_images']){

 if (@getimagesize($ref_fabricante['proveedor_ruta_images']. $products_specials['products_image'])) {


     $image_sc = $ref_fabricante['proveedor_ruta_images'] . $products_specials['products_image'];

       				?>
					<li>

						<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">
							<div class="img-wrapper-listing <?php echo ((SMALL_IMAGE_WIDTH == 0) ? 'width_none':'width_act'); ?>" style="width:<?php echo ((SMALL_IMAGE_WIDTH == 0) ? '':SMALL_IMAGE_WIDTH + 2); ?>px">
								<div class="img-listing">
									<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_specials["products_id"]) ;?>">
         <?php echo tep_image($image_sc, $products_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?>
									</a>
								</div>
								<div class="az-corner-top-left">&nbsp;</div>
									<div class="az-corner-top-right">&nbsp;</div>
									<div class="az-corner-bottom-left">&nbsp;</div>
									<div class="az-corner-bottom-right">&nbsp;</div>
							</div>
						</td></tr></table>


						<div class="prod-info-intro"><a class="prod_name" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_specials["products_id"]) ;?>"><?php echo az_short_text($products_specials['products_name'] , 35) ?></a></div>
						<div class="price-slider-intro"><?php echo $products_specials_price; ?></div>

				  </li>
				<?php

} else {
        $image_sc = $ref_fabricante['proveedor_ruta_images'] . 'no-foto.jpg';

 }

  }else{

// si en la imagan el nombre empieza por http:// pues elimina la ruta actual para que la imagen del producto siempre se vea.
   if (ereg("^http://", $products_specials['products_image']) ) {

      $image_sc = '' . $products_specials['products_image'];
      
      
     				?>
					<li>

						<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">
							<div class="img-wrapper-listing <?php echo ((SMALL_IMAGE_WIDTH == 0) ? 'width_none':'width_act'); ?>" style="width:<?php echo ((SMALL_IMAGE_WIDTH == 0) ? '':SMALL_IMAGE_WIDTH + 2); ?>px">
								<div class="img-listing">
									<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_specials["products_id"]) ;?>">
         <?php echo tep_image($image_sc, $products_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?>
									</a>
								</div>
								<div class="az-corner-top-left">&nbsp;</div>
									<div class="az-corner-top-right">&nbsp;</div>
									<div class="az-corner-bottom-left">&nbsp;</div>
									<div class="az-corner-bottom-right">&nbsp;</div>
							</div>
						</td></tr></table>


						<div class="prod-info-intro"><a class="prod_name" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_specials["products_id"]) ;?>"><?php echo az_short_text($products_specials['products_name'] , 35) ?></a></div>
						<div class="price-slider-intro"><?php echo $products_specials_price; ?></div>

				  </li>
				<?php
      
      
}else{

      $image_sc = DIR_WS_IMAGES . $products_specials['products_image'];



       				?>
					<li>

						<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">
							<div class="img-wrapper-listing <?php echo ((SMALL_IMAGE_WIDTH == 0) ? 'width_none':'width_act'); ?>" style="width:<?php echo ((SMALL_IMAGE_WIDTH == 0) ? '':SMALL_IMAGE_WIDTH + 2); ?>px">
								<div class="img-listing">
									<a class="display_block" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_specials["products_id"]) ;?>">
         <?php echo tep_image($image_sc, $products_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?>
									</a>
								</div>
								<div class="az-corner-top-left">&nbsp;</div>
									<div class="az-corner-top-right">&nbsp;</div>
									<div class="az-corner-bottom-left">&nbsp;</div>
									<div class="az-corner-bottom-right">&nbsp;</div>
							</div>
						</td></tr></table>


						<div class="prod-info-intro"><a class="prod_name" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_specials["products_id"]) ;?>"><?php echo az_short_text($products_specials['products_name'] , 35) ?></a></div>
						<div class="price-slider-intro"><?php echo $products_specials_price; ?></div>

				  </li>
				<?php


  }


   } // fin ref_fabricante

    
    
    
    
    
				
					$realpath = DIR_FS_CATALOG.'/images/'. $products_specials['products_image'];	;
					//if(file_exists($realpath)) {





        // }
				}  
				?>
		</ul>					
	</div>
	
	
	<?php if (tep_db_num_rows($products_specials_query) < 6) { ?>
	<div class="next3" style="visibility:hidden"></div>
	<?php } else { echo '<div class="next3"></div>';}?>
	
	<div class="clear"></div>
	
<?php } ?>

</div>


</div>
</div>
</div>
</div>


</div>
