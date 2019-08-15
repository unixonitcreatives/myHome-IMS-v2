<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<?php include('config.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 1;
$Accounting_auth = 0;
include('template/user_auth.php');

// Define variables and initialize with empty values
$inv_num=
$po_supplier_name=
$po_qty=
$po_unit=
$po_description=
$po_unit_price=
$po_total_amount=
$totalPrice=
$remarks=
$user=
$paymentTerms=
$transID=
$alertMessage="";


//If the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $po_supplier_name =$_POST['po_supplier'];
  $paymentTerms =$_POST['paymentTerms'];
  $totalPrice =$_POST['totalPrice'];

  $query = "INSERT INTO po_transactions (inv_date, supplier_name, paymentTerms, totalPrice, po_status) VALUES ( CURRENT_TIMESTAMP, '$po_supplier_name', '$paymentTerms', '$totalPrice', 1)";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));


  if ($result) {
    $j = 0;
    $count = sizeof($_POST['po_qty']);

    // Use insert_id property
    $po_trans_id = $link->insert_id;
    $user  = $_SESSION["username"];

    for ($j = 0; $j < $count; $j++) {

      $query = "INSERT INTO request_po (po_trans_id,po_qty,po_unit,po_description,po_unit_price,po_total_amount,user) VALUES (
        '".$po_trans_id."',
        '".$_POST['po_qty'][$j]."',
        '".$_POST['po_unit'][$j]."',
        '".$_POST['po_description'][$j]."',
        '".$_POST['po_unit_price'][$j]."',
        '".$_POST['po_total_amount'][$j]."',
        '".$user."')";

        if("" == trim($_POST['qty']))
        {

        }
        else {
          $result = mysqli_multi_query($link, $query) or die(mysqli_error($link));
        }

      }

      if($result){
        $alertMessage = "<div class='alert alert-success' role='alert'>
        New user successfully added in database.
        </div>";
      }else{
        $alertMessage = "<div class='alert alert-danger' role='alert'>
        Error Adding data in Database.
        </div>";}


        //mysqli_close($link);

      }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>MyHome | Purchase Order</title>
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
            <?php  echo $_SESSION['usertype']; ?>

            
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Purchase Order Form </h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <?php echo $alertMessage; ?>
                  <!-- ========================= FORM ============================ -->
                  <form class="form-vertical"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="createOrderForm">
                    <div class="col-md-6">
                      <!-- 1st column content -->

                      <div class="form-group">
                        <label>Supplier</label>
                        <select class="form-control"  name='po_supplier' onchange="showUser(this.value)">
                          <option>--SELECT SUPPLIER--</option>
                          <?php

                          $query = "select * from po_transactions";
                          $result = mysqli_query($link, $query);

                          $po_supplier_name = $_POST['supplier_name'];

                          while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $row['supplier_name']; ?>"><?php echo $row['supplier_name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Notes</label>
                        <input type="text" class="form-control" placeholder="Notes" name="paymentTerms">
                      </div>

                    </div>

                    <div class="col-md-12" ><!--id="txtHint"-->
                      <div class="table-responsive">
                        <table class="table" id="productTable">
                          <thead>
                            <tr>
                              <th>Model</th>
                              <th>Retail Price</th>
                              <th>Quantity</th>
                              <th>Total</th>
                              <th>Action</th>
                            </tr>
                          </thead>

                          <tbody>
                            <?php
                            $arrayNumber = 0;
                            for($x = 1; $x < 4; $x++){ ?><!-- for loop start -->
                              <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
                                <td>
                                  <div class="form-group">
                                    <select class="form-control" name="po_supplier[]" id="po_supplier<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)">
                                      <option value="">~~SELECT SUPPLIER~~</option>
                                      <?php
                                      $productSql = "SELECT * FROM inventory";
                                      $productData = $link->query($productSql);

                                      while($row = $productData->fetch_array()) {
                                        echo "<option value='".$row['inv_id']."' id='changeProduct".$row['inv_id']."'>".$row['product_description']."</option>";
                                      } // /while

                                      ?>
                                    </select>
                                  </div>
                                </td>
                                <td>
                                  <!--UNIT PRICE-->
                                  <input type="text" name="retail_price[]" id="retail_price<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />
                                  <input type="hidden" name="retailPriceValue[]" id="retailPriceValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
                                </td>
                                <td>
                                  <div class="form-group"><!--QTY-->
                                    <input type="number" name="qty[]" id="qty<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x; ?>)" autocomplete="off" class="form-control" min="1" />
                                  </div>
                                </td>
                                <td>
                                  <!--TOTAL PRICE-->
                                  <input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />
                                  <input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
                                </td>
                                <td>
                                  <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                </td>
                              </tr>

                              <?php $arrayNumber++; } ?> <!-- For Loop End -->
                            </tbody>
                            <tfoot>
                             
                                <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

                              <tr>
                                <td>
                                  <div class="form-group">
                                    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
                                      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tfoot>
                          </table>
                          <!--/table-->
                        </div>
                        <!--/table-responsive-->
                      </div>
                  </form>
                  <!-- ========================= /FORM ============================ -->
                </div>
                <!-- /.box-body -->
                  <div class="box-footer">
                      <!-- Buttons -->
                      <button type="submit" name="save" id="save" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success pull-right">Save</button>
                    </div>
                  <!-- .box-footer -->
                </div>
                <!-- /.box -->
              </section>
              <!-- /.content -->
            </div>
                <!-- /.content-wrapper -->

            <!-- =========================== FOOTER =========================== -->
            <footer class="main-footer">
              <?php include('template/footer.php'); ?>

            </footer>

</div>
<!-- ./wrapper -->
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

          <!--  <script>
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
          </script> -->

            <script src="dist/js/orderSample.js"></script>



          </body>
          </html>
