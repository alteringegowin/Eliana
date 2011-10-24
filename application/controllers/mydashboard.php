<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Mydashboard extends CI_Controller
{

    protected $tpl;

    function __construct()
    {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->load->model('home_model', 'home');
        $this->load->model('mydashboard_model', 'mydashboard');
        $this->load->library('session');
        $this->load->helper('date');
        $this->load->library('ion_auth');
        if ( !$this->ion_auth->logged_in() ) {
            //redirect them to the login page
            redirect('ionauth/login', 'refresh');
        }
    }

    function index()
    {
        $iduser = $this->session->userdata('id');
        if ( $this->ion_auth->is_admin() ) {
            $show = 1;
        } else {
            $show = 0;
        }
        //get user log list
        $this->tpl['latestupdate'] = $this->mydashboard->get_userlatestupdate($show, $iduser);

        //get keywords
        $this->db->order_by('keyword');
        $keywords = $this->db->get('tweet_keywords')->result();
        $acc = $this->db->get('tweet_follow')->result();

        $this->tpl['acc'] = $acc;
        $this->tpl['keywords'] = $keywords;
        $this->tpl['content'] = $this->load->view('mydashboard_index', $this->tpl, true);

        $this->load->view('body', $this->tpl);
    }

    function statistic($keyword)
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $stats = array();
        if ( isset($_POST['view']) ) {
            $stats = $this->mydashboard->count_sentiment_per_tanggal($keyword, $start, $end);
        }

        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/mydashboard.js';
        $this->tpl['keyword'] = $keyword;
        $this->tpl['stats'] = $stats;
        $this->tpl['content'] = $this->load->view('mydashboard_statistic', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function sentiment_bar($keyword)
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        //$start = '2011-09-01';
        //$end = '2011-09-30';

        $stats = $this->mydashboard->count_sentiment_per_tanggal($keyword, $start, $end);
        $this->tpl['stats'] = $stats;
        $this->load->view('mydashboard/sentiment_bar', $this->tpl);
    }

    function tweet($key_id='', $offset=0)
    {
        $iduser = $this->session->userdata('id');
        if ( isset($_POST['positif']) ) {
            $data = array('sentiment' => 'p');
            if ( isset($_POST['cid']) ) {
                foreach ($_POST['cid'] as $v) {
                    $this->mydashboard->inputlog($iduser, $v, 'p');
                    $this->mydashboard->updatesentiment($data, $v);
                }
            }
        } elseif ( isset($_POST['minus']) ) {
            $data = array('sentiment' => 'm');
            if ( isset($_POST['cid']) ) {
                foreach ($_POST['cid'] as $v) {
                    $this->mydashboard->inputlog($iduser, $v, 'm');
                    $this->mydashboard->updatesentiment($data, $v);
                }
            }
        } elseif ( isset($_POST['netral']) ) {
            $data = array('sentiment' => 'n');
            if ( isset($_POST['cid']) ) {
                foreach ($_POST['cid'] as $v) {
                    $this->mydashboard->inputlog($iduser, $v, 'n');
                    $this->mydashboard->updatesentiment($data, $v);
                }
            }
        }


        $limit = 10;
        $keyword = $this->mydashboard->get_key($key_id);
        $results = $this->mydashboard->get_tweet($keyword, $offset, $limit);
        $this->tpl['keyword'] = $keyword;
        $this->tpl['tweets'] = $results['data'];
        $this->tpl['pagination'] = create_pagination('/mydashboard/tweet/' . $key_id, $results['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('mydashboard_tweet', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function logs($id='', $offset=0)
    {
        $iduser = $this->session->userdata('id');
        if ( isset($_POST['positif']) ) {
            $data = array('sentiment' => 'p');
            if ( isset($_POST['cid']) ) {
                foreach ($_POST['cid'] as $v) {
                    $this->mydashboard->inputlog($iduser, $v, 'p');
                    $this->mydashboard->updatesentiment($data, $v);
                }
            }
        } elseif ( isset($_POST['minus']) ) {
            $data = array('sentiment' => 'm');
            if ( isset($_POST['cid']) ) {
                foreach ($_POST['cid'] as $v) {
                    $this->mydashboard->inputlog($iduser, $v, 'm');
                    $this->mydashboard->updatesentiment($data, $v);
                }
            }
        } elseif ( isset($_POST['netral']) ) {
            $data = array('sentiment' => 'n');
            if ( isset($_POST['cid']) ) {
                foreach ($_POST['cid'] as $v) {
                    $this->mydashboard->inputlog($iduser, $v, 'n');
                    $this->mydashboard->updatesentiment($data, $v);
                }
            }
        }

        $this->tpl['username'] = $this->ion_auth->get_user($id);
        $limit = 10;
        $logs = $this->mydashboard->get_logs($id, $offset, $limit);
        $this->tpl['logs'] = $logs['data'];
        $this->tpl['pagination'] = create_pagination('/mydashboard/logs/' . $id, $logs['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('mydashboard_log', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function user()
    {
		$iduser = $this->session->userdata('id');
        if ( $this->ion_auth->is_admin() ) {
            $show = 1;
        } else {
            $show = 0;
        }
        //get user log list
        $this->tpl['latestupdate'] = $this->mydashboard->get_userlatestupdate($show, $iduser);

        $this->tpl['users'] = $this->ion_auth->get_users_array();
        $this->tpl['content'] = $this->load->view('mydashboard_user', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}