<?php
/*
  $Id: affiliate_statistics.php,v 2.00 2003/10/12

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $affiliate_banner_history_raw = "select sum(affiliate_banners_shown) as count from " . TABLE_AFFILIATE_BANNERS_HISTORY .  " where affiliate_banners_affiliate_id  = '" .  $_GET['acID'] . "'";
  $affiliate_banner_history_query = tep_db_query($affiliate_banner_history_raw);
  $affiliate_banner_history = tep_db_fetch_array($affiliate_banner_history_query);
  $affiliate_impressions = $affiliate_banner_history['count'];
  if ($affiliate_impressions == 0) $affiliate_impressions = "n/a"; 
  
  $affiliate_query = tep_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id ='" . $_GET['acID'] . "'");
 
  $affiliate = tep_db_fetch_array($affiliate_query);
  $affiliate_percent = 0;
  $affiliate_percent = $affiliate['affiliate_commission_percent'];
  if ($affiliate_percent < AFFILIATE_PERCENT) $affiliate_percent = AFFILIATE_PERCENT;
  
  $affiliate_clickthroughs_raw = "select count(*) as count from " . TABLE_AFFILIATE_CLICKTHROUGHS . " where affiliate_id = '" . $_GET['acID'] . "'";
  $affiliate_clickthroughs_query = tep_db_query($affiliate_clickthroughs_raw);
  $affiliate_clickthroughs = tep_db_fetch_array($affiliate_clickthroughs_query);
  $affiliate_clickthroughs = $affiliate_clickthroughs['count'];

  $affiliate_sales_raw = "
    select count(*) as count, sum(affiliate_value) as total, sum(affiliate_payment) as payment from " . TABLE_AFFILIATE_SALES . " a 
    left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id=o.orders_id) 
    where a.affiliate_id = '" . $_GET['acID'] . "' and o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . "
    ";
  $affiliate_sales_query = tep_db_query($affiliate_sales_raw);
  $affiliate_sales = tep_db_fetch_array($affiliate_sales_query);

  $affiliate_transactions=$affiliate_sales['count'];
  if ($affiliate_clickthroughs > 0) {
	  $affiliate_conversions = tep_round(($affiliate_transactions / $affiliate_clickthroughs)*100,2) . "%";
  } else {
    $affiliate_conversions = "n/a";
  }

  if ($affiliate_sales['total'] > 0) {
    $affiliate_average = $affiliate_sales['total'] / $affiliate_sales['count'];
  } else {
    $affiliate_average = 0;
  }
require(DIR_WS_INCLUDES . 'template_top.php'); 
?>
   <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE, tep_get_all_get_params(array('action'))) . '">' . tep_draw_button(IMAGE_BACK) . '</a>'; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TEXT_SUMMARY_TITLE; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="4" cellspacing="2" class="dataTableContent">
              <center>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><strong><?php echo TEXT_AFFILIATE_NAME; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate['affiliate_firstname'] . ' ' . $affiliate['affiliate_lastname']; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_AFFILIATE_JOINDATE; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td width="15%" class="dataTableContent"><?php echo tep_date_short($affiliate['affiliate_date_account_created']); ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_IMPRESSIONS; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_impressions; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_VISITS; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_clickthroughs; ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_TRANSACTIONS; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_sales['count']; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_CONVERSION; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_conversions.' %';?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_AMOUNT; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $currencies->display_price($affiliate_sales['total'], ''); ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_AVERAGE; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $currencies->display_price($affiliate_average, ''); ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_COMMISSION_RATE; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_percent, ' %'; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><strong><?php echo TEXT_COMMISSION; ?></td>
                  <td width="15%" class="dataTableContent"><strong><?php echo $currencies->display_price($affiliate_sales['payment'], ''); ?></strong></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo tep_draw_separator(); ?></td>
                </tr>
                <tr>
                  <td align="left" class="dataTableContent" colspan="4"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_CLICKS, 'acID=' . $_GET['acID']) . '">' . tep_draw_button(IMAGE_CLICKTHROUGHS, 'clipboard', null,'primary') . '</a> <a href="' . tep_href_link(FILENAME_AFFILIATE_SALES, 'acID=' . $_GET['acID']) . '">' . tep_draw_button(IMAGE_SALES, 'cart',null, 'primary') . '</a>'; ?></td>
                </tr>
              </center>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>