<?php
 require('includes/application_top.php');
 require('includes/languages/' . $language . '/view_counter/view_counter_' . $_GET['file'] . '.php');
 
 echo '<div>';
 echo '<div style="text-align:center">' . VC_HELP_HEADING . '</div>';
 
 echo '<div class="smallText">' . stripslashes(VC_HELP_TEXT_MAIN) . '</div>';
 echo '</div>';
