<?php
class User extends Password
{


	private $_db;


	public function __construct($db)
	{
		parent::__construct();
		$this->_db = $db;
	}

	private function get_user_hash($username){
		try {
			$stmt = $this->_db->prepare('SELECT motDePasseUtilisateur, pseudoUtilisateur, idUtilisateur FROM utilisateur WHERE pseudoUtilisateur = :pseudoUtilisateur AND active="Yes" ');
			$stmt->execute(array('pseudoUtilisateur' => $username));
			return $stmt->fetch();
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}


	public function login($username,$password){
		$row = $this->get_user_hash($username);
		if($this->password_verify($password,$row['motDePasseUtilisateur']) == 1){
		    $_SESSION['logged_in'] = true;
		    $_SESSION['username'] = $row['pseudoUtilisateur'];
		    $_SESSION['memberID'] = $row['idUtilisateur'];
		    return true;
		}
	}
	




	public function loggout()
	{
		session_destroy();
	}

	public function is_logged_in()
	{
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


}

?>
