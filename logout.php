<?php

session_start();

if(isset($_SESSION['manoverseUserID']))
{
    $_SESSION['manoverseUserID'] = NULL;
    unset($_SESSION['manoverseUserID']);

}
header('Location: login.php');
die;


?>
