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
  
    $MAX_DISPLAY_SEARCH_RESULTS  = $_POST['MAX_DISPLAY_SEARCH_RESULTS'];
    
  IF ($MAX_DISPLAY_SEARCH_RESULTS == 0){
 $MAX_DISPLAY_SEARCH_RESULTS  = 10;
}


$pendiente_de_entrada_a = $_GET['pendiente_de_entrada_a'];

 
 if ($_POST['palabraclave']){
       $palabraclave = $_POST['palabraclave'];
}else if ($_GET['palabraclave']){

       $palabraclave = $_GET['palabraclave'];
}
 
 $page = $_GET['page'];
 $buscar_dondeesta  = $_GET['buscar_dondeesta'];
$pendiente_er  = $_POST['pendiente_er'];
 $codigo_proveedor  = $_POST['codigo_proveedor'];
   $buscar  = $_GET['buscar'];


  IF ($codigo_proveedor == 0){
 $codigo_proveedor  = 1;
}

  

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();



?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">

  <script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=600,screenX=150,screenY=150,top=150,left=150')
}
//--></script>



<?php   require(DIR_WS_INCLUDES . 'template_top.php');?>


<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo Proveedores; ?></td>










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





<style type="text/css">
<!--
.Estilo1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo2 {font-size: 9px}
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; }
-->
</style>
<body class="Estilo1">
<table width="100%" border="0">
<tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?buscar=ok&page='.$page . '&MAX_DISPLAY_SEARCH_RESULTS='.$MAX_DISPLAY_SEARCH_RESULTS.'&codigo_proveedor='.$codigo_proveedor; ?>">
      <table width="100%" border="0">
        <tr>
          <td width="227"><span class="Estilo3 Estilo1 Estilo2">Busquedas</span></td>

        </tr>
        <tr>
          <td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="palabraclave" value="">
          </span></td>

        </tr>
        <tr>
          <td><span class="Estilo2 Estilo3"><span class="Estilo5">
            <input type="submit" name="Submit" value="Buscar">
          </span></span></td>

        </tr>
      </table>
      </form></td>
      
      
      
      
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?buscar_dondeesta=ok&page='.$page . '&MAX_DISPLAY_SEARCH_RESULTS='.$MAX_DISPLAY_SEARCH_RESULTS.'&codigo_proveedor='.$codigo_proveedor; ?>">
      <table width="100%" border="0">
        <tr>
          <td width="227"><span class="Estilo3 Estilo1 Estilo2">Donde Esta</span></td>

        </tr>
        <tr>
          <td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="palabraclave" value="">
          </span></td>

        </tr>
        <tr>
          <td><span class="Estilo2 Estilo3"><span class="Estilo5">
            <input type="submit" name="Submit" value="Buscar">
          </span></span></td>

        </tr>
      </table>
      </form></td>

      
      
      
 <p><a href="<?php echo $PHP_SELF . '?pendiente_de_entrada_a=ok'; ?>">Pendiente de Entrada</a></p>
      
<?php

   if ($pendiente_de_entrada_a){
$pendiente_er = '?pendiente_de_entrada_a=ok';
                            }


?>
      
<form method="POST" action="<?php ECHO $PHP_SELF . $pendiente_er; ?>">

	<p><font face="Toledo">Filas: <font face="Viner Hand ITC"> <select size="1" name="MAX_DISPLAY_SEARCH_RESULTS">
	<option selected>10</option>
	<option>20</option>
	<option>40</option>
	<option>60</option>
	<option>80</option>
	<option>100</option>
	<option>200</option>
	<option>300</option>
	<option>400</option>
	<option>500</option>
	</select></font> </font>



<?php
       $status_procesando_paypal_array = array(array('id' => '0', 'text' => TEXT_NONE));
        $status_procesando_paypal_query = tep_db_query("select * from " . 'proveedor' . " ORDER BY proveedor_name");
        while ($status_procesando_paypal = tep_db_fetch_array($status_procesando_paypal_query)) {
          $status_procesando_paypal_array[] = array('id' => $status_procesando_paypal['proveedor_id'],
                                  'text' => $status_procesando_paypal['proveedor_name']);
        }
        echo 'Proveedores: ' . tep_draw_pull_down_menu('codigo_proveedor', $status_procesando_paypal_array, $codigo_proveedor);

  ?>



	<input type="submit" value="Enviar" name="B1" style="font-family: Toledo; font-size: 8pt; font-weight: bold"></p>




</form>



          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="4">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo 'Imagen'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Model'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'ID'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Stock'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Donde Esta'; ?></td>
            <td class="dataTableHeadingContent" align="center"><a href="<?php echo $PHP_SELF . '?ordenar_a=ok&ordenar_concep=products_name&page='.$page . '&MAX_DISPLAY_SEARCH_RESULTS='.$MAX_DISPLAY_SEARCH_RESULTS.'&codigo_proveedor='.$codigo_proveedor; ?>"><font color="#FFFFFF">Nombre</font></a></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Titular'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Status Products'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Orders Status'; ?></td>
            <td class="dataTableHeadingContent" align="center"><a href="<?php echo $PHP_SELF . '?ordenar_a=ok&ordenar_concep=time_entradasysalidas&page='.$page . '&MAX_DISPLAY_SEARCH_RESULTS='.$MAX_DISPLAY_SEARCH_RESULTS.'&codigo_proveedor='.$codigo_proveedor; ?>"><font color="#FFFFFF">Stock</font></a></td>
            <td class="dataTableHeadingContent" align="center"><a href="<?php echo $PHP_SELF . '?ordenar_a=ok&ordenar_concep=time_pendiente_entrada_total&page='.$page . '&MAX_DISPLAY_SEARCH_RESULTS='.$MAX_DISPLAY_SEARCH_RESULTS.'&codigo_proveedor='.$codigo_proveedor; ?>"><font color="#FFFFFF">SD|PE|SMR</font></a></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Proveedor'; ?></td>
           <td class="dataTableHeadingContent" align="center"><?php echo 'Creado'; ?></td>
           <td class="dataTableHeadingContent" align="center"><?php echo 'Ultima Actualización'; ?></td>
          </tr>
<?php


  //$affiliate_sales_raw = "select op.products_name, op.orders_id from " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p, " . 'admin' . " a left join " . TABLE_ORDERS_PRODUCTS . " op on op.orders_id = o.orders_id where op.products_id = p.products_id and o.orders_status = '" . $entregas_stock . "'";

		$affiliate_sales_raw = "select p.products_id,
                                                      p.proveedor_price_general,
                                                      pd.products_name,
                                                      o.billing_name,
                                                      o.orders_id,
                                                      o.orders_status,
                                                      o.date_purchased,
                                                      o.orders_date_finished,
                                                      op.lista_prov,
                                                      p.codigo_barras,
                                                      p.products_image,
                                                      p.time_ultimaactualizacion,
                                                      p.time_entradasysalidas,
                                                      p.products_stock_min,
                                                      p.time_pendiente_entrada_total,
 	                                                  p.time_mercancia_entregado_procesando,
                                                      p.time_entregado,
                                                      p.time_paypal_enviado,
                                                      p.time_pagado_transferencia,
                                                      p.time_no_recogido,
                                                      p.time_cobrados,
                                                      p.time_credito,
                                                      p.time_pagado,
                                                      p.products_model,
                                                      p.products_status,
                                                      pde.donde_esta,
                                                      p.codigo_proveedor,
                                                      p.proveedor_price from " . TABLE_PRODUCTS . " p, orders_products op, orders o, administrators a,  " . TABLE_PRODUCTS_DESCRIPTION . " pd left join " . 'products_donde_esta' . " pde on pd.products_id = pde.products_id and pde.login_id = '" . $login_id . "' where op.products_id =p.products_id and op.lista_prov = 0 and p.products_id = pd.products_id and p.time_entradasysalidas <= p.products_stock_min and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6 and op.orders_id=o.orders_id and p.codigo_proveedor = '" . $codigo_proveedor . "' or
                                                                                                                                                                                                                                                                                                                   op.products_id =p.products_id and op.lista_prov = 0 and p.products_id = pd.products_id and p.time_entradasysalidas <= p.products_stock_min and o.orders_status = a.status_pendiente and a.admin_groups_id=6 and op.orders_id=o.orders_id and p.codigo_proveedor = '" . $codigo_proveedor . "' or
                                                                                                                                                                                                                                                                                                                   op.products_id =p.products_id and op.lista_prov = 0 and p.products_id = pd.products_id and p.time_entradasysalidas <= p.products_stock_min and o.orders_status = a.cobrado and op.products_quantity >= 1 and p.time_entradasysalidas <= 0 and  a.admin_groups_id=6 and op.orders_id=o.orders_id and p.codigo_proveedor = '" . $codigo_proveedor . "' or
                                                                                                                                                                                                                                                                                                                   op.products_id =p.products_id and op.lista_prov = 0 and p.products_id = pd.products_id and p.time_entradasysalidas <= p.products_stock_min and o.orders_status = a.status_procesando and a.admin_groups_id=6 and op.orders_id=o.orders_id and p.codigo_proveedor = '" . $codigo_proveedor . "' group by p.products_model ORDER BY '" . 'orders_id' . "' DESC ";



    $affiliate_sales_split = new splitPageResults($HTTP_GET_VARS['page'], $MAX_DISPLAY_SEARCH_RESULTS, $affiliate_sales_raw, $affiliate_sales_numrows);




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




           $orders_status_values = tep_db_query("select * from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . $affiliate_sales['orders_status'] . "'");
                      $orders_status = tep_db_fetch_array($orders_status_values);



           $admin_selc_values = tep_db_query("select * from " . 'administrators' . " where code_admin = '" . $orders_status['tienda'] . "' and  admin_groups_id <> '" . 1 . "'");
                      $admin_selc = tep_db_fetch_array($admin_selc_values);


                      $products_id = $affiliate_sales['products_id'];
                      
                     //este codigo borra un registro de la base de datos.
            // tep_db_query("delete from " . 'affiliate_sales_patrocinemonos' . " where time<= '" . time() . "'");
                                                                                                                                                                      $time =  time();//+ 172800;
              // si el producto no tiene tiempo este se actualiza por primera vez y si este es rabazado en 48horas también actualiza los productos con los datos de stock mas recientes.
         $proveedor_values = tep_db_query("select * from " . 'products' . " where products_id = '" . $affiliate_sales['products_id'] . "' and time_proveedores <= '" . $time . "'");
         if ($proveedor = tep_db_fetch_array($proveedor_values)){

 //require('includes/sumador_de_productos.php');

       $entradas_os = $sumar_entregado_total['value'];;
       $salidas_os =  $sumar_credito['value']+$sumar_cobrados_total['value']+ $sumar_pagado_total['value']+$sumar_pagado_transferencia['value']+$sumar_paypal_enviado['value']+$sumar_pendiente_entrada_total['value'];
       //$sumar_cobrados_total['value'] + $sumar_pagado_total['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value'] + $sumar_pendiente_entrada_total['value'];

       $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

           $sql_data_array = array('time_proveedores' => time()+rand(1,1000000),
                                   'time_entradasysalidas' => $entradas_os - $salidas_os,
                                   'time_ultimaactualizacion' => $oldday1,
                                   'time_pendiente_entrada_total' => $sumar_pendiente_entrada_total['value'],
                                   'time_entregado' => $sumar_entregado_total['value'],
                                   'time_paypal_enviado' => $sumar_paypal_enviado['value'],
                                   'time_pagado_transferencia' => $sumar_pagado_transferencia['value'],
                                   'time_no_recogido' => $sumar_no_recogido['value'],
                                   'time_cobrados' => $sumar_cobrados_total['value'],
                                   'time_credito' => $sumar_credito['value'],
                                   'time_pagado' => $sumar_pagado_total['value'],);

     tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $affiliate_sales['products_id'] . "'");




 }

         if ($pendiente_de_entrada_a){
    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);
             }
    
?>
           <td class="dataTableContent"><a target="_blank" href="/images/<?php echo $affiliate_sales['products_image']; ?>">
           <img border="0" src="<?php echo DIR_WS_CATALOG . DIR_WS_IMAGES . $affiliate_sales['products_image']; ?>" width="70"></a></td>
           
              <td class="dataTableContent"><a target="_blank" href="categories.php?search=<?php echo $affiliate_sales['products_model']; ?>">
           <?php echo $affiliate_sales['products_model']; ?></a></td>


              <td class="dataTableContent"><a target="_blank" href="/product_info.php?products_id=<?php echo $affiliate_sales['products_id']; ?>">
           <?php echo 'Tienda'; ?></a></td>


           
              <td class="dataTableContent"><?php echo $affiliate_sales['products_id']; ?></td>
             <td class="dataTableContent"><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $affiliate_sales['products_id']) . '\')">'    ."          ".'Stock'."</td>\n"; ?></td>
          <td class="dataTableContent" align="left"><?php echo $affiliate_sales['donde_esta']; ?></td>
          <td class="dataTableContent" align="left"><?php echo $affiliate_sales['products_name']; ?></td>
          <td class="dataTableContent" align="left"><p>


          <a target="_blank" href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'orders_tienda.php?page=1&oID='. $affiliate_sales['orders_id'] . '&action=edit&value_edit='.$admin_selc['admin_id'].'&vp=ok';    ?>"></p>
          <?php echo $affiliate_sales['billing_name']; ?>

          <a target="_blank" href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?page=1&oID='. $affiliate_sales['orders_id'] . '&value_edit='.$admin_selc['admin_id'].'&vp_2=ok';    ?>"></p>
          <?php echo ' - Actualizar';
          // header.php vp = ok
          ?>


          <a target="_blank" href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'invoice_factura_ind.php?oID='. $affiliate_sales['orders_id'];    ?>"></p>
          <?php echo ' - Factura';
          // header.php vp = ok
          ?>



          </td></a>



          
          
          
          
          <td class="dataTableContent" align="left"><?php
      if ($affiliate_sales['products_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=0&pID=' . $affiliate_sales['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=1&pID=' . $affiliate_sales['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>

          <td class="dataTableContent" align="center"><?php echo $orders_status['orders_status_name'] ;   ?>
                                                               <?php echo '<p><a target="_blank" href="'. 'edit_orders_tienda.php?action=edit&action_cod=ok&oID=11153&productoid='.$affiliate_sales['products_id'].'&unidades=1' . '">Añadir</a></p>'; ?>



          </td>
     <td class="dataTableContent" align="center"><?php




                                               echo $affiliate_sales['time_entradasysalidas'] . '| ' . $affiliate_sales['time_mercancia_entregado_procesando'] . '| ' . $affiliate_sales['products_stock_min'];
                                               
           //   $entradas_os = $sumar_entregado['value'] + $sumar_no_recogido['value'];
           //   $salidas_os =  $sumar_cobrados['value'] + $sumar_pagado['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value'] + $sumar_pendiente_entrada_total['value'];
                   //     echo $entradas_os - $salidas_os;
                ?></td>
            <td class="dataTableContent" align="center"><?php

              if ($pendiente_de_entrada_a){
                 echo $sumar_pendiente_entrada_total['value'];
              }else{
               echo $affiliate_sales['time_pendiente_entrada_total'];
                }

                $proveedor_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $affiliate_sales['codigo_proveedor'] . "'");
                $proveedor = tep_db_fetch_array($proveedor_values);



           ?></td>
            <td class="dataTableContent" align="center"><?php echo $proveedor['proveedor_name']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['date_purchased']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['time_ultimaactualizacion']; ?></td>
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
                <td class="smallText" valign="top"><?php echo $affiliate_sales_split->display_count($affiliate_sales_numrows, $MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo $affiliate_sales_split->display_links($affiliate_sales_numrows, $MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
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
