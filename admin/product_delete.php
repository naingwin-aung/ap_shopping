<?php
  require_once "../config/config.php";

  $stm = $pdo->prepare("
    DELETE FROM product WHERE id=
  ".$_GET['id']);

  if($stm->execute()) {
    header("location: index.php");
  }