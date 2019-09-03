<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= PHP =================== -->
<?php
// Define variables and initialize with empty values
$inv_num=$po_supplier_name=$po_qty=$po_unit=$po_description=$po_unit_price=$po_total_amount=$totalPrice=$remarks=$user=$paymentTerms=$transID=$alertMessage="";

$supplier_address=$status="";

require_once "config.php";

$po_trans_id = $_GET['po_trans_id'];

$query = "SELECT suppliers_products.sup_prod_model, request_po.po_trans_id,po_transactions.po_supplier_name,po_transactions.po_status, suppliers.supplier_address, request_po.po_qty, request_po.po_price, request_po.po_total, po_transactions.po_inv_date, po_transactions.subTotal, po_transactions.po_notes ,po_transactions.po_user from suppliers
JOIN po_transactions ON suppliers.supplier_name = po_transactions.po_supplier_name
JOIN request_po ON po_transactions.po_trans_id = request_po.po_trans_id
JOIN suppliers_products ON request_po.po_model = suppliers_products.suppliers_product_id WHERE po_transactions.po_trans_id = '$po_trans_id' ";

$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)){
    $po_supplier_name   = $row['po_supplier_name'];
    $totalPrice         = $row['subTotal'];
    $po_qty             = $row['po_qty'];
    $po_description     = $row['sup_prod_model'];
    $po_total_amount    = $row['po_total'];
    $supplier_address   = $row['supplier_address'];
    $note               = $row['po_notes'];

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

/*if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $query = "UPDATE po_transactions SET po_status = 2 WHERE po_trans_id='$users_id'";
  $approved = mysqli_query($link, $query) or die(mysqli_error($link));

  header("Location: PO-manage.php");
  $showStatus = "<span class='label label-success'>Approved</span>";
}*/

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Approved']))
    {
       $query = "UPDATE po_transactions SET po_status = 2 WHERE po_trans_id='$po_trans_id'";
       $approved = mysqli_query($link, $query) or die(mysqli_error($link));

       $showStatus = "<span class='label label-success'>Approved</span>";
       header("Location: PO-manage.php");
    }

    elseif ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Void']))
    {
       $query = "UPDATE po_transactions SET po_status = 3 WHERE po_trans_id='$po_trans_id'";
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
            <div class="col-sm-4 invoice-col">
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
            <div class="col-sm-4 invoice-col">
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
            <div class="col-sm-4 invoice-col pull-right">
              <h4>
                <b>Purchase Order &nbsp;</b>#
                  <?php
                  echo $po_trans_id;
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

                    <th width="40%">Product Model</th>
                    <th width="15%">Quantity</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Total Amount</th>
                  </tr>
                </thead>

                <tbody>
                  <?php

                  $result = mysqli_query($link, $query) or die(mysqli_error($link));
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)){

                      $totalPrice  =  $row['subTotal'];

                      echo "<tr>";
                      //echo "<td>" .$row['po_trans_id'] . "</td>";

                      echo "<td>" . $row['sup_prod_model'] . "</td>";
                      echo "<td>" .$row['po_qty'] . "</td>";
                      echo "<td>₱ " . number_format((float)$row['po_price'],2) . "</td>";
                      echo "<td>₱ " . number_format((float)$row['po_total'],2) . "</td>";

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
                    <td align="right"><h4>Grand Total: &nbsp;</h4></td>
                    <td><h4> ₱ <?php echo number_format((float)$totalPrice,2);?></h4></td>

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
            <!--  <div>
                <table class="table-responsive">

                  <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>₱ <?php
                  echo number_format((float)$totalPrice,2);
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

          <tr>
            <td width="40%"><h3>Grand Total: &nbsp;</h3></td>
            <td width="60%"><h3> ₱ <?php
            echo number_format((float)$totalPrice,2);?></h3></td>
          </tr>
        </table>
      </div>-->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">



      <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?po_trans_id=<?php echo $po_trans_id; ?>">
        <?php
          //<button type="submit" class="btn btn-success pull-right" name="Approved"><i class="fa fa-thumbs-o-up"></i> Approve Purchase Order</button>

          if($Status == "Approved"){
            echo "<button type='submit' class='btn btn-success pull-right' name='Approved' disabled><i class='fa fa-thumbs-o-up'></i> Approve Purchase Order</button>"; //disable Approve
          } else {
            echo "<button type='submit' class='btn btn-success pull-right' name='Approved'><i class='fa fa-thumbs-o-up'></i> Approve Purchase Order</button>"; // enable Approve

          }

        ?>
      </form>


      <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?po_trans_id=<?php echo $po_trans_id; ?>">
        <?php
        if($Status == "Void"){
          echo "<button type='submit' class='btn btn-danger' name='Void' disabled><i class='fa fa-trash'></i> Void Purchase Order</button>"; //disable void

        }


        else {
                echo "<button type='submit' class='btn btn-danger' name='Void'><i class='fa fa-trash'></i> Void Purchase Order</button>"; //enable void
        }

        ?>
      </form>

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

</body>
</html>
