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



    $products_id = $HTTP_GET_VARS['products_id'];
        $edit_entregados  = $HTTP_GET_VARS['edit_entregados'];
        $edit_pagados    =  $HTTP_GET_VARS['edit_pagados'];
         $edit_entregados   =  $HTTP_GET_VARS['edit_entregados'];
         $edit_retirados   =  $HTTP_GET_VARS['edit_retirados'];
         $edit_entregados   =  $HTTP_GET_VARS['edit_entregados'];
       $products_id   =  $HTTP_GET_VARS['products_id'];
       $status_entregas   =  $HTTP_GET_VARS['status_entregas'];
       $edit_cobrado   =  $HTTP_GET_VARS['edit_cobrado'];


         

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

        $status_procesando_a_values = tep_db_query("select op.orders_id, o.delivery_name, o.date_purchased, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.status_liquidacion and a.admin_groups_id=6");
       while  ($status_procesando_a = tep_db_fetch_array($status_procesando_a_values)){

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

        $status_procesando_a_values = tep_db_query("select op.orders_id, o.delivery_name, o.date_purchased, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, admin a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status = a.pendiente_entrada and a.admin_groups_id=6");
       while  ($status_procesando_a = tep_db_fetch_array($status_procesando_a_values)){

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

        $procesando_reembolso_internacional_a_values = tep_db_query("select op.orders_id, o.delivery_name, o.date_purchased, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando_reembolso_internacional . "'");
       while  ($procesando_reembolso_internacional_a = tep_db_fetch_array($procesando_reembolso_internacional_a_values)){

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

        $status_entregas_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $status_entregas . "'");
       while  ($status_entregas_a = tep_db_fetch_array($status_entregas_a_values)){

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

        $status_salidas_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $status_salidas . "'");
       while  ($status_salidas_a = tep_db_fetch_array($status_salidas_a_values)){

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

        $valor_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_no_recogido . "'");
       while  ($valor_a = tep_db_fetch_array($valor_a_values)){

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

        $valor_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_cancelado . "'");
       while  ($valor_a = tep_db_fetch_array($valor_a_values)){

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

        $login_procesando_paypal_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando_paypal . "'");
       while  ($login_procesando_paypal_a = tep_db_fetch_array($login_procesando_paypal_a_values)){

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

        $login_pendiente_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_pendiente . "'");
       while  ($login_pendiente_a = tep_db_fetch_array($login_pendiente_a_values)){

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

        $login_transferencia_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_transferencia . "'");
       while  ($login_transferencia_a = tep_db_fetch_array($login_transferencia_a_values)){

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

        $login_transferencia_procesando_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_transferencia_procesando . "'");
       while  ($login_transferencia_procesando_a = tep_db_fetch_array($login_transferencia_procesando_a_values)){

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

        $status_procesando_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_procesando . "'");
       while  ($status_procesando_a = tep_db_fetch_array($status_procesando_a_values)){

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

        $pagado_paypal_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $pagado_paypal . "'");
       while  ($pagado_paypal_a = tep_db_fetch_array($pagado_paypal_a_values)){

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
         $pagados_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.pagado and a.admin_groups_id=6");
 while  ($pagados_a = tep_db_fetch_array($pagados_a_values)){

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

              $entregados_a_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o, administrators a where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status =a.entregas_stock and a.admin_groups_id=6");
  while  ($entregados_a = tep_db_fetch_array($entregados_a_values)){

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

        $pagado_internacional_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "' and o.orders_status ='" . $pagado_internacional . "'");
       while  ($pagado_internacional_a = tep_db_fetch_array($pagado_internacional_a_values)){

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

        $pagado_transferencia_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "' and o.orders_status ='" . $pagado_transferencia . "'");
       while  ($pagado_transferencia_a = tep_db_fetch_array($pagado_transferencia_a_values)){

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

        $paypal_enviado_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "' and o.orders_status ='" . $login_paypal_enviado . "'");
       while  ($paypal_enviado_a = tep_db_fetch_array($paypal_enviado_a_values)){

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

        $retirarados_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $retirarado . "'");
       while  ($retirarados_a = tep_db_fetch_array($retirarados_a_values)){

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

        $cobrado_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $cobrado . "'");
       while  ($cobrado_a = tep_db_fetch_array($cobrado_a_values)){

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

        $presupuestos_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_presupuestos . "'");
       while  ($presupuestos_a = tep_db_fetch_array($presupuestos_a_values)){

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







        $presupuestos_a_values = tep_db_query("select op.orders_id, o.date_purchased, o.delivery_name, op.products_quantity, op.products_inventario from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_credito . "'");
       while  ($presupuestos_a = tep_db_fetch_array($presupuestos_a_values)){

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








        $admin_log_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
    $admin_log = tep_db_fetch_array($admin_log_values);




           echo 'Inventario: '.$admin_log['admin_firstname']. ' ' . $admin_log['admin_lastname'];//$pagado.'-'.$entregas_stock.'-'.$retirarado;




             $sumar_a = 'ok';

  require('includes/sumador_de_productos.php');


      if ($log_id == 1){

    $entradas_os = $sumar_entregado['value'];
    $salidas_os = $sumar_pagos_procesando['value'] + $sumar_status_albaran['value'] + $sumar_credito['value'] + $sumar_retirado['value'] +  $sumar_cobrados_total['value'] + $sumar_pagado_total['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value'];


   $resultado =  $entradas_os-$salidas_os;
     $pagado = $sumar_pagado_total['value'];
     
     
     
       $time1 = mktime(1, 1, 1, date("m"), date("d"), date("Y"));
      $oldday1 = date("Y-m-d", $time1);
     
             $sql_data_array = array('time_proveedores' => time()+rand(1,130000),
                                   'time_entradasysalidas' => $resultado,
                                   'time_ultimaactualizacion' => $oldday1,);

     tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . $products_id . "'");

     
     
  }else{

 $pagadoyretirado = $sumar_retirado['value'] + $sumar_pagado['value'];
 $resultado = $sumar_entregado['value'] - $pagadoyretirado;
 $pagado = $sumar_pagado['value'];

 
 
}


    $entradas_os = $sumar_entregado_total['value'];
    $salidas_os = $sumar_pagos_procesando['value'] + $sumar_status_albaran['value'] + $sumar_credito['value'] + $sumar_retirado['value'] +  $sumar_cobrados_total['value'] + $sumar_pagado_total['value'] + $sumar_pagado_transferencia['value'] + $sumar_paypal_enviado['value'];


   $resultado =  $entradas_os-$salidas_os;





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
             <td><div align="center"><?php echo  $sumar_pagado_total['value']; ?></div></td>
              <td><div align="center"><?php echo $sumar_entregado_total['value']; ?></div></td>
              <td><div align="center"><?php echo $sumar_retirado_total['value']; ?></div></td>
              <td><div align="center"><?php echo  $resultado; ?></div></td>
            </tr>
          </table></td>


       <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="22">
        <tr>
          <td height="22" colspan="7"><table width="100%" border="0">
            <tr>
              <td><div align="center"><p><a href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_cobrado=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Cobrados</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_pendiente_entrada_total=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Pendiente de Entrada</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_presupuestos=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Presupuestos</font></a></p></div></td>
              <td><div align="center"><p><a href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_credito=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Credito</font></a></p></div></td>
            <td><div align="center"><p><a href="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'consultar_stock_tiendas.php?edit_liquidacion=ok&products_id=' . $products_id; ?>">
                <font size="1" face="Verdana">Pagos Procesando</font></a></p></div></td>
            </tr>
            <tr>
             <td><div align="center"><?php echo $sumar_cobrados_total['value']; ?></div></td>
             <td><div align="center"><?php echo $sumar_pendiente_entrada_total['value'] ?></div></td>
             <td><div align="center"><?php echo $sumar_presupuestos_total['value']; ?></div></td>
<?php


    $sumar_credito_sales_raw = "select sum(products_quantity) as value, count(*) as products_quantity from " . TABLE_ORDERS_PRODUCTS . " op,  " . TABLE_ORDERS . " o where o.orders_id = op.orders_id and op.products_id ='" . $products_id . "'and o.orders_status ='" . $login_credito . "'";
    $sumar_credito_sales_query = tep_db_query($sumar_credito_sales_raw);
    $sumar_credito= tep_db_fetch_array($sumar_credito_sales_query);

 ?>
             
             
             <td><div align="center"><?php echo $sumar_credito_total['value']; ?></div></td>
             <td><div align="center"><?php echo $sumar_status_liquidacion_total['value']; ?></div></td>
           </tr>
          </table></td>






</body>
</html>
<?php require('includes/application_bottom.php'); ?>
