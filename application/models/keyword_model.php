<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class keyword_model extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    function get_keywords(){
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ";
    }
}