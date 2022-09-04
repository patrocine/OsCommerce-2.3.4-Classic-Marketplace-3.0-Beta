<?php
/*
  $Id: admin_account.php,v 1.29 2002/03/17 17:52:23 harley_vb Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

  Includes Contribution
    Access with Level Account (v. 2.2a) for the Admin Area of osCommerce (MS2)

  This file may be deleted if disabling the above contribution

*/

  require('includes/application_top.php');

  $current_boxes = DIR_FS_ADMIN . DIR_WS_BOXES;

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php   require(DIR_WS_INCLUDES . 'template_top.php'); ?>




<!-- body_text //-->
    <td width="100%" valign="top">
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
            <table border="0" width="100%" cellspacing="0" cellpadding="2" align="center">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo NAVBAR_TITLE; ?></td>
              </tr>
              <tr class="dataTableRow">
                <td align="left" class="dataTableContent"><?php echo TEXT_MAIN; ?></td>
              </tr>
              <tr class="dataTableRow">
                <td align="left"><?php echo '&nbsp;<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>&nbsp;'; ?></td>
              </tr>
            </table>
        </td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
