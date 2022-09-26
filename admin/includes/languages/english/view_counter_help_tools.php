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

define('VC_HEADING', 'View Counter Tools Help');
define('VC_TEXT_MAIN', '
<div class="heading">MAINTENANCE TOOLS: </div>

<div class="section"><span class="subHeading">Create a .htaccess backup file</span> - This will create
a backup of the .htaccess file in the View Counter Htaccess Backup directory. The directory is located
in the root directory and will be created if not present.</div>

<div class="section"><span class="subHeading">Restore the .htaccess</span> - This allows a previously
stored .htaccess file to be restored from the backup directory.
</div>

<div class="section"><span class="subHeading">Rebuild the .htaccess</span> - The .htaccess file can have duplicate
IP\'s in it. This option allows those to be safely removed. 
</div>

<div class="section"><span class="subHeading">Rebuild the Banned list</span> - The .htaccess file may have been altered
outside of View Counter. This option allows the banned list and the .htaccess file to be synched.
</div>

<div class="section"><span class="subHeading">Whitelist an IP</span> - Sometimes it is preferable to ban a whole
range of IP\'s except for certain ones. This allows those to be whitelisted even if they are banned
in a CIDR or Range of IP\'s.
</div>


<div class="heading">SEND A MESSAGE TO A CUSTOMER : </div>
<div class="section">This provides a way to send a notice to a current customer on the site. For example, 
you may want to create a coupon code that allows 5% off but only if they order within the next five minutes.
</div>

<div class="heading">BLOCK A COUNTRY : </div>
<div class="section">This provides a way to block all IP\'s assigned to the selected countries from accessing 
the site. Use the Multi-Select list on the left to choose the countries to be blocked. The list on the right 
shows which countries have been blocked along with how many times each has been blocked.
</div>


<div class="heading">EDIT THE .HTACCESS FILE:</div>
<div class="section">This allows the manual editing of the .htaccess
file. Be careful with using this since a mistake can cause your site to fail to load.
</div>
 
<div class="heading" style="padding-top:10px; border-top:1px solid #000;">NEED SOME HELP? </div>
<div class="section"><span class="subHeading">Contact Me</span> - If you need help installing any addon or maintaining your
site, <a href="mailto:sales@oscommerce-solution.com"><span style="color:#0000ff; font-weight:bold;">please contact me</span></a>. I offer reasonable rates and quick turnaround times.</div>

<div class="section" style="padding-bottom:10px;"><span class="subHeading">Hosting</span> - If you would like to host somewhere where the host actually knows
the product and is easy to work with, then consider us. We handle transferring the site for free. Plus we set it up and verify the
settings are correct. You can see our basic hosting plans <a href="http://www.oscommerce-solution.com/hosting-plans.php" target="_blank"><span style="color:#0000ff; font-weight:bold;">here</span></a>
though we offer many more hosting options. We have been in business since 2003 so you can rely on us to be here when you need us.</div>
');