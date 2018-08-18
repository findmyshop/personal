select
	table_id AS user_id,
	group_concat(concat_ws('=', column_name, new_value)) as field_values,
	timestamp
from master_audit
where
	table_name = 'master_users'
group by table_id, timestamp
order by table_id asc, timestamp asc;
