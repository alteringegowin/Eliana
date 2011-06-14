<?php

class Engine extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->config->load('engine');
    }

    function index() {
        $running = TRUE;
        $this->db->where('process', 'get_tweets.php');
        $r = $this->db->get('processes')->row();
        $command = 'ps ' . $r->pid;
        exec($command, $output);
        if ( count($output) < 2 ) {
            $this->tpl['process'] = false;
        } else {
            $this->tpl['process'] = true;
        }
        
        $this->tpl['url_start'] = $this->config->item('engine_url_start');
        $this->tpl['url_stop'] = $this->config->item('engine_url_stop');

        $this->tpl['content'] = $this->load->view('engine_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}