<div class="shop_cart_bg">
	<a href="<?php echo $tmpl['url']['cart'] ?>"><?php echo AZ_HEADER_SHOPPING_CART ?></a>
	<?php echo $cart->count_contents() > 0 ? SOME_ITEMS_IN_CART. $cart->count_contents() : AZ_HEADER_NOW_IN_CART; ?>
</div>






