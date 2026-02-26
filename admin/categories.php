<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($HTTP_GET_VARS['flag'] == '0') || ($HTTP_GET_VARS['flag'] == '1') ) {
          if (isset($HTTP_GET_VARS['pID'])) {
            tep_set_product_status($HTTP_GET_VARS['pID'], $HTTP_GET_VARS['flag']);
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $HTTP_GET_VARS['cPath'] . '&pID=' . $HTTP_GET_VARS['pID']));
        break;
      case 'insert_category':
      case 'update_category':
        if (isset($HTTP_POST_VARS['categories_id'])) $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);
        $sort_order = tep_db_prepare_input($HTTP_POST_VARS['sort_order']);

        $sql_data_array = array('sort_order' => (int)$sort_order);

        if ($action == 'insert_category') {
          $insert_sql_data = array('parent_id' => $current_category_id,
                                   'date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          tep_db_perform(TABLE_CATEGORIES, $sql_data_array);

          $categories_id = tep_db_insert_id();
        } elseif ($action == 'update_category') {
          $update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          tep_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "'");
        }

        $languages = tep_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $categories_name_array = $HTTP_POST_VARS['categories_name'];
         $categories_name_suple_array = $HTTP_POST_VARS['categories_name_suple'];
          $categories_name_http_array = $HTTP_POST_VARS['categories_name_http'];
          $categories_name_http_mobil_array = $HTTP_POST_VARS['categories_name_http_mobil'];
         $categories_status_visible_array = $HTTP_POST_VARS['categories_status_visible'];

          $language_id = $languages[$i]['id'];

          $sql_data_array = array('categories_name' => tep_db_prepare_input($categories_name_array[$language_id]));
          $sql_data_suple_array = array('categories_name_suple' => tep_db_prepare_input($categories_name_suple_array[$language_id]));
          $sql_data_http_array = array('categories_name_http' => tep_db_prepare_input($categories_name_http_array[$language_id]));
          $sql_data_http_mobil_array = array('categories_name_http_mobil' => tep_db_prepare_input($categories_name_http_mobil_array[$language_id]));
          $sql_data_status_array = array('categories_status_visible' => tep_db_prepare_input($categories_status_visible_array[$language_id]));

          if ($action == 'insert_category') {
            $insert_sql_data = array('categories_id' => $categories_id,
                                     'language_id' => $languages[$i]['id']);


            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
            } elseif ($action == 'update_category') {
            tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
           tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_suple_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
           tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_status_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_http_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_http_mobil_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          }
        }

        $categories_image = new upload('categories_image');
        $categories_image->set_destination(DIR_FS_CATALOG_IMAGES);

        if ($categories_image->parse() && $categories_image->save()) {
          tep_db_query("update " . TABLE_CATEGORIES . " set categories_image = '" . tep_db_input($categories_image->filename) . "' where categories_id = '" . (int)$categories_id . "'");
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
        break;
      case 'delete_category_confirm':
        if (isset($HTTP_POST_VARS['categories_id'])) {
          $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);

          $categories = tep_get_category_tree($categories_id, '', '0', '', true);
          $products = array();
          $products_delete = array();

          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            $product_ids_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$categories[$i]['id'] . "'");

            while ($product_ids = tep_db_fetch_array($product_ids_query)) {
              $products[$product_ids['products_id']]['categories'][] = $categories[$i]['id'];
            }
          }

          reset($products);
          while (list($key, $value) = each($products)) {
            $category_ids = '';

            for ($i=0, $n=sizeof($value['categories']); $i<$n; $i++) {
              $category_ids .= "'" . (int)$value['categories'][$i] . "', ";
            }
            $category_ids = substr($category_ids, 0, -2);

            $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$key . "' and categories_id not in (" . $category_ids . ")");
            $check = tep_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $products_delete[$key] = $key;
            }
          }

// removing categories can be a lengthy process
          tep_set_time_limit(0);
          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            tep_remove_category($categories[$i]['id']);
          }

          reset($products_delete);
          while (list($key) = each($products_delete)) {
            tep_remove_product($key);
          }
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
        break;
      case 'delete_product_confirm':
        if (isset($HTTP_POST_VARS['products_id']) && isset($HTTP_POST_VARS['product_categories']) && is_array($HTTP_POST_VARS['product_categories'])) {
          $product_id = tep_db_prepare_input($HTTP_POST_VARS['products_id']);
          $product_categories = $HTTP_POST_VARS['product_categories'];

          for ($i=0, $n=sizeof($product_categories); $i<$n; $i++) {
            tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "' and categories_id = '" . (int)$product_categories[$i] . "'");
         }
         
tep_db_query("delete from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . tep_db_input($product_id) . "' ");


          $product_categories_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'");
          $product_categories = tep_db_fetch_array($product_categories_query);

          if ($product_categories['total'] == '0') {
            tep_remove_product($product_id);
          }
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
        break;
      case 'move_category_confirm':
        if (isset($HTTP_POST_VARS['categories_id']) && ($HTTP_POST_VARS['categories_id'] != $HTTP_POST_VARS['move_to_category_id'])) {
          $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);
          $new_parent_id = tep_db_prepare_input($HTTP_POST_VARS['move_to_category_id']);

          $path = explode('_', tep_get_generated_category_path_ids($new_parent_id));

          if (in_array($categories_id, $path)) {
            $messageStack->add_session(ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT, 'error');

            tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
          } else {
            tep_db_query("update " . TABLE_CATEGORIES . " set parent_id = '" . (int)$new_parent_id . "', last_modified = now() where categories_id = '" . (int)$categories_id . "'");

            if (USE_CACHE == 'true') {
              tep_reset_cache_block('categories');
              tep_reset_cache_block('also_purchased');
            }

            tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id . '&cID=' . $categories_id));
          }
        }

        break;
      case 'move_product_confirm':
        $products_id = tep_db_prepare_input($HTTP_POST_VARS['products_id']);
        $new_parent_id = tep_db_prepare_input($HTTP_POST_VARS['move_to_category_id']);

        $duplicate_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$new_parent_id . "'");
        $duplicate_check = tep_db_fetch_array($duplicate_check_query);
        if ($duplicate_check['total'] < 1) tep_db_query("update " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = '" . (int)$new_parent_id . "' where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$current_category_id . "'");

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }
                             //redirige a la carpteta donde mueves los productos
       // tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id . '&pID=' . $products_id.'&action=new_product'));
        break;
      case 'insert_product':
      case 'update_product':
        if (isset($HTTP_GET_VARS['pID'])) $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']);
        $products_date_available = tep_db_prepare_input($HTTP_POST_VARS['products_date_available']);

        $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';
        
        
        
        

   $pro_special_values = tep_db_query("select * from " . 'specials' . " where products_id = '" .   $HTTP_GET_VARS['pID'] . "'");
    if ($pro_special = tep_db_fetch_array($pro_special_values)){

	tep_db_query ("UPDATE " . 'specials' . " SET
					status = '" . $HTTP_POST_VARS['products_specials_onoff'] . "',
					specials_new_products_price = '" . $HTTP_POST_VARS['products_specials'] . "'
					WHERE products_id = '" . $HTTP_GET_VARS['pID'] . "'");








                                    }else{
 if ($HTTP_POST_VARS['products_specials_onoff'] == 1) {
      $sql_data_array = array(//Comment out line you don't need
							'products_id' => $HTTP_GET_VARS['pID'],
							'status' => $HTTP_POST_VARS['products_specials_onoff'],
                            'specials_new_products_price' => $HTTP_POST_VARS['products_specials']);
     tep_db_perform('specials', $sql_data_array);






}
}

                		   if ($HTTP_POST_VARS['products_specials_onoff']==2){

          			//then delete the little bugger
			$Query = "DELETE FROM " . 'specials' . "
			WHERE products_id = '" . $HTTP_GET_VARS['pID'] . "';";
				tep_db_query($Query);

                                          }



  if ($HTTP_POST_VARS['pdc_unidades']){
  
      $sql_data_array = array(//Comment out line you don't need
							'pdc_products_id' => $HTTP_GET_VARS['pID'],
							'pdc_unidades' => $HTTP_POST_VARS['pdc_unidades'],
                            'pdc_price_final' => $HTTP_POST_VARS['pdc_price_final']);
     tep_db_perform('products_descuento_cantidad', $sql_data_array);

  
  }

       $donde_esta_c_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $HTTP_GET_VARS['pID'] . "' and login_id = '" . $log_id . "'");
 if ($donde_esta_c= tep_db_fetch_array($donde_esta_c_values)){

  	tep_db_query ("UPDATE " . 'products_donde_esta' . " SET
					donde_esta = '" . $HTTP_POST_VARS['donde_esta'] . "',
					products_model = '" . $HTTP_POST_VARS['products_model'] . "'
					WHERE products_id = '" . $HTTP_GET_VARS['pID'] . "' and login_id = '" . $log_id . "'");

}else{

      $sql_data_array = array(//Comment out line you don't need
							'donde_esta' => $HTTP_POST_VARS['donde_esta'],
							'products_id' => $HTTP_GET_VARS['pID'],
							'login_id' => $log_id,
							'products_model' => $HTTP_POST_VARS['products_model']);
     tep_db_perform('products_donde_esta', $sql_data_array);


}





	tep_db_query ("UPDATE " . 'products_stock' . " SET
					products_stock_min = '" . $HTTP_POST_VARS['stock_min'] . "'
					WHERE products_id = '" . $HTTP_GET_VARS['pID'] . "'");


        $sql_data_array = array('products_quantity' => (int)tep_db_prepare_input($HTTP_POST_VARS['products_quantity']),
                                'codigo_proveedor' => (int)tep_db_prepare_input($HTTP_POST_VARS['codigo_proveedor']),
                                'stock_nivel' => (int)tep_db_prepare_input($HTTP_POST_VARS['stock_nivel']),
                                'products_regladeprecios' => (int)tep_db_prepare_input($HTTP_POST_VARS['products_regladeprecios']),
                                'products_cpf' => tep_db_prepare_input($HTTP_POST_VARS['products_cpf']),
                                'manufacturers_name' => tep_db_prepare_input($HTTP_POST_VARS['manufacturers_name']),
                                'products_descuento_onoff' => tep_db_prepare_input($HTTP_POST_VARS['products_descuento_onoff']),
                                'products_descuento' => tep_db_prepare_input($HTTP_POST_VARS['products_descuento']),
                                'products_descuento_g1' => tep_db_prepare_input($HTTP_POST_VARS['products_descuento_g1']),
                                'products_descuento_g2' => tep_db_prepare_input($HTTP_POST_VARS['products_descuento_g2']),
                                'products_descuento_g3' => tep_db_prepare_input($HTTP_POST_VARS['products_descuento_g3']),
                                'products_shoptoshop' => tep_db_prepare_input($HTTP_POST_VARS['products_shoptoshop']),
                                'products_cpe' => tep_db_prepare_input($HTTP_POST_VARS['products_cpe']),
                                'codigo_barras' => tep_db_prepare_input($HTTP_POST_VARS['codigo_barras']),
                                'products_rc' => (int)tep_db_prepare_input($HTTP_POST_VARS['products_rc']),
                                'opcion_1' => tep_db_prepare_input($HTTP_POST_VARS['opcion_1']),
                                'opcion_1_1' => tep_db_prepare_input($HTTP_POST_VARS['opcion_1_1']),
                                'products_youtube_1' => tep_db_prepare_input($HTTP_POST_VARS['products_youtube_1']),
                                'pdf' => tep_db_prepare_input($HTTP_POST_VARS['pdf']),
                                'products_twitter' => tep_db_prepare_input($HTTP_POST_VARS['products_twitter']),
                                'products_youtube_2' => tep_db_prepare_input($HTTP_POST_VARS['products_youtube_2']),
                                'referencia_padre' => tep_db_prepare_input($HTTP_POST_VARS['referencia_padre']),
                                'referencia_padre_g2' => tep_db_prepare_input($HTTP_POST_VARS['referencia_padre_g2']),
                                'referencia_padre_g3' => tep_db_prepare_input($HTTP_POST_VARS['referencia_padre_g3']),
                                'opcion_2' => tep_db_prepare_input($HTTP_POST_VARS['opcion_2']),
                                'opcion_2_2' => tep_db_prepare_input($HTTP_POST_VARS['opcion_2_2']),
                                'opcion_3' => tep_db_prepare_input($HTTP_POST_VARS['opcion_3']),
                                'opcion_3_3' => tep_db_prepare_input($HTTP_POST_VARS['opcion_3_3']),
                                'opcion_4' => tep_db_prepare_input($HTTP_POST_VARS['opcion_4']),
                                'opcion_4_4' => tep_db_prepare_input($HTTP_POST_VARS['opcion_4_4']),
                                'opcion_5' => tep_db_prepare_input($HTTP_POST_VARS['opcion_5']),
                                'opcion_5_5' => tep_db_prepare_input($HTTP_POST_VARS['opcion_5_5']),
                                'opcion_6' => tep_db_prepare_input($HTTP_POST_VARS['opcion_6']),
                                'opcion_6_6' => tep_db_prepare_input($HTTP_POST_VARS['opcion_6_6']),
                                'opcion_7' => tep_db_prepare_input($HTTP_POST_VARS['opcion_7']),
                                'opcion_7_7' => tep_db_prepare_input($HTTP_POST_VARS['opcion_7_7']),
                                'opcion_8' => tep_db_prepare_input($HTTP_POST_VARS['opcion_8']),
                                'opcion_8_8' => tep_db_prepare_input($HTTP_POST_VARS['opcion_8_8']),
                                'opcion_9' => tep_db_prepare_input($HTTP_POST_VARS['opcion_9']),
                                'opcion_9_9' => tep_db_prepare_input($HTTP_POST_VARS['opcion_9_9']),
                                'opcion_10' => tep_db_prepare_input($HTTP_POST_VARS['opcion_10']),
                                'opcion_10_10' => tep_db_prepare_input($HTTP_POST_VARS['opcion_10_10']),
                                'opcion_11' => tep_db_prepare_input($HTTP_POST_VARS['opcion_11']),
                                'opcion_11_11' => tep_db_prepare_input($HTTP_POST_VARS['opcion_11_11']),
                                'opcion_12' => tep_db_prepare_input($HTTP_POST_VARS['opcion_12']),
                                'opcion_12_12' => tep_db_prepare_input($HTTP_POST_VARS['opcion_12_12']),
                                'opcion_13' => tep_db_prepare_input($HTTP_POST_VARS['opcion_13']),
                                'opcion_13_13' => tep_db_prepare_input($HTTP_POST_VARS['opcion_13_13']),
                                'opcion_14' => tep_db_prepare_input($HTTP_POST_VARS['opcion_14']),
                                'opcion_14_14' => tep_db_prepare_input($HTTP_POST_VARS['opcion_14_14']),
                                'opcion_15' => tep_db_prepare_input($HTTP_POST_VARS['opcion_15']),
                                'opcion_15_15' => tep_db_prepare_input($HTTP_POST_VARS['opcion_15_15']),
                                'opcion_16' => tep_db_prepare_input($HTTP_POST_VARS['opcion_16']),
                                'opcion_16_16' => tep_db_prepare_input($HTTP_POST_VARS['opcion_16_16']),
                                'opcion_17' => tep_db_prepare_input($HTTP_POST_VARS['opcion_17']),
                                'opcion_17_17' => tep_db_prepare_input($HTTP_POST_VARS['opcion_17_17']),
                                'opcion_18' => tep_db_prepare_input($HTTP_POST_VARS['opcion_18']),
                                'opcion_18_18' => tep_db_prepare_input($HTTP_POST_VARS['opcion_18_18']),
                                'opcion_19' => tep_db_prepare_input($HTTP_POST_VARS['opcion_19']),
                                'opcion_19_19' => tep_db_prepare_input($HTTP_POST_VARS['opcion_19_19']),
                                'opcion_20' => tep_db_prepare_input($HTTP_POST_VARS['opcion_20']),
                                'opcion_20_20' => tep_db_prepare_input($HTTP_POST_VARS['opcion_20_20']),
                                'products_model' => tep_db_prepare_input($HTTP_POST_VARS['products_model']),
                                'products_model_2' => tep_db_prepare_input($HTTP_POST_VARS['products_model_2']),
                                'products_model_3' => tep_db_prepare_input($HTTP_POST_VARS['products_model_3']),
                                'products_model_4' => tep_db_prepare_input($HTTP_POST_VARS['products_model_4']),
                                'products_model' => tep_db_prepare_input($HTTP_POST_VARS['products_model']),
                                'products_price' => tep_db_prepare_input($HTTP_POST_VARS['products_price']),
                                'products_date_available' => $products_date_available,
                                'products_weight' => (float)tep_db_prepare_input($HTTP_POST_VARS['products_weight']),
                                'products_status' => tep_db_prepare_input($HTTP_POST_VARS['products_status']),
                                'products_tax_class_id' => tep_db_prepare_input($HTTP_POST_VARS['products_tax_class_id']),
                                'manufacturers_id' => (int)tep_db_prepare_input($HTTP_POST_VARS['manufacturers_id']));

        $products_image = new upload('products_image');
        $products_image->set_destination(DIR_FS_CATALOG_IMAGES);
        if ($products_image->parse() && $products_image->save()) {
          $sql_data_array['products_image'] = tep_db_prepare_input($products_image->filename);
        }

        if ($action == 'insert_product') {
          $insert_sql_data = array('products_date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          tep_db_perform(TABLE_PRODUCTS, $sql_data_array);
          $products_id = tep_db_insert_id();

          tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '" . (int)$current_category_id . "')");
        } elseif ($action == 'update_product') {
          $update_sql_data = array('products_last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");
        }

        $languages = tep_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $language_id = $languages[$i]['id'];
          
                          IF  (tep_db_prepare_input($HTTP_POST_VARS['products_name'][$language_id])){


                                      
          $sql_data_array = array('products_name' => tep_db_prepare_input($HTTP_POST_VARS['products_name'][$language_id]),
                                  'products_description' => tep_db_prepare_input($HTTP_POST_VARS['products_description'][$language_id]),
                                  'products_url' => tep_db_prepare_input($HTTP_POST_VARS['products_url'][$language_id]));


                          }else{


          $sql_data_array = array('products_name' => tep_db_prepare_input($HTTP_POST_VARS['products_model']),
                                  'products_description' => tep_db_prepare_input($HTTP_POST_VARS['products_description'][$language_id]),
                                  'products_url' => tep_db_prepare_input($HTTP_POST_VARS['products_url'][$language_id]));
                      }
          

          


          if ($action == 'insert_product') {
            $insert_sql_data = array('products_id' => $products_id,
                                     'language_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'update_product') {
            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
          }
        }

















$customers_group_query = tep_db_query("select distinct customers_group_id, customers_group_name from " . TABLE_CUSTOMERS . " where customers_group_id != '" . 0 . "' order by customers_group_id");
while ($customers_group = tep_db_fetch_array($customers_group_query)) // Gets all of the customers groups
  {
  $attributes_query = tep_db_query("select customers_group_id, customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where ((products_id = '" . $products_id . "') && (customers_group_id = " . $customers_group['customers_group_id'] . ")) order by customers_group_id");
  $attributes = tep_db_fetch_array($attributes_query);
  if (tep_db_num_rows($attributes_query) > 0) {
    if ($HTTP_POST_VARS['option'][$customers_group['customers_group_id']]) {// this is checking if the check box is checked
      if ( ($HTTP_POST_VARS['price'][$customers_group['customers_group_id']] <> $attributes['customers_group_price']) && ($attributes['customers_group_id'] == $customers_group['customers_group_id']) ) {
	    tep_db_query("update " . TABLE_PRODUCTS_GROUPS . " set customers_group_price = '" . $HTTP_POST_VARS['price'][$customers_group['customers_group_id']] . "', products_price = '" . $HTTP_POST_VARS['products_price'] . "' where customers_group_id = '" . $attributes['customers_group_id'] . "' and products_id = '" . $products_id . "'");
        $attributes = tep_db_fetch_array($attributes_query);
      }
      elseif (($HTTP_POST_VARS['price'][$customers_group['customers_group_id']] == $attributes['customers_group_price'])) {
	    $attributes = tep_db_fetch_array($attributes_query);
      }
    }
    else {
      tep_db_query("delete from " . TABLE_PRODUCTS_GROUPS . " where customers_group_id = '" . $customers_group['customers_group_id'] . "' and products_id = '" . $products_id . "'");
      $attributes = tep_db_fetch_array($attributes_query);
    }
  }
  elseif (($HTTP_POST_VARS['option'][$customers_group['customers_group_id']]) && ($HTTP_POST_VARS['price'][$customers_group['customers_group_id']] != '')) {
    tep_db_query("insert into " . TABLE_PRODUCTS_GROUPS . " (products_id, products_price, customers_group_id, customers_group_price) values ('" . $products_id . "', '" . $HTTP_POST_VARS['products_price'] . "', '" . $customers_group['customers_group_id'] . "', '" . $HTTP_POST_VARS['price'][$customers_group['customers_group_id']] . "')");
    $attributes = tep_db_fetch_array($attributes_query);
  }

}





        $pi_sort_order = 0;
        $piArray = array(0);

        foreach ($HTTP_POST_FILES as $key => $value) {
// Update existing large product images
          if (preg_match('/^products_image_large_([0-9]+)$/', $key, $matches)) {
            $pi_sort_order++;

            $sql_data_array = array('htmlcontent' => tep_db_prepare_input($HTTP_POST_VARS['products_image_htmlcontent_' . $matches[1]]),
                                    'image_number' => $pi_sort_order);

            $t = new upload($key);
            $t->set_destination(DIR_FS_CATALOG_IMAGES);
            if ($t->parse() && $t->save()) {
              $sql_data_array['products_extra_image'] = tep_db_prepare_input($t->filename);
            }

            tep_db_perform('products_extra_images', $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and 	products_extra_images_id = '" . (int)$matches[1] . "'");

            $piArray[] = (int)$matches[1];
          } elseif (preg_match('/^products_image_large_new_([0-9]+)$/', $key, $matches)) {
// Insert new large product images

            $sql_data_array = array('products_id' => (int)$products_id,
                                    'htmlcontent' => tep_db_prepare_input($HTTP_POST_VARS['products_image_htmlcontent_new_' . $matches[1]]));

            $t = new upload($key);
            $t->set_destination(DIR_FS_CATALOG_IMAGES);
            if ($t->parse() && $t->save()) {
              $pi_sort_order++;

              $sql_data_array['products_extra_image'] = tep_db_prepare_input($t->filename);
              $sql_data_array['image_number'] = $pi_sort_order;

              tep_db_perform('products_extra_images', $sql_data_array);

              $piArray[] = tep_db_insert_id();
            }
          }
        }

        $product_images_query = tep_db_query("select products_extra_image from " . 'products_extra_images' . " where products_id = '" . (int)$products_id . "' and products_extra_images_id not in (" . implode(',', $piArray) . ")");
        if (tep_db_num_rows($product_images_query)) {
          while ($product_images = tep_db_fetch_array($product_images_query)) {
            $duplicate_image_query = tep_db_query("select count(*) as total from " . 'products_extra_images' . " where 	products_extra_image = '" . tep_db_input($product_images['products_extra_images']) . "'");
            $duplicate_image = tep_db_fetch_array($duplicate_image_query);

            if ($duplicate_image['total'] < 2) {
              if (file_exists(DIR_FS_CATALOG_IMAGES . $product_images['products_extra_image'])) {
                @unlink(DIR_FS_CATALOG_IMAGES . $product_images['products_extra_image']);
              }
            }
          }
                           if ($product_images['products_extra_image']){
          tep_db_query("delete from " . 'products_extra_images' . " where products_id = '" . (int)$products_id . "' and products_extra_images_id not in (" . implode(',', $piArray) . ")");
        }                                                         }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }


     if ($HTTP_POST_VARS['pdc_unidades']){
  tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id.'&action=new_product'));

 }else{



   }
   
   
     if ($HTTP_POST_VARS['unidades_nuevo_pedido']){















  if ($HTTP_POST_VARS['unidades_nuevo_pedido'] <> 0){
 $unidades = $HTTP_POST_VARS['unidades_nuevo_pedido'];
 $numero_pedido = $HTTP_POST_VARS['numero_nuevo_pedido'];
}






    if ($unidades){

  $selec_nuevopedido_values = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op where o.orders_id = op.orders_id and o.orders_id = '" . $numero_pedido . "' and op.products_id = '" . $products_id. "'");
   if ($selec_nuevopedido = tep_db_fetch_array($selec_nuevopedido_values)){

   // si existe actualiza la nueva cantidad.


           $sql_status_update_array = array('products_quantity' => $selec_nuevopedido["products_quantity"]+$unidades, );
            tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $products_id . "' and orders_id = '" . $numero_pedido . "'");





        // Suma order total

// precio total del pedido actual
   $precioactual_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_total' . "'");
   $precioactual_total = tep_db_fetch_array($precioactual_total_values);

// precio total del pedido actual
   $precioactual_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");
   $precioactual_subtotal = tep_db_fetch_array($precioactual_subtotal_values);

// datos del producto
   $producto_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $products_id . "'");
   $producto = tep_db_fetch_array($producto_values);

    $importe = $producto['products_price']*$unidades;

                  // ot_total
           $sql_status_update_array = array('value' => $precioactual_total['value']+$importe,
                                            'text' => $precioactual_total['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido. "' and class = '" . 'ot_total' . "'");


                  // ot_subtotal
           $sql_status_update_array = array('value' => $precioactual_subtotal['value']+$importe,
                                            'text' => $precioactual_subtotal['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");



         // fin








    // si no existe lo inserta por primera vez
}else{

    $codigobarras_values = tep_db_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . (int)$products_id . "'");
    $codigobarras_c = tep_db_fetch_array($codigobarras_values);

                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');






           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $numero_pedido . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();







        // Suma order total

// precio total del pedido actual
   $precioactual_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_total' . "'");
   $precioactual_total = tep_db_fetch_array($precioactual_total_values);

// precio total del pedido actual
   $precioactual_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");
   $precioactual_subtotal = tep_db_fetch_array($precioactual_subtotal_values);

// datos del producto
   $producto_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $products_id . "'");
   $producto = tep_db_fetch_array($producto_values);

    $importe = $producto['products_price']*$unidades;

                  // ot_total
           $sql_status_update_array = array('value' => $precioactual_total['value']+$importe,
                                            'text' => $precioactual_total['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido . "' and class = '" . 'ot_total' . "'");

           // ot_subtotal
           $sql_status_update_array = array('value' => $precioactual_subtotal['value']+$importe,
                                            'text' => $precioactual_subtotal['value']+$importe.'€', );
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_status_update_array, 'update', " orders_id = '" . $numero_pedido . "' and class = '" . 'ot_subtotal' . "'");


         // fin










            }
               }// fin































  tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id.'&action=new_product'));

 }else{

       tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id.''));



   }
   
        break;
      case 'copy_to_confirm':
        if (isset($HTTP_POST_VARS['products_id']) && isset($HTTP_POST_VARS['categories_id'])) {
          $products_id = tep_db_prepare_input($HTTP_POST_VARS['products_id']);
          $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);

          if ($HTTP_POST_VARS['copy_as'] == 'link') {
            if ($categories_id != $current_category_id) {
              $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$categories_id . "'");
              $check = tep_db_fetch_array($check_query);
              if ($check['total'] < '1') {
                tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '" . (int)$categories_id . "')");
              }
            } else {
              $messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
            }
          } elseif ($HTTP_POST_VARS['copy_as'] == 'duplicate') {
            $product_query = tep_db_query("select products_quantity, codigo_proveedor, stock_nivel, products_regladeprecios, products_cpf, 	manufacturers_name, products_youtube_1, pdf, products_twitter,  referencia_padre, referencia_padre_g2, referencia_padre_g3, products_youtube_2, opcion_1, opcion_1_1, opcion_2, opcion_2_2, opcion_3, opcion_3_3, opcion_4, opcion_4_4, opcion_5, opcion_5_5, opcion_6, opcion_6_6, opcion_7, opcion_7_7, opcion_8, opcion_8_8, opcion_9, opcion_9_9, opcion_10, opcion_10_10, opcion_11, opcion_11_11, opcion_12, opcion_12_12, opcion_13, opcion_13_13, opcion_14, opcion_14_14, opcion_15, opcion_15_15, opcion_16, opcion_16_16, opcion_17, opcion_17_17, opcion_18, opcion_18_18, opcion_19, opcion_19_19, opcion_20, opcion_20_20, codigo_barras, products_rc, products_cpe, products_model, products_model_2, products_model_3, products_model_4, products_image, products_price, products_date_available, products_weight, products_tax_class_id, manufacturers_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
            $product = tep_db_fetch_array($product_query);

            tep_db_query("insert into " . TABLE_PRODUCTS . " (products_quantity, codigo_proveedor, stock_nivel, products_regladeprecios, products_cpf,	manufacturers_name, referencia_padre, referencia_padre_g2, referencia_padre_g3, products_youtube_1, pdf, products_twitter, products_youtube_2, opcion_1, opcion_1_1, opcion_2, opcion_2_2, opcion_3, opcion_3_3, opcion_4, opcion_4_4, opcion_5, opcion_5_5, opcion_6, opcion_6_6, opcion_7, opcion_7_7, opcion_8, opcion_8_8, opcion_9, opcion_9_9, opcion_10, opcion_10_10, opcion_11, opcion_11_11, opcion_12, opcion_12_12, opcion_13, opcion_13_13, opcion_14, opcion_14_14, opcion_15, opcion_15_15, opcion_16, opcion_16_16, opcion_17, opcion_17_17, opcion_18, opcion_18_18, opcion_19, opcion_19_19, opcion_20, opcion_20_20, codigo_barras, products_rc, products_cpe, products_model, products_model_2, products_model_3, products_model_4, products_image, products_price, products_date_added, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id) values ('" . tep_db_input($product['products_quantity']) . "', '" . tep_db_input($product['products_model']) . "', '" . tep_db_input($product['products_image']) . "', '" . tep_db_input($product['products_price']) . "',  now(), " . (empty($product['products_date_available']) ? "null" : "'" . tep_db_input($product['products_date_available']) . "'") . ", '" . tep_db_input($product['products_weight']) . "', '0', '" . (int)$product['products_tax_class_id'] . "', '" . (int)$product['manufacturers_id'] . "')");
            $dup_products_id = tep_db_insert_id();

            $description_query = tep_db_query("select language_id, products_name, products_description, products_url from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$products_id . "'");
            while ($description = tep_db_fetch_array($description_query)) {
              tep_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('" . (int)$dup_products_id . "', '" . (int)$description['language_id'] . "', '" . tep_db_input($description['products_name']) . "', '" . tep_db_input($description['products_description']) . "', '" . tep_db_input($description['products_url']) . "', '0')");
            }

            $product_images_query = tep_db_query("select products_extra_image, htmlcontent, image_number from " .  'products_extra_images' . " where products_id = '" . (int)$products_id . "'");
            while ($product_images = tep_db_fetch_array($product_images_query)) {
              tep_db_query("insert into " . 'products_extra_images' . " (products_id, 	products_extra_image, htmlcontent, image_number) values ('" . (int)$dup_products_id . "', '" . tep_db_input($product_images['products_extra_image']) . "', '" . tep_db_input($product_images['htmlcontent']) . "', '" . tep_db_input($product_images['image_number']) . "')");
            }

            tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$dup_products_id . "', '" . (int)$categories_id . "')");
            $products_id = $dup_products_id;
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }













        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $categories_id . '&pID=' . $products_id));
        
        
        
        break;
    }
  }

// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!tep_is_writable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }

  require(DIR_WS_INCLUDES . 'template_top.php');

  if ($action == 'new_product') {
    $parameters = array('products_name' => '',
                       'products_description' => '',
                       'products_url' => '',
                       'products_id' => '',
                       'products_quantity' => '',
                       'products_descuento_onoff' => '',
                       'products_descuento' => '',
                       'products_descuento_g1' => '',
                       'products_descuento_g2' => '',
                       'products_descuento_g3' => '',
                       'products_shoptoshop' => '',
                       'codigo_proveedor' => '',
                       'stock_nivel' => '',
                       'products_regladeprecios' => '',
                       'products_cpf' => '',
                       'products_cpe' => '',
                       'manufacturers_name' => '',
                       'codigo_barras' => '',
                       'products_rc' => '',
                       'opcion_1' => '',
                       'opcion_1_1' => '',
                       'products_youtube_1' => '',
                       'pdf' => '',
                       'products_twitter' => '',
                       'products_youtube_2' => '',
                       'referencia_padre' => '',
                       'referencia_padre_g2' => '',
                       'referencia_padre_g3' => '',
                       'opcion_2' => '',
                       'opcion_2_2' => '',
                       'opcion_3' => '',
                       'opcion_3_3' => '',
                       'opcion_4' => '',
                       'opcion_4_4' => '',
                       'opcion_5' => '',
                       'opcion_5_5' => '',
                       'opcion_6' => '',
                       'opcion_6_6' => '',
                       'opcion_7' => '',
                       'opcion_7_7' => '',
                       'opcion_8' => '',
                       'opcion_8_8' => '',
                       'opcion_9' => '',
                       'opcion_9_9' => '',
                       'opcion_10' => '',
                       'opcion_10_10' => '',
                       'opcion_11' => '',
                       'opcion_11_11' => '',
                       'opcion_12' => '',
                       'opcion_12_12' => '',
                       'opcion_13' => '',
                       'opcion_13_13' => '',
                       'opcion_14' => '',
                       'opcion_14_14' => '',
                       'opcion_15' => '',
                       'opcion_15_15' => '',
                       'opcion_16' => '',
                       'opcion_16_16' => '',
                       'opcion_17' => '',
                       'opcion_17_17' => '',
                       'opcion_18' => '',
                       'opcion_18_18' => '',
                       'opcion_19' => '',
                       'opcion_19_19' => '',
                       'opcion_20' => '',
                       'opcion_20_20' => '',
                       'products_model' => '',
                       'products_model_2' => '',
                       'products_model_3' => '',
                       'products_model_4' => '',
                       'products_image' => '',
                       'products_larger_images' => array(),
                       'products_price' => '',
                       'products_weight' => '',
                       'products_date_added' => '',
                       'products_last_modified' => '',
                       'products_date_available' => '',
                       'products_status' => '',
                       'products_tax_class_id' => '',
                       'manufacturers_id' => '');

    $pInfo = new objectInfo($parameters);
    
    
    
    
    
    
    
    
    






    
    
    
    
    
    
    
    
    
    

    if (isset($HTTP_GET_VARS['pID']) && empty($HTTP_POST_VARS)) {
      $product_query = tep_db_query("select pd.products_name, products_descuento_onoff, products_descuento, products_descuento_g1, products_descuento_g2, products_descuento_g3, products_shoptoshop, pd.products_description, pd.products_url, p.products_id, p.products_quantity, codigo_proveedor, stock_nivel, products_regladeprecios, products_cpf, 	manufacturers_name, referencia_padre, referencia_padre_g2, referencia_padre_g3, products_youtube_1, pdf, p.products_model_2, p.products_model_3, p.products_model_4, products_twitter, products_youtube_2, opcion_1, opcion_1_1, opcion_2, opcion_2_2, opcion_3, opcion_3_3, opcion_4, opcion_4_4, opcion_5, opcion_5_5, opcion_6, opcion_6_6, opcion_7, opcion_7_7, opcion_8, opcion_8_8, opcion_9, opcion_9_9, opcion_10, opcion_10_10, opcion_11, opcion_11_11, opcion_12, opcion_12_12, opcion_13, opcion_13_13, opcion_14, opcion_14_14, opcion_15, opcion_15_15, opcion_16, opcion_16_16, opcion_17, opcion_17_17, opcion_18, opcion_18_18, opcion_19, opcion_19_19, opcion_20, opcion_20_20, codigo_barras, products_rc, products_cpe, p.products_model, p.products_image, p.products_price, p.products_weight, p.products_date_added, p.products_last_modified, date_format(p.products_date_available, '%Y-%m-%d') as products_date_available, p.products_status,
      p.products_tax_class_id, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
      $product = tep_db_fetch_array($product_query);

      $pInfo->objectInfo($product);


















      $product_images_query = tep_db_query("select products_extra_images_id, products_extra_image, htmlcontent, image_number from " . 'products_extra_images' . " where products_id = '" . (int)$product['products_id'] . "' order by image_number");
      while ($product_images = tep_db_fetch_array($product_images_query)) {
        $pInfo->products_larger_images[] = array('products_extra_images_id' => $product_images['products_extra_images_id'],
                                                 'products_extra_image' => $product_images['products_extra_image'],
                                                 'htmlcontent' => $product_images['htmlcontent'],
                                                 'image_number' => $product_images['image_number']);
      }
    }

    $manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
    $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
      $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                     'text' => $manufacturers['manufacturers_name']);
    }

    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class_query = tep_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . " order by tax_class_title");
    while ($tax_class = tep_db_fetch_array($tax_class_query)) {
      $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                                 'text' => $tax_class['tax_class_title']);
    }

    $languages = tep_get_languages();

    if (!isset($pInfo->products_status)) $pInfo->products_status = '1';
    switch ($pInfo->products_status) {
      case '0': $in_status = false; $out_status = true; break;
      case '1':
      default: $in_status = true; $out_status = false;
    }

    $form_action = (isset($HTTP_GET_VARS['pID'])) ? 'update_product' : 'insert_product';
?>
<script type="text/javascript"><!--
var tax_rates = new Array();
<?php
    for ($i=0, $n=sizeof($tax_class_array); $i<$n; $i++) {
      if ($tax_class_array[$i]['id'] > 0) {
        echo 'tax_rates["' . $tax_class_array[$i]['id'] . '"] = ' . tep_get_tax_rate_value($tax_class_array[$i]['id']) . ';' . "\n";
      }
    }
?>

function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}

function getTaxRate() {
  var selected_value = document.forms["new_product"].products_tax_class_id.selectedIndex;
  var parameterVal = document.forms["new_product"].products_tax_class_id[selected_value].value;

  if ( (parameterVal > 0) && (tax_rates[parameterVal] > 0) ) {
    return tax_rates[parameterVal];
  } else {
    return 0;
  }
}

function updateGross() {
  var taxRate = getTaxRate();
  var grossValue = document.forms["new_product"].products_price.value;

  if (taxRate > 0) {
    grossValue = grossValue * ((taxRate / 100) + 1);
  }

  document.forms["new_product"].products_price_gross.value = doRound(grossValue, 4);
}

function updateNet() {
  var taxRate = getTaxRate();
  var netValue = document.forms["new_product"].products_price_gross.value;

  if (taxRate > 0) {
    netValue = netValue / ((taxRate / 100) + 1);
  }

  document.forms["new_product"].products_price.value = doRound(netValue, 4);
}





<?php
       if (AYUDA_ADMIN == 'true'){
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_fecha_alta = '<a class="hastip"  title="' . AYUDA_TEXT_FECHA_ALTA . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_fabricante = '<a class="hastip"  title="' . AYUDA_TEXT_FABRICANTE . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_nombre_producto = '<a class="hastip"  title="' . AYUDA_TEXT_NOMBRE_PRODUCTO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_referencia = '<a class="hastip"  title="' . AYUDA_TEXT_REFERENCIA . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_impuesto_nombre = '<a class="hastip"  title="' . AYUDA_TEXT_IMPUESTO_NOMBRE . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_pvp = '<a class="hastip"  title="' . AYUDA_TEXT_PVP . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_pvp_impuesto = '<a class="hastip"  title="' . AYUDA_TEXT_PVP_IMPUESTO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_precio_grupo = '<a class="hastip"  title="' . AYUDA_TEXT_PRECIO_GRUPO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_shoptoshop = '<a class="hastip"  title="' . AYUDA_TEXT_SHOPTOSHOP . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_shoptoshop_seleccion = '<a class="hastip"  title="' . AYUDA_TEXT_SHOPTOSHOP_SELECCION . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_descuento_cliente_vincular = '<a class="hastip"  title="' . AYUDA_TEXT_DESCUENTO_CLIENTE_VINCULAR . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_descuento_cliente = '<a class="hastip"  title="' . AYUDA_TEXT_DESCUENTO_CLIENTE . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_descuento_cantidad_unidades = '<a class="hastip"  title="' . AYUDA_TEXT_DESCUENTO_CANTIDAD_UNIDADES . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_descuento_cantidad_precio = '<a class="hastip"  title="' . AYUDA_TEXT_DESCUENTO_CANTIDAD_PRECIO . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_stocknivel = '<a class="hastip"  title="' . AYUDA_TEXT_STOCKNIVEL . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_regladecategorias_onoff = '<a class="hastip"  title="' . AYUDA_TEXT_REGLADECATEGORIAS_ONOFF . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_carasteristicas = '<a class="hastip"  title="' . AYUDA_TEXT_CARASTERISTICAS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_codigodebarras = '<a class="hastip"  title="' . AYUDA_TEXT_CODIGODEBARRAS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
 $ayuda_status = '<a class="hastip"  title="' . AYUDA_TEXT_STATUS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';


$ayuda_shoptoshop = '<p><a href="configuration.php?gID=6126&cID=112087&action=edit">Configurar</a> '.'<a class="hastip"  title="' . AYUDA_TEXT_SHOPTOSHOP . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</p></span></font></b>';
$ayuda_ofertas_selec = '<p><a href="configuration.php?gID=6126&cID=112087&action=edit">Ver Ofertas </a> '.'<a class="hastip"  title="' . AYUDA_TEXT_OFERTAS_SELEC . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</p></span></font></b>';
$ayuda_proveedores = '<p><a href="conceptos_proveedores.php">Ir A Proveedores </a> '.'<a class="hastip"  title="' . AYUDA_TEXT_PROVEEDORES . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
$ayuda_regladeprecios = '<p><a href="regladeprecios.php">Ir A Reglas de Precios </a> '.'<a class="hastip"  title="' . AYUDA_TEXT_REGLADEPRECIOS . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
$ayuda_reglafabricante = '<p><a href="cpe.php">Ir Crear reglas de caegoria </a> '.'<a class="hastip"  title="' . AYUDA_TEXT_REGLAFABRICANTE . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
$ayuda_reglacategoria = '<p><a href="cpe.php">Ir Crear reglas de caegoria </a> '.'<a class="hastip"  title="' . AYUDA_TEXT_REGLACATEGORIA . '"><b><font size="1" color="#FFFFFF"><span style="background-color: #000000">_?_</span></font></b>';
                           }

 ?>
//--></script>
    <?php echo tep_draw_form('new_product', FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : '') . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"'); ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_PRODUCT, tep_output_generated_category_path($current_category_id)); ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
            <td class="main"><?php echo $ayuda_status . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_radio_field('products_status', '1', $in_status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . tep_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?></td>
            <td class="main"><?php echo $ayuda_fecha_alta . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_date_available', $pInfo->products_date_available, 'id="products_date_available"') . ' <small>(YYYY-MM-DD)</small>'; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
            <td class="main"><?php echo $ayuda_fabricante . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          

          
          
          
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_NAME; ?></td>
          <td class="main"><?php echo $ayuda_nombre_producto . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . ' ' . tep_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (empty($pInfo->products_id) ? '' : tep_get_products_name($pInfo->products_id, $languages[$i]['id']))); ?></td> </tr>
<?php
    }
?>

            <td class="main"><?php echo 'Referencia o Codigo de Barras'; ?></td>
            <td class="main"><?php echo $ayuda_referencia . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_model', $pInfo->products_model.$HTTP_GET_VARS['ean'].$HTTP_GET_VARS['codigobarras']); ?></td>
          </tr>
          <tr>

          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          
         <tr bgcolor="#ebebff">
            <td class="main"><?php echo 'Codigo de Barras'; ?></td>
            <td class="main"><?php echo $ayuda_codigodebarras . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('codigo_barras', $pInfo->codigo_barras); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


         <tr bgcolor="#ebebff">
            <td class="main"><?php echo 'Referencia 2'; ?></td>
            <td class="main"><?php echo $ayuda_codigodebarras . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_model_2', $pInfo->products_model_2); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


         <tr bgcolor="#ebebff">
            <td class="main"><?php echo 'Referencia 3'; ?></td>
            <td class="main"><?php echo $ayuda_codigodebarras . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_model_3', $pInfo->products_model_3); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

          <tr bgcolor="#ebebff">
            <td class="main"><?php echo 'Referencia 4'; ?></td>
            <td class="main"><?php echo $ayuda_codigodebarras . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_model_4', $pInfo->products_model_4); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


            
            
                <?php

  $addstock_values = tep_db_query("select * from " . TABLE_ORDERS . "  where orders_status = '" . $entregas_stock . "' order by date_purchased DESC");
   $addstock = mysqli_fetch_array($addstock_values);

  $addpend_values = tep_db_query("select * from " . TABLE_ORDERS . "  where orders_status = '" . $status_entregas . "' order by date_purchased DESC");
   $addpend = tep_db_fetch_array($addpend_values);


  $stockmin_values = tep_db_query("select * from " . 'products_stock' . "  where products_id = '" . $HTTP_GET_VARS['pID'] . "'");
   $stockmin = tep_db_fetch_array($stockmin_values);



















 $stock_exterior = '<script language="javascript" src="products_info_stock.php?stock_nivel=6&products_id_stock='. $HTTP_GET_VARS['pID'] . ' "> </script>';

     $query = tep_db_query("SELECT * FROM `products_stock` WHERE  products_id='" . $HTTP_GET_VARS['pID'] . "' and products_stock_real >= 1");
  if ($products_stock = tep_db_fetch_array($query)){
     $color = '#CCFF99';
}else{
 $color = '#FFA8A8';
}



                    ?>

          <tr bgcolor="#CCFF99">
            <td class="main"><?php echo 'Unidades Stock ('.$stock_exterior.')';; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('unidades_nuevo_pedido', '') . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('numero_nuevo_pedido', $addstock['orders_id']); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

            
          <tr bgcolor="#CCFF99">
            <td class="main"><?php echo 'Stock Minimio';; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('stock_min', $stockmin['products_stock_min']) . tep_draw_separator('pixel_trans.gif', '24', '15'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

            
            
            
            
            <?php



       $donde_esta_c_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $HTTP_GET_VARS['pID'] . "' and login_id = '" . $log_id . "'");
 $donde_esta_c= tep_db_fetch_array($donde_esta_c_values)

                  ?>

          
   <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_weight', $pInfo->products_weight); ?></td>
          </tr>

      <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>

   <tr>
            <td class="main"><?php echo 'Donde Esta en Almacén'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('donde_esta', $donde_esta_c['donde_esta']); ?></td>
          </tr>

      <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>


          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
            <td class="main"><?php echo $ayuda_impuesto_nombre . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id, 'onchange="updateGross()"'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_NET; ?></td>
         <td class="main"><?php echo $ayuda_pvp . tep_draw_separator('pixel_trans.gif', '24', '15') . ' ' . tep_draw_input_field('products_price', $pInfo->products_price, 'onkeyup="updateGross()"'); ?></td> </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></td>
          <td class="main"><?php echo $ayuda_pvp_impuesto . tep_draw_separator('pixel_trans.gif', '24', '15') . ' ' . tep_draw_input_field('products_price_gross', $pInfo->products_price, 'onkeyup="updateNet()"'); ?></td> </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<script type="text/javascript"><!--
updateGross();
//--></script>






<td><table border="0" cellspacing="0" cellpadding="2">
<tr valign="top">
<?php
    $customers_group_query = tep_db_query("select distinct customers_group_id, customers_group_name from " . TABLE_CUSTOMERS . " where customers_group_id != '" . 0 . "' order by customers_group_id");
    $header = false;
    while ($customers_group = tep_db_fetch_array($customers_group_query)) {
    if (!$header) {
      $header = true;
?>
    <td><table border="0" cellpadding="0" cellspacing="0">
      <tr class="dataTableHeadingRow">
      <td class="dataTableHeadingContent" colspan="3"><?php echo $ayuda_precio_grupo . $options['products_options_name']; ?></td>
    </tr>
<?php
        }
     if (tep_db_num_rows($customers_group_query) > 0) {
       $attributes_query = tep_db_query("select customers_group_id, customers_group_price from " . TABLE_PRODUCTS_GROUPS . " where products_id = '" . $pInfo->products_id . "' and customers_group_id = '" . $customers_group['customers_group_id'] . "' order by customers_group_id");
     } else {
         $attributes = array('customers_group_id' => 'new');
       }
?>
    <tr class="dataTableRow">
       <td class="dataTableContent"><?php echo tep_draw_checkbox_field('option[' . $customers_group['customers_group_id'] . ']', 'option[' . $customers_group['customers_group_id'] . ']', true) . '&nbsp;' . $customers_group['customers_group_name']; ?>&nbsp;</td>
       <td class="dataTableContent"><?php
       if ($attributes = tep_db_fetch_array($attributes_query)) {
       echo tep_draw_input_field('price[' . $customers_group['customers_group_id'] . ']', $attributes['customers_group_price'], 'size="7"');
       } else {
	   echo tep_draw_input_field('price[' . $customers_group['customers_group_id'] . ']', '', 'size="7"');
	 } ?></td>
    </tr>
<?php }
      if ($header) {
?>
      </table></td>
<?php
      }
?>
     </tr>
       </table></td>
     </tr>




        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="smallText" align="right"><?php echo tep_draw_hidden_field('products_date_added', (tep_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : ''))); ?></td>
      </tr>
  <?php
  $codigo_proveedor = $_GET['codigo_proveedor'];
  $codigobarras_des = $_GET['codigobarras_des'];

 
        if ($codigo_proveedor){

 $query = tep_db_query("SELECT * FROM `products_compartir` WHERE  proveedor_id='" . $codigo_proveedor . "'");
$url = tep_db_fetch_array($query);


       ?>
<p>
<iframe name="I1" width="1404" height="332" src="<?php echo   $url['ruta_url'] ?>products_stock_exterior_quick_description_up.php?&action=new_product&codigobarras_des=
<?php echo $codigobarras_des ?>">
El explorador no admite los marcos flotantes o no está configurado actualmente para mostrarlos.
</iframe></p>
          <?php
          } ?>

<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main" valign="top"><?php if ($i == 0) echo TEXT_PRODUCTS_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                <td class="main">  <?php echo tep_draw_textarea_field('products_description[' . $languages[$i]['id'] . ']', 'soft', '70', '10',
(isset($products_description[$languages[$i]['id']]) ? stripslashes($products_description[$languages[$i]['id']]) :
tep_get_products_description($pInfo->products_id, $languages[$i]['id'])),'id = products_description[' .
$languages[$i]['id'] . '] class="ckeditor"'); ?> </td>
              </tr>
            </table></td>
          </tr>
<?php
    }
    
         // valores predeterminados al crear nuevo producto
     if ($pInfo->codigo_proveedor == ''){
  $pInfo->codigo_proveedor = 1;
 }
     if ($pInfo->stock_nivel == ''){
  $pInfo->stock_nivel = 6;
 }
     if ($pInfo->products_quantity == ''){
  $pInfo->products_quantity = 999999;
 }

     if ($pInfo->products_weight == ''){
  $pInfo->products_weight = '0.12';
 }
 
      if ($pInfo->products_regladeprecios == ''){
  $pInfo->products_regladeprecios = '1';
 }

      if ($pInfo->products_rc == ''){
  $pInfo->products_rc = '2';
 }

      if ($pInfo->products_descuento_onoff == ''){
  $pInfo->products_descuento_onoff = 1;
 }
 
      if ($pInfo->products_descuento == ''){
  $pInfo->products_descuento = 0.00;
 }

      if ($pInfo->products_descuento_g1 == ''){
  $pInfo->products_descuento = 0.00;
 }
      if ($pInfo->products_descuento_g2 == ''){
  $pInfo->products_descuento = 0.00;
 }
      if ($pInfo->products_descuento_g3 == ''){
  $pInfo->products_descuento = 0.00;
 }




 
?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
          


            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_IMAGE; ?></td>
            <td class="main" style="padding-left: 30px;">
              <div><?php echo '<strong>' . TEXT_PRODUCTS_MAIN_IMAGE . ' <small>(' . SMALL_IMAGE_WIDTH . ' x ' . SMALL_IMAGE_HEIGHT . 'px)</small></strong><br />' . (tep_not_null($pInfo->products_image) ? '<a href="' . DIR_WS_CATALOG_IMAGES . $pInfo->products_image . '" target="_blank">' . $pInfo->products_image . '</a> &#124; ' : '') . tep_draw_file_field('products_image'); ?></div>

              <ul id="piList">
<?php
    $pi_counter = 0;
    
        if ($HTTP_GET_VARS['products_extra_images_id']){
 tep_db_query("delete from " . 'products_extra_images' . " where products_extra_images_id = '" . $HTTP_GET_VARS['products_extra_images_id'] . "' ");

         ?>
         
         
              <script type="text/javascript">

    var pagina = '<?php echo FILENAME_CATEGORIES, '?cPath=' . $HTTP_GET_VARS['cPath'] . '&pID=' . $HTTP_GET_VARS['pID']. '&action=new_product'; ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

         
         
         
 <?php
    }

    foreach($pInfo->products_larger_images as $pi) {
      $pi_counter++;

      echo '             <li id="piId' . $pi_counter . '" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s" style="float: right;"></span><a href="#" onclick="showPiDelConfirm(' . $pi_counter . ');return false;" class="ui-icon ui-icon-trash" style="float: right;"></a><strong>' . TEXT_PRODUCTS_LARGE_IMAGE . '</strong><br />' . tep_draw_file_field('products_image_large_' . $pi['products_extra_images_id']) . '<br /><a href="' . DIR_WS_CATALOG_IMAGES . $pi['products_extra_image'] . '" target="_blank">' . $pi['products_extra_image'] . '</a><br /><br />' . TEXT_PRODUCTS_LARGE_IMAGE_HTML_CONTENT . '<br />' . tep_draw_textarea_field('products_image_htmlcontent_' . $pi['products_extra_images_id'], 'soft', '70', '3', $pi['htmlcontent']) . ''.'<a href="'. 'categories.php?del_pdc=' . 'action' . '&pID=' .  $HTTP_GET_VARS['pID'].'&action=new_product' . '&products_extra_images_id=' .  $pi['products_extra_images_id'].'"> Eliminar Todo ('.$pi['products_extra_images_id'].')</li>';
    }
?>
              </ul>

              <a href="#" onclick="addNewPiForm();return false;"><span class="ui-icon ui-icon-plus" style="float: left;"></span><?php echo TEXT_PRODUCTS_ADD_LARGE_IMAGE; ?></a>

<div id="piDelConfirm" title="<?php echo TEXT_PRODUCTS_LARGE_IMAGE_DELETE_TITLE; ?>">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo TEXT_PRODUCTS_LARGE_IMAGE_CONFIRM_DELETE; ?></p>
</div>

<style type="text/css">
#piList { list-style-type: none; margin: 0; padding: 0; }
#piList li { margin: 5px 0; padding: 2px; }
</style>

<script type="text/javascript">
$('#piList').sortable({
  containment: 'parent'
});

var piSize = <?php echo $pi_counter; ?>;

function addNewPiForm() {
  piSize++;

  $('#piList').append('<li id="piId' + piSize + '" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s" style="float: right;"></span><a href="#" onclick="showPiDelConfirm(' + piSize + ');return false;" class="ui-icon ui-icon-trash" style="float: right;"></a><strong><?php echo TEXT_PRODUCTS_LARGE_IMAGE; ?></strong><br /><input type="file" name="products_image_large_new_' + piSize + '" /><br /><br /><?php echo TEXT_PRODUCTS_LARGE_IMAGE_HTML_CONTENT; ?><br /><textarea name="products_image_htmlcontent_new_' + piSize + '" wrap="soft" cols="70" rows="3"></textarea></li>');
}

var piDelConfirmId = 0;

$('#piDelConfirm').dialog({
  autoOpen: false,
  resizable: false,
  draggable: false,
  modal: true,
  buttons: {
    'Delete': function() {
      $('#piId' + piDelConfirmId).effect('blind').remove();
      $(this).dialog('close');
    },
    Cancel: function() {
      $(this).dialog('close');
    }
  }
});

function showPiDelConfirm(piId) {
  piDelConfirmId = piId;

  $('#piDelConfirm').dialog('open');
}
</script>

            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          
          
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="smallText" align="right"><?php echo tep_draw_hidden_field('products_date_added', (tep_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : ''))); ?></td>
      </tr>

          
          
          
          
          
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_URL . '<br /><small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?></td>
            <td class="main"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (isset($products_url[$languages[$i]['id']]) ? stripslashes($products_url[$languages[$i]['id']]) : tep_get_products_url($pInfo->products_id, $languages[$i]['id']))); ?></td>
          </tr>
<?php
    }

   $pro_special_values = tep_db_query("select * from " . 'specials' . " where products_id = '" .   $HTTP_GET_VARS['pID'] . "'");
    $pro_special = tep_db_fetch_array($pro_special_values);

























?>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Cuenta de Twitter del Fabricante';; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_twitter', $pInfo->products_twitter); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>




                   </tr>
          <tr>
            <td class="main"><?php echo 'Nombre archivo .pdf';; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('pdf', $pInfo->pdf); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>




                   </tr>
          <tr>
            <td class="main"><?php echo 'Video Youtube 1';; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_youtube_1', $pInfo->products_youtube_1); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Video Youtube 2'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_youtube_2', $pInfo->products_youtube_2); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>



                   </tr>
          <tr>
            <td class="main"><?php echo 'Referencia Padre grupo 1';; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('referencia_padre', $pInfo->referencia_padre); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Referencia Padre grupo 2'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('preferencia_padre_g2', $pInfo->referencia_padre_g2); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Referencia Padre grupo 3'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('referencia_padre_g3', $pInfo->referencia_padre_g3); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





           <tr>            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
              <td class="main"><?php echo $ayuda_shoptoshop.'SHOP TO SHOP Inactive (0) Active (1) ' . $ayuda_shoptoshop_seleccion; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_shoptoshop', $pInfo->products_shoptoshop); ?></td>
          </tr>
          <tr>
           <tr>
           <tr>            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

            <td class="main"><?php echo 'Vincular el Decuento Cliente (1) Producto (0)'. $ayuda_descuento_cliente_vincular; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_descuento_onoff', $pInfo->products_descuento_onoff); ?></td>
          </tr>
          <tr>
           <tr>
            <td class="main"><?php echo 'Descuento Aplicar al Producto' . $ayuda_descuento_cliente; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_descuento', $pInfo->products_descuento); ?></td>
          </tr>
          <tr>
          </tr>
          <tr>
           <tr>
            <td class="main"><?php echo 'Descuento Aplicar al Producto g1' . $ayuda_descuento_cliente; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_descuento_g1', $pInfo->products_descuento_g1); ?></td>
          </tr>
          <tr>
          </tr>
          <tr>
           <tr>
            <td class="main"><?php echo 'Descuento Aplicar al Producto g2' . $ayuda_descuento_cliente; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_descuento_g2', $pInfo->products_descuento_g2); ?></td>
          </tr>
          <tr>
          </tr>
          <tr>
           <tr>
            <td class="main"><?php echo 'Descuento Aplicar al Producto g3' . $ayuda_descuento_cliente; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_descuento_g3', $pInfo->products_descuento_g3); ?></td>
          </tr>
          <tr>
           <tr>            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>



           <tr>            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

            <td class="main"><?php echo 'Descuento por Cantidades '. $ayuda_descuento_cantidad_unidades; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('pdc_unidades', $pInfo->pdc_unidades); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo 'Precios ' . $ayuda_descuento_cantidad_precio . '<a href="'. 'categories.php?del_pdc=' . 'action' . '&pID=' .  $HTTP_GET_VARS['pID'].'&action=new_product' . '"> ->> Eliminar Todo' ; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('pdc_price_final', $pInfo->pdc_price_final); ?></td>
          </tr>

          <tr>
           <tr>


<?php

        if ($HTTP_GET_VARS['del_pdc'] == 'action'){

 tep_db_query("delete from " . 'products_descuento_cantidad' . " where pdc_products_id = '" . $HTTP_GET_VARS['pID'] . "' ");


    }
        if ($HTTP_GET_VARS['del_pdc_unidad'] == 'action'){

 tep_db_query("delete from " . 'products_descuento_cantidad' . " where pdc_id = '" . $HTTP_GET_VARS['pdc_id'] . "' ");


    }

   $pdc_consulta_values = tep_db_query("select * from " . 'products_descuento_cantidad' . " where pdc_products_id = '" .   $HTTP_GET_VARS['pID'] . "' order by pdc_unidades ASC");
  while  ($pdc_consulta = tep_db_fetch_array($pdc_consulta_values)){


 ?>


           <tr>
           <td class="main"><?php echo 'Cantidad: '. $pdc_consulta['pdc_unidades'] . ' precio: '. $pdc_consulta['pdc_price_final'] . '<a href="'. 'categories.php?del_pdc_unidad=' . 'action' . '&pID=' .  $HTTP_GET_VARS['pID'].'&action=new_product'.'&pdc_id=' . $pdc_consulta['pdc_id']. '"> ->> Eliminar'; ?></td>
          </tr>
   </tr>

          
          
 <?php } ?>
          

           <tr>
           <td class="main"></td>
          </tr>
          <tr>
           <tr>            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>


            <td class="main"><?php echo $ayuda_ofertas_selec . ' Activar Oferta (1) Desactivar Oferta (0) Borrar Oferta (2) '; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_specials_onoff', $pro_special['status']); ?></td>
          </tr>
          <tr>
           <tr>
            <td class="main"><?php echo 'Precio de Oferta ' . $ayuda_ofertas; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_specials',  $pro_special['specials_new_products_price']); ?></td>
          </tr>
          <tr>
           <tr>            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
          

            <td class="main"><?php echo $ayuda_proveedores . ' Codigo Proveedor'; ?>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('codigo_proveedor', $pInfo->codigo_proveedor); ?></td>
          </tr>
          <tr>
           <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo 'Stock Nivel '. $ayuda_stocknivel; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('stock_nivel', $pInfo->stock_nivel); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo 'Regla de Precios'. $ayuda_regladeprecios; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_regladeprecios', $pInfo->products_regladeprecios); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                   </tr>
          <tr>
            <td class="main"><?php echo 'Regla de Fabricante'. $ayuda_reglacategoria; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_cpf', $pInfo->products_cpf); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>



          <tr>
            <td class="main"><?php echo 'Nombre de Fabricante'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('manufacturers_name', $pInfo->manufacturers_name); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>



                    </tr>
          <tr>
            <td class="main"><?php echo 'Regla de Categoria'. $ayuda_reglafabricante; ; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_cpe', $pInfo->products_cpe); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                    </tr>



                   </tr>
          <tr>
            <td class="main"><?php echo 'Reglas de Categorias Usar(1) NO(2)' . $ayuda_regladecategorias_onoff; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_rc', $pInfo->products_rc); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   <?php

                       if ($pInfo->opcion_1){
                           }else{
                           $pInfo->opcion_1 = OPCION_1;
                           }
                       if ($pInfo->opcion_2){
                           }else{
                           $pInfo->opcion_2 = OPCION_2;
                           }
                        if ($pInfo->opcion_3){
                           }else{
                           $pInfo->opcion_3 = OPCION_3;
                           }
                        if ($pInfo->opcion_4){
                           }else{
                           $pInfo->opcion_4 = OPCION_4;
                           }
                        if ($pInfo->opcion_5){
                           }else{
                           $pInfo->opcion_5 = OPCION_5;
                           }
                        if ($pInfo->opcion_1){
                           }else{
                           $pInfo->opcion_6 = OPCION_6;
                           }
                        if ($pInfo->opcion_6){
                           }else{
                           $pInfo->opcion_6 = OPCION_6;
                           }
                        if ($pInfo->opcion_7){
                           }else{
                           $pInfo->opcion_7 = OPCION_7;
                           }
                        if ($pInfo->opcion_8){
                           }else{
                           $pInfo->opcion_8 = OPCION_8;
                           }
                        if ($pInfo->opcion_9){
                           }else{
                           $pInfo->opcion_9 = OPCION_9;
                           }
                        if ($pInfo->opcion_10){
                           }else{
                           $pInfo->opcion_10 = OPCION_10;
                           }
                        if ($pInfo->opcion_11){
                           }else{
                           $pInfo->opcion_11 = OPCION_11;
                           }
                        if ($pInfo->opcion_12){
                           }else{
                           $pInfo->opcion_12 = OPCION_12;
                           }
                        if ($pInfo->opcion_13){
                           }else{
                           $pInfo->opcion_13 = OPCION_13;
                           }
                        if ($pInfo->opcion_14){
                           }else{
                           $pInfo->opcion_14 = OPCION_14;
                           }
                        if ($pInfo->opcion_15){
                           }else{
                           $pInfo->opcion_15 = OPCION_15;
                           }
                        if ($pInfo->opcion_16){
                           }else{
                           $pInfo->opcion_16 = OPCION_16;
                           }
                         ;if ($pInfo->opcion_17){
                           }else{
                           $pInfo->opcion_17 = OPCION_17;
                           }
                       if ($pInfo->opcion_18){
                           }else{
                           $pInfo->opcion_18 = OPCION_18;
                           }
                        if ($pInfo->opcion_19){
                           }else{
                           $pInfo->opcion_19 = OPCION_19;
                           }
                        if ($pInfo->opcion_20){
                           }else{
                           $pInfo->opcion_20 = OPCION_20;
                           }
                         ?>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 1' . $ayuda_carasteristicas;; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_1', $pInfo->opcion_1); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 1_1'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_1_1', $pInfo->opcion_1_1); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>




                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 2'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_2', $pInfo->opcion_2); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 2_2'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_2_2', $pInfo->opcion_2_2); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 3'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_3', $pInfo->opcion_3); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 3_3'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_3_3', $pInfo->opcion_3_3); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 4'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_4', $pInfo->opcion_4); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 4_4'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_4_4', $pInfo->opcion_4_4); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 5'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_5', $pInfo->opcion_5); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 5_5'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_5_5', $pInfo->opcion_5_5); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 6'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_6', $pInfo->opcion_6); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 6_6'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_6_6', $pInfo->opcion_6_6); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 7'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_7', $pInfo->opcion_7); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 7_7'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_7_7', $pInfo->opcion_7_7); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 8'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_8', $pInfo->opcion_8); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 8_8'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_8_8', $pInfo->opcion_8_8); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 9'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_9', $pInfo->opcion_9); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 9_9'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_9_9', $pInfo->opcion_9_9); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>


                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 10'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_10', $pInfo->opcion_10); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 10_10'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_10_10', $pInfo->opcion_10_10); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>



                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 11'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_11', $pInfo->opcion_11); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 11_11'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_11_11', $pInfo->opcion_11_11); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>



                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 12'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_12', $pInfo->opcion_12); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 12_12'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_12_12', $pInfo->opcion_12_12); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>







                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 13'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_13', $pInfo->opcion_13); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 13_13'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_13_13', $pInfo->opcion_13_13); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 14'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_14', $pInfo->opcion_14); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 14_14'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_14_14', $pInfo->opcion_14_14); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 15'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_15', $pInfo->opcion_15); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 15_15'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_15_15', $pInfo->opcion_15_15); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 16'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_16', $pInfo->opcion_16); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 16_16'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_16_16', $pInfo->opcion_16_16); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 17'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_17', $pInfo->opcion_17); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 17_17'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_17_17', $pInfo->opcion_17_17); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 18'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_18', $pInfo->opcion_18); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 18_18'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_18_18', $pInfo->opcion_18_18); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 19'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_19', $pInfo->opcion_19); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 19_19'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_19_19', $pInfo->opcion_19_19); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>





                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 20'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_20', $pInfo->opcion_20); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>

                   </tr>
          <tr>
            <td class="main"><?php echo 'Opcion 20_20'; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('opcion_20_20', $pInfo->opcion_20_20); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>









          </tr>
           <tr>
           <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
         <tr>

       </table></td>
      </tr>
      <tr>
      
      
      
      

      
      
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="smallText" align="right"><?php echo tep_draw_hidden_field('products_date_added', (tep_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : ''))); ?></td>
      </tr>
    </table>

<script type="text/javascript">
$('#products_date_available').datepicker({
  dateFormat: 'yy-mm-dd'
});
</script>

    </form>
<?php
  } elseif ($action == 'new_product_preview') {
    $product_query = tep_db_query("select p.products_id, pd.language_id, pd.products_name, pd.products_description, pd.products_url, p.products_quantity, codigo_proveedor, stock_nivel, p.products_model, p.products_image, p.products_price, p.products_weight, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.manufacturers_id  from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "'");
    $product = tep_db_fetch_array($product_query);

    $pInfo = new objectInfo($product);
    $products_image_name = $pInfo->products_image;

    $languages = tep_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      $pInfo->products_name = tep_get_products_name($pInfo->products_id, $languages[$i]['id']);
      $pInfo->products_description = tep_get_products_description($pInfo->products_id, $languages[$i]['id']);
      $pInfo->products_url = tep_get_products_url($pInfo->products_id, $languages[$i]['id']);
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . $pInfo->products_name; ?></td>
            <td class="pageHeading" align="right"><?php echo $currencies->format($pInfo->products_price); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_name, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"') . $pInfo->products_description; ?></td>
      </tr>
<?php
      if ($pInfo->products_url) {
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo sprintf(TEXT_PRODUCT_MORE_INFORMATION, $pInfo->products_url); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
      if ($pInfo->products_date_available > date('Y-m-d')) {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_AVAILABLE, tep_date_long($pInfo->products_date_available)); ?></td>
      </tr>
<?php
      } else {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_ADDED, tep_date_long($pInfo->products_date_added)); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }

    if (isset($HTTP_GET_VARS['origin'])) {
      $pos_params = strpos($HTTP_GET_VARS['origin'], '?', 0);
      if ($pos_params != false) {
        $back_url = substr($HTTP_GET_VARS['origin'], 0, $pos_params);
        $back_url_params = substr($HTTP_GET_VARS['origin'], $pos_params + 1);
      } else {
        $back_url = $HTTP_GET_VARS['origin'];
        $back_url_params = '';
      }
    } else {
      $back_url = FILENAME_CATEGORIES;
      $back_url_params = 'cPath=' . $cPath . '&pID=' . $pInfo->products_id;
    }
?>
      <tr>
        <td align="right" class="smallText"><?php echo tep_draw_button(IMAGE_BACK, 'triangle-1-w', tep_href_link($back_url, $back_url_params, 'NONSSL')); ?></td>
      </tr>
    </table>
<?php
  } else {
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            

<SCRIPT>
<!--
function sffh(){document.s.search.focus();}
function clk(url,oi,cad,ct,cd,sg){if(document.images){var e = window.encodeURIComponent ? encodeURIComponent : escape;var u="";var oi_param="";var cad_param="";if (url) u="&url="+e(url.replace(/#.*/,"")).replace(/\+/g,"%2B");if (oi) oi_param="&oi="+e(oi);if (cad) cad_param="&cad="+e(cad);new Image().src="/url?sa=T"+oi_param+cad_param+"&ct="+e(ct)+"&cd="+e(cd)+u+"&ei=yzHqRPLoGpy2QP6B_X0"+sg;}return true;}
// -->
</SCRIPT>
  <BODY topMargin=3 onload=sffh()>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            


            <td align="left"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="left">
                
  <BODY topMargin=3 onload=sffh()>
<form name="s"  method="get" action="<?php echo $PHP_SELF . '?cPath=' . $HTTP_GET_VARS['cPath'];?>">
                   <?php
                       if (NEW_PRODUCT == 1){
                     ?>
<p><input type="radio" value="1" checked name="<?php ECHO 'new_products_cat' ?>">
<input type="radio" name="<?php ECHO 'new_products_cat' ?>" value="2"><font color="#008000"><b>Activado</b></font>
 
 
                           <?php
                          }else if (NEW_PRODUCT == 2){
                             ?>
<p><input type="radio" value="1"  name="<?php ECHO 'new_products_cat' ?>">
<input type="radio" checked name="<?php ECHO 'new_products_cat' ?>" value="2"><font color="#ff0000"><b>Desactivado</b></font>
                                  <?php
                          }
                             ?>
 
 
	<p><input type="text" name="search" size="20">
 <input type="checkbox" name="<?php ECHO 'cPath' ?>" value="<?php ECHO $HTTP_GET_VARS['cPath']; ?> " checked>

 <input type="submit" value="Buscar" name="B1"></p>
</form>




                
<?php
 //  echo tep_draw_form('search', FILENAME_CATEGORIES, '', 'get');
   //    echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('search');
  //     echo tep_hide_session_id() . '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="left">
<?php
    echo tep_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
    echo HEADING_TITLE_GOTO . ' ' . tep_draw_pull_down_menu('cPath', tep_get_category_tree(), $current_category_id, 'onchange="this.form.submit();"');
    echo tep_hide_session_id() . '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CATEGORIES_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>



<?php



     echo '<p><b><a href="' . 'categories.php?cPath=' . (int)$current_category_id . 'pID='.$pInfo->products_id.'">VOLVER A LA CATEGORIA</a></b> '.(int)$current_category_id;

                    if ( $HTTP_GET_VARS['new_products_cat'] == 1){
  	tep_db_query ("UPDATE " . TABLE_CONFIGURATION . " SET
					configuration_value = '" . 1 . "'
					WHERE configuration_key = '" . 'NEW_PRODUCT' . "'");
                              echo 'a';
     
                           if ( NEW_PRODUCT == 2){
                                echo 'b';
                                       ?>
        <script type="text/javascript">

       var pagina = 'categories.php<? echo '?cPath=' . $HTTP_GET_VARS['cPath'] . 'pID=' . $HTTP_GET_VARS['pID'];  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

    <?php
                             }
     
     
                                                   }

                    if ( $HTTP_GET_VARS['new_products_cat'] == 2){
  	tep_db_query ("UPDATE " . TABLE_CONFIGURATION . " SET
					configuration_value = '" . 2 . "'
					WHERE configuration_key = '" . 'NEW_PRODUCT' . "'");
     
     
                           if ( NEW_PRODUCT == 1){
                                       ?>
        <script type="text/javascript">

       var pagina = 'categories.php<? echo '?cPath=' . $HTTP_GET_VARS['cPath'] . 'pID=' . $HTTP_GET_VARS['pID'];  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

    <?php
                             }
     
     
     
     
                                                   }



           if (NEW_PRODUCT == 1){
        $newproducts_values = tep_db_query("select pd.products_name from " . 'products' . " p, products_description pd where p.products_id = pd.products_id and p.products_model = '" . $HTTP_GET_VARS['search'] . "'");
      if ($newproducts = tep_db_fetch_array($newproducts_values)){


                //si el nombre es el mismo que la busqueda
         if ($newproducts['products_name'] == $HTTP_GET_VARS['search']){


                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . "");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){


             //   echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='. $codigobarras .'&url='. HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'products_stock_nuevaalta.php' . '"> </script>';
        echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?cPath=' . (int)$current_category_id . '&codigobarras='.$HTTP_GET_VARS['search'].'&url='. HTTPS_SERVER . DIR_WS_CATALOG . 'admin/products_stock_nuevaalta.php' . '&proveedor_id=' . $product_compartir['proveedor_id'] . '"> </script>';






                              }
}

    }else{


                 if (NEW_PRODUCT_PRE == 1){

 	//tep_db_query ("UPDATE " . TABLE_CONFIGURATION . " SET
				//	configuration_value = '" . 2 . "'
			//		WHERE configuration_key = '" . 'NEW_PRODUCT_PRE' . "'");




                                                       //zona envío
                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . "");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){


             //   echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?codigobarras='. $codigobarras .'&url='. HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . 'products_stock_nuevaalta.php' . '"> </script>';
        echo '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_exterior.php?cPath=' . (int)$current_category_id . '&codigobarras='.$HTTP_GET_VARS['search'].'&url='. HTTPS_SERVER . DIR_WS_CATALOG . 'admin/products_stock_nuevaalta.php' . '&proveedor_id=' . $product_compartir['proveedor_id'] . '"> </script>';






                              }
                           }
                        }
                   }





              if (NEW_PRODUCT == 1){
       $newproducts_values = tep_db_query("select * from " . 'products' . " where products_model = '" . $HTTP_GET_VARS['search'] . "'");
      if ($newproducts = tep_db_fetch_array($newproducts_values)){


    }else{
             if ($HTTP_GET_VARS['search'] <> ''){
         ?>
        <script type="text/javascript">

       var pagina = 'categories.php<? echo '?cPath=' . $HTTP_GET_VARS['cPath'] . '&action=new_product'.'&ean='.$HTTP_GET_VARS['search'];  ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

    <?php


}}}

    $categories_count = 0;
    $rows = 0;
    if (isset($HTTP_GET_VARS['search'])) {
      $search = tep_db_prepare_input($HTTP_GET_VARS['search']);

      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_name_suple, cd.categories_status_visible, cd.categories_name_http, cd.categories_name_http_mobil, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_name like '%" . tep_db_input($search) . "%' order by c.sort_order, cd.categories_name");
    } else {
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_name_suple, cd.categories_status_visible, cd.categories_name_http, cd.categories_name_http_mobil, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
    }
    while ($categories = tep_db_fetch_array($categories_query)) {
      $categories_count++;
      $rows++;

// Get parent_id for subcategories if search
      if (isset($HTTP_GET_VARS['search'])) $cPath= $categories['parent_id'];

      if ((!isset($HTTP_GET_VARS['cID']) && !isset($HTTP_GET_VARS['pID']) || (isset($HTTP_GET_VARS['cID']) && ($HTTP_GET_VARS['cID'] == $categories['categories_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
        $category_childs = array('childs_count' => tep_childs_in_category_count($categories['categories_id']));
        $category_products = array('products_count' => tep_products_in_category_count($categories['categories_id']));

        $cInfo_array = array_merge($categories, $category_childs, $category_products);
        $cInfo = new objectInfo($cInfo_array);
      }
      
      
      

      if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, tep_get_path($categories['categories_id'])) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, tep_get_path($categories['categories_id'])) . '">' . tep_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<strong>' . $categories['categories_name'] . ' | ' . $categories['categories_id'] . '</strong>'; ?></td>
                <td class="dataTableContent" align="center">&nbsp;</td>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $products_count = 0;
    if (isset($HTTP_GET_VARS['search'])) {
      $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, codigo_proveedor, stock_nivel, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and pd.products_name like '%" . tep_db_input($search) . "%' or p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p.products_model like '%" . tep_db_input($search) . "%' order by pd.products_name");
    } else {
      $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, codigo_proveedor, stock_nivel, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by pd.products_name");
    }
    while ($products = tep_db_fetch_array($products_query)) {
      $products_count++;
      $rows++;

// Get categories_id for product if search
      if (isset($HTTP_GET_VARS['search'])) $cPath = $products['categories_id'];

      if ( (!isset($HTTP_GET_VARS['pID']) && !isset($HTTP_GET_VARS['cID']) || (isset($HTTP_GET_VARS['pID']) && ($HTTP_GET_VARS['pID'] == $products['products_id']))) && !isset($pInfo) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
// find out the rating average from customer reviews
        $reviews_query = tep_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . (int)$products['products_id'] . "'");
        $reviews = tep_db_fetch_array($reviews_query);
        $pInfo_array = array_merge($products, $reviews);
        $pInfo = new objectInfo($pInfo_array);
      }

      if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id'] . '&action=new_product_preview') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id'] . '&action=new_product_preview') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $products['products_name']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($products['products_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $cPath_back = '';
    if (sizeof($cPath_array) > 0) {
      for ($i=0, $n=sizeof($cPath_array)-1; $i<$n; $i++) {
        if (empty($cPath_back)) {
          $cPath_back .= $cPath_array[$i];
        } else {
          $cPath_back .= '_' . $cPath_array[$i];
        }
      }
    }

    $cPath_back = (tep_not_null($cPath_back)) ? 'cPath=' . $cPath_back . '&' : '';
?>



              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_CATEGORIES . '&nbsp;' . $categories_count . '<br />' . TEXT_PRODUCTS . '&nbsp;' . $products_count; ?></td>
                    <td align="right" class="smallText"><?php if (sizeof($cPath_array) > 0) echo tep_draw_button(IMAGE_BACK, 'triangle-1-w', tep_href_link(FILENAME_CATEGORIES, $cPath_back . 'cID=' . $current_category_id)); if (!isset($HTTP_GET_VARS['search'])) echo tep_draw_button(IMAGE_NEW_CATEGORY, 'plus', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_category')) . tep_draw_button(IMAGE_NEW_PRODUCT, 'plus', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_product')); ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($action) {
      case 'new_category':
        $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</strong>');

        $contents = array('form' => tep_draw_form('newcategory', FILENAME_CATEGORIES, 'action=insert_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);

        $category_inputs_string = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br />' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_name[' . $languages[$i]['id'] . ']');
        }

        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_IMAGE . '<br />' . tep_draw_file_field('categories_image'));
        $contents[] = array('text' => '<br />' . TEXT_SORT_ORDER . '<br />' . tep_draw_input_field('sort_order', '', 'size="2"'));
        $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath)));
        break;
      case 'edit_category':
        $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</strong>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=update_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => TEXT_EDIT_INTRO);

        $category_inputs_string = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br />' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', tep_get_category_name($cInfo->categories_id, $languages[$i]['id']));
          $category_inputs_string_suple .= '<br />' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_name_suple[' . $languages[$i]['id'] . ']', tep_get_category_name_suple($cInfo->categories_id, $languages[$i]['id']));
          $category_inputs_string_http .= '<br />' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_name_http[' . $languages[$i]['id'] . ']', tep_get_category_name_http($cInfo->categories_id, $languages[$i]['id']));
          $category_inputs_string_http_mobil .= '<br />' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_name_http_mobil[' . $languages[$i]['id'] . ']', tep_get_category_name_http_mobil($cInfo->categories_id, $languages[$i]['id']));
          $category_inputs_string_status .= '<br />' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_status_visible[' . $languages[$i]['id'] . ']', tep_get_category_name_status($cInfo->categories_id, $languages[$i]['id']));
      }

        $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br />' . 'Nombre de Categoria Suplementaria' . $category_inputs_string_suple);
        $contents[] = array('text' => '<br />' . 'Link Externo' . $category_inputs_string_http);
        $contents[] = array('text' => '<br />' . 'Link Externo Mobil' . $category_inputs_string_http_mobil);
        $contents[] = array('text' => '<br />' . 'STATUS CATEGORIA 1-SI 0-NO' . $category_inputs_string_status);
       $contents[] = array('text' => '<br />' . tep_image(DIR_WS_CATALOG_IMAGES . $cInfo->categories_image, $cInfo->categories_name) . '<br />' . DIR_WS_CATALOG_IMAGES . '<br /><strong>' . $cInfo->categories_image . '</strong>');
        $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_IMAGE . '<br />' . tep_draw_file_field('categories_image'));
        $contents[] = array('text' => '<br />' . TEXT_EDIT_SORT_ORDER . '<br />' . tep_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'));
        $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id)));
        break;
      case 'delete_category':
        $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</strong>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=delete_category_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
        $contents[] = array('text' => '<br /><strong>' . $cInfo->categories_name . '</strong>');
        if ($cInfo->childs_count > 0) $contents[] = array('text' => '<br />' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count));
        if ($cInfo->products_count > 0) $contents[] = array('text' => '<br />' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $cInfo->products_count));
        $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_DELETE, 'trash', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id)));
        break;
      case 'move_category':
        $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_MOVE_CATEGORY . '</strong>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=move_category_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_CATEGORIES_INTRO, $cInfo->categories_name));
        $contents[] = array('text' => '<br />' . sprintf(TEXT_MOVE, $cInfo->categories_name) . '<br />' . tep_draw_pull_down_menu('move_to_category_id', tep_get_category_tree(), $current_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_MOVE, 'arrow-4', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id)));
        break;
      case 'delete_product':
        $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_DELETE_PRODUCT . '</strong>');

        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=delete_product_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
        $contents[] = array('text' => '<br /><strong>' . $pInfo->products_name . '</strong>');

        $product_categories_string = '';
        $product_categories = tep_generate_category_path($pInfo->products_id, 'product');
        for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++) {
          $category_path = '';
          for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++) {
            $category_path .= $product_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
          }
          $category_path = substr($category_path, 0, -16);
          $product_categories_string .= tep_draw_checkbox_field('product_categories[]', $product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . '&nbsp;' . $category_path . '<br />';
        }
        $product_categories_string = substr($product_categories_string, 0, -4);

        $contents[] = array('text' => '<br />' . $product_categories_string);
        $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_DELETE, 'trash', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id)));
        break;
      case 'move_product':
        $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_MOVE_PRODUCT . '</strong>');

        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=move_product_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_PRODUCTS_INTRO, $pInfo->products_name));
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><strong>' . tep_output_generated_category_path($pInfo->products_id, 'product') . '</strong>');
        $contents[] = array('text' => '<br />' . sprintf(TEXT_MOVE, $pInfo->products_name) . '<br />' . tep_draw_pull_down_menu('move_to_category_id', tep_get_category_tree(), $current_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_MOVE, 'arrow-4', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id)));
        break;
      case 'copy_to':
        $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_COPY_TO . '</strong>');

        $contents = array('form' => tep_draw_form('copy_to', FILENAME_CATEGORIES, 'action=copy_to_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><strong>' . tep_output_generated_category_path($pInfo->products_id, 'product') . '</strong>');
        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES . '<br />' . tep_draw_pull_down_menu('categories_id', tep_get_category_tree(), $current_category_id));
        $contents[] = array('text' => '<br />' . TEXT_HOW_TO_COPY . '<br />' . tep_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . tep_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
        $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_COPY, 'copy', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id)));
        break;
      default:
        if ($rows > 0) {
          if (isset($cInfo) && is_object($cInfo)) { // category info box contents
            $category_path_string = '';
            $category_path = tep_generate_category_path($cInfo->categories_id);
            for ($i=(sizeof($category_path[0])-1); $i>0; $i--) {
              $category_path_string .= $category_path[0][$i]['id'] . '_';
            }
            $category_path_string = substr($category_path_string, 0, -1);

            $heading[] = array('text' => '<strong>' . $cInfo->categories_name . '</strong>');

            $contents[] = array('align' => 'center', 'text' => tep_draw_button(IMAGE_EDIT, 'document', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=edit_category')) . tep_draw_button(IMAGE_DELETE, 'trash', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=delete_category')) . tep_draw_button(IMAGE_MOVE, 'arrow-4', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=move_category')));
            $contents[] = array('text' => '<br />' . TEXT_DATE_ADDED . ' ' . tep_date_short($cInfo->date_added));
            if (tep_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($cInfo->last_modified));
            $contents[] = array('text' => '<br />' . tep_info_image($cInfo->categories_image, $cInfo->categories_name, 180, 180) . '<br />' . $cInfo->categories_image);
            $contents[] = array('text' => '<br />' . TEXT_SUBCATEGORIES . ' ' . $cInfo->childs_count . '<br />' . TEXT_PRODUCTS . ' ' . $cInfo->products_count);
          } elseif (isset($pInfo) && is_object($pInfo)) { // product info box contents
            $heading[] = array('text' => '<strong>' . tep_get_products_name($pInfo->products_id, $languages_id) . '</strong>');



  $product_values = tep_db_query("select * from " . 'products' . "  where products_id = '" . $pInfo->products_id . "'");
   $product = tep_db_fetch_array($product_values);




            $contents[] = array('align' => 'center', 'text' => tep_draw_button(IMAGE_EDIT, 'document', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product')) .
            tep_draw_button(IMAGE_DELETE, 'trash', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_product')) .
            tep_draw_button(IMAGE_MOVE, 'arrow-4', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=move_product')) .
            tep_draw_button(IMAGE_COPY_TO, 'copy', tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_to')));
            $contents[] = array('text' => '<br />' . TEXT_DATE_ADDED . ' ' . tep_date_short($pInfo->products_date_added));
            if (tep_not_null($pInfo->products_last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($pInfo->products_last_modified));
            if (date('Y-m-d') < $pInfo->products_date_available) $contents[] = array('text' => TEXT_DATE_AVAILABLE . ' ' . tep_date_short($pInfo->products_date_available));


           $contents[] = array('text' => '<a target="_blank" href="' . 'quick_cliente.php?buscar=ok&page=&MAX_DISPLAY_SEARCH_RESULTS=100&codigo_proveedor=' . $product['codigo_proveedor'] . '&palabraclave=' . $product['products_model'] . '">MODIFICAR X EAN ->></a>');

              if ($product['referencia_padre']){
            $contents[] = array('text' => '<a target="_blank" href="' . 'quick_cliente.php?buscar=ok&page=&MAX_DISPLAY_SEARCH_RESULTS=100&codigo_proveedor=' . $product['codigo_proveedor'] . '&palabraclave=' . $product['referencia_padre'] . '">MODIFICAR X REFERENCIA PADRE ->></a>');
                  }

              if ($product['referencia_padre_g2']){
            $contents[] = array('text' => '<a target="_blank" href="' . 'quick_cliente.php?buscar=ok&page=&MAX_DISPLAY_SEARCH_RESULTS=100&codigo_proveedor=' . $product['codigo_proveedor'] . '&palabraclave=' . $product['referencia_padre_g2'] . '">MODIFICAR X REFERENCIA PADRE G2 ->></a>');
                  }

              if ($product['referencia_padre_g3']){
            $contents[] = array('text' => '<a target="_blank" href="' . 'quick_cliente.php?buscar=ok&page=&MAX_DISPLAY_SEARCH_RESULTS=100&codigo_proveedor=' . $product['codigo_proveedor'] . '&palabraclave=' . $product['referencia_padre_g2'] . '">MODIFICAR X REFERENCIA PADRE G3 ->></a>');
                  }


          //  $contents[] = array('text' => '<br />' . tep_info_image($pInfo->products_image, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br />' . $pInfo->products_image);
            $contents[] = array('text' => '<br />' . '<img border="0" src="'.HTTPS_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $pInfo->products_image.'" width="'.SMALL_IMAGE_WIDTH.'" height="'.SMALL_IMAGE_HEIGHT.'"></p>' . '<br />' . $pInfo->products_image);

             $contents[] = array('text' => '<br />' . TEXT_PRODUCTS_PRICE_INFO . ' ' . $currencies->format($pInfo->products_price) . '<br />' . TEXT_PRODUCTS_QUANTITY_INFO . ' ' . $pInfo->products_quantity);
            $contents[] = array('text' => '<br />' . TEXT_PRODUCTS_AVERAGE_RATING . ' ' . number_format($pInfo->average_rating, 2) . '%');
          }
        } else { // create category/product info
          $heading[] = array('text' => '<strong>' . EMPTY_CATEGORY . '</strong>');

          $contents[] = array('text' => TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS);
        }
        break;
    }

    if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
    </table>
<?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
