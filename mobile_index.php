<?php
require_once('mobile/includes/application_top.php');


  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link('mobile_login.php', '', 'SSL'));
  }}


require(DIR_MOBILE_INCLUDES . 'header.php');
require(DIR_WS_LANGUAGES . $language . '/index.php');
$headerTitle->write($headerTitleText);
?>
<!-- categories //-->
<div id="iphone_content">

          <?php if (BOTON_COMPRA == 'True' and PERMISO_LOGINRADIUS == 'True'){ ?>
        <div id="cms">
        


  <div id="bouton" style="height:65px;">

          <?php print $SOCIALLOGININTERFACE;?>

        </div>

        <?php
     }
          ?>
</div>

         <?php if (BOTON_COMPRA == 'True'){ ?>

      <div id="cms">
  <div id="bouton" style="height:24px;">

	<?php
	if (!tep_session_is_registered('customer_id')) { 
		echo '<span style="float:left;">' . tep_draw_form('create_account', tep_mobile_link(FILENAME_CREATE_ACCOUNT, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_CREATE_ACCOUNT) . '</form></span>' .  
		     '<span style="float:right;">' . tep_draw_form('login', tep_mobile_link(FILENAME_LOGIN, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_LOGIN) . '</form></span>';
	} else { 
		echo tep_draw_form('create_account', tep_mobile_link(FILENAME_MOBILE_LOGOFF, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_LOGOFF) . '</form>';
	}
	?>
  </div>
  
            <?php
     }
          ?>
  
</div>









     <?php





	$listing_sql = 		"select     p.products_id, p.stock_nivel, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando,
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
		$category_parent_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$current_category_id . "'");
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
$categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_name_suple, categories_name_http_mobil, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = " . $parent_id . " and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id . $path_cond . "' order by sort_order, cd.categories_name");
while ($categories = tep_db_fetch_array($categories_query))  {
	$list[] = $categories;
}

// check if there are manufacturers
$manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");

// check if there are specials
$specials_count_query = tep_db_query("select count(*) as total from " . TABLE_SPECIALS . " where status = '1'");
$specials_count = tep_db_fetch_array($specials_count_query);

// set the link for classic site
$classic_site = str_replace('mobile_catalogue.php', 'index.php', $_SERVER['REQUEST_URI']);

//require(DIR_MOBILE_INCLUDES . 'header.php');
require(DIR_WS_LANGUAGES . $language . '/index.php');
require(DIR_WS_LANGUAGES . $language . '/modules/boxes/bm_specials.php');
//$headerTitle->write($headerTitleText);

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

        echo tep_draw_form('manufacturers', tep_href_link(FILENAME_CATALOG, '', 'NONSSL', false), 'get') .
             BOX_HEADING_MANUFACTURERS . ':&nbsp;&nbsp;' . tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, (isset($HTTP_GET_VARS['manufacturers_id']) ? $HTTP_GET_VARS['manufacturers_id'] : ''), 'onChange="this.form.submit();" size="' . MAX_MANUFACTURERS_LIST . '" style="width: "') . tep_hide_session_id();
	}
// EOF manufacturers menu
?>



















    <div id="ficheProdTop">


 <?php

if ($HTTP_GET_VARS['manufacturers_id'] == '' ) {
	?>
<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
<?php
	if (isset($HTTP_GET_VARS['cPath']) != TRUE ) {
		echo tep_mobile_selection(tep_mobile_link(FILENAME_PRODUCTS_NEW), array(tep_image(DIR_MOBILE_IMAGES . 'new.png'), TEXT_MOBILE_PRODUCTS_NEW)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
		if ($specials_count['total'] > 0 ) {
		echo tep_mobile_selection(tep_mobile_link(FILENAME_SPECIALS), array(tep_image(DIR_MOBILE_IMAGES . 'specials.png'), MODULE_BOXES_SPECIALS_TITLE)).'<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
		}
		?></table><?php
	}
?>
<table id="categoriesTable" class="categories" width="100%" cellpadding="0" cellspacing="0">
<?php
	foreach ($list as $item ) {


      if ($item['categories_name_suple']){
       $categories_a = $item['categories_name_suple'];
}else{
    $categories_a = $item['categories_name'];
}



            if ($item['categories_name_http_mobil']){
          $categories_string = $item['categories_name_http_mobil'];

       }else{
      $categories_string = tep_mobile_link(FILENAME_CATALOG, 'cPath=' . $item['categories_id']);

          }






		$path = $categories_string;
		$img = strlen($item['categories_image']) > 0 ? tep_image(DIR_WS_IMAGES . $item['categories_image'], $categories_a, 40,40) : ' ';
		print tep_mobile_selection($path, array($img, $categories_a)) . '<div class="fleche"><img src="' . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';

	}
?>
</table>
<?php
}
?>




  </div>







	<div id="cms">			
	<?php echo TEXT_WELCOME; ?>
 
     <?php require('mobile_products_new_index.php');
?>
     <?php //require('mobile_specials_index.php');
?>

</div>



<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
