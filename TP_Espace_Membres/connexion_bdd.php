<?php
session_start();

try {
	$bdd = new PDO('mysql:host=localhost;dbname=tp_espace_membres;charset=utf8', 'root', '');
}
catch (Exception $e) {
	die('Erreur : '.$e->getMessage());
}

$pseudo = $_POST['pseudo'];
$automatique = $_POST['automatique'];

//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id, pass FROM membres WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $pseudo));

$resultat = $req->fetch();

$req->closeCursor();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);

if (!$resultat) {
?>
	<h1>Mauvais identifiant ou mot de passe !!!</h1>
    <p><a href="connexion.php">Retour à la page de connexion.</a></p>
<?php
} else {
    if ($isPasswordCorrect) {
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        echo 'Vous êtes connecté !';

        if ($automatique) {
	        echo 'Cookie créer !';
	        setcookie("Pseudo", $pseudo, time()+3600);
	        setcookie("MDR", $resultat['pass'], time()+3600);
        }
    }
    else {
	?>
		<h1>Mauvais identifiant ou mot de passe !!!</h1>
	    <p><a href="connexion.php">Retour à la page de connexion.</a></p>
	<?php
    }
}

header('Location: index.php');
?>