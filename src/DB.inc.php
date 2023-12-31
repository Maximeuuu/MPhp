<?php

include("../../identifiantSQL.inc.php");

class DB {
	private static $instance = null; //mémorisation de l'instance de DB pour appliquer le pattern Singleton
	private $connect=null; //connexion PDO à la base

	/************************************************************************/
	//	Constructeur gerant  la connexion à la base via PDO
	//	NB : il est non utilisable a l'exterieur de la classe DB
	/************************************************************************/	
	private function __construct() {
		// Connexion à la base de données
		$connStr = 'pgsql:host='.getUtilisateur().' port='.getPortNumber().' dbname='.getLogin();
		try {
			// Connexion à la base
			$this->connect = new PDO($connStr, getLogin(), getMdp() );
			// Configuration facultative de la connexion
			$this->connect->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); 
			$this->connect->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); 
		}
		catch (PDOException $e) {
			echo "probleme de connexion :".$e->getMessage();
			return null;    
		}
	}

	/************************************************************************/
	//	Methode permettant d'obtenir un objet instance de DB
	//	NB : cet objet est unique pour l'exécution d'un même script PHP
	//	NB2: c'est une methode de classe.
	/************************************************************************/
	public static function getInstance() {
		if (is_null(self::$instance)) {
			try { 
				self::$instance = new DB(); 
			} 
			catch (PDOException $e) {
				echo $e;
			}
		} //fin IF
		$obj = self::$instance;

		if (($obj->connect) == null) {
			self::$instance=null;
		}
		return self::$instance;
	} //fin getInstance	 

	/************************************************************************/
	//	Methode permettant de fermer la connexion a la base de données
	/************************************************************************/
	public function close() {
		$this->connect = null;
	}

	/************************************************************************/
	//	Methode uniquement utilisable dans les méthodes de la class DB 
	//	permettant d'exécuter n'importe quelle requête SQL
	//	et renvoyant en résultat les tuples renvoyés par la requête
	//	sous forme d'un tableau d'objets
	//	param1 : texte de la requête à exécuter (éventuellement paramétrée)
	//	param2 : tableau des valeurs permettant d'instancier les paramètres de la requête
	//	NB : si la requête n'est pas paramétrée alors ce paramètre doit valoir null.
	//	param3 : nom de la classe devant être utilisée pour créer les objets qui vont
	//	représenter les différents tuples.
	//	NB : cette classe doit avoir des attributs qui portent le même que les attributs
	//	de la requête exécutée.
	//	ATTENTION : il doit y avoir autant de ? dans le texte de la requête
	//	que d'éléments dans le tableau passé en second paramètre.
	//	NB : si la requête ne renvoie aucun tuple alors la fonction renvoie un tableau vide
	/************************************************************************/
	private function execQuery($requete,$tparam,$nomClasse) {
		//on prépare la requête
		$stmt = $this->connect->prepare($requete);
		//on indique que l'on va récupére les tuples sous forme d'objets instance de Client
		$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $nomClasse); 
		//on exécute la requête
		if ($tparam != null) {
			$stmt->execute($tparam);
		}
		else {
			$stmt->execute();
		}
		//récupération du résultat de la requête sous forme d'un tableau d'objets
		$tab = array();
		$tuple = $stmt->fetch(); //on récupère le premier tuple sous forme d'objet
		if ($tuple) {
			//au moins un tuple a été renvoyé
			 while ($tuple != false) {
				$tab[]=$tuple; //on ajoute l'objet en fin de tableau
				$tuple = $stmt->fetch(); //on récupère un tuple sous la forme
				//d'un objet instance de la classe $nomClasse	       
			} //fin du while	           	     
		}
	return $tab;    
	}

	/************************************************************************/
	//	Methode utilisable uniquement dans les méthodes de la classe DB
	//	permettant d'exécuter n'importe quel ordre SQL (update, delete ou insert)
	//	autre qu'une requête.
	//	Résultat : nombre de tuples affectés par l'exécution de l'ordre SQL
	//	param1 : texte de l'ordre SQL à exécuter (éventuellement paramétré)
	//	param2 : tableau des valeurs permettant d'instancier les paramètres de l'ordre SQL
	//	ATTENTION : il doit y avoir autant de ? dans le texte de la requête
	//	que d'éléments dans le tableau passé en second paramètre.
	/************************************************************************/
	private function execMaj($ordreSQL,$tparam) {
		$stmt = $this->connect->prepare($ordreSQL);
		$res = $stmt->execute($tparam); //execution de l'ordre SQL      	     
		return $stmt->rowCount();
	}

	/*************************************************************************
	* Fonctions qui peuvent être utilisées dans les scripts PHP
	*************************************************************************/
	public function getUtilisateurs() {
		$requete = 'select * from MUtilisateur';
		return $this->execQuery($requete,null,'MUtilisateur');
	}
	
	public function getMessages() {
		$requete = 'select * from MMEssage';
		return $this->execQuery($requete,null,'MMessage');
	}

	public function getMessagesID($id1,$id2) {
		$requete = 'select * from MMessage where idusource = ? and idudest = ? or idusource = ? and idudest = ?';
		$tparam = array($id1,$id2,$id2,$id1);
		return $this->execQuery($requete,$tparam,'MMEssage');
	}

	public function getMessageAtDate($date) {
		$requete = 'select * from MMessage where dateEnvois = ?';
		return $this->execQuery($requete,array($date),'MMessage');
	}
	
	public function insertMessage($id,$date,$contenu) {
		$requete = 'insert into MMessage values(?,?,?)';
		$tparam = array($id,$date,$contenu);
		return $this->execMaj($requete,$tparam);
	}
	
	public function updateContenuMessage($id,$contenu) {
		$requete = 'update MMessage set $contenu = ? where idMessage = ?';
		$tparam = array($contenu,$id);
		return $this->execMaj($requete,$tparam);
	}

	public function deleteContenuMessage($id) {
		$requete = 'update MMessage set $contenu = \'message supprime\' where idMessage = ?';
		$tparam = array($id);
		return $this->execMaj($requete,$tparam);
	}
	
	public function getMessageCommunication($idUserS,$idUserD) {
		$requete = 'select * from MCommunication where idUserSource = ? and idUserDestination = ?';
		return $this->execQuery($requete,$idUserS,$idUserD);
	}

	public function insertCommunication($idUserS,$idUserD,$idMessage) {
		$requete = 'insert into MCommunication values(?,?,?)';
		$tparam = array($idUserS,$idUserD,$idMessage);
		return $this->execMaj($requete,$tparam);
	}

} //fin classe DB

?>

