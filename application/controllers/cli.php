<?php

class Cli extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('tweep');
        if ( !$this->input->is_cli_request() ) {
            die('cli only');
        }
    }

    function eliana_get_tweet()
    {
        $res = $this->db->query('SELECT keyword FROM tweet_keywords')->result();
        $keyword = array();
        foreach ($res as $r) {
            $keyword[] = $r->keyword;
        }

        $res = $this->db->query('SELECT screen_name FROM tweet_follow')->result();
        $users = array();
        foreach ($res as $r) {
            $keyword[] = $r->screen_name;
        }

        $this->load->library('consumer');
        $this->consumer->setTrack($keyword);
        $this->consumer->consume();
    }

    function eliana_process_tweet()
    {
        while (true) {
            // Process all new tweets
            $query = 'SELECT cache_id, raw_tweet ' .
                'FROM json_cache WHERE NOT parsed LIMIT 100';
            $result = $this->db->query($query)->result_array();
            foreach ($result as $row) {
                $cache_id = $row['cache_id'];

                // Gather tweet data from the JSON object
                // $oDB->escape() escapes ' and " characters, and blocks characters that
                // could be used in a SQL injection attempt

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
            }

            $this->db->where('parsed', 1);
            $this->db->delete('json_cache');
            $this->db->query('OPTIMIZE TABLE  json_cache');

            // You can adjust the sleep interval to handle the tweet flow and 
            // server load you experience
            sleep(5);
        }
    }

    function eliana_monitor()
    {
        while (true) {
            $this->db->where('process', 'eliana_get_tweet');
            $r = $this->db->get('processes')->row();
            $output = array();
            $output2 = array();
            if ( $r->pid ) {
                $command = 'ps ' . $r->pid;
                exec($command, $output);
            }
            if ( count($output) < 2 ) {

                //kirim email
                $this->load->library('email');
                $this->email->from('no-reply@eliana.listentelligence.com', 'Admin');
                $this->email->to('bhasunjaya@gmail.com');
                $this->email->cc('mega@think.web.id');

                $this->email->subject('[ELIANA] Down at ' . date('Y-m-d H:i:s'));
                $this->email->message('yes.. its down brother');
                $this->email->send();

                //try to restart the service
                $output = `php index.php cli eliana_get_tweet > /dev/null 2>&1 & echo $!`;
                if ( $output ) {
                    $db['pid'] = $output;
                    $this->db->where('process', 'eliana_get_tweet');
                    $this->db->update('processes', $db);
                }
                
                $output = `php index.php cli eliana_process_tweet > /dev/null 2>&1 & echo $!`;
                if ( $output2 ) {
                    $db['pid'] = $output;
                    $this->db->where('process', 'eliana_process_tweet');
                    $this->db->update('processes', $db);
                }
                sleep(10);
            }
            sleep(60);
        }
    }

}
