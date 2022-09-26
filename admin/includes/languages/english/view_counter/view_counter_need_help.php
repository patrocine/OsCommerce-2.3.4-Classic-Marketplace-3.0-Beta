<?php
$addons = array('Header Tags SEO', 'All Products SEO', 'Google Sitemap XML SEO', 'Sitemap SEO', 'Ultimate SEO V2.2d');
$links =  array('addons.oscommerce.com/info/5851',
                'addons.oscommerce.com/info/6216',
                'addons.oscommerce.com/info/6583',
                'addons.oscommerce.com/info/6459',
                'addons.oscommerce.com/info/2823'                
               ); 
$urls = '<div style="width=800px; text-align:center;">';               
for ($i = 0; $i < count($addons); ++$i) {               
    $urls .= '<div class="section_row_help"><a class="section_email" href="http://' . $links[$i] . '" target="_blank">' . $addons[$i] . '</a></div>';                
}
$urls .= '</div>';
$contactHelp = file_get_contents(DIR_WS_LANGUAGES . $language . '/view_counter/view_counter_footer.txt');

define('VC_HELP_HEADING', 'Need Help');
define('VC_HELP_TEXT_MAIN', '

<div class="section_block" style="padding-top:10px;">Getting the most out of View Counter may take some effort due to 
its complexity. If you need help with it or would like it updated,  please feel free to 
<a style="color:blue; font-weight:bold;" href="mailto:support@oscommerce-solution.com">email me</a> for a quote.
</div>

<div class="section_block_line">Besides this addon, some of the most popular addons are also written by me. Here are some 
you may want to look at:
</div>

 
' . $urls . '
 
 
<div class="section_block_line">If you are in need of a host that actually knows the package and is easy 
to work with, then please consider us. Unlike many hosts nowadays, we handle transferring the site for free. 
Plus we set it up and verify the settings are correct before turning it over. You can see our basic hosting plans 
<a class="section_email_blue" href="http://www.oscommerce-solution.com/hosting-plans.php">here</a> though we offer many more hosting options. We have been in business since 2003 so you can rely on us to be here 
when you need us.
</div>

');