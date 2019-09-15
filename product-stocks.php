<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 0;
$Accounting_auth = 0;
include('template/user_auth.php');
?>
<!-- ======================= UPDATE  =================== -->
<?php
$inv_id=$addSuccess=$users_id=$alertMessage=$emptyMessage=$category=$subCategory=$branch=$pCode=$model=$poNum=$qty=$srp=$date=$remarks="";

require_once "config.php";

$inv_id = $_GET['inv_id'];

//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //Assigning posted values to variables
  $inv_id       = test_input($_POST['inv_id']);
  $poNum        = test_input($_POST['po_number']);
  $qty          = test_input($_POST['qty']);
  $date         = test_input($_POST['date_receive']);


  // Validation
  if (empty($poNum)){
    $emptyMessage = "Please enter a po-number.";
  }
  if (empty($qty)){
    $emptyMessage = "Please enter a qty.";
  }
  if (empty($date)){
    $emptyMessage = "Please enter a date recieve.";
  }



  // Check if input has no errors before inserting in database
  if(empty($emptyMessage)){
    //Checking the values are existing in the database or not
    $query = "INSERT INTO add_inv (inv_id, add_inv_po_number, add_inv_qty, add_inv_date_arriv) VALUES ('$inv_id', '$poNum', '$qty', '$date')";
    $insert_result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
      $alertMessage = "<div class='alert alert-success' role='alert'>
      Stocks data successfully added in database.
      </div>";
    }else {
      $alertMessage = "<div class='alert alert-success' role='alert'>
      Error updating record.
      </div>";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>
<!-- ======================================================= -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Stock Update</title>
  <!-- ======================= CSS ================================= -->
  <?php include('template/css.php'); ?>
</head>
<body class="hold-transition skin-green fixed sidebar-mini">
  <div class="wrapper">

    <!-- ======================= MENU BAR =========================== -->
    <?php include('template/menu-bar.php'); ?>
    <!-- ======================= SIDEBAR ============================ -->
    <?php include('template/sidebar-manage.php'); ?>
    <!-- ======================== HEADER CONTENT ==================== -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Stock Update
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
        <!-- general form elements -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Stock History</h3>
            <br><a href="product-manage.php" class="text-center">View Stocks</a>

          </div>
          <?php echo $alertMessage; ?>
          <!-- /.box-header -->

          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">PO Number</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Qty</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Date Received</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Attempt select query execution
                  $query = "SELECT * from add_inv WHERE inv_id='$inv_id'";
                  if($result = mysqli_query($link, $query)){
                    if(mysqli_num_rows($result) > 0){

                      while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>" . $row['add_inv_po_number'] . "</td>";
                        echo "<td>" . $row['add_inv_qty'] . "</td>";
                        echo "<td>" . $row['add_inv_date_arriv'] . "</td>";
                        echo "<td>";
                        echo "&nbsp; <a href='product-stock-update.php?add_inv_id=". $row['add_inv_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                        echo "&nbsp; <a href='product-stock-delete.php?add_inv_id=". $row['add_inv_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                        echo "</td>";
                        echo "</tr>";
                      }

                      // Free result set
                      mysqli_free_result($result);
                    } else{
                      echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                  } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                  }

                  // Close connection
                  mysqli_close($link);
                  ?>
                </tbody>
              </table>
              </div>
            </div>
          </section>
          <!-- /.content-wrapper -->
        </div>
        <!-- =========================== MODAL =========================== -->


        <!-- =========================== FOOTER =========================== -->
        <footer class="main-footer">
          <?php include('template/footer.php'); ?>
        </footer>


        <!-- =========================== JAVASCRIPT ========================= -->
        <?php include('template/js.php'); ?>


      </body>
      </html>
