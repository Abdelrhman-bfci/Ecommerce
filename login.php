<?php
   ob_start();

    session_start();

    $pagetitle = 'Login ';

    if (isset($_SESSION['user'])) {

      header('Location:index.php');

    }

      include "init.php";

      if ($_SERVER['REQUEST_METHOD']=='POST') {

        if (isset($_POST['login'])) {

          if (isset($_POST['username']) && !empty($_POST['username'])) {

             $username =  $_POST['username'];
          }

          if (isset($_POST['password']) && !empty($_POST['password'])) {

                   $pass =  $_POST['password'];

                   $hash = sha1($pass);

             //echo $hash;
          }

          $stmt = $con->prepare('select
                                    username ,
                                    password,
                                    userid
                                    from user
                                    where
                                    username = ? and password = ?
                                     ');

          $stmt->execute(array($username,$hash));

          $row = $stmt->fetch();

          $count =  $stmt->rowCount();
          if($count > 0 ){

            $_SESSION['user'] = $username;

            $_SESSION['userid'] = $row['userid'];

          header('Location:index.php');

           exit();

       }

     }else {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email    = $_POST['email'];
        $hashpass = sha1($password);

           $errors = array();

         if (isset($_POST['username'])) {

             $user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);

             if(strlen($user) < 4){

               $errors[] = 'The User Name must be Larger than 4 character';
             }
         }

         if (isset($_POST['password']) && isset($_POST['password2'])) {

           if(empty($_POST['password'])){

             $errors[] = 'the password can\'t be empty';
           }

           $pass = sha1($_POST['password']);

           $pass2 = sha1($_POST['password2']);

           if( $pass !== $pass2 ){

             $errors[] = 'The password is not correct';
           }

        }

        if (isset($_POST['email'])) {

            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);



            if(filter_var($email,FILTER_VALIDATE_EMAIL) !=true){

              $errors[] = "Plase Enter Valid email" ;
            }
        }

        if(empty($errors)){

             $check =   checkitem("username" ,"user" ,$username);

             if ($check == 1) {

                   $errors[] = "The User is exist " ;
             }
             else {


                 $stmt = $con->prepare("insert
                                        into
                                        user
                                        (username,password,truststat,email,date)
                                        values(?,?,0,?,now())");

                 $stmt->execute(array($username,$hashpass,$email));

                  $successmes = 'Congrate You Are Sign In';

             }
        }


    }
  }
 ?>
 <div class="container login-page">
  <h1 class="text-center">
    <span class="selected" data-class="login">login </span>|<span data-class="signup"> Signup</span>
  </h1>
    <form class="login" method="post" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
    <div class="form-group">
      <input
      type="text"
      name="username"
      class="form-control"
      placeholder="Enter UserName"
      autocomplete="off"
      required
      />
    </div>
    <div class="form-group">
      <input
      type="password"
      name="password"
      class="form-control"
      placeholder="Enter Password"
      autocomplete="new-password"
      required
      />
    </div>
      <input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
      <hr>
    </form>
    <form class="signup" method="post" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
    <div class="form-group">
      <input
      pattern=".{3,}"
      title="The Username must be 4 chars"
      type="text"
      name="username"
      class="form-control"
      placeholder="Enter UserName"
      autocomplete="off"
      required
      />
    </div>
      <div class="form-group">
        <input
        type="text"
        name="email"
        class="form-control"
        placeholder="Enter Email"
        required
        />
    </div>
    <div class="form-group">
      <input
      minlength ="4"
      type="password"
      name="password"
      class="form-control"
      placeholder="Enter Password"
      autocomplete="new-password"
      required
      />
    </div>
    <div class="form-group">
      <input
      minlength = "4"
      type="password"
      name="password2"
      class="form-control show"
      placeholder="Enter Confirm Password"
      autocomplete="new-password"
      required
      />
    </div>
      <input type="submit" class="btn btn-success btn-block" name="signup" value="Signup">
    </form>
    <div class="error text-center">
      <?php
        if(!empty($errors)){
         foreach ($errors as $err) {
           echo '<div class="err-mes">'.$err.'</div>';
         }
       }
       if( isset($successmes)){
         echo "<div class='err-mes success'>".$successmes."</div>";
       }
       ?>
    </div>
 </div>
 <?php
 include $tpl."footer.php" ;

  ob_end_flush();
?>
