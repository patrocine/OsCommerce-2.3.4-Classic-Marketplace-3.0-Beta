<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require_once('includes/application_top.php');
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');
//ini_set('display_startup_errors', 'On');
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>
<?php
  if ($messageStack->size('account') > 0) {
    echo $messageStack->output('account');
  }
  ?>
  
  <div style="float:right;>
  <?php
echo  tep_draw_button(HEADER_TITLE_MY_ACCOUNT, 'person', tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  ?>
  </div>
<fieldset id="users-profile-core">
	<legend>
		Link your account with another social account	</legend>
	<?php 
	
	$action = (isset($_GET['lruser_id']) ? $_GET['lruser_id'] : '');	
if (tep_not_null($action) && ($obj->IsAuthenticated != true)) {
		$check_social_provider_query = "SELECT * FROM " . TABLE_SOCIALLOGIN . " WHERE loginradiusid = '" . $_GET['lruser_id'] . "'";
	 $check_social_provider = tep_db_query($check_social_provider_query);
		$check_social=tep_db_fetch_array($check_social_provider);
		if($check_social){
		if($customer_social_provider!=$check_social['Provider']){
	   	tep_db_query("DELETE FROM " . TABLE_SOCIALLOGIN . " WHERE loginradiusid='" . $_GET['lruser_id'] . "' and customers_id='" . $customer_id . "'");
		?><table cellspacing="0" cellpadding="2" border="0" width="100%">
  <tr class="messageStackSuccess">
    <td class="messageStackSuccess"><img width="10" height="10" title="Success" alt="Success" src="images/icons/success.gif">&nbsp;Your account has been  remove successfully</td>
  </tr></table><?php
		}
		elseif($customer_social_provider==$check_social['Provider']){
			?><table cellspacing="0" cellpadding="2" border="0" width="100%">
  <tr class="messageStackError">
    <td class="messageStackError"><img width="10" height="10" title="Error" alt="Error" src="images/icons/error.gif">&nbsp;You cannot remove the Social ID through which you are already logged in </td>
  </tr></table><?php
  		}
	 }
}
	  elseif ($obj->IsAuthenticated == true ) {
$lrdata = sociallogin_getuser_data($userprofile);
$check_customer_query = "SELECT * FROM " . TABLE_SOCIALLOGIN . " WHERE customers_id = '" . $customer_id . "' and Provider='" . $lrdata['Provider'] . "'";
	 $check_customer = tep_db_query($check_customer_query);
	 $check_customer = tep_db_fetch_array($check_customer);
	   if(!$check_customer){
		$sql_sociallogin_data_array = array('customers_id' => $customer_id,
											'loginradiusid' => mysql_real_escape_string($lrdata['id']),						 					
											'customer_activity' => 'Y',
											'customer_socialpicture' => $lrdata['thumbnail'],
											'Provider' => $lrdata['Provider']
											);
		tep_db_perform(TABLE_SOCIALLOGIN, $sql_sociallogin_data_array);
		?><table cellspacing="0" cellpadding="2" border="0" width="100%">
  <tbody><tr class="messageStackSuccess">
    <td class="messageStackSuccess"><img width="10" height="10" title="Success" alt="Success" src="images/icons/success.gif">&nbsp;You have sucessfully added one more identity to your account.</td>
  </tr>
</tbody></table><?php
	   }
	 else {
		 ?><table cellspacing="0" cellpadding="2" border="0" width="100%">
  <tr class="messageStackError">
    <td class="messageStackError"><img width="10" height="10" title="Error" alt="Error" src="images/icons/error.gif">&nbsp;This account is already mapped with an account. please try with another account.</td>
  </tr></table><?php
		 }
	  }
 ?>
	    <div>
	       <div style="float:right;">
        <?php   $http = HTTP_SERVER;
	if(ENABLE_SSL != 'false'){
		$http = HTTPS_SERVER;
	}
	  $loc = urlencode($http. $_SERVER["REQUEST_URI"]);
      ?>
           <script src="http://hub.loginradius.com/include/js/LoginRadius.js" ></script> <script type="text/javascript"> var options={}; options.login=true; LoginRadius_SocialLogin.util.ready(function () { $ui = LoginRadius_SocialLogin.lr_login_settings;$ui.interfacesize = "small";$ui.apikey = "<?php echo $lrsetting['apikey'];?>";$ui.callback="<?php echo $loc;?>"; $ui.lrinterfacecontainer ="interfacecontainerdiv"; LoginRadius_SocialLogin.init(options); }); </script>
			   <div class="interfacecontainerdiv" id="interfacecontainerdiv"></div> 
            </div>
			<div style="float:left; width:270px;">
			   <div style="float:left; padding:5px;">
               <?php if(!empty($customer_picture)){?>
			   			   <img style="width:80px; height:auto;background: none repeat scroll 0 0 #FFFFFF; border: 1px solid #CCCCCC; display: block; margin: 2px 4px 4px 0; padding: 2px;" alt="Logintest" src="<?php echo $customer_picture;?>"><?php }?>
			   </div>
			   <div style="float:right;padding:5px; font-weight: bold; font-size: 20px;margin: 5px;">
			   <?php echo $customer_first_name;?>
			   </div>
			</div>
	      </div>
		  <div style="clear:both;"></div><br>
	  By adding another account, you can log in with the new account as well!<br>
	  <table>
	  <div style="width:580px;">
	  <ul class="AccountSetting-addprovider">
	  
	<?php
 	$check_social_customer_query = "SELECT * FROM " . TABLE_SOCIALLOGIN . " WHERE customers_id = '" . $customer_id . "'";
	 $check_social_customer = tep_db_query($check_social_customer_query);
	 while($check_social = tep_db_fetch_array($check_social_customer)){
?>	 
<tr><td><li style="list-style:none;"><span style="margin-right:5px;"> <?php echo tep_image(DIR_WS_IMAGES . 'mapping/'.$check_social['Provider'].'.png');?></span></td><td>
			 
			 <?php if($customer_social_provider==$check_social['Provider']){ echo '<span style="color:red;">Currently connected with </span>'. $customer_social_provider;}
	else { echo 'You can also use ' . $check_social['Provider'];}?></td><td>
	       
<a href="account_mapping.php?lruser_id=<?php echo $check_social['loginradiusid'];?>"><input class="buttondelete" type="button" value="remove" /></a>
						
            </li><br></td></tr>
			<?php }?>
		</ul>
	</div>
	</table>
</fieldset>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>