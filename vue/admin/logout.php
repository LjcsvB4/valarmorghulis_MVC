<?php
//include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//log user out
$user->loggout();
header('Location: ../../index.php'); 
?>
