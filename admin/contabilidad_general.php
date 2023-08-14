<?php
/*
  $Id: affiliate_sales.php,v 1.6 2003/02/19 15:00:52 simarilius Exp $

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');


  $crear_parte = $_GET['crear_parte'];
  $insertar_cont = $_POST['insertar_cont'];
  $editar_cont = $_GET['editar_cont'];
  $id_registro = $_GET['id_registro'];
  $seleccionar_formulario = $_GET['seleccionar_formulario'];
  $filtrar_palabraclave = $_GET['filtrar_palabraclave'];
  $filtrar_status = $_GET['filtrar_status'];

  
           $concepto = $_POST['concepto'];
           $nombre = $_POST['nombre'];
           $total_presupuesto = $_POST['total_presupuesto'];
           $fianza = $_POST['fianza'];
           $telefono = $_POST['telefono'];
           $observaciones  = $_POST['observaciones'];
           $concepto  = $_POST['concepto'];
           $palabraclave  = $_POST['palabraclave'];
           
    $sumar_total_sales_raw = "select sum(group_price_total) as value, count(*) as group_price_total from products_groups";
    $sumar_total_sales_query = tep_db_query($sumar_total_sales_raw);
    $sumar_total= tep_db_fetch_array($sumar_total_sales_query);
    
    
    $sumar_beneficio_sales_raw = "select sum(total_beneficio) as value, count(*) as total_beneficio from orders where orders_status='" . $cobrado . "' or orders_status='" . $pagado . "'";
    $sumar_beneficio_sales_query = tep_db_query($sumar_beneficio_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_beneficio_sales_query);

    
    $sumar_beneficio_sales_raw = "select sum(total_beneficio) as value, count(*) as total_beneficio from contabilidad_general where total_costo <> '" . 0 . "'";
    $sumar_beneficio_sales_query = tep_db_query($sumar_beneficio_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_beneficio_sales_query);

    $sumar_gastos_sales_raw = "select sum(importe) as value, count(*) as importe from contabilidad_general where status = '" . 2 . "'";
    $sumar_gastos_sales_query = tep_db_query($sumar_gastos_sales_raw);
    $sumar_gastos= tep_db_fetch_array($sumar_gastos_sales_query);

    $sumar_retiros_sales_raw = "select sum(importe) as value, count(*) as importe from contabilidad_general where status = '" . 4 . "'";
    $sumar_retiros_sales_query = tep_db_query($sumar_retiros_sales_raw);
    $sumar_retiros= tep_db_fetch_array($sumar_retiros_sales_query);

    $sumar_inversion_sales_raw = "select sum(importe) as value, count(*) as importe from contabilidad_general where status = '" . 3 . "'";
    $sumar_inversion_sales_query = tep_db_query($sumar_inversion_sales_raw);
    $sumar_inversion= tep_db_fetch_array($sumar_inversion_sales_query);


           
           
           
                                                //calcula unidades x precio al por mayor de todos los productos.
                     $stock_values = tep_db_query("select ps.products_id, pg.products_id, ps.products_stock_real, pg.customers_group_price from " . 'products_stock' . " ps, " . 'products_groups' . " pg where ps.products_id = pg.products_id and ps.products_stock_real >= '" . 0 . "'");
                      while ($stock = tep_db_fetch_array($stock_values)){


                   $sql_status_update_array = array('group_price_total' => $stock['products_stock_real']*$stock['customers_group_price'],);
            tep_db_perform('products_groups', $sql_status_update_array, 'update', " products_id= '" . $stock['products_id'] . "' and customers_group_id = 2");

                  }
                  

                  
                  

  if ($filtrar_monto){
           
           
           
           
           
           
                }





   
  //insertar registro
  if ($_GET['monto']){


$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

                              if ($_POST['status'] == 2){
                             $_POST['importe'] = -$_POST['importe'];
                          }else if ($_POST['status'] == 4){
                            $_POST['importe'] = -$_POST['importe'];
                                                     }

                  $sql_data_array = array('importe' => $_POST['importe'],
                                  'observaciones' => $_POST['observaciones'],
                                  'status' => $_POST['status'],
                                  'fecha' => $oldday1,
                                  'concepto' => 2);
          tep_db_perform('contabilidad_general', $sql_data_array);

         	tep_redirect(tep_href_link('contabilidad_general.php', ''));


}   //fin

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  

  
                                                                                   // and cc.tienda = '" . $code_admin . "'
  $affiliate_sales_raw = "select * from " . 'contabilidad_general' . " cc where id <> '" . 0 . "' ORDER BY id DESC";


    $affiliate_sales_split = new splitPageResults($HTTP_GET_VARS['page'], 20, $affiliate_sales_raw, $affiliate_sales_numrows);

?>

<?php   require(DIR_WS_INCLUDES . 'template_top.php');?>





        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo 'SERVICIO TECNICO'; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">


            
            
          <?php


  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select * from " . 'contabilidad_general_conceptos' . " ORDER BY id");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['id'],
                               'text' => $orders_status['concepto']);
    $orders_status_array[$orders_status['concepto_id']] = $orders_status['concepto'];
  }


                ?>









  <style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: xx-small;
	font-weight: bold;
	color: #000099;
}
.Estilo2 {
	color: #0000FF;
	font-size: x-small;
	font-family: Verdana;
}
.Estilo3 {
	font-size: 10px;
	color: #0033FF;
}
.Estilo4 {color: #0000FF; font-size: 9px; }
.Estilo5 {
	color: #0033FF;
	font-family: Verdana;
	font-size: 10px;
}
.Estilo6 {
	font-family: Verdana;
	font-size: 10px;
}
-->
</style>

                    <?php

                                       echo  'Mercancia: ' . $sumar_total['value'];
                                         echo ' </p>Total Beneficios: '.$sumar_beneficio['value'];
                                          echo ' </p>Sumar Gastos: '.$sumar_gastos['value'];
                                          echo ' </p>Sumar Retiros: '.$sumar_retiros['value'];
                                           echo ' </p>Sumar Iversion: '.$sumar_inversion['value'];



                           ?>

  <table border="0" width="100%" id="table1" cellspacing="0">
	<tr>
		<td><form method="POST" action="<?php echo $PHP_SELF . '?monto=ok'; ?>">
	<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
	Buscar por datos del Cliente</font></b></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	<input name="observaciones" value="<?php echo $nombre ?>" size="20" style="font-weight: 700">
<input name="importe" value="<?php echo $monto ?>" size="5" style="font-weight: 350">
	<p><?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['concepto_nombre']);   ?></p>

 <input type="submit" value="Buscar" name="B1" style="font-family: Tahoma; font-size: 10pt; color: #000080"></font></p>
</form></td>
	</tr>



 <table border="0" width="100%" cellspacing="0">
	<tr>
		<td>
		<form method="POST" action="<?php echo $PHP_SELF . '?filtrar_status=ok'; ?>">
			<p><?php echo tep_draw_pull_down_menu('concepto', $orders_statuses, $order->info['concepto_nombre']);   ?><input type="submit" value="Filtrar por Estatus" name="B1"></p>
		</form>
		</td>
	</tr>






        <?php   if ($seleccionar_formulario){



                     $registros_values = tep_db_query("select * from " . 'contabilidad_st' . " where id = '" . $id_registro . "'");
                      $registros = tep_db_fetch_array($registros_values);

       ?>









<body class="Estilo1">
<table width="100%" border="0">
  <tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?editar_cont=ok&id_registro='.$id_registro.'&page='.$page.'&palabraclave='.$registros['traking']; ?>">
      <p class="Estilo2 Estilo3">Tienda: <?php echo $name_boxes; ?></p>
               <input type="checkbox" name="editar_cont" value="ok" checked>
        Presupuesto Total:
          <input type="text" name="total_presupuesto" value="<?php echo $registros['total_presupuesto']; ?>">
		Fianza:&nbsp;
          <input type="text" name="fianza" value="<?php echo $registros['fianza']; ?>">
  	<p class="Estilo4 Estilo5">
          Nombre:<input type="text" name="nombre" value="<?php echo $registros['nombre']; ?>">
			Teléfono:
    <input type="text" name="telefono" value="<?php echo $registros['telefono']; ?>">
      </p>
         <textarea rows="10" cols="50" name="observaciones"><?php echo $registros['observaciones']; ?></textarea>

         <p>&nbsp;</p>
        <p class="Estilo3 Estilo6">Concepto: <?php echo tep_draw_pull_down_menu('concepto',  $orders_statuses, $registros['concepto']);   ?>

            <p>Traking: <?php ECHO $registros['traking']; ?></p>

      </p>
      <p> <span class="Estilo5">
        <input type="submit" name="Submit" value="Actualizar">
      </span><span class="Estilo3"> </span> </p>
    </form></td>


<p>&nbsp;</p>




             <?php }else{


                         

                                                             ?>
             
                 <p><a href="<?php echo $PHP_SELF . '?crear_parte=ok'; ?>">Crear Nuevo Parte de Asistencia Tecnica</a></p>
             
                <?php if ($crear_parte){




                    ?>
                

<body class="Estilo1">
<table width="100%" border="0">
  <tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?insertar_cont=ok'; ?>">
      <p class="Estilo2 Estilo3">Tienda: <?php echo $name_boxes ?></p>
     <input type="checkbox" name="insertar_cont" value="ok" checked>
          Presupuesto: <input type="text" name="total_presupuesto"> Fianza:
          <input type="text" name="fianza"></p>
<p class="Estilo4 Estilo5">Nombre:<input type="text" name="nombre">
		Teléfono:
    <input type="text" name="telefono">
      </p>



<p>&nbsp;</p>




               <?php }

             }
                  ?>
                                                                                                                                                                
                  <?php if ($crear_parte){ }else{ ?>
                      <?php if ($seleccionar_formulario){ }else{ ?>
                  
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="4">
          <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" align="right"><?php echo 'ID '; ?></td>
             <td class="dataTableHeadingContent" align="right"><?php echo 'FECHA'; ?></td>
          <td class="dataTableHeadingContent" align="center"><?php echo 'BORRAR'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Observaciones'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Importes'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Orders id'; ?></td>
          <td class="dataTableHeadingContent"><?php echo 'Costo'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Bruto'; ?></td>
           <td class="dataTableHeadingContent"><?php echo 'Beneficios'; ?></td>
          <td class="dataTableHeadingContent"><?php echo 'Conceptos'; ?></td>

          </tr>
<?php
  if ($affiliate_sales_numrows > 0) {
    $affiliate_sales_values = tep_db_query($affiliate_sales_raw);
    $number_of_sales = '0';
    while ($affiliate_sales = tep_db_fetch_array($affiliate_sales_values)) {
      $number_of_sales++;
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {
        echo '          <tr class="dataTableRowSelected">';
      } else {
        echo '          <tr class="dataTableRow">';
      }
      
      
       $concep_values = tep_db_query("select * from " . 'contabilidad_st_conceptos' . " where concepto_id = '" . $affiliate_sales['concepto'] . "'");
       $concep_nom = tep_db_fetch_array($concep_values);



               //borra los registros de los pedidos que no se encuentren en cobrado o pagado.
  $query = tep_db_query("SELECT * FROM `orders` WHERE  orders_id='" . $affiliate_sales['orders_id'] . "' and orders_status = '" . $cobrado . "' or orders_id='" . $affiliate_sales['orders_id'] . "' and orders_status = '" . $pagado . "'");
if ($borrar = tep_db_fetch_array($query)){

}else{

              if ($affiliate_sales['status'] == 0){

			$Query = "DELETE FROM " . 'contabilidad_general' . "
			WHERE orders_id = '" . $affiliate_sales['orders_id'] . "';";
				tep_db_query($Query);
}      }



                if ($borrar){

 			$Query = "DELETE FROM " . 'contabilidad_general' . "
			WHERE id = '" .  $_GET['idborrar'] . "';";
				tep_db_query($Query);
                      }
?>

            <?php



                 ?>
            <td class="dataTableContent"><?php echo $affiliate_sales['id']; ?></td>
            <td class="dataTableContent"><?php echo $affiliate_sales['fecha']; ?></td>
            <td class="dataTableContent"> <a href="<?php echo $PHP_SELF . '?borrar=ok&idborrar='.$affiliate_sales['id']; ?>">Borrar</a></p></td>
            <td class="dataTableContent" align="left"><?php echo $affiliate_sales['observaciones']; ?></td>
            <td class="dataTableContent" align="left"><?php echo $affiliate_sales['importe']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['orders_id']; ?></td>
           <td class="dataTableContent" align="center"><?php echo $affiliate_sales['total_costo']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['total_bruto']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['total_beneficio']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['concepto']; ?></td>
 <?php
    }
  } else {
?>
          <tr class="dataTableRowSelected">
            <td colspan="7" class="smallText"><?php echo TEXT_NO_SALES; ?></td>
          </tr>
<?php
  }
  if ($affiliate_sales_numrows > 0 && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
          <tr>
            <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $affiliate_sales_split->display_count($affiliate_sales_numrows, 20, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo $affiliate_sales_split->display_links($affiliate_sales_numrows, 20, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
  }               }} //formulario insertar
?>
<?php
        if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}
             // plantilla para trabajar con fechas.
           $time = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
         $actuals = date("d-m-Y", $time);



 $query = tep_db_query("SELECT * FROM `orders` WHERE  orders_status='" . $cobrado . "' or  orders_status='" . $pagado . "'");
 
while ($insertar = tep_db_fetch_array($query)){

                 echo  $insertar['orders_id'];

     $sumar_beneficio_sales_raw = "select sum(final_beneficio) as value, count(*) as final_beneficio from orders_products where orders_id = '" . $insertar['orders_id'] . "'";
    $sumar_beneficio_sales_query = tep_db_query($sumar_beneficio_sales_raw);
    $sumar_beneficio= tep_db_fetch_array($sumar_beneficio_sales_query);
    
    $sumar_bruto_sales_raw = "select sum(final_price) as value, count(*) as final_price from orders_products where orders_id = '" . $insertar['orders_id'] . "'";
    $sumar_bruto_sales_query = tep_db_query($sumar_bruto_sales_raw);
    $sumar_bruto= tep_db_fetch_array($sumar_bruto_sales_query);
    
    $sumar_total_sales_raw = "select sum(final_price_total) as value, count(*) as final_price_total from orders_products where orders_id = '" . $insertar['orders_id'] . "'";
    $sumar_total_sales_query = tep_db_query($sumar_total_sales_raw);
    $sumar_total= tep_db_fetch_array($sumar_total_sales_query);








    $beneficio_values = tep_db_query("select * from " . 'orders_products' . " where orders_id = '" . $insertar['orders_id'] . "'");
while ($beneficio = tep_db_fetch_array($beneficio_values)){


    $pr_grupos_values = tep_db_query("select * from " . 'products_groups' . " where products_id = '" . $beneficio['products_id'] . "' and customers_group_id = '" . 2 . "'");
    $pr_grupos = tep_db_fetch_array($pr_grupos_values);

               $pvmtotal = $pr_grupos['customers_group_price'] * $beneficio['products_quantity'];
               $pvptotal =   $beneficio['final_price'] * $beneficio['products_quantity'];

             $sql_status_update_array = array('final_beneficio' =>  $pvptotal- $pvmtotal,
                                              'final_price_total' =>  $pvptotal,
                                                                 );
            tep_db_perform('orders_products', $sql_status_update_array, 'update', " orders_id = '" . $insertar['orders_id'] . "' and products_id = '" . $beneficio['products_id'] . "'");


}









             $sql_status_update_array = array('total_beneficio' =>  $sumar_beneficio['value']);
            tep_db_perform('orders', $sql_status_update_array, 'update', " orders_id = '" . $insertar['orders_id'] . "'");


     $donde_esta_c_values = tep_db_query("select * from " . 'orders' . " where orders_id='" . $insertar['orders_id'] . "' and orders_status='" . $cobrado . "' or orders_id='" . $insertar['orders_id'] . "' and orders_status='" . $pagado . "'");
   if  ($pagado= tep_db_fetch_array($donde_esta_c_values)){

     $donde_esta_c_values = tep_db_query("select * from " . 'contabilidad_general' . " where orders_id='" . $insertar['orders_id'] . "'");
   if  ($conta_general= tep_db_fetch_array($donde_esta_c_values)){

                       $sql_status_update_array = array('orders_id' => $insertar['orders_id'],
                                                       'total_beneficio' => $sumar_beneficio['value'],
                                                       'total_bruto' => $sumar_total['value'],
                                                       'total_costo' => $sumar_total['value']-$sumar_beneficio['value'],
                                                       'concepto' => 1);
             tep_db_perform('contabilidad_general', $sql_status_update_array, 'update', " orders_id = '" . $insertar['orders_id'] . "'");


}else{
       $sql_data_array = array(//Comment out line you don't need
							'orders_id' => $insertar['orders_id'],
							'concepto' => 1,
							'total_beneficio' => $sumar_beneficio['value'],
							'total_bruto' => $sumar_total['value'],
                            'total_costo' => $sumar_total['value']-$sumar_beneficio['value']);
     tep_db_perform('contabilidad_general', $sql_data_array);

}

}

}










 ?>

        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');?>
