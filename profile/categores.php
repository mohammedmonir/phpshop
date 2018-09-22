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
    <h1>the categores</h1>
    <div class="row">
            <?php
           
            $items=getitems($_GET["pageid"]);
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
            
            
           
            
            
            ?>
    </div>

</div>


<?php
include "footer.php"; 
ob_end_flush();

