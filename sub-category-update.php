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
$addSuccess=$users_id=$alertMessage=$emptyMessage="";

require_once "config.php";

$users_id = $_GET['subCategory_ID'];
$query = "SELECT * from subCategory WHERE subCategory_ID='$users_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $subCat              =   $row['subCategory'];
    }
}else {
    $alertMessage="<div class='alert alert-danger' role='alert'>Theres Nothing to see Here.</div>";
}
//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Assigning posted values to variables.
    $subCat = test_input($_POST['subCategory']);
    // Validate category
    if(empty($subCat)){
        $emptyMessage = "Please enter a Sub-category.";
    }
    // Check if input has no errors before inserting in database
    if(empty($emptyMessage)){
    //Checking the values are existing in the database or not
    $query = "UPDATE subCategory SET subCategory='$subCat' WHERE subCategory_ID='$users_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Sub-category data successfully updated in database.
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

// Close connection
mysqli_close($link);
?>
<!-- ======================================================= -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MyHome | Sub-category</title>
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
        Manage Sub-category
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
              <h3 class="box-title">Sub-category</h3>
              <br><a href="sub-category-manage.php" class="text-center">View Sub-category</a>

            </div>
            <?php echo $alertMessage; ?>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?subCategory_ID=<?php echo $users_id; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Sub-category</label>
                  <input type="text" class="form-control" placeholder="Sub-category" oninput="upperCaseF(this)" name="subCategory" value="<?php echo $subCat; ?>"required>
                </div>
              <!-- /.box-body -->
             </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
    <!-- /.content -->
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
