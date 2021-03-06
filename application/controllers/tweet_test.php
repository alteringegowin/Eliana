<?php

class Tweet_test extends CI_Controller {

    function __construct() {
        parent::__construct();

        // It really is best to auto-load this library!
        $this->load->library('tweet');

        // Enabling debug will show you any errors in the calls you're making, e.g:
        $this->tweet->enable_debug(TRUE);

        // If you already have a token saved for your user
        // (In a db for example) - See line #37
        // 
        // You can set these tokens before calling logged_in to try using the existing tokens.
        // $tokens = array('oauth_token' => 'foo', 'oauth_token_secret' => 'bar');
        // $this->tweet->set_tokens($tokens);


        if ( !$this->tweet->logged_in() ) {
            // This is where the url will go to after auth.
            // ( Callback url )

            $this->tweet->set_callback(site_url('tweet_test/auth'));

            // Send the user off for login!
            $this->tweet->login();
        } else {
            // You can get the tokens for the active logged in user:
            // $tokens = $this->tweet->get_tokens();
            // 
            // These can be saved in a db alongside a user record
            // if you already have your own auth system.
        }
    }

    function index() {
        echo 'hi there';
    }

    function auth() {
        $tokens = $this->tweet->get_tokens();
        //pasarsapi, , , , 
        $param = array();
        $user = $this->tweet->call('GET', 'statuses/home_timeline', $param);
        //$user = $this->tweet->call('get', '/statuses/sjow/retweeted_by/ids');
        xdebug($user);
    }

}