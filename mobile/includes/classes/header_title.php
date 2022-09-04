<?php


  class headerTitle {
  	
    function headerTitle() {
    }
    
    function write($title = '') {
   		global $cart, $classic_site, $language; 	
    	$this->title =  (strlen($title) > 0)? $title : HEADING_TITLE;
			if(isset($classic_site))
				$url = $classic_site;
			else {
			$url = str_replace('mobile_', '', $_SERVER['REQUEST_URI']);
			}
			if (substr(basename($_SERVER['REQUEST_URI']), 0, 15) != 'mobile_checkout') {
				$leftButton = TEXT_SHOW_VIEW_1 . '<a href="' . $url . '">' . TEXT_CLASSIC_VIEW . '</a>' . TEXT_SHOW_VIEW_2;
			} else {
			$leftButton = '';
			}
	if(sizeof($cart->contents) > 0) 
			$rightButton = '<a href="' . tep_mobile_link(FILENAME_SHOPPING_CART) . '">' . tep_image(DIR_MOBILE_IMAGES . "btn_mob_cart.png") . '</a>';
		else {
		}
		echo '
	<table class="headerTitle" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td id="headerTitleLeft" class="headerTitleLeft">'  . $leftButton . '</td>
			<td id="headerTitle" class="headerTitle"><h1>' 	   . $this->title . '</h1></td>
			<td id="headerTitleRight" class="headerTitleRight">' . $rightButton . '</td>

    	</tr>
	</table>
	<!--  ajax_part_begining -->
	';
    }
}
?>
    	<table class="headerTitle" width="100%" cellpadding="0" cellspacing="0">
		<tr>
  <td id="headerTitleLeft" class="headerTitleLeft">  <?php echo tep_draw_form('quick_find', tep_mobile_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false)) ?>

 		<?php echo Buscar . ':'; ?>
 		<?php echo tep_draw_input_field('keywords', '', 'results="10" style="width:150px;"', 'search'); ?>
<input type="submit" value="<?php echo IMAGE_BUTTON_SEARCH; ?>">
</form>    </td>
      </tr>
	</table>

