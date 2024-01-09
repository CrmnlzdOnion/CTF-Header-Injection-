#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"


LOG_DIR=/var/log/myapp


mkdir -p $LOG_DIR


LOG_FILE=$LOG_DIR/access.log
ROTATE_INTERVAL=5m
find $LOG_DIR -name log-monitor.sh -exec echo "Location of this logt: {}" \;

tail -f /var/log/apache2/access.log | awk '{ print strftime("%Y-%m-%d %H:%M:%S"), $0 }' >> $LOG_FILE &

tcpdump -i any -n -l -w - 'tcp port 80' | awk '{ print strftime("%Y-%m-%d %H:%M:%S"), $0 }' >> $LOG_FILE &
s
while true; do
  sleep $ROTATE_INTERVAL
  mv $LOG_FILE $LOG_DIR/access-$(date +"%Y%m%d%H%M%S").log
  touch $LOG_FILE
  cd $LOG_DIR && ls -t access-* | tail -n +6 | xargs rm --
done