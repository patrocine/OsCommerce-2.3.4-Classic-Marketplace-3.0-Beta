<?php
/*
 * stats_discount_coupons.php
 * August 4, 2006
 * author: Kristen G. Thorson
 *
 * ot_discount_coupon_codes version 3.0
 *
 * Released under the GNU General Public License
 *
 */

  require('includes/application_top.php');
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">
            	<?php echo HEADING_TITLE; ?>
            	<?php
								if( isset( $HTTP_GET_VARS['cID'] ) && tep_not_null( $HTTP_GET_VARS['cID'] ) ) {
									if( isset( $HTTP_GET_VARS['custID'] ) && tep_not_null( $HTTP_GET_VARS['custID'] ) ) echo '<br>'.sprintf( HEADING_ORDERS_LIST, tep_customers_name($HTTP_GET_VARS['custID']), $HTTP_GET_VARS['cID'] );
									else echo '<br>'.sprintf( HEADING_CUSTOMERS_LIST, $HTTP_GET_VARS['cID'] );
								} else echo '<br>'.HEADING_COUPONS_LIST;
            	?>
            </td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (isset($HTTP_GET_VARS['page']) && ($HTTP_GET_VARS['page'] > 1)) $rows = $HTTP_GET_VARS['page'] * MAX_DISPLAY_SEARCH_RESULTS - MAX_DISPLAY_SEARCH_RESULTS;
  if( isset( $HTTP_GET_VARS['cID'] ) && $HTTP_GET_VARS['cID'] !== '' ) {
  	if( isset( $HTTP_GET_VARS['custID'] ) && (int)$HTTP_GET_VARS['custID'] !== 0 ) {
?>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_DISCOUNT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
              </tr>
<?php
	    $coupons_query_raw = "select o.orders_id, o.customers_name, o.date_purchased, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o inner join discount_coupons_to_orders dcto on dcto.orders_id = o.orders_id left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$HTTP_GET_VARS['custID'] . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' and dcto.coupons_id='".$HTTP_GET_VARS['cID']."' order by orders_id DESC";
		  $coupons_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $coupons_query_raw, $coupons_query_numrows);

		  $rows = 0;
		  $coupons_query = tep_db_query($coupons_query_raw);
		  while ($coupons = tep_db_fetch_array($coupons_query)) {
		  	$ot_query_raw = "select ot.text as order_total from orders_total ot where ot.orders_id = '".$coupons['orders_id']."' and ot.class = 'ot_discount_coupon'";
		  	$ot_query = tep_db_query($ot_query_raw);
		  	$order_discount = tep_db_fetch_array($ot_query);
		    $rows++;
?>
              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo tep_href_link(FILENAME_ORDERS, 'action=edit&oID=' . $coupons['orders_id']); ?>'">
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, 'action=edit&oID=' . $coupons['orders_id'] . '&action=edit') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $coupons['customers_name']; ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($coupons['order_total']); ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($order_discount['order_total']); ?></td>
                <td class="dataTableContent" align="center"><?php echo tep_datetime_short($coupons['date_purchased']); ?></td>
                <td class="dataTableContent" align="right"><?php echo $coupons['orders_status_name']; ?></td>
              </tr>
<?php
			}
		} else {
?>
  						<tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_CUSTOMER; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_MAX_USE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_USE_COUNT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_USE_STILL_AVAIL; ?></td>
              </tr>
<?php
	    $coupons_query_raw = "select o.customers_name, o.customers_id, dc.coupons_max_use, COUNT(dcto.coupons_id) AS coupons_use_count from discount_coupons AS dc left join discount_coupons_to_orders AS dcto ON dc.coupons_id = dcto.coupons_id left join orders as o on dcto.orders_id=o.orders_id where dc.coupons_id='".$HTTP_GET_VARS['cID']."' group by dc.coupons_id, o.customers_id order by coupons_use_count desc, dc.coupons_id asc";
		  $coupons_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $coupons_query_raw, $coupons_query_numrows);

		  $rows = 0;
		  $coupons_query = tep_db_query($coupons_query_raw);
		  while ($coupons = tep_db_fetch_array($coupons_query)) {
		    $rows++;
?>
              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='<?php echo tep_href_link(FILENAME_STATS_DISCOUNT_COUPONS, 'custID='.$coupons['customers_id'].'&cID='.$cID.'&origin=' . FILENAME_STATS_DISCOUNT_COUPONS . '?page=' . $HTTP_GET_VARS['page'], 'NONSSL'); ?>'">
                <td class="dataTableContent"><?php echo $rows; ?>.</td>
                <td class="dataTableContent"><?php echo '<a href="'.tep_href_link(FILENAME_ORDERS, 'cID='.$coupons['customers_id'].'&action=edit&origin=' . FILENAME_STATS_DISCOUNT_COUPONS . '?page=' . $HTTP_GET_VARS['page'], 'NONSSL') . '">'.$coupons['customers_name'].'</a>'; ?></td>
                <td class="dataTableContent" align="center"><?php echo ( $coupons['coupons_max_use'] == 0 ? 'unlimited' : $coupons['coupons_max_use'] ); ?></td>
                <td class="dataTableContent" align="center"><?php echo $coupons['coupons_use_count']; ?>&nbsp;</td>
                <td class="dataTableContent" align="center"><?php echo ( $coupons['coupons_max_use'] == 0 ? 'unlimited' : ( $coupons['coupons_max_use'] - $coupons['coupons_use_count'] ) ); ?></td>
              </tr>
<?php
  		}
		}
	} else {
    require(DIR_WS_CLASSES . 'currencies.php');
    $currencies = new currencies();
?>
							<tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_CODE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PERCENTAGE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_NUM_AVAIL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_USE_COUNT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_NUM_STILL_AVAIL; ?></td>
              </tr>
<?php
	  $coupons_query_raw = "select dc.*, COUNT(dcto.coupons_id) AS coupons_use_count from ".TABLE_DISCOUNT_COUPONS." AS dc left join ".TABLE_DISCOUNT_COUPONS_TO_ORDERS." AS dcto ON dc.coupons_id = dcto.coupons_id group by dc.coupons_id order by coupons_use_count desc, dc.coupons_id asc";
	  $coupons_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $coupons_query_raw, $coupons_query_numrows);

	  $rows = 0;
	  $coupons_query = tep_db_query($coupons_query_raw);
	  while ($coupons = tep_db_fetch_array($coupons_query)) {
	    $rows++;
?>
              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" <?php echo ( $coupons['coupons_use_count'] == 0 ? '' : 'onclick="document.location.href=\''.tep_href_link(FILENAME_STATS_DISCOUNT_COUPONS, 'cID='.$coupons['coupons_id'].'&origin=' . FILENAME_STATS_DISCOUNT_COUPONS . '?page=' . $HTTP_GET_VARS['page'], 'NONSSL').'\'"' ); ?>>
                <td class="dataTableContent"><?php echo $rows; ?>.</td>
                <td class="dataTableContent"><?php echo ( $coupons['coupons_use_count'] == 0 ? $coupons['coupons_id'] : '<a href="'.tep_href_link(FILENAME_DISCOUNT_COUPONS, 'cID='.$coupons['coupons_id'].'&action=edit&origin=' . FILENAME_STATS_DISCOUNT_COUPONS . '?page=' . $HTTP_GET_VARS['page'], 'NONSSL') . '">'.$coupons['coupons_id'].'</a>' ); ?></td>
                <td class="dataTableContent">
<?php 
    switch( $coupons['coupons_discount_type'] ) {
      case 'shipping':
        echo ( $coupons['coupons_discount_amount'] * 100 ).'% '.TEXT_DISPLAY_SHIPPING_DISCOUNT;
        break;
      case 'percent':
        echo ( $coupons['coupons_discount_amount'] * 100 ).'%';
        break;
      case 'fixed':
        echo $currencies->format( $coupons['coupons_discount_amount'] );
        break;
    }
?>                
                </td>
                <td class="dataTableContent" align="center"><?php echo ( $coupons['coupons_number_available'] == 0 ? 'unlimited' : $coupons['coupons_number_available'] ); ?></td>
                <td class="dataTableContent" align="center"><?php echo $coupons['coupons_use_count']; ?>&nbsp;</td>
                <td class="dataTableContent" align="center"><?php echo ( $coupons['coupons_number_available'] == 0 ? 'unlimited' : ( $coupons['coupons_number_available'] - $coupons['coupons_use_count'] ) ); ?></td>
              </tr>
<?php
  	}
	}
?>
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $coupons_split->display_count($coupons_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
                <td class="smallText" align="right"><?php echo $coupons_split->display_links($coupons_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>

<?php
 require(DIR_WS_INCLUDES . 'template_bottom.php');
 require(DIR_WS_INCLUDES . 'application_bottom.php'); 
 ?>