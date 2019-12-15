<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=TP_Blog;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Insertion du commentaire à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO commentaires (id_billet, auteur, commentaire,date_commentaire) VALUES (?, ?, ?, NOW())');
$id_billet = $_POST['billet'];
$req->execute(array($id_billet, $_POST['auteur'], $_POST['commentaire']));

// Redirection du visiteur vers la page du minichat
header('Location: commentaires.php?billet='.$_POST['billet']);
?>