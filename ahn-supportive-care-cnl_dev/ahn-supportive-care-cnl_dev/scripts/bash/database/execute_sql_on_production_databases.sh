#!/bin/bash

SQL_FILE="$1"

if [ ! -f "$SQL_FILE" ]; then
    echo "SQL file not found!"
    exit 1
fi

echo "Started Backing up Production Databases"
/root/backups/production_backup.sh
echo "Finished Backing up Production Databases"

while read -r DB_NAME
do
	echo "*********** Started Executing SQL Against the $DB_NAME Database - $(date) ***********"
	mysql -u root -pct\&sb1rt\$\$fun "$DB_NAME" < "$SQL_FILE"
	echo "*********** Finished Executing SQL Against the $DB_NAME Database - $(date) ***********"
done < <(/root/utilities/database/list_production_and_uat_databases.sh | grep production | grep -v mr_wordpress_production)

exit 0