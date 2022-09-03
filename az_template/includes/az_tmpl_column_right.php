<?php
/*
  $Id: az_tmpl_column_right.php,v 2.00 2010/11/19  Exp $

  Wrapper for AlgoZone templates (AFTS)
  http://www.algozone.com

*/
  if ($oscTemplate->hasBlocks('boxes_column_right')) {
?>

<div id="columnRight">
  <?php echo $oscTemplate->getBlocks('boxes_column_right'); ?>
</div>

<?php
  }

?>
