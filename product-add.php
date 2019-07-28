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
        <small>asdasdas</small>
      </h1>
    </section>
  <!-- ======================== MAIN CONTENT ======================= -->
    <!-- Main content -->
    <section class="content">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Product's Information</h3>
              <br><a href="product-manage.php" class="text-center">View Products</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="row">

            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="col-md-6">
                    <!-- 1st column content -->
                    <div class="form-group">
                      <label>Supplier</label> <a href="supplier-add.php">+ add new product</a>
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
                        $query = "select category from categories order by category";
                        $result = mysqli_query($link, $query);

                        $category = $_POST['category'];

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                          <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
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
                      <label>Product Description</label>
                      <input type="text" class="form-control" placeholder="Product Description" name="product_description">
                    </div>

                    <div class="form-group">
                      <label>Model</label>
                      <input type="text" class="form-control" placeholder="Model No." name="model">
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
                      <label>Date Arrival</label>
                      <input type="date" class="form-control" placeholder="Date Arrival" name="date_arriv">
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


<!-- =========================== PAGE SCRIPT ======================== -->

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

<script>
  $(function () {
    //Initialize Select2 Elements
    //$('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

<script>
  //uppercase text box
  function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
</script>

</body>
</html>
