<?php

require_once 'config.php';

$sql = "SELECT * FROM suppliers_products ";
$result = $link->query($sql);

$data = $result->fetch_all();

$link->close();

echo json_encode($data);

?>
