<?php

require_once 'config.php';

$suppliers_id = $_POST['suppliers_id'];

$sql = "SELECT suppliers_id, supplier_name FROM suppliers WHERE suppliers_id = $suppliers_id ";
$result = $link->query($sql);

if($result->num_rows > 0) {
 $row = $result->fetch_array();
} // if num_rows

$link->close();

echo json_encode($row);

?>
