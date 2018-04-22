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
      <a class="navbar-brand" href="dashbord.php"><?php echo lang('Home'); ?></a>
    </div>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="nav navbar-nav">
      <li><a href="categories.php"><?php echo lang('Categories'); ?></a></li>
      <li><a href="members.php?do=manage"><?php echo lang('Members'); ?></a></li>
      <li><a href="item.php"><?php echo lang('Item'); ?></a></li>
      <li><a href="comment.php"><?php echo lang('Commenting'); ?></a></li>
      <li><a href="#"><?php echo lang('statistics'); ?></a></li>
      <li><a href="#"><?php echo lang('Logs'); ?></a></li>
    </ul>
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Abdo <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop</a></li>
            <li><a href="Members.php?do=Edit&userid=<?php echo $_SESSION['id']; ?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>

          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
