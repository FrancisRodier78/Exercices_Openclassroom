	<h3>
		<?php echo htmlspecialchars($donnees['titre']) ?>
		<em>le <?php echo htmlspecialchars($donnees['date_creation_fr']); ?></em>
	</h3>

	<p>
		<?php // On affiche le contenu du billet ?>
		<?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?>
		<br />
	</p>
