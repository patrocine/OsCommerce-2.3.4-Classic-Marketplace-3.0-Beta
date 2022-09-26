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
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_BANNERS_BUILD_CAT);
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_AFFILIATE_BANNERS_BUILD_CAT));
  $affiliate_banners_values = tep_db_query("select * from " . TABLE_AFFILIATE_BANNERS . " order by affiliate_banners_title");
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<h1><?php echo HEADING_TITLE; ?></h1>
<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_INFORMATION; ?>
  </div>
       <div class="contentText">
            <p><?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER . ' ' . $affiliate_banners['affiliate_banners_title']; ?></p>
            <p><?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_INFO . tep_draw_form('individual_banner', tep_href_link(FILENAME_AFFILIATE_BANNERS_BUILD_CAT) ) . "\n" . tep_draw_input_field('individual_banner_id', '', 'size="5"') . "&nbsp;&nbsp;" . tep_draw_button(IMAGE_BUTTON_BUILD_A_CAT_LINK, 'link', null, 'primary'); ?></form></p>
            <p><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_AFFILIATE_VALIDCATS) . '\')"><strong>' . TEXT_AFFILIATE_VALIDPRODUCTS . '</strong></a>'; ?>&nbsp;&nbsp;<?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_VIEW;?><br /><?php echo TEXT_AFFILIATE_INDIVIDUAL_BANNER_HELP;?></p>
       </div>
  <div class="contentText">
<?php
  if (tep_not_null($_POST['individual_banner_id']) || tep_not_null($_GET['individual_banner_id'])) {

    if (tep_not_null($_POST['individual_banner_id'])) $individual_banner_id = $_POST['individual_banner_id'];
    if ($_GET['individual_banner_id']) $individual_banner_id = $_GET['individual_banner_id'];
    $affiliate_pbanners_values = tep_db_query("select c.categories_image, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $individual_banner_id . "' and cd.categories_id = '" . $individual_banner_id . "' and cd.language_id = '" . (int)$languages_id . "'");
    if ($affiliate_pbanners = tep_db_fetch_array($affiliate_pbanners_values)) {
      switch (AFFILIATE_KIND_OF_BANNERS) {
        case 1:
   			$link = '<a href="' . HTTPS_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTPS_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $affiliate_pbanners['affiliate_banners_image'] . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link1 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $affiliate_pbanners['affiliate_banners_image'] . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link2 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank">' . $affiliate_pbanners['categories_name'] . '</a>'; 
   		break;
  		case 2:
   // Link to Products
   			$link = '<a href="' . HTTPS_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTPS_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_AFFILIATE_SHOW_BANNER . '?ref=' . $affiliate_id . '&affiliate_pbanner_id=' . $individual_banner_id . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link1 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank"><img src="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_AFFILIATE_SHOW_BANNER . '?ref=' . $affiliate_id . '&affiliate_pbanner_id=' . $individual_banner_id . '" border="0" alt="' . $affiliate_pbanners['categories_name'] . '"></a>';
   			$link2 = '<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT . '?ref=' . $affiliate_id . '&cPath=' . $individual_banner_id . '&affiliate_banner_id=1" target="_blank">' . $affiliate_pbanners['categories_name'] . '</a>';
   		break;
     }
}
?>
</div>
  <div class="contentText">
           <p><?php echo TEXT_AFFILIATE_NAME; ?>&nbsp;<?php echo $affiliate_pbanners['categories_name']; ?></p>
           <p><?php echo $link; ?></p>
           <p><?php echo TEXT_AFFILIATE_INFO; ?></p>
           <p><textarea cols="60" rows="4" class="boxText"><?php echo $link1; ?></textarea></p>
           <p><strong>Text Version:</strong> <?php echo $link2; ?></p>
           <p><?php echo TEXT_AFFILIATE_INFO; ?></p>
           <P><textarea cols="60" rows="3" class="boxText"><?php echo $link2; ?></textarea></P>
<?php
}
?>
</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>