<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr>
<?php
  if (isset($currencies) && is_object($currencies)) {

    reset($currencies->currencies);
    $currencies_array = array();
    while (list($key, $value) = each($currencies->currencies)) {
      $currencies_array[] = array('id' => $key, 'text' => $value['title']);
    }

    $hidden_get_variables = '';
    reset($HTTP_GET_VARS);
    while (list($key, $value) = each($HTTP_GET_VARS)) {
      if ( ($key != 'currency') && ($key != tep_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= tep_draw_hidden_field($key, $value);
      }
    }

    $info_box_contents = '<td height="24" valign="middle" align="left">'.tep_draw_form('az_currencies', tep_href_link(basename($PHP_SELF), '', $request_type, false), 'get').'<div>'.tep_draw_pull_down_menu('currency', $currencies_array, $currency, 'onchange="this.form.submit();" class="vertical currencies_list"') . $hidden_get_variables . tep_hide_session_id().'</div></form></td>';





    echo $info_box_contents;
?>
<!-- currencies_eof //-->
<?php
  }
?>
</tr></table>