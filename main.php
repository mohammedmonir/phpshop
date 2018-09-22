<?php
ob_start(); 
session_start();
//صفحة ليس لها علاقة بالمشروع...فقط عشان اخذ الكود منها لانو بلزمني كتير
$do="";
if(isset ($_SESSION["user"])){


if (isset($_GET["do"])){

    $do = $_GET["do"];
}
else {
    $do = "manage";
}}



if($do == "manage"){//صفحة عرض الاعضاء 
}
elseif($do=="add"){


}
elseif($do=="insert"){

    
}
else{


    echo "ما في صفحة بهاد العنوان...اتاكد من  العنوان يا باشا";
}

ob_end_flush();