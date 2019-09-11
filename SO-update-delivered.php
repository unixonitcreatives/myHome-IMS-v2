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
$alertMessage=$so_model=$so_qty=$so_unit=$so_unit_price=$so_total_amount=$so_date_delivered="";

require_once "config.php";

$so_request_id = $_GET['so_request_id'];
$query = "SELECT * from so_items WHERE so_request_id='$so_request_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
    $so_model = $row['so_model'];
    $so_qty   = $row['so_qty'];
    $so_unit  = $row['so_unit'];
    $so_unit_price  = $row['so_unit_price'];
    $so_total_amount  = $row['so_total_amount'];
    $so_date_delivered  = $row['so_date_delivered'];

    }
}else {
    $alertMessage="<div class='alert alert-danger' role='alert'>Theres Nothing to see Here.</div>";
}
//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Assigning posted values to variables.
    $so_trans_id        = test_input($_POST['so_trans_id']);
    $so_model           = test_input($_POST['so_model']);
    $so_qty             = test_input($_POST['so_qty']);
    $so_unit            = test_input($_POST['so_unit']);
    $so_unit_price      = test_input($_POST['so_unit_price']);
    $so_total_amount    = test_input($_POST['so_total_amount']);
    $so_date_delivered  = test_input($_POST['so_date_delivered']);


    // Check if input has no errors before inserting in database
    if(empty($emptyMessage)){
    //Checking the values are existing in the database or not
    $query = "UPDATE so_items SET so_trans_id='$so_trans_id', so_model='$so_model', so_qty='$so_qty', so_unit='$so_unit', so_unit_price='$so_unit_price', so_total_amount='$so_total_amount', so_date_delivered='$so_date_delivered' WHERE so_request_id='$so_request_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Stocks data successfully updated in database.
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
<title>MyHome | SO Delivered Qty</title>
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
        SO Delivered Qty
        <small></small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="content">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">SO Delivered Qty</h3>
              <br><a href="SO-manage.php" class="text-center">View SO</a>

            </div>
            <?php echo $alertMessage; ?>
            <!-- /.box-header -->

              <div class="box-body">
                <div class="row">
                  <!-- form start -->
                  <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?so_request_id=<?php echo $so_request_id; ?>">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="hidden" class="form-control" placeholder="so trans id" name="so_trans_id" value="<?php echo $so_trans_id; ?>" disabled>
                      </div>
                      <div class="form-group">
                        <label>Model</label>
                        <input type="text" class="form-control" placeholder="Model" name="so_model" value="<?php echo $so_model; ?>" disabled>
                      </div>
                      <div class="form-group">
                        <label>Qty</label>
                        <input type="number" class="form-control" placeholder="Qty" name="so_qty" value="<?php echo $so_qty; ?>" disabled>
                      </div>
                      <div class="form-group">
                        <label>Unit</label>
                        <input type="text" class="form-control" placeholder="Unit" name="so_unit" value="<?php echo $so_unit; ?>" disabled>
                      </div>
                      <div class="form-group">
                        <label>Unit Price</label>
                        <input type="number" class="form-control" placeholder="Unit Price" name="so_unit_price" value="<?php echo $so_unit_price; ?>" disabled>
                      </div>
                      <div class="form-group">
                        <label>Total Amount</label>
                        <input type="number" class="form-control" placeholder="Total Amount" name="so_total_amount" value="<?php echo $so_total_amount; ?>" disabled>
                      </div>
                      <div class="form-group">
                        <label>Date Delivered</label>
                        <input type="date" class="form-control" placeholder="date" name="so_delivered_date">
                      </div>
                    </div>
                  </div>

                <div class="box-footer">
                  <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" >Save</button>
                </div>
              </div>
            </form>
          </div>
            <!-- /.box-body -->
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
