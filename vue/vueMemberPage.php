<?php

 require($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
<a href="vueLogout.php">Deconnexion</a>
	<div id="wrapper">

		<h1>Blog</h1>
		<a href="vueBiographies.php"><h2>Biographie</h2></a>
		<hr />

		<?php
			try {
				$stmt = $db->query('SELECT postID, postTitle, postDesc,postImage, postDate FROM blog_posts ORDER BY postID DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h1><a href="vueViewPost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
						echo '<p>Soumit le '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';

						echo '<p>'.$row['postDesc'].'</p>';

echo "<p><img src='../style/images/".$row['postImage']."' alt=''></p>";		
		
						echo '<p><a href="vueViewPost.php?id='.$row['postID'].'">Lire plus</a></p>';				
					echo '</div>';
				}
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	</div>


</body>
</html>











