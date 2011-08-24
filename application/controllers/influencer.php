<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

/**
 * this is the property of user that we follow
 */
class Influencer extends CI_Controller {

    protected $tpl;
    protected $profile;

    /**
     * @todo check kalo uri_segment 3 ga ada...
     */
    function __construct() {
        parent::__construct();
        $this->load->helper('time');
        $this->tpl = array();
        $this->tpl['content'] = '';
        $this->tpl['tweep'] = $this->profile;
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }
    }

    function index($screen_name = '') {
        $names = array(
            'faktanyaadalah',
            'faktacowok',
            'cumannanya',
            'mentionke',
            'vincentrompies'
        );
        $this->db->where_in('screen_name', $names);
        $res = $this->db->get('tweet_follow')->result();
        foreach ($res as $row) {
            $this->_get($row);
        }
    }

    function _get($row) {
        $user_id = $row->user_id;
        $sql = "SELECT
        t.name,t.screen_name,t.followers_count,t.tweet_text
        FROM tweets t
        WHERE t.user_id = ?
        AND t.tweet_text LIKE '%guinnesspool%'";
        $res = $this->db->query($sql, array($user_id))->result();

        $imp_influencer = 0;
        foreach ($res as $r) {
            $imp_influencer += $r->followers_count;
        }

        $sql = "
        SELECT 
        t.name,t.screen_name,t.followers_count,t.tweet_text
        FROM tweet_mentions tm 
        LEFT JOIN tweets t ON t.tweet_id=tm.tweet_id
        WHERE tm.target_user_id=?
        AND t.tweet_text LIKE '%#guinnesspool%'
        AND t.tweet_text NOT LIKE '@%'
        ";
        $res2 = $this->db->query($sql, array($user_id))->result();

        $imp_follower = 0;
        foreach ($res2 as $r) {
            $imp_follower += $r->followers_count;
        }
        echo '<div style="border:solid 1px #ccc;padding:4px;margin:4px;">';
        echo '<h2>' . $row->screen_name . '</h2>';
        echo '<h3>Total Tweet Influencer : ' . count($res) . '</h3>';
        echo '<h3>Total Impresion Influencer only : ' . $imp_influencer . '</h3>';
        echo '<h3>Total Impression From RT only : ' . $imp_follower . '</h3>';
        echo '<h3>Total Impression From this influencer : ' . ($imp_follower + $imp_influencer) . '</h3>';
        echo '</div>';
    }

}
