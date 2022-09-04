<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  $photo_status_array = array(array('id'=>'1', 'text'=>'Active'), array('id'=>'0', 'text'=>'Inactive'));
  //Image Gallery
  $photo_gallery_images_dir = 'gallery/';

  if (tep_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($HTTP_GET_VARS['pID'])) $gallery_photo_id = tep_db_prepare_input($HTTP_GET_VARS['pID']);
        $gallery_photo_title = tep_db_prepare_input($HTTP_POST_VARS['gallery_photo_title']);
		$products_model = tep_db_prepare_input($HTTP_POST_VARS['products_model']);
		$gallery_photo_order = tep_db_prepare_input($HTTP_POST_VARS['gallery_photo_order']);
		$gallery_photo_status = tep_db_prepare_input($HTTP_POST_VARS['gallery_photo_status']);

        $sql_data_array = array(
			'products_model' => $products_model,
			'gallery_photo_title' => $gallery_photo_title,
			'gallery_photo_order' => $gallery_photo_order,
			'gallery_photo_status' => $gallery_photo_status
		);

        if ($action == 'insert') {
          $insert_sql_data = array('gallery_photo_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          tep_db_perform(TABLE_GALLERY_PHOTOS, $sql_data_array);
          $gallery_photo_id = tep_db_insert_id();
        } elseif ($action == 'save') {
          $sql_data_array = $sql_data_array;

          tep_db_perform(TABLE_GALLERY_PHOTOS, $sql_data_array, 'update', "gallery_photo_id = '" . (int)$gallery_photo_id . "'");
        }

        $photos_image = new upload('gallery_photo');
        $photos_image->set_destination(DIR_FS_CATALOG_IMAGES . $photo_gallery_images_dir);

        if ($photos_image->parse() && $photos_image->save()) {
          tep_db_query("update " . TABLE_GALLERY_PHOTOS . " set gallery_photo = '" . tep_db_input($photos_image->filename) . "' where gallery_photo_id = '" . (int)$gallery_photo_id . "'");
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('gallery_photos');
        }

        tep_redirect(tep_href_link(FILENAME_GALLERY_PHOTOS, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'pID=' . $gallery_photo_id));
        break;
      case 'deleteconfirm':
        $gallery_photo_id = tep_db_prepare_input($HTTP_GET_VARS['pID']);

	     $gallery_photo_query = tep_db_query("select gallery_photo from " . TABLE_GALLERY_PHOTOS . " where gallery_photo_id = '" . (int)$gallery_photo_id . "'");
         $gallery_photo = tep_db_fetch_array($gallery_photo_query);

          $image_location = DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG_IMAGES . $photo_gallery_images_dir . $gallery_photo['gallery_photo'];

          if (file_exists($image_location)) @unlink($image_location);

          tep_db_query("delete from " . TABLE_GALLERY_PHOTOS . " where gallery_photo_id = '" . (int)$gallery_photo_id . "'");

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('gallery_photos');
        }

        tep_redirect(tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page']));
        break;
    }
  }

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo 'IDpro'; ?></td>
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PHOTO_TITLE; ?></td>
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PHOTO_ORDER; ?></td>
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PHOTO_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $photos_query_raw = "select gallery_photo_id, products_model, gallery_photo_title, gallery_photo, gallery_photo_order, gallery_photo_status, gallery_photo_added from " .  TABLE_GALLERY_PHOTOS . " order by gallery_photo_order";
  $photos_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $photos_query_raw, $photos_query_numrows);
  $photos_query = tep_db_query($photos_query_raw);
  while ($photos = tep_db_fetch_array($photos_query)) {
    if ((!isset($HTTP_GET_VARS['pID']) || (isset($HTTP_GET_VARS['pID']) && ($HTTP_GET_VARS['pID'] == $photos['gallery_photo_id']))) && !isset($pInfo) && (substr($action, 0, 3) != 'new')) {
      $pInfo = new objectInfo($photos);
    }

    if (isset($pInfo) && is_object($pInfo) && ($photos['gallery_photo_id'] == $pInfo->gallery_photo_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $photos['gallery_photo_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $photos['gallery_photo_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $photos['products_model']; ?></td>
				<td class="dataTableContent"><?php echo $photos['gallery_photo_title']; ?></td>
				<td class="dataTableContent"><?php echo ($photos['gallery_photo_order'] != '999' ? $photos['gallery_photo_order'] : '-'); ?></td>
				<td class="dataTableContent"><?php echo ($photos['gallery_photo_status'] == '1' ? 'Active' : 'Inactive'); ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($pInfo) && is_object($pInfo) && ($photos['gallery_photo_id'] == $pInfo->gallery_photo_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $photos['gallery_photo_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $photos_split->display_count($photos_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_GALLERY_PHOTOS); ?></td>
                    <td class="smallText" align="right"><?php echo $photos_split->display_links($photos_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="4" class="smallText"><?php echo tep_draw_button(IMAGE_INSERT, 'plus', tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $pInfo->gallery_photo_id . '&action=new')); ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<strong>' . TEXT_HEADING_NEW_PHOTO . '</strong>');

      $contents = array('form' => tep_draw_form('gallery_photos', FILENAME_GALLERY_PHOTOS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => '<br />' . 'Id del Producto' . '<br />' . tep_draw_input_field('products_model'));
      $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_TITLE . '<br />' . tep_draw_input_field('gallery_photo_title'));
      $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_IMAGE . '<br />' . tep_draw_file_field('gallery_photo'));
	  $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_SORT_ORDER . '<br />' . tep_draw_input_field('gallery_photo_order'));

	  $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_STATUS . '<br />' . tep_draw_pull_down_menu('gallery_photo_status', $photo_status_array));

      $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $HTTP_GET_VARS['pID'])));
      break;
    case 'edit':
      $heading[] = array('text' => '<strong>' . TEXT_HEADING_EDIT_PHOTO . '</strong>');

      $contents = array('form' => tep_draw_form('gallery_photos', FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $pInfo->gallery_photo_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);

	  $contents[] = array('text' => '<br />' . 'Id del Producto' . '<br />' . tep_draw_input_field('products_model', $pInfo->products_model));
       $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_TITLE . '<br />' . tep_draw_input_field('gallery_photo_title', $pInfo->gallery_photo_title));
      $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_IMAGE . '<br />' . tep_draw_file_field('gallery_photo') . '<br />' . $pInfo->gallery_photo);
	  $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_STATUS . '<br />' . tep_draw_pull_down_menu('gallery_photo_status', $photo_status_array, $pInfo->gallery_photo_status));
	  $contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_SORT_ORDER . '<br />' . tep_draw_input_field('gallery_photo_order', ($pInfo->gallery_photo_order != '999' ? $pInfo->gallery_photo_order : '-')));

      $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $pInfo->gallery_photo_id)));
      break;
    case 'delete':
      $heading[] = array('text' => '<strong>' . TEXT_HEADING_DELETE_PHOTO . '</strong>');

      $contents = array('form' => tep_draw_form('gallery_photos', FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $pInfo->gallery_photo_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><strong>' . $pInfo->gallery_photo_title . '</strong>');

      $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_DELETE, 'trash', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $pInfo->gallery_photo_id)));
      break;
    default:
      if (isset($pInfo) && is_object($pInfo)) {
        $heading[] = array('text' => '<strong>' . $pInfo->gallery_photo_title . '</strong>');

        $contents[] = array('align' => 'center', 'text' => tep_draw_button(IMAGE_EDIT, 'document', tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $pInfo->gallery_photo_id . '&action=edit')) . tep_draw_button(IMAGE_DELETE, 'trash', tep_href_link(FILENAME_GALLERY_PHOTOS, 'page=' . $HTTP_GET_VARS['page'] . '&pID=' . $pInfo->gallery_photo_id . '&action=delete')));

		$contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_SORT_ORDER . ' ' . ($pInfo->gallery_photo_order != '999' ? $pInfo->gallery_photo_order : '-'));
		$contents[] = array('text' => '<br />' . TEXT_GALLERY_PHOTOS_STATUS . ' ' . ($pInfo->gallery_photo_status == '1' ? 'Active' : 'Inactive'));

        $contents[] = array('text' => '<br />' . TEXT_DATE_ADDED . ' ' . tep_date_short($pInfo->gallery_photo_added));
        if($pInfo->gallery_photo != '')$contents[] = array('text' => '<br />' . tep_info_image($photo_gallery_images_dir . $pInfo->gallery_photo, $pInfo->gallery_photo, 150, 150));
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
    </table>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
