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
		<form method="post" action="inscription_bdd.php">
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
                    <label for="confirmer_pass">Confirmer mot de passe</label>
                    <input type="password" name="confirmer_pass" id="confirmer_pass" required="" class="form-control" placeholder="Confirmer votre mot de passe">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required="" class="form-control" placeholder="Votre Email">
                </div>

                <div class="form-group col-lg-6">
					<label for="avatar">Choisir un avatar.</label>
					<input type="file" id="avatar" name="avatar" accept=".jpg, .jpeg, .png">
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