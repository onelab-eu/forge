<?php

$content_fr = array(
	'clientHost' => 'Client',
	'sshPort' => 'Port SSH',
	'sliceName' => 'Nom de la slice',
	'serverHost' => 'Serveur',
	'serverPort' => 'Port serveur',
	'fileName' => 'Nom expérience',
	'download' => 'Télécharger le fichier',
);

$content_en = array(
	'clientHost' => 'Client',
	'sshPort' => 'SSH Port',
	'sliceName' => 'Slice name',
	'serverHost' => 'Server',
	'serverPort' => 'Server port',
	'fileName' => 'Experiment name',
	'download' => 'Download file',
);

if (array_key_exists('lang', $_GET) and htmlspecialchars($_GET['lang']) == 'en')
{
	$content = $content_en;
}
else
{
	$content = $content_fr;
}

?>
