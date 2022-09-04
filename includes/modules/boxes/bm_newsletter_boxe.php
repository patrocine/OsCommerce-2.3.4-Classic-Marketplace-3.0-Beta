<?php
/*
  $Id: boxe newsletter.php le 05 Avril 2012

  Auteur : Brouillard s'embrouille (brouillard-sembrouille@laposte.net)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  class bm_newsletter_boxe {
    var $code = 'bm_newsletter_boxe';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_newsletter_boxe() {
      $this->title = MODULE_BOXES_NEWSLETTER_TITLE;
      $this->description = MODULE_BOXES_NEWSLETTER_DESCRIPTION;

      if ( defined('MODULE_BOXES_NEWSLETTER_STATUS') ) {
        $this->sort_order = MODULE_BOXES_NEWSLETTER_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_NEWSLETTER_STATUS == 'True');

        $this->group = ((MODULE_BOXES_NEWSLETTER_CONTENT_PLACEMENT == 'Right Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;

 
$VerifierMailBoxe = '<script type="text/javascript">
   function VerifierMailBoxe(form) {
       if (form.emailabonnement.value == "" ) {
           alert("Error, no ha inroducido ningun mail")
           form.emailabonnement.focus();
           return false;
          }

       else if (form.emailabonnement.value.indexOf(",") > 0) {
           alert("' . BOX_NEWSLETTER_ERREUR_VIRGULE . '")
           form.emailabonnement.focus();
           return false;
          }

       else if (form.emailabonnement.value.indexOf(" ") > 0) {
           alert("' . BOX_NEWSLETTER_ERREUR_ESPACES . '")
            form.emailabonnement.focus();
           return false;
           }

       else if (form.emailabonnement.value.indexOf("@") < 0) {
           alert("' . BOX_NEWSLETTER_ERREUR_AROBASE . '")
           form.emailabonnement.focus();
           return false;
          }

       else if (form.emailabonnement.value.lastIndexOf(".") < 0) {
           alert("' . BOX_NEWSLETTER_ERREUR . '")
           form.emailabonnement.focus();
           return false;
          }

       else if ((form.emailabonnement.value.length - 1) - form.emailabonnement.value.lastIndexOf(".") < 2) {
           alert("' . BOX_NEWSLETTER_ERREUR . '")
           form.emailabonnement.focus();
           return false;
          }

       else {
          // form.submit()
           return true;
          }
   }
</script>';

      $data = $VerifierMailBoxe .  tep_draw_form('newsletterabonnement', tep_href_link(FILENAME_NEWSLETTER_ABONNEMENT, '', 'NONSSL'), 'post', 'onSubmit="return VerifierMailBoxe(this);"') . BOX_NEWSLETTER_TEXT_EMAIL . tep_draw_input_field('emailabonnement', '', 'size="15" maxlength="50"') . tep_draw_button(IMAGE_BUTTON_NEWSLETTER_ABONNEMENT, 'triangle-1-e', null, 'primary') . '</form>';



          
          
       $infobox = new azInfoBox();
      $infobox->azSetBoxHeading(BOX_NEWSLETTER_TEXT_ABONNEMENT);
      $infobox->azSetBoxContent($data);
      $infobox->azSetBoxFooter();
      $data = $infobox->azCreateBox('', '', '', '', false);

      $oscTemplate->addBlock($data, $this->group);
          
          
          
    }





    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_NEWSLETTER_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Best Sellers Module', 'MODULE_BOXES_NEWSLETTER_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_NEWSLETTER_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_NEWSLETTER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_NEWSLETTER_STATUS', 'MODULE_BOXES_NEWSLETTER_CONTENT_PLACEMENT', 'MODULE_BOXES_NEWSLETTER_SORT_ORDER');
    }
  }
?>
