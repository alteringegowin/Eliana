<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Tweet_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_tweet_by_keyword($keyword, $periode=array(), $paging=array())
    {
        if ( $paging ) {
            $paging['limit'] = isset($paging['limit']) ? $paging['limit'] : 25;
            $paging['offset'] = isset($paging['offset']) ? $paging['offset'] : 0;
            $this->db->limit($paging['limit'], $paging['offset']);
        }

        if ( $periode ) {
            $this->db->where("tweets.created_at BETWEEN '" . $periode['end'] . "' AND '" . $periode['end'] . "'");
        }

        $this->db->like('tweets.tweet_text', $keyword);
        $res['data'] = $this->db->get('tweets')->result();

        if ( $periode ) {
            $this->db->where("tweets.created_at BETWEEN '" . $periode['end'] . "' AND '" . $periode['end'] . "'");
        }
        $res['total'] = $this->db->get('tweets')->num_rows();
        return $res;
    }

    function get_tweet_by_user_id($user_id, $periode=array(), $paging=array())
    {
        if ( $paging ) {
            $paging['limit'] = isset($paging['limit']) ? $paging['limit'] : 25;
            $paging['offset'] = isset($paging['offset']) ? $paging['offset'] : 0;
            $this->db->limit($paging['limit'], $paging['offset']);
        }

        if ( $periode ) {
            $this->db->where("tweets.created_at BETWEEN '" . $periode['end'] . "' AND '" . $periode['end'] . "'");
        }

        $this->db->where('tweets.user_id', $user_id);
        $res['data'] = $this->db->get('tweets')->result();

        if ( $periode ) {
            $this->db->where("tweets.created_at BETWEEN '" . $periode['end'] . "' AND '" . $periode['end'] . "'");
        }
        $res['total'] = $this->db->get('tweets')->num_rows();
        return $res;
    }

}