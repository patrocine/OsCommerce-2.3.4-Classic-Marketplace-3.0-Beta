<?php    echo  tep_draw_form('cart_multi', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_multi'));?>
<script language=javascript> function changeValue(textObject,delta){  var myVal = parseInt(textObject.value);  if (myVal == NaN) {   myVal = 0;   } else {  myVal = myVal + delta;  }  /* check that it is not negetive */  if (myVal < 0) {  myVal = 0;  }  textObject.value = myVal;  return; } </script>
<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
?>
 
  <div class="contentText">

<?php
  if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>


<?php
  }

  $prod_list_contents = '<div class="ui-widget infoBoxContainer">' .
                        '  <div class="ui-widget-header ui-corner-top infoBoxHeading">' .
                        '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="productListingHeader">' .
                        '      <tr>';

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    $lc_align = '';

    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;        
      case 'PRODUCT_LIST_MIN_ORDER_QTY':
        $lc_align = 'center';
        $lc_text = '&nbsp;' . TABLE_HEADING_MIN_ORDER_QTY . '&nbsp;';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;
      case 'PRODUCT_LIST_BUY_NOW':
        $lc_text = TABLE_HEADING_BUY_NOW;
        $lc_align = 'center';
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
    }

    $prod_list_contents .= '        <td' . (tep_not_null($lc_align) ? ' align="' . $lc_align . '"' : '') . '>' . $lc_text . '</td>';
  }

  $prod_list_contents .= '      </tr>' .
                         '    </table>' .
                         '  </div>';

  if ($listing_split->number_of_rows > 0) {

    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);
    $prod_list_contents .= '  <div class=" ui-corner-bottom productListTable">' .
                           '    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="productListingData">';

while ($listing = tep_db_fetch_array($listing_query)) {
      $rows++;

      $prod_list_contents .= '      <tr>';

      for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
        switch ($column_list[$col]) {
          case 'PRODUCT_LIST_MODEL':
            $prod_list_contents .= '        <td>' . $listing['products_model'] . '</td>';
            break;
          case 'PRODUCT_LIST_NAME':
            if (isset($HTTP_GET_VARS['manufacturers_id']) && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
              $prod_list_contents .= '        <td><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . $listing['products_name'] . '</a></td>';
            } else {
              $prod_list_contents .= '        <td><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . $listing['products_name'] . '</a></td>';
            }
            break;
          case 'PRODUCT_LIST_MANUFACTURER':
            $prod_list_contents .= '        <td><a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a></td>';
            break;
          case 'PRODUCT_LIST_PRICE':
            if (tep_not_null($listing['specials_new_products_price'])) {
              $prod_list_contents .= '        <td align="right"><del>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</del>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span></td>';
            } else {
              $prod_list_contents .= '        <td align="right">' . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</td>';
            }
            break;
          case 'PRODUCT_LIST_QUANTITY':
            $prod_list_contents .= '        <td align="right">' . $listing['products_quantity'] . '</td>';
            break;            
          case 'PRODUCT_LIST_MIN_ORDER_QTY':
            $prod_list_contents .= '        <td align="right">' . $lc_text = '&nbsp;' . $listing['products_min_order_qty'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_WEIGHT':
            $prod_list_contents .= '        <td align="right">' . $listing['products_weight'] . '</td>';
            break;
          case 'PRODUCT_LIST_IMAGE':
            if (isset($HTTP_GET_VARS['manufacturers_id'])  && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
              $prod_list_contents .= '        <td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td>';
            } else {
              $prod_list_contents .= '        <td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td>';
            }
            break;
          case 'PRODUCT_LIST_BUY_NOW':
  //          $prod_list_contents .= '        <td align="center">' . $lc_text = '<input type=button value="  -1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),-1);return  false;"><input type="text" name="add_id['.$number_of_products.']"  id="add_id_'.$listing['products_id'].'" value="0" size="3"><input  type=button value="+1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),1);return  false;">'; 
  //        $lc_text .= '<input type="hidden"  name="products_id['.$number_of_products.']"  value="'.$listing['products_id'].'">';
            $prod_list_contents .= '                        <td align="center"><input type=button value="  -1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),-1);return  false;"><input type="text" name="add_id['.$number_of_products.']"  id="add_id_'.$listing['products_id'].'" value="0" size="3"><input  type=button value="+1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),1);return  false;">';     
            $prod_list_contents .= '                        <input type="hidden"  name="products_id[' . $number_of_products . ']"  value="' . $listing['products_id'] . '"></td>';           
  
         break;  
		           
        }
      }

      $prod_list_contents .= '      </tr>';
    }

    $prod_list_contents .= '    </table>' .
                           '  </div>' .
                           '</div>';

    echo $prod_list_contents;
  } else {
?>

    <p><?php echo TEXT_NO_PRODUCTS; ?></p>

<?php
  }

  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

    <br />

    <div>
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>

      <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
    </div>

<br>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" class="main"><?php echo tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', null, 'primary'); ?></td>

  </tr>
</table>
</form>
<?php
  }
?>

  </div>
