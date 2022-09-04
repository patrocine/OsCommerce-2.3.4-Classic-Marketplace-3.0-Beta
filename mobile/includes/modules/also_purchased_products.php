<?php
  if (isset($HTTP_GET_VARS['products_id'])) {
    $orders_query = tep_db_query("select p.products_id, p.products_image from " . TABLE_ORDERS_PRODUCTS . " opa, " . TABLE_ORDERS_PRODUCTS . " opb, " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p where opa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and opa.orders_id = opb.orders_id and opb.products_id != '" . (int)$HTTP_GET_VARS['products_id'] . "' and opb.products_id = p.products_id and opb.orders_id = o.orders_id and p.products_status = '1' group by p.products_id order by o.date_purchased desc limit " . MAX_DISPLAY_ALSO_PURCHASED);
    $num_products_ordered = tep_db_num_rows($orders_query);

    if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED) {
?>
<!-- also_purchased_products //-->
<div id="also_purchased">
<h1><?php echo TEXT_ALSO_PURCHASED_PRODUCTS; ?></h1>
<?php
      $col = 0;
      $info_box_contents = array();
      while ($orders = tep_db_fetch_array($orders_query)) {
      	if($col > 2) break;
      	
        $orders['products_name'] = tep_get_products_name($orders['products_id']);
      	$col ++;
        $path = '<a href="' . tep_mobile_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id']) . '">';
        $img = tep_image(DIR_WS_IMAGES . $orders['products_image'], $orders['products_name'], MOBILE_IMAGE_WIDTH, MOBILE_IMAGE_HEIGHT);
?>
					<div id="prodCell_also">
					<div class="prodImg"><?php echo $path . $img . '</a>'; ?></div>
					<div class="prodName"><?php echo $path . $orders['products_name'] . '</a>'; ?></div>
					</div>
<?php       
      }

?>
</div>
<!-- also_purchased_products_eof //-->
<?php
    }
  }
?>
