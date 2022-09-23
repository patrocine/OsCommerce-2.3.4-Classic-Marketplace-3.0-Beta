<?php
/*
  $Id: var_map.php,v 1.0 17:37:59 07/07/2009  

  osCommerce functions mappings (connection) class for AlgoZone templates

  Copyright (c) 2009 AlgoZone, Inc (www.algozone.com)

*/

function az_href_link($page, $parameters = '', $connection = '', $add_session_id = '', $search_engine_safe = '') {
	global $request_type, $session_started, $SID;
	return tep_href_link($page, $parameters, $connection, $add_session_id, $search_engine_safe); 
}  

function az_image($src, $alt = '', $width = '', $height = '', $parameters = '') {
	return tep_image($src, $alt, $width, $height, $parameters);
}

function az_draw_image_submit_button ($title, $bnum, $params) {
	$image_submit = '<button class="az-template-submit" title="' . tep_output_string($title) . '" type="submit">';
	$image_submit .= '<span class="az-button-left'.$bnum.'">&nbsp;</span>';
	$image_submit .= '<span class="az-button-middle'.$bnum.'"'.(empty($params)?'':' '.$params).'><span class="az-button-text">'.tep_output_string($title).'</span></span>';
	$image_submit .= '<span class="az-button-right'.$bnum.'">&nbsp;</span>';
	$image_submit .= '</button>';
	return $image_submit;
}

function az_draw_image_button($title, $bnum, $params) {
	$image_button = '<span class="az-template-button" title="' . tep_output_string($title) . '">';
	$image_button .= '<span class="az-button-left'.$bnum.'">&nbsp;</span>';
	$image_button .= '<span class="az-button-middle'.$bnum.'"'.(empty($params)?'':' '.$params).'><span class="az-button-text">' . tep_output_string($title) .'</span></span>';
	$image_button .= '<span class="az-button-right'.$bnum.'">&nbsp;</span></span>';
	return $image_button;
}

function az_short_text($text, $limit='20') {
	$str = strlen($text) > $limit ? substr(strip_tags($text), 0, $limit) . '&hellip;' : strip_tags($text);
	return $str;
}

function az_get_products_desc($product_id, $language = '') {
	global $languages_id;

	if (empty($language)) $language = $languages_id;

	$product_query = tep_db_query("select products_description from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language . "'");
	$product = tep_db_fetch_array($product_query);
			
	return $product['products_description'];
}

function az_get_products_rating($products_id) {
    $rating = '';
    $review_query = tep_db_query(
        "SELECT
            ROUND(SUM(`reviews_rating`)/COUNT(`reviews_id`)) as rating
         FROM
            " . TABLE_REVIEWS . "
         WHERE
            products_id = '" . (int)$products_id . "'
            AND `reviews_status` = 1");
	$review = tep_db_fetch_array($review_query);
    if ( !empty($review['rating'])  )
        $rating = tep_image(DIR_WS_IMAGES . 'stars_' . $review['rating'] . '.gif' , sprintf(AZ_TEXT_OF_5_STARS, $review['rating']));

    return $rating ;
}

function az_get_image_size($src, $width, $height) {
  if ( empty($width) || empty($height) ) {
    if ($image_size = @getimagesize($src)) {
      if (empty($width) && !empty($height)) {
        $ratio = $height / $image_size[1];
        $width = intval($image_size[0] * $ratio);
      } elseif (!empty($width) && empty($height)) {
        $ratio = $width / $image_size[0];
        $height = intval($image_size[1] * $ratio);
      } elseif (empty($width) && empty($height)) {
        $width = $image_size[0];
        $height = $image_size[1];
      }
    }
  }
	
  return array($width, $height);
}

function az_change_format($price) {
	global $az_curSymbol, $az_newSymbol;
	return '<span class="az_productPrice">'.str_replace($az_curSymbol, $az_newSymbol, $price).'</span>';	
}