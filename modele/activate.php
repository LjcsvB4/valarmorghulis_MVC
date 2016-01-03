<?php

require($_SERVER['DOCUMENT_ROOT'].'/valarmorghulis_MVC/config/config.php');

$idUtilisateur = trim($_GET['x']);
$active = trim($_GET['y']);
//if id is number and the active token is not empty carry on
if(is_numeric($idUtilisateur) && !empty($active)){
	//update users record set the active column to Yes where the memberID and active value match the ones provided in the array
	$stmt = $db->prepare("UPDATE utilisateur SET active = 'Yes' WHERE idUtilisateur = :idUtilisateur AND active = :active");
	$stmt->execute(array(
		':idUtilisateur' => $idUtilisateur,
		':active' => $active
	));
	//if the row was updated redirect the user
	if($stmt->rowCount() == 1){
		//redirect to login page
		header('Location: ../vue/vueConnexion.php?action=active');
		exit;
	} else {
		echo "Votre compte ne peut etre active."; 
	}
	
}


?>
