ALTER TABLE `master_preprocessor_clause_segmenter_runs`
ADD COLUMN `curl_request_milliseconds` INT(11) UNSIGNED NOT NULL AFTER `curl_request_succeeded`;
