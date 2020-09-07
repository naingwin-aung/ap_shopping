<?php
  session_start();
  require_once('../config/config.php');
  require_once('../config/common.php');

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location: login.php");
  }

  if($_SESSION['role'] != 1) {
    header('location: login.php');
  }
  
  if(!empty($_POST['search'])) {
    setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
  } else {
    if(empty($_GET['pageno'])) {
      unset($_COOKIE['search']);
      setcookie('search',null, -1, '/');
    }
  }
?>

    <!-- Main content -->
    <?php include_once('header.php'); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Listings</h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <a href="create.php" type="button" class="btn btn-success mb-4">New Blog Posts</a>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 160px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>

                
                
              </div>
              <!-- /.card-body -->
              
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <?php include('footer.html'); ?>

  