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

    function backup() {
        $this->load->view('__backup', $this->tpl);
    }

    function test() {
        $tweet_id = '75497305138139136';
        $this->db->where('tweet_id', $tweet_id);
        $row = $this->db->get('json_cache')->row();
        $tweet_object = unserialize(base64_decode($row->raw_tweet));
        xdebug($tweet_object); die;


        $this->db->limit(5000, 15000);
        $this->db->where('parsed', 1);
        $this->db->order_by('cache_id', 'ASC');
        $results = $this->db->get('json_cache')->result();
        $all = array();
        $i = 0;
        foreach ($results as $row) {
            $tweet_object = unserialize(base64_decode($row->raw_tweet));
            if ( $tweet_object->in_reply_to_status_id_str && $tweet_object->in_reply_to_user_id_str ) {
                $d['in_reply_to_status_id'] = $tweet_object->in_reply_to_status_id_str;
                $d['in_reply_to_user_id'] = $tweet_object->in_reply_to_user_id_str;
                //$d['text'] = $tweet_object->text;
                $this->db->where('tweet_id', $row->tweet_id);
                $this->db->update('tweets', $d);
                $i++;
            }
        }
        echo $i;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */