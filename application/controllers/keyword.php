<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Keyword extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->load->model('keyword_model','keyword');
    }

    function index($offset=0) {
        $limit = 5;
        $keywords = $this->keyword->get_keywords($offset,$limit);
        $this->tpl['keywords'] = $keywords;
        $this->tpl['pagination'] = create_pagination('keyword/index/',$keywords['total'],$limit,3);
        $this->tpl['content'] = $this->load->view('keyword_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    /**
     * 
     */
    function archieve($keyword_id=0,$offset=0) {
        $limit = 5;
        $keyword = $this->keyword->get_keyword($keyword_id);
        
        $param['keyword'] = $keyword->keyword;
        $param['limit'] = $limit;
        $param['offset'] = $offset;
        $searchs = $this->keyword->search_keyword($param);
        
        $this->tpl['searchs'] = $searchs;
        $this->tpl['pagination'] = create_pagination('keyword/archieve/'.$keyword_id,$searchs['total'],$limit,4);
        $this->tpl['javascripts'][] = 'js/keyword.archieve.js';
        $this->tpl['content'] = $this->load->view('keyword_archieve', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function export($keyword_id=0) {
        $this->tpl['content'] = $this->load->view('keyword_export', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function statistic($keyword_id=0) {
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
    function cloud(){
        echo 'cloud';
        $this->tpl['content'] = $this->load->view('keyword_cloud', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    function mark_sentiment($tweet_id,$sentiment){
        $db['sentiment'] = $sentiment;
        $this->db->where('tweet_id',$tweet_id);
        $this->db->update('tweets',$db);
    }

}
