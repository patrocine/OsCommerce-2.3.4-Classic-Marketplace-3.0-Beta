<?php
/*
  $Id: loginbox.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!--D loginbox //-->
<?php			  
	if (!tep_session_is_registered('customer_id')) {
      $loginboxcontent = tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL')) . '
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
			    <td>' . AZ_SIGN_IN_TEXT . '</td>
                <td style="padding-left:4px;">
				  <div class="az_inputbox_l"><div class="az_inputbox_r"><div class="az_inputbox_m">' .
					tep_draw_input_field('email_address', AZ_EMAIL_TEXT , 'size="25" onfocus="if(this.value == \'' . AZ_EMAIL_TEXT . '\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'' . AZ_EMAIL_TEXT . '\';}"') . 
				  '</div></div></div>
				</td>
				<td style="padding-left:2px;">
				  <div class="az_inputbox_l"><div class="az_inputbox_r"><div class="az_inputbox_m">' . 
				    tep_draw_password_field('password', AZ_PASSWORD_TEXT , 'size="25" onfocus="if(this.value == \'' . AZ_PASSWORD_TEXT . '\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'' . AZ_PASSWORD_TEXT . '\';}"') . 
				  '</div></div></div>
				</td>
				<td align="right"><input id="az_login_button" type="submit" name="' . IMAGE_BUTTON_LOGIN . '" value="&gt;" title="' . IMAGE_BUTTON_LOGIN . '" /></td>
              </tr>
             </table>
           </form>
              ';
	} else {
	  $loginboxcontent = '<table border="0" cellspacing="0" cellpadding="0"><tr><td><div class="az_inputbox_l"><div class="az_inputbox_r"><div class="az_inputbox_m">&nbsp;' . $tmpl['txt']['loginout'] . '&nbsp;</div></div></div></td><td>&nbsp;&nbsp;&nbsp;<a id="az_logout_text" href="'.tep_href_link(FILENAME_LOGOFF, '', 'SSL').'">&gt;</a></td></tr></table>';
	}
	
	echo $loginboxcontent;
?>
<!--D loginbox_eof //-->
