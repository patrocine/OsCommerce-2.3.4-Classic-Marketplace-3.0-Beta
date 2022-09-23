<?php
/*
  $Id: shopping_cart.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- shopping_cart //-->
<?php  
  $cart_contents_string  = '<table cellspacing="0" cellpadding="0" border="0" align="center"><tr>';
  //$cart_contents_string .= '<td><a href="'. $tmpl['url']['cart'] .'">'.az_image(TMPL_IMAGES.'az_cart_icon.png') . '</a></td>';
  $cart_contents_string .= '<td id="az_shoppingcart" align="right"><span class="az_cartTitle">' . AZ_HEADER_SHOPPING_CART . '</span> '.sprintf(AZ_HEADER_NOW_IN_CART, $cart->count_contents()).'<span class="az_cartPrice">' . $currencies->format($cart->show_total()) . '</span></td>';
  $cart_contents_string .= '</tr></table>';

  $infobox = new azInfoBox();
  $infobox->azSetBoxContent($cart_contents_string);
  $infobox->azCreateBox('topBox');
?>
<!-- shopping_cart_eof //-->
