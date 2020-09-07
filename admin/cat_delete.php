<?php
  require_once('../config/config.php');

  $stm = $pdo->prepare("DELETE FROM categories WHERE id=".$_GET['id']);

  if($stm->execute()) {
    header("location: category.php");
  }