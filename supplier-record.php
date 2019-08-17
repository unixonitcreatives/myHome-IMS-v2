<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 0;
$Accounting_auth = 0;
include('template/user_auth.php');

//suppliers table variables
$supplier_name=
$supplier_contact_person=
$supplier_email=
$supplier_number=
$supplier_address=
$created_at=
$get_suppliers_id="";


//suppliers_prodauts table variables
$sup_prod_model=
$sup_prod_category=
$sup_prod_subCategory=
$sup_prod_price=
$sup_prod_srp=
$sup_prod_date="";

require_once "config.php";

//get suppliers table id from Manage
$get_suppliers_id = $_GET['suppliers_id'];

$query = "SELECT * from suppliers WHERE suppliers_id='$get_suppliers_id'";
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

            <div class="col-md-6">
              <div class="form-group">
                <label>Name:</label>
                <input type="text" class="form-control" id="supplier_name" name="supplier_name"  value="<?php echo $supplier_name; ?>"/>
              </div>

              <div class="form-group">
                <label>Contact Person:</label>
                <input type="text" class="form-control" id="supplier_contact_person" name="supplier_contact_person"  value="<?php echo $supplier_contact_person; ?>"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" id="supplier_email" name="supplier_email"  value="<?php echo $supplier_email; ?>"/>
              </div>

              <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" class="form-control" id="supplier_number" name="supplier_number"  value="<?php echo $supplier_number; ?>"/>
              </div>
            </div>

            <div class="col-md-12">
              <label>Address:</label>
              <input type="text" class="form-control" id="supplier_address" name="supplier_address"  value="<?php echo $supplier_address; ?>"/>
            </div>


            <div class="col-md-12">
              <br>
              <div class="row">
              <h4>Supplier Products</h4>
            </div>
            <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
              <thead>
                <tr>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Model</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Category</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Sub-Category</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Price</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Retail Price</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Include config file
                require_once "config.php";

                // Attempt select query execution from suppliers_products table
                $query = "SELECT * FROM suppliers_products";
                if($result = mysqli_query($link, $query)){
                  if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                      echo "<tr>";
                      echo "<td>" . $row['sup_prod_model'] . "</td>";
                      echo "<td>" . $row['sup_prod_category'] . "</td>";
                      echo "<td>" . $row['sup_prod_subCategory'] . "</td>";
                      echo "<td>" . $row['sup_prod_price'] . "</td>";
                      echo "<td>" . $row['sup_prod_srp'] . "</td>";
                      echo "<td>" . $row['sup_prod_date'] . "</td>";
                      echo "<td>";
                      echo " &nbsp; <a href='supplier-update.php?suppliers_id=". $row['suppliers_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                      echo " &nbsp; <a href='supplier-delete.php?suppliers_id=". $row['suppliers_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash remove'></span></a>";
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
