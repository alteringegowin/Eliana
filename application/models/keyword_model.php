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

    function prepare_download_data($keyword, $from=false, $until=false) {
       
    }

}