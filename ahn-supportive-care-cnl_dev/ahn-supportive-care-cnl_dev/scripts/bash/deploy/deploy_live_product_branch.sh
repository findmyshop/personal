#!/bin/bash
# Purpose: Deploy the most recent version of a product branch to vhost and tag this version

# Check to make sure VHOST was passed in as an argument
if [ $# -eq 0 ]; then
		echo "Usage: ./deploy_live_product_branch vhost"
		echo "For example, the following command will deploy and the most recent version of alcoholsbirt.com_master to www.alcohosbirt.com."
		echo "The invocation below will also automatically tag alcoholsbirt.com_master with the correct version number and add an entry to medrespond_deployment_info.deployment."
		echo "./deploy_live_product_branch www.alcoholsbirt.com"
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
cd /var/www/vhosts/${VHOST:4}/subdomains/www
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

# get most recent tag associated with $BRANCH from medrespond_deployment_info
PREVIOUS_TAG=$(ssh $MR_DEPLOYMENT_INFO_SSH "mysql -B -u mdi -p'Pw~fkSwxBj4~D*9X' medrespond_deployment_info -e \"SELECT name FROM tag where branch_name = '$BRANCH' and active = 1 ORDER BY timestamp DESC, name DESC LIMIT 1\" | tail -n +2" &)

# check whether or not this branch was tagged before.  If not, create a tag with the naming convention $BRANCH_v1.1
if [ -z "$PREVIOUS_TAG" ]; then
	CURRENT_TAG="${BRANCH}_v1.1"
	echo "The $BRANCH branch wasn't previously tagged.  Creating $CURRENT_TAG as the first tag pointing to $BRANCH"
else
	PREVIOUS_TAG_VERSION=$(echo $PREVIOUS_TAG | grep -oP '\d+.\d+')
	CURRENT_TAG_VERSION=$(echo $PREVIOUS_TAG_VERSION + .1 | bc)
	CURRENT_TAG="${BRANCH}_v${CURRENT_TAG_VERSION}"
	echo "The $BRANCH branch was previously tagged with $PREVIOUS_TAG.  Creating $CURRENT_TAG as the new tag pointing to $BRANCH"
fi

# create the new tag locally
git tag -a $CURRENT_TAG -m "Auto generated tag pointing to $BRANCH.  Tag created: $(date)"
if [ "$?" -ne "0" ]; then
	echo "Failed to create the $CURRENT_TAG tag for the $BRANCH branch"
	exit 1
fi

# push tags to the remote repository
git push --tags
if [ "$?" -ne "0" ]; then
	echo "Failed to push the newly created $CURRENT_TAG tag for the $BRANCH branch to the remote repository"
	exit 1
fi

# insert a record into medrespond_deployment_info.tag
ssh $MR_DEPLOYMENT_INFO_SSH "mysql -u mdi -p'Pw~fkSwxBj4~D*9X' medrespond_deployment_info -e \"INSERT IGNORE INTO tag (name, branch_name) VALUES ('${CURRENT_TAG}', '${BRANCH}')\"" &

# insert a record into medrespond_deployment_info.deploy
ssh $MR_DEPLOYMENT_INFO_SSH "mysql -u mdi -p'Pw~fkSwxBj4~D*9X' medrespond_deployment_info -e \"INSERT IGNORE INTO deployment (vhost_name, branch_name, tag_name) VALUES ('$VHOST', '${BRANCH}', '${CURRENT_TAG}')\"" &

exit 0
