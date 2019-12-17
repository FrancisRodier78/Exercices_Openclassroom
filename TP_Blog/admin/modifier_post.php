<?php 
	// Connexion à la base de donnée
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=TP_Blog;charset=utf8', 'root', '');
	}
	catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}

	// Modification du commentaire à l'aide d'une requête préparée
	$req = $bdd->prepare('UPDATE billets SET titre=?,contenu=?,NOW() WHERE ?');
	$req->execute(array($_POST['titre'], $_POST['contenu'], $_POST['billet']));

	$req->closeCursor();

	// Redirection du visiteur vers la page du minichat
	header('Location: ../index.php?numBillet=0');
?>
