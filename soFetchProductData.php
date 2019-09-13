<?php

require_once 'config.php';

$sql = "SELECT inv_id, sku_code FROM inventory";
$result = $link->query($sql);

$data = $result->fetch_all();

$link->close();

echo json_encode($data);

?>
