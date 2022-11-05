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
     	// id_compartir	nombre_oculto	nombre_publico	ruta_url	activo
  require('includes/application_top.php');

  $editar_cont = $HTTP_GET_VARS['editar_cont'];
        $seleccionar_formulario = $HTTP_GET_VARS['seleccionar_formulario'];
   $id_concepto = $HTTP_GET_VARS['id_concepto'];
    $proveedor_name = $HTTP_POST_VARS['proveedor_name'];
  $insertar_cont = $HTTP_GET_VARS['insertar_cont'];

$eliminar_cont = $_GET['eliminar_cont'];
     $nombre_oculto = $_POST['nombre_oculto'];
 $activo = $_POST['activo'];
  $nombre_publico = $_POST['nombre_publico'];
 $ruta_url = $_POST['ruta_url'];
  $id_compartir = $_GET['id_compartir'];
 $proveedor_id = $_POST['proveedor_id'];

 $almacen = $HTTP_POST_VARS['almacen'];
   $almacenpro = $HTTP_POST_VARS['almacenpro'];


   $almacen = $_POST['almacen'];

   $almacenpro = $_POST['almacenpro'];

   $status_pendiente = $_POST['status_pendiente'];
   $status_agotado = $_POST['status_agotado'];
   $status_stock = $_POST['status_stock'];

   if ($eliminar_cont){


         tep_db_query("delete from " . 'products_compartir' . " where id_compartir= '" . $id_compartir . "'");


   tep_redirect(tep_href_link('conceptos_compartir_products.php', ''));

  }// fin editar

             
  if ($editar_cont){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

                   $sql_status_update_array = array('nombre_oculto' => $nombre_oculto,
                                                    'almacen' => $almacen,
                                                    'status_pendiente' => $status_pendiente,
                                                    'status_agotado' => $status_agotado,
                                                    'status_stock' => $status_stock,
                                                    'almacenpro' => $almacenpro,
                                                    'proveedor_id' => $proveedor_id,
                                                    'activo' => $activo,
                                                    'ruta_url' => $ruta_url,
                                                    'nombre_publico' => $nombre_publico,);
            tep_db_perform('products_compartir', $sql_status_update_array, 'update', " id_compartir= '" . $id_compartir . "'");


   tep_redirect(tep_href_link('conceptos_compartir_products.php', ''));

  }// fin editar



  //insertar registro
  if ($insertar_cont){


//$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
//$oldday1 = date("Y-m-d", $time1);


                  $sql_data_array = array('nombre_oculto' => $nombre_oculto,
                                                    'ruta_url' => $ruta_url,
                                                    'activo' => $activo,
                                                    'almacen' => $almacen,
                                                    'status_pendiente' => $status_pendiente,
                                                    'status_agotado' => $status_agotado,
                                                    'status_stock' => $status_stock,
                                                    'almacenpro' => $almacenpro,
                                                    'proveedor_id' => $proveedor_id,
                                                    'nombre_publico' => $nombre_publico,);
            tep_db_perform('products_compartir', $sql_data_array);

  tep_redirect(tep_href_link('conceptos_compartir_products.php', ''));


}   //fin





  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $affiliate_sales_raw = "select * from " . 'products_compartir' . " ORDER BY id_compartir DESC";


    $affiliate_sales_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $affiliate_sales_raw, $affiliate_sales_numrows);

?>
<?php     require(DIR_WS_INCLUDES . 'template_top.php');
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


        <?php   if ($seleccionar_formulario){



                     $registros_values = tep_db_query("select * from " . 'products_compartir' . " where id_compartir = '" . $id_compartir . "'");
                      $registros = tep_db_fetch_array($registros_values);


            ?>









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
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?editar_cont=ok&id_compartir='.$id_compartir; ?>">
      <table width="100%" border="0">
        <tr>
          <td width="227"><span class="Estilo3 Estilo1 Estilo2">Empresa</span></td>






        	<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
				<tr>
					<td>1 SI 0 NO</td>
		<td>Nombre Oculto </td>
		<td>Nombre Publico</td>
		<td>Ruta URL</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
             <input type="text" name="activo" size="2" value="<?php echo $registros['activo'] ?>"></span></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="nombre_oculto" value="<?php echo $registros['nombre_oculto'] ?>"></span></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="nombre_publico" value="<?php echo $registros['nombre_publico'] ?>"></span></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="ruta_url" value="<?php echo $registros['ruta_url'] ?>"></span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>No aparecer mi almacén</td>
		<td>Este es mi almacen</td>
		<td>ID Proveedor</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
  
  
                                                     <?php
                                                     if ($registros['almacen']){
                                                       $activo = 'checked';
                                                   }
                                                     if ($registros['almacenpro']){
                                                       $activopro = 'checked';
                                                   }
                                                        ?>
  
		<p align="center"><input type="checkbox" name="almacen" value="1" <?php echo $activo ?>></td>
		<td>
		<p align="center"><input type="checkbox" name="almacenpro" value="1" <?php echo $activopro ?>></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="proveedor_id" value="<?php echo $registros['proveedor_id'] ?>"></span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
 
 
 
 
 
				<tr>
					<td></td>
		<td>Stock </td>
		<td>Agotado</td>
		<td>Pendiente</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
        <td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
         <input type="text" name="status_stock" value="<?php echo $registros['status_stock'] ?>"></span></td>
		 <td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
             <input type="text" name="status_agotado" value="<?php echo $registros['status_agotado'] ?>"></span></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
             <input type="text" name="status_pendiente" value="<?php echo $registros['status_pendiente'] ?>"></span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
 
 
 
 
 
 
</table>




          <td><span class="Estilo2 Estilo3"><span class="Estilo5">
            <input type="submit" name="Submit" value="Actualizar">
          </span></span></td>

        </tr>
      </table>
      </form></td>

<p>&nbsp;</p>




             <?php }else{ ?>

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
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?insertar_cont=ok&id_compartir='.$id_compartir; ?>">
      <table width="100%" border="0">
        <tr>
          <td width="227"><span class="Estilo3 Estilo1 Estilo2"></span></td>








        	<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
				<tr>
					<td>1 SI 0 NO</td>
		<td>Nombre Oculto </td>
		<td>Nombre Publico</td>
		<td>Ruta URL</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
             <input type="text" name="activo" size="2" value="<?php echo $registros['activo'] ?>"></span></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="nombre_oculto" value="<?php echo $registros['nombre_oculto'] ?>"></span></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="nombre_publico" value="<?php echo $registros['nombre_publico'] ?>"></span></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="ruta_url" value="<?php echo $registros['ruta_url'] ?>"></span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>No aparecer mi almacén</td>
		<td>No aparecer almacén proveedor</td>
		<td>ID Proveedor</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<p align="center"><input type="checkbox" name="almacen" value="1"></td>
		<td>
		<p align="center"><input type="checkbox" name="almacenpro" value="1"></td>
		<td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="proveedor_id" value="<?php echo $registros['proveedor_id'] ?>"></span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>












          <td><span class="Estilo2 Estilo3"><span class="Estilo5">
            <input type="submit" name="Submit" value="Insertar">
          </span></span></td>

        </tr>
      </table>
      </form></td>

<p>&nbsp;</p>



               <?php } ?>


          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="4">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo 'Editar'; ?></td>
            <td class="dataTableHeadingContent"><?php echo 'Eliminar'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'ID'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'ID Proveedor'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'N. Oculto'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'N. Publico'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Ruta URL'; ?></td>
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




?>
            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?seleccionar_formulario=ok&id_compartir='. $affiliate_sales['id_compartir'] . '">Editar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?eliminar_cont=ok&id_compartir='. $affiliate_sales['id_compartir'] . '">Eliminar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo $affiliate_sales['activo']; ?></td>
            <td class="dataTableContent"><?php echo $affiliate_sales['proveedor_id']; ?></td>
            <td class="dataTableContent"><?php echo $affiliate_sales['nombre_oculto']; ?></td>
            <td class="dataTableContent"><?php echo $affiliate_sales['nombre_publico']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['ruta_url']; ?></td>
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
                <td class="smallText" valign="top"><?php echo $affiliate_sales_split->display_count($affiliate_sales_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo $affiliate_sales_split->display_links($affiliate_sales_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
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
