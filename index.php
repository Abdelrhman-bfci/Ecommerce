<?php


  session_start();

   $pagetitle = 'HomePage';
   include "init.php";
?>

<div class="container">
 <div class="row">
 <?php
   foreach (get_All('items') as $item) {
     echo "<div class='col-sm-6 col-md-3'>";
       echo "<div class='thumbnail item-box'>";
        echo '<span class="price-tag">$'.$item['price'].'</span>';
        echo "<img class='img-responsive' src = 'img.jpg' alt='no thing'>";
         echo "<div class='caption'>";
           echo "<h3><a href='showitem.php?itemid=$item[item_id]'>". $item['name'] ."</a></h3>";
           echo "<p>".$item['description']."</p>";
           echo "<div class='date'>".$item['add_date']."</div>";
         echo "</div>";
       echo "</div>";
     echo "</div>";
    }
  ?>
</div>
</div>

<?php
  include $tpl.'footer.php';
 ?>
