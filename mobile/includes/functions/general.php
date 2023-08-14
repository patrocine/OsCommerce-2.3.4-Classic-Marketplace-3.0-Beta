<?php
  function tep_mobile_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = false) {
	return tep_href_link($page, $parameters, $connection, $add_session_id,false);  	
  }

function tep_mobile_link2($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = false) {
    global $request_type, $session_started, $SID;
  	$module = substr($page,0,-4);
  	
  	$page = FILENAME_MOBILE;
  	$parameters = 'module=' . $module . '&' . $parameters;

    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == true) {
        $link = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;
      } else {
        $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
      }
    } else {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL</b><br><br>');
    }

    if (tep_not_null($parameters)) {
      $link .= $page . '?' . tep_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }
    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
      if (tep_not_null($SID)) {
        $_sid = $SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if (HTTP_COOKIE_DOMAIN != HTTPS_COOKIE_DOMAIN) {
          $_sid = tep_session_name() . '=' . tep_session_id();
        }
      }
    }

    if (isset($_sid)) {
      $link .= $separator . tep_output_string($_sid);
    }

    return $link;
  }

  function tep_mobile_button($text, $params = '') {
//	return '<div id="mobileButton"><table><tr><td width="1px"><img src="images/greybutton/left.gif"/></td><td>' . $text . '</td><td width="1px"><img src="images/greybutton/right.gif"/></td></tr></table></div>';
	return '<input type="submit"  style="font-size: 18pt" value="' . $text . '" ' . $params . '/>';
//	return '<div id="mobileButton"><table><tr><td width="1px"><img src="images/greybutton/left.gif"/></td><td>' . $text . '</td><td width="1px"><img src="images/greybutton/right.gif"/></td></tr></table></div>';
  }

  function tep_mobile_path_element($path, $element, $alt=null) {
		return ($path ? '<a href="' . $path .'">' . $element . '</a>' : ($alt ? $alt : $element)) ;
  }
  
  function tep_mobile_selection($path, $elements) {
  	$ret = '<tr class="categories"';
  	$ret .= ($path ? ' onclick="window.location.href=\'' . $path .'\'"' : '' );
  	$ret .=  '>';
  	foreach ($elements as $element) {
  		$ret .= '<td class="categories">' . tep_mobile_path_element($path,$element) . '</td>';
  	}
  	$ret .= '<td class="categories" align="right">';
  	//$ret .= ($path) ?  '<a href="' . $path .'">' . tep_image(DIR_MOBILE_IMAGES . 'arrow_select.png') . '</a>' : '<input type="image" src="' .DIR_MOBILE_IMAGES . 'arrow_select.png' . '" border="0" alt="">';
	return $ret;
  	
  }
  function tep_print($obj) {
		print ("<pre>");
		print_r ($obj);
		print ("</pre>\n");
	}
  function tep_debug($obj) {
  	if(MOBILE_DEBUG == 'true') {
		tep_print($obj);
  	}
  }
?>
