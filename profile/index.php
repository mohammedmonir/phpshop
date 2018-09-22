<?php
session_start();
$pagetitle="main page";
include "header.php";
include "../connection.php";
include "../function.php";
include "upper.php";
include "navbar.php";
 echo "<h1 class='text-center'>الصفحة الرئيسية</h1>";
if(isset($_SESSION["user"])){// عشان لو فتح صفحة الاندكس مباشرة وهو لا يوجد سيشن..يحولو على صفحة اللوجن
    echo "<div class='text-center ' style='font-size:30px'><a href='profile.php '>My Profile</a></div>";

 $state=checkuserstatus($_SESSION["user"]);
if($state==1){
    echo"انت غير مفعل للاسف";
}
else{

    echo"انت مفعل";
}
}else{


    header("Location:login.php");
}

include "footer.php";