<?php

require_once 'config.php';

$inv_id = $_POST['inv_id'];

$sql = "SELECT * FROM inventory WHERE inv_id = $inv_id";
$result = $link->query($sql);

if($result->num_rows > 0) {
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>
