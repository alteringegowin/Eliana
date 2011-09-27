<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Keyword extends CI_Controller
{

    protected $tpl;

    function __construct()
    {
        parent::__construct();
        if ( !$this->session->userdata('is_login') ) {
            redirect('auth/login');
        }

        $this->tpl = array();
        $this->tpl['breadcrumbs'][] = anchor('','Dashboard');
        $this->tpl['content'] = '';
        $this->load->model('keyword_model', 'keyword');
    }

    function index($offset=0)
    {
        $this->load->helper('date');
        $this->db->order_by('keyword');
        $keywords = $this->db->get('tweet_keywords')->result();
        
        $this->tpl['keywords'] = $keywords;
        $this->tpl['breadcrumbs'][] = 'Keywords';
        $this->tpl['content'] = $this->load->view('keyword/default', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    /**
     * Menghitung total tweet based on keyword and periode
     * @deprecated
     */
    function count_tweet()
    {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        echo json_encode($this->keyword->count_tweet($keyword, $start, $end));
    }

    /**
     * Menghitung total user participated based on keyword and periode
     */
    function count_user()
    {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $this->tpl['data'] = $this->keyword->count_user($keyword, $start, $end);
        $this->load->view('keyword_count_user', $this->tpl);
    }

    /**
     * menghasilkan cloud
     */
    function get_cloud()
    {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $keywords = $this->keyword->get_cloud($keyword, $start, $end);
        $this->load->library('wordcloud');
        $tags = array_slice($keywords, 0, 50);
        foreach ($tags as $r) {
            $this->wordcloud->addWord($r['word'], $r['count']);
        }
        $this->tpl['cloud'] = $this->wordcloud->showCloud();
        $this->load->view('keyword_cloud', $this->tpl);
    }

    /**
     * Menghitung statistic
     */
    function get_statistic()
    {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $this->tpl['stats'] = $this->keyword->get_statistic($keyword, $start, $end);
        $this->load->view('keyword_statistic', $this->tpl);
    }

    function get_freq()
    {
        $keyword = $this->input->post('keyword', 1);
        $start = $this->input->post('start', 1);
        $end = $this->input->post('end', 1);
        $this->tpl['freq'] = $this->keyword->get_freq($keyword, $start, $end);
        $this->load->view('keyword_statistic', $this->tpl);
    }

    function archieve($keyword_id=0)
    {
        $this->load->helper('form');
        $start = $this->uri->segment(4, date('Y-m-d'));
        $end = $this->uri->segment(5, date('Y-m-d'));
        $keyword = $this->keyword->get_keyword($keyword_id);

        $this->session->set_userdata('keyword', $keyword->keyword);

        $param['keyword'] = $keyword->keyword;
        $param['start'] = $start;
        $param['end'] = $end;
        $searchs = $this->keyword->search_keyword($param);

        $this->tpl['keyword_id'] = $keyword_id;
        $this->tpl['keyword'] = $keyword->keyword;
        $this->tpl['searchs'] = $searchs;
        $this->tpl['styles'][] = 'css/wordcloud.css';
        $this->tpl['styles'][] = 'css/visualize.css';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.js';
        $this->tpl['javascripts'][] = 'js/jquery.visualize.tooltip.js';
        $this->tpl['javascripts'][] = 'js/keyword.archieve.js';
        $this->tpl['content'] = $this->load->view('keyword_archieve', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

    function download($start, $end)
    {
        $keyword = $this->session->userdata('keyword');
        if ( $start && $end ) {
            $this->load->helper('download');
            $sql = "
                SELECT  
                    created_at,screen_name,tweet_text,name,followers_count
                FROM tweets 
                WHERE tweet_text  LIKE '%" . $this->db->escape_like_str($keyword) . "%'
                    AND created_at BETWEEN ? AND ?
                ORDER BY created_at DESC
                ";
            $this->load->dbutil();
            $query = $this->db->query($sql, array($start, $end));
            $csvdata = $this->dbutil->csv_from_result($query);
            $filename = $keyword . ' from ' . $start . ' sd ' . $end;
            force_download(url_title($filename) . '.csv', $csvdata);
        }
    }

    function user($user_id, $start, $end)
    {
        $keyword = $this->session->userdata('keyword');

        $sql = "
        SELECT
            t.created_at, t.screen_name, 
            t.tweet_text, 
            t.name, 
            t.followers_count,
            tu.profile_image_url
        FROM tweets t
            LEFT JOIN tweet_users tu ON tu.user_id=t.user_id
        WHERE 
            t.tweet_text LIKE '%" . $this->db->escape_like_str($keyword) . "%'
            AND t.created_at BETWEEN ? AND ?
            AND t.user_id = ?
        ORDER BY t.created_at DESC
        ";
        $results = $this->db->query($sql, array($start, $end, $user_id))->result();
        $this->tpl['tweets'] = $results;
        $this->tpl['content'] = $this->load->view('keyword_user', $this->tpl, true);
        $this->load->view('body', $this->tpl);
    }

}
