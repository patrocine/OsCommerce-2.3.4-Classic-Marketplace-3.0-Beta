
 <SCRIPT>
<!--
function sf(){document.codigo_barras_c.ean.focus();}
function clk(url,oi,cad,ct,cd,sg){if(document.images){var e = window.encodeURIComponent ? encodeURIComponent : escape;var u="";var oi_param="";var cad_param="";if (url) u="&url="+e(url.replace(/#.*/,"")).replace(/\+/g,"%2B");if (oi) oi_param="&oi="+e(oi);if (cad) cad_param="&cad="+e(cad);new Image().src="/url?sa=T"+oi_param+cad_param+"&ct="+e(ct)+"&cd="+e(cd)+u+"&ei=yzHqRPLoGpy2QP6B_X0"+sg;}return true;}
// -->
</SCRIPT>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>


<a href="<?php echo $PHP_SELF.'?oID='.$_GET['oID'].'&resetear=ok'; ?>">Resetear</a></font></b>


<?php




/*
  $Id: invoice.php,v 1.1 2002/06/11 18:17:59 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require('includes/conf_status.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  
  
  
  
  
  
ECHO   $ean = $_POST['ean'];
       ECHO ' / '.$_POST['qty'].' / ' . $_GET['oID'].' / ' ;
  
  if ($_GET['resetear']){
  
              $sql_status_update_array = array('products_quantity_control' => 0);
            tep_db_perform('orders_products', $sql_status_update_array, 'update', " orders_id= '" . $_GET['oID'] . "'");

  
  
}
  
  
  
             if ($ean){

 $qty_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_model ='" . $_POST['ean'] . "'");
             if ($qty = tep_db_fetch_array($qty_values)){

 $qty2_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_model ='" . $_POST['ean'] . "'and products_quantity <= products_quantity_control");
           if  ( $qty2 = tep_db_fetch_array($qty2_values)){
                         echo ' Maximo numero de productos exedidos en este pedido.';
                         
                         
    ?>



<audio autoplay>
    <source src="sonido/pitidofake.mp3" type="audio/mp3">

        Tu navegador no soporta audio HTML5.
</audio>
    <?php
                         
                         
                         
                 }else{



                                          if  ($qty['products_quantity_control'] + $_POST['qty'] <=  $qty['products_quantity']){
                                                    ?>



<audio autoplay>
    <source src="sonido/pitidook.mp3" type="audio/mp3">

        Tu navegador no soporta audio HTML5.
</audio>
    <?php
                        echo ' Producto descontado de la factura';
              $sql_status_update_array = array('products_quantity_control' => $qty['products_quantity_control'] + $_POST['qty']);
            tep_db_perform('orders_products', $sql_status_update_array, 'update', " products_model ='" . $_POST['ean'] . "' and orders_id= '" . $_GET['oID'] . "'");
                                                           }

                                                      } // qty2

         }else{
    ?>



<audio autoplay>
    <source src="sonido/pitidono.mp3" type="audio/mp3">

        Tu navegador no soporta audio HTML5.
</audio>
    <?php
      echo ' Este Producto no se encuentra en este pedido';
     }  // QTY
     
     
} // EAN











  $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
  $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");

  include(DIR_WS_CLASSES . 'order.php');
  $order = new order($oID);













               $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
                if   ( $factura_orders = tep_db_fetch_array($factura_orders_values)) {











          $factura_price_raw = "select sum(products_price) as value, sum(products_price) as price, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id ='" . $factura_orders['orders_id'] . "'";
  $factura_price_query = tep_db_query($factura_price_raw);
  $factura_price= tep_db_fetch_array($factura_price_query);



 $factura_shipping_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_shipping' . "'");
              $factura_shipping = tep_db_fetch_array($factura_shipping_values);
 $factura_tax_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_tax' . "'");
              $factura_tax = tep_db_fetch_array($factura_tax_values);

 $factura_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_total' . "'");
              $factura_total = tep_db_fetch_array($factura_total_values);


 $factura_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_subtotal' . "'");
              $factura_subtotal = tep_db_fetch_array($factura_subtotal_values);

     $admin_lof_values = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . 3 . "'");
 $admin_lof = tep_db_fetch_array($admin_lof_values);
 
     $addbook_values = tep_db_query("select * from " . 'address_book' . " where customers_id = '" . 3 . "'");
 $addbook = tep_db_fetch_array($addbook_values);

     $zone_values = tep_db_query("select * from " . 'zones' . " where zone_id = '" . $addbook['entry_zone_id'] . "'");
 $zone = tep_db_fetch_array($zone_values);
 
 
 

    ob_start();

  ?>















           <BODY topMargin=3 onload=sf()>



 <form name="codigo_barras_c" method="post" action="<?php echo $PHP_SELF.'?oID='.$oID; ?>">

  </p>
  <p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
  Control de Pedido
  <p style="margin-top: 0; margin-bottom: 0">
    <font size="1" face="Verdana"><b>
       <?php
      // seleccionado busca todos los productos que esten activados o desactivados.

       ?>
<input type="text" name="qty" size="5" value="1">
  <input name="ean" type="text" value="" size="20" style="font-family: Verdana; font-size: 8pt; color: #000080; border-style: outset; border-width: 3; background-color: #FFFF00">
     <input type="hidden" name="add_product">
    <input type="submit" name="Submit" value="Buscar" style="color: #FFFFFF; font-family: ve; font-size: 8pt; background-color: #008080">
    </b></font>
  </p>
</form>






<div align="center">
  <center>


      <td width="652" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="652" height="19">
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="75">
        <tr>
          <td width="100%" height="14">
          <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="12%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_REF_M ?></font></b></td>
              <td width="39%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_DESCRIPCION_M ?></font></b></td>
              <td width="6%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_PRECIO_M ?></font></b></td>
              <td width="6%" align="center"><b><font face="Verdana" size="1">
              <?php ECHO TEXT_CANT_M ?></font></b></td>
              <td width="6%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_IMP_M ?></font></b></td>
              <td width="6%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_PRECIO_TOTAL_M ?></font></b></td>
            </tr>




          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="75">

          <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="102%" height="437">

            <tr>

              <td width="12%" height="305" valign="top" style="font-family: Verdana; font-size: 6pt">

                             <?php
         $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "' order by donde_esta ASC");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {


    //      $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op, products_donde_esta de where de.products_id = op.products_id and op.orders_id = '" . $factura_orders['orders_id'] . "'");
   //      while      ($factura_products = tep_db_fetch_array($factura_products_values)) {
       // código aquí ?>



      <table border="-1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 7pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                
                <?php
  $qty2_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_id ='" . $factura_products['products_id'] . "'");
         $qty2 = tep_db_fetch_array($qty2_values);
           if ($qty2['products_quantity_control'] == $qty2['products_quantity']){
                $color = '#CCFF66';
                        }else if ($qty2['products_quantity_control'] == 0){
                $color = '';
                        }else if ($qty2['products_quantity_control'] <= $qty2['products_quantity']){
                      $color = '#00FFFF';
                    }else{
                    $color = '';
                }
                    ?>
 <td width="100%" height="13" bgcolor="<?php echo $color; ?>">&nbsp;
             

                   <?php

                        echo $factura_products['products_model'];






                               ?>
                  </td>
                </tr>




              </table>

                   <?php   } ?>

              </td>

              <td width="39%" height="305" valign="top" style="font-family: Verdana; font-size: 7pt">

                 <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "' order by donde_esta ASC");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>
              <table border="-1" cellpadding="-1" cellspacing="-1" style="border-collapse: collapse; font-family: Verdana; font-size: 7pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                
                
                <?php
  $qty2_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_id ='" . $factura_products['products_id'] . "'");
         $qty2 = tep_db_fetch_array($qty2_values);
           if ($qty2['products_quantity_control'] == $qty2['products_quantity']){
                $color = '#CCFF66';
                        }else if ($qty2['products_quantity_control'] == 0){
                $color = '';
                        }else if ($qty2['products_quantity_control'] <= $qty2['products_quantity']){
                      $color = '#00FFFF';
                    }else{
                    $color = '';
                }
                    ?>
 <td width="100%" height="13" bgcolor="<?php echo $color; ?>">&nbsp;
 
 
             <?php

           $donde_esta_c_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $factura_products['products_id'] . "' and login_id = '" . $log_id . "'");
 $donde_esta_c= tep_db_fetch_array($donde_esta_c_values);


              echo $donde_esta_c['donde_esta'];

                  if ($featured_products_array[$i]['shortdescription'] != '') {

  } else {
   $bah = explode(" ", $factura_products['products_name']);
   for($desc=0 ; $desc<4 ; $desc++)
      {
   echo  " $bah[$desc]" ;
      }
 //     echo '...'.$donde_esta_c['donde_esta'];
  }



 ?>








              </table>

               <?php   } ?>

              </td>

              <td width="7%" height="305" valign="top" style="font-family: Verdana; font-size: 7pt">



                                <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "' order by donde_esta ASC");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>



              <table border="-1" cellpadding="-1" cellspacing="-1" style="border-collapse: collapse; font-family: Verdana; font-size: 7pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                <?php
  $qty2_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_id ='" . $factura_products['products_id'] . "'");
         $qty2 = tep_db_fetch_array($qty2_values);
           if ($qty2['products_quantity_control'] == $qty2['products_quantity']){
                $color = '#CCFF66';
                        }else if ($qty2['products_quantity_control'] == 0){
                $color = '';
                        }else if ($qty2['products_quantity_control'] <= $qty2['products_quantity']){
                      $color = '#00FFFF';
                    }else{
                    $color = '';
                }
                    ?>
 <td width="100%" height="13" bgcolor="<?php echo $color; ?>">&nbsp;



              <?php
                             $precio =    $factura_products['final_price'];


              echo $currencies->format($precio);?>  </p>



                          </td>
                </tr>
              </table>

                     <?php   } ?>









              </td>

              <td width="7%" height="305" valign="top" style="font-family: Verdana; font-size: 7pt">

                            <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "' order by donde_esta ASC");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>


              <table border="-1" cellpadding="-1" cellspacing="-1" style="border-collapse: collapse; font-family: Verdana; font-size: 7pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                <?php
  $qty2_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_id ='" . $factura_products['products_id'] . "'");
         $qty2 = tep_db_fetch_array($qty2_values);
           if ($qty2['products_quantity_control'] == $qty2['products_quantity']){
                $color = '#CCFF66';
                        }else if ($qty2['products_quantity_control'] == 0){
                $color = '';
                        }else if ($qty2['products_quantity_control'] <= $qty2['products_quantity']){
                      $color = '#00FFFF';
                    }else{
                    $color = '';
                }
                    ?>
 <td width="100%" height="13" bgcolor="<?php echo $color; ?>">&nbsp;




                  <?php echo $factura_products['products_quantity'] ?>












                  </td>
                </tr>
              </table>
               <?php   } ?>
              </td>

              <td width="7%" height="305" valign="top" style="font-family: Verdana; font-size: 7pt">

        <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "' order by donde_esta ASC");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>
              <table border="-1" cellpadding="-1" cellspacing="-1" style="border-collapse: collapse; font-family: Verdana; font-size: 7pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                <?php
  $qty2_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_id ='" . $factura_products['products_id'] . "'");
         $qty2 = tep_db_fetch_array($qty2_values);
           if ($qty2['products_quantity_control'] == $qty2['products_quantity']){
                $color = '#CCFF66';
                        }else if ($qty2['products_quantity_control'] == 0){
                $color = '';
                        }else if ($qty2['products_quantity_control'] <= $qty2['products_quantity']){
                      $color = '#00FFFF';
                    }else{
                    $color = '';
                }
                    ?>
 <td width="100%" height="13" bgcolor="<?php echo $color; ?>">&nbsp;
<?php  echo $factura_products['products_quantity_control']; ?></td>
                </tr>
              </table>
                     <?php   } ?>
              </td>

              <td width="7%" height="305" valign="top" style="font-family: Verdana; font-size: 7pt">
                           <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "' order by donde_esta ASC");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>

              <table border="-1" cellpadding="-1" cellspacing="-1" style="border-collapse: collapse; font-family: Verdana; font-size: 7pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                 <?php
  $qty2_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $_GET['oID'] . "' and products_id ='" . $factura_products['products_id'] . "'");
         $qty2 = tep_db_fetch_array($qty2_values);
           if ($qty2['products_quantity_control'] == $qty2['products_quantity']){
                $color = '#CCFF66';
                        }else if ($qty2['products_quantity_control'] == 0){
                $color = '';
                        }else if ($qty2['products_quantity_control'] <= $qty2['products_quantity']){
                      $color = '#00FFFF';
                    }else{
                    $color = '';
                }
                    ?>
 <td width="100%" height="13" bgcolor="<?php echo $color; ?>">&nbsp;




                  <?php echo $currencies->format(($factura_products['final_price']*$factura_products['products_quantity']) * OT_TAX_IVA / 100 + ($factura_products['final_price']*$factura_products['products_quantity']) );?>







                  </td>
                </tr>




              </table>
              <?php   } ?>
                              </td>
            </tr>





          </table>

          </td>
        </tr>
        <tr>
          <td width="100%" height="44">




          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="62%">&nbsp;</td>
              <td width="38%">
              <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%" height="48">
                <tr>
                  <td width="100%" height="48" valign="top">
                  <p style="margin-top: 0; margin-bottom: 0" align="left">
                  <?php ECHO TEXT_SUBTOTAL_FACTURA_M ?></p>
                  <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                  <p style="margin-top: 0; margin-bottom: 0" align="right">
                  <?php echo $factura_subtotal['text'] ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="19">
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="62%">&nbsp;</td>
              <td width="38%">
              <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%" height="24">
                <tr>
                  <td width="100%" height="48">
                  <p style="margin-top: 0; margin-bottom: 0" align="left"><?php ECHO IMPUESTOS ?></p>
                  <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                  <p style="margin-top: 0; margin-bottom: 0" align="right">
                  <?php echo $factura_tax['text'] ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="19">
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="62%">&nbsp;</td>
              <td width="38%">
              <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%" height="48">
                <tr>
                  <td width="100%" height="48">
                  <p style="margin-top: 0; margin-bottom: 0" align="left"><?php ECHO TEXT_GASTOS_DE_ENVIO_M ?></p>
                  <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                  <p style="margin-top: 0; margin-bottom: 0" align="right">
                  <?php echo $factura_shipping['text'] ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="18">
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="50">
            <tr>
              <td width="62%" height="50">&nbsp;</td>
              <td width="38%" height="50">
              <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%">
                <tr>
                  <td width="100%">
                  <p style="margin-top: 0; margin-bottom: 0" align="left"><?php ECHO TEXT_TOTAL_FACTURA_M ?></p>
                  <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                  <p style="margin-top: 0; margin-bottom: 0" align="right">
                  <?php echo $factura_total['text'] ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="19">&nbsp;</td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
  </center>
</div>


<p align="center">.</p>
 <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>









</body>

</html>

     <?php






                             }



 ?>

