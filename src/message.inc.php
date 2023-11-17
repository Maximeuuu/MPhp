<?php

/*classe permettant de representer les tuples de la table client */
class MMessage
{
	/*avec PDO, il faut que les noms attributs soient les mêmes que ceux de la table*/
	private $idmessage;
	private $idusource;
	private $idudest;
	private $dateenvois;
	private $contenu;

	/* Les méthodes qui commencent par __ sont des methodes magiques */
	/* Elles sont appelées automatiquement par php suite à certains événements. */
	/* Ici c'est l'appel à new sur la classe qui déclenche l'exécution de la méthode */
	/* des valeurs par défaut doivent être spécifiées pour les paramètres du constructeur sinon
	il y aura une erreur lorsqu'il sera appelé automatiquement par PDO 
	*/

	public function __construct($i1=-1,$i2=-1,$i3=-1,$d="",$c="")
	{
		$this->idmessage = $i1;
		$this->idusource = $i2;
		$this->idudest = $i3;
		$this->dateenvois = $d;
		$this->contenu = $c;
	}

	public function getIdMessage() { return $this->idmessage; }
	public function getIdUtilisateur() { return $this->idusource;}
	public function getIdDestinataire() { return $this->idudest;}
	public function getDateEnvois() { return $this->dateenvois;}
	public function getContenu() { return $this->contenu; }

	public function __toString()
	{
		$res = "idmessage:".$this->idmessage."\n";
		$res = $res ."idusource:".$this->idusource."\n";
		$res = $res ."idudest:".$this->idudest."\n";
		$res = $res ."dateenvois:".$this->dateenvois."\n";
		$res = $res ."contenu:".$this->contenu."\n";
		$res = $res ."<br/>";
		return $res;
	}
}

//test
//$unclient = new Client(5,'Dupont','Le Havre');
//echo $unclient;
?>

