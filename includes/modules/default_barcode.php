<?php
/*
  $Id: default_specials.php,v 2.0 2003/06/13

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- default_specials //-->


<?php

  

   $oID = $HTTP_GET_VARS['oID'];

  

 $new = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $oID . "' ORDER BY products_model");


          
 $info_box_contents = array();
  $row = 0;
  $col = 0;
  while ($default_specials = tep_db_fetch_array($new)) {

             $stock_nivel_values = tep_db_query("select * from " . TABLE_PRODUCTS . " where products_id = '" . $default_specials['products_id'] . "'");
             $stock_nivel= tep_db_fetch_array($stock_nivel_values);





 // tep_db_query("delete from " . TABLE_SPECIALS . " where specials_new_products_price = '" . 0 . "'");

   // echo 'REPEAT(a,1)';


   $i=0;
   while ($i<$default_specials['products_quantity']){     //  $default_specials['products_model']




//START POSITIVO Y LENGTH POSITIVO
$resultado = substr("pruebacadenas", 2);
 $resultado; // imprime "uebacadenas"
$resultado = substr($default_specials['products_name'], 2, 2);
 $resultado; // imprime "ue"



   $simulacro =  '<img src="admin/barcodegen.php?barcode=' . $default_specials['products_id'] . ' ">
                  <p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. substr($default_specials['products_name'], 0, 20) .'</font><font size="1" face="Verdana"></font></p>';


         // echo "El valor de i es ", $i,"<br>";
      $i++;


   $info_box_contents[$row][$col] = array('align' => 'center',
                                           'params' => '',
                                           'text' =>  ''.$simulacro);
                                        // '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $default_specials['products_image'], $default_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id']) . '">' . $default_specials['products_name'] . '</a><br><s>' . $currencies->display_price($default_specials['products_price'], tep_get_tax_rate($default_specials['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price($default_specials['specials_new_products_price'], tep_get_tax_rate($default_specials['products_tax_class_id'])) . '</span>'. $texto_stock);
    $col ++;



       if ($col > 4) {


      $col = 0;
     $row ++;
     

    }
  }
 }
  new contentBox($info_box_contents);
?>

<!-- default_specials_eof //-->
