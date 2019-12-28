<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mon TP_Blog</title>
	<link rel="stylesheet" type="text/css" href="TP_Blog.css">
</head>

<body>
	<h1>Mon superbe TP_Blog.</h1>
	<p>Dernier billets du blog</p>

<?php
// Connexion à la base de données
try {
	$bdd = new PDO('mysql:host=localhost;dbname=TP_Blog;charset=utf8', 'root', '');
}
catch(Exception $e) {
	die('Erreur : '.$e->getMessage());
}

// On récupère les 3 derniers billets
if (isset($_GET['numBillet'])) {
	$numBillet = $_GET['numBillet'];
} else {
	$numBillet = 0;
};

$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT :debut, 3');
$req->bindParam(':debut', $numBillet, PDO::PARAM_INT);
$result = $req->execute();

$nbBilletsAffiche = 0;
while ($donnees = $req->fetch()) 
{
	$nbBilletsAffiche++;
?>
<div class="news">
	<?php include'affichage_billet.php'; ?>
	<p>
		<em><a href="commentaires.php?billet=<?php echo $donnees['id'] ?>">Commentaires</a></em>
		<em><a href="admin/modifier.php?billet=<?php echo $donnees['id'] ?>">Modifier</a></em>
		<em><a href="admin/supprimer.php?billet=<?php echo $donnees['id'] ?>">Supprimer</a></em>
	</p>
</div>	
<?php
} // Fin de la boucle des billets
$req->closeCursor();

// On compte les billets
$req = $bdd->query('SELECT COUNT(*) AS nb_billets FROM billets');

$donnees = $req->fetch();
?> <em>Page  : </em> <?php
$j = 0;
for ($i=0; $i < $donnees['nb_billets']; $i = $i + $nbBilletsAffiche) { 
	$j++; ?>
	<em><a href="index.php?numBillet=<?php echo $i ?>"><?php echo $j ?></a></em>
<?php
}$req->closeCursor();
?>

	<p>
		<em><a href="admin/ajouter.php">Ajouter billet</a></em>
	</p>

</body>
</html>