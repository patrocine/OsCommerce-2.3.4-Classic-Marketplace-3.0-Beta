<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRIVACY);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRIVACY));

  require(DIR_WS_INCLUDES . 'template_top.php');
  
  $pedido = $_GET['pedido'];
  $nombre = $_GET['nombre'];
  $esperar = $_GET['esperar'];
  $aceptar_cambio = $_GET['aceptar_cambio'];
  $esperar = $_GET['esperar'];
  $cancelar_pedido = $_GET['cancelar_pedido'];
  $enviar_producto = $_GET['enviar_producto'];


?>

    <td class="pageHeading"><?php echo 'SU PEDIDO: '.$pedido; ?></td>

<div class="contentContainer">
  <div class="contentText">
  <?php


  // El clinente con número de pedido xxxx acepta el cambio.

       if ($aceptar_cambio == 'ok'){


  tep_mail('', STORE_OWNER_EMAIL_ADDRESS, 'Modificación de Pedidos', 'El cliente con número de pedido '. $pedido .' acepta el cambio', $nombre, EMAIL_FROM);

      ?>

<p><b><font color="#FF0000" size="4" face="Verdana">En breve le enviaremos el
pedido y recibirá todos los datos del envío en su email.</font></b></p>

    <?php
   }




    // El clinente con número de pedido xxxx desea esperar a que el pedido se encuentre en stock.
       if ($esperar == 'ok'){

 tep_mail('', STORE_OWNER_EMAIL_ADDRESS, 'Modificación de Pedidos', 'El cliente con número de pedido '. $pedido .' prefiere esperar hasta que el producto que eligio este disponible.', $nombre, EMAIL_FROM);



      ?>


 <p><b><font color="#FF0000" size="4" face="Verdana">Su pedido sigue aprovisionandose y en cuanto nos entre el producto/s se lo enviaremos</font></b></p>

    <?php

   }



     // El clinente con número de pedido xxxx quiere cancelar el pedido.
       if ($cancelar_pedido == 'ok'){

  tep_mail('', STORE_OWNER_EMAIL_ADDRESS, 'Modificación de Pedidos', 'El cliente con número de pedido '. $pedido .' quiere cancelar el pedido', $nombre, EMAIL_FROM);


      ?>


 <p><b><font color="#FF0000" size="4" face="Verdana">Usted ha decidido cancelar el pedido y en breve recibirá la notificación en su email.</font></b></p>



   <?php


  }


     // El clinente con número de pedido xxxx quiere cancelar el pedido.
       if ($enviar_producto == 'ok'){

  tep_mail('', STORE_OWNER_EMAIL_ADDRESS, 'Modificación de Pedidos', 'El cliente con número de pedido '. $pedido .' acepta que se le envíe el pedido', $nombre, EMAIL_FROM);


      ?>


<p><b><font color="#FF0000" size="4" face="Verdana">En breve le enviaremos el
pedido y recibirá todos los datos del envío en su email.</font></b></p>


   <?php


  }


        ?>



  </div>

  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?></span>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
