#!/bin/bash

while true
do
    while read link; do
        wget -qO- "$link" > /dev/null
    done < /var/www/html/links/links.txt
    sleep 5
done