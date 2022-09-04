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



          ?>

<?php



   $datos_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 25 . "' or orders_status = '" . 119 . "' or orders_status = '" . 6 . "'");
               while   ( $datos = mysql_fetch_array($datos_values)) {


          $reembolso_price_raw = "select sum(products_price) as value, sum(products_price) as price, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id ='" . $datos['orders_id'] . "'";
  $reembolso_price_query = mysql_query($reembolso_price_raw);
  $reembolso_price= mysql_fetch_array($reembolso_price_query);



 $ot_shipping_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $datos['orders_id'] . "' and class =  '" . 'ot_shipping' . "'");
              $ot_shipping = mysql_fetch_array($ot_shipping_values);


 $ot_total_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $datos['orders_id'] . "' and class =  '" . 'ot_total' . "'");
              $ot_total = mysql_fetch_array($ot_total_values);


            $admin_lof_values = mysql_query("select * from " . TABLE_ADMIN . " where id = '" . $admin['id'] . "'");
 $admin_lof = mysql_fetch_array($admin_lof_values);






   ?>






<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td height="69">&nbsp;.</td>
	</tr>
	<tr>
		<td height="111">
		<table border="0" width="100%" id="table2" cellspacing="0" cellpadding="0">
			<tr>
				<td height="19">&nbsp;</td>
			</tr>
			<tr>
				<td>
				<table border="0" width="100%" id="table3">
					<tr>
						<td width="25">&nbsp;</td>
						<td width="501"><?php ECHO STORE_OWNER; ?></td>
						<td></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>
				<table border="0" width="100%" id="table4">
					<tr>
						<td width="23">&nbsp;</td>
						<td width="606"><?php echo $admin_lof['admin_direccion'] ?></td>
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
						<td width="283">España</td>
						<td width="170"><?php echo $admin_lof['admin_telefono'] ?></td>
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
		<td height="25">&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table7">
			<tr>
				<td width="21">&nbsp;</td>
				<td width="505"><?php echo $datos['delivery_name']; ?></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table8">
			<tr>
				<td width="21">&nbsp;</td>
				<td width="609"><?php echo $datos['delivery_street_address']; ?></td>
				<td><?php echo $datos['delivery_postcode']; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table9" cellspacing="0" cellpadding="0">
			<tr>
				<td width="57">&nbsp;</td>
				<td width="441"><?php echo $datos['delivery_city']; ?></td>
				<td><?php echo $datos['delivery_state']; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table10" cellspacing="0" cellpadding="0">
			<tr>
				<td width="47">&nbsp;</td>
				<td width="283"><?php echo $datos['delivery_country']; ?></td>
				<td width="170"><?php echo $datos['customers_telephone']; ?></td>
				<td><?php echo $datos['customers_email_address']; ?></a></td>
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
		<td height="88">&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table11">
			<tr>
				<td width="284">&nbsp;</td>
				<td width="77">
				<p align="center"><font size="4"><?php// echo $currencies->format($ot_total['value'] * 0.7 / 100 + $ot_total['value']); ?></font></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table border="0" width="100%" id="table12">
			<tr>
				<td width="214">&nbsp;</td>
				<td width="369">
				<p align="left"><?php// echo $admin_lof['admin_cuentabancaria'] ?></td>
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









