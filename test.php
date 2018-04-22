<?php
 ob_start();
 require "init.php";
 ?>
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
   <input type="submit" value="open pdf file" name="pdf" />
  </form>
<?php
  if (isset($_POST['pdf'])) {
    header('Location:abdo_cv.pdf');
  }
require $tpl."footer.php";
ob_end_flush();
 ?>
