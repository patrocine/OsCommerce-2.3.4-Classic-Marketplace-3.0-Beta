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
 $MAX_DISPLAY_SEARCH_RESULTS  = 100;
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
echo $codigo_proveedor  = $_POST['codigo_proveedor'];
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
	<option selected>1000</option>
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
      // $status_procesando_paypal_array = array(array('id' => '0', 'text' => TEXT_NONE));
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


  //$affiliate_sales_raw = "select op.products_name, op.orders_id from " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p, " . 'admin' . " a left join " . TABLE_ORDERS_PRODUCTS . " op on op.orders_id = o.orders_id where op.products_id = p.products_id and o.orders_status = '" . $entregas_stock . "'";           //and p.codigo_proveedor = '" . $codigo_proveedor . "'  p.codigo_proveedor = '" . $codigo_proveedor . "' and

		$affiliate_sales_raw = "select p.products_id,
                                                      p.proveedor_price_general,
                                                      pd.products_name,
                                                      p.codigo_barras,
                                                      p.products_image,
                                                      p.time_ultimaactualizacion,
                                                      p.time_entradasysalidas,
                                                      ps.products_stock_real,
                                                      ps.products_stock_min,
                                                      ps.products_stock_pendiente,
                                                      p.products_stock_obs,
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
                                                      p.products_model_2,
                                                      p.products_model_3,
                                                      p.products_status,
                                                      p.codigo_proveedor,
                                                      p.proveedor_price from " . TABLE_PRODUCTS . " p,  " . TABLE_PRODUCTS_DESCRIPTION . " pd,  " . 'products_stock' . " ps where p.products_id = ps.products_id and p.products_id = pd.products_id and ps.products_stock_real < ps.products_stock_min and ps.products_stock_min <> 0 and p.stock_nivel = 6 order by p.products_model";



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





         if ($pendiente_de_entrada_a){
    $sumar_pendiente_entrada_total_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6";
    $sumar_pendiente_entrada_total_sales_query = tep_db_query($sumar_pendiente_entrada_total_sales_raw);
    $sumar_pendiente_entrada_total= tep_db_fetch_array($sumar_pendiente_entrada_total_sales_query);
             }
    
?>
           <td class="dataTableContent"><a target="_blank" href="/images/<?php echo $affiliate_sales['products_image']; ?>">
           <img border="0" src="<?php echo DIR_WS_CATALOG . DIR_WS_IMAGES . $affiliate_sales['products_image']; ?>" width="70"></a></td>
           
              <td class="dataTableContent"><?php echo $affiliate_sales['products_model'] . ' / ' . $affiliate_sales['products_model_2']; ?></a></td>
<td class="dataTableContent" align="left"><?php echo $affiliate_sales['products_name']; ?></td>
<td class="dataTableContent" align="left"><a target="_blank" href="http://fratelligiugliano.it/art-cerca/<?php echo $affiliate_sales['products_model']; ?>">PEDIR</a></td>


              <td class="dataTableContent"><a target="_blank" href="/product_info.php?products_id=<?php echo $affiliate_sales['products_id']; ?>">
           <?php echo 'Tienda'; ?></a></td>
           
           
   <td class="dataTableContent"><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $affiliate_sales['products_id']) . '\')">'    ."          ".'Reponer'."</td>\n"; ?></td>

           

<?php

                  // stock exterior
                $product_compartir_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 1 . "'");
        WHILE ($product_compartir = tep_db_fetch_array($product_compartir_values)){



                $stock_exteriors = '<script language="javascript" src="' . $product_compartir['ruta_url'] . 'products_stock_admin.php?web=' . $product_compartir['ruta_url'] . '&stock_nivel=6&products_model_stock='. $affiliate_sales['products_model'] .'&almacen=' . $product_compartir['nombre_publico'] .'&status_pendiente=' . $product_compartir['status_pendiente'] . '&status_agotado=' . $product_compartir['status_agotado'] . '&status_stock=' . $product_compartir['status_stock'] . ' "> </script>';
  ?>
  <td width="1%"><font size="1" face="Verdana"><?php echo $stock_exteriors ?></font></td>

 <?php } ?>
              <td class="dataTableContent"><?php echo $affiliate_sales['products_stock_real'] . '| ' . $affiliate_sales['products_stock_pendiente'] . '| ' . $affiliate_sales['products_stock_min'] . '| ' . $affiliate_sales['products_stock_obs']; ?></td>
             <td class="dataTableContent"><?php echo $affiliate_sales['products_stock_real']; ?><?php echo $affiliate_sales['products_id']; ?></td>
             <td class="dataTableContent"><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link('consultar_stock_tiendas.php?products_id=' . $affiliate_sales['products_id']) . '\')">'    ."          ".'Stock'."</td>\n"; ?></td>


   <td class="dataTableContent"><a target="_blank" href="<?php echo 'categories.php?pID=' . $affiliate_sales['products_id'] . '&action=new_product'; ?>">
           <?php echo 'Editar'; ?></a></td>

          <td class="dataTableContent" align="left"><?php echo $affiliate_sales['donde_esta']; ?></td>
          <td class="dataTableContent" align="left"><?php echo $affiliate_sales['products_name']; ?></td>
          <td class="dataTableContent" align="left"><p>






          </td></a>



          
          
          
          
          <td class="dataTableContent" align="left"><?php
      if ($affiliate_sales['products_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=0&pID=' . $affiliate_sales['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=1&pID=' . $affiliate_sales['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>




</td>
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
