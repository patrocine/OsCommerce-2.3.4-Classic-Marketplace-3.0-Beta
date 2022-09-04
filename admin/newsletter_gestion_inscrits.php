<?php
/*
  $Id: newsletter_gestion_inscrits.php le 05 Avril 2012

  Auteur : Brouillard s'embrouille (brouillard-sembrouille@laposte.net)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
     case 'update':
      $abonnement_id = tep_db_prepare_input($_GET['aID']);
      $abonnement_addresse_email = tep_db_prepare_input($_POST['abonnementaddresseemail']);
      $abonnement_newsletter = tep_db_prepare_input($_POST['abonnementnewsletter']);

      $sql_data_array = array('abonnement_addresse_email' => $abonnement_addresse_email,
                              'abonnement_newsletter' => $abonnement_newsletter);

        tep_db_perform(TABLE_NEWSLETTER_ABONNEMENT, $sql_data_array, 'update', "abonnement_id = '" . tep_db_input($abonnement_id) . "'");

        tep_db_query("update " . TABLE_CUSTOMERS . " set customers_newsletter = '" . (int)$abonnement_newsletter . "' where customers_email_address = '" . $abonnement_addresse_email . "'");

        tep_redirect(tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID', 'action')) . 'aID=' . $abonnement_id));
        break;

      case 'deleteconfirm':
        $abonnement_id = tep_db_prepare_input($_GET['aID']);
        $abonnement_addresse_email = tep_db_prepare_input($_GET['Aemail']);

        tep_db_query("delete from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_id = '" . $abonnement_id . "'");

        tep_db_query("update " . TABLE_CUSTOMERS . " set customers_newsletter = '0' where customers_email_address = '" . $abonnement_addresse_email . "'");

        tep_redirect(tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID', 'action')))); 
        break;
    }
  }

  require(DIR_WS_INCLUDES . 'template_top.php');

  if ($_GET['action'] == 'edit') {
     $abonnement_query = tep_db_query("select abonnement_id, abonnement_date_creation, abonnement_addresse_email, abonnement_newsletter from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_id = '" . $_GET['aID'] . "'");

    $abonnement_values = tep_db_fetch_array($abonnement_query);
    $cInfo = new objectInfo($abonnement_values);

    $newsletter_array = array(array('id' => '1', 'text' => TEXT_ABONNE_NEWSLETTER),
                              array('id' => '0', 'text' => TEXT_NONABONNE_NEWSLETTER));
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('maj_abonnement', FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('action')) . 'action=update', 'post', ''); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_INFO_EMAIL; ?></td>
            <td class="main"><?php echo tep_draw_input_field('abonnementaddresseemail', $cInfo->abonnement_addresse_email, 'size=40 maxlength="96"', true); ?></td>
          </tr>
        </table></td>
      </tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_NEWSLETTER; ?></td>
            <td class="main"><?php echo tep_draw_pull_down_menu('abonnementnewsletter', $newsletter_array, $cInfo->abonnement_newsletter); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('action'))) .'">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr></form>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo tep_draw_form('search', FILENAME_NEWSLETTER_GESTION_INSCRITS, '', 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('search'); ?></td>
          </form></tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
             <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_EMAIL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ACCOUNT_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?></td>
              </tr>
<?php
    $search = '1';
    if (isset($_GET['search']) && (tep_not_null($_GET['search'])) ) {
      $keywords = tep_db_input(tep_db_prepare_input($_GET['search']));
      $search = "abonnement_addresse_email like '%" . $keywords . "%'";
    }
     $newsletter_query_raw = "select abonnement_newsletter, abonnement_id, abonnement_date_creation, abonnement_addresse_email from " . TABLE_NEWSLETTER_ABONNEMENT . " where " . $search . " order by abonnement_newsletter desc, abonnement_date_creation desc, abonnement_addresse_email asc";

    $newsletter_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $newsletter_query_raw, $newsletter_query_numrows);
    $newsletter_query = tep_db_query($newsletter_query_raw);
    while ($newsletter_values = tep_db_fetch_array($newsletter_query)) {

      if ((!isset($_GET['aID']) || (isset($_GET['aID']) && ($_GET['aID'] == $newsletter_values['abonnement_id']))) && !isset($cInfo)) {
        $cInfo_array = $newsletter_values;
        $cInfo = new objectInfo($cInfo_array);
      }

      if (isset($cInfo) && is_object($cInfo) && ($newsletter_values['abonnement_id'] == $cInfo->abonnement_id)) {
        echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID', 'action')) . 'aID=' . $cInfo->abonnement_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID')) . 'aID=' . $newsletter_values['abonnement_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo $newsletter_values['abonnement_addresse_email']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($newsletter_values['abonnement_newsletter'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10);

      } else {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
                <td class="dataTableContent" align="right"><?php if ( isset($cInfo) && is_object($cInfo) && ($newsletter_values['abonnement_id'] == $cInfo->abonnement_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID')) . 'aID=' . $newsletter_values['abonnement_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $newsletter_split->display_count($newsletter_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER); ?></td>
                    <td class="smallText" align="right"><?php echo $newsletter_split->display_links($newsletter_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y', 'aID'))); ?></td>
                  </tr>
<?php
    if (tep_not_null($_GET['search'])) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS) . '">' . tep_image_button('button_reset.gif', IMAGE_RESET) . '</a>'; ?></td>
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
  switch ($_GET['action']) {
    case 'confirm':
      $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_DELETE . '</strong>');

      $contents = array('form' => tep_draw_form('delete_abonnement', FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID', 'action')) . 'aID=' . $cInfo->abonnement_id . '&Aemail=' . $cInfo->abonnement_addresse_email . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO . '<br /><br /><strong>' . $cInfo->abonnement_addresse_email . '</strong>');
      $contents[] = array('align' => 'center', 'text' => '<br />' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID', 'action')) . 'aID=' . $cInfo->abonnement_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<strong>' . $cInfo->abonnement_addresse_email . '</strong>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID', 'action')) . 'aID=' . $cInfo->abonnement_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_NEWSLETTER_GESTION_INSCRITS, tep_get_all_get_params(array('aID', 'action')) . 'aID=' . $cInfo->abonnement_id . '&action=confirm') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
      $contents[] = array('text' => TEXT_ABONNEMENT_DATE_CREATION . tep_date_short($cInfo->abonnement_date_creation) . '<br /><br />' . TEXT_INFO_EMAIL . $cInfo->abonnement_addresse_email);
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
