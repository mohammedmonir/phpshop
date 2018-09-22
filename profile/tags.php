<?php
ob_start(); 
$pagetitle="categores";
session_start();
include "header.php";
include "../connection.php";
include "../function.php";
include "upper.php";
include "navbar.php";

?>
<div class="container text-center">
   
    <div class="row">
            <?php
           
           if(isset($_GET["name"])){
           echo " <h1>".$_GET["name"]."</h1>";
           $tags=$_GET["name"];
           $getstmt=$db->prepare("SELECT * FROM items WHERE tags like '%$tags%'");//تبحث عن كل شئ يشبه القيمة داخل التاق
           $getstmt->execute();
           $items = $getstmt->fetchAll();
           
           if(!empty($items)){
           foreach($items as $item){
                echo "<div class='col-sm-6 col-md-3'>";
                    echo "<div class='thumbnail itembox'>"; //كلاس من كلاسات البوت ستراب عشاان يظهرهم الصور على شكل مصغرات..بدونو راح تكون الصورة ملية الشاشة..thumbnail
                        echo "<span>".$item["price"]."</span>";
                        echo "<img src='ff.jpg' alt='unkown'></img>";
                        echo "<h1><a href='items.php?itemsid=".$item["name_id"]."'>".$item["name"]."</a></h1>";
                        echo "<h3>".$item["description"]."</h3>";
                        echo "<h6 style='text-align:right'>".$item["date"]."</h6>";
                    echo "</div>";
                echo "</div>";
            
        }
    }else{
        echo "<h1 class='text-center'>thers is not tag for this</h1>";
    }
    }  
            
           
            
            
            ?>
    </div>

</div>


<?php
include "footer.php"; 
ob_end_flush();

