<?php
/*
  $Id: information.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- information //-->
<?php
  $newline = array("<br>", "<br />", "<br/>");
  $info_text = '<ul><li><a href="' . tep_href_link(FILENAME_SHIPPING) . '">' . MENU_TEXT_SHIPPING_RETURNS . '</a></li>' . 
               '<li class="az_footer_menu_sep"></li>' . 
			   '<li><a href="' . tep_href_link(FILENAME_PRIVACY) . '">' . MENU_TEXT_PRIVACY . '</a></li>' . 
			   '<li class="az_footer_menu_sep"></li>' . 
               '<li><a href="' . tep_href_link(FILENAME_CONDITIONS) . '">' . MENU_TEXT_CONDITION_OF_USE . '</a></li></ul>';
  echo $info_text;
?>
<!-- information_eof //-->
