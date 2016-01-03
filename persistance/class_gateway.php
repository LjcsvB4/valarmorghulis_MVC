<?php
 class AdresseGateway{
 /**
 * Permet de r é cup é rer une adresse à p a r t i r de son ID .
 * @param dataError : donné es d  ' erreurs ( couple type => message ) par r é f é
rence
 * @param id : c l é primaire de l  ' adresse à r é cup é rer
 * @return instance d  ' Adresse en cas de succès , undefined sinon .
 */
 public static function getAdresseById(&$dataError , $id ) {
 i f ( isset ( $id ) ) {
 // Exé cution de l a requ ê te via l a c l a s s e de connexion ( s i n g l e t o n )
 // Les exceptions é v e n t u e l l e s , p e r s o n n a l i s é es , sont g é r é es parl e Controleur
 $queryResults = DataBaseManager : :getInstance ( )−>prepareAndExecuteQuery (
  'SELECT * FROM  Adresse  WHERE  id  =  ?  ' , array ( $id ) ) ;

 // Si l  ' ex é cussion de l a requ ê te a fonctionn é e
 i f ( isset ( $queryResults ) && is_array ( $queryResults ) ) {
 // s i une et une s e u l e adresse a é t é trouv é e
 i f ( count ( $queryResults ) == 1) {
 $row = $queryResults [ 0 ] ;
 $adresse = AdresseFabrique : :getAdresse (
 $dataError ,
 $row [  ' id  ' ] , $row [  ' numeroRue  ' ] , $row
[  ' rue  ' ] ,
 $row [  ' complementAdresse  ' ] , $row [  ' codePostal  ' ] ,
 $row [  ' v i l l e  ' ] , $row [  ' pays  ' ] ) ;
 } else {
 $dataError [  ' p e r s i s t a n c e  ' ] =  " Adresse   introuvable .  " ;
 }
 } else {
 $dataError [  ' p e r s i s t a n c e  ' ] =  " Impossible  d  ' acc é der  aux donné es .  " ;
 }
 }
 return $adresse ;
 }

 /**
 * Permet de r é cup é rer une c o l l e c t i o n d  ' adresses pr é sentes dans l a t a b l e .
 * @param dataError : donné es d  ' erreurs ( couple type => message ) par r é f é
rence
 * @return c o l l e c t i o n d  ' Adresses en cas de succès , c o l l e c t i o n vide sinon .
 */
 public s t a t i c function getAdresseAll(&$dataError ) {

 // Exé cution de l a requ ê te via l a c l a s s e de connexion ( s i n g l e t o n )
 // Les exceptions é v e n t u e l l e s , p e r s o n n a l i s é es , sont g é r é es par l e
Controleur
 $queryResults = DataBaseManager : :getInstance ( )−>prepareAndExecuteQuery (
  'SELECT * FROM  Adresse  ' , array ( ) ) ;

 // Construction de l a c o l l e c t i o n des r é s u l t a t s ( f a b r i q u e )
 $ c o l l e c t i o n A d r e s s e = array ( ) ;
 // Si l  ' ex é cussion de l a requ ê te a fonctionn é e

Chapitre 13 : Architectures MVC et DAL
 i f ( $queryResults !== false ) {
 // Parcours des l i g n e s du r é s u l t a t de l a requ ê te :
 foreach ( $queryResults as $row ) {
 // Ajout d  ' une adresse dans l a c o l l e c t i o n :
 $adresse = AdresseFabrique : :getAdresse (
 $dataError ,
 $row [  ' id  ' ] , $row [  ' numeroRue  ' ] , $row [  ' rue  ' ] ,
 $row [  ' complementAdresse  ' ] , $row [  ' codePostal  ' ] ,
 $row [  ' v i l l e  ' ] , $row [  ' pays  ' ] ) ;
 $ c o l l e c t i o n A d r e s s e [ ] = $adresse ;
 }
 } else {
 $dataError [  ' p e r s i s t a n c e  ' ] =  "Problème d  ' accès  aux donné es .  " ;
 }

 return $ c o l l e c t i o n A d r e s s e ;
 }

 /**
 * @brief Met à jour une adresse ( Update )
 * @return l  ' instance d  ' Adresse ( erreurs + donné es de l  ' adresse s a i s i e )
 */
 public s t a t i c function postAdresse(&$dataError , $id , $numeroRue ,
 $rue , $complementAddr ,
 $codePostal , $ v i l l e , $pays ) {
 // Tentative de construction d  ' une instance ( et f i l t r a g e )
 $adresse = AdresseFabrique : :getAdresse ( $dataError , $id ,
 $numeroRue , $rue , $complementAddr ,
 $codePostal , $ v i l l e , $pays ) ;
 // Si l a forme des a t t r i b u t s sont c o r r e c t s ( e xp r es s io n s r é g u l i è r e s −
s e t t e r s )
 i f (empty( $dataError ) ) {
 // Exé cussion de l a requ ê te de mis à jour :
 $queryResults = DataBaseManager : :getInstance ( )−>prepareAndExecuteQuery (
  'UPDATE  Adresse  SET numeroRue= ?,  rue= ?,   '
 .  ' complementAdresse= ?,  codePostal = ?,  v i l l e
= ?, pays= ?   '
 .  'WHERE  id= ? ' ,
 array ( $adresse−>getNumeroRue ( ) ,
 $adresse−>getRue ( ) ,
 $adresse−>getComplementAdresse ( ) ,
 $adresse−>getCodePostal ( ) ,
 $adresse−>g e t V i l l e ( ) ,
 $adresse−>getPays ( ) ,
 $adresse−>getId ( )
 )
 ) ;
 i f ( $queryResults === false ) {
 $dataError [  " p e r s i s t a n c e  " ] =  "Problème d  ' accès  aux donné es .  " ;
 }
 }

 return $adresse ;
 }

 /**

Rémy Malgouyres, http://www.malgouyres.org/ Programmation Web
 * @brief Insère une n o u v e l l e adresse ( Create )
 * @return l  ' instance d  ' Adresse ( erreurs + donné es de l a adresse s a i s i e )
 */
 public s t a t i c function putAdresse(&$dataError , $numeroRue ,
 $rue , $complementAddr ,
 $codePostal , $ v i l l e , $pays ) {

 // Tentative de construction d  ' une instance ( et f i l t r a g e )
 $adresse = AdresseFabrique : :getAdresse ( $dataError ,  " 0000000000  " ,
 $numeroRue , $rue , $complementAddr ,
 $codePostal , $ v i l l e , $pays ) ;
 // Si l a forme des a t t r i b u t s sont c o r r e c t s ( e xp r es s io n s r é g u l i è r e s −
s e t t e r s )
 i f (empty( $dataError ) ) {
 // Exé cussion de l a requ ê te d  ' i n s e r t i o n :
 $queryResults = false ;
 $count = 0 ;
 // Boucle en cas de c o l l i s i o n de l  'ID
 // Autre p o s s i b i l i t é : u t i l i s e r l e nombre de l i g n e s (COUNT)
 // ou l e maximum par ordre alpha ou hexa des ID de l a t a b l e pour
c a l c u l e r
 // un ID qui n  ' e s t pas pr é sent dans l a t a b l e . Concat é ner avec de l  '
a l é a t o i r e
 while ( $queryResults === false && $count <= 3) {
 $adresse−>s e t I d ( Config : :generateRandomId ( ) ) ; // I d e n t i f i a n t a l é a t o i r e
 $count++ ;
 $queryResults = DataBaseManager : :getInstance ( )−>prepareAndExecuteQuery (
  'INSERT INTO  Adresse ( id ,  numeroRue ,  rue ,    '
 .  ' complementAdresse ,   codePostal ,   v i l l e ,  pays
)    '
 .  'VALUES  ( ? ,   ? ,   ? ,   ? ,   ? ,   ? ,   ?)  ' ,
 array ( $adresse−>getId ( ) ,
 $adresse−>getNumeroRue ( ) ,
 $adresse−>getRue ( ) ,
 $adresse−>getComplementAdresse ( ) ,
 $adresse−>getCodePostal ( ) ,
 $adresse−>g e t V i l l e ( ) ,
 $adresse−>getPays ( )
 )
 ) ;
 }
 // 4 c o l l i s i o n s d  ' a f f i l ée , c  ' e s t t r è s louche . . .
 i f ( $queryResults === false ) {
 $dataError [  " p e r s i s t a n c e  " ] =  "Problème d  ' ex é cution  de  l a   requ ê te .  " ;
 }
 }

 return $adresse ;
 }

 /**
 * @brief Supprime une adresse à p a r t i r de son ID .
 * Retourne l e modèle de donné es ( erreurs + donné es de l  ' Adresse supprim é e )
 */
 public s t a t i c function deleteAdresse (&$dataError , $id ) {
 // Test s i l  ' adresse e x i s t e et r é cup é r a t i o n s donné es à supprimer

Chapitre 13 : Architectures MVC et DAL
 $adresse = s e l f : :getAdresseById ( $dataError , $id ) ;

 i f (empty( $dataError ) ) {
 // Exé cution de l a requ ê te via l a c l a s s e de connexion ( s i n g l e t o n )
 // Les exceptions é v e n t u e l l e s , p e r s o n n a l i s é es , sont g é r é es par l e
Controleur
 $queryResults = DataBaseManager : :getInstance ( )−>prepareAndExecuteQuery (
  'DELETE FROM  Adresse  WHERE  id= ? ' ,
 array ( $id ) ) ;
 i f ( $queryResults === false ) {
 $dataError [  " p e r s i s t a n c e  " ] =  "Problème d  ' ex é cution  de  l a   requ ê te .  " ;
 }
 }

 return $adresse ;
 }
 }
 ?>
