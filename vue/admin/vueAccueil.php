<?php
//include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../vueConnexion.php'); }
//show message from add / edit page
if(isset($_GET['delpost'])){ 
	$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));
	header('Location: vueAccueil.php?action=deleted');
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
  function delpost(id, title)
  {
	  if (confirm("Etes-vous sur de vouloir supprimer '" + title + "'"))
	  {
	  	window.location.href = 'vueAccueil.php?delpost=' + id;
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
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Titre</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {
			$stmt = $db->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postID DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['postTitle'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
				?>

				<td>
					<a href="edit_post.php?id=<?php echo $row['postID'];?>">Editer</a> | 
					<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Suppression</a>
				</td>
				
				<?php 
				echo '</tr>';
			}
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add_post.php'>Ajout Billet</a></p>

</div>

</body>
</html>
