<?php
include_once 'phirehose.php';

// External URL for Javascript code in browsers to call the framework with Ajax
define('AJAX_URL', 'http://erwin.think.web.id/140dev/');

// Basic authorization settings for connecting to the Twitter streaming API
// Fill in the values for a valid Twitter account
define('STREAM_ACCOUNT', 'MandaBoobs');
define('STREAM_PASSWORD', 'cinta.tivi');

// MySQL time zone setting to normalize dates
define('TIME_ZONE', 'Asia/Jakarta');

// Settings for monitor_tweets.php
define('TWEET_ERROR_INTERVAL', 10);
// Fill in the email address for error messages
define('TWEET_ERROR_ADDRESS', '*****');

class Consumer extends Phirehose {

    protected $CI;

    function __construct() {
        parent::__construct(STREAM_ACCOUNT, STREAM_PASSWORD, Phirehose::METHOD_FILTER);

        $this->CI = & get_instance();
    }

    public function enqueueStatus($status) {
        $tweet_object = json_decode($status);
        $tweet_id = $tweet_object->id_str;

        $raw_tweet = base64_encode(serialize($tweet_object));

        $field['raw_tweet'] = $raw_tweet;
        $field['tweet_id'] = $tweet_id;
        $this->CI->db->insert('json_cache', $field);
    }

}