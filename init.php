<?php

    ini_set('display_error','on');

     error_reporting(E_ALL);

     include "admin/confirm.php";

     $sessionuser ='';
     if (isset($_SESSION['user'])) {
       $sessionuser = $_SESSION['user'];
     }

     //routes
      $css = "layout/css/";
      $tpl = "include/templates/";
      $js =   "layout/js/";
      $lang = "include/languges/";
      $fun = "include/function/";
      //important templates

      include $fun.'function.php';

      include $lang.'arabic.php';
      include $lang.'english.php';

      include $tpl.'header.php';







 ?>
