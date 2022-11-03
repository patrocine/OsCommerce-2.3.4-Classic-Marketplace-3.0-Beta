<?php
/*
  $Id: affiliate_details.php,v 1.10 2003/02/15 00:10:38 harley_vb Exp $

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/


  require('includes/application_top.php');
  
 $result = tep_db_query("show tables like 'affiliate_compartir_empresas'");

/* Si no existe la tabla */
if(mysql_fetch_row($result) == false) {
 ?>

<?php  //<script language="javascript" src="actualizar_tabla_banners.php"> </script></td>
 ?>
 <?php
   tep_db_fetch_array($sql);
}

     if ($_GET['up_actualizar']){


                      $sql_status_update_array = array('numero_productos' => $_POST['numero_productos'],
                                                      'nombre' => $_POST['nombre'],
                                                      'email' => $_POST['email'],
                                                      'aut' => $_POST['aut'],
                                                       'url_empresa_catalog' => $_POST['url'],
                                                      'url_web' => $_POST['url_web'],
                                                      'nombre_sector' => $_POST['nombre_sector'],
                                                      'nombre_ciudad' => $_POST['nombre_ciudad'],
                                                      'url_enlace' => $_POST['url_enlace'],
                                                     );

             tep_db_perform('affiliate_compartir_empresas', $sql_status_update_array, 'update', " id_banners= '" . $_GET['id_banners'] . "'");


tep_redirect('affiliate_empresa_banner.php');


 }


                 
                 
     if ($_GET['insertar']){



    $text_email_si .= '<p>Su banner ya esta operativo en la tienda ' . HTTP_SERVER . '</p>';
    $text_email_si .= '<p> Esta confirmación es automática y es enviada en el mismo momento que se ha insertado el registro en la tienda online correspondiente.</p>';

       tep_mail('', $_POST['email'], 'Banner Insertado', $text_email_si, '', 'PatroCine.es <patrocinees@gmail.com>');


                        $sql_data_array = array('numero_productos' => $_POST['numero_productos'],
                                                      'nombre' => $_POST['nombre'],
                                                      'email' => $_POST['email'],
                                                      'aut' => $_POST['aut'],
                                                      'url_web' => $_POST['url_web'],
                                                      'nombre_sector' => $_POST['nombre_sector'],
                                                      'nombre_ciudad' => $_POST['nombre_ciudad'],
                                                      'url_enlace' => $_POST['url_enlace'],
                                                      'url_empresa_catalog' => $_POST['url'],);
               tep_db_perform('affiliate_compartir_empresas', $sql_data_array);



tep_redirect('affiliate_empresa_banner.php');


 }
 


 if ($HTTP_GET_VARS['borrar']){


         $peticion_borrar_values = tep_db_query("select * from " . 'affiliate_compartir_empresas' . " where id_banners= '" . $HTTP_GET_VARS['id_banners'] . "'");
        $peticion_borrar = tep_db_fetch_array($peticion_borrar_values);

    $text_email_si .= '<p>Su Banner ha sido borrado de la tienda ' . HTTP_SERVER . '</p>';
    $text_email_si .= '<p> Esta confirmación es automática y es enviada en el mismo momento que se ha borrado el registro en la tienda online correspondiente.</p>';



     //  tep_mail('', $peticion_borrar['email'], 'Banner Borrado', $text_email_si, '', 'PatroCine.es <patrocinees@gmail.com>');


 tep_db_query("delete from " . 'affiliate_compartir_empresas' . " where id_banners= '" . $HTTP_GET_VARS['id_banners'] . "'");

  tep_redirect('affiliate_empresa_banner.php');
}
 
 
 
 
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






<?php

          $update_reg_values = tep_db_query("select * from " . 'affiliate_compartir_empresas' . " where id_banners= '" . $_GET['id_banners'] . "'");
      if  ($update_reg = tep_db_fetch_array($update_reg_values)){

 if ($_GET['actualizar']){

     ?>


<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
-->
</style>
<body class="Estilo1"><form name="form1" method="post" action="<?php echo 'affiliate_empresa_banner.php' . '?' . 'up_actualizar=' . 'Array'.'&id_banners='.$_GET['id_banners']?>">
   <p>URL BANNER
     <input name="url" type="text" size="80" value="<?php echo $update_reg['url_empresa_catalog'] ?>" maxlength="255">
</p>

   <p>URL ENLACE
     <input name="url_enlace" type="text" size="80" value="<?php echo $update_reg['url_enlace']  ?>" maxlength="255">
</p>
   <p>URL AFFILIATE
     <input name="url_affiliate" type="text" size="80" value="<?php echo $update_reg['url_affiliate']  ?>" maxlength="255">
</p>

   <p>Sector
     <input name="nombre_sector" type="text" size="30" value="<?php echo $update_reg['nombre_sector']  ?>" maxlength="255">
 Nombre de su Sector ej. Alimentación</p>

   <p>Numero de Productos por banner para esta empresa:
     <input name="numero_productos" type="text" size="2" value="<?php echo $update_reg['numero_productos']  ?>" maxlength="2">
 entre 1 y 10 Max.</p>
 
   <p>Autorización 1 si 0 no:
     <input name="aut" type="text" size="2" value="<?php echo $update_reg['aut']  ?>" maxlength="2">
</p>

 
 
   <p>Nombre
     <input name="nombre" type="text" value="<?php echo $update_reg['nombre'] ?>" size="20">
    <p>Email
     <input name="email" type="text" value="<?php echo $update_reg['email'] ?>" size="20">

     Url Web
     <input name="url_web" type="text" value="<?php echo $update_reg['url_web'] ?>" size="20">
   </p>
   <p>
     <input type="submit" name="Submit" value="Actualizar">
</p>
   </form>





 <?php







}


  }else{




  ?>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
-->
</style>
<body class="Estilo1"><form name="form1" method="post" action="<?php echo 'affiliate_empresa_banner.php' . '?' . 'insertar=' . 'Array'?>">
   <p>URL BANNER
     <input name="url" type="text" size="80" maxlength="255">
</p>

   <p>URL ENLACE
     <input name="url_enlace" type="text" size="80" maxlength="255">
</p>

   <p>Sector
     <input name="nombre_sector" type="text" size="30" maxlength="255">
 Nombre de su Sector ej. Alimentación</p>

   <p>Numero de Productos por banner para esta empresa:
     <input name="numero_productos" type="text" size="2" maxlength="2">
 entre 1 y 10 Max.</p>
 
 
    <p>Autorización 1 si 0 no:
     <input name="aut" type="text" size="2" value="" maxlength="2">
</p>

 
 
   <p>Nombre
     <input name="nombre" type="text" size="20">
    <p>Email
     <input name="email" type="text" size="20">

     Url Web
     <input name="url_web" type="text" size="20">
   </p>
   <p>
     <input type="submit" name="Submit" value="Insertar">
</p>
   </form>
   
   
   
  <?php
 }

        ?>
   
   
   
   
<p><font face="Verdana" size="1">Código url de su banner:</font></p>
<p><font face="Verdana" size="1"><?php echo HTTP_SERVER . DIR_WS_CATALOG . 'affiliate_banners_products.php?pro_ale='; ?>
</font></p>
<p>&nbsp;</p>
<meta http-equiv="Content-Language" content="es">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="3%" align="center">id</td>
    <td width="10%" align="center">
    <p align="center">Nombre</td>
  <td width="10%" align="center">Email</td>

    <td width="20%" align="center">URL ENLACE</td>
    <td width="33%" align="center">URL EMPRESA</td>
    <td width="7%" align="center">Nº Prod</td>
    <td width="10%" align="center">Editar</td>
     <td width="10%" align="center">Borrar</td>
 </tr>
</table>




  <?php

      $image_sc = HTTP_SERVER . DIR_WS_CATALOG . 'affiliate_banners_products.php?pro_ale=';;
      $image_en = HTTP_SERVER . DIR_WS_CATALOG . 'enlace.php';;
      $url_web = HTTP_SERVER . DIR_WS_CATALOG;
      $url_affiliate = HTTP_SERVER . DIR_WS_CATALOG . 'index.php?ref=1';
      $nombre = STORE_NAME;
      $nombre_sector = NOMBRE_SECTOR;
      $nombre_ciudad = NOMBRE_CIUDAD_TIENDA;
      $email = STORE_OWNER_EMAIL_ADDRESS;



    $selec_values = tep_db_query("select * from " . 'affiliate_compartir_empresas' . "");
      while  ($selec = tep_db_fetch_array($selec_values)){

?>
<meta http-equiv="Content-Language" content="es">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family:Verdana; font-size:8pt" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <td width="3%" align="center"><?php echo $selec['id_banners']; ?>&nbsp;</td>
    <td width="10%" align="center">
                  <?php

                  if ($selec['aut'] == 1){

                    ?>
                      <p align="center"><?php echo  '<img border=0 src='.$url_web.'images/verde.jpg width=26 height=24>'; ?></td>
                     <?php
              }else{
                    ?>
                      <p align="center"><?php echo  '<img border=0 src='.$url_web.'images/rojo.jpg width=26 height=24>'; ?></td>
                     <?php

          }







                           ?>


    
   <td width="10%" align="center"><?php echo $selec['nombre']; ?></td>
     <td width="10%" align="center"><?php echo $selec['email']; ?></td>
    <td width="20%" align="center"><?php echo $selec['url_web']; ?>&nbsp;</td>
    <td width="20%" align="center"><?php echo $selec['url_enlace']; ?>&nbsp;</td>
    <td width="33%" align="center"><?php echo $selec['url_empresa_catalog']; ?>&nbsp;</td>
    <td width="7%" align="center"><?php echo $selec['numero_productos'] ?>&nbsp;</td>
    <td width="7%" align="center"><?php echo $selec['nombre_ciudad'] ?>&nbsp;</td>
    <td width="7%" align="center"><?php echo $selec['nombre_sector'] ?>&nbsp;</td>
     <td width="5%" align="center"><p><a href="<?php echo $PHP_SELF . '?actualizar=ok&id_banners=' . $selec['id_banners']; ?>">Editar</a></p></td>
   <td width="5%" align="center"><p><a href="<?php echo $PHP_SELF . '?borrar=ok&id_banners=' . $selec['id_banners']; ?>">Borrar</a></p></td>
   <td width="10%" align="center"><p><?php  echo ' <td class="smallText" align="center"><br><script language="javascript" src="'. $selec['url_enlace'].'?url_affiliate='.$url_affiliate.'&linkbanner='.$image_sc.'&linkenlace='.$image_en.'&url_web='.$url_web.'&nombre='.$nombre.'&nombre_sector='.$nombre_sector.'&nombre_ciudad='.$nombre_ciudad.'&email='.$email.'"> </script></td>' . '</a><br />';

   ?></a></p></td>
    </tr>
</table>



 <?php
}
  
  
  







     ?>


<p>&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1"><b>ID:
</b>id del banners</font></p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1"><b>Nombre:</b> Nombre de la empresa</font></p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1"><b>URL EMPRESA:</b> Código url que la otra
empresa le proporciona, envíele el código de su empresa para que también pueda
crear su banner en su tienda online. </font> </p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1"><b>NºProd:
</b>Numero de productos máximos
que se imprimirán por banner.</font></p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1"><b>
Borrar:</b> Borrar el registro seleccionado.</font><p style="margin-top: 0; margin-bottom: 0">&nbsp;<p style="margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="1">En <a href="http://www.patrocine.es">
www.patrocine.es</a> tenemos una zona donde encontrarás tiendas online con la
misma aplicación.</font>





</td>
</tr></table>
</form>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
