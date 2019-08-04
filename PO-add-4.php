<?php require_once "config.php"; ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Add PO</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-green fixed sidebar-mini">

  <div class="table-responsive">
    <!--Table-->
    <table class="table table-bordered" id="productTable">
      <thead>
        <tr>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Model</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Stock Count</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Retail Price</th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Action</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $q = $_GET['q'];

        $arrayNumber = 0;
        for($x = 1; $x < 4; $x++) { //begin loop?><!--MODEL-->
          <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; //Multidimensional Array?>">
            <td>
              <div class="form-group">
                <select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)">
                  <option>~~SELECT~~</option>
                  <?php
                  $query = "SELECT * FROM inventory WHERE supplier_name = '". $q ."'  ";;
                  $productData = $connect->query($query);

                  while($row = $productData->fetch_array()) {
                    echo "<option value='".$row['inv_id']."' id='changeProduct".$row['inv_id']."'>".$row['product_description']."</option>";
                  } // /while

                  ?>
                </select>
              </div>
            </td>
            <td>
              <div class="form-group"><!--QTY-->
                <input type="text" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x; ?>)" autocomplete="off" class="form-control" min="1">
              </div>
            </td>
            <td>
              <div class="form-group"><!--UNIT PRICE-->
                <input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />
                <!--==para saan kaya hidden input==-->
                <input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
              </div>
            </td>
            <td>
              <div class="form-group"><!--TOTAL PRICE-->
                <input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />
                <!--==para saan kaya hidden input==-->
              <input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />
              </div>
            </td>
            <!--<td>
              <div class="form-group">
                <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
              </div>
            </td>-->
          </tr>
          <?php $arrayNumber++; $x++;}//end loop ?>
        </tbody>
        <tfoot>
            <div class="form-group">  <!--subamount-->
              <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
                <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
                <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
            </div>  <!--/subamount-->
        </tfoot>
      </table>
      <!--/table-->


    </div>
    <!-- /.content-wrapper -->
    <script>
    /*$('#crud_table tbody').on('keyup change',function(){
    calc();
  });
  $('#totalPrice').on('keyup change',function(){
  calc_total();
});


});

$(document).ready(calculate);
$(document).on("keyup", calculate);

function calc()
{
$('#crud_table tbody tr').each(function(i, element) {
var html = $(this).html();
if(html!='')
{
var qty = $(this).find('#po_qty').val();
var price = $(this).find('#po_unit_price').val();
$(this).find('#po_total_amount').val(qty*price);

calc_total();
}
});
}

function calc_total()
{
total=0;

$('.po_total_amount').each(function() {
total += parseInt($(this).val());
});

$('#totalPrice').val(total.toFixed(2));
//tax_sum=total/100*$('#tax').val();
//$('#tax_amount').val(tax_sum.toFixed(2));
//$('#total_amount').val((tax_sum+total).toFixed(2));
}*/
</script>



<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
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



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>




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
<script src="dist/js/orderSample.js"></script>
</body>
</html>
