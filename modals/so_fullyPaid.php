<?php
include('../config.php');

$get_customer_id = "";


//If the form is submitted
if(isset($_POST['fullyPaid'])){

  $get_customer_id = $_POST['so_trans_id'];

  //INSERT query to so_transactions table
  $query = "UPDATE so_transactions SET so_paymentTerms = 'Fully Paid' WHERE so_trans_id = '$get_customer_id' ";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));


  //if result is true
  if($result){
  //  $queryUpdate = "UPDATE so_transactions SET so_grand_total = '".$new_grand_total."' WHERE so_trans_id = '".$get_customer_id."' ";
  //$resultUpdate = mysqli_query($link, $queryUpdate) or die(mysqli_error($link));
          //if($resultUpdate){
                  header("Location: ../SO-manage.php?alert=receive");
                  exit();
              //  }else {
                    //  echo "Error updating record: " . mysqli_error($link);
                    //}// /if resultUpdate

  }else {
    echo "Error updating record: " . mysqli_error($link);
  }// /if result

}// /form submitted


  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  // Close connection
  mysqli_close($link);
  ?>
