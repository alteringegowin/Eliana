<?php

class generator extends Controller {

    function __construct() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->helper('date');
    }

    function index() {
        die;
        $r = $this->db->get('_oldnews')->result();
        // id
        // post_title
        // post_url_title
        // post_excerpt
        // post_content
        // post_publish_date
        // post_create_date
        // post_update_date
        // post_author
        // post_status
        // post_parent
        // post_order
        // post_thumbnail
        // post_type
        // category_id

        // id
        // id_status
        // id_cat
        // title
        // lead
        // content
        // thumbnail
        // image
        // rdate
        // masuki 	barui
        $acara_cat[1] = "News";
        $acara_cat[2] = "Event";
        $acara_cat[3] = "Promotions";
        $acara_cat[4] = "Tips";
        $counter = 1;
        foreach ($r as $c) {
            $data = array();
            $data['post_title'] = strip_tags($c->title);
            $data['post_url_title'] = url_title($c->title);
            $data['post_excerpt'] = $c->lead;
            $data['post_content'] = $c->content;
            $data['post_publish_date'] = mysql_to_unix($c->masuki);
            $data['post_create_date'] = mysql_to_unix($c->masuki);
            $data['post_update_date'] = mysql_to_unix($c->masuki);
            $data['post_status'] = $c->id_status;
            $data['post_parent'] = 1;
            $data['post_type'] = strtolower($acara_cat[$c->id_cat]);
            $this->db->insert('posts',$data);
            $counter++;
        }
        echo $counter;
    }

    function product() {
        die('dada');
        $res = $this->db->get('tyres')->result();
        foreach($res as $row) {
            $db = array();
            $db['product_title'] = $row->tyre_title;
            $db['product_excerpt'] = strip_tags($row->tyre_lead);
            $db['product_content'] = $row->tyre_content;
            $db['product_status'] = 1;
            $meta['type'] = $row->cat_id;
            $db['product_meta'] = serialize('type');
            $this->db->insert('products',$db);
        }
    }

    function temp() {
        die;
        $res = $this->db->get('faqs')->result();
        foreach ($res as $r) {
            $db = array();
            $db['faq_created'] = mysql_to_unix($r->barui);
            if($r->masuki) {
                $db['faq_updated'] = mysql_to_unix($r->masuki);
            }
            $this->db->where('id',$r->id);
            $this->db->update('faqs',$db);
        }
    }

    function importcsv() {
        die;
        $this->load->helper('inflector');
        $handle = fopen(FCPATH."toko.csv", "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $image = array();
            if($data[4]) {
                $d = str_replace(" ", "", $data[4]);
                $image[] = trim($d).'.jpg';
            }
            if($data[5]) {
                $d = str_replace(" ", "", $data[5]);
                $image[] = trim($d).'.jpg';
            }
            $db['toko_image'] = serialize($image);
            $this->db->where('id',$data[0]);
            $this->db->update('tokos',$db);
            echo $data[1].' '.count($image).'gbr done<br>';
        }
        fclose($handle);
    }

    /**
     * fungsi untuk memindahkan poto toko ke 1 direktori saja
     */
    function pototoko() {
        die;
        $this->load->helper('inflector');
        $this->load->helper('directory');
        $map = directory_map('./potos/', FALSE, TRUE);
        //xdebug($map);
        foreach($map as $k=>$v) {
            foreach($v as $poto) {
                copy('./potos/'.$k.'/'.$poto,'./poto/'.underscore($poto));
            }
        }

        $map = directory_map('./poto/', FALSE, TRUE);
    }

    /**
     * fungsi untuk memindahkan poto toko ke 1 direktori saja
     */
    function pototoko2() {
        die;
        $this->load->helper('inflector');
        $this->load->helper('directory');
        $map = directory_map('./poto/', FALSE, TRUE);
        foreach($map as $v) {
            $name = str_replace("_", "", $v);
            rename('./poto/'.$v,'./poto/'.$name);
        }

    }

    function importcsvcity() {
        $handle = fopen(FCPATH."kota_epat.csv", "r");
        $sql = '';
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $db['id'] = $data[0];
            $db['city_name'] = $data[1];
            //$this->db->insert('cities',$db);
            
            $where = "id = ".$db['id'];
            $sql .= $this->db->update_string('cities',$db,$where).";\n";
        }
        xdebug($sql);
        fclose($handle);
    }

    function maps() {
        die('x');
        $this->load->library('simplepie');
        $this->simplepie->set_feed_url('http://maps.google.com/maps/ms?ie=UTF8&hl=en&vps=2&jsv=299a&oe=UTF8&msa=0&output=georss&msid=116221373610759425322.000496408438308f90903');
        $this->simplepie->set_cache_location(FCPATH.'/logs');
        $this->simplepie->init();
        $this->simplepie->handle_content_type();

        $data['rss_items'] = $this->simplepie->get_items();

        $c = array();
        foreach($data['rss_items'] as $item) {
            $xid = explode(' ',trim($item->get_title()));
            //if(trim($xid[0]) == '122'){
            $point = explode(' ',trim($item->get_gmap_point()));
            $d['toko_lat'] = $point[0];
            $d['toko_long'] = $point[1];
            //$d['latitude'] = $item->get_channel_tags(SIMPLEPIE_NAMESPACE_GEORSS, 'point');

            $this->db->where('id',$xid[0]);
            $this->db->update('tokos',$d);
            $c[] = $d;
            //}
            xdebug($item);
            die;

        }
        xdebug($data['rss_items']);
    }

    function smallcaps() {
        die;
        $tokos = $this->db->get('tokos')->result();
        foreach($tokos as $r) {
            $db['toko_image'] = strtolower($r->toko_image);
            $this->db->where('id',$r->id);
            $this->db->update('tokos',$db);
        }
    }

    function generate_data_product() {
        $handle = fopen(FCPATH."csv/data_mobil.csv", "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $car['brand_id'] = $data[0];
            $car['vehicle_name'] = $data[2];
            $car['vehicle_created'] = time();
            $this->db->insert('vehicles',$car);
            $car_id = $this->db->insert_id();

            $objects = explode(',',$data[3]);
            foreach($objects as $b) {
                $relation['car_id'] = $car_id;
                $relation['object_id'] = trim($b);
                $this->db->insert('relations',$relation);
            }

            xdebug($data);
        }
        fclose($handle);
    }
    function generate_brands() {
        $handle = fopen(FCPATH."csv/data_brands.csv", "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $car['brand_name'] = $data[1];
            $this->db->insert('brands',$car);
            xdebug($data);
        }
        fclose($handle);
    }

    function tokosimage() {
        $tokos = $this->db->get('tokos')->result();
        foreach($tokos as $r) {
            $images = unserialize($r->toko_image);
            foreach($images as $img) {
                if(!file_exists (FCPATH.'poto/'.$img)) {
                    echo ' NOT FOUND : <b>' .$img.'</b><br>';
                }
            }

        }
    }

    function tokosmaps() {
        $tokos = $this->db->get('tokos')->result();
        foreach($tokos as $r) {
            if(!$r->toko_lat) {
                echo ' NOT FOUND ON MAP : <b>' .$r->toko_name.'</b><br>';
            }
        }
    }


}




