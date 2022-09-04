<?php
/**
 * sociallogin module
 *
 * @package modules
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: meta_tags.php 11202 2008-11-23 09:18:34Z drbyte $
 */


//show socialsharing on BOTTOM
if($lrsetting['sharepos'] == "0"){
if((($current_page == "index.php") && ($lrsetting['sharehomepages'] == "on")) || (($current_page == "product_info.php")&&($lrsetting['shareproductpages'] == "on")) || (($current_page == "shopping_cart.php")&&($lrsetting['shareshoppingpages'] == "on")) || (($current_page == "product_reviews.php")&&($lrsetting['sharereviewspages'] == "on")) || ($lrsetting['shareallpages'] == "on")){
	echo $socialshare;
	}
	elseif(($lrsetting['sharehomepages'] == "")&&($lrsetting['shareproductpages'] == "")&&($lrsetting['sharereviewspages'] == "")&&($lrsetting['shareshoppingpages'] == "")){
		echo $socialshare;
		}	
}
//show socialcounter on BOTTOM
if($lrsetting['counterpos'] == "0"){
if((($current_page == "index.php") && ($lrsetting['counterhomepages'] == "on")) || (($current_page == "product_info.php")&&($lrsetting['counterproductpages'] == "on")) || (($current_page == "shopping_cart.php")&&($lrsetting['countershoppingpages'] == "on")) || (($current_page == "product_reviews.php")&&($lrsetting['counterreviewspages'] == "on")) || ($lrsetting['counterallpages'] == "on")){
	echo $socialcounter;
	}
	elseif(($lrsetting['counterhomepages'] == "")&&($lrsetting['counterproductpages'] == "")&&($lrsetting['countershoppingpages'] == "")&&($lrsetting['counterreviewspages'] == "")){
		echo $socialcounter;
		}	
}	

?>