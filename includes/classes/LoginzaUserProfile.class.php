<?php
/**
 * Класс LoginzaUserProfile предназначен для генерации некоторых полей профиля пользователя сайта,
 * и создания пользователя на сайте osCommerce 
 * на основе полученного профиля от Loginza API (http://loginza.ru/api-overview).
 * 
 * При генерации используются несколько полей данных, что позволяет сгенерировать непереданные 
 * данные профиля, на основе имеющихся.
 * 
 * Например: Если в профиле пользователя не передано значение nickname, то это значение может быть
 * сгенерированно на основе email или full_name полей.
 * 
 * @version 1.0
 */
class LoginzaUserProfile {
	/**
	 * Профиль
	 *
	 * @var unknown_type
	 */
	private $profile;  
	
	/**
	 * Данные для транслита
	 *
	 * @var unknown_type
	 */
	private $translate = array(
	'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ж'=>'g', 'з'=>'z',
	'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p',
	'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'ы'=>'i', 'э'=>'e', 'А'=>'A',
	'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ж'=>'G', 'З'=>'Z', 'И'=>'I',
	'Й'=>'Y', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R',
	'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Ы'=>'I', 'Э'=>'E', 'ё'=>"yo", 'х'=>"h",
	'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh", 'щ'=>"shch", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
	'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH", 'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"",
	'Ю'=>"YU", 'Я'=>"YA"
	);
	
  public $exist_customer = true;
  public $customer_data = array();
  
	function __construct($profile) {
		$this->profile = $profile;

    if ( (isset($this->profile->email)) && (tep_validate_email($this->profile->email)) ) {
      $check_existEmail = tep_db_query("select customers_id, customers_firstname, customers_email_address, customers_default_address_id 
                                        from " . TABLE_CUSTOMERS . " 
                                        where customers_email_address = '" . $this->profile->email . "'" );
    	$check_customer = tep_db_fetch_array($check_existEmail);
    }
    $this->exist_customer = (bool)$check_customer; 
    if ( $this->exist_customer ) {
      $this->customer_data = $check_customer; 
    } else {
      $this->customer_data = array('first_name'           => ($this->profile->name->first_name ? $this->profile->name->first_name : ''),
                                   'last_name'            => ($this->profile->name->last_name  ? $this->profile->name->last_name  : ''),
                                   'email'                => ($this->profile->email            ? $this->profile->email            : ''),
                                   'customers_telephone'  => ($this->profile->phone->preferred ? $this->profile->phone->preferred  : ''),
                                   'customers_newsletter' => 1,   
                                   'password'             => tep_encrypt_password(uniqid()) );    
      $this->setCountries_id();
    }                             
                                        
	}

  private function setCountries_id(){
    if ( isset($this->profile->address->home->country) ) {
      $country_query = tep_db_query("select countries_id from " . TABLE_COUNTRIES . " where countries_iso_code_2 = '" . $this->profile->address->home->country . "'");  
      $country_array = tep_db_fetch_array($country_query);
      if ( isset($country_array['countries_id']) && is_numeric($country_array['countries_id']) ) {
        $this->customer_data['countries_id'] = $country_array['countries_id'];
      } else {
          $this->customer_data['countries_id'] = 0;
      }
    }
  }

  public function login() {
    if ( $this->exist_customer ) {
      $this->login_customer();
    } else {
      $this->create_customer();
    } 
  }

  private function create_customer() {
    global $language, $cart, $navigation, $customer_id, $customer_country_id;
    $customer_data = $this->customer_data;
    $FirstName           = $customer_data['first_name'];
    $LastName            = $customer_data['last_name'];
    $Email               = $customer_data['email'];
    $customers_telephone = $customer_data['customers_telephone'];
    $password            = $customer_data['password'];
    $customer_country_id = $customer_data['countries_id'];

    require (DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);
    
    $sql_data_array = array ('customers_firstname' => $FirstName, 
                             'customers_lastname' => $LastName, 
                             'customers_email_address' => $Email,
                             'customers_telephone' => $customers_telephone,                                  
    			                 	 'customers_newsletter' => 1, 
                             'customers_password' => $password );  
    tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);
  	$customer_id = tep_db_insert_id ();
  	$sql_data_array = array ('customers_id' => $customer_id, 
                             'entry_firstname' => $FirstName, 
                             'entry_lastname' => $LastName, 
                             'entry_country_id' => $customer_country_id );
  	tep_db_perform ( TABLE_ADDRESS_BOOK, $sql_data_array );
  	
  	$address_id = tep_db_insert_id ();
  	tep_db_query ( "update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . ( int ) $address_id . "' where customers_id = '" . ( int ) $customer_id . "'" );
  	tep_db_query ( "insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . ( int ) $customer_id . "', '0', now())" );
  	if (SESSION_RECREATE == 'True') {
  		tep_session_recreate ();
  	}  
  	$customer_first_name = $FirstName;
  	$customer_default_address_id = $address_id;
  	$customer_country_id = '0';
  	tep_session_register('customer_id');
  	tep_session_register('customer_default_address_id');
  	tep_session_register('customer_first_name');
    tep_session_register('customer_country_id');    	
  	$cart->restore_contents();    	      
  	$name = $FirstName . ' ' . $LastName;
  	

    $email_text = sprintf(EMAIL_GREET_NONE, $FirstName);
  	$email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;              
  	tep_mail($name, $Email, EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS); 
    
    if (sizeof($navigation->snapshot) > 0) {
      $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
      $navigation->clear_snapshot();
      tep_redirect($origin_href);
    } else {
      tep_redirect(tep_href_link(FILENAME_DEFAULT));
    }      
  }

  private function login_customer() {
  	global $cart, $navigation, $customer_id;
    $customer_data = $this->customer_data;
    $customer_id = $customer_data['customers_id'];
  	$customer_default_address_id = $customer_data['customers_default_address_id'];
  	$customer_first_name = $customer_data['customers_firstname'];
  	tep_session_register('customer_id');
  	tep_session_register('customer_default_address_id');
  	tep_session_register('customer_first_name');
  	
  	tep_db_query("update " . TABLE_CUSTOMERS_INFO . " 
                   set customers_info_date_of_last_logon = now(), 
                       customers_info_number_of_logons = customers_info_number_of_logons+1 
                   where customers_info_id = '" . (int)$customer_id . "'" );				
  	$cart->restore_contents ();				        
  	$name = $FirstName . ' ' . $LastName;
  
    if (sizeof($navigation->snapshot) > 0) {
      $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
      $navigation->clear_snapshot();
      tep_redirect($origin_href);
    } else {
      tep_redirect(tep_href_link(FILENAME_DEFAULT));
    }  
  }
	
	public function genNickname () {
		if ($this->profile->nickname) {
			return $this->profile->nickname;
		} elseif (!empty($this->profile->email) && preg_match('/^(.+)\@/i', $this->profile->email, $nickname)) {
			return $nickname[1];
		} elseif ( ($fullname = $this->genFullName()) ) {
			return $this->normalize($fullname, '.');
		}
		// шаблоны по которым выцепляем ник из identity
		$patterns = array(
			'([^\.]+)\.ya\.ru',
			'openid\.mail\.ru\/[^\/]+\/([^\/?]+)',
			'openid\.yandex\.ru\/([^\/?]+)',
			'([^\.]+)\.myopenid\.com'
		);
		foreach ($patterns as $pattern) {
			if (preg_match('/^https?\:\/\/'.$pattern.'/i', $this->profile->identity, $result)) {
				return $result[1];
			}
		}
		
		return false;
	}
	
	public function genUserSite () {
		if (!empty($this->profile->web->blog)) {
			return $this->profile->web->blog;
		} elseif (!empty($this->profile->web->default)) {
			return $this->profile->web->default;
		}
		
		return $this->profile->identity;
	}
	
	public function genDisplayName () {
	 	if ( ($fullname = $this->genFullName()) ) {
			return $fullname;
		} elseif ( ($nickname = $this->genNickname()) ) {
			return $nickname;
		}
		
		$identity_component = parse_url($this->profile->identity);
		
		$result = $identity_component['host'];
		if ($identity_component['path'] != '/') {
			$result .= $identity_component['path'];
		}
		
		return $result.$identity_component['query'];
		
	}
	
	public function genFullName () {
		if ($this->profile->name->full_name) {
			return $this->profile->name->full_name;
		} elseif ( $this->profile->name->first_name || $this->profile->name->last_name ) {
			return trim($this->profile->name->first_name.' '.$this->profile->name->last_name);
		}
		
		return false;
	}

	/**
	 * Транслит + убирает все лишние символы заменяя на символ $delimer
	 *
	 * @param unknown_type $string
	 * @param unknown_type $delimer
	 * @return unknown
	 */
	private function normalize ($string, $delimer='-') {
		$string = strtr($string, $this->translate);
	    return trim(preg_replace('/[^\w]+/i', $delimer, $string), $delimer);
	}
}

?>