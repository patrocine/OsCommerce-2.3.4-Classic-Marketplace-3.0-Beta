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



  

<?php  $orderss_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . $oID . "'");

  $orderss = tep_db_fetch_array($orderss_values);

  

  $orders_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $oID . "'");
  $orders_products = tep_db_fetch_array($orders_products_values);
  
  
             if ($login_id_remoto){
               $log_id = $login_id_remoto;



 }else{
              $log_id = $login_id;



}

  $direccion_empresa_values = tep_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $log_id . "'");
  $direccion_empresa = tep_db_fetch_array($direccion_empresa_values);


    //Configuración
$datos_empresa = $order->info['payment_method'];




    



  

  ?>

  


  

  

<table cellpadding=0 cellspacing=0 border=0>

		<tr>

			<font color="#0033CC">Comentarios Configurados</font><font color="#0066CC">;</font>

			</td>

		</tr>

	<tr>

		<td>





<p style="margin-top: 0; margin-bottom: 0"><b><font face="Verdana" size="1">
Comentarios</font></b></p>
<button class="cbutton" onClick=" updateComment('Le informamos que hoy día <?php echo date("d-m-Y"); ?> su pedido ya esta disponible en <?php echo $datos_empresa ?> \n Cuando quiera ya puede venir a recogerlo. \n Para cualquier consulta puede llamarnos al <?php echo $direccion_empresa['admin_telefono'] . ' - ' . $direccion_empresa['admin_movil']; ?>  \n  \n ','19');">Recoger</button>&nbsp;
<button class="cbutton" onClick="updateComment('Hola <?php  ?><?php echo $orderss['customers_name']?><?php  ?> \n Número de Pedido: <?php echo $orderss['customers_id']?><?php  ?> \n Le informamos que el Producto <?php echo $orders_products['products_name']?> no lo tenemos actualmente disponible por un error de stock puede elegir otro producto. \n\n Sentimos no poder servirle este producto.','3');">No Disponible</button>&nbsp;


  </P>


<button class="cbutton" onClick="killbox();">Reset</button>&nbsp;

		</td>

		</tr>



</table>



</body>

</html>

