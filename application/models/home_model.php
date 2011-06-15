<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_followed($offset=0,$limit=5){
        $this->db->select('tweet_users.*,tweet_follow.*');
        $this->db->join('tweet_users','tweet_users.user_id=tweet_follow.user_id','LEFT');
        $this->db->limit($limit,$offset);
        $this->db->order_by('tweet_follow.screen_name','ASC');
        $followeds['data'] = $this->db->get('tweet_follow')->result();
        $followeds['total'] = $this->db->get('tweet_follow')->num_rows();
        return $followeds;
    }
    
    
    function search_followed($q,$offset=0,$limit=5){
        $this->db->select('tweet_users.*,tweet_follow.*');
        $this->db->join('tweet_users','tweet_users.user_id=tweet_follow.user_id','LEFT');
        $this->db->limit($limit,$offset);
        $this->db->like('tweet_follow.screen_name',$q);
        $this->db->order_by('tweet_follow.screen_name','ASC');
        $followeds['data'] = $this->db->get('tweet_follow')->result();
        
        $this->db->like('tweet_follow.screen_name',$q);
        $followeds['total'] = $this->db->get('tweet_follow')->num_rows();
        return $followeds;
    }
    
}