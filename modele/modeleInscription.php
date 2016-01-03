<?php
 
require $_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/'.'config/config.php';
if($user->is_logged_in())
{
	header('Location : ../vue/vueMemberPage.php');
}

if(isset($_POST['submit']))
{
	if(strlen($_POST['username']) < 3)
	{
		$error[] = 'Veuillez saisir un nom d\'utilisateur ayant plus de 3 caractères';
	}
	else
	{
		$stmt= $db->prepare('SELECT pseudoUtilisateur from utilisateur where pseudoUtilisateur = :username');
		$stmt->execute(array(":username"=>$_POST['username']));
		$row=$stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['pseudoUtilisateur']))
		{
			$error[] = "L'utilisateur existe déjà, veuillez en saisir un nouveau";
		}
	}

	if(strlen($_POST['password']) <3)
	{
		$error[] = 'Veuillez saisir un password ayant plus de 3 caractères';
	}
	if(strlen($_POST['passwordConfirm']) <3)
	{
		$error[] = 'Veuillez saisir un password de confirmation ayant plus de 3 caractères';
	}


	if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
	{
		$error[] = 'Veuillez saisir un email valide';
	}
	else
	{
		$stmt= $db->prepare('SELECT email from utilisateur where email = :email');
		$stmt->execute(array(":email"=>$_POST['email']));
		$row=$stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email']))
		{
			$error[] = "L'email existe déjà, veuillez en saisir un nouveau";
		}
	}
	if($_POST['passwordConfirm']!=$_POST['password'])
	{
		$error[] = 'Le mot de passe et le mot de passe de confirmation ne sont pas égaux';
	}

	if(!isset($error))
	{
		$activation = md5(uniqid(rand(),true));
		$hash_password = $user->password_hash($_POST['password'],PASSWORD_BCRYPT);
		
		$stmt = $db->prepare('INSERT INTO utilisateur(pseudoUtilisateur,motDePasseUtilisateur,email,active) VALUES (:pseudoUtilisateur,:motDePasseUtilisateur,:email,:active)');
		$stmt->execute(array(
			":pseudoUtilisateur"=>$_POST['username'],
			":motDePasseUtilisateur"=>$hash_password,
			":email"=>$_POST['email'],
			":active"=>$activation
			));
		$id = $db->lastInsertId('idUtilisateur');

$mail->setFrom('SITEEMAIL', 'Mailer');
$mail->addAddress($_POST['email'], $_POST['username']); 


$mail->Subject = 'activer votre compte sur valarmorghulis';
$mail->Body    = 'L\'adresse url pour activer le compte, se trouve ci-dessous :'.
		 'http://localhost/valarmorghulis_MVC/modele/activate.php?x='.$id.'&y='.$activation;


if(!$mail->send()) 
{
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} 
else 
{
   /* echo 'Message has been sent';*/
/*echo '<p><a href="http://localhost/valarmorghulis_1/activate.php?x='.$id.'&y='.$activation.'">activation compte</a></p>';*/
   header('Location: ../vue/vueInscription.php?action=joined');
    
}
	}
}
