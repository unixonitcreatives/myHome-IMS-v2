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

//initialize variables
$totalV=
$so_request_id=
$so_model=
$so_qty=
$so_unit =
$so_unit_price=
$get_customer_id=
$get_customer_name=
$get_so_date=
$so_delivery_date=
$get_so_paymentTerms=
$get_so_grand_total=
$so_get_amount_receive=
$so_total_amount="";

//get links

$get_customer_id = $_GET['so_trans_id'];
$get_customer_name = $_GET['so_customer_name'];
$get_so_date = $_GET['so_date'];
$get_so_paymentTerms= $_GET['so_paymentTerms'];
$get_so_grand_total= $_GET['so_grand_total'];

$alertMessage="";

//loggedin username
$user = $_SESSION["username"];

$query = "SELECT SUM(so_amount_receive) AS amount_receive FROM so_installments_history WHERE so_trans_id = '$get_customer_id' ";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_assoc($result)){
  $amountR = $row['amount_receive'];
  $total_grand_amount = $get_so_grand_total - $amountR;
}

ob_start();

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
          <small>asdasdas</small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
        <?php  echo $_SESSION['usertype']; ?>
        <div class="box box-success">
          <div class="box-header with-border">
            <?php echo $alertMessage; ?>
            <h3 class="box-title">Sales Transactions History</h3>
            <!-- Button trigger modal -->


            <!-- if balance is 0 -->
            <?php
            if ($total_grand_amount == 0){

              echo '<button type="button" class="btn btn-success btn-sm pull-right" id="receivePaymentBtn" data-toggle="modal" data-target="#receivePayment" aria-disabled="true" disabled>
              Receive Payment
              </button>';

            }else {
              echo '<button type="button" class="btn btn-success btn-sm pull-right" id="receivePaymentBtn" data-toggle="modal" data-target="#receivePayment">
              Receive Payment
              </button>';
            }
            ?>
            <!-- /Button trigger modal -->
          </div>


          <div class="box-body">

            <?php echo $alertMessage; ?> <!-- alert message -->
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


            <h6><a type="button" data-toggle="collapse" data-target="#collapseItems" aria-expanded="false" aria-controls="collapseExample">+ Purchased Items</a></h6>
            <!-- Collapse Button -->

            <div class="collapse" id="collapseItems">
              <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                <thead>
                  <tr>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Model</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Quantity</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Unit</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Retail Price</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Delivery Date</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Date Delivered</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total Amount</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM so_items WHERE so_trans_id = '$get_customer_id' ";
                  $result = mysqli_query($link, $query);
                  if(mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){ ?>
                      <tr>
                        <td><?php echo htmlspecialchars($row['so_model']);?></td>
                        <td><?php echo htmlspecialchars($row['so_qty']);?></td>
                        <td><?php echo htmlspecialchars($row['so_unit']);?></td>
                        <td><?php echo htmlspecialchars($row['so_unit_price']);?></td>
                        <td><?php echo htmlspecialchars($row['so_delivery_date']);?></td>
                        <td><?php echo htmlspecialchars($row['so_date_delivered']);?></td>
                        <td><?php echo htmlspecialchars($row['so_total_amount']);?></td>
                        <td>
                          <a data-toggle="modal" data-target="#updateDelivery" class="btn btn-sm btn-success" href='updateDelivery?so_request_id=<?php echo $row['so_request_id']; ?>' >Update Delivery</a>
                      </tr>

                    <?php }
                  }else{
                    echo "<p class='lead'><em>No records were found.</em></p>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- /Collapse -->
      </section>
      <!-- /.content-wrapper -->


      <!--================Installment History Table===================================--->

      <section class="content">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title" >Remaining Balance: ₱ <b id="so_grand_total_on_top"><?php echo number_format($total_grand_amount,2);?></b></h3>

            <!-- if balance is 0 -->
            <?php
            if ($total_grand_amount == 0){

              echo '<button type="button" class="btn btn-success btn-sm pull-right"  data-toggle="modal" data-target="#updatePaymentBtn">Fully Paid</button>';

            }else {
              echo '<button type="button" class="btn btn-success btn-sm pull-right"  data-toggle="modal" data-target="#updatePaymentBtn" aria-disabled="true" disabled>Fully Paid</button>';
            }
            ?>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1 calCulate" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
              <thead>
                <tr>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Transaction No</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Date</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Amount</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Payment Mode</th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Reference No.</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM so_installments_history WHERE so_trans_id = '$get_customer_id' ";
                $result = mysqli_query($link, $query);
                if(mysqli_num_rows($result) > 0){
                  while ($row = mysqli_fetch_assoc($result)){ ?>

                    <tr>
                      <td><?php echo htmlspecialchars($row['so_installment_id']);?></td>
                      <td><?php echo htmlspecialchars($row['so_receive_payment_date']);?></td>
                      <td><?php echo htmlspecialchars($row['so_amount_receive']);?></td>
                      <td><?php echo htmlspecialchars($row['so_paymentMode']);?></td>
                      <td><?php echo htmlspecialchars($row['so_ref_no']);?></td>
                    </tr>

                  <?php } ?>

                <?php }else{
                  echo "<p class='lead'><em>No records were found.</em></p>";
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </section>
      <!-- /.content-wrapper -->
    </div>
    <!--================/Installment History Table===================================--->



    <!-- ================== Receive Payment Modal ====================================-->
    <div class="modal fade" id="receivePayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Receive Payment Form</h4>
          </div>
          <div class="modal-body">
            <form method="POST"  action="modals/so_receive_payments.php">

              <!--<div class="form-group">
              <input type="hidden" class="form-control"  name="total_grand_amount" value="<?php echo htmlspecialchars($total_grand_amount); ?>">
            </div> -->

            <div class="form-group">
              <input type="hidden" class="form-control"  name="so_trans_id" value="<?php echo htmlspecialchars($get_customer_id); ?>">
            </div>

            <div class="form-group">
              <label>SO Date:</label>
              <input type="date" class="form-control"  name="so_receive_payment_date">
            </div>

            <div class="form-group">
              <label>Amount:</label>
              <input type="number" class="form-control"  name="so_amount_receive">
            </div>

            <div class="form-group">
              <label>Mode of Payment:</label>
              <select class="form-control" id="so_unit" name="so_paymentMode">
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Bank Deposit">Bank Deposit</option>
              </select>
            </div>

            <div class="form-group">
              <label>Reference No:</label>
              <input type="text" class="form-control"  name="so_ref_no">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" name="receivePaymentBtn" class="btn btn-success">Receive</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /Modal -->
  <!-- /.box-header -->
  <!-- ================== /Receive Payment Modal ====================================-->


  <!-- ================== Fully Paid Modal ====================================-->
  <div class="modal fade" id="updatePaymentBtn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Receive Payment Form</h4>
        </div>
        <div class="modal-body">
          <form method="POST"  action="modals/so_fullyPaid.php">

            <div class="form-group">
              <input type="hidden" class="form-control"  name="so_trans_id" value="<?php echo htmlspecialchars($get_customer_id); ?>">
            </div>

            <?php
            if($total_grand_amount == 0){
              echo 'Please press update button to continue
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" name="fullyPaid" class="btn btn-success">Update</button>
                </div>';
            }else {
              echo 'You still have remaining balance of ' .$total_grand_amount.
              '<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"  >Cancel</button>
              <button type="submit" name="fullyPaid" class="btn btn-success" aria-disabled="true" disabled>Update</button>
              </div>';
            }
            ?>

          </form>
        </div>
      </div>
    </div>
    </div>
    <!-- /Modal -->
    <!-- /.box-header -->
<!-- ================== /Fully Paid Modal ====================================-->

<!-- ================== Update Delivery Modal ====================================-->
<div class="modal fade" id="updateDelivery<?php echo $row['so_request_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Receive Payment Form</h4>
      </div>
      <div class="modal-body">

        <form method="POST"  action="SO-update-items.php?so_trans_id=<?php echo $so_request_id; ?>">

          <div class="form-group">
            <input type="text" class="form-control"  name="so_request_id" value="<?php echo $so_request_id; ?>">
          </div>

          <div class="form-group">
            <label>Delivery Date:</label>
            <input type="date" class="form-control"  name="so_delivery_date">
          </div>

          <div class="form-group">
            <label>Date Delivered:</label>
            <input type="date" class="form-control"  name="so_date_delivered">
          </div>

          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"  >Cancel</button>
          <button type="submit" name="updateDeliveryBtn" class="btn btn-success" >Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  <!-- /Modal -->
  <!-- /.box-header -->
<!-- ================== /Update Delivery Modal ====================================-->


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

<?php ob_end_flush(); ?>
</body>
</html>
