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

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_SUMMARY);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_SUMMARY));

  $affiliate_banner_history_raw = "select sum(affiliate_banners_shown) as count from " . TABLE_AFFILIATE_BANNERS_HISTORY .  " where affiliate_banners_affiliate_id  = '" . $affiliate_id . "'";
  $affiliate_banner_history_query=tep_db_query($affiliate_banner_history_raw);
  $affiliate_banner_history = tep_db_fetch_array($affiliate_banner_history_query);
  $affiliate_impressions = $affiliate_banner_history['count'];
  if ($affiliate_impressions == 0) $affiliate_impressions="n/a"; 

  $affiliate_clickthroughs_raw = "select count(*) as count from " . TABLE_AFFILIATE_CLICKTHROUGHS . " where affiliate_id = '" . $affiliate_id . "'";
  $affiliate_clickthroughs_query = tep_db_query($affiliate_clickthroughs_raw);
  $affiliate_clickthroughs = tep_db_fetch_array($affiliate_clickthroughs_query);
  $affiliate_clickthroughs =$affiliate_clickthroughs['count'];

  $affiliate_sales_raw = "
			select count(*) as count, sum(affiliate_value) as total, sum(affiliate_payment) as payment from " . TABLE_AFFILIATE_SALES . " a 
			left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id=o.orders_id) 
			where a.affiliate_id = '" . $affiliate_id . "' and o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . " 
			";
  $affiliate_sales_query = tep_db_query($affiliate_sales_raw);
  $affiliate_sales = tep_db_fetch_array($affiliate_sales_query);

  $affiliate_transactions=$affiliate_sales['count'];
  if ($affiliate_clickthroughs > 0) {
	$affiliate_conversions = tep_round(($affiliate_transactions / $affiliate_clickthroughs)*100, 2) . "%";
  } else {
    $affiliate_conversions = "n/a";
  }
  $affiliate_amount = $affiliate_sales['total'];
  if ($affiliate_transactions>0) {
	$affiliate_average = tep_round($affiliate_amount / $affiliate_transactions, 2);
  } else {
	$affiliate_average = "n/a";
  }
  $affiliate_commission = $affiliate_sales['payment'];

  $affiliate_values = tep_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate_id . "'");
  $affiliate = tep_db_fetch_array($affiliate_values);
  $affiliate_percent = 0;
  $affiliate_percent = $affiliate['affiliate_commission_percent'];
  if ($affiliate_percent < AFFILIATE_PERCENT) $affiliate_percent = AFFILIATE_PERCENT;
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=450,height=150,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<!-- body_text //-->
 <div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_INFORMATION; ?>
  </div>
   <div class="contentText">
<?php
  if ($messageStack->size('account') > 0) {
?>

       <p><?php echo $messageStack->output('account'); ?></p>
<?php
}
?>
           <p><?php echo TEXT_GREETING . $affiliate['affiliate_firstname'] . ' ' . $affiliate['affiliate_lastname'] . '<br />' . TEXT_AFFILIATE_ID . $affiliate_id; ?></p>
           <p><strong><?php echo TEXT_SUMMARY_TITLE; ?></strong></p>
           <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <center>
                <tr>
                  <td width="35%" align="right" ><?php echo TEXT_IMPRESSIONS; ?><a class="hastip"  title="<?php echo TEXT_IMPRESSIONS_HELP;?>"><strong>[-?-]</strong></a></td>
                  <td width="15%">&nbsp;<?php echo $affiliate_impressions; ?></td>
                  <td width="35%" align="right"><?php echo TEXT_VISITS; ?><a class="hastip"  title="<?php echo TEXT_VISITS_HELP;?>"><strong>[-?-]</strong></a></td>
                  <td width="15%">&nbsp;<?php echo $affiliate_clickthroughs; ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right"><?php echo TEXT_TRANSACTIONS; ?><a class="hastip"  title="<?php echo TEXT_TRANSACTIONS_HELP;?>"><strong>[-?-]</strong></a> </td>
                  <td width="15%">&nbsp;<?php echo $affiliate_transactions; ?></td>
                  <td width="35%" align="right"><?php echo TEXT_CONVERSION; ?><a class="hastip"  title="<?php echo TEXT_CONVERSION_HELP;?>"><strong>[-?-]</strong></a></td>
                  <td width="15%">&nbsp;<?php echo $affiliate_conversions;?></td>
                </tr>
                <tr>
                  <td width="35%" align="right"><?php echo TEXT_AMOUNT; ?><a class="hastip"  title="<?php echo TEXT_AMOUNT_HELP;?>"><strong>[-?-]</strong></a>
                  <td width="15%">&nbsp;<?php echo $currencies->display_price($affiliate_amount, ''); ?></td>
                  <td width="35%" align="right"><?php echo TEXT_AVERAGE; ?><a class="hastip"  title="<?php echo TEXT_AVERAGE_HELP;?>"><strong>[-?-]</strong></a>  </td> </td>
                  <td width="15%">&nbsp;<?php echo $currencies->display_price($affiliate_average, ''); ?></td>
                </tr>
                <tr>
                   <td align="right"><?php echo TEXT_CLICKTHROUGH_RATE; ?><a class="hastip"  title="<?php echo TEXT_CLICKTHROUGH_RATE_HELP;?>"><strong>[-?-]</strong></a></td>
                   <td>&nbsp;<?php echo  $currencies->display_price(AFFILIATE_PAY_PER_CLICK, ''); ?></td>
                   <td align="right"><?php echo TEXT_PAYPERSALE_RATE; ?><a class="hastip"  title="<?php echo TEXT_PAY_PER_SALE_RATE_HELP;?>"><strong>[-?-]</strong></a></td>
                   <td>&nbsp;<?php echo  $currencies->display_price(AFFILIATE_PAYMENT, ''); ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right"><?php echo TEXT_COMMISSION_RATE; ?><a class="hastip"  title="<?php echo TEXT_COMMISSION_RATE_HELP;?>"><strong>[-?-]</strong></a></td>
                  <td width="15%">&nbsp;<?php echo tep_round($affiliate_percent, 2). '%'; ?></td>
                  <td width="35%" align="right"><?php echo TEXT_COMMISSION; ?><a class="hastip"  title="<?php echo TEXT_COMMISSION_HELP;?>"><strong>[-?-]</strong></a</td>
                  <td width="15%">&nbsp;<?php echo $currencies->display_price($affiliate_commission, ''); ?></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo tep_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="boxtext" colspan="4"><strong><?php echo TEXT_SUMMARY; ?></strong></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo tep_draw_separator(); ?></td>
                </tr>
            </table>
<div class="contentContainer">
          <p><strong><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL'). '">' . TEXT_AFFILIATE_SUMMARY . '</a>';?></strong></p>
           <ul>
                   <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'SSL'). '">' . TEXT_AFFILIATE_ACCOUNT . '</a>';?> </li>
                   <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTER, '', 'SSL'). '">' . TEXT_AFFILIATE_NEWSLETTER . '</a>';?></li>
                   <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_PASSWORD, '', 'SSL'). '">' . TEXT_AFFILIATE_PASSWORD . '</a>';?></li>
                   <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWS, '', 'SSL'). '">' . TEXT_AFFILIATE_NEWS . '</a>';?></li>
          </ul>
         <p><strong><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS . '</a>';?></strong></p>
          <ul>
                    <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BANNERS, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS_BANNERS . '</a>';?></li>
                    <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BUILD, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS_BUILD . '</a>';?></li>
                    <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_PRODUCT, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS_PRODUCT . '</a>';?></li>
                    <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_TEXT, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS_TEXT . '</a>';?></li>
          </ul>
         <p><strong><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_REPORTS, '', 'SSL'). '">' . TEXT_AFFILIATE_REPORTS . '</a>';?></strong></p>
           <ul>
                    <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'). '">' . TEXT_AFFILIATE_CLICKRATE . '</a>';?></li>
                    <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'SSL'). '">' . TEXT_AFFILIATE_PAYMENT . '</a>';?></li>
                    <li class="ul"><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'). '">' . TEXT_AFFILIATE_SALES . '</a>';?></li>
         </ul>

      </div>
   </div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>