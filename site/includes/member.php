<?php
if(!$_SESSION['is_connect']) {
	if(isset($_POST['submit-connection'])) {
		echo '<span class="error">Identifiants incorrects</span>';
	} ?>
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<p>
			<label class="user block">Identifiant</label>
			<input type="text" name="log_login" id="log_login" size="25" />
		</p>
		<p>
			<label class="lock block">Pass</label>
			<input type="password" name="pass" id="pass" size="25" />
		</p>
		<p>
			<input type="submit" name="submit-connection" id="submit-connection" value="Connexion" />
		</p>
		<p class="key"><a href="password">Mot de passe oublié ?</a></p>
	</form><?php 
}
else { 
	joueur_refresh($_SESSION['id']);
	joueur_timeout();
	$nb = joueur_get_nbconnect();
	?>
	<span class="success">Vous êtes connecté</span>
	<p class="user"><?php echo $_SESSION['pseudo']; ?> (<a href="profil">mon profil</a>)</p>
	<p class="group"><?php echo '<span id="nbco">'.joueur_print_nbco($nb).'</span> en ligne' ?> (<a id="see_list" href="javascript:;">voir liste</a>)</p>
	<p class="disconnect"><a href="deconnexion">Déconnexion</a></p><?php
}
