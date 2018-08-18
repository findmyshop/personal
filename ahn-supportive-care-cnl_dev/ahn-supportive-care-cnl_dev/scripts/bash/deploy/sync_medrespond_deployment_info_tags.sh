#!/bin/bash
# Purpose: Sync tags from our git repository to the medrespond_deployment_info database.
while read -r VHOST
do
	while read -r TAG
	do
		mysql -u mdi -p'Pw~fkSwxBj4~D*9X' medrespond_deployment_info -e "INSERT IGNORE INTO tag (name, branch_name) VALUES ('${TAG}', (SELECT name FROM branch WHERE vhost_name = '${VHOST}' and active = 1))"
	done < <(git ls-remote git@github.com:MedRespondCME/ahn-supportive-care.git | awk '{print $2}' | grep "refs/tags/${VHOST:4}" | grep -v '\^{}' | cut -d '/' -f 3)
done < <(mysql -B -u mdi -p'Pw~fkSwxBj4~D*9X' medrespond_deployment_info -e "SELECT name FROM vhost WHERE name LIKE 'www.%' and active = 1" | tail -n +2)
