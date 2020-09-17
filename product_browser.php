    <?php include('header.php') ?>
				<?php
				
					require_once('config/config.php');

          if(!empty($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
          } else {
            $pageno = 1;
          }
          $numOfrecs = 3;
          $offset = ($pageno -1) * $numOfrecs;

          if ($_GET) {
              $stm = $pdo->prepare("
                SELECT * FROM product WHERE category_id = :id
              ");
              $stm->bindParam(":id", $_GET['id']);

              if($stm->execute()) {
                $rawResult = $stm->fetchAll();
              }

              $total_pages = ceil(count($rawResult)/ $numOfrecs);

              $stm = $pdo->prepare("
                SELECT * FROM product WHERE category_id = :id ORDER BY id DESC LIMIT $offset, $numOfrecs
              ");
              $stm->bindParam(":id", $_GET['id']);

              if($stm->execute()) {
                $result = $stm->fetchAll();
							}
          }
          
				?>
				<div class="container">
				<div class="row">
					<div class="col-xl-3 col-lg-4 col-md-5">
						<div class="sidebar-categories">
							<div class="head">Browse Categories</div>
							<ul class="main-categories">
								<li class="main-nav-list">
									<?php
										$catstm = $pdo->prepare("
											SELECT * FROM categories ORDER BY id DESC
										");
										if ($catstm->execute()) {
											$catResult = $catstm->fetchAll();
										}
									?>

									<?php foreach($catResult as $val) : ?>
										<a href="product_browser.php?id=<?php echo $val['id']; ?>">
											<span class="lnr lnr-arrow-right"></span><?php echo escape($val['name']); ?>
										</a>
									<?php endforeach; ?>
								</li>
							</ul>
						</div>
					</div>
			<div class="col-xl-9 col-lg-8 col-md-7">							
				<div class="filter-bar d-flex flex-wrap align-items-center">
						<div class="pagination">
						<a href="?pageno=1">
							First
						</a>

							<a <?php if($pageno <= 1){echo 'disabled';} ?> href="<?php if($pageno <= 1){echo '#';} 
							else {echo '?pageno='.($pageno-1);}?>"
							 class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>

							<a <?php if($pageno >= $total_pages){echo 'disabled';} ?> href="#" class="active">
							<?php echo $pageno; ?></a>
							<a href="<?php if($pageno >=$total_pages){echo '#';} else {echo '?pageno='.($pageno+1);}?>"
							 class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>

							 <a href="?pageno=<?php echo $total_pages; ?>">
								Last
							</a>
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						<?php if ($result): ?>
							<?php foreach ($result as $results): ?>
								<div class="col-lg-4 col-md-6">
								<div class="single-product">
									<img class="img-fluid" src="admin/images/<?php echo escape($results['image']) ?>" 
									style="height: 300px;">
									<div class="product-details">
										<h6><?php echo escape($results['name']) ?></h6>
										<div class="price">
											<h6><?php echo escape($results['price']) ?></h6>
										</div>
										<div class="prd-bottom">

											<a href="" class="social-info">
												<span class="ti-bag"></span>
												<p class="hover-text">add to bag</p>
											</a>
											<a href="product_detail.php?id=<?php echo $results['id'] ?>" class="social-info">
												<span class="lnr lnr-move"></span>
												<p class="hover-text">view more</p>
											</a>
										</div>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>
						
					</div>
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>

  