<?php

/**
 * Mencari jumlah retweet
 * 
 * @param string $text
 * @param string $screen_name
 * @return int 
 */
function count_retweeted($text, $screen_name) {
    $ci = & get_instance();
    $text = character_limiter($text, 30, '');
    $RT = 'RT @' . $screen_name;
    $sql = "
    SELECT count(*) as total
    FROM tweets 
    WHERE tweet_text  LIKE '%" . $ci->db->escape_like_str($RT) . "%" . $ci->db->escape_like_str($text) . "%'";
    $row = $ci->db->query($sql)->row();
    if ( isset($row->total) ) {
        return $row->total;
    } else {
        return 0;
    }
}

function count_reply($tweet_id='75512205222739968') {
    $ci = & get_instance();
    $sql = "
        SELECT 
            count(tweet_id) as total, 
            max(created_at ) as last, 
            min(created_at) as first
        FROM tweets 
        WHERE in_reply_to_status_id = ?
        GROUP BY in_reply_to_status_id
        ";
    return $ci->db->query($sql, array($tweet_id))->row();
}