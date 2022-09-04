<?php
require_once('mobile/includes/application_top.php');
require(DIR_MOBILE_INCLUDES . 'header.php');


define('HEADING_TITLE', 'DONDE ESTAMOS ');

//require(DIR_WS_LANGUAGES . $language . '/' . str_replace("mobile_", "", FILENAME_SHIPPING));
$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHIPPING));
$headerTitle->write();
?>
<div id="iphone_content">
<!--  ajax_part_begining -->
<div id="cms">
        <?php if (PERMISO_DIRECCIONWEB == 'True'){ ?>
<?php echo STORE_NAME_ADDRESS; ?>
                    <?php } ?>
                           <?php if (PERMISO_MAPAWEB == 'True'){ ?>
<?php echo USER_LOCALIZACION_GOOGLEMAPS ?>
                           <?php } ?>
</div>
<?php require(DIR_MOBILE_INCLUDES . 'footer.php');
?>
