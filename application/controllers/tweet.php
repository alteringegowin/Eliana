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

        $this->session->set_userdata('xurl', current_url());

        $pagination = create_pagination('tweet/index/' . $keyword_id, $tweets['total'], $paging_param['limit'], 4);

        $no = $paging_param['limit'] * $paging_param['offset'];
        $this->tpl['keyword_id'] = $keyword_id;
        $this->tpl['keyword_string'] = $keyword_text;
        $this->tpl['breadcrumbs'][] = $keyword_text;
        $this->tpl['pagination'] = $pagination;
        $this->tpl['tweets'] = $tweets;
        $this->tpl['no'] = $no;
        $this->tpl['content'] = $this->load->view('tweet/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function post_sentiment()
    {
        $post = $this->input->post();
        $sentiment = $post['sentiment'];
        if ( $sentiment && isset($post['user_id']) && $post['user_id'] ) {
            $this->load->model('tweet_model', 'tweet');
            $this->tweet->set_tweet_sentiment($sentiment, $post['user_id']);

            $user_id = $this->session->userdata['user_id'];
            $this->load->model('log_model', 'log');
            foreach ($post['user_id'] as $r) {
                $action = 'set jenis kelamin user:' . $r . ' menjadi ' . sentiment($sentiment);
                $mode = 'sentiment';
                $this->log->save_log($user_id, $action, $mode);
            }

            $xurl = $this->session->userdata('xurl');
            if ( $xurl ) {
                $this->session->unset_userdata('xurl');
                redirect($xurl);
            } else {
                redirect('tweet/index');
            }
        }
    }

    function sentiment($keyword_id=0, $sentiment='', $offset=0)
    {
        $this->load->model('tweet_model', 'tweet');
        $this->load->model('keyword_model', 'keyword');

        $keyword_text = $this->keyword->get_keyword($keyword_id)->keyword;

        $paging_param['offset'] = $offset;
        $paging_param['limit'] = 20;
        $tweets = $this->tweet->get_tweet_by_keyword($keyword_text, array(), $paging_param, $sentiment);

        $this->session->set_userdata('xurl', current_url());

        $pagination = create_pagination('tweet/sentiment/' . $keyword_id . '/' . $sentiment, $tweets['total'], $paging_param['limit'], 5);

        $no = $paging_param['limit'] * $paging_param['offset'];
        $this->tpl['keyword_string'] = $keyword_text;
        $this->tpl['keyword_id'] = $keyword_id;
        $this->tpl['breadcrumbs'][] = $keyword_text;
        $this->tpl['pagination'] = $pagination;
        $this->tpl['tweets'] = $tweets;
        $this->tpl['no'] = $no;
        $this->tpl['content'] = $this->load->view('tweet/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}