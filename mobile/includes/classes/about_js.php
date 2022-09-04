<?php
require_once(DIR_MOBILE_CLASSES . 'common_js.php');

class aboutJS extends commonJS{
    
    function buildXML() {
    	$cat = $this->createMainCategory();
      
      	$cat->append_child($this->nodeFromFile(1,BOX_INFORMATION_CONDITIONS,tep_mobile_link(FILENAME_MOBILE_CONDITIONS)));
        $cat->append_child($this->nodeFromFile(2,BOX_INFORMATION_SHIPPING,tep_mobile_link(FILENAME_MOBILE_SHIPPING)));
    	$cat->append_child($this->nodeFromFile(3,BOX_INFORMATION_PRIVACY,tep_mobile_link(FILENAME_MOBILE_PRIVACY)));
		$cat->append_child($this->nodeFromFile(4,BOX_INFORMATION_CONTACT,tep_mobile_link(FILENAME_MOBILE_CONTACT_US)));
    }
}
?>

<script language="javascript" src="<?php echo DIR_MOBILE_INCLUDES; ?>categories.js"></script>
<script type="text/javascript">
<!--
var mobile_img_dir = '<?php echo DIR_MOBILE_IMAGES; ?>';
var catNav = new CategoriesNavigator('<?php echo FILENAME_ABOUT; ?>','<?php $categoriesJS = new aboutJS(); echo str_replace("\n",'',$categoriesJS->getText()); ?>');
function onWindowLoad(){
	catNav.run();
}
window.onload=onWindowLoad;
//-->
</script>
