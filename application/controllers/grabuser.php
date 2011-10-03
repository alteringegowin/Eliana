<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Grabuser extends CI_Controller
{

    protected $tpl;

    function __construct()
    {
        parent::__construct();
        if ( !$this->session->userdata('is_login') ) {
            redirect('ionauth/login');
        }

        $this->tpl['breadcrumbs'][] = anchor(site_url(), 'Dashboard');
        $this->tpl['content'] = '';
    }

    function index($offset=0)
    {
        $limit = 25;
        $this->db->limit($limit, $offset);
        $this->db->order_by('sex', 'ASC');
        $users = $this->db->get('tweet_users')->result();
        $total = $this->db->get('tweet_users')->num_rows();

        $pagination = create_pagination('grabuser/index/', $total, $limit, 3);

        $this->session->set_userdata('xurl', current_url());


        $this->tpl['breadcrumbs'][] = 'Tweet User';
        $this->tpl['pagination'] = $pagination;
        $this->tpl['users'] = $users;
        $this->tpl['content'] = $this->load->view('grabuser/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function post_sex()
    {
        $post = $this->input->post();
        $sex = $post['sex'];
        if ( $sex && isset($post['user_id']) && $post['user_id'] ) {
            $this->load->model('tweet_model', 'tweet');
            $this->tweet->set_tweep_sex($sex, $post['user_id']);

            $user_id = $this->session->userdata['user_id'];
            $this->load->model('log_model', 'log');
            foreach ($post['user_id'] as $r) {
                $action = 'set jenis kelamin user:' . $r . ' menjadi ' . $sex;
                $mode = 'sex';
                $this->log->save_log($user_id, $action, $mode);
            }

            $xurl = $this->session->userdata('xurl');
            if ( $xurl ) {
                $this->session->unset_userdata('xurl');
                redirect($xurl);
            } else {
                redirect('grabuser/index');
            }
        }
    }

    function search()
    {
        $q = $this->input->post('q', true);
        $key = md5($q);
        $this->session->set_userdata($key, $q);
        redirect('grabuser/result/' . $key);
    }

    function result($key, $offset=0)
    {
        $q = $this->session->userdata($key);
        $limit = 25;
        $this->db->limit($limit, $offset);
        $this->db->order_by('sex', 'ASC');
        $this->db->like('screen_name', $q);
        $this->db->or_like('name', $q);
        $users = $this->db->get('tweet_users')->result();

        $this->db->like('screen_name', $q);
        $this->db->or_like('name', $q);
        $total = $this->db->get('tweet_users')->num_rows();

        $this->session->set_userdata('xurl', current_url());
        $pagination = create_pagination('grabuser/result/' . $key . '/', $total, $limit, 4);


        $this->tpl['breadcrumbs'][] = 'Tweet User';
        $this->tpl['pagination'] = $pagination;
        $this->tpl['users'] = $users;
        $this->tpl['content'] = $this->load->view('grabuser/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}

