<?php
   ob_start();

    session_start();

   $pagetitle = 'Categories';

   if(isset($_SESSION['username'])){

           include "init.php";

           $do = '';

           if(isset($_GET['do'])){ $do = $_GET['do']; }else { $do = 'manage'; }

           if ($do == 'manage' ) {

                   $sort = 'asc';
                   $sort_array = array('asc','desc');
                   if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
                     $sort = $_GET['sort'];
                   }
                    $stmt2 = $con->prepare("select * from categories where parent = 0 order by ordering $sort");

                    $stmt2->execute();

                    $cats = $stmt2->fetchAll();
             ?>

                <h1 class="text-center"> The Categories Management</h1>
                <div class="container categories">
                   <div class="panel panel-default">
                     <div class="panel-heading"><i class="fa fa-edit"></i>Manage Categories
                      <div class="option pull-right">
                         <i class="fa fa-sort"></i>Ordering:[
                          <a class="<?php if($sort == 'asc'){ echo 'active' ; } ?>" href="?sort=asc">Asc </a>|
                          <a class="<?php if($sort == 'desc'){ echo 'active' ; } ?>" href="?sort=desc"> Desc</a>]
                           <i class="fa fa-low-vision"></i>View:[
                            <span class="active" data-view = "full">full </span>|
                            <span data-view = "classic">Classic</span>]
                      </div>
                     </div>
                      <div class="panel-body">
                        <?php
                           foreach ($cats as $cat) {
                             echo "<div class='cat'>";
                             echo"<div class='hidden-buttons'>";
                                echo '<a class="btn btn-primary btn-xs" href="categories.php?do=edit&catid='.$cat['id'].'">
                                <i class ="fa fa-edit"></i> Edit </a>';
                                echo '<a class="btn btn-danger btn-xs confirm" href="categories.php?do=delete&catid='.$cat['id'].'">
                                <i class="fa fa-close"></i>Delete </a>';
                             echo "</div>";
                             echo '<h3>'.$cat['name']."</h3>";
                             echo "<div class='full-view'>";
                                 echo '<p>'; if($cat['description'] == '')
                                 {echo "There is no description";} else {
                                   echo $cat['description'];
                                 } echo "</p>";
                                 if($cat['visibility']==1){echo '<span class="visibility"><i class="fa fa-low-vision"></i>Hidden</span>'; }
                                 if($cat['allow_comment']==1){echo '<span class="comment"><i class="fa fa-close"></i>Commenting Disable</span>'; }
                                 if($cat['allow_ads']==1){echo '<span class="advertises"><i class="fa fa-close"></i>advertises Disable</span>'; }


                            // get sup Category of this category
                          if (!empty(get_category("where parent = {$cat['id']}"))) {

                            echo "<h4 class='cat-head'> Chaild Category </h4>";
                               
                          echo "<ul class='list-unstyled cat-child'>";
                           foreach (get_category("where parent = {$cat['id']}") as $cat) {

                           echo'<li class="child-link"><a href="categories.php?do=edit&catid='.$cat['id'].'" >'.$cat['name'] . '</a></li>';
                              echo '<a class="show-delete confirm" href="categories.php?do=delete&catid='.$cat['id'].'">Delete </a>';
                           }
                           echo "</ul>";
                           
                           
                           }

                             echo "</div>";
                           
                        
                            echo "</div>";
                            echo "<hr>";
                         }

                         ?>
                      </div>

                   </div>
                     <a class="cat-btn btn btn-primary" href="categories.php?do=add">
                       <i class="fa fa-plus"></i>  Add New Categorie
                     </a>
                </div>



      <?php        } elseif ($do == 'add') { ?>

             <h1 class="text-center"> Add New Categorie </h1>
             <div class="container">
                <form class="form-horizontal" action="categories.php?do=insert" method="post">

                    <div class="form-group">
                       <label class="col-sm-2 control-label">Name</label>
                         <div class="col-lg-8 col-sm-10 col-md-4">
                       <input type="text" name="name" class="form-control" autocomplete="off" required="required" >
                      </div>
                   </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                          <div class="col-lg-8 col-sm-10 col-md-4">
                           <input type="text" name="description" class="form-control">
                      </div>
                    </div>
                      <div class="form-group">
                         <label class="col-sm-2 control-label">Order</label>
                           <div class="col-lg-8 col-sm-10 col-md-4">
                         <input type="text" name="order" class="form-control">
                        </div>
                     </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Parent </label>
                          <div class="col-lg-8 col-sm-10 col-md-4">
                            <select name="parent">
                              <option value="0">None</option>
                              <?php 
                               $category =  get_cat('where parent = 0 ');
                               foreach ($category as $c) {
                                 echo "<option value ='".$c['id']."'>".$c['name']."</option>";
                               }
                              ?>
                            </select>
                       </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Visibility</label>
                          <div class="col-lg-8 col-sm-10 col-md-4">
                            <div>
                                <input id="vis-yes" type="radio" name="visibal" value="0" checked >
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibal" value="1"  >
                                <label for="vis-no">No</label>
                            </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-sm-2 control-label">Allow Comment</label>
                         <div class="col-lg-8 col-sm-10 col-md-4">
                           <div>
                               <input id="com-yes" type="radio" name="com" value="0" checked >
                               <label for="com-yes">Yes</label>
                           </div>
                           <div>
                               <input id="com-no" type="radio" name="com" value="1"  >
                               <label for="com-no">No</label>
                           </div>
                      </div>
                   </div>
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-lg-8 col-sm-10 col-md-4">
                          <div>
                              <input id="ads-yes" type="radio" name="ads" value="0" checked >
                              <label for="ads-yes">Yes</label>
                          </div>
                          <div>
                              <input id="ads-no" type="radio" name="ads" value="1"  >
                              <label for="ads-no">No</label>
                          </div>
                     </div>
                  </div>
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                           <input type="submit"  value="Add New Categories" class="btn btn-primary ">
                          </div>
                       </div>

                  </form>
             </div>

<?php      } elseif ($do == 'insert') {

                      echo  " <h1 class='text-center'> Insert  New Categorie </h1>";
                      echo '<div class="container">';
                     if($_SERVER['REQUEST_METHOD'] == 'POST'){


                           $name = $_POST['name'];
                           $des = $_POST['description'];
                           $parent = $_POST['parent'];
                           $order = $_POST['order'];
                           $visible = $_POST['visibal'];
                           $comment = $_POST['com'];
                           $ads = $_POST['ads'];

                           // update records
                      if(!empty($name)){

                             $check =   checkitem( 'name' ,"categories",$name);

                             if ($check == 1) {
                               $messag = "<div class='alert alert-danger'>Sorry this Categorie is exit</div>";
                                 redircthome($messag ,'back');
                             }
                             else {


                                 $stmt = $con->prepare("insert into
                                 categories(name,description,parent,ordering,visibility,allow_comment,allow_ads)
                                 values(?,?,?,?,?,?,?)");
                                 $stmt->execute(array($name,$des,$parent,$order,$visible,$comment,$ads));

                               $messag = '<div class="alert alert-success">' .$stmt->rowCount() . " Records Insert".'</div>' ;
                                 redircthome($messag,'back');
                             }
                          }
                        else {
                          $messag = '<div class="alert alert-success">Please enter the Name Of Categorie</div>' ;
                            redircthome($messag,'back');
                        }
                  }else {
                        // echo "Sorry you can't enter this page directiry";
                         $massege = '<div class="alert alert-danger">Sorry you can\'t enter this page directiry</div>';
                         redircthome($massege,'back',5);
                      }
                      echo "</div>";
       } elseif ($do == 'edit') {
             if(isset($_GET['catid']) && is_numeric($_GET['catid'])){

              $catid = intval($_GET['catid']);
             }
             else {
              $catid=0;
             }

             $stmt = $con->prepare('select * from Categories where id = ? ');
               $stmt->execute(array($catid));
            //  while($ft = $stmt->fetch()){
            //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
            //  }
             $cats = $stmt->fetch();

             $count =  $stmt->rowCount();

             if($count>0){
            ?>

                <h1 class="text-center"> Edit Categorie </h1>
                <div class="container">
                   <form class="form-horizontal" action="categories.php?do=update" method="post">
                       <input type="hidden" name="catid" value="<?php echo $catid ;  ?>">
                       <div class="form-group">
                          <label class="col-sm-2 control-label">Name</label>
                            <div class="col-lg-8 col-sm-10 col-md-4">
                          <input type="text" name="name" class="form-control" value="<?php echo $cats['name'] ; ?>" required="required" >
                         </div>
                      </div>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">Description</label>
                             <div class="col-lg-8 col-sm-10 col-md-4">
                              <input type="text" name="description" class="form-control" value="<?php echo $cats['description'] ; ?>">
                         </div>
                       </div>
                         <div class="form-group">
                            <label class="col-sm-2 control-label">Order</label>
                              <div class="col-lg-8 col-sm-10 col-md-4">
                            <input type="text" name="order" class="form-control" value="<?php echo $cats['ordering'] ; ?>">
                           </div>
                        </div>
                        <div class="form-group">
                        <label class="col-sm-2 control-label">Parent</label>
                          <div class="col-lg-8 col-sm-10 col-md-4">
                            <select name="parent">
                              <option value="0">None</option>
                              <?php 
                               $category =  get_cat('where parent = 0 ');
                               foreach ($category as $c) {
                                 echo "<option ";
                                 if ($cats['parent'] == $c['id']) { echo "selected";}
                                 echo" value ='".$c['id']."'>".$c['name']."</option>";
                               }
                              ?>
                            </select>
                       </div>
                    </div>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">Visibility</label>
                             <div class="col-lg-8 col-sm-10 col-md-4">
                               <div>
                                   <input id="vis-yes" type="radio" name="visibal" value="0" <?php if($cats['visibility'] == 0){ echo "checked";} ?> >
                                   <label for="vis-yes">Yes</label>
                               </div>
                               <div>
                                   <input id="vis-no" type="radio" name="visibal" value="1" <?php if($cats['visibility'] == 1){ echo "checked";} ?> >
                                   <label for="vis-no">No</label>
                               </div>
                          </div>
                       </div>
                       <div class="form-group">
                          <label class="col-sm-2 control-label">Allow Comment</label>
                            <div class="col-lg-8 col-sm-10 col-md-4">
                              <div>
                                  <input id="com-yes" type="radio" name="com" value="0" <?php if($cats['allow_comment'] == 0){ echo "checked";}?> >
                                  <label for="com-yes">Yes</label>
                              </div>
                              <div>
                                  <input id="com-no" type="radio" name="com" value="1" <?php if($cats['allow_comment'] == 1){ echo "checked";}?> >
                                  <label for="com-no">No</label>
                              </div>
                         </div>
                      </div>
                      <div class="form-group">
                         <label class="col-sm-2 control-label">Allow Ads</label>
                           <div class="col-lg-8 col-sm-10 col-md-4">
                             <div>
                                 <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cats['allow_ads'] == 0){ echo "checked";}?> >
                                 <label for="ads-yes">Yes</label>
                             </div>
                             <div>
                                 <input id="ads-no" type="radio" name="ads" value="1" <?php if($cats['allow_ads'] == 1){ echo "checked";}?> >
                                 <label for="ads-no">No</label>
                             </div>
                        </div>
                     </div>
                           <div class="form-group">
                             <div class="col-sm-offset-2 col-sm-10">
                              <input type="submit"  value="Save Categories" class="btn btn-primary ">
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

      }elseif ($do == 'update') {

              echo  " <h1 class='text-center'> Update Category </h1>";
              echo '<div class="container">';
             if($_SERVER['REQUEST_METHOD'] == 'POST'){

                   $catid       = $_POST['catid'];
                   $name        = $_POST['name'];
                   $des         = $_POST['description'];
                   $order       = $_POST['order'];
                   $parent      = $_POST['parent'];
                   $visible     = $_POST['visibal'];
                   $com         = $_POST['com'];
                   $ads         = $_POST['ads'];

                   // update records
               if(!empty($name)){
                   $stmt = $con->prepare("update categories
                   set name =? ,description =?, ordering =? , parent =? ,
                    visibility =? , allow_comment=? ,allow_ads=?
                   where id =? ");
                   $stmt->execute(array($name,$des,$order,$parent,$visible,$com,$ads,$catid));

                   $messag = '<div class="alert alert-success">' .$stmt->rowCount() . " Records update".'</div>' ;
                   redircthome($messag ,'back');
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
              if(isset($_GET['catid']) && is_numeric($_GET['catid'])){

               $catid = intval($_GET['catid']);
              }
              else {
               $catid = 0;
              }

              $stmt = $con->prepare('select * from categories where id = ? limit 1');
                $stmt->execute(array($catid));
             //  while($ft = $stmt->fetch()){
             //     echo $ft[0] . $ft[1] .$ft[2] .$ft[3] . $ft[4];
             //  }
              $cats = $stmt->fetch();

              $count =  $stmt->rowCount();
              if($count>0){

                $stmt = $con->prepare('Delete from categories where id = ?');
                $stmt->execute(array($catid));
                echo  " <h1 class='text-center'> Delete Member </h1>";
                echo '<div class="container">';

                $messag =  '<div class="alert alert-success">' .$stmt->rowCount() . " Records Delete".'</div>' ;
                redircthome($messag ,'back');
                echo "</div>";
              }
              else {
                echo "<div class='container'>";
                $messag = "<div class='alert alert-danger'>The category id is not exist </div>";
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
