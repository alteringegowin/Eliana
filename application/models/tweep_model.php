<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tweep_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_tweep($screen_name) {
        $acc = $this->db->get('tweet_follow',array('screen_name'=>$screen_name))->row();
        return $acc;
    }

}