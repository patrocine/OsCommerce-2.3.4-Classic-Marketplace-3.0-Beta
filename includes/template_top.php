<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
require_once('az_template/mapping/vars_map.php');

  $oscTemplate->buildBlocks();

  if (!$oscTemplate->hasBlocks('boxes_column_left')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }

  if (!$oscTemplate->hasBlocks('boxes_column_right')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
  
  


//#AZ AlgoZone Template Controller Class
require('az_template/template_main.php');

$template = new azTmpl();
//#AZ


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo tep_output_string_protected($oscTemplate->getTitle()); ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<link rel="stylesheet" type="text/css" href="ext/jquery/ui/redmond/jquery-ui-1.10.4.min.css" />
<script type="text/javascript" src="ext/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.10.4.min.js"></script>
<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="ext/jquery/ui/i18n/jquery.ui.datepicker-<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>.js"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>

<script type="text/javascript" src="ext/photoset-grid/jquery.photoset-grid.min.js"></script>

<link rel="stylesheet" type="text/css" href="ext/colorbox/colorbox.css" />
<script type="text/javascript" src="ext/colorbox/jquery.colorbox-min.js"></script>
<link rel="stylesheet" type="text/css" href="ext/960gs/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>960_24_col.css" />
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php echo $oscTemplate->getBlocks('header_tags'); ?>

<?php
//#AZ AlgoZone CSS and JSS inclusions
$template->az_tmpl_css();
$template->az_tmpl_js();
//#AZ
?>
</head>
 <script type="text/javascript" src="ext/tooltip/tooltipsy.min.js"></script>

<body>

<div id="bodyWrapper" class="container_<?php echo $oscTemplate->getGridContainerWidth(); ?>">

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<?php
//#AZ AlgoZone Header Inclusion
  $template->az_tmpl_header();
  $template->az_tmpl_content_top();
//#AZ
?>
