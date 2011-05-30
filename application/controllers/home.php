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
    }

    function index($offset=0) {
        $this->load->helper('date');
        $limit = 25;
        $results = $this->home->get_followed($offset, $limit);
        $this->tpl['followeds'] = $results;
        $this->tpl['pagination'] = create_pagination('home/index', $results['total'], $limit, 3);
        $this->tpl['content'] = $this->load->view('home_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */