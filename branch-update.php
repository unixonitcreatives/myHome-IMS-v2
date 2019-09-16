<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$branchName=$branchAddress=$alertMessage=$created_at="";

require_once "config.php";

$users_id = $_GET['id'];
$query = "SELECT * from branches WHERE id='$users_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)){
        $branchName              =   $row['branch_name'];
        $branchAddress           =   $row['branch_address'];
        $created_at              =   $row['created_at'];
    }
}else {
    $alertMessage="<div class='alert alert-danger' role='alert'>Theres Nothing to see Here.</div>";
}

//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Assigning posted values to variables.
    $branchName = test_input($_POST['branch_name']);
    $branchAddress = test_input($_POST['branch_address']);

    // Validate category
    if(empty($branchName)){
        $alertMessage = "Please enter a branch name.";
    }

    // Validate category
    if(empty($branchAddress)){
        $alertMessage = "Please enter a branch address.";
    }

    // Check input errors before inserting in database
    if(empty($alertMessage)){
    //Checking the values are existing in the database or not
    $query = "UPDATE branches SET branch_name='$branchName', branch_address='$branchAddress' WHERE id='$users_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
  Branch data successfully updated in database.
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

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Add Branch</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-green fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>I</b>MS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>MyHome</b>IMS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="profile.php" class="icon-bar">
              <span class="hidden-xs">Hello, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
            </a>
          </li>

          <li class="dropdown user user-menu">
            <a href="logout.php" class="icon-bar">
              <span class="hidden-xs">Log out</span>
            </a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    <?php include ('template/sidebar-admin.php'); ?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        UPDATE BRANCH
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard active"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
<section class="content">
    <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Branch's Information</h3>
              <p><a href="branch-manage.php">View Branches</a></p>
            </div>
            <!-- /.box-header -->
            <?php echo $alertMessage; ?>
            <!-- form start -->
            <form  method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $users_id; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label>Branch Name</label>
                  <input type="text" class="form-control" placeholder="Branch Name" name="branch_name" value="<?php echo $branchName; ?> "required>
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" placeholder="Address" name="branch_address" value="<?php echo $branchAddress; ?> "required>
                </div>

                <div class="form-group">
                  <label>Created At</label>
                  <input type="text" class="form-control" placeholder="Created at" name="created_at" value="<?php echo $created_at; ?> " disabled>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
              </div>
            </form>
          </div>
          <!-- /.box -->


        </div>
    <!-- /.content -->
  </div>
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
      <?php include('template/footer.php'); ?>
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- Alert animation -->
<script type="text/javascript">
$(document).ready(function () {

  window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
      $(this).remove();
    });
  }, 1000);

});
</script>
</body>
</html>
