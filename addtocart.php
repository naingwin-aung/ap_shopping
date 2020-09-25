<?php
  session_start();
  require_once "config/config.php";

  if ($_POST) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $stm = $pdo->prepare("
      SELECT * FROM product 
      ");

    if($stm->execute()) {
      $result = $stm->fetch(PDO::FETCH_ASSOC);
    }

    if ($qty > $result['quantity']) {
      echo "<script>alert('Not enough stock');
      window.location.href='product_detail.php?id=$id'</script>";
    } else {
      if(isset($_SESSION['cart']['id'.$id])) {
        $_SESSION['cart']['id'.$id] += $qty;
      } else {
        $_SESSION['cart']['id'.$id] = $qty;
      }
  
      header("Location: cart.php");
    }
  }