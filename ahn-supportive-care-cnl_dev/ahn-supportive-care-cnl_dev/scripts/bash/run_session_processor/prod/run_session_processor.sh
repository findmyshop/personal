#!/bin/bash

echo "##################################################################"
echo "Session Processor Run Start Date - $(date)"
echo "##################################################################"

ENVIRONMENTS=( uat www )

for ENVIRONMENT in "${ENVIRONMENTS[@]}"
do
    echo "************* $(echo $ENVIRONMENT | tr [a-z] [A-Z]) Environment *************"

    if [ "$ENVIRONMENT" = "www" ]
    then
        PROTOCOL="https"
    else
        PROTOCOL="http"
    fi

    while read -r DOMAIN
    do
        curl -L --fail "$(echo $PROTOCOL)://$(echo $DOMAIN)/session_processor" > /dev/null 2>&1

        if [ $? -eq 0 ]
        then
                echo "SUCCESS processing sessions for - $DOMAIN"
        else
                echo "ERROR processing sessions for - $DOMAIN"
        fi
    done < <(ssh root@prod02.medrespond.net "/usr/bin/find /var/www/vhosts/ -name \"$ENVIRONMENT\" -type d | cut -d'/' -f5 | /bin/sed \"s/^/$(echo $ENVIRONMENT)./\"")
done

echo "##################################################################"
echo "Session Processor Run End Date - $(date)"
echo "##################################################################"
