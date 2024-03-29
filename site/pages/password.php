<h2>Récupération de mot de pass</h2>
<?php
if($_SESSION['is_connect'])
	header('location: accueil'); // Redirection de cohérence (status<->page)

require_once('lib/constants.php');
require_once('lib/utils.php');

if(isset($_POST['submit-mail'])) {
	$mail = clean_str($_POST['lost_mail']);
	
	if(!valid_email($mail))
		echo '<p class="error">Le mail entré est invalide</p>';
	elseif($_POST['confirm'] != $_POST['rand'])
		echo '<p class="error">Le code de sécurité ne correspond pas</p>';
	elseif(!joueur_exists($mail))
		echo '<p class="error">Ce mail n\'existe pas dans la base de données</p>';
	else {
		$new_pass = generate_password(8);
	
		$message = "Bonjour,

Vous avez fait une demande de nouveau mot de passe sur le site Prono Foot. Si ce n'est pas le cas, merci de prévenir un administrateur.

Votre nouveau mot de passe est le suivant : $new_pass
Votre identifiant reste le même : $mail

Veuillez conserver ce message précieusement, pour éviter de perdre à nouveau votre mot de passe. Vous pouvez aussi le modifier pour en choisir un que vous retiendrez mieux en vous connectant sur le site, dans l'espace membre.

L'équipe Prono Foot
".DEFAULT_MAIL."\n".WEBLINK;
	
		if(send_mail(DEFAULT_MAIL, $mail, 'Prono Foot', 'Votre mot de passe a été modifié', $message)) {
			joueur_update_pass(joueur_get_id($mail), crypt_password($new_pass));
			echo '<p class="success">Votre mot de pas vient d\'être renouvellé et envoyé à l\'adresse email fournie</p>';
		}
		else
			echo '<p class="error">L\'envoi du mail n\'a pas fonctionné, veuillez réessayer. Si le problème persiste, contactez un administrateur</p>';
	}
}
echo '<p>Veuillez entrer l\'adresse mail du compte pour lequel vous avez perdu le mot de passe</p>';
?>

<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
	<p>
		<label>Email :</label>
		<input type="text" name="lost_mail" size="30" />
	</p>
	<p>
		Code de sécurité : &nbsp;<strong><?php echo $confirm=substr(md5(rand()), 3, 4); ?></strong><br />
		<label for="confirm">Merci de recopier le code donné ci-dessus : </label>
		<input type="text" name="confirm" id="confirm" maxlength="4" size="4" />
		<input type="hidden" name="rand" id="rand" value="<?php echo $confirm; ?>" />
	</p>
	<p>
		<input type="submit" name="submit-mail" value="Envoyer" />
	</p>
</form>
