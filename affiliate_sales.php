<?php
/*
  $Id: osCAffiliate 20-Nov-2014
  OSC-Affiliate for osCommerce 2.3xx family
  Contribution based on: http://addons.oscommerce.com/info/158
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 - 2014 osCommerce
  Released under the GNU General Public License
  Updated by Fimble (http://forums.oscommerce.com/user/15542-fimble/)
  http://www.linuxuk.co.uk
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('affiliate_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_AFFILIATE, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_SALES);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'));

  $affiliate_sales_raw = "
    select  a.*, o.orders_status as orders_status_id, os.orders_status_name as orders_status from " . TABLE_AFFILIATE_SALES . " a 
    left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id = o.orders_id) 
    left join " . TABLE_ORDERS_STATUS . " os on (o.orders_status = os.orders_status_id and language_id = '" . (int)$languages_id . "') 
    where a.affiliate_id = '" . $affiliate_id . "'	 
    order by affiliate_date DESC
    ";

  $affiliate_sales_split = new splitPageResults($affiliate_sales_raw, MAX_DISPLAY_SEARCH_RESULTS);
    require(DIR_WS_INCLUDES . 'template_top.php'); 
?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td align="right"><?php echo tep_image(DIR_WS_IMAGES . 'affiliate_sales.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="4">
          <tr>
            <td class="main" colspan="5"><?php echo TEXT_AFFILIATE_HEADER . ' <strong>' . tep_db_num_rows(tep_db_query($affiliate_sales_raw)); ?></strong></td>
          </tr>
          <tr>
            <td colspan="5"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="infoBoxHeading" align="center"><?php echo TABLE_HEADING_DATE; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_DATE_HELP;?>">[-?-]</a></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_VALUE; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_SALE_VALUE_HELP;?>">[-?-]</a></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_PERCENTAGE; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_COMMISSION_RATE_HELP;?>">[-?-]</a></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_SALES; ?>&nbsp;<a class="hastip"  title="<?php echo TABLE_HEADING_SALES;?>">[-?-]</a></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_STATUS; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_STATUS_HELP;?>">[-?-]</a></td>
          </tr>
<?php
  if ($affiliate_sales_split->number_of_rows > 0) {
    $affiliate_sales_values = tep_db_query($affiliate_sales_split->sql_query);
    $number_of_sales = 0;
    $sum_of_earnings = 0;
    while ($affiliate_sales = tep_db_fetch_array($affiliate_sales_values)) {
      $number_of_sales++;
      if ($affiliate_sales['orders_status_id'] >= AFFILIATE_PAYMENT_ORDER_MIN_STATUS) $sum_of_earnings += $affiliate_sales['affiliate_payment'];
      if (($number_of_sales / 2) == floor($number_of_sales / 2)) {
        echo '          <tr class="productListing-even">';
      } else {
        echo '          <tr class="productListing-odd">';
      }
?>
            <td class="smallText" align="center"><?php echo tep_date_short($affiliate_sales['affiliate_date']); ?></td>
            <td class="smallText" align="right"><?php echo $currencies->display_price($affiliate_sales['affiliate_value'], ''); ?></td>
            <td class="smallText" align="right"><?php echo $affiliate_sales['affiliate_percent'] . " %"; ?></td>
            <td class="smallText" align="right"><?php echo $currencies->display_price($affiliate_sales['affiliate_payment'], ''); ?></td>
            <td class="smallText" align="right"><?php if ($affiliate_sales['orders_status']) echo $affiliate_sales['orders_status']; else echo TEXT_DELETED_ORDER_BY_ADMIN; ?></td>
          </tr>
<?php
    }
  } else {
?>
          <tr class="productListing-odd">
            <td class="main" colspan="5"><?php echo TEXT_NO_SALES; ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td colspan="5"><?php echo tep_draw_separator(); ?></td>
          </tr>
<?php 
  if ($affiliate_sales_split->number_of_rows > 0) {
?>
          <tr>
            <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText"><?php echo $affiliate_sales_split->display_count(TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE; ?> <?php echo $affiliate_sales_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
<?php
  }
?>
            <td class="main" colspan="5"><br /><?php echo TEXT_INFORMATION_SALES_TOTAL . ' <strong>' .  $currencies->display_price($sum_of_earnings,''), '</strong>' . TEXT_INFORMATION_SALES_TOTAL2; ?></td>
          </tr>
                <tr>
                  <td colspan="5"><?php echo tep_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="boxtext" colspan="5"><strong><?php echo TEXT_SALES; ?><strong></td>
                </tr>
                <tr>
                  <td colspan="5"><?php echo tep_draw_separator(); ?></td>
                </tr>
        </table></td>
      </tr>
    </table></td>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>