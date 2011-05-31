<?php

class Status_twitter {

    protected $ci;

    function __construct() {
        $this->ci = & get_instance();
    }

    function count_reply($tweet_id='75512205222739968') {
        $sql = "
        SELECT 
            count(tweet_id) as total, 
            max(created_at ) as last, 
            min(created_at) as first
        FROM tweets 
        WHERE in_reply_to_status_id = ?
        GROUP BY in_reply_to_status_id
        ";
        return $this->db->query($sql,array($tweet_id))->row();
    }

}