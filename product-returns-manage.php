<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 1;
$Accounting_auth = 0;
include('template/user_auth.php');
?>

<?php
$alertMessage="";

if(isset($_GET['alert'])){
  if ($_GET['alert'] == 'deletesuccess'){
    $alertMessage = "<div class='alert alert-danger' role='alert'>Data Deleted.</div>";
  }elseif ($_GET['alert'] == 'success'){
    $alertMessage = "<div class='alert alert-success' role='alert'>Data Successfully Updated.</div>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Returned</title>
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
          Manage Returned Stocks
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
        <?php echo $alertMessage; ?>
        <!-- general form elements -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Returned Stocks Information</h3>
            <br><a href="product-returns-add.php" class="text-center">+ New Returned Stocks</a>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">
            <div class="row">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Returned Stock ID</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Series No</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Model</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Qty</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Product Code</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Model</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Qty</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Amount</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total Amount</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">GPL Amount</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total GPL</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Pickup Date</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Returned Date</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Order No</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Reason</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Actions</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Include config file
                  require_once "config.php";

                  // Attempt select query execution
                  //$query = "SELECT inventory.inv_id,inventory.category,inventory.subCategory,inventory.branch_name,inventory.sku_code,inventory.model,inventory.retail_price,inventory.remarks, SUM(add_inv.add_inv_qty) AS stockCount FROM inventory JOIN add_inv WHERE add_inv.inv_id = inventory.inv_id GROUP BY inventory.inv_id";
                  $query = "SELECT * FROM returns ORDER BY return_id DESC";
                  if($result = mysqli_query($link, $query)){
                    if(mysqli_num_rows($result) > 0){
                      while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>" . $row['return_id'] . "</td>";
                        echo "<td>" . $row['r_seriesNum'] . "</td>";
                        echo "<td>" . $row['r_model'] . "</td>";
                        echo "<td>" . $row['r_qty'] . "</td>";
                        echo "<td>" . $row['r_amount'] . "</td>";
                        echo "<td>" . $row['r_totalAmount'] . "</td>";
                        echo "<td>" . $row['r_gpl'] . "</td>";
                        echo "<td>" . $row['r_totalGpl'] . "</td>";
                        echo "<td>" . $row['r_pickDate'] . "</td>";
                        echo "<td>" . $row['r_returnDate'] . "</td>";
                        echo "<td>" . $row['r_orderNum'] . "</td>";
                        echo "<td>" . $row['r_reason'] . "</td>";
                        echo "<td>";
                        echo "&nbsp; <a href='product-returns-update.php?return_id=". $row['return_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                        echo "&nbsp; <a href='product-returns-delete.php?return_id=". $row['return_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
            <!-- /row -->
          </div>
          <!-- /.box -->

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
