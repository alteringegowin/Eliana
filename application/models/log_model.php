<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Log_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function save_log($user_id, $action, $mode=1, $tweet_id='')
    {
        $db['userid'] = $user_id;
        $db['log_date'] = date('Y-m-d H:i:s');
        $db['action'] = $action;
        $db['tweet_id'] = $tweet_id;
        $db['mode'] = $mode;
        $this->db->insert('logs', $db);
    }

}