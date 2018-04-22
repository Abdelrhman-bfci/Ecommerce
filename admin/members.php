<?php



session_start();

if (isset($_SESSION['username'])) {

     $pagetitle = 'Members';
    include "init.php" ;

       $do = '';
       if(isset($_GET['do'])){

         $do = $_GET['do'];

       }else {

         $do = 'manage';

       }

         $userid='';

      if($do=='manage'){


              $query = '';

              if(isset($_GET['active']) && $_GET['active'] == 0){

                 $query = 'and truststat = 0';

              }

               $stmt = $con->prepare("select * from user where groupid != 1 $query");
               $stmt->execute();

               $rows = $stmt->fetchAll();

         ?>

        <h1 class="text-center"> Manage Member </h1>
        <div class="container">
               <div class="table-responsive">
                 <table class="main-table text-center table table-bordered">
                    <tr>
                       <td>#ID</td>
                       <td>Avater</td>
                       <td>UserName</td>
                       <td>Email</td>
                       <td>Fullname</td>
                       <td>Register date</td>
                       <td>Control</td>
                    </tr>
                    <?php
                     foreach ($rows as $row) {
                       echo "<tr>";
                          echo "<td>". $row['userid'] ."</td>";
                          echo "<td>";
                          if(empty($row['avater'])){
                            echo "No Image";
                          }
                          else{
                           echo "<img class=' img-responsive avater-img img-thumbnail' src=uploadfile/avater/". $row['avater'] .">";
                          }
                          echo "</td>";
                          echo "<td>". $row['username'] ."</td>";
                          echo "<td>". $row['email'] ."</td>";
                          echo "<td>". $row['fullname'] ."</td>";
                          echo "<td>". $row['date'] ."</td>";
                          echo '<td>  <a href="members.php?do=Edit&userid='.$row['userid'].'" class="btn btn-success"><i class="fa fa-edit" ></i>Edit</a>
                                <a href="members.php?do=Delete&userid='.$row['userid'].'" class="btn btn-danger confirm"><i class="fa fa-times" ></i>Delete</a> ';
                            if($row['truststat'] == 0){
                                echo '<a href="members.php?do=Active&userid='.$row['userid'].'" class="btn btn-info"><i class="fa fa-check"></i></i>Activate</a> </td>';
                            }
                            echo "</td>";
                       echo "</tr>";
                     }
                     ?>

                 </table>
               </div>
                <a class="btn btn-primary" href="members.php?do=add"> <i class="fa fa-plus"></i>  Add New Member  </a>

          </div>
    <?php }elseif ($do =='add') { ?>

         <h1 class="text-center"> Add New Member </h1>
         <div class="container">
            <form class="form-horizontal" action="members.php?do=insert" method="post" enctype="multipart/form-data">

                <div class="form-group">
                   <label class="col-sm-2 control-label">Username</label>
                     <div class="col-lg-8 col-sm-10 col-md-4">
                   <input type="text" name="username" class="form-control" autocomplete="off" required="required" >
                  </div>
               </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                      <div class="col-lg-8 col-sm-10 col-md-4">
                       <input type="password" name="password" class="form-control show"  autocomplete="new-password" required >
                       <i class="fa fa-eye"></i>
                      <!-- <i class="fa fa-eye"></i> -->
                   </div>
                </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">Full Name</label>
                       <div class="col-lg-8 col-sm-10 col-md-4">
                     <input type="text" name="fullname" class="form-control" required="required">
                    </div>
                 </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                      <input type="email" name="email" class="form-control" required="required">
                     </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">User Avater</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                          <div class="ava-img">
                           <input type="file" name="avater" required="required">
                         </div>
                     </div>
                  </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                       <input type="submit"  value="Add Member" class="btn btn-primary ">
                      </div>
                   </div>

              </form>
         </div>
 <?php
   }elseif ($do == 'insert') {

     echo  " <h1 class='text-center'> Insert  New Member </h1>";
     echo '<div class="container">';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // avater file 
          

          $avatername = $_FILES['avater']['name'];
          $avatersize = $_FILES['avater']['size'];
          $avatertype = $_FILES['avater']['type'];
          $avatertmp = $_FILES['avater']['tmp_name'];


          $avaterAllowExtension = array("jpg","jpeg","png","gif");

          $vaterExtensionarray = explode('.', $avatername);

          $vaterExtension = strtolower(end($vaterExtensionarray));
           

          

         
        

          $user = $_POST['username'];
          $pass = $_POST['password'];
          $fullname = $_POST['fullname'];
          $email = $_POST['email'];
          $hash = sha1($pass);
           $formerror  = array();
          if(empty($user)){
          $formerror[] = "Username can't be empty";
          }
          if(strlen($user) < 4){
          $formerror[] = "Username can't be less than 4";
          }
          if(strlen($user) > 10){
          $formerror[] = "Username can't be more the 10";
          }
          if(empty($fullname)){
            $formerror[] = "Full Name can't be empty";
          }
          if(empty($email)){
            $formerror[] = "Email can't be empty";
          }
          if(empty($pass)){
            $formerror[] = "Password can't be empty";
          }
          if(strlen($pass) < 7){
            $formerror[] = "Password can't be less then 7";
          }
          if (!empty($avatername)&&!in_array($vaterExtension, $avaterAllowExtension)) {
            $formerror[] = "The Extension Is Not Allowed ";
          }
          if (empty($avatername)) {
            $formerror[] = "The Avater  is Required ";
          }
          if ($avatersize > 1572864) {
            $formerror[] = "The Avater file size shoud be less than 1.5 mb";
          }
          foreach ($formerror as $err) {
            $messag = '<div class="alert alert-danger">'.$err . '</div>';
              redircthome($messag ,'back',100);
          }
           
          // update records
       if(empty($formerror)){

            $avater = rand(0,10000000).'_'.$avatername;

            move_uploaded_file($avatertmp,"uploadfile\avater\\".$avater);

          $check =   checkitem("username" ,"user" ,$user);

          if ($check == 1) {
            $messag = "<div class='alert alert-info'>Sorry this user is exit</div>";
              redircthome($messag ,'back',4);
          }
          else {


              $stmt = $con->prepare("insert into user (username,password,fullname,truststat,email,date,avater) values(?,?,?,1,?,now(),?)");
              $stmt->execute( array($user,$hash,$fullname,$email,$avater));

            $messag = '<div class="alert alert-success">' .$stmt->rowCount() . " Records Insert".'</div>' ;
              redircthome($messag,'back',100);
          }
       }
    }

    else {
       // echo "Sorry you can't enter this page directiry";
        $massege = '<div class="alert alert-danger">Sorry you can\'t enter this page directiry</div>';
        redircthome($massege);
    } 
  
    echo "</div>";

       }elseif ($do == 'Edit') {

         if(isset($_GET['userid']) && is_numeric($_GET['userid'])){

          $userid = intval($_GET['userid']);
         }
         else {
          $userid=0;
         }

         $stmt = $con->prepare('select * from user where userid = ? limit 1');
           $stmt->execute(array($userid));
        //  while($ft = $stmt->fetch()){
        //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
        //  }
         $row = $stmt->fetch();

         $count =  $stmt->rowCount();

         if($count>0){
        ?>
      <!-- //  echo "Welcome to edite page".$_GET['userid']; -->

          <h1 class="text-center"> Edit Member </h1>
          <div class="container">
             <form class="form-horizontal" action="members.php?do=update" method="post">
               <input type="hidden" name="userid" value="<?php echo $userid ;?>">
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>
                      <div class="col-lg-8 col-sm-10 col-md-4">
                    <input type="text" name="username" class="form-control"value="<?php echo $row['username']; ?>" autocomplete="off" required="required" >
                   </div>
                </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">Password</label>
                       <div class="col-lg-8 col-sm-10 col-md-4">
                       <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
                       <input type="password" name="newpassword" class="form-control"  autocomplete="new-password" >
                    </div>
                 </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                      <input type="text" name="fullname"value="<?php echo $row['fullname']; ?>" class="form-control" required="required">
                     </div>
                  </div>
                    <div class="form-group">
                       <label class="col-sm-2 control-label">Email</label>
                         <div class="col-lg-8 col-sm-10 col-md-4">
                       <input type="email" name="email" value="<?php echo $row['email']; ?>"class="form-control" required="required">
                      </div>
                   </div>
                     <div class="form-group">
                       <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit"  value="Save" class="btn btn-primary ">
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
       echo  " <h1 class='text-center'> Update Member </h1>";
       echo '<div class="container">';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $userid = $_POST['userid'];
            $user = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];

            $pass ='';

            if(empty($_POST['newpassword'])){
              $pass = $_POST['oldpassword'];
            }
            else {
              $pass = sha1($_POST['newpassword']);
            }
             $formerror  = array();
            if(empty($user)){
            $formerror[] = "Username can't be empty";
            }
            if(strlen($user) < 4){
            $formerror[] = "Username can't be less than 4";
            }
            if(strlen($user) > 10){
            $formerror[] = "Username can't be more the 10";
            }
            if(empty($fullname)){
              $formerror[] = "Full Name can't be empty";
            }
            if(empty($email)){
              $formerror[] = "Email can't be empty";
            }

            foreach ($formerror as $err) {
              echo '<div class="alert alert-danger">'.$err . '</div>';
            }
            // update records
       if(empty($formerror)){
            $stmt = $con->prepare("update user set username =? ,password =?, fullname =? , email =? where userid =? ");
            $stmt->execute( array($user,$pass,$fullname,$email,$userid));

            $messag = '<div class="alert alert-success">' .$stmt->rowCount() . " Records update".'</div>' ;
            redircthome($messag ,'back',4);
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
    }
      elseif ($do == 'Delete') {

        if(isset($_GET['userid']) && is_numeric($_GET['userid'])){

         $userid = intval($_GET['userid']);
        }
        else {
         $userid=0;
        }

        $stmt = $con->prepare('select * from user where userid = ? limit 1');
          $stmt->execute(array($userid));
       //  while($ft = $stmt->fetch()){
       //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
       //  }
        $row = $stmt->fetch();

        $count =  $stmt->rowCount();
        if($count>0){

          $stmt = $con->prepare('Delete from user where userid = ?');
          $stmt->execute(array($userid));
          echo  " <h1 class='text-center'> Delete Member </h1>";
          echo '<div class="container">';

          $messag =  '<div class="alert alert-success">' .$stmt->rowCount() . " Records Delete".'</div>' ;
          redircthome($messag ,'back');
          echo "</div>";
        }
        else {
          echo "<div class='container'>";
          $messag = "<div class='alert alert-danger'>The user id is not exist </div>";
            redircthome($messag ,'back');
          echo "</div>";
        }

      }
      elseif ($do == 'Active') {

        if(isset($_GET['userid']) && is_numeric($_GET['userid'])){

         $userid = intval($_GET['userid']);
        }
        else {
         $userid=0;
        }

        $stmt = $con->prepare('select * from user where userid = ? limit 1');
          $stmt->execute(array($userid));
       //  while($ft = $stmt->fetch()){
       //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
       //  }
        $row = $stmt->fetch();

        $count =  $stmt->rowCount();
        if($count>0){

          $stmt = $con->prepare('update user set truststat = 1 where userid = ?');
          $stmt->execute(array($userid));
          echo  " <h1 class='text-center'> Activate Member </h1>";
          echo '<div class="container">';

          $messag =  '<div class="alert alert-success">' .$stmt->rowCount() . " Records Activete".'</div>' ;
          redircthome($messag ,'back');
          echo "</div>";
        }
        else {
          echo "<div class='container'>";
          $messag = "<div class='alert alert-danger'>The user id is not exist </div>";
            redircthome($messag ,'back');
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

 ?>
