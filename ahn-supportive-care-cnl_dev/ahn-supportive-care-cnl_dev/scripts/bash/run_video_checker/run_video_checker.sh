#!/bin/bash

echo "##################################################################"
echo "Video Checker Run Start Date - $(date)"
echo "##################################################################"
while read -r DOMAIN
do
    curl -L --fail "https://$(echo $DOMAIN)/video_checker" > /dev/null 2>&1

    if [ $? -eq 0 ]
    then
            echo "SUCCESS running the video checker for - $DOMAIN"
    else
            echo "ERROR running the video checker for - $DOMAIN"
    fi
done < <(ssh root@prod02.medrespond.net "/usr/bin/find /var/www/vhosts/ -name www -type d | cut -d'/' -f5 | /bin/sed \"s/^/www./\"")
echo "##################################################################"
echo "Video Checker Run End Date - $(date)"
echo "##################################################################"
