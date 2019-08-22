<?php

require_once 'config.php';

$sql = "SELECT suppliers_product_id, sup_prod_model FROM suppliers_products ";
$result = $link->query($sql);

$data = $result->fetch_all();

$link->close();

echo json_encode($data);

?>
