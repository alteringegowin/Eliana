<?php
/**
 * modified by erwin handoko
 * http://twitter.com/bhasunjaya
 */
if ( isset($GLOBALS["HTTP_RAW_POST_DATA"]) ) {


    //the full path such as /home/www/ not url
    $path_upload = '';
    
    // url path to the upload directory path
    // dont forget the trailing slash
    $url_upload = 'http://yourdomain/home/www/';

    //the image file name
    // lebih baik lagi ditambahkan randomize biar ga ketumpukan

    $fileName = time() . '-img.png';

    // get the binary stream
    $im = $GLOBALS["HTTP_RAW_POST_DATA"];

    //process write on our server
    $fp = fopen($path_upload . '/' . $fileName, 'wb');
    fwrite($fp, $im);
    fclose($fp);
    
    //the file url
    echo $url_upload.$fileName;

    //the fileName;
    echo $fileName;
    
    
} else
    echo 'result=An error occured.';