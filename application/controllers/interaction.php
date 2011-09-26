<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Interaction extends CI_Controller
{

    protected $tpl;

    function __construct()
    {
        parent::__construct();
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }

        $this->tpl = array();
        $this->tpl['content'] = '';
    }

    function index($id=0)
    {

        $this->db->where('id', $id);
        $obj_keyword = $this->db->get('tweet_keywords')->row();

        $keyword = $obj_keyword->keyword;
        $start = $this->input->post('from');
        $end = $this->input->post('to');

        $ts_start = mktime(0, 0, 0, date('m'), date('d') - 7, date('Y'));
        $start = $start ? $start : date('Y-m-d', $ts_start);
        $end = $end ? $end : date('Y-m-d');


        $this->load->model('keyword_model', 'keyword');
        $res = $this->keyword->get_freq($keyword, $start, $end);

        $users = $this->keyword->count_user($keyword, $start, $end);
        $total['users'] = 0;
        $total['tweets'] = 0;
        $total['impression'] = 0;
        foreach ($res as $r) {
            $total['users'] += $r->users;
            $total['tweets'] += $r->tweets;
            $total['impression'] += $r->impression;
        }

        $this->tpl['keyword_id'] = $id;
        $this->tpl['total'] = $total;
        $this->tpl['start'] = $start;
        $this->tpl['end'] = $end;
        $this->tpl['keyword'] = $keyword;
        $this->tpl['users'] = $users;
        $this->tpl['interactions'] = $res;
        $this->tpl['javascripts'][] = 'js/interaction.js';
        $this->tpl['content'] = $this->load->view('interaction/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function tweet($keyword_id=0, $start='', $end='')
    {
        $this->db->where('id', $keyword_id);
        $obj_keyword = $this->db->get('tweet_keywords')->row();

        $this->load->model('keyword_model', 'keyword');
        
        
        $param['keyword'] = $obj_keyword->keyword;
        $param['start'] = $start;
        $param['end'] = $end;
        
        $res = $this->keyword->search_keyword($param);
        $this->tpl['tweets'] = $res;
        $this->tpl['content'] = $this->load->view('interaction/tweet', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}