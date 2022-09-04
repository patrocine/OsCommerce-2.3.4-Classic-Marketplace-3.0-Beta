<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (PERMISO_FILENAME_LOGIN == 'True'){
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }}

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCTS_NEW);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCTS_NEW));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
  <div class="contentText">

<?php
  $listing_sql = "select p.codigo_proveedor, p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id, p.time_entradasysalidas, p.products_date_added, m.manufacturers_name, s.specials_new_products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id) left join " . TABLE_SPECIALS . " s ON (s.products_id = p.products_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd  where p.time_entradasysalidas >= 1 and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' or
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      p.time_mercancia_entregado_procesando >= 1 and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_price, p.time_entradasysalidas ASC, pd.products_name";
  include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);
?>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
