<?php

try {
	$bdd = new PDO('mysql:host=localhost;dbname=tp_espace_membres;charset=utf8', 'root', '');
}
catch (Exception $e) {
	die('Erreur : '.$e->getMessage());
}

$pseudo = $_POST['pseudo'];
$pass = $_POST['pass'];
$nouveau_pass = $_POST['nouveau_pass'];
$confirmer_pass = $_POST['confirmer_pass'];

// Vérification de la validité des informations
$req = $bdd->prepare('SELECT pseudo, pass FROM membres WHERE (pseudo = :pseudo)');
$req->execute(array(
    'pseudo' => $pseudo));

$data = $req->fetch();

$isPasswordCorrect = password_verify($pass, $data['pass']);

$req->closeCursor();

if ($nouveau_pass != $confirmer_pass) {
?>
	<h1>Le mot de passe n'est pas similaire !!!</h1>
    <p><a href="changerMDP.php">Retour à la page de changement.</a></p>
<?php
} elseif (!$isPasswordCorrect) {
?>
	<h1>Le mot de passe a changer n'est pas bon !!!</h1>
    <p><a href="changerMDP.php">Retour à la page de changement.</a></p>
<?php
} else {
	// Hachage du mot de passe
	$pass_hache = password_hash($nouveau_pass, PASSWORD_DEFAULT);

	// Insertion
	$req = $bdd->prepare('UPDATE membres SET pass = :pass WHERE pseudo = :pseudo');
	$req->execute(array(
	    'pseudo' => $pseudo,
	    'pass' => $pass_hache));

	$req->closeCursor();

	header('Location: index.php');
}
?>
