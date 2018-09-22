<?php
session_start();

$pagetitle = "my page";?>

<?php include "header.php";?>
<?php  include "navbar.php";
include "connection.php";
include "function.php";

if(isset ($_SESSION["user"])){


echo "<div class='container alert alert-success'> welcome " . $_SESSION["user"]." in login and id is ".$_SESSION["id"]."</div><br><br><br>";

}
else {

header ("Location : index.php");
exit();
}?>
<div class="big">
    <div class="container parent">
        
        <div class="row text-center">
            <h1 style="font-size:55px; font-weight:bold">DashBoard</h1>
            <div class="col-md-3 child child1">
                Total members
                <span><a href='members.php' style='color:black'><?php echo countitem("userid","users");?></a></span>
            </div>
            <div class="col-md-3 child child2 ">
               Pendeng members
               <span><a href='members.php?do=manage&page=pending' style='color:black'><?php echo checkitem("state","users",1)?></a></span>
            </div>
            <div class="col-md-3 child child3">
                Total item
                <span><a href='items.php' style='color:black'><?php echo countitem("name_id","items");?></a></span>
            </div>
            <div class="col-md-3 child child4">
                Total comments
                <span><a href='comments.php' style='color:black'><?php echo countitem("c_id","comment");?></a></span>
            </div>


        </div>  

    </div>



    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <i class="fa fa-users"></i> latest regesterd users
                        <span class="toggle-info pull-right">
                             <i class="fa fa-plus fa-lg"></i>
                         </span>
                     </div>
                     <div class="panel-body m1">
                      <ul class="list-unstyled latest-users">
                           
                      <?php   // لعرض زر التفعيل ورز التعديل
                            $thelatest=getlatest("*","users","userid",5);
                            foreach ($thelatest as $users){
                                echo '<li>'.$users["name"].'<a href=" members.php?do=edit&userid='.$users["userid"].'" <span class="btn btn-success pull-right" style="padding:5px; width:70px;"><i class="fa fa-edit"></i> Edit</span></a>';
                                
                       if($users["state"]==1){
                        echo '<a href=" members.php?do=activate&userid='.$users["userid"].'" <span class=" btn btn-danger pull-right activate"  ><i class="fa fa-tag"></i> activate</span></a></li>';
                            
                       }
                         }
                      ?>
                      
                     </ul>
                    </div>
                
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">

                        <i class="fa fa-users"></i> latest comments
                        <span class="toggle-info pull-right">
                             <i class="fa fa-plus fa-lg"></i>
                         </span>
                     </div>
                     <div class="panel-body ">
                         <?php
                     $stmt=$db->prepare("SELECT comment.*,users.name AS username2 FROM comment
 
                        INNER JOIN users
                        ON users.userid=comment.user_id ORDER BY c_id DESC lIMIT 5 
                        
                      ");

                        $stmt->execute();
                        $comments=$stmt->fetchALL();
                        
                         foreach($comments as $comment){
                            echo "<div class='box-com row'>";//حتى تظهر التعليقات بهذا الشكل ..استعملت كلاسات البوت ستراب مثل كلاس رو والاعمدة
                                 echo '<span class="user-com col-sm-4">'.$comment["username2"].'</span>';
                                 echo '<p class="com col-sm-7">'.$comment["comment"].'</p>';
                            echo "</div>";
                         }
               
                      
                      
                    ?> 
                    </div>
                
                </div>
            </div>

                            

            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> lastes items
                         <span class="toggle-info pull-right">
                             <i class="fa fa-plus fa-lg"></i>
                         </span>

                     </div>
                     <div class="panel-body">
                     <ul class="list-unstyled latest-users">
                           
                      <?php   // لعرض زر التفعيل ورز التعديل


                            $thelatest=getlatest("*","items","name_id",5);
                            foreach ($thelatest as $item){
                                echo '<li>'.$item["name"].'<a href=" items.php?do=edit&itemsid='.$item["name_id"].'" <span class="btn btn-success pull-right" style="padding:5px; width:70px;"><i class="fa fa-edit"></i> Edit</span></a>';
                              
                              
                                
                       if($item["approve"]==0){
                        echo '<a href=" items.php?do=approve&itemsid='.$item["name_id"].'" <span class=" btn btn-danger pull-right activate"  ><i class="fa fa-tag"></i> approve</span></a></li>';
                            
                       }
                         }
                      ?>
                      
                     </ul>
                    </div>
                
                </div>


            </div>
        </div>
    </div>


    </div>
</div>













    




<?php include "footer.php";?>








