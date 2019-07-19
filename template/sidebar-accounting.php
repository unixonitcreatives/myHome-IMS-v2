
<div class="user-panel">
        <!-- <div class="pull-left image">
          <img src="dist/img/profile.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo htmlspecialchars($_SESSION["username"]); ?></p>
          <!-- Status
          <a href="#"><i class="fa fa-circle text-success"></i> Online
          </a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- Optionally, you can add icons to the links -->
         <li class="active"><a href="index.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-cart-plus"></i> <span>Purchase Order</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="accounting-PO-manage.php">Manage PO</a></li>

                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-th"></i> <span>Products</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="accounting-product-manage.php">Manage Products</a></li>
                                <li><a href="accounting-product-aging.php">Aging Products</a></li>
                            </ul>
                        </li>

                        <li><a href="accounting-report.php"><i class="fa fa-pie-chart"></i> <span>Reports</span></a>
                        </li>

                        <li><a href="support.php"><i class="fa fa-superpowers"></i> <span>Support</span></a>
                        </li>
                        <li><a href="logout.php"><i class="fa fa-superpowers"></i> <span>Logout</span></a>
                        </li>
                    </ul>
