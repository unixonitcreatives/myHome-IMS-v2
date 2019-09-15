<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<?php include('config.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 1;
$Accounting_auth = 0;
include('template/user_auth.php');



//so_items
$so_trans_id=$so_model=$so_qty=$so_unit_price=$price=$so_total_amount=$so_date_delivered=$alertMessage="";

//so_transactions
$so_date=$so_customer_name=$so_sub_total=$so_paymentTerms=$so_deliveryFee=$so_grand_total=$so_staff=$so_remarks=$so_user="";

require_once "config.php";


//If the form is submitted
if($_SERVER['REQUEST_METHOD'] == "POST"){

  $so_customer_name               =$_POST['so_customer_name'];
  $so_sub_total                   =$_POST['so_sub_totalValue'];
  $so_paymentTerms                =$_POST['so_paymentTerms'];
  $so_deliveryFee                 =$_POST['so_delivery_fee'];
  $so_grand_total                 =$_POST['so_grand_totalAmount'];
  $so_staff                       =$_POST['so_staff'];
  $so_remarks                     =$_POST['so_remarks'];


  //loggedin username
  $user = $_SESSION["username"];

  //INSERT query to so_transactions table
  $query = "INSERT INTO so_transactions (so_date, so_customer_name, so_sub_total, so_paymentTerms, so_delivery_fee, so_grand_total, so_staff, so_remarks, so_user) VALUES (CURRENT_TIMESTAMP, '$so_customer_name', '$so_sub_total', '$so_paymentTerms', '$so_deliveryFee', '$so_grand_total', '$so_staff', '$so_remarks', '$user')";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));

  if ($result) {
    $j = 0;

    //Counts the elements in array
    $count = count($_POST['so_model']);

    // Use insert_id property to get the id of previous table (po_transactions)
    $so_trans_id = $link->insert_id;

    for ($j = 0; $j < $count; $j++) {

      $query = "SELECT stock_qty FROM inventory WHERE inv_id='".$_POST['so_model'][$j]."'";
      $updateProductQuantityData = $link->query($query);

        while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()){
          $updateQty[$j] = $updateProductQuantityResult[0] - $_POST['so_qty'][$j];
          //update add_inv
          $update_table_query = "UPDATE inventory SET stock_qty='".$updateQty[$j]."' WHERE inv_id = '".$_POST['so_model'][$j]."' ";
          $link->query($update_table_query);

            //add order in so_items table
            $insert_order_query = "INSERT INTO so_items (so_trans_id, so_model, so_unit_price, so_qty, price, so_total_amount, so_date_delivered) VALUES (
              '".$so_trans_id."',
              '".$_POST['so_model'][$j]."',
              '".$_POST['so_unit_priceValue'][$j]."',
              '".$_POST['so_qty'][$j]."',
              '".$_POST['price'][$j]."',
              '".$_POST['so_totalValue'][$j]."',
              NULL)";

              $insert_order_query_result = mysqli_multi_query($link, $insert_order_query) or die(mysqli_error($link));
              //INSERT query to so_transactions table end
              if($insert_order_query_result){
                $alertMessage = "<div class='alert alert-success' role='alert'>
                New Sales Order Created.
                </div>";

              }else{
                $alertMessage = "<div class='alert alert-danger' role='alert'>
                Error Creating Sales Order.
                </div>";}

          }// /while

      }// /for
    }// /if(result)
  }// /POST


    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    // Close connection
    //mysqli_close($link);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>MyHome | Sales Order Form</title>
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
              Sales Order Request
              <small></small>
            </h1>
          </section>
          <!-- ======================== MAIN CONTENT ======================= -->
          <!-- Main content -->
          <section class="content">
            <?php  echo $_SESSION['usertype']; ?>

            <?php echo $alertMessage; ?>
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Sales Order Form </h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- <?php echo $alertMessage; ?> -->
                <!-- ========================= FORM ============================ -->
                <form class="form-vertical"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" ><!-- id="createOrderForm" -->
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
                      <label class="text text-red">*</label>
                      <label>Date</label>
                      <input type="date" onload="getDate()" class="form-control" id="so_date"  disabled>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text text-red">*</label>
                      <label>Payment Method</label>
                      <select class="form-control select2" style="width: 100%;" id="" maxlength="50" placeholder="customer name" name="so_paymentTerms" required>
                        <option value="">~~SELECT~~</option>
                        <option value="Fully Paid">Fully Paid</option>
                        <option value="Installment">Installment</option>
                        <option value="Home Credit">Home Credit</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text text-red">*</label>
                      <label>Sales Person</label>
                      <select class="form-control select2" style="width: 100%;" id="" maxlength="50" placeholder="customer name" name="so_staff" required>
                        <option selected="selected">~~SELECT~~</option>
                        <?php

                        // Include config file
                        require_once "config.php";
                        // Attempt select query execution
                        // $query = "SELECT * FROM orders WHERE name LIKE '%$name%' AND item LIKE '%$item%' AND status LIKE '%$status%'";
                        $query = "SELECT username FROM users WHERE usertype = 'Sales' ";
                        $result = mysqli_query($link, $query);

                        //$customer_name = $_POST['customer_name'];

                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='" .$row['username']. "'>" .$row['username']. "</option>";
                        } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Note</label>
                      <input type="text" class="form-control"  name="so_remarks">
                    </div>
                  </div>

                  <div class="col-md-12" ><!--id="txtHint"-->
                    <div class="table-responsive">
                      <table class="table" id="soproductTable">
                        <thead>
                          <tr>
                            <th>Product Code</th>
                            <th>SRP Price</th>
                            <th>Quantity</th>
                            <th>Price</th>
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
                                  <select class="form-control" name="so_model[]" id="so_model<?php echo $x; ?>" onchange="sogetProductData(<?php echo $x; ?>)">
                                    <option value="">~~SELECT MODEL~~</option>
                                    <?php
                                    $productSql = "SELECT * FROM inventory ";
                                    $productData = $link->query($productSql);

                                    while($row = $productData->fetch_array()) {
                                      echo "<option value='".$row['inv_id']."' id='changeProduct".$row['inv_id']."'>".$row['sku_code']."</option>";
                                    } // /while

                                    ?>
                                  </select>
                                </div>
                              </td>
                              <td>
                                <!--UNIT PRICE-->
                                <input type="text" name="so_unit_price[]" id="so_unit_price<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />
                                <input type="hidden" name="so_unit_priceValue[]" id="so_unit_priceValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
                              </td>
                              <td>
                                <div class="form-group"><!--QTY-->
                                  <input type="number" name="so_qty[]" id="so_qty<?php echo $x; ?>" onkeyup="sogetTotal(<?php echo $x; ?>)" autocomplete="off" class="form-control" min="1" />
                                </div>
                              </td>
                              <td>
                                <input type="text" name="price[]" id="price<?php echo $x; ?>" onkeyup="sogetTotal(<?php echo $x; ?>)" autocomplete="off" class="form-control" />
                              </td>
                              <td>
                                <!--TOTAL PRICE-->
                                <input type="text" name="so_total_amount[]" id="so_total_amount<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />
                                <input type="hidden" name="so_totalValue[]" id="so_totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
                              </td>
                              <td>
                                <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                              </td>
                            </tr>

                            <?php $arrayNumber++; } ?> <!-- For Loop End -->
                          </tbody>

                          <tfoot>
                            <tr>
                              <td></td><td></td><td></td><td><label for="subTotal" class="pull-right">Sub Amount:</label></td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" id="so_sub_total" name="so_sub_total" disabled />
                                  <input type="hidden" class="form-control" id="so_sub_totalValue" name="so_sub_totalValue" />
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td></td><td></td><td></td><td><label for="subTotal" class="pull-right">Delivery Fee:</label></td>
                              <td>
                                <div class="form-group">
                                  <input type="number" class="form-control" id="so_delivery_fee" name="so_delivery_fee" onchange="delFee()" value="0.00"/>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td></td><td></td><td></td><td><label for="subTotal" class="pull-right">Grand Total Amount:</label></td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" id="so_grand_total" name="so_grand_total" disabled />
                                  <input type="hidden" class="form-control" id="so_grand_totalAmount" name="so_grand_totalAmount" />
                                </div>
                              </td>
                            </tr>
                          </tfoot>
                        </table>
                        <!-- /table -->
                      </div>
                      <!--/table-responsive-->
                      <button type="button" class="btn btn-default" onclick="soAddRow()" id="soAddRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
                    </div>

                    <!-- ========================= /FORM ============================ -->
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <!-- Buttons -->
                    <button type="submit" name="save" id="save" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success">Create</button>
                    <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Clear</button>
                  </div>
                </form>
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



      </body>
      </html>
