<?php
/*
  $Id: affiliate_newsletters.php,v 2.00 2003/10/12

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'lock':
      case 'unlock':
        $affiliate_newsletter_id = tep_db_prepare_input($_GET['nID']);
        $status = (($action == 'lock') ? '1' : '0');

        tep_db_query("update " . TABLE_AFFILIATE_NEWSLETTERS . " set locked = '" . $status . "' where affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");

        tep_redirect(tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']));
        break;
      case 'insert':
      case 'update':
        if (isset($_POST['newsletter_id'])) $affiliate_newsletter_id = tep_db_prepare_input($_POST['newsletter_id']);
        $affiliate_newsletter_module = tep_db_prepare_input($_POST['module']);
        $title = tep_db_prepare_input($_POST['title']);
        $content = tep_db_prepare_input($_POST['content']);

        $affiliate_newsletter_error = false;
        if (empty($title)) {
          $messageStack->add(ERROR_NEWSLETTER_TITLE, 'error');
          $affiliate_newsletter_error = true;
        }

        if (empty($affiliate_newsletter_module)) {
          $messageStack->add(ERROR_NEWSLETTER_MODULE, 'error');
          $affiliate_newsletter_error = true;
        }

        if ($affiliate_newsletter_error == false) {
          $sql_data_array = array('title' => $title,
                                  'content' => $content,
                                  'module' => $affiliate_newsletter_module);

          if ($action == 'insert') {
            $sql_data_array['date_added'] = 'now()';
            $sql_data_array['status'] = '0';
            $sql_data_array['locked'] = '0';

            tep_db_perform(TABLE_AFFILIATE_NEWSLETTERS, $sql_data_array);
            $affiliate_newsletter_id = tep_db_insert_id();
          } elseif ($action == 'update') {
            tep_db_perform(TABLE_AFFILIATE_NEWSLETTERS, $sql_data_array, 'update', "affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");
          }

          tep_redirect(tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'nID=' . $affiliate_newsletter_id));
        } else {
          $action = 'new';
        }
        break;
      case 'deleteconfirm':
        $affiliate_newsletter_id = tep_db_prepare_input($_GET['nID']);

        tep_db_query("delete from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");

        tep_redirect(tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page']));
        break;
      case 'delete':
      case 'new': if (!isset($_GET['nID'])) break;
      case 'send':
      case 'confirm_send':
        $affiliate_newsletter_id = tep_db_prepare_input($_GET['nID']);

        $check_query = tep_db_query("select locked from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$affiliate_newsletter_id . "'");
        $check = tep_db_fetch_array($check_query);

        if ($check['locked'] < 1) {
          switch ($action) {
            case 'delete': $error = ERROR_REMOVE_UNLOCKED_NEWSLETTER; break;
            case 'new': $error = ERROR_EDIT_UNLOCKED_NEWSLETTER; break;
            case 'send': $error = ERROR_SEND_UNLOCKED_NEWSLETTER; break;
            case 'confirm_send': $error = ERROR_SEND_UNLOCKED_NEWSLETTER; break;
          }

          $messageStack->add_session($error, 'error');

          tep_redirect(tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']));
        }
        break;
    }
  }
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<script language="javascript" src="includes/general.js"></script>

<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
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

    $parameters = array('title' => '',
                        'content' => '',
                        'module' => '');

    $nInfo = new objectInfo($parameters);

    if (isset($_GET['nID'])) {
      $form_action = 'update';

      $nID = tep_db_prepare_input($_GET['nID']);

      $affiliate_newsletter_query = tep_db_query("select title, content, module from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$nID . "'");
      $affiliate_newsletter = tep_db_fetch_array($affiliate_newsletter_query);

      $nInfo->objectInfo($affiliate_newsletter);
    } elseif ($_POST) {
      $nInfo->objectInfo($_POST);
    }

    $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
    $directory_array = array();
    if ($dir = dir(DIR_WS_MODULES . 'newsletters/')) {
      while ($file = $dir->read()) {
        if (!is_dir(DIR_WS_MODULES . 'newsletters/' . $file)) {
          if (substr($file, strrpos($file, '.')) == $file_extension) {
            $directory_array[] = $file;
          }
        }
      }
      sort($directory_array);
      $dir->close();
    }

    for ($i=0, $n=sizeof($directory_array); $i<$n; $i++) {
      $modules_array[] = array('id' => substr($directory_array[$i], 0, strrpos($directory_array[$i], '.')), 'text' => substr($directory_array[$i], 0, strrpos($directory_array[$i], '.')));
    }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('newsletter', FILENAME_AFFILIATE_NEWSLETTERS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'action=' . $form_action); if ($form_action == 'update') echo tep_draw_hidden_field('newsletter_id', $nID); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_NEWSLETTER_MODULE; ?></td>
            <td class="main"><?php echo tep_draw_pull_down_menu('module', $modules_array, $nInfo->module); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_NEWSLETTER_TITLE; ?></td>
            <td class="main"><?php echo tep_draw_input_field('title', $nInfo->title, '', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_NEWSLETTER_CONTENT; ?></td>
            <td class="main"><?php echo tep_draw_textarea_field('content', 'soft', '100%', '20', $nInfo->content); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" align="right"><?php echo (($form_action == 'insert') ? tep_draw_button(IMAGE_SAVE) : tep_draw_button(IMAGE_UPDATE)). '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset($_GET['nID']) ? 'nID=' . $_GET['nID'] : '')) . '">' . tep_draw_button(IMAGE_CANCEL) . '</a>'; ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } elseif ($action == 'preview') {
    $nID = tep_db_prepare_input($_GET['nID']);

    $affiliate_newsletter_query = tep_db_query("select title, content, module from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$nID . "'");
    $affiliate_newsletter = tep_db_fetch_array($affiliate_newsletter_query);

    $nInfo = new objectInfo($affiliate_newsletter);
?>
      <tr>
        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']) . '">' . tep_draw_button(IMAGE_BACK) . '</a>'; ?></td>
      </tr>
      <tr>
        <td><tt><?php echo nl2br($nInfo->content); ?></tt></td>
      </tr>
      <tr>
        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']) . '">' . tep_draw_button(IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
  } elseif ($action == 'send') {
    $nID = tep_db_prepare_input($_GET['nID']);

    $affiliate_newsletter_query = tep_db_query("select title, content, module from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$nID . "'");
    $affiliate_newsletter = tep_db_fetch_array($affiliate_newsletter_query);

    $nInfo = new objectInfo($affiliate_newsletter);

    include(DIR_WS_LANGUAGES . $language . '/modules/newsletters/' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.')));
    include(DIR_WS_MODULES . 'newsletters/' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.')));
    $module_name = $nInfo->module;
    $module = new $module_name($nInfo->title, $nInfo->content);
?>
      <tr>
        <td><?php if ($module->show_choose_audience) { echo $module->choose_audience(); } else { echo $module->confirm(); } ?></td>
      </tr>
<?php
  } elseif ($action == 'confirm') {
    $nID = tep_db_prepare_input($_GET['nID']);

    $affiliate_newsletter_query = tep_db_query("select title, content, module from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$nID . "'");
    $affiliate_newsletter = tep_db_fetch_array($affiliate_newsletter_query);

    $nInfo = new objectInfo($affiliate_newsletter);

    include(DIR_WS_LANGUAGES . $language . '/modules/newsletters/' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.')));
    include(DIR_WS_MODULES . 'newsletters/' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.')));
    $module_name = $nInfo->module;
    $module = new $module_name($nInfo->title, $nInfo->content);
?>
      <tr>
        <td><?php echo $module->confirm(); ?></td>
      </tr>
<?php
  } elseif ($action == 'confirm_send') {
    $nID = tep_db_prepare_input($_GET['nID']);

    $affiliate_newsletter_query = tep_db_query("select affiliate_newsletters_id, title, content, module from " . TABLE_AFFILIATE_NEWSLETTERS . " where affiliate_newsletters_id = '" . (int)$nID . "'");
    $affiliate_newsletter = tep_db_fetch_array($affiliate_newsletter_query);

    $nInfo = new objectInfo($affiliate_newsletter);

    include(DIR_WS_LANGUAGES . $language . '/modules/newsletters/' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.')));
    include(DIR_WS_MODULES . 'newsletters/' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.')));
    $module_name = $nInfo->module;
    $module = new $module_name($nInfo->title, $nInfo->content);
?>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" valign="middle"><?php echo tep_image(DIR_WS_IMAGES . 'ani_send_email.gif', IMAGE_ANI_SEND_EMAIL); ?></td>
            <td class="main" valign="middle"><strong><?php echo TEXT_PLEASE_WAIT; ?></strong></td>
          </tr>
        </table></td>
      </tr>
<?php
  tep_set_time_limit(0);
  flush();
  $module->send($nInfo->affiliate_newsletters_id);
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><font color="#ff0000"><strong><?php echo TEXT_FINISHED_SENDING_EMAILS; ?></strong></font></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']) . '">' . tep_draw_button(IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NEWSLETTERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_SIZE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_MODULE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_SENT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $affiliate_newsletters_query_raw = "select affiliate_newsletters_id, title, length(content) as content_length, module, date_added, date_sent, status, locked from " . TABLE_AFFILIATE_NEWSLETTERS . " order by date_added desc";
    $affiliate_newsletters_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $affiliate_newsletters_query_raw, $affiliate_newsletters_query_numrows);
    $affiliate_newsletters_query = tep_db_query($affiliate_newsletters_query_raw);
    while ($affiliate_newsletters = tep_db_fetch_array($affiliate_newsletters_query)) {
    if ((!isset($_GET['nID']) || (isset($_GET['nID']) && ($_GET['nID'] == $affiliate_newsletters['affiliate_newsletters_id']))) && !isset($nInfo) && (substr($action, 0, 3) != 'new')) {
        $nInfo = new objectInfo($affiliate_newsletters);
      }

      if (isset($nInfo) && is_object($nInfo) && ($affiliate_newsletters['affiliate_newsletters_id'] == $nInfo->affiliate_newsletters_id) ) {
        echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=preview') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $affiliate_newsletters['affiliate_newsletters_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $affiliate_newsletters['affiliate_newsletters_id'] . '&action=preview') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $affiliate_newsletters['title']; ?></td>
                <td class="dataTableContent" align="right"><?php echo number_format($affiliate_newsletters['content_length']) . ' bytes'; ?></td>
                <td class="dataTableContent" align="right"><?php echo $affiliate_newsletters['module']; ?></td>
                <td class="dataTableContent" align="center"><?php if ($affiliate_newsletters['status'] == '1') { echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK); } else { echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS); } ?></td>
                <td class="dataTableContent" align="center"><?php if ($affiliate_newsletters['locked'] > 0) { echo tep_image(DIR_WS_ICONS . 'locked.gif', ICON_LOCKED); } else { echo tep_image(DIR_WS_ICONS . 'unlocked.gif', ICON_UNLOCKED); } ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($nInfo) && is_object($nInfo) && ($affiliate_newsletters['affiliate_newsletters_id'] == $nInfo->affiliate_newsletters_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $affiliate_newsletters['affiliate_newsletters_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $affiliate_newsletters_split->display_count($affiliate_newsletters_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS); ?></td>
                    <td class="smallText" align="right"><?php echo $affiliate_newsletters_split->display_links($affiliate_newsletters_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'action=new') . '">' . tep_draw_button(IMAGE_NEW_NEWSLETTER) . '</a>'; ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<strong>' . $nInfo->title . '</strong>');

      $contents = array('form' => tep_draw_form('newsletters', FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><strong>' . $nInfo->title . '</strong>');
      $contents[] = array('align' => 'center', 'text' => '<br />' . tep_draw_button(IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']) . '">' . tep_draw_button(IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($nInfo)) {
        $heading[] = array('text' => '<strong>' . $nInfo->title . '</strong>');

        if ($nInfo->locked > 0) {
          $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=new') . '">' . tep_draw_button(IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=delete') . '">' . tep_draw_button(IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=preview') . '">' . tep_draw_button(IMAGE_PREVIEW) . '</a> <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=send') . '">' . tep_draw_button(IMAGE_SEND) . '</a> <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=unlock') . '">' . tep_draw_button(IMAGE_UNLOCK) . '</a>');
        } else {
          $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=preview') . '">' . tep_draw_button(IMAGE_PREVIEW) . '</a> <a href="' . tep_href_link(FILENAME_AFFILIATE_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $nInfo->affiliate_newsletters_id . '&action=lock') . '">' . tep_draw_button(IMAGE_LOCK) . '</a>');
        }
        $contents[] = array('text' => '<br />' . TEXT_NEWSLETTER_DATE_ADDED . ' ' . tep_date_short($nInfo->date_added));
        if ($nInfo->status == '1') $contents[] = array('text' => TEXT_NEWSLETTER_DATE_SENT . ' ' . tep_date_short($nInfo->date_sent));
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

<?php
  }
?>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
