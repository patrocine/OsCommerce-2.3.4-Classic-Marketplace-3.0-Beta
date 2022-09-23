<?php
/*
  $Id: az_product.php,v 1.0 17:37:59 06/17/2009  

  az_product.php extension for AlgoZone templates

  Copyright (c) 2009 AlgoZone, Inc (www.algozone.com)

*/
?>
<!-- az_product //-->
<?php  
	
	/*
	before including this module be sure you have defined right values in structure: $product
	*/
	/*$az_imgbox = new azImageBox();
    $imgboxW = ($product['image_size'][0]+6) . 'px'; // image border width
	$prod_img = $az_imgbox->azCreateBox($product['image'], $imgboxW);*/
	    	
	ob_start();	
?>	
	 <div class="az_product_list_box">
	 
	 <div class="az_product_list_img"><?php echo $product['image'];?></div>
	 <div class="az_product_list_head"><?php echo $product['name'];?></div>	 
	 <div class="az_product_list_price"><?php echo $product['price'];?></div>
	 <div class="clear"></div>
	 
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
<!-- az_product_eof //-->


