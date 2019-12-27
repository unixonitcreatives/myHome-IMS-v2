<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'xacmiyzwof');*/

define('DB_SERVER', 'unixondev.com');//unixondev.com
define('DB_USERNAME', 'vipfouuo_myhome');//vipfouuo_myhome
define('DB_PASSWORD', 'T@Wj+rt_JJlN');//T@Wj+rt_JJlN
define('DB_NAME', 'vipfouuo_myhomev2');//vipfouuo_myhomev2

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME) or die("Something Went Wrong" . mysqli_connect_error());

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
