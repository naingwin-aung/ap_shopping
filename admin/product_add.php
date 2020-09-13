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

  if($_POST) {
    if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category'])
    || empty($_POST['quantity']) || empty($_POST['price']) || empty($_FILES['image'])) {

      if(empty($_POST['name'])) {
        $nameError = "Category Name is required";
      } 
      if(empty($_POST['description'])) {
        $descError = "Description is requried";
      }

      if(empty($_POST['category'])) {
        $catError = "Category is requried";
      }

      if(empty($_POST['quantity'])) {
        $qtyError = "Quantity is requried";
      }elseif((is_numeric($_POST['quantity']) != 1) || $_POST['quantity'] < 0) {
        $qtyError = 'Quantity should be integer value';
      }

      if(empty($_POST['price'])) {
        $priceError = "Price is requried";
      }elseif((is_numeric($_POST['price']) != 1) || $_POST['price'] < 0) {
        $priceError = 'Price should be integer value';
      }

      if(empty($_FILES['image'])) {
        $imageError = "Image is requried";
      }
    } else {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file, PATHINFO_EXTENSION);

      if($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
        echo "<script>alert('Image must be jpg, png, jpeg!')</script>";
      }else {//image validation success
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $category = $_POST['category'];
        $qty = $_POST['quantity'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];

        move_uploaded_file($_FILES['image']['tmp_name'], $file);

        $stm = $pdo->prepare("
          INSERT INTO product (name, description, category_id, price, quantity, image) VALUES
          (:name, :description, :category, :price, :quantity, :image)
        ");
        $stm->bindParam(":name", $name);
        $stm->bindParam(":description", $desc);
        $stm->bindParam(":category", $category);
        $stm->bindParam(":price", $price);
        $stm->bindParam(":quantity", $qty);
        $stm->bindParam(":image", $image);
        
        if ($stm->execute()) {
          header("location: index.php");
        }
      }
    }
  }

?>

    <?php include_once('header.php'); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form action="product_add.php" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="">Name</label>
                    <p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError;?></p>
                    <input type="text" class="form-control" name="name">
                  </div>

                  <div class="form-group">
                    <label for="">Description</label>
                    <p style="color:red;"><?php echo empty($descError) ? '' : '*'.$descError;?></p>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <?php
                            $catstm = $pdo->prepare("
                              SELECT * FROM categories");
                            if($catstm->execute()) {
                              $catResult = $catstm->fetchAll();
                            }
                    ?>
                    <label for="">Category</label>
                    <p style="color:red;"><?php echo empty($catError) ? '' : '*'.$catError;?></p>
                    <select name="category" class="form-control">
                      <option value="" disabled selected>SELECT CATEGOTY</option>

                      <?php foreach($catResult as $value) :?>
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="">Quantity</label>
                    <p style="color:red;"><?php echo empty($qtyError) ? '' : '*'.$qtyError;?></p>
                    <input type="number" class="form-control" name="quantity">
                  </div>

                  <div class="form-group">
                    <label for="">Price</label>
                    <p style="color:red;"><?php echo empty($priceError) ? '' : '*'.$priceError;?></p>
                    <input type="number" class="form-control" name="price">
                  </div>

                  <div class="form-group">
                    <label for="">Upload Image</label>
                    <p style="color:red;"><?php echo empty($imageError) ? '' : '*'.$imageError;?></p>
                    <input type="file" class="form-control" name="image">
                  </div>

                  <div class="form-group">
                    <button class="btn btn-success">SUBMIT</button>
                    <a href="index.php" class="btn btn-warning">Back</a>
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

  