<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= PHP =================== -->
<?php
// Define variables and initialize with empty values
$inv_num=$po_supplier_name=$po_qty=$po_unit=$po_description=$po_unit_price=$po_total_amount=$totalPrice=$remarks=$user=$paymentTerms=$transID=$alertMessage="";

$supplier_address=$status="";

require_once "config.php";

$users_id = $_GET['id'];

$query = "SELECT request_po.po_trans_id, suppliers.supplier_address,po_transactions.supplier_name,po_transactions.po_status, suppliers.supplier_address, request_po.po_qty, request_po.po_unit, request_po.po_unit_price, request_po.po_description, request_po.po_unit_price, request_po.po_total_amount,po_transactions.inv_date, po_transactions.paymentTerms, po_transactions.totalPrice, request_po.user from suppliers " .
"INNER JOIN po_transactions ON suppliers.supplier_name = po_transactions.supplier_name ".
"INNER JOIN request_po ON po_transactions.po_trans_id = request_po.po_trans_id WHERE po_transactions.po_trans_id = $users_id";

$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)){
    $po_supplier_name   = $row['supplier_name'];
    $totalPrice         = $row['totalPrice'];
    $po_qty             = $row['po_qty'];
    $po_description     = $row['po_description'];
    $po_unit_price      = $row['po_unit_price'];
    $po_total_amount    = $row['po_total_amount'];
    $supplier_address   = $row['supplier_address'];
    $po_unit            = $row['po_unit'];
    $note               = $row['paymentTerms'];

    if($row['po_status'] == 1){
      $showStatus = "<p class='label label-warning invoice-col'>Pending</p>";
      $Status = "Pending";
    }elseif ($row['po_status'] == 2){
      $showStatus = "<p class='label label-success invoice-col'>Approved</p>";
      $Status = "Approved";
    }elseif ($row['po_status'] == 3){
      $showStatus = "<h4><p class='label label-danger invoice-col'>Void</p></h4>";
      $Status = "Void";

    }else {
      $showStatus = "<span class='text-default invoice-col'>Error</span>";

    }


  }
  $num_rows = mysqli_num_rows($result);
} else{
  echo "<p class='lead'><em>No records were found.</em></p>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $query = "UPDATE po_transactions SET po_status = 2 WHERE po_trans_id='$users_id'";
  $approved = mysqli_query($link, $query) or die(mysqli_error($link));

  $showStatus = "<span class='label label-success'>Approved</span>";
  header("Location: PO-manage.php");


}
?>
<!-- =================================================== -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MyHome | View</title>
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
         Welcome to MyHome Furniture IMS Dashboard<br>
        <small>Insert Tagline, Contact Details or Important Details</small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="header">
                <div class="col-xs-3">
                  <img class="img-responsive" src="dist/img/logo-01.png">
                  <br>
                </div>
                <small class="pull-right">
                    <button onclick="window.history.back()" target="_blank" class="btn btn-default no-print" ><i class="fa fa-arrow-left">&nbsp;Back</i></button>
                    <button onclick="Print()" target="_blank" class="btn btn-default no-print" ><i class="fa fa-print">&nbsp;Print</i></button>
                </small>

              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-3 invoice-col">
              From
              <address>
                <strong>
                  <?php
                  //dito bro, company name nung supplier sa PO na to
                  echo $po_supplier_name;
                  ?>

                </strong><br>
                <?php echo $supplier_address; ?>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
              To
              <address>
                <strong>MyHome Interior Furniture Co.</strong><br>
                Unit 13-16 #30th Real St. Las Pinas Commercial Complex <br>
                Alabang-Zapote Road, Las Piñas<br>
                Phone: (555) 539-1037<br>
                Email: hello.world@example.com
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <h4>
                <b>Purchase Order &nbsp;</b>#
                  <?php
                  echo $users_id;
                  ?>

                <br>

                <b>Date:</b> <script> document.write(new Date().toLocaleDateString()); </script> <br><br>
                <b>Status: &nbsp;</b><?php echo $showStatus; ?></label><br>

              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>

                    <th width="40%">Product Description</th>
                    <th width="15%">Quantity</th>
                    <th width="15%">Unit</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Total Amount</th>
                  </tr>
                </thead>

                <tbody>
                  <?php

                  $result = mysqli_query($link, $query) or die(mysqli_error($link));
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)){

                      $totalPrice  =  $row['totalPrice'];

                      echo "<tr>";
                      //echo "<td>" .$row['po_trans_id'] . "</td>";

                      echo "<td>" . $row['po_description'] . "</td>";
                      echo "<td>" .$row['po_qty'] . "</td>";
                      echo "<td>" . $row['po_unit'] . "</td>";
                      echo "<td>₱ " . number_format($row['po_unit_price'],2) . "</td>";
                      echo "<td>₱ " . number_format($row['po_total_amount'],2) . "</td>";

                      echo "</tr>";

                    }


                    // Free result set
                    mysqli_free_result($result);
                  } else{
                    echo "<p class='lead'><em>No records were found.</em></p>";
                  }

                  ?>


                </tbody>
                <tfooter class="table-footer">

                    <td>No of Items : <?php echo $num_rows; ?></td>
                    <td></td>
                    <td></td>
                    <td align="right"><h4>Grand Total: &nbsp;</h4></td>
                    <td><h4> ₱ <?php echo number_format($totalPrice,2,'.',',');?></h4></td>

                </tfooter>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              <p class="lead">Important Notes:</p>
              <!--
              <img src="dist/img/credit/visa.png" alt="Visa">
              <img src="dist/img/credit/mastercard.png" alt="Mastercard">
              <img src="dist/img/credit/american-express.png" alt="American Express">
              <img src="dist/img/credit/paypal2.png" alt="Paypal">
              -->
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
               <?php echo $note; ?>
              </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
              <div>
                <table class="table-responsive">
                  <!--
                  <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>₱ <?php
                  echo number_format($totalPrice,2,'.',',');
                  ?></td>
                </tr>
                <
                <tr>
                <th>Tax (9.3%)</th>
                <td>Kailangan paba ito?</td>
              </tr>
              <tr>
              <th>Shipping:</th>
              <td>Kailangan paba ito?</td>
            </tr>
          -->
          <tr>
            <td width="40%"><h3>Grand Total: &nbsp;</h3></td>
            <td width="60%"><h3> ₱ <?php
            echo number_format($totalPrice,2,'.',',');?></h3></td>
          </tr>
        </table>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">



      <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $users_id; ?>">
        <?php
          //<button type="submit" class="btn btn-success pull-right" name="Approved"><i class="fa fa-thumbs-o-up"></i> Approve Purchase Order</button>

          if($Status == "Approved"){
            echo "<button type='submit' class='btn btn-success pull-right' name='Approved' disabled><i class='fa fa-thumbs-o-up'></i> Approve Purchase Order</button>"; //disable Approve
          } else {
            echo "<button type='submit' class='btn btn-success pull-right' name='Approved'><i class='fa fa-thumbs-o-up'></i> Approve Purchase Order</button>"; // enable Approve

          }

        ?>
      </form>


      <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $users_id; ?>">
        <?php
        if($Status == "Void"){
          echo "<button type='submit' class='btn btn-danger' name='Void' disabled><i class='fa fa-trash'></i> Void Purchase Order</button>"; //disable void

        }


        else {
                echo "<button type='submit' class='btn btn-danger' name='Void'><i class='fa fa-trash'></i> Void Purchase Order</button>"; //enable void
        }

        ?>
      </form>




      <?php
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Approved']))
          {
             $query = "UPDATE po_transactions SET po_status = 2 WHERE po_trans_id='$users_id'";
             $approved = mysqli_query($link, $query) or die(mysqli_error($link));

             $showStatus = "<span class='label label-success'>Approved</span>";
             header("Location: PO-manage.php");
          }

          elseif ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Void']))
          {
             $query = "UPDATE po_transactions SET po_status = 3 WHERE po_trans_id='$users_id'";
             $approved = mysqli_query($link, $query) or die(mysqli_error($link));

             $showStatus = "<span class='label label-success'>Approved</span>";
             header("Location: PO-manage.php");
          }

      ?>


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
