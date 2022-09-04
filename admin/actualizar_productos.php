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



 $empresa_values = mysql_query("select * from " . 'affiliate_patrocinemonos' . " where selec='" . 1 . "'");
 $empresa = mysql_fetch_array($empresa_values);



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






<p style="margin-top: 0; margin-bottom: 0"><u><b><font face="Verdana" size="2">
Envíe su Catalogo a Nuestro Portal</font></b></u></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
<p style="margin-top: 0; margin-bottom: 0"><b>
<font face="Verdana" size="2" color="#FF6600">
<a target="_self" href="actualizar_productos.php?categorias=ok&page=1">
<font color="#FF6600">Actualizar Categorías</font></a> |
<a target="_self" href="actualizar_productos.php?productos=ok&page=1">
<font color="#FF6600">Actualizar Productos</font></a> |
<a href="actualizar_productos.php?productos_to_categorias=ok&page=1">
<font color="#FF6600">Actualizar Parentescos</font></a> </font></b></p>
<?php IF ($HTTP_GET_VARS['actualizacion_exito']){ ?>

<p align="center"><font color="#FF0000" face="Verdana" size="2"><b>TODAS LAS
CATEGORÍAS, PRODUCTOS Y PARENTESCOS HAN SIDO ACTUALIZADOS CON ÉXITO</b></font></p>
<?php }else if ($HTTP_GET_VARS['categorias'] or $HTTP_GET_VARS['productos']or $HTTP_GET_VARS['productos_to_categorias']){}else{ ?>


<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">
Instrucciones</font></p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">1º
Pulse sobre Actualizar Categorías.</font></p>
<p style="margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1">2º No
detenga este proceso hasta que le aparezca el siguiente mensaje en color <b>
<font color="#FF0000">rojo</font></b></font></p>
<p align="center"><font face="Verdana" size="1">&quot;TODAS LAS CATEGORÍAS, PRODUCTOS
Y PARENTESCOS HAN SIDO ACTUALIZADOS CON ÉXITO&quot;</font></p>

 <?php   } ?>

<?PHP




 // PATROCINEMONOS

 $empresa_values = mysql_query("select * from " . 'affiliate_patrocinemonos' . " where selec = '" . 1 . "'");
 $empresa = mysql_fetch_array($empresa_values);
 
if ($HTTP_GET_VARS['categorias']){   // categorias

   $affiliate_contrato_value_values = "
      select * from " . TABLE_CATEGORIES . "
      order by '" . 'categories_id' . "' desc
      ";
    $affiliate_contrato_split = new splitPageResults($HTTP_GET_VARS['page'], 100, $affiliate_contrato_value_values, $affiliate_sales_numrows);

  if ($affiliate_sales_numrows > 0) {
    $affiliate_contrato_valuee = tep_db_query($affiliate_contrato_value_values);
    $number_of_sales = '0';
    while ($asdfcds = tep_db_fetch_array($affiliate_contrato_valuee)) {
      $number_of_sales++;
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {

  echo '<tr class="headerBar">';
      } else {
        echo '<tr class="dataTableRowSelected">';
      }


   $adfasersd_values = mysql_query("select * from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $asdfcds['categories_id'] . "' and language_id = '" . (int)$languages_id . "'");
   $adfasersd = mysql_fetch_array($adfasersd_values);


 $empresa_email_address                       = $empresa['empresa_email_address'];
 $password                                    = $empresa['empresa_password_original'];

 $categories_id                               = $asdfcds['categories_id'];
 $parent_id                                   = $asdfcds['parent_id'];
 $categories_name                             = $adfasersd['categories_name'];

?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="100%"><p>
<iframe name="<?php echo $categories_id ;  ?>" border="0" frameborder="0" scrolling="no" width="700" height="20" src="<?php echo HTTP_SERVER . DIR_WS_ADMIN .'actualizar_confirm_salida.php'.
                                   '?salida_c=' . 'ok' .
                                   '&empresa_email_address=' . $empresa_email_address .
                                   '&password=' . $password .
                                   '&categories_id=' . $categories_id  .
                                   '&categories_name=' . $categories_name  .
                                   '&parent_id=' . $parent_id
?>", "<?php echo $categories_id ?>">
 </iframe><br></td>


<?php


    }
  } else {
?>
          <tr class="dataTableRowSelected">
            <td colspan="7" class="smallText"><?php echo 'No hay categorias en la base de datos'; ?></td>
          </tr>
<?php
  }
  if ($affiliate_sales_numrows > 0 && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
          <tr>
            <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
              <?php $num_pages = ceil($affiliate_sales_numrows / 100);?>
       <td class="smallText" align="left"><?php echo $affiliate_contrato_split->display_links($affiliate_sales_numrows, 100, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'] , tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>

               <?php
               if ( $num_pages == $HTTP_GET_VARS['page']){    ?>
              <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=actualizar_productos.php?productos=ok&page=1">
          <?php   }else{   ?>

     <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=actualizar_productos.php?categorias=ok&page=<?php echo $HTTP_GET_VARS['page'] + 1; ?>">


               <?php  }  ?>
                </tr>
            </table></td>
          </tr>
<?php
  }


 } // productos

 if ($HTTP_GET_VARS['productos']){   //productos



   $affiliate_contrato_value_values = "
      select * from " . TABLE_PRODUCTS . "
      order by '" . 'products_id' . "' desc
      ";
    $affiliate_contrato_split = new splitPageResults($HTTP_GET_VARS['page'], 100, $affiliate_contrato_value_values, $affiliate_sales_numrows);

  if ($affiliate_sales_numrows > 0) {
    $affiliate_contrato_valuee = tep_db_query($affiliate_contrato_value_values);
    $number_of_sales = '0';
    while ($disosdks = tep_db_fetch_array($affiliate_contrato_valuee)) {
      $number_of_sales++;
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {

  echo '<tr class="headerBar">';
      } else {
        echo '<tr class="dataTableRowSelected">';
      }


  $dlkksod_values = mysql_query("select * from " . 'products_description' . " where products_id = '" . $disosdks['products_id'] . "' and language_id = '" . (int)$languages_id . "'");
  $dlkksod = mysql_fetch_array($dlkksod_values);
  $asdxxxd_values = mysql_query("select * from " . 'products_to_categories' . " where products_id = '" . $disosdks['products_id'] . "'");
  $asdxxxd = mysql_fetch_array($asdxxxd_values);
  $asseopi_values = mysql_query("select * from " . 'specials' . " where products_id = '" . $disosdks['products_id'] . "'");
  $asseopi = mysql_fetch_array($asseopi_values);
  
  $iva_values = mysql_query("select * from " . 'tax_rates' . " where tax_class_id= '" . $disosdks['products_tax_class_id'] . "'");
  $iva = mysql_fetch_array($iva_values);


 $empresa_email_address                       = $empresa['empresa_email_address'];
 $password                                    = $empresa['empresa_password_original'];
 $products_id                                 = $disosdks['products_id'];
 $products_model                              = $disosdks['products_model'];
 $products_image                              = $disosdks['products_image'];
 $products_price                              = $disosdks['products_price'] * $iva['tax_rate'] / 100 + $disosdks['products_price'];
 $products_weight                             = $disosdks['products_weight'];
 $products_status                             = $disosdks['products_status'];
 $products_date_added                         = $disosdks['products_date_added'];
 $products_last_modified                      = $disosdks['products_last_modified'];

 $products_categories                         = $asdxxxd['categories_id'];

 $products_name                               = $dlkksod['products_name'];
 

 
 $products_url                                = $dlkksod['products_url'];

 $specials_new_products_price                 = $asseopi['specials_new_products_price'] * $iva['tax_rate'] / 100 + $asseopi['specials_new_products_price'];
 $specials_date_added                         = $asseopi['specials_date_added'];
 $specials_last_modified                      = $asseopi['specials_last_modified'];
 $expires_date                                = $asseopi['expires_date'];
 $date_status_change                          = $asseopi['date_status_change'];
 $status                                      = $asseopi['status'];



?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="100%"><p>
<iframe name="I1" border="0" frameborder="0" scrolling="no" width="700" height="20" src="<?php echo HTTP_SERVER . DIR_WS_ADMIN . 'actualizar_confirm_salida.php'.
                                   '?salida_ca=' . 'ok' .
                                   '&empresa_email_address=' . $empresa_email_address .
                                   '&password=' . $password .
                                   '&products_id=' . $products_id  .
                                   '&products_model=' . $products_model  .
                                   '&products_image=' . $products_image  .
                                   '&products_price= ' . $products_price .
                                   '&products_weight=' . $products_weight .
                                   '&products_status=' . $products_status .
                                   '&products_name=' . $products_name  .
                                   '&products_url=' . $products_url  .
                                   '&products_date_added=' . $products_date_added  .
                                   '&products_last_modified=' . $products_last_modified  .
                                   '&products_categories=' . $products_categories  .
                                   '&categories_id=' . $categories_id  .
                                   '&parent_id=' . $parent_id  .
                                   '&categories_name=' . $categories_name .
                                   '&specials_new_products_price=' . $specials_new_products_price .
                                   '&specials_date_added=' . $specials_date_added .
                                   '&specials_last_modified=' . $specials_last_modified .
                                   '&expires_date=' . $expires_date .
                                   '&date_status_change=' . $date_status_change .
                                   '&status=' . $status

?>", "<?php echo $affiliate_orders_id ?>">
</iframe><br></td>


<?php


    }
  } else {
?>
          <tr class="dataTableRowSelected">
            <td colspan="7" class="smallText"><?php echo 'No hay productos en la base de datos'; ?></td>
          </tr>
<?php
  }
  if ($affiliate_sales_numrows > 0 && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
          <tr>
            <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
           <?php $num_pages = ceil($affiliate_sales_numrows / 100);?>

             <td class="smallText" align="left"><?php echo $affiliate_contrato_split->display_links($affiliate_sales_numrows, 100, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'] , tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>

               <?php
               if ( $num_pages == $HTTP_GET_VARS['page']){    ?>
              <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=actualizar_productos.php?productos_to_categorias=ok&page=1">
          <?php   }else{   ?>

     <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=actualizar_productos.php?productos=ok&page=<?php echo $HTTP_GET_VARS['page'] + 1; ?>">


               <?php  }  ?>



                </tr>
            </table></td>
          </tr>
<?php
  }


 } // productos









 if ($HTTP_GET_VARS['productos_to_categorias']) {

   $affiliate_contrato_value_values = "
      select * from " . TABLE_PRODUCTS_TO_CATEGORIES . "
      order by '" . 'products_id' . "' desc
      ";
    $affiliate_contrato_split = new splitPageResults($HTTP_GET_VARS['page'], 100, $affiliate_contrato_value_values, $affiliate_sales_numrows);

  if ($affiliate_sales_numrows > 0) {
    $affiliate_contrato_valuee = tep_db_query($affiliate_contrato_value_values);
    $number_of_sales = '0';
    while ($lodsx = tep_db_fetch_array($affiliate_contrato_valuee)) {
      $number_of_sales++;
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {

  echo '<tr class="headerBar">';
      } else {
        echo '<tr class="dataTableRowSelected">';
      }

   $asxt_values = mysql_query("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . $lodsx['categories_id'] . "'");
   $asxt = mysql_fetch_array($asxt_values);


  $empresa_email_address                       = $empresa['empresa_email_address'];
  $password                                    = $empresa['empresa_password_original'];
  $categories_id                               = $lodsx['categories_id'];
  $products_id                                 = $lodsx['products_id'];

?>

<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="100%"><p>
<iframe name="<?php echo $categories_id ;  ?>" border="0" frameborder="0" scrolling="no" width="700" height="20" src="<?php echo HTTP_SERVER . DIR_WS_ADMIN .'actualizar_confirm_salida.php'.
                                   '?salida_cb=' . 'ok' .
                                   '&empresa_email_address=' . $empresa_email_address .
                                   '&password=' . $password .
                                   '&categories_id=' . $categories_id .
                                   '&products_id=' . $products_id
?>", "<?php echo $categories_id ?>">
 </iframe><br></td>


<?php


    }
  } else {
?>
          <tr class="dataTableRowSelected">
            <td colspan="7" class="smallText"><?php echo 'No hay productos en la base de datos'; ?></td>
          </tr>
<?php
  }
  if ($affiliate_sales_numrows > 0 && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
          <tr>
            <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
           <?php $num_pages = ceil($affiliate_sales_numrows / 100);?>


                <td class="smallText" align="left"><?php echo $affiliate_contrato_split->display_links($affiliate_sales_numrows, 100, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>


                <?php
               if ( $num_pages == $HTTP_GET_VARS['page']){    ?>
                <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=actualizar_productos.php?actualizacion_exito=ok">
             <?php   }else{   ?>
                <META HTTP-EQUIV="REFRESH" CONTENT="5; URL=actualizar_productos.php?productos_to_categorias=ok&page=<?php echo $HTTP_GET_VARS['page'] + 1; ?>">
                 <?php  }  ?>



                                </tr>
            </table></td>
          </tr>
<?php
  }

} //productos categorias

?>

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
<?php require(DIR_WS_INCLUDES . 'footer.php');




?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');




 ?>
































