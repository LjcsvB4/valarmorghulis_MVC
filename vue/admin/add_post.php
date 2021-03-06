<?php //include config
require_once($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../vueConnexion.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Administrateur - Ajouter Billet</title>
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
	<p><a href="./vueAccueil.php">Blog Admin Index</a></p>

	<h2>Add Post</h2>

	<?php
	//if form has been submitted process it
	if(isset($_POST['submit'])){
		$_POST = array_map( 'stripslashes', $_POST );
		//collect form data
		extract($_POST);
		//very basic validation
		if($postTitle ==''){
			$error[] = 'Veuillez entrer un titre.';
		}
		if($postDesc ==''){
			$error[] = 'Veuillez entrer une description.';
		}
		if($postCont ==''){
			$error[] = 'Veuillez entrer un contenu.';
		}

		if(!isset($error)){
			try {





$nom = $_POST['nom'];
$dir = '../../style/images/';
$ext = strtolower( pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION) );
$file=uniqid().'.'.$ext;
move_uploaded_file($_FILES['image']['tmp_name'], $dir.$file);
$photo = $file;


				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postImage,postCont,postDate) VALUES (:postTitle, :postDesc,:postImage, :postCont, :postDate)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postImage' => $photo,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s')
				));
				//redirect to index page
				header('Location: vueAccueil.php?action=added');
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

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
		<span><input id="nom" name="nom" type="text" maxlength="255" value="" /><label>Nom</label></span>
		<label for="image"> Ajouter une photo</label>
 		<input type="hidden" name="MAX_FILE_SIZE" value="300000" >
 		<input type="file" id="file" name="image">

		<p><input type='submit' name='submit' value='Valider'></p>

	</form>

</div>
