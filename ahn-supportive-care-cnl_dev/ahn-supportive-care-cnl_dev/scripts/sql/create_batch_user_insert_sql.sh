#!/bin/bash

FILENAME="$1"
ORGANIZATION_ID="2"
DATETIME=`date +"%Y-%m-%d %H:%M:%S"`

while read -r USER
do
	IFS=' ' read -a USER_ARRAY <<< "$USER"
	USERNAME="${USER_ARRAY[0]}"
	PASSWORD="${USER_ARRAY[1]}"
	PASSWORD=`echo -n $PASSWORD | md5`

	read -r -d '' MASTER_USERS_INSERT << EOF
	INSERT INTO master_users (
		user_type_id,
		first_name,
		last_name,
		username,
		password,
		email,
		created_by,
		created_date
	) VALUES (
		4,
		'',
		'',
		'$USERNAME',
		'$PASSWORD',
		'',
		0,
		'$DATETIME'
	);
EOF

	read -r -d '' MASTER_USER_MAP_INSERT << EOF
	INSERT INTO master_users_map (
		user_id,
		organization_id,
		last_response,
		last_left_rail
	) VALUES (
		(SELECT id FROM master_users WHERE username = '$USERNAME'),
		$ORGANIZATION_ID,
		'',
		''
	);
EOF

echo $MASTER_USERS_INSERT
echo $MASTER_USER_MAP_INSERT
done < $FILENAME