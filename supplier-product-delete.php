<?php
session_start();
require_once 'config.php';
$get_suppliers_id = $_GET['suppliers_product_id'];

$query = "DELETE from suppliers_products WHERE suppliers_product_id = '$get_suppliers_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if ($result){
    header("Location: supplier-manage.php?alert=deletesuccess");
}else {
    echo "Error deleteing record: " . mysqli_error($link);
}
// Close connection
mysqli_close($link);
?>
