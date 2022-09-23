<?php
/*
  $Id: search.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- search //-->
<?php    
  $search_string = tep_draw_form('quick_find', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get');
  $search_string .= '<div style="padding-bottom:6px;">';
  $search_string .= '<a class="az_search_advance" href="' . tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL') . '">' . AZ_SIGN_UP_TEXT . ' &gt;</a>';
  $search_string .= '<a class="az_search_advance" style="margin-left:30px;" href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '">' . AZ_ADVANCED_SEARCH_TEXT . ' &gt;</a>';
  $search_string .= '</div>';
  $search_string .= '<table border="0" align="center" cellpadding="0" cellspacing="0"><tr>';
  $search_string .= '<td>' . AZ_BOX_HEADING_SEARCH . '</td>';
  $search_string .= '<td style="padding-left:12px;">';
  $search_string .= '<div id="az_search_box_l"><div id="az_search_box_r"><div id="az_search_box_m">';
  $search_string .= tep_draw_input_field('keywords', AZ_SEARCH_KEYWORD, 'size="20" maxlength="30" onfocus="if(this.value == \''.AZ_SEARCH_KEYWORD.'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.AZ_SEARCH_KEYWORD.'\';}"') . tep_hide_session_id();
  $search_string .= '</div></div></div>';
  $search_string .= '</td>';
  $search_string .= '<td align="right">';
  $search_string .= '<input id="az_search_button" type="submit" name="' . AZ_BUTTON_SEARCH . '" value="&gt;" title="' . AZ_BUTTON_SEARCH . '" />';
  $search_string .= '</td>';
  $search_string .= '</tr></table>';
  $search_string .= '</form>';
  
  $infobox = new azInfoBox();
  $infobox->azSetBoxContent($search_string);
  $infobox->azCreateBox('topBox');
?>
<!-- search_eof //-->
