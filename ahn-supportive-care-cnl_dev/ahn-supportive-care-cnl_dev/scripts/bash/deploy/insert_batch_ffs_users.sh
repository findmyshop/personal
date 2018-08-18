#!/bin/bash

STARTING_USERNAME_SUFFIX="$1"
ENDING_USERNAME_SUFFIX="$2"

printf "SET @organization_id = (SELECT id FROM master_organizations where name = 'Allegheny Health Network');\n\n"
printf "SET @user_type_id = (SELECT id FROM master_user_types where type_name = 'user');\n\n"
printf "SET @hospital_element_id = (SELECT id FROM master_organization_hierarchy_level_elements WHERE name = 'Forbes Hospital');\n\n"
printf "SET @culig_element_id = (SELECT id FROM master_organization_hierarchy_level_elements WHERE name = 'Culig');\n\n"
printf "SET @pelle_element_id = (SELECT id FROM master_organization_hierarchy_level_elements WHERE name = 'Pellegrini');\n\n"

for i in $(seq $STARTING_USERNAME_SUFFIX $ENDING_USERNAME_SUFFIX)
do
cat <<EOF
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
	@user_type_id,
	'',
	'',
	'Culig${i}',
	'2be987e67d0e412de7e5cbb83e179938',
	'',
	0,
	NOW()
);

INSERT INTO master_users_map (
	user_id,
	organization_id,
	last_response,
	last_left_rail
) VALUES (
	(SELECT id FROM master_users WHERE username = 'Culig${i}'),
	@organization_id,
	'',
	''
);

INSERT INTO master_users_organization_hierarchy_level_element_map (
	user_id,
	organization_hierarchy_level_element_id
) VALUES (
	(SELECT id FROM master_users WHERE username = 'Culig${i}'),
	@hospital_element_id
);

INSERT INTO master_users_organization_hierarchy_level_element_map (
	user_id,
	organization_hierarchy_level_element_id
) VALUES (
	(SELECT id FROM master_users WHERE username = 'Culig${i}'),
	@culig_element_id
);

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
	@user_type_id,
	'',
	'',
	'Pelle${i}',
	'2be987e67d0e412de7e5cbb83e179938',
	'',
	0,
	NOW()
);

INSERT INTO master_users_map (
	user_id,
	organization_id,
	last_response,
	last_left_rail
) VALUES (
	(SELECT id FROM master_users WHERE username = 'Pelle${i}'),
	@organization_id,
	'',
	''
);

INSERT INTO master_users_organization_hierarchy_level_element_map (
	user_id,
	organization_hierarchy_level_element_id
) VALUES (
	(SELECT id FROM master_users WHERE username = 'Pelle${i}'),
	@hospital_element_id
);

INSERT INTO master_users_organization_hierarchy_level_element_map (
	user_id,
	organization_hierarchy_level_element_id
) VALUES (
	(SELECT id FROM master_users WHERE username = 'Pelle${i}'),
	@pelle_element_id
);

EOF
done


