<?php
/*
  $Id: REGLA DE PRECIOS.php,v 1.6 2003/02/19 15:00:52 simarilius Exp $

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/


  define('TEXT_NO_SALES', 'No hay Registros');

  require('includes/application_top.php');

   $act_precios = $_GET['act_precios'];
   $editar_cont = $_GET['editar_cont'];
   $insertar_cont = $_GET['insertar_cont'];
   $eliminar_cont = $_GET['eliminar_cont'];
   $seleccionar_formulario = $_GET['seleccionar_formulario'];

   
   
  $regladeprecios = $_POST['regladeprecios'];
  $menor = $_POST['menor'];
 $mayor = $_POST['mayor'];
 $porcent_value = $_POST['porcent_value'];
 $id_regladeprecios = $_GET['id_regladeprecios'];

          if ($act_precios){


             $products_values = mysql_query("select * from " . 'products' . " where products_status = '" . 1 . "'");
    while ($products= mysql_fetch_array($products_values)){


             $regladeprecios_values = mysql_query("select * from " . 'products_regladeprecios' . " where regladeprecios= '" . $products['products_regladeprecios'] . "' and menor <= '" . $products['products_price'] . "' ORDER BY menor DESC");
    if ($regladeprecios= mysql_fetch_array($regladeprecios_values)){


              $coste_values = mysql_query("select * from " . 'products_groups' . " where products_id = '" . $products['products_id'] . "' and customers_group_id = 2");
              $coste= mysql_fetch_array($coste_values);



                          // $29porcent = $coste['customers_group_price'] * $regladeprecios['porcent_value'] / 100 + $coste['customers_group_price'];



                     $porcentage  =  $products['products_price_sin'];

            $total_products_price  =  $porcentage * $regladeprecios['porcent_value'] / 100 + $porcentage;



                   $sql_status_update_array = array('products_price' => $total_products_price ,    );
            tep_db_perform('products', $sql_status_update_array, 'update', " products_id = '" . $products['products_id'] . "'");


         }
       } // fin de actualizar precios
       echo '<p><b><font size="6" color="#FF0000">TODOS LOS PRECIOS SE HAN SINCRONIZADOS CON EXITO</font></b></p>';
     }

  if ($editar_cont){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

                   $sql_status_update_array = array('regladeprecios' => $regladeprecios,
                                          'menor' => $menor,
                                          'porcent_value' => $porcent_value,     );
            tep_db_perform('products_regladeprecios', $sql_status_update_array, 'update', " id_regladeprecios= '" . $id_regladeprecios . "'");


   tep_redirect(tep_href_link('regladeprecios.php', ''));

  }// fin editar

  if ($eliminar_cont){

            
         tep_db_query("delete from " . 'products_regladeprecios' . " where id_regladeprecios= '" . $id_regladeprecios . "'");


   tep_redirect(tep_href_link('regladeprecios.php', ''));

  }// fin editar



  //insertar registro
  if ($insertar_cont){


$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


                  $sql_data_array = array('regladeprecios' => $regladeprecios,
                                          'menor' => $menor,
                                          'porcent_value' => $porcent_value,     );
          tep_db_perform('products_regladeprecios', $sql_data_array);

  tep_redirect(tep_href_link('regladeprecios.php', ''));


}   //fin





  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $regladeprecios_raw = "select * from " . 'products_regladeprecios' . " ORDER BY menor DESC";


    $regladeprecios_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $regladeprecios_raw, $regladeprecios_numrows);

?>
<?php   require(DIR_WS_INCLUDES . 'template_top.php');?>





        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>        <td class="pageHeading">Reglas de Precios</td>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">








<p>Porcentaje: Cambialo para que los precios que tienes entre rango de importes
se aplique y asegúrese que están correlativos</p>
<p style="margin-top: 0; margin-bottom: 0">Ejmpl 10€ + 10%</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
20€ +&nbsp;&nbsp; 9%</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
30€ +&nbsp;&nbsp; 8%</p>
<p style="margin-top: 0; margin-bottom: 0">Esto significa que si el producto
cuesta 15€ se aplicará 10%</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
si el producto cuesta 25€ se aplicará&nbsp;&nbsp; 9%</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
si el producto cuesta 30€ o + aplicará 8%</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">Cuando realices cambios pulsa en
&quot;Sincronizar precios&quot; para que los cambios hagan efecto.</p>
<p>&nbsp;&nbsp; </p>



            <p><a  <?php echo '<a href="'. $PHP_SELF . '?act_precios=ok' . '">'; ?>
<img border="0" src="http://pcclinicrealejos.com.es/admin/images/sincronizar_precios.jpg" width="200" height="25"></a></p>


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



                     $registros_values = tep_db_query("select * from " . 'products_regladeprecios' . " where id_regladeprecios = '" . $id_regladeprecios . "'");
                      $registros = tep_db_fetch_array($registros_values);


            ?>






 <p align="center"><a href="<?php $PHP_SELF . '?act_precios=ok' ?>"><font size="5">SINCRONIZAR PRECIOS</font></a></p>


<body class="Estilo1">
<table width="100%" border="0">
  <tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?editar_cont=ok&id_regladeprecios='.$id_regladeprecios; ?>">
      <p class="Estilo2 Estilo3">&nbsp;Nº de Regla&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Importe Producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		% a calcular</p>
      <p class="Estilo4 Estilo5">
        <input type="text" name="regladeprecios" value="<?php echo $registros['regladeprecios'] ?>">
        <input type="text" name="menor" value="<?php echo $registros['menor'] ?>">
         <input type="text" name="porcent_value" value="<?php echo $registros['porcent_value'] ?>">
    </p>
      <p> <span class="Estilo5">
        <input type="submit" name="Submit" value="Actualizar">
      </span><span class="Estilo3"> </span> </p>
    </form></td>

<p>&nbsp;</p>
  <tr>
    <td>&nbsp;</td>





             <?php }else{ ?>

<body class="Estilo1">
<table width="100%" border="0">
  <tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?insertar_cont=ok&id_regladeprecios='.$id_regladeprecios; ?>">
            <p class="Estilo2 Estilo3">&nbsp;Nº de Regla&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Importe Producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		% a calcular</p> <p class="Estilo4 Estilo5">
         <input type="text" name="regladeprecios" value="<?php echo $registros['regladeprecios'] ?>">
        <input type="text" name="menor" value="<?php echo $registros['menor'] ?>">
         <input type="text" name="porcent_value" value="<?php echo $registros['porcent_value'] ?>">
    </p>
      <p> <span class="Estilo5">
        <input type="submit" name="Submit" value="Insertar">
      </span><span class="Estilo3"> </span> </p>
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
            <td class="dataTableHeadingContent"><?php echo 'ID'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Importe'; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo 'Porcentage'; ?></td>
            </tr>
<?php
  if ($regladeprecios_numrows > 0) {
    $regladeprecios_values = tep_db_query($regladeprecios_raw);
    $number_of_sales = '0';
    while ($regladeprecios = tep_db_fetch_array($regladeprecios_values)) {
      $number_of_sales++;
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {
        echo '          <tr class="dataTableRowSelected">';
      } else {
        echo '          <tr class="dataTableRow">';
      }




?>
            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?seleccionar_formulario=ok&id_regladeprecios='. $regladeprecios['id_regladeprecios'] . '">Editar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?eliminar_cont=ok&id_regladeprecios='. $regladeprecios['id_regladeprecios'] . '">Eliminar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['regladeprecios']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['menor']; ?></td>
            <td class="dataTableContent" align="center"><?php echo $regladeprecios['porcent_value']; ?></td>
<?php
    }
  } else {
?>
          <tr class="dataTableRowSelected">
            <td colspan="7" class="smallText"><?php echo TEXT_NO_SALES; ?></td>
          </tr>
<?php
  }
  if ($regladeprecios_numrows > 0 && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
          <tr>
            <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $regladeprecios_split->display_count($regladeprecios_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo $regladeprecios_split->display_links($regladeprecios_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
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
