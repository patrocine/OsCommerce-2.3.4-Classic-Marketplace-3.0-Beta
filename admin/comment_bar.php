<html>

<!--

--------------------------------------------------------------------

Admin Comments Toolbar 2.0 by Skeedo.com Enterprises info@skeedo.com

Released under GNU General Public License for use with OSCommerce

--------------------------------------------------------------------

-->

<head>

   <script language="JavaScript">

   <!--



	var usrdate = '';



   function updateComment(obj,statusnum) {

			var textareas = document.getElementsByTagName('textarea');

			var myTextarea = textareas.item(0);

			if (myTextarea.value != '') {			

			myTextarea.value += '\n\n---<?php echo date("d-m-Y H:i:s"); ?>---\n' + obj;

			myTextarea.scrollTop=myTextarea.scrollHeight;

			}

			else {

			myTextarea.value = obj;

			}



			var selects = document.getElementsByTagName('select');

			var theSelect = selects.item(0);

			theSelect.selectedIndex = statusnum;

			

   }



   function killbox() {

			var box = document.getElementsByTagName('textarea');

			var killbox = box.item(0);

			killbox.value = '';



	}



	function getdate2 () {

               usrdate2 = prompt("NUMERO DE CERTIFICADO:");

	}



	function getdate () {

			usrdate = prompt("TOTAL DEL REEMBOLSO:");



	}

   //-->















   

   </script>



<style type="text/css">

.cbutton { width: 100px; font-family: Verdana; font-size: 9px; padding: 0px; border-bottom: 1px solid #000000; border-right: 1px solid #000000; border-top: 1px solid #000099; border-left: 4px solid #000099; cursor: hand;}

</style>



</head>

<body>



<!--

Edit the following buttons to make the buttons

and text inserts of your liking.



e.g. <button class="cbutton" onClick="updateComment('Text for button to insert','Order Status #');">Button Text</button>&nbsp;



Orderstatusnumber is the number of the order status option you would like the button to select, 0 being the first. 



e.g.	Paypal Processing

		Pending

		Backordered

		Processed

		Cancelled

		See Invoice



Paypal Processing would be 0, Cancelled would be 4.



Please note that the 'B. order Dte' button uses two functions. This is to prompt the user for a backorder date to insert.

Editing this and the other buttons should be pretty straight forward! 



To add more buttons just copy the first button code line to the end before the reset button. 





-->


  

<?php





$orderss_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");

  $orderss = tep_db_fetch_array($orderss_values);



  $orders_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $oID . "'");

  $orders_products = tep_db_fetch_array($orders_products_values);

  $orders_totals_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $oID . "'  and class =  '" . 'ot_total' . "'  ");

  $orders_totals = tep_db_fetch_array($orders_totals_values);
  
  

           if ($login_id_remoto){
               $log_id = $login_id_remoto;
               }else{
               $log_id = $admin['id'];
           }
           

           
           
  $direccion_empresa_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . 14 . "'");
  $direccion_empresa = tep_db_fetch_array($direccion_empresa_values);




    //Configuración   $direccion_empresa['']
$datos_empresa = STORE_NAME . '\n '. $direccion_empresa['admin_direccion'] .' \n '. $direccion_empresa['admin_poblacion'] . ' - ' . $direccion_empresa['admin_cp'] . ' \n '. $direccion_empresa['admin_state'] .'';
                                                                                                          //

 $pagar_Transfer .= ' Hola su pedido se encuentra actualmente en stock y se lo podriamos enviar de inmediato pero debido al valor del producto y al pesar mas de 2Kg (Paquete Azul, le tardaría 15días.) no podemos mandarselo contrareembolso. \n  mas información en http://www.correos.es/contenido/02P-EnviarPaq/01-PaqUrgente/01-PaqPostal/02P0101-PaqPostalExpress.asp';
 $pagar_Transfer .= '\n \n En cuanto recibamos el pago se lo enviaremos y recibira en su mail una confirmación de envío.';
 $pagar_Transfer .= ' \n \n DATOS BANCARIOS \n Titular: EUROCONSOLAS S.L. \n Banco: CAJA SIETE \n Cuenta: 3076-0040-20-2172995629  \n \n En observaciones ponga el número de pedido que es ('.$orderss['orders_id'].') y reenvie este mismo mensaje confirmando que realizo la transferencia.';
 // $pagar_Transfer .=   '\n \n En cuanto recibamos la transferencia se lo enviaremos por carta postal certificada si es menos de 2Kg  o Paquete Azul si sobre pasa los 2kg de peso \n El pedido se lo envíamos por Correos (www.correos.es)  \n \n Cuando le enviemos el pedido en su mail recibirá una confirmación de envío junto con el número de certificado, usted podrá hacer un seguimiento online a través de la pagina de www.correos.es o desde su historial de pedido accediendo a su panel de control logeandose en nuestra web de compras www.euroconsolas.com.';


 $pagar_Transfer_esp .= ' Hola buenas le confirmamos que  su pedido se encuentra en stock, en cuanto recibamos el pago se lo enviaremos por Postal express Asegurado y lo recibira en 48Horas.';
 $pagar_Transfer_esp .= ' \n \n DATOS BANCARIOS \n Titular: EUROCONSOLAS S.L. \n Banco: CAJA SIETE \n Cuenta: 3076-0040-20-2172995629  \n \n En observaciones ponga el número de pedido que es ('.$orderss['orders_id'].') y reenvie este mismo mensaje confirmando que realizo la transferencia.';
 $pagar_Transfer_esp .=   '\n \n  Cuando le enviemos el pedido en su mail recibirá una confirmación de envío junto con el número de certificado, usted podrá hacer un seguimiento online a través del localizador de envió de correos, también puede hacer el seguimiento desde su historial de pedido podrá hacer el seguimiento del pedido. \n http://www.correos.es/contenido/13-MenuRec2/01-MenuRec21/2010_c1-LocalizadorE.asp';
 $pagar_Transfer_esp .=   '\n \n   Puede obtener mas información sobre envios y entregas en www.correos.es.';







 $Esperando_Transfer_48 .= 'Hola buenas su pedido se encuentra en stock pero debido al valor del producto y al pesar mas de 2Kg (Paquete Azul, le tardaría 15días.) no podemos mandárselo contrareembolso, en cuanto recibamos el pago se lo enviaremos de inmediato. \n \n DATOS BANCARIOS \n Titular: EUROCONSOLAS S.L. \n Banco: La Caixa \n Cuenta: 2100-5907-17-0200014410  \n Banco: CAJA SIETE \n Cuenta: 3076-0040-20-2172995629  \n \n  En observaciones ponga el número de pedido que es ('.$orderss['orders_id'].')';
 $Esperando_Transfer_48 .= '\n \n En cuanto recibamos el pago se lo enviaremos por POSTAL EXPRESS y lo recibira en 48h.';
 $Esperando_Transfer_48 .= '\n \n Cuando le enviemos el pedido en su mail recibirá una confirmación de envío junto con el número de certificado, usted podrá hacer un seguimiento online a través de la pagina de www.correos.es, también desde su historial de pedido podrá hacer el seguimiento del pedido.';
 $Esperando_Transfer_48 .= '\n \n Puede obtener mas información sobre envios y entregas en www.correos.es.';




 $acuenta_Transfer_48 .= 'Hola buenas su pedido se encuentra en stock pero debido al precio del producto es necesario que haga un ingreso de 25euros a cuenta y que le será descontado del total de la factura)';
 $acuenta_Transfer_48 .= '\n \n '. STORE_BANK_ADDRESS_MODULES .' \n  \n En observaciones ponga el número de pedido que es ('.$orderss['orders_id'].')';
 $acuenta_Transfer_48 .= '\n \n En cuanto recibamos el pago de 25euros se lo enviaremos por POSTAL EXPRESS Contrareembolso y lo recibira en 48h.';
 $acuenta_Transfer_48 .= '\n \n En su historial de pedido puede observar como ya le hemos descontado los 25euros del total que ahora es de  ('.   $currencies->format($orders_totals['value']) .').';

 $acuenta_Transfer_48 .= '\n \n Cuando le enviemos el pedido en su mail recibirá una confirmación de envío junto con el número de certificado, usted podrá hacer un seguimiento online a través de la pagina de www.correos.es, también desde su historial de pedido podrá hacer el seguimiento del pedido.';
 $acuenta_Transfer_48 .= '\n \n Puede obtener mas información sobre envios y entregas en www.correos.es.';

 $pagar_transferencia .= '\n \n Su pedido esta preparado solo a la espera del pago.';
  $pagar_transferencia .= '\n \n Transferencia Bancaria';
   $pagar_transferencia .= '\n \n TOTAL: ('.   $currencies->format($orders_totals['value']) .')';
  $pagar_transferencia .= '\n \n Poner en Observaciones del Pago El número de este pedido ('.$orderss['orders_id'].')';
  $pagar_transferencia .= '\n Enviar a '. STORE_BANK_NAME_MODULES;
  $pagar_transferencia .= '\n '. STORE_BANK_ADDRESS_MODULES .'';
 $pagar_transferencia .= '\n \n Le damos un ' . REDEEM_POINT_VALUE * 100 . '% de descuento en BitShop moneda con la que damos los descuentos y podrás comprar de nuevo en el valor que este en el momento de su compra';
$pagar_transferencia .= '\n \n Si no tiene billetera acceda a esta pagina y siga las instrucciones para instalar Trust Wallet https://web30.store/bitshop-p-12.html';
$pagar_transferencia .= '\n \n Acceda a su panel de control y balla a editar cuenta o acceda directamente con este link. ' . HTTPS_SERVER . '/' . 'account_edit.php';


  ?>



  

  

<table cellpadding=0 cellspacing=0 border=0>

		<tr>

			<font color="#0033CC">Comentarios Configurados</font><font color="#0066CC">;</font>

			</td>

		</tr>

	<tr>

		<td>

<button class="cbutton" onClick="updateComment('El dinero correspondiente al pedido con número ID <?php echo $orderss['orders_id']?> ha sido ingresado en la cuenta facilitada por usted, con el titular y nombre facilitados.','37');">Devolución Dinero</button>&nbsp;



<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
Reembolsos Nacionales</font></b></p>
<button class="cbutton" onClick="getdate(); getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad carta postal Certificada Contrareembolso. \n Total del reembolso ' + usrdate + '  euros     \n\n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 5 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.\n  \n ','27');">Max 2kg-CPCR</button>&nbsp;
<button class="cbutton" onClick="getdate(); getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad Paquete Azul Certificado Contrareembolso. \n Total del reembolso ' + usrdate + '  euros     \n\n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 5 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','27');">Max 20kg-PACR</button>&nbsp;
<button class="cbutton" onClick="getdate(); getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad Postal Express Certificado Contrareembolso. \n Total del reembolso ' + usrdate + '  euros     \n\n Nº de Certificado EE' + usrdate2 + 'ES \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 5 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n \n ','27');">Max 20kg-PECR</button>&nbsp;
<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
Reembolsos Internacionales</font></b></p>

<button class="cbutton" onClick="getdate(); getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad carta postal Certificada Internacional Contrareembolso. \n Total del reembolso ' + usrdate + '  euros     \n\n Nº de Certificado RR' + usrdate2 + 'ES \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 5 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentrasupedido.   \n  \n ','28');">Max 2kg-CPCIR</button>&nbsp;
<button class="cbutton" onClick="getdate(); getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad carta Paquete Postal Internacional Contrareembolso. \n Total del reembolso ' + usrdate + '  euros     \n\n Nº de Certificado CP' + usrdate2 + 'ES \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 5 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digandonde se encuentra su pedido.   \n  \n ','28');">Max 20kg-CPCIR</button>&nbsp;

<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
Certificados Nacionales Normal</font></b></p>
<button class="cbutton" onClick="getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad carta postal Certificada. \n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 5 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','43');">Max 2kg-CPC</button>&nbsp;
<button class="cbutton" onClick="getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad Paquete Azul Certificado. \n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 5 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','43');">Max 20kg-CPCU</button>&nbsp;
<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
Certificados Nacionales Urgente</font></b></p>
<button class="cbutton" onClick="getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad carta postal Certificada Urgente. \n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 3 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','43');">Max 2kg-CPCU</button>&nbsp;
<button class="cbutton" onClick="getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad Postal Express Certificado. \n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 3 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','43');">Max 20kg-PEC</button>&nbsp;
<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
Certificados Internacionales Normal</font></b></p>
<button class="cbutton" onClick="getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad Carta Postal Certificada Internacional. \n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 3 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','43');">Max 2kg-CPCI</button>&nbsp;
<button class="cbutton" onClick="getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad Paquete Postal Economico Certificado Internacional. \n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 3 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','43');">Max 20kg-PPECI</button>&nbsp;
<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
Certificados Internacionales Urgente</font></b></p>
<button class="cbutton" onClick="getdate2(); updateComment('CONFIRMACIÓN DE ENVÍO \n El día <?php echo date("d-m-Y"); ?> ha salido su pedido por la modalidad Paquete Postal Prioritario Certificado Internacional. \n Nº de Certificado ' + usrdate2 + ' \n\n REMITENTE \n <?php echo $datos_empresa  ?>  \n\n DESTINATARIO  \n <?php echo $orderss['delivery_name'] . '\n ' . $orderss['delivery_street_address']  . '\n ' . $orderss['delivery_city']  . '&nbsp;&nbsp;' . $orderss['delivery_postcode']  . '\n &nbsp;' . $orderss['delivery_state']  . '\n &nbsp;' . $orderss['delivery_country']    ?>\n<?php ?> \n\n Pasados 3 días laborables después de recibir esta confirmación, usted no ha recibido su pedido en su domicilio, entre en www.correos.es, pulse en LOCALIZADOR DE ENVÍO e inserte el número certificado, también puede llamar al centro de atención al cliente de correos 902-197-197 y dando el número de certificado para que le digan donde se encuentra su pedido.   \n  \n ','43');">Max 20kg-PPPCI</button>&nbsp;

   </P>
   
 Propuestas a Clientes</font></b></p>
<button class="cbutton"   onClick="updateComment('CONFIRMACIÓN DEL ENVÍO \n Partes del pedido no se encuentran en stock ya que son por encargo, para no demorarle el pedido hemos divido el pedido en dos partes y será enviado por separado. \n Los gastos de envío paga el 50% para que no pague mas por el mismo pedido, ejm si el gasto es de 7 euros en cada pedido se le pondrá 3.50€  \n  \n ','13');">Dividido en dos</button>&nbsp;

   </P>
<button class="cbutton" onClick="updateComment('Hola <?php echo $orderss['delivery_name']?><?php  ?><?php  ?><?php  ?> \n Número de Pedido: <?php echo $orderss['customers_id']?><?php  ?> \n Le informamos que su pedido ya se encuentra en su oficina de correos, para obtener mas información puede obtenerla en el 902 197 197 o acercandose a su oficina de correos y facilitando el número de certificado de su pedido que es el Nº:  ( <?php echo $orderss['certificado'] ?> ). \n','35');">Recogida</button>&nbsp;

<button class="cbutton" onClick="updateComment('Hola <?php echo $orderss['delivery_name']?><?php  ?><?php  ?><?php  ?> \n Número de Pedido: <?php echo $orderss['customers_id']?><?php  ?> \n Le informamos que su pedido ha sido devuelto por correos, esto es debido a que usted no retiro el pedido o que hubo un error en correos y no se lo entregaron si este es su caso puede reenviarnos este mensaje para así volvérselo a enviar. \n','18');">Devuelto</button>&nbsp;

<button class="cbutton" onClick="updateComment('Hola <?php  ?><?php echo $orderss['delivery_name']?><?php  ?> \n Número de Pedido: <?php echo $orderss['customers_id']?><?php  ?> \n Le informamos que el Producto <?php echo $orders_products['products_name']?>no lo tenemos actualmente disponible por un error de stock puede elegir otro producto. \n\n Sentimos no poder servirle este producto.','4');">No Disponible</button>&nbsp;

<button class="cbutton" onClick="updateComment('Hola <?php  ?><?php echo $orderss['delivery_name']?><?php  ?> \n Número de Pedido: <?php echo $orderss['customers_id']?><?php  ?> \n La dirección de envío de su pedido esta incompleta, para enviarle el pedido necesitamos que nos la complete. \n Dirección Actual \n <?php echo $orderss['delivery_street_address'] . '\n' . $orderss['delivery_city'] . ',&nbsp;' . $orderss['delivery_postcode'] . '\n' . $orderss['delivery_state'] . ',&nbsp;' . $orderss['delivery_country']?>  \n\n reenvienos este mensaje con sus datos completados o a nuestro mail <?php echo STORE_OWNER_EMAIL_ADDRESS ?> \n\n Un Saludo \n EuroConsolas.','13');">Error Dirección</button>&nbsp;

<button class="cbutton" onClick="updateComment('Hola <?php  ?><?php echo $orderss['delivery_name']?><?php  ?> \n Número de Pedido: <?php echo $orderss['customers_id']?><?php  ?> \n Su pedido no puede ser enviado por los siguientes motivos. \n Modo de pago incorrecto \n\n  <?php  ?> Haga click en el siguiente vinculo y posteriormente en la categoría (MODO DE PAGO Y ENVÍO) para obtener ayuda visual de cómo realizar el pago correctamente \n http://www.euroconsolas.net/presentacion/presentacion.htm \n\n Un Saludo \n EuroConsolas.','13');">Error PAGO</button>&nbsp;    </P>

<button class="cbutton" onClick="updateComment('<?php echo $acuenta_Transfer_48 ?> ','37');">Acuenta-Transfer-48</button>&nbsp;    </P>
<button class="cbutton" onClick="updateComment('<?php echo $pagar_transferencia ?> ','38');">Pagar Transferencia</button>&nbsp;    </P>

<button class="cbutton" onClick=" updateComment('Hola \n En este momento el producto solicitado no se encuentra en stock pero lo tenemos pendiente de entrada en nuestro almacen. \n En cuanto lo tengamos disponible el estado de su pedido cambiará a PROCESANDO REEMBOLSO.','28');">Pendiente de Entrada</button>&nbsp;


<button class="cbutton" onClick="killbox();">Reset</button>&nbsp;

		</td>

		</tr>



</table>



</body>

</html>

