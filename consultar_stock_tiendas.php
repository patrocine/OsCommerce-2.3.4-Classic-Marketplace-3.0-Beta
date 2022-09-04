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

   if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}



  echo  $products_id = $HTTP_GET_VARS['products_id'];
        $edit_entregados  = $HTTP_GET_VARS['edit_entregados'];


 // Listado Confirmacion de los productos pagados
   if ($edit_liquidacion){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cliente</font></td>
  </tr>

              <?php

        $status_procesando_a_values = mysql_query("select op.orders_id, o.delivery_name, o.date_purchased, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.status_liquidacion and a.admin_groups_id=6");
       while  ($status_procesando_a = mysql_fetch_array($status_procesando_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
      <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $status_procesando_a['orders_id'] . '">'.$status_procesando_a['orders_id'].'</a></p>' ?></font></td>
  <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['delivery_name']; ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final





 // Listado Confirmacion de los productos pagados
   if ($edit_pendiente_entrada_total){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $status_procesando_a_values = mysql_query("select op.orders_id, o.delivery_name, o.date_purchased, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6");
       while  ($status_procesando_a = mysql_fetch_array($status_procesando_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
     <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $status_procesando_a['orders_id'] . '">'.$status_procesando_a['orders_id'].'</a></p>' ?></font></td>
   <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['delivery_name']; ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final







// Listado Confirmacion de los productos pagados
   if ($edit_procesando_reembolso_internacional){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $procesando_reembolso_internacional_a_values = mysql_query("select op.orders_id, o.delivery_name, o.date_purchased, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando_reembolso_internacional . "'");
       while  ($procesando_reembolso_internacional_a = mysql_fetch_array($procesando_reembolso_internacional_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $procesando_reembolso_internacional_a['orders_id'] . '">'.$procesando_reembolso_internacional_a['orders_id'].'</a></p>' ?></font></td>
   <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $procesando_reembolso_internacional_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $procesando_reembolso_internacional_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $procesando_reembolso_internacional_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final



// Listado Confirmacion de los productos pagados
   if ($edit_status_entregas){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $status_entregas_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $status_entregas . "'");
       while  ($status_entregas_a = mysql_fetch_array($status_entregas_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $status_entregas_a['orders_id'] . '">'.$status_entregas_a['orders_id'].'</a></p>' ?></font></td>
   <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_entregas_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_entregas_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_entregas_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final





// Listado Confirmacion de los productos pagados
   if ($edit_status_salidas){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $status_salidas_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $status_salidas . "'");
       while  ($status_salidas_a = mysql_fetch_array($status_salidas_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $status_salidas_a['orders_id'] . '">'.$status_salidas_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_salidas_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_salidas_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_salidas_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final



// Listado Confirmacion de los productos pagados
   if ($edit_no_recogido){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $valor_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_no_recogido . "'");
       while  ($valor_a = mysql_fetch_array($valor_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $valor_a['orders_id'] . '">'.$valor_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $valor_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $valor_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $valor_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final


// Listado Confirmacion de los productos pagados
   if ($edit_cancelado){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $valor_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_cancelado . "'");
       while  ($valor_a = mysql_fetch_array($valor_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $valor_a['orders_id'] . '">'.$valor_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $valor_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $valor_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $valor_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final







// Listado Confirmacion de los productos pagados
   if ($edit_procesando_paypal){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $login_procesando_paypal_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando_paypal . "'");
       while  ($login_procesando_paypal_a = mysql_fetch_array($login_procesando_paypal_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $login_procesando_paypal_a['orders_id'] . '">'.$login_procesando_paypal_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_procesando_paypal_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_procesando_paypal_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_procesando_paypal_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final













// Listado Confirmacion de los productos pagados
   if ($edit_login_pendiente){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $login_pendiente_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_pendiente . "'");
       while  ($login_pendiente_a = mysql_fetch_array($login_pendiente_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $login_pendiente_a['orders_id'] . '">'.$login_pendiente_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_pendiente_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_pendiente_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_pendiente_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final


// Listado Confirmacion de los productos pagados
   if ($edit_login_transferencia){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $login_transferencia_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_transferencia . "'");
       while  ($login_transferencia_a = mysql_fetch_array($login_transferencia_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $login_transferencia_a['orders_id'] . '">'.$login_transferencia_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_transferencia_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_transferencia_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_transferencia_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final


// Listado Confirmacion de los productos pagados
   if ($edit_transferencia_procesando){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $login_transferencia_procesando_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_transferencia_procesando . "'");
       while  ($login_transferencia_procesando_a = mysql_fetch_array($login_transferencia_procesando_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $login_transferencia_procesando_a['orders_id'] . '">'.$login_transferencia_procesando_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_transferencia_procesando_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_transferencia_procesando_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $login_transferencia_procesando_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final




// Listado Confirmacion de los productos pagados
   if ($edit_status_procesando){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $status_procesando_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando . "'");
       while  ($status_procesando_a = mysql_fetch_array($status_procesando_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $status_procesando_a['orders_id'] . '">'.$status_procesando_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $status_procesando_a['delivery_name']; ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final


















// Listado Confirmacion de los productos pagados
   if ($edit_pagado_paypal){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $pagado_paypal_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado_paypal . "'");
       while  ($pagado_paypal_a = mysql_fetch_array($pagado_paypal_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $pagado_paypal_a['orders_id'] . '">'.$pagado_paypal_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_paypal_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_paypal_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_paypal_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final







// Listado Confirmacion de los productos pagados
   if ($edit_pagados){
                   ?>
                   
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>
                   
              <?php

        $pagados_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado . "'");
       while  ($pagados_a = mysql_fetch_array($pagados_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $pagados_a['orders_id'] . '">'.$pagados_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagados_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagados_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagados_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}
    //final
    
        // Listado Confirmacion de los productos entregados
   if ($edit_entregados){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $entregados_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "' and o.orders_status ='" . $entregas_stock . "' and o.orders_status ='" . $entregas_stock . "'");
       while  ($entregados_a = mysql_fetch_array($entregados_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $entregados_a['orders_id'] . '">'.$entregados_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $entregados_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $entregados_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $entregados_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}

           //final
           

           
        // Listado Pagado Internacional
   if ($edit_pagado_internacional){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $pagado_internacional_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "' and o.orders_status ='" . $pagado_internacional . "'");
       while  ($pagado_internacional_a = mysql_fetch_array($pagado_internacional_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $pagado_internacional_a['orders_id'] . '">'.$pagado_internacional_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_internacional_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_internacional_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_internacional_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}

           //final

           


        // Listado paypal enviado
   if ($edit_pagado_transferencia){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $pagado_transferencia_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "' and o.orders_status ='" . $pagado_transferencia . "'");
       while  ($pagado_transferencia_a = mysql_fetch_array($pagado_transferencia_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $pagado_transferencia_a['orders_id'] . '">'.$pagado_transferencia_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_transferencia_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_transferencia_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $pagado_transferencia_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}

           //final



        // Listado paypal enviado
   if ($edit_paypal_enviado){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $paypal_enviado_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "' and o.orders_status ='" . $login_paypal_enviado . "'");
       while  ($paypal_enviado_a = mysql_fetch_array($paypal_enviado_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $paypal_enviado_a['orders_id'] . '">'.$paypal_enviado_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $paypal_enviado_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $paypal_enviado_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $paypal_enviado_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}

           //final









                                                                                                                                                           
    
        // Listado Confirmacion de los productos Retirados
   if ($edit_retirados){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $retirarados_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $retirarado . "'");
       while  ($retirarados_a = mysql_fetch_array($retirarados_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $retirarados_a['orders_id'] . '">'.$retirarados_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $retirarados_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $retirarados_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $retirarados_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}

           //final









   
        // Listado Confirmacion de los productos Retirados
   if ($edit_cobrado){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Confirmado</font></td>
  </tr>

              <?php

        $cobrado_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $cobrado . "'");
       while  ($cobrado_a = mysql_fetch_array($cobrado_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $cobrado_a['orders_id'] . '">'.$cobrado_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $cobrado_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $cobrado_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $cobrado_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}

           //final

        // Listado Confirmacion de los productos Retirados
   if ($edit_presupuestos){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Nombre</font></td>
  </tr>

              <?php

        $presupuestos_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_presupuestos . "'");
       while  ($presupuestos_a = mysql_fetch_array($presupuestos_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $presupuestos_a['orders_id'] . '">'.$presupuestos_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $presupuestos_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $presupuestos_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $presupuestos_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}

           //final

        // Listado Confirmacion de los productos Retirados
   if ($edit_credito){
                   ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana">Pedido</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Fecha</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Cantidad</font></td>
    <td width="25%" align="center"><font size="2" face="Verdana">Nombre</font></td>
  </tr>

              <?php







        $presupuestos_a_values = mysql_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_credito . "'");
       while  ($presupuestos_a = mysql_fetch_array($presupuestos_a_values)){

         ?>

<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo '<p><a target="_parent" href="'. HTTP_SERVER . DIR_WS_ADMIN . 'edit_orders_tienda.php?action=edit&oID=' . $presupuestos_a['orders_id'] . '">'.$presupuestos_a['orders_id'].'</a></p>' ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $presupuestos_a['date_purchased'] ?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $presupuestos_a['products_quantity']?></font></td>
    <td width="25%" align="center"><font size="2" face="Verdana"><?php echo $presupuestos_a['delivery_name'] ?></font></td>
  </tr>  </table>
       <?php



   }



}


   if ($serie_aa){

    if ($action_salidas){

            //si es admin o tienda
     if ($login_id_remoto <> 0){
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id_remoto . "'");
     $admin_a = mysql_fetch_array($admin_a_values);

           }else{
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id . "'");
     $admin_a = mysql_fetch_array($admin_a_values);


     }             //fin



            //direcciones
     $address_books_values = mysql_query("select * from " . 'address_book' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $address_books = mysql_fetch_array($address_books_values);
     $customerss_values = mysql_query("select * from " . 'customers' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $customerss = mysql_fetch_array($customerss_values);
              //fin


       //si el la peticion de retirada no existe se crea una nueva en la tienda correspondiente.
    $salidas_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $status_salidas_c . "' ");
   if ($salidas_c = mysql_fetch_array($salidas_values)){








                   //
                  //selecciona los productos y los datos de estos
    $codigobarras_values = mysql_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . $products_id . "'");
   if ($codigobarras_c = mysql_fetch_array($codigobarras_values)){








  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where  orders_id = '" . $salidas_c['orders_id'] . "' and products_id = '" . $products_id . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){


 //Pone el precio de oferta antes que el precio normal
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}  //fin




                                                             //CHIVATOS
                                                echo 'CORRECTO ACTUALIZADO'.$unidades;
                                                            echo 'serie A';
                                                              //FIN
                             //
                              $serie_a = 'ok';
  require('includes/proveedores_precios.php');




                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

                      $sql_status_update_array = array('contencion' =>1,);

               if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;

            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $codigobarras_a['products_id'] . "'");







}else{
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'dd';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $salidas_c['orders_id'] . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");






     }



       }










}else{
$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


   $sql_data_array = array('customers_id' => $address_books['customers_id'],
                          'customers_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'customers_company' => '',
                          'customers_street_address' => $address_books['entry_street_address'],
                          'customers_suburb' => '',
                          'customers_city' => $address_books['entry_city'],
                          'customers_postcode' => $address_books['entry_postcode'],
                          'customers_state' => '',
                          'customers_country' => $address_books['entry_country_id'],
                          'customers_telephone' => $customerss['customers_telephone'],
                          'customers_email_address' => $customerss['customers_email_address'],
                          'customers_address_format_id' => 1,
                          'delivery_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'delivery_company' => '',
                          'delivery_street_address' => $address_books['entry_street_address'],
                          'delivery_suburb' => '',
                          'delivery_city' => $address_books['entry_city'],
                          'delivery_postcode' => $customerss['customers_telephone'],
                          'delivery_state' => '',
                          'delivery_country' => $address_books['entry_country_id'],
                          'delivery_address_format_id' => 1,
                          'billing_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'billing_company' => '',
                          'billing_street_address' => $customerss['customers_email_address'],
                          'billing_suburb' => '',
                          'billing_city' => $address_books['entry_city'],
                          'billing_postcode' => $address_books['entry_postcode'],
                          'billing_state' => '',
                          'billing_country' => $address_books['entry_country_id'],
                          'billing_address_format_id' => 1,
                          'payment_method' => $order->info['payment_method'],
                          'cc_type' => '',
                          'cc_owner' => '',
                          'cc_number' => '',
                          'cc_expires' => '',
                          'date_purchased' => $oldday1,
                          'orders_status' => $status_salidas_c,
                          'currency' => 'EUR',
                          'currency_value' => 1);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

   $insert_id = tep_db_insert_id();


      $sql_data_array = array('orders_id' => $insert_id,
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
							'orders_status_id' => $status_salidas_c, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_SUBTOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_subtotal",
                            'sort_order' => "1");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);


   $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DISCOUNT,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_customer_discount",
                            'sort_order' => "2");
   tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DELIVERY,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_shipping",
                            'sort_order' => "3");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TAX,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_tax",
                            'sort_order' => "4");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

      $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_total",
                            'sort_order' => "5");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);



 // Header("Location: ".$PHP_SELF."?action_salidas=ok&action_entradas=ok&admin_id_c=".$admin_id_c."&products_id=".$products_id."&status_salidas_c=".$status_salidas_c."&status_entradas_c=".$status_entradas_c."&unidades=".$unidades."");


        //insertar productos cuando se inserte por primera vez la orden
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


    $codigobarras_values = mysql_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . $products_id . "' and pd.products_id = '" . $products_id . "'");
  $codigobarras_c = mysql_fetch_array($codigobarras_values);



                             echo $codigobarras_a['orders_id'].'dd';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $insert_id . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");




            //fin





}        //fin





}  //action SALIDAS  peticiones de retiradas

















    if ($action_entradas){

            //si es admin o tienda
     if ($login_id_remoto <> 0){
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id_remoto . "'");
     $admin_a = mysql_fetch_array($admin_a_values);

           }else{
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id . "'");
     $admin_a = mysql_fetch_array($admin_a_values);


     }             //fin



            //direcciones
     $address_books_values = mysql_query("select * from " . 'address_book' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $address_books = mysql_fetch_array($address_books_values);
     $customerss_values = mysql_query("select * from " . 'customers' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $customerss = mysql_fetch_array($customerss_values);
              //fin


       //si el la peticion de entrada no existe se crea una nueva en la tienda correspondiente.
    $salidas_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $status_entradas_c . "'");
   if ($salidas_c = mysql_fetch_array($salidas_values)){








                   //
                  //selecciona los productos y los datos de estos
    $codigobarras_values = mysql_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . $products_id . "'");
   if ($codigobarras_c = mysql_fetch_array($codigobarras_values)){








  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where  orders_id = '" . $salidas_c['orders_id'] . "' and products_id = '" . $products_id . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){


 //Pone el precio de oferta antes que el precio normal
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}  //fin




                                                             //CHIVATOS
                                                echo 'CORRECTO ACTUALIZADOl'.$unidades;
                                                            echo 'serie A';
                                                              //FIN
                             //
                              $serie_a = 'ok';
  require('includes/proveedores_precios.php');




                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

                      $sql_status_update_array = array('contencion' =>1,);

               if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;

            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $codigobarras_a['products_id'] . "'");







}else{
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'ddii';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $salidas_c['orders_id'] . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");






     }



       }










}else{





$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


   $sql_data_array = array('customers_id' => $address_books['customers_id'],
                          'customers_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'customers_company' => '',
                          'customers_street_address' => $address_books['entry_street_address'],
                          'customers_suburb' => '',
                          'customers_city' => $address_books['entry_city'],
                          'customers_postcode' => $address_books['entry_postcode'],
                          'customers_state' => '',
                          'customers_country' => $address_books['entry_country_id'],
                          'customers_telephone' => $customerss['customers_telephone'],
                          'customers_email_address' => $customerss['customers_email_address'],
                          'customers_address_format_id' => 1,
                          'delivery_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'delivery_company' => '',
                          'delivery_street_address' => $address_books['entry_street_address'],
                          'delivery_suburb' => '',
                          'delivery_city' => $address_books['entry_city'],
                          'delivery_postcode' => $customerss['customers_telephone'],
                          'delivery_state' => '',
                          'delivery_country' => $address_books['entry_country_id'],
                          'delivery_address_format_id' => 1,
                          'billing_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'billing_company' => '',
                          'billing_street_address' => $customerss['customers_email_address'],
                          'billing_suburb' => '',
                          'billing_city' => $address_books['entry_city'],
                          'billing_postcode' => $address_books['entry_postcode'],
                          'billing_state' => '',
                          'billing_country' => $address_books['entry_country_id'],
                          'billing_address_format_id' => 1,
                          'payment_method' => $order->info['payment_method'],
                          'cc_type' => '',
                          'cc_owner' => '',
                          'cc_number' => '',
                          'cc_expires' => '',
                          'date_purchased' => $oldday1,
                          'orders_status' => $status_entradas_c,
                          'currency' => 'EUR',
                          'currency_value' => 1);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

    echo $insert_id = tep_db_insert_id();


      $sql_data_array = array('orders_id' => $insert_id,
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
							'orders_status_id' => $status_entradas_c, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_SUBTOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_subtotal",
                            'sort_order' => "1");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);


   $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DISCOUNT,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_customer_discount",
                            'sort_order' => "2");
   tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DELIVERY,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_shipping",
                            'sort_order' => "3");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TAX,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_tax",
                            'sort_order' => "4");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

      $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_total",
                            'sort_order' => "5");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);



 //Header("Location: ".$PHP_SELF."?action_entradas=ok&action_salidas=ok&admin_id_c=".$admin_id_c."&products_id=".$products_id."&status_entradas_c=".$status_entradas_c."&status_salidas_c=".$status_salidas_c."&unidades=".$unidades."");


 //Insertar el producto
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'ddii';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $insert_id . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");




}        //fin


}  //action ENTREDAS

}//serie a











































     if ($serie_bb){


     // PETICIONES DE RETIRADA


    if ($action_salidas){

            //si es admin o tienda
     if ($login_id_remoto <> 0){
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id_remoto . "'");
     $admin_a = mysql_fetch_array($admin_a_values);

           }else{
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id . "'");
     $admin_a = mysql_fetch_array($admin_a_values);


     }             //fin



            //direcciones
     $address_books_values = mysql_query("select * from " . 'address_book' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $address_books = mysql_fetch_array($address_books_values);
     $customerss_values = mysql_query("select * from " . 'customers' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $customerss = mysql_fetch_array($customerss_values);
              //fin


       //si el la peticion de retirada no existe se crea una nueva en la tienda correspondiente.
    $salidas_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $status_salidas_c . "' ");
   if ($salidas_c = mysql_fetch_array($salidas_values)){








                   //
                  //selecciona los productos y los datos de estos
    $codigobarras_values = mysql_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . $products_id . "'");
   if ($codigobarras_c = mysql_fetch_array($codigobarras_values)){








  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where  orders_id = '" . $salidas_c['orders_id'] . "' and products_id = '" . $products_id . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){


 //Pone el precio de oferta antes que el precio normal
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}  //fin




                                                             //CHIVATOS

                                                            echo 'serie A-Actualizar-1-salidas';
                                                              //FIN
                             //
                              $serie_a = 'ok';
  require('includes/proveedores_precios.php');




                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

                      $sql_status_update_array = array('contencion' =>1,);

               if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;

            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $codigobarras_a['products_id'] . "'");







}else{
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'dd';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $salidas_c['orders_id'] . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");






     }



       }










}else{
$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


   $sql_data_array = array('customers_id' => $address_books['customers_id'],
                          'customers_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'customers_company' => '',
                          'customers_street_address' => $address_books['entry_street_address'],
                          'customers_suburb' => '',
                          'customers_city' => $address_books['entry_city'],
                          'customers_postcode' => $address_books['entry_postcode'],
                          'customers_state' => '',
                          'customers_country' => $address_books['entry_country_id'],
                          'customers_telephone' => $customerss['customers_telephone'],
                          'customers_email_address' => $customerss['customers_email_address'],
                          'customers_address_format_id' => 1,
                          'delivery_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'delivery_company' => '',
                          'delivery_street_address' => $address_books['entry_street_address'],
                          'delivery_suburb' => '',
                          'delivery_city' => $address_books['entry_city'],
                          'delivery_postcode' => $customerss['customers_telephone'],
                          'delivery_state' => '',
                          'delivery_country' => $address_books['entry_country_id'],
                          'delivery_address_format_id' => 1,
                          'billing_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'billing_company' => '',
                          'billing_street_address' => $customerss['customers_email_address'],
                          'billing_suburb' => '',
                          'billing_city' => $address_books['entry_city'],
                          'billing_postcode' => $address_books['entry_postcode'],
                          'billing_state' => '',
                          'billing_country' => $address_books['entry_country_id'],
                          'billing_address_format_id' => 1,
                          'payment_method' => $order->info['payment_method'],
                          'cc_type' => '',
                          'cc_owner' => '',
                          'cc_number' => '',
                          'cc_expires' => '',
                          'date_purchased' => $oldday1,
                          'orders_status' => $status_salidas_c,
                          'currency' => 'EUR',
                          'currency_value' => 1);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

    echo $insert_id = tep_db_insert_id();


      $sql_data_array = array('orders_id' => $insert_id,
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
							'orders_status_id' => $status_salidas_c, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_SUBTOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_subtotal",
                            'sort_order' => "1");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);


   $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DISCOUNT,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_customer_discount",
                            'sort_order' => "2");
   tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DELIVERY,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_shipping",
                            'sort_order' => "3");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TAX,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_tax",
                            'sort_order' => "4");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

      $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_total",
                            'sort_order' => "5");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);



// Header("Location: ".$PHP_SELF."?serie_bb=ok&action_salidas=ok&action_entradas=ok&admin_id_c=".$admin_id_c."&products_id=".$products_id."&status_salidas_c=".$status_salidas_c."&status_entradas_c=".$status_entradas_c."&unidades=".$unidades."");







        //insertar productos cuando se inserte por primera vez la orden
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


    $codigobarras_values = mysql_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . $products_id . "' and pd.products_id = '" . $products_id . "'");
  $codigobarras_c = mysql_fetch_array($codigobarras_values);



                             echo $codigobarras_a['orders_id'].'dd';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $insert_id . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");



















}        //fin





}  //action SALIDAS  peticiones de retiradas













     //PETICIONES DE MERCANCIAS



    if ($action_entradas){

            //si es admin o tienda
     if ($login_id_remoto <> 0){
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id_remoto . "'");
     $admin_a = mysql_fetch_array($admin_a_values);

           }else{
      $admin_a_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $login_id . "'");
     $admin_a = mysql_fetch_array($admin_a_values);


     }             //fin



            //direcciones
     $address_books_values = mysql_query("select * from " . 'address_book' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $address_books = mysql_fetch_array($address_books_values);
     $customerss_values = mysql_query("select * from " . 'customers' . " where customers_id = '" . $admin_a['tienda_cuenta_cliente'] . "'");
     $customerss = mysql_fetch_array($customerss_values);
              //fin


       //si el la peticion de entrada no existe se crea una nueva en la tienda correspondiente.
    $salidas_values = mysql_query("select * from " . TABLE_ORDERS . " where orders_status = '" . $status_entradas_c . "'");
   if ($salidas_c = mysql_fetch_array($salidas_values)){








                   //
                  //selecciona los productos y los datos de estos
    $codigobarras_values = mysql_query("select * from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_id = pd.products_id and p.products_id = '" . $products_id . "'");
   if ($codigobarras_c = mysql_fetch_array($codigobarras_values)){








  $codigobarras_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where  orders_id = '" . $salidas_c['orders_id'] . "' and products_id = '" . $products_id . "'");
 if ($codigobarras_a = tep_db_fetch_array($codigobarras_a_values)){


 //Pone el precio de oferta antes que el precio normal
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){
      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}  //fin




                                                             //CHIVATOS
                                                echo 'CORRECTO ACTUALIZADOl'.$unidades;
                                                            echo 'serie A-actualizar-2-salidas';
                                                              //FIN
                             //
                              $serie_a = 'ok';
  require('includes/proveedores_precios.php');




                      $sql_status_update_array = array('products_quantity' => $unidades + $codigobarras_a['products_quantity'],
                                                       'final_price_euro' => $total_pago_euro,
                                                       'final_price_tienda' => $ganancias_tiendas,
                                                      );

             tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_status_update_array, 'update', " orders_products_id= '" . $codigobarras_a['orders_products_id'] . "'");

                      $sql_status_update_array = array('contencion' =>1,);

               if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;

            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id= '" . $codigobarras_a['products_id'] . "'");







}else{
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'ddii';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $salidas_c['orders_id'] . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");






     }



       }










}else{





$time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
$oldday1 = date("Y-m-d", $time1);


   $sql_data_array = array('customers_id' => $address_books['customers_id'],
                          'customers_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'customers_company' => '',
                          'customers_street_address' => $address_books['entry_street_address'],
                          'customers_suburb' => '',
                          'customers_city' => $address_books['entry_city'],
                          'customers_postcode' => $address_books['entry_postcode'],
                          'customers_state' => '',
                          'customers_country' => $address_books['entry_country_id'],
                          'customers_telephone' => $customerss['customers_telephone'],
                          'customers_email_address' => $customerss['customers_email_address'],
                          'customers_address_format_id' => 1,
                          'delivery_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'delivery_company' => '',
                          'delivery_street_address' => $address_books['entry_street_address'],
                          'delivery_suburb' => '',
                          'delivery_city' => $address_books['entry_city'],
                          'delivery_postcode' => $customerss['customers_telephone'],
                          'delivery_state' => '',
                          'delivery_country' => $address_books['entry_country_id'],
                          'delivery_address_format_id' => 1,
                          'billing_name' => $address_books['entry_firstname'] . ' ' . $address_books['entry_lastname'],
                          'billing_company' => '',
                          'billing_street_address' => $customerss['customers_email_address'],
                          'billing_suburb' => '',
                          'billing_city' => $address_books['entry_city'],
                          'billing_postcode' => $address_books['entry_postcode'],
                          'billing_state' => '',
                          'billing_country' => $address_books['entry_country_id'],
                          'billing_address_format_id' => 1,
                          'payment_method' => $order->info['payment_method'],
                          'cc_type' => '',
                          'cc_owner' => '',
                          'cc_number' => '',
                          'cc_expires' => '',
                          'date_purchased' => $oldday1,
                          'orders_status' => $status_entradas_c,
                          'currency' => 'EUR',
                          'currency_value' => 1);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

    $insert_id = tep_db_insert_id();


      $sql_data_array = array('orders_id' => $insert_id,
                            //Comment out line you don't need
							//'new_value' => $new_value,	//for 2.2
							'orders_status_id' => $status_entradas_c, //for MS1 or MS2
                            'date_added' => $oldday1);
     tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_SUBTOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_subtotal",
                            'sort_order' => "1");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);


   $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DISCOUNT,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_customer_discount",
                            'sort_order' => "2");
   tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_DELIVERY,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_shipping",
                            'sort_order' => "3");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TAX,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_tax",
                            'sort_order' => "4");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

      $sql_data_array = array('orders_id' => $insert_id,
                            'title' => TEXT_TOTAL,
                            'text' => $temp_amount,
                            'value' => "0.00",
                            'class' => "ot_total",
                            'sort_order' => "5");
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);



 // Header("Location: ".$PHP_SELF."?serie_bb=ok&action_entradas=ok&action_salidas=ok&admin_id_c=".$admin_id_c."&products_id=".$products_id."&status_entradas_c=".$status_entradas_c."&status_salidas_c=".$status_salidas_c."&unidades=".$unidades."");



  //Insertar el producto
  $ofertas_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $codigobarras_c['products_id'] . "'");
 if  ($ofertas = mysql_fetch_array($ofertas_values)){


      $codigobarras_c['products_price'] = $ofertas['specials_new_products_price'];
}

                                 echo 'serie B';
                             $serie_b = 'ok';
   require('includes/proveedores_precios.php');


                             echo $codigobarras_a['orders_id'].'ddii';

           $Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " set
              orders_id = '" . $insert_id . "',
              products_id = '" . $codigobarras_c['products_id'] . "',
              products_model = '" . $codigobarras_c['products_model'] . "',
              products_name = '" . $codigobarras_c['products_name'] . "',
              products_price = '". $codigobarras_c['products_price'] . "',
              final_price = '" . $codigobarras_c['products_price'] . "',
              final_price_euro = '" . $total_pago_euro . "',
              final_price_tienda = '" . $ganancias_tiendas . "',
              products_tax = '" . $ProductsTax . "',
              products_quantity = '" . $unidades . "'";
              tep_db_query($Query);
              $new_product_id = tep_db_insert_id();



                $sql_status_update_array = array('contencion' =>1,);

    if ($proveedorprice) $sql_status_update_array['proveedor_price'] = $proveedorprice;


            tep_db_perform(TABLE_PRODUCTS, $sql_status_update_array, 'update', " products_id = '" . $codigobarras_c['products_id'] . "'");











}        //fin


}  //action ENTREDAS




}//serie bb




 ?>

































<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<style type="text/css"><!--
BODY { margin-bottom: 10px; margin-left: 10px; margin-right: 10px; margin-top: 10px; }
//--></style>


<?php

  if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}


        $admin_log_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
    $admin_log = mysql_fetch_array($admin_log_values);




           echo 'Inventario: '.$admin_log['admin_firstname']. ' ' . $admin_log['admin_lastname'];//$pagado.'-'.$entregas_stock.'-'.$retirarado;




             $sumar_a = 'ok';

  require('includes/sumador_de_productos.php');




    ?>


       <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="22">
        <tr>
          <td height="22" colspan="7"><table width="100%" border="0">
            <tr>
              <td><div align="center"><p><a href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_pagados=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Pagados</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_entregados=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Entregado</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo  HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_retirados=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Retirado</font></a></p></div></td>
              <td><div align="center"><font size="1" face="Verdana">Diponibilidad</font></div></td>
            </tr>
            <tr>
             <td><div align="center"><?php echo $sumar_pagado['value'] ?></div></td>
              <td><div align="center"><?php echo $sumar_entregado['value']; ?></div></td>
              <td><div align="center"><?php echo $sumar_retirado['value']; ?></div></td>
              <td><div align="center"><?php

                          $pagadoyretirado = $sumar_retirado['value'] + $sumar_pagado['value'];

              echo  $sumar_entregado['value'] - $pagadoyretirado;


  ?></div></td>
            </tr>
          </table></td>


       <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="22">
        <tr>
          <td height="22" colspan="7"><table width="100%" border="0">
            <tr>
              <td><div align="center"><p><a href="<?php echo $PHP_SELF . '?edit_cobrado=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Cobrados</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo $PHP_SELF . '?edit_pendiente_entrada_total=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Pendiente de Entrada</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo $PHP_SELF . '?edit_presupuestos=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Presupuestos</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo $PHP_SELF . '?edit_credito=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Credito</font></a></p></div></td>
            <td><div align="center"><p><a href="<?php echo $PHP_SELF . '?edit_liquidacion=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Pagos Procesando</font></a></p></div></td>
            </tr>
            <tr>
             <td><div align="center"><?php echo $sumar_cobrados['value'] ?></div></td>
             <td><div align="center"><?php echo $sumar_pendiente_entrada_total['value'] ?></div></td>
             <td><div align="center"><?php echo $sumar_presupuestos['value']; ?></div></td>
<?php


    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_credito . "'";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);

 ?>
             
             
             <td><div align="center"><?php echo $sumar_credito['value']; ?></div></td>
             <td><div align="center"><?php echo $sumar_status_liquidacion['value']; ?></div></td>
           </tr>
          </table></td>





      <?php




           ?>




                          <?php



      
      

      
      
       
   $orders_values = mysql_query("select * from " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p, " . TABLE_ADMIN . " a, " . TABLE_ORDERS_PRODUCTS . " op where o.orders_id = op.orders_id and op.products_id = '" . $products_id . "' and p.products_id = '" . $products_id . "' and o.proveedor_id <> 0 and o.orders_status = a.abono and a.admin_groups_id <> 1 and a.admin_groups_id = 6");
   while ($orders = mysql_fetch_array($orders_values)){

 if ($login_id_remoto){
    $log_id =  $login_id_remoto;
}else{

    $log_id = $login_id;

}

   $admin_log_values = mysql_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
    $admin_log = mysql_fetch_array($admin_log_values);

      $proveedor_admin_values = mysql_query("select * from " . 'proveedor' . " where proveedor_id = '" . $orders['codigo_proveedor'] . "'");
    $proveedor_admin = mysql_fetch_array($proveedor_admin_values);
    


 ?>
  


 <form name="form1" method="post" action="<?php echo $PHP_SELF . '?serie_aa=ok&action_salidas=ok&action_entradas=ok&admin_id_c='. $orders['admin_id'] . '&products_id='.$products_id . '&status_salidas_c='.$orders['status_salidas']. '&status_entradas_c='.$admin_log['peticiones_mercancias']; ?>">
  <table width="424" border="0">

      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="22">
        <tr>

          <td width="9%" height="22"><font face="Verdana" size="1">Población:
       <font color="#FF0000">    <?php echo $orders['name_boxes'] ?></font></td>
          <td width="9%" height="22"><font face="Verdana" size="1"><p align="center">Disponible:
         <font color="#FF0000">  <?php echo $orders['products_quantity'] ?></font></td>
          <td width="28%" height="22"><font face="Verdana" size="1">Empresa:
         <font color="#FF0000"> <?php echo $orders['admin_firstname'] . ' ' . $orders['admin_lastname'] ?></font></td>
          <td width="28%" height="22"><div align="center"><td width="28%" height="22"><font face="Verdana" size="1">Proveedor  <font color="#FF0000"> <?php echo $proveedor_admin['proveedor_name']; ?></div></font></td>

         </tr>
       </table>
      </td>
    </tr>
  </table>
</form>





























 <?php

}
       
       

 ?>









    </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>

<p class="smallText" align="right"><?php echo '<a href="javascript:window.close()">' . TEXT_CLOSE_WINDOW . '</a>'; ?></p>

</body>
</html>
<?php require('includes/application_bottom.php'); ?>
