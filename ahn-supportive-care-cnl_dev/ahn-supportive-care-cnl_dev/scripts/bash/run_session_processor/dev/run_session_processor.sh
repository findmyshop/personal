#!/bin/bash

echo "##################################################################"
echo "Session Processor Run Start Date - $(date)"
echo "##################################################################"

while read -r SUBDOMAIN
do
    echo "************ subdomain - $SUBDOMAIN ************"
    while read -r ALIAS
    do
        curl -L --fail "http://$(echo $ALIAS)/session_processor" > /dev/null 2>&1

        if [ $? -eq 0 ]
        then
                echo "SUCCESS processing sessions for - $ALIAS"
        else
                echo "ERROR processing sessions for - $ALIAS"
        fi
    done < <(/usr/sbin/apachectl -S 2>/dev/null  | grep "alias $SUBDOMAIN" | sort | uniq | sed -e 's/^[ \t]*//' | cut -d' ' -f2)
done < <(ls -1 /var/www/vhosts/sbirtmentor.com/subdomains)

echo "##################################################################"
echo "Session Processor Run End Date - $(date)"
echo "##################################################################"