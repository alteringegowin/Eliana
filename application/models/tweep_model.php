<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class tweep_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_tweep($user_id) {
        return $this->db->get_where('tweet_follow', array('user_id' => $user_id))->row();
    }

    function get_tweep_status($user_id, $offset, $limit) {
        $sql = "
        SELECT SQL_CALC_FOUND_ROWS * FROM tweets
        WHERE user_id = ?
        AND tweet_text NOT LIKE '@%'
        ORDER BY created_at DESC
        LIMIT $offset,$limit 
        ";
        $r['data'] = $this->db->query($sql, array($user_id))->result();
        $total = $this->db->query('SELECT FOUND_ROWS() as total')->row();
        $r['total'] = $total->total;
        return $r;
    }

    function get_mention($user_id, $offset, $limit) {
        $sql = "
        SELECT SQL_CALC_FOUND_ROWS * 
            
        FROM tweet_mentions m 
            LEFT JOIN tweets t ON t.tweet_id=m.tweet_id
        WHERE m.target_user_id= ?
        ORDER BY created_at DESC
        LIMIT $offset,$limit 
        ";
        $r['data'] = $this->db->query($sql, array($user_id))->result();
        $total = $this->db->query('SELECT FOUND_ROWS() as total')->row();
        $r['total'] = $total->total;
        return $r;
    }

    function get_top_mention($user_id, $limit=10) {
        $sql = "
        SELECT 
            m.source_user_id,
            u.screen_name,
            u.profile_image_url,
            u.description,
            u.followers_count,
            count(*) as total 
        FROM tweet_mentions m
            LEFT JOIN tweet_users u ON u.user_id=m.source_user_id
        WHERE m.target_user_id=?
        GROUP BY m.source_user_id
        ORDER BY total DESC
        LIMIT 10
        ";
        return $this->db->query($sql, array($user_id))->result();
    }

    function get_top_mentioned($user_id, $limit=10) {
        $sql = "
        SELECT 
            m.target_user_id,
            u.screen_name,
            u.profile_image_url,
            u.description,
            u.followers_count,
            count(*) as total 
        FROM tweet_mentions m
            LEFT JOIN tweet_users u ON u.user_id=m.target_user_id
        WHERE m.source_user_id=? AND u.screen_name IS NOT NULL
        GROUP BY m.target_user_id
        ORDER BY total DESC
        LIMIT 10
        ";
        return $this->db->query($sql, array($user_id))->result();
    }

    function get_tweet($tweet_id) {
        return $this->db->get_where('tweets', array('tweet_id' => $tweet_id))->row();
    }

    function get_retweet($obj) {
        $text = $obj->tweet_text;
        $screen_name = $obj->screen_name;
        $text = character_limiter($text, 30, '');
        $RT = 'RT @' . $screen_name;
        $sql = "
    SELECT * 
    FROM tweets 
    WHERE tweet_text  LIKE '%" . $this->db->escape_like_str($RT) . "%" . $this->db->escape_like_str($text) . "%'";
        $row = $this->db->query($sql)->result();
        return $row;
    }

    function count_total_rt_tweep($retweet_data) {
        $total = 0;
        foreach ($retweet_data as $r) {
            $total += $r->followers_count;
        }
        return $total;
    }

    function get_cloud_keyword($user_id, $start, $end) {
        $sql = "
        SELECT 
        tweet_text
        FROM `tweets` 
        
        WHERE 
            user_id = ?
            AND created_at BETWEEN ? AND ?
        ";

        $stats = $this->db->query($sql, array($user_id, $start, $end))->result();
        $str = '';
        foreach ($stats as $r) {
            $str .= " " . $r->tweet_text;
        }

        $words = $this->process_words($str);

        return array_reverse($words);
    }

    function process_words($text, $forbidden=array(), $min_length=4) {
        $index = array();
        $forbidden = array('yang', 'kepada', 'http', 'cont', 'dengan', 'oleh',
            'kita', 'kamu', 'saya', 'tapi'
        );
        $text = str_replace('RT', ' rt ', $text);
        $text = strtolower($text);
        $text = str_replace('tidak ', 'tidak-', $text);
        $tandabaca = array('.', ',', '!', "\r\n", "\n", "\r", '$', '%','&',
            '^', ')', '(', '+', '|', ':', ';', '/', '?', '=', "\""
        );
        $text = str_replace($tandabaca, ' ', $text);
        $text = str_replace($forbidden, ' ', $text);

        $text = str_replace('@', ' @', $text);
        $text = str_replace('#', ' #', $text);

        $text = strip_tags($text);

        $text = explode(' ', $text);
        natcasesort($text);
        $i = 0;
        foreach ($text as $word) {
            $string = trim($word);
            if ( (!empty($string)) && ($string != '') && (strlen($string) >= $min_length) ) {
                if ( !isset($index[$i]['word']) ) { // if not set this is a new index
                    $index[$i]['word'] = $string;
                    $index[$i]['count'] = 1;
                } elseif ( $index[$i]['word'] == $string ) {  // count repeats
                    $index[$i]['count'] += 1;
                } else { // else this is a different word, increment $i and create an entry
                    $i++;
                    $index[$i]['word'] = $string;
                    $index[$i]['count'] = 1;
                }
            }
        }

        function cmp($a, $b) {
            return ($a['count'] > $b['count']) ? +1 : -1;
        }

        if ( $index ) {

            usort($index, "cmp");
            return($index);
        } else {
            return $index;
        }
    }

}