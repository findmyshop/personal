insert into master_users (
  user_type_id,
  first_name,
  last_name,
  username,
  password,
  email,
  patient_id,
  created_by,
  created_date,
  last_modified_by,
  last_modified_date
) values (
  1,
  '',
  '',
  'MRtest',
  'faba68975ed69f25b785c12785fd0002', -- medrespond
  'support@medrespond.com',
  0,
  0,
  NOW(),
  NULL,
  NULL
);

insert into master_users_map (
  user_id,
  organization_id,
  last_response,
  last_left_rail
) values (
  (select id from master_users where username = 'MRtest' limit 1),
  (select id from master_organizations where organization_name = 'pra' limit 1),
  '',
  ''
);