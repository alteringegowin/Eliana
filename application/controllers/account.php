<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Account extends CI_Controller
{

    protected $tpl;

    function __construct()
    {
        parent::__construct();
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }

        $this->tpl = array();
        $this->tpl['breadcrumbs'][] = anchor('', 'Dashboard');
        $this->tpl['content'] = '';
        $this->load->model('keyword_model', 'keyword');
    }

    function index()
    {
        $sql = "
        SELECT
        tf.user_id,
        tf.screen_name,
        sum(t.followers_count) as total
        FROM tweet_follow tf
        LEFT JOIN tweet_mentions tm ON tf.user_id = tm.target_user_id
        LEFT JOIN tweets t ON t.tweet_id=tm.tweet_id 
        WHERE created_at BETWEEN DATE_SUB(created_at, INTERVAL 6 DAY) AND DATE_ADD(created_at,INTERVAL 1 DAY)
            AND t.tweet_text NOT LIKE '@%'
        GROUP BY tf.user_id            
        ORDER BY tf.screen_name ASC 
        ";
        $acc = $this->db->query($sql)->result();

        $this->tpl['acc'] = $acc;
        $this->tpl['breadcrumbs'][] = 'Account';
        $this->tpl['content'] = $this->load->view('account/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}
