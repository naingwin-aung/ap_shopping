<?php
    include_once "header.php";
    include_once "config/config.php";
?>
    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $total = 0;
                                foreach ($_SESSION['cart'] as $key => $qty) : 
                                    $id = str_replace('id','',$key);

                                    $stm = $pdo->prepare("
                                        SELECT * FROM product WHERE id =
                                    ". $id);

                                        $stm->execute();
                                        $result = $stm->fetch(PDO::FETCH_ASSOC);
                                        $total += $result['price'] * $qty;
                                ?>

                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin/images/<?php echo $result['image'] ?>" alt="" height="200">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo escape($result['name']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price']) ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" value="<?php echo $qty ?>" 
                                        title="Quantity:" class="input-text qty" readonly>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price'] * $qty)?></h5>
                                </td>
                                <td>
                                    <a href="cart_item_clear.php?pid=<?php echo $result['id'] ?>" 
                                    class="primary-btn" style="line-height: 30px; border-radius: 10px">Clear</a>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                            
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo $total ?></h5>
                                </td>
                            </tr>
                            
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="clearall.php">Clear All</a>
                                        <a class="gray_btn" href="index.php">Continue Shopping</a>
                                        <a class="primary-btn" href="sale_order.php">Order Submit</a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
    <?php include_once "footer.php" ?>
    <!-- End footer Area -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
