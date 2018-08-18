<?php
/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *   development
 *   testing
 *   production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
    $_subd = explode(".", $_SERVER['HTTP_HOST']);
    if(strpos($_subd[0], 'www') !== false || strpos($_subd[0], 'demo') !== false) {
        define('ENVIRONMENT', 'production');
    } else if(strpos($_subd[0] ,'uat') !== false) {
        define('ENVIRONMENT', 'testing');
        define('DEBUG', 'true');
    } else if(strpos($_subd[0], 'grunt') !== false || strpos($_subd[0], 'dev') !== false) {
        define('ENVIRONMENT', 'development');
        define('DEBUG', 'true');
    } else {
        define('ENVIRONMENT', 'unknown');
    }

    define('MR_ASK_LENGTH', '200');

    /* SET THE PROJECT */
    if(strpos($_subd[1], 'pgh-sbirt-ebi') !== false) {
        define('MR_PROJECT', 'ebi');
        define('MR_TYPE', 'hybrid');
    } else if(strpos($_subd[1], 'adhdkidsstudyconversations') !== false) {
        define('MR_PROJECT', 'adh');
        define('MR_TYPE', 'ct');
    } else if(strpos($_subd[1], 'white-label') !== false) {
        if(strpos($_subd[2], 'fit-for-surgery') !== false) {
            define('MR_PROJECT', 'f4s_white_label_demo');
            define('MR_TYPE', 'f4s_white_label');
        }
    } else if(strpos($_subd[1], 'supportivecareoptions') !== false) {
        define('MR_PROJECT', 'scc');
        define('MR_TYPE', 'hybrid');
        define('FACEBOOK_APP_ID', '593877084107468');
        define('SITE_VERIFICATION', 'F_qJaAQqQdxb8MwzNB3qpQIegJsv8zFW4PzNdUwpmGM');
    } else if(strpos($_subd[1], 'pkdconversations') !== false) {
        define('MR_PROJECT', 'pkd');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-1');
    } else if(strpos($_subd[1], 'medrespond-pfra') !== false) {
        $p = explode('/', $_SERVER['REQUEST_URI']);

        if(($key = array_search('index.php', $p)) !== false) {
            unset($p[$key]);
            $p = array_values($p);
        }
        /* Limit to projects that exist under this domain */
        if($p[1] == 'pra' || $p[1] == 'prb' || $p[1] == 'prc') {
            define('MR_DIRECTORY', $p[1].'/');
            define('MR_PROJECT', $p[1]);
        } else {
            define('MR_DIRECTORY', 'pra/');
            define('MR_PROJECT', 'pra');
        }
        define('ANALYTICS_ID', 'UA-71966247-6');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
    } else if(strpos($_subd[1], 'situpconversations') !== false) {
        define('MR_PROJECT', 't2d');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-3');
    } else if(strpos($_subd[1], 'delightclinicalstudy') !== false) {
        define('MR_PROJECT', 'ddk');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-4');
    } else if(strpos($_subd[1], 'postpartumconversations') !== false) {
        define('MR_PROJECT', 'ppd');
        define('MR_TYPE', 'hybrid');
        define('MR_HAS_SPEAKER', false);
        define('MR_IDLE_TIME', '15');
        define('FACEBOOK_APP_ID', '1051071881606772');
    } else if(strpos($_subd[1], 'monarch2conversations') !== false) {
        define('MR_PROJECT', 'jpbl');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-2');
    } else if(strpos($_subd[1], 'juniperconversations') !== false) {
        define('MR_PROJECT', 'jcc');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-5');
    } else if(strpos($_subd[1], 'apecsconversation') !== false) {
        define('MR_PROJECT', 'alz');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-8');
    } else if(strpos($_subd[1], 'node1forpsvt') !== false) {
        define('MR_PROJECT', 'msp');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-9');
        define('SITE_VERIFICATION', 'KVCgeaiA7mK-qDnAnbRcINEx53LIIX5-bSaslGq9mnI');
    } else if(strpos($_subd[1], 'alcoholsbirt') !== false) {
        define('MR_PROJECT', 'dod');
        define('MR_TYPE','military_training');
    } else if(strpos($_subd[1], 'rushsbirt') !== false) {
        define('MR_PROJECT', 'rush');
        define('MR_TYPE', 'training');
    } else if(strpos($_subd[1], 'sbirtcoach') !== false) {
        define('MR_PROJECT', 'sbirt');
        define('MR_TYPE', 'training');
    } else if(strpos($_subd[1], 'sbirtmentor') !== false) {
        define('MR_PROJECT', 'sbirt');
        define('MR_TYPE', 'training');
    }else if(strpos($_subd[1], 'fit-for-surgery') !== false) {
        define('MR_PROJECT', 'f4s');
        define('MR_TYPE', 'hybrid');
    }else if(strpos($_subd[1], 'cnl') !== false) {
        define('MR_PROJECT', 'cnl');
        define('MR_TYPE', 'hybrid');
    } else if(strpos($_subd[1], 'onsoralchemoguide') !== false) {
        define('MR_PROJECT', 'oct');
        define('MR_TYPE', 'hybrid');
        define('FACEBOOK_APP_ID', '260330461014353');
        define('SITE_VERIFICATION', '-oW1qIJmRrsEKrc-zhp3-BxeuHQtWSTYQi7vgVk_RtA');
    } else if(strpos($_subd[1], 'asknamisandiego') !== false) {
        define('MR_PROJECT', 'nsd');
        define('MR_TYPE', 'ct');
        define('FACEBOOK_APP_ID', '1638854819776453');
        define('SITE_VERIFICATION', '6ZxjoiO4_tT40bXXC3HOFjhu1wbBYjInngRSi4_nD-g');
    } else if(strpos($_subd[1], 'wcrcanswers') !== false) {
        define('MR_PROJECT', 'bcran');
        define('MR_TYPE', 'ct');
        //define('FACEBOOK_APP_ID', '1638854819776453');
        //define('SITE_VERIFICATION', '6ZxjoiO4_tT40bXXC3HOFjhu1wbBYjInngRSi4_nD-g');
    } else if(strpos($_subd[1], 'tssim') !== false) {
        define('MR_PROJECT', 'tss');
        define('MR_TYPE', 'hybrid');
    } else if(strpos($_subd[1], 'yourstudyconversations') !== false) {
        define('MR_PROJECT', 'ysc');
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', true);
        define('MR_IDLE_TIME', '15');
        define('ANALYTICS_ID', 'UA-71966247-7');
    } else if(strpos($_subd[1], 'babytalkwithmyexceladoc') !== false) {
        $p = explode('/', $_SERVER['REQUEST_URI']);
        if(($key = array_search('index.php', $p)) !== false) {
            unset($p[$key]);
            $p = array_values($p);
        }
        /* Limit to projects that exist under this domain */
        if($p[1] == 'epr') {
            define('MR_DIRECTORY', $p[1].'/');
            define('MR_PROJECT', $p[1]);
        }else{
            define('MR_DIRECTORY', 'epr/');
            define('MR_PROJECT', 'epr');
        }

        define('FACEBOOK_APP_ID', '272990263057161');
        define('MR_TYPE', 'hybrid');
        define('ANALYTICS_ID', 'UA-77084537-1');
        define('SITE_VERIFICATION', 'dBFJlkBywtnh9IAAVOZlxg4BgmJQiY2dZICIh_WslFA');
        define('MR_HAS_SPEAKER', false);
    } else if(strpos($_subd[1], 'behavioralhealthanswers') !== false) {
        $p = explode('/', $_SERVER['REQUEST_URI']);
        if(($key = array_search('index.php', $p)) !== false) {
            unset($p[$key]);
            $p = array_values($p);
        }
        /* Limit to projects that exist under this domain */
        if($p[1] == 'some future project') {
            define('MR_DIRECTORY', 'demo/');
            define('MR_PROJECT', 'nami_white_label_demo');
        } else if($p[1] == 'demo-asl') {
            define('MR_DIRECTORY', 'demo-asl/');
            define('MR_PROJECT', 'nami_white_label_demo_asl');
            define('FACEBOOK_APP_ID', '993141560807335');
        } else { // default to the demo-eng project
            define('MR_DIRECTORY', 'demo-eng/');
            define('MR_PROJECT', 'nami_white_label_demo_eng');
            define('FACEBOOK_APP_ID', '993141560807335');
        }

        define('MR_TYPE', 'nami_white_label');
        define('MR_HAS_SPEAKER', false);
    } else if(strpos($_subd[1], 'medrespond') !== false) {
        if($_subd[2] === 'com') {
            // medrespond.com
            define('MR_PROJECT', 'mrd');
            define('MR_TYPE', 'ct');
        } else if($_subd[2] === 'net') {
            define('MR_PROJECT', 'cnl');
            define('MR_TYPE', 'hybrid');
            // medrespond.net
            // use this for temporary development before a domain is purchased
        }
    } else if(strpos($_subd[1], 'electricitydialogue') !== false) {
        // enersource redirect
        $p = explode('/', $_SERVER['REQUEST_URI']);
        if($p[1] == 'enr') {
            define('MR_DIRECTORY', $p[1].'/');
            define('MR_PROJECT', $p[1]);
        } else {
            define('MR_DIRECTORY', 'enr/');
            define('MR_PROJECT', 'enr');
        }
        define('MR_TYPE', 'ct');
        define('MR_HAS_SPEAKER', false);
    } else {
        define('MR_PROJECT', 'default');
        define('MR_TYPE', 'ct');
    }
    /* Enforce logouts on idle time (minutes) */
    if(!defined('MR_IDLE_TIME')) {
        define('MR_IDLE_TIME', 'false');
    }
    /* Google Analytics Sheet */
    if(!defined('ANALYTICS_ID')) {
        define('ANALYTICS_ID', false);
    }
    /* Site Verification */
    if(!defined('SITE_VERIFICATION')) {
        define('SITE_VERIFICATION', false);
    }
    /* For multiple projects on one domain (pseudo directory) */
    if(!defined('MR_DIRECTORY')) {
        define('MR_DIRECTORY', '');
    }
    /* Whether or not this domain has multiple project subdirectories configured */
    define('HAS_MULTIPLE_MR_DIRECTORIES', (
        MR_TYPE === 'nami_white_label' ||
        MR_PROJECT === 'pra' ||
        MR_PROJECT === 'prb' ||
        MR_PROJECT === 'prc'
    ) ? true : false);

    /* We wanna know if a project enables the user to set a speaker */
    if(!defined('MR_HAS_SPEAKER')) {
        define('MR_HAS_SPEAKER',false);
    }
    /* Facebook App ID */
    if(!defined('FACEBOOK_APP_ID')) {
        define('FACEBOOK_APP_ID', false);
    }
    /* Should login be enforced with CAPTCHA? */
    define('LOGIN_CAPTCHA', (
        MR_PROJECT === 'enr'
    ) ? true : false);
    define('LOGIN_BY_EMAIL_ENABLED', (
        MR_PROJECT === 'enr'
    ) ? true : false);
    /* When data-input is private 'N/A' will replace any logged input_questions. Also, some parts of the dashboard become hidden. */
    define('PRIVATE_DATA', (strpos($_subd[0],'www') !== false && (
        MR_PROJECT === 'pra' ||
        MR_PROJECT === 'prb' ||
        MR_PROJECT === 'prc'
    )) ? true : false);

    /* Constant to bypass logins */
    define('USER_AUTHENTICATION_REQUIRED', (
        MR_PROJECT === 'adh' ||
        MR_PROJECT === 'ysc' ||
        MR_PROJECT === 'nsd' ||
        MR_PROJECT === 'pra' ||
        MR_PROJECT === 'prb' ||
        MR_PROJECT === 'prc' ||
        MR_PROJECT === 'mrd' ||
        MR_PROJECT === 'ppd' ||
        MR_PROJECT === 'scc' ||
        MR_PROJECT === 'oct' ||
        MR_PROJECT === 'epr' ||
        //MR_PROJECT === 'msp' ||
        MR_PROJECT === 'bcran' ||
        MR_TYPE === 'f4s_white_label' ||
        MR_TYPE === 'nami_white_label'
    ) ? false : true);

    define('HAS_256K_VIDEOS', (
        MR_PROJECT === 'dod' ||
        MR_PROJECT === 'mrd' ||
        MR_PROJECT === 'jcc' ||
        MR_PROJECT === 'jpbl' ||
        MR_PROJECT === 'pkd' ||
        MR_PROJECT === 'pra' ||
        MR_PROJECT === 'rush' ||
        MR_PROJECT === 'sbirt' ||
        MR_PROJECT === 't2d' ||
        MR_PROJECT === 'ycs'
    ) ? false : true);

    define('HAS_ASL_VIDEOS', (MR_TYPE === 'nami_white_label') ? true : false);

    if(HAS_ASL_VIDEOS) {
        define('VIDEOS_DEFAULT_TO_ASL', (
            MR_PROJECT === 'nami_white_label_demo_asl'
        ) ? true : false);
    } else {
        define('VIDEOS_DEFAULT_TO_ASL', false);
    }

    /* Constant for ~ tilda logins (apache style) */
    define('LOGIN_BY_USERNAME_ENABLED', (
        MR_PROJECT === 'f4s' || MR_PROJECT === 'cnl'
    ) ? true : false);

    /* This constant determines whether or not successive failed authentication attempts will temporarily lock a user account */
    define('BRUTE_FORCE_LOCKOUTS_ENABLED', (
        MR_PROJECT === 'pra' ||
        MR_PROJECT === 'prb' ||
        MR_PROJECT === 'prc'
    ) ? true : false);

    /* This constant determines how many successive failed authentication attempts will temporarily lock a user account */
    define('BRUTE_FORCE_LOCKOUTS_SUCCESSIVE_FAILED_ATTEMPTS_THRESHOLD', 5);

    /* This constant determines how long a user account remains locked for after the last failed login attempt */
    define('BRUTE_FORCE_LOCKOUTS_MINUTES_LOCKED', 20);

    define('ALLOW_MULTIPLE_CONCURRENT_USER_SESSIONS', (
        MR_PROJECT === 'pra' ||
        MR_PROJECT === 'prb' ||
        MR_PROJECT === 'prc'
    ) ? false : true);

    define('SHOW_RESPONSES_VIEWED_DATA', (
        MR_PROJECT === 'pra' ||
        MR_PROJECT === 'prb' ||
        MR_PROJECT === 'prc'
    ) ? false : true);

    define('SHOW_RESPONSES_VIEWED_PER_CATEGORY_DATA', (
        MR_PROJECT === 'msp'
    ) ? true : false);

    define('USER_PAYMENT_REQUIRED', (
        MR_PROJECT === 'sbirt'
    ) ? true : false);

    define('LOG_FLOW_ATTEMPTS', (
        MR_PROJECT === 'tss'
    ) ? true : false);

    /* Tiny SEO Fix */
    define('DYNAMIC_META_TAGS', (
        MR_PROJECT === 'epr' ||
        MR_PROJECT === 'oct' ||
        MR_PROJECT === 'nsd' ||
        MR_PROJECT === 'scc' ||
        MR_PROJECT === 'msp' ||
        MR_PROJECT === 'ppd' ||
        MR_PROJECT === 'bcran' ||
        MR_TYPE === 'f4s_white_label' ||
        MR_TYPE === 'nami_white_label'
    ) ? true : false);

/* Preprocessor Web Service URLs */
switch (ENVIRONMENT) {
    case 'development':
        define('PREPROCESSOR_URL', 'http://dev.preprocessor.medrespond.com');
        define('PREPROCESSOR_CLAUSE_SEGMENTER_URL', 'http://dev.preprocessor.medrespond.com/clause_segmenter');
        define('PREPROCESSOR_DISAMBIGUATOR_URL', 'http://dev.preprocessor.medrespond.com/disambiguator');
    break;
    case 'testing':
        define('PREPROCESSOR_URL', 'http://uat.preprocessor.medrespond.com');
        define('PREPROCESSOR_CLAUSE_SEGMENTER_URL', 'http://uat.preprocessor.medrespond.com/clause_segmenter');
        define('PREPROCESSOR_DISAMBIGUATOR_URL', 'http://uat.preprocessor.medrespond.com/disambiguator');
    break;
    case 'production':
        define('PREPROCESSOR_URL', 'https://preprocessor.medrespond.com');
        define('PREPROCESSOR_CLAUSE_SEGMENTER_URL', 'https://preprocessor.medrespond.com/clause_segmenter');
        define('PREPROCESSOR_DISAMBIGUATOR_URL', 'https://preprocessor.medrespond.com/disambiguator');
    break;
    default:
        exit('The application environment is not set correctly.');
}

/* timeout for API calls to the preprocessor clause segmenter */
DEFINE('PREPROCESSOR_CURLOPT_TIMEOUT_MS', 250);

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
if(defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development':
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;
        case 'testing':
        break;
        case 'production':
            error_reporting(0);
        break;
        default:
            exit('The application environment is not set correctly.');
    }
}
/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */
    $system_path = '../codeigniter/system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
    $application_folder = '../codeigniter/application';

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
    // The directory name, relative to the "controllers" folder.  Leave blank
    // if your controller is not in a sub-folder within the "controllers" folder
    // $routing['directory'] = '';

    // The controller class file name.  Example:  Mycontroller
    // $routing['controller'] = '';

    // The controller function you wish to be called.
    // $routing['function']  = '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 *
 */
    // $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

    // Set the current directory correctly for CLI requests
    if(defined('STDIN')) {
        chdir(dirname(__FILE__));
    }

    if(realpath($system_path) !== FALSE) {
        $system_path = realpath($system_path).'/';
    }

    // ensure there's a trailing slash
    $system_path = rtrim($system_path, '/').'/';

    // Is the system path correct?
    if(!is_dir($system_path)) {
        exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
    }

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
    // The name of THIS file
    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

    // The PHP file extension
    // this global constant is deprecated.
    define('EXT', '.php');

    // Path to the system folder
    define('BASEPATH', str_replace("\\", "/", $system_path));

    // Path to the front controller (this file)
    define('FCPATH', str_replace(SELF, '', __FILE__));

    // Name of the "system folder"
    define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));


    // The path to the "application" folder
    if(is_dir($application_folder)) {
        define('APPPATH', $application_folder.'/');
    } else {
        if( ! is_dir(BASEPATH.$application_folder.'/')) {
            exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
        }

        define('APPPATH', BASEPATH.$application_folder.'/');
    }

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH.'core/CodeIgniter.php';
/* End of file index.php */
/* Location: ./index.php */