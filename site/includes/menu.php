<ul>
	<li><a href="accueil">Accueil</a></li>
	<?php 
	if($_SESSION['is_connect']) { ?>
		<li><a href="mypronos">Mes pronos</a></li>
		<li><a href="pronos">Tous les pronos</a></li>
		<li><a href="historique">Historique</a></li>
		<li><a href="classements">Classements</a></li>
		
			<?php 
			if(in_array($_SESSION['id'], $idadmins)) { ?>
				<li><a href="javascript:void();">Admin</a>
					<ul>
						<li><a href="add">Création</a></li>
						<li><a href="maj">Mises à jour</a></li>
						<li><a href="groupes">Groupes</a></li>
						<li><a href="scores">Saisie scores</a></li>
						<li><a href="demandes">Demandes</a></li>
						<li><a href="mailing">Mailing</a></li>
					</ul>
				</li><?php
			}
	}
	else { ?>
		<li><a href="news">Actualités</a></li>
		<li><a href="inscription">S'inscrire</a></li><?php
	} ?>
</ul>
