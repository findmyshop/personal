<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_library
{
    private $CI = FALSE;        // CodeIgniter Global Instance
    private $TMP_DIRECTORY = 'tmp/';

    public function __construct() {
        $this->CI =& get_instance();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function create_csv($records, $account_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        // We are saving the csv files in the format:
        //   csv_report_<account id>_<date>_<time>.csv
        $filename = 'csv_export_'.$account_id.'_'.date("Y-m-d_H-i-s").'.csv';
        $filepath = FCPATH.$this->TMP_DIRECTORY.$filename;
        $csv_file = fopen($filepath, FOPEN_WRITE_CREATE);

        if(count($records) > 0) {
            $fields = $this->get_fields_for_display($records[0]);
            fputcsv($csv_file, $fields);
        } else {
            log_error(__FILE__, __LINE__, __METHOD__, 'Data to export to csv contains no records');
            chmod($filepath, FILE_WRITE_MODE);
            fclose($csv_file);
            return $filename;
        }

        foreach($records as $item) {
            if(!fputcsv($csv_file, $item)) {
                log_error(__FILE__, __LINE__, __METHOD__, 'Error writing records to csv file');
                chmod($filepath, FILE_WRITE_MODE);
                fclose($csv_file);
                return $filename;
            }
        }

        chmod($filepath, FILE_WRITE_MODE);
        fclose($csv_file);

        return $filename;
    }

    private function get_fields_for_display($record)
    {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        // NOTE (Alex Quinn 7/7/14):
        //   This function is used to modify field names from
        //   the format "field_name" to "Field Name" for dispaying
        //   to a user. If at some point the models return a
        //   different format for these fields this function will break.

        $fields = array();

        foreach (array_keys($record) as $field) {
            $field = str_replace('_', ' ', $field);
            $field = ucwords($field);
            array_push($fields, $field);
        }

        return $fields;
    }

    /**
     * Write CSV from a query result object to a file
     *
     * @access public
     * @param object - The query result object
     * @param string - The fully qualified file name and path
     * @param  bool - whether or not to overwrite the file (default is append)
     * @return boolean
     */
    public function write_query_result_to_csv_file($query, $fully_qualified_filename, $overwrite_file = FALSE) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(!is_object($query) OR !method_exists($query, 'list_fields')) {
            return FALSE;
        }

        if(empty($fully_qualified_filename) || !is_string($fully_qualified_filename)) {
            return FALSE;
        }

        if(!is_bool($overwrite_file)) {
            return FALSE;
        }

        $delim = ",";
        $newline = "\r\n";
        $enclosure = '"';
        $out = '';

        if($overwrite_file) {
            foreach($query->list_fields() as $name) {
                $out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delim;
            }

            $out = rtrim($out);
            $out .= $newline;

            if(!file_put_contents($fully_qualified_filename, $out)) {
                return FALSE;
            }

            $out = '';
        }

        foreach($query->result_array() as $row) {
            foreach($row as $item) {
                $out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure.$delim;
            }
            $out = rtrim($out);
            $out .= $newline;
        }

        if(!file_put_contents($fully_qualified_filename, $out, FILE_APPEND)) {
            return FALSE;
        }

        return TRUE;
    }

    public function write_associative_array_rows_to_csv_file($rows, $row_keys_to_write, $fully_qualified_filename, $overwrite_file = FALSE) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(empty($rows) || empty($row_keys_to_write)) {
            return FALSE;
        }

        if(empty($fully_qualified_filename) || !is_string($fully_qualified_filename)) {
            return FALSE;
        }

        if(!is_bool($overwrite_file)) {
            return FALSE;
        }

        $delim = ",";
        $newline = "\r\n";
        $enclosure = '"';
        $out = '';

        if($overwrite_file) {
            foreach($row_keys_to_write as $name) {
                $out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delim;
            }

            $out = rtrim($out);
            $out .= $newline;

            if(!file_put_contents($fully_qualified_filename, $out)) {
                return FALSE;
            }

            $out = '';
        }

        foreach($rows as $row) {
            foreach($row_keys_to_write as $key) {
                $out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $row[$key]).$enclosure.$delim;
            }
            $out = rtrim($out);
            $out .= $newline;
        }

        if(!file_put_contents($fully_qualified_filename, $out, FILE_APPEND)) {
            return FALSE;
        }

        return TRUE;
    }
}