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

	function get_userlatestupdate($show,$iduser) {
		$filter = '';
		if($show == 0){
			$filter = "AND t.userid ='".$iduser."'";
		}
        $sql = "
        SELECT u.id,u.username,t.log_date,g.description FROM users u, logs t, groups g
		WHERE log_date = (SELECT MAX(log_date)
                 FROM logs t WHERE u.id = t.userid) ".$filter." AND g.id = u.group_id
        ORDER BY u.username";
        $result = $this->db->query($sql)->result();
		return $result;
    }

	function get_logs($id, $offset, $limit) {
        $sql = "
        SELECT 
			t.created_at, 
			t.screen_name,
			t.tweet_id,
			t.tweet_text, 
			t.name, 
			t.followers_count, 
			t.sentiment, 
			tu.profile_image_url, 
			l.log_date,
			l.action
		FROM 
			tweets t,
			tweet_users tu,
			logs l
		WHERE 
			tu.user_id = t.user_id AND t.tweet_id = l.tweet_id AND l.userid = '".$id."'
		ORDER BY l.log_date DESC LIMIT $offset,$limit
        ";
        $r['data'] = $this->db->query($sql)->result();
        $total = $this->db->query("SELECT count(*) as total FROM logs WHERE userid = '".$id."'")->row();
        $r['total'] = $total->total;
        return $r;
    }

	public function inputlog($iduser,$key_id,$sentiment)
	{
		$sql = "SELECT sentiment FROM tweets WHERE tweet_id = '".$key_id."'";
        $result = $this->db->query($sql)->result();

		switch ($result[0]->sentiment) {
			case 'n':
			    $old = 'netral';
				break;
			case 'm':
			    $old = 'minus';
			    break;
		    case 'p':
			    $old = 'positif';
				break;
			case 'a':
			    $old = 'ask';
			break;
		}

		switch ($sentiment) {
			case 'n':
			    $new = 'netral';
				break;
			case 'm':
			    $new = 'minus';
			    break;
		    case 'p':
			    $new = 'positif';
				break;
			case 'a':
			    $new = 'ask';
			break;
		}

		$data = array('userid'=>$iduser, 'log_date'=>date('Y-m-d H:i:s'), 'action'=>'update sentiment from '.$old.' to '.$new , 'tweet_id'=>$key_id);
		$ok = $this->db->insert('logs',$data);
	}

	public function updatesentiment($data,$id)
	{
		$ok = $this->db->update('tweets',$data,array('tweet_id'=>$id));
	}
}