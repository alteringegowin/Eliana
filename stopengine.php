<?php

//$kill = "kill -9 `ps -ef |grep yourtwapperkeeper|grep -v grep | awk '{print $2}'`";
//exec($kill);
// Start and register jobs


require_once('./140dev_config.php');
require_once('./db_lib.php');

$oDB = new db;
// Process all new tweets
$query = 'SELECT * FROM processes';
$result = $oDB->select($query);
while ($row = mysqli_fetch_assoc($result)) {
    $output = shell_exec('kill -9 ' . $row['pid']);
}
echo "stoped";
