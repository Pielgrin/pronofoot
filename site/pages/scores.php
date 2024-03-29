<h2>Admin : saisie des scores</h2>
<?php
require_once('lib/journee.php');
require_once('lib/match.php');
require_once('lib/joueur.php');
require_once('lib/prono.php');
require_once('lib/news.php');

$waiting_journees = journee_get_waiting_results();
if(mysql_num_rows(journee_get_nbunterminate()) > 1) {
	echo '<p>Journée du: ';
	$idj = '';
	while($j = mysql_fetch_assoc($waiting_journees)) {
		if($j['id'] != $idj)
			echo '<strong><a href="scores-'.$j['id'].'">'.shortdate_to_str($j['numero']).'</a></strong> ';
		$idj = $j['id'];
	}
	echo '<br /><br />';
}

if(isset($_GET['journee'])) {
	$idjournee = intval($_GET['journee']);
	if(!journee_exists($idjournee))
		echo '<span class="error">La journée demandée n\'existe pas</span>';
	elseif(!journee_has_match($idjournee))
		echo '<span class="error">Aucun match n\'est enregistré pour la journée demandée</span>';
	else {
		$journee = journee_get_by_id($idjournee);
		echo '<p class="strong">Saisie des scores pour la journée '.$journee['numero'].' du '.shortdate_to_str($journee['date']).'</p>';
	}
}
else {
	$journee = mysql_fetch_assoc(journee_get_waiting_results());
	$idjournee = $journee['id'];
	if(!journee_has_match($idjournee))
		echo '<span class="error">Aucun match n\'est enregistré pour la prochaine journée</span>';
	else
		echo '<p class="strong">Saisie des scores pour la journée '.$journee['numero'].' du '.shortdate_to_str($journee['date']).'</p>';
}

if(isset($_POST['submit_scores'])) {
	$display = array('error' => '', 'success' => '');
	$good = 0;
	foreach($_POST as $key => $score) {
		$idm = explode('_',$key);
		if($idm[0] == 'match' && $score != '') {
			if(valid_score($score)) {
				if(match_set_score($idm[1], $score)) { /* maj des <points;nbmatchs> ici */
					$idj = match_get_journee($idm[1]);
					if(!journee_remain_match($idj)) { news_make_results($idj); news_feed_rss(); journee_terminate($idj); }
					$good += 1;
					$display['success'] = '<span class="success">Les scores de <strong>'.$good.'</strong> match(s) ont été enregistrés et les joueur mis à jour !</span>';
				}
			}
			else
				$display['error'] = '<span class="error">Un ou plusieurs scores n\'ont pas été enregistrés, veuillez réessayer</span>';
		}
	}
	echo $display['success'];
	echo $display['error'];
}

$matchs = journee_get_waiting_results($idjournee);
if(mysql_num_rows($matchs)) {
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<?php
	while($match = mysql_fetch_assoc($matchs)) {
		echo '<p><input type="text" name="match_'.$match['idmatch'].'" size="4" />&nbsp;&nbsp;'.$match['equipe1'].' - '.$match['equipe2'].'</p>';
	}
	?>
	<br />
	<p>
		<input type="submit" name="submit_scores" id="submit_scores" value="Valider les scores" />
	</p>
</form>
<p class="smalltext">
Note :<br />
Les scores doivent être au format "Score1-Score2" (exemples : 3-2, 0-1, 5-1...)<br />
Vous n'êtes pas obligé de remplir tous les scores d'un coup, les points des joueurs se mettent à jour à chaque score donné.
</p>
<?php
}
