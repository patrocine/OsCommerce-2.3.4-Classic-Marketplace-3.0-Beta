<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<?php
  if ($messageStack->size('account') > 0) {
    echo $messageStack->output('account');
  }
?>

<div class="contentContainer">
  <h2><?php echo MY_ACCOUNT_TITLE; ?></h2>

  <div class="contentText">
    <ul class="accountLinkList">
      <li><span class="ui-icon ui-icon-person accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . MY_ACCOUNT_INFORMATION . '</a>'; ?></li>
      <li><span class="ui-icon ui-icon-home accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . MY_ACCOUNT_ADDRESS_BOOK . '</a>'; ?></li>
      <li><span class="ui-icon ui-icon-key accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL') . '">' . MY_ACCOUNT_PASSWORD . '</a>'; ?></li>
    </ul>
  </div>

  <h2><?php echo MY_ORDERS_TITLE; ?></h2>

  <div class="contentText">
    <ul class="accountLinkList">
      <li><span class="ui-icon ui-icon-cart accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . MY_ORDERS_VIEW . '</a>'; ?></li>
    </ul>
  </div>

  <h2><?php echo EMAIL_NOTIFICATIONS_TITLE; ?></h2>
  
  

<!-- // Points/Rewards Module V2.1beta points_system_box_bof //-->
<?php
    if (USE_POINTS_SYSTEM == 'true') {
?>
  <h2><?php echo MY_POINTS_TITLE; ?></h2>

  <div class="contentText">
	<ul class="accountLinkList">
	<?php
	  $has_points = tep_get_shopping_points($customer_id);
	  if ($has_points > 0) {
	?>
	  <li><span class="ui-icon ui-icon-cart accountLinkListEntry"></span><?php echo sprintf(MY_POINTS_CURRENT_BALANCE, number_format($has_points,POINTS_DECIMAL_PLACES),$currencies->format(tep_calc_shopping_pvalue($has_points))); ?></li>
	<?php
	  }
	?>
    <li><span class="ui-icon ui-icon-cart accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_MY_POINTS, '', 'SSL') . '">' . MY_POINTS_VIEW . '</a>'; ?></li>
    <li><span class="ui-icon ui-icon-cart accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_MY_POINTS_HELP, '', 'SSL') . '">' . MY_POINTS_VIEW_HELP . '</a>'; ?></li>
    </ul>
  </div>
<?php } ?>
  
  

  <div class="contentText">
    <ul class="accountLinkList">
      <li><span class="ui-icon ui-icon-mail-closed accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a>'; ?></li>
      <li><span class="ui-icon ui-icon-heart accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_PRODUCTS . '</a>'; ?></li>
    </ul>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
