<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	require ("DB.inc.php");
	require 'utilisateur.inc.php';
	require 'fctAux.inc.php';

	$db = DB::getInstance();
	if ($db == null)
	{
		echo "Impossible de se connecter à la base de donnée !";
	}
	else
	{
		try
		{
			$utilisateurs = $db->getUtilisateurs();
			$tableauGenere = genererTableauUtilisateurs( $utilisateurs );
			$titre = "Consultation des utilisateurs";
			
			echo enTete( "utilisateurs");
			echo corps( $titre, $tableauGenere );
			echo pied();
			
		} //fin try
		catch (Exception $e) { echo $e->getMessage(); }  
		
	$db->close();
	} //fin du else connexion reussie
	
	function genererTableauUtilisateurs($utilisateurs)
	{
		$str = "<table>\n<thead><tr>";
		$str.= "<th>identifiant</th><th>prenom</th><th>dernière connexion</th>\n";
		$str.= "</thead>\n";
		
		$str.= "<tbody>";
		
		try
		{
		foreach( $utilisateurs as $user )
		{
			//var_dump($user);
			
			$str.= "<tr>";
			$str.= "<td><a href=\"messagerie.php\">".$user->getIdUtilisateur()."</a></td>";
			$str.= "<td>".$user->getPrenom()."</td>";
			$str.= "<td>".$user->getDateConnexion()."</td>";
			$str.= "</tr>";
		}
		} //fin try
		catch (Exception $e) { echo $e->getMessage(); }

		return $str."</tbody></table>";
	}
?>
