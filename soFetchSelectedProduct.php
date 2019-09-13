<?php

require_once 'config.php';

$inv_id = $_POST['inv_id'];

$sql = "SELECT sku_code, retail_price FROM inventory WHERE inv_id = '$inv_id' ";
$result = $link->query($sql);

if($result->num_rows > 0) {
 $row = $result->fetch_array();
} // if num_rows

$link->close();

echo json_encode($row);

?>
