<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
  $Admin_auth = 1;
  $Manager_auth = 0;
  $Accounting_auth = 0;
 include('template/user_auth.php');

 $get_so_amount_receive = $_GET['so_amount_receive'];
 $alertMessage = "";
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
          <h3 class="box-title">Sales Order List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php
          if(isset($_GET['alert'])){
              if( $_GET['alert'] == 'receive'){
                  $alertMessage = "<div class='alert alert-success' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Receive Payment Successful</div>";
              }elseif ($_GET['alert'] == 'insertsuccess'){
                  $alertMessage = "<div class='alert alert-success' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>New data added.</div>";
              }elseif ($_GET['alert'] == 'deletesuccess'){
                  $alertMessage = "<div class='alert alert-success' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Data deleted.</div>";
              }
          } ?>
          <?php echo $alertMessage; ?> <!-- alert message -->
          <div class="row">

          </div>
          <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
      <thead>
      <tr>
        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">SO Number</th>
        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Customer Name</th>
        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total Amount</th>
        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Payment Terms</th>
        <th>Action</th>
        </tr>
          </thead>
            <tbody>
                        <?php
                         // Include config file
                         require_once "config.php";

                         // Attempt select query execution
                         $query = "SELECT * FROM so_transactions ORDER BY so_trans_id DESC";
                         if($result = mysqli_query($link, $query)){
                             if(mysqli_num_rows($result) > 0){

                                     while($row = mysqli_fetch_array($result)){
                                         echo "<tr>";
                                             echo "<td>" . $row['so_trans_id'] . "</td>";
                                             echo "<td>" . $row['so_customer_name'] . "</td>";
                                             echo "<td>" . $row['so_grand_total'] . "</td>";
                                             echo "<td>" . $row['so_paymentTerms'] . "</td>";



                                            echo "<td>";

                                            if($row['so_paymentTerms'] == "Installment"){
                                             echo "<a href='SO-installments.php?so_trans_id=".$row['so_trans_id']." && so_customer_name=".$row['so_customer_name']." && so_date=".$row['so_date']." && so_paymentTerms=".$row['so_paymentTerms']."  && so_sub_total=".$row['so_sub_total']." && so_delivery_fee=".$row['so_delivery_fee']." && so_discount=".$row['so_discount']." && so_grand_total=".$row['so_grand_total']."' title='View Record'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                           }else if($row['so_paymentTerms'] == "Fully Paid"){
                                              echo "<a href='SO-fullyPaid.php?so_trans_id=".$row['so_trans_id']." && so_customer_name=".$row['so_customer_name']." && so_date=".$row['so_date']." && so_paymentTerms=".$row['so_paymentTerms']."  && so_sub_total=".$row['so_sub_total']." && so_delivery_fee=".$row['so_delivery_fee']." && so_discount=".$row['so_discount']." && so_grand_total=".$row['so_grand_total']."' title='View Record'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                           }




                                             echo " &nbsp; <a href='SO-update.php?so_trans_id=". $row['so_trans_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";

                                             echo " &nbsp; <a href='SO-delete.php?so_trans_id=". $row['so_trans_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash remove'></span></a>";

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
