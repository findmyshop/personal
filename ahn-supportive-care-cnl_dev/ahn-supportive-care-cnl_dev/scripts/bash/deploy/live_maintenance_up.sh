#!/bin/bash

while read VHOST;do touch "$VHOST/.maintenance_lock";done < <(find /var/www/vhosts/ -type d -name www)