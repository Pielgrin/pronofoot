<?php
if(!$_SESSION['is_connect']) { ?>
	<h2>Accueil</h2>
	<div class="bienvenue">
	<img src="images/accueil_ballon.png" alt="Pronostics de Football !" />
	<p>Bienvenue sur le site de pronostics pour le "big ligue 1" ! <span class="smalltext">(anciennement "big five")</span></p>
	</div>
	<p class="go acc_dec clear">Il faut se connecter dans l'espace membre pour accéder aux fonctionnalités du site</p>
	<p class="go acc_dec">Si vous n'avez pas de compte et que vous voulez en créer un, <a href="inscription">cliquez ici</a></p>
	<p class="go acc_dec">Si vous avez un problème ou juste besoin de contacter un admin, <a href="contact">cliquez ici</a></p>
	<br />
	<p class="ystar acc_dec">Pour consulter les règles du jeu, <a href="reglement">cliquez ici</a></p>
	<?php
}
else {
	include_once('news.php');
}
