<?php
if(!isset($language) && empty($language)){
	$language = 'english';
}
//require(DIR_WS_LANGUAGES . $language . '/' . 'socialloginandsocialshare.php');
$result = tep_db_query("select * FROM " . TABLE_LOGINRADIUS_SETTING . "");
 
while ($rrr = tep_db_fetch_array($result)){
	$setting[] = $rrr;
}
for($i=0;$i <sizeof($setting);$i++){
	$lrsetting[$setting[$i]['setting']] = $setting[$i]['value'];
}
/**
 * Function that remove tmp data of user.
 */
function remove_tmpuser($lrdata) {
	tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = '".$lrdata['session']."'");
}

	  
//get verification link on click of user
if(!empty($_GET['socialloginid']) and !empty($_GET['verificationcode'])){
	sociallogin_verification_link(mysql_real_escape_string(trim($_GET['socialloginid'])), mysql_real_escape_string(trim($_GET['verificationcode'])) );
}
tep_db_query("CREATE TABLE IF NOT EXISTS " . TABLE_SOCIALLOGIN . " (
  `customers_id` int(11) NOT NULL,
  `loginradiusid` varchar(64) NOT NULL,
  `customer_varification` varchar(25) NOT NULL,
  `customer_activity` varchar(1) NOT NULL,
  `customer_socialpicture` varchar(225) DEFAULT NULL,
  `Provider` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

// Starting loginradius login process.
$lrdata = array();
$obj = new LoginRadius();
$userprofile = $obj->loginradius_get_data($lrsetting['apisecret'], $lrsetting['useapi']);
if ($obj->IsAuthenticated == true ) {	
  //$process = true;
   $lrdata = sociallogin_getuser_data($userprofile);
   
   if(!tep_session_is_registered('customer_id')){
	 if (empty($lrdata['Email']) && $lrsetting['dummyemail'] == 1) {
	 $lrdata['Email'] = sociallogin_get_randomEmail($lrdata);
   }
 
 	 // Check if id exists
	  $check_customer_query = "SELECT * FROM " . TABLE_CUSTOMERS . " AS c INNER JOIN " . TABLE_SOCIALLOGIN . " AS s ON c.customers_id = s.customers_id WHERE s.loginradiusid = '" . $lrdata['id'] . "'";
	 $check_customer = tep_db_query($check_customer_query);
	 $check_customer = tep_db_fetch_array($check_customer);
	 
	  if ((!$check_customer || empty($check_customer)) && !empty($lrdata['Email'])) {	
	 // Check if email exists
		$check_customer_query = tep_db_query("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE customers_email_address = '" . $lrdata['Email'] . "'");
		$customers_id = tep_db_fetch_array($check_customer_query);
			if($customers_id){
				//enter data in sociallogin table if not is in
				if($lrsetting['linkaccount'] == '1'){
					$customer_id = $customers_id['customers_id'];
					$sql_sociallogin_data_array = array('customers_id' => $customer_id,
														'loginradiusid' => mysql_real_escape_string($lrdata['id']),						 					
														'customer_activity' => 'Y',
														'customer_socialpicture' => $lrdata['thumbnail'],
														'Provider' => $lrdata['Provider']
					);
				tep_db_perform(TABLE_SOCIALLOGIN, $sql_sociallogin_data_array);
				}
				sociallogin_logging_existUser($lrdata);
			}
		elseif(!$customers_id){
				if($lrsetting['allfields']=='1'){
					foreach($lrdata as $key => $value){
	    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description) values ('Store tmp data', '".$lrdata['session']."', '".mysql_real_escape_string($value)."', '".mysql_real_escape_string($key)."')");
	  }
					$popuptitle = $lrsetting['popupemailtitle'];
					$popupmessage = $lrsetting['popupfieldmessage'];
					$magtype = 'normal';					
					print sociallogin_popup($popuptitle, $popupmessage, $magtype, $lrdata);
				}
				else{
					$customers_id = sociallogin_add_newUser($lrdata);
					$sql_sociallogin_data_array = array('customers_id' => $customers_id,
														'loginradiusid' => mysql_real_escape_string($lrdata['id']),						 					
														'customer_activity' => 'Y',
														'customer_socialpicture' => $lrdata['thumbnail'],
														'Provider' => $lrdata['Provider']
					);
				tep_db_perform(TABLE_SOCIALLOGIN, $sql_sociallogin_data_array);
				sociallogin_mail($lrdata['Email'], $lrdata['password']);
				sociallogin_logging_existUser($lrdata);
				}
			}
		}	
	 elseif ($check_customer) {
	  if($check_customer['customer_activity'] == 'N'){
	 //not login and show popup
			$msg = 'Verifique su correo electrónico haciendo clic en el enlace de confirmación enviado a su email.';
			print sociallogin_message_popup($msg);		 			
	}		
	   elseif($check_customer['customer_activity'] == 'Y'){
	   		//$customers_id=$check_customer['customers_id'];
	   		sociallogin_logging_existUser($lrdata);
		}
	}			
	else{
		foreach($lrdata as $key => $value){
	    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description) values ('Store tmp data', '".$lrdata['session']."', '".mysql_real_escape_string($value)."', '".mysql_real_escape_string($key)."')");
	  }
		$popuptitle = $lrsetting['popupemailtitle'];
		$popupmessage = $lrsetting['popupfieldmessage'];
		$magtype = 'normal';
		print sociallogin_popup($popuptitle, $popupmessage, $magtype, $lrdata);       
	  }       
  }
}
elseif (isset($_POST['cancel'])) {
	 remove_tmpuser($lrdata);
	 tep_redirect('index.php');
 }
elseif (isset($_POST['LoginRadiusEmailClick']) && !empty($_POST['session'])){
	$lrdata['session'] = $_POST['session'];
	$query = tep_db_query("select configuration_title, configuration_key, configuration_value, configuration_description from " . TABLE_CONFIGURATION . " where configuration_key = '" . mysql_real_escape_string($_POST['session']) . "'");
			  while($tmp_data = tep_db_fetch_array($query)) {
				$key = $tmp_data['configuration_description'];
				$value = $tmp_data['configuration_value'];
				$lrdata[$key] = $value;
	          }
			 $msg = '';
			$lrerror = 'lrfielderror';
		if((isset($_POST['gender']) && empty($_POST['gender']))||
           (isset($_POST['FirstName']) && empty($_POST['FirstName']))||
           (isset($_POST['LastName']) && empty($_POST['LastName']))||
          (isset($_POST['dob']) && empty($_POST['dob']))||
           (isset($_POST['address']) && empty($_POST['address']))||
           (isset($_POST['email']) && empty($_POST['email']))||
           (isset($_POST['city']) && empty($_POST['city']))||
           (isset($_POST['state']) && empty($_POST['state']))||
           (isset($_POST['postcode']) && empty($_POST['postcode']))||
           (isset($_POST['telephone']) && empty($_POST['telephone'])))
           {echo $msg .= 'Rellene todos los campos<br>'; $lrerror .= 'lremptyerror ';}
		
	else{	
		  if (isset($_POST['address']) && strlen($_POST['address']) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
			$msg .= ENTRY_STREET_ADDRESS_ERROR . "<br>";
			$lrerror .= 'lraddresserror ';
			}
			if (isset($_POST['postcode']) && (strlen($_POST['postcode']) < ENTRY_POSTCODE_MIN_LENGTH)) {
			$msg .= ENTRY_POST_CODE_ERROR . "<br>";
			$lrerror .= 'lrcode_error ';
			}
   
      if (ACCOUNT_DOB == 'true'){
		if (isset($_POST['dob']) && !empty($_POST['dob'])) {
			  if ((is_numeric(tep_date_raw($_POST['dob'])) == false) || (@checkdate(substr(tep_date_raw($_POST['dob']), 4, 2), substr(tep_date_raw($_POST['dob']), 6, 2), substr(tep_date_raw($_POST['dob']), 0, 4)) == false)) {
				$msg .= ENTRY_DATE_OF_BIRTH_ERROR . "<br>";
				$lrerror .= 'lrdoberror ';
			  }
			}
          }
		  if (isset($_POST['city']) && (strlen($_POST['city']) < ENTRY_CITY_MIN_LENGTH)) {
			$msg .= ENTRY_CITY_ERROR . "<br>";
			$lrerror .= 'lrcityerror ';
		  }
		  if (isset($_POST['telephone']) && (strlen($_POST['telephone']) < ENTRY_TELEPHONE_MIN_LENGTH)) {
			$msg .= ENTRY_TELEPHONE_NUMBER_ERROR . "<br>";
			$lrerror .= 'lrtelephoneerror ';
		  }
		  if (isset($_POST['email'])) {
			if (strlen($_POST['email']) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
					$msg .= ENTRY_EMAIL_ADDRESS_ERROR . "<br>";
					$lrerror .= 'lremailerror ';
			} elseif (tep_validate_email($_POST['email']) == false) {
					$msg .= ENTRY_EMAIL_ADDRESS_CHECK_ERROR . "<br>";
					$lrerror .= 'lremailerror ';
			}
				else {					
	 $check_email_query = "select * from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($_POST['email']) . "'";
     $check_email = tep_db_query($check_email_query);	 
	  $customers_id = $check_email['customers_id'];
	  if($check_email['total'] > 0){
	 $check_sociallogin_id_query = "select * from " . TABLE_SOCIALLOGIN . " where customers_id = '" . $customers_id . "' and Provider = '" . $lrdata['Provider'] . "'";
     $check_sociallogin_id = tep_db_query($check_sociallogin_id_query);
	 	if ($check_sociallogin_id) {
		  $lrerror .= 'lremailerror ';
		  $msg .= ENTRY_EMAIL_ADDRESS_ERROR_EXISTS . "<br>";
					}
				}
  			}
	  } 
}

	 if($lrerror=='lrfielderror'){
	 // Check if email exists
	if(empty($lrdata['postcode'])){
		$lrdata['postcode'] = mysql_real_escape_string($_POST['postcode']);
	}
	if(empty($lrdata['Email'])){
		$lrdata['Email'] = mysql_real_escape_string($_POST['email']);
	}	
	if(empty($lrdata['FirstName'])){
		$lrdata['FirstName'] = mysql_real_escape_string($_POST['FirstName']);
	}
	if(empty($lrdata['LastName'])){
		$lrdata['LastName'] = mysql_real_escape_string($_POST['LastName']);
	}
                   if (ACCOUNT_GENDER == 'true') {
	if(empty($lrdata['gender'])){
		$lrdata['gender'] = mysql_real_escape_string($_POST['gender']);
 }
 
 }
 
       if (ACCOUNT_DOB == 'true') {
	if(empty($lrdata['dob'])){
		$lrdata['dob'] = mysql_real_escape_string($_POST['dob']);
	}
}
 
	if(empty($lrdata['address'])){
		$lrdata['address'] = mysql_real_escape_string($_POST['address']);
	}
	if(empty($lrdata['city']) || $lrdata['city'] =='unknown'){
		$lrdata['city'] = mysql_real_escape_string($_POST['city']);
	}
	if(empty($lrdata['state'])){
		$lrdata['state'] = mysql_real_escape_string($_POST['state']);
	}
	if(empty($lrdata['telephone'])){
		$lrdata['telephone'] = mysql_real_escape_string($_POST['telephone']);
	}
	if(empty($lrdata['country'])){
		$lrdata['country'] = mysql_real_escape_string($_POST['country']);
		
	}
}

	if(($lrsetting['allfields']==1)&&((empty($lrdata['postcode']))||
       (empty($lrdata['Email']))||
       (empty($lrdata['FirstName']))||
       (empty($lrdata['LastName']))||
     //  (empty($lrdata['gender']))||
     //  (empty($lrdata['dob']))||
       (empty($lrdata['address']))||
       (empty($lrdata['city']))||
       (empty($lrdata['state']))||
       (empty($lrdata['telephone'])))){$msg .= $lrsetting['popupfieldmessage']; $lrerror .= 'lrdeleteposterror123 ';}
	elseif(($lrsetting['dummyemail']==1)&&(empty($lrdata['Email']))){$msg .= $lrsetting['popupfieldmessage']; $lrerror .= 'lrdeleteposterror ';}
	if($lrerror != 'lrfielderror'){
		$popuptitle = $lrsetting['popupemailtitle'];
		$popupmessage = $msg;//$lrsetting['popuperroremailmessage'];
		$lrerror .= 'warning';
		print sociallogin_popup($popuptitle, $popupmessage, $lrerror, $lrdata);
		}
		
 else{
 	 //$loginRadiusId = $lrdata['id'];	 
	 if(!isset($_POST['email'])){
	 // Check if id exists
	 $check_customer_query = "SELECT * FROM " . TABLE_CUSTOMERS . " AS c INNER JOIN " . TABLE_SOCIALLOGIN . " AS s ON c.customers_id = s.customers_id WHERE s.loginradiusid = '" . $lrdata['id'] ."'";
	 $check_customer = tep_db_query($check_customer_query);
	 $check_customer=tep_db_fetch_array($check_customer);
	 
	 if (!$check_customer) {
	 // Check if email exists		    
		$check_customer_query = "SELECT * FROM " . TABLE_CUSTOMERS . "
					   WHERE customers_email_address = '" . $lrdata['Email'] . "'";

		$check_customer = tep_db_query($check_customer_query);
		$customers_id = $check_customer['customers_id'];
		
			if($customers_id){
				//enter data in sociallogin table if not is in
				if($lrsetting['linkaccount'] == '1'){
					  $sql_sociallogin_data_array = array('customers_id' => $customers_id,
														'loginradiusid' => mysql_real_escape_string($lrdata['id']),						 					
														'customer_activity' => 'Y',
														'customer_socialpicture' => $lrdata['thumbnail'],
														'Provider' => $lrdata['Provider']
					);
					tep_db_perform(TABLE_SOCIALLOGIN, $sql_sociallogin_data_array);
				}
			sociallogin_logging_existUser($lrdata);
		}
		else{
			$customers_id = sociallogin_add_newUser($lrdata);		
	$sql_sociallogin_data_array = array('customers_id' => $customers_id,
										'loginradiusid' => mysql_real_escape_string($lrdata['id']),						 					
										'customer_activity' => 'Y',
										'customer_socialpicture' => $lrdata['thumbnail'],
										'Provider' => $lrdata['Provider']
	);
	tep_db_perform(TABLE_SOCIALLOGIN, $sql_sociallogin_data_array);	
	sociallogin_mail($lrdata['Email'], $lrdata['password']);
	sociallogin_logging_existUser($lrdata);	
		}
	}

	elseif($check_customer){
		if($check_customer['customer_activity'] == 'N'){
	 //not login and show popup
			$msg = 'Verifique por favor su correo electrónico haciendo clic en el enlace de confirmación enviado a su email';
			print sociallogin_message_popup($msg);		
	}	
	   elseif($check_customer['customer_activity'] == 'Y') {		   
	   sociallogin_logging_existUser($lrdata);		   
	   }
  }    
}
else{//check email address not same email enter by user
  $check_customer_query = tep_db_query("SELECT * FROM " . TABLE_CUSTOMERS . " AS c INNER JOIN " . TABLE_SOCIALLOGIN . " AS s ON c.customers_id = s.customers_id WHERE s.Provider = '" . $lrdata['Provider'] . "' AND c.customers_email_address = '" . $lrdata['Email'] . "' AND s.customer_activity = 'Y'");
  $check_customer = tep_db_fetch_array($check_customer_query);
	// if email and sociallogin id enter in db show popup to enter defrant email 
  if($check_customer){			
		$popuptitle = $lrsetting['popupemailtitle'];
		$popupmessage = $lrsetting['popuperroremailmessage'];
		$lrerror = 'warning';
		print sociallogin_popup($popuptitle, $popupmessage, $lrerror, $lrdata);
  }
  
  else if(!$check_customer){
			$check_customer_query = tep_db_query("SELECT customers_id FROM " . TABLE_CUSTOMERS . " WHERE customers_email_address = '" . $lrdata['Email'] . "'");
			$check_customer = tep_db_fetch_array($check_customer_query);
			$customers_id = $check_customer['customers_id'];
			$lrdata['customer_varification'] = mt_rand();
			if($check_customer){
				$sql_sociallogin_data_array = array('customers_id' => $customers_id,
													'loginradiusid' => mysql_real_escape_string($lrdata['id']),						 					
													'customer_activity' => 'N',
													'customer_socialpicture' => $lrdata['thumbnail'],
													'customer_varification' => $lrdata['customer_varification'],
													'Provider' => $lrdata['Provider']
				);
				tep_db_perform(TABLE_SOCIALLOGIN, $sql_sociallogin_data_array);	
				$msg = 'Su enlace de confirmación ha sido enviado a su correo electrónico. Verifique por favor su correo electrónico haciendo clic en el enlace de confirmación.';
				print sociallogin_message_popup($msg);
				sociallogin_account_verification_mail($lrdata['Email'], mysql_real_escape_string($lrdata['id']), mysql_real_escape_string($lrdata['customer_varification']));
			}
	
			else if(!$check_customer){
				//fuction for enter userprofile data in zencart tables
				$customers_id = sociallogin_add_newUser($lrdata);
				$sql_sociallogin_data_array = array('customers_id' => $customers_id,
												'loginradiusid' => mysql_real_escape_string($lrdata['id']),						 					
												'customer_activity' => 'N',
												'customer_socialpicture' => $lrdata['thumbnail'],
												'customer_varification' => $lrdata['customer_varification'],
												'Provider' => $lrdata['Provider']
				);
				tep_db_perform(TABLE_SOCIALLOGIN, $sql_sociallogin_data_array);
				$msg = 'Su enlace de confirmación ha sido enviado a su correo electrónico. Verifique por favor su correo electrónico haciendo clic en el enlace de confirmación.';
				print sociallogin_message_popup($msg);
				sociallogin_account_verification_mail($lrdata['Email'], mysql_real_escape_string($lrdata['id']), mysql_real_escape_string($lrdata['customer_varification']));
				}
			}
		}
	}
}
 	
/**
 * Function that enter data in coustomer table.
 */
  function sociallogin_add_newUser($lrdata) {
    // Defining global variables. 
      global $cart, $navigation, $messageStack, $breadcrumb, $customer_zone_id, $confirm;
     // Checking all data set after click.
		  
	  // Getting default zone id.
      $zone_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'STORE_ZONE'");
      $zone_array = tep_db_fetch_array($zone_query);
      $zone_id = $zone_array['configuration_value'];
	  if (!empty($lrdata['FirstName']) && !empty($lrdata['LastName'])) {
       $lrdata['FirstName'] = $lrdata['FirstName'];
       $lrdata['LastName'] = $lrdata['LastName'];
     }
     elseif (!empty($lrdata['FullName'])) {
       $lrdata['FirstName'] = $lrdata['FullName'];
       $lrdata['LastName'] = $lrdata['FullName'];
     }
     elseif (!empty($lrdata['ProfileName'])) {
       $lrdata['FirstName'] = $lrdata['ProfileName'];
       $lrdata['LastName']  = $lrdata['ProfileName'];
     }
     elseif (!empty($lrdata['NickName'])) {
       $lrdata['FirstName'] = $lrdata['NickName'];
       $lrdata['LastName'] = $lrdata['NickName'];
     }
     elseif (!empty($email)) {
       $user_name = explode('@', $lrdata['Email']);
       $lrdata['FirstName']  = $user_name[0];
       $lrdata['LastName'] = str_replace("_", " ", $user_name[0]);
     }
     else {
       $lrdata['FirstName'] = $lrdata['id'];
       $lrdata['LastName'] = $lrdata['id'];
     }
      if (ACCOUNT_DOB == 'true'){
	 $lrdata['dob'] = date('Y-m-d', strtotime($lrdata['dob']));
                             }
  	 $sql_data_array = array('customers_gender' => $lrdata['gender'],							 
							 'customers_firstname' => $lrdata['FirstName'],
                              'customers_lastname' => $lrdata['LastName'],
							  'customers_dob' => $lrdata['dob'],						  
                              'customers_email_address' => $lrdata['Email'],
							  'customers_telephone' => $lrdata['telephone'],
							  'customers_newsletter' => (int)$newsletter,
							  'customers_default_address_id' => 0,
                              'customers_password' => tep_encrypt_password($lrdata['password'])
							  );
	 
      tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);
	  $customers_id = tep_db_insert_id();
	  if(empty($lrdata['country'])){
		  // Getting default country id.
		  $country_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'STORE_COUNTRY'");
		  $country_array = tep_db_fetch_array($country_query);
		  $lrdata['country'] = $country_array['configuration_value'];
	  }	
	  $sql_data_array = array('customers_id' => $customers_id,
							  'entry_gender' => $lrdata['gender'],
							  'entry_company' => $lrdata['company'],
							  'entry_firstname' => $lrdata['FirstName'],
                              'entry_lastname' => $lrdata['LastName'],
							  'entry_street_address' => $lrdata['address'],
							  'entry_postcode' =>  $lrdata['postcode'],                              
                              'entry_city' => $lrdata['city'],	
							  'entry_state' => $lrdata['state'],	
							  'entry_country_id' => $lrdata['country'],
							  'entry_zone_id' => $zone_id
							  );
							  							  
      tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
      $address_id = tep_db_insert_id();
	  
	  tep_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customers_id . "'");

	  $name = $lrdata['FirstName'] . ' ' . $lrdata['LastName'];
	  $email_text = sprintf(EMAIL_GREET_NONE, $lrdata['FirstName']);
      $email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
      tep_mail($name, $lrdata['Email'], EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
	  tep_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customers_id . "', '0', now())");
	  remove_tmpuser($lrdata);
	  
	return $customers_id;
  }




/**
 * Function that logging in exist user.
 */
  function sociallogin_logging_existUser($lrdata) {
    global $session_started, $lrsetting;
    // redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
    if ($session_started == false) {
      tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
    }
    // Defining global variables. 
      global $cart, $navigation, $messageStack, $breadcrumb, $customer_id, $customer_first_name,$customer_last_name, $customer_default_address_id, $customer_country_id, $customer_zone_id, $password, $confirm, $customer_picture, $customer_social_provider;
	  
	  //sql quire for fatch user profile data from data base
	  $check_customer_query = tep_db_query("SELECT * FROM " . TABLE_CUSTOMERS . " AS c INNER JOIN " . TABLE_SOCIALLOGIN . " AS s ON c.customers_id = s.customers_id WHERE s.loginradiusid = '" . $lrdata['id'] . "'");
      $check_customer = tep_db_fetch_array($check_customer_query);
	 	  
      $customer_id = $check_customer['customers_id'];
      $customer_default_address_id = $check_customer['customers_default_address_id'];
      $customer_first_name = $check_customer['customers_firstname'];
	  $customer_last_name = $check_customer['customers_lastname'];
	  $customer_picture = $check_customer['customer_socialpicture'];
	  $customer_country_id = $check_country['entry_country_id'];
      $customer_zone_id = $check_country['entry_zone_id'];
	  $customer_social_provider = $lrdata['Provider'];
      tep_session_register('customer_id');
      tep_session_register('customer_default_address_id');
      tep_session_register('customer_first_name');
	  tep_session_register('customer_last_name');
	  tep_session_register('customer_picture');
	  tep_session_register('customer_country_id');
      tep_session_register('customer_zone_id');
	  tep_session_register('customer_social_provider');
	  tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int)$customer_id . "'");
	  
	  // reset session token
        $sessiontoken = md5(tep_rand() . tep_rand() . tep_rand() . tep_rand());
		
		
      // restore cart contents
        $cart->restore_contents();
		if(!empty($lrsetting[redirect])){
			tep_redirect($lrsetting[redirect]);
			}
        elseif (sizeof($navigation->snapshot) > 0) {
          $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
          $navigation->clear_snapshot();
          tep_redirect($origin_href);
        } 
		else {
          tep_redirect(tep_href_link(FILENAME_DEFAULT));
        }
  }

	
/**
 * Function that generate a random mail.
 */
  function sociallogin_get_randomEmail($lrdata) {
    switch ($lrdata['Provider']) {
      case 'twitter':
        $lrdata['Email'] = $lrdata['id'] . '@' . $lrdata['Provider'] . '.com';
        break;
           
      case 'linkedin':
        $lrdata['Email'] = $lrdata['id'] . '@' . $lrdata['Provider'] . '.com';
        break;
           
      default:
        $Email_id = substr($lrdata['id'], 7);
        $Email_id2 = str_replace("/", "_", $Email_id);
        $lrdata['Email'] = str_replace(".", "_", $Email_id2) . '@' . $lrdata['Provider'] . '.com';
        break;
    }
    return $lrdata['Email'];
  }


  
/**
 * Function getting social user profile data.
 *
 * @param array $userprofile
 *   An array containing all userprofile data keys:
 *
 * @return array
 */
  function sociallogin_getuser_data($userprofile) {
    $lrdata['id'] = tep_db_prepare_input((!empty($userprofile->ID) ? $userprofile->ID : ''));
	$lrdata['session'] = uniqid('LoginRadius_', true);
	$lrdata['Provider'] = tep_db_prepare_input((!empty($userprofile->Provider) ? $userprofile->Provider : ''));
    $lrdata['FirstName'] = tep_db_prepare_input((!empty($userprofile->FirstName) ? $userprofile->FirstName : ''));
    $lrdata['LastName'] = tep_db_prepare_input((!empty($userprofile->LastName) ? $userprofile->LastName : ''));
	$lrdata['NickName'] = tep_db_prepare_input((!empty($userprofile->NickName) ? $userprofile->NickName : ''));
    $lrdata['FullName'] = tep_db_prepare_input((!empty($userprofile->FullName) ? $userprofile->FullName : ''));
    $lrdata['ProfileName'] = tep_db_prepare_input((!empty($userprofile->ProfileName) ? $userprofile->ProfileName : ''));
    
      if (ACCOUNT_DOB == 'true'){
    
    $lrdata['dob'] = tep_db_prepare_input((!empty($userprofile->BirthDate) ? $userprofile->BirthDate : ''));
                             }
    
    $lrdata['telephone'] = tep_db_prepare_input($userprofile->PhoneNumbers[0]->PhoneNumber);
       if (ACCOUNT_GENDER == 'true') {
    $lrdata['gender'] = tep_db_prepare_input((!empty($userprofile->Gender) ? $userprofile->Gender : ''));

   if($lrdata['gender']=='M' || $lrdata['gender']=='Male'){
   		$lrdata['gender'] = 'm';
   }
   elseif($lrdata['gender']=="F" || $lrdata['gender']=="female"){
   		$lrdata['gender'] = 'f';
   }
      }
   $lrdata['postcode']=tep_db_prepare_input((!empty($userprofile->postcode) ? $userprofile->postcode : '')); 
   
    $lrdata['city'] = tep_db_prepare_input((!empty($userprofile->City) ? $userprofile->City : ''));
    if (empty($lrdata['city'])) {
      $lrdata['city'] = tep_db_prepare_input((!empty($userprofile->HomeTown) ? $userprofile->HomeTown : ''));
    }
    $lrdata['state'] = tep_db_prepare_input((!empty($userprofile->State) ? $userprofile->State : ''));
    $lrdata['address'] = tep_db_prepare_input((!empty($userprofile->MainAddress) ? $userprofile->MainAddress : ''));
    $lrdata['company'] = tep_db_prepare_input($userprofile->Positions[0]->Comapny->Name);
	if (empty($lrdata['company'])) {
      $lrdata['company'] = tep_db_prepare_input((!empty($userprofile->Industry) ? $userprofile->Industry : ''));
    }
    $lrdata['password'] = mt_rand();
    $lrdata['Email'] = tep_db_prepare_input((sizeof($userprofile->Email) > 0 ? $userprofile->Email[0]->Value : ''));
    $lrdata['thumbnail'] = (!empty($userprofile->ThumbnailImageUrl) ? trim($userprofile->ThumbnailImageUrl) : '');
    if (empty($lrdata['thumbnail']) && $lrdata['provider'] == 'facebook') {
      $lrdata['thumbnail'] = "http://graph.facebook.com/" . $lrdata['id'] . "/picture?type=square";
    }
	if(ENABLE_SSL == 'true'){
		$lrdata['thumbnail'] = str_replace ( "http://" , "https://", $lrdata['thumbnail'] );
		if (!curl_init($lrdata['thumbnail'])) {
		$lrdata['thumbnail'];
		}
    elseif(ENABLE_SSL == 'false') {
		}
	}
    return $lrdata;
   }



/**
 * fuction for sent a mail when popup show to user
 */
 
function sociallogin_mail($Email, $pass){
			$subject = "[" . STORE_NAME ."] Your Email ID and password";
			//$url_address =  (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
			$txt = "\nEmail =" . $Email ." \nPassword=" . $pass . "\nClick on following link or paste it in browser to login.\n" . tep_href_link(FILENAME_LOGIN, '', 'SSL');
			mail($Email,$subject,$txt);
			return;
		}


/**
 * function for send varification link 
 */
 
function sociallogin_account_verification_mail($Email, $sociallogin_id, $verification_code){
			$subject = "[" . STORE_NAME ."] Email Verification";
			$url_address =  (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
			 $txt = 'Por favor, haz clic en el siguiente enlace o pegalo en el navegador para verificar su correo electrónico';
			$txt .= "\n" . $url_address . "index.php?socialloginid=" . $sociallogin_id . "&verificationcode=" . $verification_code . "";
			mail($Email,$subject,$txt);
			return;
	}


/**
 * function for get varification
 */

 function sociallogin_verification_link($first, $second){
  
	$Verify_sociallogin_customers_query = tep_db_query("SELECT *	FROM " . TABLE_SOCIALLOGIN . " WHERE loginradiusid = '" . $first . "' and customer_varification = '" . $second . "' and customer_activity = 'N'");
	$Verify_sociallogin_customers_array = tep_db_fetch_array($Verify_sociallogin_customers_query);
      $customer_check = $Verify_sociallogin_customers_array['customers_id'];
	  $Provider_check = $Verify_sociallogin_customers_array['Provider'];

     
	if(!empty($customer_check) && !empty($Provider_check)){ 
	$check_number_row_selected_query = tep_db_query("SELECT * FROM " . TABLE_SOCIALLOGIN . "	WHERE customers_id = '" . $customer_check ."' AND Provider = '" . $Provider_check ."' and customer_activity = 'Y'");
	$check_number_row_selected = tep_db_num_rows($check_number_row_selected_query);
			 									 
	if($check_number_row_selected < 1){

		$verify_user_query = tep_db_query("update " . TABLE_SOCIALLOGIN . " set customer_activity = 'Y', customer_varification = '' where loginradiusid = '" . $first . "' and customer_varification = '" . $second .  "'");

		$msg = "Tu mensaje ha sido verificado con éxito. Ahora puede acceder a su cuenta.";

        print sociallogin_message_popup($msg);
			

		  }

		}

	}



/**
 * Open a popup for Display message.
 */

function sociallogin_message_popup($msg){?>
<style type="text/css">
/* CSS Document */
.LoginRadius_overlay {
  background: none no-repeat scroll 0 0 rgba(127, 127, 127, 0.6);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 100001;
  width: 100%;
  height: 100%;
  overflow: auto;
  padding: 200px 20px 20px 20px;
  padding-bottom: 130px;
  position: fixed;
}

#popupouter{
  -moz-border-radius:4px;
  -webkit-border-radius:4px;
  border-radius:4px;
  overflow:auto;
  background:#f3f3f3;
  padding:0px 0px 0px 0px;
  width:370px;
  margin:0 auto;
}

#outerp {
  font-size: 17px;
  line-height: 1.1em !important;
  margin: 9px !important;
  text-align: center !important;
}

#popupinner{
  -moz-border-radius:4px;
  -webkit-border-radius:4px;
  border-radius:4px;
  overflow:auto;
  background:#ffffff;
  margin:10px;
  padding:10px 8px 4px 8px;
  border-top: 1px solid #ccc;
}

#textmatter{
  margin:10px 0px 10px 0px;
  font-family:Arial, Helvetica, sans-serif;
  color:#666666;
  border-radius: 5px 5px 5px 5px;
  color: #222222;
  font-size: 12px;
  padding: 10px;
  text-align: justify;
}

#innerp {
  font-size: 13px;
  font-weight: bold;
  line-height: 1em !important;
  margin-bottom: 0;
  margin-left: 10px;
  padding: 0;
  text-align: left !important;
}
.inputtxt{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:11px;
	border:#e5e5e5 1px solid;
	width:390px;!important;
	height:27px;
	margin:5px 0px 15px 0px;
}
.inputtxterror{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:11px;
	border:#FF0000 1px solid;
	width:390px;!important;
	height:27px;
	margin:5px 0px 15px 0px;
}
.inputbutton{
	border: 1px solid #1d6dc1;
	border-radius:4px;
	font-size:14px;
	text-shadow: 0 -1px 0 #1d6dc1;
	color: #fff;
	border: 1px solid #1d6dc1;
	background: #7abcff;
	background: -moz-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgba(122,188,255,1)),color-stop(44%,rgba(96,171,248,1)),color-stop(100%,rgba(64,150,238,1)));
	background: -webkit-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	background: -o-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	background: -ms-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7abcff',endColorstr='#4096ee',GradientType=0);
	background: linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	padding: 5px 21px;
}
.inputbutton:hover{
	border-radius:4px;
	padding: 5px 21px;
	color: #fff;
	text-shadow: 0 1px 0 #1d6dc1;
	border: 1px solid #1d6dc1;
	background: #9bcdff;
	background: -moz-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgba(155,205,255,1)),color-stop(44%,rgba(134,192,250,1)),color-stop(100%,rgba(110,176,242,1)));
	background: -webkit-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: -o-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: -ms-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#9bcdff',endColorstr='#6eb0f2',GradientType=0);
}
#textdivpopup{
	text-align:right;
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#000000;
	margin-left:216px;
}
.spanpopup{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#00ccff;
}
.span1{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#333333;
}
#errormassages{
color:#FF0000;
font-size:8px;
margin-left:5px;
}
<!--[if IE]>
.LoginRadius_content_IE
{
background:black;
-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
filter: alpha(opacity=90);
}
<![endif]-->


</style>
	
	<?php
		$output = '<div class = "LoginRadius_overlay LoginRadius_content_IE"><div id ="popupouter">';
		$output .= '<div id="popupinner"><div id="textmatter">';
		$output .= "<b>" . $msg . "</b><br>";
		$output .= '<center><form method="post" action="index.php"><input type="submit" value="OK" class="inputbutton" name = "OK"/></center>';
		$output .= '</div></form></div></div></div>';
		return $output;}


/**
 * Function that remove tmp data of user.
 */
function sociallogin_popup($popuptitle, $popupmessage, $lrerror, $lrdata){
	global $lrsetting;
	?>
<style type="text/css">
/* CSS Document */
.LoginRadius_overlay {
	background: none no-repeat scroll 0 0 rgba(127, 127, 127, 0.6);
	position: absolute;
	top: 0;
	left: 0;
	z-index: 100001;
	width: 100%;
	height: 100%;
	overflow: auto;
	padding: 120px 20px 20px 20px;
	padding-bottom: 130px;
	position: fixed;
}

#popupouter{
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	overflow:auto;
	background:#f3f3f3;
	padding:0px 0px 0px 0px;
	width:570px;
	margin:0 auto;
}

#outerp {
	font-size: 17px;
	line-height: 1.1em !important;
	margin: 9px !important;
	text-align: center !important;
}

#popupinner{
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border-radius:4px;
	overflow:auto;
	background:#ffffff;
	margin:10px;
	padding:10px 8px 4px 8px;
	border-top: 1px solid #ccc;
}

#textmatter{
	margin:10px 0px 10px 0px;
	font-family:Arial, Helvetica, sans-serif;
	color:#666666;
	border-radius: 5px 5px 5px 5px;
	color: #222222;
	font-size: 12px;
	padding: 10px;
	text-align: justify;
}

#innerp {
	font-size: 13px;
	font-weight: bold;
	line-height: 1em !important;
	margin-bottom: 0;
	margin-left: 10px;
	padding: 0;
	text-align: left !important;
}
.inputtxt{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:11px;
	border:#e5e5e5 1px solid;
	width:380px;!important;
	height:27px;
	margin:5px 0px 15px 0px;
}
.inputtxterror{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:11px;
	border:#FF0000 1px solid;
	width:380px;!important;
	height:27px;
	margin:5px 0px 15px 0px;
}
.inputbutton{
	border: 1px solid #1d6dc1;
	border-radius:4px;
	font-size:18px;
	text-shadow: 0 -1px 0 #1d6dc1;
	color: #fff;
	border: 1px solid #1d6dc1;
	background: #7abcff;
	background: -moz-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgba(122,188,255,1)),color-stop(44%,rgba(96,171,248,1)),color-stop(100%,rgba(64,150,238,1)));
	background: -webkit-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	background: -o-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	background: -ms-linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7abcff',endColorstr='#4096ee',GradientType=0);
	background: linear-gradient(top,rgba(122,188,255,1) 0,rgba(96,171,248,1) 44%,rgba(64,150,238,1) 100%);
	padding: 5px 21px;
}
.inputbutton:hover{
	border-radius:4px;
	padding: 5px 21px;
	color: #fff;
	text-shadow: 0 1px 0 #1d6dc1;
	border: 1px solid #1d6dc1;
	background: #9bcdff;
	background: -moz-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgba(155,205,255,1)),color-stop(44%,rgba(134,192,250,1)),color-stop(100%,rgba(110,176,242,1)));
	background: -webkit-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: -o-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: -ms-linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	background: linear-gradient(top,rgba(155,205,255,1) 0,rgba(134,192,250,1) 44%,rgba(110,176,242,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#9bcdff',endColorstr='#6eb0f2',GradientType=0);
}
#textdivpopup{
	text-align:right;
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#000000;
	margin-left:216px;
}
.spanpopup{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#00ccff;
}
.span1{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#333333;
}
#errormassages{
	color:#FF0000;
	font-size:8px;
	margin-left:5px;
}
<!--[if IE]>

.LoginRadius_content_IE
{
	background:black;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
	filter: alpha(opacity=90);
}
<![endif]-->

</style>

<script>
function validateForm()
{
	if(!loginRadiusPopupSubmit){
		return true;
	}
	var loginRadiusForm = document.getElementById('loginRadiusForm');
		var loginRadiusErrorDiv = document.getElementById('textmatter');
		for(var i = 0; i < loginRadiusForm.elements.length; i++){
			//alert(loginRadiusForm.elements[i].value.trim());
			if(loginRadiusForm.elements[i].value.trim() == ""){
				loginRadiusErrorDiv.innerHTML = "<b>Rellene todos los campos</b>";
				loginRadiusErrorDiv.style.backgroundColor = "#f6d9d0";
				loginRadiusErrorDiv.style.border = "1px solid #990000";
				
				return false;
			}
			
			if(loginRadiusForm.elements[i].name == "email"){
				var email = loginRadiusForm.elements[i].value.trim();
				var atPosition = email.indexOf("@");
				var dotPosition = email.lastIndexOf(".");
				if(atPosition < 1 || dotPosition < atPosition+2 || dotPosition+2>=email.length){
					loginRadiusErrorDiv.innerHTML = "<b>Por favor, introduzca una dirección e-mail válida</b>";
					loginRadiusErrorDiv.style.backgroundColor = "#f6d9d0";
					loginRadiusErrorDiv.style.border = "1px solid #990000";
					
					return false;
				}
			}
		}
		return true;
	}
</script>
<?php

   $output = '<div class = "LoginRadius_overlay LoginRadius_content_IE"><div id ="popupouter">';
   $popuptitle = str_replace('%s', $lrdata['Provider'] , $popuptitle);
   $output .='<div id="outerp"><center>' . $popuptitle . '</center></div><div id="popupinner">';
   $popupmessage = str_replace('%s', $lrdata['Provider'] , $popupmessage);
   if (strpos($lrerror, 'warning')) { 
   	$style = 'background-color: #f6d9d0; border: 1px solid #990000;';
   }
   else{
   	$style = 'background-color: #e1eabc; border: 1px solid #90b203;';
   }	   
   $output .= '<div id="textmatter" style="'.$style.'">';
   $output .= "<b>" . $popupmessage . "</b>";
   $output .= '</div><form id="loginRadiusForm" onsubmit="return validateForm();" method="post" action=""><div align="right"><span style="padding-right:30px" class="inputRequirement">* Requiere de Información</span></div><div ';
   if($lrsetting['allfields'] != '0'){
   $output .= 'style="height: 300px;overflow-y: scroll;"';
   }
   $output .= '><table>';
   if($lrsetting['allfields'] != '0'){

    if (ACCOUNT_GENDER == 'true') {
   if(empty($lrdata['gender'])){
    $output .= '<tr><td><b id="textmatter">Gender<span id="errormassages">*</span></b></td><td><input name="gender" type="radio" checked="chacked" value="m"><b id="textmatter">Male</b><input name="gender" type="radio" value="f"><b id="textmatter">Female</b></td></tr>';
   }
}
   if(empty($lrdata['FirstName'])){
   $output .= '<tr><td><b id="textmatter">First Name<span id="errormassages">*</span></b></td><td><input type="text" name="FirstName" id="FirstName" value="'.(isset($_POST['FirstName'])?htmlspecialchars($_POST['FirstName']):'').'"'; 
    if(strpos($lrerror, "lrfirstnameerror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= '/></td></tr>';
   }
   if(empty($lrdata['LastName'])){
   $output .= '<tr><td><b id="textmatter">Last Name<span id="errormassages">*</span></b></td><td><input type="text" name="LastName" id="LastName" value="'.(isset($_POST['LastName'])?htmlspecialchars($_POST['LastName']):'').'"'; 
    if(strpos($lrerror, "lrlastnameerror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= '/></td></tr>';
   }
   
    if (ACCOUNT_DOB == 'true'){
   
   if(empty($lrdata['dob'])){
   $output .= '<tr><td><b id="textmatter">Date of Birth<span id="errormassages">*</span></b></td><td><input type="text" name="dob" id="dob" value="'.(isset($_POST['dob'])?htmlspecialchars($_POST['dob']):'') . '"'; 
    if(strpos($lrerror, "lrdoberror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= 'style="margin:0;"/><br><span id="errormassages"><br />Eg. (mm/dd/yyyy)</span></td></tr>';
   }
   
    }
   
   

   if(empty($lrdata['Email'])){
   $output .= '<tr><td><b id="textmatter">Email<span id="errormassages">*</span></b></td><td><input type="text" name="email" value="'.(isset($_POST['email'])?htmlspecialchars($_POST['email']):'').'"'; 
    if(strpos($lrerror, "lremailerror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= 'style="margin:0;"/><span id="errormassages"><br />Ex: example@example.com</span></td></tr>';
   }
   
   
   
   if(empty($lrdata['address'])){
   $output .= '<tr><td><b id="textmatter">Street Address<span id="errormassages">*</span></b></td><td><input type="text" name="address" id="address" value="'.(isset($_POST['address'])?htmlspecialchars($_POST['address']):'').'"';
    if(strpos($lrerror, "lraddresserror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= '/></td></tr>';
   }
  }


   
   
   if($lrsetting['allfields'] != 0){
   if(empty($lrdata['city']) || $lrdata['city'] =='unknown'){
   $output .= '<tr><td><b id="textmatter">City<span id="errormassages">*</span></b></td><td><input type="text" name="city" value="'.(isset($_POST['city'])?htmlspecialchars($_POST['city']):'').'"'; 
    if(strpos($lrerror, "lrcityerror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= '/></td></tr>';
   }
   if(empty($lrdata['state'])){
   $output .= '<tr><td><b id="textmatter">Provincia: <span id="errormassages">*</span></b></td><td><input type="text" name="state" value="'.(isset($_POST['state'])?htmlspecialchars($_POST['state']):'').'"';
    if(strpos($lrerror, "lrstateerror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= '/></td></tr>';
   }
   if(empty($lrdata['country'])){
	   
   $output .= '<tr><td><b id="textmatter">País: <span id="errormassages">*</span></b></td><td>';
		$countries_query = tep_db_query("SELECT * FROM " . TABLE_COUNTRIES);
		while ($country = tep_db_fetch_array($countries_query)) {
			$countries[] = $country;
		}
      ?>
      <?php 
	  		for($i=0;$i <sizeof($countries);$i++){
				$country[$countries[$i]['countries_id']] =$countries[$i]['countries_name'];
			}
  		$lrcountry = (isset($_POST['country']) ? htmlspecialchars($_POST['country']):'');
      $output .= '<select id="country" name="country"';
		if(strpos($lrerror , "lrcountryerror")){
			$output .= 'class="inputtxterror"';
		}
		else{
			$output .= 'class="inputtxt"';
		}
		$output .= '><option value="" selected="selected">---Seleccionar País---</option>';
         foreach ($country as $countries_id => $countries_name) {
        $output .= '<option ';
		if ($countries_id == $lrcountry) {
			$output .= " selected=\"selected\"";
		} 
			$output .= 'value="' . $countries_id . '"> ' . $countries_name;
		   $output .= '</option>';
       }	
    $output .= '</select></td></tr>';
   }   
   
   if(empty($lrdata['postcode'])){
   $output .= '<tr><td><b id="textmatter">Post/Zip Code<span id="errormassages">*</span></b></td><td><input type="text" name="postcode" value="'.(isset($_POST['postcode'])?htmlspecialchars($_POST['postcode']):'').'"'; 

    if(strpos($lrerror , "lrcode_error")){
      $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
   
	$output .= '/></td></tr>';
   }
   if(empty($lrdata['telephone'])){
   $output .= '<tr><td><b id="textmatter">Telephone<span id="errormassages">*</span></b></td><td><input type="text" name="telephone" value="'.(isset($_POST['telephone'])?htmlspecialchars($_POST['telephone']):'').'"'; 
    if(strpos($lrerror, "lrtelephoneerror") && strpos($lrerror, 'warning')){
   $output .= 'class="inputtxterror"';
   }
   else{
   	$output .= 'class="inputtxt"';
   }
	$output .= '/></td></tr>';
   }
  }
   $output .= '</table></div><div>'; 
   $output .= '<center><input type="submit"  name="LoginRadiusEmailClick" value="Entrar" class="inputbutton" onClick="loginRadiusPopupSubmit = true"/>';
   $output .= '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Cancelar" class="inputbutton" name="cancel" onClick="loginRadiusPopupSubmit = false"/><input type="hidden" value="'.$lrdata['session'].'" name="session" id="session" /></center>';
   $output .= '</div></form></div></div></div>';
   return $output;
   }
   
class LoginRadius {
  public $IsAuthenticated, $JsonResponse, $UserProfile, $IsAuth, $UserAuth;
  public function loginradius_get_data($ApiSecrete, $useapi) {
    $IsAuthenticated = false;
	if($useapi == '1'){
		$useapi = "CURL";
	}
	
	if (isset($_REQUEST['token'])) {
      $ValidateUrl = "https://hub.loginradius.com/userprofile/".$ApiSecrete."/".$_REQUEST['token']."";
	  $JsonResponse = $this->loginradius_call_api($ValidateUrl, $useapi);
      $UserProfile = json_decode($JsonResponse);
      if (isset($UserProfile->ID) && $UserProfile->ID != ''){ 
        $this->IsAuthenticated = true;
		return $UserProfile;
      }
    }
  }
  
 public function loginradius_call_api($ValidateUrl, $useapi) {
    if ($useapi == 'CURL') {
	    $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $ValidateUrl);
          curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5);
		  curl_setopt($curl_handle, CURLOPT_TIMEOUT, 5);
          curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        if (ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' or !ini_get('safe_mode'))) 
		  {
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
          }
        else 
		  {
            curl_setopt($curl_handle,CURLOPT_HEADER, 1);
            $url = curl_getinfo($curl_handle,CURLINFO_EFFECTIVE_URL);
            curl_close($curl_handle);
            $curl_handle = curl_init();
            $url = str_replace('?','/?',$url);
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
         }
		 $JsonResponse = curl_exec($curl_handle);
		 $httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
			 if(in_array($httpCode, array(400, 401, 403, 404, 500, 503)) && $httpCode != 200)
			 {
				return '<div id="Error">Uh oh, looks like something went wrong. Try again in a sec!</div>';
			 }
			 else
			 {
				if(curl_errno($curl_handle) == 28)
				{
					return '<div id="Error">Uh oh, looks like something went wrong. Try again in a sec!</div>';
				}
			 }			 
     }
	 else {
        $JsonResponse = @file_get_contents($ValidateUrl);
		if(strpos(@$http_response_header[0], "400") !== false || strpos(@$http_response_header[0], "401") !== false || strpos(@$http_response_header[0], "403") !== false || strpos(@$http_response_header[0], "404") !== false || strpos(@$http_response_header[0], "500") !== false || strpos(@$http_response_header[0], "503") !== false)
		 {
				return '<div id="Error">Uh oh, looks like something went wrong. Try again in a sec!</div>';
		 }
        }
	 return $JsonResponse;
  }}
?>
