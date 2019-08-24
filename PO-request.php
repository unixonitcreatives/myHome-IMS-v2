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
                  <select class="form-control"  name='po_supplier'>
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
<?php include('template/js.php'); ?>






</body>
</html>
