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
  if (!tep_session_is_registered('affiliate_id')) {
  $navigation->set_snapshot();
  tep_redirect(tep_href_link(FILENAME_AFFILIATE, '', 'SSL'));
  }
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_NEWS);
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_NEWS));
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<h1><?php echo HEADING_TITLE; ?></h1>
<div class="contentContainer">
  <div class="contentText">
<?php
    $affiliate_news_query = tep_db_query('select affiliate_news_headlines, affiliate_news_contents ,date_added, news_status from ' . TABLE_AFFILIATE_NEWS . ', ' . TABLE_AFFILIATE_NEWS_CONTENTS . " where news_id = affiliate_news_id and affiliate_news_languages_id = '" . (int)$languages_id . "' and news_status = 1 order by date_added desc");
    $row = 0;
    while ($affiliate_news = tep_db_fetch_array($affiliate_news_query)) {
    echo '<strong>' . $affiliate_news['affiliate_news_headlines'] . '</strong> - <i>' . tep_date_long($affiliate_news['date_added']) . '</i><br />' . nl2br($affiliate_news['affiliate_news_contents']) . '<br /><hr /><br />';
     $row++;
    }
?>
  </div>
</div>
  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_AFFILIATE)); ?></span>
  </div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>