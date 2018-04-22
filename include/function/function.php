<?php

    /*
      **
      **
      ** This function used to Fetch  element of All Records of database
      **
      */

       function get_All($tablename){

         global $con ;

         $stmt = $con->prepare("SELECT * FROM  $tablename WHERE approve = 1");
 
         $stmt->execute();

          $All = $stmt->fetchAll();

         return $All ;


       }



          /*
          **
          **
          ** This function used to Fetch  element of Items Datebase
          **
          */

           function getItem($where , $value, $approve=null ){

             global $con ;
              if ($approve == null) {
                $sql = 'and approve = 1';
              }
              else {
                $sql =null;
              }
             $stmt = $con->prepare("select * from items where $where = ? $sql ORDER BY item_id DESC");

             $stmt->execute(array($value));

              $items = $stmt->fetchAll();

             return $items ;


           }


    
      /*
      **
      **
      ** This function used to Fetch  element of Category
      **
      */

       function get_category($where = NULL){

         global $con ;

         $stmt = $con->prepare("select * from categories $where");

         $stmt->execute();

          $cats = $stmt->fetchAll();

         return $cats ;


       }

         /*
      **
      **
      ** This function used to Fetch  element of Category
      **
      */

       function get_cat($where){

         global $con ;

         $stmt = $con->prepare("select * from categories $where");

         $stmt->execute();

          $cats = $stmt->fetchAll();

         return $cats ;


       }


       /*
       ** This function used to check user status in the database
       ** if is active or not active
       */

     function checkuserstatus($user){

       global $con ;

       $stmt = $con->prepare("
                         select
                            username, truststat
                         from
                             user
                          where
                             username = ?
                          and
                            truststat = 0
                           ");
        $stmt->execute(array($user));

       $count =  $stmt->rowCount();

        return $count;

     }


  /*
  *
  This function is used to determine the title of avialable title
  *
  */

  function GetTitle (){

     global $pagetitle ;

     if(isset($pagetitle)){

       echo $pagetitle;
     }

     else {
       echo "Default";
     }
  }

  /*

  ** This function used to redirect to home page
  **

  */

  function redircthome($massege ,$url=null, $seconds = 3){

      echo $massege;
      if ($url === null) {
        $url = 'index.php';
      }
      else {
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
             $url = $_SERVER['HTTP_REFERER'];
             }else{
             $url ='index.php';
           }
      }
      echo "<div class='alert alert-info'> You will to redirect $url page after $seconds</div>";

      header("refresh:$seconds;url=$url");
      exit();

  }

   /*
   ** This function used to check item in the database for no duplication
   **
   */
   function checkitem($select ,$from ,$value){

    global $con;
    $stmt1 = $con->prepare("select $select from $from where $select = ?");
    $stmt1->execute(array($value));

    $count = $stmt1->rowCount();

     // echo "<div class='alert-info'>The Item Aready Exit </div>"
     return  $count;

   }

   /*
   **
   **
   ** THis function used to counting the number of any item
   **
   */

   function Itemcount ($item , $table ,$condition='')
   {
        global $con ;

           $stmt = $con->prepare("select count($item) from $table $condition");

           $stmt->execute();

           $usercount =  $stmt->fetchColumn();

           return $usercount;

   }

   /*
   **
   **
   ** This function used to Fetch letest element of section
   **
   */

    function getlatest($select , $table , $order ,$limit = 5){

      global $con ;

      $stmt = $con->prepare("select $select from $table order by $order desc limit $limit");

      $stmt->execute();

       $rows = $stmt->fetchAll();

      return $rows ;


    }

 ?>
