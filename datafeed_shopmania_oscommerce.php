<?php

##########################################################################################
# In order to be able to use this script you need to join the merchant program depending on the country where your store is selling the products
#
# AUSTRALIA - http://shopmania.com.au/ (only supporting AUD, NZD datafeeds)
# ARGENTINA - http://www.shopmania.com.ar/ (only supporting ARS, EUR, USD)       *NEW
# BRASIL - http://www.shopmania.com.br/ (only supporting BRL, USD) 
# BULGARY - http://www.shopmania.bg/ (only supporting BGN, EUR, USD)
# CZECH REPUBLIC - http://www.shop-mania.cz/ (only supporting CZK, EUR, USD)		*NEW
# CHILE - http://www.shopmania.cl/ (only supporting CLP, USD, EUR)       *NEW
# CHINA - http://www.shopmania.cn/ (only supporting CNY, USD)       
# DEUTSCHLAND - http://www.shopmania.de/ (only supporting EUR, USD) 
# FRANCE - http://www.shopmania.fr/ (only supporting EUR, USD datafeeds)
# HUNGARY - http://www.shopmania.hu/ (only supporting HUF, EUR, USD datafeeds)
# INDIA - http://www.shopmania.in/ (only supporting INR, USD datafeeds)
# IRELAND - http://www.shopmania.ie/ (only supporting EUR, GBP datafeeds)
# ITALY - http://www.shopmania.it/ (only supporting EUR, USD datafeeds)
# JAPAN - http://www.shopmania.jp/  (only supporting JPY, USD datafeeds)       
# MEXICO - http://www.shopmania.com.mx/ (only supporting MXN (Mexican peso), USD, EUR datafeeds)
# NETHERLANDS - http://www.shopmania.nl/ (only supporting EUR datafeeds)		*NEW
# POLSKA - http://www.shopmania.pl/ (only supporting PLN, EUR, USD) 
# PORTUGAL - http://www.shopmania.pt/ (only supporting EUR, USD) 
# ROMANIA - http://www.shopmania.ro/ (only supporting RON, EUR, USD datafeeds)
# RUSSIA - http://www.shopmania.ru/ (only supporting RUB, EUR, USD)       
# SERBIA - http://www.shopmania.rs/ (only supporting RSD, EUR)		*NEW	
# SLOVAKIA - http://www.shop-mania.sk/ (only supporting EUR, USD)
# SOUTH AFRICA - http://www.shopmania.co.za/ (only supporting ZAR, USD, EUR)       *NEW
# SPAIN - http://www.shopmania.es/ (only supporting EUR datafeeds) 
# SWEDEN - http://www.shopmania.se/ (only supporting SEK, EUR, USD datafeeds)		*NEW
# TURKEY - http://www.shopmania.com.tr/ (only supporting TRY, EUR, USD)
# US - http://www.shopmania.com/ (only supporting USD, CAD datafeeds)
# UK - http://www.shopmania.co.uk/ (only supporting GBP, EUR, USD datafeeds)
#
# Once you join the program and your application is approved you need to place the file on your server and set up the path to the file on the Merchant Interface
# Files will be  retrieved daily from your server having the products listed automatically on ShopMania
# 
# 
# Options
# @url_param taxes=on (on,off) 
# @url_param storetaxes=on (on,off) 
# @url_param discount=on (on,off) 
# @url_param add_vat=off (on,off) 
# @url_param vat_value=24 (VAT_VALUE) 
# @url_param shipping=off (on,off) 
# @url_param add_tagging=on (on,off) 
# @url_param tagging_params=&utm_source=shopmania&utm_medium=cpc&utm_campaign=direct_link (TAGGING_PARAMS) 
# @url_param description=on (on,off) 
# @url_param image=on (on,off) 
# @url_param specialprice=on (on,off) 
# @url_param sef=off (on,off) 
# @url_param on_stock=off (on,off) 
# @url_param forcepath=off (on,off) 
# @url_param forcefolder= (FORCEFOLDER) 
#
# 
##########################################################################################

// Current datafeed script version
$script_version = "1.22";

// Print current Script version
if (@$_GET['get'] == "version") {
	echo "<b>Datafeed osCommerce 2</b> <br />";
	echo "version <b>" . $script_version . "</b><br />";
	exit;
}

//session_start();

// Se no time limit only if php is not in Safe Mode
if (!ini_get("safe_mode")) {
	set_time_limit(0);
}
ignore_user_abort();
error_reporting(E_ALL^E_NOTICE);
$_SVR = array();

# If you use a default configuration you need to do place this file in your /catalog/ directory. 
# Otherwise if you place this file in another directory please modify the line below with the path to the catalog directory. 

##### Include configuration files ################################################

$site_base_path = "./";

// Include required files
if(file_exists($site_base_path . "includes/shared.inc.php")) {
	require($site_base_path . "includes/shared.inc.php");
}

if(!file_exists($site_base_path . "includes/application_top.php")) {
	exit('<HTML><HEAD><TITLE>404 Not Found</TITLE></HEAD><BODY><H1>Not Found</H1>Please ensure that datafeed_shopmania_oscommerce.php is in the catalog directory, or make sure the path to the catalog directory is defined corectly above in $catalog_path variable</BODY></HTML>');
}
else {
	require($site_base_path . "includes/application_top.php");
}

####################################################################


# Once all is set up you need to check the result and make sure the output is correct
# Point the browser to http://www.example.com/path_to_datafeed/shopmania_datafeed.php and look into the source code of the out put
# What you need to see is something like this
# Category | Manufacturer | Part Number | Merchant Code | Product Name | Product Description | Product URL | Product Image URL | Product Price | Currency | Shipping Price | Availability | GTIN (UPC/EAN/ISBN)  

##### Avoid any modifications below this line #####

// Datafeed specific settings
$datafeed_separator = "|"; // Possible options are \t or |


##### Extract params from url ################################################

$apply_taxes = (@$_GET['taxes'] == "off") ? "off" : "on";
$apply_storetaxes = (@$_GET['storetaxes'] == "off") ? "off" : "on";
$apply_discount = (@$_GET['discount'] == "off") ? "off" : "on";
$add_vat = (@$_GET['add_vat'] == "on") ? "on" : "off";
$vat_value = (@$_GET['vat_value'] > 0) ? ((100 + $_GET['vat_value']) / 100) : 1.24; // default value
$add_shipping = (@$_GET['shipping'] == "off") ? "off" : "on";
$add_availability = (@$_GET['availability'] == "off") ? "off" : "on";
$add_gtin = (@$_GET['gtin'] == "off") ? "off" : "on";
$add_tagging = (@$_GET['add_tagging'] == "off") ? "off" : "on";
$tagging_params = (@$_GET['tagging_params'] != "") ? urldecode($_GET['tagging_params']) : "utm_source=shopmania&utm_medium=cpc&utm_campaign=direct_link";
$show_description = (@$_GET['description'] == "off") ? "off" : ((@$_GET['description'] == "limited") ? "limited" : "on");
$show_image = (@$_GET['image'] == "off") ? "off" : "on";
$show_specialprice = (@$_GET['specialprice'] == "off") ? "off" : "on";
$sef = (@$_GET['sef'] == "on") ? "on" : "off";
$on_stock_only = (@$_GET['on_stock'] == "on") ? "on" : "off";
$language_code = (@$_GET['language'] != "") ? $_GET['language'] : "";
$language_id = (@$_GET['language_id'] != "") ? $_GET['language_id'] : "";
$currency = (@$_GET['currency'] != "") ? $_GET['currency'] : "";
$display_currency = (@$_GET['display_currency'] != "") ? $_GET['display_currency'] : "";
$force_path = (@$_GET['forcepath'] == "on") ? "on" : "off";
$use_path = (@$_GET['usepath'] != "") ? $_GET['usepath'] : "";
$force_folder = (@$_GET['forcefolder'] != "") ? $_GET['forcefolder'] : "";
$use_compression = (@$_GET['compression'] == "on") ? "on" : "off";
$limit = (@$_GET['limit'] != "") ? $_GET['limit'] : "";


####################################################################

if ($use_compression == "on") {
	// Start compressing
	smfeed_compression_start();
}

// Print URL options
if (@$_GET['get'] == "options") {
	$script_basepath = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	
	echo "<b>Datafeed osCommerce 2</b> <br />";
	echo "version <b>" . $script_version . "</b><br /><br /><br />";
		
	echo "<b>Taxes options</b> - possible values on, off default value on<br />";
	echo "taxes=on (on,off) <a href=\"" . $script_basepath . "?taxes=off" . "\" >" . $script_basepath . "?taxes=off" . "</a><br /><br />";
	
	echo "<b>Store taxes options</b> - possible values on, off default value on<br />";
	echo "storetaxes = on (on,off) <a href=\"" . $script_basepath . "?storetaxes=off" . "\" >" . $script_basepath . "?storetaxes=off" . "</a><br /><br />";
	
	echo "<b>Discount options</b> - possible values on, off default value on<br />";
	echo "discount=on (on,off) <a href=\"" . $script_basepath . "?discount=off" . "\" >" . $script_basepath . "?discount=off" . "</a><br /><br />";
	
	echo "<b>Add VAT to prices</b> - possible values on, off default value off<br />";
	echo "add_vat=off (on,off) <a href=\"" . $script_basepath . "?add_vat=on" . "\" >" . $script_basepath . "?add_vat=on" . "</a><br /><br />";
		
	echo "<b>VAT value</b> - possible values percent value default value 24  - interger or float number ex 19 or 19.5<br />";
	echo "vat_value=24 (VAT_VALUE) <a href=\"" . $script_basepath . "?add_vat=on&vat_value=19" . "\" >" . $script_basepath . "?add_vat=on&vat_value=19" . "</a><br /><br />";
		
	echo "<b>Add shipping to datafeed</b> - possible values on, off default value on<br />";
	echo "shipping=on (on,off) <a href=\"" . $script_basepath . "?shipping=off" . "\" >" . $script_basepath . "?shipping=off" . "</a><br /><br />";
	
	echo "<b>Add availability to datafeed</b> - possible values on, off default value on<br />";
	echo "availability=on (on,off) <a href=\"" . $script_basepath . "?availability=off" . "\" >" . $script_basepath . "?add_availability=off" . "</a><br /><br />";
	
	//echo "<b>Add GTIN to datafeed</b> - possible values on, off default value on<br />";
	//echo "gtin=on (on,off) <a href=\"" . $script_basepath . "?gtin=off" . "\" >" . $script_basepath . "?gtin=off" . "</a><br /><br />";
	
	echo "<b>Add GA Tagging to product URL</b> - possible values on, off default value on<br />";
	echo "add_tagging=on (on,off) <a href=\"" . $script_basepath . "?add_tagging=off" . "\" >" . $script_basepath . "?add_tagging=off" . "</a><br /><br />";
	
	echo "<b>Add custom Tagging to product URL</b> - possible values url_encode(TAGGING_PARAMS) default value tagging_params=utm_source=shopmania&utm_medium=cpc&utm_campaign=direct_link<br />";
	echo "tagging_params=utm_source=shopmania&utm_medium=cpc&utm_campaign=direct_link (TAGGING_PARAMS) <a href=\"" . $script_basepath . "?tagging_params=from%3Dshopmania" . "\" >" . $script_basepath . "?tagging_params=from%3Dshopmania" . "</a><br /><br />";
	
	echo "<b>Display Description options</b> - possible values on, off, limited default value on<br />";
	echo "description=on (on,off) <ul><li><a href=\"" . $script_basepath . "?description=off" . "\" >" . $script_basepath . "?description=off" . "</a></li>";
	echo "<li><a href=\"" . $script_basepath . "?description=limited" . "\" >" . $script_basepath . "?description=limited" . "</a></li></ul>";

	echo "<b>Display image options</b> - possible values on, off default value on<br />";
	echo "image=on (on,off) <a href=\"" . $script_basepath . "?image=off" . "\" >" . $script_basepath . "?image=off" . "</a><br /><br />";
	
	echo "<b>Special price options</b> - possible values on, off default value on<br />";
	echo "specialprice=on (on,off) <a href=\"" . $script_basepath . "?specialprice=off" . "\" >" . $script_basepath . "?specialprice=off" . "</a><br /><br />";
	
	echo "<b>Show only on stock products</b> - possible values on, off default value on<br />";
	echo "on_stock=on (on,off) <a href=\"" . $script_basepath . "?on_stock=off" . "\" >" . $script_basepath . "?on_stock=off" . "</a><br /><br />";
	
	echo "<b>Get prices in specified currency</b> - possible values USD,EUR etc. <br />";
	echo "currency=DEFAULT_CURRENCY <a href=\"" . $script_basepath . "?currency=EUR" . "\" >" . $script_basepath . "?currency=EUR" . "</a><br /><br />";
	
	echo "<b>Get texts in specified language code</b> - possible values en,de etc. <br />";
	echo "language=DEFAULT_LANGUAGE_CODE <a href=\"" . $script_basepath . "?language=en" . "\" >" . $script_basepath . "?language=en" . "</a><br /><br />";
	
	echo "<b>Get texts in specified language id</b> - possible values 1,2 etc. <br />";
	echo "language_id=DEFAULT_LANGUAGE_ID <a href=\"" . $script_basepath . "?language_id=1" . "\" >" . $script_basepath . "?language_id=1" . "</a><br /><br />";
	
	echo "<b>Limit displayed products</b> - possible values integer (start,step)<br />";
	echo "limit=no_limit <a href=\"" . $script_basepath . "?limit=0,10" . "\" >" . $script_basepath . "?limit=0,10" . "</a><br /><br />";
		
	echo "<b>Add basepath to product URL</b> - possible values on, off default value off<br />";
	echo "forcepath=off (on,off) <a href=\"" . $script_basepath . "?forcepath=on" . "\" >" . $script_basepath . "?forcepath=on" . "</a><br /><br />";
	
	echo "<b>Usepath - force defined basepath to product URL</b> - possible values ex: www.site.com<br />";
	echo "usepath=BASEPATH <a href=\"" . $script_basepath . "?forcepath=on&usepath=www.site.com" . "\" >" . $script_basepath . "forcepath=on&usepath=www.site.com" . "</a><br /><br />";
	
	echo "<b>Use compression</b> - possible values on, off default value on<br />";
	echo "compression=on (on,off) <a href=\"" . $script_basepath . "?compression=off" . "\" >" . $script_basepath . "?compression=off" . "</a><br /><br />";
	
	echo "<b>Display currency code</b> - force the display of certain currency code possible values USD,EUR etc. <br />";
	echo "display_currency=DEFAULT_CURRENCY <a href=\"" . $script_basepath . "?display_currency=EUR" . "\" >" . $script_basepath . "?display_currency=EUR" . "</a><br /><br />";
		
	exit;
}

##### Extract options from database ################################################

if (@$_GET['currency'] != "") {
	$row_currency['configuration_value'] = $_GET['currency'];
}
else {
	// Detect default currency
	$query_currency = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'DEFAULT_CURRENCY'");
	$row_currency = tep_db_fetch_array( $query_currency );
}

// Get default currency value
$query_currency_rate = tep_db_query("SELECT * FROM " . TABLE_CURRENCIES . " WHERE code = '" . addslashes($row_currency['configuration_value']) . "'");
$row_currency_rate = tep_db_fetch_array( $query_currency_rate );

if (strpos(strtolower($row_currency_rate['symbol_right']), "ron") !== false || strpos(strtolower($row_currency_rate['symbol_right']), "lei") !== false) {
	$datafeed_currency = "RON";
}
else {
	$datafeed_currency = $row_currency['configuration_value'];
}

// Force displayed currency
$datafeed_currency = ($display_currency != "") ? $display_currency : $datafeed_currency;

if ($language_id > 0) {
	// Set the main language
	$main_language = $language_id;
}
elseif ($language_code != "") {
	// Detect default language ID
	$query_language_id = tep_db_query("SELECT languages_id FROM " . TABLE_LANGUAGES . " WHERE code = '" . addslashes($language_code) . "'");
	$row_language_id = tep_db_fetch_array( $query_language_id );
	
	// Set the main language
	$main_language = $row_language_id['languages_id'];
}
else {
	// Detect default language code
	$query_language_code = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'DEFAULT_LANGUAGE'");
	$row_language_code = tep_db_fetch_array( $query_language_code );

	// Detect default language ID
	$query_language_id = tep_db_query("SELECT languages_id FROM " . TABLE_LANGUAGES . " WHERE code = '" . addslashes($row_language_code['configuration_value']) . "'");
	$row_language_id = tep_db_fetch_array( $query_language_id );

	// Set the main language
	$main_language = $row_language_id['languages_id'];
}

// Get flat shipping value if set
$shipping_flat_value = (strtolower(MODULE_SHIPPING_FLAT_STATUS) == "true") ? MODULE_SHIPPING_FLAT_COST : "";

// Get all categories
$categories_query = tep_db_query("SELECT * 
FROM (" . TABLE_CATEGORIES . ") 
LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " ON ( " . TABLE_CATEGORIES_DESCRIPTION . ".categories_id = " . TABLE_CATEGORIES . ".categories_id AND " . TABLE_CATEGORIES_DESCRIPTION . ".language_id = '" . addslashes($main_language) . "')"
);

// Build categories array
while( $row_cat = tep_db_fetch_array( $categories_query ) ) {
	foreach ($row_cat as $i=>$v) {
		$CAT_ARR[$row_cat['categories_id']][$i] = $v;
	}
}

######################################################################


##### Extract products from database ###############################################

// Get products
$image_field = ($show_image == "on") ? "prd.products_image" : "''";
$description_field = ($show_description != "off") ? "prdsc.products_description" : "''";

// Build stock condition
//$on_stock_cond = ($on_stock_only == "on" || (STOCK_CHECK == "true" &&  STOCK_ALLOW_CHECKOUT == "false")) ? "AND prd.products_quantity > 0" : "";
$on_stock_cond = ($on_stock_only == "on") ? " AND prd.products_quantity > 0" : "";

// Build limit filter
if ($limit != "") {
	$limit_arr = explode(",", $limit);
	$limit_cond = ($limit_arr[0] >= 0 && @$limit_arr[1] > 0) ? " LIMIT " . $limit_arr[0] . "," . @$limit_arr[1] : (($limit_arr[0] > 0) ? " LIMIT 0," . $limit_arr[0] : "");
}
else {
	$limit_cond = "";
}

$products_query = tep_db_query("SELECT
manuf.manufacturers_name AS manufacturer,
prd.products_id AS id,
prd.products_id AS mpc,
prd.products_model AS mpn,
prd.products_quantity AS quantity,
prdsc.products_name AS name,
" . $description_field . " AS description,
prd.products_price AS price,
prd.products_tax_class_id,
" . $image_field . " AS products_image,
prdtocat.categories_id
FROM (" . TABLE_PRODUCTS . " prd,
" . TABLE_PRODUCTS_DESCRIPTION . " AS prdsc,
" . TABLE_PRODUCTS_TO_CATEGORIES . " AS prdtocat)
LEFT JOIN " . TABLE_MANUFACTURERS . " AS manuf ON ( manuf.manufacturers_id = prd.manufacturers_id )
WHERE ( prd.products_id = prdsc.products_id AND prdsc.language_id = '" . addslashes($main_language) . "' )
AND prd.products_id = prdtocat.products_id
AND prd.products_status = 1
" . addslashes($on_stock_cond) . "
ORDER BY prd.products_id ASC, prdtocat.categories_id DESC" . addslashes($limit_cond));

// Check for any applicable specials for the corresponding products_id
$specials_query = tep_db_query("SELECT
" . TABLE_SPECIALS . ".products_id AS idS,
" . TABLE_SPECIALS . ".specials_new_products_price AS priceS
FROM " . TABLE_SPECIALS . ",
" . TABLE_PRODUCTS . "
WHERE " . TABLE_SPECIALS . ".products_id = " . TABLE_PRODUCTS . ".products_id
AND " . TABLE_SPECIALS . ".status = 1 
AND " . TABLE_PRODUCTS . ".products_status = 1");

while( $row_s = tep_db_fetch_array( $specials_query ) ) {
	foreach ($row_s as $i=>$v) {
		$SPECIALS[$row_s['idS']][$i] = $v;
	}
}

###################################################################


##### Print product data ####################################################

$current_id = 0;

// Print the products
while( $row = tep_db_fetch_array( $products_query ) )
{
	// If we've sent this one, skip the rest - this is to ensure that we do not get duplicate products
	$prod_id = $row['id'];
	
	if ($current_id == $prod_id) {
		continue;
	}
	else {
		$current_id = $prod_id;
	}
	
	// Clean description
	$row['description'] = smfeed_clean_description($row['description']);
	
	// Limit description size
	if ($show_description == "limited") {
		$row['description'] = strip_tags($row['description']);
		$row['description'] = substr($row['description'], 0, 250);
	}

	// Get product url
	$row['product_url'] = tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $row['id'], 'NONSSL', false);
		
	// Add basepath if not included
	if (preg_match("/(http|https)\:\/\//", $row['product_url'])) {
		// Continue
	}
	elseif ($force_path == "on") {
		// Use basepath
		$basepath = ($use_path != "") ? $use_path : $_SERVER['HTTP_HOST'];
		$row['product_url'] = "http://" . $basepath . "/" . $row['product_url'];
	}
	elseif (preg_match("/(http|https)\:\/\//", DIR_WS_CATALOG)) {
		$row['product_url'] = DIR_WS_CATALOG . $row['product_url'];
	}
	else {
		$row['product_url'] = "http://" . $_SERVER['HTTP_HOST'] . DIR_WS_CATALOG . $row['product_url'];
	}
	
	// Add GA Tagging parameters to url
	if ($add_tagging == "on") {
		$and_param = (preg_match("/\?/", $row['product_url'])) ? "&" : "?";
		$row['product_url'] = $row['product_url'] . $and_param . $tagging_params;
	}
	
	// Get image url
	if($row['products_image'] != "") {
		
		if (preg_match("/http\:\/\//", $row['products_image'])) {
			$row['image_url'] = $row['products_image'];
		}
		elseif (preg_match("/http\:\/\//", DIR_WS_IMAGES)) {
			$row['image_url'] = DIR_WS_IMAGES . $row['products_image'];
		}
		elseif (preg_match("/http\:\/\//", DIR_WS_CATALOG)) {
			$row['image_url'] = DIR_WS_CATALOG . DIR_WS_IMAGES . $row['products_image'];
		}
		else {
			$row['image_url'] = HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $row['products_image'];
		}		
	}
	else {
		$row['image_url'] = "";
	}
	
	// Reset the products price to our special price if there is one for this product
	if (($show_specialprice == "on") && ($new_price = tep_get_products_special_price($row['id']))) {
		$row['price'] = $new_price;
	}
	elseif(($apply_special == "on") && $SPECIALS[$row['id']]['idS']){
		$row['price'] = $SPECIALS[$row['id']]['priceS'];
	}
	
	// Include tax - if this is not working corectly simply comment the following lines and you will have the prices without the tax included
	if ($apply_taxes == "on" && (DISPLAY_PRICE_WITH_TAX == "true") && ($row['products_tax_class_id'] > 0) ) {
		$row['price'] = $row['price'] + ( ( $row['price'] * tep_get_tax_rate($row['products_tax_class_id']) ) / 100 );
    }
  
	// Clean product name (new lines)	
	$row['name'] = str_replace("\n", " ", strip_tags($row['name']));		
	$row['name'] = str_replace("\r", "", strip_tags($row['name']));
	$row['name'] = str_replace("\t", " ", strip_tags($row['name']));
	
	// Clean product description (Replace new line with <BR>). In order to make sure the code does not contains other HTML code it might be a good ideea to strip_tags()	
   	$row['description'] = smfeed_replace_not_in_tags("\n", "<BR />", $row['description']);
	$row['description'] = str_replace("\n", " ", $row['description']);
	$row['description'] = str_replace("\r", "", $row['description']);
	$row['description'] = str_replace("\t", " ", $row['description']);
			
	// Get full category path
	$category_name = smfeed_get_full_cat($row['categories_id'], $CAT_ARR);
	
	// Add VAT to prices
	if ($add_vat == "on") {
		$row['price'] = $row['price'] * $vat_value;
	}

	// Apply currency exchange rates
	$row['price'] = number_format($row_currency_rate['value'] * $row['price'], 2);
		
	// Clean product names and descriptions (separators)
	if ($datafeed_separator == "\t") {
		$category_name = str_replace("\t", " ", $category_name);
		// Continue... tabs were already removed
	}
	elseif ($datafeed_separator == "|") {
		$row['name'] = str_replace("|", " ", strip_tags($row['name']));
		$row['description'] = str_replace("|", " ", $row['description']);
		$category_name = str_replace("|", " ", $category_name);
	}
	else {
		print "Incorrect columns separator.";
		exit;			
	}
	
	// Build stock conditions
	if (STOCK_CHECK == "true" && $add_availability == "on") {
		if ($row['quantity'] > 0) {
			$availability = "In stock";
		}
		else {
			if (STOCK_ALLOW_CHECKOUT == "true") {
					$availability = (STOCK_MARK_PRODUCT_OUT_OF_STOCK != "***") ? STOCK_MARK_PRODUCT_OUT_OF_STOCK : "Out of sock";
			}
			else {
				$availability = "Out of stock";
			}
		}
	}
	elseif($add_availability == "on") {
		$availability = "In stock";
	}
	else {
		$availability = "";
	}
	
	// Add Shipping
	$shipping_flat_value = number_format($row_currency_rate['value'] * $shipping_flat_value, 2);
	$row['shipping_value'] = ($add_shipping == "on" && $shipping_flat_value > 0) ? $shipping_flat_value : "";
	
	// Add Gtin code
	$gtin = "";
	
	// Output the datafeed content
	// Category, Manufacturer, Model, ProdCode, ProdName, ProdDescription, ProdURL, ImageURL, Price, Currency, Shipping value, Availability, GTIN (UPC/EAN/ISBN) 
	print 
		$category_name . $datafeed_separator .
		$row['manufacturer'] . $datafeed_separator .
		$row['mpn'] . $datafeed_separator .
		$row['mpc'] . $datafeed_separator .
		$row['name'] . $datafeed_separator .
		$row['description'] . $datafeed_separator .
		$row['product_url'] . $datafeed_separator .
		$row['image_url'] . $datafeed_separator .
		$row['price'] . $datafeed_separator .
		$datafeed_currency . $datafeed_separator .
		$row['shipping_value'] . $datafeed_separator .
		$availability . $datafeed_separator . 
		$gtin . "\n";
}

###################################################################

if ($use_compression == "on") {
	// End compressing
	smfeed_compression_end();
}

##### Functions ########################################################

// Get categories fulll path
function smfeed_get_full_cat($cat_id, $CATEGORY_ARR) {

	$item_arr = $CATEGORY_ARR[$cat_id];
	$cat_name = $item_arr['categories_name'];
	
	while (sizeof($CATEGORY_ARR[$item_arr['parent_id']]) > 0 && is_array($CATEGORY_ARR[$item_arr['parent_id']]) ) {
		
		$cat_name = $CATEGORY_ARR[$item_arr['parent_id']]['categories_name'] . " > " . $cat_name;		
		$item_arr = $CATEGORY_ARR[$item_arr['parent_id']];
	}
	
	// Strip html from category name
	$cat_name = smfeed_html_to_text($cat_name);
	
	return $cat_name;
}

function smfeed_html_to_text($string){

	$search = array (
		"'<script[^>]*?>.*?</script>'si",  // Strip out javascript
		"'<[\/\!]*?[^<>]*?>'si",  // Strip out html tags
		"'([\r\n])[\s]+'",  // Strip out white space
		"'&(quot|#34);'i",  // Replace html entities
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&(reg|#174);'i",
		"'&#8482;'i",
		"'&#149;'i",
		"'&#151;'i"
		);  // evaluate as php
	
	$replace = array (
		" ",
		" ",
		"\\1",
		"\"",
		"&",
		"<",
		">",
		" ",
		"&iexcl;",
		"&cent;",
		"&pound;",
		"&copy;",
		"&reg;",
		"<sup><small>TM</small></sup>",
		"&bull;",
		"-",
		);
	
	$text = preg_replace ($search, $replace, $string);
	return $text;
	
}

function smfeed_clean_description($string){

	$search = array (
		"'<html>'i",
		"'</html>'i",
		"'<body>'i",
		"'</body>'i",
		"'<head>.*?</head>'si",
		"'<!DOCTYPE[^>]*?>'si"
		); 

	$replace = array (
		"",
		"",
		"",
		"",
		"",
		""
		); 
		
	$text = preg_replace ($search, $replace, $string);
	return $text;

}

function smfeed_replace_not_in_tags($find_str, $replace_str, $string) {
	
	$find = array($find_str);
	$replace = array($replace_str);	
	preg_match_all('#[^>]+(?=<)|[^>]+$#', $string, $matches, PREG_SET_ORDER);	
	foreach ($matches as $val) {	
		if (trim($val[0]) != "") {
			$string = str_replace($val[0], str_replace($find, $replace, $val[0]), $string);
		}
	}	
	return $string;
}

function smfeed_compression_start(){

	global $_SERVER, $_SVR;	
	$_SVR['NO_END_COMPRESSION'] = false;
	$_SVR['IDX_DO_GZIP_COMPRESS'] = false;
	
	// We have headers already sent so we cannot start the compression
	if (headers_sent()) {
		$_SVR['NO_END_COMPRESSION'] = true;
		return false;
	}
	
	$idx_phpver = phpversion();
	$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
	if ($idx_phpver >= "4.0.4pl1" && (strstr($useragent, "compatible") || strstr($useragent, "Gecko"))) {
		if (extension_loaded("zlib"))	{
			// Set compression level
			ini_set("zlib.output_compression_level", 5);
			ob_start("ob_gzhandler");
		}
	}
	elseif ($idx_phpver > "4.0") {
	
		if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], "gzip")) {
		
			if (extension_loaded("zlib")) {
			
				// Set compression level
				ini_set("zlib.output_compression_level", 5);
				$_SVR['IDX_DO_GZIP_COMPRESS'] = true;
				ob_start();
				ob_implicit_flush(0);
				header("Content-Encoding: gzip");
			}			
		}
	}
}

function smfeed_compression_end(){

	global $_SERVER, $_SVR;
	
	// We have not started the compression as we have headers already sent
	if ($_SVR['NO_END_COMPRESSION']) {
		return false;
	}
	// Compress buffered output if required and send to browser
	if ($_SVR['IDX_DO_GZIP_COMPRESS']) {
		$gzip_contents = ob_get_contents();
		ob_end_clean();
		$gzip_size = strlen($gzip_contents);
		$gzip_crc = crc32($gzip_contents);
		$gzip_contents = gzcompress($gzip_contents, 9);
		$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);
		print "\x1f\x8b\x08\x00\x00\x00\x00\x00";
		print $gzip_contents;
		print pack("V", $gzip_crc);
		print pack("V", $gzip_size);
	}
}

###################################################################

//session_destroy();

// Reset osCsid cookie
setcookie("osCsid", "");

exit;

?>