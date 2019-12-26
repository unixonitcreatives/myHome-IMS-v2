<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');//unixondev.com
define('DB_USERNAME', 'root');//vipfouuo_myhome
define('DB_PASSWORD', '');//T@Wj+rt_JJlN
define('DB_NAME', 'xacmiyzwof');//vipfouuo_myhomev2

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME) or die("Something Went Wrong" . mysqli_connect_error());

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
