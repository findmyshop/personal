#!/bin/bash

while read VHOST;do rm "$VHOST/.maintenance_lock";done < <(find /var/www/vhosts/ -type d -name uat)