<?php
/*
  $Id: invoice.php,v 1.1 2002/06/11 18:17:59 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
      //  $status_liquidacion = 37;
        
        
        
  require('includes/application_top.php');
  require('includes/conf_status.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
  $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");

  include(DIR_WS_CLASSES . 'order.php');
  $order = new order($oID);






      // $fecha_inicio = '2007-08-01';                                                                         $pagado_transferencia
                //  $fecha_final = '2007-08-31';

                $status_pro = $pagado;
               // $status_pro = $pagado_transferencia;
               
                       $status = $_POST['status'];
                       $status2 = $_POST['status2'];
                       $fecha_inicio = $_POST['fecha_inicio'];
                        $fecha_final = $_POST['fecha_final'];
                        
                        
                         //  echo $fecha_inicio . ' Hasta '.$status . ' - ' . $fecha_final;
                           
                           
                           
                $factura_orders_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $status . "'  and last_modified  >= '" . $fecha_inicio . "' and last_modified  <= '" . $fecha_final . "' or orders_status = '" . $status2 . "'  and last_modified >= '" . $fecha_inicio . "' and last_modified <= '" . $fecha_final . "' or orders_status = '" . $status2 . "'  and last_modified >= '" . $fecha_inicio . "' and last_modified <= '" . $fecha_final . "' ORDER BY last_modified ASC");
                if   ( $factura_orders = mysql_fetch_array($factura_orders_values)) {


          $factura_price_raw = "select sum(products_price) as value, sum(products_price) as price, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id ='" . $factura_orders['orders_id'] . "'";
  $factura_price_query = mysql_query($factura_price_raw);
  $factura_price= mysql_fetch_array($factura_price_query);




 $liquidacion_values = mysql_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $tienda_cuenta_cliente . "'");
              $liquidacion = mysql_fetch_array($liquidacion_values);


 $liquidacion_h_values = mysql_query("select * from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $tienda_cuenta_cliente . "'");
              $liquidacion_h = mysql_fetch_array($liquidacion_h_values);



 $factura_shipping_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_shipping' . "'");
              $factura_shipping = mysql_fetch_array($factura_shipping_values);

 $factura_total_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_total' . "'");
              $factura_total = mysql_fetch_array($factura_total_values);


 $factura_subtotal_values = mysql_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_subtotal' . "'");
              $factura_subtotal = mysql_fetch_array($factura_subtotal_values);
              

          $sd_raw = "select sum(final_price_euro) as value, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and o.orders_status = '" . $status . "'  and o.last_modified >= '" . $fecha_inicio . "' and o.last_modified <= '" . $fecha_final . "' or orders_status = '" . $status2 . "'  and last_modified >= '" . $fecha_inicio . "' and last_modified <= '" . $fecha_final . "' ORDER BY last_modified ASC";
  $sd_query = mysql_query($sd_raw);
  $sd= mysql_fetch_array($sd_query);

          $sds_raw = "select sum(final_price_tienda) as value, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o  where o.orders_id = op.orders_id and o.orders_status = '" . $status . "'  and o.last_modified >= '" . $fecha_inicio . "' and o.last_modified <= '" . $fecha_final . "' or orders_status = '" . $status2 . "'  and last_modified >= '" . $fecha_inicio . "' and last_modified <= '" . $fecha_final . "' ORDER BY last_modified ASC";
  $sds_query = mysql_query($sds_raw);
  $sds= mysql_fetch_array($sds_query);

            $suma = 78;

                  ?>


  <p>BALANCE DE VENTAS</p>
<?php echo $fecha_inicio . ' Hasta ' . $fecha_final ?>

<p></p>

         <?php


       //   $factura_products_values = mysql_query("select op.products_quantity, op.products_name, op.products_model, op.products_price, op.final_price_tienda, op.final_price_euro, o.orders_id, pv.proveedor_name from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p, " . 'proveedor' . " pv where op.products_id = p.products_id and pv.proveedor_id = p.codigo_proveedor and o.orders_id = op.orders_id and  o.orders_status = '" . $status . "'  and o.last_modified >= '" . $fecha_inicio . "' and o.last_modified <= '" . $fecha_final . "'");
          $factura_products_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $status . "'  and last_modified >= '" . $fecha_inicio . "' and last_modified <= '" . $fecha_final . "' or orders_status = '" . $status2 . "'  and last_modified >= '" . $fecha_inicio . "' and last_modified <= '" . $fecha_final . "' ORDER BY last_modified ASC");
         while      ($factura_products = mysql_fetch_array($factura_products_values)) {



          $cus_values = mysql_query("select * from " . 'customers' . " where customers_id = '" . $factura_products['customers_id'] . "'");
        $customers = mysql_fetch_array($cus_values);  ?>







<table border="0" width="100%" id="table1" cellspacing="0" style="font-size: 8pt; font-family: Verdana; font-weight: bold">
	<tr>
		<td width="220"><?php echo $factura_products['products_model']; ?></td>
		<td width="496"> <font size="1" face="Verdana">



                  <?php
                  

                            // ++$suma

                     echo   '|'. $factura_products['orders_id'] . '|' . $factura_products['last_modified'] .'|'. $customers['customers_dni'] .'|'  ;

   if ($featured_products_array[$i]['shortdescription'] != '') {

  } else {
   $bah = explode(" ", $factura_products['delivery_name']);
   for($desc=0 ; $desc<3 ; $desc++)
      {
      echo "$bah[$desc] ";
      }
      echo '|';

          }

     $cliente_values = mysql_query("select * from " . 'orders_total' . " where orders_id = '" . $factura_products['orders_id'] . "' and class = '" . ot_total . "'");
              $cliente = mysql_fetch_array($cliente_values);


     echo $currencies->format($cliente['value']);

 ?>






  </font></td>
		<td width="105"> <?php ?></td>
		<td width="22">
		<p align="center">







  </td>
		<td width="84"><?php // ECHO  $currencies->format($factura_products['final_price_tienda']);





                  ?></td>
		<td>
  
  
  
  
       <?php

                           if ( $factura_products['final_price_euro'] == $factura_products['final_price_tienda']){
                            ?>

                    <a target="_blank" href="<?php echo 'edit_orders_tienda.php?oID='.$factura_products['orders_id']; ?>"><font color="#FF0000">

                      <?php // echo $currencies->format($factura_products['final_price_euro']);?>

                       <font color="#FF0000">

                               <?php
                            }else{
                                 ?>


                                         <a target="_blank" href="<?php echo 'edit_orders_tienda.php?oID='.$factura_products['orders_id']; ?>">

                      <?php // echo  $currencies->format($factura_products['final_price_euro']);?>


                                 <?php
                              }
                                   ?>
  
  


                      </td>







           	</tr>
</table>




       <?php


        }






             ?>










                  <?php















}






          $total_print_values = mysql_query("select sum(value) as valu from " . TABLE_ORDERS . " o, orders_total ot where o.orders_id = ot.orders_id and class = '" . ot_total . "' and value >= 0 and orders_status = '" . $status . "'  and last_modified  >= '" . $fecha_inicio . "' and last_modified  <= '" . $fecha_final . "'");
      $total_print = mysql_fetch_array($total_print_values);

          $total_print2_values = mysql_query("select sum(value) as valu from " . TABLE_ORDERS . " o, orders_total ot where o.orders_id = ot.orders_id and class = '" . ot_total . "' and value >= 0 and orders_status = '" . $status2 . "'  and last_modified  >= '" . $fecha_inicio . "' and last_modified  <= '" . $fecha_final . "'");
      $total_print2 = mysql_fetch_array($total_print2_values);



        echo 'Total|'.$currencies->format($total_print['valu']+$total_print2['valu']);




        $total_print_values = mysql_query("select sum(value) as valu from " . TABLE_ORDERS . " o, orders_total ot where o.orders_id = ot.orders_id and class = '" . ot_total . "' and value <= 0 and orders_status = '" . $status . "'  and last_modified  >= '" . $fecha_inicio . "' and last_modified  <= '" . $fecha_final . "'");
      $total_print = mysql_fetch_array($total_print_values);




        echo '||Total Negativo|'.$currencies->format($total_print['valu']);






                                                                                                                                                                                                                                                      
               
               
?>



