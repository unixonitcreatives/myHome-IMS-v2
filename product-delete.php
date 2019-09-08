<?php
session_start();
require_once 'config.php';
$inv_id = $_GET['inv_id'];
$query = "DELETE from inventory WHERE inv_id='$inv_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if ($result){
    header("Location: product-manage.php?alert=deletesuccess");
}else {
    echo "Error deleteing record: " . mysqli_error($link);
}
// Close connection
mysqli_close($link);
?>
