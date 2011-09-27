<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Home extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->load->model('home_model', 'home');
        $this->load->library('session');
        $this->load->helper('date');
		$this->load->library('ion_auth');
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }
    }

    function index() {
        //get account
        $this->db->order_by('tweet_follow.screen_name');
        $this->db->Select('tweet_users.*,tweet_follow.*');
        $this->db->join('tweet_users', 'tweet_users.user_id=tweet_follow.user_id', 'LEFT');
        $acc = $this->db->get('tweet_follow')->result();

        //get keywords
        $this->db->order_by('keyword');
        $keywords = $this->db->get('tweet_keywords')->result();

        $this->tpl['acc'] = $acc;
        $this->tpl['keywords'] = $keywords;
        $this->tpl['content'] = $this->load->view('home_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function def() {
        redirect('home/index');
    }

    function tweep($offset=0) {
        $this->load->helper('date');
        $limit = 25;
        $results = $this->home->get_followed($offset, $limit);
        $this->tpl['followeds'] = $results;
        $this->tpl['pagination'] = create_pagination('home/tweep', $results['total'], $limit, 3);
        $this->tpl['content'] = $this->load->view('home_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function backup() {
        $this->load->view('__backup', $this->tpl);
    }

    function search() {
        $q = $this->input->post('q', true);
        $key = md5($q);
        $this->session->set_userdata($key, $q);
        redirect('home/result/' . $key);
    }

    function result($key) {
        $q = $this->session->userdata($key);
        $this->load->helper('date');
        $limit = 25;
        $offset = $this->uri->segment(4, 0);
        $results = $this->home->search_followed($q, $offset, $limit);
        $this->tpl['followeds'] = $results;
        $this->tpl['pagination'] = create_pagination('home/result/' . $key, $results['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('home_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */