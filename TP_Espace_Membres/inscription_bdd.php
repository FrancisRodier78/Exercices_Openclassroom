<?php

try {
	$bdd = new PDO('mysql:host=localhost;dbname=tp_espace_membres;charset=utf8', 'root', '');
}
catch (Exception $e) {
	die('Erreur : '.$e->getMessage());
}

$pseudo = $_POST['pseudo'];
$email = $_POST['email'];
$avatar = $_POST['avatar'];

// Vérification de la validité des informations
$req = $bdd->prepare('SELECT pseudo FROM membres WHERE (pseudo = :pseudo)');
$req->execute(array(
    'pseudo' => $pseudo));

$data = $req->fetch();

$req->closeCursor();

if (in_array($pseudo, $data)) {
?>
	<h1>Le pseudo existe déja !!!</h1>
    <p><a href="index.php">Retour à la page d'inscription.</a></p>
<?php
} elseif ($_POST['pass'] != $_POST['confirmer_pass']) {
?>
	<h1>Le mot de passe n'est pas similaire !!!</h1>
    <p><a href="index.php">Retour à la page d'inscription.</a></p>
<?php
} else {
	// Hachage du mot de passe
	$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);

	// Insertion
	$req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, avatar, date_inscription) VALUES(:pseudo, :pass, :email, :avatar, CURDATE())');
	$req->execute(array(
	    'pseudo' => $pseudo,
	    'pass' => $pass_hache,
	    'email' => $email,
		'avatar' => $avatar));

	$req->closeCursor();

	header('Location: index.php');
}
?>
