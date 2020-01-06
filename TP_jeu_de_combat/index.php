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
	//exit();
}

$db = new PDO('mysql:host=localhost;dbname=tp_jeu_de_combat', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new PersonnagesManager($db);

if (isset($_SESSION['perso'])) {
  $perso = $_SESSION['perso'];
}

if (isset($_POST['creer']) && isset($_POST['nom'])) {
	switch ($_POST['type']) {
		case 'magicien':
			$perso = new Magicien(['nom' => $_POST['nom']]);
			break;
		case 'guerrier':
			$perso = new Guerrier(['nom' => $_POST['nom']]);
			break;
		default:
			$message = 'Le type de personnage est invalide.';
			break;
	}

	if (isset($perso)) {
		if (!$perso->nomValide()) {
			$messsage = 'Le nom choisi est invalide.';
			unset($perso);
		} elseif ($manager->exists($perso->getNom())) {
			$message = 'Le nom du personnage est déjà pris.';
			unset($perso);
		} else {
			$manager->add($perso);
		}
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
					var_dump($perso->getDegats());

					$manager->update($perso);
					$manager->update($persoAFrapper);
					break;
				case Personnages::PERSONNAGE_TUE:
					$message = 'Vous avez tué ce personnage !';
					$manager->update($perso);
					$manager->delete($persoAFrapper);
					break;
				case Personnages::PERSO_ENDORMI:
					$message = 'Vous êtes endormi, vous ne pouvez pas frapper de personnage !';
					break;
			}
		}		
	}	
} elseif (isset($_GET['ensorceler'])) {
	if (!isset($perso)) {
		$message = 'Merci de créer un personnage ou de vous identifier.';
	} else {
		if ($perso->getType() != 'magicien') {
			$message = 'Seuls les magicien peuvent ensorceler des personnages !';
		} else {
			if (!$manager->exists((int) $_GET['ensorceler'])) {
				$message = 'Le personnage que vous voulez ensorceler n\'existe pas !';
			} else {
				$persoAEnsorceler = $manager->get((int) $_GET['ensorceler']);
				$retour = $perso->lancerUnSort($persoAEnsorceler);

				switch ($retour) {
					case Personnages::CEST_MOI:
						$message = 'Mais;;; pourquoi voulez-vous vous ensorceler ???';
						break;
					case Personnages::PERSONNAGE_ENSORCELE:
						$message = 'Le personnage est bien ensorcelé !';
						$manager->update($perso);
						$manager->update($persoAEnsorceler);
						break;
					case Personnages::PAS_DE_MAGIE:
						$message = 'Vous n\'avez pas de magie !';
						break;
					case Personnages::PERSO_ENDORMI:
						$message = 'Vous êtes endormi, vous ne pouvez pas lancer de sort !';
						break;
				}
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
	<p><a href="?deconnexion=1">Déconnexion</a></p>

	<fieldset>
		<legend>Mes informations</legend>
		<p>
			Type : <?= ucfirst($perso->getType()) ?><br />
			Nom : <?= htmlspecialchars($perso->getNom()) ?><br />
			Dégâts : <?= $perso->getDegats() ?>
<?php
switch ($perso->getType()) {
	case 'magicien':
		echo 'Magie : ';
		break;
	case 'guerrier':
		echo 'Protection : ';
		break;
}

echo $perso->getAtout();
?>
		</p>
	</fieldset>	

	<fieldset>
		<legend>Qui attaquer ?</legend>
		<p>
<?php
$retourpersos = $manager->getList($perso->getNom());

if (empty($retourpersos)) {
	echo 'Personne à frapper !';
} else {
	if ($perso->estEndormi()) {
		echo 'Un magicien vous a endormi ! Vous allez vous réveiller dans ', $perso->reveil(), '.';
	} else {
		foreach ($retourpersos as $unPerso) {
			echo '<a href="?frapper=', (int) $unPerso->getId(), '">', htmlspecialchars($unPerso->getNom()), '</a> (dégâts : ', $unPerso->getDegats(), ' | type : ', $unPerso->getType(), ')';

			if ($perso->getType() == 'magicien') {
				echo '| <a href="?ensorceler=', $unPerso->getId(); '">Lancer un sort <a>';
			}
			echo '<br />';
		}	
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
				Nom : <input type="text" name="nom" maxlength="50" /> <input type="submit" value="Utiliser ce personnage" name="utiliser" /><br />
				Type : 
				<select name="type">
					<option value="magicien">Magicien></option>
					<option value="guerrier">Guerrier></option>
				</select>
				<input type="submit" name="creer" value="Créer ce personnage"/>
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