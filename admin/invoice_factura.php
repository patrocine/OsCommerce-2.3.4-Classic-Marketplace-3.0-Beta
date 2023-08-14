<?php
/*
  $Id: invoice.php,v 1.1 2002/06/11 18:17:59 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require('includes/conf_status.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
  $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");

  include(DIR_WS_CLASSES . 'order.php');
  $order = new order($oID);




               $factura_orders_values = tep_db_query("select * from " . TABLE_ORDERS . " where orders_status = '" . 5 . "' or orders_status = '" . 133 . "' or orders_status = '" . 134 . "' or orders_status =  '" . 6 .  "' or orders_status =  '" . 20 .  "' or orders_status =  '" . 25 .  "' or orders_status =  '" . 119 .   "'");
                while   ( $factura_orders = tep_db_fetch_array($factura_orders_values)) {


          $factura_price_raw = "select sum(products_price) as value, sum(products_price) as price, count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id ='" . $factura_orders['orders_id'] . "'";
  $factura_price_query = tep_db_query($factura_price_raw);
  $factura_price= tep_db_fetch_array($factura_price_query);



 $factura_shipping_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_shipping' . "'");
              $factura_shipping = tep_db_fetch_array($factura_shipping_values);

 $factura_total_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_total' . "'");
              $factura_total = tep_db_fetch_array($factura_total_values);


 $factura_subtotal_values = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $factura_orders['orders_id'] . "' and class =  '" . 'ot_subtotal' . "'");
              $factura_subtotal = tep_db_fetch_array($factura_subtotal_values);

           $admin_lof_values = tep_db_query("select * from " . TABLE_ADMIN . " where id = '" . $admin['id'] . "'");
 $admin_lof = tep_db_fetch_array($admin_lof_values);

  ?>

<div align="center">
  <center>
  <table border="2" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="656" height="199">
    <tr>
      <td width="652" height="161">
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="650" height="147">
        <tr>
          <td width="191" height="147">
          <p align="center">
          <img  src="<?php echo HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . 'logo_sts.jpg';  ?>" border="0"></td>
          <td width="323" height="147" valign="top">
          <p style="margin-top: 0; margin-bottom: 0" align="center"><b>
          <a href="http://<?php ECHO FACTURA_WEB; ?>" style="text-decoration: none">
          <font color="#000000" size="2"><?php ECHO FACTURA_WEB; ?></font></a></b></p>
          <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
          <p style="margin-top: 0; margin-bottom: 0"><font size="2"><b>&nbsp;<?php ECHO STORE_FACTURA; ?></b></font></p>
          <p style="margin-top: 0; margin-bottom: 0"><font size="1">&nbsp; <?php echo $admin_lof['admin_direccion'] ?> </p>
          <p style="margin-top: 0; margin-bottom: 0">&nbsp;<?php echo $admin_lof['admin_poblacion'] ?>
          <?php ECHO $admin_lof['admin_cp']; ?></p>
          <p style="margin-top: 0; margin-bottom: 0">&nbsp;<?php echo $admin_lof['admin_provincia'] ?> </p>
          <p style="margin-top: 0; margin-bottom: 0">&nbsp; <?php ECHO PAIS; ?></p>
          <p style="margin-top: 0; margin-bottom: 0">&nbsp;<?php echo $admin_lof['admin_telefono'] ?> </p>
          <p style="margin-top: 0; margin-bottom: 0">&nbsp;</font><a href="mailto:<?php echo FACTURA_EMAIL; ?>"><font size="1" color="#000000"><?php echo  $email['value_name']; ?></font></a></td>
          <td width="381" height="147" valign="top">
          <p align="right" style="margin-top: 0; margin-bottom: 0"><b>
          <font size="3"><?php echo TEXT_FACTURA_A_CLIENTES; ?></font></b></p>
          <p align="right" style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
          <p align="left" style="margin-top: 0; margin-bottom: 0"><b>&nbsp;<?php ECHO TEXT_NUMERO_FACTURA ?>
          </b><?php echo $factura_orders['orders_id'] ?></p>
          <p align="left" style="margin-top: 0; margin-bottom: 0"><b>&nbsp;<?php ECHO TEXT_FECHA; ?>
          </b><?php echo $factura_orders['date_purchased'] ?> </p>
          <p align="left" style="margin-top: 0; margin-bottom: 0"><b>&nbsp; <?php echo TEXT_MODO_ENVIO; ?>
           </b><?php echo $factura_shipping['title'] ?> </td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td width="652" height="19">
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="140">
        <tr>
          <td width="100%" height="140">
          <table border="0" cellpadding="3" cellspacing="3" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%" height="35">
            <tr>
              <td width="48%" height="35"><?php echo TEXT_DATOS_DE_CLIENTES ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?php echo $factura_orders['customers_id'] ?></td>
              <td width="52%" height="35">
              <table border="2" cellpadding="5" cellspacing="5" style="border-collapse: collapse; font-size: 10pt" bordercolor="#C0C0C0" width="100%">
                <tr>
                  <td width="100%"><?php ECHO TEXT_AFILIADO_TX; ?></td>
                </tr>
              </table>
              </td>
            </tr>
            <tr>
              <td width="100%" height="35" colspan="2" valign="top">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
                <tr>
                  <td width="100%">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="52">
                    <tr>
                      <td width="41%" height="52" valign="top">
                      <table border="2" cellspacing="5" style="border-collapse: collapse" bordercolor="#C0C0C0" width="100%" height="54">
                        <tr>
                          <td width="100%" height="28">
                          <p style="margin-top: 0; margin-bottom: 0"><b>
                          <font size="1"><?php echo TEXT_NOMBRE_M; ?></font></b></p>
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="2"><?php echo $factura_orders['billing_name'] ?></font></td>
                        </tr>
                        <tr>
                          <td width="100%" height="11"></td>
                        </tr>
                      </table>
                      </td>
                      <td width="3%" height="52">&nbsp;</td>
                      <td width="56%" height="52">
                      <table border="2" cellspacing="5" style="border-collapse: collapse" bordercolor="#C0C0C0" width="100%">
                        <tr>
                          <td width="100%" colspan="2">
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="1"><b><?php ECHO TEXT_DIRECCION_DE_ENVIO_M; ?></b></font></p>
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="2"><?php echo $factura_orders['billing_street_address'] ?></font></td>
                        </tr>
                        <tr>
                          <td width="53%">
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="1"><b><?php ECHO TEXT_POBLACION_M ?></b></font></p>
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="2"><?php echo $factura_orders['billing_city']?></font></td>
                          <td width="47%">
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="1"><b><?php ECHO TEXT_CODIGO_POSTAL_M ?></b></font></p>
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="2"><?php echo $factura_orders['billing_postcode']?></font></td>
                        </tr>
                        <tr>
                          <td width="100%" colspan="2">
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="1"><b><?php ECHO TEXT_PROVINCIA_M ?></b></font></p>
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="2"><?php echo $factura_orders['billing_state']?></font></td>
                        </tr>
                        <tr>
                          <td width="50%">
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="1"><b><?php ECHO TEXT_PAIS_M ?></b></font></p>
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="2"><?php echo $factura_orders['billing_country']?></font></td>
                          <td width="50%">
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="1"><b><?php ECHO TEXT_TELEFONO_M ?></b></font></p>
                          <p style="margin-top: 0; margin-bottom: 0">
                          <font size="2"><?php echo $factura_orders['customers_telephone']?></font></td>
                        </tr>
                      </table>
                      </td>
                    </tr>
                  </table>
                  </td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td width="652" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="652" height="19">
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="75">
        <tr>
          <td width="100%" height="14">
          <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="12%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_REF_M ?></font></b></td>
              <td width="40%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_DESCRIPCION_M ?></font></b></td>
              <td width="13%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_PRECIO_M ?></font></b></td>
              <td width="6%" align="center"><b><font face="Verdana" size="1">
              <?php ECHO TEXT_CANT_M ?></font></b></td>
              <td width="11%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_IMP_M ?></font></b></td>
              <td width="18%" align="center"><b><font size="1" face="Verdana">
              <?php ECHO TEXT_PRECIO_TOTAL_M ?></font></b></td>
            </tr>





          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="75">

          <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="102%" height="437">

            <tr>

              <td width="12%" height="305" valign="top" style="font-family: Verdana; font-size: 8pt">

                             <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "'");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>



      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 8pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                  <td width="100%" height="13">&nbsp;

                  <?php echo $factura_products['products_model'] ?>
                  </td>
                </tr>




              </table>

                   <?php   } ?>

              </td>

              <td width="39%" height="305" valign="top" style="font-family: Verdana; font-size: 8pt">

                 <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "'");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 5pt" bordercolor="#111111" width="100%" height="13">
                <tr>
                  <td width="100%" height="13">&nbsp;
             <?php

           $donde_esta_c_values = tep_db_query("select * from " . 'products_donde_esta' . " where  products_id = '" . $factura_products['products_id'] . "' and login_id = '" . $login_id . "'");
 $donde_esta_c= tep_db_fetch_array($donde_esta_c_values);




                  if ($featured_products_array[$i]['shortdescription'] != '') {

  } else {
   $bah = explode(" ", $factura_products['products_name']);
   for($desc=0 ; $desc<8 ; $desc++)
      {
      echo "$bah[$desc] ";
      }
      echo '...'.$donde_esta_c['donde_esta'];
  }



 ?>








                  </td>
                </tr>
              </table>

               <?php   } ?>

              </td>
              <td width="13%" height="305" valign="top" style="font-family: Verdana; font-size: 8pt">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 8pt" bordercolor="#111111" width="100%">
                <tr>
                  <td width="100%">
                  <p align="center">


                                <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "'");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>






                   <p style="margin-top: 0; margin-bottom: 0"><?php echo $currencies->format($factura_products['final_price']);?>  </p>





                     <?php   } ?>









                  </td>
                </tr>
              </table>
              </td>
              <td width="6%" height="305" valign="top" style="font-family: Verdana; font-size: 8pt">


                            <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "'");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>

              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 8pt" bordercolor="#111111" width="100%">
                <tr>
                  <td width="100%">
                  <p align="center">





                  <?php echo $factura_products['products_quantity'] ?>












                  </td>
                </tr>
              </table>
               <?php   } ?>
              </td>
              <td width="11%" height="305" valign="top" style="font-family: Verdana; font-size: 8pt">
                      <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "'");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 8pt" bordercolor="#111111" width="100%">
                <tr>
                  <td width="100%"><?php ECHO TIPO_IMPUESTO ?></td>
                </tr>
              </table>
                     <?php   } ?>
              </td>
              <td width="21%" height="305" valign="top" style="font-family: Verdana; font-size: 8pt">
                                         <?php
          $factura_products_values = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $factura_orders['orders_id'] . "'");
         while      ($factura_products = tep_db_fetch_array($factura_products_values)) {  ?>

              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 8pt" bordercolor="#111111" width="89%">
                <tr>
                  <td width="100%">
                  <p align="right">




                  <?php echo $currencies->format($factura_products['final_price']*$factura_products['products_quantity']);?>







                  </td>
                </tr>




              </table>
              <?php   } ?>
                              </td>
            </tr>




          </table>

          </td>
        </tr>
        <tr>
          <td width="100%" height="44">




          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="62%">&nbsp;</td>
              <td width="38%">
              <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%" height="48">
                <tr>
                  <td width="100%" height="48" valign="top">
                  <p style="margin-top: 0; margin-bottom: 0" align="left">
                  <?php ECHO TEXT_SUBTOTAL_FACTURA_M ?></p>
                  <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                  <p style="margin-top: 0; margin-bottom: 0" align="right">
                  <?php echo $factura_subtotal['text'] ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="19">
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
            <tr>
              <td width="62%">&nbsp;</td>
              <td width="38%">
              <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%" height="48">
                <tr>
                  <td width="100%" height="48">
                  <p style="margin-top: 0; margin-bottom: 0" align="left"><?php ECHO TEXT_GASTOS_DE_ENVIO_M ?></p>
                  <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                  <p style="margin-top: 0; margin-bottom: 0" align="right">
                  <?php echo $factura_shipping['text'] ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="18">
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="50">
            <tr>
              <td width="62%" height="50">&nbsp;</td>
              <td width="38%" height="50">
              <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: Verdana; font-size: 10pt" bordercolor="#111111" width="100%">
                <tr>
                  <td width="100%">
                  <p style="margin-top: 0; margin-bottom: 0" align="left"><?php ECHO TEXT_TOTAL_FACTURA_M ?></p>
                  <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
                  <p style="margin-top: 0; margin-bottom: 0" align="right">
                  <?php echo $factura_total['text'] ?></td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="19">&nbsp;</td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
  </center>
</div>


<p align="center">.</p>
 <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>










</body>

</html>

     <?php






                             }



 ?>

