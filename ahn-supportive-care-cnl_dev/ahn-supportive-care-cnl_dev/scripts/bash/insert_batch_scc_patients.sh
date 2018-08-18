#!/bin/bash
# modify this script to insert a batch of new patients for supportivecareoptions.com


mysql -u root -pct\&sb1rt\$\$fun ahn_scc_production -e "ALTER TABLE master_patients AUTO_INCREMENT=2501";

for((i=0;i<5000;i++));
do
mysql -u root -pct\&sb1rt\$\$fun ahn_scc_production  <<eof
	insert into master_patients (
		organization_id,
		created_date,
		created_by,
		last_modified_date,
		modified_by,
		login_enabled,
		active
	) values (
		2,
		current_date(),
		0,
		NULL,
		NULL,
		1,
		1
	);
eof
done;