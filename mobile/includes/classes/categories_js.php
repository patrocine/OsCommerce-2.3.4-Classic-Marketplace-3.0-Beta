<?php 
require_once(DIR_MOBILE_CLASSES . 'common_js.php');
  
class categoriesJS extends commonJS {
    function buildXML() {
    	$cat = $this->createMainCategory();
    	$this->getXML($cat, 0);
    }
    
    function getXML($parent, $parent_id) {
  		global $languages_id, $path_cond;
  		$empty = true;
    	$categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = " . $parent_id . " and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id . $path_cond . "' order by sort_order, cd.categories_name");
		while ($categories = tep_db_fetch_array($categories_query))  {
	  		$cat = $this->doc->create_element("category");
      		$cat->set_attribute("id", $categories['categories_id']);
      		$cat->set_attribute("name", addslashes($categories['categories_name']));
      		$cat->set_attribute("image", $categories['categories_image']);
      		
      		$parent->append_child($cat);
	  		$this->getXML($cat, $categories['categories_id']);
  			$empty = false;
	  	}	
		if($empty)
			$parent->set_attribute("path", FILENAME_DEFAULT .'?cPath='.$parent_id);
    }
}
    
?>
<script language="javascript" src="<?php echo DIR_MOBILE_INCLUDES; ?>categories.js"></script>
<script type="text/javascript">
var mobile_img_dir = '<?php echo DIR_MOBILE_IMAGES; ?>';
var catNav = new CategoriesNavigator('<?php echo FILENAME_DEFAULT; ?>', '<?php $categoriesJS = new categoriesJS(); echo str_replace("\n",'',$categoriesJS->getText()); ?>');
function onWindowLoad(){
	catNav.run();
}
window.onload=onWindowLoad;
</script>
