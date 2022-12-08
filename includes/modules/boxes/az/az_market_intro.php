<?php
    function tep_show_marketplace($counter) {
      global $tree, $categories_string, $cPath_array;

      if($tree[$counter]['level'] > 0){
		$categories_string .= '<div class="categ_nav level_3">';
	  }else{
		$categories_string .= '<div class="level_2">';
        
      }
    
      for ($i=0; $i<$tree[$counter]['level']; $i++) {
         
      }


      if (isset($cPath_array) && in_array($counter, $cPath_array)) {
        $categories_string .= '<div class="active_item">';
      }


      $categories_string .= '<a class="categ_nav" href="';

      if ($tree[$counter]['parent'] == 0) {
        $cPath_new = 'cPath=' . $counter;
      } else {
        $cPath_new = 'cPath=' . $tree[$counter]['path'];
      }

      $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">';

      $categories_string .= $tree[$counter]['name'];


      $categories_string .= '</a>';
	  
	  if (isset($cPath_array) && in_array($counter, $cPath_array)) {
        $categories_string .= '</div>';
      }

	  $categories_string .= '</div>';

      if ($tree[$counter]['next_id'] != false) {
        $this->tep_show_marketplace($tree[$counter]['next_id']);
      }
    }

    function getDataa() {
      global $categories_string, $tree, $languages_id, $cPath, $cPath_array;

      $categories_string = '';
      $tree = array();

      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . 'marketplace' . " c, " . 'marketplace_description' . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
      while ($categories = tep_db_fetch_array($categories_query))  {
        $tree[$categories['categories_id']] = array('name' => $categories['categories_name'],
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
          $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . 'marketplace' . " c, " . 'marketplace_description' . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
          if (tep_db_num_rows($categories_query)) {
            $new_path .= $value;
            while ($row = tep_db_fetch_array($categories_query)) {
              $tree[$row['categories_id']] = array('name' => $row['categories_name'],
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

      $this->tep_show_marketplace($first_element);
    }
	  echo $categories_string;
   

   
   

   

   

    
