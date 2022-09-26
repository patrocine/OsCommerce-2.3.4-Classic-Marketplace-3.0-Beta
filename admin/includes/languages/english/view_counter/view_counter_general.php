<style> .do-color {color:red} </style>
<?php
$contactHelp = file_get_contents(DIR_WS_LANGUAGES . $language . '/view_counter/view_counter_footer.txt');
define('VC_HELP_HEADING', 'View Counter General Help');
define('VC_HELP_TEXT_MAIN', '
<div class="heading">General Purpose: </div>
<div class="section">This program provides a way to view and manage the visitors to your site and to tally certain
aspects of their visits, thus the name View Counter. It allows you to see who is, and has been, visiting your site 
and to control what is done with them, from just ignoring them, to kicking them off the site temporarily to banning them
for future visits.
</div>

<div class="section"><span class="subHeading">Data Skimmers</span> - One of the biggest problems facing shops, and hosts
for that matter, nowadays are "Data Skimmers." These are search bots that scan a site in order to obtain as much data from them
as possible. They then collate and sell this data to various advertising companies or, sometimes, hackers. Data Skimmers
don\'t help your site in any way. They can do thousands of page views in a day so they just bog the server down
and use your bandwidth. When such an IP is identified, it needs to be banned. </div>

<div class="section"><span class="subHeading">Spoofing</span> - Some hackers and spammers will emulate a search
engine to try to get by a sites defences. This is known as spoofing. You can do it yourself using browser addons meant 
for this purpose. It can be a legitimate way to test a site since it helps to know what the search engines are
seeing. If such an IP is identified, it will have "Spoofed" added to the name. Be sure to check the owner of the IP
before banning it since some search engine bots can be seen as spoofed.</div>

<div class="heading" style="padding-top:4px">Configuration Settings: </div>
<div class="section"><span class="subHeading">ON/OFF</span> - This turns View Counter on or off. With it 
set to off, it will not function at all and is, effectively, removed from the shop.</div>

<div class="section"><span class="subHeading">Active Time</span> - This is used to determine what constitutes a 
live session.</div>

<div class="section"><span class="subHeading">Bad Bot Trap</span> - There is a directory and file in the root directory who\'s
only purpose is trap bad bots or hackers. When View Counter is installed they are mentioned in the .htaccess and robots files. 
If a search engine or hacker attempts to load the file or enter that directory, they are flagged. Some search engines, mainly 
Google and Bing, will visit such locations regardless of the robots entry so you shouldn\'t automatically ban IP\'s that are 
shown to have visited either.</div>

<div class="section"><span class="subHeading">Block Countries Shop</span> - This setting only applies to the shop side and 
controls whether countries are blocked and which database is used to get data about the IP\'s. If the setting is set to Off, 
then countries won\'t be blocked. If set to Internal, checking is done using a database in the form of a file on the server. 
If set to External, the file database is still checked first for speed but then external web sites are checked. This can result 
is better results but if the external sites are slow to load, your site will also slow down. If you want to block countries from your site, Internal is recommended.</div>

<div class="section"><span class="subHeading">Block Countries Allow Bots</span> - This setting is only used if the Block Countries Shop options 
is enabled. If this one is set to On, then search engines are not blocked, even if they are from a blocked country. If Off, then 
all IP\'s from a blocked country are blocked, even search engines. This can be an important setting for sites that use
google remarketing since they want all countries to have access to the site.</div>

<div class="section"><span class="subHeading">Countries Check Admin</span> - This setting is similar to the Block Countries 
Shop setting except it controls the admin side. It also doesn\'t block countries. The setting just determines which database is used 
in admin. Since the slowness in admin is less catastrophic, using External for this setting may provide better results without too 
much slowness.</div>

<div class="section"><span class="subHeading">Data Skimmers Minimum Count (<spam class="do-color">Pro Version Only</span>)</span> - This sets the minimum number of
hits that occur before an IP is considered a skimmer.</div>

<div class="section"><span class="subHeading">Data Skimmers Period of Time (<spam class="do-color">Pro Version Only</span>)</span> - This sets the time frame to evaluate to see how many 
clicks an IP has made.</div>

<div class="section"><span class="subHeading">Data Skimmers Show Bots (<spam class="do-color">Pro Version Only</span>)</span> - This causes search bots to be considered when evaluating
skimmers. This may be useful to identify bad bots and spoofers. If enabled, be careful when banning any that show since they may be legitimate bots.
</div>

<div class="section"><span class="subHeading">Date Format</span> - This controls the format of the date displayed in the 
monitor section.</div>

<div class="section"><span class="subHeading">Force Reset</span> - This controls the number of days data is stored
in the main View Counter table. Too long of a period can result in a very large amount of data being stored, depending upon
how busy the site is.</div>

<div class="section"><span class="subHeading">Force Reset Storage</span> - This controls the number of days data is stored
in the View Counter storage table. This table is a duplicate of the main View Counter table but is not accessed as much. This
speeds up access to the main table. The length of time for this table should be a longer period since it is used for the
reports.</div>

<div class="section"><span class="subHeading">Hide Admin Links</span> - This contains any IP\'s that you would like to 
skip in the listings, like your own IP. Multiple IP\'s can be entered by separating them with a comma.</div>

<div class="section"><span class="subHeading">Item Name Length</span> - This controls the length of text displayed on the 
monitor pages for what is in the shopping cart.</div>

<div class="section"><span class="subHeading">Kick Off</span> - If enabled, the Kick Off option in the monitor
section will be enabled. When that button is clicked, the visitor with that IP is temporarily kicked off of the site.</div>

<div class="section"><span class="subHeading">Page Refresh Period</span> - This controls how often the monitor
page is refreshed. Leaving it blank means it is never refreshed.</div>

<div class="section"><span class="subHeading">Rows Per Page</span> - This controls how many rows are displayed
on View Counters monitor page.</div>

<div class="section"><span class="subHeading">Send Emails To</span> - If you would like emails generated by View Counter
to be sent to some address other than what is declared as the shops email address, enter it here.</div>

<div class="section"><span class="subHeading">Show Flags</span> - This controls whether the flags are displayed
in the listing or not. The countries of some IP\'s cannot be found due to a limitation of the free database being used.</div>

<div class="section"><span class="subHeading">Show Account Details</span> - If on and a customer with an account is logged in, 
the details of that customer will be displayed in a popup on the monitor page.</div>

<div class="section" style="padding-bottom:4px"><span class="subHeading">Version checker</span> - This controls how the version of View Counter is checked. 
</div>

' . $contactHelp );