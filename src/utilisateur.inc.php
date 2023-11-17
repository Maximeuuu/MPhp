<?php

/*classe permettant de representer les tuples de la table client */
class MUtilisateur
{
	/*avec PDO, il faut que les noms attributs soient les mêmes que ceux de la table*/
	private $idu;
	private $prenom;
	private $dateconnexion;

	/* Les méthodes qui commencent par __ sont des methodes magiques */
	/* Elles sont appelées automatiquement par php suite à certains événements. */
	/* Ici c'est l'appel à new sur la classe qui déclenche l'exécution de la méthode */
	/* des valeurs par défaut doivent être spécifiées pour les paramètres du constructeur sinon
	il y aura une erreur lorsqu'il sera appelé automatiquement par PDO 
	*/

	public function __construct($i=-1,$p="",$d="")
	{
		$this->idu = $i;
		$this->prenom = $p;
		$this->dateconnexion = $d;
	}

	public function getIdUtilisateur() { return $this->idu; }
	public function getPrenom() { return $this->prenom;}
	public function getDateConnexion() { return $this->dateconnexion; }

	public function __toString()
	{
		$res = "id:".$this->idu."\n";
		$res = $res ."prenom:".$this->prenom."\n";
		$res = $res ."date:".$this->dateconnexion."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

?>

