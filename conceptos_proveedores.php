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

  $editar_cont = $HTTP_GET_VARS['editar_cont'];
        $seleccionar_formulario = $HTTP_GET_VARS['seleccionar_formulario'];
   $id_concepto = $HTTP_GET_VARS['id_concepto'];
    $proveedor_name = $HTTP_POST_VARS['proveedor_name'];
  $insertar_cont = $HTTP_GET_VARS['insertar_cont'];



       
  if ($editar_cont){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

                   $sql_status_update_array = array('proveedor_name' => $proveedor_name );
            tep_db_perform('proveedor', $sql_status_update_array, 'update', " proveedor_id= '" . $id_concepto . "'");


   tep_redirect(tep_href_link('conceptos_proveedores.php', ''));

  }// fin editar



  //insertar registro
  if ($insertar_cont){


$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


                  $sql_data_array = array('proveedor_name' => $proveedor_name );
          tep_db_perform('proveedor', $sql_data_array);

  tep_redirect(tep_href_link('conceptos_proveedores.php', ''));


}   //fin





  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $affiliate_sales_raw = "select * from " . 'proveedor' . " ORDER BY proveedor_name DESC";


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



                     $registros_values = tep_db_query("select * from " . 'proveedor' . " where proveedor_id = '" . $id_concepto . "'");
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
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?editar_cont=ok&id_concepto='.$id_concepto; ?>">
      <table width="100%" border="0">
        <tr>
          <td width="227"><span class="Estilo3 Estilo1 Estilo2">Empresa</span></td>
          </tr>
        <tr>
          <td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="proveedor_name" value="<?php echo $registros['proveedor_name'] ?>">
          </span></td>
          </tr>
        <tr>
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
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?insertar_cont=ok&id_concepto='.$id_concepto; ?>">
      <table width="100%" border="0">
        <tr>
          <td width="227"><span class="Estilo3 Estilo1 Estilo2">Empresa</span></td>
         </tr>
        <tr>
          <td><span class="Estilo4 Estilo5 Estilo1 Estilo2">
            <input type="text" name="proveedor_name" value="<?php echo $registros['proveedor_name'] ?>">
          </span></td>
          </tr>
        <tr>
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
            <td class="dataTableHeadingContent"><?php echo 'ID'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Proveedor'; ?></td>
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
            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?seleccionar_formulario=ok&id_concepto='. $affiliate_sales['proveedor_id'] . '">Editar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo $affiliate_sales['proveedor_id']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $affiliate_sales['proveedor_name']; ?></td>
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
