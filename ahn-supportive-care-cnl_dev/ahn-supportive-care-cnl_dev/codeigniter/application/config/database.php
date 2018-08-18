<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	 ['hostname'] The hostname of your database server.
|	 ['username'] The username used to connect to the database
|	 ['password'] The password used to connect to the database
|	 ['database'] The name of the database you want to connect to
|	 ['dbdriver'] The database type. ie: mysql.	 Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	 ['dbprefix'] You can add an optional prefix, which will be added
|					to the table name when using the	Active Record class
|	 ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	 ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	 ['cache_on'] TRUE/FALSE - Enables/disables query caching
|	 ['cachedir'] The path to the folder where cache files should be stored
|	 ['char_set'] The character set used in communicating with the database
|	 ['dbcollat'] The character collation used in communicating with the database
|					NOTE: For MySQL and MySQLi databases, this setting is only used
|					 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|					(and in table creation queries made with DB Forge).
|					 There is an incompatibility in PHP with mysql_real_escape_string() which
|					 can make your site vulnerable to SQL injection if you are using a
|					 multi-byte character set and are running versions lower than these.
|					 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	 ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	 ['autoinit'] Whether or not to automatically initialize the database.
|	 ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							 - good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.	By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/
$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'mysql';
$db['default']['port'] = '3306';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

/* One DEV to rule them all. */
if (ENVIRONMENT === 'development'){
    $db['default']['username'] = 'root';
    $db['default']['password'] = 'ct&sb1rt$$fun';
//        $db['default']['password'] = 'root';

    if(strpos($_SERVER['HTTP_HOST'], 'anthony-dev') !== FALSE) {
        $db['default']['database'] = 'medrespond_anthony_dev';
    } else if(strpos($_SERVER['HTTP_HOST'], 'trevor-dev') !== FALSE) {
        $db['default']['database'] = 'medrespond_trevor_dev';
    }else if(strpos($_SERVER['HTTP_HOST'], 'cnl-local-dev') !== FALSE) {
        $db['default']['database'] = 'cnl_local_dev';
    }else if(strpos($_SERVER['HTTP_HOST'], 'charles-dev') !== FALSE) {
        $db['default']['database'] = 'cnl_local_dev';
        $db['default']['password'] = '1Testing!';
        $db['default']['hostname'] = '127.0.0.1';
    }else if(strpos($_SERVER['HTTP_HOST'], 'cnl-dev') !== FALSE) {
        $db['default']['database'] = 'cnl_dev';
        $db['default']['hostname'] = '127.0.0.1';
    } else {
        $db['default']['database'] = 'medrespond_dev';
    }
} else if(MR_TYPE === 'f4s_white_label') {
    switch (ENVIRONMENT) {
        case 'testing' :
            $db['default']['username'] = 'mr_uat';
            $db['default']['password'] = 'tHElITTLEsH1T$';
            $db['default']['database'] = 'f4s_white_label_uat';
            break;
        case 'production' :
            $db['default']['username'] = 'mr_production';
            $db['default']['password'] = 'TheBigSh1t_';
            $db['default']['database'] = 'f4s_white_label_production';
            break;
        default :
            die('Environment not set.');
    }
} else if(MR_TYPE === 'nami_white_label') {
    switch (ENVIRONMENT) {
        case 'testing' :
            $db['default']['username'] = 'mr_uat';
            $db['default']['password'] = 'tHElITTLEsH1T$';
            $db['default']['database'] = 'nami_white_label_uat';
            break;
        case 'production' :
            $db['default']['username'] = 'mr_production';
            $db['default']['password'] = 'TheBigSh1t_';
            $db['default']['database'] = 'nami_white_label_production';
            break;
        default :
            die('Environment not set.');
    }
} else {
    switch (MR_PROJECT){
        case 'ebi' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'pitt_sbirt_ebi_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'pitt_sbirt_ebi_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'adh' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'mmg_adh_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'pitt_sbirt_ebi_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'bcran' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'bcran_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'bcran_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'scc' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'ahn_w';
                    $db['default']['password'] = 'A_place4ahN_stuff$';
                    $db['default']['database'] = 'ahn_scc_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'ahn_w';
                    $db['default']['password'] = 'A_place4ahN_stuff$';
                    $db['default']['database'] = 'ahn_scc_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'pkd' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'root';
                    $db['default']['password'] = 'ct&sb1rt$$fun';
                    $db['default']['database'] = 'mmg_otsuka_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mmg_clinical';
                    $db['default']['password'] = 'pr0duct1on$MMG$pw';
                    $db['default']['database'] = 'mmg_otsuka_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'jcc' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'root';
                    $db['default']['password'] = 'ct&sb1rt$$fun';
                    $db['default']['database'] = 'mmg_jcc_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mmg_clinical';
                    $db['default']['password'] = 'pr0duct1on$MMG$pw';
                    $db['default']['database'] = 'mmg_jcc_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 't2d' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'root';
                    $db['default']['password'] = 'ct&sb1rt$$fun';
                    $db['default']['database'] = 'mmg_t2d_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mmg_clinical';
                    $db['default']['password'] = 'pr0duct1on$MMG$pw';
                    $db['default']['database'] = 'mmg_t2d_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'ddk' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'root';
                    $db['default']['password'] = 'ct&sb1rt$$fun';
                    $db['default']['database'] = 'az_ddk_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mmg_clinical';
                    $db['default']['password'] = 'pr0duct1on$MMG$pw';
                    $db['default']['database'] = 'az_ddk_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'tss' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'ddi_tss_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'ddi_tss_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'jpbl' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'root';
                    $db['default']['password'] = 'ct&sb1rt$$fun';
                    $db['default']['database'] = 'mmg_lilly_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mmg_clinical';
                    $db['default']['password'] = 'pr0duct1on$MMG$pw';
                    $db['default']['database'] = 'mmg_lilly_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'dod' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'dod_asb_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'dod_asb_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'f4s' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'ahn_f4s_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'ahn_f4s_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'cnl' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'ahn_cnl_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'ahn_cnl_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'nsd' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'nami_sd_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'nami_sd_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'pra' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'pfizer_ra_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'pfizer_ra_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'prb' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'pfizer_ra_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'pfizer_ra_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'prc' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'pfizer_ra_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'pfizer_ra_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'enr' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'ed_ens_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'ed_ens_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'ysc' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'mmg_ysc_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'mmg_ysc_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'alz' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'mmg_alz_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'mmg_alz_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'mrd' :
            $db['default']['username'] = 'mr_production';
            $db['default']['password'] = 'TheBigSh1t_';
            $db['default']['database'] = 'mr_demo_production';
            break;
        case 'ppd' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'ahn_ppd_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'ahn_ppd_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'mrd' :
            $db['default']['username'] = 'mr_production';
            $db['default']['password'] = 'TheBigSh1t_';
            $db['default']['database'] = 'ahn_ppc_production';
            break;
        case 'rush' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'rush_sbirt_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'rush_sbirt_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'sbirt' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'mr_sbirt_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'mr_sbirt_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'oct' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'ons_oct_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'ons_oct_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'msp' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'mmg_msp_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'mmg_msp_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'epr' :
            switch (ENVIRONMENT) {
                case 'testing' :
                    $db['default']['username'] = 'mr_uat';
                    $db['default']['password'] = 'tHElITTLEsH1T$';
                    $db['default']['database'] = 'exc_epr_uat';
                    break;
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'exc_epr_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        case 'default' :
            switch (ENVIRONMENT) {
                case 'production' :
                    $db['default']['username'] = 'mr_production';
                    $db['default']['password'] = 'TheBigSh1t_';
                    $db['default']['database'] = 'mr_demo_production';
                    break;
                default :
                    die('Environment not set.');
            }
            break;
        default :
            show_404();
    }
}

/* End of file database.php */
/* Location: ./application/config/database.php */
