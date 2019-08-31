<aside class="main-sidebar">
    <section class="sidebar">
<div class="user-panel">
        <!-- <div class="pull-left image">
          <img src="dist/img/profile.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo htmlspecialchars($_SESSION["username"]); ?></p>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
           Status
=======
          <!-- Status
>>>>>>> parent of 548a919... update
=======
          <!-- Status
>>>>>>> parent of 548a919... update
=======
          <!-- Status
>>>>>>> parent of 548a919... update
          <a href="#"><i class="fa fa-circle text-success"></i> Online
          </a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- Optionally, you can add icons to the links -->
         <li class="active"><a href="index.php"><i class="fa fa-home"></i> <span>Admin Dashboard</span></a></li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-id-card-o"></i> <span>Suppliers</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="supplier-add.php">Add Suppliers</a></li>
                                <li><a href="supplier-manage.php">Manage Suppliers</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-th-large"></i> <span>Category</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="category-add.php">Add Categories</a></li>
                                <li><a href="category-manage.php">Manage Categories</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-archive"></i> <span>Branches</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="branch-add.php">Add Branches</a></li>
                                <li><a href="branch-manage.php">Manage Branches</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-cart-plus"></i> <span>Purchase Order</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <!-- <li><a href="PO-add.php">Add PO</a></li> -->
                                <li><a href="PO-request.php">Request PO</a></li>
                                <li><a href="PO-manage.php">Manage PO</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-cart-plus"></i> <span>Stocks</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <!-- <li><a href="PO-add.php">Add PO</a></li> -->
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                                <li><a href="product-add.php">Recieve Stocks</a></li>
                                <li><a href="product-manage.php">Manage Stocks</a></li>
=======
                                <li><a href="PO-request.php">Recieve Items</a></li>
                                <li><a href="PO-manage.php">Manage PO</a></li>
>>>>>>> parent of 548a919... update
=======
                                <li><a href="PO-request.php">Recieve Items</a></li>
                                <li><a href="PO-manage.php">Manage PO</a></li>
>>>>>>> parent of 548a919... update
=======
                                <li><a href="PO-request.php">Recieve Items</a></li>
                                <li><a href="PO-manage.php">Manage PO</a></li>
>>>>>>> parent of 548a919... update
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-cart-plus"></i> <span>Sales Order</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <!-- <li><a href="PO-add.php">Add PO</a></li> -->
                                <li><a href="SO-add.php">Create SO</a></li>
                                <li><a href="SO-manage.php">Manage SO</a></li>

                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-th"></i> <span>Products</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="product-add.php">Add Products</a></li>
                                <li><a href="product-manage.php">Manage Products</a></li>
                                <li><a href="product-aging.php">Aging Products</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-users"></i> <span>Customers</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="customer-add.php">Add Customers</a></li>
                                <li><a href="customer-manage.php">Manage Customers</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#"><i class="fa fa-user-circle-o"></i> <span>Personnel</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="user-add.php">Add Personnel</a></li>
                                <li><a href="user-manage.php">Manage Personnel</a></li>
                            </ul>
                        </li>

                        <li><a href="report.php"><i class="fa fa-pie-chart"></i> <span>Reports</span></a>
                        </li>

                        <li><a href="logout.php"><i class="fa fa-close"></i> <span>Logout</span></a>
                        </li>
                    </ul>
                </section>
            </aside>
