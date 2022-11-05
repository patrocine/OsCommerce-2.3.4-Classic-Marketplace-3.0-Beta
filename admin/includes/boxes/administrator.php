<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
                                   admin_files.php
  Copyright (c) 2010 osCommerce
                                      define_checkout_confirmation.php
  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_ADMINISTRATOR,
    'apps' => array(
      array(
        'code' => FILENAME_ADMIN_MEMBERS,
        'title' => BOX_ADMINISTRATOR_MEMBERS,
        'link' => tep_href_link(FILENAME_ADMIN_MEMBERS)
      ),
      array(
        'code' => 'admin_members.php?gID=groups',
        'title' => 'Grupos Admin',
        'link' => tep_href_link('admin_members.php?gID=groups')
      ),
      array(
        'code' => 'admin_files.php',
        'title' => 'Grupos Archivos',
        'link' => tep_href_link('admin_files.php')
      ),
      array(
        'code' => 'donde_esta_tiendas.php',
        'title' => 'Donde Esta',
        'link' => tep_href_link('donde_esta_tiendas.php')
      ),
      array(
        'code' => 'define_mainpage.php',
        'title' => 'Pagina Principal',
        'link' => tep_href_link('define_mainpage.php')
      ),
      array(
        'code' => 'define_checkout_confirmation.php',
        'title' => 'Mensaje Confirmación de pedido',
        'link' => tep_href_link('define_checkout_confirmation.php')
      ),
      array(
        'code' => 'define_conditions.php',
        'title' => 'Condiciones de Uso',
        'link' => tep_href_link('define_conditions.php')
      ),
      array(
        'code' => 'define_shipping.php',
        'title' => 'Condiciones y Protocolo',
        'link' => tep_href_link('define_shipping.php')
      ),
        array(
        'code' => 'define_devoluciones.php',
        'title' => 'Envios y Devoluciones',
        'link' => tep_href_link('define_devoluciones.php')
      ),
        array(
        'code' => 'conceptos_balances_ventas.php',
        'title' => 'Balances de Ventas',
        'link' => tep_href_link('conceptos_balances_ventas.php')
       ),
      array(
        'code' => 'configuracion_productos.php',
        'title' => 'Mantenimiento Catalogos',
        'link' => tep_href_link('configuracion_productos.php')
       ),
   )
  );
?>
