<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack York - oscommerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/
 
 switch (true) {  
     case (!empty($_SERVER['HTTP_CLIENT_IP'])) && filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) : $thisIP = $_SERVER['HTTP_CLIENT_IP']; break;
     case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) && filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) : $thisIP = $_SERVER['HTTP_X_FORWARDED_FOR']; break;
     case (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) : $thisIP = $_SERVER['REMOTE_ADDR']; break;
     default: return; //probably an IPV6
 } 

 
 include_once('includes/languages/' . $language . '/view_counter.php');

 function IsSearchBot($userAgent) {
     $searchbotStr = 'Ask Jeeves|Google|AdsBot-Google|Googlebot|FeedFetcher-Google|msnbot|msnbot-media|bingbot|Yahoo|Yahoo|Slurp|' .
     'AbachoBOT|accoona|AcioRobot|Ahrefs|ASPSeek|CocoCrawler|Dumbot|FAST-WebCrawler|baidu|BOTW|Baiduspider|GeonaBot|Gigabot|' .
     'HenryTheMiragorobot|Lycos|MSRBOT|Scooter|AltaVista|IDBot|eStyle|Rambler|Scrubby|Bloglines subscriber|Charlotte|Charlotte t China|' .
     'DotBot|Java VM|LinkWalker|LiteFinder|QihooBot|Sogou head spider|Sogou web spider|Sosospider|Sosoimagespider|'.
     'Superdownloads Spiderman|thefind|WebAlta Crawler|Yeti|YodaoBot';

     /*
$searchbotStr = 'ABCdatos BotLink|Acme.Spider|Ahoy! The Homepage Finder|Alkaline|Anthill|Walhello appie|Arachnophilia|Arale|Araneo|AraybOt|ArchitextSpider|
Aretha|ARIADNE|arks|AskJeeves|ASpider (Associative Spider)|ATN Worldwide|Atomz.com Search Robot|AURESYS|BackRub|Bay Spider|
Big Brother|Bjaaland|BlackWidow|Die Blinde Kuh|Bloodhound|Borg-Bot|BoxSeaBot|bright.net caching robot|BSpider|CACTVS Chemistry Spider|
Calif|Cassandra|Digimarc Marcspider/CGI|Checkbot|ChristCrawler.com|churl|cIeNcIaFiCcIoN.nEt|CMC/0.01|Collective|Combine System|
Conceptbot|ConfuzzledBot|CoolBot|Web Core / Roots|XYLEME Robot|Internet Cruiser Robot|Cusco|CyberSpyder Link Test|CydralSpider|Desert Realm Spider|
DeWeb(c) Katalog/Index|DienstSpider|Digger|Digital Integrity Robot|Direct Hit Grabber|DNAbot|DownLoad Express|DragonBot|DWCP|e-collector|
EbiNess|EIT Link Verifier Robot|ELFINBOT|Emacs-w3 Search Engine|ananzi|esculapio|Esther|Evliya Celebi|FastCrawler|Fluid Dynamics Search Engine robot|
Felix IDE|Wild Ferret Web Hopper #1, #2, #3|FetchRover|fido|Hämähäkki|KIT-Fireball|Fish search|Fouineur|Robot Francoroute|Freecrawl|
FunnelWeb|gammaSpider, FocusedCrawler|gazz|GCreep|GetBot|GetURL|Golem|Googlebot|Grapnel/0.01 Experiment|Griffon |
Gromit|Northern Light Gulliver|Gulper Bot|HamBot|Harvest|havIndex|HI (HTML Index) Search|Hometown Spider Pro|ht://Dig|HTMLgobble|
Hyper-Decontextualizer|iajaBot|IBM_Planetwide|Popular Iconoclast|Ingrid|Imagelock|IncyWincy|Informant|InfoSeek Robot 1.0|Infoseek Sidewinder|
InfoSpiders|Inspector Web|IntelliAgent|I, Robot|Iron33|Israeli-search|JavaBee|JBot Java Web Robot|JCrawler|Jeeves|
JoBo Java Web Robot|Jobot|JoeBot|The Jubii Indexing Robot|JumpStation|image.kapsi.net|Katipo|KDD-Explorer|Kilroy|KO_Yappo_Robot|
LabelGrabber|larbin|legs|Link Validator|LinkScan|LinkWalker|Lockon|logo.gif Crawler|Lycos|Mac WWWWorm|
Magpie|marvin/infoseek|Mattie|MediaFox|MerzScope|NEC-MeshExplorer|MindCrawler|mnoGoSearch search engine software|moget|MOMspider|
Monster|Motor|MSNBot|Muncher|Muninn|Muscat Ferret|Mwd.Search|Internet Shinchakubin|NDSpider|Nederland.zoek|
NetCarta WebMap Engine|NetMechanic|NetScoop|newscan-online|NHSE Web Forager|Nomad|The NorthStar Robot|nzexplorer|ObjectsSearch|Occam|
HKU WWW Octopus|OntoSpider|Openfind data gatherer|Orb Search|Pack Rat|PageBoy|ParaSite|Patric|pegasus|The Peregrinator|
PerlCrawler 1.0|Phantom|PhpDig|PiltdownMan|Pimptrain|Pioneer|html_analyzer|Portal Juice Spider|PGP Key Agent|PlumtreeWebAccessor|
Poppi|PortalB Spider|psbot|GetterroboPlus Puu|The Python Robot|Raven Search|RBSE Spider|Resume Robot|RoadHouse Crawling System|RixBot|
Road Runner: The ImageScape Robot|Robbie the Robot|ComputingSite Robi/1.0|RoboCrawl Spider|RoboFox|Robozilla|Roverbot|RuLeS|SafetyNet Robot|Scooter|
Sleek|Search.Aus-AU.COM|SearchProcess|Senrigan|SG-Scout|ShagSeeker|Shai|Sift|Simmany Robot Ver1.0|Site Valet|
Open Text Index Robot|SiteTech-Rover|Skymob.com|SLCrawler|Inktomi Slurp|Smart Spider|Snooper|Solbot|Spanner|Speedy Spider|
spider_monkey|SpiderBot|Spiderline Crawler|SpiderMan|SpiderView(tm)|Spry Wizard Robot|Site Searcher|Suke|suntek search engine|Sven|
Sygol|TACH Black Widow|Tarantula|tarspider|Tcl W3 Robot|TechBOT|Templeton|TeomaTechnologies|TITAN|TitIn|
The TkWWW Robot|TLSpider|UCSD Crawl|UdmSearch|UptimeBot|URL Check|URL Spider Pro|Valkyrie|Verticrawl|Victoria|
vision-search|void-bot|Voyager|VWbot|The NWI Robot|W3M2|WallPaper (alias crawlpaper)|the World Wide Web Wanderer|w@pSpider by wap4.com|WebBandit Web Spider|
WebCatcher|WebCopy|webfetcher|The Webfoot Robot|Webinator|weblayers|WebLinker|WebMirror|The Web Moose|WebQuest|
Digimarc MarcSpider|WebReaper|webs|Websnarf|WebSpider|WebVac|webwalk|WebWalker|WebWatch|Wget|
whatUseek Winona|WhoWhere Robot|Wired Digital|Weblog Monitor|w3mir|WebStolperer|The Web Wombat|The World Wide Web Worm|WebZinger|XGET);     
*/

     return ((preg_match("/$searchbotStr/i", $userAgent, $out) > 0) ? $out[0] : '');
 }
 
 function SetVisitorSpoofedName($customer_id, $viewSqlArray) {
     if (tep_session_is_registered('customer_id')) {
         $vc_query = tep_db_query("select customers_firstname, customers_lastname from customers where customers_id='" . (int)$customer_id . "'");
         if (tep_db_num_rows($vc_query) > 0) {
             $db = tep_db_fetch_array($vc_query);
             $viewSqlArray['isbot'] = 2; //the IP was already shown to be a bot so set the flag
             $viewSqlArray['bot_name'] = $db['customers_firstname'] . ' ' . $db['customers_lastname'] .  ' ' . TEXT_SPOOFED_AS . IsSearchBot($_SERVER['HTTP_USER_AGENT']); //store the name of the bot                 
         }
     } else {
         $viewSqlArray['isbot'] = 0; //the IP was already shown to be a bot so set the flag
         $viewSqlArray['bot_name'] = TEXT_SPOOFED_AS . IsSearchBot($_SERVER['HTTP_USER_AGENT']); //store the name of the bot     
     }
     return $viewSqlArray;
 }
 
 $spoofedAction = false;
 $viewSqlArray = array();
 $viewSqlArray['ip'] = $thisIP;
 $viewSqlArray['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
 
 $view_check_query = tep_db_query("select isbot, bot_name from view_counter where ip_number = INET_ATON('" . tep_db_input($viewSqlArray['ip']) . "')");
 $view_check = array(); //increase the scope
 $found = false; //use instead of array since checking is faster
   
 if (tep_db_num_rows($view_check_query) > 0) {
     $view_check = tep_db_fetch_array($view_check_query);
     $found = true;
 }
 
 if (! $found) { //not a previous identified IP
     $ua = $_SERVER['HTTP_USER_AGENT'];

     if ($spider_flag) {
         $bot = IsSearchBot($ua);
         if (! isset($bot[1])) { //name not found
             if (($pos = strpos($user_agent, 'http')) !== FALSE) { //if http://botname.com
                 $bot = substr($user_agent, $pos + 7);             // is now botname.com
                 if (($pos = strpos($bot, '.')) !== FALSE) {
                     $bot = substr($bot, 0, -($pos - 1));
                 }               
             }
         }
         
         $viewSqlArray['isbot'] = 1;
         $viewSqlArray['bot_name'] = (isset($bot[1]) ? $bot : 'No Bot ID');
     } else {    
     
         $hostname = gethostbyaddr($viewSqlArray['ip']);
         if (preg_match("/search\.msn\.com$/", $hostname)) { //special case for msn since they don't always follow the rules
             $viewSqlArray['isbot'] = 1;
             $viewSqlArray['bot_name'] = 'msnbot';
         } else if (tep_session_is_registered('customer_id')) { //not found and is a logged in customer
             $vc_query = tep_db_query("select customers_firstname, customers_lastname from customers where customers_id='" . (int)$customer_id . "'");
             if (tep_db_num_rows($vc_query) > 0) {
                 $db = tep_db_fetch_array($vc_query);
                 $viewSqlArray['isbot'] = 0; 
                 $viewSqlArray['bot_name'] = $db['customers_firstname'] . ' ' . $db['customers_lastname']; //store the customers name                 
                 $spoofedAction = false;
             }         
         }     
     }  
 } else if ($view_check['isbot']) { //only if this is a previously found bot
      if (tep_session_is_registered('customer_id')) {
         $vc_query = tep_db_query("select customers_firstname, customers_lastname from customers where customers_id='" . (int)$customer_id . "'");
         if (tep_db_num_rows($vc_query) > 0) {
             $db = tep_db_fetch_array($vc_query);
             $viewSqlArray['isbot'] = 2; //the IP was already shown to be a bot so set the flag
             $viewSqlArray['bot_name'] = $db['customers_firstname'] . ' ' . $db['customers_lastname'] . ' spoofed as ' .IsSearchBot($_SERVER['HTTP_USER_AGENT']); //store the name of the bot                 
             $spoofedAction = true;
         }
     } else {
         if (! isset($viewSqlArray['bot_name'][1])) {

             $ua = $_SERVER['HTTP_USER_AGENT'];
             $bot = IsSearchBot($ua);
             
             if (! isset($bot[1])) { //name not found
                 if (($pos = strpos($user_agent, 'http')) !== FALSE) { //if http://botname.com
                     $bot = substr($user_agent, $pos + 7);             // is now botname.com
                     if (($pos = strpos($bot, '.')) !== FALSE) {
                         $bot = substr($bot, 0, -($pos - 1));
                     }               
                 }
             }             
             $view_check['bot_name'] = (isset($bot[1]) ? $bot : 'No Bot ID');
         }

         $viewSqlArray['isbot'] = 1; //the IP was already shown to be a bot so set the flag
         $viewSqlArray['bot_name'] = $view_check['bot_name']; //store the name of the bot as previously recorded    
     }
 } else if (tep_session_is_registered('customer_id')) {
     $vc_query = tep_db_query("select customers_firstname, customers_lastname from customers where customers_id='" . (int)$customer_id . "'");
     if (tep_db_num_rows($vc_query) > 0) {
         $db = tep_db_fetch_array($vc_query);
         $viewSqlArray['isbot'] = 0; //the IP was already shown to be a bot so set the flag
         $viewSqlArray['bot_name'] = $db['customers_firstname'] . ' ' . $db['customers_lastname']; //store the name of the bot                 
         $spoofedAction = false;
     }
 } else {
    $viewSqlArray['bot_name'] = '';
    $viewSqlArray['isbot'] = 0; 
     $bot = IsSearchBot($_SERVER['HTTP_USER_AGENT']);
     if (isset($bot[1])) {
         $viewSqlArray['bot_name'] = $bot;
         $viewSqlArray['isbot'] = 1; 
     }    
 } 

 //check for spoofing
 if ($viewSqlArray['isbot'] && (stristr($ua, 'msnbot') || stristr($ua, 'bingbot') || stristr($ua, 'googlebot') || stristr(strtolower(gethostbyaddr($thisIP)), 'google'))) {
     
     //it's pretending to be MSN's bot or Google's bot
     $hostname = gethostbyaddr($thisIP);
     
     if (!preg_match("/\.googlebot\.com$/", $hostname) && !preg_match("/search\.msn\.com$/", $hostname)){
         //the hostname does not belong to either live.com or googlebot.com.
         //Remember the UA already said it is either MSNBot or Googlebot.
         //So it's a spammer.
         $viewSqlArray = SetVisitorSpoofedName($customer_id, $viewSqlArray);
         $spoofedAction = true;
     } else {
         //Now we have a hit that half-passes the check. One last go:
         $real_ip = gethostbyname($hostname);
         
         if ($thisIP != $real_ip){
             //spammer!
            $viewSqlArray = SetVisitorSpoofedName($customer_id, $viewSqlArray);
            $spoofedAction = true;
         } else {
             //real bot
             $viewSqlArray['isbot'] = 1;
             $viewSqlArray['bot_name'] = IsSearchBot($_SERVER['HTTP_USER_AGENT']); 
         }
     }
 }

 if (VIEW_COUNTER_BLOCK_COUNTRIES_SHOP != 'Off' && ! defined('DIR_WS_ADMIN')) {
     if (VIEW_COUNTER_BLOCK_COUNTRIES_BOTS == 'Off' || (VIEW_COUNTER_BLOCK_COUNTRIES_BOTS == 'On' && $viewSqlArray['isbot'] == 0)) {
         include('includes/modules/view_counter_country_block.php');
     }	 
 }
 $viewSqlArray['isadmin'] = '';  //needed to not get missing argument error
 if (defined('DIR_WS_ADMIN') && strpos($_SERVER['PHP_SELF'], DIR_WS_ADMIN) !== FALSE) {
     $viewSqlArray['isadmin'] = DIR_WS_ADMIN;
 } 

 $viewSqlArray['file'] = basename($_SERVER['PHP_SELF']);
 $viewSqlArray['arg'] = $_SERVER['QUERY_STRING'];
 $viewSqlArray['method'] = $_SERVER['REQUEST_METHOD'];
 $viewSqlArray['time'] = $_SERVER['REQUEST_TIME'];
 
 if (($pos = strpos($viewSqlArray['arg'], '?osCsid')) !== FALSE) {
     $viewSqlArray['arg'] = substr($viewSqlArray['arg'], 0, $pos);
 } else if (($pos = strpos($viewSqlArray['arg'], '&osCsid')) !== FALSE) {
     $viewSqlArray['arg'] = substr($viewSqlArray['arg'], 0, $pos);
 } else if (($pos = strpos($viewSqlArray['arg'], 'osCsid')) !== FALSE) {
     $viewSqlArray['arg'] = substr($viewSqlArray['arg'], 0, $pos);
 } 

 /******************************************************************************
 Access to an invalid location has occurred or a suspicious entry in the url was 
 found. If the IP does not belong to a bot, either ban the IP or notify the shop 
 owner or both, depending upon the ban bot setting.
 ******************************************************************************/
 if (! $viewSqlArray['isbot'] && VIEW_COUNTER_BAD_BOT_TRAP != 'Off' && ! defined('DIR_WS_ADMIN')) {
  
     include('includes/functions/view_counter.php');
     
     if (! IgnoreThisIP($viewSqlArray['ip'])) {
     
         /* Ban Bad Bot */
         if (isset($invalidAttempt) && $invalidAttempt) {
             HandleVCBan($viewSqlArray['ip']);
             return;
         }         
         
         /* Ban Hacker */
         //This array is also stored in functions in admin so update it if this is changed.
         $cmpArry = array("(\<|%3C)script(>|%3E)", "base64_encode", "(\<|%3C)(.*)(\>|%3E)", "(\<|%3C).*iframe", "javascript:",
                          "eval\(\$_", "javascript:", "mysql_query", "..\/cmd", "phpinfo\(", "\/iframe", "\$_GET",
                          "\$_POST", "\$_SESSION", "\$_REQUEST", "\$_ENV", "GLOBALS\[", "\$HTTP_",
                          "autoLoadConfig", "php\/login", "alert\(", "convert\(", "mysite\.com",
                          "misc.php", "cltreq.asp", "owssvr.dll", "cmd.exe", "awstats", "phpmyadmin", "openwebmail", "formmail",
                          "drop table", "from table", "IDSAlert."
                          ); 

         foreach ($cmpArry as $test) {
             if (preg_match('/' . $test . '/', $viewSqlArray['arg'])) {
               
                 if (VIEW_COUNTER_BAD_BOT_TRAP != 'Email') {  //then ban or both is set
                     $sqlData = array('ip_number' => ip2long(tep_db_input($ip)), 'ignore_status' => 0);
                     tep_db_perform('view_counter_banned', $sqlData);  
                     AlterHtaccessFile($ip);
                 }                
                 
                 if (VIEW_COUNTER_BAD_BOT_TRAP != 'Ban') {    //then send email. Ban, if set to Both, will be handled above
                     $email_sent = tep_db_query("select 1 from view_counter_emails where ip_number = inet_aton('" . $viewSqlArray['ip'] . "') and sent = 1");
                     if (tep_db_num_rows($email_sent) == 0) {                 
                         $msg = sprintf(TEXT_VIEW_COUNTER_EMAIL_TRAP_MSG_HACKER, $viewSqlArray['ip'], 'http://www.projecthoneypot.org/ip_' .  $viewSqlArray['ip']);
                         $subject = sprintf(TEXT_VIEW_COUNTER_EMAIL_TRAP_SUBJECT, $viewSqlArray['ip']);
                         $vcSendTo = (tep_not_null(VIEW_COUNTER_SEND_EMAILS_TO) ? VIEW_COUNTER_SEND_EMAILS_TO : STORE_OWNER_EMAIL_ADDRESS);
                         tep_db_query("insert into view_counter_emails (ip_number, sent) values (inet_aton('" . $viewSqlArray['ip'] . "'), '1')");
                         tep_mail(STORE_OWNER, $vcSendTo, $subject, $msg, STORE_OWNER, $vcSendTo);
                     }
                 }
                 break;
             } 
         }
     }
 }       
  
 $view_check_query = tep_db_query("select view_count from view_counter
  where ip_number = INET_ATON('". tep_db_input($viewSqlArray['ip']) . "') and 
        language_id=" . (int)$languages_id . " and 
        file_name='"  . tep_db_input($viewSqlArray['file']) . "' and 
        arg='"        . tep_db_input($viewSqlArray['arg']) . "'" 
 );
 
 if (tep_db_num_rows($view_check_query) > 0) {   
 
     $view_check = tep_db_fetch_array($view_check_query);
     $cnt = $view_check['view_count'] + 1;
     tep_db_query("update view_counter set view_count = " . (int)$cnt . ", ip_active=1, last_date = now() " .  
      " where file_name = '" . tep_db_input($viewSqlArray['file']) . "' and " .
      "       arg  = '" .      tep_db_input($viewSqlArray['arg']) . "' and " .
      "       language_id  = " . (int)$languages_id . " and " .
      "       ip_number = INET_ATON('" . tep_db_input($viewSqlArray['ip']) . "' ) and " . 
      "       session_id = '" .tep_db_input(tep_session_id()) . "'");
 } else { 
  
     if (isset($_SERVER['HTTP_REFERER'])) {
         $refer_data = addslashes(tep_db_input(urldecode($_SERVER['HTTP_REFERER'])));
         $refer_data = explode('?', $refer_data);
     } else {
         $refer_data = array(0 => '', 1 => '');
     }   
    	$referrer=$refer_data[0];
    	$referrer_query = (isset($refer_data[1]) ? $refer_data[1] : '');
  
     $insert_sql_data =
      " file_name = '" . tep_db_input($viewSqlArray['file']) . "', " .
      " arg = '" . tep_db_input($viewSqlArray['arg']) . "', " . 
      " view_count = 1, " .
      " ip_number = INET_ATON( '" . $viewSqlArray['ip'] . "' ), " .
      " ip_active = 1, " .
      " session_id = '" . tep_db_input(tep_session_id()) . "', " . 
      " isbot = " . (int)$viewSqlArray['isbot'] . "," .
      " isadmin = '" . tep_db_input($viewSqlArray['isadmin']) . "', " .
      " last_date = now(), " .
      " bot_name = '" . tep_db_input($viewSqlArray['bot_name']) . "', " .
      " referrer = '" . tep_db_input($referrer) ."', " .
      " referrer_query = '" . tep_db_input($referrer_query) . "', " .
      " user_agent = '" . tep_db_input($viewSqlArray['user_agent']) . "', " .
      " language_id = " . (int)$languages_id
     ;
     
     tep_db_query("insert view_counter set " . $insert_sql_data); //can't use perform due to apostrophes added to inet_aton string
     tep_db_query("insert view_counter_storage set " . $insert_sql_data);
 }
 
 /**** BEGIN KILL A SESSION AS ENTERED IN WHO'S ONLINE ****/   
 if (VIEW_COUNTER_ENABLE_KILL_SESSION == 'true') {
      $session_kill_query = tep_db_query("select session_msg as msg from view_counter_session_kill where session_id = '" . tep_db_input(tep_session_id()) . "'");
      
      if (tep_db_num_rows($session_kill_query) > 0) {
          $db = tep_db_fetch_array($session_kill_query);
          if (tep_not_null($db['msg'])) {
              $msg = $db['msg'];
              tep_db_query("delete from view_counter_session_kill where session_id = '" . tep_db_input(tep_session_id()) . "'");
          } else { //this is a kill message
              $sid = tep_session_id();
              if (tep_session_is_registered('cart') && is_object($cart)) {
                  if ($cart->count_contents() > 0) {
                      $cart->reset(true);
                  }
              }
              
              tep_db_query("delete from view_counter_session_kill where session_id = '" . tep_db_input(tep_session_id()) . "'");
              tep_session_destroy($sid);
              tep_session_unregister($sid);
              tep_session_close();
              unset($sid);
              $msg = TEXT_VIEW_COUNTER_KILL_MESSAGE;
          }
          echo '<script type="text/javascript">alert("'. $msg .'");</script>';
      }  
  }
  /**** END KILL A SESSION AS ENTERED IN WHO'S ONLINE ****/
