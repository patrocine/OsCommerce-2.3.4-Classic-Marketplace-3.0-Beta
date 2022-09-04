<?php	
	require('includes/application_top.php');
	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('Content-Type: text/xml');	
	$response="<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";	

	$response= "<CART>";
	$response.= "<CARTLIST>";
	$products = $cart->get_products();
	for ($i=0, $n=sizeof($products); $i<$n; $i++)
	{
		$response .= "<ITEM>";	
				$response .= "<NAME>".htmlspecialchars($products[$i]['name'])."</NAME>";	
				$response .= "<LINK>".htmlspecialchars(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']))."</LINK>";	
				$response .= "<IMAGE>".htmlspecialchars(DIR_WS_IMAGES . $products[$i]['image'])."</IMAGE>";	
				$response .= "<QTY>".htmlspecialchars($products[$i]['quantity'])."</QTY>";
				$response .= "<PRICE>". htmlspecialchars($currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity'])) ."</PRICE>";	
		$response .= "</ITEM>";
	}	
	$response .= "</CARTLIST>";
	$response .= "<TOTAL>".htmlspecialchars($currencies->format($cart->show_total()))."</TOTAL>";
	$response .= "</CART>";
	
	echo $response;


?>
