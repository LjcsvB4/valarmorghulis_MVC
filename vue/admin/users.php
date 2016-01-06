<?php
//include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../vueConnexion.php'); }
//show message from add / edit page
if(isset($_GET['deluser'])){ 
	//if user id is 1 ignore
	if($_GET['deluser'] !='1'){
		$stmt = $db->prepare('DELETE FROM utilisateur WHERE idUtilisateur = :idUtilisateur') ;
		$stmt->execute(array(':idUtilisateur' => $_GET['deluser']));
		header('Location: users.php?action=deleted');
		exit;
	}
} 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Users</title>
  <link rel="stylesheet" href="../../style/normalize.css">
  <link rel="stylesheet" href="../../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'users.php?deluser=' + id;
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
		echo '<h3>User '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Pseudo</th>
		<th>Email</th>
		<th>Action</th>
	</tr>
	<?php
		try {
			$stmt = $db->query('SELECT idUtilisateur, pseudoUtilisateur, email FROM utilisateur ORDER BY pseudoUtilisateur');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['pseudoUtilisateur'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				?>

				<td>
					<a href="edit_user.php?id=<?php echo $row['idUtilisateur'];?>">Editer</a> 
					<?php if($row['idUtilisateur'] != 1){?>
						| <a href="javascript:deluser('<?php echo $row['idUtilisateur'];?>','<?php echo $row['pseudoUtilisateur'];?>')">Suppression</a>
					<?php } ?>
				</td>
				
				<?php 
				echo '</tr>';
			}
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add_user.php'>Ajout Utilisateur</a></p>

</div>

</body>
</html>
