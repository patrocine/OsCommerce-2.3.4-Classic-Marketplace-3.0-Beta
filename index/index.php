<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
            require('mobile_version.php');
            
  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }}
// the following cPath references come from application_top.php
  $category_depth = 'top';
  if (isset($cPath) && tep_not_null($cPath)) {
    $categories_products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
    $categories_products = tep_db_fetch_array($categories_products_query);
    if ($categories_products['total'] > 0) {
      $category_depth = 'products'; // display products
    } else {
      $category_parent_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$current_category_id . "'");
      $category_parent = tep_db_fetch_array($category_parent_query);
      if ($category_parent['total'] > 0) {
        $category_depth = 'nested'; // navigate through the categories
      } else {
        $category_depth = 'products'; // category has no products, but display the 'no products' message
      }
    }
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);
  
  


  require(DIR_WS_INCLUDES . 'template_top.php');

  if ($category_depth == 'nested') {
    $category_query = tep_db_query("select cd.categories_name, cd.categories_name_suple, c.categories_image from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and cd.categories_id = '" . (int)$current_category_id . "' and cd.language_id = '" . (int)$languages_id . "'");
    $category = tep_db_fetch_array($category_query);
    
    
       if ($category['categories_name_suple']){
       $categories_a = $category['categories_name_suple'];
}else{
    $categories_a = $category['categories_name'];
}
    
?>

<h1><?php echo $categories_a; ?></h1>

<div class="contentContainer">
  <div class="contentText">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
<?php
    if (isset($cPath) && strpos('_', $cPath)) {
// check to see if there are deeper categories within the current category
      $category_links = array_reverse($cPath_array);
      for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
        $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
        $categories = tep_db_fetch_array($categories_query);
        
        


        
        
        
        if ($categories['total'] < 1) {
          // do nothing, go through the loop
        } else {
          $categories_query = tep_db_query("select c.categories_productos, c.categories_id, cd.categories_name, cd.categories_name_suple, cd.categories_name_http, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_status_visible='" . 1 ."' order by sort_order, cd.categories_name");
          break; // we've found the deepest category the customer is in
        }
      }
    } else {
          $categories_query = tep_db_query("select c.categories_productos, c.categories_id, cd.categories_name, cd.categories_name_suple, cd.categories_name_http, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_status_visible='" . 1 ."'  order by sort_order, cd.categories_name");
    }

    $number_of_categories = tep_db_num_rows($categories_query);

    $rows = 0;
    while ($categories = tep_db_fetch_array($categories_query)) {
      $rows++;
      
      
      if ($categories['categories_name_suple']){
       $categories_a = $categories['categories_name_suple'];
}else{


    $categories_a = $categories['categories_name'];

}



      
      $cPath_new = tep_get_path($categories['categories_id']);
      
      
      if ($categories['categories_name_http']){
       $categories_http = $categories['categories_name_http'];
}else{
    $categories_http = tep_href_link(FILENAME_DEFAULT, $cPath_new);
}
      
      $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';


      if ($categories['categories_productos'] == 0){




}else{


    if (ereg("^https://", $categories['categories_image']) ) {
    echo '        <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . $categories_http . '">' . tep_image($categories['categories_image'], $categories_a, SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br />' . $categories_a . '</a></td>' . "\n";
    }else{
//    echo '        <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . $categories_http . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories_a, SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br />' . $categories_a . '</a></td>' . "\n";
    echo '        <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . $categories_http . '">' . '<img border="0" src="'. DIR_WS_IMAGES . $categories['categories_image'] .'" width="' . SUBCATEGORY_IMAGE_WIDTH . '" height="' . SUBCATEGORY_IMAGE_HEIGHT . '">' . '<br />' . $categories_a . '</a></td>' . "\n";

     }



}

        if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_categories)) {
        echo '      </tr>' . "\n";
        echo '      <tr>' . "\n";
      }
    }


// needed for the new products module shown below
    $new_products_category_id = $current_category_id;
?>

 <form method="GET" action="advanced_search_result.php">
	<p style="margin-top: 0; margin-bottom: 0">
	<input type="text" name="keywords" size="30" style="font-family: Verdana; font-size: 10pt; font-weight: bold">
    <input type="radio" value="<?php echo (int)$current_category_id ?>" checked name="categories_id">
    <input type="radio" value="1" checked name="inc_subcat">     </p>

	<?php echo tep_draw_button('Buscar en estas Categorías', 'key', null, 'primary'); ?></p>
</form>





      </tr>
    </table>

    <br />

<?php include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS); ?>

  </div>
</div>

<?php
  } elseif ($category_depth == 'products' || (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id']))) {
// create column list
    $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                         'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                         'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                         'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                         'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                         'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                         'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                         'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

    asort($define_list);

    $column_list = array();
    reset($define_list);
    while (list($key, $value) = each($define_list)) {
      if ($value > 0) $column_list[] = $key;
    }

    $select_column_list = '';

    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      switch ($column_list[$i]) {
        case 'PRODUCT_LIST_MODEL':
          $select_column_list .= 'p.products_model, ';
          break;
        case 'PRODUCT_LIST_NAME':
          $select_column_list .= 'pd.products_name, ';
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
          $select_column_list .= 'm.manufacturers_name, ';
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $select_column_list .= 'p.products_quantity, ';
          break;
        case 'PRODUCT_LIST_IMAGE':
          $select_column_list .= 'p.products_image, ';
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $select_column_list .= 'p.products_weight, ';
          break;
      }
    }

// show the products of a specified manufacturer
if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
      if (isset($HTTP_GET_VARS['filter_id']) && tep_not_null($HTTP_GET_VARS['filter_id'])) {
// We are asked to show only a specific category
 if (PERMISO_STOCK_NIVEL_6 == 'true'){
        $listing_sql = "select " . $select_column_list . " p.products_id, p.stock_nivel, p.products_model, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . 'products_stock' . " ps where ps.products_id = p.products_id and ps.products_stock_real >= 0.01 and p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "'";
                                  }else{
        $listing_sql = "select " . $select_column_list . " p.products_id, p.stock_nivel, p.products_model, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "'";
                                  }
      } else {
// We show them all

          if (PERMISO_STOCK_NIVEL_6 == 'true'){
        $listing_sql = "select " . $select_column_list . " p.products_id, p.stock_nivel, p.products_model, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . 'products_stock' . " ps where  ps.products_id = p.products_id and ps.products_stock_real >= 0.01 and p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'";
                                   }else{
        $listing_sql = "select " . $select_column_list . " p.products_id, p.stock_nivel, p.products_model, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m where p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'";
                                   }


      }
    } else {
// show the products in a given categorie
      if (isset($HTTP_GET_VARS['filter_id']) && tep_not_null($HTTP_GET_VARS['filter_id'])) {
// We are asked to show only specific catgeory
            if (PERMISO_STOCK_NIVEL_6 == 'true'){
        $listing_sql = "select " . $select_column_list . " p.products_id, p.products_model, p.stock_nivel, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . 'products_stock' . " ps where  ps.products_id = p.products_id and ps.products_stock_real >= 0.01 and p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
                                            }else{
        $listing_sql = "select " . $select_column_list . " p.products_id, p.products_model, p.stock_nivel, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
                                             }

      } else {
// We show them all
              if (PERMISO_STOCK_NIVEL_6 == 'true'){
        $listing_sql = "select " . $select_column_list . " p.codigo_proveedor, p.products_model, p.products_id, p.stock_nivel, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . 'products_stock' . " ps where  ps.products_id = p.products_id and ps.products_stock_real >= 0.01 and p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
                                                   }else{
        $listing_sql = "select " . $select_column_list . " p.codigo_proveedor, p.products_model, p.products_id, p.stock_nivel, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
                                                    }
      }
    }

    
    if ( (!isset($HTTP_GET_VARS['sort'])) || (!preg_match('/^[1-8][ad]$/', $HTTP_GET_VARS['sort'])) || (substr($HTTP_GET_VARS['sort'], 0, 1) > sizeof($column_list)) ) {
      for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
        if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
          $HTTP_GET_VARS['sort'] = $i+1 . 'a';
          $listing_sql .= " order by pd.products_name";
          break;
        }
      }
    } else {
      $sort_col = substr($HTTP_GET_VARS['sort'], 0 , 1);
      $sort_order = substr($HTTP_GET_VARS['sort'], 1);

      switch ($column_list[$sort_col-1]) {
        case 'PRODUCT_LIST_MODEL':
          $listing_sql .= " order by p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_NAME':
          $listing_sql .= " order by p.products_price " . ($sort_order == 'd' ? 'desc' : '');
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
          $listing_sql .= " order by m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $listing_sql .= " order by p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_IMAGE':
          $listing_sql .= " order by p.products_price";
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $listing_sql .= " order by p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_PRICE':
          $listing_sql .= " order by final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
      }
    }

    $catname = HEADING_TITLE;
    if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
      $image = tep_db_query("select manufacturers_image, manufacturers_name as catname from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'");
      $image = tep_db_fetch_array($image);
      $catname = $image['catname'];
    } elseif ($current_category_id) {
      $image = tep_db_query("select c.categories_image, cd.categories_name_suple, cd.categories_name as catname from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
      $image = tep_db_fetch_array($image);
      $catname = $image['catname'];

      if ($image['categories_name_suple']){
       $categories_a = $image['categories_name_suple'];
}else{
    $categories_a = $image['categories_name'];
}


      $catname = $image['catname'];
    }



     $marketplace_values = tep_db_query("select * from " . 'marketplace' . " m, marketplace_description md where m.categories_id = md.categories_id and md.categories_id = '" .  $cPath. "'");
  $marketplace = tep_db_fetch_array($marketplace_values);

    
    
?>

<h1><?php echo $marketplace['categories_name']?></h1>



    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
<?php
    if (isset($cPath) && strpos('_', $cPath)) {
// check to see if there are deeper categories within the current category
      $category_links = array_reverse($cPath_array);
      for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
        $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
        $categories = tep_db_fetch_array($categories_query);
        if ($categories['total'] < 1) {
          // do nothing, go through the loop
        } else {
          $categories_query = tep_db_query("select c.categories_id, cd.categories_name_suple,  cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
          break; // we've found the deepest category the customer is in
        }
      }
    } else {
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name_suple, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
    }

    $number_of_categories = tep_db_num_rows($categories_query);

    $rows = 0;
    while ($categories = tep_db_fetch_array($categories_query)) {
      $rows++;
      
      
      if ($categories['categories_name_suple']){
       $categories_a = $categories['categories_name_suple'];
}else{
    $categories_a = $categories['categories_name'];
}

      
      $cPath_new = tep_get_path($categories['categories_id']);
      $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
	  
//if (tep_not_null($categories['categories_image'])) {
	  
	  
      echo '        <td align="center" class="smallText" width="' . $width . '" valign="top">
	  <a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">';

	  if (tep_not_null($categories['categories_image'])) {
	  	  echo tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories_a, SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) ;
	  }

	  echo  '<br />' . $categories['categories_name'] . '</a>
	  </td>' . "\n";
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_categories)) {
        echo '      </tr>' . "\n";
        echo '      <tr>' . "\n";
      }


    }
	

// needed for the new products module shown below
    $new_products_category_id = $current_category_id;
?>
      </tr>
    </table>















<div class="contentContainer">

<?php
// optional Product List Filter
    if (PRODUCT_LIST_FILTER > 0) {
      if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
        $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' order by cd.categories_name";
      } else {
        $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS . " m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by m.manufacturers_name";
      }
      $filterlist_query = tep_db_query($filterlist_sql);
      if (tep_db_num_rows($filterlist_query) > 1) {
        echo '<div class="form_1">' . tep_draw_form('filter', FILENAME_DEFAULT, 'get') . '<p align="right">' . TEXT_SHOW . '&nbsp;';
        if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
          echo tep_draw_hidden_field('manufacturers_id', $HTTP_GET_VARS['manufacturers_id']);
          $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
        } else {
          echo tep_draw_hidden_field('cPath', $cPath);
          $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
        }
        echo tep_draw_hidden_field('sort', $HTTP_GET_VARS['sort']);
        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
          $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
        }
        echo tep_draw_pull_down_menu('filter_id', $options, (isset($HTTP_GET_VARS['filter_id']) ? $HTTP_GET_VARS['filter_id'] : ''), 'onchange="this.form.submit()"');
        echo tep_hide_session_id() . '</p></form></div>' . "\n";
      }
    }



  if ($cPath >= 99999999){
      }else{
    ?>


 <form method="GET" action="advanced_search_result.php">
	<p style="margin-top: 0; margin-bottom: 0">
	<input type="text" name="keywords" size="30" style="font-family: Verdana; font-size: 10pt; font-weight: bold">
    <input type="radio" value="<?php echo (int)$current_category_id ?>" checked name="categories_id">
    <input type="radio" value="1" checked name="inc_subcat">     </p>

	<?php echo tep_draw_button('Buscar en esta Categoría', 'key', null, 'primary');
   ?></p>
</form>

   <?php
}

   if ($cPath >= 99999999){


    $marketplace_values = tep_db_query("select * from " . 'marketplace' . " m, marketplace_description md where m.categories_id = md.categories_id and parent_id = '" .  $cPath. "'");
  while  ($marketplace = tep_db_fetch_array($marketplace_values)){



?>


<table border="0" width="100%" id="table1">
	<tr>
		<td>
		<p align="center"><a href="<?php ECHO $marketplace['categories_name_http'] ?>">
		<img border="0" src="<?php ECHO $marketplace['categories_image'] ?>" width="120" height=""></a></td>
	</tr>
	<tr>
		<td> <a href="<?php ECHO $marketplace['categories_name_http'] ?>">
		<p align="center"><b><font size="4"><?php ECHO $marketplace['categories_name'] ?></font></b></a></td>
	</tr>
</table>




</body>
 <?php
   }

     }


        if ($cPath >= 99999999){
        }else{
    include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);
}
?>

</div>

<?php
  } else { // default page
	require(TMPL_BOXES . 'main_part_intro.php');	
?>	
<?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
  

  
  
  
?>
