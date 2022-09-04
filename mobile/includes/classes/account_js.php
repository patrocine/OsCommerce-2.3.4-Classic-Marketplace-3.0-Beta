<?php
require_once(DIR_MOBILE_CLASSES . 'common_js.php');

class accountJS extends commonJS{
    
    function buildXML() {
    	$cat = $this->createMainCategory();
      
      	$cat->append_child($this->nodeFromFile(1,TEXT_MY_ORDERS,tep_mobile_link(FILENAME_MOBILE_ACCOUNT_HISTORY,'','SSL')));
        $cat->append_child($this->nodeFromFile(2,HEADER_TITLE_MY_ACCOUNT,tep_mobile_link(FILENAME_MOBILE_ACCOUNT_EDIT)));
		$cat->append_child($this->nodeFromFile(3,IMAGE_BUTTON_ADDRESS_BOOK,tep_mobile_link(FILENAME_MOBILE_ADDRESS_BOOK,'','SSL')));
		$cat->append_child($this->nodeFromFile(4,CATEGORY_PASSWORD,tep_mobile_link(FILENAME_MOBILE_ACCOUNT_PASSWORD,'','SSL')));
		$cat->append_child($this->nodeFromFile(5,TEXT_NEWSLETTERS,tep_mobile_link(FILENAME_MOBILE_ACCOUNT_NEWSLETTERS,'','SSL')));
		$cat->append_child($this->nodeFromFile(6,BOX_HEADING_NOTIFICATIONS,tep_mobile_link(FILENAME_MOBILE_ACCOUNT_NOTIFICATIONS,'','SSL')));
		$cat->append_child($this->nodeFromFile(7,HEADER_TITLE_LOGOFF,tep_mobile_link(FILENAME_MOBILE_LOGOFF,'','SSL')));
    }
}
?>

<script language="javascript" src="<?php echo DIR_MOBILE_INCLUDES; ?>categories.js"></script>
<script type="text/javascript">
<!--
var mobile_img_dir = '<?php echo DIR_MOBILE_IMAGES; ?>';
var catNav = new CategoriesNavigator('<?php echo tep_mobile_link(FILENAME_ACCOUNT, '', 'SSL'); ?>','<?php $categoriesJS = new accountJS(); echo str_replace("\n",'',$categoriesJS->getText()); ?>');
function onWindowLoad(){
	catNav.run();
}
window.onload=onWindowLoad;
-->
</script>
