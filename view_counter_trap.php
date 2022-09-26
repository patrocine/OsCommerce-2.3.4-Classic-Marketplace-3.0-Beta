<?php
 
 $invalidAttempt = true;
 $isHacker = false;
 require('includes/application_top.php');
 $invalidAttempt = false;
 $url = HTTP_SERVER . DIR_WS_HTTP_CATALOG . '/404.shtml';
 header("Location: $url");
 exit;
 
