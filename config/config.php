<?php
     define('MYSQL_USER','root');
     define('MYSQL_PASSWORD','root');
     define('MYSQL_HOST','localhost');
     define('MYSQL_DBNAME','ap_shopping');

    $options = array(
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    );

    $pdo = new PDO(
         'mysql:host='.MYSQL_HOST.';dbname='. MYSQL_DBNAME ,MYSQL_USER,MYSQL_PASSWORD,$options
    );