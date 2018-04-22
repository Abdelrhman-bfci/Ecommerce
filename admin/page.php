<?php

<?php

session_start();

if (isset($_SESSION['username'])) {

     $pagetitle = 'Item';
    include "init.php" ;
       $do = '';
       if(isset($_GET['do'])){ $do = $_GET['do'];}else {$do = 'manage';}

          if($do=='manage'){

          }elseif ($do = 'add') {
            # code...
          }elseif ($do = 'insert') {
            # code...
          }elseif ($do == 'Edit') {
            # code...
          }elseif ($do == 'update') {
            # code...
          }elseif ($do == 'delete') {
            # code...
          }elseif ($do == 'active') {
            # code...
          }else {
            header('Location:index.php');
                exit();

          }

    include $tpl.'footer.php';

  }else {

    header('Location:index.php');
    exit();
  }
  ob_end_flush();
 ?>

 ?>
