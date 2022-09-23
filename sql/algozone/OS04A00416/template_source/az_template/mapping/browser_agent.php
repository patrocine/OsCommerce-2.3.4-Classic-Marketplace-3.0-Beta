<?php
/*
  $Id: browser_agent.php 2009-01-30 $

  Copyright (c) 2009 AlgoZone, Inc ( www.algozone.com )

*/

$agent['http'] = isset($_SERVER["HTTP_USER_AGENT"]) ? strtolower($_SERVER["HTTP_USER_AGENT"]) : "";
$agent['version'] = 'unknown';
$agent['browser'] = 'unknown';
$agent['b_version'] = 0;
$agent['platform'] = 'unknown';

$oss = array('win', 'mac', 'linux', 'unix');
foreach ($oss as $os) {
	if (strstr($agent['http'], $os)) {
		$agent['platform'] = $os;
		break;
	}
}
	
$browsers = "mozilla msie gecko firefox ";
$browsers.= "konqueror safari netscape navigator ";
$browsers.= "opera mosaic lynx amaya omniweb";
$device_type = "iphone";

$browsers = explode(" ", $browsers);

$nua = strToLower( $_SERVER['HTTP_USER_AGENT']);

$l = strlen($nua);
for ($i=0; $i<count($browsers); $i++){
  $browser = $browsers[$i];
  $n = stristr($nua, $browser);
  if(strlen($n)>0){
   $agent["b_version"] = "";
   $agent["browser"] = $browser;
   if (stristr($nua, $device_type))
   {
   	  $agent["device_type"] = $device_type;
   }
   $j=strpos($nua, $agent["browser"])+$n+strlen($agent["browser"])+1;
   for (; $j<=$l; $j++){
     $s = substr ($nua, $j, 1);
     if(is_numeric($agent["b_version"].$s) )
     $agent["b_version"] .= $s;
     else
     break;
   }
  }
}

?>