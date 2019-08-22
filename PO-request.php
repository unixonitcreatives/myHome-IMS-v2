<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<?php include('config.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 1;
$Accounting_auth = 0;
include('template/user_auth.php');

$suppliers_product_id="";

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
                   <!-- <?php echo $alertMessage; ?> -->
                  <!-- ========================= FORM ============================ -->
                  <form class="form-vertical"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="createOrderForm">
                    <div class="col-md-6">
                      <!-- 1st column content -->

                      <div class="form-group">
                        <label>Supplier</label>
                        <select class="form-control"  name='po_supplier' onchange="showUser(this.value)">
                          <option>~~SELECT SUPPLIER~~</option>
                          <?php

                          $query = "select * from suppliers";
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
                              <th>Price</th>
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
                                    <select class="form-control" name="sup_prod_model[]" id="sup_prod_model<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)">
                                      <option value="">~~SELECT MODEL~~</option>
                                      <?php
                                      $productSql = "SELECT * FROM suppliers_products";
                                      $productData = $link->query($productSql);

                                      while($row = $productData->fetch_array()) {
                                        echo "<option value='".$row['suppliers_product_id']."' id='changeProduct".$row['suppliers_product_id']."'>".$row['sup_prod_model']."</option>";
                                      } // /while

                                      ?>
                                    </select>
                                  </div>
                                </td>
                                <td>
                                  <!--UNIT PRICE-->
                                  <input type="text" name="po_price[]" id="po_price<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />
                                  <input type="hidden" name="po_priceValue[]" id="po_priceValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
                                </td>
                                <td>
                                  <div class="form-group"><!--QTY-->
                                    <input type="number" name="po_qty[]" id="po_qty<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x; ?>)" autocomplete="off" class="form-control" min="1" />
                                  </div>
                                </td>
                                <td>
                                  <!--TOTAL PRICE-->
                                  <input type="text" name="po_total[]" id="po_total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />
                                  <input type="hidden" name="po_totalValue[]" id="po_totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
                                </td>
                                <td>
                                  <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                                </td>
                              </tr>

                              <?php $arrayNumber++; } ?> <!-- For Loop End -->
                            </tbody>
                              </table>
                              <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
                            <!--<tfoot>



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
                          /table-->
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
            <!-- <?php include('template/js.php'); ?> -->


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




          <!-- Latest compiled and minified JavaScript -->
          <script type="text/javascript" src="dist/js/orderSample.js"></script>
          <script type="text/javascript" src="dist/js/jquery.min.js"></script>
          <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
          <script src="https://ajax.googleapis.com/ajax/libs/d3js/5.9.0/d3.min.js"></script>
          <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
          <script src="dist/js/bootstrap.min.js"></script>
          <script src="bower_components/jquery/dist/jquery.min.js"></script>
          <!-- Bootstrap 3.3.7 -->
          <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
          <!-- Select2 -->
          <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
          <!-- InputMask -->
          <script src="plugins/input-mask/jquery.inputmask.js"></script>
          <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
          <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
          <!-- date-range-picker -->
          <script src="bower_components/moment/min/moment.min.js"></script>
          <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
          <!-- bootstrap datepicker -->
          <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
          <!-- bootstrap color picker -->
          <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
          <!-- bootstrap time picker -->
          <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
          <!-- SlimScroll -->
          <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
          <!-- iCheck 1.0.1 -->
          <script src="plugins/iCheck/icheck.min.js"></script>
          <!-- FastClick -->
          <script src="bower_components/fastclick/lib/fastclick.js"></script>
          <!-- AdminLTE App -->
          <script src="dist/js/adminlte.min.js"></script>
          <!-- AdminLTE for demo purposes -->
          <script src="dist/js/demo.js"></script>
          <!-- DataTables -->
          <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
          <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

          </body>
          </html>
