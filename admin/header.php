<?php
  require_once('../config/common.php');
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Ap Shopping</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars">
        </i></a>
      </li>
    </ul>

    <?php 
      $link = $_SERVER['PHP_SELF'];
      $link_array = explode('/',$link);
      $page = end($link_array);
    ?>

  <?php if($page == 'index.php' || $page== 'category.php' || $page == 'user.php') : ?>
    <!-- SEARCH FORM -->
    <?php if($page != 'order.php' && $page != 'weekly_report.php' && $page != 'monthly_report.php' && $page != 'royal_cus.php' && $page != 'best_seller.php') : ?>
      <form class="form-inline ml-3" method="POST"
        <?php if($page == 'index.php') : ?>
          action = "index.php";
        <?php elseif($page == 'category.php'):?>
          action = "category.php";
        <?php elseif($page == 'user.php'):?>
          action = "user.php";
        <?php endif; ?>
      >
      <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
        <div class="input-group input-group-sm">
          <input name="search" class="form-control form-control-navbar" type="search"
          placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    <?php endif; ?>
  <?php endif; ?>
  
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

      <img src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"

           style="opacity: .8">
      <span class="brand-text font-weight-light">Apshopping</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
  
        <div class="info">
          <a href="#" class="d-block"> <?php echo ucfirst($_SESSION['user_name']); ?></a>

       
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="/admin/index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Products 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/category.php" class="nav-link">
              <i class="fas fa-list"></i>
              <p>
                Categories 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/order.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Order 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/user.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users 
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly report</p>
                </a>
              </li><li class="nav-item">
                <a href="royal_cus.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customer</p>
                </a>
              </li><li class="nav-item">
                <a href="best_seller_item.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Seller</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    </div>
    <!-- /.content-header -->