<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHIPPING);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHIPPING));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo 'EMPRESA 3.0 OsOcommerce'; ?></h1>







                                                   <?php



                 $product_compartir_values = tep_db_query( "select * from " . TABLE_PRODUCTS . " p,  " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.time_entradasysalidas < p.products_stock_min and p.products_stock_min <> 0 and p.codigo_proveedor = '" . 	653801 . "'";
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){


                  echo  $product_compartir['products_id']



                            }








                                                                     ?>

















<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
