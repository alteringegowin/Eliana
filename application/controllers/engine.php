<?php

class Engine extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->config->load('engine');
    }

    function test() {

#$output = shell_exec('kill -9 11851');
        $output = shell_exec('ps -ef |grep eliana_get_tweet');
        echo "<pre>$output</pre>";
        $output = shell_exec('ps -ef |grep eliana_process_tweet');
        echo "<pre>$output</pre>";
    }

    function startengine() {
        die;
        $output = `php index.php cli eliana_get_tweet > /dev/null 2>&1 & echo $!`;
        $db['pid'] = $output;
        $this->db->where('process', 'eliana_get_tweet');
        $this->db->update('processes', $db);

        $output = `php index.php cli eliana_process_tweet > /dev/null 2>&1 & echo $!`;
        $db['pid'] = $output;
        $this->db->where('process', 'eliana_process_tweet');
        $this->db->update('processes', $db);
    }

    function stopengine() {
        die;
        $kill = "kill -9 `ps -ef |grep eliana_get_tweet|grep -v grep | awk '{print $2}'`";
        exec($kill);

        $kill = "kill -9 `ps -ef |grep eliana_process_tweet|grep -v grep | awk '{print $2}'`";
        exec($kill);


        $db['pid'] = 0;
        $this->db->where('process', 'eliana_get_tweet');
        $this->db->update('processes', $db);

        $db['pid'] = 0;
        $this->db->where('process', 'eliana_process_tweet');
        $this->db->update('processes', $db);
    }

    function index() {


        $running = TRUE;
        $this->db->where('process', 'eliana_get_tweet');
        $r = $this->db->get('processes')->row();
        $output = array();
        if ( $r->pid ) {
            $command = 'ps ' . $r->pid;
            exec($command, $output);
        }
        if ( count($output) < 2 ) {
            $this->tpl['process'] = false;
        } else {
            $this->tpl['process'] = true;
        }

        $this->tpl['url_start'] = site_url('engine/startengine');
        $this->tpl['url_stop'] = site_url('engine/stopengine');

        $this->tpl['content'] = $this->load->view('engine_index', $this->tpl, true);
        /*
          $t = '<div class="block_content">
          <h3>Sedang dalam pengetesan :)</h3>
          Kontak langsung erwin aja sementara kalo mo nambahin akun dan keyword ya.. .
          </div>';
         * 
         */
        //$this->tpl['content'] = $t;
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
            $screen_name = $this->input->post('screen_name', 1);
            $user_id = $this->input->post('user_id', 1);
            $table = 'tweet_follow';

            $this->db->where('screen_name', $screen_name);
            $row = $this->db->get($table)->num_rows();
            if ( $row ) {
                echo 'false';
            } else {
                $db['screen_name'] = $screen_name;
                $db['user_id'] = $user_id;
                $this->db->insert($table, $db);
                echo 'true';
            }
        }
    }

    function add_account() {
        $this->load->helper('date');
        $this->load->library('tweet');
        $tokens = $this->session->userdata('tokens');
        $tokens['oauth_token'] = $this->config->item('oauth_token');
        $tokens['oauth_token_secret'] = $this->config->item('oauth_token_secret');
        if ( $tokens ) {
            $this->tweet->set_tokens($tokens);
        }

        if ( !$this->tweet->logged_in() ) {
// This is where the url will go to after auth.
// ( Callback url )
// Send the user off for login!
            $this->tweet->set_callback(current_url());
            $this->tweet->login();
        } else {
// You can get the tokens for the active logged in user:
            $tokens = $this->tweet->get_tokens();
            $this->session->set_userdata('tokens', $tokens);
// 
// These can be saved in a db alongside a user record
// if you already have your own auth system.
        }

        $param['screen_name'] = $this->input->post('account', true);
        $user = $this->tweet->call('GET', 'users/show', $param);

        $this->tpl['user'] = $user;
        $this->tpl['content'] = $this->load->view('engine_add_account', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}
