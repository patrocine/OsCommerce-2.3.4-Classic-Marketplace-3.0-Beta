<?php
/*
  $Id: customers_points_credit.php, V2.1rc2a 2008/SEP/29 11:03:40 dsa_ Exp $
  created by Ben Zukrel, Deep Silver Accessories
  http://www.deep-silver.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

  include_once('includes/application_top.php');
  
  if ((USE_POINTS_SYSTEM == 'true') && (POINTS_AUTO_ON > 0)){
    $auto_credit_query = "select unique_id, customer_id, orders_id, date_added, points_pending, points_type from " . TABLE_CUSTOMERS_POINTS_PENDING . " where date_added <= (CURDATE() - '" . (int)POINTS_AUTO_ON . "') and points_status = 1 order by customer_id";
    $credit_rows = tep_db_query($auto_credit_query);
    
    echo '<p style="font-family: Tahoma, Arial, sans-serif; font-size: 12px;"><b>Points confirmed for the following rows...</b><br><br>For your convenience here is the cron command for your site:<br><br>php&nbsp; ' . $_SERVER["PATH_TRANSLATED"] . '<form><input name="print" type="button" value="Print this" onclick="window.print()"></form></p>';
      
    while($auto_credit = tep_db_fetch_array($credit_rows)){
	    
      if (tep_not_null(POINTS_AUTO_EXPIRES)){
        tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = customers_shopping_points + '" . $auto_credit['points_pending'] . "', customers_points_expires = DATE_ADD(NOW(),INTERVAL '" . POINTS_AUTO_EXPIRES . "' MONTH) where customers_id = '" . (int)$auto_credit['customer_id'] . "'");
      } else {
        tep_db_query("update " . TABLE_CUSTOMERS . " set customers_shopping_points = customers_shopping_points + '" . $auto_credit['points_pending'] . "' where customers_id = '" . (int)$auto_credit['customer_id'] . "'");
      }

      tep_db_query("update " . TABLE_CUSTOMERS_POINTS_PENDING . " set points_status = 2 where unique_id = '". (int)$auto_credit['unique_id'] ."'");
      
      $sql = "optimize table " . TABLE_CUSTOMERS_POINTS_PENDING . "";

      print $total_points_awarded = '<li style="font-family: Tahoma, Arial, sans-serif; font-size: 12px;">Customer id :' . (int)$auto_credit['customer_id'] .'&nbsp;&nbsp;Order id :' . (int)$auto_credit['orders_id'] .'&nbsp;&nbsp;Date :' . tep_date_short($auto_credit['date_added']) .'&nbsp;&nbsp;Total Points :' . number_format($auto_credit['points_pending'],POINTS_DECIMAL_PLACES) .'&nbsp;&nbsp;Points Type =' . $auto_credit['points_type'] .'</li>';
      $total_points_mail = $total_points_mail .= 'Customer id :' . (int)$auto_credit['customer_id'] .' Order id :' . (int)$auto_credit['orders_id'] .' Date :' . tep_date_short($auto_credit['date_added']) .' Total Points :' . number_format($auto_credit['points_pending'],POINTS_DECIMAL_PLACES) .' Points Type =' . $auto_credit['points_type']. "\n";
  
    }
    $points_subject = 'Points Auto confirmed.';
    $points_email = '<b>Points confirmed for the following rows...</b>'. "\n\n" . $total_points_mail;
    tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $points_subject, $points_email, STORE_OWNER,   STORE_OWNER_EMAIL_ADDRESS);
    echo 'Done!<br />You may close this window now. ';
  }
