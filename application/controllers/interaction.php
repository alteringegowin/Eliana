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

        $this->tpl['breadcrumbs'][] = anchor(site_url(), 'Dashboard');
        $this->tpl['breadcrumbs'][] = anchor('keyword', 'Keywords');
        $this->tpl['content'] = '';
    }

    function periode()
    {
        $start = $this->input->post('from');
        $end = $this->input->post('to');
        $keyword_id = $this->input->post('keyword_id');
        redirect('interaction/index/' . $keyword_id . '/' . $start . '/' . $end);
    }

    function index($id=0, $start=0, $end=0)
    {

        $this->db->where('id', $id);
        $obj_keyword = $this->db->get('tweet_keywords')->row();

        $keyword = $obj_keyword->keyword;


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

        $this->tpl['breadcrumbs'][] = $keyword;
        $this->tpl['content'] = $this->load->view('interaction/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function tweet($keyword_id=0, $start, $end, $date)
    {
        $this->load->model('keyword_model', 'keyword');
        $this->db->where('id', $keyword_id);
        $obj_keyword = $this->db->get('tweet_keywords')->row();
        $keyword = $obj_keyword->keyword;

        $res = $this->keyword->search_keyword_by_date($keyword, $date);

        $this->tpl['breadcrumbs'][] = anchor('interaction/index/' . $keyword_id . '/' . $start . '/' . $end, $obj_keyword->keyword);
        $this->tpl['breadcrumbs'][] = $date;
        $this->tpl['tweets'] = $res;
        $this->tpl['content'] = $this->load->view('interaction/tweet', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function user($keyword_id=0, $user='', $start='', $end='')
    {
        $this->load->model('keyword_model', 'keyword');
        $this->db->where('id', $keyword_id);
        $obj_keyword = $this->db->get('tweet_keywords')->row();

        $res = $this->keyword->search_keyword_by_user_id($obj_keyword->keyword, $user, $start, $end);
        $tweet_user = $this->keyword->get_user($user);

        $this->tpl['breadcrumbs'][] = anchor('interaction/index/' . $keyword_id . '/' . $start . '/' . $end, $obj_keyword->keyword);
        $this->tpl['breadcrumbs'][] = $tweet_user->screen_name;
        $this->tpl['tweets'] = $res;
        $this->tpl['tweet_user'] = $tweet_user;
        $this->tpl['content'] = $this->load->view('interaction/user', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function download($keyword_id=0, $start='', $end='')
    {

        $this->load->model('keyword_model', 'keyword');
        $this->db->where('id', $keyword_id);
        $obj_keyword = $this->db->get('tweet_keywords')->row();

        $param['keyword'] = $obj_keyword->keyword;
        $param['start'] = $start;
        $param['end'] = $end;
        $res = $this->keyword->search_keyword($param);

        $this->load->library('table');
        $this->table->set_heading('name', 'tweet', 'created', 'followers');


        foreach ($res['data'] as $r) {
            $this->table->add_row(
                $r->screen_name, $r->tweet_text, $r->created_at, $r->followers_count
            );
        }
        $filename = $param['keyword'] . '_' . $start . '_' . $end;
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=$filename.xls");
        echo $this->table->generate();
    }

}