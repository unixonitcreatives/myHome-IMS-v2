<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php 
  $Admin_auth = 1;
  $Manager_auth = 1;
  $Accounting_auth = 0;
 include('template/user_auth.php');
?>


<!-- ========================== ADD FORM TO THE DATABASE ====================================== -->
<?php
require_once "config.php";

$customers_lname=$customers_fname=$customers_contact=$customers_email=$customers_address=$alertMessage="";


//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Assigning posted values to variables.
    $customers_name = test_input($_POST['customer_name']);
    $customers_contact = test_input($_POST['customer_contact']);
    $customers_email = test_input($_POST['customer_email']);
    $customers_address = test_input($_POST['customer_address']);

    // Validate category
    if(empty($customers_name)){
        $alertMessage = "Please enter a fullname.";
    }
    if(empty($customers_contact)){
        $alertMessage = "Please enter a contact number.";
    }
    if(empty($customers_email)){
        $alertMessage = "Please enter a email address.";
    }
    if(empty($customers_address)){
        $alertMessage = "Please enter a address.";
    }


    // Check input errors before inserting in database
    if(empty($alertMessage)){
    //Checking the values are existing in the database or not
    $query = "INSERT INTO customers (customer_name,customer_contact,customer_email,customer_address, created_at) VALUES ('$customers_name','$customers_contact','$customers_email','$customers_address', CURRENT_TIMESTAMP)";

    //logs query

    $logsquery = "INSERT INTO logs (user,description,created_at) VALUES ('" . htmlspecialchars($_SESSION["username"]) . "','Added customer $customers_name', CURRENT_TIMESTAMP)";

    $logsquery = "INSERT INTO logs (user,description) VALUES ('" . htmlspecialchars($_SESSION["username"]) . "','Added customer $customers_name')";

    $logsresult = mysqli_query($link, $logsquery) or die(mysqli_error($link));



    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if($result){
         $alertMessage = "<div class='alert alert-success' role='alert'>
  New customer successfully added in database.
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

// Close connection
mysqli_close($link);

?>
<!-- ================================================================ -->

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MyHome | Customer</title>
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
        Add Customer
        <small>asdasdas</small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="content">
      <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Customer's Information</h3>
              <br><a href="customer-manage.php" class="text-center">View Customers</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" placeholder="Fullname" name="customer_name" required>
                </div>

                <div class="form-group">
                <label>Phone</label>
                  <input type="text" class="form-control" placeholder="Phone" name="customer_contact" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" placeholder="Email" name="customer_email" required>
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" placeholder="Address" name="customer_address" required>
                </div>
              <!-- /.box-body -->
            </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" >Save</button>
              </div>
            </form>
          </div>
          <!-- /.box -->


        </div>
    </section>
  <!-- /.content-wrapper -->
</div>


<!-- =========================== FOOTER =========================== -->
  <footer class="main-footer">
      <?php include('template/footer.php'); ?>
  </footer>


<!-- =========================== JAVASCRIPT ========================= -->
      <?php include('template/js.php'); ?>


<!-- =========================== PAGE SCRIPT ======================== -->

<!-- Alert animation -->
<script type="text/javascript">
$(document).ready(function () {

  window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
      $(this).remove();
    });
  }, 1000);

});
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  });
</script>

<script>
  //uppercase text box
  function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
</script>
<?php include('template/disable_button.php'); ?>

</body>
</html>
