<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

// Points/Rewards system V2.1beta BOF
define('TEXT_WELCOME_POINTS_TITLE', 'As part of our Welcome to new customers, we have credited your account <u>%s</u> with a total of %s Shopping Points, worth %s');
define('TEXT_WELCOME_POINTS_LINK', 'Please refer to the <u>%s</u> as conditions may apply.');
// Points/Rewards system V2.1beta EOF


define('NAVBAR_TITLE_1', 'Crear una Cuenta');
define('NAVBAR_TITLE_2', 'Exito');
define('HEADING_TITLE', 'Su cuenta ha sido creada!');
define('TEXT_ACCOUNT_CREATED', 'Enhorabuena! Su cuenta ha sido creada con &eacute;xito! Ahora puede disfrutar de las ventajas de disponer de una cuenta para mejorar su navegaci&oacute;n en nuestro catalogo. Si tiene <small><strong>CUALQUIER</strong></small> pregunta sobre el funcionamiento del catalogo, por favor comuniquela al <a href="' . (defined('FILENAME_MOBILE_CONTACT_US')? tep_mobile_link(FILENAME_MOBILE_CONTACT_US) : tep_href_link(FILENAME_CONTACT_US)) . '">encargado</a>.<br><br>Se ha enviado una confirmaci&oacute;n a la direcci&oacute;n de correo que nos ha proporcionado. Si no lo ha recibido en 1 hora pongase en contacto con <a href="' . (defined('FILENAME_MOBILE_CONTACT_US')? tep_mobile_link(FILENAME_MOBILE_CONTACT_US) : tep_href_link(FILENAME_CONTACT_US)) . '">nosotros</a>.');
?>
