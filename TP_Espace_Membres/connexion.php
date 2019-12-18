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

<div class="entree">
	<form method="post" action="connexion_bdd.php">
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
</body>
</html>