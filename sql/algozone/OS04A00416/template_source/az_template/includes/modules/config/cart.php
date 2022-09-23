<?php
	$tmpl['txt']['banner_text1'] = AZ_BANNER_TEXT1;
	$tmpl['txt']['banner_text2'] = AZ_BANNER_TEXT2;
	$tmpl['txt']['banner_text3'] = AZ_BANNER_TEXT3;
	$tmpl['txt']['products'] = MENU_TEXT_PRODUCTS;
	
	$tmpl['url']['reviews'] = tep_href_link(FILENAME_REVIEWS);
	$tmpl['url']['prod_info'] = tep_href_link(FILENAME_PRODUCT_INFO);
	
	$tmpl['cfg']['left_column'] = false;
	$tmpl['cfg']['right_column'] = false;
	
	$side_boxes_query = tep_db_query("Select configuration_key From " . TABLE_CONFIGURATION . " Where configuration_key REGEXP '^MODULE_BOXES(.*)STATUS' and configuration_value = 'True'");
	if (tep_db_num_rows($side_boxes_query) > 0) {
		while ($side_box = tep_db_fetch_array($side_boxes_query)) {
			$config_key = str_replace('STATUS', 'CONTENT_PLACEMENT', $side_box['configuration_key']);
			$box_pos_query = tep_db_query("Select configuration_value From " . TABLE_CONFIGURATION . " Where configuration_key = '" . $config_key . "'");
			$box_pos = tep_db_fetch_array($box_pos_query);
			if(strtolower($box_pos['configuration_value']) == 'left column') {				
				$tmpl['cfg']['left_column'] = true;
			} else if(strtolower($box_pos['configuration_value']) == 'right column') {
				$tmpl['cfg']['right_column'] = true;
			}
		}
	}
	
	if (basename($_SERVER['PHP_SELF']) == FILENAME_DEFAULT && !isset($_REQUEST['cPath']) && !isset($_REQUEST['manufacturers_id'])) {
		$tmpl['cfg']['left_column'] = false;
		$tmpl['cfg']['right_column'] = false;
	}
	
	if($tmpl['cfg']['left_column'] && $tmpl['cfg']['right_column']) {
		$az_cols = '3';
	} else if(!$tmpl['cfg']['left_column'] && !$tmpl['cfg']['right_column']) {
		$az_cols = '1';
	} else if($tmpl['cfg']['left_column'] && !$tmpl['cfg']['right_column']) {
		$az_cols = '2a';
	} else if(!$tmpl['cfg']['left_column'] || $tmpl['cfg']['right_column']) {
		$az_cols = '2b';
	}
		
	$tmpl['cfg']['max_display_listing'] = '8';
	$tmpl['cfg']['info_image_width'] = '320';
	$tmpl['cfg']['info_image_height'] = '';
?>