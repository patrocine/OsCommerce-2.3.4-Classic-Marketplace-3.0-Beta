<?php

/*******************************************************************************
Add the given IP to the .htaccess file and the banned IP DB table. This is a 
modified, stripped-down, version of the admin function by a similar name. The 
name was changed to prevent having to check if it was present, for speed.
/******************************************************************************/
function AlterHtaccessFile($ip) {
 
    if (! tep_validate_ip_address($ip)) {
        return false;
    }
    
    $arrayWrite = array();
    $htaccessfile = '';
    $arrayWrite = GetHtaccessFileContents($htaccessfile);       
    
    if ($arrayWrite) {    
        $endLine = '';
        $items = count($arrayWrite);

        for ($i = 0; $i < $items; ++$i) {
     
            if (strpos($arrayWrite[$i], $ip) !== FALSE) { //IP exists in .htaccess file - should never happen since the IP accessed the site now
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
            $arrayTmp[] = 'deny from ' . $ip . PHP_EOL;
            array_splice($arrayWrite, $endLine - 1, 0, $arrayTmp);
        } else {        
            $arrayWrite[] = '# Begin IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;      
            $arrayWrite[] = 'order allow,deny' . PHP_EOL;
            $arrayWrite[] = 'deny from ' . $ip . PHP_EOL;
            $arrayWrite[] = 'allow from all' . PHP_EOL;
            $arrayWrite[] = '# End IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;
        }
    } else { //create a new file
        $arrayWrite[] = '# Begin IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;      
        $arrayWrite[] = 'order allow,deny' . PHP_EOL;
        $arrayWrite[] = 'deny from ' . $ip . PHP_EOL;
        $arrayWrite[] = 'allow from all' . PHP_EOL;
        $arrayWrite[] = '# End IP deny by View Counter from www.oscommerce-solution.com' . PHP_EOL;
    }
    
    if (! empty($arrayWrite)) {
        if (WriteHTAccess($htaccessfile, $arrayWrite)) {
            return true;
        } else {
            return false; //ERROR_HTACCESS_WRITE_FAILED;
        }
    }  
    return false;    
}

/*******************************************************************************
Return an array with city, state and country for the given IP to be used on the
create account and new address pages.
/******************************************************************************/
function GetAutoFillArray(&$addrArray) {
    require('view_counter/IP2Location.php');
    $vcCountry = new IP2Location('view_counter/view_counterDB.BIN', IP2Location::FILE_IO); //fastest
    $record = $vcCountry->lookup('97.70.12.202', IP2Location::ALL);
    if (is_object($record)) {
        $countries_query = tep_db_query("select countries_id from countries where countries_name = '" . tep_db_input($record->countryName) . "'");
        $countryID = '';
        if (tep_db_num_rows($countries_query)) {
            $country = tep_db_fetch_array($countries_query);
            $countryID = $country['countries_id'];
        }         
        $addrArray['city'] = (tep_not_null($record->cityName) ? $record->cityName : '');
        $addrArray['state'] = (tep_not_null($record->regionName) ? $record->regionName : '');
        $addrArray['country'] = $countryID;
    }
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

/******************************************************
A common function to handle invalid attempts
******************************************************/
function HandleVCBan($ip) {
    
    $view_check_query = tep_db_query("select 1 from view_counter_banned where ip_number = INET_ATON('" . $ip . "')");
 
    if (tep_db_num_rows($view_check_query) == 0) { //hasn't been banned yet 
       
        if (VIEW_COUNTER_BAD_BOT_TRAP != 'Email') {  //then ban or both is set
            $sqlData = array('ip_number' => ip2long(tep_db_input($ip)), 'ignore_status' => 0);
            tep_db_perform('view_counter_banned', $sqlData);  
            AlterHtaccessFile($ip);
        } 
        
        if (VIEW_COUNTER_BAD_BOT_TRAP != 'Ban') {    //then send email. Ban, if set to Both, will be handled above
            $mail_sent_query = tep_db_query("select 1 from view_counter_emails where ip_number = inet_aton('" . $ip . "') and sent = 1");
            if (tep_db_num_rows($email_sent) == 0) {
                $subject = sprintf(TEXT_VIEW_COUNTER_EMAIL_TRAP_SUBJECT, $ip); 
                $msg = sprintf(TEXT_VIEW_COUNTER_EMAIL_TRAP_MSG_SPOOF, $ip, 'http://www.projecthoneypot.org/ip_' . $ip);
                $vcSendTo = (tep_not_null(VIEW_COUNTER_SEND_EMAILS_TO) ? VIEW_COUNTER_SEND_EMAILS_TO : STORE_OWNER_EMAIL_ADDRESS);
                tep_db_query("insert into view_counter_emails (ip_number, sent) values (INET_ATON('" . $ip . "'), '1')");
                tep_mail(STORE_OWNER, $vcSendTo, $subject, $msg, STORE_OWNER, $vcSendTo);
            }
        } 
    } else if (VIEW_COUNTER_BAD_BOT_TRAP != 'Ban') {    //has been banned but was the shop owner notified?
        $mail_sent_query = tep_db_query("select 1 from view_counter_emails where ip_number = inet_aton('" . ip . "') and sent = 1");
        if (tep_db_num_rows($email_sent) == 0) { //shop owner hasn't been notified of this IP yet so do so
            $subject = sprintf(TEXT_VIEW_COUNTER_EMAIL_TRAP_SUBJECT, $ip); 
            $msg = sprintf(TEXT_VIEW_COUNTER_EMAIL_TRAP_MSG_SPOOF, $ip, 'http://www.projecthoneypot.org/ip_' .  $ip);
            $vcSendTo = (tep_not_null(VIEW_COUNTER_SEND_EMAILS_TO) ? VIEW_COUNTER_SEND_EMAILS_TO : STORE_OWNER_EMAIL_ADDRESS);
            tep_db_query("insert into view_counter_emails (ip_number, sent) values (INET_ATON('" . $ip . "'), '1')");
            tep_mail(STORE_OWNER, $vcSendTo, $subject, $msg, STORE_OWNER, $vcSendTo);
        }     
    }      
} 

function IgnoreThisIP($ip) {
    $view_check_query = tep_db_query("select 1 from view_counter_ignore where ip_number = INET_ATON('" . tep_db_input($ip) . "')");
    if (tep_db_num_rows($view_check_query)) { //this IP is OK so ignore
        return true;
    }
    
    $goodIPs = explode(',', VIEW_COUNTER_GOOD_IP_LIST);
    if (in_array($ip, $goodIPs) !== FALSE) { //a known good IP so ignore
        return true;
    } 
    return false;
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