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

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_BANNERS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_BANNERS));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div class="contentContainer">


            <h1><?php echo TEXT_INFORMATION; ?></h1>
  <div class="contentText">
       <p><strong><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BANNERS, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS . '</a>';?></strong></p>
                    <p><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10">&nbsp;<?php echo TEXT_INFORMATION_BANNERS_BANNERS ;?></p>
                    <p><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BANNERS, '', 'SSL') . '">' . tep_draw_button(IMAGE_BUTTON_BUILD_BANNER_LINK, 'link', null, 'primary') . '</a>';?></p>
  </div>
  <hr />
   <div class="contentText">
            <p><strong><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_PRODUCT, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS_PRODUCT . '</a>';?></strong></p>
                    <p><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10">&nbsp;<?php echo TEXT_INFORMATION_BANNERS_PRODUCT ;?></p>
                    <p><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_PRODUCT, '', 'SSL') . '">' . tep_draw_button(IMAGE_BUTTON_BUILD_PRODUCT_LINK, 'link', null, 'primary') . '</a>';?></p>
   </div>
     <hr />
      <div class="contentText">
            <p><strong><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BUILD, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS_BUILD . '</a>';?></strong></p>

                    <p><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10">&nbsp;<?php echo TEXT_INFORMATION_BANNERS_BUILD ;?></p>
                    <p><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_BUILD, '', 'SSL') . '">' . tep_draw_button(IMAGE_BUTTON_BUILD_DYN_LINK, 'link', null, 'primary')  . '</a>';?></p>
     </div>
       <hr />
    <div class="contentText">

            <p><strong><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_TEXT, '', 'SSL'). '">' . TEXT_AFFILIATE_BANNERS_TEXT . '</a>';?></strong></p>
            <p><img src="images/arrow_green.gif" border="0" alt="" width="12" height="10">&nbsp;<?php echo TEXT_INFORMATION_BANNERS_TEXT ;?></p>
                    <p><?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS_TEXT, '', 'SSL') . '">' . tep_draw_button(IMAGE_BUTTON_BUILD_TEXT_LINK, 'link', null, 'primary') . '</a>';?></p>
    </div>
    </div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>