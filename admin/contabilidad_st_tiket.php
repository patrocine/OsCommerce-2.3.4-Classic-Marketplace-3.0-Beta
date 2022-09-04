

<?php
/*
  $Id: empresa_help1.php,v 1.4 2003/02/17 17:21:11 harley_vb Exp $

  OSC-empresa

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
   define('TEXT_CLOSE_WINDOW', 'Cerrar Ventana');
 require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ORDER_PROCESS_TIENDA);

 $id_registro = $_GET['id_registro'];
 $concepto_xt = $_GET['concepto_xt'];




   if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}
                    $registros_values = tep_db_query("select * from " . 'contabilidad_st' . " where id = '" . $id_registro . "'");
                      $registros = tep_db_fetch_array($registros_values);

            $concepto_values = tep_db_query("select * from " . 'contabilidad_st_conceptos' . " where concepto_id = '" . $concepto_xt . "'");
                      $concepto = tep_db_fetch_array($concepto_values);



?>




<title>SERVICIO TÉCNICO</title>

<p><u><b><font face="Verdana">SERVICIO TÉCNICO</font></b></u></p>
<p align="center">
<img border="0" src="images/logo_sts.jpg" width="75" height="73"></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">Traking: <?php echo $registros['traking']; ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">
Fecha de Entrega:&nbsp; <?php echo tep_date_short($registros['fecha_insercion']); ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">


<font face="Verdana" style="font-size: 7pt">ID
Tiket:&nbsp;<?php echo $registros['id']; ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">
Status: &nbsp;<?php echo $concepto['concepto_nombre']; ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">
Cobrado:&nbsp;<?php echo $registros['importe']; ?>€</font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">
Fianza:&nbsp; <?php echo $registros['fianza']; ?>€</font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">
Total Presupuesto:&nbsp;<?php echo $registros['total_presupuesto']; ?>€</font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">
Nombre:&nbsp; <?php echo $registros['nombre']; ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">Nº
Teléfono:&nbsp; <?php echo $registros['telefono']; ?></font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" style="font-size: 7pt">Tipo
de Servicio:&nbsp;</font></b><font face="Verdana" style="font-size: 7pt"> <?php echo $registros['observaciones']; ?></font></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0"><u><b><font face="Verdana" size="1">
FIRMA DEL CLIENTE</font></b></u></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<a href="http://www.EuroConsolas.com"><font color="#000000" face="Verdana">
www.truechip.es</font></a></b></p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 7pt">C/ San
Juan Bosco, Edf, Temait III, Local 27</font></p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 7pt">3º
Planta, Estación de Guaguas - La Orotava</font></p>
<p style="margin-top: 0; margin-bottom: 0">

<font face="Verdana" style="font-size: 7pt">Tienda:
605 705 891</font></p>

<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 6pt">Se
establecerá el plazo de entrega según disponibilidad de componentes en un plazo
máximo de 15 días.</font></p>
<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" style="font-size: 6pt">La
empresa no se hace responsable de cualquier pérdida de datos que contenga dicho
equipo.</font></p>







     </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>

</body>
</html>
<?php require('includes/application_bottom.php'); ?>
