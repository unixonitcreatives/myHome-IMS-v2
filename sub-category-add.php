<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
  $Admin_auth = 1;
  $Manager_auth = 0;
  $Accounting_auth = 0;
 include('template/user_auth.php');
?>
<!-- ========================== ADD FORM TO THE DATABASE ====================================== -->
<?php
// Define variables and initialize with empty values
$subCat=$alertMessage=$emptyMessage="";

require_once "config.php";

//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //Assigning posted values to variables.
  $subCat = test_input($_POST['subCategory']);

    // Validate category

    if(empty($subCat)){
        $emptyMessage = "Please enter a subCategory.";
    }


    // Check input if no errors before inserting in database
    if(empty($emptyMessage)){

      //Checking the values are existing in the database or not
    $query = "INSERT INTO subCategory (subCategory) VALUES ('$subCat')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if($result){
      $alertMessage = "<div class='alert alert-success' role='alert'>
New Sub-category successfully added in database.
</div>";

    }else{
        $alertMessage = "<div class='alert alert-danger fade in' role='alert'>
  Error Adding data in Database.
</div>";}

    }
    mysqli_close($link);
  }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!-- ================================================================ -->

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
        Add Sub-category
        <small></small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="content">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-success">
            <?php echo $alertMessage; ?>
            <div class="box-header with-border">
              <h3 class="box-title">Sub-category</h3>
              <br><a href="sub-category-manage.php" class="text-center">View Sub-categories</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="box-body">
                  <div class="form-group">
                  <label>Sub-category</label>
                  <input type="text" class="form-control" placeholder="Sub-category" oninput="upperCaseF(this)" name="subCategory" required>
                </div>
                <?php echo $emptyMessage; ?>
            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" >Save</button>
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
