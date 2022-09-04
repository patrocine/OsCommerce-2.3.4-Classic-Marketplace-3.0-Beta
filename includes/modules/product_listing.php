<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
//add product description to fetched fields
$listing_sqls = str_replace('pd.products_name,', 'pd.products_name, pd.products_description, ', $listing_sql);
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id ');
?>

<div class="contentText contConteiner_listing">
<?php
if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
    <div>
      <span class="f_right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>
      <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
    </div>
    <br />
<?php
  }

  $prod_list_contents = '<div class="infoBoxContainer">';

  if ( !empty($column_list) ) {
  $prod_list_contents .='  <div class="infoBoxHeading1 padding_pages_2 margin_bottom_1">' .
                        '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="productListingHeader1">' .
                        '      <tr>' .
                        '      <td class="padding0"><b>'.TEXT_SORT_PRODUCTS.' '.TEXT_BY.':</b>  ';

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
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
      $prod_list_contents .= '  '.$lc_text.'  ' ;
    }
  }

  $prod_list_contents .= '      </td>' .
                         '      </tr>' .
                         '    </table>' .
                         '  </div>';
  } // if ( !empty($column_list) ) {

  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);

    $prod_list_contents .= '    <table border="0" width="100%" cellspacing="0" cellpadding="2" class="padding0 productListingData">';

    $counter = 0;
    $col = 0;
    $width = floor(100 / $az_listing_columns);
    $num_products = tep_db_num_rows($listing_query);
    while ($listing = tep_db_fetch_array($listing_query)) {

        $counter++;
        if ($col === 0) {
            $prod_list_contents .= '<tr>';
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

                         // Total CON EL DESCUENTO DEL PRODUCTO
                                     if ($customer_id <> 0 OR DESCUENTO_CLIENTE <> 0){
       $products_porcentage_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $listing['products_id'] . "' and products_descuento_onoff = '" . 0 . "'");
      if ($products_porcentage = tep_db_fetch_array($products_porcentage_values)){


              $customers_porcentage = $products_porcentage['products_descuento'];

            $products_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;
              <font color="#FF0000" size="5"><b>' . $currencies->display_price($listing['products_price'] *$customers_porcentage/100+$listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</b></font></span>';




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


        #Include template layout for the product box
        #build variables map
        $product['id']				= $listing['products_id'];
        $product['model']				= $listing['products_model'];
        $product['name']			= $listing['products_name']  . ' ' .$listing['products_model'] . '';

        if ($listing['products_price'] <> 0 or $customer_group_price['customers_group_price'] <> 0){

        $product['price']			= $products_price;//.' <font color="#FF0000"><b>'.$customers_porcentage.'</b></font>';

		                            }else{

                                  $product['price']			= '';
                                  }

        $product['price_special']	= $products_price_special;



         $product['info_url']		= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id'].'&cPath='.$cPath);









        $product['desc']			= $listing['products_description'];
        $product['more_info_btn']	= tep_image_button('', AZ_BUTTON_MORE_INFO, '', '3');



                if (BOTON_COMPRA == 'True' and $listing['products_price'] <> 0){
        $product['buy_now_url']		= tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']);
         $product['buy_now_btn']	    = tep_image_button('button_in_cart.gif', AZ_BUTTON_CART, '', '2', false);

                            }
        $product['review_stars']	= az_get_products_rating($listing['products_id']);

		$product['buy_now_btn_main'] = az_image(TMPL_IMAGES . 'az-button-cart.gif');





               $products_id_stock = $product['id'];
                $act_stock_siempre = 'OK';

      require('product_stock.php');

      require('product_images_listing.php');





        //$get_width	= get_img_width(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, '', '', '');



















            IF (PERMISO_COINCIDENCIA_PROVEEDOR == 'True'){


            //Borra todos los registros que coincidan con precio y deja la ultima fecha.

         $group_producto_values = mysql_query("select referencia_fabricante, count(referencia_fabricante) as rf from " . 'products' . " where referencia_fabricante = '" . $listing['referencia_fabricante'] . "' and products_status = 1 group by referencia_fabricante order by products_price DESC");
   while  ($group_producto = mysql_fetch_array($group_producto_values)){

                     if  ($group_producto['referencia_fabricante'] <> '' and $group_producto['rf'] >= 2){

       $group2_producto_values = mysql_query("select * from " . 'products' . " where referencia_fabricante = '" . $group_producto['referencia_fabricante'] . "' order by products_price asc");
   if  ($group2_producto = mysql_fetch_array($group2_producto_values)){




            $sql_status_update_array = array('products_status' => 0,);
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id <> '" . $group2_producto['products_id'] . "' and referencia_fabricante = '" . $group2_producto['referencia_fabricante'] . "' ");




          ?>



         <script type="text/javascript">

       var pagina = '<? echo $PHP_SELF.$_SERVER['REQUEST_URI'];  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>


      <?php





      echo $group2_producto['products_price'];
   }

                   // echo $group_producto['rf'] . ' | ';
                                                             }


}



               } // permiso de coincidencia de proveedor




        if (($col >= $az_listing_columns) || ($counter == $num_products)) {
            while ( $col < $az_listing_columns ) {
                $prod_list_contents .= '<td class="padding0" width="'.$width.'%" align="center" valign="top"></td>';
                $col++;
            }

            $prod_list_contents .= '</tr>';
            $col = 0;
        }
    }

    $prod_list_contents .= '    </table>' .
                           '</div>';

    echo $prod_list_contents;




   } else {

/************** BEGIN SITESEARCH CHANGE ******************/
    if (isset($_GET['keywords'])) {







      echo  tep_draw_form('product_notify', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'post', 'onsubmit="return checkform(this);"'),
                                 '<table border="0"><tr><td class="productListing-data" colspan="2">' . TEXT_NO_PRODUCTS_KEYWORD  . '</td></tr>' .
                                 '<tr><td height="5"></td></tr><tr><td width="25%" class="productListing-data">' . TEXT_PRODUCT_NAME . '</td><td>' . tep_draw_input_field('keywords', '', 'size="40" maxlength="255" ') . '</td></tr>' .
                                 '<tr><td height="5"></td></tr><tr><td class="productListing-data">' . TEXT_CUSTOMER_NAME . '</td><td>' . tep_draw_input_field('cust_name', '', 'size="40" maxlength="100"', false) . '</td></tr>' .
                                 '<tr><td height="5"></td></tr><tr><td class="productListing-data">' . TEXT_CUSTOMER_EMAIL . '</td><td>' . tep_draw_input_field('cust_email', '', 'size="40" maxlength="100"', false) . '</td></tr>' .

                                 '<tr><td height="5"></td></tr><tr><td class="productListing-data" valign="top">' . TEXT_COMMENTS  . '</td><td>' . tep_draw_textarea_field('comments', 'soft', 10, 4, '', '', false) . '</td></tr>' .

                                 '<tr><td height="5"></td></tr><tr><td colspan="2" align="center" class="productListing-data"><INPUT type="submit" name="request_submit" value="Submit"></td></tr>' .
                                 '</table></form>';








    } else {
?>
    <p><?php echo TEXT_NO_PRODUCTS; ?></p>

<?php
    }
}
/************** BEGIN SITESEARCH CHANGE ******************/





  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

    <div class="az_pager">
      <span><?php echo '<label>'.TEXT_RESULT_PAGE.'</label>' . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>

    </div>
<?php
  }
?>
</div>
