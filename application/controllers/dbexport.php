<?php

class Dbexport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
    }

    function index() {
        $this->load->helper('file');
        $string = read_file('./eliana_new.sql');
        echo $string;
    }

}