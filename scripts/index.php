<?php

header('Content-Type: text / plain; charset = utf-8');
header('Access-control-Allow-Origin: *');
	/*
		$1 SSH_KEY
		$2 CLIENT_HOST
		$3 SSH_PORT
		$4 SLICENAME
		$5 SERVER_HOST:SERVER_PORT
		$6 FILE_NAME
	*/
	$serverAndPort = explode(':', $_POST['serverAndPort']);
	$serverHost = $serverAndPort[0];
	$port = $serverAndPort[1];
	$message=shell_exec("/var/www/forge.npafi.org/scripts/phpScript.sh /var/www/forge.npafi.org/scripts/ple.key ".$_POST['clientHost']." ".$_POST['sshPort']." ".$_POST['sliceName']." ".$serverHost." ".$port." ".$_POST['fileName']." ".$_POST['fileTarget']."; echo $?");

	echo $message;

?>
