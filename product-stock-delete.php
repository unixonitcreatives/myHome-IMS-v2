<?php
session_start();
require_once 'config.php';
$add_inv_id = $_GET['add_inv_id'];
$query = "DELETE from add_inv WHERE add_inv_id='$add_inv_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if ($result){
    header("Location: product-stocks-update.php?alert=deletesuccess");
}else {
    echo "Error deleteing record: " . mysqli_error($link);
}
// Close connection
mysqli_close($link);
?>
