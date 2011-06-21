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
    }
    
    function index(){
        $r = $this->home->statistic();
        $this->tpl['stats'] = $r;
        $this->tpl['content'] = $this->load->view('home_statistic', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    function def(){
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
        $offset = $this->uri->segment(4,0);
        $results = $this->home->search_followed($q,$offset, $limit);
        $this->tpl['followeds'] = $results;
        $this->tpl['pagination'] = create_pagination('home/result/'.$key, $results['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('home_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */