<?php
if (strpos(PROJECT_VERSION, 'v2.3') !== FALSE) { 
  require('includes/template_bottom.php');
  require('includes/application_bottom.php');

} else {

 require('includes/footer.php'); 
 echo '<!-- footer_eof //-->';
 echo '</body>';
 echo '</html>';
 require('includes/application_bottom.php');
}