<?php
session_start();
$pagetitle="new ads";
include "header.php";

include "../connection.php";
include "../function.php";
include "upper.php";
include "navbar.php";
if(isset($_GET["itemsid"])&&is_numeric($_GET["itemsid"]))// في زر التعديل بخليه يودي على هاد الريكويست
{
 $itemsid=$_GET["itemsid"];
}




$stmt=$db->prepare("SELECT items.*,categories.name AS catname2, users.name AS username2 FROM items
INNER JOIN categories ON categories.id=items.cat_id INNER JOIN users 
ON users.userid=items.member_id WHERE name_id=?");//لعرض حقول جدول الانواع بالاضافة الي اسم القسم واسم العضو
$stmt->execute(array($itemsid));
$row = $stmt->fetch();
$count= $stmt->rowCount();

if($count>0){
    if($row["approve"]==0){
        echo "<h1 class='text-center'> the item is not approver</h1>";
    }else{
    echo "<h1 class='text-center'>". $row["name"]."</h1>";
    ?>
     <div class='container'>
      <div class="row">
        <div class='col-md-3'>
            <img class="img-responsive" src="ff.jpg" alt="items"></img>
        </div>
        <div class="col-md-9 ">
            <h2><?php echo $row["name"]; ?></h2>
            <p><?php echo $row["description"]; ?></p>
            <ul class="list-unstyled infoul">
                <li><span>the date is </span>:<?php echo $row["date"]; ?></li>
                <li><span>the price is</span>:<?php echo "$".$row["price"]; ?></li>
                <li><span>the country is </span>:<?php echo $row["country_made"]; ?></li>
                <li><span>the category is</span> :<a href="categores.php?pageid=<?php echo $row["cat_id"];?>"><?php echo $row["catname2"]; ?></a></li>
                <li><span>the username is</span> :<?php echo $row["username2"]; ?></li>
                <li><span>the tags is</span> :<?php
                    $alltags=explode("," ,$row["tags"]);// عشان كل كلمة وراها فاصلة..افصلها عن الكلمة التي تليها
                    foreach($alltags as $tag){
                        $tag=str_replace(" ","",$tag);// عشان اذا كتبت كلمة فيها مسافة..تبدلي المسافة الي بدون مسافة
                        echo "<a href='tags.php?name={$tag}'>".$tag."</a> | ";

                    }
                
                ?></li>
            </ul>
                
            
        </div>
        
    </div>
    <?php }?>
    <hr>
<?php    if(isset($_SESSION["user"])){?><!--عشان لو فتح الرابط مباشرة من اي مكان ثاني ما يظهرلو مكان التعليق-->
    <div class='row'>                                 <!-- بداية الكومينتات -->
        <div class='col-md-offset-3'>
            <div class="comment">
                <h1>add your comment</h1>
                <form action="<?php echo $_SERVER['PHP_SELF'] ."?itemsid=".$row['name_id']?>" method="POST"><!--عشان يبعت على نفس الصفحة الي انا فيها..-->
                    <textarea name="comment" style="width:500px;height:120px"></textarea>
                    <input type="submit" value="add comment" class="btn btn-primary"/>
                </form>
               <?php

                if($_SERVER["REQUEST_METHOD"]=="POST"){
                   $comment= $_POST["comment"];
                   $itemid = $row["name_id"];
                   $userid = $_SESSION["UserId"]; //  حتى يكون التعليق مرتبط برقم ايدي الشخص الذي سجل الدخول في الموقع...طبعا انا في صفحة اللوجن لما بعمل تسجيل دخول بخزن ايدي الشخص في السيشن هذا السيشن تم تخزينه في صفحة اللوجن 
                   

                   if(!empty($comment)){
                   $stmt = $db->prepare("INSERT INTO comment (comment,state,comment_date,item_id,user_id) 
                   VALUES (:zcomment,0,now(),:zitem_id,:zuserid) ");
                   $stmt->execute(array(
                        'zcomment'=> $comment,
                        'zitem_id'=>$itemid,
                          'zuserid'=>  $userid// عبارة عن اي دي الشخص الي مخزن بالسيشن في صفحة تسجيل الدخول عشاان يكون التعليق مربوط بالشخص الي مسجل الدخول
                        
                  

                   ));
                   header("Location:msgcomment.php");//حولتها على هادي الصفحة عشااان لو سويت اعادة تحميل للصفحة ما ضيف نفس الكومينت كمان مرة
             


                }else{

                    echo "<h2> the comment is null </h2>";
                }



               } 
               
               ?>
            </div>
        </div><!--نهاية الكومينتات -->
    </div>
    <?php 
    }else{// اذا لم بكن سيشن موجود...اظهر له هادي الرسالة
        echo "you must login to add your comment";
    }?>

<?php 

$stmt=$db->prepare("SELECT comment.*,users.name AS username2 FROM comment
 INNER JOIN users
 ON users.userid=comment.user_id WHERE item_id = ?");

$stmt->execute(array($row["name_id"]));// عندما اي دي التعليق يساوي اي دي اسم النوع
$rowcom=$stmt->fetchALL();

?>

    <hr>
    
       
            <?php 
           
            foreach($rowcom as $com)//عرض التعليقات
                {
                   echo "<div class='comment2-box'>";
                            echo '<div class="row">';
                            echo "<div class='col-md-3'>";
                            echo "<img src='ff.jpg' class='img-responsive img thumbnail img-circle' alt='unkown'></img>";
                                    echo "<h3>" .$com["username2"]."</h3><br>";
                            echo "</div>";

                            echo "<div class='col-md-9'>";
                                    echo "<p class='com'>". $com["comment"]."</p><br>";
                                echo "</div>";

                            echo "</div>";
                    echo "</div>";
                    echo "<hr >";

                }         
            ?>
        
    


   

    <?php
}else{

    echo "there is no such id";
}

include "footer.php";