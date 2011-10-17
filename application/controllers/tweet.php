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
        $this->load->library('session');

        $keyword_text = $this->keyword->get_keyword($keyword_id)->keyword;

        if ( $this->input->post('view') ) {
            $datestart = $this->input->post('start');
            $dateend = $this->input->post('end');

            $this->session->unset_userdata('datestart');
            $this->session->unset_userdata('dateend');
            $newdata = array('datestart' => $datestart, 'dateend' => $dateend);
            $this->session->set_userdata($newdata);
        }

        $start = $this->session->userdata('datestart');
        $end = $this->session->userdata('dateend');

        $periode = array();

        if ( isset($start) && isset($end) ) {
            $periode = array('start' => $start, 'end' => $end);
        }

        $paging_param['offset'] = $offset;
        $paging_param['limit'] = 20;
        $tweets = $this->tweet->get_tweet_by_keyword($keyword_text, $periode, $paging_param);

        $this->session->set_userdata('xurl', current_url());

        $pagination = create_pagination('tweet/index/' . $keyword_id, $tweets['total'], $paging_param['limit'], 4);

        $no = $paging_param['limit'] * $paging_param['offset'];
        $this->tpl['keyword_id'] = $keyword_id;
        $this->tpl['keyword_string'] = $keyword_text;
        $this->tpl['breadcrumbs'][] = $keyword_text;
        $this->tpl['pagination'] = $pagination;
        $this->tpl['tweets'] = $tweets;
        $this->tpl['start'] = $start;
        $this->tpl['end'] = $end;
        $this->tpl['no'] = $no;
        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/sentimentupdate.js';
        $this->tpl['content'] = $this->load->view('tweet/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function post_sentiment($id, $sentiment)
    {
        $this->load->model('tweet_model', 'tweet');
        $this->tweet->set_tweet_sentiment($sentiment, $id);

        $user_id = $this->session->userdata['user_id'];
        $this->load->model('log_model', 'log');

        $action = 'set sentiment menjadi ' . sentiment($sentiment);
        $mode = 'sentiment';
        $tweet_id = $id;
        $this->log->save_log($user_id, $action, $mode, $tweet_id);


        $xurl = $this->session->userdata('xurl');
        if ( $xurl ) {
            $this->session->unset_userdata('xurl');
            redirect($xurl);
        } else {
            redirect('tweet/index');
        }
    }

    function sentiment($keyword_id=0, $sentiment='', $start=0, $end=0, $offset=0)
    {
        $this->load->model('tweet_model', 'tweet');
        $this->load->model('keyword_model', 'keyword');
        $this->load->library('session');

        $keyword_text = $this->keyword->get_keyword($keyword_id)->keyword;

        if ( $this->input->post('view') ) {
            $datestart = $this->input->post('start');
            $dateend = $this->input->post('end');

            $this->session->unset_userdata('datestart');
            $this->session->unset_userdata('dateend');
            $newdata = array('datestart' => $datestart, 'dateend' => $dateend);
            $this->session->set_userdata($newdata);
        }

        $start = $this->session->userdata('datestart');
        $end = $this->session->userdata('dateend');

        $periode = array();

        if ( isset($start) && isset($end) ) {
            $periode = array('start' => $start, 'end' => $end);
        }

        $paging_param['offset'] = $offset;
        $paging_param['limit'] = 20;
        $tweets = $this->tweet->get_tweet_by_keyword($keyword_text, $periode, $paging_param, $sentiment);

        $this->session->set_userdata('xurl', current_url());

        $pagination = create_pagination('tweet/sentiment/' . $keyword_id . '/' . $sentiment, $tweets['total'], $paging_param['limit'], 5);

        $no = $paging_param['limit'] * $paging_param['offset'];
        $this->tpl['keyword_string'] = $keyword_text;
        $this->tpl['keyword_id'] = $keyword_id;
        $this->tpl['breadcrumbs'][] = $keyword_text;
        $this->tpl['pagination'] = $pagination;
        $this->tpl['tweets'] = $tweets;
        $this->tpl['no'] = $no;
        $this->tpl['start'] = $start;
        $this->tpl['end'] = $end;
        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/sentimentupdate.js';
        $this->tpl['content'] = $this->load->view('tweet/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}