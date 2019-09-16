<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 0;
$Accounting_auth = 0;
include('template/user_auth.php');


// Include config file
require_once "config.php";

//initialize variable
$so_request_id=
$so_model=
$so_qty=
$so_unit =
$so_unit_price=
$so_date_delivered=
$so_total_amount="";

//get links
$get_customer_id = $_GET['so_trans_id'];
$get_customer_name = $_GET['so_customer_name'];
$get_so_date = $_GET['so_date'];
$get_so_paymentTerms= $_GET['so_paymentTerms'];
$get_so_sub_total= $_GET['so_sub_total'];
$get_so_delivery_fee= $_GET['so_delivery_fee'];
$get_so_discount= $_GET['so_discount'];
$get_so_grand_total= $_GET['so_grand_total'];

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Sales Order</title>
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
          Manage Sales Order
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
        <?php  echo $_SESSION['usertype']; ?>
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Sales Order List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <label>SO Date:</label>
                <input type="text" class="form-control"  name="so_customer_name" value="<?php echo htmlspecialchars($get_so_date); ?>" disabled>
              </div>
              <div class="col-md-6">
                <label>SO Transaction No.:</label>
                <input type="text" class="form-control"  name="get_customer_id" value="<?php echo htmlspecialchars($get_customer_id); ?>" disabled>
              </div>
              <div class="col-md-6">
                <label>Customer Name:</label>
                <input type="text" class="form-control"  name="so_customer_name" value="<?php echo htmlspecialchars($get_customer_name); ?>" disabled>
              </div>
              <div class="col-md-6">
                <label>SO Payment Terms:</label>
                <input type="text" class="form-control"  name="get_customer_id" value="<?php echo htmlspecialchars($get_so_paymentTerms); ?>" disabled>
              </div>
            </div><br>
            <table class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
              <thead>
                <tr>
                  <th>Model</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Retail Price</th>
                  <th>Total Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT so_items.so_model, so_items.so_qty AS qty, so_items.so_unit_price AS unitPrice, so_items.so_total_amount AS totalAmount, so_items.price AS price, inventory.model AS model FROM inventory, so_items WHERE inventory.inv_id = so_items.so_model AND so_items.so_trans_id = '$get_customer_id' ";
                $result = mysqli_query($link, $query);
                  if(mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){ ?>

                <tr>
                  <td><?php echo htmlspecialchars($row['model']);?></td>
                  <td><?php echo htmlspecialchars(number_format($row['qty']));?></td>
                  <td><?php echo htmlspecialchars(number_format($row['unitPrice']));?></td>
                  <td><?php echo htmlspecialchars(number_format($row['price']));?></td>
                  <td><?php echo htmlspecialchars(number_format($row['totalAmount']));?></td>
                </tr>

              <?php }
              }else{
                echo "<p class='lead'><em>No records were found.</em></p>";
            }
            ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>Sub-total:</td>
              <td><?php echo htmlspecialchars($get_so_sub_total); ?></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>Delivery Fee:</td>
              <td><?php echo htmlspecialchars($get_so_delivery_fee); ?></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>Grand Total:</td>
              <td><?php echo htmlspecialchars(number_format($get_so_grand_total)); ?></td>
            </tr>
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
