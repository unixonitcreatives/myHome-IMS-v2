<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', '37.59.55.185');//37.59.55.185
define('DB_USERNAME', 'xAcmiyzWOF'); //xAcmiyzWOF
define('DB_PASSWORD', 'cQZ2tArDGK'); //cQZ2tArDGK
define('DB_NAME', 'xAcmiyzWOF');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME) or die("Something Went Wrong" . mysqli_connect_error());

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
