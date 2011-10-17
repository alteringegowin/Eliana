<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Tweet_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_tweet_by_keyword($keyword, $periode=array(), $paging=array(), $sentiment='')
    {

        $param_query[] = $periode['start'];
        $param_query[] = $periode['end'];
        $this->db->where("tweets.created_at BETWEEN '" . $periode['start'] . "' AND '" . $periode['end'] . "'");

        $sql_add_sentiment = '';
        if ( $sentiment ) {
            $this->db->where('sentiment', $sentiment);
            $sql_add_sentiment = "AND tweets.sentiment = ?";
            $param_query[] = $sentiment;
        }

        $paging['limit'] = isset($paging['limit']) ? $paging['limit'] : 25;
        $paging['offset'] = isset($paging['offset']) ? $paging['offset'] : 0;

        $sql = "
        SELECT 
        SQL_CALC_FOUND_ROWS *
        FROM tweets 
        WHERE 
            tweets.tweet_text LIKE '%" . $keyword . "%'
            AND tweets.created_at BETWEEN ? AND ?
            $sql_add_sentiment
        ORDER BY tweets.created_at DESC
        LIMIT " . $paging['offset'] . "," . $paging['limit'] . "
        ";

        $data = $this->db->query($sql, $param_query)->result();
        $total = $this->db->query('SELECT FOUND_ROWS() as total')->row();


        $res['data'] = $data;
        $res['total'] = $total->total;
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

    /**
     * Setting Sentiment
     * 
     * @author erwin 
     * @param type $sentiment
     * @param type $array_tweet_id 
     */
    function set_tweet_sentiment($sentiment, $tweet_id)
    {
        $db['sentiment'] = $sentiment;
        if ( is_array($tweet_id) ) {
            $this->db->where_in('tweet_id', $tweet_id);
        } else {
            $this->db->where('tweet_id', $tweet_id);
        }
        $this->db->update('tweets', $db);
    }

    function set_tweep_sex($sex, $user_id_array=array())
    {
        $db['sex'] = $sex;
        $this->db->where_in('user_id', $user_id_array);
        $this->db->update('tweet_users', $db);
    }

}