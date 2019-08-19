<?php

require_once 'config.php';

$suppliers_product_id = $_POST['suppliers_product_id'];

$sql = "SELECT * FROM suppliers_products WHERE $suppliers_product_id = $suppliers_product_id";
$result = $link->query($sql);

if($result->num_rows > 0) {
 $row = $result->fetch_array();
} // if num_rows

$link->close();

echo json_encode($row);

?>
