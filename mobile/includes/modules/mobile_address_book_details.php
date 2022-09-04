<?php
/*
  $Id: address_book_details.php,v 1.10 2003/06/09 22:49:56 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  if (!isset($process)) $process = false;
?>
	<div id="abd">
<h1><?php echo NEW_ADDRESS_TITLE; ?></h1>
<div class="required"><?php echo FORM_REQUIRED_INFORMATION; ?></div>

<?php
	if (ACCOUNT_GENDER == 'true') {
		$male = $female = 'm';
		if (isset($gender)) {
			$selectedGender = ($gender == 'm') ? 'm' : 'f';
		} elseif (!empty($entry['entry_gender'])) {
			$selectedGender = ($entry['entry_gender'] == 'm') ? 'm' : 'f';
		} else {
			$selectedGender = '';
			}
		$gender_array[0] = array('id' => false,
					'text' => PULL_DOWN_DEFAULT);        
		$gender_array[1] = array('id' => 'm',
					'text' => MALE);
		$gender_array[2] = array('id' => 'f',
					'text' => FEMALE);        
		?>
		<label for="gender" class="float"><?php echo ENTRY_GENDER; ?></label>
		<?php echo tep_draw_pull_down_menu('gender', $gender_array, $selectedGender); ?>
		<br />
<?php
	}
?>
          <br />
		  <label for="firstname" class="float"><?php echo ENTRY_FIRST_NAME; ?></label>
		  <?php echo tep_draw_input_field('firstname', $entry['entry_firstname']) . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
		  <br />
		  <label for="lastname" class="float"><?php echo ENTRY_LAST_NAME; ?></label>
		  <?php echo tep_draw_input_field('lastname', $entry['entry_lastname']) . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
		  <br />
		  <?php
  if (ACCOUNT_COMPANY == 'true') {
?>
		  <label for="company" class="float"><?php echo ENTRY_COMPANY; ?></label>
		  <?php echo tep_draw_input_field('company', $entry['entry_company']) . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?>
<?php
  }
?>
          <br />
		  <label for="street" class="float"><?php echo ENTRY_STREET_ADDRESS; ?></label>
		  <?php echo tep_draw_input_field('street_address', $entry['entry_street_address']) . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
		  <br />
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
		  <label for="suburb" class="float"><?php echo ENTRY_SUBURB; ?></label>
		  <?php echo tep_draw_input_field('suburb', $entry['entry_suburb']) . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?>
<?php
  }
?>
          <br />
		  <label for="postcode" class="float"><?php echo ENTRY_POST_CODE; ?></label>
		  <?php echo tep_draw_input_field('postcode', $entry['entry_postcode']) . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
		  <br />
		  <label for="city" class="float"><?php echo ENTRY_CITY; ?></label>
		  <?php echo tep_draw_input_field('city', $entry['entry_city']) . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
		  <br />
<?php
  if (ACCOUNT_STATE == 'true') {
?>
          
		  <label for="state" class="float"><?php echo ENTRY_STATE; ?></label>
		  
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = tep_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo tep_draw_pull_down_menu('state', $zones_array);
      } else {
        echo tep_draw_input_field('state');
      }
    } else {
      echo tep_draw_input_field('state', tep_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'], $entry['entry_state']));
    }

    if (tep_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>';
?>

<?php
  }
?>
          <br />
		  <label for="country" class="float"><?php echo ENTRY_COUNTRY; ?></label>
		  <?php echo tep_get_country_list('country', $entry['entry_country_id']) . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
		  <br />
<?php
  if ((isset($HTTP_GET_VARS['edit']) && ($customer_default_address_id != $HTTP_GET_VARS['edit'])) || (isset($HTTP_GET_VARS['edit']) == false) ) {
?>
          
		  <?php echo tep_draw_checkbox_field('primary', 'on', false, 'id="primary"') . ' ' . SET_AS_PRIMARY; ?>
		  
<?php
  }
?>
</div>