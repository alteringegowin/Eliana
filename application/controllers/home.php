<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Home extends CI_Controller {
    protected $tpl;
    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
    }

    function index() {
        $this->tpl['content'] = $this->load->view('home_index',$this->tpl,true);
        $this->load->view('body',$this->tpl);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */