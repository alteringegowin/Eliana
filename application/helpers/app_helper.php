<?php

function create_pagination($segment, $total, $limit, $uri_segment) {
    $CI = & get_instance();
    $CI->load->library('pagination');

    $config['base_url'] = site_url($segment);
    $config['total_rows'] = $total;
    $config['per_page'] = $limit;
    $config['uri_segment'] = $uri_segment;

    $CI->pagination->initialize($config);

    return $CI->pagination->create_links();
}

function sentiment($sentiment) {
    switch ($sentiment)
    {
        case 'p':
            return 'positif';
            break;
        case 'm':
            return 'negatif';
            break;
        case 'a':
            return 'asking';
            break;
        case 'n':
            return 'netral';
            break;

        default:
            return '-';
            break;
    }
}