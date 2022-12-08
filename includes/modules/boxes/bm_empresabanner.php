<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_empresabanner {
    var $code = 'bm_empresabanner';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_empresabanner() {
      $this->title = MODULE_BOXES_EMPRESABANNER_TITLE;
      $this->description = MODULE_BOXES_EMPRESABANNER_DESCRIPTION;

      if ( defined('MODULE_BOXES_EMPRESABANNER_STATUS') ) {
        $this->sort_order = MODULE_BOXES_EMPRESABANNER_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_EMPRESABANNER_STATUS == 'True');

        $this->group = ((MODULE_BOXES_EMPRESABANNER_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }




    function execute() {
      global $oscTemplate;





   $registros_values = tep_db_query("select * from " . 'products_compartir' . " where activo = '" . 3 . "'");
                    while  ($registros = tep_db_fetch_array($registros_values)){



            ?>
<?php  $f .='<table border="0" width="100%">' ;?>
<?php  $f .='<tr>' ;?>
<?php  $f .='<td width="194"><a href=' .  $registros['ruta_url'] . '>';?>
<?php  $f .='<img src="' .  $registros['ruta_url'] . 'images/store_logo.png"' . 'width="160" height=""></a></td>';?>
<?php  $f .='<tr><td>&nbsp;</td></tr></tr></tr></table>' ;?>





   <?php

      }


$f .='</p>';






  if ($pro_ale <= 11){


   $banner_values = tep_db_query("select * from " . 'affiliate_compartir_empresas' . " where aut = '" . 1 . "'   ORDER BY RAND() LIMIT 1");
   if ($banner = tep_db_fetch_array($banner_values)){






 $empresa_banner = $banner['url_empresa_catalog'].$banner['numero_productos'];

  }else{

   $empresa_banner = 'affiliate_banners_products.php?pro_ale=5';
}

  }




    $tiendas_values = tep_db_query("select * from " . 'affiliate_compartir_empresas' . " where aut = '" .  1 . "' order by nombre_sector asc");
   while ($tiendas = tep_db_fetch_array($tiendas_values)){
                     if ($tiendas['url_affiliate']){

          }else{
        $tiendas['url_affiliate'] = $tiendas['url_web'];

      }

       ?>
       
       
<?php  $a .='<hr size="15" noshade color="#000000">' ;?>


<?php  $a .='<tr>' ;?>
<?php  $a .='<td colspan="2">'; ?>
<?php  $a .='  <p align="center"><b><font size="4">'. '<a href="'.$tiendas['url_affiliate'] .'"><img border="0" src="'.$tiendas['url_web'] .'/images/store_logo.png'.'" width="120" height="">' .'</a></font></b></td>'; ?>
<?php  $a .='</tr>'; ?>
<?php  $a .='<tr>'; ?>
<?php  $a .='<td width="100%" colspan="2">'; ?>
<?php  $a .='<p align="center"><b><font size="4">'. $tiendas['nombre'].'</font></b></td></p>' ;?>
<?php  $a .='</tr>' ;?>
<?php  $a .='<tr>'; ?>
<?php  $a .='<td width="6%"><b>Empresa:</b></td>' ;?>
<?php  $a .='<td width="94%"><b>&nbsp;'.$tiendas['nombre_sector'].'</b></td></p>'; ?>
<?php  $a .='</tr>'; ?>
<?php  $a .='<tr>' ;?>
<?php  $a .='<td colspan="2">'; ?>
<?php  $a .='<p align="center"><b>Ubicación: '.$tiendas['nombre_ciudad'].'</b></td></p>' ?>
<?php  $a .='</tr>' ?>
<?php  $a .='<tr>' ?>
<?php  $a .='<td colspan="2">' ?>
<?php  $a .='	<p align="right"><b><a href="'.$tiendas['url_affiliate'] .'"><font size="3">Visitar Marketplace-&gt;&gt;</font></a></b></td>' ?>
<?php  $a .='</tr>' ?>
<?php  $a .='</tr>' ?>

















       

 <?php



     }
     
     
     
    $tiendas_values = tep_db_query("select * from " . 'affiliate_compartir_empresas' . " where id_banners = '" .  $banner['id_banners'] . "'");
   if ($tiendas = tep_db_fetch_array($tiendas_values)){

               if ($tiendas['url_affiliate']){

          }else{
        $tiendas['url_affiliate'] = $tiendas['url_web'];

      }
       ?>


<?php  $b .='<hr size="15" noshade color="#000000">' ;?>


<?php  $b .='<tr>' ;?>
<?php  $b .='<td colspan="2">'; ?>
<?php  $b .='  <p align="center"><b><font size="4">'. '<a href="'.$tiendas['url_affiliate'] .'"><img border="0" src="'.$tiendas['url_web'] .'/images/store_logo.png'.'" width="120" height="">' .'</a></font></b></td>'; ?>
<?php  $b .='</tr>'; ?>
<?php  $b .='<tr>'; ?>
<?php  $b .='<td width="100%" colspan="2">'; ?>
<?php  $b .='<p align="center"><b><font size="4">'. $tiendas['nombre'].'</font></b></td></p>' ;?>
<?php  $b .='</tr>' ;?>
<?php  $b .='<tr>'; ?>
<?php  $b .='<td width="6%"><b>Empresa:</b></td>' ;?>
<?php  $b .='<td width="94%"><b>&nbsp;'.$tiendas['nombre_sector'].'</b></td></p>'; ?>
<?php  $b .='</tr>'; ?>
<?php  $b .='<tr>' ;?>
<?php  $b .='<td colspan="2">'; ?>
<?php  $b .='<p align="center"><b>Ubicación: '.$tiendas['nombre_ciudad'].'</b></td></p>' ?>
<?php  $b .='</tr>' ?>
<?php  $b .='<tr>' ?>
<?php  $b .='<td colspan="2">' ?>
<?php  $b .='	<p align="right"><b><a href="'.$tiendas['url_affiliate'] .'"><font size="3">Visitar Marketplace-&gt;&gt;</font></a></b></td>' ?>
<?php  $b .='</tr>' ?>
<?php  $b .='</tr>' ?>



















 <?php



     }

     
     
     
     


              
	  $infobox = new azInfoBox();
      $infobox->azSetBoxHeading($f.'<a href="https://oscommerce.com"><img src="images/logo_oscommerce.png"></a>' .
      '<p><b><a href="https://github.com/patrocine/OsCommerce-2.3.4-Classic-Empresa-3.0-Beta"><font size="2">Descargar Tienda</a></font></b> <img border="0" src="'.'https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png'.'" width="30" height="">'   .
      '<p><b><font size="2">MARKETPLACE ' . NOMBRE_SECTOR . ' en ' . NOMBRE_CIUDAD_TIENDA . '</font></b></p> ');
      $infobox->azSetBoxContent(' '.$b.'<td class="smallText" align="center"><br><script language="javascript" src="'.$empresa_banner.'"> </script></td>' . '</a><br />');
      $infobox->azSetBoxFooter();
      $data = $infobox->azCreateBox('', '', '', '', false);
              
              

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_EMPRESABANNER_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable empresabanner Module', 'MODULE_BOXES_EMPRESABANNER_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_EMPRESABANNER_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_EMPRESABANNER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_EMPRESABANNER_STATUS', 'MODULE_BOXES_EMPRESABANNER_CONTENT_PLACEMENT', 'MODULE_BOXES_EMPRESABANNER_SORT_ORDER');
    }
  }
?>
