<?php

ob_start();
session_start();
$rootDirectory= $_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/';
define('DBHOST','localhost');
define('DBUSERNAME','root');
define('DBPASSWORD','Pate63500');
define('DBNAME','site_web');
define('SITEEMAIL','noreply@hotmail.fr');
define('DIR','http://localhost/valarmorghulis_MVC/');


try 
{
	$db = new PDO('mysql:host='.DBHOST.';port=3306;charset=utf8;dbname='.DBNAME,DBUSERNAME,DBPASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
	echo '<p class="bg-danger">'.$e->getMessage.'</p>';
}


require_once('class_autoload.php');
Autoload::load();
$user = new User($db);
$mail = new PHPMailer();


?>
