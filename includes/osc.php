<?php

  /**
   * @package osC_Sec Security Settings for osC_Sec.php
   * @author Te Taipo <rohepotae@gmail.com>
   * @copyright Copyleft (c) Hokioi-IT
   * @license http://opensource.org/licenses/gpl-license.php GNU Public License
   * @see readme.htm
   * @link http://addons.oscommerce.com/info/7834/
   **/
  if ( false !== strpos( $_SERVER['SCRIPT_NAME'], osc_selfchk() ) ) send404Header();

  /**
   * [[ SETTINGS ]] - stuff to edit
   * see: readme.htm for detailed
   * instructions.
   **/

  $timestampOffset = 0;          # Set the time offset from GMT, example: a setting of -10 is GMT-10 which is Tahiti, 12 is New Zealand
  $nonGETPOSTReqs = 0;           # 1 = Prevent security bypass attacks via forged requests, 0 = leave it as it is
  $spiderBlock = 0;              # 1 = Block a list of web spiders based on their user-agent, 0 = don't
  $disable_tellafriend = 0;      # 1 = Auto redirect back to the index.php page
  
  /**
   * this section of settings is to allow osC_Sec.php
   * to ban an IP address if it breaks the rules
   * see readme.htm for further information
   **/

  $banipaddress = 0;              # 1 = adds ip to htaccess for permanent ban, 0 = calls a page die if injection detected
  $useIPTRAP = 0;                 # 1 = add IPs to the IP Trap contribution, 0 = leave it off
  $ipTrapBlocked = "";            # Put the full URL to your blocked.php if you intend to use IP Trap.
                                  # Example: $ipTrapBlocked = "http://www.yourwebsite.com/blocked.php";

  /**
   * email settings: Don't use if your 
   * Web Service Provider limits how
   * many emails per hour / per day
   **/

  $emailenabled = 0;                            # 1 = send yourself an email notification of injection attack, 0 = don't
  $youremail = "youremail@yourdomain.com";      # set your email address here so that the server can send you a notification of any action taken and why
  $fromemail = "securityscript@yourdomain.com"; # set up an email like securityscript@yourdomain.com where the attack notifications will come from

  /*
  * END OF SETTINGS
  *****************************/

  $osC_Sec = new osC_Sec();
  $osC_Sec->Sentry( $timestampOffset,$nonGETPOSTReqs,$spiderBlock,$banipaddress,$useIPTRAP,
                    $ipTrapBlocked,$emailenabled,$youremail,$fromemail,$disable_tellafriend );

  /**
   * send404Header()
   * 
   * @return
   */
  function send404Header() {
      $header = array( "HTTP/1.1 404 Not Found", "HTTP/1.1 404 Not Found", "Content-Length: 0" );
      foreach ( $header as $sent ) {
          header( $sent );
      }
      die();
  }
  /**
   * osc_selfchk()
   * 
   * @return
   */
  function osc_selfchk() {
      $oscsecfilepath = str_replace( DIRECTORY_SEPARATOR, urldecode( "%2F" ), __file__ );
      $oscsecfilepath = explode( "/", $oscsecfilepath );
      if ( false !== is_array( $oscsecfilepath ) ) {
          $fileself = $oscsecfilepath[count( $oscsecfilepath ) - 1];
          if ( $fileself[0] == "/" ) {
              return $fileself;
          } else {
              return "/" . $fileself;
          }
      }
  }
?>