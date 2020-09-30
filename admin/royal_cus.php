<?php
  session_start();
  require_once('../config/config.php');
  require_once('../config/common.php');

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location: /admin/login.php");
  }

  if($_SESSION['role'] != 1) {
    header("location: /admin/login.php");
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
                <h3 class="card-title">Weekly Reports</h3>
              </div>
        <?php
         $stmt = $pdo->prepare('SELECT * FROM sale_orders GROUP BY user_id HAVING SUM(total_price)>=60000 ORDER BY  id DESC');
         $stmt->execute();
         $result= $stmt->fetchAll();
        ?>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="product_add.php" type="button" class="btn btn-success mb-4">Create New Product</a>
                <table id="d-table" class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User Name</th>
                      <th>Total Amount</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if($result): ?>
                      <?php $i= 1;?>  
                        <?php foreach($result as $results): ?>
                        <?php
                          $userstm = $pdo->prepare("
                            SELECT * FROM users WHERE id =  
                          ".$results['user_id']);
                          if($userstm->execute()) {
                            $userResult = $userstm->fetch();
                          }
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo escape($userResult['name'])?></td>
                                <td>
                                  <?php echo escape($results['total_price'])?>
                                </td>
                                <td>
                                  <?php echo escape(date("d-m-Y", strtotime($results['order_date'])))?>
                                </td>
                                
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>                 
                    <?php endif; ?>    
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
  <script>
    $(document).ready(function() {
      $('#d-table').DataTable({
        "pagingType": "full_numbers";
    });
    } );
  </script>

                           