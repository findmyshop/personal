<?php    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).    Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

// are we an ajax call?
define('IS_AJAX', (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ? TRUE : FALSE);

// Log actions
define('ACTION_START', 'Start');
define('ACTION_LEFT_RAIL', 'LRQ');
define('ACTION_LOG', 'Log');
define('ACTION_NEXT', 'Next');
define('ACTION_DONE', 'Done');
define('ACTION_Q', 'Question');
define('ACTION_A', 'Answer');
define('ACTION_R', 'Rating');
define('ACTION_PREV', 'Previous');
define('ACTION_MA', 'Multiple Answer');
define('ACTION_REPEAT', 'Repeat');
define('ACTION_RELATED', 'Related');
define('ACTION_RETURNING_USER', 'Returning User');
define('ACTION_OTHER', 'Other');

// ANONYMOUS_GUEST_USERNAME is reserved for unauthenticated guest 'logins'
if(MR_TYPE === 'nami_white_label') {
    if(MR_PROJECT === 'nami_white_label_demo_asl') {
        define('ANONYMOUS_GUEST_USERNAME', 'Guest-ASL');
    } else {
        define('ANONYMOUS_GUEST_USERNAME', 'Guest-English');
    }

    define('HAS_MULTIPLE_ANONYMOUS_GUEST_USERS', true);
} else {
    define('ANONYMOUS_GUEST_USERNAME', 'Guest');
    define('HAS_MULTIPLE_ANONYMOUS_GUEST_USERS', false);
}

if(ENVIRONMENT === 'production') {
    define('VIDEO_CHEKCER_EMAIL_ADDRESS', 'cloudfront@medrespond.com');
} else {
    define('VIDEO_CHEKCER_EMAIL_ADDRESS', 'anthony.jack@medrespond.com');
}

define('SUPPORT_EMAIL_ADDRESS', 'support@medrespond.com');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
