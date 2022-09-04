===  Social Login ===
Contributors: LoginRadius
Donate link: http://www.loginradius.com
Tags: Social login, openID, osCommerce plugin, LoginRadius, open authentication,  Social Login, OpenID integration, Open Authentication, User Profile Data, Social Analytics, oAuth integration, Online Identity, Social Profile storage,
single sign-on , SAAS solution, Social Sign-in, Social Login Plug-in, Google, Yahoo OpenID, Hyves openid,Linkedin openid, Mixi opendID, Virgilio OpenID
Requires: osCommerce online merchant v2.3.1
Tested on: osCommerce online merchant v2.3.1
module version : 2.0

This plugin enables social login on osCommerce websites.

== Description ==

This plugin adds social login on an osCommerce website letting users log in through their 
existing IDs such as Facebook, Twitter, Google, Yahoo and over 15 more! This eliminates lengthy
registration process i.e. filling up a long registration form, verifying email ID, remembering 
another username and password so your users are just one click away from logging in to your website. 
Other than social login, LoginRadius plugin also provides User Profile Data and Social Analytics.

Watch out Our video: http://www.youtube.com/loginradius

= Features =
* Social login
* User profile data
* Social analytics
* FREE service
* No programming skills required
* White label & premium solutions available
* Available for non-CMS websites as well
* 24x7 support


= List of ID Providers =
* Facebook
* Google
* Twitter
* AOL
* Flickr
* Yahoo
* Linkedin
* Wordpress
* Blogger
* MyOpenID
* LiveJournal
* VeriSign
* OpenID
* Hyves
* Mixi
* MySpace
* Orange
* StackExchange
* SteamCommunity
* Virgilio

= Important links =
* Website: http://www.loginradius.com
* osCommerce live demo: http://oscommercedemo.loginradius.com
* Other live demo: http://www.loginradius.com/demo
* Press/Media page: http://www.loginradius.com/press
* Blog: http://blog.loginradius.com
* Our video: http://www.youtube.com/loginradius

== Installation ==
Installation process:-

1. Upload files as name of folders
2. Navigate to "catalog\admin\includes\boxes\modules.php" in your OSCommerce root folder and add following code at the bottom of the page:-

<?php
$cl_box_groups[sizeof($cl_box_groups)-1]['apps'][] = array(
        'code' => FILENAME_SOCIALLOGINANDSOCIALSHARE,
        'title' => BOX_TOOLS_SOCIALLOGINANDSOCIALSHARE,
        'link' => tep_href_link(FILENAME_SOCIALLOGINANDSOCIALSHARE)
      )
?>

3.Add following code in file - "YOUR_ADMIN/includes/languages/english.php", before "?>" tag at the bottom of the file:-

define('BOX_TOOLS_SOCIALLOGINANDSOCIALSHARE', 'Social Login and Social Share');

4. Add following code in file - "YOUR_ADMIN/includes/filenames.php
" 


define('FILENAME_SOCIALLOGINANDSOCIALSHARE', 'socialloginandsocialshare.php');

5. Add following code in file - "YOUR_ADMIN/includes/database_tables.php
":-


define('TABLE_LOGINRADIUS_SETTING', 'loginradius_setting');

6. Add following code in file - "catalog/includes/application_top.php
" at the bottom of the file:-


<?php require_once('sociallogin.php');?>

7. Add following code in file - "catalog/includes/template_top.php" at the bottom of the file:-

<?php require_once('socialshare.php');?>

8. Add following code in file - "catalog/includes/template_bottom.php" at top

<?php require('social_sharing_footer.php'); ?>

9. Please add following code in file includes/database_tables.php

define('TABLE_SOCIALLOGIN', 'sociallogin');

define('TABLE_LOGINRADIUS_SETTING', 'loginradius_setting');

NOTE- If you have added Facebook, Google, Twitter, LinkedIn, Yahoo, FourSquare and/or Live;
you are required to insert their API Key and Secret on Provider Settings page of www.loginradius.com to activate them on your LoginRadius interface.Help is available on Provider Settings page,i.e.,https://www.loginradius.com/Account/providersettings.aspx


== Frequently Asked Questions ==

= What is LoginRadius =

LoginRadius is a Software As A Service (SAAS) which allows users to log in to a third party website via popular open IDs/oAuths such as Google, Facebook, 
Yahoo, AOL and over 20 more.

= How long can I keep my account? =

How long you use LoginRadius is completely up to you. You may remove LoginRadius from your website and delete your account at any time.

= What is the best way to reach the LoginRadius Team? =

If you have any questions or concerns regarding LoginRadius, please write us at hello@loginradius.com.

= How much you charge for this service? =

It is FREE and will remain free, but for advanced features and customized solutions, there are various packages available. Please contact us for further 
details.

= Do you have a live demo site? =

Yes, please visit our osCommerce live demo site at http://oscommercedemo.loginradius.com :)

== Screenshots ==

1. Screenshot-1: This screenshot displays loginradius interface for login section. Its showing all selected providers with a slider 
option./catalog/Screenshot-1.jpg
2. Screenshot-2: This screenshot displays Social Login(LoginRadius) module's configuration options after installation./catalog/Screenshot-2.jpg
3. Screenshot-3: This screenshot shows loginradius interface on login page./catalog/Screenshot-3.jpg

== Changelog ==

= 1.4=
Change log:
1. Added interface customization for language, social icon set and theme
2. Added More user profile data.
3. Bug fixed for https redirection issue.