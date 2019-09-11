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
$inv_id=$sku_code=$addSuccess=$users_id=$alertMessage=$emptyMessage=$category=$subCategory=$branch=$pCode=$model=$poNum=$qty=$srp=$date=$remarks="";

require_once "config.php";

$inv_id = $_GET['inv_id'];
$sku_code = $_GET['sku_code'];

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
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
      header("Location: product-manage.php?alert=success");
      exit();
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
  <title>MyHome | Stock Qty</title>
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
          Add Stock Qty
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
        <!-- general form elements -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Add Stock Qty from <?php echo $sku_code; ?></h3>
            <br><a href="product-manage.php" class="text-center">View Stocks</a>

          </div>
          <?php echo $alertMessage; ?>
          <!-- /.box-header -->

          <div class="box-body">
            <div class="row">
              <!-- form start -->
              <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="inv_id" value="<?php echo $inv_id; ?>">
                </div>

                <div class="form-group">
                  <label>PO Number</label>
                  <select class="form-control select2" style="width: 100%;" name="po_number">
                    <option value="">~~SELECT~~</option>
                    <?php

                    $query = "select po_trans_id from po_transactions order by po_trans_id desc";
                    $result = mysqli_query($link, $query);


                    while ($row = mysqli_fetch_assoc($result)) { ?>
                      <option value="<?php echo $row['po_trans_id']; ?>"><?php echo $row['po_trans_id']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Quantity</label>
                  <input type="number" class="form-control" placeholder="Quantity" name="qty">
                </div>

                <div class="form-group">
                  <label>Date Recieve</label>
                  <input type="date" class="form-control" placeholder="Date Receive" name="date_receive" id="pfDate" >
                </div>
              </div>
            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" >Save</button>
            </div>
          </div>
        </form>
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
