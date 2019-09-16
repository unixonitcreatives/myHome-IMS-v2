<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
  $Admin_auth = 1;
  $Manager_auth = 0;
  $Accounting_auth = 0;
 include('template/user_auth.php');

$alertMessage="";

 if(isset($_GET['alert'])){
     if( $_GET['alert'] == 'receive'){
         $alertMessage = "<div class='alert alert-success' role='alert'>Receive Payment Successful</div>";
     }elseif ($_GET['alert'] == 'deletesuccess'){
         $alertMessage = "<div class='alert alert-danger' role='alert'>Data deleted.</div>";
     }elseif ($_GET['alert'] == 'success'){
         $alertMessage = "<div class='alert alert-success' role='alert'>Product Delivered Succefully.</div>";
     }
 }

?>

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
              <br><a href="pCode-add.php" class="text-center">+ add new Sub-category</a>
            </div>
            <?php echo $alertMessage; ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                      <thead>
                        <tr>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Category Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Include config file
                        require_once "config.php";

                        // Attempt select query execution
                        $query = "SELECT * FROM subCategory order by subCategory Desc";
                        if($result = mysqli_query($link, $query)){
                          if(mysqli_num_rows($result) > 0){
                            $j = 0;
                            while($row = mysqli_fetch_array($result)){
                              $j += 1;
                              echo "<tr id='".$row['subCategory_ID']."'>";
                              echo "<td>" . $row['subCategory'] . "</td>";
                              echo "<td>";
                              echo "<a href='sub-category-update.php?subCategory_ID=". $row['subCategory_ID'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                              echo " &nbsp; <a href='sub-category-delete.php?subCategory_ID=". $row['subCategory_ID'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash remove'></span></a>";
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
      </div>
    </section>
  <!-- /.content-wrapper -->
</div>
<!-- =========================== MODAL =========================== -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose words. You can add words, delete words </h4>
      </div>
      <div class="modal-body">
      <div class="modal-body-inner">

      </div>
      </div>
      <div class="modal-footer">
        <button type="button" id = "modelformbuttonclick" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- =========================== FOOTER =========================== -->
  <footer class="main-footer">
      <?php include('template/footer.php'); ?>
  </footer>


<!-- =========================== JAVASCRIPT ========================= -->
      <?php include('template/js.php'); ?>

</body>
</html>
