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


  if ($editar_cont){


      $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);

                   $sql_status_update_array = array('proveedor_name' => $proveedor_name,
                                                    'proveedor_grupo_id' => $proveedor_grupo_id,
                                                    'proveedor_impuesto' => $proveedor_impuesto,
                                                    'proveedor_descuento' => $proveedor_descuento,
                                                    'cuenta' => $cuenta, );
            tep_db_perform('proveedor', $sql_status_update_array, 'update', " proveedor_id= '" . $id_concepto . "'");


   tep_redirect(tep_href_link('conceptos_proveedores.php', ''));

  }// fin editar



  //insertar registro
  if ($insertar_cont){


$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


                  $sql_data_array = array('proveedor_name' => $proveedor_name,
                                          'proveedor_grupo_id' => $proveedor_grupo_id,
                                          'proveedor_impuesto' => $proveedor_impuesto,
                                          'proveedor_descuento' => $proveedor_descuento,
                                          'cuenta' => $cuenta, );
          tep_db_perform('proveedor', $sql_data_array);

  tep_redirect(tep_href_link('conceptos_proveedores.php', ''));


}   //fin





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




<p><b>Configuración de parámetros para la creación de un balance.</b></p>
<form method="POST" action="<?php echo 'invoice_pagado_total_tienda.php' ?>">
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;<input type="text" name="fecha_inicio" size="20" value="0000-mes-dia">
	Hasta <input type="text" name="fecha_final" size="20" value="0000-mes-dia"></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
	<p>&nbsp;</p>
 
 
<?php


                        //  or $login_groups_id == 8
   if ($login_groups_id == 1){


        //     echo 'dos';




  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 2 . "' or  language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 3 . "' ORDER BY orders_status_name");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }





}else{
  //   echo 'tres';
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' and tienda = '" . $code_admin . "' and permiso_tienda_editar = '" . 2 . "'ORDER BY orders_status_name");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }





}






  ?>
 
 
  </b> <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
  
  </b> <?php echo tep_draw_pull_down_menu('status2', $orders_statuses, $order->info['orders_status']); ?></td>


  
	<p><input type="submit" value="Enviar" name="B1"></p>






</form>










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
