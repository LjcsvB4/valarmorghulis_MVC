<?php
  /**
   *  @brief  classe  Autoload  : permet de  charger  automatiquement  les  classes .
   * La méthode  autoloadCallback ()  permer de  charger  le code source
   * d ' une  classe  dont  le nom est  passé  en  paramètre .
   * Pour  cela ,  la  méthode  load ()  déclare  autoloadCallback ()
   * par un appel  à  spl_autoload_register ()
   */

class Autoload
{
      //  référence  vers  l ' unique  instance  d ' Autoload
	 private  static  $m_instance = null ;

     /***  @brief  Chargement de  l ' unique  instance  et  déclaration  du  callback  d 'autoload .*/

	public  static  function  load ()
	{

		if (null !== self::$m_instance ){ 
			//  Test  :  s i  l ' instance  existe .
			throw new Exception ("Erreur l 'autoload ne peut être chargée qu 'une fois :" .__CLASS__) ;
		}
		//  Allocation  de  l ' instance  ( constructeur  par  défaut )  :
		self::$m_instance=new  self();

		//  Déclaration  du  callback  chargé d ' inclure  les  classes  :
		if(!spl_autoload_register (array(self::$m_instance,'autoloadCallback'),false)){
			throw new Exception (" Impossible de lancer l'autoload :" .__CLASS__) ;
		}

	}


/***  @brief  Désactivation  du  callback  d ' autoload  et  destruction  de  l ' instance .*/

	public static function shutDown()
	{

		if(null !== self::$m_instance){
			if(!spl_autoload_unregister(array(self::$m_instance,' _autoload')))
			{
				throw new Exception ("Impossible d 'arrêter l'autoload :" .__CLASS__) ;
			}
			self::$m_instance=null;
		}

	}


/***  @brief  Callback d ' Autoload .
*  Cette  méthode  est  appelée  automatiquement en  cas d ' instanciation
* d ' une  classe  inconnue .  La méthode  charge  alors  la  classe  en  question .
*
* @paramclass: nom de  la  classe  à  charger .
*
* @note L' arborescence  des  répertoires  et  les  noms de  f i c h i e r s PHP
*  contenant  les  classes  sont  imposés  pour  permettre  àà  cette  fonction
* de  trouver  le nom du  f i c h i e r PHP à  partir  du nom de  la  classe .
*/

	private static function autoloadCallback ($class)
	{
		//  Racine du site
		global  $rootDirectory;
		// Nom du fichier PHP contenant la classe :
		$sourceFileName = 'class_'.strtolower($class).'.php';
		//  Liste  des  sous-répertoire
		$directoryList =array('', 'config/','modele/','controleur/','metier/',' persistance/','modele/phpmailer/') ;
		//  Parcours  de  tous  les  sous-répertoire
		foreach($directoryList as $subDir){
		// Chemin vers le fichier
		$filePath=$rootDirectory.$subDir.$sourceFileName;
		// si le fichier  existe

			if(file_exists($filePath))
			{
				// Chargement de  la  classe  :

				require $filePath;
				
			}
		}
	}
}
?>

