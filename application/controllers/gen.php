<?php

/**
 * buat test tanpa ada username dan password
 */
class Gen extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        die('a');
        // Process all new tweets
        $query = 'SELECT cache_id, raw_tweet ' .
            'FROM json_cache WHERE NOT parsed';
        $result = $this->db->query($query)->result_array();
        foreach ($result as $row) {
            $cache_id = $row['cache_id'];
            $tweet_object = unserialize(base64_decode($row['raw_tweet']));
            $user_object = $tweet_object->user;
            $user_id = $user_object->id_str;


            // Add a new user row or update an existing one
            $dbuser['screen_name'] = $user_object->screen_name;
            $dbuser['profile_image_url'] = $user_object->profile_image_url;
            $dbuser['user_id'] = $user_object->id_str;
            $dbuser['name'] = $user_object->name;
            $dbuser['location'] = $user_object->location;
            $dbuser['url'] = $user_object->url;
            $dbuser['description'] = $user_object->description;
            $dbuser['created_at'] = date('Y-m-d H:i:s', strtotime($user_object->created_at));
            $dbuser['followers_count'] = $user_object->followers_count;
            $dbuser['friends_count'] = $user_object->friends_count;
            $dbuser['statuses_count'] = $user_object->statuses_count;
            $dbuser['time_zone'] = $user_object->time_zone;
            $dbuser['last_update'] = date('Y-m-d H:i:s', strtotime($tweet_object->created_at));

            $row = $this->db->get_where('tweet_users', array('user_id' => $user_id))->row();
            if ( $row ) {
                $this->db->where(array('user_id' => $user_id));
                $this->db->update('tweet_users', $dbuser);
            } else {
                $this->db->insert('tweet_users', $dbuser);
            }



            $tweet_id = $tweet_object->id_str;
            $ada = $this->db->get_where('tweets', array('tweet_id' => $tweet_id))->row();
            if ( !$ada ) {
                if ( isset($tweet_object->geo) ) {
                    $geo_lat = $tweet_object->geo->coordinates[0];
                    $geo_long = $tweet_object->geo->coordinates[1];
                } else {
                    $geo_lat = $geo_long = 0;
                }

                $dbtweet['tweet_id'] = $tweet_id;
                $dbtweet['tweet_text'] = $tweet_object->text;
                $dbtweet['created_at'] = date('Y-m-d H:i:s', strtotime($tweet_object->created_at));
                $dbtweet['geo_lat'] = $geo_lat;
                $dbtweet['geo_long'] = $geo_long;
                $dbtweet['user_id'] = $user_object->id_str;
                $dbtweet['screen_name'] = $user_object->screen_name;
                $dbtweet['source'] = $tweet_object->source;
                $dbtweet['followers_count'] = $user_object->followers_count;
                $dbtweet['friends_count'] = $user_object->friends_count;
                $dbtweet['statuses_count'] = $user_object->statuses_count;
                $dbtweet['name'] = $user_object->name;
                $dbtweet['in_reply_to_status_id'] = $tweet_object->in_reply_to_status_id_str;
                $dbtweet['in_reply_to_user_id'] = $tweet_object->in_reply_to_user_id_str;
                $dbtweet['profile_image_url'] = $user_object->profile_image_url;

                $this->db->insert('tweets', $dbtweet);


                // Mark the tweet as having been parsed
                $dbparsed['parsed'] = true;
                $this->db->where('cache_id', $cache_id);
                $this->db->update('json_cache', $dbparsed);
            }

            $entities = $tweet_object->entities;
            // The mentions, tags, and URLs from the entities object are also
            foreach ($entities->user_mentions as $user_mention) {
                $entities_param = array(
                    'tweet_id' => $tweet_id,
                    'source_user_id' => $user_id,
                    'target_user_id' => $user_mention->id,
                );
                $ada = $this->db->get_where('tweet_mentions', $entities_param)->row();

                if ( !$row ) {
                    $this->db->insert('tweet_mentions', $entities_param);
                }
            }

            echo $tweet_id . PHP_EOL;
        }
        exit;
    }

    function tweet()
    {

        $cont = true;
        while ($cont) {
            $this->db->limit(100);
            $res = $this->db->get('tweets_bck')->result();

            if ( !$res ) {
                $cont = false;
            }
            $f_tweet_id = array();
            foreach ($res as $r) {
                //check apakah ada tweet tersebut
                $this->db->where('tweet_id', $r->tweet_id);
                $row = $this->db->get('tweets')->row();

                if ( !$row ) {
                    $this->db->where('tweet_id', $r->tweet_id);
                    $this->db->insert('tweets', $r);
                }

                $this->db->where('tweet_id', $r->tweet_id);
                $this->db->delete('tweets_bck');
            }
        }
        exit;
    }

    function users()
    {
        $cont = true;
        while ($cont) {
            $this->db->limit(100);
            $res = $this->db->get('tweet_users2')->result();

            if ( !$res ) {
                $cont = false;
            }

            $f_tweet_id = array();
            foreach ($res as $r) {
                $this->db->where('user_id', $r->user_id);
                $row = $this->db->get('tweet_users')->row();

                if ( !$row ) {
                    $this->db->insert('tweet_users', $r);
                }

                $this->db->where('user_id', $r->user_id);
                $this->db->delete('tweet_users2');
            }
        }
        exit;
    }

    function mentions()
    {
        $cont = true;
        while ($cont) {
            $this->db->limit(100);
            $res = $this->db->get('tweet_mentions_bck')->result();

            if ( !$res ) {
                $cont = false;
            }

            $f_tweet_id = array();
            foreach ($res as $r) {
                $this->db->where('tweet_id', $r->tweet_id);
                $this->db->where('source_user_id', $r->source_user_id);
                $this->db->where('target_user_id', $r->target_user_id);
                $row = $this->db->get('tweet_mentions')->row();

                if ( !$row ) {
                    $this->db->insert('tweet_mentions', $r);
                }

                $this->db->where('tweet_id', $r->tweet_id);
                $this->db->where('source_user_id', $r->source_user_id);
                $this->db->where('target_user_id', $r->target_user_id);
                $this->db->delete('tweet_mentions_bck');
                echo $r->tweet_id . PHP_EOL;
            }
        }
        exit;
    }

    function import()
    {
        $host = '';
        $host = '';
        $host = '';

        $host = 'dbcrawler.ckvsjwlj7gia.ap-southeast-1.rds.amazonaws.com';
        $username = 'thinkweb';
        $password = 'th1nkw3b';
        $db = 'eliana_db';
        $string = 'mysql -h ' . $host . ' -u ' . $username . ' -p' . $password . ' ' . $db . ' < /home/eliana/public_html/dump/tweet_mentions_bck.sql';
        $output = shell_exec($string);
        xdebug($output);
    }

}
