<!-- ======================= SESSION =================== -->
<?php include('template/session.php'); ?>
<?php include('config.php'); ?>
<!-- ======================= USER AUTHENTICATION  =================== -->
<?php
$Admin_auth = 1;
$Manager_auth = 1;
$Accounting_auth = 0;
include('template/user_auth.php');


/*$get_suppliers_id = $_GET['suppliers_id'];

$query = "SELECT * from suppliers WHERE suppliers_id='$get_suppliers_id'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)){
$supplier_name              =   $row['supplier_name'];
$supplier_contact_person    =   $row['supplier_contact_person'];
$supplier_email             =   $row['supplier_email'];
$supplier_number            =   $row['supplier_number'];
$supplier_address           =   $row['supplier_address'];
$created_at                 =   $row['created_at'];

}
}else {
$alertMessage="<div class='alert alert-danger' role='alert'>Theres Nothing to see Here.</div>";
}*/


$po_inv_date=$po_supplier_name=$po_notes=$po_totalPrice=$po_status=$po_trans_id=$po_model=$po_price=$po_qty=$po_total="";

//If the form is submitted
if($_SERVER['REQUEST_METHOD'] == "POST"){
  //po_transactions
  $po_inv_date;
  $po_supplier_name           =$_POST['po_supplier_name'];
  $po_notes                   =$_POST['po_notes'];
  $po_totalPrice              =$_POST['subTotal'];
  $po_status;

  //request_po



  //loggedin username
  $user = $_SESSION["username"];

  //INSERT query to so_transactions table
  $query = "INSERT INTO po_transactions (po_inv_date, po_supplier_name, po_notes, subTotal, po_status) VALUES (CURRENT_TIMESTAMP, '$po_supplier_name', '$po_notes', '$po_totalPrice', 1)";
  $result = mysqli_query($link, $query) or die(mysqli_error($link));

  if ($result) {
    $j = 0;

    //Counts the elements in array
    $count = count($_POST['po_model']);

    // Use insert_id property to get the id of previous table (po_transactions)
    $po_trans_id = $link->insert_id;

    for ($j = 0; $j < $count; $j++) {

      $query = "INSERT INTO request_po (po_trans_id, po_model, po_price, po_qty, po_total) VALUES (
        '".$po_trans_id."',
        '".$_POST['sup_prod_model'][$j]."',
        '".$_POST['po_price'][$j]."',
        '".$_POST['po_qty'][$j]."',
        '".$_POST['po_total'][$j]."')";


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
                <form class="form-vertical"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" ><!-- id="createOrderForm" -->
                  <div class="col-md-6">
                    <!-- 1st column content -->

                    <div class="form-group">
                      <label>Supplier</label>
                      <select class="form-control"  id="po_supplier_name" name="po_supplier_name">
                        <option value="">~~SELECT SUPPLIER~~</option>
                        <?php

                        $query = "SELECT suppliers_id, supplier_name FROM suppliers";
                        $result = $link->query($query);

                        //$po_supplier_name = $_POST['supplier_name'];

                        while ($row = $result->fetch_array()) { ?>
                          <option value="<?php echo $row['suppliers_id']; ?>"><?php echo $row['supplier_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Notes</label>
                      <input type="text" class="form-control" placeholder="Notes" name="po_notes">
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
                                    $productSql = "SELECT * FROM suppliers_products ";
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
                                <input type="number" name="po_price[]" id="po_price<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />
                                <!--<input type="hidden" name="po_priceValue[]" id="po_priceValue<?php echo $x; ?>" autocomplete="off" class="form-control" />-->
                              </td>
                              <td>
                                <div class="form-group"><!--QTY-->
                                  <input type="number" name="po_qty[]" id="po_qty<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x; ?>)" autocomplete="off" class="form-control" min="1" />
                                </div>
                              </td>
                              <td>
                                <!--TOTAL PRICE-->
                                <input type="number" name="po_total[]" id="po_total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />
                                <!--<input type="hidden" name="po_totalValue[]" id="po_totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />-->
                              </td>
                              <td>
                                <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                              </td>
                            </tr>

                            <?php $arrayNumber++; } ?> <!-- For Loop End -->
                          </tbody>

                          <tfoot>
                            <tr>
                              <td></td><td></td><td><label for="subTotal" class="pull-right">Sub Amount:</label></td>
                              <td>
                                <div class="form-group">
                                  <input type="number" class="form-control" id="subTotal" name="subTotal" disabled />
                                  <!--<input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />-->
                                </div>
                              </td>
                            </tr>
                          </tfoot>
                        </table>
                        <!-- /table -->
                      </div>
                      <!--/table-responsive-->
                      <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
                    </div>

                    <!-- ========================= /FORM ============================ -->
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <!-- Buttons -->
                    <button type="submit" name="save" id="save" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();" class="btn btn-success">Request</button>
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
