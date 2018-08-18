DELETE FROM master_activity_logs WHERE operating_system = 'Unknown Platform';
TRUNCATE TABLE master_session_processor_runs;
TRUNCATE TABLE master_processed_sessions;