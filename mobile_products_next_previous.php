<?php
  /*

  WebMakers.com Added: Previous/Next through categories products
  Thanks to Nirvana, Yoja and Joachim de Boer
  Modifications: Linda McGrath osCommerce@WebMakers.com

  /includes/products_next_previous.php

  Syntax:
 include (DIR_WS_INCLUDES . 'products_next_previous.php');
  
  
  Already has its own table and can be included anywhere in product_info.php

  Add to english.php

  Can now work with cateogies at any depth

  */
    // previous next product
  define('PREV_NEXT_PRODUCT', 'Product ');
  define('PREV_NEXT_FROM', ' from ');
   define('TEXT_ANTERIOR_INFO', 'Anterior ');
  define('TEXT_SIGUIENTE_INFO', ' Siguiente ');


				// calculate the previous and next
				if (!$current_category_id) {
					$cPath_query = tep_db_query ("SELECT categories_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id ='" .  (int)$HTTP_GET_VARS['products_id'] . "'");
					$cPath_row = tep_db_fetch_array($cPath_query);
					$current_category_id = $cPath_row['categories_id'];
				}
                                                                                                                                           //  p.products_status = '1'  and
        $products_ids = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc where p.products_status = '1'  and p.products_id = ptc.products_id and ptc.categories_id = $current_category_id");

				while ($product_row = tep_db_fetch_array($products_ids)) {
					$id_array[] = $product_row['products_id'];
				}


        //   ECHO       $id_array;
				reset ($id_array);
				$counter = 0;
				while (list($key, $value) = each ($id_array)) {
					if ($value == (int)$HTTP_GET_VARS['products_id']) {
						$position = $counter;
						if ($key == 0)
							$previous = -1; // it was the first to be found
						else
							$previous = $id_array[$key - 1];

						if ($id_array[$key + 1])
							$next_item = $id_array[$key + 1];
						else {
							$next_item = $id_array[0];
						}
					}
					$last = $value;
					$counter++;

				}
				if ($previous == -1)
					$previous = $last;

				$category_name_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = $current_category_id AND language_id = $languages_id");
				$category_name_row = tep_db_fetch_array($category_name_query);
?>
<tr>
  <td>
    <table border="0" align="center">
      <tr>
        <td align="left" class="main"><a href="<? echo tep_href_link('mobile_product_info.php', "products_id=$previous&cPath=$cPath"); ?>"><?php echo TEXT_ANTERIOR_INFO; ?></a></td>
<!--        <td align="center" class="main"><?php echo (PREV_NEXT_PRODUCT); ?><?php echo ($position+1 . "/" . $counter); ?><br><?php echo (PREV_NEXT_FROM) ?><?php echo ($category_name_row['categories_name']); ?></td> -->
        <td align="center" class="main"><?php echo (PREV_NEXT_PRODUCT); ?><?php echo ($position+1 . "/" . $counter); ?></td>
        <td align="right" class="main"><a href="<? echo tep_href_link('mobile_product_info.php', "products_id=$next_item&cPath=$cPath"); ?>"><?php echo TEXT_SIGUIENTE_INFO; ?></a></td>
      </tr>
    </table>
  </td>
</tr>
