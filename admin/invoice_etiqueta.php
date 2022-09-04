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

  $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
  $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");

  include(DIR_WS_CLASSES . 'order.php');
  $order = new order($oID);



                $factura_orders_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 6 . "' or orders_status =  '" . 5 .  "' or orders_status =  '" . 10 .  "' or orders_status =  '" . 20 .  "' or orders_status =  '" . 25 .   "' or orders_status =  '" . 119 .   "' order by delivery_name");
               while   ( $factura_orders = mysql_fetch_array($factura_orders_values)) {


          $factura_price_raw = "select sum(products_price) as value, sum(products_price) as price, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id ='" . $factura_orders['orders_id'] . "'";
  $factura_price_query = mysql_query($factura_price_raw);
  $factura_price= mysql_fetch_array($factura_price_query);



 $factura_shipping_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_shipping' . "'");
              $factura_shipping = mysql_fetch_array($factura_shipping_values);

 $factura_total_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_total' . "'");
              $factura_total = mysql_fetch_array($factura_total_values);


 $factura_subtotal_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_subtotal' . "'");
              $factura_subtotal = mysql_fetch_array($factura_subtotal_values);


           $admin_lof_values = mysql_query("select * from " . TABLE_ADMIN . " where id = '" . $admin['id'] . "'");
 $admin_lof = mysql_fetch_array($admin_lof_values);



  ?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family:Verdana; font-size:10pt" bordercolor="#111111" width="100%" height="108">
  <tr>
    <td width="4%" height="106" valign="top">&nbsp;</td>
    <td width="46%" height="106" valign="top">
        <p style="margin-top: 0; margin-bottom: 0"> </p>
    <p style="margin-top: 0; margin-bottom: 0"><span style="font-size: 5pt">.</span></p>
    <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo $factura_orders['delivery_name'] ?></font></p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo $factura_orders['delivery_street_address'] ?></font></p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo  $factura_orders['delivery_city'] . ' ' . $factura_orders['delivery_postcode'] ?></font></p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo $factura_orders['delivery_state'] . ' ' . $factura_orders['delivery_country'] ?></font></p>

    <td width="46%" height="106" valign="top">
    <p style="margin-top: 0; margin-bottom: 0">
    <span style="font-size: 5pt">.</span></p>
    <p style="margin-top: 0; margin-bottom: 0">
    &nbsp;</p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo STORE_OWNER; ?></font></a></p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo $admin_lof['admin_direccion'] ?></font></p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo $admin_lof['admin_poblacion'] ?>
     <?php ECHO $admin_lof['admin_cp']; ?></font></p>
    <p style="margin-top: 0; margin-bottom: 0"><font size="2"><?php echo $admin_lof['admin_provincia'] . ' - ' . 'España'; ?></font></p>
    <td width="4%" height="106" valign="top">&nbsp;</td>
  </tr>
</table>
</body>

</html>
     <?php






                             }



 ?>
<p>&nbsp;</p>
