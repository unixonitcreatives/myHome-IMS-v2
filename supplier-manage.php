<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 0;
$Accounting_auth = 0;
include('template/user_auth.php');


$alertMessage="";
?>

<?php
if(isset($_GET['alert'])){
  if ($_GET['alert'] == 'deletesuccess'){
    $alertMessage = "<div class='alert alert-danger' role='alert'>Product deleted successfully.</div>";
  }
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
            <?php echo $alertMessage; ?>
            <div class="row">
            </div>
            <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
              <thead>
                <tr>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Supplier Name</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Contact Person</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Email</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Contact Number</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Address</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Include config file
                require_once "config.php";

                // Attempt select query execution
                $query = "SELECT * FROM suppliers";
                if($result = mysqli_query($link, $query)){
                  if(mysqli_num_rows($result) > 0){

                    while($row = mysqli_fetch_array($result)){
                      echo "<tr>";
                      echo "<td>" . $row['supplier_name'] . "</td>";
                      echo "<td>" . $row['supplier_contact_person'] . "</td>";
                      echo "<td>" . $row['supplier_email'] . "</td>";
                      echo "<td>" . $row['supplier_number'] . "</td>";
                      echo "<td>" . $row['supplier_address'] . "</td>";
                      echo "<td>";
                      echo "<a href='supplier-add-products.php?suppliers_id=". $row['suppliers_id'] ." && supplier_name=". $row['supplier_name'] ."' title='Add Products' data-toggle='tooltip'><span class='fa fa-plus-square'></span></a>";
                      echo " &nbsp; <a href='supplier-record.php?suppliers_id=". $row['suppliers_id'] ."' title='View Record' data-toggle='tooltip'><span class='fa fa-eye'></span></a>";
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
