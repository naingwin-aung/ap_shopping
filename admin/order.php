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
                <h3 class="card-title">Order Listings</h3>
              </div>
              <!-- /.card-header -->
              <?php 
                if(!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                } else {
                  $pageno = 1;
                }
                $numOfrecs = 4;
                $offset = ($pageno -1) * $numOfrecs;

                $stm = $pdo->prepare("
                SELECT * FROM sale_orders ORDER BY id DESC
                ");

                if($stm->execute()) {
                  $rawResult = $stm->fetchAll();
                }

                $total_pages = ceil(count($rawResult)/ $numOfrecs);

                $stm = $pdo->prepare("
                  SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$numOfrecs
                ");

                if($stm->execute()) {
                  $result = $stm->fetchAll();
                }
                               
              ?>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User</th>
                      <th>Total Price</th>
                      <th>Order Date</th>
                      <th style="width: 160px;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if($result): ?>
                      <?php $i= 1;?>  
                        <?php foreach($result as $results): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <?php
                                  $userstm = $pdo->prepare("
                                    SELECT * FROM users WHERE id =
                                  ".$results['user_id']);
                                  if($userstm->execute()) {
                                    $userResult = $userstm->fetch();
                                  }
                                ?>
                                <td><?php echo escape($userResult['name'])?></td>
                                <td>
                                  <?php echo escape($results['total_price'])?>
                                </td>
                                <td>
                                  <?php echo escape(date('d-m-Y'), strtotime($results['order_date']))?>
                                </td>
                                <td>
                                  <a href="order_detail.php?id=<?php echo $results['id'];?>" type="button"
                                  class="btn btn-warning">View Detail</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>  
                  </tbody>
                </table>
                <div class="float-right">
                  <nav aria-label= "Page navigation example" class="mt-4">
                      <ul class="pagination">
                          <li class="page-item"> <a href="?pageno=1" class="page-link">First</a></li>
                          <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>"> 
                            <a href="<?php if($pageno <= 1){echo '#';} else {echo '?pageno='.($pageno-1);}?>" class="page-link">Previous</a>
                          </li>
                          <li class="page-item"> <a href="#" class="page-link"><?php echo $pageno; ?></a></li>
                          <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>"> 
                            <a href="<?php if($pageno >=$total_pages){echo '#';} else {echo '?pageno='.($pageno+1);}?>" class="page-link">Next</a>
                          </li>
                          <li class="page-item"> <a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
                      </ul>
                  </nav>
                </div>
                               
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

  