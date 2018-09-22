<?php
session_start();
$pagetitle="new ads";
include "header.php";

include "../connection.php";
include "../function.php";
include "upper.php";
include "navbar.php";


if(isset($_SESSION["user"])){//لجلب معلومات العضو
   

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $name=          filter_var($_POST["name"],FILTER_SANITIZE_STRING);
        $description=   filter_var($_POST["description"],FILTER_SANITIZE_STRING);
        $price=         filter_var($_POST["price"],FILTER_SANITIZE_NUMBER_INT);
        $country_made=  filter_var($_POST["country_made"],FILTER_SANITIZE_STRING);
        $status=        filter_var($_POST["status"],FILTER_SANITIZE_STRING);
        $category=      filter_var($_POST["category"],FILTER_SANITIZE_STRING);
        $tags=        filter_var($_POST["tags"],FILTER_SANITIZE_STRING);
        
         $formerror = array();
        if(strlen($name)<4){

                $formerror[]="<div class='container alert alert-danger'>the username is less than 4</div>";

        }
        if(strlen($description)<4){
            
                            $formerror[]="<div class='container alert alert-danger'>the description is less than 4</div>";
            
                    }
        if(empty($name)){

                $formerror[]="<div class='container alert alert-danger'>user name is empty</div>";
        }
          if(empty($price)){

                $formerror[]="<div class='container alert alert-danger'>user price is empty</div>";
        }
          if(empty($country_made)){

                $formerror[]="<div class='container alert alert-danger'>user country_made is empty</div>";
        }
        
        if($status==0){

                $formerror[]="<div class='container alert alert-danger'>user status is empty</div>";
        }
        if($category==0){
            
                            $formerror[]="<div class='container alert alert-danger'>user category is empty</div>";
                    }
                    
                    
                    foreach($formerror as $error){
                        
                                        echo $error."<br>";
                                }
        if(empty($formerror)){
           $userid= $_SESSION["UserId"];
            $stmt=$db->prepare("INSERT INTO items(name,description,price,country_made,state,date,cat_id,member_id,tags)
            VALUES(:zname,:zdescription,:zprice,:zcountry_made,:zstate,now(),:zcat_id,:zmember_id,:ztags)");
           $stmt->execute(array(
                'zname'                   =>$name,
                'zdescription'            =>$description,
                'zprice'                  =>$price,
                  'zcountry_made'         =>$country_made,
                'zstate'                 =>$status,
                'zcat_id'                =>$category,
                'zmember_id'             =>$_SESSION["UserId"],//عند تسجيل الدخول في صفحة اللوجن...تم تسجيل الايدي في السيشن عشان اربطو مع حقل الميمبر ايدي
                'ztags'             =>$tags

           ));
  
          

            echo "<div class='container alert alert-success'>the items was added success</div>";
          
        }
    }
    
   
    echo "<div class='text-center  ' style='font-size:20px'>في صفحة اضافة الاعلانات  ".$_SESSION["user"]." اهلا وسهلا بك</div>";
    ?>
    
     
    <div class="information">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                   new ads
                </div>
                <div class="panel-body row">
                    <div class="col-md-8">
                 
                
               
                   
       <form class="container formads" style="position: relative;top:-182px;" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
   
          
               <div class="row margin">
                       <lable class= "col-md-2  ">name</lable>
                       <input type="text" name="name" class="col-md-4 live-name1"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">description</lable>
                       <input type="text" name="description" class="col-md-4 live-disc"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">price</lable>
                       <input type="text" name="price" class="col-md-4 live-price"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">country made</lable>
                       <input type="text" name="country_made" class="col-md-4"  />
   
               </div> 
               <div class="row margin">
                       <lable class= "col-md-2 ">Status</lable>
                       <select name="status" style="width:33.5% ;height: 30px;margin-bottom:10px">
                           <option value="0">....</option>
                           <option value="1">new</option>
                           <option value="2">like new</option>
                           <option value="3">used</option>
                           <option value="4">very old</option>

                        </select>
   
               </div> 
             
          
              <div class="row margin">
                       <lable class= "col-md-2 ">category</lable>
                       <select name="category" style="width:33.5%; height: 30px; margin-bottom:10px">
                           <option value="0">....</option>
                         <?php 
                           $stmt=$db->prepare("SELECT * FROM categories");
                           $stmt->execute();
                           $cats=$stmt->fetchAll();
                            foreach($cats as $cat){
                               echo "<option value='".$cat['id']."'>".$cat['name']."</option>";     

                            }

                         
                         ?>

                        </select>
              
               
                        <div class="row margin">
                       <lable class= "col-md-2 ">Tags</lable>
                       <input type="text" name="tags" class="col-md-4" placeholder="tags here" />
   
               </div> 
               
                     <div class="row margin">
                       <lable class= "col-md-offset-2"></lable>
                       <input type="submit" class="btn btn-success btn-lg" style="width:33.5%" value="add Items">
   
                     </div>      
       </form>
   
                     </div>
   
   
   
                    </div>
                    <div class="col-md-4">  
                        <?php
                    echo "<div class='live-img'>";
                        echo "<div class='thumbnail itembox'>"; //كلاس من كلاسات البوت ستراب عشاان يظهرهم الصور على شكل مصغرات..بدونو راح تكون الصورة ملية الشاشة..thumbnail
                            echo "<span>0$</span>";
                            echo "<img src='ff.jpg' alt='unkown'></img>";
                            echo "<h1>test</h1>";
                            echo "<p>description</p>";
                        echo "</div>";
                     echo "</div>";?>
                    </div>
                </div>
            </div>
        
    </div>
    </div>
    <?php
  
}

else{

    header("Location:login.php");
}







include "footer.php";