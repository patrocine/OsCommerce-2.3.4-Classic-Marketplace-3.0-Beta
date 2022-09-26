<?php
$contactHelp = file_get_contents(DIR_WS_LANGUAGES . $language . '/view_counter/view_counter_footer.txt');
define('VC_HELP_HEADING', 'View Counter Definitions');
define('VC_HELP_TEXT_MAIN', '
<div class="heading">General Terms: </div>
<div class="section"><span class="subHeading">Banned</span> - This means the banned entry will not be able to access the site.</div>

<div class="section"><span class="subHeading">CIDR</span> - This is a shorthand way of covering a number of IP\'s with one line. All search
engines and hackers have multiple IP\'s. Those IP\'s are generally purchased in blocks so they have 
a range of IP\'s that may cover 111.111.111.0 through 111.111.111.20. Instead of entering all
of those separately, they can be entered on one line with something like 111.111.111.0/24. But you have
to be careful with CIDR\'s since you can inadvertently block a normal visitor to the site. Generally
speaking, the higher the number after the /, the safer it is to use. If you banned a range of 
IP\'s using something like 111.111.111.0/4, it would pretty much ban every IP in that range, which
is not always the correct thing to do.</div>

<div class="section"><span class="subHeading">Ignore</span> - This means the entry will just not show up in View Counter\'s display. The current
exception to this is if the ignored entry is a CIDR. That is because there is no easy
way to check if an IP is in a CIDR while loading the list. It is possible but would slow the 
display down too much to be useful.</div>

<div class="heading">Settings Section: </div>
<div class="section"><span class="subHeading">Banned List</span> - This list contains all of the IP\'s and/or Domain Names that are currently banned via the .htaccess file.</div>

<div class="section"><span class="subHeading">Ignore List</span> - This list contains all of the IP\'s that are currently being ignored via the .htaccess file.</div>

<div class="section"><span class="subHeading">Active Only</span> - Only show the visitors on the site. The number of minutes used to determine an active visitor is controlled by the Active Time setting.</div>
<div class="section"><span class="subHeading">Related</span> - Show the entries in a related fashion, based on the session ID. This is currently set to always be on.</div>

<div class="section"><span class="subHeading">Show Only IP</span> - When an IP is submitted via this box, it is the only one that will be displayed in the list.</div>

<div class="section"><span class="subHeading">Block Range</span> - Any IP, IP Range, CIDR and Domain Name can be entered in this box 
and it will be added to the banned list. If a Range or CIDR is banned, all IP\'s that belong to it will be banned but the individual
IP\'s will still show up in the list. This will be changed in future versions.</div>

<div class="section"><span class="subHeading">IP in CIDR</span> - This can be used to chek the existing CIDR\'s to see if an IP exists in it. This is useful if 
someone says they can no longer access the site. If a CIDR was use to block a number of IP\'s, it may contain IP\'s that shouldn\'t 
be blocked and this will allow them to be found. </div>

<div class="section"><span class="subHeading">Ignore Range</span> - When an IP is submitted via this box, it will no longer show in the list of IP\'s. The box will also 
accept CIDR\'s and Ranges but any IP in those will continue to show in the list.</div>

<div class="section"><span class="subHeading">Use Storage Table</span> - View Counter keeps two tables for holding tracking date:
View Counter and View Counter Storage. View Counter usually has less data in it so it is quicker to use. View Counter Storage holds its
data longer so you can see farther back in time. The time for both of these is controlled by View Counter settings in the configuration
section. This option allows you to switch between the two tables.</div>

<div class="section"><span class="subHeading">Refresh Status</span> - This line shows the last time a refresh was performed and
how long it is until the next refresh will occur, assuming the refresh option is set in the settings.</div>

<div class="heading" style="padding-top:10px; border-top:1px solid #000;">List Elements: <span style="font-size:10px; font-weight:normal;">(clicking once on a column heading sorts that column in ascending order. Click it again and it
sorts in descending order.)</span></div>
<div class="section"><span class="subHeading">Visitors</span> - Contains the type of visitor or the name if a logged in customer. </div>
<div class="section"><span class="subHeading">File Name</span> - The name of the file accessed for this entry.</div>

<div class="section"><span class="subHeading">Parameters</span> - This further describes the url. Hackers will use this to try to get into the database. If hacker code is 
 found, this entry will be highlighted. Not all hacking attempts will be caught, of course.</div>
 
<div class="section"><span class="subHeading">Count</span> - Shows how many time the page has been accessed.</div>

<div class="section"><span class="subHeading">IP</span> - The IP of the visitor.</div>

<div class="section"><span class="subHeading">Last Date Time</span> - The date/time of the last visit.</div>

<div class="section"><span class="subHeading">Ban</span> - Add this IP to the Banned list.</div>
<div class="section"><span class="subHeading">Ignore</span> - Add this IP to the Ignore list.</div>
<div class="section"><span class="subHeading">Delete</span> - Delete this IP from the list.</div>
<div class="section"><span class="subHeading">Kick</span> - Kick this visitor off of the site. Check the email and/or message that is displayed to be sure it is 
 worded as you perfer.</div>
<div class="section"><span class="subHeading">?</span> - Opens the DNS window that provides details about this visitor.</div>

' . $contactHelp );