<?php
/*
  $Id: my_points.php, V2.1rc2a 2008/OCT/01 17:41:03 dsa_ Exp $
  created by Ben Zukrel, Deep Silver Accessories
  http://www.deep-silver.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/
define('NAVBAR_TITLE', 'Información de Credito o Abono');

define('HEADING_TITLE', 'My información de Credito o Abono');

define('HEADING_ORDER_DATE', 'Fecha');
define('HEADING_ORDERS_NUMBER', 'Pedido No. & Status');
define('HEADING_ORDERS_STATUS', 'Pedido Status');
define('HEADING_POINTS_COMMENT', 'Comentarios');
define('HEADING_POINTS_STATUS', 'Credito Status');
define('HEADING_POINTS_TOTAL', 'Credito');

define('TEXT_DEFAULT_COMMENT', 'Shopping Points');
define('TEXT_DEFAULT_REDEEMED', 'BitShop Canjeados');

define('TEXT_DEFAULT_REFERRAL', 'Referral Points');
define('TEXT_DEFAULT_REVIEWS', 'Review Points');

define('TEXT_ORDER_HISTORY', 'View details for order no.');
define('TEXT_REVIEW_HISTORY', 'Show this Review.');

define('TEXT_ORDER_ADMINISTATION', '---');
define('TEXT_STATUS_ADMINISTATION', '-----------');

define('TEXT_POINTS_PENDING', 'Pendiente');
define('TEXT_POINTS_PROCESSING', 'Procesando');
define('TEXT_POINTS_CONFIRMED', 'Confirmado');
define('TEXT_POINTS_CANCELLED', 'Cancelado');
define('TEXT_POINTS_REDEEMED', 'Canjeado');

define('MY_POINTS_EXPIRE', 'Expira en: ');
define('MY_POINTS_CURRENT_BALANCE', '<b>Balanza de Credito :</b> %s Credito. <b>Valorado en :</b> %s .');

define('MY_POINTS_HELP_LINK', ' Por favor chequee aqui <a href="' . tep_href_link(FILENAME_MY_POINTS_HELP) . '" title="Reward Point Program FAQ"><u>Ayuda</u></a> Programa de BitShop FAQ entrar para más información.');

define('TEXT_NO_PURCHASES', 'You have not yet made any purchases, and you don\'t have points yet');
define('TEXT_NO_POINTS', 'You don\'t have Qualified Points yet.');

define('TEXT_DISPLAY_NUMBER_OF_RECORDS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> points records)');
?>
