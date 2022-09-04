<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

  if (!defined('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_STATUS')) {
    define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION', '<div align="center"><a href=' . tep_href_link('ext/modules/payment/sofortueberweisung/install.php', 'install=sofortueberweisung_direct', 'SSL') . '>' . tep_image('ext/modules/payment/sofortueberweisung/autoinstaller.gif', 'Autoinstaller (recomendado)') . '</a></div><br><img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.sofortueberweisung.de/cms/index.php?vpartner=21" target="_blank" style="text-decoration: underline; font-weight: bold;">Visite la web de Sofortüberweisung</a>&nbsp;<a href="javascript:toggleDivBlock(\'sofortueberweisungInfo\');">(info)</a><span id="sofortueberweisungInfo" style="display: none;"><br><i>Con el uso del link para usar Sofortüberweisung osCommerce da a cada cliente otra opcion mas de pago.</i></span><br><br>Numero de cuenta para pruebas:<br><br>BLZ#: 88888888');
  } else {
    define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.sofortueberweisung.de/cms/index.php?vpartner=21" target="_blank" style="text-decoration: underline; font-weight: bold;">Visite la web de Sofortüberweisung</a>&nbsp;<a href="javascript:toggleDivBlock(\'sofortueberweisungInfo\');">(info)</a><span id="sofortueberweisungInfo" style="display: none;"><br><i>	Con el uso del link para usar Sofortüberweisung osCommerce da a cada cliente otra opcion mas de pago.</i></span><br><br>Numero de cuenta para pruebas:<br><br>BLZ#: 88888888');
  }

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_TITLE', 'Sofortüberweisung Direkt');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_PUBLIC_TITLE', 'Sofortüberweisung');

  // checkout_payment Informationen via Bild
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION_CHECKOUT_PAYMENT', '
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="#" onclick="window.open(\'https://www.sofortueberweisung.de/cms/index.php?vpartner=21\', \'Popup\',\'toolbar=yes,status=no,menubar=no,scrollbars=yes,width=690,height=500\'); return false;">' . tep_image('ext/modules/payment/sofortueberweisung/images/sofortueberweisung.gif', 'Sofortüberweisung es una certificacion TÜV de los servicios Payment Network AG. Sus beneficios: no es necesario el registro adicional, la transferencia a su cuenta bancaria online es automatica, los mas altos estandares de seguridad y la entrega inmediata de los bienes. Para el pago a traves de Sofortüberweisung sera necesario el acceso del usuario a la banca electronica, es decir, banco, numero de cuenta, PIN y TAN.') . '</a></td>
      </tr>
    </table>');

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_DESCRIPTION_CHECKOUT_CONFIRMATION', '
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="main"><p>Despues de confirmar el pedido se le redirige al sistema de pago Sofortüberweisung donde puede realizar una transferencia online.</p><p>Usted tendra acceso a la banca electronica, es decir, banco, numero de cuenta, PIN y TAN. Mas informacion aqui: <a href="#" onclick="window.open(\'https://www.sofortueberweisung.de/cms/index.php?vpartner=21\', \'Popup\',\'toolbar=yes,status=no,menubar=no,scrollbars=yes,width=690,height=500\'); return false;">http://www.sofortueberweisung.de</a>.</p></td>
      </tr>
    </table>');

 // im Verwendungszweck werden folgende Platzhalter ersetzt:
 // {{order_date}} durch Bestelldatum
 // {{customer_id}} durch Kundennummer der Datenbank
 // {{customer_name}}  durch Kundenname
 // {{customer_company}} durch Kundenfirma
 // {{customer_email}} durch Email des Kunden

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_V_ZWECK_1', STORE_NAME);  // max 27 caracteres
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_V_ZWECK_2', 'Pedido nº {{orderid}} ID cliente: {{customer_id}}'); // max 27 caracteres
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_EMAIL_FOOTER', '');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_REDIRECT', 'Usted sera redirigido a sofortueberweisung.de. Si esto no sucede, pulse el boton.');

  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_ERROR_HEADING', 'El siguiente error fue reportado por Sofortüberweisungs durante el proceso:');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_ERROR_MESSAGE', 'El pago via Sofortüberweisung no es posible o lo ha cancelado el cliente, elija otra forma de pago.');
  define('MODULE_PAYMENT_SOFORTUEBERWEISUNG_DIRECT_TEXT_CHECK_ERROR', 'Error en la operacion de verificacion Sofortüberweisungs, compruebe manualmente');
?>
