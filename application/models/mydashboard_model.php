<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class mydashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	function get_tweet($keyword, $offset, $limit) {
        $sql = "
        SELECT
            t.created_at, t.screen_name, 
			t.tweet_id,
            t.tweet_text, 
            t.name, 
            t.followers_count,
			t.sentiment,
            tu.profile_image_url
        FROM tweets t
            LEFT JOIN tweet_users tu ON tu.user_id=t.user_id
        WHERE 
            t.tweet_text LIKE '%#" . $this->db->escape_like_str($keyword) . "%'
        ORDER BY t.created_at DESC LIMIT $offset,$limit
        ";
        $r['data'] = $this->db->query($sql)->result();
		//$total = $this->db->query('SELECT FOUND_ROWS() as total')->row();
        $total = $this->db->query("SELECT count(*) as total FROM `tweets` WHERE tweet_text LIKE '%#" . $this->db->escape_like_str($keyword) . "%'")->row();
        $r['total'] = $total->total;
        return $r;
    }

	function get_key($key_id) {
        $sql = "
        SELECT
            keyword
        FROM 
			tweet_keywords   
        WHERE 
            id =  $key_id
        ";
        $result = $this->db->query($sql)->result();
		$r = $result[0]->keyword;
        return $r;
    }

	public function updatesentiment($data,$id)
	{
		$ok = $this->db->update('tweets',$data,array('tweet_id'=>$id));
	}
}