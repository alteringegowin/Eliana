<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class tweep_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_tweep($user_id)
    {
        return $this->db->get_where('tweet_follow', array('user_id' => $user_id))->row();
    }

    function get_tweep_status($user_id, $offset, $limit)
    {
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

    function get_mention($user_id, $offset, $limit)
    {
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

    function get_top_mention($user_id, $limit=10)
    {
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
            AND m.source_user_id  != ? 
        GROUP BY m.source_user_id
        ORDER BY total DESC
        LIMIT 10
        ";
        return $this->db->query($sql, array($user_id, $user_id))->result();
    }

    function get_top_mentioned($user_id, $limit=10)
    {
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
        WHERE 
            m.source_user_id=? 
            AND u.screen_name IS NOT NULL
            AND m.target_user_id != ? 
        
        GROUP BY m.target_user_id
        ORDER BY total DESC
        LIMIT 10
        ";
        return $this->db->query($sql, array($user_id, $user_id))->result();
    }

    function get_tweet($tweet_id)
    {
        return $this->db->get_where('tweets', array('tweet_id' => $tweet_id))->row();
    }

    function get_retweet($obj)
    {
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

    function count_total_rt_tweep($retweet_data)
    {
        $total = 0;
        foreach ($retweet_data as $r) {
            $total += $r->followers_count;
        }
        return $total;
    }

    function get_cloud_keyword($user_id, $start, $end)
    {
        $RT = $this->get_tweep($user_id);
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

        $forbidden = array($RT->screen_name, 'yang', 'kepada', 'http', 'cont', 'dengan',
            'oleh',
            'kita', 'kamu', 'saya', 'tapi', 'this', 'that', '___');
        $words = $this->process_words($str, $forbidden);

        return array_reverse($words);
    }

    function process_words($text, $forbidden=array(), $min_length=4)
    {
        $index = array();
        $text = str_replace('RT', ' rt ', $text);
        $text = strtolower($text);
        $text = str_replace('tidak ', 'tidak-', $text);
        $tandabaca = array('.', ',', '!', "\r\n", "\n", "\r", '$', '%', '&',
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

        function cmp($a, $b)
        {
            return ($a['count'] > $b['count']) ? +1 : -1;
        }

        if ( $index ) {
            usort($index, "cmp");
            return($index);
        } else {
            return $index;
        }
    }

    function get_reply_list($tweet_id)
    {
        return $this->db->get_where('tweets', array('in_reply_to_status_id' => $tweet_id))->result();
    }

    function get_growth($user_id, $start, $end)
    {
        $sql = "
        SELECT 
            `user_id`,
            `screen_name`,
            date(`created_at`) as tgl,
            MAX(`followers_count`) as followers
        FROM `tweets`
        WHERE 
            `user_id` = ?
            AND created_at BETWEEN ? AND ?
        GROUP BY `tgl` 
        ORDER BY tgl ASC
        ";
        $stats = $this->db->query($sql, array($user_id, $start, $end))->result();
        return $stats;
    }

    function count_retweet_per_tanggal($screen_name, $start, $end)
    {

        $RT = 'RT @' . $screen_name;

        $sql = "
        SELECT 
            DATE(  `created_at` ) AS tanggal, 
            COUNT(  `tweet_id` ) AS tweet, 
            COUNT( DISTINCT  `user_id` ) AS users, 
            SUM(  `followers_count` ) AS followers
        FROM `tweets` 
        WHERE 
            `tweet_text` LIKE '%" . $this->db->escape_like_str($RT) . "%'
            AND `screen_name` != ?
            AND created_at BETWEEN ? AND ?
        GROUP BY tanggal
        ORDER BY tanggal ASC
            
        ";
        $stats = $this->db->query($sql, array($screen_name, $start, $end))->result();
        return $stats;
    }

    function count_retweet($screen_name, $start, $end)
    {

        $RT = 'RT @' . $screen_name;

        $sql = "
        SELECT 
            (
                SELECT 
                    COUNT( tweet_id ) 
                FROM tweets
                WHERE  `screen_name` =  '" . $this->db->escape_str($screen_name) . "'
                AND created_at
                BETWEEN  '" . $this->db->escape_str($start) . "' AND  '" . $this->db->escape_str($end) . "'
            ) AS tweets,
            COUNT(  `tweet_id` ) AS retweets, 
            COUNT( DISTINCT  `user_id` ) AS users, 
            SUM(  `followers_count` ) AS followers
        FROM `tweets` 
        WHERE 
            `tweet_text` LIKE '%" . $this->db->escape_like_str($RT) . " %'
            AND `screen_name` != ?
            AND created_at BETWEEN ? AND ?
            
        ";
        $stats = $this->db->query($sql, array($screen_name, $start, $end))->row();
        return $stats;
    }

    function count_mention($user_id, $start, $end)
    {
        $sql = "
        SELECT 
            count(t.tweet_id) as mentions,
            count(DISTINCT t.user_id) as users,
            MAX(t.created_at) as since,
            MIN(t.created_at) as until
        FROM tweet_mentions m
            LEFT JOIN tweet_users u ON u.user_id=m.source_user_id
            LEFT JOIN tweets t ON t.tweet_id=m.tweet_id
        WHERE m.target_user_id= ?
            AND t.created_at BETWEEN ? AND ?

        ";
        $stats = $this->db->query($sql, array($user_id, $start, $end))->row();
        return $stats;
    }

    function get_user_tweet_by_periode($user_id, $start, $end, $return='result')
    {
        if ( $return == 'query' ) {
            $sql = "
                SELECT t.created_at,t.screen_name,t.tweet_text,t.followers_count,t.sentiment
                FROM tweets t
                WHERE t.user_id = ?
                    AND t.created_at BETWEEN ? AND ?
                ORDER BY t.created_at DESC
            ";
            return $this->db->query($sql, array($user_id, $start, $end));
        } else {
            $sql = "
                SELECT SQL_CALC_FOUND_ROWS * FROM tweets
                WHERE user_id = ?
                    AND created_at BETWEEN ? AND ?
                ORDER BY created_at DESC
            ";
            $r['data'] = $this->db->query($sql, array($user_id, $start, $end))->result();
            $total = $this->db->query('SELECT FOUND_ROWS() as total')->row();
            $r['total'] = $total->total;
            return $r;
        }
    }

    function get_user_mentions_by_periode($user_id, $start, $end, $return='result')
    {
        if ( $return == 'query' ) {
            $sql = "
                SELECT t.created_at,t.screen_name,t.tweet_text,t.followers_count,t.sentiment
                FROM tweet_mentions m 
                    LEFT JOIN tweets t ON t.tweet_id=m.tweet_id
                WHERE m.target_user_id= ?
                    AND created_at BETWEEN ? AND ?
                ORDER BY created_at DESC
            ";
            return $this->db->query($sql, array($user_id, $start, $end));
        } else {
            $sql = "
                SELECT SQL_CALC_FOUND_ROWS * 
                FROM tweet_mentions m 
                    LEFT JOIN tweets t ON t.tweet_id=m.tweet_id
                WHERE m.target_user_id= ?
                    AND created_at BETWEEN ? AND ?
                ORDER BY created_at DESC
            ";
            $r['data'] = $this->db->query($sql, array($user_id, $start, $end))->result();
            $total = $this->db->query('SELECT FOUND_ROWS() as total')->row();
            $r['total'] = $total->total;
            return $r;
        }
    }

}