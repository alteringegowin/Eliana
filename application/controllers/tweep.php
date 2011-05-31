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

    function index($user_id='', $offset=0) {
        $this->load->helper('tweep');
        $limit = 10;
        $acc = $this->tweep->get_tweep_status($user_id, $offset, $limit);
        $this->tpl['acc'] = $acc;
        $this->tpl['pagination'] = create_pagination('/tweep/index/' . $user_id, $acc['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('tweep_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function mention($user_id='', $offset=0) {
        $limit = 10;
        $this->tpl['mention'] = $this->tweep->get_mention($user_id, $offset, $limit);
        $this->tpl['pagination'] = create_pagination('/tweep/mention/' . $user_id, $this->tpl['mention'] ['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('tweep_mention', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function user($user_id='') {
        $mentions = $this->tweep->get_top_mention($user_id, 20);
        $mentioneds = $this->tweep->get_top_mentioned($user_id, 20);
        $this->tpl['mentions'] = $mentions;
        $this->tpl['mentioneds'] = $mentioneds;
        $this->tpl['content'] = $this->load->view('tweep_user', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    /**
     * @deprecated
     * @param type $user_id 
     */
    function profile($user_id='') {
        $this->tpl['content'] = $this->load->view('tweep_profile', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function rt($user_id,$tweet_id) {
        $this->load->helper('date');
        $tweet = $this->tweep->get_tweet($tweet_id);

        $retweet = $this->tweep->get_retweet($tweet);

        $this->tpl['total'] = $this->tweep->count_total_rt_tweep($retweet); ;
        $this->tpl['tweet'] = $tweet;
        $this->tpl['retweet'] = $retweet;
        $this->tpl['content'] = $this->load->view('tweet_rt', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function reply($user_id,$tweet_id) {
        $this->load->helper('date');
        $tweet = $this->tweep->get_tweet($tweet_id);
        
        $replys = $this->tweep->get_reply_list($tweet_id);

        $this->tpl['tweet'] = $tweet;
        $this->tpl['replys'] = $replys;
        $this->tpl['content'] = $this->load->view('tweet_reply', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function keyword($user_id) {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $cloud = '';
        $keywords = array();
        if ( $start && $end ) {
            $keywords = $this->tweep->get_cloud_keyword($user_id, $start, $end);
            $this->load->library('wordcloud');
            $tags = array_slice($keywords, 0, 50);
            foreach ($tags as $r) {
                $this->wordcloud->addWord($r['word'], $r['count']);
            }
            $cloud = $this->wordcloud->showCloud();
        }

        $this->tpl['keywords'] = $keywords;
        $this->tpl['cloud'] = $cloud;
        $this->tpl['styles'][] = 'css/wordcloud.css';
        $this->tpl['javascripts'][] = 'js/tweep.keyword.js';
        $this->tpl['content'] = $this->load->view('tweep_keyword', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }
    

}