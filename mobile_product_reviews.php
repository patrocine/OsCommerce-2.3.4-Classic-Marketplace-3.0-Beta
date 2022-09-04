<?php
require_once('mobile/includes/application_top.php');
require(DIR_MOBILE_INCLUDES . 'header.php');

  if (!isset($HTTP_GET_VARS['products_id'])) {
        tep_redirect(tep_href_link(FILENAME_REVIEWS));
  }

  $product_info_query = tep_db_query("select p.products_id, p.products_model, p.products_image, p.products_price, p.products_tax_class_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
  if (!tep_db_num_rows($product_info_query)) {
    tep_redirect(tep_href_link(FILENAME_REVIEWS));
  } else {
    $product_info = tep_db_fetch_array($product_info_query);
  }

  if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
    $products_price = '<del>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
  } else {
    $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
  }

  if (tep_not_null($product_info['products_model'])) {
    $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
  } else {
    $products_name = $product_info['products_name'];
  }

  require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_PRODUCT_REVIEWS));

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()));
  
?>
<div id="iphone_content">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
  require(DIR_MOBILE_INCLUDES. "product_header.php");
  $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$product_info['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and r.reviews_status = 1 order by r.reviews_id desc";
  $reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);
  ?>
  <div id="ficheProdMid">
  <?php
  if ($reviews_split->number_of_rows > 0) {
    if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
?>
              <tr>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                    <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
    }

    $reviews_query = tep_db_query($reviews_split->sql_query);
    while ($reviews = tep_db_fetch_array($reviews_query)) {
?>
			  <tr>
              	<td class="main"><?php echo '<a href="' . tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS_INFO, 'products_id=' . $product_info['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '"><u><b>' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($reviews['customers_name'])) . '</b></u></a><br />'; ?></td>
              </tr>
			  <tr>
                <td class="smallText"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($reviews['date_added'])); ?><br /></td>
              </tr>
              <tr>
                <td class="review">
                <?php
                	$review_text = str_replace("\n", "<br>", tep_output_string_protected($reviews['reviews_text']));
                	if($HTTP_GET_VARS['reviews_id'] == $reviews['reviews_id'] || strlen($reviews['reviews_text']) < 100)
                		echo $review_text; 
					else 
               			echo substr($review_text,0,strpos($review_text, ' ' , 50)) . ' ...';
                	echo '<br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i>';
					?>
                </td>
                </td>
              </tr>
		      <tr>
		      	<td><hr class="separator"></td>
		      </tr>

<?php
    }
?>
<?php
  } else {
?>
              <tr>
                <td><?php new infoBox(array(array('text' => TEXT_NO_REVIEWS))); ?></td>
              </tr>
<?php
  }

  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
              <tr>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                    <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
<?php
  }
?>
	<tr>
	<td class="main"><?php echo tep_draw_form('back', tep_mobile_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params())) . tep_mobile_button(IMAGE_BUTTON_BACK) . "</form>"; ?>
	<td class="main"><?php echo tep_draw_form('reviews', tep_mobile_link(FILENAME_MOBILE_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params(array('module')))) . tep_mobile_button(IMAGE_BUTTON_WRITE_REVIEW) . "</form>"; ?>
              </tr>
           </div>
            </table></td>
          </td>
        </table></td>
      </tr>
    </table>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
