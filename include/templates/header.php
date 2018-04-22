<!--DOCTYPE HTML-->
<html>
  <head>
    <meta charset="utf-8">
  <title><?php GetTitle(); ?></title>
      <link rel="stylesheet" href="layout/css/bootstrap.min.css">
      <link rel="stylesheet" href="layout/css/font-awesome.min.css">
      <link rel="stylesheet" href="layout/css/jquery-ui.min.css">
      <link rel="stylesheet" href="layout/css/jquery.selectBoxIt.css">
      <link rel="stylesheet" href="layout/css/front.css">
  </head>

<body>
  <div class="upper-nav">
    <div class="container">
      <?php
         if(isset($_SESSION['user'])){ ?>
           <img class=' my-img img-thumbnail img-circle' src = 'img.jpg' alt='no thing'>
           <div class=" btn-group info">
              <span class="btn btn-default dropdown-toggle" data-toggle = "dropdown">
                   <?php echo $_SESSION['user'] ; ?>
              </span>
              <span class="caret"></span>
              <ul class="dropdown-menu">
                <li><a href="profile.php">My profile</a></li>
                <li><a href="newad.php">New Item</a></li>
                <li><a href="profile.php#my-ads">My Ads</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
           </div>
        <?php

           $userstatus = checkuserstatus($_SESSION['user']) ;

           if ($userstatus == 1) {
              //USER not active
           }
         }
         else {
      ?>
      <a href="login.php">
        <span class="pull-right">Login/Signup</span>
      </a>
      <?php  } ?>
    </div>
  </div>
  <nav class="navbar navbar-inverse">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">HomePage</a>
      </div>
      <div class="collapse navbar-collapse " id="nav">
        <!-- <li><a href="categories.php"></a></li> -->
        <ul class="nav navbar-nav navbar-right">
         <?php
         foreach (get_category('where parent = 0') as $cat) {
            echo"<li><a href='categories.php?pageid=" . $cat['id'] . "'>". $cat['name'] . "</a></li>";
         }
         ?>
      </ul>

      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
