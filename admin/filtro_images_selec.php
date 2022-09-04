<?php
/*
  $Id: stats_products_viewed.php,v 1.29 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  
  
  
?>
<?php     require(DIR_WS_INCLUDES . 'template_top.php');
?>


                       <?php
                       
     if ($login_id_remoto){
               $log_id = $login_id_remoto;
 }else{
              $log_id = $login_id;
}
                       
                       


   $admin_values = mysql_query("select * from " . 'admin' . " where admin_id = '" . $log_id . "'");
   $admin_c = mysql_fetch_array($admin_values);


                     ?>






    <form name="form1" method="get" action="<?php echo HTTP_SERVER.DIR_WS_CATALOG.'images.php'; ?>">
    
    <?php






      $status_procesando_array = array(array('id' => '0', 'text' => 'Seleccionar'));
        $status_procesando_query = tep_db_query("select * from " . 'proveedor' . "");
        while ($status_procesando = tep_db_fetch_array($status_procesando_query)) {
          $status_procesando_array[] = array('id' => $status_procesando['proveedor_id'],
                                  'text' => $status_procesando['proveedor_name']);
        }
  ECHO     tep_draw_pull_down_menu('proveedor_id', $status_procesando_array, $status_c['proveedor_id']);
  
  
  

      $filtro_array = array(array('id' => '0', 'text' => 'Seleccionar'));
        $filtro_query = tep_db_query("select * from " . 'products' . " group by filtro");
        while ($filtro = tep_db_fetch_array($filtro_query)) {
          $filtro_array[] = array('id' => $filtro['filtro'],
                                  'text' => $filtro['filtro']);
        }
  ECHO     tep_draw_pull_down_menu('filtro', $filtro_array, $status_c['filtro']);


        ?>
    
    
 <p><input type="checkbox" name="imagenes" value="ON">Imagenes</p>
 <p><input type="checkbox" name="extra_imagenes" value="ON">Extra Imagenes</p>
 <p> Comprueba si tenemos las imagenes en el servidor, pero las que no esten también aparecen si eligues todas. </p>
   <p><input type="radio" value="1" name="repetidas">Todas<input type="radio" checked name="repetidas" value="2">Menos las Repetidas</p>
  
  <p> Comprueba si tenemos las imagenes en el servidor, Ponga no si el proceso se eterniza. </p>
  <p><input type="radio" value="1" checked name="modelo">Comprobar SI<input type="radio" name="modelo" value="2">Comprobar NO</p>
</p>
  <p>
    <input type="submit" name="Submit" value="Cambiar">
</p>
</form>







<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
