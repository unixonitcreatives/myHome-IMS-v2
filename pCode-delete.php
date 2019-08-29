<?php
session_start();
require_once 'config.php';
$users_id = $_GET['pCode_ID'];
$query = "DELETE from prod_code WHERE pCode_ID='$users_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if ($result){
    header("Location: pCode-manage.php?alert=deletesuccess");
}else {
    echo "Error deleteing record: " . mysqli_error($link);
}
// Close connection
mysqli_close($link);
?>
