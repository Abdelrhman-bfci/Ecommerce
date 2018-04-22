<?php
     session_start();

      $pagetitle = 'Profile';

       include "init.php";

    if (isset($_SESSION['user'])) {

       $getuser = $con->prepare("select * from user where username = ?");

       $getuser->execute(array($sessionuser));

       $getinfo = $getuser->fetch();



     ?>

   <h1 class="text-center"> My Profile</h1>
  <div class="information block">
    <div class="container">
     <div class="panel panel-primary">
      <div class="panel-heading">My Information</div>
      <div class="panel-body">
        <ul class="list-unstyled">
            <li>
              <i class="fa fa-unlock fa-fw"></i>
              <span>Login Name</span>: <?php echo $getinfo['username']; ?>
            </li>
            <li>
              <i class="fa fa-envelope fa-fw"></i>
              <span>Email</span>: <?php echo $getinfo['email']; ?>
            </li>
            <li>
              <i class="fa fa-user fa-fw"></i>
             <span>Full Name</span>: <?php echo $getinfo['fullname']; ?>
            </li>
            <li>
              <i class="fa fa-calendar fa-fw"></i>
              <span>Register Date</span>:<?php echo $getinfo['date']; ?>
            </li>

              <li>
                <i class="fa fa-tags fa-fw"></i>
                <span>Favorate Category</span>:
              </li>

        </ul>
        <a href="#my-ads" class="btn btn-primary"> Edit Info </a>
      </div>
     </div>
    </div>
  </div>
  <div id="my-ads" class="my-ads block">
    <div class="container">
     <div class="panel panel-primary">
      <div class="panel-heading">My Ads</div>
      <div class="panel-body">

        <?php

         if (!empty(getItem('member_id',$getinfo['userid']))) {
            echo "<div class='row'>";
          foreach (getItem('member_id',$getinfo['userid'],1) as $item) {
            echo "<div class='col-sm-6 col-md-3'>";
              echo "<div class='thumbnail item-box'>";
              if($item['approve'] == 0){
               echo "<span class='approve-status'>Ad Not Active</span>";
             }
               echo '<span class="price-tag"> $'.$item['price'].'</span>';
               echo "<img class='img-responsive' src = 'img.jpg' alt='no thing'>";
                echo "<div class='caption'>";
                  echo "<h3><a href='showitem.php?itemid=$item[item_id]'>". $item['name'] ."</a></h3>";
                  echo "<p>".$item['description']."</p>";
                    echo "<div class='date'>".$item['add_date']."</div>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
           }
           echo "</div>";
         }
         else {
           echo "There is No Ads To Show <a href='newad.php'>New Ad</a>";
         }
         ?>

      </div>
     </div>
    </div>
  </div>
  <div class="comments block">
    <div class="container">
     <div class="panel panel-primary">
      <div class="panel-heading">Latest Comments</div>
      <div class="panel-body">

  <?php
        $stmt = $con->prepare("select comments from comments where user_id =? ");

                                        $stmt->execute(array($getinfo['userid']));

                                        $coms = $stmt->fetchAll();

                    if(!empty($coms)){

                       foreach ($coms as $com) {
                         echo "<div  class='com-box'>" ;
                              echo "<p class='com-c'>".$com['comments']."</p>";
                         echo "</div>";
                        }

                  }else {
                        echo "Thers is no comments ";
                  }

         ?>

      </div>
     </div>
    </div>
  </div>


<?php

}else {

  header('Location:login.php');

  exit();
}
  include $tpl.'footer.php';
 ?>
