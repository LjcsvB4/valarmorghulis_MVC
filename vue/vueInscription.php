<?php
$title = 'accueil';
if(isset($_GET['action']) && $_GET['action']=='joined')
{
	require 'layout/header_vue.php';
}
else
{
	require 'layout/header.php';
}
?>



<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<form role="form" name="form" method="POST" action="modele/modeleInscription.php" autocomplete="off">
				<h2>Veuillez vous inscrire</h2>
<?php
if(isset($_GET['action']) && $_GET['action']=='joined')
{
	echo '<p><a class="LienFormulaire" href="vueConnexion.php">Connexion</a></p>';
}
else
{
	echo '<p><a class="LienFormulaire" href="vue/vueConnexion.php">Connexion</a></p>';
}
?>
				
				<?php
				if(isset($error))
				{
					foreach($error as $error)
					{
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
				if(isset($_GET['action']) && $_GET['action']=='joined')
				{
					echo '<p class="bg-success">L\'enregistrement s\'est bien passé, veuillez activer votre compte en allant dans votre boîte mail</p>';


				}


				?>
				<div class="form-group">

					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="pseudo">
				</div>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="email" >

					
 
				</div>
				
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">

							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="mot de passe">


 
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">

							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmer mot de passe">


 
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 center">
					<input type="submit" name="submit" id="submit" class="btn btn-primary" value="valider">
					</div>

 
				</div>

			</form>
		</div>
	</div>
</div>



<?php
if(isset($_GET['action']) && $_GET['action']=='joined')
{
	require 'layout/footer_vue.php';
}
else
{
	require 'layout/footer.php';
}
?>
