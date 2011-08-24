<?php

/**
 * Mencari jumlah retweet
 * 
 * @param string $text
 * @param string $screen_name
 * @return int 
 */
function count_retweeted($text, $screen_name, $user_id='', $date='') {
    $ci = & get_instance();
    $text = character_limiter($text, 30, '');
    $RT = 'RT @' . $screen_name;
    $matchstr = $ci->db->escape_like_str($RT) . "%" . $ci->db->escape_like_str($text);
    $sql = "
    SELECT 
        COUNT( tweets.tweet_id ) AS total
    FROM tweet_mentions
        LEFT JOIN tweets ON tweets.tweet_id = tweet_mentions.tweet_id ";
    if ( $user_id ) {
        $sql .= " AND tweet_mentions.target_user_id=" . $user_id;
    }

    $sql .= " 
        WHERE 
            tweets.tweet_text  LIKE '%" . $matchstr . "%'
            AND created_at BETWEEN '$date' AND DATE_ADD('$date', INTERVAL 3 DAY);
    ";
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