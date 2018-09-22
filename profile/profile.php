<?php
session_start();
$pagetitle="my profile";
include "header.php";
include "../connection.php";
include "../function.php";
include "upper.php";
include "navbar.php";


$getuser=$db->prepare("SELECT * FROM users WHERE name=?");
$getuser->execute(array($_SESSION["user"]));
$row= $getuser->fetch();


echo "<div class='text-center ' style='font-size:20px'>في صفحتك الشخصية  ".$_SESSION["user"]." اهلا وسهلا بك</div>||| <a href='newads.php' style='font-size:30px' '>new ads</a>";

?>
<div class="information">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                my information
            </div>
            <div class="panel-body prof">
               <?php
               echo "<ul class='list-unstyled '> ";
                    echo "<li><span style='margin-right:135px'>the name </span>: ".$row["name"] . "<br></li>";
                    echo "<li><span style='margin-right:106px'>the full name</span> :". $row["fullname"]. "<br></li>";
                    echo "<li><span style='margin-right:141px'>the email</span> :".$row["email"]. "<br>";
                    echo "<li><span style='margin-right:151px'>the date</span> :".$row["date"]. "<br></li>";
                    echo "<li><span style='margin-right:79px'>favourit category</span>:</li>";
               echo "</ul>";
               ?>
               <a href="#" class="btn btn-primary">edit information</a>
            </div>
        </div>
    </div>
</div>

<div class="information">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                my ads
            </div>
            <div class="panel-body">
                <?php
            $items=getitemsprofile($row["userid"]);
            if(!empty($items)){
            foreach($items as $item){
                echo "<div class='col-sm-6 col-md-3'>";
                    echo "<div class='thumbnail itembox'>"; //كلاس من كلاسات البوت ستراب عشاان يظهرهم الصور على شكل مصغرات..بدونو راح تكون الصورة ملية الشاشة..thumbnail
                    if($item["approve"]==0){//عشان اذا كان غير مفعل..تظهر له رسالة بانه غير مفعل..وينتظر القبول من الادمن

                        echo "<p style='background:red;width: 100px;color: white;'>not approved</p>";
                    }
                        echo "<span>".$item["price"]."</span>";
                        echo "<img src='ff.jpg' alt='unkown'></img>";
                        echo "<h1><a href='items.php?itemsid=".$item["name_id"]."'> ".$item["name"]."</a></h1>";
                        echo "<h3>".$item["description"]."</h3>";
                        echo "<h6 style='text-align:right'>".$item["date"]."</h6>";
                    echo "</div>";
                echo "</div>";
            }}else{echo "there is no ads <a href='newads.php'>new adds</a>";} ?>
            </div>
        </div>
    </div>
</div>


<div class="information">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                latest comment
            </div>
            <div class="panel-body">
                <?php
                $getcom=$db->prepare("SELECT comment FROM comment WHERE user_id=?");
                $getcom->execute(array($row["userid"]));
                $rowcom= $getcom->fetchAll();
                if(empty($rowcom)){
                    echo "there is no comment!!";
                }
                else{
                    foreach($rowcom as $comment){

                        echo $comment["comment"]."<br>";
                    }



                }
                ?>
            </div>
        </div>
    </div>
</div>



<?php


include "footer.php";