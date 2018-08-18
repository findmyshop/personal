#!/bin/bash
# -----------------------------------------------------------------------------------
# Utility used to clean activity made by MedRespond Employees From the Database
# -----------------------------------------------------------------------------------


echo "##############################################################################"
echo "MedRespond Employee Data Cleaning Start -  $(date)"
echo "##############################################################################"

echo "Backing Up Production Databases"
/root/backups/production_backup.sh
echo "Finished Backing Up Production Databases"

while read -r DB_NAME; do
        echo "******* Cleaning Employee Data From $DB_NAME *******"

        # Delete activity from known MedRespond IP addresses and the MRTest account
        mysql -u root -pct\&sb1rt\$\$fun "$DB_NAME"  <<eof
        DELETE
        FROM master_activity_logs
        WHERE ip_address IN(
                '173.13.62.73',
                '67.165.87.79',
                '108.39.226.40',
                '100.6.104.187',
                '74.109.202.23',
                '71.182.236.205',
                '50.163.215.173',
                '71.60.75.56'
        ) OR user_id = (
          SELECT id FROM master_users WHERE username = 'MRTest'
        );
eof

done < <(/root/backups/list_production_and_uat_databases.sh | grep production)

echo "##############################################################################"
echo "MedRespond Employee Data Cleaning End -  $(date)"
echo "##############################################################################"