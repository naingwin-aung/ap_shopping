<?php
  session_start();
  require_once('../config/config.php');
  require_once('../config/common.php');

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location: /admin/login.php");
  }

  if($_SESSION['role'] != 1) {
    header('location: /admin/login.php');
  }

  if($_POST) {
    if(empty($_POST['name']) || empty($_POST['description'])) {
      if(empty($_POST['name'])) {
        $nameError = "Category Name is required";
      } 
      if(empty($_POST['description'])) {
        $descError = "Description is requried";
      }
    } else {
       $name = $_POST['name'];
       $desc = $_POST['description'];
       $id = $_GET['id'];

       $stm = $pdo->prepare("
        UPDATE categories SET name =:name, description =:description WHERE id = :id
       ");

       $stm->bindParam(":id", $id);
       $stm->bindParam(":name", $name);
       $stm->bindParam(":description", $desc);

       if($stm->execute()) {
         echo "<script>alert('Category update Success!'); window.location.href='category.php';</script>";
       }
    }
  }

  $stm = $pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
  if($stm->execute()) {
    $result = $stm->fetch(PDO::FETCH_ASSOC);
  }

?>

    <?php include_once('header.php'); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form action="cat_edit.php?id=<?php echo $result['id']; ?>" method="POST">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="">Name</label>
                    <p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError;?></p>
                    <input type="text" class="form-control" name="name" value="<?php echo escape($result['name']); ?>">
                  </div>

                  <div class="form-group">
                    <label for="">Description</label>
                    <p style="color:red;"><?php echo empty($descError) ? '' : '*'.$descError;?></p>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control"><?php echo escape($result['description']); ?></textarea>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-success">SUBMIT</button>
                    <a href="category.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>  
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <?php include('footer.html'); ?>

  