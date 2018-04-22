<?php
      ob_start();

     session_start();


      $pagetitle = 'Create New Ad';

       include "init.php";


    if (isset($_SESSION['user'])) {

      if( $_SERVER['REQUEST_METHOD'] == 'POST'){

        $errorform = array();

         $name         = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
         $description  = filter_var($_POST['des'],FILTER_SANITIZE_STRING);
         $price        = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
         $made_cantery = filter_var($_POST['made'],FILTER_SANITIZE_STRING);
         $status       = filter_var($_POST['stat'],FILTER_SANITIZE_NUMBER_INT);
         $category     = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);

         $memberid = $_SESSION['userid'];

         if(strlen($name) < 4){
           $errorform[] = 'The Title Must Be Larger Then 4 Character';
         }

         if(strlen($description) < 10){
           $errorform[] = 'The Description Must Be Larger Then 10 Character ';
         }

         if(strlen($made_cantery) < 2){
           $errorform[] = 'The Cantery Must Be Larger Then 2 Chararcter ';
         }

         if ( empty($price) ){
           $errorform[] = 'The Price Must Be Not Empty ';
         }

         if(empty($errorform)){


             $stmt = $con->prepare("insert into
                                               items(
                                                 name ,
                                               description ,
                                                price ,
                                                add_date ,
                                                country_made ,
                                                 status ,
                                                 cat_id ,
                                                 member_id)
                                               values(?,?,?,now(),?,?,?,?)");

                $stmt->execute(
                  array(
                    $name,
                    $description,
                    $price,
                    $made_cantery,
                    $status,
                    $category,
                    $memberid
                  )
                );

                $successmes = $stmt->rowCount()."Records Insert";


              }

      }

     ?>

   <h1 class="text-center"> Add New Ad</h1>
  <div class="add_ad block">
    <div class="container">
     <div class="panel panel-primary">
      <div class="panel-heading"> Create New Ad</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-8 col-xs-8">
            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="post">

                <div class="form-group">
                   <label class="col-sm-3 control-label">Name</label>
                     <div class="col-lg-8 col-sm-9 col-md-4">
                   <input
                   pattern = ".{2,}"
                   title="The Name Must Be At least 2 Character"
                   type="text"
                   name="name"
                   class="form-control live-name"
                   required
                     >
                  </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-3 control-label">Description</label>
                     <div class="col-lg-8 col-sm-9 col-md-4">
                   <input
                   pattern=".{10,30}"
                   title="The Name Must Be At least 10 Character And At Most 30"
                   type="text"
                   name="des"
                   class="form-control live-desc"
                   required
                     >
                  </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-3 control-label">Price</label>
                     <div class="col-lg-8 col-sm-9 col-md-4">
                   <input
                   type="text"
                   name="price"
                   class="form-control live-price"
                   required
                     >
                  </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-3 control-label">Country Made</label>
                     <div class="col-lg-8 col-sm-9 col-md-4">
                   <input type="text" name="made" required class="form-control">
                  </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-3 control-label">Status</label>
                     <div class="col-lg-8 col-sm-9 col-md-4">
                     <select name="stat" required>
                        <option value="">.....</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">old</option>
                     </select>
                  </div>
                </div>

                <div class="form-group">
                   <label class="col-sm-3 control-label">Category</label>
                     <div class="col-lg-8 col-sm-9 col-md-4">
                     <select name="category" required>
                        <option value="">.....</option>
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
                      <div class="col-sm-offset-3 col-sm-9">
                       <input type="submit"  value="Add New Item" class="btn btn-primary ">
                      </div>
                   </div>
              </form>

          </div>
          <div class="col-md-4 col-xs-4">
              <div class='thumbnail item-box live-preview'>
               <span class="price-tag">0$</span>
                <img class='img-responsive' src = 'img.jpg' alt='no thing'>
                 <div class='caption'>
                   <h3>Title</h3>
                    <p>Description</p>
                 </div>
             </div>
          </div>
        </div>
      </div>
     </div>
     <?php
       if(!empty($errorform) || !empty($successmes)){

         foreach ($errorform as $error) {
           echo "<div class='alert alert-danger'>".$error ."</div>";
         }
          if(isset($successmes)){
          echo "<div class='alert alert-success'>".$successmes."</div>";
        }

       }
      ?>
    </div>
  </div>

<?php

}else {

  header('Location:login.php');

  exit();
}
  include $tpl.'footer.php';

  ob_end_flush();
 ?>
