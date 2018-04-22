<?php

    ob_start("ob_gzhandler");

   session_start();

   if (isset($_SESSION['username'])){



               $pagetitle = 'Dashboard';
               include "init.php" ;



                  $item = 'userid';

                  $table = 'user';

                  $condition = 'where truststat = 0';



                $usercount = Itemcount($item , $table);

                 $userpending = Itemcount($item ,$table,$condition);

    ?>


          <div class="container stat-home text-center">
            <h1>Dashboard</h1>
             <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="stat st-member">
                  <i class="fa fa-users"></i>
                  <div class="info">
                    Total Member
                   <span><a href="members.php"><?php echo $usercount; ?></a><span>
                  </div>
               </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ">
                <div class="stat st-pending">
                  <i class="fa fa-user-plus"></i>
                  <div class="info">
                    pending Member
                   <span><a href="members.php?active=0"><?php echo $userpending; ?></a><span>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="stat st-item">
                  <i class="fa fa-tag"></i>
                  <div class="info">
                    Total Item
                    <span><a href="item.php"><?php echo Itemcount('item_id','items');  ?></a><span>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <div class="stat st-comment">
                  <i class="fa fa-comments"></i>
                  <div class="info">
                    Total Comments
                    <span><a href="comment.php"><?php echo Itemcount('cid','comments');  ?></a><span>
                  </div>

                </div>
              </div>
             </div>
          </div>
        <div class="latest">
          <div class="container">
              <div class="row">
                <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                     <i class="fa fa-users"></i> Latest Register Users
                     <span class="toggle-info pull-right">
                       <i class="fa fa-plus fa-lg"></i>
                     </span>
                   </div>
                    <div class="panel-body">
                         <?php

                           $thelast = getlatest('*' , "user" , "userid",5);
                           echo "<ul class='list-unstyled latest-user'>";
                           foreach ($thelast as $last) {

                             echo "<li>". $last['username']."<span class='btn btn-success pull-right'>
                             <i class ='fa fa-edit'>";
                              echo "</i><a href='members.php?do=Edit&userid=$last[userid]'>Edit</a></span>";
                              if($last['truststat'] == 0){
                                  echo '<a href="members.php?do=Active&userid='.$last['userid'].'" class="btn btn-info pull-right"><i class="fa fa-check"></i>Activate</a>';
                               }
                              echo "</li>";
                              echo "</br>";

                           }
                           echo "</ul>";
                         ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                     <i class="fa fa-tag"></i> Latest Item
                     <span class="toggle-info pull-right">
                       <i class="fa fa-plus fa-lg"></i>
                     </span>
                   </div>
                    <div class="panel-body">
                      <?php

                        $thelast = getlatest('*' , "items" , "item_id");
                        echo "<ul class='list-unstyled latest-user'>";
                        foreach ($thelast as $last) {
                          echo "<li>". $last['name']."<span class='btn btn-success pull-right'>
                            <i class ='fa fa-edit'>";
                             echo "</i><a href='item.php?do=Edit&itemid=$last[item_id]'>Edit</a></span>";

                             if($last['approve'] == 0){
                                 echo '<a href="item.php?do=approve&itemid='.$last['item_id'].'" class="btn btn-info pull-right">
                                 <i class="fa fa-check"></i>Approve</a>';
                              }
                              echo '<a href="item.php?do=delete&itemid='.$last['item_id'].'" class="btn btn-danger confirm pull-right">
                              <i class="fa fa-close"></i>Delete</a>';
                           echo "</li> ";
                            echo "</br>";
                           }
                        echo "</ul>";
                      ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                     <i class="fa fa-comments-o"></i> Latest Comments
                     <span class="toggle-info pull-right">
                       <i class="fa fa-plus fa-lg"></i>
                     </span>
                   </div>
                    <div class="panel-body">

                      <?php
                            $stmt = $con->prepare("select
                                                            comments.* ,
                                                            user.username as username
                                                            from comments
                                                            join user
                                                            on
                                                            comments.user_id = user.userid
                                                            order by cid desc
                                                            limit 4
                                                              ");

                                                            $stmt->execute();

                                                            $coms = $stmt->fetchAll();

                              foreach ($coms as $com) {
                                 echo "<div  class='com-box'>" ;
                                      echo "<span class='com-n'>".$com['username']."</span>";
                                      echo "<p class='com-c'>".$com['comments']."</p>";
                                 echo "</div>";
                                }

                             ?>
                          </div>
                        </div>
                      </div>

                    </div>
                </div>
              </div>
      <?php
               include $tpl.'footer.php';
     }else {

         header('Location:index.php');
         exit();
   }

     ob_end_flush();
 ?>
