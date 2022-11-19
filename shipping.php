<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHIPPING);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHIPPING));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo 'ENVIOS Y DEVOLUCIONES'; ?></h1>

<div class="contentContainer">
  <div class="contentText">
   <?php include(DIR_WS_LANGUAGES . $language . '/' . 'define_devoluciones.php'); ?>
  </div>


<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
