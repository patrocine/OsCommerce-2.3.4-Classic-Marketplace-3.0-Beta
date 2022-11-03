<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
                                                                            http://www.empresa30.es/admin/create_order_tienda.php
  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2">

        <?php
        
                     $permiso_boxes = $_GET['permiso_boxes'];
                     $aut_permiso_boxes = $_GET['aut_permiso_boxes'];

                if ($aut_permiso_boxes){
        
                      $sql_status_update_array = array('admin_boxes' => $permiso_boxes,        );

             tep_db_perform('administrators', $sql_status_update_array, 'update', " admin_id= '" . $login_id . "'");

                                    }
       ?>
        
        





 </td>


  </tr>
  <tr class="headerBar">
    <td class="headerBarContent">&nbsp;&nbsp;
               <?php

              $permiso_boxes_values = tep_db_query("select * from " . 'administrators' . " where admin_id = '" . $login_id . "' and admin_boxes = '" . 1 . "'");
             if ($permiso_boxes = tep_db_fetch_array($permiso_boxes_values)){
          ?>

 <a href="orders_tienda.php?permiso_boxes=0&aut_permiso_boxes=ok">Menú OFF</a>

              <?php


      }else{

          ?>
 | <a href="orders_tienda.php?permiso_boxes=1&aut_permiso_boxes=ok">Menú ON</a>


              <?php
          }

            ?>



| <a href="index.php">Principal</a>
 | <a href="orders_tienda.php">Listar Pedidos</a>
 | <a href="create_order_tienda.php">Crear Pedido</a>
 | <a href="conceptos_balances_ventas.php">Balances</a>
 | <a href="conceptos_stock.php">Pendiente de Servir</a>
 | <a href="conceptos_stock_min.php">Stock Recomendado</a>
 | <a href="easypopulate.php">Actualizar Catalogos</a>
 | <a href="quick_cliente.php">Modificar Productos</a>
 | <a href="customers_points_pending.php">Programa de Puntos</a>
 | <a href="coupons.php">Cupones</a>
 | <a href="whos_online.php">Clientes Online</a>
 | <a href="https://www.youtube.com/playlist?list=PLv6_VqQZKB8ZSEhfF9nlTvjpjyDiQKqaE">Tutoriales</a>

 
 <?php
 
 
 
        if (AYUDA_ADMIN == 'true'){
        ECHO '|<a href="'.$_SERVER['PHP_SELF']. '?ayuda_admin_link=true&oID='.$oID. '&action=edit&ayuda_admin_link=admin_ayuda_off'.'">Ayuda off</a>';

    }
 
        if (AYUDA_ADMIN == 'false'){
          ECHO '|<a href="'.$_SERVER['PHP_SELF']. '?ayuda_admin_link=true&oID='.$oID. '&action=edit&ayuda_admin_link=admin_ayuda_on'.'">Ayuda on</a>';

    }

    if ($_GET['ayuda_admin_link'] == 'admin_ayuda_off'){

        
                      $sql_status_update_array = array('configuration_value' => 'false',        );
             tep_db_perform('configuration', $sql_status_update_array, 'update', " configuration_key= '" . 'AYUDA_ADMIN' . "'");

        


                          ?>

                      <script type="text/javascript">

    var pagina = '<?php echo $_SERVER['PHP_SELF'].'?ayuda_admin_link=true&oID='.$oID. '&action=edit' ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

              <?php

                      }
                      
     if ($_GET['ayuda_admin_link']== 'admin_ayuda_on'){
                      
                      
                      $sql_status_update_array = array('configuration_value' => 'true',        );
             tep_db_perform('configuration', $sql_status_update_array, 'update', " configuration_key= '" . 'AYUDA_ADMIN' . "'");


                          ?>

                      <script type="text/javascript">

    var pagina = '<?php echo $_SERVER['PHP_SELF'].'?ayuda_admin_link=true&oID='.$oID. '&action=edit' ?>';
    var segundos = 0;

    function redireccion() {

        document.location.href=pagina;

    }

    setTimeout("redireccion()",segundos);

     </script>

              <?php

                  }


       ?>

  |</p>

</a></td>
    <td class="headerBarContent" align="right"><?php echo (tep_session_is_registered('admin') ? 'Logged in as: ' . $admin['username']  . ' (<a href="' . tep_href_link(FILENAME_LOGIN, 'action=logoff') . '" class="headerLink">Logoff</a>)' : ''); ?>&nbsp;&nbsp;</td>
  </tr>
</table>
