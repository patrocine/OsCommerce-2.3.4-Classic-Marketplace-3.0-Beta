<?php
require_once('mobile/includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_ADVANCED_SEARCH));
$navigation->set_snapshot();

  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  $manufacturers_array = array();
  $manufacturers_array[] = array('id' => '', 'text' => PULL_DOWN_DEFAULT);

  while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);
        $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                       'text' => $manufacturers_name);
   }

      $info_box_contents = array();
      $info_box_contents[] = array('form' => tep_draw_form('manufacturers', tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false), 'get'),
                                   'text' => tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, (isset($HTTP_GET_VARS['manufacturers_id']) ? $HTTP_GET_VARS['manufacturers_id'] : ''), 'onChange="this.form.submit();" size="' . MAX_MANUFACTURERS_LIST . '" style="width: 100%"') . tep_hide_session_id());
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write(NAVBAR_TITLE_1);
?>
<div id="iphone_content">
<!-- search //-->
<?php
  if ($messageStack->size('search') > 0) {
?>
<div id="messageStack">
<?php echo $messageStack->output('search'); ?></td>
</div>
<?php
  }
?>

<?php echo tep_draw_form('quick_find', tep_mobile_link(FILENAME_ADVANCED_SEARCH_RESULT, $keywords=$keywords, 'NONSSL', false)) ?>
<div id="cms">
	<table width="100%" cellpadding="0" cellspacing="5"  style="margin-left:3%";>
 <div id="bouton"><input type="submit" value="<?php echo IMAGE_BUTTON_SEARCH; ?>"></div>
 	<tr>
 		<td><?php echo TEXT_KEYWORDS.':'; ?></td>
 		<td><?php echo tep_draw_input_field('keywords', '', 'results="10" style="width:150px;"', 'search'); ?> </td>
 	</tr>
 	<?php
	if(sizeof($manufacturers_array) > 1 && SHOW_MANUFACTURERS_SEARCH_MENU == 'true') {
		?>
		<tr>
			<td><?php echo BOX_HEADING_MANUFACTURERS.':'; ?></td>
			<td><?php echo tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, (isset($HTTP_GET_VARS['manufacturers_id']) ? $HTTP_GET_VARS['manufacturers_id'] : ''), '') . tep_hide_session_id(); ?> </td>
		</tr>
		<?php
	}
	if(SHOW_CATEGORIES_SEARCH_MENU == 'true') {
		?>
		<tr>
			<td><?php echo ENTRY_CATEGORIES; ?> </td>
			<td><?php echo tep_draw_pull_down_menu('categories_id', tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES))), '') . tep_hide_session_id(); ?> </td> 
		</tr>
		<tr>
			<td><?php echo ENTRY_INCLUDE_SUBCATEGORIES.':'; ?> </td>
			<td><?php echo tep_draw_checkbox_field('inc_subcat', '1', true) . tep_hide_session_id(); ?> </td>
		</tr>
		<?php
	}

	if(SHOW_SEARCH_BY_PRICE_RANGE == 'true') {
		?>
		<tr>
			<td><?php echo ENTRY_PRICE_FROM; ?> </td>
			<td><?php echo tep_draw_input_field('pfrom'); ?> </td>
		</tr>
		<tr>
			<td><?php echo ENTRY_PRICE_TO; ?> </td>
			<td><?php echo tep_draw_input_field('pto'); ?> </td>
		</tr>
		<?php
	}

	if(SHOW_SEARCH_BY_DATE_RANGE == 'true') {
		?>
		<tr>
		<td><?php echo ENTRY_DATE_FROM; ?> </td>
		<td><?php echo tep_draw_input_field('dfrom', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"'); ?> </td>
		</tr>
		<tr>
		<td><?php echo ENTRY_DATE_TO; ?> </td>
		<td><?php echo tep_draw_input_field('dto', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"'); ?> </td>
		</tr>
		<?php
	}
?>
 </table>
 <div id="bouton"><input type="submit" value="<?php echo IMAGE_BUTTON_SEARCH; ?>"></div>
	</div>
</form>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
