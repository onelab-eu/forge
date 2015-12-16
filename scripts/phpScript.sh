#!/bin/bash
# $1 SSH_KEY
# $2 CLIENT_IP (or CLIENT_HOSTNAME)
# $3 CLIENT_SSH_PORT
# $4 SLICE_NAME
# $5 SERVER_IP (or SERVER_HOSTNAME)
# $6 SERVER_PORT
# $7 TRACE_FILE_NAME
# $8 TARGET_FILE

ssh -o StrictHostKeyChecking=no -i $1 -l $4 -p $3 $2 'bash -s' < generateTraffic.sh $5 $6 $7 $8 > /dev/null
