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

  $navigation->remove_current_page();
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_AFFILIATE_BANNERS_BUILD_CAT);

//require(DIR_WS_INCLUDES . 'template_top.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo $products['products_name']; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<script type="text/javascript"><!--
var i=0;
function resize() {
  if (navigator.appName == 'Netscape') i=40;
  if (document.images[0]) window.resizeTo(document.images[0].width +30, document.images[0].height+60-i);
  self.focus();
}
//--></script>
</head>
 <body onload="resize();">
<div id="bodyWrapper">
  <div id="bodyContent">
  <h1><?php echo HEADING_TITLE; ?></h1>
      <div class="contentContainer">
      <div class="contentText">
    <?php echo TEXT_INFORMATION; ?>
  </div>
 <div class="bodyContent">
<?
    echo "<p><strong>". TEXT_VALID_CATEGORIES_ID . "</strong></td><td><strong>" . TEXT_VALID_CATEGORIES_NAME . "</strong></p><p>";
    $result = tep_db_query("SELECT * FROM categories, categories_description WHERE categories.categories_id = categories_description.categories_id and categories_description.language_id = '" . (int)$languages_id . "' ORDER BY categories_description.categories_id");
    if ($row = tep_db_fetch_array($result)) {
        do {
            echo "<p> ".$row["categories_id"];
            echo "&nbsp;-&nbsp;".$row["categories_name"]."</p>";
            echo "</p>";
        }
        while($row = tep_db_fetch_array($result));
    }

?>
</div>
      <div style="float: right;">
        <?php echo '<a href="#" onclick="window.close(); return false;">' . TEXT_CLOSE_WINDOW . '</a>'; ?>
      </div>
 </div>
  </div>
   </div>

</body>
</html>
<?php require('includes/application_bottom.php'); ?>