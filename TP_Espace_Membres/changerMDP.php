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

	<div class="entree">
		<form method="post" action="changerMDP_bdd.php">
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
</body>
</html>