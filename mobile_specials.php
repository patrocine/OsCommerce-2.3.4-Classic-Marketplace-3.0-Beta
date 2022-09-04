<?php
require_once('mobile/includes/application_top.php');

  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link('mobile_login.php', '', 'SSL'));
  }}



    $listing_sql = 	"select distinct p.products_id, p.stock_nivel, p.products_porcentage, p.products_status, time_entradasysalidas, p.time_mercancia_entregado_procesando,
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
    						where p.products_porcentage <= -0.02 and p.products_status = '1'
    						and p.products_id = p2c.products_id
    						and pd.products_id = p2c.products_id 
    						and pd.language_id = '" . (int)$languages_id . "'
    						";
          
 $listing_sql .= " order by p.products_porcentage ASC, pd.products_name";

          
                           // and s.status = '1'
    if (isset($HTTP_GET_VARS['manufacturers_id'])) 
        $listing_sql .= " and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'";
        
    $classic_site = DIR_WS_HTTP_CATALOG . 'specials.php?' . tep_get_all_get_params();
    require(DIR_MOBILE_INCLUDES . 'header.php');
    require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_SPECIALS));
    $headerTitle->write();
    
?>
<div id="iphone_content">
<?php
	require(DIR_MOBILE_MODULES . 'products.php');
?>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
