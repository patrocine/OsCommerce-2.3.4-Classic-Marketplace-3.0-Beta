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

  if ($editar_cont){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

                   $sql_status_update_array = array('observaciones' => $observaciones,
                                                    'importe' => $importe,
                                                    'fianza' => $fianza,
                                                    'total_presupuesto' => $total_presupuesto,
                                                    'concepto' => $concepto,
                                                    'nombre' => $nombre,
                                                    'telefono' => $telefono,
                                                    'fecha_valor' => $fecha_valor,
                                                    'fecha_modificacion' => $oldday1,);
            tep_db_perform('contabilidad_st', $sql_status_update_array, 'update', " id= '" . $id_registro . "'");

           	tep_redirect(tep_href_link('contabilidad_st.php?filtrar_palabraclave=ok&palabraclave='.$palabraclave, ''));

  }// fin editar



   
  //insertar registro
  if ($insertar_cont){


$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


                  $sql_data_array = array('tienda' => $tienda,
                                  'observaciones' => $observaciones,
                                  'importe' => $importe,
                                  'fianza' => $fianza,
                                  'total_presupuesto' => $total_presupuesto,
                                  'nombre' => $nombre,
                                  'telefono' => $telefono,
                                  'tienda' => $code_admin,
                                  'traking' => 'ST' . rand(100000,1000000),
                                  'concepto' => $concepto,
                                  'fecha_insercion' => $oldday1,
                                  'fecha_modificacion' => $oldday1,);
          tep_db_perform('contabilidad_st', $sql_data_array);

         	tep_redirect(tep_href_link('contabilidad_st.php', ''));


}   //fin

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  
     echo $concepto;
  
  if ($filtrar_status){                                                                                     // and cc.tienda = '" . $code_admin . "'
  $affiliate_sales_raw = "select * from " . 'contabilidad_st' . " cc where cc.concepto = '" . $concepto . "' ORDER BY fecha_insercion DESC";

  
}else if ($filtrar_palabraclave){

                                                                                                                                                                                                                                              //   and tienda = '" . $code_admin . "'
 $affiliate_sales_raw = "select * from " . 'contabilidad_st' . "  where traking like '%" . $palabraclave . "%' or observaciones like '%" . $palabraclave . "%' or telefono like '%" . $palabraclave . "%' or nombre like '%" . $palabraclave . "%' ORDER BY fecha_insercion DESC";

}else{                                                                                                                                            // and cc.tienda = '" . $code_admin . "'
  $affiliate_sales_raw = "select * from " . 'contabilidad_st' . " cc, " . 'contabilidad_st_conceptos' . " ccc where cc.concepto = ccc.concepto_id  ORDER BY fecha_insercion DESC";
}

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
  $orders_status_query = tep_db_query("select * from " . 'contabilidad_st_conceptos' . " ORDER BY concepto_id");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['concepto_id'],
                               'text' => $orders_status['concepto_nombre']);
    $orders_status_array[$orders_status['concepto_id']] = $orders_status['concepto_nombre'];
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



  <table border="0" width="100%" id="table1" cellspacing="0">
	<tr>
		<td><form method="POST" action="<?php echo $PHP_SELF . '?filtrar_palabraclave=ok'; ?>">
	<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
	Buscar por datos del Cliente</font></b></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	<input name="palabraclave" value="<?php echo $palabraclave ?>" size="20" style="font-weight: 700"><input type="submit" value="Buscar" name="B1" style="font-family: Tahoma; font-size: 10pt; color: #000080"></font></p>
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
             
                <?php if ($crear_parte){ ?>
                

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



           <textarea rows="10" cols="50" name="observaciones"></textarea>

         <p>&nbsp;</p>
        <p class="Estilo3 Estilo6">Concepto: <?php echo tep_draw_pull_down_menu('concepto',  $orders_statuses, $order->info['concepto_nombre']);   ?>


          
          
          
      </p>
      <p> <span class="Estilo5">
        <input type="submit" name="Submit" value="Insertar">
      </span><span class="Estilo3"> </span> </p>
    </form></td>

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
              <td class="dataTableHeadingContent" align="right"><?php echo 'Traking '; ?></td>
          <td class="dataTableHeadingContent" align="center"><?php echo 'Nombre'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Editar'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Tiket'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Crear Factura'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'ID'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'ID'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Tienda'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Fianza'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Total Presupuesto'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Telefono'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Status'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Observaciones'; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo 'F. Inserción'; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo 'F. Modificación'; ?></td>
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






?>
            <td class="dataTableContent" align="center"><?php echo '<p><a target="_blank" href="/euroconsolas/spain/st.php?traking='.  $affiliate_sales['traking'] .'">'. $affiliate_sales['traking']; ?></a></p></td>

            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['nombre']; ?></td>

            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?seleccionar_formulario=ok&id_registro='. $affiliate_sales['id'] . '&concepto_xt=' . $affiliate_sales['concepto_id'].'&page='.$page.'">Editar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo '<p><a target="_blank" href="'. 'contabilidad_st_tiket.php' .'?seleccionar=ok&id_registro='. $affiliate_sales['id'] . '&concepto_xt=' . $affiliate_sales['concepto'].'">Tiket Serv.Tec.</a></p>'; ?></td>



            <?php


     $existe_pedido_values = tep_db_query("select * from " . TABLE_ORDERS . " where delivery_name like '%" . $affiliate_sales['traking'] . "%'");
     if  ($existe_pedido = tep_db_fetch_array($existe_pedido_values)){
      ?>
      
      
      
      
        <td class="dataTableContent"><?php echo '<a href="' . 'edit_orders_tienda.php' . '?page=1&oID=' . $existe_pedido['orders_id'] . '"><p><font color="#FF0000">Ir al Pedido</font></p></a>'; ?></td>
         <td class="dataTableContent"><?php echo '<a target="_blank" href="' . 'invoice_factura_ind_tiket.php?oID=' . $existe_pedido['orders_id'] . '"><p><font color="#FF0000">Tiket Compra</font></p></a>'; ?></td>

      
      <?php
      
      
      if ($affiliate_sales['concepto'] == 1){
      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);




                   $sql_status_update_array = array('concepto' => 2,
                                                    'fecha_modificacion' => $oldday1,);
            tep_db_perform('contabilidad_st', $sql_status_update_array, 'update', " id= '" . $affiliate_sales['id'] . "'");



                 }
      
      if ($affiliate_sales['concepto'] == 8){
      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);




                   $sql_status_update_array = array('concepto' => 2,
                                                    'fecha_modificacion' => $oldday1,);
            tep_db_perform('contabilidad_st', $sql_status_update_array, 'update', " id= '" . $affiliate_sales['id'] . "'");



                 }


      
}else{

       ?>
       
       
       
            <td class="dataTableContent"><?php echo '<a href="' . FILENAME_CREATE_ORDER_TIENDA . '?Customer_nr=' . $tienda_cuenta_cliente . '&st_nombre=' . $affiliate_sales['nombre'] . '&st_traking=' . $affiliate_sales['traking'] . '&st_telefono=' . $affiliate_sales['telefono'] . '">Crear Pedido</a>'; ?></td>
            <td class="dataTableContent"></td>

           <?php

            }
                 ?>
            <td class="dataTableContent"><?php echo $affiliate_sales['id']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['tienda']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['fianza']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['total_presupuesto']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['telefono']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $concep_nom['concepto_nombre']; ?></td>
            <td class="dataTableContent" align="left"><?php echo $affiliate_sales['observaciones']; ?></td>
            <td class="dataTableContent" align="right"><?php echo tep_date_short($affiliate_sales['fecha_insercion']); ?></td>
            <td class="dataTableContent" align="right"><?php echo tep_date_short($affiliate_sales['fecha_modificacion']); ?></td>
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
