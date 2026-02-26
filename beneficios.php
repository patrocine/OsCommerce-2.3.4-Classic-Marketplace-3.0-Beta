<?php


?>


<?php
/*
  $Id: osCAffiliate 20-Nov-2014
  OSC-Affiliate for osCommerce 2.3xx family
  Contribution based on: http://addons.oscommerce.com/info/158
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 - 2014 osCommerce
  Released under the GNU General Public License
  Updated by Fimble (http://forums.oscommerce.com/user/15542-fimble/)
  http://www.linuxuk.co.uk
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_INFO);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_INFO));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo BENEFICIOS; ?></h1>

<div class="contentContainer">
  <div class="contentText">
    <?php echo 'Total de Reparto de Beneficios entre los socios'; ?>
  </div>



<div class="contentContainer">
  <div class="contentText">
    <?php




     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 37 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);

     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 37 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio4= tep_db_fetch_array($sumar_entregado_total_sales_query);



            echo '<p style="margin-top: 0; margin-bottom: 0">Total Beneficios en cobrados: '.$sumar_beneficio['value'].'Eur</td>';

            echo '<p style="margin-top: 0; margin-bottom: 0">Total Facturas en cobrados: '. number_format($sumar_beneficio4['value'], 2, '.', '').'Eur</td>';

           echo '<p style="margin-top: 0; margin-bottom: 0">Total Precio Costo en cobrados: '.($sumar_beneficio4['value']-$sumar_beneficio['value']).'Eur</td>';

               ?>
  </div>
     <p>&nbsp;</p>
<p><i><b><font size="4">Cobrados Pendientes de Repartir beneficios entre los
socios</font></b></i></p>
<table border="0" id="table1" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td width="96">Orders Id</td>
		<td width="260">Nombre</td>
		<td width="96">Total Pedido</td>
		<td width="96">Total Beneficios</td>
        <td width="96">Precio Costo</td>

  <?php

               $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 37 . "' order by orders_id desc");
            while ($factura_orders2 = tep_db_fetch_array($factura_orders_values)){

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);
    
    
     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_price from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio2= tep_db_fetch_array($sumar_entregado_total_sales_query);


       ?>
  
	</tr>
	<tr>
		<td width="96"><?php echo $factura_orders2['orders_id'] ?></td>
		<td width="260"><?php echo $factura_orders2['customers_name'] ?></td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value']-$sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
	</tr>
 
               <?php
  }
      ?>
 
</table>


     <p>&nbsp;</p>
     
     




    <?php



     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 131 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);






  $AYUDA_TEXT = 'Pedidos pendiente de ser abonados, cuando se cobran se factura en la caja del dia.';

               ?>
  </div>
     <p>&nbsp;</p>
<p><i><b><font size="4">Albaranes a clientes Pendientes de pasar a cobrados.</font></b></i> <a class="hastip"  title="<?php echo $AYUDA_TEXT;?>"><b><font size="5" color="#FFFFFF"><span style="background-color: #000000">_??_</span></font></b></i></p> </a>
<table border="0" id="table1" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td width="96">Orders Id</td>
		<td width="260">Nombre</td>
		<td width="96">Total Pedido</td>
		<td width="96">Total Beneficios</td>
        <td width="96">Precio Costo</td>

  <?php
           $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =139";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $prepago_procesando= tep_db_fetch_array($sumar_entregado_total_sales_query);

            $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 131 . "' order by orders_id desc");
            while ($factura_orders2 = tep_db_fetch_array($factura_orders_values)){

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);


     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_price from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio2= tep_db_fetch_array($sumar_entregado_total_sales_query);


       ?>

	</tr>
	<tr>
		<td width="96"><?php echo $factura_orders2['orders_id'] ?></td>
		<td width="260"><?php echo $factura_orders2['customers_name'] ?></td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value']-$sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
	</tr>
               </div>
                <?php
              }

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 131 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);

     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 131 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio4= tep_db_fetch_array($sumar_entregado_total_sales_query);



            echo '<p style="margin-top: 0; margin-bottom: 0">Total Beneficios en Albaranes: '.$sumar_beneficio['value'].'Eur</td>';

            echo '<p style="margin-top: 0; margin-bottom: 0">Total Facturas en Albaranes: '. number_format($sumar_beneficio4['value'], 2, '.', '').'Eur</td>';

           echo '<p style="margin-top: 0; margin-bottom: 0">Total Precio Costo en Albaranes: '.($sumar_beneficio4['value']-$sumar_beneficio['value']).'Eur</td>  <p>&nbsp;</p>';




 //echo 'Beneficios en Albaranes acumulados: '.$sumar_beneficio['value'].'Eur';



 $AYUDA_TEXT = 'Los clientes que confirman su pedido quedan a la espera de ser recogido';
      ?>

</table>


     <p>&nbsp;</p>








 </div>
     <p>&nbsp;</p>
<p><i><b><font size="4">Pedidos de clientes Pendientes de recoger</font></b></i> <a class="hastip"  title="<?php echo $AYUDA_TEXT;?>"><b><font size="5" color="#FFFFFF"><span style="background-color: #000000">_??_</span></font></b></i></p> </a>
<table border="0" id="table1" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td width="96">Orders Id</td>
		<td width="260">Nombre</td>
		<td width="96">Total Pedido</td>
		<td width="96">Total Beneficios</td>
        <td width="96">Precio Costo</td>

  <?php
           $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =139";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $prepago_procesando= tep_db_fetch_array($sumar_entregado_total_sales_query);

            $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 66 . "' order by orders_id desc");
            while ($factura_orders2 = tep_db_fetch_array($factura_orders_values)){

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);


     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_price from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio2= tep_db_fetch_array($sumar_entregado_total_sales_query);


       ?>

	</tr>
	<tr>
		<td width="96"><?php echo $factura_orders2['orders_id'] ?></td>
		<td width="260"><?php echo $factura_orders2['customers_name'] ?></td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value']-$sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
	</tr>
               </div>
                <?php






 //echo 'Beneficios en Albaranes acumulados: '.$sumar_beneficio['value'].'Eur';


  }


     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 66 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);

     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 66 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio4= tep_db_fetch_array($sumar_entregado_total_sales_query);



            echo '<p style="margin-top: 0; margin-bottom: 0">Total Beneficios en Recoger: '.$sumar_beneficio['value'].'Eur</td>';

            echo '<p style="margin-top: 0; margin-bottom: 0">Total Facturas en Recoger: '. number_format($sumar_beneficio4['value'], 2, '.', '').'Eur</td>';

           echo '<p style="margin-top: 0; margin-bottom: 0">Total Precio Costo en Recoger: '.($sumar_beneficio4['value']-$sumar_beneficio['value']).'Eur</td>  <p>&nbsp;</p>';





 $AYUDA_TEXT = 'Los clientes que confirman su pedido quedan a la espera de ser recogido';
      ?>

</table>


     <p>&nbsp;</p>




 </div>
     <p>&nbsp;</p>
<p><i><b><font size="4">Presupuestos de clientes Pendientes de confirmación</font></b></i> <a class="hastip"  title="<?php echo $AYUDA_TEXT;?>"><b><font size="5" color="#FFFFFF"><span style="background-color: #000000">_??_</span></font></b></i></p> </a>
<table border="0" id="table1" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td width="96">Orders Id</td>
		<td width="260">Nombre</td>
		<td width="96">Total Pedido</td>
		<td width="96">Total Beneficios</td>
        <td width="96">Precio Costo</td>

  <?php
           $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =139";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $prepago_procesando= tep_db_fetch_array($sumar_entregado_total_sales_query);

            $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 81 . "' order by orders_id desc");
            while ($factura_orders2 = tep_db_fetch_array($factura_orders_values)){

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);


     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_price from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio2= tep_db_fetch_array($sumar_entregado_total_sales_query);


       ?>

	</tr>
	<tr>
		<td width="96"><?php echo $factura_orders2['orders_id'] ?></td>
		<td width="260"><?php echo $factura_orders2['customers_name'] ?></td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value']-$sumar_beneficio['value'], 2, '.', '') ?>Eur</td>
	</tr>

               <?php
  }




     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 81 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);

     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 81 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio4= tep_db_fetch_array($sumar_entregado_total_sales_query);



            echo '<p style="margin-top: 0; margin-bottom: 0">Total Beneficios en Presupuestos : '.$sumar_beneficio['value'].'Eur</td>';

            echo '<p style="margin-top: 0; margin-bottom: 0">Total Facturas en Presupuestos: '. number_format($sumar_beneficio4['value'], 2, '.', '').'Eur</td>';

           echo '<p style="margin-top: 0; margin-bottom: 0">Total Precio Costo en Presupuestos: '.($sumar_beneficio4['value']-$sumar_beneficio['value']).'Eur</td>  <p>&nbsp;</p>';




$AYUDA_TEXT = 'El valor total de toda la mercancía a precio base de proveedor que ha entrado en la empresa.';
       ?>

</table>
















 </p>

     <p>&nbsp;</p>
<p><i><b><font size="4">Valor total de toda las Mercancías que han entrado en el comercio a Precio Base desde el principio. (precio costo sin descuento)</font></b></i> <a class="hastip"  title="<?php echo $AYUDA_TEXT;?>"><b><font size="5" color="#FFFFFF"><span style="background-color: #000000">_??_</span></font></b></i></p> </a>
 <?php

     $sumar_entregado_total_sales_raw = "select sum(customers_group_price*products_quantity) as value, count(*) as customers_group_price from orders_products op, orders o, products_groups pg where op.products_id = pg.products_id and pg.customers_group_id = 2 and o.orders_id = op.orders_id and o.orders_status = '" . 75 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio2= tep_db_fetch_array($sumar_entregado_total_sales_query);



      ?>

       TOTAL:  <?php echo number_format($sumar_beneficio2['value'], 2, '.', '') ?>Eur

     <p>&nbsp;</p>

     <p>&nbsp;</p>
<p><i><b><font size="3">Valor total de toda la mercancía que hay en stock a Precio Base (precio costo sin descuento)</font></b></i></p>


 <?php

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 15 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio3= tep_db_fetch_array($sumar_entregado_total_sales_query);




      ?>



      TOTAL STOCK REAL ACTUAL:  <?php echo number_format($sumar_beneficio2['value'] - $sumar_beneficio3['value'], 2, '.', '') ?>Eur </p>


      <p>&nbsp;</p>
<p><i><b><font size="3">Valor total de productos facturados, beneficios y costos de la mercancia (precio costo sin descuento)</font></b></i></p>



     <?php





     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 15 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);

     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 15 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio4= tep_db_fetch_array($sumar_entregado_total_sales_query);



            echo '<p style="margin-top: 0; margin-bottom: 0">Total Beneficios Repartidos: '.$sumar_beneficio['value'].'Eur</td>';

            echo '<p style="margin-top: 0; margin-bottom: 0">Total Facturado: '. number_format($sumar_beneficio4['value'], 2, '.', '').'Eur</td>';

           echo '<p style="margin-top: 0; margin-bottom: 0">Total Precio Costo facturados: '.($sumar_beneficio4['value']-$sumar_beneficio['value']).'Eur</td>';




            ?>




</table>
     <p>&nbsp;</p>

     <p>&nbsp;</p>
<p><i><b><font size="4">Inversión de Socios en mercancias</font></b></i></p>



<table border="0" width="31%" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td width="179"><b>Nombre<b>Nombre</b></td>
		<td width="300"><b>Importes Pendientes</b></td>
	</tr>
	<tr>
            <?php
       $concep_values = tep_db_query("select * from " . 'contabilidad_general' . " group by observaciones order by observaciones desc ");
      while ($concep_nom = tep_db_fetch_array($concep_values)){

        $sumar_entregado_total_sales_raw = "select sum(importe) as value, count(*) as importe from contabilidad_general where observaciones = '" . $concep_nom['observaciones'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_pvp= tep_db_fetch_array($sumar_entregado_total_sales_query);


                 ?>
		<td width="179"><?php  echo $concep_nom['observaciones']  ?></td>
		<td width="300"><?php  echo $sumar_pvp['value']  ?>Eur.</td>
	</tr>

      <?php
                  }
        ?>








 </div>
     <p>&nbsp;</p>


  </table>


<p><i><b><font size="4">Albaranes a Proveedores son pedidos a proveedores que estan pendiente de entrada o requieren atención de reposición.</font></b></i> <a class="hastip"  title="<?php echo $AYUDA_TEXT;?>"><b><font size="5" color="#FFFFFF"><span style="background-color: #000000">_??_</span></font></b></i></p> </a>
<table border="0" id="table1" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td width="96">Orders Id</td>
		<td width="260">Nombre</td>
		<td width="96">Total Pedido</td>

  <?php
           $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =139";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $prepago_procesando= tep_db_fetch_array($sumar_entregado_total_sales_query);

            $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 77 . "' order by orders_id desc");
            while ($factura_orders2 = tep_db_fetch_array($factura_orders_values)){

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);


     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_price from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio2= tep_db_fetch_array($sumar_entregado_total_sales_query);


       ?>

	</tr>
	<tr>
		<td width="96"><?php echo $factura_orders2['orders_id'] ?></td>
		<td width="260"><?php echo $factura_orders2['customers_name'] ?></td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value'], 2, '.', '') ?>Eur</td>
	</tr>

               <?php
  }




     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 77 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);

     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 77 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio4= tep_db_fetch_array($sumar_entregado_total_sales_query);




            echo '<p style="margin-top: 0; margin-bottom: 0">Total Facturas en Presupuestos: '. number_format($sumar_beneficio4['value'], 2, '.', '').'Eur</td>';




$AYUDA_TEXT = 'El valor total de toda la mercancía a precio base de proveedor que ha entrado en la empresa.';
       ?>













 </div>



  </table>


<p><i><b><font size="4">Facturas a Proveedor son pedidos a proveedores y reposiciones de mercancias.</font></b></i> <a class="hastip"  title="<?php echo $AYUDA_TEXT;?>"><b><font size="5" color="#FFFFFF"><span style="background-color: #000000">_??_</span></font></b></i></p> </a>
<table border="0" id="table1" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td width="96">Orders Id</td>
		<td width="260">Nombre</td>
		<td width="96">Total Pedido</td>

  <?php
           $sumar_entregado_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from orders_products op,  orders o where o.orders_id = op.orders_id and op.products_id ='" . $products_id_stock . "'and o.orders_status =139";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $prepago_procesando= tep_db_fetch_array($sumar_entregado_total_sales_query);

            $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 75 . "' order by orders_id desc");
            while ($factura_orders2 = tep_db_fetch_array($factura_orders_values)){

     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);


     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_price from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_id = '" . $factura_orders2['orders_id'] . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio2= tep_db_fetch_array($sumar_entregado_total_sales_query);


       ?>

	</tr>
	<tr>
		<td width="96"><?php echo $factura_orders2['orders_id'] ?></td>
		<td width="260"><?php echo $factura_orders2['customers_name'] ?></td>
		<td width="96"><?php echo number_format($sumar_beneficio2['value'], 2, '.', '') ?>Eur</td>
	</tr>

               <?php
  }




     $sumar_entregado_total_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 75 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_entregado_total_sales_query);

     $sumar_entregado_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_beneficio from orders_products op, orders o where o.orders_id = op.orders_id and o.orders_status = '" . 75 . "'";
    $sumar_entregado_total_sales_query = tep_db_query($sumar_entregado_total_sales_raw);
    $sumar_beneficio4= tep_db_fetch_array($sumar_entregado_total_sales_query);



            echo '<p style="margin-top: 0; margin-bottom: 0">Total Facturas en Presupuestos: '. number_format($sumar_beneficio4['value'], 2, '.', '').'Eur</td>';






       ?>


  </table>









