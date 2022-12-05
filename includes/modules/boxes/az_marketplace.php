<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class az_marketplace {
    var $code = 'az_marketplace';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function az_marketplace() {
      $this->title = MODULE_BOXES_AZ_MARKETPLACE_TITLE;
      $this->description = MODULE_BOXES_AZ_MARKETPLACE_DESCRIPTION;

      if ( defined('MODULE_BOXES_AZ_MARKETPLACE_STATUS') ) {
        $this->sort_order = MODULE_BOXES_AZ_MARKETPLACE_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_AZ_MARKETPLACE_STATUS == 'True');

        $this->group = ((MODULE_BOXES_AZ_MARKETPLACE_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function tep_show_category($counter) {
      global $tree, $categories_string, $cPath_array;

      if($tree[$counter]['level'] > 5){
		$categories_string .= '<div class="cat_child" style="">';
	  }else{
		$categories_string .= '<div class="cat_parent">';
        //if ( file_exists(DIR_WS_IMAGES . $tree[$counter]['image']) )
            //$categories_string .= '&nbsp;&nbsp;';
			
      }
    
      //for ($i=0; $i<$tree[$counter]['level']; $i++) {
        //$categories_string .= '<div class="space_cat">&nbsp;</div>';
      //}
	  $i=$tree[$counter]['level'];
	  if ($i>1) {
        $categories_string .= '<div class="padding_child">';
	  }






              if ($tree[$counter]['name_http']){
                    $tree[$counter]['productos'] = 1;
       }



                  if  ($tree[$counter]['productos'] == 0){




}else{



      
	  if (isset($cPath_array) && in_array($counter, $cPath_array)) {
		$categories_string .= '<a class="active_cat" href="';
      } else {
	  	$categories_string .= '<a href="';
	  }

      if ($tree[$counter]['parent'] == 0) {
        $cPath_new = 'cPath=' . $counter;
      } else {
        $cPath_new = 'cPath=' . $tree[$counter]['path'];
      }


           if ($tree[$counter]['name_http']){
          $categories_string .= $tree[$counter]['name_http'].'">';
       }else{
      $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">';
         }




  }






      //if (isset($cPath_array) && in_array($counter, $cPath_array)) {
        //$categories_string .= '<strong>';
      //}

// display category name


      if ($tree[$counter]['name_suple']){
       $categories_a = $tree[$counter]['name_suple'];
}else{
    $categories_a = $tree[$counter]['name'];
}
        if (ereg("^https://", $tree[$counter]['name_http']) ) {
          $categories_string .=  '<b><font color="#FF6600">' . $categories_a . '</font></b>';
}else{
          $categories_string .=  $categories_a;

}
     if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '</strong>';
     }

     if (tep_has_category_subcategories($counter)) {
     $categories_string .= '-&gt;';
      }







         // si la fecha sobrepasa



       $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      //$oldday1 = date("Y-m-d", $time1);

                  if  ($tree[$counter]['productos'] == 0){
      $categoriestime_values = tep_db_query("select * from " . 'marketplace' . " where categories_productos = '" . 0 ."' and categories_id = '" . $tree[$counter]['id_categories'] ."'");

}else{

    $categoriestime_values = tep_db_query("select * from " . 'marketplace' . " where categories_time <= '" . $time1 ."' and categories_id = '" . $tree[$counter]['id_categories'] ."'");
}



if ($categoriestime = tep_db_fetch_array($categoriestime_values)){


  $products_in_category = tep_count_products_in_category($counter);

   if ($products_in_category == 0){
  $status_categories = 0;
}else{
   $status_categories = 1;
}
                // echo'sa';
           $sql_data_array = array('categories_time' => time()+rand(1,130000),
                                   'categories_productos' => tep_count_products_in_category($counter),
                                   'categories_status' => $status_categories, );

     tep_db_perform('marketplace', $sql_data_array, 'update', "categories_id = '" . $tree[$counter]['id_categories'] . "'");


                                      }

// $categories_string .= '&nbsp;(<label>' . $tree[$counter]['productos'] . '</label>)';




                    // si la fecha sobrepasa.



             $categories_string .= '</a>';



     if ($i>1) {
        $categories_string .= '</div>';
	  }







      //if (SHOW_COUNTS == 'true') {
        //$products_in_category = tep_count_products_in_category($counter);
        //if ($products_in_category > 0) {
          //$categories_string .= '&nbsp;';
        //}
      //}

      //$categories_string .= '<br>';
	  $categories_string .= '</div>';

      if ($tree[$counter]['next_id'] != false) {
        $this->tep_show_category($tree[$counter]['next_id']);
      }
    }

    function getData() {
      global $categories_string, $tree, $languages_id, $cPath, $cPath_array;

      $categories_string = '';
      $tree = array();

      $categories_query = tep_db_query("select c.categories_id, c.categories_productos, cd.categories_name_http, cd.categories_name, cd.categories_name_suple, c.categories_image, c.parent_id from " . 'marketplace' . " c, " . 'marketplace_description' . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and cd.categories_status_visible='" . 1 ."' order by sort_order, cd.categories_name");
      while ($categories = tep_db_fetch_array($categories_query))  {
        $tree[$categories['categories_id']] = array('name' => $categories['categories_name'],
                                                    'name_http' => $categories['categories_name_http'],
                                                    'name_suple' => $categories['categories_name_suple'],
                                                    'id_categories' => $categories['categories_id'],
                                                    'productos' => $categories['categories_productos'],
                                                    'parent' => $categories['parent_id'],
                                                    'level' => 0,
                                                    'image' => $categories['categories_image'],
                                                    'path' => $categories['categories_id'],
                                                    'next_id' => false);

        if (isset($parent_id)) {
          $tree[$parent_id]['next_id'] = $categories['categories_id'];
        }

        $parent_id = $categories['categories_id'];

        if (!isset($first_element)) {
          $first_element = $categories['categories_id'];
        }
      }

      if (tep_not_null($cPath)) {
        $new_path = '';
        reset($cPath_array);
        while (list($key, $value) = each($cPath_array)) {
          unset($parent_id);
          unset($first_id);
          $categories_query = tep_db_query("select c.categories_id, c.categories_productos, cd.categories_name_http, cd.categories_name, cd.categories_name_suple, c.categories_image, c.parent_id from " . 'marketplace' . " c, " . 'marketplace_description' . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and cd.categories_status_visible='" . 1 ."' order by sort_order, cd.categories_name");
          if (tep_db_num_rows($categories_query)) {
            $new_path .= $value;
            while ($row = tep_db_fetch_array($categories_query)) {
              $tree[$row['categories_id']] = array('name' => $row['categories_name'],
                                                    'name_http' => $row['categories_name_http'],
                                                    'name_suple' => $row['categories_name_suple'],
                                                   'id_categories' => $row['categories_id'],
                                                   'productos' => $row['categories_productos'],
                                                   'parent' => $row['parent_id'],
                                                   'level' => $key+1,
                                                   'image' => $categories['categories_image'],
                                                   'path' => $new_path . '_' . $row['categories_id'],
                                                   'next_id' => false);

              if (isset($parent_id)) {
                $tree[$parent_id]['next_id'] = $row['categories_id'];
              }

              $parent_id = $row['categories_id'];

              if (!isset($first_id)) {
                $first_id = $row['categories_id'];
              }

              $last_id = $row['categories_id'];
            }
            $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
            $tree[$value]['next_id'] = $first_id;
            $new_path .= '_';
          } else {
            break;
          }
        }
      }

      $this->tep_show_category($first_element);
              
        $infobox = new azInfoBox();
        $infobox->azSetBoxHeading(MARKETPLACE);
        $infobox->azSetBoxContent($categories_string);
        $infobox->azSetBoxFooter();
        $data = $infobox->azCreateBox('', '', '', '', false);

      return $data;
    }

    function execute() {
      global $SID, $oscTemplate;

      if ((USE_CACHE == 'true') && empty($SID)) {
        $output = tep_cache_categories_box();
      } else {
        $output = $this->getData();
      }

      $oscTemplate->addBlock($output, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_AZ_MARKETPLACE_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Categories Module', 'MODULE_BOXES_AZ_MARKETPLACE_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_AZ_MARKETPLACE_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_AZ_MARKETPLACE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_AZ_MARKETPLACE_STATUS', 'MODULE_BOXES_AZ_MARKETPLACE_CONTENT_PLACEMENT', 'MODULE_BOXES_AZ_MARKETPLACE_SORT_ORDER');
    }
  }
