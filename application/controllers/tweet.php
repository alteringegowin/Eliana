<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Tweet extends CI_Controller
{

    protected $tpl;

    function __construct()
    {
        parent::__construct();
        if ( !$this->session->userdata('is_login') ) {
            redirect('ionauth/login');
        }

        $this->tpl = array();
        $this->tpl['breadcrumbs'][] = anchor('', 'Dashboard');
        $this->tpl['breadcrumbs'][] = anchor('keyword', 'Keywords');
        $this->tpl['content'] = '';
    }

    function index($keyword_id=0, $offset=0)
    {
        $this->load->model('tweet_model', 'tweet');
        $this->load->model('keyword_model', 'keyword');

        $keyword_text = $this->keyword->get_keyword($keyword_id)->keyword;

        $paging_param['offset'] = $offset;
        $paging_param['limit'] = 20;
        $tweets = $this->tweet->get_tweet_by_keyword($keyword_text, array(), $paging_param);


        $pagination = create_pagination('tweet/index', $tweets['total'], $paging_param['limit'], 4);

        $no = $limit * $offset;
        $this->tpl['keyword_string'] = $keyword_text;
        $this->tpl['breadcrumbs'][] = $keyword_text;
        $this->tpl['pagination'] = $pagination;
        $this->tpl['content'] = $this->load->view('tweet/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}