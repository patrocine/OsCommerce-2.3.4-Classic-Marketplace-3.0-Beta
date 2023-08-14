<?php


    if(ereg("Android", $_SERVER["HTTP_USER_AGENT"])){
header('Location:'. HTTP_COOKIE_PATH .'mobile_index.php');
} if(ereg("iPhone", $_SERVER["HTTP_USER_AGENT"])){
header('Location:'. HTTP_COOKIE_PATH .'mobile_index.php');

}

?>



