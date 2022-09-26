<?php
$contactHelp = file_get_contents(DIR_WS_LANGUAGES . $language . '/view_counter/view_counter_footer.txt');
define('VC_HELP_HEADING', 'View Counter Reports Help');
define('VC_HELP_TEXT_MAIN', '
<div class="heading">REPORTS: </div>
<div class="section row_spacing">The Reports page is used to run various reports using the data View Counter
collects. Using them can allow you to find out in more detail about what is going on in your shop. 
</div>

<div class="heading">Fast Clicks</div>
<div class="section row_spacing">A data skimmer or hacker will usually use scripts to 
interrogate your site. This allows them to move from one page to the next much more quickly than a human can do. This report 
shows the clicks of a certain IP as well as their times. If you see many clicks too close together to have been caused by 
a person, then that IP is most likely a data skimmer or hacker. But before banning the IP, please realize that, technically, a
search engine is a data skimmer so you shouldn\'t ban an IP unless you check who it is first.
</div>

<div class="heading">Hacker Attempts</div>
<div class="section row_spacing">This lists any IP\'s that have triggered the code in 
View Counter that checks for certain hacking attempts.
</div>

<div class="heading">IP Counts</div>
<div class="section row_spacing">This report shows how many times an IP caused a page hit. The count 
for search bots will normally be high. But legitimate cusotmers to the site should not be so high counts can indicate data skimmers 
or hackers. 
</div>

<div class="heading">Page Counts</div>
<div class="section row_spacing">This reports shows how many times a particular page has 
been viewed. This can be useful to know if parts of your shop are not being viewed as you want. 
</div>

<div class="heading">Pages Not Visited</div>
<div class="section row_spacing">This report shows pages that have not been visited 
by anyone. It can be useful in determining dead spots or broken links in the shop.
</div>

<div class="heading">Path Tracker</div>
<div class="section row_spacing">This report shows the path someone has taken on your shop. 
It can indicate why visitors are leaving the shop or not completing an order. 
</div>

<div class="heading">Referrers</div>
<div class="section row_spacing">This report tries to show the location the visitor came from 
before reaching the site. The referrer setting is not a required item so entries in this report may not show the location.
</div>

<div class="heading">Skimmers (<spam style="color:red;">Pro Version Only</span>)</div>
<div class="section row_spacing">This report produces a listing of all of the IP\'s that have clicked a large amount of time
in a certain period. The minimum number of clicks and the time frame are controlled in the settings. The idea behind this
report is that a legitimate visitor would only make a certain number of clicks in a given amount of time. So if the report shows
that a certain IP has 1,000 clicks in the last 24 hours, you can be fairly certain that that is not a legitimate visitor.
</div>
' . $contactHelp );