<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  https://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
*/

  $validated = $_POST['validated'];
  $sql = "SELECT * FROM anti_robotreg WHERE session_id = '" . tep_session_id() . "' LIMIT 1";
  if ( !$result = tep_db_query($sql) ) {
    $error = true;
    $entry_antirobotreg_error = true;
    $text_antirobotreg_error = ERROR_VALIDATION_1;
  } else {
    $entry_antirobotreg_error = false;
    $anti_robot_row = tep_db_fetch_array($result);
    if ((( strtoupper($_POST['antirobotreg']) != $anti_robot_row['reg_key'] ) || ($anti_robot_row['reg_key'] == '') || (strlen($_POST['antirobotreg']) != ENTRY_VALIDATION_LENGTH)) && ($validated != CODE_CHECKED || strlen($validated) == 0)) {
      $error = true;
      $entry_antirobotreg_error = true;
      $text_antirobotreg_error = ERROR_VALIDATION_2;
    } else {
      $sql = "DELETE FROM anti_robotreg WHERE session_id = '" . tep_session_id() . "'";
      if ( !$result = tep_db_query($sql) ) {
        $error = true;
        $entry_antirobotreg_error = true;
        $text_antirobotreg_error = ERROR_VALIDATION_3;
      } else {
        $sql = "OPTIMIZE TABLE anti_robotreg";
        if ( !$result = tep_db_query($sql) ) {
          $error = true;
          $entry_antirobotreg_error = true;
          $text_antirobotreg_error = ERROR_VALIDATION_4;
        } else {
          $entry_antirobotreg_error = false;
		  if (str_replace(array('account_edit.php','account_password.php','account_pwa.php','ask_a_question.php','contact_us.php','create_account.php','password_forgotten.php','tell_a_friend.php'), '', $PHP_SELF) != $PHP_SELF) $validated = CODE_CHECKED;
        }
      }
    }
  }	
?>