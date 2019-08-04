<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php 
  $Admin_auth = 1;
  $Manager_auth = 0;
  $Accounting_auth = 0;
 include('template/user_auth.php');
?>

<!-- ========================== ADD FORM TO THE DATABASE ====================================== -->
<?php

// Define variables and initialize with empty values
$supplier_name=$supplier_contact_person=$supplier_email=$supplier_number=$supplier_address=$alertMessage=$users_id=$created_at="";

require_once "config.php";


$users_id = $_GET['id'];
$query = "SELECT * from suppliers WHERE id='$users_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $supplier_name              =   $row['supplier_name'];
        $supplier_contact_person    =   $row['supplier_contact_person'];
        $supplier_email             =   $row['supplier_email'];
        $supplier_number            =   $row['supplier_number'];
        $supplier_address           =   $row['supplier_address'];
        $created_at                 =   $row['created_at'];
    }
}else {
    $alertMessage="<div class='alert alert-danger' role='alert'>Theres Nothing to see Here.</div>";
}



//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Assigning posted values to variables.
    $supplier_name = test_input($_POST['supplier_name']);
    $supplier_contact_person = test_input($_POST['supplier_contact_person']);
    $supplier_email = test_input($_POST['supplier_email']);
    $supplier_number = test_input($_POST['supplier_number']);
    $supplier_address = test_input($_POST['supplier_address']);

    // Validate supplier name

    if(empty($supplier_name)){
        $alertMessage = "Please enter a supplier name.";
    }

    // Validate supplier contact person

    if(empty($supplier_contact_person)){
        $alertMessage = "Please enter a supplier contact person.";
    }

    // Validate supplier email

    if(empty($supplier_email)){
        $alertMessage = "Please enter a supplier email.";
    }

    // Validate supplier contact number

    if(empty($supplier_number)){
        $alertMessage = "Please enter a supplier contact number.";
    }

    // Validate supplier contact number

    if(empty($supplier_address)){
        $alertMessage = "Please enter a supplier address.";
    }
    // Check input errors before inserting in database
    if(empty($alertMessage)){
    //Checking the values are existing in the database or not
    $query = "UPDATE suppliers SET supplier_name='$supplier_name', supplier_contact_person='$supplier_contact_person', supplier_email='$supplier_email', supplier_number='$supplier_number', supplier_address='$supplier_address' WHERE id='$users_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Supplier data successfully updated in database.
</div>";
    }else {
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Error updating record.
</div>";}

// remove all session variables
//session_unset();
// destroy the session
//session_destroy();

// Close connection
mysqli_close($link);
}
    }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!-- ================================================================ -->

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MyHome | Supplier</title>
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
        Add Supplier
        <small>asdasdas</small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
<section class="content">
    <div class="col-md-6">
      <?php echo $alertMessage; ?>
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Supplier's Information</h3>
              <br><a href="supplier-manage.php" class="text-center">View Supplier</a>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
             <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $users_id; ?>">

              <div class="box-body">
                <div class="form-group">
                  <label>Suppliers</label>
                  <input type="text" class="form-control" placeholder="Suppliers" name="supplier_name" oninput="upperCaseF(this)" value="<?php echo $supplier_name; ?>" required>
                </div>

                <div class="form-group">
                  <label>Contact Person</label>
                  <input type="text" class="form-control" placeholder="Contact Person" name="supplier_contact_person" oninput="upperCaseF(this)" value="<?php echo $supplier_contact_person; ?>" required>
                </div>

                <div class="form-group">
                <label>Phone</label>
                  <input type="text" class="form-control" placeholder="Phone" name="supplier_number" value="<?php echo $supplier_number; ?>" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" placeholder="Email" name="supplier_email" value="<?php echo $supplier_email; ?>" required>
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" placeholder="Address" name="supplier_address" oninput="upperCaseF(this)" value="<?php echo $supplier_address; ?>" required>
                </div>
                <div class="form-group">
                <label>Created at</label>
                <input type="text" class="form-control" placeholder="date" name="date" value="<?php echo $created_at; ?>" disabled>
              </div>
              </div>



              <!-- /.box-body -->
              <div class="box-footer">
                  <button type="submit" class="btn btn-success">Save</button>
              </div>
            </form>
          </div>
          <!-- /.box -->


        </div>
    <!-- /.content -->
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
  })
</script>

<script>
  //uppercase text box
  function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
</script>

</body>
</html>
