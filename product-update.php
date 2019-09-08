<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
  $Admin_auth = 1;
  $Manager_auth = 0;
  $Accounting_auth = 0;
 include('template/user_auth.php');
?>
<!-- ======================= UPDATE  =================== -->
<?php
$addSuccess=$users_id=$alertMessage=$emptyMessage=$category=$subCategory=$branch=$pCode=$model=$poNum=$qty=$srp=$date=$remarks="";

require_once "config.php";

$inv_id = $_GET['inv_id'];
$query = "SELECT * from inventory WHERE inv_id='$inv_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
      $category     = $row['category'];
      $subCategory  = $row['subCategory'];
      $branch       = $row['branch_name'];
      $pCode        = $row['sku_code'];
      $model        = $row['model'];
      $poNum        = $row['po_number'];
      $qty          = $row['qty'];
      $srp          = $row['retail_price'];
      $date         = $row['date_arriv'];
      $remarks      = $row['remarks'];
    }
}else {
    $alertMessage="<div class='alert alert-danger' role='alert'>Theres Nothing to see Here.</div>";
}
//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Assigning posted values to variables.
    $category     = test_input($_POST['category']);
    $subCategory  = test_input($_POST['subCategory']);
    $branch       = test_input($_POST['branch_name']);
    $pCode        = test_input($_POST['pCode']);
    $model        = test_input($_POST['model']);
    $poNum        = test_input($_POST['po_number']);
    $qty          = test_input($_POST['qty']);
    $srp          = test_input($_POST['retail_price']);
    $date         = test_input($_POST['date_receive']);
    $remarks      = test_input($_POST['remarks']);


    // Validation
    if (empty($category)){
        $emptyMessage = "Please enter a category.";
    }
    if (empty($subCategory)){
        $emptyMessage = "Please enter a sub-category.";
    }
    if (empty($branch)){
        $emptyMessage = "Please enter a branch.";
    }
    if (empty($pCode)){
        $emptyMessage = "Please enter a product code.";
    }
    if (empty($model)){
        $emptyMessage = "Please enter a model.";
    }
    if (empty($poNum)){
        $emptyMessage = "Please enter a po-number.";
    }
    if (empty($qty)){
        $emptyMessage = "Please enter a qty.";
    }
    if (empty($srp)){
        $emptyMessage = "Please enter a srp.";
    }
    if (empty($date)){
        $emptyMessage = "Please enter a date recieve.";
    }
    if (empty($remarks)){
        $emptyMessage = "Please enter a remarks.";
    }


    // Check if input has no errors before inserting in database
    if(empty($emptyMessage)){
    //Checking the values are existing in the database or not
    $query = "UPDATE inventory SET category='$category', subCategory='$subCategory', branch_name='$branch', sku_code='$pCode', model='$model', po_number='$poNum', qty='$qty', retail_price='$srp', date_arriv='$date', remarks='$remarks' WHERE inv_id='$inv_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Stocks data successfully updated in database.
</div>";
    }else {
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Error updating record.
</div>";
    }
}
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>
<!-- ======================================================= -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MyHome | Stock Update</title>
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
        Stock Update
        <small></small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="content">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Stock Update</h3>
              <br><a href="product-manage.php" class="text-center">View Stocks</a>

            </div>
            <?php echo $alertMessage; ?>
            <!-- /.box-header -->

              <div class="box-body">
                <div class="row">
                  <!-- form start -->
                  <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?inv_id=<?php echo $inv_id; ?>">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Category</label>
                        <select class="form-control select2" style="width: 100%;" name="category">
                          <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
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
                          <option value="<?php echo $subCategory; ?>"><?php echo $subCategory; ?></option>
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
                          <option value="<?php echo $branch; ?>"><?php echo $branch; ?></option>
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
                          <option value="<?php echo $pCode; ?>"><?php echo $pCode; ?></option>
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
                          <option value="<?php echo $model; ?>"><?php echo $model; ?></option>
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
                          <option value="<?php echo $poNum; ?>"><?php echo $poNum; ?></option>
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
                        <input type="number" class="form-control" placeholder="Quantity" name="qty" value="<?php echo $qty; ?>">
                      </div>

                      <div class="form-group">
                        <label>Retail Price</label>
                        <input type="number" class="form-control" placeholder="Retail Price" name="retail_price" value="<?php echo $srp; ?>">
                      </div>

                      <div class="form-group">
                        <label>Date Recieve</label>
                        <input type="date" class="form-control" placeholder="Date Receive" name="date_receive" id="pfDate" value="<?php echo $date; ?>">
                      </div>

                      <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" placeholder="Remarks" name="remarks" value="<?php echo $remarks; ?>">
                      </div>

                    </div>
                  </div>

                <div class="box-footer">
                  <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" >Save</button>
                </div>
              </div>
            </form>
          </div>
            <!-- /.box-body -->
</section>
  <!-- /.content-wrapper -->
</div>
<!-- =========================== MODAL =========================== -->


<!-- =========================== FOOTER =========================== -->
  <footer class="main-footer">
      <?php include('template/footer.php'); ?>
  </footer>


<!-- =========================== JAVASCRIPT ========================= -->
      <?php include('template/js.php'); ?>


</body>
</html>
