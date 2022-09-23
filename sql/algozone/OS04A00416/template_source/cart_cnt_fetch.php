<?php	
	require('includes/application_top.php');
	$navigation->remove_current_page();
	
	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	if ( defined('CHARSET') ) {
	  header('Content-Type: text/xml; charset='.CHARSET);
	  $response='<?xml version="1.0" encoding="'.CHARSET.'"?>';	
	}else{
	  header('Content-Type: text/xml; charset=iso-8859-1');
	  $response='<?xml version="1.0" encoding="iso-8859-1"?>';	
	}

	$response .= "<cart>";
	$response .= "<cartlist>";
	$products = $cart->get_products();
	for ($i=0, $n=sizeof($products); $i<$n; $i++)
	{
		$response .= "<item>";	
				$response .= "<name><![CDATA[".$products[$i]['name']."]]></name>";	
				$response .= "<link><![CDATA[".tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id'])."]]></link>";	
				$response .= "<image><![CDATA[".DIR_WS_IMAGES . $products[$i]['image']."]]></image>";	
				$response .= "<qty><![CDATA[".$products[$i]['quantity']."]]></qty>";
				$response .= "<price><![CDATA[".$currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) ."]]></price>";	
		$response .= "</item>";
	}	
	$response .= "</cartlist>";
	$response .= "<total><![CDATA[".$currencies->format($cart->show_total())."]]></total>";
	$response .= "</cart>";
	
	echo $response;
?>
