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

  define('TABLE_AFFILIATE_PATROCINEMONOS', 'affiliate_patrocinemonos');

  require('includes/application_top.php');
  
  

  $result = mysql_query("show tables like 'affiliate_patrocinemonos'");

/* Si no existe la tabla */
if(mysql_fetch_row($result) == false) {
 ?>

 <script language="javascript" src="actualizar_empresas.php"> </script></td>

 <?php
   mysql_query($sql);
}






     if ($HTTP_GET_VARS['actualizar']){

   $sql_status_update_array = array('empresa_email_address' => $HTTP_POST_VARS['email_usuario'],
                                    'patrocinemonos_homepage' => $HTTP_POST_VARS['patrocinemonos_homepage'],
                                    'empresa_password_original' => $HTTP_POST_VARS['password']);
                 tep_db_perform(TABLE_AFFILIATE_PATROCINEMONOS, $sql_status_update_array, 'update', "selec = '" . 1 . "'");


   tep_redirect('actualizar_datos_patrocinemonos.php');


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

  // IF NOT EXISTS (SELECT * FROM affiliate_compartir_empresas){
  //   echo 'si';
//}else{
//   echo 'no';
//}




        $configure_values = mysql_query("select * from " . TABLE_AFFILIATE_PATROCINEMONOS . " where selec = '" . 1 . "'");
        $configure = mysql_fetch_array($configure_values);

  ?>

<form method="post" action="<?php echo 'actualizar_datos_patrocinemonos.php' . '?' . 'actualizar=' . 'Array'?>">

    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 8pt" bordercolor="#111111" width="500">
 <tr>
<font face="Verdana" size="1"><b>
Email de Usuario:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font><input width="250" type="text" name="email_usuario" value="<?php echo $configure['empresa_email_address']; ?>" size="35"><b><font face="Verdana" size="1"><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
Contraseña:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></b><input width="250" type="text" name="password" value="<?php echo $configure['empresa_password_original']; ?>" size="20"><font face="Verdana" size="1"><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
Vinculo Enlace:</font></b><input width="250" type="text" name="patrocinemonos_homepage" value="<?php echo $configure['patrocinemonos_homepage']; ?>" size="68"><font face="Verdana" size="1"><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>

  </table>
      <input type="Submit" name="submit" value="Actualizar">





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






























