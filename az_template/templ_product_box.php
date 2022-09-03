<?php
/*
  $Id: templ_product_box.php,v 1.0 17:37:59 06/17/2009  

  templ_product_box.php extension for AlgoZone templates (AFTS)

  Copyright (c) 2009 AlgoZone, Inc (www.algozone.com)

*/
?>

<?php
		// before including this module be sure you have variables map setup to structure: $product
        ob_start();
?>
			
				<div class="az_product_img" align="center"><a href="<?php echo $product['info_url'] ?>"><?php echo $product['image'] ?></a></div>
				<div class="az_product_box_padding" align="center">
					<div class="az_rating" align="center"><?php echo  $product['review_stars'] ?></div>
					<div class="az_product_name" align="center"><a href="<?php echo $product['info_url'] ?>"><?php echo $product['name'] ?></a></div>
					<div><?php echo $product['price'] ?></div>
					<div class="az_add_cart" align="center"><a href="<?php echo $product['buy_now_url'] ?>"><?php echo $product['buy_now_btn']; ?></a></div>
				</div>
					
		
<?php
        $az_product_html = ob_get_contents();
        ob_end_clean();

        $productbox = new azProductBox();
        $productbox->azSetBoxHeading();
        $productbox->azSetBoxContent($az_product_html);
        $productbox->azSetBoxFooter();
        $az_product_html = $productbox->azCreateBox('pbox', '', '', '', false);

?>
