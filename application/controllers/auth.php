<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['no_menu'] = true;
        $this->load->library('session');
        $this->load->helper('date');
    }

    function login() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ( $this->form_validation->run() ) {
            $post = $this->input->post();
            if ( $post['email'] == 'eliana' && $post['password'] == 'sumpecakepbener' ) {
                $this->session->set_userdata('is_login', true);
                redirect('home');
            }
        }

        $this->tpl['content'] = $this->load->view('auth_login', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function logout() {
        $this->session->unset_userdata('is_login');
        redirect('auth/login');
    }

}