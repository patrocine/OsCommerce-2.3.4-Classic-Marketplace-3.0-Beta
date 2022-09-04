<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class newsletter {
    var $show_choose_audience, $title, $content;

    function newsletter($title, $content) {
      $this->show_choose_audience = false;
      $this->title = $title;
      $this->content = $content;
    }

    function choose_audience() {
      return false;
    }

    function confirm() {
      global $HTTP_GET_VARS;


     $provincia1 = STORE_ZONE_NEWSLETTERS1;  //provincia principal
     $provincia2 = STORE_ZONE_NEWSLETTERS2;  //provincia limitrofe


      if (NEWSLETTER_PUBLI == 1){
      //SOLO CANARIAS.
   $mail_query1 = tep_db_query("select count(*) as count from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_CUSTOMERS . " c where c.customers_id = ab.customers_id and ab.entry_zone_id = '170' and c.customers_newsletter = '1' or c.customers_id = ab.customers_id and ab.entry_zone_id = '157' and c.customers_newsletter = '1'");
	$mail_query2 = tep_db_query("select count(*) as count from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_newsletter 	= '1'");
                       }else if  (NEWSLETTER_PUBLI == 2){

      //TODA ESPA�A

	$mail_query1 = tep_db_query("select count(*) as count from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_CUSTOMERS . " c where c.customers_id = ab.customers_id and c.customers_newsletter = '1'");
	$mail_query2 = tep_db_query("select count(*) as count from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_newsletter 	= '1'");
                              }else if  (NEWSLETTER_PUBLI == 3){
 // TODA ESPA�A MENOS CANARIAS.

	$mail_query1 = tep_db_query("select count(*) as count from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_CUSTOMERS . " c where c.customers_id = ab.customers_id and ab.entry_zone_id <> '".$provincia1."' and c.customers_newsletter = '1' and ab.entry_zone_id <> '".$provincia2."'");
	$mail_query2 = tep_db_query("select count(*) as count from " . TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_newsletter 	= '1'");

                            }//fin

	$mail1 = tep_db_fetch_array($mail_query1);
	$mail2 = tep_db_fetch_array($mail_query2);

	$mail['count'] = ($mail1['count'] + $mail2['count'] );
 
 
 
 
 

      $confirm_string = '<table border="0" cellspacing="0" cellpadding="2">' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><font color="#ff0000"><strong>' . tep_draw_separator('pixel_trans.gif', '20', '1') .  TEXT_TITRE_INFO . '</strong></font></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main">' . sprintf(TEXT_COUNT_CUSTOMERS, '<font color="#0000ff">' . $mail['count']) . '</font></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main">' . TEXT_TITRE_MAIL . "&nbsp;" . '<font color="#0000ff">' . $this->title . '</font></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><font color="#ff0000"><strong>' . tep_draw_separator('pixel_trans.gif', '20', '1') . TEXT_TITRE_VIEW . '</strong></font></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><tt>' . $this->content . '</tt></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td align="right"><a href="' . tep_href_link(FILENAME_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID'] . '&action=confirm_send') . '">' . tep_image_button('button_send.gif', IMAGE_SEND) . '</a> <a href="' . tep_href_link(FILENAME_NEWSLETTERS, 'page=' . $_GET['page'] . '&nID=' . $_GET['nID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '</table>';

      return $confirm_string;
    }

    function send($newsletter_id) {
     // $mail_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");



                        if (NEWSLETTER_PUBLI == 1){
           // canarias
        $mail_query1 = tep_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_newsletter, c.customers_id, ab.entry_postcode from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_CUSTOMERS . " c where c.customers_id = ab.customers_id and ab.entry_zone_id = '170' and c.customers_newsletter = '1' or c.customers_id = ab.customers_id and ab.entry_zone_id = '157' and c.customers_newsletter = '1'");
                                           }else if  (NEWSLETTER_PUBLI == 2){
          // toda espa�a.
        $mail_query1 = tep_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_newsletter, c.customers_id, ab.entry_postcode from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_CUSTOMERS . " c where c.customers_id = ab.customers_id and c.customers_newsletter = '1'");
        $mail_query2 = tep_db_query("select * from " . 		TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_newsletter = '1'");
                                       }else if  (NEWSLETTER_PUBLI == 3){

          // toda espa�a MENOS CANARIAS.
     	$mail_query1 = tep_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_newsletter, c.customers_id, ab.entry_postcode from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_CUSTOMERS . " c where c.customers_id = ab.customers_id and ab.entry_zone_id <> '".$provincia1."' and c.customers_newsletter = '1' and ab.entry_zone_id <> '".$provincia2."'");
        $mail_query2 = tep_db_query("select * from " . 		TABLE_NEWSLETTER_ABONNEMENT . " where abonnement_newsletter = '1'");

        }





      $mimemessage = new email(array('X-Mailer: osCommerce'));




      // Build the text version
      $text = strip_tags($this->content);
      if (EMAIL_USE_HTML == 'true') {
       $mimemessage->add_html(sprintf(TEXT_DESABONNEMENT_NEWSLETTER, '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_NEWSLETTER_DESABONNEMENT . '?emaildesabonnement=' . str_replace('@', '4r0b6s3', $mail['abonnement_addresse_email']) . '&iID=' . $mail['abonnement_id'] . '">') . $this->content);
} else {
        $mimemessage->add_text($text);
      }

      $mimemessage->build_message();




      	while ($mail = tep_db_fetch_array($mail_query1)) {


    //  $sql_status_update_array = array('customers_newsletter' => 1,);

      //      tep_db_perform(TABLE_CUSTOMERS, $sql_status_update_array, 'update', " customers_id = '" . $mail['customers_id'] . "'");

//  $de_values = mysql_query("select * from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_CUSTOMERS . " c where c.customers_id = ab.customers_id and ab.entry_zone_id = '170'");
  //   $de = mysql_fetch_array($de_values);







       //  echo '<p>' .  $mail['entry_postcode'] . '-' . $mail['customers_email_address'] . ' Cuenta' . $mail['customers_newsletter'] . '</p>33333333';

         $mimemessage->send($mail['customers_firstname'] . ' ' . $mail['customers_lastname'] . ' ' . $mail['customers_email_address'], 	$mail['customers_email_address'], '', EMAIL_FROM, $this->title,'');

           	}

     while ($mail = tep_db_fetch_array($mail_query2)) {

       //   echo '<p>' .  $mail['abonnement_addresse_email'] . ' NEWSLETTERS' . '</p>22222222';
        //todas espa�a conectar // canarias desconectar
      $mimemessage->send(STORE_NAME, 	$mail['abonnement_addresse_email'], '', EMAIL_FROM, $this->title,'');
      	}










//      while ($mail = tep_db_fetch_array($mail_query)) {
  //      $mimemessage->send($mail['customers_firstname'] . ' ' . $mail['customers_lastname'], $mail['customers_email_address'], '', EMAIL_FROM, $this->title);
    //  }

      $newsletter_id = tep_db_prepare_input($newsletter_id);
      tep_db_query("update " . TABLE_NEWSLETTERS . " set date_sent = now(), status = '1' where newsletters_id = '" . tep_db_input($newsletter_id) . "'");
    }
  }
?>
