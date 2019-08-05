

<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<?php include('config.php'); ?>
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
  <title>MyHome | Purchase Order</title>
  <script src="jquery-1.11.1.min.js"></script>         
  <script type="text/javascript">
        $(function () {
            $('.pnm, .price, .subtot, .grdtot').prop('readonly', true);
            var $tblrows = $("#example2 tbody tr");

            $tblrows.each(function (index) {
                var $tblrow = $(this);

                $tblrow.find('.qty').on('change', function () {

                    var qty = $tblrow.find("[name=qty]").val();
                    var price = $tblrow.find("[name=price]").val();
                    var subTotal = parseInt(qty, 10) * parseFloat(price);

                    if (!isNaN(subTotal)) {

                        $tblrow.find('.subtot').val(subTotal.toFixed(2));
                        var grandTotal = 0;

                        $(".subtot").each(function () {
                            var stval = parseFloat($(this).val());
                            grandTotal += isNaN(stval) ? 0 : stval;
                        });

                        $('.grdtot').val(grandTotal.toFixed(2));
                    }
                });
            });
        });
    </script>
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
          Purchase Order Request
          <small></small>
        </h1>
      </section>
      <!-- ======================== MAIN CONTENT ======================= -->
      <!-- Main content -->
      <section class="content">
      <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">

              <?php
              $users_id = $_GET['id'];
              $query = "SELECT * from suppliers WHERE id='$users_id'";
              $result = mysqli_query($link, $query) or die(mysqli_error($link));
              if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)){
                      $supplier_name = $row['supplier_name'];
                  }
              }else {
                  echo "Theres nothing to see here.";
              }
              ?>

              <h3 class="box-title">Supplier: <?php echo $supplier_name; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                      <thead>
                        <tr>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">No</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Product Name</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Category</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Model No.</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Stock Count</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Quantity</th>
                          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Cost Price</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Include config file
                        require_once "config.php";

                        // Attempt select query execution
                        $query = "SELECT * FROM inventory WHERE supplier_name = '$supplier_name' ";
                        if($result = mysqli_query($link, $query)){
                          if(mysqli_num_rows($result) > 0){
                            $j = 0;
                            while($row = mysqli_fetch_array($result)){
                              $j += 1;
                              echo "<tr>";
                              echo "<td> $j </td>";
                              echo "<td>" . $row['product_description'] . "</td>";
                              echo "<td>" . $row['category'] . "</td>";
                              echo "<td>" . $row['model'] . "</td>";
                              echo "<td>" . $row['qty'] . " pc(s)</td>";
                              if($row['qty'] <= 0){
                              echo "<td><input type='text' class='form-control qty' name='qty' value='No Stock Count' disabled/></td>";
                              } else {
                              echo "<td><input type='text' class='form-control qty' name='qty' value='' /></td>";
                              }

                              echo "<td><input type='text' class='form-control price' name='price' value='".$row['cost_price']."'></td>";

                              
                              echo "<td><input type='text' class='form-control subtot' name='subtot' type='text' value='0' /></td>";

                              echo "</tr>";
                            }

                              echo "<tfoot>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td>Grand Total:</td>";
                              echo "<td><input class='form-control grdtot' type='text' value='0' /></td>";
                              echo "</tfoot>";
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
              <!-- /.box-body -->
            </div>
              <div class="box-footer">
                <button type="button" onclick="siteRedirect()" class="btn btn-success">Proceed</button>
                <script>
                  function siteRedirect() {
                    var selectbox = document.getElementById("selectSupplier");
                    var selectedValue = selectbox.options[selectbox.selectedIndex].value;
                    console.log(selectedValue);
                    window.location.href = selectedValue;
                  }

                </script>

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

      <script>
      function showUser(str) {
        if (str == "") {
          document.getElementById("txtHint").innerHTML = "";
          return;
        } else {
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
          } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("txtHint").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("GET","PO-add-4.php?q="+str,true);
          xmlhttp.send();
        }
      }


      </script>




    </body>
    </html>