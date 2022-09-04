<?php
require_once('mobile/includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_ADVANCED_SEARCH));
    $navigation->set_snapshot();

// set the link for classic site
$classic_site = 'index.php';

require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write(IMAGE_BUTTON_SEARCH);
?>
<div id="iphone_content">
<!-- search //-->
<?php
  if ($messageStack->size('search') > 0) {
?>
<div id="mobilemessageStack">
<?php echo $messageStack->output('search'); ?></td>
</div>
<?php
  }
?>
<?php echo tep_draw_form('quick_find', tep_mobile_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false)) ?>
<div id="cms">
<table width="100%" cellpadding="0" cellspacing="5"  style="margin-left:3%";>
 	<tr>
 		<td><?php echo TEXT_KEYWORDS . ':'; ?></td>
 		<td><?php echo tep_draw_input_field('keywords', '', 'results="10" style="width:150px;"', 'search'); ?></td>
 	</tr>
	</table>
 <div id="bouton"><input type="submit" value="<?php echo IMAGE_BUTTON_SEARCH; ?>"></div>
</form>
<?php
	if (SHOW_MANUFACTURERS_SEARCH_MENU == 'true' || SHOW_CATEGORIES_SEARCH_MENU == 'true' || SHOW_SEARCH_BY_PRICE_RANGE == 'true' || SHOW_SEARCH_BY_DATE_RANGE == 'true') {
		?>
		<div id="bouton"><?php echo tep_draw_form('advancedsearch', tep_mobile_link(FILENAME_ADVANCED_SEARCH, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_ADVANCED_SEARCH) . "</form></div>"; ?>
		<?php
	}
	?>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
