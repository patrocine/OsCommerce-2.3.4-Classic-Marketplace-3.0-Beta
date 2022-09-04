<?php
/*
  $Id: ask_a_question.php,v 2.3.4 2013/06/25 17:35:01 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  cORRECTED BY DANNY 2011

*/

  require('includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ASK_QUESTION);
    
if (!tep_session_is_registered('customer_id') && (ALLOW_ASK_A_QUESTION != 'true')) {
  // is guests are not allowed to ask a question and customer is not logged in return to product page
  tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']));
}

  $valid_product = false;
  if (isset($HTTP_GET_VARS['products_id'])) {
    $product_info_query = tep_db_query("select pd.products_name, p.products_model, p.manufacturers_id, p.products_image, p.image_folder, p.image_display from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
    if (tep_db_num_rows($product_info_query)) {
      $valid_product = true;
      $product_info = tep_db_fetch_array($product_info_query);
    }
  }

  if ($valid_product == false) {
    tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']));
  }
  $product_info_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = " . (int)$product_info['manufacturers_id']);
  $mfg = tep_db_fetch_array($product_info_query);
 
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
    $error = false;
    $from_email_address = tep_db_prepare_input($HTTP_POST_VARS['from_email_address']);
    $from_name = tep_db_prepare_input($HTTP_POST_VARS['from_name']);
    $message = tep_db_prepare_input($HTTP_POST_VARS['message']);
//Remove any newline and anything after it on the header fields of the mail.
    $from_name = preg_replace('/[\n|\r].*/', '', $from_name);
//Dont send any injection type mails.
    $from_name = preg_replace('/Content-Type:.*/i', '', $from_name);

    if (empty($from_name)) {
      $error = true;
      $messageStack->add('ask_quest', ERROR_FROM_NAME);
    }

    if (!tep_validate_email($from_email_address)) {
      $error = true;
      $messageStack->add('ask_quest', ERROR_FROM_ADDRESS);
    }

    if (!tep_not_null($message)) {
      $error = true;
      $messageStack->add('ask_quest', ERROR_MESSAGE);
    }

    if ((stripos($message, 'href=') !== false) || (stripos($message, 'http://') !== false) || (stripos($message, 'https://') !== false)) {
      $error = true;
      $messageStack->add('friend', ERROR_HAS_LINK);
    }
    
    if (substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], '.php') + 4) != tep_href_link(FILENAME_ASK_QUESTION)) {
      $error = true;
      $messageStack->add('friend', ERROR_INVALID_ACCESS);
    }

    if ($error == false) {
      $email_subject = sprintf(TEXT_EMAIL_SUBJECT, $from_name, STORE_NAME);
      $email_body = sprintf(TEXT_EMAIL_INTRO, STORE_OWNER, $from_name, $product_info['products_name'], $mfg['manufacturers_name'] . ' ' . $product_info['products_model']) . "\n\n";

      $email_body .= $message . "\n\n";

      $email_body .= sprintf(TEXT_EMAIL_LINK, tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id'])) . "\n\n" .
                     sprintf(TEXT_EMAIL_SIGNATURE, STORE_NAME . "\n" . HTTP_SERVER . DIR_WS_CATALOG . "\n");

      tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $email_subject, $email_body, $from_name, $from_email_address);

      $messageStack->add_session('header', sprintf(TEXT_EMAIL_SUCCESSFUL_SENT, $product_info['products_name']), 'success');

      tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']));
    }
  } elseif (tep_session_is_registered('customer_id')) {
    $account_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
    $account = tep_db_fetch_array($account_query);

    $from_name = $account['customers_firstname'] . ' ' . $account['customers_lastname'];
    $from_email_address = $account['customers_email_address'];
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_ASK_QUESTION, 'products_id=' . $HTTP_GET_VARS['products_id']));
  
  
  require(DIR_WS_INCLUDES . 'template_top.php');
  
  echo '<p style="float: right;">';
  if ($product_info['image_display'] == 1) {
    echo tep_image(DIR_WS_LANGUAGES . $language . '/images/' . 'no_picture.gif', TEXT_NO_PICTURE, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
  } elseif (($product_info['image_display'] != 2) && tep_not_null($product_info['products_image'])) {
    echo tep_image(DIR_WS_IMAGES . $product_info['image_folder'] . $product_info['products_image'], $product_info['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
  }
  echo "</p>\n";
?>

<h1><?php echo HEADING_TITLE . '<br />' . $product_info['products_name'] . '<br /><span class="smallText">[' . $mfg['manufacturers_name'] . ' ' . $product_info['products_model'] . ']</span>'; ?></h1>
<div style="clear: both"></div>
<?php
  if ($messageStack->size('ask_quest') > 0) {
    echo $messageStack->output('ask_quest');
  }

 echo tep_draw_form('ask_question', tep_href_link(FILENAME_ASK_QUESTION, 'action=process&products_id=' . $HTTP_GET_VARS['products_id'])); ?>
<div class="contentContainer">
  <div>
    <div class="inputRequirement" style="float: right;"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
    <h2><?php echo FORM_TITLE_CUSTOMER_DETAILS; ?></h2>
  </div>
  <div class="contentText">
    <table border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main"><?php echo FORM_FIELD_CUSTOMER_NAME; ?></td>
        <td class="main"><?php echo tep_draw_input_field('from_name', $from_name, 'size="40"'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo FORM_FIELD_CUSTOMER_EMAIL; ?></td>
        <td class="main"><?php echo tep_draw_input_field('from_email_address', $from_email_address, 'size="40"'); ?></td>
      </tr>
    </table>
  <div>
    <div class="inputRequirement" style="float: right;"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
    <h2><?php echo FORM_TITLE_FRIEND_MESSAGE; ?></h2>
  </div>
    <?php echo tep_draw_textarea_field('message', 'soft', 40, 8); ?> 
    <p>&nbsp;</p>
    <div class="buttonSet">
      <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', null, 'primary'); ?></span>
      <?php echo tep_draw_button(IMAGE_BUTTON_BACK, 'triangle-1-w', tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id'])); ?>
    </div>
  </div>
</div>
</form>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
