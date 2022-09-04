<?php

  /**
   * @package osC_Sec Security Class for Oscommerce
   * @author Te Taipo <rohepotae@gmail.com>
   * @copyright (c) Hokioi-IT
   * @license http://opensource.org/licenses/gpl-license.php GNU Public License
   * @version $Id: osC_Sec.php 5.0.6
   * @see readme.htm
   * @link http://addons.oscommerce.com/info/8283/
   **/

  # switch off server error 'notices'
  error_reporting( 6135 );

  # make sure $_SERVER[ "REQUEST_URI" ] is set
  fix_server_vars();
  
  # prevent direct viewing of osC_Sec.php
  if ( false !== strpos( strtolower( $_SERVER[ "SCRIPT_NAME" ] ), osCSec_selfchk() ) ) senda404Header();
  
  # include the settings file osc.php
  $oscfilepath = rtrim( dirname( __file__ ), '/\\' ) . DIRECTORY_SEPARATOR . 'osc.php';
  if ( file_exists( $oscfilepath ) ) {
      require_once( $oscfilepath );
  } else {
      # if osc.php missing
      $osC_Sec = new osC_Sec();
      $osC_Sec->Sentry( $timestampOffset = 0,
                        $nonGETPOSTReqs = 0,
                        $spiderBlock = 0,
                        $banipaddress = 0,
                        $useIPTRAP = 0,
                        $ipTrapBlocked="",
                        $emailenabled = 0,
                        $youremail = "",
                        $fromemail = "",
                        $disable_tellafriend = NULL );
  }

  class osC_Sec {
   
    var $_fullreport = true;
    
    function Sentry( $timestampOffset = 0,
                     $nonGETPOSTReqs = 0,
                     $spiderBlock = 0,
                     $banipaddress = 0,
                     $useIPTRAP = 0,
                     $ipTrapBlocked = "",
                     $emailenabled = 0,
                     $youremail = "",
                     $fromemail = "",
                     $disable_tellafriend = NULL ) {
      
      $this->_nonGETPOSTReqs = ( bool )$this->fINT( $nonGETPOSTReqs );
      $this->_banipaddress = ( bool )$this->fINT( $banipaddress );
      $this->_useIPTRAP = ( bool )$this->fINT( $useIPTRAP );
      $this->_emailenabled = ( bool )$this->fINT( $emailenabled );
      $this->_currentVersion = "5.0.6";
      $spiderBlock = ( bool )$this->fINT( $spiderBlock );
      
      $this->_disable_tellafriend = 0;
      if ( isset( $disable_tellafriend ) ) $this->_disable_tellafriend = ( bool )$this->fINT( $disable_tellafriend );

      $this->setIPTrapBlocked( $ipTrapBlocked );

      if ( false !== ( bool )$this->fINT( $this->_emailenabled ) ) {
          $this->_youremail = $youremail;
          $this->_fromemail = $fromemail;
          $this->_timestampOffset = $this->fINT( $timestampOffset );
      }
      
      # if open_basedir is not set in php.ini then set it in the local scope
      # only available for version 2.3.1 of osCommerce
      $this->setOpenBaseDir();
      
      # check settings are correct
      $this->chkSetup();
      
      # reliably set $PHP_SELF as a filename
      global $PHP_SELF;
      $PHP_SELF = $this->phpSelfFix();

      # prevent the version of php being discovered
      $this->x_powered_by();
      
      # ban bad harvesting spiders
      if ( false !== $spiderBlock ) $this->badArachnid();

      # set the host address to be used in the email notification and htaccess
      if ( ( false !== $this->_emailenabled )
         || ( false !== $this->_banipaddress ) ) {
         $this->_httphost = preg_replace( "/^(?:([^\.]+)\.)?domain\.com$/", "\1", $_SERVER[ "SERVER_NAME" ] );
      }
      # set the path to the htaccess in the root catalog
      if ( $this->_banipaddress ) $this->_htaccessfile = $this->strCharsfrmStr( $this->getDir() . ".htaccess", "//", "/" );
      
      # set the path to the IP_Trapped.txt file
      if ( false !== $this->_useIPTRAP ) {
         $this->_ipTrappedURL = $this->strCharsfrmStr( $this->getDir() . "banned/IP_Trapped.txt", "//", "/" );
         # if ip address already in the trapped banlist, redirect to blocked.php
         if ( false !== $this->ipTrapped() ) {
             header( "Location: " . $this->_ipTrapBlocked );
             exit;
         }
      }

      # check for the specific attempt to exploit osCommerce
      # no requests are exempt from this filter
      $this->osCAdminLoginBypass();
      
      # filters either _GET or _POST requests
      $this->_REQUEST_Shield();

      # check for database injection attempts
      $this->dbShield();

      # check _GET requests against the blacklist
      $this->getShield();

      # check _POST requests against the blacklist
      $this->postShield();

      # run through $_COOKIE checking against blacklists
      $this->cookieShield();

      # prevent non-standard requests:
      $this->checkReqType();

      # prevent tell_a_friend.php spam
      # by disabling guest emailing
      $this->disable_tellafriend();

      # PHP5 with register_long_arrays off? From SoapCMS Core Security Class
      $this->setGlobals();

      # merge $_REQUEST with cleaned _GET and _POST excluding _COOKIE data
      $_REQUEST = array_merge( $_GET, $_POST );
    } // end of osC_Sec Sentry function

    /**
     * banChecker()
     * 
     * @return
     */
    function banChecker( $r = "", $t = false ) {
         if ( false !== $this->byPass() && false !== ( bool )$t ) {
             return $this->tinoRahui( $r );
         } else return;
    }
    /**
     * osCEmailer()
     * 
     * @return
     */
    function osCEmailer( $r, $fullreport = true ) {
         # disable the emailer if htaccess not writable when .htaccess banning is enabled
         if ( false !== $this->_banipaddress ) {
            if ( false === $this->hCoreFileChk( $this->_htaccessfile ) ) return;
         }
         # if the default install 'to' email has not changed or is empty, then disable the emailer
         if ( ( false !== strpos( $this->_youremail, "youremail@yourdomain.com" ) )
              || empty( $this->_youremail ) ) return;
  
         # send the notification
         if ( ( ( false !== $this->_banipaddress )
               || ( false !== $this->_useIPTRAP ) )
               && ( false !== $this->_emailenabled ) ) {
            global $PHP_SELF;
            if ( ( false !== $this->_banipaddress )
                && ( false !== $this->hCoreFileChk( $this->_htaccessfile ) ) ) {
                $banAction = "htaccess banned";
            } elseif ( ( false !== $this->_useIPTRAP ) ) {
                $banAction = "IP Trap banned";
            }
            if ( !isset( $this->_timestampOffset ) ) $this->_timestampOffset = 0;
            $timestamp = gmdate( "D, d M Y H:i:s", time() + ( $this->_timestampOffset * 3600 ) );
            $to = $this->_youremail;
            $subject = $this->_httphost . " " . ( substr( $r, 0, 60 ) ) . "...";
            $body = "This IP [ " . $this->getRealIP() . " ] has been " . $banAction . " on the http://" . $this->_httphost .
                " website by osC_Sec.php version " . $this->_currentVersion . "\n\nREASON FOR BAN: " . $r . "\n\nTime of ban: " .
                $timestamp . "\n";
            $body .= "\n.------------[ ALL \$_GET VARIABLES ]-------------\n#\n";
            if ( !empty( $_GET ) ) {
                $sDimGET = $this->array_flatten( $_GET, true );
                foreach ( $sDimGET as $k => $v ) {
                    if ( empty( $v ) ) $v = "NULL";
                    if ( !is_array( $k ) && !is_array( $v ) ) $body .= "# - " . $k . " = " . htmlspecialchars( $v ) . "\n";
                }
            } else {
                $body .= "# - No \$_GET data\n";
            }
            $body .= "#\n`--------------------------------------------------------\n";
            $body .= "\n.---------[ ALL \$_POST FORM VARIABLES ]-------\n#\n";
            if ( ( isset( $_POST ) ) && ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) ) {
                $sDimPOST = $this->array_flatten( $_POST, true );
                foreach ( $sDimPOST as $k => $v ) {
                    if ( empty( $v ) ) $v = "NULL";
                    if ( !is_array( $k ) && !is_array( $v ) ) $body .= "# - " . $k . " = " . htmlspecialchars( $v ) . "\n";
                }
            } else {
                $body .= "# - No POST form data\n";
            }
            $body .= "#\n`--------------------------------------------------------\n";
            $body .= "\n.------------[ \$_SERVER VARIABLES ]--------------\n#\n";
            if ( false !== $fullreport ) {
                $sDimSERVER = $this->array_flatten( $_SERVER, true );
                foreach ( $sDimSERVER as $k => $v ) {
                    if ( empty( $v ) ) $v = "NULL";
                    if ( !is_array( $k ) && !is_array( $v ) ) $body .= "# - " . $k . " = " . htmlspecialchars( $v ) . "\n";
                }
            } else {
                # short report
                $serverVars = new ArrayIterator( array( "HTTP_HOST", "HTTP_USER_AGENT", "SERVER_ADDR", "REMOTE_ADDR",
                    "DOCUMENT_ROOT", "SCRIPT_FILENAME", "REQUEST_METHOD", "REQUEST_URI", "SCRIPT_NAME", "QUERY_STRING",
                    "HTTP_X_CLUSTER_CLIENT_IP", "HTTP_X_FORWARDED_FOR", "HTTP_X_ORIGINAL_URL", "ORIG_PATH_INFO",
                    "HTTP_X_REWRITE_URL", "HTTP_CLIENT_IP", "HTTP_PROXY_USER", "REDIRECT_URL", "SERVER_SOFTWARE" ) );
                while ( $serverVars->valid() ) {
                    if ( array_key_exists( $serverVars->current(), $_SERVER ) && !empty( $_SERVER[$serverVars->current()] ) ) {
                        $body .= "# - \$_SERVER[ \"" . $serverVars->current() . "\" ] = " . $_SERVER[$serverVars->current()] .
                            "\n";
                    }
                    $serverVars->next();
                }
   
            }
   
            $body .= "# - \$PHP_SELF filename ( osC_Sec ) = " . $PHP_SELF . "\n";
            $body .= "#\n`--------------------------------------------------------\n\n";
            $body .= "OTHER INFO\n";
            $body .= $this->_htaccessfile;
            $body .= "\n";
            $body .= "is htaccess writeable = " . ( false !== $this->hCoreFileChk( $this->_htaccessfile ) );
            $body .= "\n\nResolve IP address: http://en.utrace.de/?query=" . $this->getRealIP() . "\n";
            $body .= "Search Project Honeypot: http://www.projecthoneypot.org/ip_" . $this->getRealIP() . "\n\n";
            $body .= "This email was generated by osC_Sec. To disable email notifications," .
                " open osc.php file, and in the Settings section change \$emailenabled" . " = 1 to \$emailenabled = 0\n\n";
            $body .= "Keep up with the latest version of osC_Sec.php at ";
            $body .= "http://addons.oscommerce.com/info/8283 and http://goo.gl/dQ3jH\n";
            $body .= "Email rohepotae@gmail.com with any suggestions.\n\n";
            $from = "From: " . $this->_fromemail;
            mail( $to, $subject, $body, $from );
      }
    return;
    }
    /**
     * setGlobals()
     * 
     * @return
     */
    function setGlobals() {
      if ( @phpversion() >= "5.0.0"
         && ( !ini_get( "register_long_arrays" )
         || @ini_get( "register_long_arrays" ) == "0"
         || strtolower( @ini_get( "register_long_arrays" ) ) == "off" ) ) {
         global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_SERVER_VARS, $HTTP_COOKIE_VARS,
                $HTTP_ENV_VARS, $HTTP_POST_FILES, $HTTP_SESSION_VARS;

                $HTTP_POST_VARS = $_POST;
                $HTTP_GET_VARS = $_GET;
                $HTTP_SERVER_VARS = $_SERVER;
                $HTTP_COOKIE_VARS = $_COOKIE;
                $HTTP_ENV_VARS = $_ENV;
                $HTTP_POST_FILES = $_FILES;

                # _SESSION is the only superglobal which is conditionally set
                if ( isset( $_SESSION ) ) $HTTP_SESSION_VARS = $_SESSION;
      }
    return;
    }
    /**
     * senda403Header()
     * 
     * @return
     */
    function senda403Header() {
        $header = array( "HTTP/1.1 403 Access Denied", "Status: 403 Access Denied by osC_Sec", "Content-Length: 0" );
        foreach ( $header as $sent ) {
            header( $sent );
        }
        die();
    }

    /**
     * tinoRahui()
     * 
     * @return
     */
    function tinoRahui( $r ) {
         if ( false === $this->byPass() ) return;
         if ( ( false !== $this->_banipaddress ) && ( false !== $this->hCoreFileChk( $this->_htaccessfile ) ) ) {
             # send an email
             if ( false !== $this->_emailenabled ) $this->osCEmailer( $r, $this->_fullreport );
             # add ip to htaccess
             $this->htaccessbanip( $this->getRealIP() );
             # call an access denied header
             return $this->senda403Header();
         } elseif ( false !== $this->_useIPTRAP ) {
             if ( isset( $this->_ipTrappedURL ) && ( false !== $this->hCoreFileChk( $this->_ipTrappedURL ) ) ) {
                 # send an email
                 $this->osCEmailer( $r, $this->_fullreport );
                 # add ip to iptrap ban file
                 $this->ipTrapban( $this->getRealIP() );
                 # redirect to blocked.php
                 header( "Location: " . $this->_ipTrapBlocked );
                 exit;
             } else {
                 # if non-wrtiable iptrap file then call an access denied header
                 header( "Location: " . $this->_ipTrapBlocked );
                 exit;
             }
         } elseif ( false !== $this->_banipaddress ) {
             if ( false === $this->hCoreFileChk( $this->_htaccessfile ) ) {
                 # if non-wrtiable htaccess then call an access denied header
                 return $this->senda403Header();
             }
         } elseif ( ( false === $this->_banipaddress ) && ( !$this->_useIPTRAP ) ) {
             # if no banip or iptrap then call an access denied header
             return $this->senda403Header();
         } else return;
    }
    /**
     * osCAdminLoginBypass()
     * @return
     */
    function osCAdminLoginBypass() {
         # $this->byPass() is not called here
         if ( false !== strpos( $this->getREQUEST_URI(), ".php/login" ) ) {
            $r = "osC_Sec detected an attempt to exploit the admin login bypass exploit. ";
            $this->banChecker( $r, true );
            return;
         } else return;
    }

    /**
     * disable_tellafriend()
     * @return
     */
    function disable_tellafriend() {
         if ( false === $this->_disable_tellafriend
             || empty( $this->_disable_tellafriend )
             || 0 == $this->_disable_tellafriend ) return;
         global $PHP_SELF;
         $errlevel = ini_get( 'error_reporting' );
         if ( false === strpos( $PHP_SELF, "tell_a_friend.php" ) ) {
              return;
         } elseif ( false !== strpos( $PHP_SELF, "tell_a_friend.php" )
           && ( "POST" == $_SERVER[ "REQUEST_METHOD" ] )
           && isset( $_GET[ "products_id" ] ) ) {
              $r = "osC_Sec detected an attempt to send spam via the tell_a_friend.php file. ";
              $this->banChecker( $r, true );
              return;
         } elseif ( false !== strpos( $PHP_SELF, "tell_a_friend.php" )
           && isset( $_GET[ "products_id" ] ) ) {
              error_reporting( 0 );
              header( "Location: ./index.php" );
              return error_reporting( $errlevel );
         }
    }
    /**
     * databaseShield()
     * @return
     */
    function dbShield() {
         if ( false === $this->byPass() || empty( $_SERVER[ "QUERY_STRING" ] ) ) return;
         $_query = stripslashes( $_SERVER[ "QUERY_STRING" ] );
         if ( false !== $this->injectionMatch( strtolower( $_query ) ) ) {
               $r = "osC_Sec detected a database injection attempt: [ " . $_query . " ]. ";
               $this->banChecker( $r, true );
               return;
         }
         if ( ( strlen( $_SERVER[ "HTTP_USER_AGENT" ] ) > 1 )
              && false !== $this->injectionMatch( $_SERVER[ "HTTP_USER_AGENT" ] ) ) {
                $r = "\$_SERVER[ \"HTTP_USER_AGENT\" ] contains a database injection attempt: [ " . $_SERVER[ "HTTP_USER_AGENT" ] . " ]. ";
                $this->banChecker( $r, true );
                return;
         }
    }
    /**
     * postShield()
     * 
     * @return
     */
    function postShield() {
         if ( ( !isset( $_POST ) ) || ( "POST" !== $_SERVER[ "REQUEST_METHOD" ] )
             || ( false === $this->byPass() ) ) return;
         $postvar_blacklist = array( "eval(base64_decode", "concat(@@" );
 
         $pnodes = $this->array_flatten( $_POST, false );
         $i = 0;
         while ( $i < count( $pnodes ) ) {
             foreach ( $postvar_blacklist as $blacklisted ) {
                 $pnodes[$i] = strtolower( $pnodes[$i] );
                 if ( ( is_string( $pnodes[$i] ) ) && ( strlen( $pnodes[$i] ) > 0 ) ) {
                     if ( ( false !== strpos( $pnodes[$i], $blacklisted ) )
                         || ( false !== strpos( urldecode( $pnodes[$i] ), urldecode( $blacklisted ) ) ) ) {
                         $r = "osC_Sec detected an attempt to post malicious content: " . htmlspecialchars( stripslashes( $blacklisted ) ) . ". ";
                         $this->banChecker( $r, true );
                         return;
                     }
                 }
             }
             $i++;
         }
    }
    /**
     * getShield()
     * 
     * @return
     */
    function getShield() {
         if ( ( false === $this->byPass() ) || empty( $_SERVER[ "QUERY_STRING" ] ) ) return;
         $reqvar_blacklist = array(
         "php/login", "eval(base64_decode", "asc%3Deval", "fromCharCode", "; base64", "base64,","_START_",
         "onerror=alert(", "mysql_query", "../cmd", "rush=", "pwtoken_get", "EXTRACTVALUE(", "phpinfo(", "%000",
         "php_uname", "%3Cform", "passthru(", "sha1(", "sha2(", "<%3Fphp", "}%00.", "/iframe", "\$_GET",
         "ob_starting", ") limit", "%20and%201=1", "document.cookie", "document.write(", "onload%3d",
         "document.location", "window.location", "location.replace\(", "document.write",
         "onunload%3d", "PHP_SELF", "shell_exec", "\$_SERVER", "substr(", "\$_POST", "\$_SESSION", "\$_REQUEST",
         "\$_ENV", "GLOBALS[", "\$HTTP_", ".php/admin", "mosConfig_", "%3C@replace(", "hex_ent", "inurl:",
         "replace(", "/iframe>", "return%20clk", "login.php?action=backupnow", "php/password_for", "@@datadir",
         "unhex(", "error_reporting(", "HTTP_CMD", "=alert(", "version()", "localhost", "})%3B", "/FRAMESET",
         "Set-Cookie", "%27%a0%6f%72%a0%31%3d%31", "%bf%5c%27", "%bf%27", "%ef%bb%bf", "%8c%5c",
         "%a3%27", "%20regexp%20", "JHs=", "HTTP/1.", "{\$_", "PRINT @@variable", "xp_cmdshell",
         "xp_availablemedia", "*(|(objectclass=", "||UTL_HTTP.REQUEST", "<script>" );

         $injectattempt = false;
         
         $thenode = strtolower( $this->getREQUEST_URI() );
 
         $v = $this->cleanString( 1, $this->url_decoder( $thenode ) );
         
         # run through a specific set of tests on the REQUEST_URI irregardless of REQUEST_METHOD
         if ( ( false !== ( bool )preg_match( "/onmouse(?:down|over)/i", $v ) )
             && ( 2 < ( int )preg_match_all( "/c(?:path|tthis|t\(this)|http:|(?:forgotte|admi)n|sqlpatch|,,|ftp:|(?:aler|promp)t/i", $v, $matches ) ) ) {
             $injectattempt = true;
         } elseif ( ( ( false !== strpos( $v, "ftp:" ) ) && ( substr_count( $v, "ftp" ) > 1 ) )
             && ( 2 < ( int )preg_match_all( "/@|\/\/|:/i", $v, $matches ) ) ) {
             $injectattempt = true;
         } elseif ( ( "POST" == $_SERVER[ "REQUEST_METHOD" ] )
                   && ( false !== ( bool )preg_match( "/(?:showimg|cookie|cookies)=/i", $v ) ) ) {
                   $injectattempt = true;
         } elseif ( ( substr_count( $v, "../" ) > 2 )
             || ( substr_count( $v, "..//" ) > 2 ) ) {
             $sqlfilematchlist = "access_|access.|\balias\b|apache|bin|\bboot\b|config|\benviron\b|error_|error.|etc|
                        httpd|.log|_log|\.(?:js|txt|exe|ht|ini|bat)|\blib\b|log|\bproc\b|\bsql\b|tmp|\busr\b|
                        \bvar\b|(?:uploa|passw)d";
             $sqlfilematchlist = preg_replace( "/[\s]/i", "", $sqlfilematchlist );
             if ( false !== ( bool )preg_match( "/$sqlfilematchlist/i", $v ) ) {
                $injectattempt = true;
             }
         } elseif ( ( false !== ( bool )preg_match( "/%0D%0A/i", $thenode ) )
             && ( false !== strpos( $thenode, "utf-7" ) ) ) {
             $injectattempt = true;
         } elseif ( false !== ( bool )preg_match( "/php:\/\/filter|convert.base64-(?:encode|decode)|zlib.(?:inflate|deflate)/i", $v )
             || false !== ( bool )preg_match( "/data:\/\/filter|text\/plain|http:\/\/(?:127.0.0.1|localhost)/i", $v ) ) {
             $injectattempt = true;
         }
         if ( false !== ( bool )$injectattempt ) {
             $r = "osC_Sec detected an attempt to read or include unauthorized file content. ";
             $this->banChecker( $r, true );
             return;
         }
         foreach ( $reqvar_blacklist as $blacklisted ) {
             $blacklisted = strtolower( $this->url_decoder( $blacklisted ) );
             # simple check of the request_uri against the blacklist irregardless of REQUEST_METHOD

             if ( ( false !== strpos( $thenode, $blacklisted ) ) ||
                  ( false !== strpos( $this->url_decoder( urldecode( $thenode ) ), $this->url_decoder( $blacklisted ) ) ) ) {
                 $r = "osC_Sec blacklist request_uri item is banned: " . htmlspecialchars( $blacklisted ) . ". ";
                 $this->banChecker( $r, true );
                 return;
             }
             # simple check of the http_user_agent against the blacklist irregardless of REQUEST_METHOD
             if ( ( false !== strpos( strtolower( $_SERVER[ "HTTP_USER_AGENT" ] ), $blacklisted ) )
                 || ( false !== strpos( $this->url_decoder( $_SERVER[ "HTTP_USER_AGENT" ] ), $this->url_decoder( $blacklisted ) ) ) ) {
                  $r = "\$_SERVER[ \"HTTP_USER_AGENT\" ] contains a banned string: " . htmlspecialchars( $blacklisted ) . ". ";
                  $this->banChecker( $r, true );
                  return;
             }
         }
         # check each part of the $_GET query string against the list
         if ( !empty( $_SERVER[ "QUERY_STRING" ] ) ) {
             $gnodes = explode( "&", $_SERVER[ "QUERY_STRING" ] );
             $i = 0;
             while ( $i < count( $gnodes ) ) {
               if ( false === is_string( $gnodes[$i] ) ) {
                  continue;
               } else {
                  if ( false !== strpos( $gnodes[$i], "=" ) ) {
                     $tmp = explode( "=", $gnodes[$i] );
                     if ( is_array( $tmp ) ) {
                         $gvar = strtolower( $tmp[count( $tmp ) - count( $tmp )] );
                         $gval = $tmp[count( $tmp ) - 1];
                     }
                  } else {
                    $gvar = $gnodes[$i];
                    $gval = "";
                  }
                  $gfvar = $this->cleanString( 2, $gvar );
                  if ( !empty( $gval ) )  {
                     $gval64 = strtolower( base64_decode( $gval ) );
                     $gvalhexcheck = strtolower( $this->hextoascii( $gval ) );
                     $gval = strtolower( $gval );
                     $gfval = $this->cleanString( 2, $gval );
                  }
                  foreach ( $reqvar_blacklist as $blacklisted ) {
                      $blacklisted = strtolower( $this->url_decoder( $blacklisted ) );
                      if ( false !== $this->issetStrlen( $gfvar ) && ( false !== strpos( $gfvar, $blacklisted ) )
                          || ( false !== strpos( $this->url_decoder( urldecode( $gfvar ) ), $this->url_decoder( $blacklisted ) ) ) ) {
                           $r = "getShield() listed query_string filtered variable is banned: " . htmlspecialchars( $blacklisted ) . ". ";
                           $this->banChecker( $r, true );
                           return;
                      }
                      if ( false !== $this->issetStrlen( $gvalhexcheck )
                           && ( ( false !== strpos( $gvalhexcheck, $blacklisted ) )
                           || ( false !== strpos( $this->url_decoder( urldecode( $gvalhexcheck ) ), $this->url_decoder( $blacklisted ) ) ) ) ) {
                           $r = "osC_Sec blacklist hexcode query_string value is banned: " . htmlspecialchars( $blacklisted ) . ". ";
                           $this->banChecker( $r, true );
                           return;
                      }
                      if ( false !== $this->issetStrlen( $gvalhexcheck )
                           && false !== $this->injectionMatch( $gvalhexcheck ) ) {
                           $r = "osC_Sec detected a hexcode database injection attempt: [ " . $gvalhexcheck . " ]. ";
                           $this->banChecker( $r, true );
                           return;
                       }
                      if ( false !== $this->issetStrlen( $gval64 ) && ( false !== strpos( $gval64, $blacklisted ) ) ) {
                           $r = "osC_Sec base64 encoded blacklist query_string value is banned: " . htmlspecialchars( $blacklisted ) . ". ";
                           $this->banChecker( $r, true );
                           return;
                      }
                      if ( false !== $this->issetStrlen( $gfval ) && ( ( false !== strpos( $gfval, $blacklisted ) ) ||
                           ( false !== strpos( $this->url_decoder( urldecode( $gfval ) ), $this->url_decoder( $blacklisted ) ) ) ) ) {
                           $r = "osC_Sec blacklist query_string filtered value is banned: " . htmlspecialchars( $blacklisted ) . ". ";
                           $this->banChecker( $r, true );
                           return;
                      }
                  }
               }
             $i++;
             }
         }
    }
    /**
     * _REQUEST_Shield()
     * 
     * @return
     */
    function _REQUEST_Shield() {

         # this filter will only be affective on patched webservers to catch the PHP
         # code execution bug (CVE-2012-1823) See: http://www.php.net/archive/2012.php#id2012-05-08-1
         if ( false !== strpos( $this->getREQUEST_URI(), "?" ) ) {
            $v = substr( $this->getREQUEST_URI(), strpos( $this->getREQUEST_URI(), "?" ), strlen( $this->getREQUEST_URI() ) );
            if ( false !== strpos( $v, "-" )
                && ( ( false !== strpos( $v, "?-" ) )
                    || ( false !== strpos( $v, "?+-" ) )
                    || ( false !== strpos( $this->url_decoder( $v ), "?+-" ) ) )
                && ( false === strpos( $this->url_decoder( $v ), "=" ) ) ) {
                $r = "osC_Sec detected an attempt to exploit PHP bug. ";
                $this->banChecker( $r, true );
                return;
            }
         }
    }
    /**
     * cookieShield()
     * 
     * @return
     */
    function cookieShield() {
         if ( ( false === $this->byPass() ) || ( false !== empty( $_COOKIE ) ) ) return;
 
         $_cookie_blacklist = "eval\(base64_|fromCharCode|prompt\(|ZXZhbCg=|ZnJvbUNoYXJDb2Rl|U0VMRUNULyoqLw==|Ki9XSEVSRS8q";
 
         $injectattempt = false;
         $cnodekeys = array_keys( $_COOKIE );
         $cnodevals = array_values( $_COOKIE );
         $v = implode( " ", $cnodevals );
         $orig_v = $v;
         $injectattempt = ( bool )$this->injectionMatch( $v );
         if ( false !== ( bool )$injectattempt ) {
             $r = "osC_Sec detected malicious \$_COOKIE content: [ " . stripslashes( $orig_v ) . " ].";
             $this->banChecker( $r, true );
             return;
         }
         $i = 0;
         while ( $i < count( $cnodekeys ) ) {
             $cnodekey = strtolower( $cnodekeys[$i] );
             if ( empty( $cnodevals[$i] ) ) {
               continue;
             } else {
               $cnodeval = rawurldecode( strtolower( $cnodevals[$i] ) );
             }
             if ( ( is_string( $cnodekey ) ) ) {
                if ( false !== ( bool )preg_match( "/$_cookie_blacklist/i", ( $cnodeval ) ) ) {
                   $r = "osC_Sec detected a banned \$_Cookie string: " . $cnodekey . "=" . $cnodeval;
                   $this->banChecker( $r, true );
                   return;
                }
             }
             $i++;
         }
    }
    /**
     * injectionMatch()
     * 
     * @param mixed $string
     * @return
     */
    function injectionMatch( $string ) {
         $string = $this->url_decoder( $string );
         $string = $this->cleanString( 1, $string ); // urldecode twice
         $string = strtolower( $string );
         $string = str_replace( "//", " ", $string );
         $sqlmatchlist = "(?:abs|ascii|base64|bin|cast|chr|char|charset|collation|concat|concat_ws|
                           conv|convert|count|curdate|database|date|decode|diff|distinct|elt|encode|encrypt|
                           extract|field|floor|format|hex|if|in|insert|instr|interval|lcase|left|
                           length|load_file|locate|lock|log|lower|lpad|ltrim|max|md5|mid|mod|name|now|
                           null|ord|password|position|quote|rand|repeat|replace|reverse|right|rlike|
                           round|row_count|rpad|rtrim|_set|schema|sha1|sha2|sleep|soundex|space|strcmp|
                           substr|substr_index|substring|sum|time|trim|truncate|ucase|unhex|upper|
                           _user|user|values|varchar|version|while|xor)\(|\(0x|@@|cast|integer";
                           $sqlmatchlist = preg_replace( "/[\s]/i", "", $sqlmatchlist );
                           
         $sqlupdatelist = "\bcolumn\b|\bdata\b|concat\(|\bemail\b|\blogin\b|\bname\b|\bpass\b|sha1|sha2|\btable\b|\bwhere\b|\buser\b|\bval\b|0x";
         
         if ( false !== ( bool )preg_match( "/\bdrop\b/i", $string )
             && false !== ( bool )preg_match( "/\btable\b|\buser\b/i", $string )
             && false !== ( bool )preg_match( "/--|\//i", $string ) ) {
               return true;
         } elseif ( ( false !== strpos( $string, "grant" ) )
                 && ( false !== strpos( $string, "all" ) )
                 && ( false !== strpos( $string, "privileges" ) ) ) {
               return true;
         } elseif ( false !== ( bool )preg_match( "/(?:(sleep\((\s*)(\d*)(\s*)\)|benchmark\((.*)\,(.*)\)))/i", $string ) ) {
               return true;
         } elseif ( false !== preg_match_all( "/\bload\b|\bdata\b|\binfile\b|\btable\b|\bterminated\b/i", $string, $matches ) > 3 ) {
               return true;
         } elseif ( ( ( false !== ( bool )preg_match( "/select|declare|ascii\(substring|length\(/i", $string ) )
           && ( false !== ( bool )preg_match( "/\band\b|\bif\b|\bfrom\b/i", $string ) )
           && ( false !== ( bool )preg_match( "/$sqlmatchlist/", $string ) ) ) ) {
               return true;
         } elseif ( false !== preg_match_all( "/$sqlmatchlist/", $string, $matches ) > 2 ) {
               return true;
         } elseif ( false !== strpos( $string, "update" ) && false !== ( bool )preg_match( "/\bset\b/i", $string )
               && ( false !== ( bool )preg_match( "/$sqlupdatelist/i", $string ) ) ) {
               return true;
         # tackle the noDB / js issue
         } elseif ( ( substr_count( $string, "var" ) > 1 ) && ( false !== ( bool )preg_match( "/date\(|while\(|sleep\(/i", $string ) ) ) {
               return true;
         }
         $string = $this->cleanString( 2, $string );
         $sqlmatchlist = "@@|_and|ascii|b(?:enchmark|etween|in|itlength|ulk)|c(?:ast|har|ookie|ollate|oncat|urrent)|\bdate\b|dump|
                          e(?:lt|xport)|false|\bfield\b|fetch|format|function|\bhaving\b|i(?:dentity|nforma|nstr)|\bif\b|\bin\b|
                          l(?:case|eft|ength|ike|imit|oad|ocate|ower|pad|trim)|join|m(:?ake|atch|d5|id)|not_like|not_regexp|order|outfile|
                          p(?:ass|ost|osition|riv)|\bquote\b|\br(?:egexp\b|ename\b|epeat\b|eplace\b|equest\b|everse\b|eturn\b|ight\b|like\b|pad\b|trim\b)|
                          \bs(?:ql\b|hell\b|leep\b|trcmp\b|ubstr\b)|\bt(?:able\b|rim\b|rue\b|runcate\b)|u(?:case|nhex|pdate|pper|ser)|
                          values|varchar|\bwhen\b|where|with|\(0x|_(?:decrypt|encrypt|get|post|server|cookie|global|or|request|xor)|
                          (?:column|db|load|not|octet|sql|table|xp)_";
                         $sqlmatchlist = preg_replace( "/[\s]/i", "", $sqlmatchlist );
                         
         if ( false !== strpos( $string, "by" )
             && ( false !== ( bool )preg_match( "/\border\b|\bgroup\b/i", $string ) )
             && ( false !== ( bool )preg_match( "/\bcolumn\b|\bdesc\b|\berror\b|\bfrom\b|hav|\blimit\b|\boffset\b|\btable\b|\/|--/i", $string )
             || ( false !== ( bool )preg_match( "/\b[0-9]\b/i", $string ) ) ) ) {
               return true;
         } elseif ( ( false !== ( bool )preg_match( "/\btable\b|\bcolumn\b/i", $string  ) ) && false !== strpos( $string, "exists" )
             && ( false !== ( bool )preg_match( "/\bif\b|\berror\b|\buser\b|\bno\b/i", $string ) ) ) {
               return true;
         } elseif ( ( ( false !== strpos( $string, "waitfor" ) && false !== strpos( $string, "delay" ) && ( ( bool )preg_match( "/(:)/i", $string ) ) )
             || false !== strpos( $string, "nowait" ) )
             && ( false !== ( bool )preg_match( "/--|\/|\blimit\b|\bshutdown\b|\bupdate\b|\bdesc\b/i", $string ) ) ) {
               return true;
         } elseif ( false !== ( bool )preg_match( "/\binto\b/i", $string )
             && ( false !== ( bool )preg_match( "/\boutfile\b/i", $string ) ) ) {
               return true;
         } elseif ( false !== ( bool )preg_match( "/\bdrop\b/i", $string )
             && ( false !== ( bool )preg_match( "/\buser\b/i", $string ) ) ) {
               return true;
         } elseif ( ( ( false !== strpos( $string, "create" ) && false !== ( bool )preg_match( "/\btable\b|\buser\b|\bselect\b/i", $string ) )
             || ( false !== strpos( $string, "delete" ) && false !== strpos( $string, "from" ) ) 
             || ( false !== strpos( $string, "insert" ) && ( false !== ( bool )preg_match( "/\bexec\b|\binto\b|from/i", $string ) ) )
             || ( false !== strpos( $string, "select" ) && ( false !== ( bool )preg_match( "/\bby\b|\bcase\b|from|\bif\b|\binto\b|\bord\b|union/i", $string ) ) ) )
             && ( ( false !== ( bool )preg_match( "/$sqlmatchlist/i", $string ) ) || ( 2 < substr_count( $string, "," ) ) ) ) {
               return true;
         } elseif ( ( false !== strpos( $string, "union" ) )
                  && ( false !== strpos( $string, "select" ) )
                  && ( false !== strpos( $string, "from" ) ) ) {
                  return true;
         } elseif ( false !== strpos( $string, "null" ) ) {
               $nstring = preg_replace( "/[^a-z]/i", "", $this->url_decoder( $string ) );
               if ( false !== ( bool )preg_match( "/(null){2,}/i", $nstring ) ) {
                   return true;
               } else return false;
         } else return false;
    return false;
    }
    function hextoascii( $str ) {
         if ( ( substr_count( $str, "%" ) < 3 ) && ( substr_count( $str, "\x" ) < 1 ) ) return;
         $p = "";
         for ( $i = 0; $i < strlen( $str ); $i = $i + 2 ) {
             $p .= chr( hexdec( substr( $str, $i, 2 ) ) );
         }
         return $this->cleanString( 1, $p );
    }
    function cleanString( $b, $s ) {
         switch( $b ) {
             case( 1 ):
                  return preg_replace( "/[^\s{}a-z0-9_?,()=@%:{}\/.-]/i", "", $this->url_decoder( $s ) );
                  break;
             case ( 2 ):
                  return preg_replace( "/[^\s{}a-z0-9_?,=@%:{}\/.-]/i", "", $this->url_decoder( $s ) );
                  break;
             case ( 3 ):
                  return preg_replace( "/[^a-z0-9]/i", "", $this->url_decoder( $s ) );
                  break;
             default:
                  return $this->url_decoder( $s );
         }
    }
    function notemptisarr( $var ) {
         return ( bool )( !empty( $var ) && is_array( $var ) );
    }
    /**
     * htaccessbanip()
     * 
     * @param mixed $banip
     * @return
     */
    function htaccessbanip( $banip ) {
         if ( false === $this->byPass() ) return;
         if ( !isset( $this->_htaccessfile ) ) return $this->senda403Header();
         $limitend = "# End of $this->_httphost Osc_Sec Ban\n";
         $newline = "deny from $banip\n";
         if ( file_exists( $this->_htaccessfile ) ) {
             $mybans = file( $this->_htaccessfile );
             $lastline = "";
             if ( in_array( $newline, $mybans ) ) exit();
             if ( in_array( $limitend, $mybans ) ) {
                 $i = count( $mybans ) - 1;
                 while ( $mybans[$i] != $limitend ) {
                     $lastline = array_pop( $mybans ) . $lastline;
                     $i--;
                 }
                 $lastline = array_pop( $mybans ) . $lastline;
                 $lastline = array_pop( $mybans ) . $lastline;
                 array_push( $mybans, $newline, $lastline );
             } else {
                 array_push( $mybans, "\n\n# $this->_httphost Osc_Sec Ban\n", "order allow,deny\n", $newline,
                     "allow from all\n", $limitend );
             }
         } else {
             $mybans = array( "# $this->_httphost Osc_Sec Ban\n", "order allow,deny\n", $newline, "allow from all\n", $limitend );
         }
         if ( ini_get( 'allow_url_fopen' ) == 1 ) @ini_set( 'allow_url_fopen', '0' );
         if ( ini_get( 'allow_url_include' ) == 1 ) @ini_set( 'allow_url_include', '0' );
         $myfile = fopen( $this->_htaccessfile, "w" );
         fwrite( $myfile, implode( $mybans, "" ) );
         fclose( $myfile );
    }
    /**
     * ipTrapped()
     * 
     * @return
     */
    function ipTrapped() {
         if ( ( false !== $this->_useIPTRAP )
             && ( !empty( $this->_ipTrappedURL )
                 && file_exists( $this->_ipTrappedURL ) ) ) {
                # if IP is already in IP Trap list then redirect
                $mybans = file( $this->_ipTrappedURL );
                if ( false === $mybans ) return false;
                $mybans = array_values( $mybans );
                foreach ( $mybans as $i => $value ) {
                    if ( strlen( $mybans[$i] > 0 ) ) {
                        # find IP address in IP Trap ban list
                        if ( false !== strpos( $mybans[$i], $this->getRealIP() ) ) {
                            $this->_emailenabled = 0;
                            return true;
                        }
                    }
                }
         }
         return false;
    }
    
    function setIPTrapBlocked( $ipTrapBlocked ) {
         if ( false !== ( bool )$this->fINT( $this->_useIPTRAP ) ) {
            if ( false !== $this->fURL( $ipTrapBlocked ) ) {
                $this->_ipTrapBlocked = $ipTrapBlocked;
                return;
            } else {
                $this->_ipTrapBlocked = "";
                return;
            }
         } else return;
    }
    /**
     * my_array_filter_fn()
     * 
     * @param mixed $val
     * @return
     */
    function my_array_filter_fn( $val ) {
         $val = trim( $val );
         $allowed_vals = array( "0" );
         return in_array( $val, $allowed_vals, true ) ? true : ( $val ? true : false );
    }
    /**
     * ipTrapban()
     * 
     * @param mixed $banip
     * @return
     */
    function ipTrapban( $banip ) {
         if ( false === $this->byPass() ) return;
         $bannedAlready = false;
         $limitend = "\n";
         $newline = "$banip";
         if ( !empty( $this->_ipTrappedURL ) && file_exists( $this->_ipTrappedURL ) ) {
             $mybans = file( $this->_ipTrappedURL );
             $lastline = "";
             $mybans = array_filter( $mybans, array( "osC_Sec", "my_array_filter_fn" ) );
             $mybans = array_values( $mybans );
             $endIPTrapIP = "999.999.999.999";
             foreach ( $mybans as $i => $value ) {
                 if ( strlen( $mybans[$i] > 0 ) ) {
                     if ( false !== strpos( $mybans[$i], $newline ) ) $bannedAlready = true;
                 }
             }
             foreach ( $mybans as $i => $value ) {
                 if ( false !== strpos( $mybans[$i], " " ) ) $mybans[$i] = preg_replace( "/[\s\r\n]/i", "", $mybans[$i] );
                 if ( ( false === ( bool )preg_match( "`[\r\n]`", $mybans[$i] ) ) ) $mybans[$i] = $mybans[$i] . "\n";
             }
             if ( false !== ( bool )$bannedAlready ) {
                 if ( ini_get( 'allow_url_fopen' ) == 1 ) @ini_set( 'allow_url_fopen', '0' );
                 if ( ini_get( 'allow_url_include' ) == 1 ) @ini_set( 'allow_url_include', '0' );
                 $myfile = fopen( $this->_ipTrappedURL, "w" );
                 fwrite( $myfile, implode( $mybans, "" ) );
                 fclose( $myfile );
             }
             if ( false === ( bool )$bannedAlready ) {
                 if ( ( false !== strpos( $mybans[$i], $endIPTrapIP ) ) ) unset( $mybans[$i] );
                 if ( in_array( $limitend, $mybans ) ) {
                     $i = count( $mybans ) - 1;
                     while ( $mybans[$i] != $limitend ) {
                         $lastline = array_pop( $mybans ) . $lastline;
                         $i--;
                     }
                     array_push( $mybans, $newline, $endIPTrapIP );
                 } else {
                     array_push( $mybans, "\n", $newline, $endIPTrapIP );
                 }
             } else {
                 if ( false === ( bool )$bannedAlready ) {
                     $mybans = array( "\n", $newline, $endIPTrapIP );
                 }
             }
             if ( false === ( bool )$bannedAlready ) {
                 $mybans = array_filter( $mybans, array( "osC_Sec", "my_array_filter_fn" ) );
                 $mybans = array_values( $mybans );
                 $i = 0;
                 foreach ( $mybans as $i => $value ) {
                     if ( false !== strpos( $mybans[$i], " " ) ) $mybans[$i] = str_replace( " ", "", $mybans[$i] );
                     if ( ( false === ( bool )preg_match( "`[\r\n]`", $mybans[$i] ) ) ) $mybans[$i] = $mybans[$i] . "\n";
                 }
                 if ( ini_get( 'allow_url_fopen' ) == 1 ) @ini_set( 'allow_url_fopen', '0' );
                 if ( ini_get( 'allow_url_include' ) == 1 ) @ini_set( 'allow_url_include', '0' );
                 $myfile = fopen( $this->_ipTrappedURL, "w" );
                 fwrite( $myfile, implode( $mybans, "" ) );
                 fclose( $myfile );
             }
         }
    }
    /**
     * hCoreFileChk()
     * 
     * @param mixed $filename
     * @return
     */
    function hCoreFileChk( $filename ) {
         if ( ( file_exists( $filename ) )
             && ( is_readable( $filename ) )
             && ( is_writable( $filename ) ) ) {
             return true;
         }
         return false;
    }
    /**
     * checkfilename()
     * 
     * @param mixed $fname
     * @return
     */
    function checkfilename( $fname ) {
         if ( ( !empty( $fname ) )
             && ( substr_count( $fname, ".php" ) == 1 )
             && ( ".php" == substr( $fname, -4 ) ) ) {
             if ( ( ( strlen( $fname ) ) - ( strpos( $fname, "." ) ) ) <> 4 ) {
                 return false;
             } elseif ( ( false !== file_exists( $fname )
                       && false !== is_readable( $fname ) )
                       || ( false !== strpos( $_SERVER[ "SCRIPT_NAME" ], "ext/modules/" ) ) ) return true;
         } else return false;
         return false;
    }
    /**
     * phpSelfFix()
     * 
     * @return
     */
    function phpSelfFix() {
         if ( false !== ( bool )ini_get( "register_globals" )
             || ( !isset( $HTTP_SERVER_VARS ) ) ) $HTTP_SERVER_VARS = $_SERVER;
         $filename = NULL;
         # this is the RC3 standard code
         $filename = ( ( ( strlen( ini_get( "cgi.fix_pathinfo" ) ) > 0 )
                      && ( ( bool )ini_get( "cgi.fix_pathinfo" ) == false ) )
                      || !isset( $HTTP_SERVER_VARS[ "SCRIPT_NAME" ] ) ) ?
                      basename( $HTTP_SERVER_VARS[ "PHP_SELF" ] ) :
                      basename( $HTTP_SERVER_VARS[ "SCRIPT_NAME" ] );
                     if ( false === $this->checkfilename( $filename ) ) {
                         $filename = NULL;
                     } else return $filename;
 
         # if RC3 fails then try a version of FWR Media's $PHP_SELF code.
         if ( empty( $filename ) && ( false !== strpos( $_SERVER[ "SCRIPT_NAME" ], ".php" ) ) ) {
             preg_match( "@[a-z0-9_]+\.php@i", $_SERVER[ "SCRIPT_NAME" ], $matches );
             if ( is_array( $matches ) && ( array_key_exists( 0, $matches ) )
                 && ( substr( $matches[0], -4, 4 ) == ".php" )
                 && ( is_readable( $matches[0] )
                 || ( false !== strpos( $_SERVER[ "SCRIPT_NAME" ], "ext/modules/" ) ) ) ) {
                 $filename = $matches[0];
             }
             if ( false === $this->checkfilename( $filename ) ) {
                 $filename = NULL;
             } else return $filename;
         }
   
         # if that fails then try osC_Sec $PHP_SELF code
         if ( empty( $filename ) && false !== $this->issetStrlen( $_SERVER[ "SCRIPT_FILENAME" ] ) ) {
             $tmp = explode( "/", $_SERVER[ "SCRIPT_FILENAME" ] );
             if ( is_array( $tmp ) ) {
                 $filename = $tmp[count( $tmp ) - 1];
             }
             if ( false !== $this->checkfilename( $filename ) ) {
                 return $filename;
             }
         } elseif ( ( $_SERVER[ "PHP_SELF" ] == "/" ) || ( $_SERVER[ "SCRIPT_NAME" ] == "/" ) ) {
          return "index.php";
         } else die(); // prevent the page from executing
    }
    /**
     * array_flatten()
     * 
     * @param mixed $array
     * @param bool $preserve_keys
     * @return
     */
    function array_flatten( $array, $preserve_keys = false ) {
         if ( false === $preserve_keys ) {
             $array = array_values( $array );
         }
         $flattened_array = array();
         foreach ( $array as $k => $v ) {
             if ( is_array( $v ) ) {
                 $flattened_array = array_merge( $flattened_array, $this->array_flatten( $v, $preserve_keys ) );
             } elseif ( $preserve_keys ) {
                 $flattened_array[ $k ] = $v;
             } else {
                 $flattened_array[] = $v;
             }
         }
         return $flattened_array;
    }

    /**
     * byPass()
     * 
     * @return
     */
    function byPass() {
        
         $filename_bypass = array();
         $dir_bypass = array();
         $exfrmBanlist = array();
   
         # list of files to bypass. I have added a few for consideration. Try to keep this list short
         $filename_bypass = array( "sitemonitor", "protx_process.php", "dps_pxpay_result_handler.php", 
                                   "ipn.php", "express_payflow.php", "quickpay.php", "xml.php",
                                   "xml2.php" );
         
         # bypass all files in a directory. Use this sparingly
         $dir_bypass = array( "/ext/modules/payment" );
   
         # list of IP exceptions. Add bypass ips and uncomment for use
         # $exfrmBanlist = array( '', '', '' );
         
         $realip = $this->getRealIP();
         if ( false === empty( $exfrmBanlist ) ) {
           foreach ( $exfrmBanlist as $exCeptions ) {
               if ( false !== ( strlen( $realip ) == strlen( $exCeptions ) )
                   && ( false !== strpos( $realip, $exCeptions ) ) ) {
                   return false;
               }
           }
         }
         if ( false === empty( $filename_bypass ) ) {
           global $PHP_SELF;
           foreach ( $filename_bypass as $filename ) {
               if ( false !== strpos( $PHP_SELF, $filename ) ) {
                   return false;
               }
           }
         }
         if ( false === empty( $dir_bypass ) ) {
           foreach ( $dir_bypass as $dirname ) {
               if ( false !== strpos( $_SERVER[ "SCRIPT_NAME" ], $dirname ) ) {
                   return false;
               }
           }
         }
         return true;
    }
    /**
     * checkReqType()
     * 
     * @return
     */
    function checkReqType() {
         if ( false === $this->byPass() || ( false === $this->_nonGETPOSTReqs ) ) return;
         $reqType = $_SERVER[ "REQUEST_METHOD" ];
         $req_whitelist = array( "GET", "OPTIONS", "HEAD", "POST" );
         # first check for numbers in REQUEST_METHOD
         if ( false !== ( bool )preg_match( "/[0-9]+/", $reqType ) ) {
             $r = " Request method [ " . $_SERVER[ "REQUEST_METHOD" ] . " ] should not contain numbers. ";
             $this->banChecker( $r, true );
         }
         # then make sure its all UPPERCASE (for servers that do not filter the case of the request method)
         if ( false === ctype_upper( $reqType ) ) {
             $r = " Request method [ " . $_SERVER[ "REQUEST_METHOD" ] . " ] should be in all uppercase letters. ";
             $this->banChecker( $r, true );
             # lastly check against the whitelist
         } elseif ( false === in_array( $reqType, $req_whitelist ) ) {
             $r = " Request method [ " . $_SERVER[ "REQUEST_METHOD" ] . " ] is neither GET, OPTIONS, HEAD or POST. ";
             $this->banChecker( $r, true );
         }
    }
    /**
     * chkSetup()
     * 
     * @return
     */
    function chkSetup() {
         # Make sure $banipaddress and $useIPTRAP are not both activated at the same time
         if ( ( $this->_banipaddress ) && ( $this->_useIPTRAP ) ) die( "<p align=center><font face=verdana size=1>" .
                 "<strong>WARNING</strong>: Choose either \$banipaddress or \$useIPTRAP, not both thanks.</font></p>" );
         # if using IPTrap, Make sure $ipTrapBlocked is set
         if ( ( $this->_useIPTRAP ) && empty( $this->_ipTrapBlocked ) ) die( "<p align=center><font face=verdana size=1>" .
                 "<strong>WARNING</strong>: Check the \$ipTrapBlocked url to the IP Trap blocked.php file in the osc.php file for errors.<br />".
                 "\$ipTrapBlocked cannot be left empty if IP Trap is enabled. If not empty then check that the URL is correct." );
     return;
    }
    /**
     * getDir()
     * 
     * @return
     */
    function getDir() {
         if ( defined( "DIR_FS_CATALOG" )
            && false === strpos( DIR_FS_CATALOG, "http://" ) ) {
            if ( "/" !== substr( DIR_FS_CATALOG, -1 ) ) return DIR_FS_CATALOG . "/";
               return DIR_FS_CATALOG;
         } elseif ( !defined( "DIR_FS_CATALOG" )
            || ( defined( "DIR_FS_CATALOG" )
               && false !== strpos( DIR_FS_CATALOG, "http://" ) ) ) {
               $rootDir = $_SERVER[ "SCRIPT_NAME" ];
               if ( false !== strpos( $rootDir, "/" ) ) {
                  if ( $rootDir[0] == "/" ) {
                     $rootDir = substr( $rootDir, 1 );
                     $pos = strpos( strtolower( $rootDir ), strtolower( "/" ) );
                     $pos += strlen( "." ) - 1;
                     $rootDir = substr( $rootDir, 0, $pos );
                     if ( "/" !== substr( $rootDir, -1 ) ) $rootDir = "/" . $rootDir . "/";
                  }
               }
               $dirFS = $_SERVER[ "DOCUMENT_ROOT" ] . $rootDir;
               while ( ( false !== strpos( $dirFS, "//" ) ) ) {
                   $dirFS = str_replace( "//", "/", $dirFS );
               }
         return $dirFS;
         }
    }
    /**
     * check_ip()
     * 
     * @param mixed $ip
     * @return
     */
    function check_ip( $ip ) {
         # simple ip format check
         if ( function_exists( 'filter_var' )
             && defined( 'FILTER_VALIDATE_IP' )
             && defined( 'FILTER_FLAG_IPV4' )
             && defined( 'FILTER_FLAG_IPV6' ) ) {
             if ( filter_var( $ip, FILTER_VALIDATE_IP,
                                   FILTER_FLAG_IPV4 ||
                                   FILTER_FLAG_IPV6 ) === false ) {
                                   return $this->senda403Header();
             } else return true;
         }
         if ( preg_match( '/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $ip ) ) {
           $parts = explode( '.', $ip );
           foreach ( $parts as $ip_parts ) {
             if ( !is_numeric( $ip_parts ) || ( ( int )( $ip_parts ) > 255 ) || ( ( int )( $ip_parts ) < 0 ) ) {
                return $this->senda403Header();
             }
           }
         return true;
         } else return false;
    }
   
    /**
     * getRealIP()
     * 
     * @return
     */
    function getRealIP() {
         global $_SERVER;
         $ip_addresses = array();
         if ( isset( $_SERVER ) ) {
         // check for IPs passing through proxies
            if ( !empty( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) ) {
             // check if multiple ips exist in var
              $iplist = explode( ',', $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] );
              foreach ( $iplist as $ip ) {
               if ( $this->check_ip( $ip ) )
                $HTTP_X_FORWARDED_FOR = $ip;
              }
            }
         }
         if ( ( !empty( $_SERVER[ 'HTTP_CLIENT_IP' ] )
               && false !== $this->check_ip( $_SERVER[ 'HTTP_CLIENT_IP' ] ) ) 
           || ( !empty( $HTTP_X_FORWARDED_FOR )
               && false !== $this->check_ip( $HTTP_X_FORWARDED_FOR ) ) 
           || ( !empty( $_SERVER[ 'HTTP_X_FORWARDED' ] )
               && false !== $this->check_ip( $_SERVER[ 'HTTP_X_FORWARDED' ] ) )
           || ( !empty( $_SERVER[ 'HTTP_PROXY_USER' ] )
               && false !== $this->check_ip( $_SERVER[ 'HTTP_PROXY_USER' ] ) ) 
           || ( !empty( $_SERVER[ 'HTTP_X_CLUSTER_CLIENT_IP' ] )
               && false !== $this->check_ip( $_SERVER[ 'HTTP_X_CLUSTER_CLIENT_IP' ] ) ) 
           || ( !empty( $_SERVER[ 'HTTP_FORWARDED' ] )
               && false !== $this->check_ip( $_SERVER[ 'HTTP_FORWARDED' ] ) )
           || ( !empty( $_SERVER[ 'HTTP_CF_CONNECTING_IP' ] )
               && false !== $this->check_ip( $_SERVER[ 'HTTP_CF_CONNECTING_IP' ] ) )
           || ( !empty( $_SERVER[ 'HTTP_FORWARDED_FOR' ] )
               && false !== $this->check_ip( $_SERVER[ 'HTTP_FORWARDED_FOR' ] ) ) ) {
                  # just disable the ban IP function so as not to
                  # accidentally ban an upstream proxy server
                  # however osC_Sec can still block any
                  # malicious requests irregardless
                  $this->_banipaddress = 0;
                  $this->_useIPTRAP = 0;
         }
         return ( false !== $this->check_ip( $_SERVER[ "REMOTE_ADDR" ] ) ) ? $_SERVER[ "REMOTE_ADDR" ] : $this->senda403Header();
    }
    function fINT( $integ ) {
      # check input is an integer and no lower than 0 in value
       if ( function_exists( 'filter_var' ) && defined( 'FILTER_SANITIZE_NUMBER_INT' ) ) {
              $integ_filtered = ( int )filter_var( $integ, FILTER_SANITIZE_NUMBER_INT );
              if ( isset( $integ )
                  && $integ_filtered
                  && is_int( $integ_filtered )
                  && 0 <= $integ_filtered ) {
                return $integ_filtered;
              } else return 0;
       } elseif ( isset( $integ )
                  && is_int( $integ )
                  && 0 <= ( int )$integ ) {
                return ( int )$integ;
       } else return 0;
    }
    function fURL( $url ) {
         if ( function_exists( 'filter_var' ) && defined( 'FILTER_SANITIZE_URL' ) ) {
                $url_filtered = filter_var( $url, FILTER_SANITIZE_URL );
                return true;
         }
         if ( !isset( $url_filtered ) ) {
           if ( preg_match( "#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i", $url ) ) {
               return true;
           } else return false;
         }
         return false;
    }
    /**
     * strCharsfrmStr()
     * 
     * @param mixed $string
     * @param mixed $strip
     * @param mixed $replace
     * @return
     */
    function strCharsfrmStr( $string, $strip, $replace ) {
         $x = ( false !== strpos( $string, $strip ) ) ? true : false;
         while ( false !== $x ) {
             $string = str_replace( $strip, $replace, $string );
             $x = ( false !== strpos( $string, $strip ) ) ? true : false;
         }
         return $string;
    }
    /**
     * Bad Spider Block
     */
    function badArachnid() {
         if ( false === $this->byPass() ) return;
         if ( false !== $this->issetStrlen( $_SERVER[ "HTTP_USER_AGENT" ] ) ) {
           $badagentlist = array( "Baidu", "WebLeacher", "autoemailspider", "MSProxy", "Yeti", "Twiceler", "blackhat", "Mail.Ru", "fuck" );
           $lcUserAgent = strtolower( $_SERVER[ "HTTP_USER_AGENT" ] );
           foreach ( $badagentlist as $badagent ) {
               $badagent = strtolower( $badagent );
               if ( false !== strpos( $lcUserAgent, $badagent ) ) {
                   $header = array( "HTTP/1.1 404 Not Found", "HTTP/1.1 404 Not Found", "Content-Length: 0" );
                   foreach ( $header as $sent ) {
                       header( $sent );
                   }
                   die();
               }
           }
         } else return;
     return;
    }
    function get_version() {
         if ( false !== file_exists( $this->getDir() . 'includes/version.php' )
            && false !== is_readable( $this->getDir() . 'includes/version.php' ) ) {
            return trim( implode( '', file( $this->getDir() . 'includes/version.php' ) ) );
         }
      return false;
    }
    function setOpenBaseDir() {
         if ( false !== $this->get_version()
            && $this->get_version() == "2.3.1" ) {
            if ( strlen( ini_get( 'open_basedir' ) == 0 ) ) {
                return @ini_set( 'open_basedir', $this->getDir() );
            }
         } else return;
    }
   /**
    * x_powered_by()
    */
    function x_powered_by() {
         $errlevel = ini_get( 'error_reporting' );
         error_reporting( 0 );
         if ( false !== ( bool )ini_get( 'expose_php' ) ) {
            header( "X-Powered-By: osC_Sec" );
         }
         error_reporting( $errlevel );
         return;
    }
   /**
    * url_decoder()
    */
    function url_decoder( $var ) {
         return rawurldecode( urldecode( $var ) );
    }
    function getREQUEST_URI() {
         if ( false !== getenv( 'REQUEST_URI' ) ) {
            return getenv( 'REQUEST_URI' );
         } else {
            return $_SERVER[ "REQUEST_URI" ];
         }
    }
    function issetStrlen( $str ) {
        if ( isset( $str ) && ( strlen( $str ) > 0 ) ) {
           return true;
        } else {
           return false;
        }
    }
  } // end of class
  
  /**
   * osCSec_selfchk()
   * 
   * @return
   */
  function osCSec_selfchk() {
      $oscsecfilepath = str_replace( DIRECTORY_SEPARATOR, urldecode( "%2F" ), __file__ );
      $oscsecfilepath = explode( "/", $oscsecfilepath );
      if ( is_array( $oscsecfilepath ) ) {
          $fileself = $oscsecfilepath[count( $oscsecfilepath ) - 1];
          if ( $fileself[0] == "/" ) {
              return $fileself;
          } else {
              return "/" . $fileself;
          }
      }
  }
  /**
   * senda404Header()
   * 
   * @return
   */
  function senda404Header() {
         $header = array( "HTTP/1.1 404 Not Found", "HTTP/1.1 404 Not Found", "Content-Length: 0" );
         foreach ( $header as $sent ) {
             header( $sent );
         }
         die();
  }
 /**
  * fix_server_vars()
  * 
  * @return
  */
  function fix_server_vars() {
         $_request_uri = "";
         if ( empty( $_SERVER[ "REQUEST_URI" ] )
             || ( php_sapi_name() != "cgi-fcgi"
                 && false !== ( bool )preg_match( "/^Microsoft-IIS\//", $_SERVER[ "SERVER_SOFTWARE" ] ) ) ) {
            if ( false !== getenv( 'REQUEST_URI' ) ) {
               $_request_uri = getenv( 'REQUEST_URI' );
            } elseif ( isset( $_SERVER[ "HTTP_X_ORIGINAL_URL" ] ) ) {
                   $_request_uri = $_SERVER[ "HTTP_X_ORIGINAL_URL" ];
            } elseif ( isset( $_SERVER[ "HTTP_X_REWRITE_URL" ] ) ) {
                       $_request_uri = $_SERVER[ "HTTP_X_REWRITE_URL" ];
            } else {
               if ( !isset( $_SERVER[ "PATH_INFO" ] )
                   && isset( $_SERVER[ "ORIG_PATH_INFO" ] ) ) $_SERVER[ "PATH_INFO" ] = $_SERVER[ "ORIG_PATH_INFO" ];
               if ( isset( $_SERVER[ "PATH_INFO" ] ) ) {
                   if ( $_SERVER[ "PATH_INFO" ] == $_SERVER[ "SCRIPT_NAME" ] ) {
                       $_request_uri = $_SERVER[ "PATH_INFO" ];
                   } else {
                       $_request_uri = $_SERVER[ "SCRIPT_NAME" ] . $_SERVER[ "PATH_INFO" ];
                   }
               }
            }
            if ( !empty( $_SERVER[ "QUERY_STRING" ] ) ) {
                $_request_uri .= "?" . $_SERVER[ "QUERY_STRING" ];
            }
            $_SERVER[ "REQUEST_URI" ] = $_request_uri;
         }
         # fix php.cgi in script_filename
         if ( isset( $_SERVER[ "SCRIPT_FILENAME" ] )
             && isset( $_SERVER[ "PATH_TRANSLATED" ] )
             && ( strpos( $_SERVER[ "SCRIPT_FILENAME" ], "php.cgi" ) == strlen( $_SERVER[ "SCRIPT_FILENAME" ] ) - 7 ) ) {
             $_SERVER[ "SCRIPT_FILENAME" ] = $_SERVER[ "PATH_TRANSLATED" ];
         }
  }
?>