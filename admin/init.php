<?php

     include "confirm.php";

     //routes
      $css = "layout/css/";
      $tpl = "include/templates/";
      $js =   "layout/js/";
      $lang = "include/languges/";
      $fun = "include/function/";
      //important templates

      include $fun.'function.php';

      include $tpl.'header.php';

      include $lang.'arabic.php';
      include $lang.'english.php';

      if(!isset($nonavbar)){
          include $tpl.'navbar.php';
      }
 ?>
