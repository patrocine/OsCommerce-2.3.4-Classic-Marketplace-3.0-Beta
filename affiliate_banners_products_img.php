<?php
  require('includes/configure.php');
   require(DIR_WS_FUNCTIONS . 'database.php');
  tep_db_connect() or die('Unable to connect to database server!');

   $products_id = $_GET['products_id'];
$query = mysql_query("SELECT * FROM `products` WHERE  products_id = '" . $products_id . "'");
if ($products = mysql_fetch_array($query)){

   $pic = HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $products['products_image'];

    } //patrocine


   $fp=fopen($pic,"r");
			if (!$fp) exit();
   $img_type=substr($banner,strrpos($banner,".")+1);
			$pos=strrpos($banner,"/");
			if ($pos) $img_name=substr($banner,strrpos($banner,"/")+1);
  	else $img_name=$banner;
  	header ("Content-type: image/$img_type");
			header ("Content-Disposition: inline; filename=$img_name");
			fpassthru($fp);
			fclose ($fp);
			exit();

?>

