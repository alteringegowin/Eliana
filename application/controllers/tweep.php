<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

/**
 * this is the property of user that we follow
 */
class Tweep extends CI_Controller
{

    protected $tpl;
    protected $profile;

    /**
     * @todo check kalo uri_segment 3 ga ada...
     */
    function __construct()
    {
        parent::__construct();
        $this->load->helper('time');
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }

        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->load->model('tweep_model', 'tweep');
        if ( !$this->uri->segment(3) ) {
            //redirect('home/tweep');
        }
        $this->tpl['breadcrumbs'][] = anchor('', 'Dashboard');
        $this->tpl['breadcrumbs'][] = anchor('account', 'Accounts');
        $this->profile = $this->tweep->get_tweep($this->uri->segment(3));
        $this->tpl['tweep'] = $this->profile;
    }

    function index($user_id='', $offset=0)
    {
        $this->load->helper('tweep');
        $limit = 10;
        $account = $this->tweep->get_tweep($user_id);
        $acc = $this->tweep->get_tweep_status($user_id, $offset, $limit);


        $this->tpl['breadcrumbs'][] = anchor('tweep/index/' . $user_id, $account->screen_name);
        $this->tpl['breadcrumbs'][] = 'status';

        $this->tpl['acc'] = $acc;
        $this->tpl['pagination'] = create_pagination('/tweep/index/' . $user_id, $acc['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('tweep/tweep_index', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function statistic($user_id)
    {
        $account = $this->tweep->get_tweep($user_id);
        
        $this->tpl['breadcrumbs'][] = anchor('tweep/index/' . $user_id, $account->screen_name);
        $this->tpl['breadcrumbs'][] = 'statistic';
        
        $this->tpl['user_id'] = $user_id;
        $this->tpl['styles'][] = 'css/wordcloud.css';
        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/tweep.statistic.js';
        $this->tpl['content'] = $this->load->view('tweep/tweep_statistic', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function mention($user_id='', $offset=0)
    {
        $account = $this->tweep->get_tweep($user_id);
        
        $this->tpl['breadcrumbs'][] = anchor('tweep/index/' . $user_id, $account->screen_name);
        $this->tpl['breadcrumbs'][] = 'mention';
        
        $limit = 10;
        $this->tpl['mention'] = $this->tweep->get_mention($user_id, $offset, $limit);
        $this->tpl['pagination'] = create_pagination('/tweep/mention/' . $user_id, $this->tpl['mention'] ['total'], $limit, 4);
        $this->tpl['content'] = $this->load->view('tweep/tweep_mention', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function user($user_id='')
    {
        $account = $this->tweep->get_tweep($user_id);
        
        $this->tpl['breadcrumbs'][] = anchor('tweep/index/' . $user_id, $account->screen_name);
        $this->tpl['breadcrumbs'][] = 'mention';
        $mentions = $this->tweep->get_top_mention($user_id, 20);
        $mentioneds = $this->tweep->get_top_mentioned($user_id, 20);
        $this->tpl['mentions'] = $mentions;
        $this->tpl['mentioneds'] = $mentioneds;
        $this->tpl['content'] = $this->load->view('tweep/tweep_user', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function growth($user_id)
    {
        
    }

    /**
     * @deprecated
     * @param type $user_id 
     */
    function profile($user_id='')
    {
        $this->tpl['content'] = $this->load->view('tweep/tweep_profile', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function rt($user_id, $tweet_id)
    {
        $this->load->helper('date');
        $tweet = $this->tweep->get_tweet($tweet_id);

        $retweet = $this->tweep->get_retweet($tweet);

        $this->tpl['total'] = $this->tweep->count_total_rt_tweep($retweet); ;
        $this->tpl['tweet'] = $tweet;
        $this->tpl['retweet'] = $retweet;
        $this->tpl['content'] = $this->load->view('tweep/tweet_rt', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function reply($user_id, $tweet_id)
    {
        $this->load->helper('date');
        $tweet = $this->tweep->get_tweet($tweet_id);

        $replys = $this->tweep->get_reply_list($tweet_id);

        $this->tpl['tweet'] = $tweet;
        $this->tpl['replys'] = $replys;
        $this->tpl['content'] = $this->load->view('tweep/tweet_reply', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function get_growth($user_id)
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');

        $growth = $this->tweep->get_growth($user_id, $start, $end);
        $this->tpl['growth'] = $growth;
        $this->load->view('tweep/tweet_get_growth', $this->tpl);
    }

    function get_rt($user_id='')
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $screen_name = $this->tpl['tweep']->screen_name;


        $rt = $this->tweep->count_retweet_per_tanggal($screen_name, $start, $end);


        $this->tpl['rt'] = $rt;
        $this->load->view('tweep/tweep_get_rt', $this->tpl);
    }

    /**
     * menghasilkan cloud
     */
    function get_cloud($user_id)
    {
        $this->load->library('wordcloud');
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);

        $keywords = $this->tweep->get_cloud_keyword($user_id, $start, $end);
        $tags = array_slice($keywords, 0, 100);
        foreach ($tags as $r) {
            $word = anchor('#', $r['word']);
            $this->wordcloud->addWord($word, $r['count']);
        }
        $this->tpl['cloud'] = $this->wordcloud->showCloud();
        $this->load->view('tweep/tweep_get_cloud', $this->tpl);
    }

    function get_stat_rt($user_id)
    {
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);

        $keywords = $this->tweep->count_retweet($this->profile->screen_name, $start, $end);
        $this->tpl['rt'] = $keywords;
        $this->load->view('tweep/tweep_get_stat_rt', $this->tpl);
    }

    function get_mention($user_id)
    {
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);


        $keywords = $this->tweep->count_mention($user_id, $start, $end);
        $this->tpl['mention'] = $keywords;
        $this->load->view('tweep/tweep_get_mention', $this->tpl);
    }

}