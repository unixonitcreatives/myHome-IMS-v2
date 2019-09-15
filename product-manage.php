<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
  $Admin_auth = 1;
  $Manager_auth = 1;
  $Accounting_auth = 1;
 include('template/user_auth.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MyHome | Product</title>
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
        Manage Product
        <small></small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="content">
      <?php  echo $_SESSION['usertype']; ?>
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Branch's Information</h3>
              <br><a href="branch-add.php" class="text-center">+ add new branch</a>
            </div>

            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Stock ID</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Category</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Sub-Category</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Branch</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Product Code</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Model</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Qty</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">SRP</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Remarks</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Include config file
                        require_once "config.php";

                        // Attempt select query execution
                        //$query = "SELECT inventory.inv_id,inventory.category,inventory.subCategory,inventory.branch_name,inventory.sku_code,inventory.model,inventory.retail_price,inventory.remarks, SUM(add_inv.add_inv_qty) AS stockCount FROM inventory JOIN add_inv WHERE add_inv.inv_id = inventory.inv_id GROUP BY inventory.inv_id";
                        $query = "SELECT * FROM inventory";
                        if($result = mysqli_query($link, $query)){
                          if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                              echo "<tr>";
                              echo "<td><a href='product-stocks.php?inv_id=". $row['inv_id'] ."' title='View History' data-toggle='tooltip'>" . $row['inv_id'] . "</a></td>";
                              echo "<td>" . $row['category'] . "</td>";
                              echo "<td>" . $row['subCategory'] . "</td>";
                              echo "<td>" . $row['branch_name'] . "</td>";
                              echo "<td>" . $row['sku_code'] . "</td>";
                              echo "<td>" . $row['model'] . "</td>";
                              echo "<td>" . $row['stock_qty'] . "</td>";
                              echo "<td>" . $row['retail_price'] . "</td>";
                              echo "<td>" . $row['remarks'] . "</td>";
                              echo "<td>";
                              echo "<a href='product-add-stocks.php?inv_id=". $row['inv_id'] ."&&sku_code=".$row['sku_code']."' title='Add Stocks' data-toggle='tooltip'><span class='glyphicon glyphicon-plus'></span></a>";
                              echo "&nbsp; <a href='product-update.php?inv_id=". $row['inv_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                              echo "&nbsp; <a href='product-delete.php?inv_id=". $row['inv_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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

</body>
</html>
