<?php
/*
  $Id: mobile_checkout_new_address.php  2012-12-20 00:52:16Z raiwa $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if (!isset($process)) $process = false;
?>
<div id="abd">
<?php
  if (ACCOUNT_GENDER == 'true') {
		$gender_array[0] = array('id' => false,
					'text' => PULL_DOWN_DEFAULT);        
		$gender_array[1] = array('id' => 'm',
					'text' => MALE);
		$gender_array[2] = array('id' => 'f',
					'text' => FEMALE);        
?>
			<div class="form_line gender">
              <label for="gender" class="float"><?php echo ENTRY_GENDER; ?> *</label>
		<?php echo tep_draw_pull_down_menu('gender', $gender_array, ''); ?>
			</div><?php
  }
?>
		<label for="firstname" class="float"><?php echo ENTRY_FIRST_NAME; ?></label>
		<?php echo tep_draw_input_field('firstname', $account['customers_firstname']); ?>
		<br />
		<label for="lastname" class="float"><?php echo ENTRY_LAST_NAME; ?></label>
		<?php echo tep_draw_input_field('lastname', $account['customers_lastname']); ?>
		<br />
		<?php
		if (ACCOUNT_COMPANY == 'true') {
			?><div class="form_line">
			  <h1><?php echo CATEGORY_COMPANY; ?></h1>
			  <label for="company" class="float"><?php echo ENTRY_COMPANY; ?></label>
			  <?php echo tep_draw_input_field('company'); ?>
			  </div>
			  <?php
		}
		?>
			<div class="form_line">
			  <h1><?php echo CATEGORY_ADDRESS; ?></h1>
              <label for="street" class="float"><?php echo ENTRY_STREET_ADDRESS; ?> *</label>
			  <?php echo tep_draw_input_field('street_address'); ?>
			  </div>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>			<div class="form_line">
              <label for="suburb" class="float"><?php echo ENTRY_SUBURB; ?></label>
			  <?php echo tep_draw_input_field('suburb'); ?>
			</div>
<?php
  }
?>
			<div class="form_line">
              <label for="postcode" class="float"><?php echo ENTRY_POST_CODE; ?> *</label>
			  <?php echo tep_draw_input_field('postcode'); ?>
			</div>
			<div class="form_line">
			  <label for="city" class="float"><?php echo ENTRY_CITY; ?> *</label>
			  <?php echo tep_draw_input_field('city'); ?>
			</div>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
            <div class="form_line">  
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
?></div><?php
  }
?>
	<div class="form_line">
	<label for="country" class="float"><?php echo ENTRY_COUNTRY; ?> *</label>
	<?php echo tep_get_country_list('country', $country); ?>
	</div>
</div>
