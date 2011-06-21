<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

/**
 * getting list of day for dropdown
 * @return array 
 */
function list_days() {
    $days[''] = 'D';

    for ($d = 1; $d <= 31; $d++) {
        $day = str_pad($d, 2, '0', STR_PAD_LEFT);
        $days[$day] = $day;
    }

    return $days;
}

/**
 * list month
 * 
 * @return array 
 */
function list_months() {
    return array(
        '' => 'M',
        '01' => 'Jan',
        '02' => 'Feb',
        '03' => 'Mar',
        '04' => 'Apr',
        '05' => 'May',
        '06' => 'Jun',
        '07' => 'Jul',
        '08' => 'Aug',
        '09' => 'Sep',
        '10' => 'Oct',
        '11' => 'Nov',
        '12' => 'Dec'
    );
}

function get_bulan($int_month) {
    $months = list_months();
    return isset($months[$int_month]) ? $months[$int_month] : $int_month;
}

/**
 * outputs an array of the last 100 years
 * 
 * @param int $quantity
 * @return array
 */
function list_years_past($quantity = 100) {
    $years[''] = 'Y';

    for ($y = date('Y'); $y >= date('Y') - $quantity; $y--) {
        $years[$y] = $y;
    }

    return $years;
}

/**
 * outputs an array of the next 10 years
 * 
 * @param int $quantity
 * @return array 
 */
function list_years_future($quantity = 10) {
    $years[''] = 'Y';

    for ($y = date('Y'); $y <= date('Y') + $quantity; $y++) {
        $years[$y] = $y;
    }

    return $years;
}

/**
 * outputs an array of the 24 hours
 * 
 * @return array
 */
function list_hours() {
    $hours[''] = 'Hour';

    for ($h = 1; $h <= 24; $h++) {
        $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
        $hours[$hour] = $hour;
    }

    return $hours;
}

/**
 * outputs an array of the 60 minutes
 * 
 * @return array
 */
function list_minutes() {
    $minutes[''] = 'Minute';

    for ($m = 0; $m <= 60; $m++) {
        $minute = str_pad($m, 2, '0', STR_PAD_LEFT);
        $minutes[$minute] = $minute;
    }

    return $minutes;
}

function date_diffxx($d1, $d2) {
    /* compares two timestamps and returns array with differencies (year, month, day, hour, minute, second)
     */
    //check higher timestamp and switch if neccessary
    if ( $d1 < $d2 ) {
        $temp = $d2;
        $d2 = $d1;
        $d1 = $temp;
    } else {
        $temp = $d1; //temp can be used for day count if required
    }
    $d1 = date_parse($d1);
    $d2 = date_parse($d2);
    //seconds
    if ( $d1['second'] >= $d2['second'] ) {
        $diff['second'] = $d1['second'] - $d2['second'];
    } else {
        $d1['minute']--;
        $diff['second'] = 60 - $d2['second'] + $d1['second'];
    }
    //minutes
    if ( $d1['minute'] >= $d2['minute'] ) {
        $diff['minute'] = $d1['minute'] - $d2['minute'];
    } else {
        $d1['hour']--;
        $diff['minute'] = 60 - $d2['minute'] + $d1['minute'];
    }
    //hours
    if ( $d1['hour'] >= $d2['hour'] ) {
        $diff['hour'] = $d1['hour'] - $d2['hour'];
    } else {
        $d1['day']--;
        $diff['hour'] = 24 - $d2['hour'] + $d1['hour'];
    }
    //days
    if ( $d1['day'] >= $d2['day'] ) {
        $diff['day'] = $d1['day'] - $d2['day'];
    } else {
        $d1['month']--;
        $diff['day'] = date("t", $temp) - $d2['day'] + $d1['day'];
    }
    //months
    if ( $d1['month'] >= $d2['month'] ) {
        $diff['month'] = $d1['month'] - $d2['month'];
    } else {
        $d1['year']--;
        $diff['month'] = 12 - $d2['month'] + $d1['month'];
    }
    //years
    $diff['year'] = $d1['year'] - $d2['year'];
    
    $diff['total'] = ($diff['hour']*60)+($diff['hour']*60*24);
    
    
    return $diff;
}

/* End of file time_helper.php */
/* Location: ./application/helpers/time_helper.php */