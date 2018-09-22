
<?php

session_start();

$do="";
if(isset ($_SESSION["user"])){


if (isset($_GET["do"])){

    $do = $_GET["do"];
}
else {
    $do = "manage";
}}



if($do == "manage"){//صفحة عرض الاعضاء 
    $pagetitle="عرض الكومينتات";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";




        $stmt=$db->prepare("SELECT comment.*,items.name AS item2,users.name AS username2 FROM comment
        INNER JOIN items
        ON items.name_id=comment.item_id
        INNER JOIN users
        ON users.userid=comment.user_id");

        $stmt->execute();
        $rows=$stmt->fetchALL();

    ?>
       <h2 class='text-center'>Manage comment</h2><br>
        <div class="container">
                <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                                <tr>
                                        <td>Id</td>
                                        <td>comment</td>
                                        <td>username</td>
                                        <td>items</td>
                                        <td>Regsterd data</td>
                                        <td>Control</td>
                                </tr>
                                
                                <?php
                                foreach($rows as $row){
                                 echo "<tr>";
                                        echo "<td>".$row["c_id"]."</td>";
                                        echo "<td>".$row["comment"]."</td>";
                                        echo "<td>".$row["username2"]."</td>";
                                        echo "<td>".$row["item2"]."</td>";
                                        echo "<td>".$row["comment_date"]."</td>";
                                        echo "<td>
                                       <a href='comments.php?do=edit&comid=".$row['c_id']."'class='btn btn-success'>Edit</a>
                                    <a href='comments.php?do=delete&comid=".$row['c_id']."' class='btn btn-danger confirm'>Delete</a>";
                                        if($row["state"]==0){//يعني اذا كان عضو غير مفعل نفذ هذا الكود وهو اظهار هاد الزر

                                              echo" <a href='comments.php?do=approve&comid=".$row['c_id']."' class='btn btn-primary'>activate</a>";   

                                        }
                                      echo " </td>";//كلاس كونفيرم سويتو بالجي كويري عشان يطلعلي رسالة تاكيد

                             echo "</tr>";

                                }

                                ?>
                        </table>
                </div>
               
        </div>




      <?php
    include "footer.php";
}//نهاية صفحة عرض الاعضاء





elseif ($do=="edit"){//بداية صفحة التعديل  

   $pagetitle ="Edit members";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";
   
        
    
    ?>
   <?php 
 
     
   if(isset($_GET["comid"])&&is_numeric($_GET["comid"]))
   {
    $comid=$_GET["comid"];
      
   
   }
   $stmt=$db->prepare("SELECT * FROM comment WHERE c_id=? ");
   $stmt->execute(array($comid));
   $row = $stmt->fetch();
   $count = $stmt->rowCount();
 
 
   
if($count>0){
   
?>
<h1 style="text-align:center; font-weight:bold" > Edit comment</h1>
 <div style="margin-left:200px" >
                
        <form class="container" action="comments.php?do=update" method="POST">

        <input type="hidden" name="comid" value="<?php echo $row["c_id"]?>"/>
            <div class="row margin">
                    <lable class= "col-md-2 ">comment</lable>
                    <textarea name="comment" class="col-md-6" ><?php echo $row["comment"];?></textarea>

            </div> 
         
            <div class="row margin">
                    <lable class= "col-md-offset-2"></lable>
                    <input type="submit" class="btn btn-brimary btn-lg"  value="Save" style="width:50%"/>

            </div>      
        <form>

</div>





   <?php   
         
   
}





 
      include "footer.php";
}//نهاية صفحة التعديل





elseif($do=="update"){//بداية صفحة التحديث
        $pagetitle ="update comment";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";

          echo '<h1 class="text-center">Update members</h1>';
if($_SERVER["REQUEST_METHOD"]=="POST"){

        $comid=$_POST["comid"];
        $comment =$_POST["comment"];
        


               
                        $stmt=$db->prepare("UPDATE comment SET comment =?  WHERE c_id = ?");
                        $stmt->execute(array($comment,$comid));
                        echo "<h3>ROW UPDATED</h3> <br>";
                      
                        
                      }
                      else{
                        
                        redrict("we will be dirctly to home page",4);
                                }
                


                

        include "footer.php";


}//نهاية صفحة التحديث



elseif($do=="delete"){//بداية صفحة الحذف
        $pagetitle ="delete comment";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
       
      
       if(isset($_GET["comid"])&&is_numeric($_GET["comid"]))
       {
        $comid=$_GET["comid"];
          
       
       }
       $stmt=$db->prepare("SELECT * FROM comment WHERE c_id=? ");
       $stmt->execute(array($comid));
       
       $count = $stmt->rowCount();

       if($count> 0){
               $stmt = $db->prepare("DELETE FROM comment WHERE c_id=:zc_id");
               $stmt->bindParam(":zc_id",$comid);
               $stmt->execute();
               ?>
               <div class='alert alert-success'>the row was deleted</div>
               <?php



       }
     
include "footer.php";


}//نهاية صفحة الحذف

elseif($do=="approve"){//بداية صفحة التفعيل
        $pagetitle ="approve comment";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";
       
      
       if(isset($_GET["comid"])&&is_numeric($_GET["comid"]))
       {
        $comid=$_GET["comid"];
          
       
       }
           $check=checkitem("c_id","comment",$comid);
      if($check >0){
        $stmt = $db->prepare("UPDATE comment SET state=1 WHERE c_id=?");
        $stmt->execute(array($comid));
        ?>
        <div class='alert alert-success'>the row was activated</div>
        <?php




      }






       
     
include "footer.php";

  

}//نهاية صفحة التفعيل





else{
    echo "ما في صفحة بهاد العنوان...اتاكد من  العنوان يا باشا";
}


