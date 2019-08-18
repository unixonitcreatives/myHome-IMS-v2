<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 0;
$Accounting_auth = 0;
include('template/user_auth.php');



//suppliers_prodauts table variables
$sup_prod_model=
$sup_prod_category=
$sup_prod_subCategory=
$sup_prod_price=
$sup_prod_srp=
$get_suppliers_id=
$alertMessage=
$sup_prod_date="";

require_once "config.php";

//get suppliers table id from Manage
$get_suppliers_id = $_GET['suppliers_product_id'];

$query = "SELECT * FROM suppliers_products WHERE suppliers_product_id='$get_suppliers_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)){
    $sup_prod_model               =   $row['sup_prod_model'];
    $sup_prod_category            =   $row['sup_prod_category'];
    $sup_prod_subCategory         =   $row['sup_prod_subCategory'];
    $sup_prod_price               =   $row['sup_prod_price'];
    $sup_prod_srp                 =   $row['sup_prod_srp'];
    $sup_prod_date                =   $row['sup_prod_date'];

  }
}else {
  $alertMessage="<div class='alert alert-danger' role='alert'>Theres Nothing to see Here.</div>";
}

//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Assigning posted values to variables.
    $sup_prod_model               =   test_input($_POST['sup_prod_model']);
    $sup_prod_category            =   test_input($_POST['sup_prod_category']);
    $sup_prod_subCategory         =   test_input($_POST['sup_prod_subCategory']);
    $sup_prod_price               =   test_input($_POST['sup_prod_price']);
    $sup_prod_srp                 =   test_input($_POST['sup_prod_srp']);
    $sup_prod_date                =   test_input($_POST['sup_prod_date']);


    // Validate model
    if(empty($sup_prod_model)){
        $alertMessage = "Please enter a model.";
    }
    // Validate category
    if(empty($sup_prod_category)){
        $alertMessage = "Please enter a category.";
    }
    // Validate category
    if(empty($sup_prod_subCategory)){
        $alertMessage = "Please enter a sub-category.";
    }
    // Validate category
    if(empty($sup_prod_price)){
        $alertMessage = "Please enter a price.";
    }
    // Validate category
    if(empty($sup_prod_srp)){
        $alertMessage = "Please enter a retail price.";
    }
    // Validate category
    if(empty($sup_prod_date)){
        $alertMessage = "Please enter a date.";
    }

    // Check input errors before inserting in database
    if(empty($alertMessage)){
    //Checking the values are existing in the database or not
    $query = "UPDATE suppliers_products SET sup_prod_model='$sup_prod_model', sup_prod_category='$sup_prod_category', sup_prod_subCategory='$sup_prod_subCategory', sup_prod_price='$sup_prod_price', sup_prod_srp='$sup_prod_srp',  sup_prod_date='$sup_prod_date' WHERE suppliers_product_id='$get_suppliers_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Product data successfully updated in database.
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


// Close connection
mysqli_close($link);

?>

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
          Manage Supplier
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Search for Supplier Information</h3>
            <br><a href="supplier-add.php" class="text-center">+ Add New Supplier</a>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <?php echo $alertMessage; ?>
          <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?suppliers_product_id=<?php echo $get_suppliers_id; ?>">
            <div class="col-md-12">
              <div class="form-group">
                <label>Model:</label>
                <input type="text" class="form-control" id="sup_prod_model" name="sup_prod_model"  value="<?php echo $sup_prod_model; ?>" required/>
              </div>

              <div class="form-group">
                <label>Category:</label>
                <input type="text" class="form-control" id="sup_prod_category" name="sup_prod_category"  value="<?php echo $sup_prod_category; ?>" required/>
              </div>


              <div class="form-group">
                <label>Sub-Category</label>
                <input type="text" class="form-control" id="sup_prod_subCategory" name="sup_prod_subCategory"  value="<?php echo $sup_prod_subCategory; ?>" required/>
              </div>

              <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" id="sup_prod_price" name="sup_prod_price"  value="<?php echo $sup_prod_price; ?>" required/>
              </div>

              <div class="form-group">
                <label>Retail Price:</label>
                <input type="number" class="form-control" id="sup_prod_srp" name="sup_prod_srp"  value="<?php echo $sup_prod_srp; ?>" required/>
              </div>

              <div class="form-group">
                <label>Date:</label>
                <input type="date" class="form-control" id="sup_prod_date" name="sup_prod_date"  value="<?php echo $sup_prod_date; ?>" required/>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success">Update Product</button>
            </div>
              </form>
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
