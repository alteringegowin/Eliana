<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_followed($offset=0, $limit=5) {
        $this->db->select('tweet_users.*,tweet_follow.*');
        $this->db->join('tweet_users', 'tweet_users.user_id=tweet_follow.user_id', 'LEFT');
        $this->db->limit($limit, $offset);
        $this->db->order_by('tweet_follow.screen_name', 'ASC');
        $followeds['data'] = $this->db->get('tweet_follow')->result();
        $followeds['total'] = $this->db->get('tweet_follow')->num_rows();
        return $followeds;
    }

    function search_followed($q, $offset=0, $limit=5) {
        $this->db->select('tweet_users.*,tweet_follow.*');
        $this->db->join('tweet_users', 'tweet_users.user_id=tweet_follow.user_id', 'LEFT');
        $this->db->limit($limit, $offset);
        $this->db->like('tweet_follow.screen_name', $q);
        $this->db->order_by('tweet_follow.screen_name', 'ASC');
        $followeds['data'] = $this->db->get('tweet_follow')->result();

        $this->db->like('tweet_follow.screen_name', $q);
        $followeds['total'] = $this->db->get('tweet_follow')->num_rows();
        return $followeds;
    }

    function statistic() {
        $start = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')));
        $end = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));
        $sql = "
        SELECT 
            f.user_id, 
            u.screen_name, 
            u.description, 
            u.profile_image_url, 
            u.followers_count, 
            COUNT( m.tweet_id ) AS mentions, 
            COUNT( DISTINCT m.source_user_id ) AS users
        FROM  `tweet_follow` f
            LEFT JOIN tweet_mentions m ON f.user_id = m.`target_user_id` AND m.source_user_id != m.target_user_id
            LEFT JOIN tweet_users u ON f.user_id = u.user_id  
            LEFT JOIN tweets t ON t.tweet_id = m.tweet_id
        WHERE 
            t.created_at BETWEEN  ? AND  ?
        GROUP BY f.user_id
        ORDER BY mentions DESC 
        ";
        return $this->db->query($sql, array($start, $end))->result();
    }
    
    function count_tweet(){
        $sql = "";
    }

}