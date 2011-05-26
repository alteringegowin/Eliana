<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

/**
 * Debug Helper
 *
 * Outputs the given variable(s) with formatting and location.
 *
 * Modified by Dan to produce a little prettier output.
 * 
 * @author              Phil Sturgeon <http://philsurgeon.co.uk>
 * @modified    Dan Horrigan
 * @link                http://philsturgeon.co.uk/news/2010/09/power-dump-php-applications
 * @access              public
 * @param               mixed   Variables to be output
 */
function dump() {
    list($callee) = debug_backtrace();
    $arguments = func_get_args();
    $total_arguments = count($arguments);

    echo '<div style="background: #EEE !important; border:1px solid #666; padding:10px;">';
    echo '<h1 style="border-bottom: 1px solid #CCC; padding: 0 0 5px 0; margin: 0 0 5px 0; font: bold 18px sans-serif;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</h1><pre>';
    $i = 0;
    foreach ($arguments as $argument) {
        echo '<strong>Debug #' . (++$i) . ' of ' . $total_arguments . '</strong>:<br />';
        var_dump($argument);
        echo '<br />';
    }

    echo "</pre>";
    echo "</div>";
}

/**
 * Outputs an array or variable
 *
 * @param    $var array, string, integer
 * @return    string
 */
function xdebug($var = '') {
    echo _before();
    echo print_r($var, 1);
    echo _after();
}

// --------------------------------------------------------------------

/**
 * Outputs the last query
 *
 * @return    string
 */
function debug_last_query() {
    $CI = & get_instance();
    echo _before();
    echo $CI->db->last_query();
    echo _after();
}

// --------------------------------------------------------------------

/**
 * Outputs the query result
 *
 * @param    $query object
 * @return    string
 */
function debug_query_result($query = '') {
    echo _before();
    print_r($query->result_array());
    echo _after();
}

// --------------------------------------------------------------------

/**
 * Outputs all session data
 *
 * @return    string
 */
function debug_session() {
    $CI = & get_instance();
    echo _before();
    print_r($CI->session->all_userdata());
    echo _after();
}

// --------------------------------------------------------------------

/**
 * Logs a message or var
 *
 * @param    $message array, string, integer
 * @return    string
 */
function debug_log($message = '') {
    is_array($message) ? log_message('debug', print_r($message)) : log_message('debug', $message);
}

// --------------------------------------------------------------------

/**
 * _before
 *
 * @return    string
 */
function _before() {
    $before = '<div style="padding:10px 20px 10px 20px; background-color:#fbe6f2; border:1px solid #d893a1; color: #000; font-size: 12px;>' . "\n";
    $before .= '<h5 style="font-family:verdana,sans-serif; font-weight:bold; font-size:18px;">Debug Helper Output</h5>' . "\n";
    $before .= '<pre>' . "\n";
    return $before;
}

// --------------------------------------------------------------------
/**
 * _after
 *
 * @return    string
 */
function _after() {
    $after = '</pre>' . "\n";
    $after .= '</div>' . "\n";
    return $after;
}

// --------------------------------------------------------------------

/* End of file debug_helper.php */
/* Location: ./application/helpers/debug_helper.php */