<?php

class Logging extends CI_Controller
{

    protected $tpl;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Log list for current user
     */
    function index()
    {
        $this->tpl['content'] = $this->load->view('logging/index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function user()
    {
        $this->tpl['content'] = $this->load->view('logging/user', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}