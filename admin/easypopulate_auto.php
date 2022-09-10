
<?php

// Current EP Version
$curver = '2.76-MS2';
$menos_tiempo_meses ='3';
/*
  $Id: easypopulate.php,v 2.75 2005/04/05 AL Exp $
  
  
  
       $thiscategoryname = ereg_replace("(ó)", 'o', $thiscategoryname);
      $thiscategoryname = ereg_replace("(á)", 'a', $thiscategoryname);
      $thiscategoryname = ereg_replace("(é)", 'e', $thiscategoryname);
      $thiscategoryname = ereg_replace("(í)", 'i', $thiscategoryname);
      $thiscategoryname = ereg_replace("(ú)", 'u', $thiscategoryname);
  
  
  
                   // este codigo le quita las comillas al nombre para que el sisemta de presupuestos funcione correctamente.
                 $name = ereg_replace("([\]\")", '', $name);

                       $name = ereg_replace("(ó)", 'o', $name);
      $name = ereg_replace("(á)", 'a', $name);
      $name = ereg_replace("(é)", 'e', $name);
      $name = ereg_replace("(í)", 'i', $name);
      $name = ereg_replace("(ú)", 'u', $name);
  
*/
 require('includes/application_top.php');
require('includes/database_tables.php');

//
//*******************************
//*******************************
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************

// **** Temp directory ****
// if you changed your directory structure from stock and do not have /catalog/temp/, then you'll need to change this accordingly.
//
$tempdir = "/temp/";
$tempdir2 = "/temp/";

//**** File Splitting Configuration ****
// we attempt to set the timeout limit longer for this script to avoid having to split the files
// NOTE:  If your server is running in safe mode, this setting cannot override the timeout set in php.ini
// uncomment this if you are not on a safe mode server and you are getting timeouts
// set_time_limit(330);

// if you are splitting files, this will set the maximum number of records to put in each file.
// if you set your php.ini to a long time, you can make this number bigger



global $maxrecs;
$maxrecs = 300; // default, seems to work for most people.  Reduce if you hit timeouts
//$maxrecs = 4; // for testing

//**** Image Defaulting ****
global $default_images, $default_image_manufacturer, $default_image_product, $default_image_category;

// set them to your own default "We don't have any picture" gif
//$default_image_manufacturer = 'no_image_manufacturer.gif';
//$default_image_product = 'no_image_product.gif';
//$default_image_category = 'no_image_category.gif';

// or let them get set to nothing
$default_image_manufacturer = '';
$default_image_product = '';
$default_image_category = '';

//**** Status Field Setting ****
// Set the v_status field to "Inactive" if you want the status=0 in the system
// Set the v_status field to "Delete" if you want to remove the item from the system <- THIS IS NOT WORKING YET!
// If zero_qty_inactive is true, then items with zero qty will automatically be inactive in the store.
global $active, $inactive, $zero_qty_inactive, $deleteit;
$active = 'Active';
$inactive = 'Inactive';
//$deleteit = 'Delete'; // not functional yet
$zero_qty_inactive = true;

//**** Size of products_model in products table ****
// set this to the size of your model number field in the db.  We check to make sure all models are no longer than this value.
// this prevents the database from getting fubared.  Just making this number bigger won't help your database!  They must match!


global $modelsize;
$modelsize = 150;

//**** Price includes tax? ****
// Set the v_price_with_tax to
// 0 if you want the price without the tax included
// 1 if you want the price to be defined for import & export including tax.
global $price_with_tax;
$price_with_tax = PRECIOS_C;

// **** Quote -> Escape character conversion ****
// If you have extensive html in your descriptions and it's getting mangled on upload, turn this off
// set to 1 = replace quotes with escape characters
// set to 0 = no quote replacement
global $replace_quotes;
$replace_quotes = true;

// **** Field Separator ****
// change this if you can't use the default of tabs
// Tab is the default, comma and semicolon are commonly supported by various progs
// Remember, if your descriptions contain this character, you will confuse EP!
global $separator;
$separator = "\t"; // tab is default
//$separator = ","; // comma
//$separator = ";"; // semi-colon
//$separator = "~"; // tilde
//$separator = "-"; // dash
//$separator = "*"; // splat

// **** Max Category Levels ****
// change this if you need more or fewer categories
global $max_categories;
$max_categories = 7; // 7 is default

// VJ product attributes begin
// **** Product Attributes ****
// change this to false, if do not want to download product attributes
global $products_with_attributes;
$products_with_attributes = false;






// change this to true, if you use QTYpro and want to set attributes stock with EP.
global $products_attributes_stock;
$products_attributes_stock = false;


// change this if you want to download selected product options
// this might be handy, if you have a lot of product options, and your output file exceeds 256 columns (which is the max. limit MS Excel is able to handle)
global $attribute_options_select;
//$attribute_options_select = array('Size', 'Model'); // uncomment and fill with product options name you wish to download // comment this line, if you wish to download all product options
// VJ product attributes end




// ****************************************
// Froogle configuration variables
// -- YOU MUST CONFIGURE THIS!  IT WON'T WORK OUT OF THE BOX!
// ****************************************

// **** Froogle product info page path ****
// We can't use the tep functions to create the link, because the links will point to the admin, since that's where we're at.
// So put the entire path to your product_info.php page here
global $froogle_product_info_path;
$froogle_product_info_path = "http://www.yourdomain.com/catalog/product_info.php";

// **** Froogle product image path ****
// Set this to the path to your images directory
global $froogle_image_path;
$froogle_image_path = "http://www.yourdomain.com/catalog/images/";

// **** Froogle - search engine friendly setting
// if your store has SEARCH ENGINE FRIENDLY URLS set, then turn this to true
// I did it this way because I'm having trouble with the code seeing the constants
// that are defined in other places.
global $froogle_SEF_urls;
$froogle_SEF_urls = false;


// ****************************************
// End Froogle configuration variables
// ****************************************

//*******************************
//*******************************
// E N D
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************


//*******************************
//*******************************
// S T A R T
// INITIALIZATION
//*******************************
//*******************************



//*******************************
// If you are running a pre-Nov1-2002 snapshot of OSC, then we need this include line to avoid
// errors like:
//   undefined function tep_get_uploaded_file
 if (!function_exists(tep_get_uploaded_file)){
	include ('easypopulate_functions.php');
 }
//*******************************

// VJ product attributes begin
global $attribute_options_array;
$attribute_options_array = array();

if ($products_with_attributes == true) {
	if (is_array($attribute_options_select) && (count($attribute_options_select) > 0)) {
		foreach ($attribute_options_select as $value) {
			$attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " where products_options_name = '" . $value . "'";

			$attribute_options_values = tep_db_query($attribute_options_query);

			if ($attribute_options = tep_db_fetch_array($attribute_options_values)){
				$attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
			}
		}
	} else {
		$attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " order by products_options_id";

		$attribute_options_values = tep_db_query($attribute_options_query);

		while ($attribute_options = tep_db_fetch_array($attribute_options_values)){
			$attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
		}
	}
}
// VJ product attributes end

global $filelayout, $filelayout_count, $filelayout_sql, $langcode, $fileheaders;

// these are the fields that will be defaulted to the current values in the database if they are not found in the incoming file
global $default_these;
$default_these = array(
	'v_products_image',
	#'v_products_mimage',
	#'v_products_bimage',
	#'v_products_subimage1',
	#'v_products_bsubimage1',
	#'v_products_subimage2',
	#'v_products_bsubimage2',
	#'v_products_subimage3',
	#'v_products_bsubimage3',
	'v_categories_id',
	'v_products_price',
	'v_products_quantity',
	'v_products_weight',
	'v_date_avail',
	'v_instock',
	'v_tax_class_title',
	'v_manufacturers_name',
	'v_manufacturers_id',
	'v_products_dim_type',
	'v_products_length',
	'v_products_width',
	'v_products_height'
	);

//elari check default language_id from configuration table DEFAULT_LANGUAGE
$epdlanguage_query = tep_db_query("select languages_id, name from " . TABLE_LANGUAGES . " where code = '" . DEFAULT_LANGUAGE . "'");
if (tep_db_num_rows($epdlanguage_query)) {
	$epdlanguage = tep_db_fetch_array($epdlanguage_query);
	$epdlanguage_id   = $epdlanguage['languages_id'];
	$epdlanguage_name = $epdlanguage['name'];
} else {
	Echo 'Strange but there is no default language to work... That may not happen, just in case... ';
}

$langcode = ep_get_languages();

if ( $dltype != '' ){
	// if dltype is set, then create the filelayout.  Otherwise it gets read from the uploaded file
	ep_create_filelayout($dltype); // get the right filelayout for this download
}

//*******************************
//*******************************
// E N D
// INITIALIZATION
//*******************************
//*******************************


if ( $download == 'stream' or  $download == 'tempfile' ){
	//*******************************
	//*******************************
	// DOWNLOAD FILE
	//*******************************
	//*******************************
	$filestring = ""; // this holds the csv file we want to download
	$result = tep_db_query($filelayout_sql);
	$row =  tep_db_fetch_array($result);

	// Here we need to allow for the mapping of internal field names to external field names
	// default to all headers named like the internal ones
	// the field mapping array only needs to cover those fields that need to have their name changed
	if ( count($fileheaders) != 0 ){
		$filelayout_header = $fileheaders; // if they gave us fileheaders for the dl, then use them
	} else {
		$filelayout_header = $filelayout; // if no mapping was spec'd use the internal field names for header names
	}
	//We prepare the table heading with layout values
	foreach( $filelayout_header as $key => $value ){
		$filestring .= $key . $separator;
	}
	// now lop off the trailing tab
	$filestring = substr($filestring, 0, strlen($filestring)-1);

	// set the type
	if ( $dltype == 'froogle' ){
		$endofrow = "\n";
	} else {
		// default to normal end of row
		$endofrow = $separator . 'EOREOR' . "\n";
	}
	$filestring .= $endofrow;

	$num_of_langs = count($langcode);
	while ($row){


		// if the filelayout says we need a products_name, get it
		// build the long full froogle image path
		$row['v_products_fullpath_image'] = $froogle_image_path . $row['v_products_image'];
		// Other froogle defaults go here for now
		$row['v_froogle_instock'] 		= 'Y';
		$row['v_froogle_shipping'] 		= '';
		$row['v_froogle_upc'] 			= '';
		$row['v_froogle_color']			= '';
		$row['v_froogle_size']			= '';
		$row['v_froogle_quantitylevel']		= '';
		$row['v_froogle_manufacturer_id']	= '';
		$row['v_froogle_exp_date']		= '';
		$row['v_froogle_product_type']		= 'OTHER';
		$row['v_froogle_delete']		= '';
		$row['v_froogle_currency']		= 'USD';
		$row['v_froogle_offer_id']		= $row['v_products_model'];
		$row['v_froogle_product_id']		= $row['v_products_model'];

		// names and descriptions require that we loop thru all languages that are turned on in the store
		foreach ($langcode as $key => $lang){
			$lid = $lang['id'];

			// for each language, get the description and set the vals
			$sql2 = "SELECT *
				FROM ".TABLE_PRODUCTS_DESCRIPTION."
				WHERE
					products_id = " . $row['v_products_id'] . " AND
					language_id = '" . $lid . "'
				";
			$result2 = tep_db_query($sql2);
			$row2 =  tep_db_fetch_array($result2);

			// I'm only doing this for the first language, since right now froogle is US only.. Fix later!
			// adding url for froogle, but it should be available no matter what
			if ($froogle_SEF_urls){
				// if only one language
				if ($num_of_langs == 1){
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '/products_id/' . $row['v_products_id'];
				} else {
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '/products_id/' . $row['v_products_id'] . '/language/' . $lid;
				}
			} else {
				if ($num_of_langs == 1){
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '?products_id=' . $row['v_products_id'];
				} else {
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '?products_id=' . $row['v_products_id'] . '&language=' . $lid;
				}
			}

			$row['v_products_name_' . $lid] 	= $row2['products_name'];
			$row['v_products_description_' . $lid] 	= $row2['products_description'];
			$row['v_products_url_' . $lid] 		= $row2['products_url'];

			// froogle advanced format needs the quotes around the name and desc
			$row['v_froogle_products_name_' . $lid] = '"' . strip_tags(str_replace('"','""',$row2['products_name'])) . '"';
			$row['v_froogle_products_description_' . $lid] = '"' . strip_tags(str_replace('"','""',$row2['products_description'])) . '"';

			// support for Linda's Header Controller 2.0 here
			if(isset($filelayout['v_products_head_title_tag_' . $lid])){
				$row['v_products_head_title_tag_' . $lid] 	= $row2['products_head_title_tag'];
				$row['v_products_head_desc_tag_' . $lid] 	= $row2['products_head_desc_tag'];
				$row['v_products_head_keywords_tag_' . $lid] 	= $row2['products_head_keywords_tag'];
			}
			// end support for Header Controller 2.0
		}

		// for the categories, we need to keep looping until we find the root category

		// start with v_categories_id
		// Get the category description
		// set the appropriate variable name
		// if parent_id is not null, then follow it up.
		// we'll populate an aray first, then decide where it goes in the
		$thecategory_id = $row['v_categories_id'];
		$fullcategory = ''; // this will have the entire category stack for froogle
		for( $categorylevel=1; $categorylevel<$max_categories+1; $categorylevel++){
			if ($thecategory_id){
				$sql2 = "SELECT categories_name
					FROM ".TABLE_CATEGORIES_DESCRIPTION."
					WHERE	
						categories_id = " . $thecategory_id . " AND
						language_id = " . $epdlanguage_id ;

				$result2 = tep_db_query($sql2);
				$row2 =  tep_db_fetch_array($result2);
				// only set it if we found something
				$temprow['v_categories_name_' . $categorylevel] = $row2['categories_name'];
				// now get the parent ID if there was one
				$sql3 = "SELECT parent_id
					FROM ".TABLE_CATEGORIES."
					WHERE
						categories_id = " . $thecategory_id;
				$result3 = tep_db_query($sql3);
				$row3 =  tep_db_fetch_array($result3);
				$theparent_id = $row3['parent_id'];
				if ($theparent_id != ''){
					// there was a parent ID, lets set thecategoryid to get the next level
					$thecategory_id = $theparent_id;
				} else {
					// we have found the top level category for this item,
					$thecategory_id = false;
				}
				//$fullcategory .= " > " . $row2['categories_name'];
				$fullcategory = $row2['categories_name'] . " > " . $fullcategory;
			} else {
				$temprow['v_categories_name_' . $categorylevel] = '';
			}
		}
		// now trim off the last ">" from the category stack
		$row['v_category_fullpath'] = substr($fullcategory,0,strlen($fullcategory)-3);

		// temprow has the old style low to high level categories.
		$newlevel = 1;
		// let's turn them into high to low level categories
		for( $categorylevel=6; $categorylevel>0; $categorylevel--){
			if ($temprow['v_categories_name_' . $categorylevel] != ''){
				$row['v_categories_name_' . $newlevel++] = $temprow['v_categories_name_' . $categorylevel];
			}
		}
		// if the filelayout says we need a manufacturers name, get it
		if (isset($filelayout['v_manufacturers_name'])){
			if ($row['v_manufacturers_id'] != ''){
				$sql2 = "SELECT manufacturers_name
					FROM ".TABLE_MANUFACTURERS."
					WHERE
					manufacturers_id = " . $row['v_manufacturers_id']
					;
				$result2 = tep_db_query($sql2);
				$row2 =  tep_db_fetch_array($result2);
				$row['v_manufacturers_name'] = $row2['manufacturers_name'];
			}
		}


		// If you have other modules that need to be available, put them here

		// VJ product attribs begin
		if (isset($filelayout['v_attribute_options_id_1'])){
			$languages = tep_get_languages();

			$attribute_options_count = 1;
      foreach ($attribute_options_array as $attribute_options) {
				$row['v_attribute_options_id_' . $attribute_options_count] 	= $attribute_options['products_options_id'];

				for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
					$lid = $languages[$i]['id'];

					$attribute_options_languages_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' and language_id = '" . (int)$lid . "'";

					$attribute_options_languages_values = tep_db_query($attribute_options_languages_query);

					$attribute_options_languages = tep_db_fetch_array($attribute_options_languages_values);

					$row['v_attribute_options_name_' . $attribute_options_count . '_' . $lid] = $attribute_options_languages['products_options_name'];
				}

				$attribute_values_query = "select products_options_values_id from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' order by products_options_values_id";

				$attribute_values_values = tep_db_query($attribute_values_query);

				$attribute_values_count = 1;
				while ($attribute_values = tep_db_fetch_array($attribute_values_values)) {
					$row['v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count] 	= $attribute_values['products_options_values_id'];

					$attribute_values_price_query = "select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$row['v_products_id'] . "' and options_id = '" . (int)$attribute_options['products_options_id'] . "' and options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "'";

					$attribute_values_price_values = tep_db_query($attribute_values_price_query);

					$attribute_values_price = tep_db_fetch_array($attribute_values_price_values);

					$row['v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count] 	= $attribute_values_price['price_prefix'] . $attribute_values_price['options_values_price'];

	//// attributes stock add start        
	if ( $products_attributes_stock	== true ) {   
		   $stock_attributes = $attribute_options['products_options_id'].'-'.$attribute_values['products_options_values_id'];
		   
		   $stock_quantity_query = tep_db_query("select products_stock_quantity from " . TABLE_PRODUCTS_STOCK . " where products_id = '" . (int)$row['v_products_id'] . "' and products_stock_attributes = '" . $stock_attributes . "'");
           $stock_quantity = tep_db_fetch_array($stock_quantity_query);
		   
		   $row['v_attribute_values_stock_' . $attribute_options_count . '_' . $attribute_values_count] = $stock_quantity['products_stock_quantity'];
 	}
	//// attributes stock add end  
					
					
					for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
						$lid = $languages[$i]['id'];

						$attribute_values_languages_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "' and language_id = '" . (int)$lid . "'";

						$attribute_values_languages_values = tep_db_query($attribute_values_languages_query);

						$attribute_values_languages = tep_db_fetch_array($attribute_values_languages_values);

						$row['v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid] = $attribute_values_languages['products_options_values_name'];
					}

					$attribute_values_count++;
				}

				$attribute_options_count++;
			}
		}
		// VJ product attribs end

		// this is for the separate price per customer module
		if (isset($filelayout['v_customer_price_1'])){
			$sql2 = "SELECT
					customers_group_price,
					customers_group_id
				FROM
					".TABLE_PRODUCTS_GROUPS."
				WHERE
				products_id = " . $row['v_products_id'] . "
				ORDER BY
				customers_group_id"
				;
			$result2 = tep_db_query($sql2);
			$ll = 1;
			$row2 =  tep_db_fetch_array($result2);
			while( $row2 ){
				$row['v_customer_group_id_' . $ll] 	= $row2['customers_group_id'];
				$row['v_customer_price_' . $ll] 	= $row2['customers_group_price'];
				$row2 = tep_db_fetch_array($result2);
				$ll++;
			}
		}
		if ($dltype == 'froogle'){
			// For froogle, we check the specials prices for any applicable specials, and use that price
			// by grabbing the specials id descending, we always get the most recently added special price
			// I'm checking status because I think you can turn off specials
			$sql2 = "SELECT
					specials_new_products_price
				FROM
					".TABLE_SPECIALS."
				WHERE
				products_id = " . $row['v_products_id'] . " and
				status = 1 and
				expires_date < CURRENT_TIMESTAMP
				ORDER BY
					specials_id DESC"
				;
			$result2 = tep_db_query($sql2);
			$ll = 1;
			$row2 =  tep_db_fetch_array($result2);
			if( $row2 ){
				// reset the products price to our special price if there is one for this product
				$row['v_products_price'] 	= $row2['specials_new_products_price'];
			}
		}

		//elari -
		//We check the value of tax class and title instead of the id
		//Then we add the tax to price if $price_with_tax is set to 1
		$row_tax_multiplier 		= tep_get_tax_class_rate($row['v_tax_class_id']);
		$row['v_tax_class_title'] 	= tep_get_tax_class_title($row['v_tax_class_id']);
		$row['v_products_price'] 	= round($row['v_products_price'] +
				($price_with_tax * $row['v_products_price'] * $row_tax_multiplier / 100),2);


		// Now set the status to a word the user specd in the config vars
		if ( $row['v_status'] == '1' ){
			$row['v_status'] = $active;
		} else {
			$row['v_status'] = $inactive;
		}

		// remove any bad things in the texts that could confuse EasyPopulate
		$therow = '';
		foreach( $filelayout as $key => $value ){
			//echo "The field was $key<br>";

			$thetext = $row[$key];
			// kill the carriage returns and tabs in the descriptions, they're killing me!
			$thetext = str_replace("\r",' ',$thetext);
			$thetext = str_replace("\n",' ',$thetext);
			$thetext = str_replace("\t",' ',$thetext);
			// and put the text into the output separated by tabs
			$therow .= $thetext . $separator;
		}

		// lop off the trailing tab, then append the end of row indicator
		$therow = substr($therow,0,strlen($therow)-1) . $endofrow;

		$filestring .= $therow;
		// grab the next row from the db
		$row =  tep_db_fetch_array($result);
	}

	#$EXPORT_TIME=time();
	$EXPORT_TIME = strftime('%Y%b%d-%H%I');
	if ($dltype=="froogle"){
		$EXPORT_TIME = "FroogleEP" . $EXPORT_TIME;
	} else {
		$EXPORT_TIME = "EP" . $EXPORT_TIME;
	}

	// now either stream it to them or put it in the temp directory
	if ($download == 'stream'){
		//*******************************
		// STREAM FILE
		//*******************************
		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: attachment; filename=$EXPORT_TIME.txt");
// Changed if using SSL, helps prevent program delay/timeout (add to backup.php also)
	//	header("Pragma: no-cache");
if ($request_type== 'NONSSL'){
header("Pragma: no-cache");
 } else {
header("Pragma: ");
}
		header("Expires: 0");
		echo $filestring;
		die();
	} else {
		//*******************************
		// PUT FILE IN TEMP DIR
		//*******************************
		$tmpfname = DIR_FS_DOCUMENT_ROOT . $tempdir . "$EXPORT_TIME.txt";
		//unlink($tmpfname);
		$fp = fopen( $tmpfname, "w+");
		fwrite($fp, $filestring);
		fclose($fp);
		echo "You can get your file in the Tools/Files under " . $tempdir . "EP" . $EXPORT_TIME . ".txt";
		die();
	}
}   // *** END *** download section
?>


<?php   require(DIR_WS_INCLUDES . 'template_top.php');?>





        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo 'ACTUALIZAR CATALOGOS GENERALES'; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">


</table></td>
<td class="pageHeading" valign="top"><?php
echo "Easy Populate $curver - Lenguage por Defecto : " . $epdlanguage_name . '(' . $epdlanguage_id .')' ;
?>

<p class="smallText">

<?php
    $usrfl_name = $HTTP_POST_FILES['usrfl']['name'];
$usrfl_size = $HTTP_POST_FILES['usrfl']['size'];
 $usrfl =  $HTTP_POST_FILES['usrfl']['tmp_name'];

	//*******************************
	//*******************************
	// UPLOAD AND INSERT FILE
	//*******************************
	//*******************************


		// move the file to where we can work with it
		$file = tep_get_uploaded_file('usrfl');
		if (is_uploaded_file($file['tmp_name'])) {
			tep_copy_uploaded_file($file, DIR_FS_DOCUMENT_ROOT . $tempdir);
		}


   $link_p = $HTTP_GET_VARS['link_p'];
   $proveedor_id = $HTTP_GET_VARS['proveedor_id'];
   $lote = $HTTP_GET_VARS['lote'];

		echo "<p class=smallText>";
		echo "File uploaded. <br>";
		echo "Ruta del Archivo: " . $link_p . "<br>";
		echo "Id de Proveedor: " . $proveedor_id . "<br>";
        echo "<br>";
        echo "<br>";
        echo "NO DETENGA NI CIERRE ESTA VENTAN HASTA QUE TERMINE DE CARGAR LA PAGINA.<br>";
        echo "<br>";
        echo "<br>";

		// get the entire file into an array
   $prove_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id= '" . $proveedor_id . "'");
     $prove = tep_db_fetch_array($prove_values);
        $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
       $oldday1 = date("Y-m-d", $time1);



             $texto_mail .= STORE_OWNER;
             $texto_mail .= " Esta sincronización es con el proveedor " . $prove['proveedor_name'];
             $texto_mail .= "\n\n";
             $texto_mail .= "Se an insertado todas las novedades hasta la fecha: " . $oldday1;
             $texto_mail .= "\n\n\n\n";
             $texto_mail .= "¿Que es Novedades?";
             $texto_mail .= "\n\n";
             $texto_mail .= "Se han insertado todas las novedades hasta la fecha.";
             $texto_mail .= "\n\n";
             $texto_mail .= "Tutoriales";
             $texto_mail .= "\n";
             $texto_mail .= "https://www.youtube.com/playlist?list=PLv6_VqQZKB8bQWaRnjZDGApV4zdMWj4_V";
             //   $texto_mail .= $oldday1;


             $cabezera .=  STORE_OWNER . ' ' . $prove['proveedor_name'] . ' NOVEDADES INSERTADAS';



          // tep_mail('', STORE_OWNER_EMAIL_ADDRESS , $cabezera, $texto_mail, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);




  
$readed = file($link_p);


 if ($localfile){
		// move the file to where we can work with it
		$file = tep_get_uploaded_file('usrfl');			$attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " order by products_options_id";

			$attribute_options_values = tep_db_query($attribute_options_query);

			$attribute_options_count = 1;
			//while ($attribute_options = tep_db_fetch_array($attribute_options_values)){
 	if (is_uploaded_file($file['tmp_name'])) {
			tep_copy_uploaded_file($file, DIR_FS_DOCUMENT_ROOT . $tempdir);
  }

		echo "<p class=smallText>";
		echo "Filename: " . $localfile . "<br>";

		// get the entire file into an array
		$readed = file(DIR_FS_DOCUMENT_ROOT . $tempdir . $localfile);
 }

	// now we string the entire thing together in case there were carriage returns in the data
	$newreaded = "";
	foreach ($readed as $read){
		$newreaded .= $read;
	}

	// now newreaded has the entire file together without the carriage returns.
	// if for some reason excel put qoutes around our EOREOR, remove them then split into rows
	$newreaded = str_replace('"EOREOR"', 'EOREOR', $newreaded);
	$readed = explode( $separator . 'EOREOR',$newreaded);


	// Now we'll populate the filelayout based on the header row.
	$theheaders_array = explode( $separator, $readed[0] ); // explode the first row, it will be our filelayout
	$lll = 0;
	$filelayout = array();
	foreach( $theheaders_array as $header ){
		$cleanheader = str_replace( '"', '', $header);
	//	echo "Fileheader was $header<br><br><br>";
		$filelayout[ $cleanheader ] = $lll++; //
	}
	unset($readed[0]); //  we don't want to process the headers with the data

	// now we've got the array broken into parts by the expicit end-of-row marker.
	array_walk($readed, 'walk');



if (is_uploaded_file($usrfl) && $split==1) {
	//*******************************
	//*******************************
	// UPLOAD AND SPLIT FILE
	//*******************************
	//*******************************
	// move the file to where we can work with it
	$file = tep_get_uploaded_file('usrfl');
	//echo "Trying to move file...";
	if (is_uploaded_file($file['tmp_name'])) {
		tep_copy_uploaded_file($file, DIR_FS_DOCUMENT_ROOT . $tempdir);
 }

	$infp = fopen(DIR_FS_DOCUMENT_ROOT . $tempdir . $usrfl_name, "r");

	//toprow has the field headers
	$toprow = fgets($infp,32768);

	$filecount = 1;

	echo "Creating file EP_Split" . $filecount . ".txt ...  ";
	$tmpfname = DIR_FS_DOCUMENT_ROOT . $tempdir . "EP_Split" . $filecount . ".txt";
	$fp = fopen( $tmpfname, "w+");
	fwrite($fp, $toprow);

	$linecount = 0;
	$line = fgets($infp,32768);
	while ($line){
		// walking the entire file one row at a time
		// but a line is not necessarily a complete row, we need to split on rows that have "EOREOR" at the end
		$line = str_replace('"EOREOR"', 'EOREOR', $line);
		fwrite($fp, $line);
		if (strpos($line, 'EOREOR')){
			// we found the end of a line of data, store it
			$linecount++; // increment our line counter
			if ($linecount >= $maxrecs){
				echo "Added $linecount records and closing file... <Br>";
				$linecount = 0; // reset our line counter
				// close the existing file and open another;
				fclose($fp);
				// increment filecount
				$filecount++;
				echo "Creating file EP_Split" . $filecount . ".txt ...  ";
				$tmpfname = DIR_FS_DOCUMENT_ROOT . $tempdir . "EP_Split" . $filecount . ".txt";
				//Open next file name
				$fp = fopen( $tmpfname, "w+");
				fwrite($fp, $toprow);
			}
		}
		$line=fgets($infp,32768);
	}
	echo "Added $linecount records and closing file...<br><br> ";
	fclose($fp);
	fclose($infp);

	echo "You can download your split files in the Tools/Files under /catalog/temp/";

}


   if ($lote >= 2){


  ?>

                             <script type="text/javascript">

    var pagina = '<?php echo 'easypopulate_sincronizacion_auto.php?proveedor_id=' . $proveedor_id .'&link_p=' . $prove['link_sincronizacion']; ?>';
    var segundos = 30000;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>
   <?php

}else{

 ?>

                             <script type="text/javascript">

    var pagina = '<?php echo 'easypopulate_auto.php?proveedor_id=' . $proveedor_id .'&link_p=' . $prove['link_novedades'] .'&lote=2'; ?>';
    var segundos = 30000;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>
   <?php





}












?>






	  </td>
	</tr>
      </table>
    </td>
 </tr>
</table>






<p> </p>
<p> </p><p><br>
</p></body>
</html>

<?php

function ep_get_languages() {
	$languages_query = tep_db_query("select languages_id, code from " . TABLE_LANGUAGES . " order by sort_order");
	// start array at one, the rest of the code expects it that way
	$ll =1;
	while ($ep_languages = tep_db_fetch_array($languages_query)) {
		//will be used to return language_id en language code to report in product_name_code instead of product_name_id
		$ep_languages_array[$ll++] = array(
					'id' => $ep_languages['languages_id'],
					'code' => $ep_languages['code']
					);
	}
	return $ep_languages_array;
};

function tep_get_tax_class_rate($tax_class_id) {
	$tax_multiplier = 0;
	$tax_query = tep_db_query("select SUM(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " WHERE  tax_class_id = '" . $tax_class_id . "' GROUP BY tax_priority");
	if (tep_db_num_rows($tax_query)) {
		while ($tax = tep_db_fetch_array($tax_query)) {
			$tax_multiplier += $tax['tax_rate'];
		}
	}
	return $tax_multiplier;
};

function tep_get_tax_title_class_id($tax_class_title) {
	$classes_query = tep_db_query("select tax_class_id from " . TABLE_TAX_CLASS . " WHERE tax_class_title = '" . $tax_class_title . "'" );
	$tax_class_array = tep_db_fetch_array($classes_query);
	$tax_class_id = $tax_class_array['tax_class_id'];
	return $tax_class_id ;
}

function print_el( $item2 ) {
	echo " | " . substr(strip_tags($item2), 0, 10);
};

function print_el1( $item2 ) {
	echo sprintf("| %'.4s ", substr(strip_tags($item2), 0, 80));
};
function ep_create_filelayout($dltype){
	global $filelayout, $filelayout_count, $filelayout_sql, $langcode, $fileheaders, $max_categories;
	// depending on the type of the download the user wanted, create a file layout for it.
	$fieldmap = array(); // default to no mapping to change internal field names to external.
	switch( $dltype ){
	case 'full':
		// The file layout is dynamically made depending on the number of languages
		$iii = 0;
		$filelayout = array(
			'v_products_model'		=> $iii++,
			'v_products_image'		=> $iii++,
			);

		foreach ($langcode as $key => $lang){
			$l_id = $lang['id'];
			// uncomment the head_title, head_desc, and head_keywords to use
			// Linda's Header Tag Controller 2.0
			//echo $langcode['id'] . $langcode['code'];
			$filelayout  = array_merge($filelayout , array(
					'v_products_name_' . $l_id		=> $iii++,
					'v_products_description_' . $l_id	=> $iii++,
					'v_products_url_' . $l_id	=> $iii++,
			//		'v_products_head_title_tag_'.$l_id	=> $iii++,
			//		'v_products_head_desc_tag_'.$l_id	=> $iii++,
			//		'v_products_head_keywords_tag_'.$l_id	=> $iii++,
					));
		}


		// uncomment the customer_price and customer_group to support multi-price per product contrib

    // VJ product attribs begin
     $header_array = array(
			'v_products_price'		=> $iii++,
			'v_products_weight'		=> $iii++,
			'v_date_avail'			=> $iii++,
			'v_date_added'			=> $iii++,
			'v_products_quantity'		=> $iii++,
			);

			$languages = tep_get_languages();

      global $attribute_options_array;

      $attribute_options_count = 1;
      foreach ($attribute_options_array as $attribute_options_values) {
				$key1 = 'v_attribute_options_id_' . $attribute_options_count;
				$header_array[$key1] = $iii++;

        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $l_id = $languages[$i]['id'];

					$key2 = 'v_attribute_options_name_' . $attribute_options_count . '_' . $l_id;
					$header_array[$key2] = $iii++;
				}

				$attribute_values_query = "select products_options_values_id  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";

				$attribute_values_values = tep_db_query($attribute_values_query);

				$attribute_values_count = 1;
				while ($attribute_values = tep_db_fetch_array($attribute_values_values)) {
					$key3 = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key3] = $iii++;

					for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
						$l_id = $languages[$i]['id'];

						$key4 = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $l_id;
						$header_array[$key4] = $iii++;
					}

					$key5 = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key5] = $iii++;
	
//// attributes stock add start        
	if ( $products_attributes_stock	== true ) { 
					$key6 = 'v_attribute_values_stock_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key6] = $iii++;
	}				
//// attributes stock add end 		
					
					$attribute_values_count++;
				}

				$attribute_options_count++;
     }

    $header_array['v_manufacturers_name'] = $iii++;

    $filelayout = array_merge($filelayout, $header_array);
    // VJ product attribs end

		// build the categories name section of the array based on the number of categores the user wants to have
		for($i=1;$i<$max_categories+1;$i++){
			$filelayout = array_merge($filelayout, array('v_categories_name_' . $i => $iii++));
		}

		$filelayout = array_merge($filelayout, array(
			'v_tax_class_title'		=> $iii++,
			'v_status'			=> $iii++,
			));

		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_image as v_products_image,
			p.products_price as v_products_price,
			p.products_weight as v_products_weight,
			p.products_date_available as v_date_avail,
			p.products_date_added as v_date_added,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity,
			p.manufacturers_id as v_manufacturers_id,
			subc.categories_id as v_categories_id,
			p.products_status as v_status
			FROM
			".TABLE_PRODUCTS." as p,
			".TABLE_CATEGORIES." as subc,
			".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id
			";

		break;
	case 'priceqty':
		$iii = 0;
		// uncomment the customer_price and customer_group to support multi-price per product contrib
		$filelayout = array(
			'v_products_model'		=> $iii++,
			'v_products_price'		=> $iii++,
			'v_products_quantity'		=> $iii++,
			#'v_customer_price_1'		=> $iii++,
			#'v_customer_group_id_1'		=> $iii++,
			#'v_customer_price_2'		=> $iii++,
			#'v_customer_group_id_2'		=> $iii++,
			#'v_customer_price_3'		=> $iii++,
			#'v_customer_group_id_3'		=> $iii++,
			#'v_customer_price_4'		=> $iii++,
			#'v_customer_group_id_4'		=> $iii++,
				);
		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_price as v_products_price,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity
			FROM
			".TABLE_PRODUCTS." as p
			";

		break;

	case 'category':
		// The file layout is dynamically made depending on the number of languages
		$iii = 0;
		$filelayout = array(
			'v_products_model'		=> $iii++,
		);

		// build the categories name section of the array based on the number of categores the user wants to have
		for($i=1;$i<$max_categories+1;$i++){
			$filelayout = array_merge($filelayout, array('v_categories_name_' . $i => $iii++));
		}


		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			subc.categories_id as v_categories_id
			FROM
			".TABLE_PRODUCTS." as p,
			".TABLE_CATEGORIES." as subc,
			".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc			
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id
			";
		break;

	case 'froogle':
		// this is going to be a little interesting because we need
		// a way to map from internal names to external names
		//
		// Before it didn't matter, but with froogle needing particular headers,
		// The file layout is dynamically made depending on the number of languages
		$iii = 0;
		$filelayout = array(
			'v_froogle_products_url_1'			=> $iii++,
			);
		//
		// here we need to get the default language and put
		$l_id = 1; // dummy it in for now.
//		foreach ($langcode as $key => $lang){
//			$l_id = $lang['id'];
			$filelayout  = array_merge($filelayout , array(
					'v_froogle_products_name_' . $l_id		=> $iii++,
					'v_froogle_products_description_' . $l_id	=> $iii++,
					));
//		}
		$filelayout  = array_merge($filelayout , array(
			'v_products_price'		=> $iii++,
			'v_products_fullpath_image'	=> $iii++,
			'v_category_fullpath'		=> $iii++,
			'v_froogle_offer_id'		=> $iii++,
			'v_froogle_instock'		=> $iii++,
			'v_froogle_ shipping'		=> $iii++,
			'v_manufacturers_name'		=> $iii++,
			'v_froogle_ upc'		=> $iii++,
			'v_froogle_color'		=> $iii++,
			'v_froogle_size'		=> $iii++,
			'v_froogle_quantitylevel'	=> $iii++,
			'v_froogle_product_id'		=> $iii++,
			'v_froogle_manufacturer_id'	=> $iii++,
			'v_froogle_exp_date'		=> $iii++,
			'v_froogle_product_type'	=> $iii++,
			'v_froogle_delete'		=> $iii++,
			'v_froogle_currency'		=> $iii++,
				));
		$iii=0;
		$fileheaders = array(
			'product_url'		=> $iii++,
			'name'			=> $iii++,
			'description'		=> $iii++,
			'price'			=> $iii++,
			'image_url'		=> $iii++,
			'category'		=> $iii++,
			'offer_id'		=> $iii++,
			'instock'		=> $iii++,
			'shipping'		=> $iii++,
			'brand'			=> $iii++,
			'upc'			=> $iii++,
			'color'			=> $iii++,
			'size'			=> $iii++,
			'quantity'		=> $iii++,
			'product_id'		=> $iii++,
			'manufacturer_id'	=> $iii++,
			'exp_date'		=> $iii++,
			'product_type'		=> $iii++,
			'delete'		=> $iii++,
			'currency'		=> $iii++,
			);
		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_image as v_products_image,
			p.products_price as v_products_price,
			p.products_weight as v_products_weight,
			p.products_date_added as v_date_avail,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity,
			p.manufacturers_id as v_manufacturers_id,
			subc.categories_id as v_categories_id
			FROM
			".TABLE_PRODUCTS." as p,
			".TABLE_CATEGORIES." as subc,
			".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id
			";
		break;

// VJ product attributes begin
	case 'attrib':
		$iii = 0;
		$filelayout = array(
			'v_products_model'		=> $iii++
			);

    $header_array = array();

		$languages = tep_get_languages();

    global $attribute_options_array;

    $attribute_options_count = 1;
    foreach ($attribute_options_array as $attribute_options_values) {
			$key1 = 'v_attribute_options_id_' . $attribute_options_count;
			$header_array[$key1] = $iii++;

			for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
				$l_id = $languages[$i]['id'];

				$key2 = 'v_attribute_options_name_' . $attribute_options_count . '_' . $l_id;
				$header_array[$key2] = $iii++;
			}

			$attribute_values_query = "select products_options_values_id  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";

			$attribute_values_values = tep_db_query($attribute_values_query);

			$attribute_values_count = 1;
				while ($attribute_values = tep_db_fetch_array($attribute_values_values)) {
					$key3 = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key3] = $iii++;

					for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
						$l_id = $languages[$i]['id'];

						$key4 = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $l_id;
						$header_array[$key4] = $iii++;
					}

					$key5 = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key5] = $iii++;
	
//// attributes stock add start        
	if ( $products_attributes_stock	== true ) { 
					$key6 = 'v_attribute_values_stock_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key6] = $iii++;
	}				
//// attributes stock add end 		
					
					$attribute_values_count++;
				}

			$attribute_options_count++;
    }

    $filelayout = array_merge($filelayout, $header_array);

		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model
			FROM
			".TABLE_PRODUCTS." as p
			";

		break;
// VJ product attributes end
	}
	$filelayout_count = count($filelayout);

}


function walk( $item1 ) {
	global $filelayout, $filelayout_count, $modelsize;
	global $active, $inactive, $langcode, $default_these, $deleteit, $zero_qty_inactive;
        global $epdlanguage_id, $price_with_tax, $replace_quotes;
	global $default_images, $default_image_manufacturer, $default_image_product, $default_image_category;
	global $separator, $max_categories;
	// first we clean up the row of data

	// chop blanks from each end
	$item1 = ltrim(rtrim($item1));

	// blow it into an array, splitting on the tabs
	$items = explode($separator, $item1);

	// make sure all non-set things are set to '';
	// and strip the quotes from the start and end of the stings.
	// escape any special chars for the database.
	foreach( $filelayout as $key=> $value){
		$i = $filelayout[$key];
		if (isset($items[$i]) == false) {
			$items[$i]='';
		} else {
			// Check to see if either of the magic_quotes are turned on or off;
			// And apply filtering accordingly.
			if (function_exists('ini_get')) {
				//echo "Getting ready to check magic quotes<br>";
				if (ini_get('magic_quotes_runtime') == 1){
					// The magic_quotes_runtime are on, so lets account for them
					// check if the last character is a quote;
					// if it is, chop off the quotes.
					if (substr($items[$i],-1) == '"'){
						$items[$i] = substr($items[$i],2,strlen($items[$i])-4);
					}
					// now any remaining doubled double quotes should be converted to one doublequote
					$items[$i] = str_replace('\"\"',"&#34",$items[$i]);
					if ($replace_quotes){
						$items[$i] = str_replace('\"',"&#34",$items[$i]);
						$items[$i] = str_replace("\'","&#39",$items[$i]);
					}
				} else { // no magic_quotes are on
					// check if the last character is a quote;
					// if it is, chop off the 1st and last character of the string.
					if (substr($items[$i],-1) == '"'){
						$items[$i] = substr($items[$i],1,strlen($items[$i])-2);
					}
					// now any remaining doubled double quotes should be converted to one doublequote
					$items[$i] = str_replace('""',"&#34",$items[$i]);
					if ($replace_quotes){
						$items[$i] = str_replace('"',"&#34",$items[$i]);
						$items[$i] = str_replace("'","&#39",$items[$i]);
					}
				}
			}
		}
	}
/*
	if ( $items['v_status'] == $deleteit ){
		// they want to delete this product.
		echo "Deleting product " . $items['v_products_model'] . " from the database<br>";
		// Get the ID

		// kill in the products_to_categories

		// Kill in the products table

		return; // we're done deleteing!
	}
*/
	// now do a query to get the record's current contents
	$sql = "SELECT
		p.products_id as v_products_id,
		p.products_model as v_products_model,
		p.products_image as v_products_image,
		p.products_price as v_products_price,
		p.products_weight as v_products_weight,
		p.products_date_added as v_date_avail,
		p.products_tax_class_id as v_tax_class_id,
		p.products_quantity as v_products_quantity,
		p.manufacturers_id as v_manufacturers_id,
		subc.categories_id as v_categories_id
		FROM
		".TABLE_PRODUCTS." as p,
		".TABLE_CATEGORIES." as subc,
		".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
		WHERE
		p.products_id = ptoc.products_id AND
		p.products_model = '" . $items[$filelayout['v_products_model']] . "' AND
		ptoc.categories_id = subc.categories_id
		";

	$result = tep_db_query($sql);
	$row =  tep_db_fetch_array($result);


	while ($row){
		// OK, since we got a row, the item already exists.
		// Let's get all the data we need and fill in all the fields that need to be defaulted to the current values
		// for each language, get the description and set the vals
		foreach ($langcode as $key => $lang){
			//echo "Inside defaulting loop";
			//echo "key is $key<br>";
			//echo "langid is " . $lang['id'] . "<br>";
//			$sql2 = "SELECT products_name, products_description
//				FROM ".TABLE_PRODUCTS_DESCRIPTION."
//				WHERE
//					products_id = " . $row['v_products_id'] . " AND
//					language_id = '" . $lang['id'] . "'
//				";
			$sql2 = "SELECT *
				FROM ".TABLE_PRODUCTS_DESCRIPTION."
				WHERE
					products_id = " . $row['v_products_id'] . " AND
					language_id = '" . $lang['id'] . "'
				";
			$result2 = tep_db_query($sql2);
			$row2 =  tep_db_fetch_array($result2);
                        // Need to report from ......_name_1 not ..._name_0
			$row['v_products_name_' . $lang['id']] 		= $row2['products_name'];
			$row['v_products_description_' . $lang['id']] 	= $row2['products_description'];
			$row['v_products_url_' . $lang['id']] 		= $row2['products_url'];

			// support for Linda's Header Controller 2.0 here
			if(isset($filelayout['v_products_head_title_tag_' . $lang['id'] ])){
				$row['v_products_head_title_tag_' . $lang['id']] 	= $row2['products_head_title_tag'];
				$row['v_products_head_desc_tag_' . $lang['id']] 	= $row2['products_head_desc_tag'];
				$row['v_products_head_keywords_tag_' . $lang['id']] 	= $row2['products_head_keywords_tag'];
			}
			// end support for Header Controller 2.0
		}

		// start with v_categories_id
		// Get the category description
		// set the appropriate variable name
		// if parent_id is not null, then follow it up.
		$thecategory_id = $row['v_categories_id'];

		for( $categorylevel=1; $categorylevel<$max_categories+1; $categorylevel++){
			if ($thecategory_id){
				$sql2 = "SELECT categories_name
					FROM ".TABLE_CATEGORIES_DESCRIPTION."
					WHERE
						categories_id = " . $thecategory_id . " AND
						language_id = " . $epdlanguage_id ;

				$result2 = tep_db_query($sql2);
				$row2 =  tep_db_fetch_array($result2);
				// only set it if we found something
				$temprow['v_categories_name_' . $categorylevel] = $row2['categories_name'];
				// now get the parent ID if there was one
				$sql3 = "SELECT parent_id
					FROM ".TABLE_CATEGORIES."
					WHERE
						categories_id = " . $thecategory_id;
				$result3 = tep_db_query($sql3);
				$row3 =  tep_db_fetch_array($result3);
				$theparent_id = $row3['parent_id'];
				if ($theparent_id != ''){
					// there was a parent ID, lets set thecategoryid to get the next level
					$thecategory_id = $theparent_id;
				} else {
					// we have found the top level category for this item,
					$thecategory_id = false;
				}
			} else {
					$temprow['v_categories_name_' . $categorylevel] = '';
			}
		}
		// temprow has the old style low to high level categories.
		$newlevel = 1;
		// let's turn them into high to low level categories
		for( $categorylevel=$max_categories+1; $categorylevel>0; $categorylevel--){
			if ($temprow['v_categories_name_' . $categorylevel] != ''){
				$row['v_categories_name_' . $newlevel++] = $temprow['v_categories_name_' . $categorylevel];
			}
		}

		if ($row['v_manufacturers_id'] != ''){
			$sql2 = "SELECT manufacturers_name
				FROM ".TABLE_MANUFACTURERS."
				WHERE
				manufacturers_id = " . $row['v_manufacturers_id']
				;
			$result2 = tep_db_query($sql2);
			$row2 =  tep_db_fetch_array($result2);
			$row['v_manufacturers_name'] = $row2['manufacturers_name'];
		}

		//elari -
		//We check the value of tax class and title instead of the id
		//Then we add the tax to price if $price_with_tax is set to true
		$row_tax_multiplier = tep_get_tax_class_rate($row['v_tax_class_id']);
		$row['v_tax_class_title'] = tep_get_tax_class_title($row['v_tax_class_id']);
		if ($price_with_tax){
			$row['v_products_price'] = round($row['v_products_price'] + ($row['v_products_price'] * $row_tax_multiplier / 100),2);
		}

		// now create the internal variables that will be used
		// the $$thisvar is on purpose: it creates a variable named what ever was in $thisvar and sets the value
		foreach ($default_these as $thisvar){
			$$thisvar	= $row[$thisvar];
		}

		$row =  tep_db_fetch_array($result);
	}

	// this is an important loop.  What it does is go thru all the fields in the incoming file and set the internal vars.
	// Internal vars not set here are either set in the loop above for existing records, or not set at all (null values)
	// the array values are handled separatly, although they will set variables in this loop, we won't use them.
	foreach( $filelayout as $key => $value ){
		$$key = $items[ $value ];
	}

        // so how to handle these?  we shouldn't built the array unless it's been giving to us.
	// The assumption is that if you give us names and descriptions, then you give us name and description for all applicable languages
	foreach ($langcode as $lang){
		//echo "Langid is " . $lang['id'] . "<br>";
		$l_id = $lang['id'];
		if (isset($filelayout['v_products_name_' . $l_id ])){
			//we set dynamically the language values
			$v_products_name[$l_id] 	= $items[$filelayout['v_products_name_' . $l_id]];
			$v_products_description[$l_id] 	= $items[$filelayout['v_products_description_' . $l_id ]];
			$v_products_url[$l_id] 		= $items[$filelayout['v_products_url_' . $l_id ]];
			// support for Linda's Header Controller 2.0 here
			if(isset($filelayout['v_products_head_title_tag_' . $l_id])){
				$v_products_head_title_tag[$l_id] 	= $items[$filelayout['v_products_head_title_tag_' . $l_id]];
				$v_products_head_desc_tag[$l_id] 	= $items[$filelayout['v_products_head_desc_tag_' . $l_id]];
				$v_products_head_keywords_tag[$l_id] 	= $items[$filelayout['v_products_head_keywords_tag_' . $l_id]];
			}
			// end support for Header Controller 2.0
		}
	}
	//elari... we get the tax_clas_id from the tax_title
	//on screen will still be displayed the tax_class_title instead of the id....
	if ( isset( $v_tax_class_title) ){
		$v_tax_class_id          = tep_get_tax_title_class_id($v_tax_class_title);
	}
	//we check the tax rate of this tax_class_id
        $row_tax_multiplier = tep_get_tax_class_rate($v_tax_class_id);

	//And we recalculate price without the included tax...
	//Since it seems display is made before, the displayed price will still include tax
	//This is same problem for the tax_clas_id that display tax_class_title
	if ($price_with_tax){
		$v_products_price        = round( $v_products_price / (1 + ( $row_tax_multiplier * $price_with_tax/100) ), 4);
	}

	// if they give us one category, they give us all 6 categories
	unset ($v_categories_name); // default to not set.
	if ( isset( $filelayout['v_categories_name_1'] ) ){
		$newlevel = 1;
		for( $categorylevel=6; $categorylevel>0; $categorylevel--){
			if ( $items[$filelayout['v_categories_name_' . $categorylevel]] != ''){
				$v_categories_name[$newlevel++] = $items[$filelayout['v_categories_name_' . $categorylevel]];
			}
		}
		while( $newlevel < $max_categories+1){
			$v_categories_name[$newlevel++] = ''; // default the remaining items to nothing
		}
	}

	if (ltrim(rtrim($v_products_quantity)) == '') {
		$v_products_quantity = 1;
	}
	if ($v_date_avail == '') {
		$v_date_avail = "CURRENT_TIMESTAMP";
		$v_date_avail = "NULL";
	} else {
		// we put the quotes around it here because we can't put them into the query, because sometimes
		//   we will use the "current_timestamp", which can't have quotes around it.
		$v_date_avail = '"' . $v_date_avail . '"';
	}

	if ($v_date_added == '') {
		$v_date_added = "CURRENT_TIMESTAMP";
	} else {
		// we put the quotes around it here because we can't put them into the query, because sometimes
		//   we will use the "current_timestamp", which can't have quotes around it.
		$v_date_added = '"' . $v_date_added . '"';
	}


	// default the stock if they spec'd it or if it's blank
	$v_db_status = '1'; // default to active
	if ($v_status == $inactive){
		// they told us to deactivate this item
		$v_db_status = '0';
	}
	if ($zero_qty_inactive && $v_products_quantity == 0) {
		// if they said that zero qty products should be deactivated, let's deactivate if the qty is zero
		$v_db_status = '0';
	}

	if ($v_manufacturer_id==''){
		$v_manufacturer_id="NULL";
	}

	if (trim($v_products_image)==''){
		$v_products_image = $default_image_product;
	}

	if (strlen($v_products_model) > $modelsize ){
		echo "<font color='red'>" . strlen($v_products_model) . $v_products_model . "... ERROR! - Too many characters in the model number.<br>
			12 is the maximum on a standard OSC install.<br>
			Your maximum product_model length is set to $modelsize<br>
			You can either shorten your model numbers or increase the size of the field in the database.</font>";
		die();
	}

	// OK, we need to convert the manufacturer's name into id's for the database
	if ( isset($v_manufacturers_name) && $v_manufacturers_name != '' ){
		$sql = "SELECT man.manufacturers_id
			FROM ".TABLE_MANUFACTURERS." as man
			WHERE
				man.manufacturers_name = '" . $v_manufacturers_name . "'";
		$result = tep_db_query($sql);
		$row =  tep_db_fetch_array($result);
		if ( $row != '' ){
			foreach( $row as $item ){
				$v_manufacturer_id = $item;
			}
		} else {
			// to add, we need to put stuff in categories and categories_description
			$sql = "SELECT MAX( manufacturers_id) max FROM ".TABLE_MANUFACTURERS;
			$result = tep_db_query($sql);
			$row =  tep_db_fetch_array($result);
			$max_mfg_id = $row['max']+1;
			// default the id if there are no manufacturers yet
			if (!is_numeric($max_mfg_id) ){
				$max_mfg_id=1;
			}

			// Uncomment this query if you have an older 2.2 codebase
			/*
			$sql = "INSERT INTO ".TABLE_MANUFACTURERS."(
				manufacturers_id,
				manufacturers_name,
				manufacturers_image
				) VALUES (
				$max_mfg_id,
				'$v_manufacturers_name',
				'$default_image_manufacturer'
				)";
			*/

			// Comment this query out if you have an older 2.2 codebase
			$sql = "INSERT INTO ".TABLE_MANUFACTURERS."(
				manufacturers_id,
				manufacturers_name,
				manufacturers_image,
				date_added,
				last_modified
				) VALUES (
				$max_mfg_id,
				'$v_manufacturers_name',
				'$default_image_manufacturer',
				CURRENT_TIMESTAMP,
				CURRENT_TIMESTAMP
				)";
			$result = tep_db_query($sql);
			$v_manufacturer_id = $max_mfg_id;
		}
	}
	// if the categories names are set then try to update them
	if ( isset($v_categories_name_1)){
		// start from the highest possible category and work our way down from the parent
		$v_categories_id = 0;
		$theparent_id = 0;
		for ( $categorylevel=$max_categories+1; $categorylevel>0; $categorylevel-- ){
			$thiscategoryname = $v_categories_name[$categorylevel];
   
   
      $thiscategoryname = ereg_replace("(ó)", 'o', $thiscategoryname);
      $thiscategoryname = ereg_replace("(á)", 'a', $thiscategoryname);
      $thiscategoryname = ereg_replace("(é)", 'e', $thiscategoryname);
      $thiscategoryname = ereg_replace("(í)", 'i', $thiscategoryname);
      $thiscategoryname = ereg_replace("(ú)", 'u', $thiscategoryname);
   
			if ( $thiscategoryname != ''){
				// we found a category name in this field
    
    
                       //seguridad
                             $row =  tep_db_fetch_array($result);
                             if ($row['products_status_exel']){
                             $status_exel = $row['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }
                       //seguridad products_status_exel
                              if ($vv_seguridad == 5 and $status_exel == 1){
// now the subcategory
				$sql = "SELECT cat.categories_id
					FROM ".TABLE_CATEGORIES." as cat, 
					     ".TABLE_CATEGORIES_DESCRIPTION." as des
					WHERE
						cat.categories_id = des.categories_id AND
						des.language_id = $epdlanguage_id AND
						cat.parent_id = " . $theparent_id . " AND
						des.categories_name = '" . $thiscategoryname . "'";
				$result = tep_db_query($sql);
				$row =  tep_db_fetch_array($result);
				if ( $row != '' ){
					foreach( $row as $item ){
						$thiscategoryid = $item;
					}
				} else {


					// to add, we need to put stuff in categories and categories_description
					$sql = "SELECT MAX( categories_id) max FROM ".TABLE_CATEGORIES;
					$result = tep_db_query($sql);
					$row =  tep_db_fetch_array($result);
					$max_category_id = $row['max']+1;
					if (!is_numeric($max_category_id) ){
						$max_category_id=1;
					}
     

					$sql = "INSERT INTO ".TABLE_CATEGORIES."(
						categories_id,
						categories_image,
						parent_id,
						sort_order,
						date_added,
						last_modified
						) VALUES (
						$max_category_id,
						'$default_image_category',
						$theparent_id,
						0,
						CURRENT_TIMESTAMP
						,CURRENT_TIMESTAMP
						)";
					$result = tep_db_query($sql);
					$sql = "INSERT INTO ".TABLE_CATEGORIES_DESCRIPTION."(
							categories_id,
							language_id,
							categories_name
						) VALUES (
							$max_category_id,
							'$epdlanguage_id',
							'$thiscategoryname'
						)";
					$result = tep_db_query($sql);
					$thiscategoryid = $max_category_id;
     

     
				}
				// the current catid is the next level's parent
				$theparent_id = $thiscategoryid;
				$v_categories_id = $thiscategoryid; // keep setting this, we need the lowest level category ID later
			}
		}
	}
     } // seguridad
	if ($v_products_model != "") {
		//   products_model exists!
		array_walk($items, 'print_el');

		// First we check to see if this is a product in the current db.
		$result = tep_db_query("SELECT products_id FROM ".TABLE_PRODUCTS." WHERE (products_model = '". $v_products_model . "')");

		if (tep_db_num_rows($result) == 0)  {
			//   insert into products

			$sql = "SHOW TABLE STATUS LIKE '".TABLE_PRODUCTS."'";
			$result = tep_db_query($sql);
			$row =  tep_db_fetch_array($result);
			$max_product_id = $row['Auto_increment'];
			if (!is_numeric($max_product_id) ){
				$max_product_id=1;
			}
			$v_products_id = $max_product_id;
			echo "<font color='green'> !New Product!</font><br>";

        if ($price_with_tax == false){
          $v_products_price == 0;
                   }
                   
                   

                   
                   
$time1 = mktime(1, 1, 1, date("m")-$menos_tiempo_meses, date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

$time2 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday2 = date("Y-m-d", $time2);


if ($vv_stock_nivel){

}else{
  $vv_stock_nivel = 1;
}

     if ( $vv_codigodebarras == 0){
      $vv_codigodebarras = 'nd';
  }
                       //seguridad
                             $row =  tep_db_fetch_array($result);
                             if ($row['products_status_exel']){
                             $status_exel = $row['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }
                             
                // ELIMINA LOS DOS ULITMOS NUMEROS DE LA REFERENCIA.
                if ( $vv_codigo_proveedor == 653762 ){

   $vv_products_cpe = ereg_replace("[0-9]{2}$", "", "$v_products_model");

                                                 }

                                              // echo  $vv_products_cpe;
                             
                       //seguridad products_status_exel
                              if ($vv_seguridad == 5 and $status_exel == 1){

              $sql_data_array = array('products_image' => $v_products_image,
                              'products_model' => $v_products_model,
                              'products_last_modified' => $oldday2,
                              'modificar_producto' => $vv_modificar_producto,
                              'products_date_added' => $oldday1,
                              'nobuscar' => $vv_nobuscar,
                              'stock_nivel' => $vv_stock_nivel,
                              'products_cpe' => $vv_products_cpe,
                              'products_cpf' => $vv_products_cpf,
                              'products_regladeprecios' => $vv_regladeprecios,
                              'stock_disponible_proveedor' => $vv_stock_disponible,
                              'referencia_fabricante' => $vv_referencia_fabricante,
                              'filtro' => $vv_filtro,
                             // 'easypopulate_time2' => time(),
                              'costo' => $vv_costo,
                              'pdf' => $vv_pdf,
                              'products_extrapeso_precio' => $vv_products_extrapeso_precio,
                              'proveedor' => $vv_proveedor,
                              'proveedor_price_general' => $vv_customers_group_price_2,
                              'codigo_proveedor' => $vv_codigo_proveedor,
                              'codigo_barras' => $vv_codigodebarras,
                              'priceminister' => $vv_priceminister,
                              'referencia_fabricante' => $vv_referencia_fabricante,
                              'proveedes' => $vv_proveedes,
                              'grupo_comision' => $vv_grupo_comision,
                              'products_date_available' => $v_date_avail,
                              'products_tax_class_id' => $v_tax_class_id,
                              'products_weight' => $v_products_weight,
                              'products_price_sin' => $v_products_price,
                              'products_quantity' => $v_products_quantity,
                              'opcion_1' => $vv_opcion_1,
                              'opcion_1_1' => $vv_opcion_1_1,
                              'opcion_2' => $vv_opcion_2,
                              'opcion_2_2' => $vv_opcion_2_2,
                              'opcion_3' => $vv_opcion_3,
                              'opcion_3_3' => $vv_opcion_3_3,
                              'opcion_4' => $vv_opcion_4,
                              'opcion_4_4' => $vv_opcion_4_4,
                              'opcion_5' => $vv_opcion_5,
                              'opcion_5_5' => $vv_opcion_5_5,
                              'opcion_6' => $vv_opcion_6,
                              'opcion_6_6' => $vv_opcion_6_6,
                              'opcion_7' => $vv_opcion_7,
                              'opcion_7_7' => $vv_opcion_7_7,
                              'opcion_8' => $vv_opcion_8,
                              'opcion_8_8' => $vv_opcion_8_8,
                              'opcion_9' => $vv_opcion_9,
                              'opcion_9_9' => $vv_opcion_9_9,
                              'opcion_10' => $vv_opcion_10,
                              'opcion_10_10' => $vv_opcion_10_10,
                              'manufacturers_id' => $v_manufacturer_id);

      if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;
      if ($vv_customers_group_price_2 <> 0) $sql_data_array['proveedor_price_general'] = $vv_customers_group_price_2;




      
      
       tep_db_perform(TABLE_PRODUCTS, $sql_data_array);
           $insert_id = tep_db_insert_id();

              } // SEGURIDAD
              
              


              
       
   //  $specials_values = mysql_query("select * from " . TABLE_SPECIALS . " where products_id = '" . $insert_id . "' and  status = '" . 1 . "'");
   // if ($specials = mysql_fetch_array($specials_values)){     }

       
     if  ($vv_specials == 1){

     $wersdf_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_model = '" . $v_products_model . "'");
     $wersdf = tep_db_fetch_array($wersdf_values);

    $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

       // calcula precio costos
       if  ($wersdfs['costo'] == 2){

       $v_products_price = $vv_customers_group_price_2 * 9 / 100 + $vv_customers_group_price_2;


   }
       if ($v_products_price == 0){
         $v_products_price = $wersdf['products_price'];
   }

                               //seguridad products_status_exel


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

  $sql_data_array = array('products_id' => $wersdf['products_id'],
                                    'specials_date_added' => $oldday1,
                                    'specials_last_modified' => $oldday1,
                                    'expires_date' => $vv_expires_date,
                                    'status' => $vv_specials,);

if ($v_products_price <> 0) $sql_data_array['specials_new_products_price'] = $v_products_price;
 if ($vv_specials_new_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $vv_specials_new_products_price;


          tep_db_perform(TABLE_SPECIALS, $sql_data_array);
                                   } // SEGURIDAD

                   } // fin vv_specials


                         //seguridad products_status_exel
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
               tep_db_query("delete from " . TABLE_SPECIALS . " where status = '" .  0 . "' and products_id = '" . $v_products_id . "'");
                                  }// SEGURIDAD
       

} else {
			// existing product, get the id from the query
			// and update the product data
			$row =  tep_db_fetch_array($result);
			$v_products_id = $row['products_id'];
			echo "<font color='black'> Updated</font><br>";
			$row =  tep_db_fetch_array($result);
   
      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

          if ($vv_stock_nivel){

}else{
  $vv_stock_nivel = 1;
}




// si el precio es un numero ejecuto el siguiente codigo
 if ($v_products_price){




      $seguimiento_precios_primero_values = tep_db_query("select * from " . 'products_seguimientos_precios' . " where products_id = '" . $v_products_id . "'");
   if  ($seguimiento_precios_primero = tep_db_fetch_array($seguimiento_precios_primero_values)){

                                                                                                                                                                                           // products_last_modified
      $seguimiento_precios_masdeunavez_values = tep_db_query("select * from " . 'products_seguimientos_precios' . " psp, " . 'products' . " p where p.products_id = psp.products_id and p.products_last_modified = '" . $oldday1 . "' and psp.products_id = '" . $v_products_id . "' order by psp.fecha ASC");
   if  ($seguimiento_precios_masdeunavez = tep_db_fetch_array($seguimiento_precios_masdeunavez_values)){

                                           $row =  tep_db_fetch_array($result);
                                               //seguridad
                       //seguridad products_status_exel
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

       tep_db_query("delete from " . 'products_seguimientos_precios' . " where fecha = '" .  $oldday1 . "' and products_id = '" . $v_products_id . "'");

          $sql_data_array = array('products_id' => $v_products_id,
                              'fecha' => $oldday1,
                              'precio' => $v_products_price);
      tep_db_perform('products_seguimientos_precios', $sql_data_array);

                                           } // SEGURIDAD
}else{

 } // $seguimiento_precios_masdeunavez




}else{

 //  la primera vez que se inserta un precio con mismo products_id
                                                   $row =  tep_db_fetch_array($result);
                                                 //seguridad
      $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

       $sql_data_array = array('products_id' => $v_products_id,
                              'fecha' => $oldday1,
                              'precio' => $v_products_price);
      tep_db_perform('products_seguimientos_precios', $sql_data_array);

                                 } // SEGURIDAD


} //$v_products_price
} // $seguimiento_precios_primero




                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 //    and p.modificar_precio_siempre = '" . 1 . "'
      // SI EL PRODUCTO LO TENEMOS EN STOCK NO MODIFICA NI EL STATUS NI EL PRECIO
      
     $orders_values = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p, " . 'administrators' . " a, " . TABLE_ORDERS_PRODUCTS . " op where o.orders_id = op.orders_id and op.products_id = '" . $v_products_id . "' and p.products_id = '" . $v_products_id . "' and o.orders_status = a.abono and op.products_quantity >= 1 ");
   if ($vvvorders = tep_db_fetch_array($orders_values)){

  if ( $vv_codigodebarras == 0){
      $vv_codigodebarras = 'nd';
  }


  
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

       // calcula precio costos
       if  ($wersdfs['costo'] == 2){

       $v_products_price = $vv_customers_group_price_2 * 9 / 100 + $vv_customers_group_price_2;


   }

                           // si el codigo del proveedor es de euroconsolas la regla de precio no cambia
               if ($vv_codigo_proveedor == 1){
                                                        //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
//chivato
                                   echo 'producto-a1';
      $sql_data_array = array('products_image' => $v_products_image,
                              'products_weight' => $v_products_weight,
                              'products_balance_stock_control' => $vv_products_balance_stock_control,
                              'products_quantity' => $v_products_quantity,
                              'nobuscar' => $vv_nobuscar,
                              'products_tax_class_id' => $v_tax_class_id,
                              'grupo_comision' => $vv_grupo_comision,
                              'modificar_precio_siempre' => $vv_modificar_precio_siempre,
                              'modificar_producto' => $vv_modificar_producto,
                              'stock_nivel' => $vv_stock_nivel,
                              'filtro' => $vv_filtro,
                              'costo' => $vv_costo,
                              'pdf' => $vv_pdf,
                              'products_extrapeso_precio' => $vv_products_extrapeso_precio,
                              'proveedor' => $vv_proveedor,
                              'products_regladeprecios' => $vv_regladeprecios,
                              'proveedes' => $vv_proveedes,
                              'codigo_proveedor' => $vv_codigo_proveedor,
                              'codigo_barras' => $vv_codigodebarras,
                              'priceminister' => $vv_priceminister,
                             // 'referencia_fabricante' => $vv_referencia_fabricante,
                              'products_date_available' => $v_date_avail,
                              'products_last_modified' => $oldday1,
                              'manufacturers_id' => $v_manufacturer_id);

         if ($vv_products_cpe) $sql_data_array['products_cpe'] = $vv_products_cpe;
         if ($vv_products_cpf) $sql_data_array['products_cpe'] = $vv_products_cpf;
         if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;
         if ($vv_customers_group_price_2 <> 0) $sql_data_array['proveedor_price_general'] = $vv_customers_group_price_2;
         if ($v_manufacturers_name) $sql_data_array['manufacturers_name'] = $v_manufacturers_name;
         if ($vv_referencia_fabricante) $sql_data_array['referencia_fabricante'] = $vv_referencia_fabricante;

     tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $v_products_id . "'");
                                } // SEGURIDAD
     
                             }else{



                             if ($vv_stock_nivel == 6){
                          $vvv_stock_nivel  = 6;
                         }else{
                         $vvv_stock_nivel  = 4;
                     }
                     
                     
                     
                             if ($vv_stock_nivel == 6){
                          $vvv_db_status  = $v_db_status;
                         }else{
                         $vvv_db_status  = 1;
                     }
                     


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
                                   //chivato
                                   echo 'producto-b1';
      $sql_data_array = array('products_image' => $v_products_image,
                              'products_weight' => $v_products_weight,
                              'products_balance_stock_control' => $vv_products_balance_stock_control,
                              'products_quantity' => $v_products_quantity,
                              'nobuscar' => $vv_nobuscar,
                              'products_tax_class_id' => $v_tax_class_id,
                              'grupo_comision' => $vv_grupo_comision,
                              'modificar_precio_siempre' => $vv_modificar_precio_siempre,
                              'modificar_producto' => $vv_modificar_producto,
                              'stock_nivel' => $vvv_stock_nivel,
                              'filtro' => $vv_filtro,
                              'costo' => $vv_costo,
                              'pdf' => $vv_pdf,
                              'products_extrapeso_precio' => $vv_products_extrapeso_precio,
                              'proveedor' => $vv_proveedor,
                              'products_regladeprecios' => $vv_regladeprecios,
                              'proveedes' => $vv_proveedes,
                              'codigo_proveedor' => $vv_codigo_proveedor,
                              'codigo_barras' => $vv_codigodebarras,
                              'priceminister' => $vv_priceminister,
                           //   'referencia_fabricante' => $vv_referencia_fabricante,
                              'products_date_available' => $v_date_avail,
                              'products_last_modified' => $oldday1,
                              'manufacturers_id' => $v_manufacturer_id);

         if ($vv_products_cpe) $sql_data_array['products_cpe'] = $vv_products_cpe;
         if ($vv_products_cpf) $sql_data_array['products_cpe'] = $vv_products_cpf;
         if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;
         if ($vv_customers_group_price_2 <> 0) $sql_data_array['proveedor_price_general'] = $vv_customers_group_price_2;
         if ($v_manufacturers_name) $sql_data_array['manufacturers_name'] = $v_manufacturers_name;
         if ($vv_referencia_fabricante) $sql_data_array['referencia_fabricante'] = $vv_referencia_fabricante;

     tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $v_products_id . "'");
                               } // SEGURIDAD

                         }//fin
     
     
     
     
     

         // provisional
      
   //   if ($vv_modificar_producto == 1){

     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }

                                       $products_price_sin = $v_products_price;

                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

          $sql_status_update_array = array('products_regladeprecios' => $vv_regladeprecios);
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");
                                                            } // SEGURIDAD


               $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

             $regladeprecios_values = mysql_query("select * from " . 'products_regladeprecios' . " where regladeprecios= '" . $wersdfs['products_regladeprecios'] . "' and menor <= '" . $v_products_price . "' ORDER BY menor DESC");
    if ($regladeprecios= mysql_fetch_array($regladeprecios_values)){

                 // ejecuta la tabla de precios correspondiente y suma al precio de PVP el porcentaje especificado.
       //   if ($v_products_price >= $regladeprecios['menor'] and $v_products_price <=  $regladeprecios['mayor']){
            $v_products_price  =  $v_products_price * $regladeprecios['porcent_value'] / 100 + $v_products_price;

          //   }


         }


       // calcula precio costos
       if  ($wersdfs['costo'] == 2){

       $v_products_price = $vv_customers_group_price_2 * 9 / 100 + $vv_customers_group_price_2;


   }


       if ($v_products_price == 0){
         $v_products_price = $wersdfs['products_price'];
   }
   
                                                               //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
                                             echo 'producto-3';

           $sql_status_update_array = array('specials_last_modified' => $oldday1,
                                            'expires_date' => $vv_expires_date,
                                            'status' => $vv_specials,);

                            if ($v_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $v_products_price;
                            if ($vv_specials_new_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $vv_specials_new_products_price;


            tep_db_perform(TABLE_SPECIALS, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");

            
            

          tep_db_query("delete from " . TABLE_SPECIALS . " where status = '" .  0 . "' and products_id = '" . $v_products_id . "'");
          
                                            } // SEGURIDAD
          


  if ( $vv_codigodebarras == 0){
      $vv_codigodebarras = 'nd';
  }


           $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

       // calcula precio costos
       if  ($wersdfs['costo'] == 2){

       $v_products_price = $vv_customers_group_price_2 * 9 / 100 + $vv_customers_group_price_2;


   }
   
   
   

                           // si el codigo del proveedor es de euroconsolas la regla de precio no cambia
               if ($vv_codigo_proveedor == 1){

   
                                                      //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
                                            //chivato
                                   echo 'producto-2';
                                   
                                   
      $sql_data_array = array('products_image' => $v_products_image,
                              'products_weight' => $v_products_weight,
                              'products_balance_stock_control' => $vv_products_balance_stock_control,
                              'modificar_precio_siempre' => $vv_modificar_precio_siempre,
                              'modificar_producto' => $vv_modificar_producto,
                              'products_quantity' => $v_products_quantity,
                              'nobuscar' => $vv_nobuscar,
                              'products_tax_class_id' => $v_tax_class_id,
                              'grupo_comision' => $vv_grupo_comision,
                              
                              'stock_nivel' => $vv_stock_nivel,

                               'filtro' => $vv_filtro,
                              'costo' => $vv_costo,
                              'pdf' => $vv_pdf,
                              'products_extrapeso_precio' => $vv_products_extrapeso_precio,
                              'proveedor' => $vv_proveedor,
                              'proveedes' => $vv_proveedes,
                              'codigo_proveedor' => $vv_codigo_proveedor,
                              'codigo_barras' => $vv_codigodebarras,
                              'priceminister' => $vv_priceminister,
                             // 'referencia_fabricante' => $vv_referencia_fabricante,
                              'products_date_available' => $v_date_avail,
                              'products_last_modified' => $oldday1,
                              'manufacturers_id' => $v_manufacturer_id);

         if ($vv_products_cpe) $sql_data_array['products_cpe'] = $vv_products_cpe;
         if ($vv_products_cpf) $sql_data_array['products_cpe'] = $vv_products_cpf;
         if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;
         if ($vv_customers_group_price_2 <> 0) $sql_data_array['proveedor_price_general'] = $vv_customers_group_price_2;
         if ($v_manufacturers_name) $sql_data_array['manufacturers_name'] = $v_manufacturers_name;
         if ($vv_referencia_fabricante) $sql_data_array['referencia_fabricante'] = $vv_referencia_fabricante;

      tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $v_products_id . "'");


                               } // SEGURIDAD

  }else{



      //chivato
                                   echo 'producto-2';



                             if ($vv_stock_nivel == 6){
                          $vvv_stock_nivel  = 6;
                         }else{
                         $vvv_stock_nivel  = 4;
                     }


                             if ($vv_stock_nivel == 6){
                          $vvv_db_status  = $v_db_status;
                         }else{
                         $vvv_db_status  = 1;
                     }


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

      $sql_data_array = array('products_image' => $v_products_image,
                              'products_weight' => $v_products_weight,
                              'products_status' => $vvv_db_status,
                              'products_balance_stock_control' => $vv_products_balance_stock_control,
                              'modificar_precio_siempre' => $vv_modificar_precio_siempre,
                              'modificar_producto' => $vv_modificar_producto,
                              'products_quantity' => $v_products_quantity,
                              'nobuscar' => $vv_nobuscar,
                              'products_tax_class_id' => $v_tax_class_id,
                              'grupo_comision' => $vv_grupo_comision,
                              'stock_nivel' => $vvv_stock_nivel,
                              'filtro' => $vv_filtro,
                              'costo' => $vv_costo,
                              'pdf' => $vv_pdf,
                              'products_extrapeso_precio' => $vv_products_extrapeso_precio,
                              'proveedor' => $vv_proveedor,
                              'proveedes' => $vv_proveedes,
                              'codigo_proveedor' => $vv_codigo_proveedor,
                              'codigo_barras' => $vv_codigodebarras,
                              'priceminister' => $vv_priceminister,
                           //   'referencia_fabricante' => $vv_referencia_fabricante,
                              'products_date_available' => $v_date_avail,
                              'products_last_modified' => $oldday1,
                              'manufacturers_id' => $v_manufacturer_id);

         if ($vv_products_cpe) $sql_data_array['products_cpe'] = $vv_products_cpe;
         if ($vv_products_cpf) $sql_data_array['products_cpe'] = $vv_products_cpf;
         if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;
         if ($vv_customers_group_price_2 <> 0) $sql_data_array['proveedor_price_general'] = $vv_customers_group_price_2;
         if ($v_manufacturers_name) $sql_data_array['manufacturers_name'] = $v_manufacturers_name;
          if ($vv_referencia_fabricante) $sql_data_array['referencia_fabricante'] = $vv_referencia_fabricante;

      tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $v_products_id . "'");

                            } // SEGURIDAD


    } // fin s







     //provisional

 // }  // fin  vv_modificar_producto
  
  
  

      
 // SI NO LO TENEMOS SE MODICA COMO SIEMPRE.
}else{
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }

                                  $products_price_sin = $v_products_price;

                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

            $sql_status_update_array = array('products_regladeprecios' => $vv_regladeprecios);
            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");

                                              } // SEGURIDAD

               $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

             $regladeprecios_values = mysql_query("select * from " . 'products_regladeprecios' . " where regladeprecios= '" . $wersdfs['products_regladeprecios'] . "' and menor <= '" . $v_products_price . "' ORDER BY menor DESC");
    if ($regladeprecios= mysql_fetch_array($regladeprecios_values)){

                 // ejecuta la tabla de precios correspondiente y suma al precio de PVP el porcentaje especificado.
       //   if ($v_products_price >= $regladeprecios['menor'] and $v_products_price <=  $regladeprecios['mayor']){
            $v_products_price  =  $v_products_price * $regladeprecios['porcent_value'] / 100 + $v_products_price;

          //   }


         }

















     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

       // calcula precio costos
       if  ($wersdfs['costo'] == 2){

       $v_products_price = $vv_customers_group_price_2 * 9 / 100 + $vv_customers_group_price_2;


   }



                      if ($v_products_price == 0){
         $v_products_price = $wersdfs['products_price'];
   }

                                                      //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

           $sql_status_update_array = array('specials_last_modified' => $oldday1,
                                            'expires_date' => $vv_expires_date,
                                            'status' => $vv_specials,);
                                            
                            if ($v_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $v_products_price;
                            if ($vv_specials_new_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $vv_specials_new_products_price;

                                            
            tep_db_perform(TABLE_SPECIALS, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");
                                    } // SEGURIDAD

  if ( $vv_codigodebarras == 0){
      $vv_codigodebarras = 'nd';
  }


            $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);
      // calcula precio costos
       if  ($wersdfs['costo'] == 2){

       $v_products_price = $vv_customers_group_price_2 * 9 / 100 + $vv_customers_group_price_2;


   }
   
   
   
 //	if ($v_status == $Inactive){
		// they told us to deactivate this item
	//	$v_db_status = '0';
	//}
   
   
   
   
   
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }
                             
                             
                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;
                                    
                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;
                                                             
                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }
                             


                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){


                                   
                                   
                      if ($vv_reglascat == 1){

                      $vv_stock_nivel = 1;
                      $vv_regladeprecios = 1;


                  }

                 // ELIMINA LOS DOS ULITMOS NUMEROS DE LA REFERENCIA.
                if ( $vv_codigo_proveedor == 653762 ){

   $vv_products_cpe = ereg_replace("[0-9]{2}$", "", "$v_products_model");

                                                 }

                                              // echo  $vv_products_cpe;

      $sql_data_array = array('manufacturers_id' => $v_manufacturer_id,
                              'modificar_categoria_rdc' => $vv_modificar_categoria_rdc,
                              'easypopulate_time2' => time());














                           //   'referencia_fabricante' => $vv_referencia_fabricante,

                         /*
                             'products_image' => $v_products_image,
                              'products_weight' => $v_products_weight,
                              'products_status' => $v_db_status,
                              'products_balance_stock_control' => $vv_products_balance_stock_control,
                              'products_quantity' => $v_products_quantity,
                              'nobuscar' => $vv_nobuscar,
                              'modificar_precio_siempre' => $vv_modificar_precio_siempre,
                              'modificar_producto' => $vv_modificar_producto,
                              'products_tax_class_id' => $v_tax_class_id,
                              'grupo_comision' => $vv_grupo_comision,
                              'stock_nivel' => $vv_stock_nivel,
                              'filtro' => $vv_filtro,
                              'products_extrapeso_precio' => $vv_products_extrapeso_precio,
                              'costo' => $vv_costo,
                              'proveedor' => $vv_proveedor,
                              'proveedes' => $vv_proveedes,
                              'codigo_barras' => $vv_codigodebarras,
                              'priceminister' => $vv_priceminister,
                           //   'referencia_fabricante' => $vv_referencia_fabricante,
                              'codigo_proveedor' => $vv_codigo_proveedor,
                              'products_date_available' => $v_date_avail,
                              'products_last_modified' => $oldday1,
                              'manufacturers_id' => $v_manufacturer_id);

                                  */




         if ($v_products_image <> $sql_data_array['products_image']) $sql_data_array['products_image'] = $v_products_image;
         if ($v_products_weight <> $sql_data_array['products_weight']) $sql_data_array['products_weight'] = $v_products_weight;
         if ($vv_products_balance_stock_control <> $sql_data_array['products_balance_stock_control']) $sql_data_array['products_balance_stock_control'] = $vv_products_balance_stock_control;
         if ($v_products_quantity <> $sql_data_array['products_quantity']) $sql_data_array['products_quantity'] = $v_products_quantity;
         if ($vv_nobuscar <> $sql_data_array['nobuscar']) $sql_data_array['nobuscar'] = $vv_nobuscar;
         if ($vv_modificar_precio_siempre <> $sql_data_array['modificar_precio_siempre']) $sql_data_array['modificar_precio_siempre'] = $vv_modificar_precio_siempre;
         if ($vv_modificar_producto <> $sql_data_array['modificar_producto']) $sql_data_array['modificar_producto'] = $vv_modificar_producto;
         if ($v_tax_class_id <> $sql_data_array['products_tax_class_id']) $sql_data_array['products_tax_class_id'] = $v_tax_class_id;
         if ($vv_grupo_comision <> $sql_data_array['grupo_comision']) $sql_data_array['grupo_comision'] = $vv_grupo_comision;
         if ($vv_filtro <> $sql_data_array['filtro']) $sql_data_array['filtro'] = $vv_filtro;
         if ($vv_products_extrapeso_precio <> $sql_data_array['products_extrapeso_precio']) $sql_data_array['products_extrapeso_precio'] = $vv_products_extrapeso_precio;
         if ($vv_costo <> $sql_data_array['costo']) $sql_data_array['costo'] = $vv_costo;
         if ($vv_proveedor <> $sql_data_array['proveedor']) $sql_data_array['proveedor'] = $vv_proveedor;
         if ($vv_proveedes <> $sql_data_array['proveedes']) $sql_data_array['proveedes'] = $vv_proveedes;
         if ($vv_codigodebarras <> $sql_data_array['codigo_barras']) $sql_data_array['codigo_barras'] = $vv_codigodebarras;
         if ($vv_priceminister <> $sql_data_array['priceminister']) $sql_data_array['priceminister'] = $vv_priceminister;
         if ($vv_codigo_proveedor <> $sql_data_array['codigo_proveedor']) $sql_data_array['codigo_proveedor'] = $vv_codigo_proveedor;
         if ($v_date_avail <> $sql_data_array['products_date_available']) $sql_data_array['products_date_available'] = $v_date_avail;
         if ($oldday1 <> $sql_data_array['products_last_modified']) $sql_data_array['products_last_modified'] = $oldday1;
         if ($vv_stock_nivel <> $sql_data_array['stock_nivel']) $sql_data_array['stock_nivel'] = $vv_stock_nivel;
         if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;
         if ($products_price_sin <> 0) $sql_data_array['products_price_sin'] = $products_price_sin;
         if ($vv_customers_group_price_2 <> 0) $sql_data_array['proveedor_price_general'] = $vv_customers_group_price_2;
         if ($v_manufacturers_name) $sql_data_array['manufacturers_name'] = $v_manufacturers_name;
         if ($vv_referencia_fabricante) $sql_data_array['referencia_fabricante'] = $vv_referencia_fabricante;
         // si quieres poner el precio de algunos productos en 0 configura la columna filtro con este numero.
         if ($vv_filtro == 125125) $sql_data_array['products_price'] = 0;
         if ($vv_products_cpe) $sql_data_array['products_cpe'] = $vv_products_cpe;
         if ($vv_products_cpf) $sql_data_array['products_cpf'] = $vv_products_cpf;
         if ($vv_opcion_1) $sql_data_array['opcion_1'] = $vv_opcion_1;
         if ($vv_opcion_1_1) $sql_data_array['opcion_1_1'] = $vv_opcion_1_1;
         if ($vv_opcion_2) $sql_data_array['opcion_2'] = $vv_opcion_2;
         if ($vv_opcion_2_2) $sql_data_array['opcion_2_2'] = $vv_opcion_2_2;
         if ($vv_opcion_3) $sql_data_array['opcion_3'] = $vv_opcion_3;
         if ($vv_opcion_3_3) $sql_data_array['opcion_3_3'] = $vv_opcion_3_3;
         if ($vv_opcion_4) $sql_data_array['opcion_4'] = $vv_opcion_4;
         if ($vv_opcion_4_4) $sql_data_array['opcion_4_4'] = $vv_opcion_4_4;
         if ($vv_opcion_5) $sql_data_array['opcion_5'] = $vv_opcion_5;
         if ($vv_opcion_5_5) $sql_data_array['opcion_5_5'] = $vv_opcion_5_5;
         if ($vv_opcion_6) $sql_data_array['opcion_6'] = $vv_opcion_6;
         if ($vv_opcion_6_6) $sql_data_array['opcion_6_6'] = $vv_opcion_6_6;
         if ($vv_opcion_7) $sql_data_array['opcion_7'] = $vv_opcion_7;
         if ($vv_opcion_7_7) $sql_data_array['opcion_7_7'] = $vv_opcion_7_7;
         if ($vv_opcion_8) $sql_data_array['opcion_8'] = $vv_opcion_8;
         if ($vv_opcion_8_8) $sql_data_array['opcion_8_8'] = $vv_opcion_8_8;
         if ($vv_opcion_9) $sql_data_array['opcion_9'] = $vv_opcion_9;
         if ($vv_opcion_9_9) $sql_data_array['opcion_9_9'] = $vv_opcion_9_9;
         if ($vv_opcion_10) $sql_data_array['opcion_10'] = $vv_opcion_10;
         if ($vv_opcion_10_10) $sql_data_array['opcion_10_10'] = $vv_opcion_10_10;
         if ($vv_stock_disponible) $sql_data_array['stock_disponible_proveedor'] = $vv_stock_disponible;
         if ($vv_talla) $sql_data_array['products_talla'] = $vv_talla;

      tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $v_products_id . "'");
      
     // inserta la rdc del proveedor + el id de categoria donde iran los productos.
     
     
    $permiso_reglas_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $vv_codigo_proveedor . "'");
     $permiso_reglas = tep_db_fetch_array($permiso_reglas_values);

     
          if ($permiso_reglas['utilizar_reglas_internas'] == '1'){
          }else{
     if ($vv_products_cpeidc){
    $cpeidc_busca_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_idproveedor = '" . $vv_codigo_proveedor . "' and  cp_ce = '" . $vv_products_cpe . "' order by cp_id ASC");
     if ($cpeidc_busca = tep_db_fetch_array($cpeidc_busca_values)){

 }else{
                  $sql_data_array = array('cp_ce' => $vv_products_cpe);
  if ($vv_codigo_proveedor <> 0) $sql_data_array['cp_idproveedor'] = $vv_codigo_proveedor;
  if ($vv_products_cpeidc <> 0) $sql_data_array['cp_ci'] = $vv_products_cpeidc;
          tep_db_perform('categories_pareja', $sql_data_array);

}

            tep_db_query("delete from " . 'categories_pareja' . " where cp_idproveedor = '" .  $vv_codigo_proveedor . "' and cp_ce = '" . $vv_products_cpe . "' and cp_ci <>  '" . $vv_products_cpeidc . "' ");


             } // fin cpeidc
          } // fin permiso

                 // por medio de coincidencia por referencia products_model
    $cpe_busca_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_quita_id = '" . 1 . "' order by cp_id ASC");
     while ($cpe_busca = tep_db_fetch_array($cpe_busca_values)){
                                // por medio de coincidencia por el nombre del producto products_name
    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_quita_nombre_1'] . "%' and products_name like '%" . $cpe_busca['cp_quita_nombre_2'] . "%' and products_name like '%" . $cpe_busca['cp_quita_nombre_3'] . "%' and products_id= '" . $v_products_id . "'");
   if  ($cpe_model = tep_db_fetch_array($cpe_model_values)){

       $sql_data_array = array('products_status' => 0,);
      tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $cpe_model['products_id'] . "'");

                ECHO 'Qita';
                                     }
 }










           $sql_status_update_array = array('specials_last_modified' => $oldday1,
                                            'expires_date' => $vv_expires_date,
                                            'status' => $vv_specials,);

                            if ($v_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $v_products_price;
                             if ($vv_specials_new_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $vv_specials_new_products_price;


            tep_db_perform(TABLE_SPECIALS, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");



                               

 }                                      } // SEGURIDAD

















     $wersdff_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $v_products_id . "'");
     $wersdff = tep_db_fetch_array($wersdff_values);


      $wersdf_values = tep_db_query("select * from " . TABLE_SPECIALS . " where products_id = '" . $v_products_id . "'");
    if ($wersdf = tep_db_fetch_array($wersdf_values)){




                   }else{

                 if  ($vv_specials == 1){

$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

      $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

       // calcula precio costos
       if  ($wersdfs['costo'] == 2){

       $v_products_price = $vv_customers_group_price_2 * 9 / 100 + $vv_customers_group_price_2;


   }

                    if ($v_products_price == 0){
         $v_products_price = $wersdfs['products_price'];
         
   }                                                  //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){                                                         //seguridad

                  $sql_data_array = array('products_id' => $v_products_id,
                                    'specials_date_added' => $oldday1,
                                    'specials_last_modified' => $oldday1,
                                    'expires_date' => $vv_expires_date,
                                    'status' => $vv_specials,);

  if ($v_products_price <> 0) $sql_data_array['specials_new_products_price'] = $v_products_price;
  if ($vv_specials_new_products_price <> 0) $sql_status_update_array['specials_new_products_price'] = $vv_specials_new_products_price;

          tep_db_perform(TABLE_SPECIALS, $sql_data_array);
          
} // SEGURIDAD
          

}


          }










 // NOTIFICACIONES POR CAMBIO DE PRECIO O DE STOCK
          // 6 = binary
 if ($vv_codigo_proveedor == 6){


 // 3 = hispanochina
}else if ($vv_codigo_proveedor == 3){

// 14 = lameesoftware
}else if ($vv_codigo_proveedor == 14){

}else{

             echo '44';
             
             
             
             
             
             
             
             
             
             

// si el precio es un numero ejecuto el siguiente codigo
 if ($v_products_price){




      $seguimiento_precios_primero_values = tep_db_query("select * from " . 'products_seguimientos_precios' . " where products_id = '" . $v_products_id . "'");
   if  ($seguimiento_precios_primero = tep_db_fetch_array($seguimiento_precios_primero_values)){

                                                                                                                                                                                           // products_last_modified
      $seguimiento_precios_masdeunavez_values = tep_db_query("select * from " . 'products_seguimientos_precios' . " psp, " . 'products' . " p where p.products_id = psp.products_id and p.products_last_modified = '" . $oldday1 . "' and psp.products_id = '" . $v_products_id . "' order by psp.fecha ASC");
   if  ($seguimiento_precios_masdeunavez = tep_db_fetch_array($seguimiento_precios_masdeunavez_values)){


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }
                             
                             
                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

       tep_db_query("delete from " . 'products_seguimientos_precios' . " where fecha = '" .  $oldday1 . "' and products_id = '" . $v_products_id . "'");

          $sql_data_array = array('products_id' => $v_products_id,
                              'fecha' => $oldday1,
                              'precio' => $v_products_price);
      tep_db_perform('products_seguimientos_precios', $sql_data_array);
                                } // SEGURIDAD

}else{

 } // $seguimiento_precios_masdeunavez




}else{

 //  la primera vez que se inserta un precio con mismo products_id

     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

          $sql_data_array = array('products_id' => $v_products_id,
                              'fecha' => $oldday1,
                              'precio' => $v_products_price);
      tep_db_perform('products_seguimientos_precios', $sql_data_array);

                                          } // SEGURIDAD


} //$v_products_price
} // $seguimiento_precios_primero
             
             
             
             
             
             
             
             
             
             
             
             
 
 if ($v_products_price){

     $p_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $p = tep_db_fetch_array($p_values);

     $pdes_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id= '" . $v_products_id . "'");
     $pdes = tep_db_fetch_array($pdes_values);

            $v_products_price = number_format($v_products_price, 2, '.', '');


      $notificaciones_values = tep_db_query("select * from " . 'products_notificacion_cambios' . " where products_id = '" . $v_products_id . "' and products_price <> '" . $v_products_price . "' or  products_id = '" . $v_products_id . "' and products_activado <> '" . $p['products_status'] . "'");
   while ($notificaciones = @tep_db_fetch_array($notificaciones_values)){




      // se envia el mail del cambio del precio con el nuevo precio.


         if   ($p['products_status'] == 1){
               $status_c = 'Activado';
     }else if ($p['products_status'] == 0){
              $status_c =  'Desastivado';
 }


           // cuerpo del email.
      $encabezado_mail = 'Nuevo Precio: ' . $v_products_price  . '€ Nombre: ' . $pdes['products_name'];
      $texto_del_mail = "Nuevo Precio: " . $v_products_price  . "€ Nombre: " . $pdes['products_name'] . " \n " . HTTP_SERVER . DIR_WS_CATALOG . "product_info.php?products_id=".$v_products_id." \n " . " \n " . "Status: ". $status_c . " \n " . " \n " . "Pulsar en el siguiente vinculo para dar de baja esta alerta\n " . HTTP_SERVER . DIR_WS_CATALOG . "product_info.php?products_id=".$v_products_id."&baja_email=".$notificaciones['email']."";

     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

     tep_mail('', $notificaciones['email'], $encabezado_mail, $texto_del_mail, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);


          $sql_data_array = array('products_price' => $v_products_price,
                                  'products_activado' => $p['products_status'],);
      tep_db_perform('products_notificacion_cambios', $sql_data_array, 'update', "products_id = '" . $v_products_id . "' and email = '" . $notificaciones['email'] . "'");
                            } // SEGURIDAD
}
}

  // fin de alertas de mail.

  }//proveedor






         $seguimiento_precios_values = tep_db_query("select * from " . 'products_seguimientos_precios' . " where products_id = '" . $v_products_id . "' group by precio order by fecha DESC");
   while  ($seguimiento_precios = tep_db_fetch_array($seguimiento_precios_values)){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
     $fecha = date("Y-m-d", $time);

     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
    tep_db_query("delete from " . 'products_seguimientos_precios' . " where precio = '" . $seguimiento_precios['precio'] . "' and products_id = '" . $v_products_id  . "' and id <> '" . $seguimiento_precios['id'] . "'");
                                   } // SEGURIDAD

}






     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                //    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                //    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                               //  if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                             //                                $tiempo_permiso = 1;

                             //    }else if ( time() <= $tiempo_60min){

                               //                              $tiempo_permiso = 1;
                            // }else{


                       //  }



                                                         //seguridad
                              //      if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

            // Actualiza o inserta las imagenes extras. del grupo 1

   $pr_imagenes_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 1 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_1 . "'");
if ($pr_imagenes = tep_db_fetch_array($pr_imagenes_values)){


          $sql_status_update_array = array('products_extra_image' => $vv_products_image_extra_1,);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " image_number = 1 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_1 . "'");


}else{


    $pr_imagenes_insert_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 1 and products_id = '" . $v_products_id . "' and products_extra_image = '" . $vv_products_image_extra_1 . "'");
if ($pr_imagenes_insert = tep_db_fetch_array($pr_imagenes_insert_values)){

  }else{


                                            $sql_data_array = array('products_extra_image' => $vv_products_image_extra_1,
                                          'image_number' => 1,
                                          'products_id' => $v_products_id,);
          tep_db_perform('products_extra_images', $sql_data_array);



             }
             
             
             
}

//} // seguridad
              // SI EL PVP ES UNA OPORTUNIDAD PONE EL MISMO EN EL PVM
              if ($vv_filtro <> 125125){
     if ($v_products_price <= $vv_customers_group_price){
     $vv_customers_group_price = $v_products_price;
 }}










     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

  // Actualiza o inserta las imagenes extras. del grupo 2

   $pr_imagenes_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 2 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_2 . "'");
if ($pr_imagenes = tep_db_fetch_array($pr_imagenes_values)){


          $sql_status_update_array = array('products_extra_image' => $vv_products_image_extra_2,);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " image_number = 2 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_2 . "'");


}else{


    $pr_imagenes_insert_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 2 and products_id = '" . $v_products_id . "' and products_extra_image = '" . $vv_products_image_extra_2 . "'");
if ($pr_imagenes_insert = tep_db_fetch_array($pr_imagenes_insert_values)){

  }else{


                                            $sql_data_array = array('products_extra_image' => $vv_products_image_extra_2,
                                          'image_number' => 2,
                                          'products_id' => $v_products_id,);
          tep_db_perform('products_extra_images', $sql_data_array);



             }



}

} // seguridad


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
// Actualiza o inserta las imagenes extras. del grupo 3

   $pr_imagenes_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 3 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_3 . "'");
if ($pr_imagenes = tep_db_fetch_array($pr_imagenes_values)){


          $sql_status_update_array = array('products_extra_image' => $vv_products_image_extra_3,);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " image_number = 3 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_3 . "'");


}else{


    $pr_imagenes_insert_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 3 and products_id = '" . $v_products_id . "' and products_extra_image = '" . $vv_products_image_extra_3 . "'");
if ($pr_imagenes_insert = tep_db_fetch_array($pr_imagenes_insert_values)){

  }else{


                                            $sql_data_array = array('products_extra_image' => $vv_products_image_extra_3,
                                          'image_number' => 3,
                                          'products_id' => $v_products_id,);
          tep_db_perform('products_extra_images', $sql_data_array);



             }



}


            } // seguridad


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
  // Actualiza o inserta las imagenes extras. del grupo 4

   $pr_imagenes_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 4 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_4 . "'");
if ($pr_imagenes = tep_db_fetch_array($pr_imagenes_values)){


          $sql_status_update_array = array('products_extra_image' => $vv_products_image_extra_4,);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " image_number = 4 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_4 . "'");


}else{


    $pr_imagenes_insert_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 4 and products_id = '" . $v_products_id . "' and products_extra_image = '" . $vv_products_image_extra_4 . "'");
if ($pr_imagenes_insert = tep_db_fetch_array($pr_imagenes_insert_values)){

  }else{


                                            $sql_data_array = array('products_extra_image' => $vv_products_image_extra_4,
                                          'image_number' => 4,
                                          'products_id' => $v_products_id,);
          tep_db_perform('products_extra_images', $sql_data_array);



             }



}


       } // seguridad


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
 // Actualiza o inserta las imagenes extras. del grupo 5

   $pr_imagenes_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 5 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_5 . "'");
if ($pr_imagenes = tep_db_fetch_array($pr_imagenes_values)){


          $sql_status_update_array = array('products_extra_image' => $vv_products_image_extra_5,);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " image_number = 5 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_5 . "'");


}else{


    $pr_imagenes_insert_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 5 and products_id = '" . $v_products_id . "' and products_extra_image = '" . $vv_products_image_extra_5 . "'");
if ($pr_imagenes_insert = tep_db_fetch_array($pr_imagenes_insert_values)){

  }else{


                                            $sql_data_array = array('products_extra_image' => $vv_products_image_extra_5,
                                          'image_number' => 5,
                                          'products_id' => $v_products_id,);
          tep_db_perform('products_extra_images', $sql_data_array);



             }



}


             } // seguridad


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
 // Actualiza o inserta las imagenes extras. del grupo 6

   $pr_imagenes_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 6 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_6 . "'");
if ($pr_imagenes = tep_db_fetch_array($pr_imagenes_values)){


          $sql_status_update_array = array('products_extra_image' => $vv_products_image_extra_6,);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " image_number = 6 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_6 . "'");


}else{


    $pr_imagenes_insert_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 6 and products_id = '" . $v_products_id . "' and products_extra_image = '" . $vv_products_image_extra_6 . "'");
if ($pr_imagenes_insert = tep_db_fetch_array($pr_imagenes_insert_values)){

  }else{


                                            $sql_data_array = array('products_extra_image' => $vv_products_image_extra_6,
                                          'image_number' => 6,
                                          'products_id' => $v_products_id,);
          tep_db_perform('products_extra_images', $sql_data_array);



             }



}




            } // seguridad


     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
// Actualiza o inserta las imagenes extras. del grupo 7

   $pr_imagenes_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 7 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_7 . "'");
if ($pr_imagenes = tep_db_fetch_array($pr_imagenes_values)){


          $sql_status_update_array = array('products_extra_image' => $vv_products_image_extra_7,);
            tep_db_perform('products_extra_images', $sql_status_update_array, 'update', " image_number = 7 and products_id = '" . $v_products_id . "' and products_extra_image <> '" . $vv_products_image_extra_7 . "'");


}else{


    $pr_imagenes_insert_values = tep_db_query("select * from " . 'products_extra_images' . " where image_number = 7 and products_id = '" . $v_products_id . "' and products_extra_image = '" . $vv_products_image_extra_7 . "'");
if ($pr_imagenes_insert = tep_db_fetch_array($pr_imagenes_insert_values)){

  }else{


                                            $sql_data_array = array('products_extra_image' => $vv_products_image_extra_7,
                                          'image_number' => 7,
                                          'products_id' => $v_products_id,);
          tep_db_perform('products_extra_images', $sql_data_array);



             }



}


      } // seguridad









   $pr_grupo_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $v_products_id . "' and customers_group_id = '" . 1 . "'");
if ($pr_grupo = tep_db_fetch_array($pr_grupo_values)){


// tarifa de precios para el grupo 1
      $sql_data_array = array('customers_group_id' => 1);

                             if ($vv_customers_group_price <> 0) $sql_data_array['customers_group_price'] = $vv_customers_group_price;
                             if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;

      tep_db_perform('products_groups', $sql_data_array, 'update', "products_id = '" . $v_products_id . "' and customers_group_id = '" . 1 . "'");







}else{
      // tarifa de precios para el grupo 1
      $sql_data_array = array('customers_group_id' => 1,
                              'products_id' => $v_products_id);
                              
                             if ($vv_customers_group_price <> 0) $sql_data_array['customers_group_price'] = $vv_customers_group_price;
                             if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;

                               tep_db_perform('products_groups', $sql_data_array);






}






   $pr_grupo2_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $v_products_id . "' and customers_group_id = '" . 2 . "'");
if ($pr_grupo2 = tep_db_fetch_array($pr_grupo2_values)){





 // Tarifas de precios para el grupo 2
      $sql_data_array = array('customers_group_id' => 2);

                             if ($vv_customers_group_price_2 <> 0) $sql_data_array['customers_group_price'] = $vv_customers_group_price_2;
                             if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;

      tep_db_perform('products_groups', $sql_data_array, 'update', "products_id = '" . $v_products_id . "' and customers_group_id = '" . 2 . "'");




 }else{


 // Tarifas de precios para el grupo 2
      $sql_data_array = array('customers_group_id' => 2,
                              'products_id' => $v_products_id);

                             if ($vv_customers_group_price_2 <> 0) $sql_data_array['customers_group_price'] = $vv_customers_group_price_2;
                             if ($v_products_price <> 0) $sql_data_array['products_price'] = $v_products_price;

                               tep_db_perform('products_groups', $sql_data_array);



                           }





		}



     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
		// the following is common in both the updating an existing product and creating a new product
                if ( isset($v_products_name)){
   foreach( $v_products_name as $key => $name){

                 // crea un espacio junto a la comilla ejemplo (,space)
                   $name = ereg_replace(",", ", ", $name);
                 // este codigo le quita las comillas al nombre para que el sisemta de presupuestos funcione correctamente.
                 $name = ereg_replace("([\]\")", '', $name);



							if ($name!=''){
					$sql = "SELECT * FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE
							products_id = $v_products_id AND
							language_id = " . $key;
					$result = tep_db_query($sql);
					if (tep_db_num_rows($result) == 0) {
						// nope, this is a new product description
						$result = tep_db_query($sql);
						$sql =
							"INSERT INTO ".TABLE_PRODUCTS_DESCRIPTION."
								(products_id,
								language_id,
								products_name,
								products_add_1,
								products_description,
								products_url)
								VALUES (
									'" . $v_products_id . "',
									" . $key . ",
									'" . $name  . "',
									'" . $vv_products_add_1  . "',
									'". $v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9 . "',
						            '". $v_products_url[$key] . "'
									)";
						// support for Linda's Header Controller 2.0
						if (isset($v_products_head_title_tag)){

                  // crea un espacio junto a la comilla ejemplo (,space)
                   $name = ereg_replace(",", ", ", $name);


                  // este codigo le quita las comillas al nombre para que el sisemta de presupuestos funcione correctamente.
                 $name = ereg_replace("([\]\")", '', $name);




							// override the sql if we're using Linda's contrib
							$sql =
								"INSERT INTO ".TABLE_PRODUCTS_DESCRIPTION."
									(products_id,
									language_id,
									products_name,
									products_add_1,
								    products_description,
									products_url,
									products_head_title_tag,
									products_head_desc_tag,
									products_head_keywords_tag)
									VALUES (
										'" . $v_products_id . "',
										" . $key . ",
										'" . $name . "',
										'" . $vv_products_add_1  . "',
									    '". $v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9 . "',
									    '". $v_products_url[$key] . "',
										'". $v_products_head_title_tag[$key] . "',
										'". $v_products_head_desc_tag[$key] . "',
										'". $v_products_head_keywords_tag[$key] . "')";
						}
						// end support for Linda's Header Controller 2.0
						$result = tep_db_query($sql);
					} else {
						// already in the description, let's just update it
      
      
                  // crea un espacio junto a la comilla ejemplo (,space)
                   $name = ereg_replace(",", ", ", $name);


                  // este codigo le quita las comillas al nombre para que el sisemta de presupuestos funcione correctamente.
                 $name = ereg_replace("([\]\")", '', $name);

                       $name = ereg_replace("(ó)", 'o', $name);
      $name = ereg_replace("(á)", 'a', $name);
      $name = ereg_replace("(é)", 'e', $name);
      $name = ereg_replace("(í)", 'i', $name);
      $name = ereg_replace("(ú)", 'u', $name);
                 
                   // products_description='".$v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9 . "',




                         $sql_status_update_array = array('products_name' => $name,
                                            'products_add_1' => $vv_products_add_1,
                                            'products_url' => $v_products_url[$key],);

                            if ($v_products_description[$key]) $sql_status_update_array['products_description'] = $v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9;


            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "' and language_id = '".$key."' ");









                          /*
 					$sql =
							"UPDATE ". TABLE_PRODUCTS_DESCRIPTION." SET
                               products_name='" . $name . "',

                               products_add_1='" . $vv_products_add_1 . "',
                               products_description='".$v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9 . "',
                               products_url='" . $v_products_url[$key] .  ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9 . "'
							WHERE
								products_id = '$v_products_id' AND
								language_id = '$key'";


                            */


						// support for Lindas Header Controller 2.0
						if (isset($v_products_head_title_tag)){
							// override the sql if we're using Linda's contrib




                    $sql_status_update_array = array('products_name' => $name,
                                            'products_add_1' => $vv_products_add_1,
                                            'products_url' => $v_products_url[$key],
                                            'products_head_title_tag' => $v_products_head_title_tag[$key],
                                            'products_head_desc_tag' => $v_products_head_desc_tag[$key],
                                            'products_head_keywords_tag' => $v_products_head_keywords_tag[$key],);

                            if ($v_products_description[$key]) $sql_status_update_array['products_description'] = $v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9;


            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "' and language_id = '".$key."' ");





                 // products_description = '".$v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9 . "',
                        /*
  					$sql =
								"UPDATE ".TABLE_PRODUCTS_DESCRIPTION." SET
									products_name = '" . $name . "',

                                    products_add_1='" . $vv_products_add_1 . "',
                                    products_description = '".$v_products_description[$key] . ' ' . $vv_description_add_1 . ' ' . $vv_description_add_2 . ' ' . $vv_description_add_3 . ' ' . $vv_description_add_4 . ' ' . $vv_description_add_5 . ' ' . $vv_description_add_6 . ' ' . $vv_description_add_7 . ' ' . $vv_description_add_8 . ' ' . $vv_description_add_9 . "',
                                    products_url = '" . $v_products_url[$key] ."',
									products_head_title_tag = '" . $v_products_head_title_tag[$key] ."',
									products_head_desc_tag = '" . $v_products_head_desc_tag[$key] ."',
									products_head_keywords_tag = '" . $v_products_head_keywords_tag[$key] ."'
								WHERE
									products_id = '$v_products_id' AND
									language_id = '$key'";
                                                  */





						}
						// end support for Linda's Header Controller 2.0
						$result = tep_db_query($sql);
      
      
                       } // seguridad
      
      
      if ($vv_borrar_producto == 1){

     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }

                                                         //seguridad
                                    if ($vv_seguridad == 5){

     tep_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" .  $v_products_id . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" .  $v_products_id . "'");
     tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "'");
     tep_db_query("delete from " . TABLE_SPECIALS . " where products_id = '" .  $v_products_id . "'");
     tep_db_query("delete from " . 'products_groups' . " where products_id = '" .  $v_products_id . "'");
     tep_db_query("delete from " . 'products_seguimientos_precios' . " where products_id = '" .  $v_products_id . "'");
                                   } // SEGURIDAD
     
                 }

      
      
      
      
					}
				}
			}
		}
		if (isset($v_categories_id)){
			//find out if this product is listed in the category given
			$result_incategory = tep_db_query('SELECT
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.products_id,
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id
						FROM
							'.TABLE_PRODUCTS_TO_CATEGORIES.'
						WHERE
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.products_id='.$v_products_id.' AND
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id='.$v_categories_id);

			if (tep_db_num_rows($result_incategory) == 0) {

                            // INICIO 24
        if ($vv_modificar_categoria == 0){















                         // SELECCION 1









 
 
 

 
 
 
 
 
 
 
 

                                                               //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                                         $v_categories_id_original = $v_categories_id;

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }
                             
                             
                             
                             
                             
                             

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){
                                    
 tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "'");
 
 
                     // si el producto no encuentra categoria se inserta en la categoría novedades definida en el listado exel.

    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "'");
    if ($cpe = tep_db_fetch_array($cpe_values)){


}else{

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT


}



      if ($wersdfs['products_cpf'] == 1){
          $wersdfs['products_cpf'] = 0;
      }
      if ($wersdfs['products_cpe'] == 1){
          $wersdfs['products_cpe'] = 0;
                        }

                  // por número de categoria externa.
    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' or cp_cf= '" . $wersdfs['products_cpf'] . "' and cp_cf >= '" . 1 . "'");
    while ($cpe = tep_db_fetch_array($cpe_values)){


                                                         //seguridad




                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }  // CPE

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT







                                         } // SEGURIDAD



} // fin while cpe




                             

                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $tiempo_permiso == 1){
                             
                       //seleccion 1


              // por medio de coincidencia por referencia products_model
    $cpe_busca_values = tep_db_query("select * from " . 'categories_pareja' . " order by cp_id ASC");
     while ($cpe_busca = tep_db_fetch_array($cpe_busca_values)){


       if ($cpe_busca['cp_ce_model'] <> 'defaultmodel'){


    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_model like '%" . $cpe_busca['cp_ce_model'] . "%' and products_id= '" . $v_products_id . "'");
     if  ($cpe_model = tep_db_fetch_array($cpe_model_values)){

      $cpe_busca_a_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_model = '" . $cpe_busca['cp_ce_model'] . "'");
   while  ($cpe_busca_a = tep_db_fetch_array($cpe_busca_a_values)){
      
      
                                   $v_categories_id =  $cpe_busca_a['cp_ci'];
                                   
                                   
                                   
     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $v_products_id . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "' and categories_id = '" .  $v_categories_id_original . "'");

}

                                   
                              ECHO 'SELEC MODEL';

                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT


} // fin while
                                   
                                   
                                   
                                   
                                   
                                   
                                   
                                   
       }}
        IF  ($cpe_busca['cp_ce_nombre'] <> 'defaultnombre'){

                                 if ($cpe_busca['cp_ce_nombre_2'] <> 'defaultnombre2'){
                  $bce_nombre2_1 = "and products_name like '%" . $cpe_busca['cp_ce_nombre_2'] . "%'";
                                }else{
                      $bce_nombre2_1 = '';

                  }
                  
                  
                                 if ($cpe_busca['cp_ce_nombre_3'] <> 'defaultnombre3'){
                  $bce_nombre3_1 = "and products_name like '%" . $cpe_busca['cp_ce_nombre_3'] . "%'";
                                }else{
                      $bce_nombre3_1 = '';

                  }
                  
                  

                  

   $cpe_menos_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_menosnombre_1'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_2'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_3'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_menos = tep_db_fetch_array($cpe_menos_values)){
                                         /*
                                 $menos1 = $cpe_busca['cp_ce_menosnombre_1']

                    if ($cpe_busca['cp_ce_menosnombre_1'] == 'defaultmenosnombre1'){
                         $cpe_busca['cp_ce_menosnombre_1'] = '';
                }
                    if ($cpe_busca['cp_ce_menosnombre_2'] == 'defaultmenosnombre2'){
                         $cpe_busca['cp_ce_menosnombre_2'] = '';
                }
                    if ($cpe_busca['cp_ce_menosnombre_3'] == 'defaultmenosnombre1'){
                         $cpe_busca['cp_ce_menosnombre_3'] = '';
                }

                                              */
            $sql_status_update_array = array('products_cp_ce_menosnombre_1' => $cpe_busca['cp_ce_menosnombre_1'],
                                             'products_cp_ce_menosnombre_2' => $cpe_busca['cp_ce_menosnombre_2'],
                                             'products_cp_ce_menosnombre_3' => $cpe_busca['cp_ce_menosnombre_3']);
            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");



 }else{

 }



                               // por medio de coincidencia por el nombre del producto products_name
   $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_nombre'] . "%' $bce_nombre2_1 $bce_nombre3_1 and products_id= '" . $v_products_id . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){

                   if ($cpe_busca['cp_ce_nombre_2'] <> 'defaultnombre2'){
                  $bce_nombre2_2 = "and cp_ce_nombre_2 = '" . $cpe_busca['cp_ce_nombre_2'] . "'";
                      }else{
                      $bce_nombre2_2 = '';

                  }


                   if ($cpe_busca['cp_ce_nombre_3'] <> 'defaultnombre3'){
                  $bce_nombre3_2 = "and cp_ce_nombre_3 = '" . $cpe_busca['cp_ce_nombre_3'] . "'";
                      }else{
                      $bce_nombre3_2 = '';

                  }
                  
                  
                  
                                 if ($cpe_busca['cp_ce_menosnombre_1'] <> 'defaultmenosnombre1'){
                  $bce_defaultmenosnombre1_2 = "and cp_ce_menosnombre_1 <> '" . $cpe_model['products_cp_ce_menosnombre_1'] . "'";
                                }else{
                  $bce_defaultmenosnombre1_2 = '';

                  }


                                 if ($cpe_busca['cp_ce_menosnombre_2'] <> 'defaultmenosnombre2'){
                  $bce_defaultmenosnombre2_2 = "and cp_ce_menosnombre_2 <> '" . $cpe_model['products_cp_ce_menosnombre_2'] . "'";
                                }else{
                  $bce_defaultmenosnombre2_2 = '';

                  }


                                 if ($cpe_busca['cp_ce_menosnombre_3'] <> 'defaultmenosnombre3'){
                  $bce_defaultmenosnombre3_2 = "and cp_ce_menosnombre_3 <> '" . $cpe_model['products_cp_ce_menosnombre_3'] . "'";
                                }else{
                  $bce_defaultmenosnombre3_2 = '';

                  }







      $cpe_busca_b_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_nombre = '" . $cpe_busca['cp_ce_nombre'] . "' $bce_nombre2_2 $bce_nombre3_2 $bce_defaultmenosnombre1_2 $bce_defaultmenosnombre2_2 $bce_defaultmenosnombre3_2");
      while  ( $cpe_busca_b = tep_db_fetch_array($cpe_busca_b_values)){






     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $v_products_id . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "' and categories_id = '" .  $v_categories_id_original . "'");

}

                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }



      

      
                                    if ($cpe_busca_b['cp_ci']){
                                  $v_categories_id =  $cpe_busca_b['cp_ci'];
                                       }else{
                                   $v_categories_id =  $v_categories_id_original;

                                   }
                                  


                                      ECHO 'SELECCION1r';

                                                        //seguridad





                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT

                                        } // SEGURIDAD



                                               } // fin while.



                                               // $v_categories_id =  $cpe_busca_b['cp_ci'];
                                  
       }
         }
          }// comprobar cpe model y nombre


                  // if ($cpe_busca_a['cp_ci']){
                   //           $status_exel = 1;
                  // }else if ($cpe_busca_b['cp_ci']){
                   //           $status_exel = 1;
                   //                   }




                                      ECHO 'SELECCION1r';






                                        
                                        
                                        
                                        
                                        







                                                                                                                                                                                                                                                                 

                                        
                                        
                                        
                                        
                                        
                                        
                                      }else{











                                   // SELECCION 2





                                                                                        echo 'DUPLICADOS';
                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1){



                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }


    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   }





       
       
                                         } // SEGURIDAD

                                         }   // FIN 24

       
       
       
       
       
       
       
       
       

       
       
       
       
       
       

   	} else {













                     // SELECCION 3





				// already in this category, nothing to do!
    
    
               //INICIO  25
           if ($vv_modificar_categoria == 0){






                                                               //seguridad
     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);

                                         $v_categories_id_original = $v_categories_id;



                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }







                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1 and $tiempo_permiso == 1){

 tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "'");
 



                     // si el producto no encuentra categoria se inserta en la categoría novedades definida en el listado exel.

    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "'");
    if ($cpe = tep_db_fetch_array($cpe_values)){


}else{

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT


}



 


      if ($wersdfs['products_cpf'] == 1){
          $wersdfs['products_cpf'] = 0;
      }
      if ($wersdfs['products_cpe'] == 1){
          $wersdfs['products_cpe'] = 0;
                        }

                  // por número de categoria externa.
    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' or cp_cf= '" . $wersdfs['products_cpf'] . "' and cp_cf >= '" . 1 . "'");
    while ($cpe = tep_db_fetch_array($cpe_values)){


                                                         //seguridad




                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }  // CPE

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT







                                         } // SEGURIDAD



} // fin while cpe








                                    $tiempo_3600hora = $wersdfs['easypopulate_time2'] + 43200;
                                    $tiempo_60min  = $wersdfs['easypopulate_time2'] + 120;

                                 if (time() >= $tiempo_3600hora){
                                 // activar nuevo tiempo falta un update.

                                                             $tiempo_permiso = 1;

                                 }else if ( time() <= $tiempo_60min){

                                                             $tiempo_permiso = 1;
                             }else{


                         }



                                                         //seguridad
                                    if ($vv_seguridad == 5 and $tiempo_permiso == 1){

                       //seleccion 1


              // por medio de coincidencia por referencia products_model
    $cpe_busca_values = tep_db_query("select * from " . 'categories_pareja' . " order by cp_id ASC");
     while ($cpe_busca = tep_db_fetch_array($cpe_busca_values)){


       if ($cpe_busca['cp_ce_model'] <> 'defaultmodel'){


    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_model like '%" . $cpe_busca['cp_ce_model'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){


      $cpe_busca_a_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_model = '" . $cpe_busca['cp_ce_model'] . "'");
    while  ($cpe_busca_a = tep_db_fetch_array($cpe_busca_a_values)){
                                   $v_categories_id =  $cpe_busca_a['cp_ci'];
                                   
     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $v_products_id . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "' and categories_id = '" .  $v_categories_id_original . "'");

}
                                   
                                   
                                   
                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT

                                   
                                   
                                   
             } // fin while
                                   
                                   
                                   
                                   
       }}
        IF  ($cpe_busca['cp_ce_nombre'] <> 'defaultnombre'){

                                 if ($cpe_busca['cp_ce_nombre_2'] <> 'defaultnombre2'){
                  $bce_nombre2_1 = "and products_name like '%" . $cpe_busca['cp_ce_nombre_2'] . "%'";
                                }else{
                      $bce_nombre2_1 = '';

                  }


                                 if ($cpe_busca['cp_ce_nombre_3'] <> 'defaultnombre3'){
                  $bce_nombre3_1 = "and products_name like '%" . $cpe_busca['cp_ce_nombre_3'] . "%'";
                                }else{
                      $bce_nombre3_1 = '';

                  }




   $cpe_menos_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_menosnombre_1'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_2'] . "%' and products_id= '" . $v_products_id . "' or products_name like '%" . $cpe_busca['cp_ce_menosnombre_3'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_menos = tep_db_fetch_array($cpe_menos_values)){

                                                /*
                    if ($cpe_busca['cp_ce_menosnombre_1'] == 'defaultmenosnombre1'){
                         $cpe_busca['cp_ce_menosnombre_1'] = '';
                }
                    if ($cpe_busca['cp_ce_menosnombre_2'] == 'defaultmenosnombre2'){
                         $cpe_busca['cp_ce_menosnombre_2'] = '';
                }
                    if ($cpe_busca['cp_ce_menosnombre_3'] == 'defaultmenosnombre1'){
                         $cpe_busca['cp_ce_menosnombre_3'] = '';
                }
                                                     */
            $sql_status_update_array = array('products_cp_ce_menosnombre_1' => $cpe_busca['cp_ce_menosnombre_1'],
                                             'products_cp_ce_menosnombre_2' => $cpe_busca['cp_ce_menosnombre_2'],
                                             'products_cp_ce_menosnombre_3' => $cpe_busca['cp_ce_menosnombre_3']);
            tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_status_update_array, 'update', " products_id= '" . $v_products_id . "'");
            
            
            
            
            
 }else{

 }



                               // por medio de coincidencia por el nombre del producto products_name
    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_nombre'] . "%' $bce_nombre2_1 $bce_nombre3_1 and products_id= '" . $v_products_id . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){

                   if ($cpe_busca['cp_ce_nombre_2'] <> 'defaultnombre2'){
                  $bce_nombre2_2 = "and cp_ce_nombre_2 = '" . $cpe_busca['cp_ce_nombre_2'] . "'";
                      }else{
                      $bce_nombre2_2 = '';

                  }


                   if ($cpe_busca['cp_ce_nombre_3'] <> 'defaultnombre3'){
                  $bce_nombre3_2 = "and cp_ce_nombre_3 = '" . $cpe_busca['cp_ce_nombre_3'] . "'";
                      }else{
                      $bce_nombre3_2 = '';

                  }



                                 if ($cpe_busca['cp_ce_menosnombre_1'] <> 'defaultmenosnombre1'){
                  $bce_defaultmenosnombre1_2 = "and cp_ce_menosnombre_1 <> '" . $cpe_model['products_cp_ce_menosnombre_1'] . "'";
                                }else{
                  $bce_defaultmenosnombre1_2 = '';

                  }


                                 if ($cpe_busca['cp_ce_menosnombre_2'] <> 'defaultmenosnombre2'){
                  $bce_defaultmenosnombre2_2 = "and cp_ce_menosnombre_2 <> '" . $cpe_model['products_cp_ce_menosnombre_2'] . "'";
                                }else{
                  $bce_defaultmenosnombre2_2 = '';

                  }


                                 if ($cpe_busca['cp_ce_menosnombre_3'] <> 'defaultmenosnombre3'){
                  $bce_defaultmenosnombre3_2 = "and cp_ce_menosnombre_3 <> '" . $cpe_model['products_cp_ce_menosnombre_3'] . "'";
                                }else{
                  $bce_defaultmenosnombre3_2 = '';

                  }







      $cpe_busca_b_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_nombre = '" . $cpe_busca['cp_ce_nombre'] . "' $bce_nombre2_2 $bce_nombre3_2 $bce_defaultmenosnombre1_2 $bce_defaultmenosnombre2_2 $bce_defaultmenosnombre3_2");
     while ($cpe_busca_b = tep_db_fetch_array($cpe_busca_b_values)){




                                    
                                        // Si
     $cpeo_categori_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES_DESCRIPTION . " cd where ptc.categories_id = cd.categories_id and ptc.categories_id = '" . $v_categories_id_original . "'  and ptc.products_id= '" . $v_products_id . "'");
     IF  ($cpeo_categori = tep_db_fetch_array($cpeo_categori_values)){
        tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" .  $v_products_id . "' and categories_id = '" .  $v_categories_id_original . "'");

}




                                    if ($cpe_busca_b['cp_ci']){
                                  $v_categories_id =  $cpe_busca_b['cp_ci'];
                                       }else{
                                   $v_categories_id =  $v_categories_id_original;

                                   }








                              if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }




                                      ECHO 'SELECCION3S';

                                                        //seguridad


                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }
				// nope, this is a new category for this product
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT



                          }  // fin   while






                                  
                                  
                               // $v_categories_id =  $cpe_busca_b['cp_ci'];
                                  
                                  
                                  
       }
         }
          }// comprobar cpe model y nombre











                                        } // SEGURIDAD





                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                       }else{











                                               // SELECCION 4











     $wersdfs_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id= '" . $v_products_id . "'");
     $wersdfs = tep_db_fetch_array($wersdfs_values);





                       // no se borra la categoria 1
                  // por número de categoria externa.
    $cpe_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce= '" . $wersdfs['products_cpe'] . "' and cp_ce >= '" . 1 . "' or cp_cf= '" . $wersdfs['products_cpf'] . "' and cp_cf >= '" . 1 . "'");
    while ($cpe = tep_db_fetch_array($cpe_values)){



                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }



                   if ($cpe['cp_ci']){
                              $status_exel = 1;
                    }else if ($cpe_busca_a['cp_ci']){
                              $status_exel = 1;
                   }else if ($cpe_busca_b['cp_ci']){
                            echo  $status_exel = 1;
                                      }




                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1){



                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                  }  // CPE

    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   } // CPCAT







                                         } // SEGURIDAD









} // fin while cpe











                                // por medio de coincidencia por referencia products_model
    $cpe_busca_values = tep_db_query("select * from " . 'categories_pareja' . " order by cp_id ASC");
     while ($cpe_busca = tep_db_fetch_array($cpe_busca_values)){




    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_model like '%" . $cpe_busca['cp_ce_model'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){
      $cpe_busca_a_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_model = '" . $cpe_busca['cp_ce_model'] . "'");
      $cpe_busca_a = tep_db_fetch_array($cpe_busca_a_values);
                                   $v_categories_id =  $cpe_busca_a['cp_ci'];
       }

                                // por medio de coincidencia por el nombre del producto products_name
    $cpe_model_values = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_name like '%" . $cpe_busca['cp_ce_nombre'] . "%' and products_id= '" . $v_products_id . "'");
     IF  ($cpe_model = tep_db_fetch_array($cpe_model_values)){
      $cpe_busca_b_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_ce_nombre = '" . $cpe_busca['cp_ce_nombre'] . "'");
      $cpe_busca_b = tep_db_fetch_array($cpe_busca_b_values);


                                   $v_categories_id =  $cpe_busca_b['cp_ci'];

       }


         }


                             if ($wersdfs['products_status_exel']){
                             $status_exel = $wersdfs['products_status_exel'];
                             }else{
                             $status_exel = 1;
                             }



                   if ($cpe['cp_ci']){
                              $status_exel = 1;
                    }else if ($cpe_busca_a['cp_ci']){
                              $status_exel = 1;
                   }else if ($cpe_busca_b['cp_ci']){
                            echo  $status_exel = 1;
                                      }

                                                         //seguridad
                                    if ($vv_seguridad == 5 and $status_exel == 1){

                                          // SI EL CPE EXISTE CAMBIA SUSTITULLE EL ID CATEGORIES NUEVO
                                       if ($cpe['cp_ci']){
                                    $v_categories_id = $cpe['cp_ci'];
                                   }

                                    // si el PRODUCTS_ID Y CATEGORI_ID COINCIDEN NO INSERT EN BD
    $cpcat_values = tep_db_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id= '" . $v_products_id . "' and categories_id= '" . $v_categories_id . "'");
    if  ($cpcat = tep_db_fetch_array($cpcat_values)){
   }else{                         // nope, this is a new category for this product
                            $res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                			VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
   }

       
       
                                        } // SEGURIDAD












                                           ECHO 'CAT4033';









                                         } // FIN 25
    
			}
		}
		// for the separate prices per customer module
		$ll=1;

















		if (isset($v_customer_price_1)){
			
			if (($v_customer_group_id_1 == '') AND ($v_customer_price_1 != ''))  {
				echo "<font color=red>ERROR - v_customer_group_id and v_customer_price must occur in pairs</font>";
				die();
			}
			// they spec'd some prices, so clear all existing entries
			$result = tep_db_query('
						DELETE
						FROM
							'.TABLE_PRODUCTS_GROUPS.'
						WHERE
							products_id = ' . $v_products_id
						);
			// and insert the new record
			if ($v_customer_price_1 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_1 . ',
								' . $v_customer_price_1 . ',
								' . $v_products_id . ',
								' . $v_products_price .'
								)'
							);
			}
			if ($v_customer_price_2 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_2 . ',
								' . $v_customer_price_2 . ',
								' . $v_products_id . ',
								' . $v_products_price . '
								)'
							);
			}
			if ($v_customer_price_3 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_3 . ',
								' . $v_customer_price_3 . ',
								' . $v_products_id . ',
								' . $v_products_price . '
								)'
							);
			}
			if ($v_customer_price_4 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_4 . ',
								' . $v_customer_price_4 . ',
								' . $v_products_id . ',
								' . $v_products_price . '
								)'
							);
			}

		}

		// VJ product attribs begin
		if (isset($v_attribute_options_id_1)){
			$attribute_rows = 1; // master row count

			$languages = tep_get_languages();

			// product options count
			$attribute_options_count = 1;
			$v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;

			while (isset($$v_attribute_options_id_var) && !empty($$v_attribute_options_id_var)) {
				// remove product attribute options linked to this product before proceeding further
				// this is useful for removing attributes linked to a product
				$attributes_clean_query = "delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "'";

				tep_db_query($attributes_clean_query);

				$attribute_options_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "'";

				$attribute_options_values = tep_db_query($attribute_options_query);

				// option table update begin
				if ($attribute_rows == 1) {
					// insert into options table if no option exists
					if (tep_db_num_rows($attribute_options_values) <= 0) {
						for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
							$lid = $languages[$i]['id'];

						  $v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;

							if (isset($$v_attribute_options_name_var)) {
								$attribute_options_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_options_name_var . "')";

								$attribute_options_insert = tep_db_query($attribute_options_insert_query);
							}
						}
					} else { // update options table, if options already exists
						for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
							$lid = $languages[$i]['id'];

							$v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;

							if (isset($$v_attribute_options_name_var)) {
								$attribute_options_update_lang_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "' and language_id ='" . (int)$lid . "'";

								$attribute_options_update_lang_values = tep_db_query($attribute_options_update_lang_query);

								// if option name doesn't exist for particular language, insert value
								if (tep_db_num_rows($attribute_options_update_lang_values) <= 0) {
									$attribute_options_lang_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_options_name_var . "')";

									$attribute_options_lang_insert = tep_db_query($attribute_options_lang_insert_query);
								} else { // if option name exists for particular language, update table
									$attribute_options_update_query = "update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . $$v_attribute_options_name_var . "' where products_options_id ='" . (int)$$v_attribute_options_id_var . "' and language_id = '" . (int)$lid . "'";

									$attribute_options_update = tep_db_query($attribute_options_update_query);
								}
							}
						}
					}
				}
				// option table update end

				// product option values count
				$attribute_values_count = 1;
				$v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;

				while (isset($$v_attribute_values_id_var) && !empty($$v_attribute_values_id_var)) {
					$attribute_values_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$$v_attribute_values_id_var . "'";

					$attribute_values_values = tep_db_query($attribute_values_query);

					// options_values table update begin
					if ($attribute_rows == 1) {
						// insert into options_values table if no option exists
						if (tep_db_num_rows($attribute_values_values) <= 0) {
							for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
								$lid = $languages[$i]['id'];

								$v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;

								if (isset($$v_attribute_values_name_var)) {
									$attribute_values_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_values_name_var . "')";

									$attribute_values_insert = tep_db_query($attribute_values_insert_query);
								}
							}


							// insert values to pov2po table
							$attribute_values_pov2po_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "')";

							$attribute_values_pov2po = tep_db_query($attribute_values_pov2po_query);
						} else { // update options table, if options already exists
							for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
								$lid = $languages[$i]['id'];

								$v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;

								if (isset($$v_attribute_values_name_var)) {
									$attribute_values_update_lang_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$$v_attribute_values_id_var . "' and language_id ='" . (int)$lid . "'";

									$attribute_values_update_lang_values = tep_db_query($attribute_values_update_lang_query);

									// if options_values name doesn't exist for particular language, insert value
									if (tep_db_num_rows($attribute_values_update_lang_values) <= 0) {
										$attribute_values_lang_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_values_name_var . "')";

										$attribute_values_lang_insert = tep_db_query($attribute_values_lang_insert_query);
									} else { // if options_values name exists for particular language, update table
										$attribute_values_update_query = "update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . $$v_attribute_values_name_var . "' where products_options_values_id ='" . (int)$$v_attribute_values_id_var . "' and language_id = '" . (int)$lid . "'";

										$attribute_values_update = tep_db_query($attribute_values_update_query);
									}
								}
							}
						}
					}
					// options_values table update end

					// options_values price update begin
				  $v_attribute_values_price_var = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;

					if (isset($$v_attribute_values_price_var) && ($$v_attribute_values_price_var != '')) {
						$attribute_prices_query = "select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id ='" . (int)$$v_attribute_options_id_var . "' and options_values_id = '" . (int)$$v_attribute_values_id_var . "'";

						$attribute_prices_values = tep_db_query($attribute_prices_query);

						$attribute_values_price_prefix = ($$v_attribute_values_price_var < 0) ? '-' : '+';

						// options_values_prices table update begin
						// insert into options_values_prices table if no price exists
						if (tep_db_num_rows($attribute_prices_values) <= 0) {
							$attribute_prices_insert_query = "insert into " . TABLE_PRODUCTS_ATTRIBUTES . " (products_id, options_id, options_values_id, options_values_price, price_prefix) values ('" . (int)$v_products_id . "', '" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "', '" . (float)$$v_attribute_values_price_var . "', '" . $attribute_values_price_prefix . "')";

							$attribute_prices_insert = tep_db_query($attribute_prices_insert_query);
						} else { // update options table, if options already exists
							$attribute_prices_update_query = "update " . TABLE_PRODUCTS_ATTRIBUTES . " set options_values_price = '" . $$v_attribute_values_price_var . "', price_prefix = '" . $attribute_values_price_prefix . "' where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "' and options_values_id ='" . (int)$$v_attribute_values_id_var . "'";

							$attribute_prices_update = tep_db_query($attribute_prices_update_query);
						}
					}
					// options_values price update end

//////// attributes stock add start
		$v_attribute_values_stock_var = 'v_attribute_values_stock_' . $attribute_options_count . '_' . $attribute_values_count;

		if (isset($$v_attribute_values_stock_var) && ($$v_attribute_values_stock_var != '')) {
        
		$stock_attributes = $$v_attribute_options_id_var.'-'.$$v_attribute_values_id_var;
		
		$attribute_stock_query = tep_db_query("select products_stock_quantity from " . TABLE_PRODUCTS_STOCK . " where products_id = '" . (int)$v_products_id . "' and products_stock_attributes ='" . $stock_attributes . "'");		
		
		// insert into products_stock_quantity table if no stock exists
		if (tep_db_num_rows($attribute_stock_query) <= 0) {
			$attribute_stock_insert_query =tep_db_query("insert into " . TABLE_PRODUCTS_STOCK . " (products_id, products_stock_attributes, products_stock_quantity) values ('" . (int)$v_products_id . "', '" . $stock_attributes . "', '" . (int)$$v_attribute_values_stock_var . "')");
				
		} else { // update options table, if options already exists
			$attribute_stock_insert_query = tep_db_query("update " . TABLE_PRODUCTS_STOCK. " set products_stock_quantity = '" . (int)$$v_attribute_values_stock_var . "' where products_id = '" . (int)$v_products_id . "' and products_stock_attributes = '" . $stock_attributes . "'");
					    
			// turn on stock tracking on products_options table
		    $stock_tracking_query = tep_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_track_stock = '1' where products_options_id = '" . (int)$$v_attribute_options_id_var . "'");
		
		}
	}
//////// attributes stock add end					

					
					
					
					$attribute_values_count++;
					$v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
				}

				$attribute_options_count++;
				$v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;
			}

			$attribute_rows++;
		}
		// VJ product attribs end

	} else {
		// this record was missing the product_model
		array_walk($items, 'print_el');
		echo "<p class=smallText>No products_model field in record. This line was not imported <br>";
		echo "<br>";
	}
// end of row insertion code
}


require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

