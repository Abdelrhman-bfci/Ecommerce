<?php

   function lang($pharse){

    static $lang  = array(
        // navber design
       'Home'        =>  'Home' ,
       'Sittings'    => 'Sittings',
       'Categories'  => 'Categories' ,
       'Item'        => 'Item',
       'Members'     => 'Members' ,
       'Logs'        => 'Logs',
       'statistics'  => 'Statistics',
      'Commenting'   => 'Commenting',

      );

      return $lang[$pharse];
   }
 ?>
