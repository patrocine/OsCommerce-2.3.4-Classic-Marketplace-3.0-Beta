<?php
/*
  $Id: localization.php,v 1.12 2003/06/25 20:36:48 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  function quote_oanda_currency($code, $base = DEFAULT_CURRENCY) {
    //$page = file('http://www.oanda.com/convert/fxdaily?value=1&redirected=1&exch=' . $code .  '&format=CSV&dest=Get+Table&sel_list=' . $base);
    if ($code == $base) {
    	return 1;
    } else {
    	$oanda_us_date = str_replace('/', '%2F', strftime('%m/%d/%y', mktime(0,0,0,date('m'),date('d'),date('Y'))));
		$page = file('http://www.oanda.com/convert/fxdaily?value=1&date='. $oanda_us_date .'&date_fmt=us&lang=en&exch='. $code .'&exch2=&expr2=&dest=Get+Table&sel_list='. $base .'&format=CSV&redirected=1&result=1');

    	$match = array();

    	preg_match('/(.+),(\w{3}),([0-9.]+),([0-9.]+)/i', implode('', $page), $match);

    	if (sizeof($match) > 0) {
      		return $match[3];
    	} else {
      		return false;
    	}
    }
  }

  function quote_xe_currency($to, $from = DEFAULT_CURRENCY) {
    $page = file('http://www.xe.net/ucc/convert.cgi?Amount=1&From=' . $from . '&To=' . $to);

    $match = array();

    preg_match('/[0-9.]+\s*' . $from . '\s*=\s*([0-9.]+)\s*' . $to . '/', implode('', $page), $match);

    if (sizeof($match) > 0) {
      return $match[1];
    } else {
      return false;
    }
  }
?>
