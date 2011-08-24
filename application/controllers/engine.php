<?php

class Engine extends CI_Controller {

    protected $tpl;

    function __construct() {
        parent::__construct();
        $this->tpl = array();
        $this->config->load('engine');
    }

    function test() {
        
    }

    function check_captcha($val) {
        if ( $this->recaptcha->check_answer($this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $val) ) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_captcha', $this->lang->line('recaptcha_incorrect_response'));
            return FALSE;
        }
    }

    function testold() {
        #$output = shell_exec('kill -9 11851');
        $output = shell_exec('ps -ef |grep eliana_get_tweet');
        echo "<pre>$output</pre>";
        $output = shell_exec('ps -ef |grep eliana_process_tweet');
        echo "<pre>$output</pre>";
        
        $output = shell_exec('ps -ef |grep eliana_monitor');
        echo "<pre>$output</pre>";
    }

    function startengine() {
        $this->tpl['act'] = 'engine/startengine';
        $this->tpl['title_atas'] = 'Start The Engine!';
        $this->load->library('recaptcha');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->lang->load('recaptcha');
        $this->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|callback_check_captcha');
        if ( $this->form_validation->run() ) {
            $this->tpl['recaptcha'] = 'AHoi';
            $output = `php index.php cli eliana_get_tweet > /dev/null 2>&1 & echo $!`;
            $db['pid'] = $output;
            $this->db->where('process', 'eliana_get_tweet');
            $this->db->update('processes', $db);

            $output = `php index.php cli eliana_process_tweet > /dev/null 2>&1 & echo $!`;
            $db['pid'] = $output;
            $this->db->where('process', 'eliana_process_tweet');
            $this->db->update('processes', $db);
            
            //monitor tweets
            $output = `php index.php cli eliana_monitor > /dev/null 2>&1 & echo $!`;
            

            redirect('engine');
        } else {
            $this->tpl['recaptcha'] = $this->recaptcha->get_html();
        }
        $this->tpl['content'] = $this->load->view('engine_startengine', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function stopengine() {
        $this->tpl['act'] = 'engine/stopengine';
        $this->tpl['title_atas'] = 'Stop The Engine!';

        $this->load->library('recaptcha');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->lang->load('recaptcha');
        $this->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|callback_check_captcha');
        if ( $this->form_validation->run() ) {

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
            redirect('engine');
        } else {
            $this->tpl['recaptcha'] = $this->recaptcha->get_html();
        }
        $this->tpl['content'] = $this->load->view('engine_startengine', $this->tpl, true);
        $this->load->view('body', $this->tpl);
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
            $this->tweet->set_callback(current_url());
            $this->tweet->login();
        } else {
            $tokens = $this->tweet->get_tokens();
            $this->session->set_userdata('tokens', $tokens);
        }

        $param['screen_name'] = $this->input->post('account', true);
        $user = $this->tweet->call('GET', 'users/show', $param);

        $this->tpl['user'] = $user;
        $this->tpl['content'] = $this->load->view('engine_add_account', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}
