<?php
class commonJS{
  	var $doc;
	
	function commonJS() {
		$this->buildXML();
	}
    function buildXML() {
		$this->doc = domxml_new_doc("1.0");
    }
	
	function getText() {
    	return $this->doc->dump_mem();
    }
    
    function curl_file($filename) {
    	$ch = curl_init();

    	curl_setopt($ch, CURLOPT_URL,$filename );    
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1 );    
    	curl_setopt ($ch, CURLOPT_COOKIE, session_name().'='.session_id() ); 	
    	$content  = curl_exec($ch);
    	curl_close($ch);
    	return split("\n",addslashes($content));
    }

	function getFileText($filename) {
		$lines = $this->curl_file($filename);
//		$lines = file($filename);
		$ret = "";
		foreach ($lines as $line_num => $line) {
			if(strpos(htmlspecialchars($line), 'ajax_part_begining') > 0)
				$ret = " ";
			else if(strpos(htmlspecialchars($line), 'ajax_part_ending') > 0) 
				return $ret;
			else if (strlen($ret) > 0)
				$ret = $ret . $line;
		}
		return "ERROR";
	}

	function createMainCategory($title = null) {
		if($title == null ) {
			global $headerTitle;
			$title = $headerTitle->title;
		}
			
		$this->doc = domxml_new_doc("1.0");
		$root = $this->doc->create_element("root");
		$this->doc->append_child($root);
		  
		$cat = $this->doc->create_element("category");
	    $cat->set_attribute("id", "root");
	    $cat->set_attribute("name", $title);
	    $root->append_child($cat);
	    return $cat;
	}
	
	function nodeFromFile($id,$name,$filename) {
	  $el = $this->doc->create_element("category");
      $el->set_attribute("id", $id);
      $el->set_attribute("name", $name);
      $el->set_attribute("type", "text");
      $el->append_child($this->doc->create_text_node($this->getFileText($filename)));
      return $el;
	}
	
}
?>
