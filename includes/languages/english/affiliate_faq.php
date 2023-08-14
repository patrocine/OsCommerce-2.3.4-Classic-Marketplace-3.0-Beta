<?php
/*
  $Id: osCAffiliate 20-Nov-2014
  OSC-Affiliate for osCommerce 2.3xx family
  Contribution based on: http://addons.oscommerce.com/info/158
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 - 2014 osCommerce
  Released under the GNU General Public License
  Updated by Fimble (http://forums.oscommerce.com/user/15542-fimble/)
  http://www.linuxuk.co.uk
*/
define('NAVBAR_TITLE', 'Programa de Afiliados - Preguntas Frecuentes');
define('HEADING_TITLE', 'Programa de Afiliados - Preguntas Frecuentes');
define('BOX_AFFILIATE_CONTACT', ' contact us ');


 if (AFFILIATE_OPTION == 'true'){

  $text_option = 'Cuando un cliente se registre con tu link de referidos tu id de afiliado queda vinculado con el del cliente y cada vez que este realice una compra se te sumara la comisión en tu zona de ventas, cuando los pedidos esten en pagado estarán preparados para el proximo cierre..';
    $perpetuo =' Cliente Permanente Activado';
}else{
    $text_option = 'Cuando un cliente ae registra y hace un pedido dentro del tiempo que esta activo el referido conseguirás la comisión, con este metodo perderás la comisión si el cliente no compra en el momento.';
    $perpetuo =' Cliente Ocasional Activado';
}


define('TEXT_INFORMATION', '' . STORE_NAME . ' ha compilado esta información para que pueda estar mejor informado sobre nuestro programa de afiliados.
Si tiene alguna pregunta, póngase en contacto con nosotros para obtener más información.<br />


<a name="0"> 
<ul>
<li><a href="' . tep_href_link('affiliate_faq.php') . '#1">Cuando se cobran las comisiones?</a>
<li><a href="' . tep_href_link('affiliate_faq.php') . '#2">Como se calculan las comisiones? ' . $perpetuo . '</a>
<li><a href="' . tep_href_link('affiliate_faq.php') . '#3">Como invito a mis a migos y familiares con mi referido?</a>
<li><a href="' . tep_href_link('affiliate_faq.php') . '#4">Cuanto es la Comisión de ' . STORE_NAME . ' ?</a>
<li><a href="' . tep_href_link('affiliate_faq.php') . '#5">Desde que se generá la comision cuanto tiempo tengo que esperar para cobrarla?</a>
<li><a href="' . tep_href_link('affiliate_faq.php') . '#6">De cuanto tiene que ser el importe minimo para cerrar los pagos?</a>
<li><a href="' . tep_href_link('affiliate_faq.php') . '#7">Como recibo mis pagos?</a>

</ul>
<hr width ="90%">
<br />
<FONT COLOR="#000000" size="4"><B><U>Preguntas y Respuestas</U></B></FONT>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Cuando se cobran las comisiones?</font><a name="1"></a><br />

Las comisiones se van acumulando y cuando la empresa realice el cierre todos los pedidos que estan pagados ´se creará una orden única de pagos que podrás ver en la zona de pagos, no olvides configurar tus datos de pago para que la empresa pueda hacerte el ingreso.

</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . tep_href_link('affiliate_faq.php') . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Como se calculan las comisiones? ' . $perpetuo . '</font><a name="2"></a><br />



 ' . $text_option . '</p>

<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . tep_href_link('affiliate_faq.php') . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Como invito a mis a migos y familiares con mi referido?</font><a name="3"></a><br />

En tu panel de afiliado, dirigete a la zona de referidos y podrás copiar y enviar el link de referidos o usar el qr para que un amigo pueda escanearla desde tu movil.


</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . tep_href_link('affiliate_faq.php') . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Cuanto es la Comisión de ' . STORE_NAME . ' ?</font><a name="4"></a><br />
El porcentage es de  ' . AFFILIATE_PERCENT . '% por cada venta.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . tep_href_link('affiliate_faq.php') . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Desde que se generá la comision cuanto tiempo tengo que esperar para cobrarla?</font><a name="5"></a><br />
Desde que se genera la comision tienen que pasar ' . AFFILIATE_BILLING_TIME . ' Dia/s.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . tep_href_link('affiliate_faq.php') . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">De cuanto tiene que ser el importe minimo para cerrar los pagos?</font><a name="6"></a><br />
Tienen que acumularse '.AFFILIATE_THRESHOLD.'Eur para cerrar el pago mensual.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><a href="' . tep_href_link('affiliate_faq.php') . '#0">top</a></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Como recibo mis pagos?</font><a name="7"></a><br />
Paypal, Transferencia Bancaria, o Dinero Digital Busd, Usdt, Usdc</p>
');
?>
