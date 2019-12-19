<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mon TP_Espace_Membres</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="TP_Espace_Membres.css">
</head>

<body>
	<h1>Connexion</h1>
    <p><a href="index.php">Retour à la première page.</a></p>

    <?php
    if (isset($_POST['pseudo']) and isset($_POST['pass'])) {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=tp_espace_membres;charset=utf8', 'root', '');
        }
        catch (Exception $e) {
            die('Erreur : '.$e->getMessage());
        }

        $pseudo = $_POST['pseudo'];

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

                if (isset($_POST['automatique'])) {
                    setcookie("Pseudo", $pseudo, time()+3600);
                    setcookie("MDR", $resultat['pass'], time()+3600);
                }
            } else {
            ?>
                <h1>Mauvais identifiant ou mot de passe !!!!</h1>
                <p><a href="connexion.php">Retour à la page de connexion.</a></p>
            <?php
            }
        }

        //header('Location: index.php');
    } else {
        ?>
        <div class="entree">
            <form method="post" action="connexion.php">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="pseudo">Pseudonyme</label>
                        <input type="text" name="pseudo" id="pseudo" required="" class="form-control" placeholder="Votre Pseudonyme">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="pass">mot de passe</label>
                        <input type="password" name="pass" id="pass" required="" class="form-control" placeholder="Votre mot de passe">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="automatique">Connexion automatique</label>
                        <input type="checkbox" name="automatique" value="automatique"><br>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary pull-right">Envoyer</button>
                    </div>
                </div>
            </form></div>   
    <?php } ?>
</body>
</html>