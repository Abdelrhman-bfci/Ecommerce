<?php

        ob_start();

        session_start();

        $pagetitle = 'Show Item';

         include "init.php";

         if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){

          $itemid = intval($_GET['itemid']);
         }
         else {
          $itemid=0;
         }

         $stmt = $con->prepare('select
                                    items.* ,
                                    categories.name as catname,
                                    user.username
                                from
                                    items
                                join
                                    categories
                                on
                                  categories.id = items.cat_id
                                join
                                   user
                                on
                                  user.userid = items.member_id
                                where
                                   item_id = ?
                                  ');

          $stmt->execute(array($itemid));
        //  while($ft = $stmt->fetch()){
        //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
        //  }
         $items = $stmt->fetch();

         $count =  $stmt->rowCount();

         if( $count>0 ){

 ?>
<h1 class="text-center"> <?php echo $items['name']; ?> </h1>
<div class="container">
    <div class="row">
      <div class="col-md-3 col-xs-3">
           <img class='img-responsive img-thumbnail center-block' src = 'img.jpg' alt='no thing'>
      </div>
      <div class="col-md-9 col-xs-9 item-info">
         <h2><?php echo $items['name']; ?></h2>
         <p>The Description : <?php echo $items['description']; ?></p>
          <ul class="list-unstyled ">
             <li>
               <i class="fa fa-calendar fa-fw"></i>
               <span>The Date : </span><?php echo $items['add_date']; ?>
             </li>
             <li>
               <i class="fa fa-money fa-fw"></i>
               <sapn>The Price :</span> $<?php echo $items['price']; ?>
             </li>
             <li>
               <i class="fa fa-building fa-fw"></i>
               <sapn> Made in </sapn><?php echo $items['country_made']; ?>
             </li>
             <li>
               <i class="fa fa-tag fa-fw"></i>
                <sapn>Category :</sapn><a href="categories.php?pageid=<?php echo $items['cat_id']; ?>"> <?php echo $items['catname']; ?> </a>
             </li>
             <li>
               <i class="fa fa-user fa-fw"></i>
               <sapn>Add By :</sapn> <a href="#"> <?php echo $items['username']; ?> </a>
             </li>
          </ul>
    </div>
  </div>
  <hr class="custom-hr">
  <?php if (isset($_SESSION['user'])){ ?>
    <div class="row">
     <div class="col-md-offset-3">
       <div class="add-comment">
         <h3>Add Comment </h3>
          <script>
            function getcomment(){

              var xmlhttp;

              if(window.XMLHttpRequest){
                xmlhttp = new XMLHttpRequest();
              }
              else{
                xmlhttp = new ActiveXobject("Microsoft.HTTPXML");
              }

              xmlhttp.onreadystatechange = function(){

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                  document.getElementById("com").innerHTML = xmlhttp.responseText;
                }

              }

              xmlhttp.open("GET","showitem.php #com",true);

              xmlhttp.send();
            }
          </script>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid='.$items['item_id'] ; ?>" method="POST">
           <textarea name="comment" id="com" required></textarea>
           <input type="submit" class="btn btn-primary btn-sm" value="Add Comment" >
        </form>
        <?php

         if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
          $userid = $_SESSION['userid'];
          $itemid = $items['item_id']  ;



          if (!empty($comment)) {
               $stmt = $con->prepare("insert into
                      comments(comments,status,comment_date,item_id,user_id)
                      values(?,0,now(),?,?)
               ");
              $stmt->execute(
                array(
                $comment,
                $itemid,
                $userid
              ));

              if($stmt){
                echo "<div class='alert alert-success'> Comment Add </div>";

                

              }
          }
          else {
              echo "<div class='alert alert-danger'> please enter cooment </div>";
          }



        }
        ?>
      </div>
     </div>
    </div>
    <?php }else {
       echo "<a href = 'login.php'>Login </a>or Rgister to comment";
    } ?>
  <hr class="custom-hr">
  <?php

       $stmt = $con->prepare("select
                                 comments.* ,
                                   user.username as username
                                 from
                                  comments
                                 join
                                  user
                                 on
                                  comments.user_id = user.userid
                                 where
                                  item_id =?
                                  and
                                 status = 1
                                ORDER BY cid DESC
                                 ");

       $stmt->execute(array($items['item_id']));

       $coms = $stmt->fetchAll();
       ?>



    <?php  foreach ($coms as $com) { ?>
                <div class="comment-box">
                  <div class='row'>
                     <div class="col-sm-2 text-center">
                       <img class='img-responsive img-thumbnail img-circle center-block' src = 'img.jpg' alt='no thing'>
                       <?php echo $com['username'] ; ?>
                     </div>
                     <div class="col-sm-10">
                       <p class="load" id="com"><?php echo $com['comments'] ; ?></p>
                     </div>
                  </div>";
                </div>
                <hr class="custom-hr">
      <?php }?>
</div>


<?php
  }else {
  echo ' <div class="container">';
   echo '<div class="alert alert-danger">No Item With This ID </div>';
 echo "</div>";
}
include $tpl.'footer.php';
  ob_end_flush();
 ?>
