<?php
session_start();
require_once 'config.php';
$so_trans_id = $_GET['so_trans_id'];
$query = "DELETE from so_transactions WHERE so_trans_id='$so_trans_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if ($result){
    header("Location: SO-manage.php?alert=deletesuccess");
}else {
    echo "Error deleteing record: " . mysqli_error($link);
}
// Close connection
mysqli_close($link);
?>
