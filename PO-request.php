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
                        <small>asdasdas</small>
                    </h1>
                </section>
                <!-- ======================== MAIN CONTENT ======================= -->
                <!-- Main content -->
                <section class="content">
                    <?php  echo $_SESSION['usertype']; ?>

                    <!-- ========================= FORM ============================ -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Purchase Order Form </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <?php echo $alertMessage; ?>
                                <form class="form-vertical" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    <div class="col-md-6">
                                        <!-- 1st column content -->

                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <select class="form-control" style="width: 100%;" name='po_supplier' onchange="showUser(this.value)">
                                                <option>--SELECT SUPPLIER--</option>
                                                <?php
                                                
                                                include "config.php";
                                                
                                                $query = "select po_trans_id, supplier_name from po_transactions";
                                                $result = mysqli_query($link, $query);

                                                $po_supplier_name = $_POST['suppliername'];

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

                                    <div class="col-md-12" id="txtHint">
                                        <!-- 2nd row content -->

                                    </div>
                                    </div>
                            </div>
                            <div class="box-footer">
                                <!-- Buttons -->
                                <button type="submit" name="save" id="save" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success pull-right">Save</button>
                            </div>

                            </form>
                        <!-- ========================= /FORM ============================ -->
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
