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
                <h3 class="card-title">Product Listings</h3>
              </div>
        <?php 
          if(!empty($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
          } else {
            $pageno = 1;
          }
          $numOfrecs = 10;
          $offset = ($pageno -1) * $numOfrecs;

          if(empty($_POST['search']) && empty($_COOKIE['search'])){
              $stm = $pdo->prepare("
              SELECT * FROM product ORDER BY id DESC
              ");

              if($stm->execute()) {
                $rawResult = $stm->fetchAll();
              }

              $total_pages = ceil(count($rawResult)/ $numOfrecs);

              $stm = $pdo->prepare("
                SELECT * FROM product ORDER BY id DESC LIMIT $offset,$numOfrecs
              ");

              if($stm->execute()) {
                $result = $stm->fetchAll();
              }
          } else {
              $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
              $stm = $pdo->prepare("
              SELECT * FROM product WHERE name LIKE '%$searchKey%' ORDER BY id DESC
              ");

              if($stm->execute()) {
                $rawResult = $stm->fetchAll();
              }

              $total_pages = ceil(count($rawResult)/ $numOfrecs);

              $stm = $pdo->prepare("
              SELECT * FROM product WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs
              ");

              if($stm->execute()) {
                $result = $stm->fetchAll();
              }
          }
          
        ?>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="product_add.php" type="button" class="btn btn-success mb-4">Create New Product</a>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>In Stock</th>
                      <th>Price</th>
                      <th style="width: 160px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($result): ?>
                      <?php $i= 1;?>  
                        <?php foreach($result as $results): ?>
                        <?php
                          $catstm = $pdo->prepare("
                            SELECT * FROM categories WHERE id =
                          ".$results['category_id']);
                          if($catstm->execute()) {
                            $catResult = $catstm->fetchAll();
                          }
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo escape($results['name'])?></td>
                                <td>
                                  <?php echo escape(substr($results['description'], 0, 20))?>
                                </td>
                                <td>
                                  <?php echo escape($catResult[0]['name'])?>
                                </td>
                                <td>
                                  <?php echo escape($results['quantity'])?>
                                </td>
                                <td>
                                  <?php echo escape($results['price'])?>
                                </td>
                                
                                <td>
                                  <a href="product_edit.php?id=<?php echo $results['id'];?>" type="button" 
                                  class="btn btn-warning">Edit</a>
                                  <a href="product_delete.php?id=<?php echo $results['id'];?>" 
                                  onclick="return confirm('Are you sure you want to delete this item')"
                                  type="button" class="btn btn-danger">Delete</a>
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

                           