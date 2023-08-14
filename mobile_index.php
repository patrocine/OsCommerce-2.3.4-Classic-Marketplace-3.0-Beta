<?php
require_once('mobile/includes/application_top.php');
require(DIR_MOBILE_INCLUDES . 'header.php');
require(DIR_WS_LANGUAGES . $language . '/index.php');
$headerTitle->write($headerTitleText);


            ?>


<!-- categories //-->
<div id="iphone_content">
<div id="cms">
  <div id="bouton" style="height:24px;">
	<?php
	if (!tep_session_is_registered('customer_id')) { 
		echo '<span style="float:left;">' . tep_draw_form('create_account', tep_mobile_link(FILENAME_CREATE_ACCOUNT, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_CREATE_ACCOUNT) . '</form></span>' .  
		     '<span style="float:right;">' . tep_draw_form('login', tep_mobile_link(FILENAME_LOGIN, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_LOGIN) . '</form></span>';
	} else { 
		echo tep_draw_form('create_account', tep_mobile_link(FILENAME_MOBILE_LOGOFF, '', 'SSL')) . tep_mobile_button(IMAGE_BUTTON_LOGOFF) . '</form>';
	}
	?>
  </div>
</div>
	<div id="cms">			
	<?php echo TEXT_WELCOME; ?>
 
     <?php require('mobile_products_new_index.php');
?>
     <?php //require('mobile_specials_index.php');

?>

</div>



<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>



