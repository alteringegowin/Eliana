<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Mydashboard extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->load->model('home_model', 'home');
		$this->load->model('mydashboard_model', 'mydashboard');
        $this->load->library('session');
        $this->load->helper('date');
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }
    }

    function index() {
        //get keywords
        $this->db->order_by('keyword');
        $keywords = $this->db->get('tweet_keywords')->result();
		$acc = $this->db->get('tweet_follow')->result();

        $this->tpl['acc'] = $acc;
        $this->tpl['keywords'] = $keywords;
        $this->tpl['content'] = $this->load->view('mydashboard_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

	function tweet($key_id='',$offset=0) {
		if(isset($_POST['positif'])){
			$data = array('sentiment'=>'p');
			if(isset($_POST['cid'])){
				foreach($_POST['cid'] as $v){
					$this->mydashboard->updatesentiment($data,$v);
				}
			}
		}elseif(isset($_POST['minus'])){
			$data = array('sentiment'=>'m');
			if(isset($_POST['cid'])){
				foreach($_POST['cid'] as $v){
					$this->mydashboard->updatesentiment($data,$v);
				}
			}
		}elseif(isset($_POST['netral'])){
			$data = array('sentiment'=>'n');
			if(isset($_POST['cid'])){
				foreach($_POST['cid'] as $v){
					$this->mydashboard->updatesentiment($data,$v);
				}
			}
		}


		$limit =10;
        $keyword = $this->mydashboard->get_key($key_id);    
        $results = $this->mydashboard->get_tweet($keyword, $offset, $limit);
		$this->tpl['tweets'] = $results['data'];
		$this->tpl['pagination'] = create_pagination('/mydashboard/tweet/' . $key_id, $results['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('mydashboard_tweet', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}