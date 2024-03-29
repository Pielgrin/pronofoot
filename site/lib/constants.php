<?php
/***************************************************/
/* Fichier PHP regroupant des constantes usuelles  */
/***************************************************/

define('TITLE', 'Prono Foot');

define('TIMEZONE', 'Europe/Paris');

define('DEFAULT_MAIL', 'pronofoot@julienp.fr');

define('WEBLINK', 'http://pronofoot.julienp.fr');

define('FLUX_RSS', 'resources/rss.xml');

// durée timeout pour le status 'online' en minutes
define('TIMEOUT', 5);

// durée des cookies
define('COOKIE_EXPIRE', time() + 365 * 24 * 3600); // 1 an
define('COOKIE_UNSET',  time() - 3600);

$idadmins = array(1,8);
$restricted = array('add','maj','scores','mailing','demandes','groupes');
$authorized = array('accueil','contact','inscription','password','news','reglement');
