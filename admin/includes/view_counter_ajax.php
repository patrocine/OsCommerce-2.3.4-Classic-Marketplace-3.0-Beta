<?php
/*
  $Id: view_counter, v 1.0 2012/07/01 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2012 oscommerce-solution.com

  Released under the GNU General Public License
*/
require_once('includes/application_top.php');
require_once('includes/functions/view_counter.php');

$ip = trim($_GET['id']);
$whois = GetWhoIS($ip); 
echo "<pre>$whois</pre>"; 
