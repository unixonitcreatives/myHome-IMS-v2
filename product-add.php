<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
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
        Add Product
        <small></small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="content">

          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Product's Information</h3>
              <br><a href="product-manage.php" class="text-center">View Stocks</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="row">

            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="col-md-6">
                    <!-- 1st column content -->
                    <div class="form-group">
                      <label>Supplier</label> <a href="supplier-add.php">+ add new</a>
                      <select class="form-control select2" style="width: 100%;" name="supplier_name" >
                        <?php
                        require_once "config.php";
                        $query = "select supplier_name from suppliers order by supplier_name";
                        $result = mysqli_query($link, $query);

                        $supplier_name = $_POST['supplier_name'];

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                          <option value="<?php echo $row['supplier_name']; ?>"><?php echo $row['supplier_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Category</label> <a href="category-add.php">+add new</a>
                      <select class="form-control select2" style="width: 100%;" name="category">
                        <?php
                        require_once "config.php";
                        $query = "select sup_prod_category from suppliers_products order by sup_prod_category";
                        $result = mysqli_query($link, $query);

                        $category = $_POST['sup_prod_category'];

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                          <option value="<?php echo $row['sup_prod_category']; ?>"><?php echo $row['sup_prod_category']; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Branch</label> <a href="branch-add.php">+add new</a>
                      <select class="form-control select2" style="width: 100%;" name="branch_name">
                        <?php
                        require_once "config.php";
                        $query = "select branch_name from branches order by branch_name";
                        $result = mysqli_query($link, $query);

                        $branch_name = $_POST['branch_name'];

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                          <option value="<?php echo $row['branch_name']; ?>"><?php echo $row['branch_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Product Code</label>
                      <select class="form-control select2" style="width: 100%;" name="pCode">
                        <?php
                        require_once "config.php";
                        $query = "select pCode from prod_code order by pCode";
                        $result = mysqli_query($link, $query);

                        $branch_name = $_POST['pCode'];

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                          <option value="<?php echo $row['pCode']; ?>"><?php echo $row['pCode']; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Model</label>
                      <select class="form-control select2" style="width: 100%;" name="model">
                        <?php
                        require_once "config.php";
                        $query = "select sup_prod_model from suppliers_products order by sup_prod_model";
                        $result = mysqli_query($link, $query);

                        $branch_name = $_POST['sup_prod_model'];

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                          <option value="<?php echo $row['sup_prod_model']; ?>"><?php echo $row['sup_prod_model']; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>PO Number</label>
                      <input type="number" class="form-control" placeholder="PO Number" name="po_number">
                    </div>

                    <div class="form-group">
                      <label>Quantity</label>
                      <input type="number" class="form-control" placeholder="Quantity" name="qty">
                    </div>

                    <div class="form-group">
                      <label>Retail Price</label>
                      <input type="number" class="form-control" placeholder="Retail Price" name="retail_price">
                    </div>

                    <div class="form-group">
                      <label>Supplier Price</label>
                      <input type="number" class="form-control" placeholder="Cost Price" name="cost_price">
                    </div>

                    <div class="form-group">
                      <label>Date Recieve</label>
                      <input type="date" class="form-control" placeholder="Date Receive" name="date_receive">
                    </div>

                  </div>
                </div>

              <!-- /.box-body -->
            </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" >Save</button>
              </div>
             </div>
            </form>
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
