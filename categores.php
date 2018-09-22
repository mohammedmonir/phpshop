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


if($do == "manage"){//بداية صفحة ال manage
    $pagetitle="عرض الاقسام";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";

   
    
    $sort="ASC";//الجزء الخاص بترتيب العناصر حسب رقم ال ordering الي بضيفو في خانة الاضافة
    $sort_array=array("ASC","DESC");
    if(isset($_GET["sort"]) && in_array($_GET["sort"],$sort_array)){
        $sort=$_GET["sort"];

    }//نهاية الجزء الخاص بترتيب العناصر حسب رقم ال ordering الي بضيفو في فورم الاضافة

    $stmt2=$db->prepare("SELECT * FROM categories WHERE parent=0 ORDER BY ordering $sort");//عندما البيرنت يساوي 1 يعني العناصر الرئيسية..اما الاقسام الفرعية راح تاخد تلقيائيا صفر
    $stmt2->execute();
    $categores=$stmt2->fetchAll();


    ?>
        <h1 class="text-center" style="font-size:50px">Manage Categores</h1>
        <div class="container categores">
       <a class='btn btn-primary 'href='categores.php?do=add' style='margin-bottom:5px'>click to add categores</a>
                <div class="panel panel-default">
                        <div class="panel-heading">
                                Manage Categores
                                <div class="ordering pull-right">
                                        Ordering:
                                        <a href="?sort=ASC" class="ord1 ">ASC </a>|
                                        <a href="?sort=DESC" class="ord1">DESC</a>
                                        ||VIEW:
                                        <span style="color:red;cursor: pointer;" data-view="full">view full </span>|
                                        <span style="color:red;cursor: pointer; " data-view="">view heading</sapn>

                                </div>
                          </div>
                        <div class="panel-body">
                        <?php

                        foreach($categores as $cats){
                                echo "<div class='cat'>";

                                echo "<div class='hidden-button'>";
                                        echo"<a href='categores.php?do=edit&catid=".$cats['id']."' class='btn  btn-primary' style='margin-right:5px;'><i class='fa fa-edit'></i>edit</a>";
                                        echo"<a href='categores.php?do=delete&catid=".$cats['id']."' class='btn  btn-danger confirm'><i class='fa fa-close'></i>delete</a>";
                               echo "</div>";
                                 echo "<h1 style='font-weight:bold'>".$cats["name"]."</h1>";

                                 echo "<div class='full-view'>";
                                        echo "<p>";
                                        if($cats["description"]==''){
                                                echo "<h4>description is null </h4><br>";
                                                }else{ 
                                                        echo"<h4> الوصف : ". $cats["description"]."</h4><br>";
                                                }
                                                "</p>";  
                                        if( $cats["visibilty"]==1){echo '<span class="vis">hidden</span>';}else{echo "visible ";}
                                        if( $cats["allow_comment"]==1){echo '<span class="comment">not comment</span>';}else{echo "comment is enable ";}
                                        if( $cats["allow_ads"]==1){echo '<span class="ads">not ads</span>';}else{echo "ads id enable ";}
                                 echo "</div>" ;   
                                     
                                echo "</div>";
                                 $childcats=$db->prepare("SELECT * FROM categories WHERE parent = {$cats["id"]}");//عندما البيرنت يساوي 1 يعني العناصر الرئيسية..اما الاقسام الفرعية راح تاخد تلقيائيا صفر
                                $childcats->execute();
                                $categores=$childcats->fetchAll(); 
                                echo "<div class='parent' style='background:#f9f9f9'>";
                                if(!empty($categores)){//عشان لو فش اقسام فرعية ما يظهرها 
                                echo "<h4 style='margin-left:50px; color:red'>child categoreis for ".$cats["name"]."</h4>" ;             
                                  foreach($categores as $c){
                                        echo "<ul class='list-unstyled'>";    
                                                echo "<li style='margin-left:100px; '><a href='categores.php?do=edit&catid=".$c['id']."'  style='margin-right:20px;'>". $c["name"]."</a>";
                                                echo"<a href='categores.php?do=delete&catid=".$c['id']."' class=' confirm' style='color:red'>delete</a> </li>";
                                        echo "</ul>";

                                  }       
                                  echo "</div>";               
                                }else{
                                        echo "<h4>there is no child categores</h4>";
                                }
                                echo "<hr>";

                        }
                        ?>
                        
                        </div>
                </div>

        </div>

    <?php




    include "footer.php";
}//نهاية صفحة الmanage




elseif($do=="add"){//صفحة الاضافة الجزء الاول
    $pagetitle="اضافة الاقسام";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";

    ?>
    <h1 style="text-align:center; font-weight:bold"> Add Category</h1>
    <div style="margin-left:200px" >
                   
           <form class="container" action="categores.php?do=insert" method="POST">
   
          
               <div class="row margin">
                       <lable class= "col-md-2 ">name</lable>
                       <input type="text" name="name" class="col-md-6"  value="" />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2">description</lable>
                       <input type="text" name="description" class="col-md-6 "/>
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2">ordering</lable>
                       <input type="text" name="ordering" class="col-md-6"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2">the main category</lable>
                        <select name="parent">
                                <option value="0"> null</option><!--  اذا اخترتها يعني قسم رئيسي-->
                                <?php
                                $getstmt=$db->prepare("SELECT * FROM categories WHERE parent=0");//عشان يظهرلي الاقسام الرئيسية فقط
                                $getstmt->execute();
                                $row = $getstmt->fetchAll();
                                foreach($row as $cat){
                                    echo "<option value='".$cat['id']."'>".$cat["name"]."</option>";
                                }

                                ?>

                        </select>
   
               </div> 



               <div class="row margin">
                       <lable class= "col-md-12" style="font-size:40px ;font-weight:bold">visibilty</lable>
                       <div>
                       <input id="vis" type="radio" name="visible"  value="0" checked   />
                       <lable for="vis">Yes</lable>
                        </div>  
                        <div>
                       <input id="vis" type="radio" name="visible"   value="1"    />
                       <lable for="vis">No</lable>
                        </div>  
               </div>   
               <div class="row margin" >
                       <lable class= "col-md-12" style="font-size:40px ;font-weight:bold">Allow Commenting</lable>
                       <div>
                       <input id="com" type="radio" name="commenting"  value="0" checked />
                       <lable for="com">Yes</lable>
                        </div>  
                        <div>
                       <input id="com" type="radio" name="commenting"   value="1"/>
                       <lable for="com">No</lable>
                        </div>  
               </div> 
               <div class="row margin">
                       <lable class= "col-md-12" style="font-size:40px ;font-weight:bold">Allow Ads</lable>
                       <div>
                       <input id="ads" type="radio" name="ads"   value="0" checked />
                       <lable for="ads">Yes</lable>
                        </div>  
                        <div>
                       <input id="ads" type="radio" name="ads"   value="1" />
                       <lable for="ads">No</lable>
                        </div>  
               </div>        
               <div class="row margin">
                       <lable class= "col-md-offset-2"></lable>
                       <input type="submit" class="btn btn-brimary btn-lg" style="width:50%" value="add categories">
   
               </div>      
</form>
   
   </div>
   

<?php

    include "footer.php";

}//نهاية صفحة الاضافة الجزء الاول



elseif($do=="insert"){//بداية صفحة الاضافة الجزء الثاني
    $pagetitle ="added category";
    include "headereditmember.php";
    include "navbar.php";
    include "connection.php";
    include "function.php";

      echo '<h1 class="text-center">added members</h1>';
    if($_SERVER["REQUEST_METHOD"]=="POST"){

     
    $name             =$_POST["name"];
    $description      =$_POST["description"];
    $ordering         =$_POST["ordering"];
    $parent           =$_POST["parent"];
    $visibilty        =$_POST["visible"];
    $commenting       =$_POST["commenting"];
    $ads              =$_POST["ads"];
      
                
                    $check = checkitem("name","categories",$name); //فنكشن لفحص الاسم هل هو موجود ام لا...يجب ان يكون الاسم غير مكرر في قاعدة البيانات حتى يعمل هذا الفنكشن
                    if($check==1){

                            echo "Sorry :this name is exist";

                    }
                    else{
                    

                    $stmt=$db->prepare("INSERT INTO categories(name,description,parent,ordering,visibilty,allow_comment,allow_ads)
                     VALUES(:zname,:zdescription,:zparent,:zordering,:zvisibilty,:zcommenting,:zads)");
                    $stmt->execute(array(
                            'zname'               =>$name ,
                            'zdescription'        =>$description,
                            'zordering'           =>$ordering,
                            'zparent'           =>$parent,
                            'zvisibilty'          =>$visibilty,
                            'zcommenting'         =>$commenting,
                            'zads'                =>$ads


                    ));
           
                    header("Location:categores.php?do=insert2");

            
                    }
                } else{
                    
                     
                           redrict("we will be dirctly to home page",4);//تحويل للصفحة الرئيسية اذا ضغطت على الرابط مباشرة
                } 
    include "footer.php";

}//نهاية صفحة الاضافة الجزء الثاني              


                elseif($do=="insert2"){//صفحة الاضافة الجزء الثالث...طبعا انا وديتو على هادي الصفحة عشان لو سوى اعادة تحميل للصفحة ما يضيف كمان قسم
                $pagetitle ="added category";
                include "headereditmember.php";
                include "navbar.php";
                include "connection.php";
                include "function.php";


                echo "<h1>تمت الاضافة بنجاح</h1>";

                include "footer.php";


                }//نهاية صفحة الاضافة الجزء الثالث



   elseif($do=="edit"){//بداية صفحة التعديل
                        $pagetitle ="Edit categores";
                        include "headereditmember.php";
                        include "navbar.php";
                        include "connection.php";
                        include "function.php";
                       
                            
                        
                       if(isset($_GET["catid"])&&is_numeric($_GET["catid"]))
                       {
                        $catid=$_GET["catid"];
                       
                       }
                       $stmt=$db->prepare("SELECT * FROM categories WHERE id=? ");
                       $stmt->execute(array($catid));
                       $row = $stmt->fetch();
                       $count = $stmt->rowCount();
                     
                     
                       
                    if($count>0){
                       
                    ?>
                                
                                <h1 style="text-align:center; font-weight:bold"> Edit Category</h1>
                          <div style="margin-left:200px" >
                                
                        <form class="container" action="categores.php?do=update" method="POST">
                
                        <input type="hidden" name="id" value="<?php echo $row["id"];?>"/>
                        <div class="row margin">
                                <lable class= "col-md-2 ">name</lable>
                                <input type="text" name="name" class="col-md-6"  value="<?php echo $row["name"]; ?>" />
                
                        </div> 
                        <div class="row margin">
                                <lable class= "col-md-2">description</lable>
                                <input type="text" name="description" class="col-md-6 " value="<?php echo $row["description"]; ?>" />
                
                        </div> 
                        <div class="row margin">
                                <lable class= "col-md-2">ordering</lable>
                                <input type="text" name="ordering" class="col-md-6" value="<?php echo $row["ordering"]; ?>" />
                
                        </div> 
                        <div class="row">
                        <lable class= "col-md-2">the main category</lable>
                        <select name="parent">
                                <option value="0"> null</option> <!--  اذا اخترتها يعني قسم رئيسي-->
                                <?php
                                $getstmt=$db->prepare("SELECT * FROM categories WHERE parent=0");
                                $getstmt->execute();
                                $maincats = $getstmt->fetchAll();
                                foreach($maincats as $maincat){
                                    echo "<option value='".$maincat['id']."'";
                                    if($row["parent"]==$maincat["id"]){
                                            echo "selected";
                                    }
                                    echo ">".$maincat["name"]."</option>";
                                }

                                ?>

                        </select>
   
                        </div>
                        <div class="row margin">
                                <lable class= "col-md-12" style="font-size:40px ;font-weight:bold">visibilty</lable>
                                <div>
                                <input id="vis" type="radio" name="visible"  value="0" <?php if($row["visibilty"]==0){echo "checked";}  ?> />
                                <lable for="vis">Yes</lable>
                                        </div>  
                                        <div>
                                <input id="vis" type="radio" name="visible"   value="1"   <?php if($row["visibilty"]==1){echo "checked";}  ?> />
                                <lable for="vis">No</lable>
                                        </div>  
                        </div>   
                        <div class="row margin" >
                                <lable class= "col-md-12" style="font-size:40px ;font-weight:bold">Allow Commenting</lable>
                                <div>
                                <input id="com" type="radio" name="commenting"  value="0" <?php if($row["allow_comment"]==0){echo "checked";}  ?>/>
                                <lable for="com">Yes</lable>
                                        </div>  
                                        <div>
                                <input id="com" type="radio" name="commenting"   value="1" <?php if($row["allow_comment"]==1){echo "checked";}  ?> />
                                <lable for="com">No</lable>
                                        </div>  
                        </div> 
                        <div class="row margin">
                                <lable class= "col-md-12" style="font-size:40px ;font-weight:bold">Allow Ads</lable>
                                <div>
                                <input id="ads" type="radio" name="ads"   value="0" <?php if($row["allow_ads"]==0){echo "checked";}  ?> />
                                <lable for="ads">Yes</lable>
                                        </div>  
                                        <div>
                                <input id="ads" type="radio" name="ads"   value="1" <?php if($row["allow_ads"]==1){echo "checked";}  ?> />
                                <lable for="ads">No</lable>
                                        </div>  
                        </div>        
                        <div class="row margin">
                                <lable class= "col-md-offset-2"></lable>
                                <input type="submit" class="btn btn-brimary btn-lg" style="width:50%" value="save">
                
                        </div>      
                </form>
   
        </div>
   
                    
                       <?php   
                             
                       
                    }
                    
                    
                    
                    
                    
                     
                          include "footer.php";

                        
                }//نهاية صفحة التعديل



elseif($do=="update"){//بداية صفحة التحديث
        $pagetitle ="update categores";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";

          echo '<h1 class="text-center">Update members</h1>';
if($_SERVER["REQUEST_METHOD"]=="POST"){

        $id                   =$_POST["id"];
        $name                 =$_POST["name"];
        $description          =$_POST["description"];
        $ordering             =$_POST["ordering"];
        $parent              =$_POST["parent"];
        $visible              =$_POST["visible"];
        $commenting           =$_POST["commenting"];
        $ads                  =$_POST["ads"];

                        $stmt=$db->prepare("UPDATE categories SET name =? , description = ? ,ordering = ?,parent=?,visibilty = ? ,allow_comment = ?,allow_ads = ? WHERE id = ?");
                        $stmt->execute(array($name,$description,$ordering,$parent,$visible,$commenting, $ads,$id ));
                        echo "<h1>ROW UPDATED</h1> <br>";
                     
 
                 
                        
                      }
                      else{
                        
                        redrict("we will be dirctly to home page",4);
           }



                

        include "footer.php";



}//نهاية صفحة التحديث
elseif($do=="delete"){

        $pagetitle ="delete categoris";
        include "headereditmember.php";
        include "navbar.php";
        include "connection.php";
        include "function.php";
       
      
       if(isset($_GET["catid"])&&is_numeric($_GET["catid"]))
       {
        $catid=$_GET["catid"];
          
       
       }
       $stmt=$db->prepare("SELECT * FROM categories WHERE id=? ");
       $stmt->execute(array($catid));
       
       $count = $stmt->rowCount();

       if($count> 0){
               $stmt = $db->prepare("DELETE FROM categories WHERE id=:zid");
               $stmt->bindParam(":zid",$catid);
               $stmt->execute();
               ?>
               <div class='alert alert-success'>the category was deleted</div>
               <?php
              



       }
     
include "footer.php";

}





else{ 

   
        echo "ما في صفحة بهاد العنوان...اتاكد من  العنوان يا باشا";
    
    
}
ob_end_flush();
