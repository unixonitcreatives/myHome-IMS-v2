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

require_once "config.php";

$sup_prod_date=
$suppliers_id=
$sup_prod_model=
$sup_prod_category=
$sup_prod_subCategory=
$sup_prod_price=
$sup_prod_srp=
$get_suppliers_name=
$alertMessage="";

$get_suppliers_id   = $_GET['suppliers_id'];
$get_suppliers_name = $_GET['supplier_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $sup_prod_date = $_POST['sup_prod_date'];

  $j = 0;

  //Counts the elements in array
  $count = count($_POST['sup_prod_model']);


  for ($j = 0; $j < $count; $j++) {

    $query = "INSERT INTO  suppliers_products (suppliers_id, sup_prod_model, sup_prod_category, sup_prod_subCategory, sup_prod_price, sup_prod_srp, sup_prod_date) VALUES (
      '".$get_suppliers_id."',
      '".$_POST['sup_prod_model'][$j]."',
      '".$_POST['sup_prod_category'][$j]."',
      '".$_POST['sup_prod_subCategory'][$j]."',
      '".$_POST['sup_prod_price'][$j]."',
      '".$_POST['sup_prod_srp'][$j]."',
      '".$sup_prod_date."')";

      $result = mysqli_multi_query($link, $query) or die(mysqli_error($link));

    }

    if($result){
      $alertMessage = "<div class='alert alert-success' role='alert'>
      Products added successfully.
      </div>";
    }else{
      $alertMessage = "<div class='alert alert-danger' role='alert'>
      Error adding data.
      </div>";}
      //INSERT query to so_transactions table end


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
      <title>MyHome | Supplier</title>
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
              Add Supplier Products
              <small></small>
            </h1>
          </section>
          <!-- ======================== MAIN CONTENT ======================= -->
          <!-- Main content -->
          <section class="content">

            <!-- general form elements -->
            <div class="box box-success">
                <?php echo $alertMessage;?>
              <div class="box-header with-border">
                <h3>Supplier Name:&nbsp;<?php echo $get_suppliers_name; ?></h3>
                <a href="supplier-manage.php" class="text-center">View Suppliers</a>
              </div>

              <!-- /.box-header -->
              <!-- form start -->

              <div class="box-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?suppliers_id=<?php echo $get_suppliers_id; ?>" method="post">
                  <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                      <label>Date:</label>
                      <input type="date" class="form-control" id="sup_prod_req_date" name="sup_prod_date" />
                    </div>
                  </div>
                    <!--====== Products Table =====-->
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table">
                          <tr style="text-align: center;">
                            <th>Product Model</th>
                            <th>Category</th>
                            <th>Sub-Category</th>
                            <th>Price</th>
                            <th>Retail Price</th>
                            <th></th>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-group">
                                <input type="text" class="form-control" id="sup_prod_model" name="sup_prod_model[]" placeholder="Product Model">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="text" class="form-control" id="sup_prod_category" name="sup_prod_category[]" placeholder="Product Category">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="text" class="form-control" id="sup_prod_subCategory" name="sup_prod_subCategory[]" placeholder="Product Sub-Category">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="number" class="form-control" id="sup_prod_price" name="sup_prod_price[]" placeholder="Product Price">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="number" class="form-control" id="sup_prod_srp" name="sup_prod_srp[]" placeholder= "Retail Price">
                              </div>
                            </td>
                            <td>
                              <div align="right">
                                <button type="button" name="add" id="add" class="btn btn-success pull-left">Add Row</button>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <!--====== /Products Table =====-->
                      </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                      <button type="submit" id="addProducts" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success pull-right">Add Products</button>
                    </div>
                  </form>
                </div>

                <!-- /.box -->

              </div>
              <!-- /.content -->

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
            $('.select2').select2()
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

          <!-- script for dynamic rows -->
          <!-- Add Rows -->
          <script>
          $(document).ready(function(){
            var count = 1;
            $('#add').click(function(){
              count = count + 1;
              var html_code = "<tr id='row"+count+"'>";
              html_code += "<td><input type='text' class='form-control' id='sup_prod_model' name='sup_prod_model[]' placeholder='Product Model'></td>";
              html_code += "<td><input type='text' class='form-control' id='sup_prod_category' name='sup_prod_category[]' placeholder='Product Category'></td>";
              html_code += "<td><input type='text' class='form-control' id='sup_prod_subCategory' name='sup_prod_subCategory[]' placeholder='Product Sub-Category'></td>";
              html_code += "<td><input type='number' class='form-control' id='sup_prod_price' name='sup_prod_price[]' placeholder='Product Price'></td>";
              html_code += "<td><input type='number' class='form-control' id='sup_prod_srp' name='sup_prod_srp[]' placeholder='Retail Price'></td>";
              html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-s remove'>-</button></td>";
              html_code += "</tr>";
              $('#crud_table').append(html_code);
            });
            $(document).on('click', '.remove', function(){
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });
          });
          </script>
          <!-- /script for dynamic rows -->

        </body>
        </html>
