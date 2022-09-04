<?php 
class splitPageResultsAjax extends splitPageResults {
	function display_ajax_msg() {
		if($this->number_of_pages > 1)
			$ret = '<td onClick="showMoreResults()"><table class="categories"><tr><td class="categories">' . TEXT_SHOW_MORE_RESULTS . '</td><td align="right" class="categories"><img height="30" border="0" width="30" src="images/arrow_select.png" alt=""/></td></tr></table></td>';
		return $ret;
	}
	
	function next_link() {
		global $PHP_SELF;
        if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) {
          return tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('page', 'info', 'x', 'y')) . $this->page_name . '=' . ($this->current_page_number + 1), 'NONSSL');
        } else {
          return "";
        }
		
	}
	
	function generateJS(){
		global $PHP_SELF;
		echo '<script type="text/javascript"> var pageNext = ' . $this->current_page_number. '; var pageCount = ' . $this->number_of_pages . '; var pageName = "' . $this->page_name. '";  var pageURL="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('page', 'info', 'x', 'y'))) . '";</script>';
	}
}
    
?>
<script language="javascript" src="includes/ajax.js"></script>
<script language="javascript" src="includes/split_page_results_ajax.js"></script>
<script type="text/javascript">
	function onWindowLoad() {
		generateNextPageURL();
		window.setTimeout("preloadData()",1000);
	}
window.onload=onWindowLoad;
</script>
