<?php

session_start();

if (isset($_SESSION['username'])) {

     $pagetitle = 'Item';
    include "init.php" ;
       $do = '';
       if(isset($_GET['do'])){ $do = $_GET['do'];}else {$do = 'manage';}

          if($do=='manage'){


             $stmt = $con->prepare("select items.* ,
             user.username as username ,
             categories.name as cat_name
             from items
             join user on
             items.member_id = user.userid
             join categories on
             items.cat_id = categories.id

             ");

             $stmt->execute();

             $items = $stmt->fetchAll();

       ?>

      <h1 class="text-center"> Manage Item  </h1>
      <div class="container">
             <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                  <tr>
                     <td>#ID</td>
                     <td>Name</td>
                     <td>Description</td>
                     <td>Price</td>
                     <td>Category</td>
                     <td>Member</td>
                     <td>Adding date</td>
                     <td>Control</td>
                  </tr>
                  <?php
                   foreach ($items as $item) {
                     echo "<tr>";
                        echo "<td>". $item['item_id'] ."</td>";
                        echo "<td>". $item['name'] ."</td>";
                        echo "<td>". $item['description'] ."</td>";
                        echo "<td>". $item['price'] ."</td>";
                        echo "<td>". $item['cat_name'] ."</td>";
                        echo "<td>". $item['username'] ."</td>";
                        echo "<td>". $item['add_date'] ."</td>";
                        echo '<td>  <a href="item.php?do=Edit&itemid='.$item['item_id'].'"
                              class="btn btn-success"><i class="fa fa-edit" ></i>Edit</a>
                              <a href="item.php?do=delete&itemid='.$item['item_id'].'"
                              class="btn btn-danger confirm"><i class="fa fa-times" ></i>Delete</a> ';
                              if($item['approve'] == 0){
                                  echo '<a href="item.php?do=approve&itemid='.$item['item_id'].'"
                                    class="btn btn-info"><i class="fa fa-check"></i></i>Approve</a> </td>';
                              }
                        echo "</td>";
                     echo "</tr>";
                   }
                   ?>

               </table>
             </div>
              <a class="btn btn-primary" href="item.php?do=add"> <i class="fa fa-plus"></i>  Add New Item  </a>

        </div>
<?php
          }elseif ($do == 'add') { ?>

            <h1 class="text-center"> Add New Item </h1>
            <div class="container">
               <form class="form-horizontal" action="item.php?do=insert" method="post">

                   <div class="form-group">
                      <label class="col-sm-2 control-label">Name</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                      <input type="text" name="name" class="form-control"  required="required" >
                     </div>
                   </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                      <input type="text" name="des" class="form-control"  required="required" >
                     </div>
                   </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Price</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                      <input type="text" name="price" class="form-control"  required="required" >
                     </div>
                   </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Country Made</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                      <input type="text" name="made" class="form-control"required="required">
                     </div>
                   </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Status</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                        <select name="stat">
                           <option value="0">.....</option>
                           <option value="1">New</option>
                           <option value="2">Like New</option>
                           <option value="3">Used</option>
                           <option value="4">old</option>
                        </select>
                     </div>
                   </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Members</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                        <select name="member">
                           <option value="0">.....</option>
                          <?php
                           $stmt = $con->prepare("select * from user");

                           $stmt->execute();

                           $users = $stmt->fetchAll();

                           foreach ($users as $user) {
                             echo "<option value='".$user['userid']."'>".$user['username']."</option>";
                           }
                           ?>
                        </select>
                     </div>
                   </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Category</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                        <select name="category">
                           <option value="0">.....</option>
                          <?php
                           $stmt1 = $con->prepare("select * from categories");

                           $stmt1->execute();

                           $cats = $stmt1->fetchAll();

                           foreach ($cats as $cat) {
                             echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
                           }
                           ?>
                        </select>
                     </div>
                   </div>
                   <div class="form-group">
                         <div class="col-sm-offset-2 col-sm-10">
                          <input type="submit"  value="Add New Item" class="btn btn-primary ">
                         </div>
                      </div>
                 </form>
            </div>

  <?php    }elseif ($do == 'insert') {
                echo  " <h1 class='text-center'> Insert  New Item </h1>";
                echo '<div class="container">';
               if($_SERVER['REQUEST_METHOD'] == 'POST'){

                     $name         = $_POST['name'];
                     $desc         = $_POST['des'];
                     $price        = $_POST['price'];
                     $country_made = $_POST['made'];
                     $stat         = $_POST['stat'];
                     $cat          = $_POST['category'];
                     $member       = $_POST['member'];

                      $formerror  = array();

                    if(empty($name)){
                     $formerror[] = "Name can't be empty";
                     }
                     if(empty($desc)){
                     $formerror[] = "Description can't be less than 4";
                     }
                     if(empty($price)){
                     $formerror[] = "Price can't be more the 10";
                     }
                     if(empty($country_made)){
                       $formerror[] = "Countery Made can't be empty";
                     }
                     if($stat == 0){
                       $formerror[] = "Status can't be empty";
                     }
                     if($cat == 0){
                       $formerror[] = "category can't be empty";
                     }
                     if($member == 0){
                       $formerror[] = "member can't be empty";
                     }

                     foreach ($formerror as $err) {
                       $messag = '<div class="alert alert-danger">'.$err .'</div>';
                     }
                     // update records
                if(empty($formerror)){


                        $stmt = $con->prepare("insert into
                       items(name , description , price , add_date , country_made , status , 	cat_id , member_id)
                        values(?,?,?,now(),?,?,?,?)");

                       $stmt->execute(array($name,$desc,$price,$country_made,$stat,$cat,$member));

                       $messag = '<div class="alert alert-success">' .$stmt->rowCount() . " Records Insert".'</div>' ;
                         redircthome($messag,'back');
                     }else {

                     redircthome($messag ,'back');
                 }

               }

               else {
                  // echo "Sorry you can't enter this page directiry";
                   $massege = '<div class="alert alert-danger">Sorry you can\'t enter this page directiry</div>';
                   redircthome($massege);
               }
               echo "</div>";

          }elseif ($do == 'Edit') {

                     if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){

                      $itemid = intval($_GET['itemid']);
                     }
                     else {
                      $itemid=0;
                     }

                     $stmt = $con->prepare('select * from items where item_id = ? limit 1');

                      $stmt->execute(array($itemid));
                    //  while($ft = $stmt->fetch()){
                    //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
                    //  }
                     $items = $stmt->fetch();

                     $count =  $stmt->rowCount();

                     if($count>0){
                    ?>
                  <!-- //  echo "Welcome to edite page".$_GET['userid']; -->

                      <h1 class="text-center"> Edit Item </h1>
                      <div class="container">
                         <form class="form-horizontal" action="item.php?do=update" method="post">

                              <input type="hidden" name="itemid" value="<?php echo $itemid ;?>">
                         <div class="form-group">
                              <label class="col-sm-2 control-label">Name</label>
                                <div class="col-lg-8 col-sm-10 col-md-4">
                              <input
                              type="text"
                              name="name"
                              class="form-control"
                              value="<?php echo $items['name']; ?>"  required="required" >
                             </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label">Description</label>
                                <div class="col-lg-8 col-sm-10 col-md-4">
                              <input
                              type="text"
                              name="des"
                              class="form-control"
                              value="<?php echo $items['description']; ?>"
                              required="required" >
                             </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label">Price</label>
                                <div class="col-lg-8 col-sm-10 col-md-4">
                              <input
                              type="text"
                              name="price"
                              class="form-control"
                              value="<?php echo $items['price']; ?>">
                             </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label">Country Made</label>
                                <div class="col-lg-8 col-sm-10 col-md-4">
                              <input
                              type="text"
                              name="made"
                              class="form-control"
                              value="<?php echo $items['country_made']; ?>">
                             </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label">Status</label>
                                <div class="col-lg-8 col-sm-10 col-md-4">
                                <select name="stat">
                                   <option value="0">.....</option>
                                   <option value="1" <?php if($items['status'] == 1){ echo "selected";} ?> >New</option>
                                   <option value="2" <?php if($items['status'] == 2){ echo "selected";} ?>>Like New</option>
                                   <option value="3" <?php if($items['status'] == 3){ echo "selected";} ?>>Used</option>
                                   <option value="4" <?php if($items['status'] == 4){ echo "selected";} ?>>old</option>
                                </select>
                             </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label">Members</label>
                                <div class="col-lg-8 col-sm-10 col-md-4">
                                <select name="member">
                                   <option value="0">.....</option>
                                  <?php
                                   $stmt = $con->prepare("select * from user");

                                   $stmt->execute();

                                   $users = $stmt->fetchAll();

                                   foreach ($users as $user) {
                                     echo "<option value='".$user['userid']."'";
                                      if($items['member_id'] == $user['userid']){ echo "selected";}
                                     echo ">".$user['username']."</option>";
                                   }
                                   ?>
                                </select>
                             </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label">Category</label>
                                <div class="col-lg-8 col-sm-10 col-md-4">
                                <select name="category">
                                   <option value="0">.....</option>
                                <?php
                                   $stmt1 = $con->prepare("select * from categories");

                                   $stmt1->execute();

                                   $cats = $stmt1->fetchAll();

                                   foreach ($cats as $cat) {
                                     echo "<option value='".$cat['id']."' ";
                                       if($items['cat_id'] == $cat['id']){ echo "selected";}
                                     echo">".$cat['name']."</option>";
                                   }
                                   ?>
                                </select>
                             </div>
                           </div>
                           <div class="form-group">
                                 <div class="col-sm-offset-2 col-sm-10">
                                  <input type="submit"  value="Save Item" class="btn btn-primary ">
                                 </div>
                              </div>
                           </form>

        <?php                $stmt = $con->prepare("select
                                          comments.* ,
                                          user.username as username
                                          from comments
                                          join user
                                          on
                                          comments.user_id = user.userid
                                          where item_id = ?

                                          ");

                                          $stmt->execute(array($itemid));

                                          $coms = $stmt->fetchAll();

                                          if(!empty($coms)){

                                    ?>

                                   <h1 class="text-center"> Manage [<?php echo $items['name']; ?>] Comments </h1>
                                         <div class="table-responsive">
                                            <table class="main-table text-center table table-bordered">
                                               <tr>
                                                  <td>Comment</td>
                                                  <td>User Name</td>
                                                  <td>Comment date</td>
                                                  <td>Control</td>
                                               </tr>
                                               <?php
                                                foreach ($coms as $com) {
                                                  echo "<tr>";
                                                     echo "<td>". $com['comments'] ."</td>";
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
                            <?php } ?>
                                      </div>
                  <?php
                       }else {
                       echo ' <div class="container">';
                       $messag = '<div class="alert alert-danger">no userid such this</div>';
                       redircthome($messag ,'back');
                      echo "</div>";
                }
        }elseif ($do == 'update') {
          echo  " <h1 class='text-center'> Update Item </h1>";
          echo '<div class="container">';
         if($_SERVER['REQUEST_METHOD'] == 'POST'){

               $itemid = $_POST['itemid'];
               $name = $_POST['name'];
               $description = $_POST['des'];
               $price = $_POST['price'];
               $cantry_made = $_POST['made'];
               $stat  = $_POST['stat'];
               $member = $_POST['member'];
               $category = $_POST['category'];

                $formerror  = array();
               if(empty($name)){
               $formerror[] = "Name can't be empty";
               }
               if(empty($description)){
                 $formerror[] = "Description can't be empty";
               }
               if(empty($price)){
                 $formerror[] = "Price can't be empty";
               }
               if(empty($cantry_made)){
                 $formerror[] = "Cantery Made can't be empty";
               }
              if($stat == 0 ){
                 $formerror[] = "Status can't be empty";
               }
              if($member == 0 ){
                  $formerror[] = "Member can't be empty";
                }
              if($category == 0 ){
                   $formerror[] = "Cactegory can't be empty";
               }

               foreach ($formerror as $err) {
                 echo '<div class="alert alert-danger">'.$err . '</div>';
               }
               // update records
          if(empty($formerror)){
               $stmt = $con->prepare("update
                                        items
                                    set
                                        name =? ,
                                        description =? ,
                                        price =? ,
                                        country_made =?,
                                        Status =?,
                                        cat_id =?,
                                        member_id =?
                                    where
                                        item_id =? ");
               $stmt->execute(array($name,$description,$price,$cantry_made,$stat,$category,$member,$itemid));

               $messag = '<div class="alert alert-success">' .$stmt->rowCount() . " Records update".'</div>' ;
               redircthome($messag ,'back',2);
            }
            else {
                 $messag = '';
                redircthome($messag ,'back');
            }
         }

         else {
           echo '<div class="container">';
           $messag =  "<div class='alert alert-danger'>Sorry you can't enter this page directiry</div>";
             redircthome($messag ,'back',5);
           echo "</div>";
         }
         echo "</div>";
        }elseif ($do == 'delete') {
                if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){

                 $itemid = intval($_GET['itemid']);
                }
                else {
                 $itemid = 0;
                }

                $stmt = $con->prepare('select * from items where item_id = ? limit 1');
                  $stmt->execute(array($itemid));
               //  while($ft = $stmt->fetch()){
               //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
               //  }
                $items = $stmt->fetch();

                $count =  $stmt->rowCount();

                if( $count > 0 ){

                  $stmt = $con->prepare('Delete from items where item_id = ?');

                  $stmt->execute(array($itemid));
                  echo  " <h1 class='text-center'> Delete Item </h1>";

                  echo '<div class="container">';

                  $messag =  '<div class="alert alert-success">' .$stmt->rowCount() . " Records Delete".'</div>' ;

                  redircthome($messag ,'back');

                  echo "</div>";
                }
                else {
                echo  " <h1 class='text-center'> Delete Item </h1>";

                  echo "<div class='container'>";

                  $messag = "<div class='alert alert-danger'>The user id is not exist </div>";

                    redircthome($messag);

                  echo "</div>";
                }

          }elseif ($do == 'approve') {

            if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){

             $itemid = intval($_GET['itemid']);

            }
            else {

             $itemid = 0;
            }

            $stmt = $con->prepare('select * from items where item_id = ? limit 1');

            $stmt->execute(array($itemid));
           //  while($ft = $stmt->fetch()){
           //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
           //  }
            $items = $stmt->fetch();

          $count =  $stmt->rowCount();

            if( $count > 0 ){

              $stmt = $con->prepare('update items set approve = 1 where item_id = ?');

              $stmt->execute(array($itemid));

              echo  " <h1 class='text-center'> Approve Item </h1>";

              echo '<div class="container">';

              $messag =  '<div class="alert alert-success">' .$stmt->rowCount() . " Records Approve".'</div>' ;

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

  }else {

    header('Location:index.php');
    exit();
  }
  ob_end_flush();

?>
