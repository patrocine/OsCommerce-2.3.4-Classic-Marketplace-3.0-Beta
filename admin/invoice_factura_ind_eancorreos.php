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



               $factura_orders_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
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

 $ot_shipping_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" .  $factura_orders['orders_id'] . "' and class =  '" . 'ot_shipping' . "'");
              $ot_shipping = mysql_fetch_array($ot_shipping_values);


 $ot_total_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" .  $factura_orders['orders_id'] . "' and class =  '" . 'ot_total' . "'");
              $ot_total = mysql_fetch_array($ot_total_values);


            $admin_lof_values = mysql_query("select * from " . TABLE_ADMIN . " where id = '" . $admin['id'] . "'");
 $admin_lof = mysql_fetch_array($admin_lof_values);


  ?>


<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td height="19">&nbsp;.</td>
	</tr>
	<tr>
		<td height="161">
		<table border="0" width="100%" id="table2" cellspacing="0" cellpadding="0">
			<tr>
				<td height="19">&nbsp;</td>
			</tr>
			<tr>
				<td>
				<table border="0" width="100%" id="table3">
					<tr>
						<td width="8">&nbsp;</td>
						<td width="518"><?php ECHO 'jonathan Castro SOLOMINIBIKE.COM'; ?></td>
						<td></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>
				<table border="0" width="100%" id="table4">
					<tr>
						<td width="7">&nbsp;</td>
						<td width="598"><?php echo 'Nector Alamo Nº53 1ºIzqu' ?></td>
						<td><?php ECHO $admin_lof['admin_cp']; ?></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>
				<table border="0" width="100%" id="table5" cellspacing="0" cellpadding="0">
					<tr>
						<td width="65">&nbsp;</td>
						<td width="442"><?php echo $admin_lof['admin_poblacion'] ?></td>
						<td><?php echo $admin_lof['admin_provincia'] ?> </td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>
				<table border="0" width="100%" id="table6" cellspacing="0" cellpadding="0">
					<tr>
						<td width="47">&nbsp;</td>
						<td width="206">España</td>
						<td width="208"><?php echo $admin_lof['admin_telefono'] ?></td>
						<td>
						<?php echo $admin_lof['admin_email_address'] ?></a></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td height="19">&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table7">
			<tr>
				<td width="7">&nbsp;</td>
				<td width="519"><?php echo $factura_orders['delivery_name']; ?></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table8">
			<tr>
				<td width="6">&nbsp;</td>
				<td width="598"><?php echo $factura_orders['delivery_street_address']; ?></td>
				<td><?php echo $factura_orders['delivery_postcode']; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table9" cellspacing="0" cellpadding="0">
			<tr>
				<td width="57">&nbsp;</td>
				<td width="441"><?php echo $factura_orders['delivery_city']; ?></td>
				<td><?php echo $factura_orders['delivery_state']; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table10" cellspacing="0" cellpadding="0">
			<tr>
				<td width="47">&nbsp;</td>
				<td width="207"><?php echo $factura_orders['delivery_country']; ?></td>
				<td width="206"><?php echo $factura_orders['customers_telephone']; ?></td>
				<td><?php echo $factura_orders['customers_email_address']; ?></a></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height="90">&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table11">
			<tr>
				<td width="242">&nbsp;</td>
				<td width="87">
				<p align="center"><font size="4"><?php echo $currencies->format($ot_total['value']); ?></font></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table12">
			<tr>
				<td width="195">&nbsp;</td>
				<td width="388">
				<p align="left"><?php echo $admin_lof['admin_cuentabancaria'] ?></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<p>&nbsp;</p>

<p>&nbsp;</p>
<p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
<p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
<p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
<p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
  <p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
 <p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
  <p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
 <p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>
  <p style="margin-top: -1px; margin-bottom: -1px">&nbsp;</p>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>






     <?php






                             }



 ?>

