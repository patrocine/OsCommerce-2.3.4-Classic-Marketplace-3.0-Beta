<?php
 $invalidAttempt = true;
 $isHacker = false;
 require('includes/application_top.php');
 $invalidAttempt = false;
 $url = HTTP_SERVER . DIR_WS_HTTP_CATALOG . '/404.shtml';
 header("Location: $url");
 exit; 
?>
<html>
<head>
<title>
</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body topmargin="0">

<body bgcolor="#FFFFFF" text="#000888" link="#000888" alink="#666699" vlink="#666699" topmargin="0">



<center>
&nbsp;

<p>&nbsp;Bad Bot trap by View Counter. You should not be here.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


</body>
</html>