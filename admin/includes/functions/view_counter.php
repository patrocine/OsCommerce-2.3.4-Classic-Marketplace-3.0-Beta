<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack York

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/
     
/*******************************************************************************
Add the given IP to the .htaccess file and the banned IP DB table
/******************************************************************************/
function AlterHtaccessFile($ip, $isDomain = false) {
    if (! tep_validate_ip_address($ip)) {
        return false;
    }
    $dot = '';
    
    if ($isDomain) {                  //already verified to be a domain name
        $dot = '.';                   //needed for a domain name to block all entries
    } else if (! IsValidIP($ip)) {    //this is an IP or Range so check it
        return false;
    }
   
    $arrayWrite = array();
    $htaccessfile = '';
    $arrayWrite = GetHtaccessFileContents($htaccessfile);
    
    if ($arrayWrite) {    
        $endLine = '';
 
        $arrayWrite = CleanHtaccess($arrayWrite);  //remove any duplicates that might have crept in   
        $items = count($arrayWrite);

        for ($i = 0; $i < $items; ++$i) {
     
            //if (preg_match('/\b' . $ip . '\b/', $arrayWrite[$i])) {
            if (strpos($arrayWrite[$i], $ip) !== FALSE) {
                return false;
            }
            
            if (strpos(addslashes($arrayWrite[$i]), '# End IP deny by View Counter from www.oscommerce-solution.com') !== FALSE) {
                $endLine = $i;
                break;
            }            
            
        }
        
        reset($arrayWrite);
        
        if ($endLine) {  //htaccess already has View Counter changes so add to them
            $arrayTmp = array();
            $arrayTmp[] = 'deny from ' . $dot . $ip . PHP_EOL;
            array_splice($arrayWrite, $endLine - 1, 0, $arrayTmp);
        } else {        
            $arrayWrite[] = '# Begin IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;      
            $arrayWrite[] = 'order allow,deny' . PHP_EOL;
            $arrayWrite[] = 'deny from ' . $dot . $ip . PHP_EOL;
            $arrayWrite[] = 'allow from all' . PHP_EOL;
            $arrayWrite[] = '# End IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;
        }
    } else { //create a new file
        $arrayWrite[] = '# Begin IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;      
        $arrayWrite[] = 'order allow,deny' . PHP_EOL;
        $arrayWrite[] = 'deny from ' . $dot . $ip . PHP_EOL;
        $arrayWrite[] = 'allow from all' . PHP_EOL;
        $arrayWrite[] = '# End IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;
    }
    
    if (! empty($arrayWrite)) {
        if (WriteHTAccess($htaccessfile, $arrayWrite)) {
            IgnoreThisIP($ip, 0);     
            DeleteAllIPs($ip);
            return true;
        } else {
            return false; //ERROR_HTACCESS_WRITE_FAILED;
        }
    }  
    return false;    
}  

/*******************************************************************************
Common function to check for hacker code in arg 
/******************************************************************************/
function CheckForHackerCode($view) {
    global $colors;
    
    $cmpArry = GetHackerWords();
                     
    foreach ($cmpArry as $test) {
        if (isset($view['file_name'])) {
            if (preg_match('/' . $test . '/', $view['file_name'])) {
                return ' style="background-color:' . $colors[COLOR_IS_HACKER] . '" '; 
            }
        }
        if (isset($view['arg'])) {
            if (preg_match('/' . $test . '/', $view['arg'])) {
                return ' style="background-color:' . $colors[COLOR_IS_HACKER] . '" '; 
            }
        }
    }
    if (false) {
    foreach ($cmpArry as $test) {
        if (preg_match('/' . $test . '/', $view['file_name']) || preg_match('/' . $test . '/', $view['arg'])) {
            return ' style="background-color:' . $colors[COLOR_IS_HACKER] . '" '; 
        }
    }
    }
    return '';
}    
    
/*******************************************************************************
Remove duplicate IP's and IP's that are part of a CIDR from the htaccess file 
/******************************************************************************/
function CleanHtaccess($array) {
    $cidrArray = array();
    $clearedArray = array();
    $newArray = array();

    /************** Remove duplicate IP's **************/    
    foreach ($array as $entry) {
        if (($pos = strpos($entry, 'deny from ')) !== FALSE) {  //this is an IP deny entry
            if (strpos($entry, '/') !== FALSE) {                //this is a cidr
                $cidr = trim(substr($entry, $pos + 9));          //get the cidr
                $cidrArray[] = $cidr;            
            }

            if (in_array($entry, $clearedArray)) {
                continue;
            }    
        }
        
        $clearedArray[] = $entry;
    }

    /************** Remove IP's that are part of a CIDR **************/    
    foreach ($clearedArray as $entry) {
        if (($pos = strpos($entry, 'deny from ')) !== FALSE) { //this is an IP deny entry
            if (strpos($entry, '/') === FALSE) {               //this is not a cidr
                $ip = trim(substr($entry, $pos + 9)); 
                foreach ($cidrArray as $cidr) {                 
                    if (IPinCIDR($ip, $cidr)) {
                        continue;
                    }    
                }
            }
        } 
        $newArray[] = $entry; 
    }
    
    return $newArray;
}

/*******************************************************************************
Convert a range into a CIDR or just use the give IP or CIDR 
/******************************************************************************/
function ConvertRangeToCIDR($ips) {
    $ipArray = array();
    
    if (strpos($ips, '-') !== FALSE) { //this is a range
        $ipArray = IPRangeToCIDR(explode('-',$ips));
    } else {
        $ipArray[] = $ips;
    }
    
    return $ipArray;
}

/*******************************************************************************
Delete all of the IP's in the given CIDR
/******************************************************************************/
function DeleteAllIPs($CIDR) {
    if (strpos($CIDR, '/') !== FALSE) {
        $sqlStr = 'delete from view_counter where ( ';
        
        $ips_query = tep_db_query("select distinct INET_NTOA(ip_number) from view_counter");
        $match = false;
        
        while ($ips = tep_db_fetch_array($ips_query)) {
            if (IPinCIDR($ips['ip'], $CIDR) == 1) {
                $sqlStr .= "ip_number = INET_ATON('" . $ips['ip'] . "') or ";
                $match = true;
            }
        }
        
        if ($match) {
            $sqlStr = substr($sqlStr, 0,-3);
            $sqlStr .= ' )';

            tep_db_query($sqlStr);
            $sqlStr = str_replace('view_counter', 'view_counter_flags', $sqlStr);
            tep_db_query($sqlStr);
        } 
    } else {
        DeleteThisIP($CIDR);
    }    
}

/*******************************************************************************
Delete the given IP from the IP table and Flag entry
/******************************************************************************/
function DeleteThisIP($ip) {
    tep_db_query("delete from view_counter where ip_number = INET_ATON('" . $ip . "')");
    tep_db_query("delete from view_counter_flags where ip_number = INET_ATON('" . $ip . "')");
}

/*******************************************************************************
Format the refresh line and return
/******************************************************************************/
function DisplayRefreshTime() {
    $time = time(); 
    $last_time = @date('H:i:s',$time);  
     
    $next = sprintf("+%d seconds", VIEW_COUNTER_PAGE_REFRESH); 
    //$last_time_plus = date('H:i:s',strtotime($next,$time)); 

    if ((int)VIEW_COUNTER_PAGE_REFRESH > 0) {
        $last_time_plus = '<b id="timeto_refresh">'. VIEW_COUNTER_PAGE_REFRESH . '</b>';
        return sprintf(TEXT_LAST_REFRESH, $last_time, $last_time_plus);
    }    
    
    return sprintf(TEXT_LAST_REFRESH_NO_REFRESH, $last_time);
}
    
/*******************************************************************************
Get the number of visits in the last 24 hours
*******************************************************************************/
function GetAccessCount($language_id) {
    $count = '';
    $accessedCnt_query = tep_db_query("SELECT count(*) as count FROM view_counter WHERE last_date >= now() - INTERVAL 1 DAY and language_id = '" . (int)$language_id . "' ");
    
    if (tep_db_num_rows($accessedCnt_query)) {
        $accessedCnt = tep_db_fetch_array($accessedCnt_query);
        $count = sprintf(TEXT_ACCESSS_COUNT, $accessedCnt['count']);
    }

    return $count;    
}
  
/*******************************************************************************
Get all of the stats
*******************************************************************************/
function GetAccessCountAll() {
    $countArray = array();
    $accessedCnt_query = tep_db_query("SELECT distinct * FROM view_counter_storage");
    
    if (tep_db_num_rows($accessedCnt_query)) {
        $bots = 0;
        $admin = 0;
        while ($accessedCnt = tep_db_fetch_array($accessedCnt_query)) {
            $bots = ($accessedCnt['isbot'] ? $bots + 1 : $bots);
            $admin = ($accessedCnt['isadmin'] ? $admin + 1 : $admin);
        }
        
        $countArray['ttl'] = tep_db_num_rows($accessedCnt_query);
        $countArray['bots'] = $bots;
        $countArray['admin'] = $admin;
    }    
    return $countArray;    
}
       
/*******************************************************************************
Get the correct color for the list
/******************************************************************************/
function GetColor($view) {
    global $bannedList, $colors;
    
    $colorArray = array();
    
    if (VC_in_multi_array($view['ip'], $bannedList)) {
        $colorArray['FG'] = 'style="color:' . $colors[COLOR_BUTTONS] . ';"';
    }    

    if ($view['isbot']) {
        $colorArray['BG'] = ' style="background-color:' . $colors[COLOR_IS_BOT] . ';" ';
    } else if (tep_not_null($view['isadmin'])) {
        $colorArray['BG'] = ' style="background-color:' . $colors[COLOR_IS_ADMIN] . ';"';
    } else {
        $colorArray['BG'] = '';
    }

    $isHacker = CheckForHackerCode($view);
    if (isset($isHacker[0])) {
        $colorArray['args'] = $isHacker;
        $colorArray['file_name'] = $isHacker;
    } else {
        $colorArray['file_name'] = ($view['file_name'] == 'view_counter_trap_badbot.php' ? ' style="background-color:' . $colors[COLOR_IS_BOT_TRAP] . ';"' : '');
    }
    
    return $colorArray;
} 

/*******************************************************************************
Get an array of countries
/******************************************************************************/
function GetCountriesList() {
    $cntryArray = array();
    $slash = substr(DIR_FS_CATALOG, -1) != '/' ? '/' : '';
    $cntryList = preg_replace("/(\/+)/", "/", DIR_FS_CATALOG . $slash . 'includes//view_counter_countries_list.txt');  //remove extra slashs for improper configure files      
    $fp = file($cntryList);  
    $cntryArray = array();
    $cntryArray[] = array('id' => TEXT_BLOCK_COUNTRIES_SELECT, 'text' => TEXT_BLOCK_COUNTRIES_SELECT);

    foreach ($fp as $country) {
        $country = trim($country);
        $cntryArray[] = array('id' => $country, 'text' => $country);
    }  
    return $cntryArray;
}             

/*******************************************************************************
Common function to build an array of possible hacking words. This array is also
found on the shop side so change it when this is changed.
/******************************************************************************/
function GetHackerWords() {
    return array("(\<|%3C)script(>|%3E)", "base64_encode", "(\<|%3C)(.*)(\>|%3E)", "(\<|%3C).*iframe", "javascript:",
                 "eval\(\$_", "javascript:", "mysql_query", "..\/cmd", "phpinfo\(", "\/iframe", "\$_GET",
                 "\$_POST", "\$_SESSION", "\$_REQUEST", "\$_ENV", "GLOBALS\[", "\$HTTP_",
                 "autoLoadConfig", "php\/login", "alert\(", "convert\(", "mysite\.com",
                 "misc.php", "cltreq.asp", "owssvr.dll", "cmd.exe", "awstats", "phpmyadmin", "openwebmail", "formmail",
                 "drop table", "from table", "IDSAlert."
                 ); 
}
 
/*******************************************************************************
Get domain details for the given IP
/******************************************************************************/
function GetIPDetails($ipAddr) {
  
    //verify the IP address for the
    if (ip2long($ipAddr)== -1 || ip2long($ipAddr) === false) return '';
     
    //This site or product includes IP2Location LITE data available from http://lite.ip2location.com 
    //get the country name from local DB
    require_once('../view_counter/IP2Location.php');
    //$vcCountry = new IP2Location('view_counter/view_counterDB.BIN', IP2Location::MEMORY_CACHE);
    $vcCountry = new IP2Location('../view_counter/view_counterDB.BIN', IP2Location::FILE_IO); //fastest
    
    $record = $vcCountry->lookup($ipAddr, IP2Location::ALL);
    //$record->countryName may return - as first character so check second to see if something was found
    if (tep_not_null($ipAddr) && isset($record->countryName[1]) && strpos($record->countryName, 'demo database') === FALSE ) {
        $entriesArray = GetEntriesArray(0);
        $dbArray = array('0' => 'ipAddress','1' => 'countryCode','2' => 'countryName','3' => 'regionName','4' => 'areaCode','5' => 'cityName', 
                         '6' => 'latitude','7' => 'longitude','8' => 'ipNumber','9' => 'zipCode','10' => 'timeZone','11' => 'isp', 
                         '12' => 'domainName','13' => 'netSpeed','14' => 'iddCode','15' => 'weatherStationCode','16' => 'weatherStationName', 
                         '17' => 'mcc','18' => 'mnc','19' => 'mobileCarrierName','20' => 'elevation','21' => 'usageType');
                 
        $record = (array)$record; //convert from object
        $newArray  = array();
        $cnt = count($dbArray);
        
        foreach ($record as $key => $data) {
            if (isset($data[1]) && strpos($data, 'demo DB') === FALSE && strpos($data, 'unavailable') === FALSE) {
                for ($i = 0; $i < $cnt; ++$i) {
                    if ($key == $dbArray[$i]) {
                        $newArray[$entriesArray[$i]] = $data; 
                        break;
                    }
                }
            }
        }
        return $newArray ;
    }
    
    if (VIEW_COUNTER_COUNTRIES_CHECK_ADMIN == 'External') {
     
        //get the country name from geoplugin.net
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ipAddr));
    
        if($ip_data && $ip_data->geoplugin_countryName != null) {
         
            $entriesArray = GetEntriesArray(1);
            $geoKeyArray  = array(0 => 'geoplugin_request',1 => 'geoplugin_countryCode',2 => 'geoplugin_countryName',3 => 'geoplugin_regionName',4 => 'geoplugin_areaCode',5 => 'geoplugin_city',6 => 'geoplugin_latitude',7 => 'geoplugin_longitude'); 
 
            $newArray = array(); 
            $cnt = count($geoKeyArray);      
            $ip_data = (array)$ip_data;          

            foreach ($ip_data as $entry => $data) {   
                for ($i = 0; $i < $cnt; ++$i) {
                    if (isset($entry[1]) && $entry == $geoKeyArray[$i]) {
                        $newArray[$entriesArray[$i]] = $data;
                        break;
                    }                 
                } 
            } 
            
            return $newArray;         
        }
 
        //get the country name from hostip.info
        // This notice MUST stay intact for legal use            
        if (function_exists('curl_exec')) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, "http://api.hostip.info/?ip=".$ipAddr);
            $xml = curl_exec($curl);
            
            if (curl_errno($curl)) {
                $xml = @file_get_contents("http://api.hostip.info/?ip=".$ipAddr);  //may be disabled on the server
            }                  
            
            curl_close($curl);
        } else {
            $xml = @file_get_contents("http://api.hostip.info/?ip=".$ipAddr);  //may be disabled on the server
        }

        $entriesArray = GetEntriesArray(2);               
        $hostKeyArray = array(0 => 'ip',1 => 'countryName',2 => 'countryAbbrev');
        $newArray = array();
        $cnt = count($hostKeyArray);
        
        for ($i = 0; $i < $cnt; ++$i) {
            $str = "@<" . $hostKeyArray[$i] . ">(.*?)</" . $hostKeyArray[$i] . ">@si";
            preg_match($str,$xml,$matches);
            $newArray[$entriesArray[$i]] = $matches[1];
        } 

        return $newArray;     
    }
    
    return '';
}

/*******************************************************************************
Get the stored flag data for this IP - used instead of cookies
/******************************************************************************/
function GetDBCookie($ip) {
    $db_query = tep_db_query("select data from view_counter_flags where ip_number = INET_ATON('" . tep_db_input($ip) . "')");
    if (tep_db_num_rows($db_query)) {
        $db = tep_db_fetch_array($db_query);
        return $db['data'];
    }
    return '';
}
    
function GetDomainLocation($ip) {
    $visitorGeolocation = array();
    $storedData = GetDBCookie($ip);
      
  
    if (! $storedData) {
        $visitorGeolocation = GetIPDetails($ip);

        if (! isset($visitorGeolocation['Country Code'])) {
            $visitorGeolocation['Country Code'] = '';
        }
        
        if (tep_not_null($visitorGeolocation['Country Code'])) {
            $data = base64_encode(serialize($visitorGeolocation));
            tep_db_query("insert into view_counter_flags (ip_number, data) values (inet_aton('" . $ip . "'), '" . $data . "')");
        }
    } else {
        $visitorGeolocation = unserialize(base64_decode($storedData));
    }
    
    return $visitorGeolocation;
}

/*******************************************************************************
Common function to make managing the possible entries easier
/******************************************************************************/
function GetEntriesArray($type = 0) {
    switch ($type) {
        case 0: $entriesArray = array('IP Address','Country Code','Country Name','Region Name','Areacode','City Name','latitude',
                 'Longitude','IP Number','zipCode','timeZone','isp','domainName','netSpeed','iddCode',
                 'weatherStationCode','weatherStationName','mcc','mnc','mobileCarrierName', 'elevation', 'usageType');
        break;
    
        case 1: $entriesArray = array(0 => 'IP Address',1 => 'Country Code',2 => 'Country Name',3 => 'Region Name',4 => 'Areacode',5 => 'City Name',6 => 'Latitude',7 => 'Longitude');
        break;
        
        //hostip
        case 2: $entriesArray = array(0 => 'IP Address',1 => 'Country Name',2 => 'Country Code');
        break;
    
        default: $entriesArray = array('ipAddress','ipNumber','countryCode','countryName','regionName','cityName','latitude',
                 'longitude','zipCode','timeZone','isp','domainName','netSpeed','iddCode','areaCode',
                 'weatherStationCode','weatherStationName','mcc','mnc','mobileCarrierName', 'elevation', 'usageType');
    }           
                             
    return $entriesArray;             
}                             

/*******************************************************************************
Load the .htaccess file into an array
/******************************************************************************/
function GetHtaccessFileContents(&$htaccessfile = '', $name_only = false) {
    $separator = ((substr(DIR_FS_CATALOG, -1) != '/') ? '/' : '');
    $htaccessfile = DIR_FS_CATALOG . $separator . '.htaccess';

    if ($name_only) {  //the contents are not needed so return
        return true;
    }

    if (file_exists($htaccessfile)) {
        $htaccessArray = file($htaccessfile);
        return $htaccessArray;
    }
    return false;
}

/*******************************************************************************
Returns a comman separated string used in a DB call to prevent IP's from
showing if they are in a CIDR
/******************************************************************************/
function GetInCIDRStr($htaccessfile, $storage_table, $language_id, $show_only_this_ip, $showType, $hideAdminLinks, $sortBy, $whereActive,  $whereSpoofed) {
    $view_query = tep_db_query("select vc.ip_number from " . $storage_table . " vc where vc.ip_number NOT in (select vcb.ip_number from view_counter_banned vcb where ignore_status <> 1 ) and ip_active=1 and language_id = " . (int)$language_id . $show_only_this_ip . $showType . $whereActive . $whereSpoofed . $hideAdminLinks . $sortBy . " ");
    $inCIDRStr = '';
    $inCIDRArray = array();

    $ctr = 0;
    while ($view = tep_db_fetch_array($view_query)) {
        if (! isset($inCIDRArray[$view['ip']])) {
            $check = false;
            if (IsIPinCIDR($view['ip'], $htaccessfile, $check) && $check) {
                $inCIDRArray[$view['ip']] = $ctr++;
            }
        }
    }

    if (count($inCIDRArray) > 1) {
        $inCIDRArray = array_flip($inCIDRArray);
        $inCIDRStr = implode("','", $inCIDRArray);
        $inCIDRStr = " and ( INET_NTOA(vc.ip_number) NOT IN  ( '" . $inCIDRStr . "' ))";
    }

    return $inCIDRStr;
}

function GetInCIDRStrOrig($htaccessfile, $storage_table, $language_id, $show_only_this_ip, $showType, $hideAdminLinks, $sortBy, $whereActive,  $whereSpoofed) {
    $view_query = tep_db_query("select vc.ip_number from " . $storage_table . " vc where vc.ip_number NOT in (select vcb.ip_number from view_counter_banned vcb where ignore_status <> 1 ) and ip_active=1 and language_id = " . (int)$language_id . $show_only_this_ip . $showType . $whereActive . $whereSpoofed . $hideAdminLinks . $sortBy . " ");
    $inCIDRStr = '';
    $inCIDRArray = array();

    while ($view = tep_db_fetch_array($view_query)) {
        if (! in_array($view['ip'], $inCIDRArray)) {
            $check = false;
            if (IsIPinCIDR($view['ip'], $htaccessfile, $check) && $check) {
                $inCIDRArray[] = $view['ip'];
            }
        }
    }

    if (count($inCIDRArray) > 1) {
        $inCIDRStr = implode("','", $inCIDRArray);
        $inCIDRStr = " and ( INET_NTOA(vc.ip_number) NOT IN  ( '" . $inCIDRStr . "' ))";
    }

    return $inCIDRStr;
}

/*******************************************************************************
Returns the longest str
/******************************************************************************/
function GetLongestStr($pName, $longest) {
    $nameLength = strlen($pName); //get the longest name for better appearance

    if ($nameLength > $longest) {
        $longest = $nameLength;
    }

    return $longest;
}

/*******************************************************************************
Get the sorting method and direction based on the column clicked
/******************************************************************************/
function GetSorting(&$sortByArray, &$sortBy, $cond, &$sortDirection) {
    $direction = ' asc ';

    // Get the direction
    switch ($cond) {
        case TEXT_SORT_BY_ARG:
        case TEXT_SORT_BY_PAGE_ARG: $direction = ((strpos($sortBy, 'arg') !== FALSE) ?  ((strpos($sortBy, 'asc') !== FALSE) ? ' desc ' : ' asc ') : ' asc '); break;
        
        case TEXT_SORT_BY_COUNT: 
        case TEXT_SORT_BY_PAGE_COUNT: $direction = ((strpos($sortBy, 'view_count') !== FALSE) ?  ((strpos($sortBy, 'asc') !== FALSE) ? ' desc ' : ' asc ') : ' asc '); break;
        
        case TEXT_SORT_BY_DATE: $direction = ((strpos($sortBy, 'date') !== FALSE) ?  ((strpos($sortBy, 'asc') !== FALSE) ? ' desc ' : ' asc ') : ' asc '); break;
        
        case TEXT_SORT_BY_FILENAME:
        case TEXT_SORT_BY_PAGE_FILENAME: $direction = ((strpos($sortBy, 'file_name') !== FALSE) ?  ((strpos($sortBy, 'asc') !== FALSE) ? ' desc ' : ' asc ') : ' asc '); break;
        
        case TEXT_SORT_BY_IP: 
        case TEXT_SORT_BY_PAGE_IP: $direction = ((strpos($sortBy, 'ip') !== FALSE) ?  ((strpos($sortBy, 'asc') !== FALSE) ? ' desc ' : ' asc ') : ' asc '); break;

        case TEXT_SORT_BY_ISBOT: 
        case TEXT_SORT_BY_PAGE_ISBOT: $direction = ((strpos($sortBy, 'isbot') !== FALSE) ?  ((strpos($sortBy, 'asc') !== FALSE) ? ' desc ' : ' asc ') : ' asc '); break;
        
        case TEXT_SORT_BY_VISITOR: $direction = ((strpos($sortBy, 'visitor') !== FALSE) ?  ((strpos($sortBy, 'asc') !== FALSE) ? ' desc ' : ' asc ') : ' asc '); break;
    }

    $sortDirection[$cond] = (strpos($direction, 'desc') !== FALSE ? '<img style="padding-left:3px; vertical-align: middle; margin-top: -1px;" src="images/view_counter/vc_arrow_down.gif" alt="">' : 
                                                                    '<img style="padding-left:3px; vertical-align: middle; margin-top: -1px;" src="images/view_counter/vc_arrow_up.gif" alt="">');
    
    //Set the column and direction
    switch ($cond) {
        case TEXT_SORT_BY_ARG: 
        case TEXT_SORT_BY_PAGE_ARG: $sortByArray = array('date' => '', 'filename' => '', 'ip' => '', 'count' => '', 'arg' => 'checked', 'visitor' => '', 'isbot' => ''); $sortBy = ' order by arg ' . $direction; break;
        
        case TEXT_SORT_BY_COUNT: 
        case TEXT_SORT_BY_PAGE_COUNT: $sortByArray = array('date' => '', 'filename' => '', 'ip' => '', 'count' => 'checked', 'arg' => '', 'visitor' => '', 'isbot' => ''); $sortBy = ' order by view_count ' . $direction; break;
        
        case TEXT_SORT_BY_DATE: $sortByArray = array('date' => 'checked', 'filename' => '', 'ip' => '', 'count' => '', 'arg' => '', 'visitor' => '', 'isbot' => ''); $sortBy = ' order by last_date ' . $direction; break;
        
        case TEXT_SORT_BY_FILENAME: 
        case TEXT_SORT_BY_PAGE_FILENAME: $sortByArray = array('date' => '', 'filename' => 'checked', 'ip' => '', 'count' => '', 'arg' => '', 'visitor' => '', 'isbot' => ''); $sortBy = ' order by file_name ' . $direction; break;
        
        case TEXT_SORT_BY_IP: 
        case TEXT_SORT_BY_PAGE_IP: $sortByArray = array('date' => '', 'filename' => '', 'ip' => 'checked', 'count' => '', 'arg' => '', 'visitor' => '', 'isbot' => ''); $sortBy = ' order by ip ' . $direction; break;

        case TEXT_SORT_BY_ISBOT: 
        case TEXT_SORT_BY_PAGE_ISBOT: $sortByArray = array('date' => '', 'filename' => '', 'ip' => '', 'count' => '', 'arg' => '', 'visitor' => '', 'isbot' => 'checked'); $sortBy = ' order by isbot ' . $direction; break;
        
        case TEXT_SORT_BY_VISITOR: $sortByArray = array('date' => '', 'filename' => '', 'ip' => '', 'count' => '', 'arg' => '', 'visitor' => 'checked', 'isbot' => ''); $sortBy = ' order by bot_name ' . $direction; break;
        
        default: $sortByArray = array('date' => '', 'filename' => 'checked', 'ip' => '', 'count' => '', 'arg' => '', 'visitor' => '', 'isbot' => ''); $sortBy = ' order by file_name asc '; 
    }
}

/*******************************************************************************
Get the color of the column background for mouseovers
/******************************************************************************/
function GetSortingColumColor($sortByArray, $colors) {
    $menuArray = array();
    $menuNames = array(array('name' => 'visitor',  'col' => TEXT_SORT_BY_VISITOR),
                       array('name' => 'filename', 'col' => TEXT_SORT_BY_FILENAME),
                       array('name' => 'arg',      'col' => TEXT_SORT_BY_ARG),
                       array('name' => 'count',    'col' => TEXT_SORT_BY_COUNT),
                       array('name' => 'ip',       'col' => TEXT_SORT_BY_IP),
                       array('name' => 'date',     'col' => TEXT_SORT_BY_DATE)
                      );
                      
    foreach ($menuNames as $menu) {
        $menuArray[$menu['name']] = 'onClick="SortColumn(\'' . $menu['col'] . '\',\'view_counter_form\')" style="background-color:' . ($sortByArray[$menu['name']] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : '') . '" onmouseover="this.style.background=\'' . $colors[COLOR_SELECTED_COLUMN_HIGHLIGHT] . '\';" onmouseout="this.style.background=\'' . ($sortByArray[$menu['name']] == 'checked' ? $colors[COLOR_SELECTED_COLUMN] : '') . '\';" ';
    }

    return $menuArray;
}                            

/*******************************************************************************
Returns the description of who's online
/******************************************************************************/
function GetVisitorName($bot_name) {
    return (tep_not_null($bot_name) ? $bot_name : TEXT_GUEST);
}

/*******************************************************************************
Create a backup of the .htaccess file
/******************************************************************************/
function HtaccessBackup(&$type) {
    $arrayWrite = array();
    $type = 'error';     

    $separator = ((substr(DIR_FS_CATALOG, -1) != '/') ? '/' : '');
    $backupDir = DIR_FS_CATALOG . $separator . TEXT_HTACCESS_BACKUP_LOCN;
    
    if (! is_dir($backupDir)) {
        if (! mkdir($backupDir, 0755)) {
            return ERROR_HTACCESS_BACKUP_DIR_FAILED;
        }
    }

    $backupDir .= '/';
    $htaccessfileOrig = DIR_FS_CATALOG . $separator . '.htaccess';
    $htaccessfileBkup = $backupDir . '.htaccess_bkup_'. date('Y-m-d');

    $result = copy($htaccessfileOrig, $htaccessfileBkup);

    if ($result) {
        $type = 'success';
        return SUCCESS_HTACCESS_BACKUP;
    } else {
        return ERROR_HTACCESS_WRITE_FAILED;
    }   
} 

/*******************************************************************************
Rebuild the .htaccess file by adding in the View Counter code
/******************************************************************************/
function HtaccessRebuild(&$type) {
    $arrayWrite = array();
    $htaccessfile = '';
    $type = 'error';     
    
    $arrayWrite = GetHtaccessFileContents($htaccessfile);
    
    if ($arrayWrite) {   
    
        $result = HtaccessBackup($type);
        if ($type == 'error') {
            return $result; 
        } else {
            $result = '';
            $type = 'error'; //exit - can't do backup or reset error condition
        }            
        
        $blockArray = array();
        $blockArray[] =  "\n" . '# Begin IP deny by View Counter from www.oscommerce-solution.com' . "\n";
        $blockArray[] = 'order allow,deny' . "\n";
        
        $db_query = tep_db_query("select INET_NTOA(ip_number) as ip_number, ip_string from view_counter_banned where ignore_status = 0");
        if (tep_db_num_rows($db_query) > 0) {
            while ($db = tep_db_fetch_array($db_query)) {
                $ip = ($db['ip_number'] > 0 ? $db['ip_number'] : $db['ip_string']);
                $blockArray[] = 'deny from '. $ip . "\n";
            }
        }
        $blockArray[] = 'allow from all' . "\n";
        $blockArray[] = '# End IP deny by View Counter from www.oscommerce-solution.com';
        
        $arrayWrite = array_merge($arrayWrite, $blockArray);
        $arrayWrite = CleanHtaccess($arrayWrite);
        $result = WriteHTAccess($htaccessfile, $arrayWrite);  

        if ($result) {
            $type = 'success';
            return SUCCESS_HTACCESS_REBUILD;
        } else {
            return ERROR_HTACCESS_WRITE_FAILED;
        }         
    } else {
          return ERROR_HTACCESS_NOT_FOUND;    
    }    
}

/*******************************************************************************
Rebuild the banned list from the .htaccess file
/******************************************************************************/
function HtaccessRebuildBannedList(&$type) {
    $arrayWrite = array();
    $htaccessfile = '';
    $type = 'error';     

    $arrayWrite = GetHtaccessFileContents($htaccessfile);
    
    if ($arrayWrite) { 
        $bannedArray = array();
        $cnt = count($arrayWrite);
        $result = false;
        
        for ($i =0; $i < $cnt; ++$i) {
                
            if (($pos = strpos($arrayWrite[$i], 'deny from')) !== FALSE) {
                $result = true;
                $ip = trim(substr($arrayWrite[$i], $pos + 10));

                if (IsValidIP($ip)) { //it's an ip or a cidr   
                    $db_query = tep_db_query("select 1 from view_counter_banned where ip_number = INET_ATON('" . $ip . "') and ignore_status = 0");
                    if (tep_db_num_rows($db_query)) {
                        continue;
                    }    
                
                    if (strpos($ip, '/') == FALSE) {
                        tep_db_query("insert ignore into view_counter_banned (ip_number, ignore_status) values (INET_ATON('" . $ip . "'), '0')");
                    } else {
                        tep_db_query("insert ignore into view_counter_banned (ip_string, ignore_status) values ('". tep_db_input($ip) . "', '0')");
                    }    
                } else if (IsValidDomainName($ip)) {
                    $db_query = tep_db_query("select 1 from view_counter_banned where ip_string = '" . tep_db_input($ip) . "' and ignore_status = 0");
                    if (tep_db_num_rows($db_query)) {
                        continue;
                    }                      
                    tep_db_query("insert ignore into view_counter_banned (ip_string, ignore_status) values ('". tep_db_input($ip) . "', '0')");
                }
            }                       
        } 
        
        $ip_array = array();
        $db_query = tep_db_query("select distinct ip_number, ip_string, ignore_status from view_counter_banned order by ip_number");
        while ($db = tep_db_fetch_array($db_query)) {
            if ($db['ip_number'] == 0 && empty($db['ip_string'])) { 
                continue;
            } 
            $ip_array[] = $db;
        }
        
        tep_db_query("truncate view_counter_banned");
        foreach ($ip_array as $arr) {
           tep_db_query("insert into view_counter_banned (ip_number, ip_string, ignore_status) values ('" . $arr['ip_number'] . "', '" . $arr['ip_string']. "', '" .$arr['ignore_status'] . "')");
        } 
        
        if ($result) {
            $type = 'success';
            return SUCCESS_HTACCESS_REBUILD_BANNED;
        } else {
            return ERROR_HTACCESS_WRITE_FAILED;
        }         
    }
    return ERROR_HTACCESS_NOT_FOUND;    
}

/*******************************************************************************
Restore the .htaccess file from backup
/******************************************************************************/
function HtaccessRestore($srcfile, &$type) {
    $arrayWrite = array();
    $type = 'error';     

    $separator = ((substr(DIR_FS_CATALOG, -1) != '/') ? '/' : '');
    $backupDir = DIR_FS_CATALOG . $separator . TEXT_HTACCESS_BACKUP_LOCN;    

    $backupDir .= '/';
    $htaccessfileOrig = '';
    GetHtaccessFileContents($htaccessfileOrig, true);
    $htaccessfileBkup = $backupDir . $srcfile;

    if (file_exists($htaccessfileBkup)) {    
        $arrayWrite = file($htaccessfileBkup);  
 
        $result = WriteHTAccess($htaccessfileOrig, $arrayWrite);        
        if ($result) {
            $type = 'success';
            return SUCCESS_HTACCESS_REBUILD;
        } else {
            return ERROR_HTACCESS_WRITE_FAILED;
        }         
    } else {
          return ERROR_HTACCESS_NOT_FOUND;    
    }  
} 

/*******************************************************************************
Whitelist an IP - adds an entry in the .htaccess file to allow access even if
the ip is in a blocked range
/******************************************************************************/
function HtaccessWhitelistIP($ip, &$type) {
    $db_query = tep_db_query("select 1 from view_counter_banned where (ip_number = INET_ATON('" . $ip . "') or ip_string = '" . tep_db_input($ip) . "')");
    
    if (tep_db_num_rows($db_query) > 0) {
        RemoveBannedIP($ip);
        $type = 'success';
        return SUCCESS_HTACCESS_WHITELISTED_IP;
    } 

    $htaccessfile = '';
    $arrayWrite = GetHtaccessFileContents($htaccessfile);
    
    if ($arrayWrite) { 
        $endLine = '';
 
        $arrayWrite = CleanHtaccess($arrayWrite);  //remove any duplicates that might have crept in   
         
        for ($i = 0; $i < count($arrayWrite); ++$i) {
            if (preg_match('/\b' . $ip . '\b/', $arrayWrite[$i])) {
                $type = 'success';
                return SUCCESS_HTACCESS_WHITELISTED_IP;
            }
        }
        
        reset($arrayWrite);

        for ($i = 0; $i < count($arrayWrite); ++$i) {
            if (strpos(addslashes($arrayWrite[$i]), '# End IP allow by View Counter from www.oscommerce-solution.com') !== FALSE) {
                $endLine = $i;
                break;
            }            
        }

        reset($arrayWrite);
        
        if ($endLine) {  //htaccess already has View Counter changes so add to them
            $arrayTmp = array();
            $arrayTmp[] = 'allow from ' . $dot . $ip . PHP_EOL;
            array_splice($arrayWrite, $endLine - 1, 0, $arrayTmp);
        } else {        
            $arrayWrite[] = '# Begin IP allow by View Counter from www.oscommerce-solution.com' . PHP_EOL;      
            $arrayWrite[] = 'order allow,deny' . PHP_EOL;
            $arrayWrite[] = 'allow from ' . $dot . $ip . PHP_EOL;
            $arrayWrite[] = '# End IP allow by View Counter from www.oscommerce-solution.com' . PHP_EOL;
        }
    } else { //create a new file
        $arrayWrite[] = '# Begin IP allow by View Counter from www.oscommerce-solution.com' . PHP_EOL;      
        $arrayWrite[] = 'order allow,deny' . PHP_EOL;
        $arrayWrite[] = 'allow from ' . $dot . $ip . PHP_EOL;
        $arrayWrite[] = '# End IP allow by View Counter from www.oscommerce-solution.com' . PHP_EOL;
    }
    
    if (! empty($arrayWrite)) {
        if (WriteHTAccess($htaccessfile, $arrayWrite)) {
            tep_db_query("update view_counter set ip_active=1 where ip_number = INET_ATON('" . $ip . "')");
            $type = 'success';
            return SUCCESS_HTACCESS_WHITELISTED_IP;
        } else {
            return ERROR_HTACCESS_WRITE_FAILED;
        }  
    }      
}

/*******************************************************************************
Add the given IP as an ignored IP or a banned IP, depending upon the type
/******************************************************************************/
function IgnoreThisIP($ip, $type = 1) {
    $ip_query = tep_db_query("select 1 from view_counter_banned where (ip_number = INET_ATON('" . $ip . "') or ip_string = '" . tep_db_input($ip) . "') and ignore_status = 1");
    if (tep_db_num_rows($ip_query) > 0) { //already being ignored
        return;
    }    
    
    if (strpos($ip, '/') !== FALSE || IsValidDomainName($ip)) {
        $ips_query = tep_db_query("select distinct INET_NTOA(ip_number) as ip from view_counter");
        $match = false;

        while ($ips = tep_db_fetch_array($ips_query)) {
            if (IPinCIDR($ips['ip'], $ip) == 1) {
                $sqlStr .= " ip_number = INET_ATON('" . $ips['ip'] . "') or ";
                $match = true;
            }
        }
 
        if ($match) {
            $sqlStr = '( ' . substr($sqlStr, 0, -3) . ' )';
            tep_db_query("update view_counter set ip_active=0 where " . $sqlStr);
        }
        tep_db_query("insert ignore into view_counter_banned (ip_string, ignore_status) values ('" . tep_db_input($ip) . "', " . (int)$type . ")");
    } else {
        tep_db_query("update view_counter set ip_active=0 where ip_number = INET_ATON('" . $ip . "')");
        tep_db_query("insert ignore into view_counter_banned (ip_number, ignore_status) values (INET_ATON('" . $ip . "'), " . (int)$type . ")");
    } 
}

/*******************************************************************************
Checks if the given IP is in the CIDR
/******************************************************************************/
function IPinCIDR($ip, $cidr) {
    list ($subnet, $bits) = explode('/', $cidr);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask; 
    return ($ip & $mask) == $subnet;
}
function IPRangeToCIDR($ips) {     
    $resultArray = array(); 
     
    $num = ip2long(trim($ips[1])) - ip2long(trim($ips[0])) + 1;     
    $bin = decbin($num);       
    $chunk = str_split($bin);     
    $chunk = array_reverse($chunk);     
    $start = 0;       
    while ($start < count($chunk)) {         
        if ($chunk[$start] != 0) {
            $start_ip = isset($range) ? long2ip(ip2long($range[1]) + 1) : $ips[0];             
            $range = cidr2ip($start_ip . '/' . (32 - $start));             
            $resultArray[] = $start_ip . '/' . (32 - $start);         
        }         
        $start++;     
    }    

    return str_replace(' ', '', $resultArray); 
}

function cidr2ip($cidr) { 
    $ip_arr = explode('/', $cidr);     
    $start = ip2long($ip_arr[0]);     
    $nm = $ip_arr[1];     
    $num = pow(2, 32 - $nm);     
    $end = $start + $num - 1;     
    return array($ip_arr[0], long2ip($end)); 
} 

/*******************************************************************************
Provides every IP in the CIDR. Not currently used. The results can be in the
millions and takes a very long time.
/******************************************************************************/
function cidr2ipFull($cidr) {   
      $ip_addr_cidr = $cidr;
    $ip_arr = explode('/', $ip_addr_cidr);

    $bin = '';
    for($i=1;$i<=32;$i++) {
        $bin .= $ip_arr[1] >= $i ? '1' : '0';
    }
    $ip_arr[1] = bindec($bin);

    $ip = ip2long($ip_arr[0]);
    $nm = ip2long($ip_arr[1]);
    $nw = ($ip & $nm);
    $bc = $nw | (~$nm);

    echo "Number of Hosts:    " . ($bc - $nw - 1) . "<br/>";
    echo "Host Range:         " . long2ip($nw + 1) . " -> " . long2ip($bc - 1) . "<br/>". "<br/>";

    $check = '127.0.0.1';
    $ipa = array();
    for($zm=1;($nw + $zm)<=($bc - 1);$zm++) {
        if (long2ip($nw + $zm) == $check) {
            return true;
        }  
    }
    return false;    
 }

/*******************************************************************************
Checks if the given IP is any of the ranges in the .htaccess file
/******************************************************************************/
function IsIPInCidr($ip, $htaccessArray, &$result) {
    if ($htaccessArray) {
       if ($ip) {
           $offset = strlen('deny from ');
           $items = count($htaccessArray);
           
           for ($i = 0; $i < $items; ++$i) {
               if (strpos($htaccessArray[$i], 'deny') !== FALSE && strpos($htaccessArray[$i], '/') !== FALSE) {
                   $cidr = trim(substr($htaccessArray[$i], $offset));
               
                   if (IPinCIDR($ip, $cidr)) {
                       $result = true;
                       return sprintf(TEXT_IP_IN_CIDR_FOUND, $ip, $cidr);
                   } 
               }
           }

           $result = false;           
           return sprintf(TEXT_IP_IN_CIDR_NOT_FOUND, $ip);
       }    
    }   
    
    $result = false;           
    return ERROR_HTACCESS_NOT_FOUND;
}

/*******************************************************************************
Checks for a valid domain name - assumes no more than two dots and the rest
alphnumeric
/******************************************************************************/
function IsValidDomainName($domain) {
    $cnt = substr_count($domain, '.');
    if ($cnt > 0 && $cnt < 3) {   //the domain name has to have at least one dot but no more than two
        $tmp = str_replace('.', '', $domain);
        if (ctype_alnum($tmp)) {
            return true;
        }    
    }    
    return false;
}

/*******************************************************************************
Checks for a valid IP address or optionally a cidr notation range
e.g. 1.2.3.4 or 1.2.3.0/24
/******************************************************************************/
function IsValidIP($cidr) {
    if ($cidr == '0.0.0.0') return false;
    
    if(! preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(\/[0-9]{1,2}){0,1}$/i", $cidr)) {
        $return = FALSE;
    } else {
        $return = TRUE;
    }
    
    if ( $return == TRUE ) {
        $parts = explode("/", $cidr);
        $ip = $parts[0];
        $netmask = $parts[1];
        $octets = explode(".", $ip);

        foreach ( $octets AS $octet ) {
            if ( $octet > 255 ) {
                $return = FALSE;
            }
        }

        if ( ( $netmask != "" ) && ( $netmask > 32 ) ) {
            $return = FALSE;
        }

    }
    return $return;
}

/*******************************************************************************
Kick the given IP off of the shop
/******************************************************************************/
function KickOffIP($ip, $session, $msg = '') {
    tep_db_query("insert into view_counter_session_kill (session_id, session_msg) values ('" . tep_db_input($session) . "', '" . tep_db_input($msg) . "')");     
}

/*******************************************************************************
Load just the color settings and the selected preset mode 
/******************************************************************************/
function LoadColorSettings(&$colors) {
    $mode = COLOR_PRESET_DEFAULT;
    $settings_query = tep_db_query("select * from view_counter_settings");

    if (tep_db_num_rows($settings_query)) {
        $settings = tep_db_fetch_array($settings_query);
        $color = array();
        $colors = unserialize( base64_decode( $settings['colors'] ) );        
        $mode = $colors['mode'];
        unset($colors['mode']);
    }
    
    return $mode;
}

/*******************************************************************************
Load the last settings - full set
/******************************************************************************/
function LoadSettings(&$show_only_active, &$show_only_spoofed, &$showType, &$showTypeArray, &$sortBy, &$sortByArray, &$sortDirectionArray, &$display_table, &$colors, $page_name = 'monitor') {
    $settings_query = tep_db_query("select * from view_counter_settings where page_name = '" . tep_db_input($page_name) . "'");

    if (tep_db_num_rows($settings_query)) {     
        $settings = tep_db_fetch_array($settings_query);
        $show_only_active = $settings['view_active'];
        $show_only_spoofed = $settings['view_spoofed'];
        $showType = $settings['show_type'];
        $showTypeArray = unserialize( base64_decode( $settings['show_type_array'] ) );
        $sortBy = $settings['sort_by'];
        $sortByArray = unserialize( base64_decode( $settings['sort_by_array'] ) );  
        $sortDirectionArray = unserialize( base64_decode( $settings['sort_direction_array'] ) );  
        $display_table = $settings['display_table'];
        $colors = unserialize( base64_decode( $settings['colors'] ) );   
    }
}

/*******************************************************************************
Load the last settings - reports only
/******************************************************************************/
function LoadSettingsReports($page_name, &$group_data) {
    $settings_query = tep_db_query("select group_data from view_counter_settings where page_name = '" . tep_db_input($page_name) . "'");

    if (tep_db_num_rows($settings_query)) {     
        $settings = tep_db_fetch_array($settings_query);
        $group_data = unserialize( base64_decode( $settings['group_data'] ) );
        return true;
    }
    
    return false;
}

/*******************************************************************************
Remove the given IP from the the banned DB table and the .htaccess file
/******************************************************************************/
function RemoveBannedIP($ip) {
    $arrayWrite = array();
    $htaccessfile = '';
    $arrayWrite = GetHtaccessFileContents($htaccessfile);
    
    if ($arrayWrite) { 
        $endLine = '';
        
        $dot = (IsValidDomainName($ip) ? '.' : '');
        
        for ($i = 0; $i < count($arrayWrite); ++$i) {
            if (strpos($arrayWrite[$i], 'deny from ' .$dot . $ip) !== FALSE) {
                unset($arrayWrite[$i]);
            }            
        }
        
        reset($arrayWrite);
                
        if (! WriteHTAccess($htaccessfile, $arrayWrite)) {
            return false;
        }
    }    

    RemoveIgnoredIP($ip);
    return true;
}


/*******************************************************************************
Remove the given IP or Domain name from the the banned DB table and the .htaccess 
file.
/******************************************************************************/
function RemoveIgnoredIP($ip) {
    if (strpos($ip, '/') !== FALSE || IsValidDomainName($ip)) {
        $ips_query = tep_db_query("select distinct INET_NTOA(ip_number) as ip from view_counter");
        $match = false;

        while ($ips = tep_db_fetch_array($ips_query)) {
            if (IPinCIDR($ips['ip'], $ip) == 1) {
                $sqlStr .= " ip_number = INET_ATON('" . $ips['ip'] . "') or ";
                $match = true;
            }
        }

        if ($match) {
            $sqlStr = '( ' . substr($sqlStr, 0, -3) . ' )';
            tep_db_query("update view_counter set ip_active=1 where " . $sqlStr);
        }
        tep_db_query("delete from view_counter_banned where ip_string = '" . tep_db_input($ip) . "'");
    } else {
        tep_db_query("update view_counter set ip_active=1 where ip_number = INET_ATON('" . $ip . "')");
        tep_db_query("delete from view_counter_banned where ip_number = INET_ATON('" . $ip . "')");
    } 
}

/*******************************************************************************
Save the current settings 
/******************************************************************************/
function SaveColorSettings($post) {

    $mode = COLOR_PRESET_DEFAULT;
    foreach ($post as $id => $color) {
        if ($id == 'update' || $id == 'color_preset' || $id == 'osCAdminID') { //remove known non-color posts
            if ($id == 'color_preset') {
                $mode = $color;     //save the selected mode
            }
            unset ($post[$id]);
        } else if (strpos($color, '#') === FALSE) {
            return false;
        }
    }

    $post['mode'] = $mode;
    $colors = base64_encode( serialize( $post) );  
    $check_query = tep_db_query("select 1 from view_counter_settings");    

    if (tep_db_num_rows($check_query) > 0) {
        tep_db_query("update view_counter_settings set colors = '" . tep_db_input($colors) . "' where page_name='monitor'"); 
    } else {    
        $sortByArray = array('date' => '', 'filename' => 'checked', 'ip' => '', 'count' => '');
        $sortBy = ' order by file_name asc ';
        $showTypeArray = array('bots' => '', 'customers' => 'checked', 'both' => '');
        $showType = ' and isbot = 0 ';
        $show_only_active = '';
        $show_only_spoofed = '';
        $display_table = '';

        $stringShow = base64_encode( serialize( $showTypeArray ) );  
        $stringSort = base64_encode( serialize( $sortByArray ) );         
        
        tep_db_query("insert into view_counter_settings (page_name, view_active, view_spoofed, show_type, show_type_array, sort_by, sort_by_array, display_table, colors) values ('monitor', '" . tep_db_input($show_only_active) . "', '" . tep_db_input($show_only_spoofed) . "', '" . tep_db_input($showType) . "','" . $stringShow . "', '" . tep_db_input($sortBy) . "','" . $stringSort . "','" . $display_table . "','" . $colors . "')");
    }        
}

/*******************************************************************************
Save the current settings - monitor only but can be shared
/******************************************************************************/
function SaveSettings($show_only_active, $show_only_spoofed, $showType, $showTypeArray, $sortBy, $sortByArray, $sortDirectionArray, $display_table, $page_name = 'monitor') {
    $check_query = tep_db_query("select 1 from view_counter_settings");    
       
    $stringShow = base64_encode( serialize( $showTypeArray ) );  
    $stringSort = base64_encode( serialize( $sortByArray ) ); 
    $stringDirc = base64_encode( serialize( $sortDirectionArray ) ); 
    $showType   =  tep_db_prepare_input($showType);    

    if (tep_db_num_rows($check_query) > 0) {
        tep_db_query("update view_counter_settings set page_name = '" . tep_db_input($page_name) . "', view_active = '" . tep_db_input($show_only_active) . "', view_spoofed = '" . tep_db_input($show_only_spoofed) . "', show_type = '" . tep_db_input($showType) . "', show_type_array = '" . $stringShow . "', sort_by = '" . tep_db_input($sortBy) . "', sort_by_array = '" . $stringSort . "', sort_direction_array = '" . $stringDirc . "', display_table = '" . tep_db_input($display_table) . "'"); 
    } else {    
        tep_db_query("insert into view_counter_settings (page_name, view_active, view_spoofed, show_type, show_type_array, sort_by, sort_by_array, sort_direction_array, display_table, colors) values ('" . tep_db_input($page_name) . "', '" . tep_db_input($show_only_active) . "', '" . tep_db_input($show_only_spoofed) . "', '" . tep_db_input($showType) . "', '" . $stringShow . "', '" . tep_db_input($sortBy) . "','" . $stringSort . "','" . $stringDirc . "','" . tep_db_input($display_table) . "', '')");
    }        
}

/*******************************************************************************
Save the current report settings
/******************************************************************************/
function SaveSettingsReports($page_name, $group_data) {
    $check_query = tep_db_query("select 1 from view_counter_settings where page_name = '" . tep_db_input($page_name) . "'");    
       
    $group_data = base64_encode( serialize( $group_data ) );  

    if (tep_db_num_rows($check_query) > 0) {
        tep_db_query("update view_counter_settings set group_data = '" . tep_db_input($group_data) . "' where page_name = '" . tep_db_input($page_name) . "'"); 
    } else {    
        tep_db_query("insert into view_counter_settings (page_name, group_data) values ('" . tep_db_input($page_name) . "', '" . tep_db_input($group_data) . "')");
    }        
}

/*******************************************************************************
Search a multi-array for the given needle
/******************************************************************************/
function VC_in_multi_array($needle, $haystack) {
    $in_multi_array = false;
    
    if(in_array($needle, $haystack)) {
        $in_multi_array = true;
    } else {
        foreach ($haystack as $key => $val) {
            if(is_array($val)) {
                if(VC_in_multi_array($needle, $val)) {
                    $in_multi_array = true;
                    break;
                }
            }
        }
    }
    return $in_multi_array;
}

  
/*******************************************************************************
Remove all apostrophes for use with ddrivetip code since they cause that code
to fail. Addslashes works in some cases but not all so it is best to just
remove them.
/******************************************************************************/
function RemoveApostrophes($string) {
   $string=str_replace('&#39;', '', $string);
   $string=str_replace("'", "", $string);
   $string=str_replace('"', '', $string);
   $string=preg_replace("/\\r\\n|\\n|\\r/", "<BR>", $string); 
   return $string;
}  

/*******************************************************************************
Show the customers account details if an account exists. If multiple accounts
exist, they are all show
/******************************************************************************/
function ShowAccountDetails($view, &$displayName, &$showPopup) {
    if (! tep_not_null($view['bot_name'])) {
        $displayName = TEXT_GUEST;
        return htmlspecialchars('<div style="clear:both;">' . TEXT_ACCOUNT_DETAILS_NOT_FOUND . '</div>');
    } else if ($view['isbot']) {
        $displayName = $view['bot_name'];
        $str = '<div class="accountDetail">' . $view['user_agent'] .'</div>';
        $showPopup = true;
        return htmlspecialchars($str);
    }
    
    $displayName = $view['bot_name'];    
 
    $db_query = tep_db_query("select * from customers c left join customers_info ci on c.customers_id = ci.customers_info_id where TRIM(Concat(customers_firstname, ' ', customers_lastname)) = '" . tep_db_input($view['bot_name']) . "'");
    if (tep_db_num_rows($db_query) > 0) {
        $str = '';
        while ($db = tep_db_fetch_array($db_query)) {
            $str .= '<div class="accountDetail accountDetailBorder">' . TEXT_ACCOUNT_DETAILS_EMAIL_ADDRESS . $db['customers_email_address'] .'</div>';
            $str .= '<div class="accountDetail">' . TEXT_ACCOUNT_DETAILS_PHONE . $db['customers_telephone'] .'</div>';
            $str .= '<div class="accountDetail">' . TEXT_ACCOUNT_DETAILS_CREATED_ON . $db['customers_info_date_account_created'] .'</div>';
            $str .= '<div class="accountDetail">' . TEXT_ACCOUNT_DETAILS_LAST_ACCESSED_ON . $db['customers_info_date_of_last_logon'] .'</div>';
            $str .= '<div class="accountDetail">' . TEXT_ACCOUNT_DETAILS_NUMBER_OF_LOGONS . $db['customers_info_number_of_logons'] .'</div>';
            
        }
        $showPopup = true;
        $str .= '<div class="accountDetailBorder"><div>';
        return htmlspecialchars($str);
    }    
    
    $showPopup = false;
    return '';
}

/*******************************************************************************
Show the contents of the cart, if active
/******************************************************************************/
function ShowCart($session_id, &$width = 300, $isadmin = '') {

    if (tep_not_null($isadmin)) { 
        return TEXT_CART_ADMIN;        
    }

    if (! tep_not_null($session_id)) {
        return ERROR_SESSION_EMPTY;
    }
    
    $str = '';
    
    $cart_query = tep_db_query("select * from sessions where sesskey = '" . tep_db_input($session_id) . "'");
    if (tep_db_num_rows($cart_query)) {
        $cart = tep_db_fetch_array($cart_query);
        $cartArray = UnserializeSession(trim($cart['value']));
 
        if (count($cartArray['cart']->contents) > 0) {
            $langID = $cartArray['languages_id'];      
            $longest = 0;
            $str = '<div>';
            
            foreach ($cartArray['cart']->contents as $key => $data) {
                foreach ((array)$key as $id) {
                    if (strpos($id, '{') !== FALSE) { //product has attributes
                        $idtmp = trim($id, '[ ]');
                        $pieces = explode('{', $idtmp);
                        $pName = tep_get_products_name($pieces[0], $langID);
                        $longest = GetLongestStr($pName, $longest);
                    
                        $str .= htmlspecialchars('<div class="cartProduct">ID: ' . $pieces[0] .'&nbsp;&nbsp;'. $cartArray['cart']->contents[$id]['qty'] .'&nbsp;x&nbsp;'. RemoveApostrophes($pName) . '</div>'); 
                        $items = count($pieces);
                        
                        for ($i = 1; $i < $items; ++$i) {
                            $attr = explode('}', $pieces[$i]);
                            $option_query = tep_db_query("select products_options_name from products_options where products_options_id = " . (int)$attr[0] . " and language_id = " . $langID); 
                            $option = tep_db_fetch_array($option_query);
                            $value_query = tep_db_query("select products_options_values_name from products_options_values where products_options_values_id = " . (int)$attr[1] . " and language_id = " . $langID); 
                            $value = tep_db_fetch_array($value_query);
                            $str .= htmlspecialchars('<div class="cartAttribute">&nbsp;&nbsp&nbsp;' . TEXT_CART_ATTR . '&nbsp;' . RemoveApostrophes($option['products_options_name']) . ' - '. RemoveApostrophes($value['products_options_values_name']) . '</div>');
                            $pName = TEXT_CART_ATTR . $option['products_options_name'] .$value['products_options_values_name'];
                            $longest = GetLongestStr($pName, $longest);
                        }  
                    } else {
                        $pName = tep_get_products_name($id, $langID);
                        $str .= htmlspecialchars('<div class="cartProduct">ID: ' . $id .'&nbsp;&nbsp;'. $cartArray['cart']->contents[$id]['qty'] .'&nbsp;x&nbsp;'. RemoveApostrophes($pName) . '</div>');
                        $longest = GetLongestStr($pName, $longest);
                    }
                    
                }
            }
            
            require_once('includes/classes/currencies.php');
            $currencies = new currencies();
        
            $str .= htmlspecialchars('<div class="cartTotal">' . TEXT_CART_TOTAL . ' ') .   $currencies->format($cartArray['cart']->total, true, $cartArray['currency']) .'</div>';
            $str .= '</div>';

            $width = ($longest + 6) * 9; //set the width of the box - add 6 characters for non-name text 7 multiply by 9 pixels/character
        } else {
            $str = TEXT_CART_EMPTY;
        }         
    } else {
        $str = TEXT_CART_SESSION_INACTIVE;    
    }
 
    return $str;
}

/*******************************************************************************
Show the details for this IP, if possible
/******************************************************************************/
function ShowIPDetails($record) {
    $str = '';
    
    if (is_array($record)) {
        foreach ($record as $key => $data) {         
            $str .= $key . ': ' . $data . '<br />';               
        } 
    } else {
        $str = TEXT_IP_DETAILS_NOT_FOUND;
    }

    return $str;
}

/*******************************************************************************
Show the name of the product, category, etc. in the listing when possible
/******************************************************************************/
function ShowPageItemName($arg) {
    $db_query = '';
    
    if (($pos = strpos($arg, 'cPath')) !== FALSE) {
        $equal = strpos(substr($arg, $pos), '=');
        if ($equal !== FALSE) {
            $id = (int)substr($arg, $equal + 1);
            $db_query = tep_db_query("select categories_name as name from categories_description where categories_id = " . (int)$id);
        }
        
    } else if (($pos = strpos($arg, 'products_id')) !== FALSE) {
        $equal = strpos(substr($arg, $pos), '=');
        if ($equal !== FALSE) {
            $id = (int)substr($arg, $equal + 1);
            $db_query = tep_db_query("select products_name as name from products_description where products_id = " . (int)$id);
        }
    } else if (($pos = strpos($arg, 'manufacturers_id')) !== FALSE) {
        $equal = strpos(substr($arg, $pos), '=');
        if ($equal !== FALSE) {
            $id = (int)substr($arg, $equal + 1);
            $db_query = tep_db_query("select manufacturers_name as name from manufacturers where manufacturers_id = " . (int)$id);
    }
    }    
    
    if (! empty($db_query) && tep_db_num_rows($db_query) > 0) {
        $db = tep_db_fetch_array($db_query);
        return '&nbsp;(' . (isset($db['name'][VIEW_COUNTER_ITEM_NAME_LENGTH]) ? substr($db['name'], 0, VIEW_COUNTER_ITEM_NAME_LENGTH) : $db['name']) .')';
    }

    return '';
}

function whois_query($domain) {
    global $whoisservers;
    // fix the domain name:
    $domain = strtolower(trim($domain));
    $domain = preg_replace('/^http:\/\//i', '', $domain);
    $domain = preg_replace('/^www\./i', '', $domain);
    $domain = explode('/', $domain);
    $domain = trim($domain[0]);
 
    // split the TLD from domain name
    $_domain = explode('.', $domain);
    $lst = count($_domain)-1;
    $ext = $_domain[$lst];
  
    if (!isset($servers[$ext])){
        die('Error: No matching nic server found!');
    }
 
    $nic_server = $servers[$ext];
 
    $output = '';
 
 
 echo 'nisc '.$nic_server.'<br>';
    // connect to whois server:
    if ($conn = fsockopen ($nic_server, 43)) {
        fputs($conn, $domain."\r\n");
        while(!feof($conn)) {
            $output .= fgets($conn,128);
        }
        fclose($conn);
    }
    else { die('Error: Could not connect to ' . $nic_server . '!'); }
 
    return $output;
}

/*******************************************************************************
Get the whois content of an ip by selecting the correct server 
/******************************************************************************/ 
 function GetWhoIS($ip) {  
     // For the full list of TLDs/Whois servers see wikipedia, http://www.iana.org/domains/root/db/ and http://www.whois365.com/en/listtld/
     //this list ordered with arin and iana at the top since they seem to return the most responses

     $whoisservers = array(
      'net' => 'whois.arin.net',
      'int' => 'whois.iana.org',
      'ac' => 'whois.nic.ac',
      'ae' => 'whois.nic.ae',
      'aero'=> 'whois.aero',
      'af' => 'whois.nic.af',
      'ag' => 'whois.nic.ag',
      'al' => 'whois.ripe.net',
      'am' => 'whois.amnic.net',
      'as' => 'whois.nic.as',
      'asia' => 'whois.nic.asia',
      'at' => 'whois.nic.at',
      'au' => 'whois.aunic.net',
      'az' => 'whois.ripe.net',
      'ba' => 'whois.ripe.net',
      'be' => 'whois.dns.be',
      'bg' => 'whois.register.bg',
      'bi' => 'whois.nic.bi',
      'biz' => 'whois.biz',
      'bj' => 'whois.nic.bj',
      'br' => 'whois.lacnic.net',
      'bt' => 'whois.netnames.net',
      'by' => 'whois.ripe.net',
      'bz' => 'whois.belizenic.bz',
      'ca' => 'whois.cira.ca',
      'cat' => 'whois.cat',
      'cc' => 'whois.nic.cc',
      'cd' => 'whois.nic.cd',
      'ch' => 'whois.nic.ch',
      'ci' => 'whois.nic.ci',
      'ck' => 'whois.nic.ck',
      'cl' => 'whois.nic.cl',
      'cn' => 'whois.cnnic.net.cn',
      'com' => 'whois.verisign-grs.com',
      'coop' => 'whois.nic.coop',
      'cx' => 'whois.nic.cx',
      'cy' => 'whois.ripe.net',
      'cz' => 'whois.nic.cz',
      'de' => 'whois.denic.de',
      'dk' => 'whois.dk-hostmaster.dk',
      'dm' => 'whois.nic.cx',
      'dz' => 'whois.ripe.net',
      'edu' => 'whois.educause.edu',
      'ee' => 'whois.eenet.ee',
      'eg' => 'whois.ripe.net',
      'es' => 'whois.ripe.net',
      'eu' => 'whois.eu',
      'fi' => 'whois.ficora.fi',
      'fo' => 'whois.ripe.net',
      'fr' => 'whois.nic.fr',
      'gb' => 'whois.ripe.net',
      'gd' => 'whois.adamsnames.com',
      'ge' => 'whois.ripe.net',
      'gg' => 'whois.channelisles.net',
      'gi' => 'whois2.afilias-grs.net',
      'gl' => 'whois.ripe.net',
      'gm' => 'whois.ripe.net',
      'gov' => 'whois.nic.gov',
      'gr' => 'whois.ripe.net',
      'gs' => 'whois.nic.gs',
      'gw' => 'whois.nic.gw',
      'gy' => 'whois.registry.gy',
      'hk' => 'whois.hkirc.hk',
      'hm' => 'whois.registry.hm',
      'hn' => 'whois2.afilias-grs.net',
      'hr' => 'whois.ripe.net',
      'hu' => 'whois.nic.hu',
      'ie' => 'whois.domainregistry.ie',
      'il' => 'whois.isoc.org.il',
      'in' => 'whois.inregistry.net',
      'info' => 'whois.afilias.net',
      'io' => 'whois.nic.io',
      'iq' => 'vrx.net',
      'ir' => 'whois.nic.ir',
      'is' => 'whois.isnic.is',
      'it' => 'whois.nic.it',
      'je' => 'whois.channelisles.net',
      'jobs' => 'jobswhois.verisign-grs.com',
      'jp' => 'whois.jprs.jp',
      'ke' => 'whois.kenic.or.ke',
      'kg' => 'www.domain.kg',
      'ki' => 'whois.nic.ki',
      'kr' => 'whois.nic.or.kr',
      'kz' => 'whois.nic.kz',
      'la' => 'whois.nic.la',
      'li' => 'whois.nic.li',
      'lt' => 'whois.domreg.lt',
      'lu' => 'whois.dns.lu',
      'lv' => 'whois.nic.lv',
      'ly' => 'whois.nic.ly',
      'ma' => 'whois.iam.net.ma',
      'mc' => 'whois.ripe.net',
      'md' => 'whois.ripe.net',
      'me' => 'whois.meregistry.net',
      'mg' => 'whois.nic.mg',
      'mil' => 'whois.nic.mil',
      'mn' => 'whois.nic.mn',
      'mobi' => 'whois.dotmobiregistry.net',
      'ms' => 'whois.adamsnames.tc',
      'mt' => 'whois.ripe.net',
      'mu' => 'whois.nic.mu',
      'museum' => 'whois.museum',
      'mx' => 'whois.nic.mx',
      'my' => 'whois.mynic.net.my',
      'na' => 'whois.na-nic.com.na',
      'name' => 'whois.nic.name',
      'net' => 'whois.verisign-grs.net',
      'nf' => 'whois.nic.nf',
      'nl' => 'whois.domain-registry.nl',
      'no' => 'whois.norid.no',
      'nu' => 'whois.nic.nu',
      'nz' => 'whois.srs.net.nz',
      'org' => 'whois.pir.org',
      'pl' => 'whois.dns.pl',
      'pm' => 'whois.nic.pm',
      'pr' => 'whois.uprr.pr',
      'pro' => 'whois.registrypro.pro',
      'pt' => 'whois.dns.pt',
      're' => 'whois.nic.re',
      'ro' => 'whois.rotld.ro',
      'ru' => 'whois.ripn.net',
      'sa' => 'whois.nic.net.sa',
      'sb' => 'whois.nic.net.sb',
      'sc' => 'whois2.afilias-grs.net',
      'se' => 'whois.iis.se',
      'sg' => 'whois.nic.net.sg',
      'sh' => 'whois.nic.sh',
      'si' => 'whois.arnes.si',
      'sk' => 'whois.ripe.net',
      'sm' => 'whois.ripe.net',
      'st' => 'whois.nic.st',
      'su' => 'whois.ripn.net',
      'tc' => 'whois.adamsnames.tc',
      'tel' => 'whois.nic.tel',
      'tf' => 'whois.nic.tf',
      'th' => 'whois.thnic.net',
      'tj' => 'whois.nic.tj',
      'tk' => 'whois.dot.tk',
      'tl' => 'whois.nic.tl',
      'tm' => 'whois.nic.tm',
      'tn' => 'whois.ripe.net',
      'to' => 'whois.tonic.to',
      'tp' => 'whois.nic.tl',
      'tr' => 'whois.nic.tr',
      'travel' => 'whois.nic.travel',
      'tv' => 'tvwhois.verisign-grs.com',
      'tw' => 'whois.twnic.net.tw',
      'ua' => 'whois.net.ua',
      'ug' => 'whois.co.ug',
      'uk' => 'whois.nic.uk',
      'us' => 'whois.nic.us',
      'uy' => 'nic.uy',
      'uz' => 'whois.cctld.uz',
      'va' => 'whois.ripe.net',
      'vc' => 'whois2.afilias-grs.net',
      've' => 'whois.nic.ve',
      'vg' => 'whois.adamsnames.tc',
      'wf' => 'whois.nic.wf',
      'ws' => 'whois.website.ws',
      'yt' => 'whois.nic.yt',
      'yu' => 'whois.ripe.net');
      
      
     $whoisservers_short = array(
      'net' => 'whois.arin.net',
      'int' => 'whois.iana.org'
      );

     //connect to the whois server
     $found = false; 
     foreach ($whoisservers_short as $url) {
         $w = GetWhoISFromServer($url , $ip);  
         
         if (preg_match('@whois\.[\w\.]*@si' , $w , $data)) {
             $found = true;
             break;
         }  
     }
      
     //can't find a connection - use the long list
     if (! $found) { 
         foreach ($whoisservers as $url) {
             $w = GetWhoISFromServer($url , $ip);  
             
             if (preg_match('@whois\.[\w\.]*@si' , $w , $data)) {
                 break;
             }  
         }
     }

     $whois_server = $data[0];  

     if (tep_not_null($whois_data)) {  //failed all attemtps
         echo ERROR_FSOCK_CONNECTION_FAILED;
     } 

     //now get actual whois data  
     $whois_data = GetWhoISFromServer($whois_server , $ip);  
     return $whois_data;  
 }  

/*******************************************************************************
 Get the whois result from a whois server  
/******************************************************************************/ 
 function GetWhoISFromServer($server , $ip) {  
     $data = '';  

     #Create the socket and connect  
     $f = @fsockopen($server, 43, $errno, $errstr, 3);    //Open a new connection  
     if (!$f) {          
         return '';  
     }  
    
     #Set the timeout limit for read  
     if(!stream_set_timeout($f , 3)) {  
         die('Unable to set set_timeout');   #Did this solve the problem ?  
     }  
       

     #Send the IP to the whois server      
     if ($f) {  
         fputs($f, "$ip\r\n");  
     }  

     //Set the timeout limit for read  
     if (!stream_set_timeout($f , 3)) {  
         die('Unable to stream_set_timeout');    #Did this solve the problem ?  
     }  

     //Set socket in non-blocking mode  
     stream_set_blocking ($f, 0 );  

     //If connection still valid  
     if ($f) {  
         while (!feof($f)) {  
             $data .= fread($f , 128);  
         }  
     }  
 
     //Now return the data  
     return $data;  
 } 
 
/*******************************************************************************
Used to unserialize a sesssion - normal unserialze won't work
/******************************************************************************/
if (! function_exists('UnserializeSession')) {
function UnserializeSession($session_data) {
     $return_data = array();
     $offset = 0;
     while ($offset < strlen($session_data)) {
         if (!strstr(substr($session_data, $offset), "|")) {
             throw new Exception("invalid data, remaining: " . substr($session_data, $offset));
         }
         $pos = strpos($session_data, "|", $offset);
         $num = $pos - $offset;
         $varname = substr($session_data, $offset, $num);
         $offset += $num + 1;
         $data = unserialize(substr($session_data, $offset));
         $return_data[$varname] = $data;
         $offset += strlen(serialize($data));
     }
     return $return_data;    
}
}

/*******************************************************************************
Sort a multi array - data field must be named text
/******************************************************************************/
function VC_SortMultiArray($a, $b) {
    return strnatcasecmp($a["text"], $b["text"]);
}
 
/*******************************************************************************
Multi-select menu
/******************************************************************************/
function VCMultiSelectMenu($name, $values, $selected_vals, $params = '', $required = false) {
    $field = '<select name="' . $name . '"';
    if ($params) $field .= ' ' . $params;
    $field .= ' multiple="multiple">';
    
    for ($i=0; $i<sizeof($values); ++$i) {
        if ($values[$i]['id']) {
            $field .= '<option value="' . $values[$i]['id'] . '"';
            if ( ((strlen($values[$i]['id']) > 0) && ($name == $values[$i]['id'])) ) {
                $field .= '  selected="selected"';
            } else if (tep_not_null($selected_vals)) {
                for ($j=0; $j<sizeof($selected_vals); ++$j) {
                    if ($selected_vals[$j]['id'] == $values[$i]['id']) {
                        $field .= ' selected="selected"';
                    }
                }
            }
        }

        $field .= '>' . $values[$i]['text'] . '</option>';
    }
    $field .= '</select>';

    if ($required) $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

/*******************************************************************************
Write the altered .htaccess file
/******************************************************************************/
function WriteHTAccess($htaccessfile, $arrayWrite) {
    if (file_exists($htaccessfile)) {
        $fp = fopen($htaccessfile, "w" );
        if ($fp) {
            foreach ($arrayWrite as $line) {
                fputs($fp, $line);      
            }
            
            fclose($fp);
            return true;
        }
    }
    return false;
}