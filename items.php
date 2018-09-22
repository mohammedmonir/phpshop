<?php
ob_start(); 
session_start();

$do="";
if(isset ($_SESSION["user"])){


if (isset($_GET["do"])){

    $do = $_GET["do"];
}
else {
    $do = "manage";
}}



if($do == "manage"){//بداية صفحة manage
    $pagetitle="عرض الاصناف";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";
 
        $stmt=$db->prepare("SELECT items.*,categories.name AS catname2, users.name AS username2 FROM items
         INNER JOIN categories ON categories.id=items.cat_id INNER JOIN users 
         ON users.userid=items.member_id");//لعرض حقول جدول الانواع بالاضافة الي اسم القسم واسم العضو
        $stmt->execute();
        $items=$stmt->fetchALL();


    ?>
       <h2 class='text-center'>Manage items</h2><br>
        <div class="container">
            <a href="items.php?do=add" class="btn btn-success "  style="margin-bottom:15px;"><i class="fa fa-plus"></i> click to add items</a>
                <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                                <tr>
                                        <td>id</td>
                                        <td>name</td>
                                        <td>description</td>
                                        <td>price</td>
                                        <td>date</td>
                                        <td>categores</td>
                                        <td>username</td>
                                        <td>Control</td>
                                </tr>
                                
                                <?php
                                foreach($items as $items){
                                 echo "<tr>";
                                        echo "<td>".$items["name_id"]."</td>";
                                        echo "<td>".$items["name"]."</td>";
                                        echo "<td>".$items["description"]."</td>";
                                        echo "<td>".$items["price"]."</td>";
                                        echo "<td>".$items["date"]."</td>";
                                        echo "<td>".$items["catname2"]."</td>";
                                        echo "<td>".$items["username2"]."</td>";
                                        echo "<td>
                                       <a href='items.php?do=edit&itemsid=".$items['name_id']."'class='btn btn-success'>Edit</a>
                                    <a href='items.php?do=delete&itemsid=".$items['name_id']."' class='btn btn-danger confirm'>Delete</a>";
                                    if($items["approve"]==0){
                                        echo" <a href='items.php?do=approve&itemsid=".$items['name_id']."' class='btn btn-primary'>approve</a>";   
                                        
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
    
}//نهاية صفحة ال manange


elseif($do=="add"){//بداية صفحة الاضافة الجزء الاول
    $pagetitle ="Items";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";
    include "function.php";

    ?>
    <h1 style="text-align:center; font-weight:bold"> Add Items</h1>
    <div style="margin-left:200px" >
                   
           <form class="container" action="items.php?do=insert" method="POST">
   
          
               <div class="row margin">
                       <lable class= "col-md-2 ">name</lable>
                       <input type="text" name="name" class="col-md-6"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">description</lable>
                       <input type="text" name="description" class="col-md-6"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">price</lable>
                       <input type="text" name="price" class="col-md-6"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">country made</lable>
                       <input type="text" name="country_made" class="col-md-6"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">Status</lable>
                       <select name="status" style="width:50% ;height: 30px;">
                           <option value="0">....</option>
                           <option value="1">new</option>
                           <option value="2">like new</option>
                           <option value="3">used</option>
                           <option value="4">very old</option>

                        </select>
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">member</lable>
                       <select name="member" style="width:50%;height: 30px;">
                           <option value="0">....</option>
                         <?php 
                           $stmt=$db->prepare("SELECT * FROM users");
                           $stmt->execute();
                           $users=$stmt->fetchAll();
                            foreach($users as $user){
                               echo "<option value='".$user['userid']."'>".$user['name']."</option>";     

                            }

                         
                         ?>

                        </select>
              </div> 
          
              <div class="row margin">
                       <lable class= "col-md-2 ">category</lable>
                       <select name="category" style="width:50%; height: 30px;">
                           <option value="0">....</option>
                         <?php 
                           $stmt=$db->prepare("SELECT * FROM categories WHERE parent=0");
                           $stmt->execute();
                           $cats=$stmt->fetchAll();
                            foreach($cats as $cat){

                               echo "<option value='".$cat['id']."'>".$cat['name']."</option>";    
                               $childcats=$db->prepare("SELECT * FROM categories WHERE parent = {$cat["id"]}");//عندما البيرنت يساوي 1 يعني العناصر الرئيسية..اما الاقسام الفرعية راح تاخد تلقيائيا صفر
                               $childcats->execute();
                                        $categores=$childcats->fetchAll();  
                                        foreach($categores as $cat2){
                                          echo "<option value='".$cat2['id']."'>-----".$cat2['name']."from ".$cat['name']."</option>";  


                            }}

                         
                         ?>

                        </select>
              </div> 
              <div class="row margin">
                       <lable class= "col-md-2 ">Tags</lable>
                       <input type="text" name="tags" class="col-md-6" placeholder="tags here" />
   
               </div> 
               
             
               <div class="row margin">
                       <lable class= "col-md-offset-2"></lable>
                       <input type="submit" class="btn btn-brimary btn-lg" style="width:50%" value="add Items">
   
               </div>      
</form>
   
   </div>
   <?php
   
   
    include "footer.php";

}//نهاية صفحة الاضافة الجزء الاول



elseif($do=="insert"){//صفحة الاضافة الجزء الثاني
    $pagetitle ="added items";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";
    include "function.php";

     
if($_SERVER["REQUEST_METHOD"]=="POST"){

    
    $name           =$_POST["name"];
    $description    =$_POST["description"];
    $price          =$_POST["price"];
    $country_made   =$_POST["country_made"];
    $status         =$_POST["status"];
    $member         =$_POST["member"];
    $category        =$_POST["category"];
    $tags           =$_POST["tags"];
    




            $formerror=array();
            
            if(empty($name)){

                    $formerror[]="<div class='container alert alert-danger'> name is empty</div>";
            }
              if(empty( $description )){

                    $formerror[]="<div class='container alert alert-danger'>  description  is empty</div>";
            }
              if(empty($price)){

                    $formerror[]="<div class='container alert alert-danger'>price is empty</div>";
            }
            
            if(empty($country_made)){

                    $formerror[]="<div class='container alert alert-danger'>country_made is empty</div>";
            }
            if($status==0){
                
                                    $formerror[]="<div class='container alert alert-danger'>status is empty</div>";
                            }


             if($member==0){
                
                                    $formerror[]="<div class='container alert alert-danger'>member is empty</div>";
                            }
             if($category==0){
                
                                    $formerror[]="<div class='container alert alert-danger'>status is category</div>";
                            }
            foreach($formerror as $error){

                    echo $error."<br>";
            }
            if(empty($formerror)){
                    
                    $stmt=$db->prepare("INSERT INTO items(name,description,price,country_made,state,date,cat_id,member_id,tags)
                     VALUES(:zname,:zdescription,:zprice,:zcountry_made,:zstate,now(),:zcat_id,:zmember_id,:ztags)");
                    $stmt->execute(array(
                            'zname'                   =>$name,
                            'zdescription'            =>$description,
                        'zprice'                      =>$price,
                    'zcountry_made'                   =>$country_made,
                            'zstate'                 =>$status,
                            'zcat_id'                =>$category,
                            'zmember_id'             =>$member,
                            'ztags'             =>$tags


                    ));
           
                    header("Location:items.php?do=insert2");//حولت جملة الطباعة على صفحة تانية عشان لو سويت اعادة تحميل للصفحة ما يضيف كمان عنصر

            
                    
            }  }
    include "footer.php";




}//صفحة الاضافة الجزء الثاني
elseif($do=="insert2"){//صفحة الاضافة الجزء الثالث
    $pagetitle ="added items";
    include "headereditmember.php";
    include "navbar.php";
echo"<div class='alert alert-success'>تمت الاضافة بنجاح</div>";
include "footer.php";

}//نهاية صفحة الاضافة الجزء الثالث


elseif($do=="edit"){//بداية صفحة التعديل

        $pagetitle ="Edit items";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
       
         
       if(isset($_GET["itemsid"])&&is_numeric($_GET["itemsid"]))// في زر التعديل بخليه يودي على هاد الريكويست
       {
        $itemsid=$_GET["itemsid"];
          
       
       }
       $stmt=$db->prepare("SELECT * FROM items WHERE  name_id=? ");
       $stmt->execute(array($itemsid));
       $row = $stmt->fetch();
       $count = $stmt->rowCount();
     
     
       
    if($count>0){
       
    ?>
   <h1 style="text-align:center; font-weight:bold"> Edit Items</h1>
    <div style="margin-left:200px" >
                   
           <form class="container" action="items.php?do=update" method="POST">
           <input type="hidden" name="itemid" value="<?php echo $row['name_id'];?>"/>
          
               <div class="row margin">
                       <lable class= "col-md-2 ">name</lable>
                       <input type="text" name="name" class="col-md-6" value="<?php echo $row['name'];?>"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">description</lable>
                       <input type="text" name="description" class="col-md-6" value="<?php echo $row['description'];?>" />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">price</lable>
                       <input type="text" name="price" class="col-md-6"  value="<?php echo $row['price'];?>"/>
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">country made</lable>
                       <input type="text" name="country_made" class="col-md-6" value="<?php echo $row['country_made'];?>" />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">Status</lable>
                       <select name="status" style="width:50% ;height: 30px;">
                           
                           <option value="1" <?php if($row["state"]==1){echo "selected";}?>>new</option>
                           <option value="2"  <?php if($row["state"]==2){echo "selected";}?>>like new</option>
                           <option value="3"  <?php if($row["state"]==3){echo "selected";}?>>used</option>
                           <option value="4"  <?php if($row["state"]==4){echo "selected";}?>>very old</option>

                        </select>
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">member</lable>
                       <select name="member" style="width:50%;height: 30px;">
                           
                         <?php 
                           $stmt=$db->prepare("SELECT * FROM users");
                           $stmt->execute();
                           $users=$stmt->fetchAll();
                            foreach($users as $user){
                               echo "<option value='".$user['userid']."'";
                                if($row["member_id"]==$user["userid"]){ echo "selected";}

                               echo">".$user['name']."</option>";     

                            }

                         
                         ?>

                        </select>
              </div> 
          
              <div class="row margin">
                       <lable class= "col-md-2 ">category</lable>
                       <select name="category" style="width:50%; height: 30px;">
                          
                         <?php 
                           $stmt=$db->prepare("SELECT * FROM categories");
                           $stmt->execute();
                           $cats=$stmt->fetchAll();
                            foreach($cats as $cat){
                               echo "<option value='".$cat['id']."'";
                               if($row["cat_id"]==$cat["id"]){ echo "selected";}
                               echo">".$cat['name']."</option>";     

                            }

                         
                         ?>

                        </select>
              </div> 
              <div class="row margin">
                       <lable class= "col-md-2 ">tags</lable>
                       <input type="text" name="tags" class="col-md-6" value="<?php echo $row['tags'];?>" />
   
               </div> 
               
             
               <div class="row margin">
                       <lable class= "col-md-offset-2"></lable>
                       <input type="submit" class="btn btn-brimary btn-lg" style="width:50%" value="save Items">
   
               </div>      
</form>
   
   </div>
       <?php   
             
       
    }
    //نهاية اظهار الكومينتات
    $stmt=$db->prepare("SELECT comment.*,users.name AS username2 FROM comment 
 
    INNER JOIN users
    ON users.userid=comment.user_id
    
    WHERE item_id=?");

    $stmt->execute(array($itemsid));
    $rows=$stmt->fetchALL();

?>
   <h2 class='text-center'>Manage [ <?php echo $row["name"]?> ] comment</h2><br>
    <div class="container">
            <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                            <tr>
                                   
                                    <td>comment</td>
                                    <td>username</td>
                                   
                                    <td>Regsterd data</td>
                                    <td>Control</td>
                            </tr>
                            
                            <?php
                            foreach($rows as $row){
                             echo "<tr>";
                                    
                                    echo "<td>".$row["comment"]."</td>";
                                    echo "<td>".$row["username2"]."</td>";
                                    
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
            </div><!-- نهاية اظهار الكومينتات-->
           
    </div>
    <?php
    
    
    
     
          include "footer.php";
}//نهاية صفحة التعديل

elseif($do=="update"){
        $pagetitle ="update members";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";

          echo '<h1 class="text-center">Update items</h1>';
if($_SERVER["REQUEST_METHOD"]=="POST"){

      
      $id=$_POST["itemid"];
        $name        =$_POST["name"];
        $description =$_POST["description"];
        $price =$_POST["price"];
        $country_made    =$_POST["country_made"];
        $status =$_POST["status"];
        $member =$_POST["member"];
        $category =$_POST["category"];
        $tags =$_POST["tags"];
      


        $formerror=array();
        
        if(empty($name)){

                $formerror[]="<div class='container alert alert-danger'> name is empty</div>";
        }
          if(empty( $description )){

                $formerror[]="<div class='container alert alert-danger'>  description  is empty</div>";
        }
          if(empty($price)){

                $formerror[]="<div class='container alert alert-danger'>price is empty</div>";
        }
        
        if(empty($country_made)){

                $formerror[]="<div class='container alert alert-danger'>country_made is empty</div>";
        }
        if($status==0){
            
                                $formerror[]="<div class='container alert alert-danger'>status is empty</div>";
                        }


         if($member==0){
            
                                $formerror[]="<div class='container alert alert-danger'>member is empty</div>";
                        }
         if($category==0){
            
                                $formerror[]="<div class='container alert alert-danger'>status is category</div>";
                        }
        foreach($formerror as $error){

                echo $error."<br>";
        }
        if(empty($formerror)){
                        $stmt=$db->prepare("UPDATE items SET name =? , description = ? ,price = ?,country_made = ?,state = ?,cat_id = ?,member_id = ?,tags=? WHERE name_id = ?");
                        $stmt->execute(array($name,$description,$price,$country_made,$status,$category,$member,$tags,$id));
                        echo "<h3>ROW UPDATED</h3> <br>";
                   
                        }
                      }
                    
                

        include "footer.php";




}
elseif($do=="delete"){//بداية صفحة الحذف
        $pagetitle ="delete items";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
       
      
       if(isset($_GET["itemsid"])&&is_numeric($_GET["itemsid"]))
       {
        $itemsid=$_GET["itemsid"];
          
       
       }
       $stmt=$db->prepare("SELECT * FROM items WHERE name_id=? ");
       $stmt->execute(array($itemsid));
       
       $count = $stmt->rowCount();

       if($count> 0){
               $stmt = $db->prepare("DELETE FROM items WHERE name_id=:zname_id");
               $stmt->bindParam(":zname_id",$itemsid);
               $stmt->execute();
               ?>
               <div class='alert alert-success'>the row was deleted</div>
               <?php



       }
     
include "footer.php";

}//نهاية صفحة الحذف

elseif($do=="approve"){//صفحة التفعيل
        $pagetitle ="activate members";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";
       
      
       if(isset($_GET["itemsid"])&&is_numeric($_GET["itemsid"]))
       {
        $itemsid=$_GET["itemsid"];
          
       
       }
           $check=checkitem("name_id","items",$itemsid);
      if($check >0){
        $stmt = $db->prepare("UPDATE items SET approve=1 WHERE name_id=?");
        $stmt->execute(array($itemsid));
        ?>
        <div class='alert alert-success'>the row was approved</div>
        <?php




      }//نهاية صفحة التفعيل






       
     
include "footer.php";



}

else{


    echo "ما في صفحة بهاد العنوان...اتاكد من  العنوان يا باشا";
}

ob_end_flush();