<?php //include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../vueConnexion.php'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Add Post</title>
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

	<h2>Ajout Personnage</h2>

	<?php
	//if form has been submitted process it
	if(isset($_POST['submit'])){
		$_POST = array_map( 'stripslashes', $_POST );
		//collect form data
		extract($_POST);
echo print_r($_POST);
		//very basic validation
		if($nomPersonnage ==''){
			$error[] = 'Veuillez entrer le nom du personnage.';
		}
		if($prenomPersonnage ==''){
			$error[] = 'Veuillez entrer le prenom du personnage.';
		}
		if($agePersonnage ==''){
			$error[] = 'Veuillez entrer lage du personnage';
		}
		if($biographie ==''){
			$error[] = 'Veuillez entrer la biographie';
		}

		if(!isset($error)){
			try {





$nom = $_POST['nom'];
$dir = '../../style/images/';
$ext = strtolower( pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION) );
$file=uniqid().'.'.$ext;
move_uploaded_file($_FILES['image']['tmp_name'], $dir.$file);
$photo = $file;
				$stmt = $db->prepare('INSERT INTO personnage (nomPersonnage,prenomPersonnage,age,biographie) VALUES (:nomPersonnage, :prenomPersonnage,:age, :biographie)') ;
				$stmt->execute(array(
					':nomPersonnage' => $nomPersonnage,
					':prenomPersonnage' => $prenomPersonnage,
					':age' => $agePersonnage,
					':biographie' => $biographie
				));
				//redirect to index page
				header('Location: vuePersonnage.php?action=added');
				exit;
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		}
	}
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' enctype="multipart/form-data">

		<p><label>Nom Personnage</label><br />
		<input type='text' name='nomPersonnage' value='<?php if(isset($error)){ echo $_POST['nomPersonnage'];}?>'></p>

		<p><label>Prenom Personnage</label><br />
		<input type='text' name='prenomPersonnage' value='<?php if(isset($error)){ echo $_POST['prenomPersonnage'];}?>'></p>
		<p><label>Age</label><br />
		<input type='text' name='agePersonnage' value='<?php if(isset($error)){ echo $_POST['agePersonnage'];}?>'></p>


<p><label>Biographie</label><br />
		<textarea name='biographie' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['biographie'];}?></textarea></p>


<label for="image"> nom Image</label>
<input type='text' name='nomImage' value='<?php if(isset($error)){ echo $_POST['nomImage'];}?>'></p>
 		<input type="hidden" name="MAX_FILE_SIZE" value="300000" >
 		<input type="file" id="file" name="image">
		<p><input type='submit' name='submit' value='Valider'></p>

	</form>

</div>
