#!/bin/bash
# Purpose: Deploy the most recent version of a product uat branch to vhost

# Check to make sure VHOST was passed in as an argument
if [ $# -eq 0 ]; then
		echo "Usage: ./deploy_live_product_branch vhost"
		echo "For example, the following command will deploy and the most recent version of alcoholsbirt.com_uat to uat.alcohosbirt.com and automatically add an entry to medrespond_deployment_info.deployment."
		echo "./deploy_live_product_branch uat.alcoholsbirt.com"
		exit 1
fi

VHOST="$1"
# pull the $BRANCH associated with $VHOST from the medrespond_deployment_info.branch table
MR_DEPLOYMENT_INFO_SSH=root@prod02.medrespond.net
BRANCH=$(ssh $MR_DEPLOYMENT_INFO_SSH "mysql -B -u mdi -p'Pw~fkSwxBj4~D*9X' medrespond_deployment_info -e \"SELECT name FROM branch where vhost_name = '$VHOST' and active = 1\" | tail -n +2" &)

# check whether of not a record of the branch exists in medrespond_deployment_info.branch table
if [ -z "$BRANCH" ]; then
	echo "error: Could not find an active product branch associated with $VHOST in the medrespond_deployment_info.branch table."
	exit 1
fi

# change to the proper vhost directory
cd /var/www/vhosts/${VHOST:4}/subdomains/uat
git fetch

# check whether or not a branch with the naming convention $VHOST:4_master exists in the git repository
git branch -a | grep -q remotes/origin/$BRANCH
if [ "$?" -ne "0" ]; then
	echo "error: remotes/origin/$BRANCH is not a branch in the git repository."
	exit 1
fi

# check if local is already up to date with remote
COUNT=$(git rev-list HEAD...origin/$BRANCH --count)
if [ "$COUNT" -eq "0" ]; then
	echo "local/$BRANCH already up to date with remote/$BRANCH";
	exit 0;
fi

touch .maintenance_lock
git checkout $BRANCH
git pull origin $BRANCH
rm .maintenance_lock

# insert a record into medrespond_deployment_info.deploy
ssh $MR_DEPLOYMENT_INFO_SSH "mysql -u mdi -p'Pw~fkSwxBj4~D*9X' medrespond_deployment_info -e \"INSERT IGNORE INTO deployment (vhost_name, branch_name, tag_name) VALUES ('$VHOST', '$BRANCH', NULL)\"" &

exit 0
