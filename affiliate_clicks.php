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

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_CLICKS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'));

  $affiliate_clickthroughs_raw = "
    select a.*, pd.products_name from " . TABLE_AFFILIATE_CLICKTHROUGHS . " a 
    left join " . TABLE_PRODUCTS . " p on (p.products_id = a.affiliate_products_id) 
    left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "') 
    where a.affiliate_id = '" . $affiliate_id . "'  ORDER BY a.affiliate_clientdate desc
    ";
  $affiliate_clickthroughs_split = new splitPageResults($affiliate_clickthroughs_raw, MAX_DISPLAY_SEARCH_RESULTS);

  $affiliate_clickthroughs_numrows_raw = "select count(*) as count from " . TABLE_AFFILIATE_CLICKTHROUGHS . " where affiliate_id = '" . $affiliate_id . "'";
  $affiliate_clickthroughs_query = tep_db_query($affiliate_clickthroughs_numrows_raw);
  $affiliate_clickthroughs_numrows = tep_db_fetch_array($affiliate_clickthroughs_query);
  $affiliate_clickthroughs_numrows =$affiliate_clickthroughs_numrows['count'];
  require(DIR_WS_INCLUDES . 'template_top.php');  
?>

<!-- body_text //-->
<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
  <div class="contentText">
  </div>
       <div class="contentText">
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" colspan="4"><?php echo TEXT_AFFILIATE_HEADER . ' <strong>' . $affiliate_clickthroughs_numrows; ?></strong></td>
          </tr>
   <?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?>
          <tr>
            <td class="infoBoxHeading"><?php echo TABLE_HEADING_DATE; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_DATE_HELP;?>">[-?-]</a></td>
 	        <td class="infoBoxHeading"><?php echo TABLE_HEADING_CLICKED_PRODUCT; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_CLICKED_PRODUCT_HELP;?>">[-?-]</a></td>
	        <td class="infoBoxHeading"><?php echo TABLE_HEADING_REFFERED; ?>&nbsp;<a class="hastip"  title="<?php echo TEXT_REFFERED_HELP;?>">[-?-]</a></td>
          </tr>
<?php
  if ($affiliate_clickthroughs_split->number_of_rows > 0) {
    $affiliate_clickthroughs_values = tep_db_query($affiliate_clickthroughs_split->sql_query);
    $number_of_clickthroughs = '0';
    while ($affiliate_clickthroughs = tep_db_fetch_array($affiliate_clickthroughs_values)) {
      $number_of_clickthroughs++;

      if (($number_of_clickthroughs / 2) == floor($number_of_clickthroughs / 2)) {
        echo '          <tr class="productListing-even">';
      } else {
        echo '          <tr class="productListing-odd">';
      }
?>
            <td class="smallText"><?php echo tep_date_short($affiliate_clickthroughs['affiliate_clientdate']); ?></td>
<?php
      if ($affiliate_clickthroughs['affiliate_products_id'] > 0) {
        $link_to = '<a href="' . tep_href_link (FILENAME_PRODUCT_INFO, 'products_id=' . $affiliate_clickthroughs['affiliate_products_id']) . '" target="_blank">' . $affiliate_clickthroughs['products_name'] . '</a>';
      } else {
        $link_to = "Startpage";
      }
?>
            <td class="smallText"><?php echo $link_to; ?></td>
            <td class="smallText"><?php echo $affiliate_clickthroughs['affiliate_clientreferer']; ?></td>

<?php
    }
  } else {
?>
          <tr class="productListing-odd">
            <td colspan="4" class="smallText"><?php echo TEXT_NO_CLICKS; ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td colspan="4"><?php echo tep_draw_separator(); ?></td>
          </tr>
<?php 
  if ($affiliate_clickthroughs_split->number_of_rows > 0) {
?>

              <tr>
                <td class="smallText"><?php echo $affiliate_clickthroughs_split->display_count(TEXT_DISPLAY_NUMBER_OF_CLICKS); ?></td>
                <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE; ?> <?php echo $affiliate_clickthroughs_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
              </tr>
<?php
  }
?>
                <tr>
                  <td colspan="4"><?php echo tep_draw_separator(); ?></td>
                </tr>
                 <tr>
                  <td align="center" class="boxtext" colspan="4"><strong><?php echo TEXT_CLICKS; ?></strong></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo tep_draw_separator(); ?></td>
                </tr>
        </table>
        </div>
        </div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>