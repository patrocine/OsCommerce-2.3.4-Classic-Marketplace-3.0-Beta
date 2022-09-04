<?php
/*
  $Id: account_history.php,v 1.63 2003/06/09 23:03:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_HISTORY);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));

$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);

      $cancelar_pedido = $_GET['cancelar_pedido'];
      $pedido_id = $_GET['pedido_id'];
      $cancelar_pedido_transferencia_sino = $_GET['cancelar_pedido_transferencia_sino'];
      $cancelar_pedido_transferencia = $_GET['cancelar_pedido_transferencia'];
       $cancelar_pedido_transferencia_form = $_GET['cancelar_pedido_transferencia_form'];
      $cancelar_pedido_transferencia_ej = $_GET['cancelar_pedido_transferencia_ej'];


  $cuenta = $_POST['cuenta'];
  $titular = $_POST['titular'];
  $observaciones = $_POST['observaciones'];
  $fecha = $_POST['fecha'];



  if ($cancelar_pedido){

               $sql_status_update_array = array('orders_status' => 7,);

             tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', " orders_id= '" . $pedido_id . "' and customers_id = '" . $customer_id . "'");

       $sql_data_array = array('orders_id' => $pedido_id,
                            'orders_status_id' => 7, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
     
 tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, ''));

}
  
  if ($cancelar_pedido_transferencia_ej){

               $sql_status_update_array = array('orders_cuenta_dev' => $cuenta,
                                                'orders_titular_dev' => $titular,
                                                'orders_observaciones_dev' => $observaciones,
                                                'orders_fecha_dev' => $fecha,
                                                'orders_status' => 121,);

             tep_db_perform(TABLE_ORDERS, $sql_status_update_array, 'update', " orders_id= '" . $pedido_id . "' and customers_id = '" . $customer_id . "'");

  
  
       $sql_data_array = array('orders_id' => $pedido_id,
                            'orders_status_id' => 121, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
     
   tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, ''));
}
  
  
   require(DIR_WS_INCLUDES . 'template_top.php');
?>

                 <?php       $images_page_values = mysql_query("select * from " . TABLE_INFO_MODULES . " where id = '" . 16 . "'");
                      $images_page = mysql_fetch_array($images_page_values);
                      if($images_page['value'] == 1){ // IMAGENES SUPERIOR DERECHA SI O NO?>
                <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_history.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>

                      <?php } ?>

          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php
  $orders_total = tep_count_customer_orders();

  if ($orders_total > 0) {
    $history_query_raw = "select o.orders_id, o.orders_titular_dev, o.orders_fecha_dev, o.orders_observaciones_dev, o.orders_cuenta_dev, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name, s.orders_status_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' order by orders_id DESC";
    $history_split = new splitPageResults($history_query_raw, MAX_DISPLAY_ORDER_HISTORY);
    $history_query = tep_db_query($history_split->sql_query);

    while ($history = tep_db_fetch_array($history_query)) {
      $products_query = tep_db_query("select count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$history['orders_id'] . "'");
      $products = tep_db_fetch_array($products_query);

      if (tep_not_null($history['delivery_name'])) {
        $order_type = TEXT_ORDER_SHIPPED_TO;
        $order_name = $history['delivery_name'];
      } else {
        $order_type = TEXT_ORDER_BILLED_TO;
        $order_name = $history['billing_name'];
      }
      
      
  $certificado_values = mysql_query("select certificado,f_reclamacion,n_reclamacion from " . TABLE_ORDERS . " where orders_id = '" . (int)$history['orders_id'] . "'");
              $certificado = mysql_fetch_array($certificado_values);

      
?>
          <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main"><?php echo '<b>' . TEXT_ORDER_NUMBER . '</b> ' . $history['orders_id']; ?></td>
              <td class="main" align="right"><?php echo '<b>' . TEXT_ORDER_STATUS . '</b> ' . $history['orders_status_name']; ?></td>
            </tr>
          </table>
          <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
            <tr class="infoBoxContents">
              <td><table border="0" width="100%" cellspacing="2" cellpadding="4">
                <tr>
                  <td class="main" width="50%" valign="top"><?php echo '<b>' . TEXT_ORDER_DATE . '</b> ' . tep_date_long($history['date_purchased']) . '<br><b>' . $order_type . '</b> ' . tep_output_string_protected($order_name); ?></td>
                  <td class="main" width="30%" valign="top"><?php echo '<b>' . TEXT_ORDER_PRODUCTS . '</b> ' . $products['count'] . '<br><b>' . TEXT_ORDER_COST . '</b> ' . strip_tags($history['order_total']); ?></td>
                  <td class="main" width="20%"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'order_id=' . $history['orders_id'], 'SSL') . '">' . tep_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>'; ?></td>
                </tr>













<p style="margin-top: 0; margin-bottom: 0"><b>Seguimiento del Envío:&nbsp;&nbsp;<a  target="_blank" href="<?php echo 'correos.php' . '?certificado=' . $certificado['certificado']; ?>">
  <?php echo $certificado['certificado']; ?>
                </b>
</p>
<p style="margin-top: 0; margin-bottom: 0"><b><a target="_blank" href="<?php echo 'invoice_factura.php' . '?oID=' . $history['orders_id']; ?>">Imprimir Factura</a> | <a href="configurar_factura.php">
Configurar Impresión</a></b></p>

               </td>

                
                
                
                
                
                
                
 <?php

       // si el pedido esta en transferencia
        $hfs_query = tep_db_query("select * from " . TABLE_ORDERS . " o, " . 'administrators' . " a where a.transferencia = o.orders_status and o.orders_id = '" . $history['orders_id'] . "'");
    if ($hfs = tep_db_fetch_array($hfs_query)){



       ?>
   <p><b><font face="Verdana" color="#FF0000"><a href="<?php echo $PHP_SELF.'?cancelar_pedido_transferencia_sino=ok&pedido_id='.$history['orders_id']; ?>"><font color="#FF0000">Cancelar Pedido</font></a></font></b></p>




   <?php
       if  ($cancelar_pedido_transferencia_sino){
          ?>

<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" size="1" color="#FF0000">Has realizado ya la transferencia</font></b></p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" size="2" color="#FF0000">
<a href="<?php echo $PHP_SELF.'?cancelar_pedido_transferencia_form=ok'; ?>">
<font color="#FF0000">SI</font></a> /
<a href="<?php echo $PHP_SELF.'?cancelar_pedido=ok&pedido_id='.$history['orders_id']; ?>"><font color="#FF0000">NO</font></a></font></b></p>

            <?php
       }
       
       
if ($cancelar_pedido_transferencia_form){
       
       
          ?>
          
          
          
<p>Para devolverle el importe de su compra introduzca un número de cuenta y
titular.</p>
<form method="POST" action="<?php echo $PHP_SELF . '?cancelar_pedido_transferencia_ej=ok&pedido_id=' . $history['orders_id'] ?>">
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">Nº
	de Cuenta:&nbsp;&nbsp; <input type="text" name="cuenta" value="<?php echo $history['orders_cuenta_dev'] ?>" size="30"></font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	Titular:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="titular" value="<?php echo $history['orders_titular_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
	<p style="margin-top: 0; margin-bottom: 0">
	<font face="Verdana" size="1" color="#FF0000">Escriba lo que puso en
	observaciones en el momento de realizar la transferencia</font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
	Observaciones: <input type="text" name="observaciones" value="<?php echo $history['orders_observaciones_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">
	<font face="Verdana" size="1" color="#FF0000">Fecha en la que realizo la
	transferencia</font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
	Fecha:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="fecha" value="<?php echo $history['orders_fecha_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	<input type="submit" value="Enviar" name="B1"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
</form>
          
          
          
          
          
       <?php
        }
     }
     
                       // si el pedido sale de transferencia a pendiente de entrada aparecera directamente el formulario de transferencias
         $hfs_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " osh, " . TABLE_ORDERS . " o, " . 'administrators' . " a where o.orders_id = osh.orders_id
                                                                                                                                       and osh.orders_status_id = a.transferencia
                                                                                                                                       and o.orders_id = '" . $history['orders_id'] . "'
                                                                                                                                       and o.orders_status = a.pendiente_entrada");
    if ($hfs = tep_db_fetch_array($hfs_query)){

     
     
     
        $hfsasw_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_status_id = 122  and orders_id = '" . $history['orders_id'] . "'
                                                                                                                                      ");
    if ($hfsasw = tep_db_fetch_array($hfsasw_query)){

         ?>
             <p><font face="Verdana" size="1"><b>Cuenta:</b> <?php echo $history['orders_cuenta_dev'] ?> <b>
             Titular:</b> <?php echo $history['orders_titular_dev'] ?>
         <b>Observaciones:</b> <?php echo $history['orders_observaciones_dev'] ?></font></p>
             <?php

      }else{

                ?>


   <p><b><font face="Verdana" color="#FF0000"><a href="<?php echo $PHP_SELF.'?cancelar_pedido_transferencia=ok&pedido_id='.$history['orders_id']; ?>"><font color="#FF0000">Cancelar Pedido</font></a></font></b></p>
        <?php

   if ($cancelar_pedido_transferencia){

            ?>


<p>Para devolverle el importe de su compra introduzca un número de cuenta y
titular.</p>
<form method="POST" action="<?php echo $PHP_SELF . '?cancelar_pedido_transferencia_ej=ok&pedido_id=' . $history['orders_id'] ?>">
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">Nº
	de Cuenta:&nbsp;&nbsp; <input type="text" name="cuenta" value="<?php echo $history['orders_cuenta_dev'] ?>" size="30"></font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	Titular:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="titular" value="<?php echo $history['orders_titular_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
	<p style="margin-top: 0; margin-bottom: 0">
	<font face="Verdana" size="1" color="#FF0000">Escriba lo que puso en
	observaciones en el momento de realizar la transferencia</font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
	Observaciones: <input type="text" name="observaciones" value="<?php echo $history['orders_observaciones_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">
	<font face="Verdana" size="1" color="#FF0000">Fecha en la que realizo la
	transferencia</font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
	Fecha:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="fecha" value="<?php echo $history['orders_fecha_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	<input type="submit" value="Enviar" name="B1"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
</form>

             <?php


              }


           }

                 }


         //cancelar directamente cuando esta pendiente de entrada, pendiente

$hfs_query = tep_db_query("select * from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS_HISTORY . " osh,  " . 'administrators' . " a where osh.orders_id = o.orders_id and a.status_pendiente = o.orders_status and o.orders_id = '" . $history['orders_id'] . "'
                                                                                                                                or osh.orders_id = o.orders_id and a.status_procesando = o.orders_status and o.orders_id = '" . $history['orders_id'] . "'
                                                                                                                                or osh.orders_id = o.orders_id and a.pendiente_entrada = o.orders_status and o.orders_id = '" . $history['orders_id'] . "'");
    if ($hfs = tep_db_fetch_array($hfs_query)){



         $hfsasw_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_status_id = 24  and orders_id = '" . $history['orders_id'] . "'");
    if ($hfsasw = tep_db_fetch_array($hfsasw_query)){


}else{
        ?>
        
        
     <p><b><font face="Verdana" color="#FF0000"><a href="<?php echo $PHP_SELF.'?cancelar_pedido=ok&pedido_id='.$history['orders_id']; ?>"><font color="#FF0000">Cancelar Pedido
   </font></a></font></b></p>

        
      <?php

      }






       ?>




   <?php





         ?>

             <?php
         }
         
         
         
         
         
         
            // si esta transferencia procesando
        $hfsas_query = tep_db_query("select * from " . TABLE_ORDERS . " o, " . 'administrators' . " a where a.transferencia_procesando = o.orders_status  and o.orders_id = '" . $history['orders_id'] . "'");
    if ($hfsas = tep_db_fetch_array($hfsas_query)){



        $hfsasw_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_status_id = 122  and orders_id = '" . $history['orders_id'] . "'
                                                                                                                                      ");
    if ($hfsasw = tep_db_fetch_array($hfsasw_query)){

         ?>
             <p><font face="Verdana" size="1"><b>Cuenta:</b> <?php echo $history['orders_cuenta_dev'] ?> <b>
             Titular:</b> <?php echo $history['orders_titular_dev'] ?>
         <b>Observaciones:</b> <?php echo $history['orders_observaciones_dev'] ?></font></p>
             <?php

      }else{

                ?>


   <p><b><font face="Verdana" color="#FF0000"><a href="<?php echo $PHP_SELF.'?cancelar_pedido_transferencia=ok&pedido_id='.$history['orders_id']; ?>"><font color="#FF0000">Cancelar Pedido</font></a></font></b></p>
        <?php

   if ($cancelar_pedido_transferencia){

            ?>


<p>Para devolverle el importe de su compra introduzca un número de cuenta y
titular.</p>
<form method="POST" action="<?php echo $PHP_SELF . '?cancelar_pedido_transferencia_ej=ok&pedido_id=' . $history['orders_id'] ?>">
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">Nº
	de Cuenta:&nbsp;&nbsp; <input type="text" name="cuenta" value="<?php echo $history['orders_cuenta_dev'] ?>" size="30"></font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	Titular:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="titular" value="<?php echo $history['orders_titular_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
	<p style="margin-top: 0; margin-bottom: 0">
	<font face="Verdana" size="1" color="#FF0000">Escriba lo que puso en
	observaciones en el momento de realizar la transferencia</font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
	Observaciones: <input type="text" name="observaciones" value="<?php echo $history['orders_observaciones_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">
	<font face="Verdana" size="1" color="#FF0000">Fecha en la que realizo la
	transferencia</font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
	Fecha:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="fecha" value="<?php echo $history['orders_fecha_dev'] ?>" size="40"></font></p>
	<p style="margin-top: 0; margin-bottom: 0"><font size="1" face="Verdana">
	<input type="submit" value="Enviar" name="B1"></font></p>
	<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
</form>

             <?php


              }


           }

                 }
         
         
         
         
          ?>


              </table></td>

    </td>

            </tr>
          </table>
          <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
          </table>
<?php
    }
  } else {
?>
          <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
            <tr class="infoBoxContents">
              <td><table border="0" width="100%" cellspacing="2" cellpadding="4">
                <tr>
                  <td class="main"><?php echo TEXT_NO_PURCHASES; ?></td>
                </tr>
              </table></td>
            </tr>
          </table>
<?php
  }
?>
        </td>
      </tr>
<?php
  if ($orders_total > 0) {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText" valign="top"><?php echo $history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
            <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $history_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
