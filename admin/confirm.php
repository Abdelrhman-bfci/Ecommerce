<?php

   $db = "mysql:host=localhost:3306;dbname=shop";
   $password = '';
   $username = 'root';
   $option  = array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
    );
   try {
     $con = new PDO($db, $username,$password,$option);
     $con->SetAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e) {
     echo 'not connected'. $e->getMessage();
   }
    
 ?>
