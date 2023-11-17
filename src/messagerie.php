<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	require ("DB.inc.php");
	require 'message.inc.php';
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
			$utilisateurActuel=1; $utilisateurDest=2;
			
			$messages = $db->getMessagesID($utilisateurActuel,$utilisateurDest);
			$tableauGenere = genererTableau( $messages, $utilisateurActuel );
			$titre = "Consultation des messages";
			
			echo enTete( "Messagerie");
			echo corps( $titre, $tableauGenere );
			echo pied();
			
		} //fin try
		catch (Exception $e) { echo $e->getMessage(); }  
		
	$db->close();
	} //fin du else connexion reussie
	
	function genererTableau($messages, $utilisateurActuel)
	{
		$str = "<table>\n<thead><tr>";
		$str.= "<th>contenu</th><th>date</th>\n";
		$str.= "</thead>\n";
		
		$str.= "<tbody>";
		
		try
		{
		foreach( $messages as $msg )
		{
			//var_dump($user);
			
			if( $msg->getIdUtilisateur() == $utilisateurActuel )
			{
				$couleur="rouge";
			}
			else
			{
				$couleur="bleu";
			}
			
			$str.= "<tr class=\"$couleur\">";
			$str.= "<td>".$msg->getContenu()."</td>";
			$str.= "<td>".$msg->getDateEnvois()."</td>";
			$str.= "</tr>";
		}
		} //fin try
		catch (Exception $e) { echo $e->getMessage(); }

		return $str."</tbody></table>";
	}
?>
