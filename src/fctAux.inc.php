<?php
function enTete( $titre ) {
	$tete = "<!DOCTYPE html>\n".
			"<html lang=\"fr\">\n".
			"<head>\n".
			"<meta http-equiv=\"Content-type\" content=\"text/html;charset=UTF-8\">\n".
			"<title>$titre</title>\n".
			"<meta charset=\"utf-8\">\n".
			"<link rel=\"stylesheet\" href=\"style.css\">\n".
			"</head>\n";
	return $tete;
}

function corps( $titre, $contenu ) {
	$corps=	"<body>\n".
			"<h1>$titre</h1>\n".
			$contenu.
			"</body>\n";
	return $corps;
}

function pied() {
	$pied = "</html>\n";
	return $pied;
}

/*function validerSession(){
    session_start();

    if(! isset($_SESSION['utilisateur'])) {
        header('Location: connexion.php');
    }
}*/
?>
