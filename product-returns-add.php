<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 1;
$Accounting_auth = 0;
include('template/user_auth.php');
?>

<?php
require_once "config.php";

$alertMessage=$return_id=$r_seriesNum=$r_model=$r_qty=$r_amount=$r_totalAmount=$r_gpl=$r_totalGpl=$r_pickDate=$r_returnDate=$r_orderNum=$r_reason="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $r_seriesNum      = test_input($_POST['seriesNum']);
    $r_model          = test_input($_POST['model']);
    $r_qty            = test_input($_POST['qty']);
    $r_amount         = test_input($_POST['amount']);
    $r_totalAmount    = test_input($_POST['totalAmount']);
    $r_gpl            = test_input($_POST['gpl']);
    $r_totalGpl       = test_input($_POST['totalgpl']);
    $r_pickDate       = test_input($_POST['pickDate']);
    $r_returnDate     = test_input($_POST['returnDate']);
    $r_orderNum       = test_input($_POST['orderNum']);
    $r_reason         = test_input($_POST['reason']);

    //validation
    // Validate category
    if(empty($r_seriesNum)){
        $alertMessage = "Please enter a series number";
    }
    if(empty($r_model)){
        $alertMessage = "Please enter a model";
    }
    if(empty($r_qty)){
        $alertMessage = "Please enter a qty";
    }
    if(empty($r_amount)){
        $alertMessage = "Please enter a amount";
    }
    if(empty($r_totalAmount)){
        $alertMessage = "Please enter a total amount";
    }
    if(empty($r_gpl)){
        $alertMessage = "Please enter a gpl";
    }
    if(empty($r_totalGpl)){
        $alertMessage = "Please enter a total gpl";
    }
    if(empty($r_pickDate)){
        $alertMessage = "Please enter a pickup date";
    }
    if(empty($r_returnDate)){
        $alertMessage = "Please enter a returned date";
    }
    if(empty($r_orderNum)){
        $alertMessage = "Please enter a order number";
    }
    if(empty($r_reason)){
        $alertMessage = "Please enter a reason";
    }

    if(empty($alertMessage)){

    $query = "INSERT INTO returns (r_seriesNum, r_model, r_qty, r_amount, r_totalAmount, r_gpl, r_totalGpl, r_pickDate, r_returnDate, r_orderNum, r_reason) VALUES ('$r_seriesNum', '$r_model', '$r_qty', '$r_amount', '$r_totalAmount', '$r_gpl', '$r_totalGpl', '$r_pickDate', '$r_returnDate', '$r_orderNum', '$r_reason')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if($result){
         $alertMessage = "<div class='alert alert-success' role='alert'>
                            New returns successfully added in Database.
                          </div>";
    }else {
        $alertMessage = "<div class='alert alert-danger' role='alert'>
                            Error Adding data in Database.
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

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Returned</title>
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
          Add Returns
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">

        <!-- general form elements -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Returned Stocks Information</h3>
            <br><a href="product-returns-manage.php" class="text-center">View Returned Stocks</a>
          </div>
          <!-- /.box-header -->
          <?php echo $alertMessage; ?>
          <!-- form start -->
          <div class="box-body">
            <div class="row">

              <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Series Number</label>
                    <input type="text" class="form-control" placeholder="i.e PO#, SO#, LAZADA#" name="seriesNum">
                  </div>

                  <div class="form-group">
                    <label>Model</label>
                    <input type="text" class="form-control" placeholder="Model" name="model">
                  </div>

                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control" id="returnedQty" placeholder="Quantity" name="qty" value="1">
                  </div>

                  <div class="form-group">
                    <label>Amount</label>
                    <input type="number" class="form-control" id="returnedAmount" placeholder="0.00" name="amount">
                  </div>

                  <div class="form-group">
                    <label>Total Amount</label>
                    <input type="number" class="form-control" id="returnedTotalAmount" placeholder="0.00" name="totalAmount" disabled>
                  </div>

                  <div class="form-group">
                    <label>GPL</label>
                    <input type="number" class="form-control" id="returnedGpl" placeholder="0.00" name="gpl">
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Total GPL</label>
                    <input type="number" class="form-control" id="returnedTotalGpl" placeholder="0.00" name="totalgpl" disabled>
                  </div>

                  <div class="form-group">
                    <label>Pickup Date</label>
                    <input type="date" class="form-control" placeholder="Date" name="pickDate">
                  </div>

                  <div class="form-group">
                    <label>Returned Date</label>
                    <input type="date" class="form-control" placeholder="Returned Date" name="returnDate">
                  </div>

                  <div class="form-group">
                    <label>Order Number</label>
                    <input type="number" class="form-control" placeholder="Order Number" name="orderNum">
                  </div>

                  <div class="form-group">
                    <label>Reason</label>
                    <input type="text" class="form-control" placeholder="Reason" name="reason">
                  </div>

                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" >Save</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content-wrapper -->
  </div>


  <!-- =========================== FOOTER =========================== -->
  <footer class="main-footer">
    <?php include('template/footer.php'); ?>
  </footer>


  <!-- =========================== JAVASCRIPT ========================= -->
  <?php include('template/js.php'); ?>

</body>
</html>
