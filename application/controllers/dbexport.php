<?php

class Dbexport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('download');
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }
        
    }

    function index($user_id) {
        $sql = "
        SELECT * FROM tweets 
        WHERE user_id=?
        ORDER BY created_at
        ";

        $fields = $this->db->list_fields('tweets');
        $res = $this->db->query($sql, array($user_id))->result();
        foreach ($res as $r) {
            foreach ($fields as $f) {
                $db[$f] = $r->$f;
            }
            $s[] = $this->db->insert_string('tweets_import', $db);
        }

        echo implode(";\n", $s);
    }

    function keyword() {
        $this->load->helper('download');
        /*
        $this->db->or_like('tweet_text', 'pokkaindonesia');
        $this->db->or_like('tweet_text', 'the junction bali');
        $this->db->or_like('tweet_text', 'freshonastick');
        */
        //$this->db->or_like('tweet_text', 'magnumroadcafe');
        //$this->db->or_like('tweet_text', 'guinnesspool');
        
        /*
        $this->db->or_like('tweet_text', 'mandirifiesta');
        $this->db->or_like('tweet_text', 'wallsbuavita');
        $this->db->or_like('tweet_text', 'MagnumRoadCafeSBY');
        $this->db->or_like('tweet_text', 'GuinnessMusic');
        $this->db->or_like('tweet_text', 'DapurPeduli');
        $this->db->or_like('tweet_text', 'ptc3words');
        $this->db->or_like('tweet_text', 'ABCDapurPeduli');
        $this->db->or_like('tweet_text', 'PTCblog');
         * 
         */
        //$this->db->limit(2000,2000);
        $res = $this->db->get('tweets')->result();

        $fields = $this->db->list_fields('tweets');
        foreach ($res as $r) {
            foreach ($fields as $f) {
                $db[$f] = $r->$f;
            }
            $s[] = $this->db->insert_string('tweets_keyword_backup', $db);
        }
        $data = implode(";\n", $s);
        $name = 'tweets_keyword_backup.sql';

        force_download($name, $data);
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
    
    
    function test(){
        $this->load->helper('tweep');
        $this->db->limit(30);
        $this->db->order_by('created_at','DESC');
        $this->db->where('screen_name','lalights');
        $res = $this->db->get('tweets')->result();
        foreach($res as $r){
            $cRT = count_retweeted($r->tweet_text, $r->screen_name, $r->user_id);
            xdebug($cRT);
        }
        
    }

}