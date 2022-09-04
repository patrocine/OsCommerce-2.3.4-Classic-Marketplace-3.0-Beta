<?php
/*
  $Id: shipping.php,v 1.22 2003/06/05 23:26:23 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHIPPING);

  $breadcrumb->add('Configurar Factura para Impresión', tep_href_link(FILENAME_SHIPPING));
  
  
    require(DIR_WS_INCLUDES . 'template_top.php');
  
?>

<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo 'Configurar Factura para Impresión'; ?></td>
             <?php       $images_page_values = mysql_query("select * from " . TABLE_INFO_MODULES . " where id = '" . 16 . "'");
   $images_page = mysql_fetch_array($images_page_values);

                 if($images_page['value'] == 1){ // IMAGENES SUPERIOR DERECHA SI O NO?>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_specials.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
            <?php } ?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>








 <p></p>
<p><font face="Verdana" size="2">Configure el EXPLORER o FIREBOX MOZILLA para poder imprimir su
factura, sin márgenes, sin encabezados y que quede toda dentro de una sola hoja.</font></p>
<p><font face="Verdana" size="2">MENÚ / Herramientas / Archivo / Configurar
Página /</font></p>
<p><font face="Verdana" size="2"><b>Valores Por Defecto</b></font></p>
<p><font face="Verdana" size="2">
<img border="0" src="conf_1.jpg" width="393" height="411"></font></p>
<p><font face="Verdana" size="2"><b>Configurar Con los Siguientes Valores</b></font></p>
<p><font face="Verdana" size="2">
<img border="0" src="conf_2.jpg" width="393" height="411"></font></p>
<p><font face="Verdana" size="2">Los volres de estos campos tienen que ser de 5.</font></p>


















          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
