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


  if ($pro_ale <= 11){


   $banner_values = mysql_query("select * from " . 'affiliate_compartir_empresas' . " where aut = '" . 1 . "'   ORDER BY RAND() LIMIT 1");
   if ($banner = mysql_fetch_array($banner_values)){






 $empresa_banner = $banner['url_empresa_catalog'].$banner['numero_productos'];

  }else{

   $empresa_banner = 'affiliate_banners_products.php?pro_ale=5';
}

  }



            $z .= '<p style="margin-top: 0; margin-bottom: 0"><b>'.'MERKAPLACE'.'</b></p>';

    $tiendas_values = mysql_query("select * from " . 'affiliate_compartir_empresas' . " where aut = '" .  1 . "'");
   while ($tiendas = mysql_fetch_array($tiendas_values)){
 $z .= '<p style="margin-top: 0; margin-bottom: 0"><b><a href="'.$tiendas['url_web'].'">'.$tiendas['nombre_sector'].'->>'.$tiendas['nombre'].'</a></b></p>';

           }

       echo '1';




              
              
              
              
	  $infobox = new azInfoBox();
      $infobox->azSetBoxHeading(MODULE_BOXES_EMPRESABANNER_BOX_TITLE);
      $infobox->azSetBoxContent(' <td class="smallText" align="center"><br><script language="javascript" src="'.$empresa_banner.'"> </script>'.$z.'</td>' . '</a><br />');
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