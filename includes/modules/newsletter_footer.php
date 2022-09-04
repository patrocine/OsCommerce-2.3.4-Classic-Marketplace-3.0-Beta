<?php
/*
  $Id: boxe newsletter_footer.php le 05 Avril 2012

  Auteur : Brouillard s'embrouille (brouillard-sembrouille@laposte.net)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- boxe newsletter //-->
<script type="text/javascript">
   function VerifierMail(form) {
       if (form.emailabonnement.value == "" ) {
           alert("<?php echo BOX_NEWSLETTER_ERREUR_CHAMP_VIDE; ?>")
           form.emailabonnement.focus();
           return false;
          }

       else if (form.emailabonnement.value.indexOf(",") > 0) {
           alert("<?php echo BOX_NEWSLETTER_ERREUR_VIRGULE; ?>")
           form.emailabonnement.focus();
           return false;
          }

       else if (form.emailabonnement.value.indexOf(" ") > 0) {
           alert("<?php echo BOX_NEWSLETTER_ERREUR_ESPACES; ?>")
            form.emailabonnement.focus();
           return false;
           }

       else if (form.emailabonnement.value.indexOf("@") < 0) {
           alert("<?php echo BOX_NEWSLETTER_ERREUR_AROBASE; ?>")
           form.emailabonnement.focus();
           return false;
          }

       else if (form.emailabonnement.value.lastIndexOf(".") < 0) {
           alert("<?php echo BOX_NEWSLETTER_ERREUR; ?>")
           form.emailabonnement.focus();
           return false;
          }

       else if ((form.emailabonnement.value.length - 1) - form.emailabonnement.value.lastIndexOf(".") < 2) {
           alert("<?php echo BOX_NEWSLETTER_ERREUR; ?>")
           form.emailabonnement.focus();
           return false;
          }

       else {
          // form.submit()
           return true;
          }
   }
</script>
<?php
echo '<br /><p align="left">' . BOX_NEWSLETTER_TEXT_ABONNEMENT . '<br />' . tep_draw_form('newsletterabonnement', tep_href_link(FILENAME_NEWSLETTER_ABONNEMENT, '', 'NONSSL'), 'post', 'onSubmit="return VerifierMail(this);"') . BOX_NEWSLETTER_TEXT_EMAIL . tep_draw_input_field('emailabonnement', '', 'size="15" maxlength="50"') . ' ' .  tep_draw_button(IMAGE_BUTTON_NEWSLETTER_ABONNEMENT, 'triangle-1-e', null, 'primary') . '</form></p>';
?>
<!-- boxe newsletter eof //-->