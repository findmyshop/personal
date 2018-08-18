#!/bin/bash
# Purpose: Deploy the most recent version of each uat product branch to the uat vhost and tag each version

IGNORED_VHOSTS='medrespond.com'
SUBDOMAIN='uat'

while read -r VHOST
do
	if [ -d "/var/www/vhosts/$VHOST/subdomains/$SUBDOMAIN" ]; then
		URL="${SUBDOMAIN}.${VHOST}"
		echo "Deploying to $URL"
		cd "/var/www/vhosts/$VHOST/subdomains/$SUBDOMAIN"
		/root/deploy/deploy_uat_product_branch.sh $URL
		echo "Finished Deploying to $URL"
	fi
done < <(ls -l /var/www/vhosts | awk '{print $9}' | sed '/^$/d' | grep -Ev $IGNORED_VHOSTS)
