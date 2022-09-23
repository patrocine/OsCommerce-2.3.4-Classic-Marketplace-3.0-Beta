<?php
/*
  $Id: categories.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  function tep_show_category($cid, $cpath) {
    global $categories_string, $languages_id;
	
	$categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $cid . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
	
	if (tep_db_num_rows($categories_query) > 0) {
	  if($cid == 0) {
	    $categories_string .= '<ul id="az_category_menu">' . "\n";
	  } else {
	    $categories_string .= '<ul>' . "\n";
		$categories_string .= '<li class="az_catmenu_top">&nbsp;</li>' . "\n";
	  }
	  
	  while ($categories = tep_db_fetch_array($categories_query)) {
	    if($categories['parent_id'] > 0) $cPath_new = $cpath . '_' . $categories['categories_id'];
		else $cPath_new = 'cPath=' . $categories['categories_id'];
	
		if(tep_has_category_subcategories($categories['categories_id'])) {
		  $categories_string .= '<li>' . "\n";
		  if($categories['parent_id'] > 0) {
		    $categories_string .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '"><span>&raquo;</span>' . $categories['categories_name'] . '</a>' . "\n";
		  } else {
		    $categories_string .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . $categories['categories_name'] . '</a>' . "\n";
		  }
		  
		  tep_show_category($categories['categories_id'], $cPath_new);
		  
		  $categories_string .= '</li>' . "\n";
		} else {
		  $categories_string .= '<li><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . $categories['categories_name'] . '</a></li>' . "\n";
		}
	  }  
	  if($cid != 0) {
        $categories_string .= '<li class="az_catmenu_bottom"></li>' . "\n";  
      }
	  if($cid == 0) {
	    $categories_string .= '</ul>';
	  } else {
		$categories_string .= '</ul>';
	  }
	}
  }
?>
<!-- categories //-->
<div id="az_category_menu_wrapper">
<?php
$categories_string = '';
tep_show_category(0,'');
echo $categories_string;
?>
</div>
<div class="clear"></div>
<!-- categories_eof //-->
