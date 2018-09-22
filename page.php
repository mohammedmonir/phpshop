



<?php



$do = "";
if(isset ($_GET["do"])){

    $do = $_GET["do"];



}else{

    $do="manage";



}


if($do=="add"){
echo "hello in page add users";



}
elseif($do=="delete"){
    echo "hello in page delet users";
    
    
    }
    elseif($do=="manage"){
        echo "hello in page manage";
        echo "<a href='page.php?do=add'>clikl here to page add</a>";
        
        }
        else{
            echo "error";
        }
       include "header.php";
include "footer.php";
