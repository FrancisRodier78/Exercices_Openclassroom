<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mon TP_Blog</title>
	<link rel="stylesheet" type="text/css" href="TP_Blog.css">
</head>

<body>
	<h1>Mon Super TP_Blog !</h1>
	<p><a href="../index.php?numBillet=0">Retour à la liste des billets.</a></p>

	<form action="modifier_post.php" method="post">
	<p>
		<input id="billet" name="billet" type="hidden" value=<?php echo $_GET['billet'] ?> />
	    <label for="titre">Titre</label> : <input type="text" name="titre" id="titre" /><br />
	    <label for="contenu">Contenu</label> :  <input type="text" name="contenu" id="contenu" /><br />

	    <input type="submit" value="Modifier" />
	</p>
	</form>
</body>
</html>