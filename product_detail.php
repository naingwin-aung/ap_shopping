<?php include('header.php') ?>
<?php require_once "config/config.php"; ?>
<?php require_once "config/common.php"; ?>
<!--================Single Product Area =================-->
<?php
  $stm = $pdo->prepare("
    SELECT * FROM product WHERE id = 
  ". $_GET['id']);
  if($stm->execute()) {
    $result = $stm->fetch(PDO::FETCH_ASSOC);
  }
?>
<div class="product_image_area">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <div class="s_Product_carousel">
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo $result['image'] ?>" alt="">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo $result['image'] ?>" alt="">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo $result['image'] ?>" alt="">
          </div>
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($result['name']) ?></h3>
          <h2><?php echo escape($result['price']) ?></h2>
          <ul class="list">
            <?php 
              $catstm = $pdo->prepare("
                SELECT * FROM categories
              ");
              if ($catstm->execute()) {
                $catResult = $catstm->fetchAll();
              }
            ?>
            <?php foreach($catResult as $val): ?>
              <?php if($val['id'] == $result['category_id']): ?>
            <li><a class="active" href="#"><span>Category</span> : <?php echo $val['name'] ?></a></li>
              <?php endif; ?>
            <?php endforeach; ?>
            
            <li><a href="#"><span>Availibility</span> : In Stock</a></li>
          </ul>
          <p><?php echo escape($result['description']) ?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
             class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
