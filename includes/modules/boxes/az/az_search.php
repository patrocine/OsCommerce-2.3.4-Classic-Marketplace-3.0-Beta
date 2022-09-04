<?php
  $search_string .= '<div class="form_bg">';
  $search_string .= tep_draw_input_field('keywords', AZ_SEARCH_KEYWORD, ' class="search_bg" onfocus="if(this.value == \''.AZ_SEARCH_KEYWORD.'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.AZ_SEARCH_KEYWORD.'\';}"') . '&nbsp;' . tep_hide_session_id() .'';
  $search_string .= '</div>';
  $search_string .= '<div class="az_go">';
  $search_string .= '<input name="search" value="" class="go_button" type="submit"/>';
  $search_string .= '</div>';
  
  $info_box_contents = tep_draw_form('az_quick_find', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get').$search_string.'</form>
  ';
  echo $info_box_contents;
?>
