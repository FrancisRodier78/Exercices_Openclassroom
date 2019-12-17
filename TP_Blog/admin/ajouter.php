<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mon TP_Blog</title>
	<link rel="stylesheet" type="text/css" href="TP_Blog.css">
</head>

<body>
	<h1>Mon Super TP_Blog !</h1>
	<p><a href="../index.php?numBillet=0">Retour à la liste des billets.</a></p>

<?php 
if (isset($_POST['titre']) and isset($_POST['contenu'])) {
	// Connexion à la base de donnée
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=TP_Blog;charset=utf8', 'root', '');
	}
	catch (Exception $e) {
		die('Erreur : '.$e->getMessage());
	}

	// Insertion du billet à l'aide d'une requête préparée
	$req = $bdd->prepare('INSERT INTO billets (titre, contenu, date_creation) VALUES (?, ?, NOW())');
	$req->execute(array($_POST['titre'], $_POST['contenu']));

	$req->closeCursor();

	// Redirection du visiteur vers la page du minichat
	header('Location: ../index.php?numBillet=0');
} else { 
?>
	<form action="ajouter.php" method="post">
	<p>
	    <label for="titre">Titre</label> : <input type="text" name="titre" id="titre" /><br />
	    <label for="contenu">Contenu</label> :  <input type="text" name="contenu" id="contenu" /><br />

	    <input type="submit" value="Envoyer" />
	</p>
	</form>
<?php	
}
?>
</body>
</html>