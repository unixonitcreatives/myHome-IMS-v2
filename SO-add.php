<!-- ======================= SESSION =================== -->
<?php
include('config.php');

include('template/session.php');

//<!-- ======================= USER AUTHENTICATION  =================== -->

$Admin_auth = 1;
$Manager_auth = 0;
$Accounting_auth = 0;
include('template/user_auth.php');

//!---====================== REQUEST METHOD ====================-->

// Define variables and initialize with empty values
//for so_transaction table
$so_trans_id=
$so_date=
$so_customer_name=
$so_sub_total=
$so_paymentTerms=
$so_delivery_fee=
$so_discount=
$so_grand_total=
$so_remarks=
$alertMessage="";

//for so_items table
$so_request_id=
$so_trans_id=
$so_model=
$so_qty=
$so_unit=
$so_unit_price=
$so_total_amount="";

//for so_installments table
$so_date_receive=
$so_receive_payment=
$so_reference_id="";

//If the form is submitted
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $so_customer_name       =test_input($_POST['so_customer_name']);
  $so_sub_total           =test_input($_POST['so_sub_total']);
  $so_paymentTerms        =test_input($_POST['so_paymentTerms']);
  $so_delivery_fee        =test_input($_POST['so_delivery_fee']);
  $so_discount            =test_input($_POST['so_discount']);
  $so_grand_total         =test_input($_POST['so_grand_total']);
  $so_remarks             =test_input($_POST['so_remarks']);

  //loggedin username
  $user = $_SESSION["username"];

  //INSERT query to so_transactions table
  $query = "INSERT INTO so_transactions (so_date, so_customer_name, so_sub_total, so_paymentTerms, so_delivery_fee, so_discount, so_grand_total, so_remarks, so_user) VALUES (CURRENT_TIMESTAMP, '$so_customer_name', '$so_sub_total', '$so_paymentTerms', '$so_delivery_fee', '$so_discount', '$so_grand_total', '$so_remarks', '$user' )";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));

  if ($result) {
    $j = 0;

    //Counts the elements in array
    $count = count($_POST['so_model']);

    // Use insert_id property to get the id of previous table
    $so_trans_id = $link->insert_id;

    for ($j = 0; $j < $count; $j++) {

      $query = "INSERT INTO so_items (so_trans_id, so_model, so_qty, so_unit, so_unit_price, so_total_amount) VALUES (
        '".$so_trans_id."',
        '".$_POST['so_model'][$j]."',
        '".$_POST['so_qty'][$j]."',
        '".$_POST['so_unit'][$j]."',
        '".$_POST['so_unit_price'][$j]."',
        '".$_POST['so_total_amount'][$j]."')";

        $result = mysqli_multi_query($link, $query) or die(mysqli_error($link));

      }

      if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
        New Sales Order Created.
        </div>";
      }else{
        $alertMessage = "<div class='alert alert-danger' role='alert'>
        Error Creating Sales Order.
        </div>";}
        //INSERT query to so_transactions table end

      }
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    // Close connection
    //mysqli_close($link);
    ?>
    <!---====================== /REQUEST METHOD ====================-->
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>MyHome | Sales Order</title>
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
              Add Sales Order
              <small>asdasdas</small>
            </h1>
          </section>
          <!-- ======================== MAIN CONTENT ======================= -->
          <!-- Main content -->
          <section class="content">
            <?php  echo $_SESSION['usertype']; ?>
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Sales Order Form </h3>


              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <?php echo $alertMessage; ?>
                  <form class="form-vertical" enctype="multipart/form-data" method="POST" accept-charset="utf-8" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="col-md-6">
                      <!-- 1st column content -->
                      <div class="form-group">
                        <label class="text text-red">*</label>
                        <label>Name</label>
                        <select class="form-control select2" style="width: 100%;" id="" maxlength="50" placeholder="customer name" name="so_customer_name" required>
                          <option selected="selected">~~SELECT~~</option>
                          <?php

                          // Include config file
                          require_once "config.php";
                          // Attempt select query execution
                          // $query = "SELECT * FROM orders WHERE name LIKE '%$name%' AND item LIKE '%$item%' AND status LIKE '%$status%'";
                          $query = "SELECT customer_name FROM customers";
                          $result = mysqli_query($link, $query);

                          //$customer_name = $_POST['customer_name'];

                          while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" .$row['customer_name']. "'>" .$row['customer_name']. "</option>";
                          } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date" onload="getDate()" class="form-control" id="so_date"  name="so_date"  disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Payemt Terms</label>
                        <select class="form-control select2" style="width: 100%;" id="" maxlength="50" placeholder="customer name" name="so_paymentTerms" required>
                          <option value="">~~SELECT~~</option>
                          <option value="Fully Paid">Fully Paid</option>
                          <option value="Installment">Installment</option>
                          <option value="Credit Card">Credit Card</option>
                          <option value="Home Credit">Home Credit</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control"  name="so_remarks">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <!-- 2nd row content -->
                      <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table">
                          <tr>
                            <th width="18%">Model</th>
                            <th width="18%">Quantity</th>
                            <th width="18%">Unit</th>
                            <th width="18%">Unit Price</th>
                            <th width="18%">Amount</th>
                            <th width="10%"></th>
                          </tr>

                          <tr>
                            <td>
                              <div class="form-group">
                                <input type="text" class="form-control" id="so_model" name="so_model[]" placeholder="Model">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="number" class="form-control" id="so_qty" name="so_qty[]" placeholder="Product Qty">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <select class="form-control" id="so_unit" name="so_unit[]" placeholder="Product Unit">
                                  <option value="PC/S">pc/s</option>
                                  <option value="SET/S">set/s</option>
                                </select>
                              </div>
                            </td>

                            <td>
                              <div class="form-group">
                                <input type="number" class="form-control" id="so_unit_price" name="so_unit_price[]" placeholder="Product Unit Price">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="number" class="form-control so_total_amount" id="so_total_amount" name="so_total_amount[]" placeholder= "0.00" readonly>
                              </div>
                            </td>

                            <td>
                              <div align="right">
                                <button type="button" name="add" id="add" class="btn btn-success pull-left">Add Row</button>
                              </div>
                            </td>
                          </tr>
                          <tfoot >
                            <tr>
                              <td align="right" colspan="4">Delivery Fee:</td>
                              <td>
                                <div class="form-group">
                                  <input type="number" class="form-control" id="so_delivery_fee" name="so_delivery_fee" value="100" placeholder="0.00">
                                </div>
                              </td>
                              <td>

                              </td>
                            </tr>
                            <tr>
                              <td align="right" colspan="4">Sub Total Amount:</td>
                              <td>
                                <div class="form-group">
                                  <input type="number" class="form-control" id="so_sub_total" name="so_sub_total" placeholder="0.00" readonly>
                                </div>
                              </td>
                              <td>

                              </td>
                            </tr>


                            <tr>
                              <td align="right" colspan="4">Discount/s:</td>
                              <td>
                                <div class="form-group">
                                  <input type="number" class="form-control" id="so_discount" value="0" name="so_discount" placeholder="0.00">
                                </div>
                              </td>
                              <td>

                              </td>
                            </tr>
                            <tr>
                              <td align="right" colspan="4">Grand Total Amount:</td>
                              <td>
                                <div class="form-group">
                                  <input type="number" class="form-control" id="so_grand_total" name="so_grand_total" placeholder="0.00" readonly>
                                </div>
                              </td>
                              <td>

                              </td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <!-- Buttons -->

                  <button type="submit" name="saveBtn" id="saveBtn" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success pull-right">Save</button>

                </div>

              </form>

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
              html_code += "<td><input type='text' class='form-control' id='so_model' name='so_model[]' placeholder='model'></td>";
              html_code += "<td><input type='number' class='form-control' id='so_qty' name='so_qty[]' placeholder='Product Qty'></td>";
              html_code += "<td><select class='form-control' id='so_unit' name='so_unit[]' placeholder='Product Unit'><option value='PC/S'>pc/s</option><option value='SET/S'>set/s</option></select></td>";
              html_code += "<td><input type='number' class='form-control' id='so_unit_price' name='so_unit_price[]' placeholder='Product Unit Price'></td>";
              html_code += "<td><input type='number' class='form-control so_total_amount' id='so_total_amount' name='so_total_amount[]' placeholder='0.00' readonly></td>";
              html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-s remove'>-</button></td>";
              html_code += "</tr>";
              $('#crud_table').append(html_code);
            });
            $(document).on('click', '.remove', function(){
              var delete_row = $(this).data("row");
              $('#' + delete_row).remove();
            });


            $('#crud_table tbody').on('keyup change',function(){
              calc();
            });
            $('#so_grand_total').on('keyup change',function(){
              calc_total();
            });
            $('#so_delivery_fee').on('keyup change',function(){
              calc_total();
            });

            $('#so_discount').on('keyup change',function(){
              calc_total();
            });



          });

          $(document).ready(calculate);
          $(document).on("keyup", calculate);

          function calc()
          {
            $('#crud_table tbody tr').each(function(i, element) {
              var html = $(this).html();
              if(html!='')
              {
                var qty = $(this).find('#so_qty').val();
                var price = $(this).find('#so_unit_price').val();

                $(this).find('#so_total_amount').val(qty*price);

                calc_total();
              }
            });
          }

          function calc_total()
          {
            total=0;

            var deliveryFee = parseFloat(document.getElementById("so_delivery_fee").value);
            var disc = parseInt(document.getElementById("so_discount").value||0);
            var discount_total = disc;

            $('.so_total_amount').each(function() {
              total += parseInt($(this).val());
            });
            var discount_grand_total = total * discount_total;
            $('#so_sub_total').val((total+deliveryFee).toFixed(2));

            $('#so_grand_total').val(((total - disc) + deliveryFee).toFixed(2));

            //tax_sum=total/100*$('#tax').val();
            //$('#tax_amount').val(tax_sum.toFixed(2));
            //$('#total_amount').val((tax_sum+total).toFixed(2));
          }

          </script>
          <!-- /script for dynamic rows -->

          <!-- script for onload date -->
          <script>
          var field = document.querySelector('#so_date');
          var date = new Date();

          // Set the date
          field.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
          '-' + date.getDate().toString().padStart(2, 0);
        </script>
        <!-- /script for onload date -->
      </body>
      </html>
