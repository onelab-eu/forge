#!/bin/bash
# $1 SERVER_IP
# $2 SERVER_PORT
# $3 FILE_NAME
# $4 FILE_REMOTE_SERVER

# TODO now working with eth0 to modify for tun tap device

sudo -S tcpdump -ni eth0 -w /var/www/html/$3.pcap port $2 &
sleep 2 && wget http://$1:$2/$4
sleep 2
sudo -S killall tcpdump

echo "<?php" > index.php
echo "\$file = '$3.pcap';" >> index.php
echo "header('Content-Type: text / plain; charset = utf-8');" >> index.php
echo "header('Access-control-Allow-Origin: *');" >> index.php
echo "header('Access-control-Allow-Methods: GET, POST');" >> index.php
echo "\$handle = fopen(\$file, 'rb');" >> index.php
echo "\$contents = unpack('H*', fread(\$handle, filesize(\$file)));" >> index.php
echo "fclose(\$handle);" >> index.php
echo "\$content = array_values(\$contents);" >> index.php
echo "echo \$content[0];" >> index.php
echo "?>" >> index.php

sudo -S mv index.php /var/www/html/
sudo -S chown apache:apache -R /var/www/
