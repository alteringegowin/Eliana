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

    function go() {
        $res = $this->db->get('tweet_follow')->result();
        $ada = array();
        foreach ($res as $r) {
            $ada[] = $r->user_id;
        }

        $this->db->limit(100);
        $this->db->order_by('followers_count DESC');
        $res = $this->db->get('tweet_users')->result();

        $this->tpl['ada'] = $ada;
        $this->tpl['calon'] = $res;
        $this->tpl['content'] = $this->load->view('engine_go', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function add($user_id) {
        $this->db->where('user_id', $user_id);
        $res = $this->db->get('tweet_users')->row();
        if ( $res ) {
            $this->db->where('user_id', $user_id);
            $fol = $this->db->get('tweet_follow')->row();
            if ( !$fol ) {
                $d['screen_name'] = $res->screen_name;
                $d['user_id'] = $res->user_id;
                $this->db->insert('tweet_follow', $d);
            }
        }
        redirect('engine/go');
    }

    function save($type) {
        if ( $type == 'keyword' ) {
            $keyword = $this->input->post('keyword', 1);
            $table = 'tweet_keywords';

            $this->db->where('keyword', $keyword);
            $row = $this->db->get($table)->num_rows();
            if ( $row ) {
                echo 'false';
            } else {
                $db['keyword'] = $keyword;
                $db['keyword_date'] = time();
                $this->db->insert($table, $db);
                echo 'true';
            }
        } else { 
            $keyword = $this->input->post('tweep', 1);
            $table = 'tweet_follow';

            $this->db->where('screen_name', $keyword);
            $row = $this->db->get($table)->num_rows();
            if ( $row ) {
                echo 'false';
            } else {
                $db['screen_name'] = $keyword;
                $db['keyword_date'] = time();
                //$this->db->insert($table, $db);
                echo 'true';
            }
        }
    }

}