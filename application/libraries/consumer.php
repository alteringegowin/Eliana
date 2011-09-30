<?php
define('TWITTER_CONSUMER_KEY', 'ZKSdAZ5goWFmTOn3YfUbTQ');
define('TWITTER_CONSUMER_SECRET', '1nCxAnI1zl7HFx9m5R5vFS6rLWNK7AgFn9Y0IrDKnk');
define('OAUTH_TOKEN', '26401725-Z5LqY3JeHN7fQrzNxI53PrPxXeZ2bvw18MvLHL7wM');
define('OAUTH_SECRET', 'FNUsmerJp6Blj1URGR03a4dHQ2rONpoSYOkMCR425E');
require_once(APPPATH . 'third_party/lib/Phirehose.php');
require_once(APPPATH . 'third_party/lib/OauthPhirehose.php');

class Consumer extends OauthPhirehose
{

    protected $CI;

    function __construct()
    {
        parent::__construct(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
        $this->CI = & get_instance();
    }

    public function enqueueStatus($status)
    {
        $data = json_decode($status);
        $tweet_id = $data->id_str;
        $raw_tweet = base64_encode(serialize($data));

        $field['raw_tweet'] = $raw_tweet;
        $field['tweet_id'] = $tweet_id;
        $this->CI->db->insert('json_cache', $field);
    }

}