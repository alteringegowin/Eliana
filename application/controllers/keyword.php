<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Keyword extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->load->model('keyword_model', 'keyword');
    }

    function index($offset=0) {
        $limit = 5;
        $keywords = $this->keyword->get_keywords($offset, $limit);
        $this->tpl['keywords'] = $keywords;
        $this->tpl['pagination'] = create_pagination('keyword/index/', $keywords['total'], $limit, 3);
        $this->tpl['content'] = $this->load->view('keyword_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    /**
     * 
     */
    function archieve($keyword_id=0, $offset=0) {
        $limit = 5;
        $keyword = $this->keyword->get_keyword($keyword_id);

        $param['keyword'] = $keyword->keyword;
        $param['limit'] = $limit;
        $param['offset'] = $offset;
        $searchs = $this->keyword->search_keyword($param);

        $this->tpl['searchs'] = $searchs;
        $this->tpl['pagination'] = create_pagination('keyword/archieve/' . $keyword_id, $searchs['total'], $limit, 4);
        $this->tpl['javascripts'][] = 'js/keyword.archieve.js';
        $this->tpl['content'] = $this->load->view('keyword_archieve', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function export($keyword_id=0) {
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $keyword = $this->keyword->get_keyword($keyword_id);
        if ( $start && $end ) {
            $this->load->helper('download');
            $sql = "
                SELECT  
                    created_at,tweet_text ,screen_name,name,source,followers_count,sentiment
                FROM tweets 
                WHERE tweet_text  LIKE '%" . $this->db->escape_like_str($keyword->keyword) . "%'
                    AND created_at BETWEEN ? AND ?
                ORDER BY created_at DESC
                ";
            $this->load->dbutil();
            $query = $this->db->query($sql, array($start, $end));
            $csvdata = $this->dbutil->csv_from_result($query);
            $filename = $keyword->keyword . ' from ' . $start . ' sd ' . $end;
            force_download(url_title($filename) . '.csv', $csvdata);
        }



        $this->tpl['javascripts'][] = 'js/timepicker/jquery-ui-timepicker-addon.js';
        $this->tpl['javascripts'][] = 'js/keyword.export.js';
        $this->tpl['styles'][] = 'js/timepicker/style.css';
        $this->tpl['keyword'] = $keyword;
        $this->tpl['content'] = $this->load->view('keyword_export', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    /**
     * 
     * @todo memilih periode
     * @param type $keyword_id 
     */
    function statistic($keyword_id=0) {
        $keyword = $this->keyword->get_keyword($keyword_id);
        $def_start = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $start = $this->uri->segment(4, $def_start);
        $end = $this->uri->segment(5, date('Y-m-d', mktime(0, 0, 0, date('m') + 1, 1, date('Y'))));
        $stats = $this->keyword->get_statistic_keyword($keyword->keyword, $start, $end);

        $this->tpl['stats'] = $stats;
        $this->tpl['keyword'] = $keyword;
        $this->tpl['keyword_id'] = $keyword_id;
        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/keyword.statistic.js';
        $this->tpl['content'] = $this->load->view('keyword_statistic', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    /**
     * cloud word
     */
    function cloud($keyword_id) {

        $keyword = $this->keyword->get_keyword($keyword_id);
        $def_start = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $start = $this->uri->segment(4, $def_start);
        $end = $this->uri->segment(5, date('Y-m-d', mktime(0, 0, 0, date('m') + 1, 1, date('Y'))));
        $words = $this->keyword->get_cloud_keyword($keyword->keyword, $start, $end);
        xdebug($words);

        $this->tpl['content'] = $this->load->view('keyword_cloud', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function mark_sentiment($tweet_id, $sentiment) {
        $db['sentiment'] = $sentiment;
        $this->db->where('tweet_id', $tweet_id);
        $this->db->update('tweets', $db);
    }

}
