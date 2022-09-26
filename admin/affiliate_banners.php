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
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $affiliate_banner_extension = tep_banner_image_extension();
  if (tep_not_null($action)) {
    switch ($action) {
      case 'affiliate_setflag':
        if ( ($_GET['affiliate_flag'] == '0') || ($_GET['affiliate_flag'] == '1') ) {
          tep_set_banner_status($_GET['abID'], $_GET['affiliate_flag']);

          $messageStack->add_session(SUCCESS_BANNER_STATUS_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        }
        tep_redirect(tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID']));
        break;
    case 'insert':
      case 'update':
        if (isset($_POST['affiliate_banners_id'])) $affiliate_banners_id = tep_db_prepare_input($_POST['affiliate_banners_id']);
        $affiliate_banners_title = tep_db_prepare_input($_POST['affiliate_banners_title']);
        $affiliate_products_id  = tep_db_prepare_input($_POST['affiliate_products_id']);
        $affiliate_category_id  = tep_db_prepare_input($_POST['affiliate_category_id']);
        $affiliate_banners_image_local = tep_db_prepare_input($_POST['affiliate_banners_image_local']);
        $affiliate_banners_image_target = tep_db_prepare_input($_POST['affiliate_banners_image_target']);
        $db_image_location = '';
        $affiliate_banner_error = false;
        if (empty($affiliate_banners_title)) {
          $messageStack->add(ERROR_BANNER_TITLE_REQUIRED, 'error');
          $affiliate_banner_error = true;
        }
          if (empty($affiliate_banners_image_local)) {
            $affiliate_banners_image = new upload('affiliate_banners_image');
            $affiliate_banners_image->set_destination(DIR_FS_CATALOG_IMAGES . $affiliate_banners_image_target);
            if ( ($affiliate_banners_image->parse() == false) || ($affiliate_banners_image->save() == false) ) {
              $affiliate_banner_error = true;
            }
          }
        if ($affiliate_banner_error == false) {
          $db_image_location = (tep_not_null($affiliate_banners_image_local)) ? $affiliate_banners_image_local : $affiliate_banners_image_target . $affiliate_banners_image->filename;
          $sql_data_array = array('affiliate_banners_title' => $affiliate_banners_title,
                                  'affiliate_products_id' => $affiliate_products_id,
                                  'affiliate_category_id' => $affiliate_category_id,
                                  'affiliate_banners_image' => $db_image_location);
          if ($action == 'insert') {
            $insert_sql_data = array('affiliate_date_added' => 'now()',
                                     'affiliate_status' => '1');
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            tep_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array);
            $affiliate_banners_id = tep_db_insert_id();
            $messageStack->add_session(SUCCESS_BANNER_INSERTED, 'success');
          } elseif ($action == 'update') {
            tep_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array, 'update', "affiliate_banners_id = '" . (int)$affiliate_banners_id . "'");
            $messageStack->add_session(SUCCESS_BANNER_UPDATED, 'success');
          }
          tep_redirect(tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'abID=' . $affiliate_banners_id));
        } else {
          $action = 'new';
        }
        break;
      case 'deleteconfirm':
        $affiliate_banners_id = tep_db_prepare_input($_GET['abID']);
        if (isset($_POST['delete_image']) && ($_POST['delete_image'] == 'on')) {
          $affiliate_banner_query = tep_db_query("select affiliate_banners_image from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . (int)$affiliate_banners_id . "'");
          $affiliate_banner = tep_db_fetch_array($affiliate_banner_query);
          if (is_file(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
            if (tep_is_writable(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
              unlink(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image']);
            } else {
              $messageStack->add_session(ERROR_IMAGE_IS_NOT_WRITEABLE, 'error');
            }
          } else {
            $messageStack->add_session(ERROR_IMAGE_DOES_NOT_EXIST, 'error');
          }
        }
        tep_db_query("delete from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . (int)$affiliate_banners_id . "'");
        tep_db_query("delete from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . (int)$affiliate_banners_id . "'");
        if (function_exists('imagecreate') && tep_not_null($affiliate_banner_extension)) {
        }
        $messageStack->add_session(SUCCESS_BANNER_REMOVED, 'success');
        tep_redirect(tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page']));
        break;
    }
  }
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=300,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ($action == 'new') {
    $form_action = 'insert';
    $parameters = array(
                        'affiliate_category' => '',
                        'affiliate_products_id' => '',
                        'affiliate_banners_title' => '',
                        'affiliate_banners_image' => '');
    $abInfo = new objectInfo($parameters);
    if (isset($_GET['abID'])) {
      $form_action = 'update';
      $abID = tep_db_prepare_input($_GET['abID']);
      $affiliate_banner_query = tep_db_query("select affiliate_banners_title, affiliate_products_id, affiliate_category_id, affiliate_banners_image, affiliate_status from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . (int)$abID . "'");
      $affiliate_banner = tep_db_fetch_array($affiliate_banner_query);
      $abInfo->objectInfo($affiliate_banner);
    } elseif (tep_not_null($_POST)) {
      $abInfo->objectInfo($_POST);
    }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('new_banner', FILENAME_AFFILIATE_BANNER_MANAGER, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'action=' . $form_action, 'post', 'enctype="multipart/form-data"'); if ($form_action == 'update') echo tep_draw_hidden_field('affiliate_banners_id', $abID); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_TITLE; ?></td>
            <td class="main"><?php echo tep_draw_input_field('affiliate_banners_title', $abInfo->affiliate_banners_title, '', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_LINKED_PRODUCT; ?></td>
            <td class="main"><?php echo tep_draw_input_field('affiliate_products_id', $abInfo->affiliate_products_id, '', false); ?></td>
          </tr>
          <tr>
            <td class="main" colspan=2><?php echo TEXT_BANNERS_LINKED_PRODUCT_NOTE ?></td>
          </tr>
          <tr>
            <td class="main" colspan=2>&nbsp;&nbsp;<?php echo '<a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_AFFILIATE_VALIDPRODUCTS) . '\')"><strong>' . TEXT_AFFILIATE_VALIDPRODUCTS . '</strong></a>'; ?>&nbsp;&nbsp;<?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_VIEW;?></td>
          </tr>
          <tr>
            <td class="main" colspan=2><?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_HELP;?> </td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_LINKED_CATEGORY; ?></td>
            <td class="main"><?php echo tep_draw_input_field('affiliate_category_id', $abInfo->affiliate_category_id, '', false); ?></td>
          </tr>
          <tr>
            <td class="main" colspan=2><?php echo TEXT_BANNERS_LINKED_CATEGORY_NOTE ?></td>
          </tr>
          <tr>
            <td class="main" colspan=2>&nbsp;&nbsp;<?php echo '<a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_AFFILIATE_VALIDCATS) . '\')"><strong>' . TEXT_AFFILIATE_VALIDPRODUCTS . '</strong></a>'; ?>&nbsp;&nbsp;<?php echo TEXT_AFFILIATE_CATEGORY_BANNER_VIEW;?></td>
          </tr>
          <tr>
            <td class="main" colspan=2><?php echo TEXT_AFFILIATE_CATEGORY_BANNER_HELP;?> </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
            <td class="main" valign="top"><?php echo TEXT_BANNERS_IMAGE; ?></td>
            <td class="main"><?php echo tep_draw_file_field('affiliate_banners_image') . ' ' . TEXT_BANNERS_IMAGE_LOCAL . '<br />' . DIR_FS_CATALOG_IMAGES . tep_draw_input_field('affiliate_banners_image_local', (isset($abInfo->affiliate_banners_image) ? $abInfo->affiliate_banners_image : '')); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_IMAGE_TARGET; ?></td>
            <td class="main"><?php echo DIR_FS_CATALOG_IMAGES . tep_draw_input_field('affiliate_banners_image_target'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
        </table>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>

            <td class="smallText" align="right" valign="top" nowrap><?php echo tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset($_GET['abID']) ? 'abID=' . $_GET['abID'] : ''))); ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_BANNERS; ?></td>                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_CATEGORY_ID; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRODUCT_ID; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATISTICS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $affiliate_banners_query_raw = "select affiliate_banners_id, affiliate_banners_title, affiliate_banners_image, affiliate_status, affiliate_products_id, affiliate_category_id from " . TABLE_AFFILIATE_BANNERS . " order by affiliate_banners_title";
    $affiliate_banners_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $affiliate_banners_query_raw, $affiliate_banners_query_numrows);
    $affiliate_banners_query = tep_db_query($affiliate_banners_query_raw);
    while ($affiliate_banners = tep_db_fetch_array($affiliate_banners_query)) {
      $info_query = tep_db_query("select sum(affiliate_banners_shown) as affiliate_banners_shown, sum(affiliate_banners_clicks) as affiliate_banners_clicks from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . $affiliate_banners['affiliate_banners_id'] . "'");
      $info = tep_db_fetch_array($info_query);
      if (((!$_GET['abID']) || ($_GET['abID'] == $affiliate_banners['affiliate_banners_id'])) && (!$abInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
        $abInfo_array = array_merge($affiliate_banners, $info);
        $abInfo = new objectInfo($abInfo_array);
      }
      $affiliate_banners_shown = ($info['affiliate_banners_shown'] != '') ? $info['affiliate_banners_shown'] : '0';
      $affiliate_banners_clicked = ($info['affiliate_banners_clicks'] != '') ? $info['affiliate_banners_clicks'] : '0';
      if ( (is_object($abInfo)) && ($affiliate_banners['affiliate_banners_id'] == $abInfo->affiliate_banners_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_AFFILIATE_BANNERS,'abID=' . $abInfo->affiliate_banners_id . '&action=new')  . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_AFFILIATE_BANNERS, 'abID=' . $affiliate_banners['affiliate_banners_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="javascript:popupImageWindow(\'' . FILENAME_AFFILIATE_POPUP_IMAGE . '?banner=' . $affiliate_banners['affiliate_banners_id'] . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_popup.gif', ICON_PREVIEW) . '</a>&nbsp;' . $affiliate_banners['affiliate_banners_title']; ?></td>
                <td class="dataTableContent" align="right"><?php if ($affiliate_banners['affiliate_category_id']>0) echo $affiliate_banners['affiliate_category_id']; else echo '&nbsp;'; ?></td>
                <td class="dataTableContent" align="right"><?php if ($affiliate_banners['affiliate_products_id']>0) echo $affiliate_banners['affiliate_products_id']; else echo '&nbsp;'; ?></td>
                <td class="dataTableContent" align="right"><?php echo $affiliate_banners_shown . ' / ' . $affiliate_banners_clicked; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($abInfo)) && ($affiliate_banners['affiliate_banners_id'] == $abInfo->affiliate_banners_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'selected_box=affiliate&page=' . $_GET['page'] . '&abID=' . $affiliate_banners['affiliate_banners_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $affiliate_banners_split->display_count($affiliate_banners_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_BANNERS); ?></td>
                    <td class="smallText" align="right"><?php echo $affiliate_banners_split->display_links($affiliate_banners_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                  <tr>
                    <td class="smallText" align="right" colspan="2"><?php echo tep_draw_button(IMAGE_NEW_BANNER, 'plus', tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'action=new')); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<strong>' . $abInfo->affiliate_banners_title . '</strong>');

      $contents = array('form' => tep_draw_form('affiliate_banners', FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><strong>' . $abInfo->affiliate_banners_title . '</strong>');
      if ($abInfo->affiliate_banners_image) $contents[] = array('text' => '<br />' . tep_draw_checkbox_field('delete_image', 'on', true) . ' ' . TEXT_INFO_DELETE_IMAGE);
      $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_DELETE, 'trash', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID'])));
      break;
    default:
      if (is_object($abInfo)) {
        $sql = "select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $abInfo->affiliate_products_id . "' and language_id = '" . $languages_id . "'";
        $product_description_query = tep_db_query($sql);
        $product_description = tep_db_fetch_array($product_description_query);
        $heading[] = array('text' => '<strong>' . $abInfo->affiliate_banners_title . '</strong>');
        $contents[] = array('align' => 'center', 'text' => tep_draw_button(IMAGE_EDIT, 'document', tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=new')) . tep_draw_button(IMAGE_DELETE, 'trash', tep_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=delete')) );
        if ($abInfo->affiliate_date_status_change) $contents[] = array('text' => '<br />' . sprintf(TEXT_BANNERS_STATUS_CHANGE, tep_date_short($abInfo->affiliate_date_status_change)));
      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";
    $box = new box;
    echo $box->infoBox($heading, $contents);
    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
