<?php
//include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/'.'config/config.php');
//check if already logged in move to home page
if($user->is_logged_in() ){ header('Location: ../vue/vueMemberPage.php'); } 
//process login form if submitted
if(isset($_POST['submit'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if($user->login($username,$password)){ 
		$_SESSION['username'] = $username;
		if($password=="admin" && $username=="admin")
		{
			header('Location: ../vue/admin/vueAccueil.php');
		}
		else
		{

			header('Location: ../vue/vueMemberPage.php');
			exit;
		}
	
	} else {
		$error[] = 'Wrong username or password or your account has not been activated.';
	}
}//end if submit
