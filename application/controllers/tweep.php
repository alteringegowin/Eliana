<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

/**
 * this is the property of user that we follow
 */
class Tweep extends CI_Controller {

    protected $tpl;

    /**
     * @todo check kalo uri_segment 3 ga ada...
     */
    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->load->model('tweep_model', 'tweep');
        
        
    }
    
    function index($screen_name='') {
        
        $acc = $this->tweep->get_tweep($screen_name);
        
        $this->tpl['acc'] = $acc;
        $this->tpl['content'] = $this->load->view('tweep_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    function mention($screen_name=''){
        
        $this->tpl['content'] = $this->load->view('tweep_mention', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    
    function user($screen_name=''){
        
        $this->tpl['content'] = $this->load->view('tweep_user', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    function profile($screen_name=''){
        
        $this->tpl['content'] = $this->load->view('tweep_profile', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    
    
}