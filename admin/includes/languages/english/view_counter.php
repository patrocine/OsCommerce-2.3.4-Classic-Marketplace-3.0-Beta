<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack York - oscommerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/
define('HEADING_TITLE_VC', 'View Counter');
define('HEADING_TITLE_AUTHOR', 'by <a href="http://forums.oscommerce.com/user/17188-jack-mcs/" target="blank">Jack_mcs</a> from <a href="http://www.oscommerce-solution.com/" target="_blank"><span style="font-family: Verdana, Arial, sans-serif; color: sienna; font-size: 12px;">oscommerce-solution.com</span></a>');
define('HEADING_TITLE_SUPPORT_THREAD', '<a href="http://forums.oscommerce.com/topic/392949-view-counter/" target="_blank"><span style="color: sienna;">(visit the support thread)</span></a>');
 
define('SHADOW_POS_X', '90');
define('SHADOW_POS_Y', '10');
define('SHADOW_POS_OFFSET', '150');

define('HEADING_SUB_TITLE', '<div style="padding-bottom:10px;">This package allows you to see, among other things, 
 the pages accessed on your site, the number of times they were accessed
 and the IP used. You can also do various things with the IP, as explained in the help files. Click on one of the buttons
 below for help:
 
 
 <div class="section_row" style="position:relative; margin-left:auto; margin-right:auto; width:100%; padding-top:6px;">
  <div class="section_row shadow" style="position:absolute; left:' . SHADOW_POS_X . 'px; top:' . SHADOW_POS_Y . 'px">
   <div class="section_column"><a href="javascript:void(null);" onclick="showHelp(\'' .tep_href_link("view_counter_help.php", "file=general") . '\');" title="General">General</a></div>
  </div>   
  <div class="section_row shadow" style="position:absolute; left:' . (SHADOW_POS_X + SHADOW_POS_OFFSET). 'px; top:' . SHADOW_POS_Y . 'px">
   <div class="section_column"><a href="javascript:void(null);" onclick="showHelp(\'' .tep_href_link("view_counter_help.php", "file=definitions") . '\');" title="Definitions">Definitions</a></div>
  </div>
  <div class="section_row shadow" style="position:absolute; left:' . (SHADOW_POS_X + (2 * SHADOW_POS_OFFSET)). 'px; top:' . SHADOW_POS_Y . 'px">
   <div class="section_column"><a href="javascript:void(null);" onclick="showHelp(\'' .tep_href_link("view_counter_help.php", "file=reports") . '\');" title="reports">Reports</a></div>
  </div>  
  <div class="section_row shadow" style="position:absolute; left:' . (SHADOW_POS_X + (3 * SHADOW_POS_OFFSET)). 'px; top:' . SHADOW_POS_Y . 'px">
   <div class="section_column"><a href="javascript:void(null);" onclick="showHelp(\'' .tep_href_link("view_counter_help.php", "file=tools") . '\');" title="Tools">Tools</a></div>
  </div>  
  <div class="section_row shadow" style="position:absolute; left:' . (SHADOW_POS_X + (4 * SHADOW_POS_OFFSET)). 'px; top:' . SHADOW_POS_Y . 'px">
   <div class="section_column"><a href="javascript:void(null);" onclick="showHelp(\'' .tep_href_link("view_counter_help.php", "file=need_host") . '\');" title="Need A Host">Need A Host</a></div>
  </div>   
  <div class="section_row shadow" style="position:absolute; left:' . (SHADOW_POS_X + (5 * SHADOW_POS_OFFSET)). 'px; top:' . SHADOW_POS_Y . 'px">
   <div class="section_column"><a href="javascript:void(null);" onclick="showHelp(\'' .tep_href_link("view_counter_help.php", "file=need_help") . '\');" title="Need Help?">Need Help?</a></div>
  </div>
  <div id="vc_help" title="View Counter Help" style="display: none;"></div>
</div>
</div>
');

define('HEADING_SUB_TEXT', ' 
  <div style="float:left; margin-bottom:-20px; padding-bottom:5px;" >
    <div class="main" style="text-align:center; font-weight:bold; text-decoration:underline;">SETTINGS</div>
    <div class="smallText"">
     <ul>
     <li>Ban the IP: This prevents this IP from being able to access your site.</li>
     <li>Ignore the IP: Don\'t do anything with this IP (useful for your own and known good IP\'s).</li>
     <li>Delete the IP: Remove the IP from the list.</li>
     <li>Kick off the IP: Removes the session associated with this IP.</li>
    </ul>
   </div>
  </div>
  
  <div style="float:left; margin-bottom:-20px;">
    <div  class="main" style="text-align:center; font-weight:bold; text-decoration:underline;">COLORS</div>
    <div class="smallText">
     <ul style="padding-bottom:-5px;">
     <li style="color:%s">This IP accessed the admin.</li>
     <li style="color:%s">This IP has possible hacker code in the parameters.</li>
     <li style="color:%s">This IP is a bot.</li>
     <li style="color:%s">This IP triggered the bot trap.</li>
    </ul>
   </div>
  </div>
  
  <div style="float:right; margin-bottom:-20px;">
    <div  class="main" style="text-align:center; font-weight:bold; text-decoration:underline;">STATS</div>
    <div class="smallText">
     <ul style="padding-bottom:-5px;">
     <li>Total Visits: %d</li>
     <li>Total Bots: %d</li>
     <li>Total Admins: %d</li>
    </ul>
   </div>
  </div>  

 ');

define('HEADING_COLOR_PICKER', 'View Counter Color Picker');
define('HEADING_COMMON', 'Common Settings');
define('HEADING_REPORTS', 'View Counter Reports');
define('HEADING_TOOLS', 'View Counter Tools');
define('HEADING_TOOLS_EXPLAIN', '
 This section provides various ways to manage parts of View Counter and the shop not available elsewhere.
 Click here for
 <a href="javascript:void(null);" onclick="showHelpTools();"><span class="main" style="color:#ff0000;">help</span>.</a>
 <div id="dialog-modal" title="View Counter Tools Help" style="display: none;"></div> 
');

define('EXPLAIN_TEXT_REPORT_CHOICES', '');
define('EXPLAIN_TEXT_REPORT_FAST_CLICK', 'This report shows IP\'s that skimmed the pages. If not valid search bots, they are just 
wasting bandwidth and should be banned.');
define('EXPLAIN_TEXT_REPORT_HACKING_ATTEMPTS', 'This report shows what are suspect entries. Many hackers will either try to access
the directory named admin or by altering the parameters in a url. If either of these are noticed, they will appear in this list.');
define('EXPLAIN_TEXT_REPORT_IP_COUNT', 'This report shows the cumaltive count for each IP.');
define('EXPLAIN_TEXT_REPORT_PAGE_COUNT', 'This report shows the pages on the site that have been visited and the count for each.');
define('EXPLAIN_TEXT_REPORT_PAGE_NOT_VISITED', 'This report shows pages on the site that have not been visited by anyone.');
define('EXPLAIN_TEXT_REPORT_PATH_TRACKER', 'This report shows the path for each IP (what pages were visited and in what order).');
define('EXPLAIN_TEXT_REPORT_REFERERS', 'This report shows how visitors arrived at your shop.');
define('EXPLAIN_TEXT_REPORT_SKIMMERS', 'This report shows a list of IP\'s by visit to help identify data skimmers.');
                        
define('TEXT_ACCESSS_COUNT', '(access count for last 24 hours is %d)');
define('TEXT_ACCESSS_COUNT_SINGLE_IP', ' -> (access count for the selected IP is %d)');
define('TEXT_ACCESSS_COUNT_ALL', '(access count total: %d<br>Number of bots: %d)');

define('TEXT_ACCOUNT_DETAILS_CREATED_ON', 'Created On:&nbsp;');
define('TEXT_ACCOUNT_DETAILS_EMAIL_ADDRESS', 'Email Address:&nbsp;');
define('TEXT_ACCOUNT_DETAILS_LAST_ACCESSED_ON', 'Last Accessed On:&nbsp;');
define('TEXT_ACCOUNT_DETAILS_NOT_FOUND', 'Account Not Found');
define('TEXT_ACCOUNT_DETAILS_NUMBER_OF_LOGONS', 'Number of Logons:&nbsp;');
define('TEXT_ACCOUNT_DETAILS_PHONE', 'Phone:&nbsp;');

define('TEXT_ARG', 'PARAMETERS');

define('TEXT_BAN_IP', 'BAN');
define('TEXT_BANNED_IPS', 'Banned List');
define('TEXT_BAN_REMOVE', 'Remove Ban:');
define('TEXT_BLOCK_IP_RANGE', 'Block Range');

define('TEXT_BLOCK_COUNTRIES', 'BLOCK COUNTRIES');
define('TEXT_BLOCK_COUNTRIES_ADD', 'Block Countries - ADD');
define('TEXT_BLOCK_COUNTRIES_UPDATE', 'Block Countries - NEW');
define('TEXT_BLOCK_COUNTRIES_EXPLAIN', '<p>The list on the left is a multi-select list so you can select as many countries
as you like by dragging the mouse, or by using the ctrl or shift keys and clicking. If a country is selected, any visiting IP 
from that country will be banned and will show up in the list on the right with the countries name and how many IP\'s have 
been blocked from that country.</p>
<p>The ' . TEXT_BLOCK_COUNTRIES_UPDATE . ' means only the countries selected in the list will be saved. 
The ' . TEXT_BLOCK_COUNTRIES_ADD  . ' will add the countries selected in the list to those already saved. This makes it so 
you don\'t have to re-select countries already chosen.
</p>
');
define('TEXT_BLOCK_COUNTRIES_SELECT', 'Select One or More');
define('TEXT_BLOCK_COUNTRY_DELETE', 'Delete A Block');
define('TEXT_BLOCK_LIST_EXPLAIN', 'Choose the countries <strong>to be blocked</strong>');
define('TEXT_BLOCKED_EXPLAIN', 'These IP\'s <strong>have been blocked</strong> based on their countries');

define('TEXT_BUTTON_BAN_IP', 'Ban This IP');

define('TEXT_CART_ADMIN', 'Admin link');
define('TEXT_CART_ATTR', 'Attr:');
define('TEXT_CART_EMPTY', 'Cart is empty');
define('TEXT_CART_SESSION_CORRUPTED', 'The session string appears to be corrupted.');
define('TEXT_CART_SESSION_INACTIVE', 'Session is not active');
define('TEXT_CART_TOTAL', 'Total:');

define('TEXT_CHOOSE_TABLE', 'Use Storage Table');

define('TEXT_CUSTOMER_ACTIVE_SESSIONS', 'Active Customers');
define('TEXT_CUSTOMER_NOTIFICATION', 'SEND A MESSAGE TO A CUSTOMER');
define('TEXT_CUSTOMER_MESSAGE', 'For the next five minutes, use the discount code 344323 and get 10% off your order.');
define('TEXT_CUSTOMER_MESSAGE_SUCCESS', 'The message was successfully sent');

define('TEXT_DELETE_IP', 'DELETE');
define('TEXT_DISPLAY_NUMBER_OF_LINKS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> links)');
define('TEXT_CIRCLE_SHOW_DETAILS', 'show IP details');
define('TEXT_EYE_SHOW_ALL', 'show all IP\'s');
define('TEXT_EYE_SHOW_ONLY', 'show only this IP');
define('TEXT_FILE_NAME', 'FILE NAME');
define('TEXT_GUEST', 'Guest');

define('TEXT_HTACCESS_BACKUP', 'Create a .htaccess backup:');
define('TEXT_HTACCESS_BACKUP_LOCN', 'htaccess_backups');
define('TEXT_HTACCESS_CHOOSE', 'Choose a Restore File');
define('TEXT_HTACCESS_EDITOR', 'EDIT THE .HTACCESS FILE');
define('TEXT_HTACCESS_REBUILD', 'Rebuild the .htaccess:');
define('TEXT_HTACCESS_REBUILD_BANNED', 'Rebuild the Banned List:');
define('TEXT_HTACCESS_RESTORE', 'Restore the .htaccess:');
define('TEXT_HTACCESS_TOOLS', 'MAINTENANCE TOOLS');
define('TEXT_HTACCESS_WHITELIST', 'Whitelist an IP:');

define('TEXT_KICK_OFF', 'KICK');
define('TEXT_IGNORE_IP', 'IGNORE');
define('TEXT_IGNORE_IPS', 'Ignored List');
define('TEXT_IGNORE_IP_RANGE', 'Ignore Range');
define('TEXT_IGNORE_REMOVE', 'Remove&nbsp;Ignore:');
define('TEXT_IP', 'IP');
define('TEXT_IP_DETAILS', '?');
define('TEXT_IP_DETAILS_NOT_FOUND', 'This IP could not be located in the database.');
define('TEXT_IP_IN_CIDR', 'IP in CIDR?');
define('TEXT_IP_IN_CIDR_FOUND', 'IP %s was found in the CIDR %s.');
define('TEXT_IP_IN_CIDR_NOT_FOUND', 'IP %s was not found in any of the ranges in the .htaccess file.');
define('TEXT_LAST_DATE', 'LAST DATE TIME');
define('TEXT_LAST_REFRESH', 'Last Refresh at %s - Next Refresh in %s seconds');
define('TEXT_LAST_REFRESH_NO_REFRESH', 'Last Refresh at %s');
define('TEXT_ONLY_ACTIVE', 'Active Only');
define('TEXT_ONLY_SPOOFED', 'Spoofed Only');

define('TEXT_RELATED_PAGES', 'Related');

define('TEXT_REPORT_CHOICES', 'Select a Report');
define('TEXT_REPORT_COLOR_BACKGROUND', 'Highlighted pages mean the file could not be found in the root directory.');

define('TEXT_REPORT_FAST_CLICK', 'Fast Clicks');
define('TEXT_REPORT_HACKING_ATTEMPTS', 'Hacker Attempts');
define('TEXT_REPORT_HACKING_ATTENPTS_LIMIT_IP', 'Show Only IP:');

define('TEXT_REPORT_IP_COUNT', 'IP Counts');
define('TEXT_REPORT_IP_COUNT_CNT', 'Count');
define('TEXT_REPORT_IP_COUNT_ISBOT', 'Is Bot?');
define('TEXT_REPORT_IP_COUNT_IP', 'IP');

define('TEXT_REPORT_PAGE_COUNT', 'Page Counts');
define('TEXT_REPORT_PAGE_COUNT_ARGS', 'Parameters');
define('TEXT_REPORT_PAGE_COUNT_CNT', 'Count');
define('TEXT_REPORT_PAGE_COUNT_ISBOT', 'Is Bot?');
define('TEXT_REPORT_PAGE_COUNT_IP', 'IP');
define('TEXT_REPORT_PAGE_COUNT_FILENAME', 'Filename');
define('TEXT_REPORT_PAGE_NOT_VISITED', 'Pages not Visted');

define('TEXT_REPORT_SKIMMERS', 'Skimmers');
define('TEXT_REPORT_PATH_TRACKER', 'Path Tracker');
define('TEXT_REPORT_PATH_TRACKER_BAN_IP', 'Ban This IP');
define('TEXT_REPORT_PATH_TRACKER_CURRENT_IP', 'Current IP:');
define('TEXT_REPORT_PATH_TRACKER_EXCLUDE_IP', 'Exclude IP:');
define('TEXT_REPORT_PATH_TRACKER_IP_LIST', 'IP List:');
define('TEXT_REPORT_PATH_TRACKER_PICK_IP', 'Select an IP');

define('TEXT_REPORT_REFERERS', 'Referrers');

define('TEXT_REPORT_SELECT_TYPE', 'Select a Report');
define('TEXT_REPORT_FILTER_BY_PAGE', 'Filter By Page');
define('TEXT_REPORT_SHOW_ARG', 'Show Parameters:');
define('TEXT_REPORT_SHOW_ARG_NO', 'No');
define('TEXT_REPORT_SHOW_ARG_YES', 'Yes');
define('TEXT_REPORT_SHOW_BOTS', 'Show Bots:');

define('TEXT_SHOW_ONLY_IP', 'Show Only IP');
define('TEXT_SHOW_TYPE', 'Show:');
define('TEXT_SHOW_TYPE_ADMIN', 'Admin');
define('TEXT_SHOW_TYPE_ALL', 'All');
define('TEXT_SHOW_TYPE_BOT', 'Bots');
define('TEXT_SHOW_TYPE_CUSTOMERS', 'Visitors');
define('TEXT_SHOW_TYPE_TYPE', 'Type:');
define('TEXT_SPOOFED_AS', 'Spoofed As: ');

define('TEXT_SORT_BY', 'Sort By:');
define('TEXT_SORT_BY_ARG', 'ARG');
define('TEXT_SORT_BY_COUNT', 'Count');
define('TEXT_SORT_BY_DATE', 'Date');
define('TEXT_SORT_BY_FILENAME', 'File Name');
define('TEXT_SORT_BY_IP', 'IP');
define('TEXT_SORT_BY_ISBOT', 'ISBOT');
define('TEXT_SORT_BY_VISITOR', 'VISITOR');

define('TEXT_SORT_BY_PAGE_COUNT', 'Count');
define('TEXT_SORT_BY_PAGE_FILENAME', 'File Name');
define('TEXT_SORT_BY_PAGE_IP', 'IP');
define('TEXT_SORT_BY_PAGE_ISBOT', 'ISBOT');


define('TEXT_VIEW_COUNT', 'COUNT');
define('TEXT_VISITOR', 'VISITOR');

define('COLOR_BACK', false);
define('COLOR_FRONT', true);

define('ERROR_BLOCK_COUNTRY_SELECTION_ERROR', 'An invalid selection was made. Please try again.');
define('ERROR_DOMAIN_ALREADY_BANNED', 'The domain %s is already banned.');
define('ERROR_FSOCK_CONNECTION_FAILED', 'Connection to the WhoIs site failed.');
define('ERROR_HTACCESS_BACKUP_DIR_FAILED', 'The htaccess_backup directory could not be created.');
define('ERROR_HTACCESS_INVALID_FILE', 'The selected file name is invalid.');
define('ERROR_HTACCESS_NOT_FOUND', 'Backup Failed: An .htaccess file cannot be found.');
define('ERROR_HTACCESS_WRITE_FAILED', 'An error occurred while writing the file.');
define('ERROR_IP_ALREADY_BANNED', 'IP %s has already been banned.');
define('ERROR_IP_ALREADY_IGNORED', 'IP %s has already been ignored.');
define('ERROR_KICK_NOT_ENABLED', 'Please enable the Kick Off setting to use this feature.');
define('ERROR_RANGE_BLOCK', 'The IP or IP range %s is invalid.');
define('ERROR_SESSION_EMPTY', 'The session ID does not exist or is invalid.');

define('SUCCESS_DOMAIN_BLOCK', 'The domain %s has been blocked.');
define('SUCCESS_HTACCESS_BACKUP', 'The .htaccess file has been backed up.');
define('SUCCESS_HTACCESS_REBUILD', 'The .htaccess file has been rebuilt.');
define('SUCCESS_HTACCESS_REBUILD_BANNED', 'The banned list has been updated.');
define('SUCCESS_HTACCESS_RESTORE', 'The .htaccess file has been restored.');
define('SUCCESS_HTACCESS_WHITELISTED_IP', 'The IP has been whitelisted.');
define('SUCCESS_IP_BANNED', 'IP %s has been banned.');
define('SUCCESS_IP_BANNED_REMOVED', '%s has been removed from the banned list.');
define('SUCCESS_IP_DELETED', 'IP %s has been deleted.');
define('SUCCESS_IP_IGNORED', 'IP %s is being ignored.');
define('SUCCESS_IP_IGNORED_REMOVED', '%s has been removed from the ignore list.');
define('SUCCESS_IP_KICKED', 'IP %s has been kicked off.');
define('SUCCESS_RANGE_BLOCK', 'The IP range %s has been blocked.');

define('COLOR_PRESET_HEADING', 'Preset Color Choices');
define('COLOR_PRESET_DEFAULT', 'Default');
define('COLOR_PRESET_AUTUM', 'Autum');
define('COLOR_PRESET_BLUE', 'Blue');
define('COLOR_PRESET_OSCOMMERCE', 'Oscommerce');

define('COLOR_HDR_BKGND', 'color1');
define('COLOR_OPTIONS', 'color2');
define('COLOR_COL_HEADINGS', 'color3');
define('COLOR_SELECTED_COLUMN', 'color4');
define('COLOR_SELECTED_COLUMN_HIGHLIGHT', 'color5');
define('COLOR_LANGUAGE_BAR', 'color6');
define('COLOR_BUTTONS', 'color7');
define('COLOR_IS_BOT', 'color8');
define('COLOR_IS_ADMIN', 'color9');
define('COLOR_IS_HACKER', 'color10');
define('COLOR_IS_BOT_TRAP', 'color11');
define('COLOR_CART_POPUP_BACK', 'color12');

$nameColorsArray = array(0   => COLOR_HDR_BKGND, 
                         1   => COLOR_OPTIONS,
                         2   => COLOR_COL_HEADINGS,
                         3   => COLOR_SELECTED_COLUMN,
                         4   => COLOR_SELECTED_COLUMN_HIGHLIGHT,
                         5   => COLOR_LANGUAGE_BAR,
                         6   => COLOR_BUTTONS, 
                         7   => COLOR_IS_BOT,
                         8   => COLOR_IS_ADMIN,
                         9   => COLOR_IS_HACKER,
                         10  => COLOR_IS_BOT_TRAP,
                         11 => COLOR_CART_POPUP_BACK
                        ); 
$textColorsArray = array(COLOR_HDR_BKGND => 'Header Background',
                          COLOR_OPTIONS => 'Options',
                          COLOR_COL_HEADINGS => 'Column Headings',
                          COLOR_SELECTED_COLUMN => 'Selected Column',
                          COLOR_SELECTED_COLUMN_HIGHLIGHT => 'Selected Column Mouse Over',
                          COLOR_LANGUAGE_BAR => 'Language Bar',
                          COLOR_BUTTONS => 'Buttons',
                          COLOR_IS_BOT => 'Is Bot',
                          COLOR_IS_ADMIN => 'Is Admin',
                          COLOR_IS_HACKER => 'Is Hacker',
                          COLOR_IS_BOT_TRAP => 'Is Bot Trap',
                          COLOR_CART_POPUP_BACK => 'Cart popup Background'                          
                         );


