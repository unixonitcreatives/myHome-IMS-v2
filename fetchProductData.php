<?php

require_once 'config.php';

$sql = "SELECT * FROM inventory";
$result = $link->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);

?>
