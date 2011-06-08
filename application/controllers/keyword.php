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
        $this->load->helper('form');
        $dd_keywords = $this->keyword->get_dropdown_keyword();

        $this->tpl['keywords'] = $dd_keywords;
        $this->tpl['styles'][] = 'css/wordcloud.css';
        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/keyword.index.js';
        $this->tpl['content'] = $this->load->view('keyword_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    /**
     * Menghitung total tweet based on keyword and periode
     */
    function count_tweet() {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        echo json_encode($this->keyword->count_tweet($keyword, $start, $end));
    }

    /**
     * Menghitung total user participated based on keyword and periode
     */
    function count_user() {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $this->tpl['data'] = $this->keyword->count_user($keyword, $start, $end);
        $this->load->view('keyword_count_user', $this->tpl);
    }

    /**
     * menghasilkan cloud
     */
    function get_cloud() {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $keywords = $this->keyword->get_cloud($keyword, $start, $end);
        $this->load->library('wordcloud');
        $tags = array_slice($keywords, 0, 50);
        foreach ($tags as $r) {
            $this->wordcloud->addWord($r['word'], $r['count']);
        }
        $this->tpl['cloud'] = $this->wordcloud->showCloud();
        $this->load->view('keyword_cloud', $this->tpl);
    }

    /**
     * Menghitung statistic
     */
    function get_statistic() {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $this->tpl['stats'] = $this->keyword->get_statistic($keyword, $start, $end);
        $this->load->view('keyword_statistic', $this->tpl);
    }

    /*
      function filter_keyword() {
      $param['keyword'] = $this->input->post('keyword', 1);
      $param['start'] = $this->input->post('start', 1);
      $param['end'] = $this->input->post('end', 1);
      $this->tpl['filters'] = $this->keyword->search_keyword($param);
      }
     * 
     */

    function get_freq() {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $this->tpl['freq'] = $this->keyword->get_freq($keyword, $start, $end); 
        $this->load->view('keyword_statistic', $this->tpl);
    }

}
