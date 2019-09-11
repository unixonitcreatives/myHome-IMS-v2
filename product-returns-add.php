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
require_once "config.php";

$alertMessage=$category=$subCategory=$branch=$pCode=$model=$poNum=$qty=$srp=$date=$remarks="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $category = test_input($_POST['category']);
    $subCategory = test_input($_POST['subCategory']);
    $branch = test_input($_POST['branch_name']);
    $pCode = test_input($_POST['pCode']);
    $model = test_input($_POST['model']);
    $poNum = test_input($_POST['po_number']);
    $qty = test_input($_POST['qty']);
    $srp = test_input($_POST['retail_price']);
    $date = test_input($_POST['date_receive']);
    $remarks = test_input($_POST['remarks']);

    $query = "INSERT INTO inventory (category, subCategory, branch_name, sku_code, model, po_number, qty, retail_price, date_arriv, remarks) VALUES ('$category', '$subCategory', '$branch', '$pCode', '$model', '$poNum', '$qty', '$srp', '$date', '$remarks')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if($result){
         $alertMessage = "<div class='alert alert-success' role='alert'>
                            New branch successfully added in Database.
                          </div>";
    }else {
        $alertMessage = "<div class='alert alert-danger' role='alert'>
                            Error Adding data in Database.
                          </div>";
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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
        <?php echo $alertMessage; ?>
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
                  <div class="form-group">
                    <label>Category</label>
                    <select class="form-control select2" style="width: 100%;" name="category">
                      <?php

                      $query = "select sup_prod_category from suppliers_products order by sup_prod_category";
                      $result = mysqli_query($link, $query);

                      //$category = $_POST['sup_prod_category'];

                      while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['sup_prod_category']; ?>"><?php echo $row['sup_prod_category']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Sub-Category</label> <a href="sub-category-add.php">+add new</a>
                    <select class="form-control select2" style="width: 100%;" name="subCategory">
                      <?php

                      $query = "select subCategory from subCategory order by subCategory";
                      $result = mysqli_query($link, $query);

                      //$category = $_POST['sup_prod_category'];

                      while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['subCategory']; ?>"><?php echo $row['subCategory']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Branch</label> <a href="branch-add.php">+add new</a>
                    <select class="form-control select2" style="width: 100%;" name="branch_name">
                      <?php

                      $query = "select branch_name from branches order by branch_name";
                      $result = mysqli_query($link, $query);

                      //$branch_name = $_POST['branch_name'];

                      while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['branch_name']; ?>"><?php echo $row['branch_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Product Code</label>
                    <select class="form-control select2" style="width: 100%;" name="pCode">
                      <?php

                      $query = "select pCode from prod_code order by pCode";
                      $result = mysqli_query($link, $query);

                      while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['pCode']; ?>"><?php echo $row['pCode']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Model</label>
                    <select class="form-control select2" style="width: 100%;" name="model">
                      <?php

                      $query = "select sup_prod_model from suppliers_products order by sup_prod_model";
                      $result = mysqli_query($link, $query);


                      while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['sup_prod_model']; ?>"><?php echo $row['sup_prod_model']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>PO Number</label>
                    <select class="form-control select2" style="width: 100%;" name="po_number">
                      <?php

                      $query = "select po_trans_id from po_transactions order by po_trans_id desc";
                      $result = mysqli_query($link, $query);


                      while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['po_trans_id']; ?>"><?php echo $row['po_trans_id']; ?></option>
                      <?php } ?>
                    </select>
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
                    <label>Date Recieve</label>
                    <input type="date" class="form-control" placeholder="Date Receive" name="date_receive" id="pfDate">
                  </div>

                  <div class="form-group">
                    <label>Remarks</label>
                    <input type="text" class="form-control" placeholder="Remarks" name="remarks">
                  </div>

                </div>
              </div>
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
