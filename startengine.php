<?php
// Kill any jobs that might be left hanging
$kill = "kill -9 `ps -ef |grep get_tweets.php|grep -v grep | awk '{print $2}'`";
exec($kill);
// Start and register jobs
require_once('./140dev_config.php');
require_once('./db_lib.php');

$oDB = new db;

//process
$output = `php get_tweets.php > /dev/null 2>&1 & echo $!`;
$oDB->update('processes', 'pid = ' . $output, 'process= \'get_tweets.php\'');


$kill = "kill -9 `ps -ef |grep parse_tweets.php|grep -v grep | awk '{print $2}'`";
exec($kill);
$output = `php parse_tweets.php > /dev/null 2>&1 & echo $!`;
$oDB->update('processes', 'pid = ' . $output, 'process= \'parse_tweets.php\'');

echo 'runing';
