<?php
/*
  $Id: boxes.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
	
  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }

  class infoBox extends tableBox {
    function infoBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

      if ($left_corner == true) {
        //$left_corner = tep_image(DIR_WS_IMAGES . 'infobox/corner_left.gif');
        $left_corner = tep_draw_separator('pixel_trans.gif', '11', '14');
      } else {
        //$left_corner = tep_image(DIR_WS_IMAGES . 'infobox/corner_right_left.gif');
        $left_corner = tep_draw_separator('pixel_trans.gif', '11', '14');
      }
      if ($right_arrow == true) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_IMAGES . 'infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner == true) {
        //$right_corner = $right_arrow . tep_image(DIR_WS_IMAGES . 'infobox/corner_right.gif');
        $right_corner = $right_arrow . tep_draw_separator('pixel_trans.gif', '11', '14');
      } else {
        $right_corner = $right_arrow . tep_draw_separator('pixel_trans.gif', '11', '14');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="14" class="infoBoxHeading"',
                                         'text' => $left_corner),
                                   array('params' => 'width="100%" height="14" class="infoBoxHeading"',
                                         'text' => $contents[0]['text']),
                                   array('params' => 'height="14" class="infoBoxHeading" nowrap',
                                         'text' => $right_corner));

      $this->tableBox($info_box_contents, true);
    }
  }

  class contentBox extends tableBox {
    function contentBox($contents) {
      global $contentBox_suffix;
	  
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="contentBox'.$contentBox_suffix.'"';
      $this->tableBox($info_box_contents, true);
    }

    function contentBoxContents($contents) {
      global $contentBox_suffix;
	  
	  $this->table_cellpadding = '4';
      $this->table_parameters = 'class="contentBoxContents"';
	  $this->table_border = '0';
      return $this->tableBox($contents);
    }
  }

  class contentBoxHeading extends tableBox {
    function contentBoxHeading($contents) {
	  global $contentBox_suffix;
	  
      $this->table_width = '100%';
      $this->table_cellpadding = '0';
	  $this->table_parameters = 'class="contentBoxHeading'.$contentBox_suffix.'"';

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'class="contentBoxHeading_l'.$contentBox_suffix.'"',
                                         'text' => ''),
                                   array('params' => 'class="contentBoxHeading_m'.$contentBox_suffix.'"',
                                         'text' => $contents[0]['text']),
                                   array('params' => 'class="contentBoxHeading_r'.$contentBox_suffix.'"',
                                         'text' => ''));

      $this->tableBox($info_box_contents, true);
    }
  }

  class errorBox extends tableBox {
    function errorBox($contents) {
      $this->table_data_parameters = 'class="errorBox"';
      $this->tableBox($contents, true);
    }
  }

  class productListingBox extends tableBox {
    function productListingBox($contents) {
      $this->table_parameters = 'class="productListing"';
      $this->tableBox($contents, true);
    }
  }
  
  class az_productListingBox extends tableBox {
    function az_productListingBox($contents) {
	  $this->table_border = '0';
      $this->table_parameters = 'class="az_productListing"';
	  $this->table_cellpadding = '2';
	  $this->table_cellspacing = '2';
      $this->tableBox($contents, true);
    }
  }
    
  //AlgoZone specific box classes
  class productBox extends tableBox {
    function productBox($contents) {
      $this->table_parameters = 'class="productBox" align="center"';
	  $this->table_border = '0';
	  $this->table_cellpadding = '4';
      $this->tableBox($contents, true);
    }
  }
  
  class bannerBox extends tableBox {
    function bannerBox($contents) {
      $this->table_parameters = 'class="bannerBox" align="center"';
	  $this->table_border = '0';
	  $this->table_cellpadding = '0';
      $this->tableBox($contents, true);
    }
  }

  class az_infoBoxHeading {
    function az_infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false, $suffix = '') {
  		$infobox = new azInfoBox();
		$infobox->azSetBoxHeading($contents[0]['text'], $right_arrow);
		//function azCreateBox($class='', $prefix='', $suffix='', $params='', $direct_output=true) 
		$infobox->azCreateBox('', '' , $suffix);		
	}
  }

  class az_infoBox {
    function az_infoBox($contents, $suffix = '') {
  		$infobox = new azInfoBox();
  		for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        	$contents_text =  $contents[$i]['text'];
        	if (isset($contents[$i]['form'])){
        		$contents_text = $contents[$i]['form'] . $contents_text . "</form>";
        	}
			$infobox->azSetBoxContent($contents_text);
		}
		$infobox->azSetBoxFooter();
		//function azCreateBox($class='', $prefix='', $suffix='', $params='', $direct_output=true, $box_sep=false)
		$infobox->azCreateBox('', '' , $suffix, '', true, true);
	}
  }

?>
