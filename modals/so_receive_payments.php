<?php
include('../config.php');

//modal variables
$get_customer_id=
$so_receive_payment_date=
$so_paymentMode=
$get_customer_id=
$so_reference_id=
$so_amount_receive="";

//If the form is submitted
if(isset($_POST['receivePaymentBtn'])){
  $get_customer_id                =test_input($_POST['so_trans_id']);
  $so_receive_payment_date        =test_input($_POST['so_receive_payment_date']);
  $so_amount_receive              =test_input($_POST['so_amount_receive']);
  $so_paymentMode                 =test_input($_POST['so_paymentMode']);
  $so_reference_no                =test_input($_POST['so_ref_no']);


  //INSERT query to so_transactions table
  $query = "INSERT INTO so_installments_history (so_trans_id, so_receive_payment_date, so_amount_receive, so_paymentMode, so_ref_no) VALUES ( '$get_customer_id', '$so_receive_payment_date', '$so_amount_receive', '$so_paymentMode',  '$so_reference_no')";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));

  //if result is true
  if($result){
    header("Location: ../SO-manage.php?alert=receive && so_amount_receive = $so_amount_receive ");
  }else {
    echo "Error updating record: " . mysqli_error($link);
  }

  }else {
      echo "Error updating record: " . mysqli_error($link);
  }


    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    // Close connection
    mysqli_close($link);
  ?>
