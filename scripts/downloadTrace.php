<?php

$url = 'http://'.$_GET['clientHost'].':'.$_GET['clientPort'].'/'.$_GET['fileName'].'.pcap';


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$_GET['fileName'].'.pcap');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
ob_clean();
flush();
readfile($url);
exit;

?>
