<?php

include ('config.php');

$get_so_request_id = $_GET['so_request_id'];

if(isset($_POST['updateDeliveryBtn'])){

  $so_delivery_date = $_POST['so_delivery_date'];
  $so_date_delivered = $_POST['so_date_delivered'];

  $query = "UPDATE so_items SET so_delivery_date='$so_delivery_date', so_date_delivered='$so_date_delivered' WHERE so_trans_id='$get_so_request_id'";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));
  if($result){
  echo "updated";
  }else {
    $alertMessage = "<div class='alert alert-success' role='alert'>
    Error updating record.
    </div>";
  }
}



?>
