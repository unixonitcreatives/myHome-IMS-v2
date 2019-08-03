 <?php

  if($_SESSION["usertype"] == "Administrator"){
    include ('template/sidebar-admin.php');
  }
  else if($_SESSION["usertype"] == "Manager"){
    include ('template/sidebar-manager.php');
  }
  else if($_SESSION["usertype"] == "Accounting"){
    include ('template/sidebar-accounting.php');
  }
  else {
    header('location: logout.php');
    exit;
  }

  ?>