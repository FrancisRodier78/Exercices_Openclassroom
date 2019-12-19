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
	<h1>Inscription</h1>
	<p><a href="index.php">Retour à la première page.</a></p>

    <?php
    if (isset($_POST['pseudo']) and isset($_POST['pass']) and isset($_POST['nouveau_pass']) and isset($_POST['confirmer_pass'])) {
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
    } else {
        ?>
        <div class="entree">
            <form method="post" action="changerMDP.php">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="pseudo">pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" required="" class="form-control" placeholder="Pseudo">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="pass">mot de passe actuel</label>
                        <input type="password" name="pass" id="pass" required="" class="form-control" placeholder="Votre mot de passe">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="nouveau_pass">Nouveau mot de passe</label>
                        <input type="password" name="nouveau_pass" id="nouveau_pass" required="" class="form-control" placeholder="Nouveau mot de passe">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="confirmer_pass">Confirmer mot de passe</label>
                        <input type="password" name="confirmer_pass" id="confirmer_pass" required="" class="form-control" placeholder="Confirmer mot de passe">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary pull-right">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>  
        <?php
    }
    ?>
    </body>
</html>