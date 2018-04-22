<?php
    session_start();

    if (isset($_SESSION['username'])) {
      header('Location:dashbord.php');
    }
     $pagetitle = 'Login ';
    $nonavbar ='';
   include "init.php";
   //include $tpl.'header.php';

   if ($_SERVER['REQUEST_METHOD']=='POST') {

       if (isset($_POST['username']) && !empty($_POST['username'])) {
          $username =  $_POST['username'];
       }

       if (isset($_POST['pass']) && !empty($_POST['pass'])) {
          $pass =  $_POST['pass'];
          $hash = sha1($pass);
          //echo $hash;
       }
       
   $stmt = $con->prepare('select userid ,username , password
   from
   user
   where
   username = ? and password = ?
   and groupid = 1 limit 1');
   if(!empty($hash))
   $stmt->execute(array($username,$hash));
  //  while($ft = $stmt->fetch()){
  //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
  //  }
   $row = $stmt->fetch();

   $count =  $stmt->rowCount();
   if($count > 0 ){
    $_SESSION['username'] = $username;
     $_SESSION['id'] = $row['userid'];
    //echo $_SESSION['username'];
    header('Location:dashbord.php');
    exit();
   }
}
 ?>

   <form class="login" method="post" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
     <h3 class="text-center">Admin Login</h3>
   <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
   <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
   <input class="btn btn-primary btn-block" type="submit" value="Login">
   </form>

<?php
  include $tpl.'footer.php';
 ?>
