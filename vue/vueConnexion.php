<?php
//define page title
$title = 'Connexion';

/*if(isset($_GET['action']) && $_GET['action']=='joined')
{
	require 'layout/header_vue.php';
}
else
{*/
	require 'layout/header_vue.php';
//}
?>

	
<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="../modele/modeleConnexion.php" autocomplete="off">
				<h2>Please Login</h2>
				<p><a class="LienFormulaire" href='../index.php'>Retour inscription</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
				if(isset($_GET['action'])){
					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<p class='infoFormulaire'>Votre compte est active,veuillez vous connecter</p>";
							break;
						case 'reset':
							echo "<p class='infoFormulaire'>Un lien de re-initialiation vous a ete envoye par mail</p>";
							break;
						case 'resetAccount':
							echo "<p class='infoFormulaire'>Votre mot de passe a ete change, veuillez vous connecter</p>";
							break;
					}
				}
				
				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
				</div>
				
				<div class="row">
					<div class="col-xs-9 col-sm-9 col-md-9">
						 <a class="LienFormulaire" href='vueReset.php'>Mot de passe oublie?</a>
					</div>
				</div>
				
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>
	</div>



</div>


<?php
/*if(isset($_GET['action']) && $_GET['action']=='joined')
{
	require 'layout/footer_vue.php';
}
else
{*/
	require 'layout/footer_vue.php';
//}
?>
