<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mon TP_Blog</title>
	<link rel="stylesheet" type="text/css" href="TP_Blog.css">
</head>

<body>
	<h1>Mon Super TP_Blog !</h1>
	<p><a href="index.php">Retour à la liste des billets.</a></p>

<?php
// Connexion à la base de donnée
try {
	$bdd = new PDO('mysql:host=localhost;dbname=TP_Blog;charset=utf8', 'root', '');
}
catch (Exception $e) {
	die('Erreur : '.$e->getMessage());
}

// Lecture du billet
$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
$req->execute(array($_GET['billet']));
$donnees = $req->fetch();
?>

<div class="news">
	<h3>
		<?php echo htmlspecialchars($donnees['titre']) ?>
		<em>le <?php echo htmlspecialchars($donnees['date_creation_fr']); ?></em>
	</h3>

	<p>
		<?php // On affiche le contenu du billet ?>
		<?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?>
		<br />
	</p>
</div>	

<h2>Commentaires</h2>

<?php
$req->closeCursor(); 

// Récupérations des commentaires
$req = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');
$req->execute(array($_GET['billet']));

while ($donnees = $req->fetch()) {
?>
<p><strong><?php echo nl2br(htmlspecialchars($donnees['auteur'])) ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?></p>
<p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])) ?></p>
<?php
}
$req->closeCursor();
?>

<form action="commentaires_post.php" method="post">
    <p>
    	<input id="billet" name="billet" type="hidden" value=<?php $_GET['billet'] ?> />
        <label for="auteur">Auteur</label> : <input type="text" name="auteur" id="auteur" /><br />
        <label for="commentaire">Commentaire</label> :  <input type="text" name="commentaire" id="commentaire" /><br />

        <input type="submit" value="Envoyer" />
	</p>
</form>

</body>
</html>