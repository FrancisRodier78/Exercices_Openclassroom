<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mon TP_Blog</title>
	<link rel="stylesheet" type="text/css" href="TP_Blog.css">
</head>

<body>
<?php 
if (isset($_POST['billet'])) {
	// Connexion à la base de donnée
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=TP_Blog;charset=utf8', 'root', '');
	}
	catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}

	// Delete du billet à l'aide d'une requête préparée
	$req = $bdd->prepare('DELETE FROM billets WHERE id = ?');
	$req->execute(array($_POST['billet']));

	$req->closeCursor();
} 
	// Redirection du visiteur vers la page du minichat
	header('Location: ../index.php?numBillet=0');
?>
</body>
</html>