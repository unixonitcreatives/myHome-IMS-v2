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
