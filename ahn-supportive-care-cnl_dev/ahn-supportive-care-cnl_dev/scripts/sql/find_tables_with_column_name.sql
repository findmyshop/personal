set @column_name = 'user_id';
set @table_schema = 'medrespond_anthony_dev';

SELECT DISTINCT TABLE_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE
	COLUMN_NAME = @column_name
	AND TABLE_SCHEMA = @table_schema;