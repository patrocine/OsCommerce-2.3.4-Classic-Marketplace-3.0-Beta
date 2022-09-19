<?php

# If you use a default configuration you need to do place this file in your /catalog/ directory.
# Otherwise if you place this file in another directory please modify the line below with the path to the catalog directory.

$path_catalog = "./";

# Once all is set up you need to check the result and make sure the output is correct
# Point the browser to http://www.example.com/catalog/datafeed.php and look into the source code of the out put
# What you need to see is something like this
# Category | Brand | MPN | Merchant Offer Id | Product Name | Product Description | Product URL | Product Image URL | Product Price | Currency

##### Avoid any modifications below this line #####

// Datafeed specific settings
if (isset($_GET['separator']))
    $datafeed_separator = $_GET['separator'];
else
    $datafeed_separator = ",";

if (isset($_GET['enclosure']))
    $datafeed_enclosure = $_GET['enclosure'];
else
    $datafeed_enclosure = '"';

if (isset($_GET['lineend']))
    $line_separator = $_GET['lineend'];
else
    $line_separator = "\n";

$strip_newline_in_description = true;

// Include required files
if(!file_exists($path_catalog . "/includes/application_top.php")) {
    exit('Please ensure that datafeed.php is in the catalog directory, or make sure the path to the catalog directory is defined corectly above in $catalog_path variable');
}
else {
    require($path_catalog . "/includes/application_top.php");
}

$already_sent = array();

// Detect default currency
$query_currency = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'DEFAULT_CURRENCY'");
$row_currency = tep_db_fetch_array( $query_currency );

// Detect default language code
$query_language_code = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'DEFAULT_LANGUAGE'");
$row_language_code = tep_db_fetch_array( $query_language_code );

if (isset($_GET['language_code']))
    $row_language_code['configuration_value'] = $_GET['language_code'];

// Detect default language ID
$query_language_id = tep_db_query("SELECT languages_id FROM " . TABLE_LANGUAGES . " WHERE code = '" . $row_language_code['configuration_value'] . "'");
$row_language_id = tep_db_fetch_array( $query_language_id );

if (isset($_GET['language_id']))
    $row_language_id['languages_id'] = $_GET['language_id'];

// Grab the products
$products_query = tep_db_query("SELECT
manuf.manufacturers_name AS manufacturer,
prd.products_quantity AS quantity,
prd.products_date_available AS availability_date,
prd.products_id AS id,
prd.products_id AS mpc,
prd.products_model AS mpn,
prdsc.products_name AS name,
prdsc.products_description AS description,
prd.products_price AS price,
prd.products_image,

IF(catdescparent2.categories_name!='',
CONCAT_WS( ' > ' , catdescparent2.categories_name , CONCAT_WS( ' > ' , catdescparent.categories_name , catdesccurrent.categories_name )),
CONCAT_WS( ' > ' , catdescparent.categories_name , catdesccurrent.categories_name )
)
AS category

FROM (" . TABLE_CATEGORIES . " ,
" . TABLE_PRODUCTS . " prd,
" . TABLE_PRODUCTS_DESCRIPTION . " AS prdsc,
" . TABLE_CATEGORIES_DESCRIPTION . " AS catdesccurrent,
" . TABLE_PRODUCTS_TO_CATEGORIES . " AS prdtocat)
LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " AS catdescparent on ( catdescparent.categories_id = " . TABLE_CATEGORIES . ".parent_id AND catdescparent.language_id = '" . $row_language_id['languages_id'] . "' )
LEFT JOIN " . TABLE_CATEGORIES . " AS cat2 on ( cat2.categories_id = " . TABLE_CATEGORIES . ".parent_id )
LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " AS catdescparent2 on ( catdescparent2.categories_id = cat2.parent_id AND catdescparent2.language_id = '" . $row_language_id['languages_id'] . "' )
LEFT JOIN " . TABLE_MANUFACTURERS . " AS manuf ON ( manuf.manufacturers_id = prd.manufacturers_id )
WHERE
( prd.products_id = prdsc.products_id AND prdsc.language_id = '" . $row_language_id['languages_id'] . "' )
AND prd.products_id = prdtocat.products_id
AND prdtocat.categories_id = " . TABLE_CATEGORIES . ".categories_id
AND ( catdesccurrent.categories_id = " . TABLE_CATEGORIES . ".categories_id AND catdesccurrent.language_id = '" . $row_language_id['languages_id'] . "' )
AND prd.products_status != 0");

// Check for any applicable specials for the corresponding products_id
$specials_query = tep_db_query("SELECT
" . TABLE_SPECIALS . ".products_id AS idS,
FORMAT(" . TABLE_SPECIALS . ".specials_new_products_price, 2) AS priceS
FROM
" . TABLE_SPECIALS . ",
" . TABLE_PRODUCTS . "
WHERE
" . TABLE_SPECIALS . ".products_id = " . TABLE_PRODUCTS . ".products_id
AND " . TABLE_SPECIALS . ".status != 0
AND " . TABLE_PRODUCTS . ".products_status != 0");

while( $row_s = tep_db_fetch_array( $specials_query ) )
{
    foreach ($row_s as $i=>$v) {
        $SPECIALS[$row_s['idS']][$i] = $v;
    }
}

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"offers.csv\"");

// print header
print
encloseValue('Category',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Brand',$datafeed_enclosure) . $datafeed_separator .
encloseValue('MPN',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Merchant Offer Id',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Product Name',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Product Description',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Product URL',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Product Image URL',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Product Price',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Currency',$datafeed_enclosure) . $datafeed_separator .
encloseValue('Quantity',$datafeed_enclosure) .  $datafeed_separator .
encloseValue('Available from',$datafeed_enclosure) . $line_separator;


// Print the products
while( $row = tep_db_fetch_array( $products_query ) )
{
    // If we've sent this one, skip the rest - this is to ensure that we do not get duplicate products
    if ($already_sent[$row['mpc']] == 1) continue;

    $row['product_url'] = tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $row['id'], 'NONSSL', false);
    if($row['products_image'])
    {
        $row['image_url'] = HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $row['products_image'];
    }

    // Reset the products price to our special price if there is one for this product
    if( $SPECIALS[$row['id']]['idS'] ){
        $row['price'] = $SPECIALS[$row['id']]['priceS'];
    }

    // Clean product name (new lines)
    $row['name'] = str_replace("\n", " ", $row['name']);

    // remove \r from description
    $row['description'] = str_replace("\r", "", $row['description']);
    // replace space entity with actual space
    $row['description'] = str_replace("&nbsp;", " ", $row['description']);
    // need a space between \n and " if both are in a cell, otherwise behaviour is wrong in apps
    $row['description'] = str_replace("\n\"", "\n \"", $row['description']);
    // remove html tags
    $row['description'] = strip_tags($row['description']);
    // remove extra spaces
    $row['description'] = preg_replace("/\s+/", " ", $row['description']);

    if ($strip_newline_in_description)
        $row['description'] = str_replace("\n", ' ', $row['description']);

    // Clean product names and descriptions (separators)
    if ($datafeed_separator == "\t") {
        $row['name'] = str_replace("\t", " ", strip_tags($row['name']));
        $row['description'] = str_replace("\t", " ", $row['description']);
    }
    elseif ($datafeed_separator == "|") {
        $row['name'] = str_replace("|", " ", strip_tags($row['name']));
        $row['description'] = str_replace("|", " ", $row['description']);
    }

    if ($datafeed_enclosure == '"') {
        $row['name'] = str_replace('"', '""', strip_tags($row['name']));
        $row['description'] = str_replace('"', '""', $row['description']);
    }
    elseif ($datafeed_enclosure == "'") {
        $row['name'] = str_replace("'", "\\'", strip_tags($row['name']));
        $row['description'] = str_replace("'", "\\'", $row['description']);
    }
    // Output the datafeed content
    print
    encloseValue($row['category'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['manufacturer'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['mpn'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['mpc'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['name'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['description'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['product_url'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['image_url'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['price'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row_currency['configuration_value'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['quantity'],$datafeed_enclosure) . $datafeed_separator .
    encloseValue($row['availability_date'],$datafeed_enclosure) . $line_separator;

    $already_sent[$row['mpc']] = 1;
}

function encloseValue($strVal, $strEncloseChar) {
    return $strEncloseChar . $strVal . $strEncloseChar;
}

exit;

?>
