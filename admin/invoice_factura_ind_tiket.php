<?php
/*
  $Id: empresa_help1.php,v 1.4 2003/02/17 17:21:11 harley_vb Exp $

  OSC-empresa

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

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




               $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
                while   ( $factura_orders = tep_db_fetch_array($factura_orders_values)) {


          $factura_price_raw = "select sum(products_price) as value, sum(products_price) as price, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id ='" . $factura_orders['orders_id'] . "'";
  $factura_price_query = tep_db_query($factura_price_raw);
  $factura_price= tep_db_fetch_array($factura_price_query);



 $factura_shipping_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_shipping' . "'");
              $factura_shipping = tep_db_fetch_array($factura_shipping_values);

 $factura_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_total' . "'");
              $factura_total = tep_db_fetch_array($factura_total_values);


 $factura_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_subtotal' . "'");
              $factura_subtotal = tep_db_fetch_array($factura_subtotal_values);




        if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}

 $admin_lof_values = tep_db_query("select * from " . TABLE_ADMIN . " where id = '" . $admin['id'] . "'");
 $admin_lof = mysql_fetch_array($admin_lof_values);



?>






<title>TIKET DE COMPRA</title>

<p><u><b><font face="Verdana">TIKET DE COMPRA</font></b></u></p>



<p align="left" style="margin-top: 0; margin-bottom: 0"><b>
<a href="http://www.BonCasaCandelaria.es"><font size="4" face="Verdana">
<?php echo STORE_OWNER ?></font></a></b></p>
<p align="left" style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="2"><b>
En nuestra web puedes ver todos nuestros productos y ofertas con sus precios,
fotos y sincronizados en stock.</b></font></p>
<p>&nbsp;</p>





<p align="left">
&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">FECHA:&nbsp; <?php echo tep_date_short($factura_orders['date_purchased']); ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>

<font face="Verdana" style="font-size: 7pt">Nombre:&nbsp; <?php echo $factura_orders['delivery_name']; ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><u><b><font face="Verdana" size="1">
DETALLES DE FACTURA</font></b></u></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<div align="center">






 <table border="0" width="300" id="table1" cellspacing="0" style="font-family: Verdana; font-size: 6pt">
		<tr>
			<td width="88"><b>Referencia</b></td>
			<td><b>Nombre</b></td>
			<td width="62"><b>Precio</b></span></td>
		</tr>
	</table>
	<table border="0" width="100%" id="table2" cellspacing="0" cellpadding="0">
 
 
                                   <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "' ORDER BY products_model");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>

<tr>
			<td width="7%" height="21">  <b>  <?php echo $factura_products['products_id'] ?>&nbsp;&nbsp;  </td>





 

			<td colspan="3" height="21"><?php echo $factura_products['products_name'] ?> </td>
		</tr>
		<tr>
			<td width="7%">&nbsp;</td>
			<td width="13%">&nbsp;</td>
			<td width="36%"><?php echo $factura_products['products_quantity']. 'X';?>



                                                                            <?php echo $currencies->format($factura_products['final_price']);?></td>
			<td width="44%"><?php echo $currencies->format($factura_products['final_price'] * $factura_products['products_quantity']);?></td>
		</tr>
  
  
                   <?php   } ?>
  
  
  
  
  
  
	</table>











	<table border="0" width="100%" id="table1" cellspacing="0" style="font-family: Verdana; font-size: 20pt">
		<tr>
			<td width="861">&nbsp;</td>


   <?php


      if ($reserva == $factura_orders['orders_status']){

       echo '<td><b>Pendiente de Pagar:</b></td>';

  }else{

 echo '	<td><b>TOTAL:</b></td>';
}

       ?>

			<td width="68"><b><?php echo $factura_total['text'] ?></b></span></td>
		</tr>
	</table>





</div>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>

<p style="margin-top: 0; margin-bottom: 0"><b>
<a href="http://www.EuroConsolas.com"><font color="#000000" face="Verdana">
<?php echo STORE_NAME ?></font></a></b></p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 7pt">  <?php echo STORE_FACTURA ?>  </font></p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 7pt">  <?php echo $admin_lof['admin_direccion'] ?>  </font></p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 7pt">3º
<?php echo $admin_lof['admin_poblacion'] . ' - ' . $admin_lof['admin_cp'] ?>
<p style="margin-top: 0; margin-bottom: 0">
<?php echo $admin_lof['admin_provincia'] ?> </font></p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" style="font-size: 7pt">Tlf:
<?php echo $admin_lof['admin_telefono'] ?> </font></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 7pt">Puede consultar esta factura en su panel de control /
Historial de Pedidos, en caso contrarío para cualquier reclamación es necesario
la presentación de este tiket. </font>
<p><font size="1" face="Verdana">Tiene 7 días para realizar cualquier cambio y
es imprescindible la presentación del ticket de compra y que el producto se
encuentre en su estado original sin ninguna rotura.</font></p>

 <script type="text/javascript">window.print();</script>



          <?php

         }

              ?>



     </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>

</body>
</html>
<?php require('includes/application_bottom.php'); ?>
