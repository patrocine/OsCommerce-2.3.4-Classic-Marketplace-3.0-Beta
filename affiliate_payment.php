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

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_PAYMENT);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'SSL'));

  $affiliate_payment_raw = "
    select p.* , s.affiliate_payment_status_name 
           from " . TABLE_AFFILIATE_PAYMENT . " p, " . TABLE_AFFILIATE_PAYMENT_STATUS . " s 
           where p.affiliate_payment_status = s.affiliate_payment_status_id 
           and s.affiliate_language_id = '" . (int)$languages_id . "' 
           and p.affiliate_id =  '" . $affiliate_id . "' 
           order by p.affiliate_payment_id DESC
           ";

  $affiliate_payment_split = new splitPageResults($affiliate_payment_raw, MAX_DISPLAY_SEARCH_RESULTS);
  require(DIR_WS_INCLUDES . 'template_top.php');  
?>
<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
  <div class="contentText">
    <?php// echo TEXT_INFORMATION; ?>
  </div>

 <table width=100%">
  <tr>
            <td class="main" colspan="4"><?php echo TEXT_AFFILIATE_HEADER . ' <strong>' . tep_db_num_rows(tep_db_query($affiliate_payment_raw)); ?></strong></td>
          </tr>
          <tr>
            <td colspan="4"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_PAYMENT_ID; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_PAYMENT_ID_HELP;?>">[-?-]</a></td>
            <td class="infoBoxHeading" align="center"><?php echo TABLE_HEADING_DATE; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_DATE_HELP;?>">[-?-]</a></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_PAYMENT; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_PAYMENT_HELPP;?>">[-?-]</a></td>
            <td class="infoBoxHeading" align="right"><?php echo TABLE_HEADING_STATUS; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_STATUS_HELP;?>">[-?-]</a></td>
          </tr>
<?php
  if ($affiliate_payment_split->number_of_rows > 0) {
    $affiliate_payment_values = tep_db_query($affiliate_payment_split->sql_query);
    $number_of_payment = 0;
    while ($affiliate_payment = tep_db_fetch_array($affiliate_payment_values)) {
      $number_of_payment++;

      if (($number_of_payment / 2) == floor($number_of_payment / 2)) {
        echo '          <tr class="productListing-even">';
      } else {
        echo '          <tr class="productListing-odd">';
      }
?>
            <td class="smallText" align="right"><?php echo $affiliate_payment['affiliate_payment_id']; ?></td>
            <td class="smallText" align="center"><?php echo tep_date_short($affiliate_payment['affiliate_payment_date']); ?></td>
            <td class="smallText" align="right"><?php echo $currencies->display_price($affiliate_payment['affiliate_payment_total'], ''); ?></td>
            <td class="smallText" align="right"><?php echo $affiliate_payment['affiliate_payment_status_name']; ?></td>
          </tr>
<?php
    }
  } else {
?>
          <tr class="productListing-odd">
            <td colspan="4" class="main"><?php echo TEXT_NO_PAYMENTS; ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td colspan="4"><?php echo tep_draw_separator(); ?></td>
          </tr>
<?php 
  if ($affiliate_payment_split->number_of_rows > 0) {
?>    
          <tr>
            <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText"><?php echo $affiliate_payment_split->display_count(TEXT_DISPLAY_NUMBER_OF_PAYMENTS); ?></td>
                <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE; ?> <?php echo $affiliate_payment_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
  }
  $affiliate_payment_values = tep_db_query("select sum(affiliate_payment_total) as total from " . TABLE_AFFILIATE_PAYMENT . " where affiliate_id = '" . $affiliate_id . "'");
  $affiliate_payment = tep_db_fetch_array($affiliate_payment_values);
?>
          <tr>
            <td class="main" colspan="4"><br /><?php echo TEXT_INFORMATION_PAYMENT_TOTAL . ' <strong>' . $currencies->display_price($affiliate_payment['total'], ''); ?></strong></td>
          </tr>
                <tr>
                  <td colspan="4"><?php echo tep_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="boxtext" colspan="4"><strong><?php echo TEXT_PAYMENT; ?></strong></td>
                </tr>
                                 <tr>
                  <td align="center" class="boxtext" colspan="4"><?php echo TEXT_PAYMENT_WAIT; ?></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo tep_draw_separator(); ?></td>
                </tr>
        </table>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>