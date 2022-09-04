<?php
/*
 * coupons.php
 * August 4, 2006
 * author: Kristen G. Thorson
 * ot_discount_coupon_codes version 3.0
 *
 * 
 * Released under the GNU General Public License
 *
 */

  require('includes/application_top.php');
  require( DIR_WS_FUNCTIONS.'coupons.php' );

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
  $error = (isset($HTTP_GET_VARS['error']) ? $HTTP_GET_VARS['error'] : '');
  $message = (isset($HTTP_GET_VARS['message']) ? $HTTP_GET_VARS['message'] : '');
  $coupons_id = ( !empty( $HTTP_POST_VARS['coupons_id'] ) ? tep_db_input( $HTTP_POST_VARS['coupons_id'] ) : ( !empty( $HTTP_GET_VARS['cID'] ) ? tep_db_input( $HTTP_GET_VARS['cID'] ) : kgt_create_random_coupon() ) );

  if( tep_not_null( $error ) ) {
		$messageStack->add( $error, 'error' );
	}
  if( tep_not_null( $message ) ) {
		$messageStack->add( $message, 'success' );
	}

  if (tep_not_null($action)) {
    switch ($action) {
      case 'insert':
      	//some error checking:
        if( empty( $HTTP_POST_VARS['coupons_discount_amount'] ) ) {
          $messageStack->add( ERROR_DISCOUNT_COUPONS_NO_AMOUNT, 'error' );
          $action = 'new';
        } else {
	        tep_db_query( $sql = "insert into " . TABLE_DISCOUNT_COUPONS . " values (
                '".$coupons_id."', 
                '".tep_db_input( $HTTP_POST_VARS['coupons_description'] )."', 
                '".tep_db_input( $HTTP_POST_VARS['coupons_discount_amount'] )."', 
                '" .tep_db_input( $HTTP_POST_VARS['coupons_discount_type'] )."', 
                ".( !empty( $HTTP_POST_VARS['coupons_date_start'] ) ? '"'.kgt_parse_date( $HTTP_POST_VARS['coupons_date_start'], DATE_FORMAT_SHORT ).'"' : 'null' ).", 
                ".( !empty( $HTTP_POST_VARS['coupons_date_end'] ) ? '"'.kgt_parse_date( $HTTP_POST_VARS['coupons_date_end'], DATE_FORMAT_SHORT ).'"' : 'null' ).", 
                ".( !empty( $HTTP_POST_VARS['coupons_max_use'] ) ? (int)$HTTP_POST_VARS['coupons_max_use'] : 0 ).", 
                ".( !empty( $HTTP_POST_VARS['coupons_min_order'] ) ? tep_db_input( $HTTP_POST_VARS['coupons_min_order'] ) : 0 ).", 
                ".( !empty( $HTTP_POST_VARS['coupons_min_order'] ) ? "'".tep_db_input( $HTTP_POST_VARS['coupons_min_order_type'] )."'" : 'null' ).", 
                ".( !empty( $HTTP_POST_VARS['coupons_number_available'] ) ? (int)$HTTP_POST_VARS['coupons_number_available'] : 0 ).") " );
	        tep_redirect( tep_href_link( FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $coupons_id ) );
				}
	      break;
      case 'update':
        tep_db_query($sql = "update " . TABLE_DISCOUNT_COUPONS . " set
              coupons_discount_amount = '".tep_db_input( $HTTP_POST_VARS['coupons_discount_amount'] )."',
              coupons_discount_type = '".tep_db_input( $HTTP_POST_VARS['coupons_discount_type'] )."',
        			coupons_description = '" . tep_db_input( $HTTP_POST_VARS['coupons_description'] ) . "',
        			coupons_date_start = " . ( !empty( $HTTP_POST_VARS['coupons_date_start'] ) ? '"'.kgt_parse_date( $HTTP_POST_VARS['coupons_date_start'], DATE_FORMAT_SHORT ).'"' : 'null' ) . ",
        			coupons_date_end = " .( !empty( $HTTP_POST_VARS['coupons_date_end'] ) ? '"'.kgt_parse_date( $HTTP_POST_VARS['coupons_date_end'], DATE_FORMAT_SHORT ).'"' : 'null' ). ",
							coupons_max_use = " .( !empty( $HTTP_POST_VARS['coupons_max_use'] ) ? (int)$HTTP_POST_VARS['coupons_max_use'] : 0 ). ",
              coupons_min_order = ".( !empty( $HTTP_POST_VARS['coupons_min_order'] ) ? tep_db_input( $HTTP_POST_VARS['coupons_min_order'] ) : 0 ).",
              coupons_min_order_type = ".( !empty( $HTTP_POST_VARS['coupons_min_order'] ) ? "'".tep_db_input( $HTTP_POST_VARS['coupons_min_order_type'] )."'" : 'null' ).",
							coupons_number_available = " .( !empty( $HTTP_POST_VARS['coupons_number_available'] ) ? (int)$HTTP_POST_VARS['coupons_number_available'] : 0 ). "
        			where coupons_id = '" . $coupons_id . "'");
        tep_redirect( tep_href_link( FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $coupons_id ) );
        break;
      case 'deleteconfirm':
        tep_db_query($sql = "delete from " . TABLE_DISCOUNT_COUPONS . " where coupons_id = '" .$coupons_id. "'");
        tep_db_query($sql = "delete from " . TABLE_DISCOUNT_COUPONS_TO_ORDERS . " where coupons_id = '" .$coupons_id. "'");
        //exclusions
				tep_db_query($sql = "delete from " . TABLE_DISCOUNT_COUPONS_TO_CATEGORIES . " where coupons_id = '" .$coupons_id. "'");
        tep_db_query($sql = "delete from " . TABLE_DISCOUNT_COUPONS_TO_MANUFACTURERS . " where coupons_id = '" .$coupons_id. "'");
        tep_db_query($sql = "delete from " . TABLE_DISCOUNT_COUPONS_TO_PRODUCTS . " where coupons_id = '" .$coupons_id. "'");
				tep_db_query($sql = "delete from " . TABLE_DISCOUNT_COUPONS_TO_CUSTOMERS . " where coupons_id = '" .$coupons_id. "'");
        tep_db_query($sql = "delete from " . TABLE_DISCOUNT_COUPONS_TO_ZONES . " where coupons_id = '" .$coupons_id . "'");
				//end exclusions
        tep_redirect(tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page']));
        break;
    }
  }

 require(DIR_WS_INCLUDES . 'template_top.php');
?>

    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="specialPrice" align="right">NOTICE: <a href="<?php echo tep_href_link( DIR_WS_LANGUAGES.$language.'/'.FILENAME_DISCOUNT_COUPONS_MANUAL ).'">'.HEADING_TITLE_VIEW_MANUAL; ?></a></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ( ($action == 'new') || ($action == 'edit') ) {
    $form_action = 'insert';
    if ( ($action == 'edit') && isset($HTTP_GET_VARS['cID']) ) {
      $form_action = 'update';

      $coupons_query = tep_db_query("select * from " . TABLE_DISCOUNT_COUPONS . " where coupons_id = '" . $coupons_id . "'");
      $coupons = tep_db_fetch_array($coupons_query);

      $cInfo = new objectInfo($coupons);
    } else {
      $cInfo = new objectInfo(array());
    }
?>
      <tr><form name="new_coupon" <?php echo 'action="' . tep_href_link(FILENAME_DISCOUNT_COUPONS, tep_get_all_get_params(array('action', 'info', 'cID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?> method="post"><?php if ($form_action == 'update') echo tep_draw_hidden_field('coupons_id', $HTTP_GET_VARS['cID']); ?>
        <td><br><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_ID; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('coupons_id',$cInfo->coupons_id, 'size="10" maxlength="32"'.( $action == 'edit' ? ' disabled' : '')); ?></td>
          </tr>
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_DESCRIPTION; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('coupons_description',$cInfo->coupons_description, 'size="25" maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_AMOUNT; ?>&nbsp;</td>
            <td class="main">
<?php
	  echo tep_draw_input_field('coupons_discount_amount', $cInfo->coupons_discount_amount, 'size="5" maxlength="10"');
	  echo '&nbsp;&nbsp;'.TEXT_DISCOUNT_COUPONS_TYPE;
	  echo kgt_draw_type_drop_down( 'discount', 'coupons_discount_type', ''.$cInfo->coupons_discount_type );
    echo '<br><small>'.TEXT_INFO_DISCOUNT_AMOUNT_HINT.'</small>';
?>
            </td>
          </tr>
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_DATE_START; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('coupons_date_start', ( !empty($cInfo->coupons_date_start) ? tep_date_short( $cInfo->coupons_date_start ) : '' ), 'size="10" maxlength="10"') ; ?></a></td>
          </tr>
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_DATE_END; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('coupons_date_end', ( !empty($cInfo->coupons_date_end) ? tep_date_short( $cInfo->coupons_date_end ) : '' ), 'size="10" maxlength="10"') ; ?></a></td>
          </tr>
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_MAX_USE; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('coupons_max_use', $cInfo->coupons_max_use, 'size="5" maxlength="5"'); ?></td>
          </tr>
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_MIN_ORDER; ?>&nbsp;</td>
            <td class="main">
<?php 
    echo tep_draw_input_field('coupons_min_order', $cInfo->coupons_min_order, 'size="5" maxlength="5"'); 
    echo '&nbsp;&nbsp;'.TEXT_DISCOUNT_COUPONS_MIN_ORDER_TYPE;
    echo kgt_draw_type_drop_down( 'min_order', 'coupons_min_order_type', ''.$cInfo->coupons_min_order_type );
?>
            </td>
          </tr>
          <tr>
            <td class="main" align="right" valign="top"><?php echo TEXT_DISCOUNT_COUPONS_NUMBER_AVAILABLE; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('coupons_number_available', $cInfo->coupons_number_available, 'size="5" maxlength="5"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" align="right" valign="top"><br><?php echo (($form_action == 'insert') ? tep_image_submit('button_insert.gif', IMAGE_INSERT) : tep_image_submit('button_update.gif', IMAGE_UPDATE)). '&nbsp;&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . (isset($HTTP_GET_VARS['cID']) ? '&cID=' . $HTTP_GET_VARS['cID'] : '')) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
	} else {
  	require(DIR_WS_CLASSES . 'currencies.php');
    $currencies = new currencies();
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left"><?php echo TEXT_DISCOUNT_COUPONS_ID; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TEXT_INFO_DISCOUNT_AMOUNT; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TEXT_INFO_DATE_START; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TEXT_INFO_DATE_END; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TEXT_INFO_MAX_USE; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TEXT_INFO_MIN_ORDER; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TEXT_INFO_NUMBER_AVAILABLE; ?></td>
                <td class="dataTableHeadingContent" align="left">&nbsp;</td>
              </tr>
<?php
    $coupons_query_raw = "select * from " . TABLE_DISCOUNT_COUPONS . " cd order by cd.coupons_date_end, coupons_date_start";
    $coupons_split = new splitPageResults( $HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $coupons_query_raw, $coupons_query_numrows );
    $coupons_query = tep_db_query($coupons_query_raw);
    while( $coupons = tep_db_fetch_array( $coupons_query ) ) {
      if( ( !isset( $HTTP_GET_VARS['cID'] ) || ( isset( $HTTP_GET_VARS['cID'] ) && ( $HTTP_GET_VARS['cID'] == $coupons['coupons_id'] ) ) ) && !isset( $cInfo ) && ( substr( $action, 0, 3 ) != 'new' ) ) {
	      $cInfo = new objectInfo($coupons);
	  	}

      if (isset($cInfo) && is_object($cInfo) && ($coupons['coupons_id'] == $cInfo->coupons_id) ) {
        echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $cInfo->coupons_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $coupons['coupons_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent" align="left"><?php echo $coupons['coupons_id'].' <small>'.( !empty( $coupons['coupons_description'] ) ? '( '.$coupons['coupons_description'].' )' : '' ) .'</small>'; ?></td>
                <td class="dataTableContent" align="left">
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
                <td class="dataTableContent" align="left"><?php echo !empty( $coupons['coupons_date_start'] ) ? tep_date_short( $coupons['coupons_date_start'] ) : TEXT_DISPLAY_UNLIMITED; ?></td>
                <td class="dataTableContent" align="left"><?php echo !empty( $coupons['coupons_date_end'] ) ? tep_date_short( $coupons['coupons_date_end'] ) : TEXT_DISPLAY_UNLIMITED; ?></td>
                <td class="dataTableContent" align="left"><?php echo ( $coupons['coupons_max_use'] != 0 ? $coupons['coupons_max_use'] : TEXT_DISPLAY_UNLIMITED ); ?></td>
                <td class="dataTableContent" align="left"><?php echo ( $coupons['coupons_min_order'] != 0 ? ( $coupons['coupons_min_order_type'] == 'price' ? $currencies->format( $coupons['coupons_min_order'] ) : (int)$coupons['coupons_min_order'] ) : TEXT_DISPLAY_UNLIMITED ); ?></td>
                <td class="dataTableContent" align="left"><?php echo ( $coupons['coupons_number_available'] != 0 ? $coupons['coupons_number_available'] : TEXT_DISPLAY_UNLIMITED ); ?></td>
                <td class="dataTableContent" align="left">&nbsp;
<?php 
    if( isset( $cInfo ) && is_object( $cInfo ) && ( $coupons['coupons_id'] == $cInfo->coupons_id ) ) { 
      echo tep_image( DIR_WS_IMAGES.'icon_arrow_right.gif', '' ); 
    } else { 
      echo '<a href="'.tep_href_link( FILENAME_DISCOUNT_COUPONS, 'page='.$HTTP_GET_VARS['page'].'&cID='.$coupons['coupons_id'] ).'">' . tep_image( DIR_WS_IMAGES.'icon_info.gif', IMAGE_ICON_INFO ).'</a>'; 
    } 
?>
                </td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="smallText" align="right"><?php echo $coupons_split->display_links($coupons_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?></td>
                  </tr>
<?php
  if (empty($action)) {
?>
                  <tr>
                    <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&action=new') . '">' . tep_image_button('button_new_coupon.gif', IMAGE_NEW_COUPON) . '</a>'; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_DISCOUNT_COUPONS . '</b>');

      $contents = array('form' => tep_draw_form('coupons', FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $cInfo->coupons_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $cInfo->coupons_id . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $cInfo->coupons_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->coupons_id . '</b>');

        $contents[] = array('align' => 'center',
        										'text' => '<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $cInfo->coupons_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> '.
        															'<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS, 'page=' . $HTTP_GET_VARS['page'] . '&cID=' . $cInfo->coupons_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> '
        															//exclusions
        															.'<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS_EXCLUSIONS, 'cID='.$cInfo->coupons_id.'&type=products') . '">' . tep_image_button('button_product_exclusions.gif', IMAGE_PRODUCT_EXCLUSIONS, 'hspace="2" vspace="2"') . '</a> '
        															.'<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS_EXCLUSIONS, 'cID='.$cInfo->coupons_id.'&type=manufacturers') . '">' . tep_image_button('button_manufacturer_exclusions.gif', IMAGE_MANUFACTURER_EXCLUSIONS, 'hspace="2" vspace="2"') . '</a> '
        															.'<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS_EXCLUSIONS, 'cID='.$cInfo->coupons_id.'&type=categories') . '">' . tep_image_button('button_category_exclusions.gif', IMAGE_CATEGORY_EXCLUSIONS, 'hspace="2" vspace="2"') . '</a> '
        															.'<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS_EXCLUSIONS, 'cID='.$cInfo->coupons_id.'&type=customers') . '">' . tep_image_button('button_customer_exclusions.gif', IMAGE_CUSTOMER_EXCLUSIONS, 'hspace="2" vspace="2"') . '</a> '
                                      .'<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS_EXCLUSIONS, 'cID='.$cInfo->coupons_id.'&type=zones') . '">' . tep_image_button('button_shipping_zone_exclusions.gif', IMAGE_SHIPPING_ZONE_EXCLUSIONS, 'hspace="2" vspace="2"') . '</a> '
        															//end exclusions
        									 );
        switch( $cInfo->coupons_discount_type ) {
          case 'shipping':
            $discount = ( $cInfo->coupons_discount_amount * 100 ).'% '.TEXT_DISPLAY_SHIPPING_DISCOUNT;
            break;
          case 'percent':
            $discount = ( $cInfo->coupons_discount_amount * 100 ).'%';
            break;
          case 'fixed':
            $discount = $currencies->format( $cInfo->coupons_discount_amount );
            break;
        }
        $contents[] = array('text' => '<br>' . TEXT_INFO_DISCOUNT_AMOUNT . ' ' . $discount );
        $contents[] = array('text' => '' . TEXT_INFO_DATE_START . ' ' . ( !empty( $cInfo->coupons_date_start ) ? tep_date_short( $cInfo->coupons_date_start ) : TEXT_DISPLAY_UNLIMITED ) );
        $contents[] = array('text' => '' . TEXT_INFO_DATE_END . ' ' . ( !empty( $cInfo->coupons_date_end ) ? tep_date_short( $cInfo->coupons_date_end ) : TEXT_DISPLAY_UNLIMITED ) );
        $contents[] = array('text' => '' . TEXT_INFO_MAX_USE . ' ' . ( $cInfo->coupons_max_use != 0 ? $cInfo->coupons_max_use : TEXT_DISPLAY_UNLIMITED ) );
        $contents[] = array('text' => '' . TEXT_INFO_MIN_ORDER . ' ' . ( $cInfo->coupons_min_order != 0 ? ( $cInfo->coupons_min_order_type == 'price' ? $currencies->format( $cInfo->coupons_min_order ) : (int)$cInfo->coupons_min_order ) : TEXT_DISPLAY_UNLIMITED ) );
        $contents[] = array('text' => '' . TEXT_INFO_NUMBER_AVAILABLE . ' ' . ( $cInfo->coupons_number_available != 0 ? $cInfo->coupons_number_available : TEXT_DISPLAY_UNLIMITED ) );
      }
      break;
  }
  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
}
?>
          </tr>
        </table></td>
      </tr>
    </table>

<?php 
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php'); 
?>