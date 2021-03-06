<?php require($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php'); 

if( $user->is_logged_in() ){ header('Location: vueMemberPage.php'); } 
$stmt = $db->prepare('SELECT resetToken, resetComplete FROM utilisateur WHERE resetToken = :token');
$stmt->execute(array(':token' => $_GET['key']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(empty($row['resetToken'])){
	$stop = 'Token invalide, veuillez suivre le lien present dans le mail.';
} elseif($row['resetComplete'] == 'Yes') {
	$stop = 'Votre mot de passe a deja ete change';
}

if(isset($_POST['submit'])){

	if(strlen($_POST['password']) < 3){
		$error[] = 'Le mot de passe est trop court';
	}
	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Le mot de passe de confirmation est trop court';
	}
	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Les deux mots de passe ne concordent pas';
	}

	if(!isset($error)){

		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
		try {
			$stmt = $db->prepare("UPDATE utilisateur SET motDePasseUtilisateur = :hashedpassword, resetComplete = 'Yes'  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken']
			));

			header('Location: vueConnexion.php?action=resetAccount');
			exit;

		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

$title = 'Re-initialisation du compte';

require('layout/header_vue.php'); 
?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


	    	<?php if(isset($stop)){
	    		echo "<p class='bg-danger'>$stop</p>";
	    	} else { ?>

				<form role="form" method="post" action="" autocomplete="off">
					<h2>Change Password</h2>
					<hr>

					<?php
					
					if(isset($error)){
						foreach($error as $error){
							echo '<p class="bg-danger">'.$error.'</p>';
						}
					}
					
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Votre compte est active, vous pouvez vous logger</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Veuillez verifier votre boite mail pour un lien de reinitialisation de votre compte</h2>";
							break;
					}
					?>

					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Mot de passe" tabindex="1">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Mot de passe de confirmation" tabindex="1">
							</div>
						</div>
					</div>
					
					<hr>
					<div class="row">
						<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Changer de mot de passe" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
					</div>
				</form>

			<?php } ?>
		</div>
	</div>


</div>

<?php 

require('layout/footer_vue.php'); 
?>
