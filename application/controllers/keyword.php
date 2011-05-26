<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keyword extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
    }

    function index() {
        $this->tpl['content'] = $this->load->view('keyword_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    /**
     * 
     */
    function archieve($keyword_id=0) {
        $this->tpl['content'] = $this->load->view('keyword_archieve', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    function export($keyword_id=0){
        $this->tpl['content'] = $this->load->view('keyword_export', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    function statistic($keyword_id=0){
        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/keyword.statistic.js';
        $this->tpl['content'] = $this->load->view('keyword_statistic', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }


}
