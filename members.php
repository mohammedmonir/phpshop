
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
    $pagetitle="عرض الاعضاء";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";
?><div class="container">
    <a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  Click to page add members</a>
</div>
  <?php  

        $query="";//لطباعة الاعضاء الغير مفعلين في حقل وهم عبارة عن 1state  
        if(isset($_GET["page"])&&$_GET["page"]=="pending"){

                $query="WHERE state = 1";

        }



        $stmt=$db->prepare("SELECT * FROM users $query ORDER BY userid DESC");
        $stmt->execute();
        $rows=$stmt->fetchALL();


    ?>
       <h2 class='text-center'>Manage members</h2><br>
        <div class="container m1">
                <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                                <tr>
                                        <td>Id</td>
                                        <td>username</td>
                                        <td>img</td>
                                        <td>email</td>
                                        <td>fullname</td>
                                        <td>Regsterd data</td>
                                        <td>Control</td>
                                </tr>
                                
                                <?php
                                foreach($rows as $row){
                                 echo "<tr>";
                                        echo "<td>".$row["userid"]."</td>";
                                        echo "<td>";
                                                if(empty($row["avatar"])){
                                                        echo "no img";
                                                }else{
                                                echo "<img class='m2' src='uploads/avatar/".$row["avatar"]."'/>";
                                                }
                                         echo "</td>";

                                        echo "<td>".$row["name"]."</td>";
                                        echo "<td>".$row["email"]."</td>";
                                        echo "<td>".$row["fullname"]."</td>";
                                        echo "<td>".$row["date"]."</td>";
                                        echo "<td>
                                       <a href='members.php?do=edit&userid=".$row['userid']."'class='btn btn-success'>Edit</a>
                                    <a href='members.php?do=delete&userid=".$row['userid']."' class='btn btn-danger confirm'>Delete</a>";
                                        if($row["state"]==1){//يعني اذا كان عضو غير مفعل نفذ هذا الكود وهو اظهار هاد الزر

                                              echo" <a href='members.php?do=activate&userid=".$row['userid']."' class='btn btn-primary'>activate</a>";   

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


elseif($do=="add"){//بداية صفحة الاضافة
        $pagetitle="صفحة اضافة الاعضاء";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";

        ?>
        <h1 style="text-align:center; font-weight:bold"> Add member</h1>
        <div style="margin-left:200px" >
                       
               <form class="container" action="members.php?do=insert" method="POST" enctype="multipart/form-data">
       
              
                   <div class="row margin">
                           <lable class= "col-md-2 ">username</lable>
                           <input type="text" name="username" class="col-md-6" required="required" value="" />
       
                   </div> 
                   <div class="row margin">
                           <lable class= "col-md-2">password</lable>
                           <input type="password" name="password" class="col-md-6 "/>
       
                   </div> 
                   <div class="row margin">
                           <lable class= "col-md-2">Email</lable>
                           <input type="email" name="email" class="col-md-6" required="required" />
       
                   </div> 
                   <div class="row margin">
                           <lable class= "col-md-2">Full Name</lable>
                           <input type="text" name="fullname" class="col-md-6" required="required"   />
       
                   </div>      
                   <div class="row margin">
                           <lable class= "col-md-2">upload img</lable>
                           <input type="file" name="avatar" class="col-md-6"   />
       
                   </div>      
                   <div class="row margin">
                           <lable class= "col-md-offset-2"></lable>
                           <input type="submit" class="btn btn-brimary btn-lg" style="width:50%" value="add">
       
                   </div>      
               <form>
       
       </div>
       

<?php
include "footer.php";
}//نهاية صفحة الاضافة


elseif($do=="insert"){//بداية صفحة الاضافة الجزء الثاني المرتبطة بالجزء الاول 



        $pagetitle ="added members";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";

          echo '<h1 class="text-center">added members</h1>';
if($_SERVER["REQUEST_METHOD"]=="POST"){


        $avatarname = $_FILES["avatar"]["name"];
        $avatarsize = $_FILES["avatar"]["size"];
        $avatartmp = $_FILES["avatar"]["tmp_name"];
        $avatartype = $_FILES["avatar"]["type"];

        

     
        $username =$_POST["username"];
        $password =$_POST["password"];
        $email    =$_POST["email"];
        $fullname =$_POST["fullname"];



        $_SESSION["username"]=$username;
        $_SESSION["password"]=$password;
        $_SESSION["email"]   = $email    ;    
        $_SESSION["fullname"] =$fullname ;


            $formerror=array();
                if(strlen($username)<4){

                        $formerror[]="<div class='container alert alert-danger'>the username is less than 4</div>";

                }
                if(empty($username)){

                        $formerror[]="<div class='container alert alert-danger'>user name is empty</div>";
                }
                  if(empty($password)){

                        $formerror[]="<div class='container alert alert-danger'>user password is empty</div>";
                }
                  if(empty($email)){

                        $formerror[]="<div class='container alert alert-danger'>user email is empty</div>";
                }
                
                if(empty($fullname)){

                        $formerror[]="<div class='container alert alert-danger'>user fullname is empty</div>";
                }
                foreach($formerror as $error){

                        echo $error."<br>";
                }
               if(empty($formerror)){
                       $avatar = rand(0 ,100000)."_". $avatarname;
                       move_uploaded_file($avatartmp,"uploads\avatar\\".$avatar);
                        
                    
                        $check = checkitem("name","users",$username); //فنكشن لفحص الاسم هل هو موجود ام لا...يجب ان يكون الاسم غير مكرر في قاعدة البيانات حتى يعمل هذا الفنكشن
                        if($check==1){

                                echo "Sorry :this name is exist";

                        }
                        else{
                        
                       $stmt=$db->prepare("INSERT INTO users(name,password,email,fullname,state,date,avatar)
                         VALUES(:zuser,:zpassword,:zemail,:zfullname,0,now(),:zavatar)");
                        $stmt->execute(array(
                                'zuser'         =>$username,
                                'zpassword'     =>$password,
                                'zemail'        =>$email,
                                'zfullname'     =>$fullname,
                                "zavatar"        =>$avatar


                        ));
               
                      header("Location:members.php?do=insert2");
                      
                
                        }
                  }     
                else{
                         
                         
                               redrict("we will be dirctly to home page",4);//تحويل للصفحة الرئيسية اذا ضغطت على الرابط مباشرة
                        } }
        include "footer.php";


}//نهاية صفحة الاضافة الجزء الثاني المرتبطة بالجزء الاول





elseif($do=="insert2"){//صفحة الاضافة المرتبطة مع الجزء الثاني
        $pagetitle ="added members";
        include "headereditmember.php";
        include "navbar.php";
      
        echo "<h6 class='text-center'>ROW Inserted</h6> <br>";
        ?>
        <div class="container">
        
        
        <div class='alert alert-success'><?php echo "new name <strong> ". $_SESSION["username"]."</strong>";?></div>
       <div class='alert alert-success'><?php echo "new password <strong>". $_SESSION["password"]."</strong>";?></div>
   <div class=' alert alert-success'><?php echo "new email <strong>". $_SESSION["email"]."</strong>";?></div>
       <div class='alert alert-success'><?php echo "new fullname <strong>". $_SESSION["fullname"]."</strong>";?></div>
</div>
<?php
include "footer.php";
        
}//نهاية صفحة الاضافة المرتبطة مع الجزء الثاني


elseif ($do=="edit"){//بداية صفحة التعديل  

   $pagetitle ="Edit members";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";
   
        
    
    ?>
   <?php 
 
     
   if(isset($_GET["userid"])&&is_numeric($_GET["userid"]))
   {
    $userid=$_GET["userid"];
      
   
   }
   $stmt=$db->prepare("SELECT * FROM users WHERE userid=? ");
   $stmt->execute(array($userid));
   $row = $stmt->fetch();
   $count = $stmt->rowCount();
 
 
   
if($count>0){
   
?>
<h1 style="text-align:center; font-weight:bold" > Edit member</h1>
 <div style="margin-left:200px" >
                
        <form class="container" action="members.php?do=update" method="POST">

        <input type="hidden" name="userid" value="<?php echo $userid?>"/>
            <div class="row margin">
                    <lable class= "col-md-2 ">username</lable>
                    <input type=text name="username" class="col-md-6" required="required" value="<?php echo $row["name"];?>" />

            </div> 
            <div class="row margin">
                    <lable class= "col-md-2">password</lable>
                    <input type=password name="password" class="col-md-6 "  value="<?php echo $row["password"]?>"/>

            </div> 
            <div class="row margin">
                    <lable class= "col-md-2">Email</lable>
                    <input type=email name="email" class="col-md-6" required="required" value="<?php echo $row["email"];?>"/>

            </div> 
            <div class="row margin">
                    <lable class= "col-md-2">Full Name</lable>
                    <input type=text name="fullname" class="col-md-6" required="required" value="<?php echo $row["fullname"];?>"/>

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
        $pagetitle ="update members";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";

          echo '<h1 class="text-center">Update members</h1>';
if($_SERVER["REQUEST_METHOD"]=="POST"){

        $id        =$_POST["userid"];
        $username =$_POST["username"];
        $password =$_POST["password"];
        $email    =$_POST["email"];
        $fullname =$_POST["fullname"];



                $formerror=array();
                if(strlen($username)<4){

                        $formerror[]="<div class='container alert alert-danger'>the username is less than 4</div>";

                }
                if(empty($username)){

                        $formerror[]="<div class='container alert alert-danger'>user name is empty</div>";
                }
                  if(empty($password)){

                        $formerror[]="<div class='container alert alert-danger'>user password is empty</div>";
                }
                  if(empty($email)){

                        $formerror[]="<div class='container alert alert-danger'>user email is empty</div>";
                }
                
                if(empty($fullname)){

                        $formerror[]="<div class='container alert alert-danger'>user fullname is empty</div>";
                }
                foreach($formerror as $error){

                        echo $error."<br>";
                }
                if(empty($formerror)){
                                $stmt2=$db->prepare("SELECT * FROM users WHERE name=? AND userid !=?");
                                $stmt2->execute(array($username,$id));
                                $member=$stmt2->rowCount();
                                if($member == 1){
                                        echo "<h1>الاسم موجود...ضع اسم غير هذا الاسم</h1>";
                                }else{

                        $stmt=$db->prepare("UPDATE users SET name =? , password = ? ,email = ?,fullname = ? WHERE userid = ?");
                        $stmt->execute(array($username,$password,$email,$fullname,$id));
                        echo "<h3>ROW UPDATED</h3> <br>";
                        ?>
                        <div class="container">
                         <div class='alert alert-success'><?php echo "new name <strong> ". $_POST["username"]."</strong>";?></div>
                        <div class='alert alert-success'><?php echo "new password <strong>". $_POST["password"]."</strong>";?></div>
                    <div class=' alert alert-success'><?php echo "new email <strong>". $_POST["email"]."</strong>";?></div>
                        <div class='alert alert-success'><?php echo "new fullname <strong>". $_POST["fullname"]."</strong>";?></div>
                </div>
                
                <?php

                 
                        }
                      }}
                      else{
                        
                        redrict("we will be dirctly to home page",4);
                                }
                


                

        include "footer.php";


}//نهاية صفحة التحديث



elseif($do=="delete"){//بداية صفحة الحذف
        $pagetitle ="delete members";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
       
      
       if(isset($_GET["userid"])&&is_numeric($_GET["userid"]))
       {
        $userid=$_GET["userid"];
          
       
       }
       $stmt=$db->prepare("SELECT * FROM users WHERE userid=? ");
       $stmt->execute(array($userid));
       
       $count = $stmt->rowCount();

       if($count> 0){
               $stmt = $db->prepare("DELETE FROM users WHERE userid=:zuserid");
               $stmt->bindParam(":zuserid",$userid);
               $stmt->execute();
               ?>
               <div class='alert alert-success'>the row was deleted</div>
               <?php



       }
     
include "footer.php";


}//نهاية صفحة الحذف

elseif($do=="activate"){//بداية صفحة التفعيل
        $pagetitle ="activate members";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";
       
      
       if(isset($_GET["userid"])&&is_numeric($_GET["userid"]))
       {
        $userid=$_GET["userid"];
          
       
       }
           $check=checkitem("userid","users",$userid);
      if($check >0){
        $stmt = $db->prepare("UPDATE users SET state=0 WHERE userid=?");
        $stmt->execute(array($userid));
        ?>
        <div class='alert alert-success'>the row was activated</div>
        <?php




      }






       
     
include "footer.php";

  

}//نهاية صفحة التفعيل





else{
    echo "ما في صفحة بهاد العنوان...اتاكد من  العنوان يا باشا";
}


