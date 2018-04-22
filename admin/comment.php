<?php



session_start();

if (isset($_SESSION['username'])) {

     $pagetitle = 'Comment';
    include "init.php" ;

       $do = '';
       if(isset($_GET['do'])){

         $do = $_GET['do'];

       }else {

         $do = 'manage';

       }

         $userid='';

      if($do=='manage'){



               $stmt = $con->prepare("select
                                         comments.* ,
                                         items.name as item_name,
                                         user.username as username
                                         from comments
                                         join user
                                         on
                                         comments.user_id = user.userid
                                         join items
                                         on
                                         comments.item_id = items.item_id
                                          ORDER BY cid DESC
                                         ");

               $stmt->execute();

               $coms = $stmt->fetchAll();

         ?>

        <h1 class="text-center"> Manage Comments </h1>
        <div class="container">
               <div class="table-responsive">
                 <table class="main-table text-center table table-bordered">
                    <tr>
                       <td>ID</td>
                       <td>Comment</td>
                       <td>Item Name</td>
                       <td>User Name</td>
                       <td>Comment date</td>
                       <td>Control</td>
                    </tr>
                    <?php
                     foreach ($coms as $com) {
                       echo "<tr>";
                          echo "<td>". $com['cid'] ."</td>";
                          echo "<td>". $com['comments'] ."</td>";
                          echo "<td>". $com['item_name'] ."</td>";
                          echo "<td>". $com['username'] ."</td>";
                          echo "<td>". $com['comment_date'] ."</td>";
                          echo '<td>  <a href="comment.php?do=Edit&cid='.$com['cid'].'" class="btn btn-success"><i class="fa fa-edit" ></i>Edit</a>
                                <a href="comment.php?do=Delete&cid='.$com['cid'].'" class="btn btn-danger confirm"><i class="fa fa-times" ></i>Delete</a> ';
                            if($com['status'] == 0){
                                echo '<a href="comment.php?do=Active&cid='.$com['cid'].'" class="btn btn-info"><i class="fa fa-check"></i></i>Activate</a> </td>';
                            }
                            echo "</td>";
                       echo "</tr>";
                     }
                     ?>

                 </table>
               </div>


          </div>
    <?php
          }elseif ($do == 'Edit') {

         if(isset($_GET['cid']) && is_numeric($_GET['cid'])){

          $cid = intval($_GET['cid']);
         }
         else {
          $cid = 0;
         }

         $stmt = $con->prepare('select * from comments where cid = ? limit 1');

           $stmt->execute(array($cid));
        //  while($ft = $stmt->fetch()){
        //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
        //  }
         $row = $stmt->fetch();

         $count =  $stmt->rowCount();

         if($count>0){
        ?>
      <!-- //  echo "Welcome to edite page".$_GET['userid']; -->

          <h1 class="text-center"> Edit Comment </h1>
          <div class="container">
             <form class="form-horizontal" action="comment.php?do=update" method="post">
               <input type="hidden" name="cid" value="<?php echo $cid ;?>">
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Comment</label>
                      <div class="col-lg-8 col-sm-10 col-md-4">
                      <textarea class="form-control" name="comment" ><?php echo $row['comments']; ?></textarea>
                    </div>
                 </div>

                    <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                         <input type="submit"  value="Save"
                           class="btn btn-primary ">
                       </div>
                    </div>

               </form>
          </div>
      <?php
           }else {
           echo ' <div class="container">';
           $messag = '<div class="alert alert-danger">no userid such this</div>';
           redircthome($messag ,'back');
          echo "</div>";
    }
  }
    elseif ($do == 'update') {
       echo  " <h1 class='text-center'> Update Comment</h1>";
       echo '<div class="container">';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $cid = $_POST['cid'];

            $comment = $_POST['comment'];

            $stmt = $con->prepare("update comments set comments =? where cid =? ");

            $stmt->execute( array($comment,$cid));

            $messag = '<div class="alert alert-success">' .$stmt->rowCount() . " Records update".'</div>' ;
            redircthome($messag ,'back');


      }

      else {
        echo '<div class="container">';
        $messag =  "<div class='alert alert-danger'>Sorry you can't enter this page directiry</div>";
          redircthome($messag);
        echo "</div>";
      }
      echo "</div>";
    }
      elseif ($do == 'Delete') {

        if(isset($_GET['cid']) && is_numeric($_GET['cid'])){

         $cid = intval($_GET['cid']);
        }
        else {
         $cid = 0;
        }

        $stmt = $con->prepare('select * from comments where cid = ? limit 1');

          $stmt->execute(array($cid));
       //  while($ft = $stmt->fetch()){
       //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
       //  }
        $row = $stmt->fetch();

        $count =  $stmt->rowCount();

        if( $count > 0 ){

          $stmt = $con->prepare('Delete from comments where cid = ?');
          $stmt->execute(array($cid));
          echo  " <h1 class='text-center'> Delete Comment </h1>";
          echo '<div class="container">';

          $messag =  '<div class="alert alert-success">' .$stmt->rowCount() . " Records Delete".'</div>' ;
          redircthome($messag ,'back');
          echo "</div>";
        }
        else {
          echo "<div class='container'>";
          $messag = "<div class='alert alert-danger'>The user id is not exist </div>";
            redircthome($messag );
          echo "</div>";
        }

      }
      elseif ($do == 'Active') {

        if(isset($_GET['cid']) && is_numeric($_GET['cid'])){

         $cid = intval($_GET['cid']);
        }
        else {

         $cid = 0 ;

        }

        $stmt = $con->prepare('select * from comments where cid = ? limit 1');

          $stmt->execute(array($cid));
       //  while($ft = $stmt->fetch()){
       //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
       //  }
        $row = $stmt->fetch();

        $count =  $stmt->rowCount();

        if( $count > 0 ){

          $stmt = $con->prepare('update comments set status = 1 where cid = ?');

          $stmt->execute(array($cid));

          echo  " <h1 class='text-center'> Activate Comment </h1>";

          echo '<div class="container">';

          $messag =  '<div class="alert alert-success">' .$stmt->rowCount() . " Records Activete".'</div>' ;

          redircthome($messag ,'back');

          echo "</div>";
        }
        else {

          echo "<div class='container'>";
          $messag = "<div class='alert alert-danger'>The user id is not exist </div>";
            redircthome($messag);
          echo "</div>";

        }


      }else {

        header('Location:index.php');
          exit();
      }

     include $tpl.'footer.php';

}
else {

  header('Location:index.php');
  exit();
}
 ob_end_flush();
 ?>
