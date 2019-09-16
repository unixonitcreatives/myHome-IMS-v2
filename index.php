<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>

<?php
require_once 'config.php';

//stocks count
$stocksquery = "SELECT * FROM inventory ";
$stocksresult = mysqli_query($link, $stocksquery) or die(mysqli_error($link));
if (mysqli_num_rows($stocksresult) > 0) {
  $stocksrows = mysqli_num_rows($stocksresult);
}

//po count
$poquery = "SELECT * FROM request_po ";
$poresult = mysqli_query($link, $poquery) or die(mysqli_error($link));
if (mysqli_num_rows($poresult) > 0) {
  $porows = mysqli_num_rows($poresult);
}

//so count
$soquery = "SELECT * FROM so_items ";
$soresult = mysqli_query($link, $soquery) or die(mysqli_error($link));
if (mysqli_num_rows($soresult) > 0) {
  $sorows = mysqli_num_rows($soresult);
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Dashboard</title>
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
          <small><p><strong>Note:</strong> User might experience bugs and errors during the testing period. Please contact developer for assistance.</p></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $stocksrows; ?></h3>

                <p>Total Stocks Quantity</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div> <!-- /1st box -->

          <div class="col-md-3">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php echo $porows; ?></h3>

                <p>Total Purchase Orders</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div> <!-- /2nd box -->

          <div class="col-md-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $sorows; ?></h3>

                <p>Total Sales Orders</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div> <!-- /3rd box -->

          <div class="col-md-3">
            <div class="small-box bg-red">
              <div class="inner">
                <h3>150</h3>

                <p>Total Returns</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div> <!-- /4th box -->
        </div> <!-- /row -->

        <div class="row">
          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Latest Purchase Orders</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">PO No</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Date</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Supplier</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Notes</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total Price</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Attempt select query execution
                      $poquery = "SELECT * FROM po_transactions ORDER BY po_trans_id DESC LIMIT 5 ";
                      if($poresult = mysqli_query($link, $poquery)){
                        if(mysqli_num_rows($poresult) > 0){

                          while($porow = mysqli_fetch_array($poresult)){
                            $postatus = $porow['po_status']; //ung 'po status' yan dapat name sa dbase. etong line lang gagalawin mo

                            echo "<tr>";
                            echo "<td>#" . $porow['po_trans_id'] . "</td>";
                            echo "<td>" . $porow['po_inv_date'] . "</td>";

                            echo "<td>" . $porow['po_supplier_name'] . "</td>";
                            echo "<td>" . $porow['po_notes'] . "</td>";
                            echo "<td>₱" . number_format((float)$porow['subTotal'],2) . "</td>";

                            // eto ung mag chcheck kung ano value nung 'po status' tapos papalitan nya color
                            // STATUS: 1=PENDING; 2=APPROVED; 3=VOID
                            if($postatus == 1){
                              echo "<td> <span class='label label-warning'>Pending</span> </td>";
                            } elseif ($postatus == 2) {
                              echo "<td> <span class='label label-success'>Approved</span> </td>";
                            } elseif ($postatus == 3) {
                              echo "<td> <span class='label label-danger'>Void</span> </td>";
                            } else {
                              echo "<td> <span class='label label-default'>Error</span> </td>";
                            }
                            //end here
                          }

                          // Free result set
                          mysqli_free_result($poresult);
                        } else{
                          echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                      } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                      }


                      ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                <a href="PO-request.php" class="btn btn-sm btn-info btn-flat pull-left">Create New PO</a>
                <a href="PO-manage.php" class="btn btn-sm btn-default btn-flat pull-right">View All Purchase Order</a>
              </div>
              <!-- /.box-footer -->
            </div>

            <!-- LATEST PRODUCTS TABLE -->
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Recently Added Products</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">SO Number</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Customer Name</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total Amount</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Payment Terms</th>
                      </tr>
                    </thead>
                    <tbody>
                                <?php
                                 // Attempt select query execution
                                 $so_query = "SELECT * FROM so_transactions ORDER BY so_trans_id DESC LIMIT 5";
                                 if($so_result = mysqli_query($link, $so_query)){
                                     if(mysqli_num_rows($so_result) > 0){

                                             while($so_row = mysqli_fetch_array($so_result)){

                                                 echo "<tr>";
                                                     echo "<td>" . $so_row['so_trans_id'] . "</td>";
                                                     echo "<td>" . $so_row['so_customer_name']  . "</td>";
                                                     echo "<td>  ₱ " . number_format($so_row['so_grand_total'],2) . "</td>";
                                                     echo "<td>" . $so_row['so_paymentTerms'] . "</td>";

                                                 echo "</tr>";
                                             }

                                         // Free result set
                                         mysqli_free_result($so_result);
                                     } else{
                                         echo "<p class='lead'><em>No records were found.</em></p>";
                                     }
                                 } else{
                                     echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                 }

                                 ?>
                                </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                <a href="product-add.php" class="btn btn-sm btn-info btn-flat pull-left">Create New Products</a>
                <a href="product-manage.php" class="btn btn-sm btn-default btn-flat pull-right">View All Products</a>
              </div>
              <!-- /.box-footer -->
            </div>
          </div> <!-- / col -->

          <!-- SO TABLE -->
          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Latest Sales Orders</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">SO Number</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Customer Name</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total Amount</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Payment Terms</th>
                      </tr>
                    </thead>
                    <tbody>
                                <?php
                                 // Attempt select query execution
                                 $so_query = "SELECT * FROM so_transactions ORDER BY so_trans_id DESC LIMIT 5";
                                 if($so_result = mysqli_query($link, $so_query)){
                                     if(mysqli_num_rows($so_result) > 0){

                                             while($so_row = mysqli_fetch_array($so_result)){

                                                 echo "<tr>";
                                                     echo "<td>" . $so_row['so_trans_id'] . "</td>";
                                                     echo "<td>" . $so_row['so_customer_name']  . "</td>";
                                                     echo "<td>  ₱ " . number_format($so_row['so_grand_total'],2) . "</td>";
                                                     echo "<td>" . $so_row['so_paymentTerms'] . "</td>";
                                             }

                                         // Free result set
                                         mysqli_free_result($so_result);
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
                <!-- /.table-responsive -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                <a href="SO-add.php" class="btn btn-sm btn-info btn-flat pull-left">Create New SO</a>
                <a href="SO-manage.php" class="btn btn-sm btn-default btn-flat pull-right">View All Sales Orders</a>
              </div>
              <!-- /.box-footer -->
            </div>

            
          </div> <!-- / col -->
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
