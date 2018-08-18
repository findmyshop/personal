<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access  public
 * @param  string  the URL
 * @param  string  the method: location or redirect
 * @return  string
 */
if(!function_exists('redirect')) {
    function redirect($uri = '', $method = 'location', $http_response_code = 302) {
        /* For projects that share a domain. redirect to proper base */
        if(MR_DIRECTORY !== '') {
            $uri = MR_DIRECTORY . $uri;
        }

        if(!preg_match('#^https?://#i', $uri)) {
            $uri = site_url($uri);
        }

        switch($method) {
            case 'refresh': header("Refresh:0;url=" . $uri);
                break;
            default: header("Location: " . $uri, TRUE, $http_response_code);
                break;
        }

        exit;
    }
}