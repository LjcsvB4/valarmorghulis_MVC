<?php 

require $_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php';

session_unset();

header('Location: vueConnexion.php');
exit;

