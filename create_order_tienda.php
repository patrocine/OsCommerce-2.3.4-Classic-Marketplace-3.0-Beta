<?php
/*
  $Id: create_order.php,v 1 2003/08/17 23:21:34 frankl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
  
*/






  require('includes/application_top.php');
  
    $palabraclave = $HTTP_POST_VARS['palabraclave'];

// #### Get Available Customers

	$query = tep_db_query("select customers_id, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " ORDER BY customers_lastname");
    $result = $query;

	
	if (tep_db_num_rows($result) > 0)
	{
 		// Query Successful
 		$SelectCustomerBox = "<select name='Customer'><option value=''>" . TEXT_SELECT_CUST . "</option>\n";
 		while($db_Row = tep_db_fetch_array($result))
 		{ $SelectCustomerBox .= "<option value='" . $db_Row["customers_id"] . "'";
		  if(IsSet($HTTP_GET_VARS['Customer']) and $db_Row["customers_id"]==$HTTP_GET_VARS['Customer'])
			$SelectCustomerBox .= " SELECTED ";
		  //$SelectCustomerBox .= ">" . $db_Row["customers_lastname"] . " , " . $db_Row["customers_firstname"] . " - " . $db_Row["customers_id"] . "</option>\n"; 
		  $SelectCustomerBox .= ">" . $db_Row["customers_lastname"] . " , " . $db_Row["customers_firstname"] . "</option>\n";
		
		}
		
		$SelectCustomerBox .= "</select>\n";
	}
	
	$query = tep_db_query("select code, value from " . TABLE_CURRENCIES . " ORDER BY code");
	$result = $query;
        /*
	if (tep_db_num_rows($result) > 0)
	{
 		// Query Successful
 		$SelectCurrencyBox = "<select name='Currency'><option value='' SELECTED>" . TEXT_SELECT_CURRENCY . "</option>\n";
 		while($db_Row = tep_db_fetch_array($result))
 		{ 
			$SelectCurrencyBox .= "<option value='" . $db_Row["code"] . " , " . $db_Row["value"] . "'";
		  	$SelectCurrencyBox .= ">" . $db_Row["code"] . "</option>\n";
		}
		
		$SelectCurrencyBox .= "</select>\n";
	}
       */
       
       
	if(IsSet($HTTP_GET_VARS['Customer']))
	{
 	$account_query = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $HTTP_GET_VARS['Customer'] . "'");
 	$account = tep_db_fetch_array($account_query);
 	$customer = $account['customers_id'];
 	$address_query = tep_db_query("select * from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $HTTP_GET_VARS['Customer'] . "'");
 	$address = tep_db_fetch_array($address_query);
 	//$customer = $account['customers_id'];
	} elseif (IsSet($HTTP_GET_VARS['Customer_nr']))
	{
 	$account_query = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $HTTP_GET_VARS['Customer_nr'] . "'");
 	$account = tep_db_fetch_array($account_query);
 	$customer = $account['customers_id'];
 	$address_query = tep_db_query("select * from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $HTTP_GET_VARS['Customer_nr'] . "'");
 	$address = tep_db_fetch_array($address_query);
 	//$customer = $account['customers_id'];
	} elseif (IsSet($customer_cc))
	{
 	$account_query = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_cc . "'");
 	$account = tep_db_fetch_array($account_query);
 	$customer = $account['customers_id'];
 	$address_query = tep_db_query("select * from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $customer_cc . "'");
 	$address = tep_db_fetch_array($address_query);
 	//$customer = $account['customers_id'];
	}


  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ORDER_PROCESS_TIENDA);
 

// #### Generate Page
	?>	
			<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html <?php echo HTML_PARAMS; ?>>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php
// BOF: WebMakers.com Changed: Header Tag Controller v1.0
// Replaced by header_tags.php
if ( file_exists(DIR_WS_INCLUDES . 'header_tags.php') ) {
  require(DIR_WS_INCLUDES . 'header_tags.php');
} else {
?> 
  <title><?php echo 'PANEL DE CONTROL' ?></title>
        	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		<?php require('includes/form_check.js.php'); ?>
		</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
		<!-- header //-->
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
        
        
        
        
    </table></td>
<!-- body_text //-->

<td valign="top">
		<table border='0' bgcolor='#7c6bce' width='100%'>
			<tr>
			  <td class=main><font color='#ffffff'><b><?php echo 'PEDIDOS A CLIENTES' ?></b></td>

  <table border='0' cellpadding='7'><tr><td class="main" valign="top">

 <form name="codigo_barras_c" method="post" action="<?php echo $PHP_SELF.'?oID='.$oID.'&action=edit&action_cod=ok'; ?>">

  </p>
  <p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
  Búsquedas</font></b></p>
  <p style="margin-top: 0; margin-bottom: 0">
    <font size="1" face="Verdana"><b>
       <?php
      // seleccionado busca todos los productos que esten activados o desactivados.

       ?>
<input type="checkbox" name="stock_disponible" value="ON">
  <input name="palabraclave" type="text" value="" size="20" style="font-family: Verdana; font-size: 8pt; color: #000080; border-style: outset; border-width: 3; background-color: #FFFF00">
     <input type="hidden" name="add_product">
    <input type="submit" name="Submit" value="Buscar" style="color: #FFFFFF; font-family: ve; font-size: 8pt; background-color: #008080">
    </b></font>
  </p>
</form>





       <?PHP

           if ($stock_disponible){
      // todos los productos que esten o no esten disponible

   }else{
    // solo los productos que esten disponibles.
   $stock_status = 'p.products_status = 1 and';

}


       if ($palabraclave){

             }else{
        $palabraclave = 'nohaynada';
         }
   $orders_query_raw = "select * from " . TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK . " ab on c.customers_id = ab.customers_id where c.customers_id like '%" . $palabraclave . "%' or c.customers_firstname like '%" . $palabraclave . "%' or c.customers_lastname like '%" . $palabraclave . "%' or c.customers_email_address like '%" . $palabraclave . "%' or c.customers_email_address like '%" . $palabraclave . "%' or ab.entry_firstname like '%" . $palabraclave . "%' or ab.entry_lastname like '%" . $palabraclave . "%' or ab.entry_street_address like '%" . $palabraclave . "%' or ab.entry_postcode like '%" . $palabraclave . "%' or ab.entry_city like '%" . $palabraclave . "%' ORDER BY c.customers_firstname";
 $orders_query = tep_db_query($orders_query_raw);
    while ($orders = tep_db_fetch_array($orders_query)) {



  ?>



  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="15%"><font size="1" face="Verdana"><p><a target="_self" href="<?php echo $PHP_SELF . '?Customer_nr='.$orders['customers_id']; ?>">Añadir</a></p></font></td>
         <td width="15%"><font size="1" face="Verdana"><a href="<?php echo 'orders_tienda.php?keywoards=' . $orders['customers_firstname'] . ' ' . $orders['customers_lastname'];?>">Pedidos</a></font></td>
     <td width="70%"><font size="1" face="Verdana"><p><b><?php echo ' &nbsp;&nbsp;&nbsp;' .$orders['customers_firstname'] . ' ' . $orders['customers_lastname']; ?></font></td></b></p>
   </tr>
   <?php
   
   
   
 $pedidos_query = tep_db_query("select * from " . TABLE_ORDERS . " where customers_id = '" . $orders['customers_id'] . "'");
 	while ($pedidos = tep_db_fetch_array($pedidos_query)){
      ?>


   <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="15%"><font size="1" face="Verdana"><p><a target="_self" href="<?php echo 'orders_tienda.php?selected_box=Almacen%20Central&page=1&action=edit&oID='.$pedidos['orders_id']; ?>">Editar</a></p></font></td>
    <td width="15%"><font size="1" face="Verdana"><p><a target="_self" href="<?php echo 'edit_orders_tienda.php?oID='.$pedidos['orders_id']; ?>">Actualizar</a></p></font></td>
    <td width="15%"><font size="1" face="Verdana"><p><a target="_self" href="<?php echo $PHP_SELF . '?Customer_nr='.$orders['customers_id']; ?>">Añadir</a></p></font></td>
         <td width="15%"><font size="1" face="Verdana"><a href="<?php echo 'orders_tienda.php?keywoards=' . $orders['customers_firstname'] . ' ' . $orders['customers_lastname'];?>">Pedidos</a></font></td>
     <td width="70%"><font size="1" face="Verdana"><p><b><?php echo ' &nbsp;&nbsp;&nbsp;' .$orders['customers_firstname'] . ' ' . $orders['customers_lastname']; ?></font></td></b></p>
   </tr>


     <?php
}


   
   
   
}



       ?>






  
    <?php





	print "<form action='$PHP_SELF' method='GET'>\n";
	print "<table border='0'>\n";
 
 
 
 









	print "<tr>\n";
	print "<td><font class=main><b><br>" . 'Insertar ID de Cliente: ' . "</b></font><br><br><input type=text name='Customer_nr'></td>\n";
	print "<td valign='bottom'><input type='submit' value=\"" . BUTTON_SUBMIT . "\"></td>\n";
	print "</tr>\n";
	print "</table>\n";
	print "</form>\n";
?>	
		<tr>
        
    <td width="100%" valign="top"><?php echo tep_draw_form('create_order', FILENAME_CREATE_ORDER_PROCESS_TIENDA, '', 'post', '', '') . tep_draw_hidden_field('customers_id', $account->customers_id); ?><table border="0" width="100%" cellspacing="0" cellpadding="0">
								  
	 </tr> <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_CREATE; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
        
        
        

        
        
<?php

//onSubmit="return check_form();"

  require(DIR_WS_MODULES . 'create_order_details_tienda.php');
 
?>









        </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'SSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
            <td class="main" align="right"><?php echo tep_image_submit('button_confirm.gif', IMAGE_BUTTON_CONFIRM); ?></td>
          </tr>
        </table></td>
      </tr>
      
      
      





<?php
    $orden_status_query = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $HTTP_GET_VARS['Customer_nr'] . "'");
 	$orden_status = tep_db_fetch_array($orden_status_query);


                  if ($login_groups_id == 1 or $login_groups_id == 8){

                           $affiliate_empresa_categoria_es = array();
  $affiliate_empresa_categoria_array = array();
  $affiliate_empresa_categoria_query = tep_db_query("select * from " . 'orders_status' . " where tienda = '" . $code_admin . "' and permiso_tienda_crearpedido = '" . 2 . "'or tienda = '" . $code_admin . "' and permiso_tienda_crearpedido = '" . 3 . "'ORDER BY orders_status_name");
  while ($affiliate_empresa_categoria = tep_db_fetch_array($affiliate_empresa_categoria_query)) {
    $affiliate_empresa_categoria_es[] = array('id' => $affiliate_empresa_categoria['orders_status_id'],
                                              'text' => $affiliate_empresa_categoria['orders_status_name']);
    $affiliate_empresa_categoria_array[$affiliate_empresa_categoria['orders_status_id']] = $affiliate_empresa_categoria['orders_status_name'];
  }



 }else{

                           $affiliate_empresa_categoria_es = array();
  $affiliate_empresa_categoria_array = array();
  $affiliate_empresa_categoria_query = tep_db_query("select * from " . 'orders_status' . " where tienda = '" . $code_admin . "' and permiso_tienda_crearpedido = '" . 2 . "' ORDER BY orders_status_name");
  while ($affiliate_empresa_categoria = tep_db_fetch_array($affiliate_empresa_categoria_query)) {
    $affiliate_empresa_categoria_es[] = array('id' => $affiliate_empresa_categoria['orders_status_id'],
                                              'text' => $affiliate_empresa_categoria['orders_status_name']);
    $affiliate_empresa_categoria_array[$affiliate_empresa_categoria['orders_status_id']] = $affiliate_empresa_categoria['orders_status_name'];
  }

}


          ?>
<?php echo tep_draw_pull_down_menu('new_value', $affiliate_empresa_categoria_es, $cobrado); ?>

  <p>&nbsp;</p>

 <?php






?>
      <?php echo tep_image_submit('siguiente.jpg', IMAGE_BUTTON_CONFIRM); ?>
      
      
    </table></form></td>
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
<?php 
require(DIR_WS_INCLUDES . 'application_bottom.php'); 
}
?>
