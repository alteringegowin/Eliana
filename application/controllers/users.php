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
        if ( !$this->uri->segment(3) ) {
            redirect('home');
        }
        $this->tpl['tweep'] = $this->tweep->get_tweep($this->uri->segment(3));
    }

}