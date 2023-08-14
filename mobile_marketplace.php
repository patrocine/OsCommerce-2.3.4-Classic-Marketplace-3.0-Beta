<?php
require_once('mobile/includes/application_top.php');

  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link('mobile_login.php', '', 'SSL'));
  }}


	$listing_sql = 		"select     p.products_id, p.codigo_proveedor, p.products_porcentage, p.stock_nivel, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando,
    						pd.products_name, 
    						p.manufacturers_id, 
    						p.products_price, 
    						p.products_image, 
    						p.products_tax_class_id, 
    						IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, 
    						IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . 
    						TABLE_PRODUCTS_DESCRIPTION . " pd," .
    						TABLE_PRODUCTS . " p left join " . 
    						TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . 
    						TABLE_SPECIALS . " s on p.products_id = s.products_id, " . 
    						TABLE_PRODUCTS_TO_CATEGORIES . " p2c 
    						where p.products_status = '1' 
    						and p.products_id = p2c.products_id 
    						and pd.products_id = p2c.products_id 
    						and pd.language_id = '" . (int)$languages_id . "'";
    if (isset($HTTP_GET_VARS['cPath']))
        $listing_sql .= " and p2c.categories_id = '" . (int)$current_category_id . "'";
    if (isset($HTTP_GET_VARS['manufacturers_id'])) 
        $listing_sql .= " and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'";
        
    $listing_sql .= " order by pd.products_name";

// calculate category path
$category_depth = 'top';
if (isset($cPath) && tep_not_null($cPath)) {
	$categories_products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
	$cateqories_products = tep_db_fetch_array($categories_products_query);
	if ($cateqories_products['total'] > 0) {
		$category_depth = 'products'; // display products
	} else {
		$category_parent_query = tep_db_query("select count(*) as total from " . 'marketplace' . " where parent_id = '" . (int)$current_category_id . "'");
		$category_parent = tep_db_fetch_array($category_parent_query);
		if ($category_parent['total'] > 0) {
			$category_depth = 'nested'; // navigate through the categories
		} else {
			$category_depth = 'products'; // category has no products, but display the 'no products' message
		}
	}
}

$list = array();
$parent_id = (tep_not_null($cPath) == true) ? (int)$cPath : 0;
$categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_name_suple,cd.categories_name_http, categories_name_http_mobil, c.categories_image, c.parent_id from " . 'marketplace' . " c, " . 'marketplace_description' . " cd where c.parent_id = " . $parent_id . " and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id . $path_cond . "' order by sort_order, cd.categories_name");
while ($categories = tep_db_fetch_array($categories_query))  {
	$list[] = $categories;
}

// check if there are manufacturers
$manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");

// check if there are specials
$specials_count_query = tep_db_query("select count(*) as total from " . TABLE_SPECIALS . " where status = '1'");
$specials_count = tep_db_fetch_array($specials_count_query);

// set the link for classic site
$classic_site = str_replace('mobile_marketplace.php', 'index.php', $_SERVER['REQUEST_URI']);

require(DIR_MOBILE_INCLUDES . 'header_marketplace.php');
require(DIR_WS_LANGUAGES . $language . '/index.php');
require(DIR_WS_LANGUAGES . $language . '/modules/boxes/bm_specials.php');
$headerTitle->write($headerTitleText);

if(AJAX_ENABLED =='true')
	include(DIR_MOBILE_CLASSES . 'categories_js.php');


?>
<!-- categories //-->
<div id="iphone_content">
<?php
// BOF manufacturers menu
if ($number_of_rows = tep_db_num_rows($manufacturers_query) && SHOW_MANUFACTURERS_CATALOG_MENU == 'true') {
	?>
	<div id="cms">
	<?php
	$manufacturers_array = array();
	if (MAX_MANUFACTURERS_LIST < 2) {
		$manufacturers_array[] = array('id' => '', 'text' => (($HTTP_GET_VARS['manufacturers_id'] > 0)? TEXT_MOBILE_BACK_TO_CATEGORIES : PULL_DOWN_DEFAULT));
	}

	while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
		$manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);
		$manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                	                       'text' => $manufacturers_name);
        }

        echo tep_draw_form('manufacturers', tep_href_link('mobile_marketplace.php', '', 'NONSSL', false), 'get') .
             BOX_HEADING_MANUFACTURERS . ':&nbsp;&nbsp;' . tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, (isset($HTTP_GET_VARS['manufacturers_id']) ? $HTTP_GET_VARS['manufacturers_id'] : ''), 'onChange="this.form.submit();" size="' . MAX_MANUFACTURERS_LIST . '" style="width: "') . tep_hide_session_id();
	}
// EOF manufacturers menu
?>
</div>
<?php

if ($HTTP_GET_VARS['manufacturers_id'] == '' ) {
	?>

<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
<?php
	foreach ($list as $item ) {


      if ($item['categories_name_suple']){
       $categories_a = $item['categories_name_suple'];
}else{
    $categories_a = $item['categories_name'];
}

      if ($item['categories_name_http']){
    $categories_string = $item['categories_name_http'];
  }else{
   $categories_string = tep_mobile_link('mobile_marketplace.php', 'cPath=' . $item['categories_id']);
    }



		$path = $categories_string;
		$img = strlen($categories_a) > 0 ? tep_image( $item['categories_image'], $categories_a, 40,0) : ' ';
		print tep_mobile_selection($path, array($img, $categories_a)) . '<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
		
	}
?>
</table>
<?php
}
?>




<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
<?php

		echo tep_mobile_selection('https://binance.com', array(tep_image(DIR_MOBILE_IMAGES . 'new.png'), 'Registrarse en Binance')).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div></p>';

		echo tep_mobile_selection('https://binance.com', array('', 'Registrese en Binance.com donde podrá comprar criptomonedas y dinero digital de forma segura y mantenerlas siempre asalvo, Binance es uno de los Banco de Criptomonedas mas seguro y actualmente cumple con todas las regulaciones del banco de España.')).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div></p>';


		?></table><?php

?>
<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">


<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
<?php

		echo tep_mobile_selection('https://www.bitget.com/es/expressly?channelCode=qesa&vipCode=iqpz&languageType=7', array(tep_image(DIR_MOBILE_IMAGES . 'new.png'), 'Registrarse en Bitget')).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div></p>';

		echo tep_mobile_selection('https://www.bitget.com/es/expressly?channelCode=qesa&vipCode=iqpz&languageType=7', array('', 'Registrese en BitGet.com donde podrá comprar criptomonedas y dinero digital de forma segura y mantenerlas siempre asalvo, Bitget es uno de los Bancos de Criptomonedas mas seguros, actualmente no esta regulado por el banco de España')).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div></p>';


		?></table><?php

?>
<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">


<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
<?php

		echo tep_mobile_selection('https://tradingdifferent.com/code/7Pv', array(tep_image(DIR_MOBILE_IMAGES . 'new.png'), 'Registrarse en Trading Different')).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div></p>';

		echo tep_mobile_selection('https://tradingdifferent.com/code/7Pv', array('', 'Trading Different es una herramienta con muchas funcionalidades que le permite tener mucha informacion en tiempo real para poder tomar la mejor Decision en la compra de Bitcoin, Anyela Rios lo utiliza en sus envivos para explicar sus analisis.')).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div></p>';


		?></table><?php

?>
<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">









<table id="productListing" class="categories" width="100%" cellpadding="0" cellspacing="0">
<?php 
    if ($cateqories_products['total'] > 0 || isset($HTTP_GET_VARS['manufacturers_id'])) {
		include(DIR_MOBILE_MODULES . 'products.php');
	}
?>
</table>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
