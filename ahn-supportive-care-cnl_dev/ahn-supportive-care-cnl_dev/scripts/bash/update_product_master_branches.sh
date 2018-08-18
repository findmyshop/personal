#!/bin/bash
# This script pulls changes from master into all product specific master branches with the naming convention $HOSTNAME_master

git checkout master;
git pull origin master;
git fetch;

while read -r BRANCH
do
	echo "Merging master into $BRANCH"
	git checkout $BRANCH
	git pull
	git merge master
	git push origin $BRANCH
	echo "Finished merging master into $BRANCH"
done < <(git branch -a | grep 'remotes/origin/.*_master' | cut -d '/' -f 3)

git checkout master
