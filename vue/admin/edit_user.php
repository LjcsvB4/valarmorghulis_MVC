<?php //include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../vueConnexion.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit User</title>
  <link rel="stylesheet" href="../../style/normalize.css">
  <link rel="stylesheet" href="../../style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">Utilisateur Admin Index</a></p>

	<h2>Edit User</h2>


	<?php
	//if form has been submitted process it
	if(isset($_POST['submit'])){
		//collect form data
		extract($_POST);
		//very basic validation
		if($username ==''){
			$error[] = 'Veuillez entrer le pseudo de lutilisateur';
		}
		if( strlen($password) > 0){
			if($password ==''){
				$error[] = 'Veuillez entrer le mot de passe';
			}
			if($passwordConfirm ==''){
				$error[] = 'Veuillez entrer le mot de passe de confirmation';
			}
			if($password != $passwordConfirm){
				$error[] = 'Les deux mot de passe ne concordent pas';
			}
		}
		
		if($email ==''){
			$error[] = 'Veuillez entrer un email';
		}
		if(!isset($error)){
			try {
				if(isset($password)){
					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);
					//update into database
					$stmt = $db->prepare('UPDATE utilisateur SET pseudoUtilisateur = :username, motDePasseUtilisateur = :password, email = :email WHERE idUtilisateur = :memberID') ;
					$stmt->execute(array(
						':pseudoUtilisateur' => $username,
						':motDePasseUtilisateur' => $hashedpassword,
						':email' => $email,
						':idUtilisateur' => $memberID
					));
				} else {
					//update database
					$stmt = $db->prepare('UPDATE utilisateur SET pseudoUtilisateur = :username, email = :email WHERE idUtilisateur = :memberID') ;
					$stmt->execute(array(
						':pseudoUtilisateur' => $username,
						':email' => $email,
						':idUtilisateur' => $memberID
					));
				}
				
				//redirect to index page
				header('Location: users.php?action=updated');
				exit;
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		}
	}
	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}
		try {
			$stmt = $db->prepare('SELECT idUtilisateur, pseudoUtilisateur, email FROM utilisateur WHERE idUtilisateur = :memberID') ;
			$stmt->execute(array(':idUtilisateur' => $_GET['id']));
			$row = $stmt->fetch(); 
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>

	<form action='' method='post'>
		<input type='hidden' name='memberID' value='<?php echo $row['idUtilisateur'];?>'>

		<p><label>Username</label><br />
		<input type='text' name='username' value='<?php echo $row['pseudoUtilisateur'];?>'></p>

		<p><label>Password (only to change)</label><br />
		<input type='password' name='password' value=''></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value=''></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php echo $row['email'];?>'></p>

		<p><input type='submit' name='submit' value='Modifier utilisateur'></p>

	</form>

</div>

</body>
</html>
