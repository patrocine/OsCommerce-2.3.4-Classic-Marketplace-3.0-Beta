<?php if(isset($HTTP_GET_VARS['ajax']) == false) { ?>
<!--  ajax_part_ending -->
<div id="footer">
<?php
/*
  $Id: footer.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require(DIR_WS_INCLUDES . 'counter.php');
  require(DIR_WS_LANGUAGES . $language . '/modules/boxes/bm_languages.php');
  require(DIR_WS_LANGUAGES . $language . '/modules/boxes/bm_currencies.php');

  if (FOOTER_DATE_ENABLED == 'true' || FOOTER_SITE_STATS_ENABLED == 'true') {
?>

<table border="0" width="100%" cellspacing="0" cellpadding="1">
  <tr class="footer">
	<?php if (FOOTER_DATE_ENABLED == 'true') {?>
    <td class="footer">&nbsp;&nbsp;<?php echo strftime(DATE_FORMAT_LONG); ?>&nbsp;&nbsp;</td>
	<?php }
	if (FOOTER_SITE_STATS_ENABLED == 'true') { ?>
    <td align="right" class="footer">&nbsp;&nbsp;<?php echo $counter_now . ' ' . FOOTER_TEXT_REQUESTS_SINCE . ' ' . $counter_startdate_formatted; ?>&nbsp;&nbsp;</td>
	<?php } ?>
  </tr>
</table>
  
  
<?php
  }
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<!-- BOF show mobile link //-->
	<td align="center" class="linkText">
	<?php 
 if (substr(basename($PHP_SELF), 0, 15) != 'mobile_checkout') {
   		global $classic_site; 	
			if(isset($classic_site))
				$url = $classic_site;
			else {
			$url = str_replace('mobile_', '', $_SERVER['REQUEST_URI']);
			}
			//echo TEXT_SHOW_VIEW_1 . '<a href="' . $url . '">' . TEXT_CLASSIC_VIEW . '</a>' . '&nbsp;-&nbsp;' . TEXT_MOBILE_VIEW . TEXT_SHOW_VIEW_2;
	}
 
      echo TEXT_SHOW_VIEW_1 .  '</a>' . '&nbsp;-&nbsp;' . '<a href="http://addons.oscommerce.com/info/8629"><font size="2">iOSC</font></a>'
	?>
	</td>
<!-- EOF show mobile link //-->
  <tr>
    <td align="center" class="smallText"><?php echo FOOTER_TEXT_BODY; ?></td>  
    <td class="headerNavigation" width="20%" align="right"><div class="headerNavigation">
    <a href="<?php echo USER_FACEBOOK;?>"><?php echo tep_image(DIR_MOBILE_IMAGES."facebook.png") . "<br>" . 'Facebook'; ?></a></div></td>
    <td class="headerNavigation" width="20%" align="right"><div class="headerNavigation">
    <a href="<?php echo 'http://www.twitter.com/' . USER_TWITTER;?>"><?php echo tep_image(DIR_MOBILE_IMAGES."twitter.png") . "<br>" . 'Twitter'; ?></a></div></td>
    </div></td> 
  </tr>
</table>
<?php
  if ($no_banner_for_now) { //$banner = tep_banner_exists('dynamic', '468x50')) {
?>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><?php echo tep_display_banner('static', $banner); ?></td>
  </tr>
</table>
<?php
  }
?>
</div>







</body>
</html>
<?php require(DIR_MOBILE_INCLUDES . 'application_bottom.php'); ?>
<?php
}
?>
                           <?php if (PERMISO_DIRECCIONWEB == 'True'){ ?>
          <div id="ficheProdTop">
   <?php echo STORE_NAME_ADDRESS; ?>
                            <?php  } ?>
         <?php if (PERMISO_MAPAWEB == 'True'){ ?>
<p align="center"><?php echo USER_LOCALIZACION_GOOGLEMAPS ?></p>
                         <?php  } ?>
                 </div>
