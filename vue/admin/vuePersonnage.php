<?php
//include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../vueConnexion.php'); }
//show message from add / edit page
if(isset($_GET['delperso'])){ 
	$stmt = $db->prepare('DELETE FROM personnage WHERE idPersonnage = :idPersonnage') ;
	$stmt->execute(array(':idPersonnage' => $_GET['delperso']));
	header('Location: vuePersonnage.php?action=deleted');
	exit;
} 
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="../../style/normalize.css">
  <link rel="stylesheet" href="../../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delperso(id, title)
  {
	  if (confirm("Etes-vous sur de vouloir supprimer '" + title + "'"))
	  {
	  	window.location.href = 'vuePersonnage.php?delperso=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>personnage '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Nom Personnage</th>
		<th>Prenom Personnage</th>
		<th>Age</th>
		<th>Biographie</th>
		<th>Action</th>
	</tr>
	<?php
		try {
			$stmt = $db->query('SELECT idPersonnage, nomPersonnage, prenomPersonnage, age,biographie,nomImage FROM personnage ORDER BY idPersonnage DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['nomPersonnage'].'</td>';
				echo '<td>'.$row['prenomPersonnage'].'</td>';
				echo '<td>'.$row['age'].'</td>';
				echo '<td>'.$row['biographie'].'</td>';
				?>

				<td>
					<a href="edit_personnage.php?id=<?php echo $row['idPersonnage'];?>">Editer</a> | 
					<a href="javascript:delperso('<?php echo $row['idPersonnage'];?>','<?php echo $row['nomPersonnage'];?>')">Supprimer</a>
				</td>
				
				<?php 
				echo '</tr>';
			}
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add_personnage.php'>Ajout Personnage</a></p>

</div>

</body>
</html>
