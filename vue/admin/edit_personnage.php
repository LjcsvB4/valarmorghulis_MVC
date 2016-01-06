<?php //include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../vueConnexion.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Modification Personnage</title>
  <link rel="stylesheet" href="../../style/normalize.css">
  <link rel="stylesheet" href="../../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Modification Personnage</h2>


	<?php
	//if form has been submitted process it
	if(isset($_POST['submit'])){
		$_POST = array_map( 'stripslashes', $_POST );
		//collect form data
		extract($_POST);
		//very basic validation
		if($nomPersonnage ==''){
			$error[] = 'Veuillez entrer le nom du personnage';
		}
		if($prenomPersonnage ==''){
			$error[] = 'Veuillez entrer le prenom du personnage';
		}
		if($age ==''){
			$error[] = 'Veuillez entrer lage du personnage';
		}
		if($biographie ==''){
			$error[] = 'Veuillez entrer la biographpie du personnage';
		}
		if(!isset($error)){
			try {
				//insert into database
				$stmt = $db->prepare('UPDATE personnage SET nomPersonnage = :nomPersonnage, prenomPersonnage = :prenomPersonnage,age = :age,biographie = :biographie WHERE idPersonnage = :idPersonnage') ;
				$stmt->execute(array(
					':idPersonnage' => $_GET['id'],
					':nomPersonnage' => $nomPersonnage,
					':prenomPersonnage' => $prenomPersonnage,
					':age' => $age,
					':biographie' => $biographie
				));
				//redirect to index page
				header('Location: vuePersonnage.php?action=updated');
				exit;
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		}
	}
	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}
		try {
			$stmt = $db->prepare('SELECT idPersonnage, nomPersonnage, prenomPersonnage, age,biographie FROM personnage WHERE idPersonnage = :idPersonnage') ;
			$stmt->execute(array(':idPersonnage' => $_GET['id']));
			$row = $stmt->fetch(); 
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>

	<form action='' method='post'>
		<p><label>Nom Personnage : </label><br />
		
		<input type='text' name='nomPersonnage' value='<?php echo $row['nomPersonnage'];?>'>

		<p><label>Prenom Personnage</label><br />
		<input type='text' name='prenomPersonnage' value='<?php echo $row['prenomPersonnage'];?>'></p>

		<p><label>Age</label><br />
		<input type='text' name='age' value='<?php echo $row['age'];?>'></p>

		<p><label>Biographie</label><br />
		<textarea name='biographie' cols='60' rows='10'><?php echo $row['biographie'];?></textarea></p>

		<p><input type='submit' name='submit' value='Modification'></p>

	</form>

</div>

</body>
