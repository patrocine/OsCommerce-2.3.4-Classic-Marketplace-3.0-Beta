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


                $o_values = tep_db_query("select * from " . 'orders' . " where orders_id = '" . $oID . "'");
               $o=tep_db_fetch_array($o_values);

               $c_values = tep_db_query("select * from " . 'customers' . " where customers_id = '" . $o['customers_id'] . "'");
               $c=tep_db_fetch_array($c_values);

               $pc_values = tep_db_query("select * from " . 'products_comercio' . " where customers_id = '" . $o['customers_id'] . "' and products_id = '" . $default_specials['products_id'] . "'");
               $pc=tep_db_fetch_array($pc_values);

 // tep_db_query("delete from " . TABLE_SPECIALS . " where specials_new_products_price = '" . 0 . "'");

   // echo 'REPEAT(a,1)';


   $i=0;
   while ($i<$default_specials['products_quantity']){     //  $default_specials['products_model']




//START POSITIVO Y LENGTH POSITIVO
$resultado = substr("pruebacadenas", 2);
 $resultado; // imprime "uebacadenas"
$resultado = substr($default_specials['products_name'], 2, 2);
 $resultado; // imprime "ue"


           if ($b++ >= 1 ){
       $ii =   '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 8pt">' . STORE_NAME . ' </font><font size="1" face="Verdana"></font></p>';
      $ii2 =   '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 8pt">------------ </font><font size="1" face="Verdana"></font></p>';
       $ii3 =   '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 8pt>"' . STORE_NAME . ' </font><font size="1" face="Verdana"></font></p>';
        }else{
        $ii = '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 8pt"> </font><font size="1" face="Verdana"></font></p>';
   }

if ($pc['price_etiqueta']){

$price = $pc['price_etiqueta'];

}else{
 $price = $stock_nivel['products_price'] * $c['comerciante_porcentaje'] / 100 + $stock_nivel['products_price'];

}
if ($c['comerciante_permiso'] == 1){
   $price_pvp = 'PVP';
  $price_text =   number_format($price, 2, '.', '').'Eur.';
}else{
     $price_pvp = '----------';
   $price_text = '----------';
}

                          

   $simulacro = '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 6pt">'. substr($default_specials['products_name'], 0, 15) .
   '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $default_specials['products_model'] . '</font><font size="1" face="Verdana"></font></p>'.
   '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">Valor x 100GR</font><font size="1" face="Verdana"></font></p>' .
   '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_1 . ':</font><font size="1" face="Verdana"></font></p>' .
   '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $stock_nivel['opcion_1_1'] . ' ' . OPCION_1_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
    '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_2 . ': </font><font size="1" face="Verdana"></font></p>'  .
     '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $stock_nivel['opcion_2_2'] . ' ' . OPCION_2_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_3 . ':</font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $stock_nivel['opcion_3_3'] . ' ' . OPCION_3_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_4 . ':</font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $stock_nivel['opcion_4_4'] . ' ' . OPCION_4_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
    '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_5 . ':</font><font size="1" face="Verdana"></font></p>'  .
     '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $stock_nivel['opcion_5_5'] . ' ' . OPCION_5_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_6 . ': </font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $stock_nivel['opcion_6_6'] . ' ' . OPCION_6_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_7 . ': </font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt"> '. $stock_nivel['opcion_7_7'] . ' ' . OPCION_7_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
         '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_8 . ':</font><font size="1" face="Verdana"></font></p>'  .
     '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">'. $stock_nivel['opcion_8_8'] . ' ' . OPCION_8_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
      '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">' . OPCION_9. ':</font><font size="1" face="Verdana"></font></p>'  .
     '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt"> '. $stock_nivel['opcion_9_9'] . ' ' . OPCION_9_2 . '. </font><font size="1" face="Verdana"></font></p>'  .
    '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt"> ---------- </font><font size="1" face="Verdana"></font></p>'  .
       '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 9pt"> '. $price_pvp . '  </font><font size="1" face="Verdana"></font></p>'  .
     '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 11pt"> '. $price_text . ' </font><font size="1" face="Verdana"></font></p>'  .
       $ii .
       $ii2 .
     $ii3 .
            '<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 8pt"></font><font size="1" face="Verdana"></font><font size="1" face="Verdana"></font></p>';

         // echo "El valor de i es ", $i,"<br>";
      $i++;


   $info_box_contents[$row][$col] = array('align' => 'center',
                                           'params' => '',
                                           'text' =>  ''.$simulacro);
                                        // '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $default_specials['products_image'], $default_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id']) . '">' . $default_specials['products_name'] . '</a><br><s>' . $currencies->display_price($default_specials['products_price'], tep_get_tax_rate($default_specials['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price($default_specials['specials_new_products_price'], tep_get_tax_rate($default_specials['products_tax_class_id'])) . '</span>'. $texto_stock);
    $col ++;



       if ($col > 0) {


      $col = 0;
     $row ++;
     

    }
  }
 }
  new contentBox($info_box_contents);
?>

<!-- default_specials_eof //-->
