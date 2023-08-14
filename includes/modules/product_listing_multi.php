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
          

    $ctc_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $listing['products_id'] . "'");
    $ctc = tep_db_fetch_array($ctc_values);
    $ctcp_values = tep_db_query("select * from " . TABLE_CATEGORIES . " where categories_id= '" . $ctc['categories_id'] . "'");
    $ctcp = tep_db_fetch_array($ctcp_values);
    $ctcp2_values = tep_db_query("select * from " . TABLE_CATEGORIES . " where categories_id= '" . $ctcp['parent_id'] . "'");
    $ctcp2 = tep_db_fetch_array($ctcp2_values);

                          if (ACTIVAR_IMAGEN_AUTOMATICA == 'true'){
                       if ($listing['products_image']){
            $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctc['categories_id'] . "'");

             $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctcp['parent_id'] . "'");
                                              }


             $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctcp2['parent_id'] . "'");
                                        }

   if (PERMISO_PORCENTAGE_PRECIO == 'True'){


             if ($listing['products_porcentage'] <= -0.1) {
                 $porcentage = '<font color="#FF0000"  size="2">'.$listing['products_porcentage']. '% '.'</font>';
             }else if($listing['products_porcentage'] >= 0.1){
                     if (PERMISO_PORCENTAGE_PRECIO_MAS == 'True'){
                  $porcentage = '<font color="#008000"  size="2">+'.$listing['products_porcentage']. '% '.'</font>';
                                          }else{
                                      $porcentage = '';
                                      }


         }else{
       $porcentage = '';

     }


           } // permiso porcentaje








$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $listing['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = ''.$currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '';
  }
}
                $products_price = az_change_format($products_price);



       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'].'%';
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
            $price_descpro = $listing['products_price'] *$customers_porcentage/100+$listing['products_price'];

            if ($price_descpro == $listing['products_price']){

$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        }

}else{

  $products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

}


                         // Total CON EL DESCUENTO DEL PRODUCTO
                                     if ($customer_id <> 0 OR DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'];

            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

            if ($products_price <> $listing['products_price']){

//$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
            }



      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] <> 0 ){

      $customers_porcentage = $customers_porcentage['customers_porcentage'];







            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';





 }else{

      $customers_porcentage = DESCUENTO_CLIENTE;
              if (DESCUENTO_CLIENTE <> 0){
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';



                                                                                     }


}


  }
         } // Total CON EL DESCUENTO DEL PRODUCTO



    // if ($products_price == 0){
     //$products_price = '';
   // }


if ($customers_porcentage == 0){

        $customers_porcentage = '';


}
if ($customers_porcentage){

     }else{
            $products_price =  '<font color="#000000" size="5"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</b></font>';
              }

    $pdc_precio_final_values = mysql_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $listing['products_id'] . "' order by pdc_unidades asc");
  if ($pdc_precio_final = mysql_fetch_array($pdc_precio_final_values)){

            $pdc_price_final = ' <font color="#000000" size="0"><p style="margin-top: 0; margin-bottom: 0"> <font size="0">+'.$pdc_precio_final['pdc_unidades'].' Pcs ->></s>
              <font color="#ff0000" size="0"><b>' . $pdc_precio_final['pdc_price_final'] . '€ .....</b></font></span></p>';



}else{
 $pdc_price_final = '';
}





        if (tep_not_null($listing['specials_new_products_price'])) {
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
                <font color="#FF0000" size="6"><b>' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        } else {
          //  $products_price = $porcentage . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
        }

            $precio_permiso = $products_price;



     if (tep_not_null($listing['specials_new_products_price'])) {

          $customers_porcentage = '';
 }


                              
                              
$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $listing['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = ''.$currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '';
  }
}
                $products_price = az_change_format($products_price);

                              
                              




        $p_stock_values = tep_db_query("select * from " . 'products_stock' . " where products_id = '" . $listing['products_id']  . "'");
       $p_stock = tep_db_fetch_array($p_stock_values);

                             if (  $listing['stock_nivel'] ==  6){

                                          if ($p_stock['products_stock_real'] <= 0){

                        $prod_list_contents .= '       <td align="right"><p><b> <p style="margin-top: 0; margin-bottom: 0"><font color="#FF0000">Stock: ' .  $p_stock['products_stock_real'] . '</p>';
                         $prod_list_contents .= '       <p style="margin-top: 0; margin-bottom: 0"> <font color="#FF9933">Pendiente: ' .  $p_stock['products_stock_pendiente'] . '</font></b></p></td>';





                                         }else{


                    $prod_list_contents .= '        <td align="right"><p><b><font color="#008080">Stock: ' .  $p_stock['products_stock_real'] . '</font></b></p></td>';



                                                          }



                                                          }else if (  $listing['stock_nivel'] ==  1){

                    $prod_list_contents .= '        <td align="right"><p><b><font color="#008080">Stock</font></b></p></td>';

                                                      }else if (  $listing['stock_nivel'] ==  3){

                    $prod_list_contents .= '        <td align="right"><p><b><font color="#008080">Bajo Pedido</font></b></p></td>';

                                                      }else if (  $listing['stock_nivel'] ==  2){

                    $prod_list_contents .= '        <td align="right"><p><b><font color="#008080">Cita Previa</font></b></p></td>';

                                                      }
          
            if (tep_not_null($listing['specials_new_products_price'])) {
             // $prod_list_contents .= '        <td align="right"><del>' .  $products_price . '</del>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span></td>';
            } else {
             // $prod_list_contents .= '        <td align="right">' . $products_price . '</td>';
            }
            break;
          case 'PRODUCT_LIST_PRICE':
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








    $ctc_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $listing['products_id'] . "'");
    $ctc = tep_db_fetch_array($ctc_values);
    $ctcp_values = tep_db_query("select * from " . TABLE_CATEGORIES . " where categories_id= '" . $ctc['categories_id'] . "'");
    $ctcp = tep_db_fetch_array($ctcp_values);
    $ctcp2_values = tep_db_query("select * from " . TABLE_CATEGORIES . " where categories_id= '" . $ctcp['parent_id'] . "'");
    $ctcp2 = tep_db_fetch_array($ctcp2_values);

                          if (ACTIVAR_IMAGEN_AUTOMATICA == 'true'){
                       if ($listing['products_image']){
            $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctc['categories_id'] . "'");

             $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctcp['parent_id'] . "'");
                                              }


             $sql_status_update_array = array('categories_image' => $listing['products_image']);

            tep_db_perform(TABLE_CATEGORIES, $sql_status_update_array, 'update', " categories_id= '" . $ctcp2['parent_id'] . "'");
                                        }

   if (PERMISO_PORCENTAGE_PRECIO == 'True'){


             if ($listing['products_porcentage'] <= -0.1) {
                 $porcentage = '<font color="#FF0000"  size="2">'.$listing['products_porcentage']. '% '.'</font>';
             }else if($listing['products_porcentage'] >= 0.1){
                     if (PERMISO_PORCENTAGE_PRECIO_MAS == 'True'){
                  $porcentage = '<font color="#008000"  size="2">+'.$listing['products_porcentage']. '% '.'</font>';
                                          }else{
                                      $porcentage = '';
                                      }


         }else{
       $porcentage = '';

     }


           } // permiso porcentaje








$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $listing['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = ''.$currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '';
  }
}
                $products_price = az_change_format($products_price);



       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'].'%';
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="3"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
            $price_descpro = $listing['products_price'] *$customers_porcentage/100+$listing['products_price'];

            if ($price_descpro == $listing['products_price']){

$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        }

}else{

  $products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

}


                         // Total CON EL DESCUENTO DEL PRODUCTO
                                     if ($customer_id <> 0 OR DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'];

            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';

            if ($products_price <> $listing['products_price']){

//$products_price = '<font color="#000000" size="3"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
            }



      }else{


        $customers_porcentage_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $customer_id  . "' and customers_porcentage <> '" . 0 . "'");
       $customers_porcentage = tep_db_fetch_array($customers_porcentage_values);
    if ( $customers_porcentage['customers_porcentage'] <> 0 ){

      $customers_porcentage = $customers_porcentage['customers_porcentage'];







            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';





 }else{

      $customers_porcentage = DESCUENTO_CLIENTE;
              if (DESCUENTO_CLIENTE <> 0){
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';



                                                                                     }


}


  }
         } // Total CON EL DESCUENTO DEL PRODUCTO



    // if ($products_price == 0){
     //$products_price = '';
   // }


if ($customers_porcentage == 0){

        $customers_porcentage = '';


}
if ($customers_porcentage){

     }else{
            $products_price =  '<font color="#000000" size="5"><b>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</b></font>';
              }

    $pdc_precio_final_values = mysql_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .  $listing['products_id'] . "' order by pdc_unidades asc");
  if ($pdc_precio_final = mysql_fetch_array($pdc_precio_final_values)){

            $pdc_price_final = ' <font color="#000000" size="0"><p style="margin-top: 0; margin-bottom: 0"> <font size="0">+'.$pdc_precio_final['pdc_unidades'].' Pcs ->></s>
              <font color="#ff0000" size="0"><b>' . $pdc_precio_final['pdc_price_final'] . '€ .....</b></font></span></p>';



}else{
 $pdc_price_final = '';
}





        if (tep_not_null($listing['specials_new_products_price'])) {
            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
                <font color="#FF0000" size="6"><b>' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';
        } else {
          //  $products_price = $porcentage . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
        }

            $precio_permiso = $products_price;



     if (tep_not_null($listing['specials_new_products_price'])) {

          $customers_porcentage = '';
 }




$customer_group_query = tep_db_query("select customers_group_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
$customer_group = tep_db_fetch_array($customer_group_query);
$customer_group_price_query = tep_db_query("select customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $listing['products_id'] . "' and customers_group_id =  '" . $customer_group['customers_group_id'] . "'");
if ( $customer_group['customers_group_id'] != 0) {
  if ($customer_group_price = tep_db_fetch_array($customer_group_price_query)) {
    $products_price = ''.$currencies->display_price($customer_group_price['customers_group_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '';
  }
}
                $products_price = az_change_format($products_price);







        $p_stock_values = tep_db_query("select * from " . 'products_stock' . " where products_id = '" . $listing['products_id']  . "'");
       $p_stock = tep_db_fetch_array($p_stock_values);



             if (tep_not_null($listing['specials_new_products_price'])) {
              $prod_list_contents .= '        <p style="margin-top: 0; margin-bottom: 0"><td align="right"><del>' .  $products_price . '</del>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span></td>';
            } else {
         if ($p_stock['products_stock_real'] <= 0){
            $stock = ' <p style="margin-top: 0; margin-bottom: 0"><b><font size="1" color="#FF0000"></p> Stock: '.$p_stock['products_stock_real'];
     }else{
          $stock = ' <p style="margin-top: 0; margin-bottom: 0"><b><font size="1" color="#008000"></p> Stock: '.$p_stock['products_stock_real'];

 }

              $prod_list_contents .= '        <p style="margin-top: 0; margin-bottom: 0"><td align="right">' . $products_price . ' <p style="margin-top: 0; margin-bottom: 0"></p>'.$listing['products_model']. $stock . '</font></b><font size="1"><p style="margin-top: 0; margin-bottom: 0"></p>' . $listing['products_name'] . '<font size="4"><p style="margin-top: 0; margin-bottom: 0"></p>Cod.' . $listing['products_id'] . '</p>'.tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', null, 'primary').' </p> .</font></td></p>';

            }
            





              if (  $listing['stock_nivel'] ==  6){

               if ($p_stock['products_stock_real'] <= 0){

      $prod_list_contents .= '                        <td align="center">';
            $prod_list_contents .= '                  </td>';


                   }else{
            $prod_list_contents .= '                        <td align="center"><input type=button value="  -1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),-1);return  false;"><input type="text" name="add_id['.$number_of_products.']"  id="add_id_'.$listing['products_id'].'" value="0" size="3"><input  type=button value="+1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),1);return  false;">';
            $prod_list_contents .= '                        <input type="hidden"  name="products_id[' . $number_of_products . ']"  value="' . $listing['products_id'] . '"></td>';
                  }

            }  else   if (  $listing['stock_nivel'] ==  1){

            $prod_list_contents .= '                        <td align="center"><input type=button value="  -1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),-1);return  false;"><input type="text" name="add_id['.$number_of_products.']"  id="add_id_'.$listing['products_id'].'" value="0" size="3"><input  type=button value="+1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),1);return  false;">';
            $prod_list_contents .= '                        <input type="hidden"  name="products_id[' . $number_of_products . ']"  value="' . $listing['products_id'] . '"></td>';


        }  else   if (  $listing['stock_nivel'] ==  2){

            $prod_list_contents .= '                        <td align="center"><input type=button value="  -1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),-1);return  false;"><input type="text" name="add_id['.$number_of_products.']"  id="add_id_'.$listing['products_id'].'" value="0" size="3"><input  type=button value="+1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),1);return  false;">';
            $prod_list_contents .= '                        <input type="hidden"  name="products_id[' . $number_of_products . ']"  value="' . $listing['products_id'] . '"></td>';



    }  else   if (  $listing['stock_nivel'] ==  3){
            $prod_list_contents .= '                        <td align="center"><input type=button value="  -1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),-1);return  false;"><input type="text" name="add_id['.$number_of_products.']"  id="add_id_'.$listing['products_id'].'" value="0" size="3"><input  type=button value="+1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),1);return  false;">';
            $prod_list_contents .= '                        <input type="hidden"  name="products_id[' . $number_of_products . ']"  value="' . $listing['products_id'] . '"></td>';

}












                            // IMAGENES DE PRODUCTO
                         $products_imagen = $listing['products_image'];
                         $codigo_proveedor = $listing['codigo_proveedor'];
                         require('require_images_cat.php');










              $prod_list_contents .= '        <td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . '<img src="'. $image_product  .'"  height="'. SMALL_IMAGE_WIDTH .'" width="'. SMALL_IMAGE_HEIGHT .'"></a>' . '</a></td>';

              $prod_list_contents .= '        <p><td align="center"><font size="7">' .$listing['products_id']. '</font></a></td></p>';







           }
            break;
          case 'PRODUCT_LIST_BUY_NOW':
  //          $prod_list_contents .= '        <td align="center">' . $lc_text = '<input type=button value="  -1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),-1);return  false;"><input type="text" name="add_id['.$number_of_products.']"  id="add_id_'.$listing['products_id'].'" value="0" size="3"><input  type=button value="+1" onclick="javascript:changeValue(document.getElementById(\'add_id_'.$listing['products_id'].'\'),1);return  false;">';
  //        $lc_text .= '<input type="hidden"  name="products_id['.$number_of_products.']"  value="'.$listing['products_id'].'">';



                  
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
          <?php echo tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', null, 'primary'); ?>
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
