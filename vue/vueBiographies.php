<?php require($_SERVER['DOCUMENT_ROOT']. '/valarmorghulis_MVC/config/config.php');?>
<div>
		<a href="vueMemberPage.php">Retour à la page d'accueil</a>
		<a href="vueLogout.php">Deconnexion</a>
<?php if($_SESSION['username']=='admin') { echo '<a href="admin/vueAccueil.php">Menu Admin</a>';}?>
	</div>	
		<a href="vueBioLannister.php" ><img src="../style/images/BlasonLannister.png" alt="Lannister"/></a>
		
		<a href="vueBioBaratheon.php" ><img src="../style/images/BlasonBaratheon.png" alt="Baratheon"/></a>
		
		<a href="vueBioTyrell.php" ><img src="../style/images/Tyrell.png" alt="Tyrell"/></a>
		
		<a href="vueBioGreyjoy.php" ><img src="../style/images/Greyjoy.png" alt="Greyjoy"/></a>
		
		<a href="vueBioStark.php" ><img src="../style/images/Stark.png" alt="Stark"/></a>
		
		<a href="vueBioArryn.php" ><img src="../style/images/Arren.png" alt="Arryn"/></a> <br/> <br/>
				
	</div>
		


