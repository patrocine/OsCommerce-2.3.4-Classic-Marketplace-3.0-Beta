<?php
class azBoxes {
  var $_prefix = NULL;
  var $_suffix = NULL;
  var $_class = NULL;
  var $_params = NULL;
  
  function azBoxes($class='', $prefix='', $suffix='', $params='') {
    $this->_prefix = $prefix;
    $this->_suffix = $suffix;
    $this->_class = $class;
    $this->_params = $params;
  }
  
  function azBuildBox($contents, $type=1) {
    $box_contents = array();
    if (!is_array( $contents )) {
	  $contents = array('main' => $contents);
	}
	
	if($type == 1) {
	  $box_contents[] = array('class' => $this->_prefix . $this->_class . '_l' . $this->_suffix, 
							  'params' => $this->_params);
	  $box_contents[] = array('class' => $this->_prefix . $this->_class.'_r' . $this->_suffix, 
							  'params' => $this->_params);
	  $box_contents[] = array('text' => $contents['main'], 
	                          'class' => $this->_prefix . $this->_class.'_m' . $this->_suffix, 
							  'params' => $this->_params);
	}else if($type == 2){
	  $box_contents[] = array('text' => $contents['left'], 
	                          'class' => $this->_prefix . $this->_class . '_l' . $this->_suffix, 
							  'params' => $this->_params, 
							  'close' => true);
	  $box_contents[] = array('text' => $contents['main'], 
	                          'class' => $this->_prefix . $this->_class.'_m' . $this->_suffix, 
							  'params' => $this->_params, 
							  'close' => true);
	  $box_contents[] = array('text' => $contents['right'], 
	                          'class' => $this->_prefix . $this->_class.'_r' . $this->_suffix, 
							  'params' => $this->_params, 
							  'close' => true);
	}else if($type == 3) {	  
	  $box_contents[] = array('text' => $contents['main'], 
	                          'class' => $this->_prefix . $this->_class . $this->_suffix, 
							  'params' => $this->_params);
	}
	
	$this->box_elements = $box_contents;
	
    $box_string = $this->azCreateBoxElements();
	$box_string .= $this->azCloseBoxElements();	
	
	return $box_string;
  }
	
  function azCreateBoxElements() {
	$elements_string = '';
	
    if (!empty($this->box_elements)) {
	  for ($x=0; $x < count($this->box_elements); $x++) {
        $elements_string .= '<div';
		$elements_string .= ' class="' . $this->box_elements[$x]['class'] . '"';
        if (!empty($this->box_elements[$x]['params'])) $elements_string .= ' '.$this->box_elements[$x]['params'];
        $elements_string .= '>';
        if (!empty($this->box_elements[$x]['text'])) $elements_string .= $this->box_elements[$x]['text'];
        if (isset($this->box_elements[$x]['close']) && $this->box_elements[$x]['close'] == true) $elements_string .= '</div>'."\n";
	  }
    }
	
	return $elements_string;
  }
  
  function azCloseBoxElements() {
    $elements_string = '';
	
    if (!empty($this->box_elements)) {
	  for ($x=0, $n=count($this->box_elements); $x<$n; $x++) {
	    if (empty($this->box_elements[$x]['close'])) $elements_string .= '</div>'."\n";
	  }
	}
	
	return $elements_string;
  }
}

class azInfoBox {
  var $_heading = NULL;
  var $_content = NULL;
  var $_footer  = NULL;
  var $_isHeaderSet = false;
  var $_isConterntSet = false; 
  var $_isFooterSet = false;
  
  function azInfoBox() {
    $this->_heading = new azBoxes('box_top', 'az_', '_new', '');
    $this->_content = new azBoxes('box_cont', 'az_', '_new', '');
	$this->_footer  = new azBoxes('box_bottom', 'az_', '_new', '');
  }
  
  function azSetBoxHeading($contents='', $title_link='', $type=1) {
	// Record that we need Heading
	$this->_isHeaderSet = true;
	if (empty($title_link)) {
	  $title = $contents;
	} else {
	  $title = '<a href="' . $title_link . '">' . $contents . '</a>';
	}
	
	$boxTitle = new azBoxes('boxTitle');
	$title_string = $boxTitle->azBuildBox($title, 3); // wrap heading title with 'boxTitle' Box
	
	$box_string = $this->_heading->azBuildBox($title_string, $type);
	$box_string = $this->_heading->azBuildBox($box_string, 3); // wrap with another box
	
	$this->heading_string = $box_string;
  }
  
  function azSetBoxFooter($contents='', $type=1) {
  	// Record that we need Footer
  	$this->_isFooterSet = true;  
	$box_string = $this->_footer->azBuildBox($contents, $type);
	$box_string = $this->_footer->azBuildBox($box_string, 3); // wrap with another box
	
	$this->footer_string = $box_string;
  }
  
  function azSetBoxContent($contents='', $type=1) {
  	// Record that we need Content
  	$this->_isConterntSet = true;    
    $boxContents = new azBoxes('boxContents');
	$box_string = $boxContents->azBuildBox($contents, 3); // wrap box contents with 'boxContents' Box
	
	$box_string = $this->_content->azBuildBox($box_string, $type);
	$box_string = $this->_content->azBuildBox($box_string, 3);
	
	$this->content_string = $box_string;
  }
  
  function azCreateBox($class='', $prefix='', $suffix='', $params='', $direct_output=true, $box_sep=false) {
	$infobox = new azBoxes();
	$infobox->_class  = !empty($class) ? $class : 'box';
	$infobox->_prefix = !empty($prefix) ? $prefix : 'az_';
	$infobox->_suffix = !empty($suffix) ? $suffix : '_new';
	$infobox->_params = !empty($params) ? $params : '';
	
	$contents = '';
	if ($this->_isHeaderSet) {
		$contents .= $this->heading_string;
	}
	if ($this->_isConterntSet) {
		$contents .= $this->content_string;
	}
	if ($this->_isFooterSet) {
		$contents .= $this->footer_string;
	}
	
	$box_string = $infobox->azBuildBox($contents, 3);
	
	if($box_sep == true) {
		$box_sep_obj = new azBoxes('az_box_sep');
		$box_sep_text = $box_sep_obj->azBuildBox('', 3);
		$box_string = $box_string . $box_sep_text;
	}
	
	if ($direct_output == true) echo $box_string;
	
	#Cleanup
  	$this->_isHeaderSet = false;
	$this->_isConterntSet = false; 
	$this->_isFooterSet = false;	
	
	return $box_string;
  }
}

class azProductBox extends azInfoBox {  
  function azProductBox() {
    $this->_heading = new azBoxes('pbox_top', 'az_', '_new', '');
    $this->_content = new azBoxes('pbox_cont', 'az_', '_new', '');
	$this->_footer  = new azBoxes('pbox_bottom', 'az_', '_new', '');
  }
}

class azImageBox {  
  function azImageBox() {
	$this->_heading = new azBoxes('imgbox_top', 'az_', '_new', '');
	$this->_content = new azBoxes('imgbox_cont', 'az_', '_new', '');
	$this->_footer  = new azBoxes('imgbox_bottom', 'az_', '_new', '');
	$this->_border  = new azBoxes('imgbox', 'az_', '_new', '');
  }
  
  function azCreateBox($contents='', $width='', $direct_output=false) {
	$box_string = $this->_heading->azBuildBox('');
	$contents = $this->_content->azBuildBox($contents);
	$box_string .= $this->_content->azBuildBox($contents, 3);
	$box_string .= $this->_footer->azBuildBox('');
	
	$this->_border->_params = !empty($width) ? 'style="width:'.$width.'"' : '';	
	$box_string = $this->_border->azBuildBox($box_string, 3);
	
	if ($direct_output == true) echo $box_string;
	
	return $box_string;
  }
}