<?php

/**
 * buat test tanpa ada username dan password
 */
class A extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $output = shell_exec('ps -ef |grep eliana_get_tweet');
        echo "<pre>$output</pre>";
        $output = shell_exec('ps -ef |grep eliana_process_tweet');
        echo "<pre>$output</pre>";

        $output = shell_exec('ps -ef |grep eliana_monitor');
        echo "<pre>$output</pre>";
    }

}
