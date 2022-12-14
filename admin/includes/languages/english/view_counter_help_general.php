<?php
?>
<style type="text/css">
<!--
span.subheading {
  color:#ff0000;
}

-->
</style>
<?php

define('VC_HEADING', 'View Counter General Help');
define('VC_TEXT_MAIN', '
<div class="heading">General Purpose: </div>
<div class="section">This program provides a way to view and manage the visitors to your site and to tally certain
aspects of their visits, thus the name View Counter. It allows you to see who is, and has been, visiting your site 
and to control what is done with them, from just ignorning them, to kicking off the site temporairly to banning them.
</div>

<div class="section"><span class="subHeading">Skimmers</span> - One of the biggest problems facing shops, and hosts
for that matter, nowadays are skimmers. These are search bots that scan a site in order to obtain as much data from them
as possible. They then coallate and sell this data to various advertising companies or, sometimes, hackers. Skimmers
don\'t help your site in any way at all. They can do thousands of page views in a day so they just bog the server down
and use your bandwidth. When such an IP is identified, it needs to be banned. </div>

<div class="section"><span class="subHeading">Spoofing</span> - Some hackers and spammers will emulate a search
engine to try to get by a sites defenses. This is known as spoofing. You can do it yourself using FF and one of its
addons meant for this. It can be a legitimate way to test a site since it helps to know what the search engines are
seeing. If such an IP is identified, it will be have "Spoofed" added to the name.</div>

<div class="heading">Configuration Settings: </div>
<div class="section"><span class="subHeading">ON/OFF</span> - This turns View Counter on or off. With it 
set to off, it will not function at all.</div>

<div class="section"><span class="subHeading">Active Time</span> - This is used to determine what constitutes a 
live session.</div>

<div class="section"><span class="subHeading">API Key</span> - In order for View Counter to find some of the 
information it needs, a key needs to be obtained from <a href="http://ipinfodb.com/register.php" target="_blank"><span style="color:#0000ff; font-weight:bold;">this site</span>.</a>
Registration is required but it is free.</div>

<div class="section"><span class="subHeading">Bad Bot Trap</span> - There is a directory and file in the root directory.
When View Counter is installed they are mentioned in the .htaccess and robots files. If a search engine or hacker 
attempts to use them, they are flagged. Some search engines, mainly Google and Bing, will visit such locations
regardless of the robots entry so you shouldn\'t automatically ban I{\s that are shown to have visited this directory.</div>

<div class="section"><span class="subHeading">Force Reset</span> - This entries is the number of days data is stored
in the main View Counter table. To long of a period can result in a very large amount of data being stored, depending upon
how busy the site it.</div>

<div class="section"><span class="subHeading">Force Reset Storage</span> - This entries is the number of days data is stored
in the View Counter storage table. This table is a duplicate of the main View Counter table but is not accessed as much. This
speeds up access to the main table. The length of time for this table should be a longer period since it is used for the
reports.</div>

<div class="section"><span class="subHeading">Hide Admin Links</span> - This contains any IP\'s that you would like to 
skip in the listings, like your own IP. Multiple IP\'s can be entered by separating them with a comma.</div>

<div class="section"><span class="subHeading">Kick Off</span> - If enabled, the Kick Off option in the monitor
section will be enabled..</div>

<div class="section"><span class="subHeading">Page Refresh Period</span> - This controls how often the monitor
page is refreshed. Leaving it blank means it is never refreshed.</div>

<div class="section"><span class="subHeading">Rows Per Page</span> - This controls how many rows are displayed
on View Counters monitor page.</div>

<div class="section"><span class="subHeading">Send Emails To</span> - If you would like emails generated by View Counter
to be sent to some address other than what is decalred as the shops email address, enter it here.</div>

<div class="section"><span class="subHeading">Show Flags</span> - This controls whether the flags are displayed
in the listing or not. Please note that this addon uses a third-party site to find the correct flag for each IP. They
offer a free version, used here, or a paid version. The free version is less accurate and may not always return a flag.
If the IP is clicked on, it opens their site, which uses the paid version, and a flag should always show up there.</div>


<div class="heading" style="padding-top:10px; border-top:1px solid #000;">NEED SOME HELP? </div>
<div class="section"><span class="subHeading">Contact Me</span> - If you need help installing any addon or maintaining your
site, <a href="mailto:sales@oscommerce-solution.com"><span style="color:#0000ff; font-weight:bold;">please contact me</span></a>. I offer reasonable rates and quick turnaround times.</div>

<div class="section" style="padding-bottom:10px;"><span class="subHeading">Hosting</span> - If you would like to host somewhere where the host actually knows
the product and is easy to work with, then consider us. We handle transferring the site for free. Plus we set it up and verify the
settings are correct. You can see our basic hosting plans <a href="http://www.oscommerce-solution.com/hosting-plans.php" target="_blank"><span style="color:#0000ff; font-weight:bold;">here</span></a>
though we offer many more hosting options. We have been in business since 2003 so you can rely on us to be here when you need us.</div>

');