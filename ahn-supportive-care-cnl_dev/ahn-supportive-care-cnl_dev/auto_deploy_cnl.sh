# !bin/bash

echo 'Deploying'
ssh root@dev02.medrespond.net "
cd /var/www/vhosts/sbirtmentor.com/subdomains/cnl-dev;
git checkout cnl_dev;
git pull;
"
echo "Deployed"