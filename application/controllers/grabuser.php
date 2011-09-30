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
        $limit =4;
        $this->db->limit($limit, $offset);
        $this->db->order_by('sex','DESC');
        $users = $this->db->get('tweet_users')->result();
        $total = $this->db->get('tweet_users')->num_rows();
        
        $pagination = create_pagination('grabuser/index/', $total, $limit, 4);


        $this->tpl['breadcrumbs'][] = 'Tweet User';
        $this->tpl['pagination'] = $pagination;
        $this->tpl['users'] = $users;
        $this->tpl['content'] = $this->load->view('grabuser/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}

