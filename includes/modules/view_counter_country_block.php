<?php
     
    function VisitorCountry($ip, &$dup) { 

        $db_query = tep_db_query("select country from view_counter_blocked where ip_number = inet_aton('" . $ip . "')");
        if (tep_db_num_rows($db_query) > 0) {
            $db = tep_db_fetch_array($db_query);
            $dup = true;
            return $db['country'];
        }
        
        return CountryCityFromIP($ip);
    } 
    
    function CountryCityFromIP($ipAddr) {
      
        //verify the IP address for the
        if (ip2long($ipAddr)== -1 || ip2long($ipAddr) === false) return '';
     
        //get the country name from local DB
        require('view_counter/IP2Location.php');
        //$vcCountry = new IP2Location('view_counter/IP2LOCATION-LITE-DB1.BIN');
        //$vcCountry = new IP2Location('view_counter/IP2LOCATION-LITE-DB1.BIN', IP2Location::MEMORY_CACHE);
        $vcCountry = new IP2Location('view_counter/view_counterDB.BIN', IP2Location::FILE_IO); //fastest
        $record = $vcCountry->lookup($ipAddr, IP2Location::ALL);
   
        //$record->countryName may return - as first character so check second to see if something was found
        if (tep_not_null($ipAddr) && isset($record->countryName[1]) && strpos($record->countryName, 'demo database') === FALSE ) {
            return $record->countryName;
        }
        
        if (VIEW_COUNTER_BLOCK_COUNTRIES_SHOP == 'External') {
         
            //get the country name from geoplugin.net
            $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
            if($ip_data && $ip_data->geoplugin_countryName != null) {
                return $ip_data->geoplugin_countryName;
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
            
            //get the country name inside the node <countryName> and </countryName>
            preg_match("@<countryName>(.*?)</countryName>@si",$xml,$matches);
  
            return $matches[1];
        }
        
        return '';
    }
     
    $dup  = false;
    $ctry = VisitorCountry($thisIP, $dup); // Get the current country name [Ex: United States]
    $ctry = trim($ctry);
  
    //use for local tracking - change true to false to disable and false to true to enable
    $recordCtry = false;
    if ($recordCtry) {
        if (! $dup) {
            $file = 'includes/view_counter_blocked_countrys_debug.txt';
            $mode = (file_exists($file) ? 'a' : 'w');
            if (($fp = fopen($file , $mode))) {
                $db_query = tep_db_query("select 1 from view_counter_block_list where name_to_block = '" . tep_db_input($ctry) . "'");
                fwrite($fp, 'To Be Blocked:' . $ctry . ' IP: ' . $thisIP . "\n");
                fwrite($fp, 'Already Blocked: ' . (tep_db_num_rows($db_query) ? 'Yes' : 'No') . "\n");
                fwrite($fp, 'Check present: ' . (isset($ctry[1]) ? 'Yes' : 'No') . "\n\n");
                fclose($fp);
            }
        }
       // return;
    }
  
    if (isset($ctry[1])) {
        $db_query = tep_db_query("select 1 from view_counter_block_list where name_to_block = '" . tep_db_input($ctry) . "'");
        
        if ($recordCtry) {
            $file = 'includes/view_counter_blocked_countrys_debug.txt';
            $mode = (file_exists($file) ? 'a' : 'w');
            if (($fp = fopen($file , $mode))) {
            fwrite($fp, 'Blocking:' . $ctry . ' IP: ' . $thisIP . "\n");
            fwrite($fp, 'Query:' . tep_db_num_rows($db_query) . ' Dup: ' . $dup . "\n");
            fclose($fp);
            }
        }       
        if (tep_db_num_rows($db_query) > 0) {
            if ($dup) {
                tep_db_query("update view_counter_blocked set count=count+1 where ip_number = inet_aton('" . $thisIP . "')");
            } else {
                tep_db_query("insert into view_counter_blocked (ip_number, country, count) values (inet_aton('" . $thisIP . "'), '" . tep_db_input($ctry) . "', '1')");
            } 

            header("Location: HTTP/1.1 403 Forbidden");
            exit;
        }
    }

   