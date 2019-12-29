<?php
function chargerClasse($classname)
{
	require $classname . '.php';
}

spl_autoload_register('chargerClasse');

session_start();

if (isset($_GET['deconnexion'])) {
	session_destroy();
	header('Location . ');
	exit();
}

if (isset($_SESSION['perso'])) {
	$perso = $_SESSION['perso'];
}

$db = new PDO('mysql:host=localhost;dbname=tp_jeu_de_combat', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new PersonnagesManager($db);

if (isset($_SESSION['perso'])) {
  $perso = $_SESSION['perso'];
}

if (isset($_POST['creer']) && isset($_POST['nom'])) {
	$perso = new Personnages(['nom' => $_POST['nom']]);
	if (!$perso->nomValide()) {
		$messsage = 'Le nom choisi est invalide.';
		unset($perso);
	} elseif ($manager->exists($perso->getNom())) {
		$message = 'Le nom du personnage est déjà pris.';
		unset($perso);
	} else {
		$manager->add($perso);
	}
} elseif (isset($_POST['utiliser']) && isset($_POST['nom'])) {
	if ($manager->exists($_POST['nom'])) {
		$perso = $manager->get($_POST['nom']);
	} else {
		$message = 'Ce personnage n\'existe pas !';
	}			
}

elseif (isset($_GET['frapper'])) {
	if (!isset($perso)) {
		$message = 'Merci de créer un personnage ou de vous identifier.';
	} else {
		if (!$manager->exists((int) $_GET['frapper'])) {
			$message = 'Le personnage que vous voulez frapper n\'existe pas !';
		} else {
			$persoAFrapper = $manager->get((int) $_GET['frapper']);
			$retour = $perso->frapper($persoAFrapper);

			switch ($retour) {
				case Personnages::CEST_MOI:
					$message = 'Mais pourquoi voulez-vous vous frapper ???';
					break;
				case Personnages::PERSONNAGE_FRAPPE:
					$message = 'Le personnage a bien été frappé !';
					$manager->update($perso);
					$manager->update($persoAFrapper);
					break;
				case Personnages::PERSONNAGE_TUE:
					$message = 'Vous avez tué ce personnage !';
					$manager->update($perso);
					$manager->delete($persoAFrapper);
					break;
			}
		}		
	}	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>TP : jeu de combat</title>
		<meta charset="utf-8">
	</head>
	<body>
		<p>Nombre de personnages créés : <?= $manager->count() ?></p>
<?php
if (isset($message)) {
	echo '<p>', $message, '</p>';
}

if (isset($perso)) {
?>
	<fieldset>
		<legend>Mes informations</legend>
		<p>
			Nom : <?= htmlspecialchars($perso->getNom()) ?><br />
			Dégâts : <?= $perso->getDegats() ?>
		</p>
	</fieldset>	

	<fieldset>
		<legend>Qui frapper ?</legend>
		<p>
<?php
$persos = $manager->getList($perso->getNom());

if (empty($perso)) {
	echo 'Personne à frapper !';
} else {
	foreach ($persos as $unPerso) {
		var_dump($unPerso);
		echo '<a href="?frapper=', (int) $unPerso->getId(), '">', htmlspecialchars($unPerso->getNom()), '</a> (dégâts : ', $unPerso->getDegats(), ')<br />';
	}	
}
?>
		</p>
	</fieldset>
<?php
} else {
?>
		<form action="" method="post" >
			<p>
				Nom : <input type="text" name="nom" maxlength="50" />
				<input type="submit" name="creer" value="Créer ce personnage"/>
				<input type="submit" name="utiliser" value="Utiliser ce personnage">
			</p>
		</form>
<?php 
}
?>
	</body>
</html>
<?php
if (isset($perso)) {
	$_SESSION['perso'] = $perso;
}
?>