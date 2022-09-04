<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  
 $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
   if (tep_not_null($action)) {
    switch ($action) {
      case 'save':
	  	$error = false;
	  	$settings = $_POST['lrsetting'];
		$rearrange_settings = $_POST['rearrange_settings'];
		$settings['apikey'] = trim($settings['apikey']);
		$settings['apisecret'] = trim($settings['apisecret']);
		$settings['rearrange_settings'] = (sizeof($rearrange_settings) > 0 ? serialize($rearrange_settings) : "");
        function isValidApiSettings($apikey) {
	      return !empty($apikey) && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $apikey);
    	}
		if(!isValidApiSettings($settings['apikey'])){
			$messageStack->add('Please enter a valid API Key', 'error');
		}
		elseif(!isValidApiSettings($settings['apisecret'])){
			$messageStack->add('Please enter a valid API Secret', 'error');
		}
		elseif($settings['apikey'] == $settings['apisecret']){
				$messageStack->add('Please enter a valid API and Secret', 'error');
			}
		else{
		 tep_db_query("delete from " . TABLE_LOGINRADIUS_SETTING . "");
		 foreach ($settings as $k => $v)
		  {
		  tep_db_query("INSERT INTO " . TABLE_LOGINRADIUS_SETTING . " ( setting, value )" . " VALUES ( '" . mysql_real_escape_string($k) . "', '" . mysql_real_escape_string($v) . "')");
		  }
		$messageStack->add('Options saved successfully', 'success');
			break;
		}
    }
  }
  require(DIR_WS_INCLUDES . 'template_top.php');
  
  ?>
<link rel="stylesheet" type="text/css" href="socialloginandsocialshare/socialloginandsocialshare.css">
<!--<script language="javascript" src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<script language="javascript" src="//code.jquery.com/ui/1.10.0/jquery-ui.js"></script>-->
<script language="javascript" src="socialloginandsocialshare/socialloginandsocialshare.js"></script>
<script type="text/javascript">
	jQuery(function(){
		function m(n, d){
			P = Math.pow;
			R = Math.round
			d = P(10, d);
			i = 7;
			while(i) {
				(s = P(10, i-- * 3)) <= n && (n = R(n * d / s) / d + "KMGTPE"[i])
			}
			return n;
			}
		jQuery.ajax({
			url: 'http://api.twitter.com/1/users/show.json',
			data: {
			screen_name: 'LoginRadius'
			},
			dataType: 'jsonp',
			success: function(data) {
			count = data.followers_count;
			jQuery('#followers').html(m(count, 1));
			}
		});
	});
</script>
<?php if(FILENAME_SOCIALLOGINANDSOCIALSHARE != 'socialloginandsocialshare.php'){
	echo '<div id="lrerror">Please add following code in file YOUR_ADMIN/includes/filenames.php<br><br>define(\'FILENAME_SOCIALLOGINANDSOCIALSHARE\', \'socialloginandsocialshare.php\');</div>';
	} 
	elseif(!defined('TABLE_LOGINRADIUS_SETTING')) {
		echo '<div id="lrerror">Please add following code in file YOUR_ADMIN/includes/database_tables.php<br><br>define(\'TABLE_LOGINRADIUS_SETTING\', \'loginradius_setting\');</div>';
		}
	else{
		  tep_db_query("CREATE TABLE IF NOT EXISTS " . TABLE_LOGINRADIUS_SETTING . " (
					 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					 `setting` varchar(255) NOT NULL,
					 `value` varchar(1000) NOT NULL,
					 PRIMARY KEY (`id`),
					 UNIQUE KEY `setting` (`setting`)
					 )");
		?>
<?php echo tep_draw_form('socialloginandsocialshare', FILENAME_SOCIALLOGINANDSOCIALSHARE, 'action=save', 'post', 'enctype="multipart/form-data"'); ?>
<table>
<tr>
<td colspan="2">
<?php
 
$result = tep_db_query("select * FROM " . TABLE_LOGINRADIUS_SETTING . "");
 
while ($rrr = tep_db_fetch_array($result)){
	$setting[] = $rrr;
}
for($i=0;$i <sizeof($setting);$i++){
	$lrsetting[$setting[$i]['setting']] =$setting[$i]['value'];
}

?></td>
</tr>
<tr>
<td colspan="2"><span class="pageHeading"><?php echo 'Social Login and Social Share Modules';?></span><p align="right" style="margin:0;"><?php echo 'version 2.1';?></p>
</td></tr>
  <tr>
    <td>
	<div>
  <div style="float:left; width:100%;">
	<div>
    <fieldset class="sociallogin_form sociallogin_form_main" style="background:#EAF7FF; border: 1px solid #B3E2FF;font-family: sans-serif;">
     
      <h3 style="border-bottom:#000000 1px solid; margin:0px; padding:0 0 6px 0; border-bottom: 1px solid #B3E2FF; color: #000000; margin:10px;"><?php echo 'Thank you for installing the LoginRadius OsCommerce version 2.3 Module!';?></h3>
     
      <div class="sociallogin_row" style="width:90%; line-height:160%;">
        <?php echo 'To activate the extension, please configure it and manage the social networks from you LoginRadius account. If you do not have an account, click <a href="http://www.loginradius.com" target="_blank"><span style="color: #0088CC;">here</span></a> and create one for FREE! '; ?> 
      </div>
      <div class="sociallogin_row" style="width:90%; line-height:160%;">
        <?php echo 'We also have Social Plugin for <a href="https://www.loginradius.com/loginradius-cms-social-plugins/wordpress-plugin" target="_blank"><span style="color: #0088CC;">WordPress</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/drupal-module" target="_blank"><span style="color: #0088CC;">Drupal</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/vbulletin-forum-add-on" target="_blank"><span style="color: #0088CC;">vBulletin</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/vanilla-forum-add-on" target="_blank"><span style="color: #0088CC;">VanillaForum</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/magento-extension" target="_blank"><span style="color: #0088CC;">Magento</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/oscommerce-addon" target="_blank"><span style="color: #0088CC;">osCommerce</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/prestashop-module" target="_blank"><span style="color: #0088CC;">PrestaShop</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/x-cart-module" target="_blank"><span style="color: #0088CC;">X-Cart</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/zencart-plugin" target="_blank"><span style="color: #0088CC;">Zen-Cart</span></a>, <a href="https://www.loginradius.com/loginradius-cms-social-plugins/dotnetnuke-module" target="_blank"><span style="color: #0088CC;">DotNetNuke</span></a> and <a href="https://www.loginradius.com/loginradius-cms-social-plugins/blogengine-extension" target="_blank"><span style="color: #0088CC;">BlogEngine</span></a>!'; ?> 
      </div>
      <div class="sociallogin_row sociallogin_row_button btn btn-small " style="margin-left:10px !important;">
						<div class="button2-left">
							<div class="blank">
		<a class="modal" href="http://www.loginradius.com/" target="_blank"><?php echo 'Set up my FREE account!'; ?></a>
							</div>
						</div>
					</div>
      </fieldset>
	  
    </div>
<dl id="pane" class="tabs">
	<dt class="panel1 open" id="panel1"  style="cursor:pointer;" ><span style="font-family: sans-serif;font-weight: bold;" onclick=javascript:panelshow("first")><?php echo 'Social Login'; ?></span></dt>
	<dt class="panel2 closed" id="panel2" style="cursor:pointer;" ><span style="font-family: sans-serif;font-weight: bold;" onclick=javascript:panelshow("second")><?php echo 'Social Share'; ?></span></dt>
	<dt class="panel3 closed" id="panel3" style="cursor:pointer;" ><span style="font-family: sans-serif;font-weight: bold;" onclick=javascript:panelshow("third")><?php echo 'Social Counter'; ?></span></dt>
	</dl>
	<div class="current">
  <dd id="first"  style="display:block;"><div>
<!--Social Login-->
<table class="form-table sociallogin_table">
<tr>
<td class="head">Social Login API Setting</small></td>
</tr>
  <tr>
  <td>To activate the plugin, Insert LoginRadius API Key &amp; Secret <a target="_blank" href="http://support.loginradius.com/customer/portal/articles/677100-how-to-get-loginradius-api-key-and-secret">(<span style="color:#3CF;">How to get it?</span>)</a></td>
  <tr><td>
  <table>
  <tr>
    <td><?php echo 'API key'; ?></td>

	<?php
		$adminurl = tep_href_link(FILENAME_SOCIALLOGINANDSOCIALSHARE);
		$adminurl = str_replace('socialloginandsocialshare.php', '', $adminurl);
		$adminurl = str_replace('?action=save', '', $adminurl);
	?>
	<input id="connection_url" type="hidden" value="<?php echo $adminurl;?>" />
    <td><input size="60" type="text" name="lrsetting[apikey]" id="apikey" value="<?php echo (isset($lrsetting['apikey']) ? htmlspecialchars ($lrsetting['apikey']) : ''); ?>" /></td>
  </tr>
  <tr>
    <td><?php echo 'API secret'; ?></td>
    <td><input size="60" type="text" name="lrsetting[apisecret]" id="apisecret" value="<?php echo (isset($lrsetting['apisecret']) ? htmlspecialchars ($lrsetting['apisecret']) : ''); ?>" /></td>
  </tr>
</table>
  </td></tr>
  <tr>
<td class="sociallogin_row_white">What API Connection Method do you prefer to enable API communication?<br><br>
	<?php
		$useapi_curl = "";
		$useapi_fopen = "";
		$useapi = (isset($lrsetting['useapi']) ? $lrsetting['useapi'] : "");
		if ($useapi == '1' ) $useapi_curl = "checked='checked'";
		else if ($useapi == '0') $useapi_fopen = "checked='checked'";
		else $useapi_curl = "checked='checked'";?>
		<input name="lrsetting[useapi]" id="curl" type="radio" value="1" <?php echo $useapi_curl;?>/>
    Use cURL (Recommended API connection method but sometimes this is disabled at hosting server.)<br>
        <input name="lrsetting[useapi]" id="fsockopen" type="radio" value="0" <?php echo $useapi_fopen;?>/>
    Use FSOCKOPEN (Choose this option, if cURL is disabled at your hosting server.)<br>
	<table><tr><td><div class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary">
       <a href="javascript:void(0);" onClick="MakeRequest();"><span class="ui-button-text"><?php echo 'Verify Your API Settings'; ?></span>
			</a></div></td><td><div id="ajaxDiv"></div></td></tr></table>
  </tr>
</table>
<table class="form-table sociallogin_table">
  <tr>
    <td class="head">LoginRadius Basic Settings</td>
  </tr><tr>
    <td>Please enter redirect url of your site where users redirect after successfully login? (Leave blank for osCommerce default redirect functionality)<br><br>
    <input size="60" type="text" name="lrsetting[redirect]" id="redirect" value="<?php echo (isset($lrsetting['redirect']) ? htmlspecialchars ($lrsetting['redirect']) : ''); ?>" />
	<?php 
	  /*  
      $result = $db->Execute("SELECT * FROM " . TABLE_EZPAGES . " WHERE `alt_url_external` = ''");
	  while (!$result->EOF) {
    $results[] = $result->fields;
    $result->MoveNext();
  }
      ?>
      <?php 
	  for($i=0;$i <sizeof($results);$i++){
$resultss[$results[$i]['pages_id']] =$results[$i]['pages_title'];
}
  $setredirct = (isset($lrsetting['setredirct']) ? $lrsetting['setredirct'] : "");?>
      <select id="setredirct" name="lrsetting[setredirct]">
        <option value="" selected="selected">---Default---</option>
        <?php foreach ($resultss as $pages_id => $pages_title) {?>
        <option <?php if ($pages_id == $setredirct) { echo " selected=\"selected\""; } ?> value="<?php echo $pages_id;?>" >
          <?php echo $pages_title;?>
        </option>
      <?php }?>
      </select>*/?>
	  </td>
  </tr><tr>
    <td class="sociallogin_row_white">Do you want your existing user to automatically link to their social accounts in case their osCommerce account email address matches with their social account email ID?
	<br><br>
	 <?php 
			$yeslink = "";
			$notlink = "";
			$linkaccount = (isset($lrsetting['linkaccount'])  ? $lrsetting['linkaccount'] : "");
			if ($linkaccount == '1') $yeslink = "checked='checked'";
			else if ($linkaccount == '0') $notlink = "checked='checked'";
			else $yeslink = "checked='checked'";?>
	<input name="lrsetting[linkaccount]" type="radio" value="1" <?php echo $yeslink;?>/>YES, link social accounts to osCommerce account<br>
	<input name="lrsetting[linkaccount]" type="radio" value="0" <?php echo $notlink;?>/>NO, I want my existing users to continue using native osCommerce login
	</td>
  </tr><?php /*<tr>
    <td>Do you want to send emails to admin after new User registrations at your website?
	<br><br>
	<?php
			$yessendemail = "";
			$notsendemail = "";
			$sendemail = (isset($lrsetting['sendemail'])  ? $lrsetting['sendemail'] : "");
			if ($sendemail == '1') $yessendemail = "checked='checked'";
			else if ($sendemail == '0') $notsendemail = "checked='checked'";
			else $yessendemail = "checked='checked'";?>
	<input name="lrsetting[sendemail]" type="radio" value="1" <?php echo $yessendemail; ?>/>
	YES &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="lrsetting[sendemail]" type="radio" value="0" <?php echo $notsendemail; ?>/>NO</td>
  </tr>*/?><tr>
    <td>A few ID Providers do not supply user's e-mail IDs as part of user profile data. Do you want users to provide their email IDs before completing registration process?<br>
	<br>
	<?php 
			$yesdummyemail = "";
			$notdummyemail = "";
			$dummyemail = (isset($lrsetting['dummyemail'])  ? $lrsetting['dummyemail'] : "");
			if ($dummyemail == '1') $yesdummyemail = "checked='checked'";
			else if ($dummyemail == '0') $notdummyemail = "checked='checked'";
			else $notdummyemail = "checked='checked'";?>
	<input name="lrsetting[dummyemail]" type="radio" value="0" <?php echo $notdummyemail; ?>/>YES, get real email IDs from the users (Ask users to enter their email IDs in a pop-up)<br>
	<input name="lrsetting[dummyemail]" type="radio" value="1" <?php echo $yesdummyemail; ?>/>NO, just auto-generate random email IDs for the users </td>
  </tr>
  <tr>
    <td class="sociallogin_row_white">A few ID Providers do not supply user's required fields as part of User Profile data. Do you want users to provide their required fields before completing registration process?<br>
	<br>
	<?php 
			$yesallfields = "";
			$notallfields = "";
			$allfields = (isset($lrsetting['allfields'])  ? $lrsetting['allfields'] : "");
			if ($allfields == '1') $yesallfields = "checked='checked'";
			else if ($allfields == '0') $notallfields = "checked='checked'";
			else $yesallfields = "checked='checked'";?>
	<input name="lrsetting[allfields]" type="radio" value="1" <?php echo $yesallfields; ?>/>YES &nbsp;&nbsp;&nbsp;
	<input name="lrsetting[allfields]" type="radio" value="0" <?php echo $notallfields; ?>/>NO</td>
  </tr>
  <tr>
    <td>Please enter the title of the pop-up. (You may use %s, it will be replaced by the Provider name)<br><br>
	<input size="60" type="text" name="lrsetting[popupemailtitle]" id="lrsetting[popupemailtitle]" value="<?php echo (isset($lrsetting['popupemailtitle']) ? htmlspecialchars ($lrsetting['popupemailtitle']) : 'You are trying to connect with %s account'); ?>" /></td>
  </tr><tr>
    <td class="sociallogin_row_white">Please enter the message to be displayed to the user in the pop-up.(You may use %s, it will be replaced by the Provider name)<br><br>
	<input size="60" type="text" name="lrsetting[popupfieldmessage]" id="lrsetting[popupfieldmessage]" value="<?php echo (isset($lrsetting['popupfieldmessage']) ? htmlspecialchars ($lrsetting['popupfieldmessage']) : 'Please provide the following details to complete the registration'); ?>" /></td>
  </tr><?php /*<tr>
    <td class="sociallogin_row_white">Please enter the message to be shown to the user in the pop-up message for send email to varification email<br><br>
	<input size="60" type="text" name="lrsetting[popupsendverifyemailmessage]" id="lrsetting[popupsendverifyemailmessage]" value="<?php echo (isset($lrsetting['popupsendverifyemailmessage']) ? htmlspecialchars ($lrsetting['popupsendverifyemailmessage']) : 'Your Confirmation link Has Been Sent To Your Email Address. Please verify your email by clicking on confirmation link.'); ?>" /></td>
  </tr>
  <tr>
    <td>Please enter the message to be shown to the user in the pop-up message for verify there Account by email<br><br>
	<input size="60" type="text" name="lrsetting[popupverifyemailmessage]" id="lrsetting[popupverifyemailmessage]" value="<?php echo (isset($lrsetting['popupverifyemailmessage']) ? htmlspecialchars ($lrsetting['popupverifyemailmessage']) : 'Your email has been successfully verified. Now you can login to your account.'); ?>" /></td></tr>
	<tr>
	<td class="sociallogin_row_white">Please enter the message to be shown to the user in the pop-up message for Try to Login Account with out verify there Account by email<br><br>
	<input size="60" type="text" name="lrsetting[popupnotverifyemailmessage]" id="lrsetting[popupnotverifyemailmessage]" value="<?php echo (isset($lrsetting['popupnotverifyemailmessage']) ? htmlspecialchars ($lrsetting['popupnotverifyemailmessage']) : 'You don\'t verify you Account. Please verify your account first.'); ?>" /></td>
  </tr>*/?>
</table>
<table class="form-table sociallogin_table">
  <tr>
    <td class="head">Social Login Interface Settings</td>
  </tr>
  <tr>
    <td>After User logs in, what would you like to show as part of greeting message? 
	<br><br>
	<?php  
			$showonlyfirstname = "";
			$showonlylastname = "";
			$showfullname = "";
			$showname = (isset($lrsetting['showname'])  ? $lrsetting['showname'] : "");
			if ($showname == '0') $showonlyfirstname = "checked='checked'";
			else if ($showname == '1') $showonlylastname = "checked='checked'";
			else if ($showname == '2') $showfullname = "checked='checked'";
			else $showonlyfirstname = "checked='checked'";?>
	<input name="lrsetting[showname]" type="radio" value="0" <?php echo $showonlyfirstname;?>/>First Name
	&nbsp;&nbsp;
	<input name="lrsetting[showname]" type="radio" value="1" <?php echo $showonlylastname;?>/>Last Name
	&nbsp;&nbsp;
	<input name="lrsetting[showname]" type="radio" value="2" <?php echo $showfullname;?>/>Full Name
	</td>
  </tr>
  <tr>
  	<td class="sociallogin_row_white">Please enter the <b>Title</b> to be shown on Social Login intarface<br><br>
	<input size="60" type="text" name="lrsetting[sociallogintitle]" id="lrsetting[sociallogintitle]" value="<?php echo (isset($lrsetting['sociallogintitle']) ? htmlspecialchars ($lrsetting['sociallogintitle']) : 'Login with Social ID'); ?>" />
	</td>
  </tr>
</table>
</div></dd>
<!--Social Share-->
<dd id="second" style="display:none;"><div>
<table class="form-table sociallogin_table">
  <tr>
    <td class="head">LoginRadius Social Share Settings</small></td>
  </tr>
  <tr>
    <td>Do you want to enable Social Sharing for your website?<br><br>
	<?php 	
			$yesenableshare = "";
			$noenableshare = "";
			$enableshare = (isset($lrsetting['enableshare']) ? $lrsetting['enableshare'] : "");
			if ($enableshare == '0') $noenableshare = "checked='checked'";
			else if ($enableshare == '1') $yesenableshare = "checked='checked'";
			else $noenableshare = "checked='checked'";?>
	<input name="lrsetting[enableshare]" type="radio" value="1" <?php echo $yesenableshare ?>/>Yes
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="lrsetting[enableshare]" type="radio" value="0" <?php echo $noenableshare ?>/>No</td>
  </tr>
  <tr>
    <td class="sociallogin_row_white">Enter the text that you wish to be displayed above the Social Sharing Interface. Leave the field blank if you don't want any text to be displayed.<br><br>
	<input size="60" type="text" name="lrsetting[socialsharetitle]" id="lrsetting[socialsharetitle]" value="<?php echo (isset($lrsetting['socialsharetitle']) ? htmlspecialchars ($lrsetting['socialsharetitle']) : 'Share it now!'); ?>" /></td>
  </tr>
  <tr>
    <td>What Social Sharing widget theme do you want to use across your website?<br>
<br>
<?php
$hori32 = "";
	        $hori16 = "";
			$horithemelarge = "";
			$horithemesmall = "";
			$vertibox32 = "";
			$vertibox16 = "";
            $chooseshare = (isset($lrsetting['chooseshare']) ? $lrsetting['chooseshare'] : "");
            if ($chooseshare == '0' ) $hori32 = "checked='checked'";
            else if ($chooseshare == '1' ) $hori16 = "checked='checked'";
			else if ($chooseshare == '2' ) $horithemelarge = "checked='checked'";
			else if ($chooseshare == '3' ) $horithemesmall = "checked='checked'";
			else if ($chooseshare == '4' ) $vertibox32 = "checked='checked'";
			else if ($chooseshare == '5' ) $vertibox16 = "checked='checked'";
            else $hori32 = "checked='checked'";?>
	     <a id="mymodal1" href="javascript:void(0);" onClick="Makehorivisible();" style="color: <?php if($chooseshare == '' || $chooseshare == '0' || $chooseshare == '1' || $chooseshare == '2' || $chooseshare == '3'){echo '#00CCFF';} else{ echo '#000000';}?>;"><b><?php echo 'Horizontal'; ?></b></a> &nbsp;|&nbsp; 
	     <a id="mymodal2" href="javascript:void(0);" onClick="Makevertivisible();" style="color: <?php if($chooseshare == '' || $chooseshare == '0' || $chooseshare == '1' || $chooseshare == '2' || $chooseshare == '3'){echo '#000000';} else{ echo '#00CCFF';}?>;"><b><?php echo 'Vertical'; ?></b></a>
	     <div style="border:#dddddd 1px solid; padding:10px; background:#FFFFFF; margin:10px 0 0 0;">
	     <span id = "arrow" style="position:absolute; border-bottom:8px solid #ffffff; border-right:8px solid transparent; border-left:8px solid transparent; margin:-18px 0 0 <?php if($chooseshare == '' || $chooseshare == '0' || $chooseshare == '1' || $chooseshare == '2' || $chooseshare == '3'){echo '2px';} else{ echo '90px';}?>;"></span>
	     <div id="sharehorizontal" style="display:<?php if($chooseshare == '' || $chooseshare == '0' || $chooseshare == '1' || $chooseshare == '2' || $chooseshare == '3'){echo 'Block';} else{ echo 'none';}?>;">
	     <input name="lrsetting[chooseshare]" id = "hori32" type="radio"  <?php echo $hori32;?>value="0" style="margin: 4px 10px 0 0; display: block; float: left !important;" /> <img src = '<?php echo "socialloginandsocialshare/images/socialshare/horizonSharing32.png"?>' /><br /><br />
         <input name="lrsetting[chooseshare]" id = "hori16" type="radio" <?php echo $hori16;?>value="1" style="margin: 2px 10px 0 0; display: block; float: left !important;" /> <img src = '<?php echo "socialloginandsocialshare/images/socialshare/horizonSharing16.png"?>' /><br /><br />
         <input name="lrsetting[chooseshare]" id = "horithemelarge" type="radio" <?php echo $horithemelarge;?>value="2" style="margin: 4px 10px 0 0; display: block; float: left !important;" /> <img src = '<?php echo "socialloginandsocialshare/images/socialshare/single-image-theme-large.png"?>' /><br /><br />
         <input name="lrsetting[chooseshare]" id = "horithemesmall" type="radio" <?php echo $horithemesmall;?>value="3" style="margin: 2px 10px 0 0; display: block; float: left !important;" /> <img src = '<?php echo "socialloginandsocialshare/images/socialshare/single-image-theme-small.png"?>' /><br /><br />
		 <div style="overflow:auto; background:#EBEBEB; padding:10px;">
		 Select the position of Social sharing interface<br>
	<?php
			$sharetop = "";
			$sharebottom = "";
			$sharepos = (isset($lrsetting['sharepos'])  ? $lrsetting['sharepos'] : "");
			if ($sharepos == '1') $sharebottom = "checked='checked'";
			else if ($sharepos == '0') $sharetop = "checked='checked'";
			else $sharetop = "checked='checked'";?>
	<input name="lrsetting[sharepos]" type="radio" value="0" <?php echo $sharetop ?>/>Show at the Top of content
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="lrsetting[sharepos]" type="radio" value="1" <?php echo $sharebottom ?>/>Show at the Bottom of content<br>
         </div></div>
         <div id="sharevertical" style="display:<?php if($chooseshare == '4' || $chooseshare == '5'){echo 'Block';} else{ echo 'none';}?>">
         <input name="lrsetting[chooseshare]" id = "vertibox32" type="radio"  <?php echo $vertibox32;?>value="4" style="vertical-align:top" /> <img src = '<?php echo "socialloginandsocialshare/images/socialshare/32VerticlewithBox.png"?>' />
         <input name="lrsetting[chooseshare]" id = "vertibox16" type="radio" <?php echo $vertibox16;?>value="5" style="vertical-align:top" /> <img src = '<?php echo "socialloginandsocialshare/images/socialshare/16VerticlewithBox.png"?>' style="vertical-align:top" /><br /><br />
         <div style="overflow:auto; background:#EBEBEB; padding:10px;">
         <p style="margin:0 0 6px 0; padding:0px;"><strong><?php echo 'Select the position of Social Sharing widget'; ?></strong><br>
         <?php $topshareleft = "";
	        $topshareright = "";
			$bottomshareleft = "";
			$bottomshareright = "";
			$choosesharepos = (isset($lrsetting['choosesharepos']) ? $lrsetting['choosesharepos'] : "");
            if ($choosesharepos == '0' ) $topshareleft = "checked='checked'";
            else if ($choosesharepos == '1' ) $topshareright = "checked='checked'";
			else if ($choosesharepos == '2' ) $bottomshareleft = "checked='checked'";
			else if ($choosesharepos == '3' ) $bottomshareright = "checked='checked'";
			else $topshareleft = "checked='checked'";?>
        <input name="lrsetting[choosesharepos]" id = "topshareleft" type="radio"  <?php echo $topshareleft;?>value="0" style="margin:0;"/> <?php echo 'Top Left'; ?><br /> 
        <input name="lrsetting[choosesharepos]" id = "topshareright" type="radio" <?php echo $topshareright;?>value="1" style="margin:0;"/> <?php echo 'Top Right'; ?> <br />
        <input name="lrsetting[choosesharepos]" id = "bottomshareleft" type="radio" <?php echo $bottomshareleft;?>value="2" style="margin:0;"/> <?php echo 'Bottom Left'; ?><br /> 
        <input name="lrsetting[choosesharepos]" id = "bottomshareright" type="radio" <?php echo $bottomshareright;?>value="3" style="margin:0;"/> <?php echo 'Bottom Right'; ?> <br /><br>
		<p style="margin:0 0 6px 0; padding:0px;"><strong><?php echo 'Specify distance of vertical sharing interface from top. (Leave empty for default behaviour)';?><a title="<?php echo 'Enter a number (For example - 200). It will set the \'top\' CSS attribute of the interface to the value specified. Increase in the number pushes interface towards bottom.';?>" href="javascript:void(0)" style="text-decoration:none"> (?)</a></strong><br>
	  <input size="30" type="text" name="lrsetting[verticalsharetopoffset]" id="verticalsharetopoffset" value="<?php echo (isset ($lrsetting['verticalsharetopoffset']) ? htmlspecialchars ($lrsetting['verticalsharetopoffset']) : ''); ?>" />
         </div></div>
		 </td>
  </tr>
  <tr>
    <td class="sociallogin_row_white">What Sharing Networks do you want to show in the sharing widget? (All other sharing networks will be shown as part of LoginRadius sharing icon).<br><div id="loginRadiusSharingLimit" style="color: red; display: none; margin-bottom: 5px;"><?php echo 'You can select only 9 providers.'; ?></div><br>
	<?php
	$enablefb = "";
        $enabletwitter = "";
		$enableprint = "";
		$enableemail = "";
		$enablegoogle = "";
		$enabledigg = "";
		$enablereddit = "";
		$enablevk = "";
		$enablegplus = "";
		$enabletumbler = "";
		$enablelinkedin = "";
		$enablemyspace = "";
		$enabledeli = "";
		$enableyahoo = "";
		$enablelive = "";
		$enablehyves = "";
		$enablednnkicks = "";
		$enablepin = "";
		$provider = '';
		$rearrange = (isset($lrsetting['rearrange_settings']) ? $lrsetting['rearrange_settings'] : "");
		$rearrange = unserialize($rearrange);
		$enablefb = (isset($lrsetting['enablefb']) == 'facebook'  ? 'facebook' : 'off');
        if ($enablefb == 'facebook') $enablefb = "checked='checked'";
		$enabletwitter = (isset($lrsetting['enabletwitter']) == 'twitter'  ? 'twitter' : 'off');
        if ($enabletwitter == 'twitter') $enabletwitter = "checked='checked'";
		$enableprint = (isset($lrsetting['enableprint']) == 'print'  ? 'print' : 'off');
        if ($enableprint == 'print') $enableprint = "checked='checked'";
		$enableemail = (isset($lrsetting['enableemail']) == 'email'  ? 'email' : 'off');
        if ($enableemail == 'email') $enableemail = "checked='checked'";
		$enablegoogle = (isset($lrsetting['enablegoogle']) == 'google'  ? 'google' : 'off');
        if ($enablegoogle == 'google') $enablegoogle = "checked='checked'";
		
		$enabledigg = (isset($lrsetting['enabledigg']) == 'digg'  ? 'digg' : 'off');
        if ($enabledigg == 'digg') $enabledigg = "checked='checked'";
		$enablereddit = (isset($lrsetting['enablereddit']) == 'reddit'  ? 'reddit' : 'off');
        if ($enablereddit == 'reddit') $enablereddit = "checked='checked'";
		$enablevk = (isset($lrsetting['enablevk']) == 'vkontakte'  ? 'vkontakte' : 'off');
        if ($enablevk == 'vkontakte') $enablevk = "checked='checked'";
		$enablegplus = (isset($lrsetting['enablegplus']) == 'googleplus'  ? 'googleplus' : 'off');
        if ($enablegplus == 'googleplus') $enablegplus = "checked='checked'";
		$enabletumbler = (isset($lrsetting['enabletumbler']) == 'tumblr'  ? 'tumblr' : 'off');
        if ($enabletumbler == 'tumblr') $enabletumbler = "checked='checked'";
		$enablelinkedin = (isset($lrsetting['enablelinkedin']) == 'linkedin'  ? 'linkedin' : 'off');
        if ($enablelinkedin == 'linkedin') $enablelinkedin = "checked='checked'";
		$enablemyspace = (isset($lrsetting['enablemyspace']) == 'myspace'  ? 'myspace' : 'off');
        if ($enablemyspace == 'myspace') $enablemyspace = "checked='checked'";
		$enabledeli = (isset($lrsetting['enabledeli']) == 'delicious'  ? 'delicious' : 'off');
        if ($enabledeli == 'delicious') $enabledeli = "checked='checked'";
		$enableyahoo = (isset($lrsetting['enableyahoo']) == 'yahoo'  ? 'yahoo' : 'off');
        if ($enableyahoo == 'yahoo') $enableyahoo = "checked='checked'";
		$enablelive = (isset($lrsetting['enablelive']) == 'live'  ? 'live' : 'off');
        if ($enablelive == 'live') $enablelive = "checked='checked'";
		$enablehyves = (isset($lrsetting['enablehyves']) == 'hyves'  ? 'hyves' : 'off');
        if ($enablehyves == 'hyves') $enablehyves = "checked='checked'";
		$enablednnkicks = (isset($lrsetting['enablednnkicks']) == 'dotnetkicks'  ? 'dotnetkicks' : 'off');
        if ($enablednnkicks == 'dotnetkicks') $enablednnkicks = "checked='checked'";
		$enablepin = (isset($lrsetting['enablepin']) == 'pinterest'  ? 'pinterest' : 'off');
        if ($enablepin == 'pinterest') $enablepin = "checked='checked'";
		if(empty($rearrange)) {
		  $enablefb = "checked='checked'";
		  $enabletwitter = "checked='checked'";
		  $enablelinkedin = "checked='checked'";
		  $enablegplus = "checked='checked'";
		  $enablepin = "checked='checked'";
		}
		 ?>
      <table width="100%" id="shareprovider" >
  <tr>
    <td style="width:33%">
	<input name="lrsetting[enablefb]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablefb;?> value="facebook"  /> <?php echo 'Facebook'; ?><br />
		<input name="lrsetting[enabletwitter]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enabletwitter;?> value="twitter"  /> <?php echo 'Twitter'; ?><br />
		<input name="lrsetting[enableprint]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enableprint;?> value="print"  /> <?php echo 'Print'; ?><br />
		<input name="lrsetting[enableemail]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enableemail;?> value="email"  /> <?php echo 'Email'; ?><br />
		<input name="lrsetting[enablegoogle]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablegoogle;?> value="google"  /> <?php echo 'Google'; ?><br />
		<input name="lrsetting[enablepin]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablepin;?> value="pinterest"  /> <?php echo 'Pinterest'; ?>
		</td>
    <td style="width:33%">
	<input name="lrsetting[enabledigg]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enabledigg;?> value="digg"  /> <?php echo 'Digg'; ?><br />
		<input name="lrsetting[enablereddit]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablereddit;?> value="reddit"  /> <?php echo 'Reddit'; ?><br />
		<input name="lrsetting[enablevk]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablevk;?> value="vkontakte"  /> <?php echo 'Vkontakte'; ?><br />
		<input name="lrsetting[enablegplus]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablegplus;?> value="googleplus"  /> <?php echo 'GooglePlus'; ?><br />
		<input name="lrsetting[enabletumbler]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enabletumbler;?> value="tumblr"  /> <?php echo 'Tumblr'; ?><br />
		<input name="lrsetting[enablelinkedin]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablelinkedin;?> value="linkedin"  /> <?php echo 'LinkedIn'; ?>
		</td>
    <td style="width:33%">
	<input name="lrsetting[enablemyspace]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablemyspace;?> value="myspace"  /> <?php echo 'MySpace'; ?><br />
		<input name="lrsetting[enabledeli]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enabledeli;?> value="delicious"  /> <?php echo 'Delicious'; ?><br />
		<input name="lrsetting[enableyahoo]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enableyahoo;?> value="yahoo"  /> <?php echo 'Yahoo'; ?><br />
		<input name="lrsetting[enablelive]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablelive;?> value="live"  /> <?php echo 'Live'; ?><br />
		<input name="lrsetting[enablehyves]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablehyves;?> value="hyves"  /> <?php echo 'Hyves'; ?><br />
		<input name="lrsetting[enablednnkicks]" onChange="loginRadiusSharingLimit(this);loginRadiusRearrangeProviderList(this);" type="checkbox"  <?php echo $enablednnkicks;?> value="dotnetkicks"  /> <?php echo 'DotNetKicks'; ?>
		</td>
  </tr>
</table>

	  </td>
  </tr>
  <tr>
    <td>What sharing network order do you prefer for your sharing widget?<br>
	<ul onMouseOver="lr_sortable();" id="sortable" class="ui-sortable">
						<?php 
						if (empty($rearrange)) {
						  $rearrange[] = 'facebook';
						  $rearrange[] = 'googleplus';
						  $rearrange[] = 'twitter';
						  $rearrange[] = 'linkedin';
						  $rearrange[] = 'pinterest';
						}
							foreach($rearrange  as $provider){
								?>
								<li title="<?php echo $provider ?>" id="loginRadiusLI<?php echo $provider ?>" class="lrshare_iconsprite32 lrshare_<?php echo $provider ?>">
								<input type="hidden" name="rearrange_settings[]" value="<?php echo $provider ?>" />
								</li>
								<?php
							}
						
						?>
			  </ul>
	</td>
  </tr>
  <tr>
    <td class="sociallogin_row_white">What area(s) do you want to show the social Share widget?<br><br>
	<?php
		$shareallpages = (isset($lrsetting['shareallpages']) == 'on'  ? 'on' : 'off');
        if ($shareallpages == 'on') $shareallpages = "checked='checked'";
		
		$shareproductpages = (isset($lrsetting['shareproductpages']) == 'on'  ? 'on' : 'off');
        if ($shareproductpages == 'on') $shareproductpages = "checked='checked'";
		
		$sharereviewspages = (isset($lrsetting['sharereviewspages']) == 'on'  ? 'on' : 'off');
        if ($sharereviewspages == 'on') $sharereviewspages = "checked='checked'";
		
		$shareshoppingpages = (isset($lrsetting['shareshoppingpages']) == 'on'  ? 'on' : 'off');
        if ($shareshoppingpages == 'on') $shareshoppingpages = "checked='checked'";
		
		$sharehomepages = (isset($lrsetting['sharehomepages']) == 'on'  ? 'on' : 'off');
        if ($sharehomepages == 'on') $sharehomepages = "checked='checked'";
		
		if (($shareallpages=="off")&&($shareproductpages=="off")&&($sharereviewspages=="off")&&($sharehomepages=="off")&&($shareshoppingpages=="off")){
			$shareallpages = "checked='checked'";
			}		
		?>
		<input name="lrsetting[shareallpages]" type="checkbox"  <?php echo $shareallpages;?> value="on"  /> <?php echo 'All Pages'; ?><br />
		<input name="lrsetting[shareproductpages]"  type="checkbox"  <?php echo $shareproductpages;?> value="on"  /> <?php echo 'Product Pages'; ?><br />
		<input name="lrsetting[sharereviewspages]" type="checkbox"  <?php echo $sharereviewspages;?> value="on"  /> <?php echo 'Reviews Pages'; ?><br />
        <input name="lrsetting[sharehomepages]" type="checkbox"  <?php echo $sharehomepages;?> value="on"  /> <?php echo 'Home Page'; ?><br />
		<input name="lrsetting[shareshoppingpages]"  type="checkbox"  <?php echo $shareshoppingpages;?> value="on"  /> <?php echo 'Shopping Cart'; ?></td>
  </tr>
</table>
</div></dd>
<!--Social Counter-->
<dd id="third" style="display:none;"><div>
<table class="form-table sociallogin_table">
  <tr>
    <td class="head">LoginRadius Social Counter Settings</small></td>
  </tr>
  <tr>
    <td>Do you want to enable Social Counter for your website?<br><br>
		  <?php 
		  $yesenablecounter = "";
          $noenablecounter = "";
          $enablecounter = (isset($lrsetting['enablecounter']) ? $lrsetting['enablecounter'] : "");
          if ($enablecounter == '0') $noenablecounter = "checked='checked'";
          else if ($enablecounter == '1') $yesenablecounter = "checked='checked'";
          else $noenablecounter = "checked='checked'";?>

	<input name="lrsetting[enablecounter]" type="radio" value="1" <?php echo $yesenablecounter?>/>Yes
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="lrsetting[enablecounter]" type="radio" value="0" <?php echo $noenablecounter?>/>No</td>
  </tr>
  <tr>
    <td class="sociallogin_row_white">Enter the text that you wish to be displayed above the Social Counter Interface. Leave the field blank if you don't want any text to be displayed.<br><br>
	<input size="60" type="text" name="lrsetting[socialcountertitle]" id="socialcountertitle" value="<?php echo (isset($lrsetting['socialcountertitle']) ? htmlspecialchars ($lrsetting['socialcountertitle']) : 'Be a fan!'); ?>" /></td>
  </tr>
  <tr>
    <td>What Social Counter widget theme do you want to use across your website?
<br><br>
<?php 		$chori32 = "";
	        $chori16 = "";
			$cvertibox32 = "";
			$cvertibox16 = "";
            $choosecounter = (isset($lrsetting['choosecounter']) ? $lrsetting['choosecounter'] : "");
            if ($choosecounter == '0' ) $chori16 = "checked='checked'";
            else if ($choosecounter == '1' ) $chori32 = "checked='checked'";
			else if ($choosecounter == '2' ) $cvertibox32 = "checked='checked'";
			else if ($choosecounter == '3' ) $cvertibox16 = "checked='checked'";
			else $chori16 = "checked='checked'";?>
	  <a id="mymodal3" href="javascript:void(0);" onClick="Makechorivisible();" style="color: <?php if($choosecounter == '' || $choosecounter == '0' || $choosecounter == '1'){echo '#00CCFF';} else{ echo '#000000';}?>;"><b><?php echo 'Horizontal'; ?></b></a> &nbsp;|&nbsp; 
	  <a id="mymodal4" href="javascript:void(0);" onClick="Makecvertivisible();" style="color: <?php if($choosecounter == '' || $choosecounter == '0' || $choosecounter == '1'){echo '#000000';} else{ echo '#00CCFF';}?>;"><b><?php echo 'Vertical'; ?></b></a>
	  <div style="border:#dddddd 1px solid; padding:10px; background:#FFFFFF; margin:10px 0 0 0;">
      <span id = "carrow"style="position:absolute; border-bottom:8px solid #ffffff; border-right:8px solid transparent; border-left:8px solid transparent; margin:-18px 0 0 <?php if($choosecounter == '' || $choosecounter == '0' || $choosecounter == '1'){echo '2px';} else{ echo '90px';}?>;"></span>
	  <div id="counterhorizontal" style="display:<?php if($choosecounter == '' || $choosecounter == '0' || $choosecounter == '1'){echo 'Block';} else{ echo 'none';}?>">
	  <input name="lrsetting[choosecounter]" id = "chori16" type="radio"  <?php echo $chori16;?> value="0" style="margin: 2px 10px 0 0; display: block; float: left !important;" /> <img src = '<?php echo "socialloginandsocialshare/images/socialcounter/hybrid-horizontal-horizontal.png"?>' /><br /><br />
      <input name="lrsetting[choosecounter]" id = "chori32" type="radio" <?php echo $chori32;?> value="1" style="margin: 2px 10px 0 0; display: block; float: left !important;" /> <img src = '<?php echo "socialloginandsocialshare/images/socialcounter/hybrid-horizontal-vertical.png"?>' /><br /><br />
	  <div style="overflow:auto; background:#EBEBEB; padding:10px;">
	  Select the position of Social counter interface<br><br>
	<?php 
   $countertop = "";
   $counterbottom = "";
   $counterpos = (isset($lrsetting['counterpos'])  ? $lrsetting['counterpos'] : "");
   if ($counterpos == '1') $counterbottom = "checked='checked'";
   else if ($counterpos == '0') $countertop = "checked='checked'";
   else $countertop = "checked='checked'";?>
	<input name="lrsetting[counterpos]" type="radio" value="0" <?php echo $countertop; ?>/>Show at the Top of content
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="lrsetting[counterpos]" type="radio" value="1" <?php echo $counterbottom; ?>/>Show at the Bottom of content
      </div></div>
      <div id="countervertical" style="display:<?php if($choosecounter == '2' || $choosecounter == '3'){echo 'Block';} else{ echo 'none';}?>"">
      <input name="lrsetting[choosecounter]" id = "cvertibox32" type="radio"  <?php echo $cvertibox32;?> value="2" style="vertical-align:top"/> <img src = '<?php echo "socialloginandsocialshare/images/socialcounter/hybrid-verticle-horizontal.png"?>' style="vertical-align:top" />

      <input name="lrsetting[choosecounter]" id = "cvertibox16" type="radio" <?php echo $cvertibox16;?> value="3" style="vertical-align:top"/> <img src = '<?php echo "socialloginandsocialshare/images/socialcounter/hybrid-verticle-vertical.png"?>' />
	  <div style="overflow:auto; background:#EBEBEB; padding:10px;">
         <p style="margin:0 0 6px 0; padding:0px;"><strong><?php echo 'Select the position of Social Counter widget'; ?></strong><br><br>
         <?php $topcounterleft = "";
	        $topcounterright = "";
			$bottomcounterleft = "";
			$bottomcounterright = "";

			$choosecounterpos = (isset($lrsetting['choosecounterpos']) ? $lrsetting['choosecounterpos'] : "");
            if ($choosecounterpos == '0' ) $topcounterleft = "checked='checked'";
            else if ($choosecounterpos == '1' ) $topcounterright = "checked='checked'";
			else if ($choosecounterpos == '2' ) $bottomcounterleft = "checked='checked'";
			else if ($choosecounterpos == '3' ) $bottomcounterright = "checked='checked'";
			else $topcounterleft = "checked='checked'";?>
        <input name="lrsetting[choosecounterpos]" id = "topcounterleft" type="radio"  <?php echo $topcounterleft;?>value="0" style="margin:0;"/> <?php echo 'Top Left'; ?><br /> 
        <input name="lrsetting[choosecounterpos]" id = "topcounterright" type="radio" <?php echo $topcounterright;?>value="1" style="margin:0;"/> <?php echo 'Top Right'; ?> <br />
        <input name="lrsetting[choosecounterpos]" id = "bottomcounterleft" type="radio" <?php echo $bottomcounterleft;?>value="2" style="margin:0;"/> <?php echo 'Bottom Left'; ?><br /> 
        <input name="lrsetting[choosecounterpos]" id = "bottomcounterright" type="radio" <?php echo $bottomcounterright;?>value="3" style="margin:0;"/> <?php echo 'Bottom Right'; ?> <br /><br />
		<p style="margin:0 0 6px 0; padding:0px;"><strong><?php echo 'Specify distance of vertical counter interface from top. (Leave empty for default behaviour) '; ?><a title="<?php echo 'Enter a number (For example - 200). It will set the \'top\' CSS attribute of the interface to the value specified. Increase in the number pushes interface towards bottom.';?>" href="javascript:void(0)" style="text-decoration:none"> (?)</a></strong><br>
	 <input size="30" type="text" name="lrsetting[verticalcountertopoffset]" id="verticalcountertopoffset" value="<?php echo (isset($lrsetting['verticalcountertopoffset']) ? htmlspecialchars ($lrsetting['verticalcountertopoffset']) : ''); ?>" />
  </div></div>
	  </td>
  </tr>
  <tr>
    <td class="sociallogin_row_white">What Counter Networks do you want to show in the counter widget?<br><br>
	<?php   
		$enablefblike = "";
        $enablefbrecommend = "";
		$enablefbsend = "";
		$enablegplusone = "";
		$enablegshare = "";
		$enablelinkedinshare = "";
		$enabletweet = "";
		$enablestbadge = "";
		$enableredditshare = "";
		$enablepinit = "";
		$enableHybridshare = "";
        $enablefblike = (isset($lrsetting['enablefblike']) == 'on'  ? 'on' : 'off');
        if ($enablefblike == 'on') $enablefblike = "checked='checked'";
		$enablefbrecommend = (isset($lrsetting['enablefbrecommend']) == 'on'  ? 'on' : 'off');
        if ($enablefbrecommend == 'on') $enablefbrecommend = "checked='checked'";
		$enablefbsend = (isset($lrsetting['enablefbsend']) == 'on'  ? 'on' : 'off');
        if ($enablefbsend == 'on') $enablefbsend = "checked='checked'";
		$enablegplusone = (isset($lrsetting['enablegplusone']) == 'on'  ? 'on' : 'off');
        if ($enablegplusone == 'on') $enablegplusone = "checked='checked'";
		$enablegshare = (isset($lrsetting['enablegshare']) == 'on'  ? 'on' : 'off');
		if ($enablegshare == 'on') $enablegshare = "checked='checked'";
		$enablepinit = (isset($lrsetting['enablepinit']) == 'on'  ? 'on' : 'off');
		if ($enablepinit == 'on') $enablepinit = "checked='checked'";
		$enablelinkedinshare = (isset($lrsetting['enablelinkedinshare']) == 'on'  ? 'on' : 'off');
        if ($enablelinkedinshare == 'on') $enablelinkedinshare = "checked='checked'";
		$enabletweet = (isset($lrsetting['enabletweet']) == 'on'  ? 'on' : 'off');
        if ($enabletweet == 'on') $enabletweet = "checked='checked'";
		$enablestbadge = (isset($lrsetting['enablestbadge']) == 'on'  ? 'on' : 'off');
        if ($enablestbadge == 'on') $enablestbadge = "checked='checked'";
		$enableredditshare = (isset($lrsetting['enableredditshare']) == 'on'  ? 'on' : 'off');
        if ($enableredditshare == 'on') $enableredditshare = "checked='checked'";
		$enableHybridshare = (isset($lrsetting['enableHybridshare']) == 'on'  ? 'on' : 'off');
        if ($enableHybridshare == 'on') $enableHybridshare = "checked='checked'";		
		if($enablefblike == "off" && $enablefbrecommend == "off" && $enablefbsend == "off" && $enablegplusone == "off" && $enablegshare == "off" && $enablelinkedinshare == "off" && $enabletweet == "off" && $enablestbadge == "off" && $enableredditshare == "off" && $enablepinit == "off" &&$enableHybridshare == "off") {
		  $enablefblike = "checked='checked'";
		  $enablegplusone = "checked='checked'";
		  $enablelinkedinshare = "checked='checked'";
		  $enabletweet = "checked='checked'";
		  }
		?>
	<table width="100%" class="form-table sociallogin_table">
		<tr>
		<td style="width:33%;">
       <input name="lrsetting[enablefblike]" type="checkbox"  <?php echo $enablefblike;?> value="on"  /> <?php echo 'Facebook Like' ?><br />
       <input name="lrsetting[enablefbrecommend]" type="checkbox"  <?php echo $enablefbrecommend;?> value="on"  /> <?php echo 'Facebook Recommend' ?><br />
       <input name="lrsetting[enablefbsend]" type="checkbox"  <?php echo $enablefbsend;?> value="on"  /> <?php echo 'Facebook Send' ?><br />
       <input name="lrsetting[enablegplusone]" type="checkbox"  <?php echo $enablegplusone;?> value="on"  /> <?php echo 'Google+ +1' ?><br />
       <input name="lrsetting[enablepinit]" type="checkbox"  <?php echo $enablepinit;?> value="on"  /> <?php echo 'Pinterest Pin it' ?><br />
       <input name="lrsetting[enablegshare]" type="checkbox"  <?php echo $enablegshare;?> value="on"  /> <?php echo 'Google+ Share' ?>
	   </td>
	   <td valign="top" style="width:33%;">
       <input name="lrsetting[enablelinkedinshare]" type="checkbox"  <?php echo $enablelinkedinshare;?> value="on"  /> <?php echo 'LinkedIn Share' ?><br />
	   <input name="lrsetting[enabletweet]" type="checkbox"  <?php echo $enabletweet;?> value="on"  /> <?php echo 'Twitter Tweet' ?><br />
       <input name="lrsetting[enablestbadge]" type="checkbox"  <?php echo $enablestbadge;?> value="on"  /> <?php echo 'StumbleUpon Badge' ?><br />
	   <input name="lrsetting[enableredditshare]" type="checkbox"  <?php echo $enableredditshare;?> value="on"  /> <?php echo 'Reddit' ?><br />
       <input name="lrsetting[enableHybridshare]" type="checkbox"  <?php echo $enableHybridshare;?> value="on"  /> <?php echo 'Hybridshare' ?>
	   </td>
	 </tr>
</table>
</td>
  </tr>
  <tr>
    <td>What area(s) do you want to show the social counter widget?<br><br>
	<?php
		$counterallpages = (isset($lrsetting['counterallpages']) == 'on'  ? 'on' : 'off');
        if ($counterallpages == 'on') $counterallpages = "checked='checked'";
		$counterproductpages = (isset($lrsetting['counterproductpages']) == 'on'  ? 'on' : 'off');
        if ($counterproductpages == 'on') $counterproductpages = "checked='checked'";
		$counterreviewspages = (isset($lrsetting['counterreviewspages']) == 'on'  ? 'on' : 'off');
        if ($counterreviewspages == 'on') $counterreviewspages = "checked='checked'";
		$countershoppingpages = (isset($lrsetting['countershoppingpages']) == 'on'  ? 'on' : 'off');
        if ($countershoppingpages == 'on') $countershoppingpages = "checked='checked'";
		$counterhomepages = (isset($lrsetting['counterhomepages']) == 'on'  ? 'on' : 'off');
        if ($counterhomepages == 'on') $counterhomepages = "checked='checked'";
		if (($counterallpages=="off")&&($counterproductpages=="off")&&($counterreviewspages=="off")&&($counterhomepages=="off")&&($countershoppingpages=="off")){
			$counterallpages = "checked='checked'";
			}		
		?>
		<input name="lrsetting[counterallpages]" type="checkbox"  <?php echo $counterallpages;?> value="on"  /> <?php echo 'All Pages'; ?><br />
		<input name="lrsetting[counterproductpages]"  type="checkbox"  <?php echo $counterproductpages;?> value="on"  /> <?php echo 'Product Pages'; ?><br />
		<input name="lrsetting[counterreviewspages]" type="checkbox"  <?php echo $counterreviewspages;?> value="on"  /> <?php echo 'Reviews Pages'; ?><br />
        <input name="lrsetting[counterhomepages]" type="checkbox"  <?php echo $counterhomepages;?> value="on"  /> <?php echo 'Home Page'; ?><br />
		<input name="lrsetting[countershoppingpages]"  type="checkbox"  <?php echo $countershoppingpages;?> value="on"  /> <?php echo 'Shopping Cart'; ?></td>
  </tr>
</table>
</div></dd>

<center>
<?php echo tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary'); ?>
</center></div></td>
    <td valign="top" width="30%">
<div style="float:right;">
<!-- Help Box --> 
<div style="background:#EAF7FF; border: 1px solid #B3E2FF; overflow:auto; margin:0 0 10px 0;font-family: sans-serif;">
	<h3 style="border-bottom:#000000 1px solid; margin:0px; padding:0 0 6px 0; border-bottom: 1px solid #B3E2FF; color: #000000; margin:10px;"><?php echo 'Help and Documentation'; ?></h3>
	<ul class="help_ul">
  <li><a href="http://support.loginradius.com/customer/portal/articles/1091378-oscommerce-social-login-installation-configuration-and-troubleshooting" target="_blank"><?php echo 'Plugin Installation, Configuration and Troubleshooting'; ?></a></li>
  <li><a href="http://support.loginradius.com/customer/portal/articles/677100-how-to-get-loginradius-api-key-and-secret" target="_blank"><?php echo 'How to get LoginRadius API Key &amp; Secret'; ?></a></li>
	<li><a href="http://community.loginradius.com/" target="_blank"><?php echo 'Discussion Forum'; ?></a></li>
	<li><a href="https://www.loginradius.com/Loginradius/About" target="_blank"><?php echo 'About LoginRadius'; ?></a></li>
    <li><a href="https://www.loginradius.com/product/product-overview" target="_blank"><?php echo 'LoginRadius Products'; ?></a>
	<li><a href="https://www.loginradius.com/addons" target="_blank"><?php echo 'Social Plugins'; ?></a></li>
	<li><a href="https://www.loginradius.com/sdks/loginradiussdk" target="_blank"><?php echo 'Social SDKs'; ?></a></li>
	<li><a href="https://www.loginradius.com/loginradius/Testimonials" target="_blank"><?php echo 'Testimonials'; ?></a></li>
</ul>
</div>
<div style="clear:both;"></div>
<div style="background:#EAF7FF; border: 1px solid #B3E2FF;  margin:0 0 10px 0; overflow:auto;font-family: sans-serif;">
	<h3 style="border-bottom:#000000 1px solid; margin:0px; padding:0 0 6px 0; border-bottom: 1px solid #B3E2FF; color: #000000; margin:10px;"><?php 
	echo 'Stay Updated'; ?></h3>
	<p align="justify" style="line-height: 19px;font-size:12px !important; margin:10px !important;">
<?php echo 'To receive updates on new features, releases, etc, please connect to one of our social media pages.'; ?> <br>
	<ul class="stay_ul">
  <li class="first">
    <iframe rel="tooltip" scrolling="no" frameborder="0" allowtransparency="true" style="border: none; overflow: hidden; width: 46px; height: 64px;" src="//www.facebook.com/plugins/like.php?app_id=194112853990900&amp;href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FLoginRadius%2F119745918110130&amp;send=false&amp;layout=box_count&amp;width=64&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=64" data-original-title="Like us on Facebook"></iframe>
  </li>
</ul>
	<div class="twitter_box"><span id="followers"></span></div>
<a href="https://twitter.com/LoginRadius" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false"></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>
<div style="clear:both;"></div>
<!-- Upgrade Box -->
<div style="background:#EAF7FF; border: 1px solid #B3E2FF; overflow:auto; margin:0 0 10px 0;font-family: sans-serif;">
<h3 style="border-bottom:#000000 1px solid; margin:0px; padding:0 0 6px 0; border-bottom: 1px solid #B3E2FF; color: #000000; margin:10px;"><?php echo 'Support Us'; ?></h3>
<p style="line-height: 19px; font-size:12px !important;margin:10px !important;">
<?php echo 'If you liked our FREE open-source plugin, please send your feedback/testimonial to <a href="mailto:feedback@loginradius.com"><span style="color: #0088CC;">feedback@loginradius.com</span></a>! '; ?> <br>
</div>
 </div>
</td>
  </tr>
</table>
</form>
<?php
	}
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
