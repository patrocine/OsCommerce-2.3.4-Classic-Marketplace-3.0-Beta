<?php
/*
  $Id: manufacturers.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  //$manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name, manufacturers_image from " . TABLE_MANUFACTURERS . " order by manufacturers_name LIMIT 5");
  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name, manufacturers_image from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  if ($number_of_rows = tep_db_num_rows($manufacturers_query)) {
?>
<!-- manufacturers //-->
<?php
	$brand_x = 0;
    $manufacturers_list = '<div><ul class="az_brand_list_start">';
    while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
	  if(!empty($manufacturers['manufacturers_image'])) {
		$manufacturers_list .= '<li><a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . tep_image(DIR_WS_IMAGES . $manufacturers['manufacturers_image'], $manufacturers['manufacturers_name'], '110', '', '') . '</a></li>';
	  } else {
	    $manufacturers_list .= '<li><a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . tep_image(DIR_WS_IMAGES . 'no_picture.gif', $manufacturers['manufacturers_name'], '110', '', '') . '</a></li>';
	  }
	  
	  $brand_x ++;
	  if( $brand_x == 5 ) {
	    $manufacturers_list .= '</ul><div class="clear"></div></div>';
		$manufacturers_list .= '<div><ul>';
	  }
    }
	$manufacturers_list .= '</ul><div class="clear"></div></div>';
	
	echo $manufacturers_list;
?>
<!-- manufacturers_eof //-->
<?php
  }
?>
