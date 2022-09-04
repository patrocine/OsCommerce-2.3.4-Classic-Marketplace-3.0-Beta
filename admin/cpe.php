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

   $editar_cont = $_GET['editar_cont'];
   $insertar_cont = $_GET['insertar_cont'];
   $eliminar_cont = $_GET['eliminar_cont'];
   $seleccionar_formulario = $_GET['seleccionar_formulario'];

   
   
  $regladeprecios = $_POST['regladeprecios'];
  $menor = $_POST['menor'];
 $mayor = $_POST['mayor'];
 $porcent_value = $_POST['porcent_value'];
 $id_regladeprecios = $_GET['id_regladeprecios'];



  $cp_id = $_GET['cp_id'];
  $cp_nombre_ce = $_POST['cp_nombre_ce'];
  $cp_ce = $_POST['cp_ce'];
  $cp_cf = $_POST['cp_cf'];
  $cp_ce_model = $_POST['cp_ce_model'];
  $cp_ce_nombre = $_POST['cp_ce_nombre'];
   $cp_ce_nombre_2 = $_POST['cp_ce_nombre_2'];
    $cp_ce_nombre_3 = $_POST['cp_ce_nombre_3'];
  $cp_ce_menosnombre_1 = $_POST['cp_ce_menosnombre_1'];
   $cp_ce_menosnombre_2 = $_POST['cp_ce_menosnombre_2'];
    $cp_ce_menosnombre_3 = $_POST['cp_ce_menosnombre_3'];
    
    

    
 if ($_POST['buscar_cp_ci']){
       $buscar_cp_ci = $_POST['buscar_cp_ci'];;
}else if ($_GET['buscar_cp_ci']){

       $buscar_cp_ci = $_GET['buscar_cp_ci'];;
}

    
    
    

  $cp_ci = $_POST['cp_ci'];
  $cp_quita_id = $_POST['cp_quita_id'];
  $cp_quita_nombre_1 = $_POST['cp_quita_nombre_1'];
  $cp_quita_nombre_2 = $_POST['cp_quita_nombre_2'];
  $cp_quita_nombre_3 = $_POST['cp_quita_nombre_3'];


          $MAX_DISPLAY_SEARCH_RESULTS = 500;



  if ($editar_cont){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

                   $sql_status_update_array = array('cp_nombre_ce' => $cp_nombre_ce,
                                          'cp_ce' => $cp_ce,
                                          'cp_cf' => $cp_cf,
                                          'cp_ce_model' => $cp_ce_model,
                                          'cp_ce_nombre' => $cp_ce_nombre,
                                          'cp_ce_nombre_2' => $cp_ce_nombre_2,
                                          'cp_ce_nombre_3' => $cp_ce_nombre_3,
                                          'cp_ce_menosnombre_1' => $cp_ce_menosnombre_1,
                                          'cp_ce_menosnombre_2' => $cp_ce_menosnombre_2,
                                          'cp_ce_menosnombre_3' => $cp_ce_menosnombre_3,
                                          'cp_quita_id' => $cp_quita_id,
                                          'cp_quita_nombre_1' => $cp_quita_nombre_1,
                                          'cp_quita_nombre_2' => $cp_quita_nombre_2,
                                          'cp_quita_nombre_3' => $cp_quita_nombre_3,
                                          'cp_ci' => $cp_ci,     );
            tep_db_perform('categories_pareja', $sql_status_update_array, 'update', " cp_id= '" . $cp_id . "'");


   tep_redirect(tep_href_link('cpe.php', ''));

  }// fin editar

  if ($eliminar_cont){

            
         tep_db_query("delete from " . 'categories_pareja' . " where cp_id= '" . $cp_id . "'");


   tep_redirect(tep_href_link('cpe.php?buscar_cp_ci=' . $buscar_cp_ci, ''));

  }// fin editar



  //insertar registro
  if ($insertar_cont){


$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


                  $sql_data_array = array('cp_ci' => $cp_ci,   );
                                          
if ($cp_nombre_ce) $sql_data_array['cp_nombre_ce'] = $cp_nombre_ce;
if ($cp_ce) $sql_data_array['cp_ce'] = $cp_ce;
if ($cp_cf) $sql_data_array['cp_cf'] = $cp_cf;
if ($cp_ce_model) $sql_data_array['cp_ce_model'] = $cp_ce_model;
if ($cp_ce_nombre) $sql_data_array['cp_ce_nombre'] = $cp_ce_nombre;
if ($cp_ce_nombre_2) $sql_data_array['cp_ce_nombre_2'] = $cp_ce_nombre_2;
if ($cp_ce_nombre_3) $sql_data_array['cp_ce_nombre_3'] = $cp_ce_nombre_3;
if ($cp_ce_menosnombre_1) $sql_data_array['cp_ce_menosnombre_1'] = $cp_ce_menosnombre_1;
if ($cp_ce_menosnombre_2) $sql_data_array['cp_ce_menosnombre_2'] = $cp_ce_menosnombre_2;
if ($cp_ce_menosnombre_3) $sql_data_array['cp_ce_menosnombre_3'] = $cp_ce_menosnombre_3;
if ($cp_quita_id) $sql_data_array['cp_quita_id'] = $cp_quita_id;
if ($cp_quita_nombre_1) $sql_data_array['cp_quita_nombre_1'] = $cp_quita_nombre_1;
if ($cp_quita_nombre_2) $sql_data_array['cp_quita_nombre_1'] = $cp_quita_nombre_2;
if ($cp_quita_nombre_3) $sql_data_array['cp_quita_nombre_1'] = $cp_quita_nombre_3;

                                          
                                          
          tep_db_perform('categories_pareja', $sql_data_array);

  tep_redirect(tep_href_link('cpe.php', ''));


}   //fin





  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  
  if ($buscar_cp_ci){


 $regladeprecios_raw = "select * from " . 'categories_pareja' . " where cp_ci = $buscar_cp_ci ORDER BY cp_id DESC";

}else{
  $regladeprecios_raw = "select * from " . 'categories_pareja' . " ORDER BY cp_id DESC";

}



    $regladeprecios_split = new splitPageResults($HTTP_GET_VARS['page'], $MAX_DISPLAY_SEARCH_RESULTS, $regladeprecios_raw, $regladeprecios_numrows);

?>
<?php   require(DIR_WS_INCLUDES . 'template_top.php');?>





        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">


            <td class="pageHeading">Reglas de Precios</td>










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

<form method="POST" action="">
	<p><input type="text" name="buscar_cp_ci" size="20"></p>
	<p><input type="text" name="buscar_cp_ce" size="20"></p>
	<p><input type="submit" value="Enviar" name="B1"></p>
</form>

        <?php

             echo 'f'. $buscar_cp_ci;


             if ($seleccionar_formulario){



                     $registros_values = tep_db_query("select * from " . 'categories_pareja' . " where cp_id = '" . $cp_id . "'");
                      $registros = tep_db_fetch_array($registros_values);


            ?>








<body class="Estilo1">
<table width="100%" border="0">
  <tr>
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?editar_cont=ok&cp_id='.$cp_id; ?>">
      <p class="Estilo2 Estilo3">
      
<table border="0" width="100%" id="table1">
	<tr>
		<td>EDITAR</td>
		<td>ELIMINAR </td>
		<td>ID</td>
		<td>QUITA (1 si) (0 no)</td>
		<td>QUITA NOMBRE 1</td>
		<td>QUITA NOMBRE 2</td>
		<td>QUITA NOMBRE 3</td>
		<td>NOMBRE</td>
		<td>ID-CAT-EXT</td>
		<td>ID-FABRI-EXT</td>
  		<td>B.REFERENCIA</td>
		<td>B.NOMBRE</td>
		<td>B.NOMBRE2</td>
		<td>B.NOMBRE3</td>
		<td>MENOS B.NOMBRE1</td>
		<td>MENOS B.NOMBRE2</td>
		<td>MENOS B.NOMBRE3</td>
		<td>CAT.DESTINO</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="text" name="cp_quita_id" size="1" value="<?php echo $registros['cp_quita_id'] ?>"></td>
		<td><input type="text" name="cp_quita_nombre_1" size="8" value="<?php echo $registros['cp_quita_nombre_1'] ?>"></td>
		<td><input type="text" name="cp_quita_nombre_2" size="8" value="<?php echo $registros['cp_quita_nombre_2'] ?>"></td>
		<td><input type="text" name="cp_quita_nombre_3" size="8" value="<?php echo $registros['cp_quita_nombre_3'] ?>"></td>
		<td><input type="text" name="cp_nombre_ce" size="8" value="<?php echo $registros['cp_nombre_ce'] ?>"></td>
		<td>  <input type="text" name="cp_ce" size="8" value="<?php echo $registros['cp_ce'] ?>"></td>
		<td>  <input type="text" name="cp_cf" size="8" value="<?php echo $registros['cp_cf'] ?>"></td>
		<td><input type="text" name="cp_ce_model" size="8" value="<?php echo $registros['cp_ce_model'] ?>"></td>
		<td>  <input type="text" name="cp_ce_nombre" size="8" value="<?php echo $registros['cp_ce_nombre'] ?>"></td>
		<td>  <input type="text" name="cp_ce_nombre_2" size="8" value="<?php echo $registros['cp_ce_nombre_2'] ?>"></td>
		<td>  <input type="text" name="cp_ce_nombre_3" size="8" value="<?php echo $registros['cp_ce_nombre_3'] ?>"></td>
		<td>  <input type="text" name="cp_ce_menosnombre_1" size="8" value="<?php echo $registros['cp_ce_menosnombre_1'] ?>"></td>
		<td>  <input type="text" name="cp_ce_menosnombre_2" size="8" value="<?php echo $registros['cp_ce_menosnombre_2'] ?>"></td>
		<td>  <input type="text" name="cp_ce_menosnombre_3" size="8" value="<?php echo $registros['cp_ce_menosnombre_3'] ?>"></td>
		<td> <input type="text" name="cp_ci" size="8" value="<?php echo $registros['cp_ci'] ?>"></td>
	</tr>


      
      






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
    <td><form name="form1" method="post" action="<?php echo $PHP_SELF . '?insertar_cont=ok&cp_id='.$cp_id; ?>">
            <p class="Estilo2 Estilo3"><p>
            
            
            
            
<table border="0" width="100%" id="table1">
	<tr>
		<td>EDITAR</td>
		<td>ELIMINAR </td>
		<td>ID</td>
		<td>QUITA (1 si) (0 no)</td>
		<td>QUITA NOMBRE 1</td>
		<td>QUITA NOMBRE 2</td>
		<td>QUITA NOMBRE 3</td>
		<td>NOMBRE</td>
		<td>ID-CAT-EXT</td>
		<td>ID-FABRI-EXT</td>
  		<td>B.REFERENCIA</td>
		<td>B.NOMBRE</td>
		<td>B.NOMBRE2</td>
		<td>B.NOMBRE3</td>
		<td>MENOS B.NOMBRE1</td>
		<td>MENOS B.NOMBRE2</td>
		<td>MENOS B.NOMBRE3</td>
		<td>CAT.DESTINO</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="text" name="cp_quita_id" size="1" value="<?php echo $registros['cp_quita_id'] ?>"></td>
		<td><input type="text" name="cp_quita_nombre_1" size="8" value="<?php echo $registros['cp_quita_nombre_1'] ?>"></td>
		<td><input type="text" name="cp_quita_nombre_2" size="8" value="<?php echo $registros['cp_quita_nombre_2'] ?>"></td>
		<td><input type="text" name="cp_quita_nombre_3" size="8" value="<?php echo $registros['cp_quita_nombre_3'] ?>"></td>
		<td><input type="text" name="cp_nombre_ce" size="8" value="<?php echo $registros['cp_nombre_ce'] ?>"></td>
		<td>  <input type="text" name="cp_ce" size="8" value="<?php echo $registros['cp_ce'] ?>"></td>
		<td>  <input type="text" name="cp_cf" size="8" value="<?php echo $registros['cp_cf'] ?>"></td>
		<td><input type="text" name="cp_ce_model" size="8" value="<?php echo $registros['cp_ce_model'] ?>"></td>
		<td>  <input type="text" name="cp_ce_nombre" size="8" value="<?php echo $registros['cp_ce_nombre'] ?>"></td>
		<td>  <input type="text" name="cp_ce_nombre_2" size="8" value="<?php echo $registros['cp_ce_nombre_2'] ?>"></td>
		<td>  <input type="text" name="cp_ce_nombre_3" size="8" value="<?php echo $registros['cp_ce_nombre_3'] ?>"></td>
		<td>  <input type="text" name="cp_ce_menosnombre_1" size="8" value="<?php echo $registros['cp_ce_menosnombre_1'] ?>"></td>
		<td>  <input type="text" name="cp_ce_menosnombre_2" size="8" value="<?php echo $registros['cp_ce_menosnombre_2'] ?>"></td>
		<td>  <input type="text" name="cp_ce_menosnombre_3" size="8" value="<?php echo $registros['cp_ce_menosnombre_3'] ?>"></td>
		<td> <input type="text" name="cp_ci" size="8" value="<?php echo $registros['cp_ci'] ?>"></td>
	</tr>


            
            
            
            
            
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
            <td class="dataTableHeadingContent" align="center"><?php echo 'Quita (1 si)(0 no)'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Quita nombre 1'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Quita nombre 2'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Quita nombre 3'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'Nombre Externo'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'ID CATEGORI EXT'; ?></td>
             <td class="dataTableHeadingContent" align="center"><?php echo 'ID FABRICANTE EXT'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'CATEGORI EXT MODEL'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'CATEGORI EXT NOMBRE'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'CATEGORI EXT NOMBRE 2'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'CATEGORI EXT NOMBRE 3'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'MENOS CAT EXT NOMBRE 1'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'MENOS CAT EXT NOMBRE 2'; ?></td>
            <td class="dataTableHeadingContent" align="center"><?php echo 'MENOS CAT EXT NOMBRE 3'; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo 'CATEGORI INT'; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo 'NOMBRE CATEGORIA'; ?></td>
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
            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?seleccionar_formulario=ok&cp_id='. $regladeprecios['cp_id'] . '">Editar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo '<p><a href="'. $PHP_SELF .'?eliminar_cont=ok&buscar_cp_ci='. $buscar_cp_ci . '&cp_id='. $regladeprecios['cp_id'] . '">Eliminar</a></p>'; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_id']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_quita_id']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_quita_nombre_1']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_quita_nombre_2']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_quita_nombre_3']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_nombre_ce']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_cf']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce_model']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce_nombre']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce_nombre_2']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce_nombre_3']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce_menosnombre_1']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce_menosnombre_2']; ?></td>
            <td class="dataTableContent"><?php echo $regladeprecios['cp_ce_menosnombre_3']; ?></td>



            
            <td class="dataTableContent" align="center"><?php echo $regladeprecios['cp_ci']; ?></td>
            
            

<?php

    $categories_name_values = tep_db_query("select * from " . 'categories_description' . " where categories_id = '" . $regladeprecios['cp_ci'] . "'");
                      $categories_name = tep_db_fetch_array($categories_name_values);



?>
            
            
            <td class="dataTableContent" align="center"><?php echo $categories_name['categories_name']; ?></td>
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
                <td class="smallText" valign="top"><?php echo $regladeprecios_split->display_count($regladeprecios_numrows, $MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo $regladeprecios_split->display_links($regladeprecios_numrows, $MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
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
<?php //require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php //require(DIR_WS_INCLUDES . 'application_bottom.php');?>
