<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class keyword_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * get listing keywords
     * 
     * @param int $offset
     * @param int  $limit
     * @return array
     */
    function get_keywords($offset = 0, $limit=25) {
        $sql = "
        SELECT SQL_CALC_FOUND_ROWS * FROM tweet_keywords 
        ORDER BY keyword
        LIMIT $offset,$limit ";
        $keywords['data'] = $this->db->query($sql)->result();
        $total = $this->db->query('SELECT FOUND_ROWS() as total')->row();
        $keywords['total'] = $total->total;
        return $keywords;
    }

    /**
     * get keyword based on id
     * 
     * @param int $keyword_id
     * @return obj 
     */
    function get_keyword($keyword_id) {
        return $this->db->get_where('tweet_keywords', array('id' => $keyword_id))->row();
    }

    function search_keyword($param=array()) {
        $def['keyword'] = '';
        $def['limit'] = 10;
        $def['offset'] = 0;

        $param = $param + $def;
        $offset = $param['offset'];
        $limit = $param['limit'];

        $sql = "
        SELECT SQL_CALC_FOUND_ROWS 
            * 
        FROM tweets 
        WHERE tweet_text  LIKE '%" . $this->db->escape_like_str($param['keyword']) . "%'
        ORDER BY created_at DESC
        LIMIT $offset,$limit 
        ";

        $keywords['data'] = $this->db->query($sql)->result();
        $total = $this->db->query('SELECT FOUND_ROWS() as total')->row()->total;
        $keywords['total'] = $total;
        return $keywords;
    }

    function get_statistic_keyword($keyword, $start, $end) {
        $sql = "
        SELECT 
        count(*) as total_tweets, 
        COUNT(DISTINCT screen_name) AS total_accounts,
        DATE_FORMAT(created_at,'%Y-%m-%d %H')  as tanggal
        FROM `tweets` 
        WHERE 
            `tweet_text` LIKE '%" . $this->db->escape_like_str($keyword) . "%'
            AND created_at BETWEEN ? AND ?
        GROUP BY tanggal            
        ";

        $stats = $this->db->query($sql, array($start, $end))->result();
        $d['tweets'] = array();
        $d['acc'] = array();
        $d['tanggal'] = array();
        foreach ($stats as $r) {
            $d['tweet'][] = $r->total_tweets;
            $d['acc'][] = $r->total_accounts;
            $d['tanggal'][] = $r->tanggal;
        }
        return $d;
    }

    function get_cloud_keyword($keyword, $start, $end) {
        $sql = "
        SELECT 
        tweet_text
        FROM `tweets` 
        WHERE 
            `tweet_text` LIKE '%" . $this->db->escape_like_str($keyword) . "%'
            AND created_at BETWEEN ? AND ?
        ";

        $stats = $this->db->query($sql, array($start, $end))->result();
        $str = '';
        foreach ($stats as $r) {
            $str .= " " . $r->tweet_text;
        }
        $words = array_count_values(str_word_count($str, 1,'#@'));
        asort($words);
        return array_reverse($words);
    }

    function process_words($string) {
        
    }

}