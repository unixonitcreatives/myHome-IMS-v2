<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<?php include('config.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 1;
$Accounting_auth = 0;
include('template/user_auth.php');
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Purchase Order</title>
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
          Purchase Order Request
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
      <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Select Supplier</h3>

            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <div class="box-body">
                <div class="form-group">
                   <select id="selectSupplier" class="form-control" style="width: 100%;" name='po_supplier' onchange="requestPO();">

                      <?php
                      $query = "SELECT supplier_name, suppliers_id FROM suppliers ORDER BY supplier_name";
                      $result = mysqli_query($link, $query);
                      while ($row = mysqli_fetch_assoc($result)) {
                         echo "<option value='PO-request.php?suppliers_id=".$row['suppliers_id']." && name=".$row['supplier_name']."'>".$row['supplier_name']."</option>";

                        } ?>
                   </select>
                </div>
              <!-- /.box-body -->
            </div>
              <div class="box-footer">


                <button type="button" onclick="siteRedirect()" class="btn btn-success">Proceed</button>
                <script>
                  function siteRedirect() {
                    var selectbox = document.getElementById("selectSupplier");
                    var selectedValue = selectbox.options[selectbox.selectedIndex].value;
                    console.log(selectedValue);
                    window.location.href = selectedValue;
                  }
                </script>

              </div>
            </form>
          </div>
          <!-- /.box -->


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
