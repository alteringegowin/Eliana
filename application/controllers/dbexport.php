<?php

class Dbexport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('download');
    }

    function index() {
        $res = $this->db->get('tweet_follow')->result();
        foreach ($res as $r) {
            echo anchor('dbexport/dl/' . $r->screen_name, 'tweets');
            echo ' | ';
            echo anchor('dbexport/mentions/' . $r->user_id . '/' . $r->screen_name, 'mention');
            echo ' &nbsp;&nbsp;&nbsp;' . $r->screen_name . ' ';
            echo '<br />';
        }
    }

    function dl($screen_name='acerID') {
        $this->db->where('screen_name', 'acerID');
        $query = $this->db->get('tweets');
        $csv = $this->dbutil->csv_from_result($query);
        force_download($screen_name . '.csv', $csv);
    }

    function mentions($user_id, $screen) {
        $sql = "
            SELECT DISTINCT t.* 
            FROM tweet_mentions tm 
                LEFT JOIN tweets t ON t.tweet_id = tm.tweet_id
            WHERE tm.target_user_id = ?
        ";
        $query = $this->db->query($sql, array($user_id));
        $csv = $this->dbutil->csv_from_result($query);
        force_download('mention-' . $screen . '.csv', $csv);
    }

}