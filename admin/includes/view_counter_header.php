<?php
if (strpos(PROJECT_VERSION, 'v2.3') !== FALSE) { 
  require('includes/template_top.php');
  if (basename($_SERVER['PHP_SELF']) == 'view_counter.php') { ?>
    <meta http-equiv="refresh" content="<?php echo VIEW_COUNTER_PAGE_REFRESH; ?>">
<?php 
  }
} else {
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php if (basename($_SERVER['PHP_SELF']) == 'view_counter.php') { ?>
<meta http-equiv="refresh" content="<?php echo VIEW_COUNTER_PAGE_REFRESH; ?>">
<?php } ?>
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script language="javascript" src="includes/general.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
</head>
<?php } ?>