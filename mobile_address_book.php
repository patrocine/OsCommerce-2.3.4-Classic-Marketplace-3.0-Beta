<?php
require_once('mobile/includes/application_top.php');
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_mobile_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_ADDRESS_BOOK));

  $breadcrumb->add(NAVBAR_TITLE_1, tep_mobile_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_mobile_link(FILENAME_MOBILE_ADDRESS_BOOK, '', 'SSL'));
require(DIR_MOBILE_INCLUDES . 'header.php');
$headerTitle->write();
?>
<div id="iphone_content">
<?php
  if ($messageStack->size('addressbook') > 0) {
?>
<div id="messageStack">
      <?php echo $messageStack->output('addressbook'); ?>
</div>
<?php
  }
?>
<div id="accthistpl">
<?php
  $addresses_query = tep_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' order by firstname, lastname");
  while ($addresses = tep_db_fetch_array($addresses_query)) {
    $format_id = tep_get_address_format_id($addresses['country_id']);
    $link = tep_mobile_link(FILENAME_MOBILE_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL');
    $text = array();
    $text[] = ($addresses['address_book_id'] == $customer_default_address_id) ? '<b>' . PRIMARY_ADDRESS . '</b><br>' : '<a href="' . tep_href_link(FILENAME_MOBILE_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL') . '">' . tep_mobile_button(IMAGE_BUTTON_DELETE) . '</a>';
    $text[] = '<div id="acctHist">' . tep_address_format($format_id, $addresses, true, ' ', '<br>') . '</div><div class="fleche"><span style="position:relative; top:-10px;">' . SMALL_IMAGE_BUTTON_EDIT . '</span><img src="' . DIR_WS_HTTP_CATALOG . DIR_MOBILE_IMAGES . 'arrow_select.png" /></div>';
    echo tep_mobile_selection($link, $text);
}
?>
<?php
  if (tep_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {
?>
		<div id="bouton" style="text-align:left;">
		<?php echo '<a href="' . tep_href_link(FILENAME_MOBILE_ACCOUNT, '', 'SSL') . '">' . tep_mobile_button(IMAGE_BUTTON_BACK) . '</a>' . 
			   '<span style="float:right;"><a href="' . tep_href_link(FILENAME_MOBILE_ADDRESS_BOOK_PROCESS, '', 'SSL') . '">' . tep_mobile_button(IMAGE_BUTTON_ADD_ADDRESS) . '</a></span>';?>
		</div>
<?php
  }
?>
		<div id="maxentries">
      <?php echo sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES); ?>
	  </div>
	  </div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
