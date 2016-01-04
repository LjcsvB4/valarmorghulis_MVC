<?php require($_SERVER['DOCUMENT_ROOT']. '/valarmorghulis_MVC/config/config.php'); 
$stmt = $db->prepare('SELECT postID, postTitle, postCont,postImage, postDate FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();
//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: ./vueMemberPage.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Blog - <?php echo $row['postTitle'];?></title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>

	<div id="wrapper">
<a href="vueLogout.php">Deconnexion</a>
		<h1>Blog</h1>
		<hr />
		<p><a href="./vueMemberPage.php">Accueil</a></p>


		<?php	

			echo '<div>';
				echo '<h1>'.$row['postTitle'].'</h1>';
				echo '<p>Soumit le '.date('jS M Y', strtotime($row['postDate'])).'</p>';
				echo '<img src=../style/images/'.$row["postImage"].'>';
				echo '<p>'.$row['postCont'].'</p>';				
			echo '</div>';
	

echo '<h2>Commentaires</h2>';



// Récupération des commentaires
$req = $db->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM commentaire WHERE id_billet = ? ORDER BY id DESC LIMIT 3');
$req->execute(array($_GET['id']));

while ($donnees = $req->fetch())
{
?>
<p><strong><?php echo htmlentities($donnees['auteur'], ENT_QUOTES, "UTF-8"); ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?></p>
<p><?php echo nl2br(htmlentities($donnees['commentaire'], ENT_QUOTES, "UTF-8")); ?></p>
<?php
} // Fin de la boucle des commentaires
$req->closeCursor();
?>
	</div>


<form action="../modele/modeleCommentaire_post.php" method="post" accept-charset="utf-8">
<p>
<label for="commentaire">Commentaire</label> : 
<textarea name="commentaire" id="commentaire" rows="4" cols="50">
 
</textarea><br />
<input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>">
<input type="submit" value="Envoyer" />
</p>
</form>




</body>
</html>
















